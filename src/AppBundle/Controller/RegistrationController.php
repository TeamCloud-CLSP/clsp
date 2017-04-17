<?php

namespace AppBundle\Controller;

use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use AppBundle\Validator\Constraints\ValidSignupCode;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TimezoneType;
use Symfony\Component\Form\Tests\Extension\Core\Type\TimezoneTypeTest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Database;

/**
 *
 * Methods:
 *
 * createUser - /api/register - creates a user - takes username, password, email, signupcode.
 *
 * Class RegistrationController
 * @package AppBundle\Controller
 */
class RegistrationController extends Controller
{

    /**
     * Finds a matching signup code, then registers the corresponding user.
     *
     * Takes: username, name, password, email, signup_code
     *
     * Username and Email must be unique in the database.
     *
     * @Route("/api/register", name="createRegistration")
     * @Method({"POST", "OPTIONS"})
     */
    public function createUser(Request $request) {
        $encoder = $this->container->get('security.password_encoder');

        $post_parameters = $request->request->all();

        if (array_key_exists('username', $post_parameters) && array_key_exists('password', $post_parameters) && array_key_exists('email', $post_parameters) && array_key_exists('signup_code', $post_parameters) && array_key_exists('name', $post_parameters)) {
            $conn = Database::getInstance();
            $signup_code = $post_parameters['signup_code'];
            $username = $post_parameters['username'];
            $password = $post_parameters['password'];
            $email = $post_parameters['email'];
            $name = $post_parameters['name'];
            $user = new User();

            // check to make sure username and email are unique
            $queryBuilder = $conn->createQueryBuilder();
            $results = $queryBuilder->select('users.id')->from('app_users', 'users')->where('users.username = ?')
                ->orWhere('users.email = ?')
                ->setParameter(0, $username)->setParameter(1, $email)->execute()->fetchAll();
            if (count($results) > 0) {
                $jsr = new JsonResponse(array('error' => 'The username or email already exists.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            // see if the signup code belongs to a professor registration and is not expired
            $queryBuilder = $conn->createQueryBuilder();
            $results = $queryBuilder->select('pr.id', 'pr.date_end')->from('professor_registrations', 'pr')->where('pr.signup_code = ?')
                ->andWhere('pr.date_start < ?')->andWhere('pr.date_end > ?')->andWhere('pr.professor_id is NULL')
                ->setParameter(0, $signup_code)->setParameter(1, time())->setParameter(2, time())->execute()->fetchAll();
            if (count($results) > 0) {
                // its a professor registration
                $pr_id = $results[0]['id'];
                $date_end = $results[0]['date_end'];

                // create the professor account
                $queryBuilder = $conn->createQueryBuilder();
                $queryBuilder->insert('app_users')
                    ->values(
                        array(
                            'username' => '?',
                            'password' => '?',
                            'email' => '?',
                            'is_active' => '?',
                            'date_created' => '?',
                            'date_start' => '?',
                            'date_end' => '?',
                            'timezone' => '?',
                            'is_student' => '?',
                            'is_professor' => '?',
                            'is_designer' => '?',
                            'is_administrator' => '?',
                            'name' => '?'
                        )
                    )
                    ->setParameter(0, $username)->setParameter(1, $encoder->encodePassword($user, $password))->setParameter(2, $email)->setParameter(3, 1)->setParameter(4, time())
                    ->setParameter(5, time())->setParameter(6, $date_end)->setParameter(7, date_default_timezone_get())
                    ->setParameter(8, 0)->setParameter(9, 1)->setParameter(10, 0)->setParameter(11, 0)->setParameter(12, $name)->execute();

                $professor_id = $conn->lastInsertId();

                // updates the professor registration to be linked to the professor
                $queryBuilder = $conn->createQueryBuilder();
                $queryBuilder->update('professor_registrations')->set('professor_id', '?')->where('id = ?')->setParameter(0, $professor_id)->setParameter(1, $pr_id)->execute();

                $queryBuilder = $conn->createQueryBuilder();
                $results = $queryBuilder->select('id', 'username', 'email', 'is_active', 'date_created', 'date_deleted', 'date_start', 'date_end', 'timezone', 'is_student', 'is_professor', 'is_designer', 'is_administrator')
                    ->from('app_users', 'users')->where('users.id = ?')->setParameter(0, $professor_id)->execute()->fetchAll();
                if (count($results) < 1) {
                    $jsr = new JsonResponse(array('error' => 'An error upon account creation has occurred.'));
                    $jsr->setStatusCode(500);
                    return $jsr;
                }
                return new JsonResponse($results[0]);
            }

            // otherwise, see if it belongs to a student registration
            $queryBuilder = $conn->createQueryBuilder();
            $results = $queryBuilder->select('sr.id', 'sr.date_end', 'sr.max_registrations')->from('student_registrations', 'sr')->where('sr.signup_code = ?')
                ->andWhere('sr.date_start < ?')->andWhere('sr.date_end > ?')
                ->setParameter(0, $signup_code)->setParameter(1, time())->setParameter(2, time())->execute()->fetchAll();
            if (count($results) > 0) {
                // its a student registration
                $sr_id = $results[0]['id'];
                $date_end = $results[0]['date_end'];
                $max = $results[0]['max_registrations'];

                $queryBuilder = $conn->createQueryBuilder();
                // make sure registration limit has not been hit
                $results = $queryBuilder->select('COUNT(sr.id) AS registrations')->from('student_registrations', 'sr')->
                    innerJoin('sr', 'app_users', 'students', 'students.student_registration_id = sr.id')->where('sr.id = ?')
                    ->groupBy('sr.id')->setParameter(0, $sr_id)->execute()->fetchAll();
                if (count($results) > 0) {
                    $students = $results[0]['registrations'];

                    if ($students >= $max) {
                        $jsr = new JsonResponse(array('error' => 'The registration limit of this class has been reached.'));
                        $jsr->setStatusCode(500);
                        return $jsr;
                    }
                }

                // create the professor account
                $queryBuilder = $conn->createQueryBuilder();
                $queryBuilder->insert('app_users')
                    ->values(
                        array(
                            'username' => '?',
                            'password' => '?',
                            'email' => '?',
                            'is_active' => '?',
                            'date_created' => '?',
                            'date_start' => '?',
                            'date_end' => '?',
                            'timezone' => '?',
                            'is_student' => '?',
                            'is_professor' => '?',
                            'is_designer' => '?',
                            'is_administrator' => '?',
                            'student_registration_id' => '?',
                            'name' => '?'
                        )
                    )
                    ->setParameter(0, $username)->setParameter(1, $encoder->encodePassword($user, $password))->setParameter(2, $email)->setParameter(3, 1)->setParameter(4, time())
                    ->setParameter(5, time())->setParameter(6, $date_end)->setParameter(7, date_default_timezone_get())
                    ->setParameter(8, 1)->setParameter(9, 0)->setParameter(10, 0)->setParameter(11, 0)->setParameter(12, $sr_id)->setParameter(13, $name)->execute();

                $student_id = $conn->lastInsertId();

                $queryBuilder = $conn->createQueryBuilder();
                $results = $queryBuilder->select('id', 'username', 'email', 'is_active', 'date_created', 'date_deleted', 'date_start', 'date_end', 'timezone', 'is_student', 'is_professor', 'is_designer', 'is_administrator')
                    ->from('app_users', 'users')->where('users.id = ?')->setParameter(0, $student_id)->execute()->fetchAll();
                if (count($results) < 1) {
                    $jsr = new JsonResponse(array('error' => 'An error upon account creation has occurred.'));
                    $jsr->setStatusCode(500);
                    return $jsr;
                }
                return new JsonResponse($results[0]);
            }

            // no signup code matches, so return invalid signup code
            $jsr = new JsonResponse(array('error' => 'The signup code is invalid.'));
            $jsr->setStatusCode(400);
            return $jsr;

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }


    /**
     * @Route("/register", name="user_registration")
     */
    public function registerAction(Request $request)
    {
        // 1) build the form
        $user = new User();
        $user->setTimezone('America/New_York');
        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class, array(
                "constraints" => array(
                    new NotBlank(),
  //                  new UniqueEntity(array('fields' => 'username', 'em' => 'default')),
                    new Length(array('min' => 6))
                )
            ))
            ->add('email', TextType::class, array(
                "constraints" => array(
                    new NotBlank(),
       //             new UniqueEntity(array('fields' => 'email', 'em' => 'default')),
                    new Email()
                )
            ))
            ->add('plainPassword', PasswordType::class, array(
                "constraints" => array(
                    new NotBlank(),
                    new Length(array('min' => 6))
                )
            ))
            ->add('timezone', TimezoneType::class)
            ->add('signupCode', TextType::class, array(
                "constraints" => array(
                    new NotBlank(),
                    new Length(array('min' => 16)),
       //             new ValidSignupCode(),
                )
            ))
            ->add('save', SubmitType::class, array('label' => 'Register'))
            ->getForm();

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $registration = $this->getDoctrine()->getRepository('AppBundle:Registration')->findOneBySignupCode($user->getSignupCode());

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setDateCreated(time());
            $user->setDateStart($registration->getDateStart());
            $user->setDateEnd($registration->getDateEnd());
            $user->setRegistration($registration);
            $user->setIsActive(true);
            $user->setIsStudent(true);
            $user->setIsProfessor(false);
            $user->setIsDesigner(false);
            $user->setIsAdministrator(false);

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();

            $em->persist($user);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('homepage');
        }

        return $this->render(
            'registration/register.html.twig',
            array('form' => $form->createView())
        );
    }
}