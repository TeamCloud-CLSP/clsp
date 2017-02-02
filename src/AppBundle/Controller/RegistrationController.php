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

class RegistrationController extends Controller
{
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