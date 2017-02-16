<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Tests\Controller\ProfessorControllerTest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use \DateTime;
use \DateTimeZone;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Database;

/**
 * Available functions:
 *
 * getCourses
 * getRegistrations
 * getMainPageStructure (told Yuanhan about this - this should be how he wants to set up the main professor page)
 * getStudentRegistration
 * getStudentRegistrations
 * createStudentRegistration
 * editStudentRegistration
 * deleteStudentRegistration
 * getClasses
 * getClass
 * createClass
 * editClass
 * deleteClass
 *
 * Class ProfessorController
 * @package AppBundle\Controller
 */
class ProfessorController extends Controller
{

    /**
     * Gets all courses that the professor can view and use
     *
     * Can filter by name
     *
     * @Route("/api/professor/courses", name="getCoursesAsProfessor")
     * @Method({"GET"})
     */
    public function getCourses(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        $request_parameters = $request->query->all();
        
        // gets the name parameter from request parameters, or just leaves it as double wildcard
        $name = "%%";
        if (array_key_exists('name', $request_parameters)) {
            $name = '%' . $request_parameters['name'] . '%';
        }
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $result = $queryBuilder->select('courses.id', 'courses.name', 'pr.date_start', 'pr.date_end')
            ->from('professor_registrations', 'pr')->innerJoin('pr', 'courses', 'courses', 'pr.course_id = courses.id')
            ->where('pr.professor_id = ?')->andWhere('courses.name LIKE ?')
            ->setParameter(0, $user_id)->setParameter(1, $name)->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($result), 'data' => $result));
        $jsr->setStatusCode(200);
        return $jsr;
    }

    /**
     * Gets all registrations that the professor has
     *
     * @Route("/api/professor/registrations/professor", name="getProfRegistrationsAsProfessor")
     * @Method({"GET"})
     */
    public function getRegistrations(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        $request_parameters = $request->query->all();

        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $result = $queryBuilder->select('pr.id', 'pr.date_created', 'pr.date_deleted', 'pr.date_start', 'pr.date_end', 'pr.signup_code',
            'designers.id AS designers', 'designers.username AS designers_username',
            'courses.id AS course_id', 'courses.name AS course_name')
            ->from('app_users', 'professors')
            ->innerJoin('professors', 'professor_registrations', 'pr', 'professors.id = pr.professor_id')
            ->innerJoin('pr', 'app_users', 'designers', 'pr.professor_id = designers.id')
            ->innerJoin('pr', 'courses', 'courses', 'pr.course_id = courses.id')
            ->where('professors.id = ?')
            ->setParameter(0, $user_id)->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($result), 'data' => $result));
        $jsr->setStatusCode(200);
        return $jsr;
    }

    /**
     * Gets the structure of the professor's main page.
     *
     * Professor Registration + Basic Course Information
     *      -Classes + Student Registration with the class
     *
     *
     * @Route("/api/professor/main", name="getMainStructureProfessor")
     * @Method({"GET"})
     */
    public function getMainPageStructure(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();

        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $professor_registrations = $queryBuilder->select('pr.id', 'pr.date_created', 'pr.date_deleted', 'pr.date_start', 'pr.date_end', 'pr.signup_code',
            'designers.id AS designers', 'designers.username AS designers_username',
            'courses.id AS course_id', 'courses.name AS course_name')
            ->from('app_users', 'professors')
            ->innerJoin('professors', 'professor_registrations', 'pr', 'professors.id = pr.professor_id')
            ->innerJoin('pr', 'app_users', 'designers', 'pr.professor_id = designers.id')
            ->innerJoin('pr', 'courses', 'courses', 'pr.course_id = courses.id')
            ->where('professors.id = ?')
            ->setParameter(0, $user_id)->execute()->fetchAll();

        for ($i = 0; $i < count($professor_registrations); $i++) {

            $pr_id = $professor_registrations[$i]['id'];
            $queryBuilder = $conn->createQueryBuilder();
            $results = $queryBuilder->select('classes.id AS class_id', 'classes.name AS class_name',
                'sr.id AS student_Registration_id', 'sr.date_start AS student_registration_date_start', 'sr.date_end AS student_registration_date_end')
                ->from('professor_registrations', 'pr')->innerJoin('pr', 'courses', 'courses', 'pr.course_id = courses.id')
                ->innerJoin('pr', 'classes', 'classes', 'pr.id = classes.registration_id')
                ->leftJoin('classes', 'student_registrations', 'sr', 'sr.class_id = classes.id')
                ->where('pr.id = ?')
                ->setParameter(0, $pr_id)->execute()->fetchAll();
            $professor_registrations[$i]['classes'] = $results;
            $professor_registrations[$i]['number_of_classes'] = count($results);
        }
        $jsr = new JsonResponse(array('size' => count($professor_registrations), 'data' => $professor_registrations));
        $jsr->setStatusCode(200);
        return $jsr;
    }

    /**
     * Gets detailed information on a student registrations that the professor has
     *
     * @Route("/api/professor/registrations/student/{id}", name="getStudentRegistrationSingleAsProfessor")
     * @Method({"GET"})
     */
    public function getStudentRegistration(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        $stu_id = $id;

        // makes sure that the class id is numeric
        if (!is_numeric($stu_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('classes.id AS class_id', 'classes.name AS class_name',
            'sr.id AS student_Registration_id', 'sr.date_start AS student_registration_date_start', 'sr.date_end AS student_registration_date_end')
            ->from('professor_registrations', 'pr')->innerJoin('pr', 'courses', 'courses', 'pr.course_id = courses.id')
            ->innerJoin('pr', 'classes', 'classes', 'pr.id = classes.registration_id')
            ->innerJoin('pr', 'app_users', 'professors', 'pr.professor_id = professors.id')
            ->leftJoin('classes', 'student_registrations', 'sr', 'sr.class_id = classes.id')
            ->where('sr.id = ?')->andWhere('professors.id = ?')
            ->setParameter(0, $stu_id)->setParameter(1, $user_id)->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($results), 'data' => $results));
        $jsr->setStatusCode(200);
        return $jsr;
    }

    /**
     * Gets student registrations that the professor has
     *
     * @Route("/api/professor/registrations/student", name="getStudentRegistrationAsProfessor")
     * @Method({"GET"})
     */
    public function getStudentRegistrations(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();

        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('classes.id AS class_id', 'classes.name AS class_name',
            'sr.id AS student_Registration_id', 'sr.date_start AS student_registration_date_start', 'sr.date_end AS student_registration_date_end')
            ->from('professor_registrations', 'pr')->innerJoin('pr', 'courses', 'courses', 'pr.course_id = courses.id')
            ->innerJoin('pr', 'classes', 'classes', 'pr.id = classes.registration_id')
            ->innerJoin('pr', 'app_users', 'professors', 'pr.professor_id = professors.id')
            ->leftJoin('classes', 'student_registrations', 'sr', 'sr.class_id = classes.id')
            ->andWhere('professors.id = ?')
            ->setParameter(0, $user_id)->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($results), 'data' => $results));
        $jsr->setStatusCode(200);
        return $jsr;
    }

    /**
     * Creates a student registration
     * 
     * Takes in: date_start, date_end, class_id, name
     *
     * @Route("/api/professor/registrations/student", name="createStudentRegistrationAsProfessor")
     * @Method({"POST"})
     */
    public function createStudentRegistration(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        $post_parameters = $request->request->all();

        if (array_key_exists('date_start', $post_parameters) && array_key_exists('date_end', $post_parameters) && array_key_exists('class_id', $post_parameters) && array_key_exists('name', $post_parameters)) {
            $date_start = $post_parameters['date_start'];
            $date_end = $post_parameters['date_end'];
            $class_id = $post_parameters['class_id'];
            $name = $post_parameters['name'];
            if (!is_numeric($date_start) || !is_numeric($date_end) || !is_numeric($class_id)) {
                $jsr = new JsonResponse(array('error' => 'Incorrect type for values.'));
                $jsr->setStatusCode(503);
                return $jsr;
            }
            if ($date_start > $date_end) {
                $jsr = new JsonResponse(array('error' => 'The start date cannot be after the end date.'));
                $jsr->setStatusCode(503);
                return $jsr;
            }
            $conn = Database::getInstance();

            // check to make sure the class being paired with the student registration is valid, and professor has access to it
            $queryBuilder = $conn->createQueryBuilder();
            $results = $queryBuilder->select('classes.id', 'classes.name', 'pr.owner_id', 'pr.id AS prof_reg_id')
                ->from('professor_registrations', 'pr')->innerJoin('pr', 'courses', 'courses', 'pr.course_id = courses.id')
                ->innerJoin('pr', 'classes', 'classes', 'pr.id = classes.registration_id')
                ->where('pr.professor_id = ?')->andWhere('classes.id = ?')->setParameter(0, $user_id)->setParameter(1, $class_id)->execute()->fetchAll();
            if (count($results) < 1) {
                $jsr = new JsonResponse(array('error' => 'Invalid class ID.'));
                $jsr->setStatusCode(500);
                return $jsr;
            }
            $designer_id = $results[0]['owner_id'];
            $prof_reg_id = $results[0]['prof_reg_id'];

            // make sure a student registration between this professor and the same class doesn't already exist
            $queryBuilder = $conn->createQueryBuilder();
            $results = $queryBuilder->select('sr.id')
                ->from('student_registrations', 'sr')->innerJoin('sr', 'professor_registrations', 'pr', 'sr.prof_registration_id = pr.id')
                ->where('pr.professor_id = ?')->andWhere('sr.class_id = ?')->setParameter(0, $user_id)->setParameter(1, $class_id)->execute()->fetchAll();
            if (count($results) >= 1) {
                $jsr = new JsonResponse(array('error' => 'A registration code for this class already exists.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->insert('student_registrations')
                ->values(
                    array(
                        'date_start' => '?',
                        'date_end' => '?',
                        'class_id' => '?',
                        'designer_id' => '?',
                        'prof_registration_id' => '?',
                        'date_created' => '?',
                        'signup_code' => '?',
                        'name' => '?'
                    )
                )
                ->setParameter(0, $date_start)->setParameter(1, $date_end)->setParameter(2, $class_id)->setParameter(3, $designer_id)->setParameter(4, $prof_reg_id)
                ->setParameter(5, time())->setParameter(6, md5(mt_rand()))->setParameter(7, $name)->execute();

            return new Response();

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(200);
            return $jsr;
        }
    }

    /**
     * Edits an existing professor registration tied to the currently logged in designer
     * Editing of foreign relationships is currently not supported.
     *
     * Takes in:
     *      "date_start" - start date of activation
     *      "date_end" - end date of activation
     *      "name" - name of class
     *
     * @Route("/api/professor/registrations/student/{id}", name="editStudentRegistrationAsProfessor")
     * @Method({"POST"})
     */
    public function editStudentRegistration(Request $request, $id)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        $sr_id = $id;

        if (!is_numeric($sr_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the student registration belongs to the professor
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('sr.signup_code')->from('student_registrations', 'sr')
            ->innerJoin('sr', 'professor_registrations', 'pr', 'pr.id = sr.prof_registration_id')
            ->where('pr.professor_id = ?')->andWhere('sr.id = ?')
            ->setParameter(0, $user_id)->setParameter(1, $sr_id)->execute()->fetchAll();
        if (count($results) < 1) {
            $jsr = new JsonResponse(array('error' => 'Student Registration does not exist or does not belong to the currently authenticated user.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        $post_parameters = $request->request->all();

        $queryBuilder = $conn->createQueryBuilder();
        $queryBuilder->update('student_registrations');
        if (array_key_exists('date_start', $post_parameters) && array_key_exists('date_end', $post_parameters) && array_key_exists('name', $post_parameters)) {
            $date_start = $post_parameters['date_start'];
            $date_end = $post_parameters['date_end'];
            $name = $post_parameters['name'];
            if (!is_numeric($date_start) || !is_numeric($date_end)) {
                $jsr = new JsonResponse(array('error' => 'Incorrect type for values.'));
                $jsr->setStatusCode(503);
                return $jsr;
            }
            if ($date_start > $date_end) {
                $jsr = new JsonResponse(array('error' => 'The start date cannot be after the end date.'));
                $jsr->setStatusCode(503);
                return $jsr;
            }
            $queryBuilder->set('date_start', '?')
                ->set('date_end', '?')->set('name', '?')->where('id = ?')
                ->setParameter(0, $date_start)->setParameter(1, $date_end)->setParameter(2, $name)->setParameter(3, $sr_id)->execute();

            return new Response();
        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

    }

    /**
     * Deletes a student registrations that the professor has
     *
     * @Route("/api/professor/registrations/student/{id}", name="deleteStudentRegistrationSingleAsProfessor")
     * @Method({"DELETE"})
     */
    public function deleteStudentRegistration(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        $stu_id = $id;

        // makes sure that the class id is numeric
        if (!is_numeric($stu_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // make sure the student registration exists
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('sr.date_end AS student_registration_date_end')
            ->from('professor_registrations', 'pr')->innerJoin('pr', 'courses', 'courses', 'pr.course_id = courses.id')
            ->innerJoin('pr', 'classes', 'classes', 'pr.id = classes.registration_id')
            ->innerJoin('pr', 'app_users', 'professors', 'pr.professor_id = professors.id')
            ->leftJoin('classes', 'student_registrations', 'sr', 'sr.class_id = classes.id')
            ->where('sr.id = ?')->andWhere('professors.id = ?')
            ->setParameter(0, $stu_id)->setParameter(1, $user_id)->execute()->fetchAll();

        if (count($results) < 1) {
            $jsr = new JsonResponse(array('error' => 'Registration does not exist or does not belong to the currently authenticated user.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->delete('student_registrations')->where('student_registrations.id = ?')
            ->setParameter(0, $stu_id)->execute();

        return new Response();
    }

    /**
     * Gets all classes that the professor owns
     *
     * Can filter by name
     *
     * @Route("/api/professor/classes", name="getClassesAsProfessor")
     * @Method({"GET"})
     */
    public function getClasses(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        $request_parameters = $request->query->all();

        // gets the name parameter from request parameters, or just leaves it as double wildcard
        $name = "%%";
        if (array_key_exists('name', $request_parameters)) {
            $name = '%' . $request_parameters['name'] . '%';
        }
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $result = $queryBuilder->select('classes.id', 'classes.name')
            ->from('professor_registrations', 'pr')->innerJoin('pr', 'courses', 'courses', 'pr.course_id = courses.id')
            ->innerJoin('pr', 'classes', 'classes', 'pr.id = classes.registration_id')
            ->where('pr.professor_id = ?')->andWhere('classes.name LIKE ?')
            ->setParameter(0, $user_id)->setParameter(1, $name)->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($result), 'data' => $result));
        $jsr->setStatusCode(200);
        return $jsr;
    }

    /**
     * Gets information on a specific class that the professor owns
     *
     * @Route("/api/professor/classes/{id}", name="getClassAsProfessor")
     * @Method({"GET"})
     */
    public function getClass(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        $class_id = $id;
        
        // makes sure that the class id is numeric
        if (!is_numeric($class_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
        
        // runs query to get the class specified
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('classes.id', 'classes.name')
            ->from('professor_registrations', 'pr')->innerJoin('pr', 'courses', 'courses', 'pr.course_id = courses.id')
            ->innerJoin('pr', 'classes', 'classes', 'pr.id = classes.registration_id')
            ->where('pr.professor_id = ?')->andWhere('classes.id = ?')
            ->setParameter(0, $user_id)->setParameter(1, $class_id)->execute()->fetchAll();

        // if nothing was returned, give error. if multiple results, also give error (each key should be unique)
        if (count($results) < 1) {
            $jsr = new JsonResponse(array('error' => 'Course does not exist or does not belong to the currently authenticated user.'));
            $jsr->setStatusCode(503);
            return $jsr;
        } else if (count($results) > 1) {
            $jsr = new JsonResponse(array('error' => 'An error has occurred. Check for duplicate keys in the database.'));
            $jsr->setStatusCode(500);
            return $jsr;
        }

        return new JsonResponse($results[0]);
    }

    /**
     * Creates a class from a course that the professor can use
     *
     * Takes in:
     *      name - name of the class
     *      course_id - id of the course
     *
     * @Route("/api/professor/classes", name="createClass")
     * @Method({"POST"})
     */
    public function createClass(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();

        $post_parameters = $request->request->all();

        // check for required parameters
        if (array_key_exists('name', $post_parameters) && array_key_exists('course_id', $post_parameters)) {
            $name = $post_parameters['name'];
            $course_id = $post_parameters['course_id'];
            
            // make sure int values should be numeric
            if (!is_numeric($course_id)) {
                $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }
            
            $conn = Database::getInstance();
            $queryBuilder = $conn->createQueryBuilder();
            
            // check to make sure that the professor has rights to create a class off of this course
            // by checking his professor registrations
            $results = $queryBuilder->select('pr.id', 'pr.date_start', 'pr.date_end')->from('professor_registrations', 'pr')->where('pr.professor_id = ?')
                ->andWhere('pr.course_id = ?')
                ->setParameter(0, $user_id)->setParameter(1, $course_id)->execute()->fetchAll();
            if (count($results) < 1) {
                $jsr = new JsonResponse(array('error' => 'Not allowed to create a class of this course.'));
                $jsr->setStatusCode(503);
                return $jsr;
            }
            
            // get start and end dates of the course of the registration we have to make sure the course has not expired
            $prof_reg_id = $results[0]['id'];
            $today = time();
            if ($today < $results[0]['date_start'] || $today > $results[0]['date_end']) {
                $jsr = new JsonResponse(array('error' => 'The course has expired, or has not been activated yet.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->insert('classes')
                ->values(
                    array(
                        'name' => '?',
                        'registration_id' => '?',
                        'course_id' => '?'
                    )
                )
                ->setParameter(0, $name)->setParameter(1, $prof_reg_id)->setParameter(2, $course_id)->execute();

            return new Response();

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(200);
            return $jsr;
        }
    }


    /**
     * Edits a class from a course that the professor can use
     *
     * Takes in:
     *      name - name of the course
     *      course_id - id of the course
     *
     * @Route("/api/professor/classes/{id}", name="editClass")
     * @Method({"POST"})
     */
    public function editClass(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        $class_id = $id;

        $post_parameters = $request->request->all();

        if (array_key_exists('name', $post_parameters)) {
            $name = $post_parameters['name'];
            if (!is_numeric($class_id)) {
                $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }
            $conn = Database::getInstance();

            // make sure the class exists
            $queryBuilder = $conn->createQueryBuilder();
            $results = $queryBuilder->select('pr.id', 'pr.date_start', 'pr.date_end')->from('classes')
                ->innerJoin('classes', 'professor_registrations', 'pr', 'classes.registration_id = pr.id')
                ->where('pr.professor_id = ?')->andWhere('classes.id = ?')
                ->setParameter(0, $user_id)->setParameter(1, $class_id)->execute()->fetchAll();
            if (count($results) < 1) {
                $jsr = new JsonResponse(array('error' => 'Not allowed to edit this class.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }
            $today = time();
            if ($today < $results[0]['date_start'] || $today > $results[0]['date_end']) {
                $jsr = new JsonResponse(array('error' => 'The course has expired, or has not been activated yet.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->update('classes')->set('classes.name', '?')->where('classes.id = ?')
                ->setParameter(0, $name)->setParameter(1, $class_id)->execute();

            return new Response();

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(200);
            return $jsr;
        }
    }


    /**
     * Deletes a specific class that the professor owns
     *
     * @Route("/api/professor/classes/{id}", name="deleteClass")
     * @Method({"DELETE"})
     */
    public function deleteClass(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        $class_id = $id;

        // makes sure that the class id is numeric
        if (!is_numeric($class_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // runs query to get the class specified
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('classes.id', 'classes.name')
            ->from('professor_registrations', 'pr')->innerJoin('pr', 'courses', 'courses', 'pr.course_id = courses.id')
            ->innerJoin('pr', 'classes', 'classes', 'pr.id = classes.registration_id')
            ->where('pr.professor_id = ?')->andWhere('classes.id = ?')
            ->setParameter(0, $user_id)->setParameter(1, $class_id)->execute()->fetchAll();

        // if nothing was returned, give error. if multiple results, also give error (each key should be unique)
        if (count($results) < 1) {
            $jsr = new JsonResponse(array('error' => 'Course does not exist or does not belong to the currently authenticated user.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->delete('student_registrations')->where('student_registrations.id = ?')
            ->setParameter(0, $class_id)->execute();

        return new Response();
    }

//    /**
//     * @Route("/professor/", name="professorIndex")
//     */
//    public function indexAction(Request $request)
//    {
//        return $this->render('professor/index.html.twig', [
//            'base_dir' => realpath($this->getParameter('kernel.root_dir').'..').DIRECTORY_SEPARATOR,
//        ]);
//    }
//
//    /**
//     * @Route("/professor/registrations", name="professorRegistrations")
//     */
//    public function showRegistrationsAction(Request $request)
//    {
//        //$owned_registrations = $this->getUser()->getOwnedRegistrations();
//        return $this->render('professor/registrations.html.twig', array(
//            'base_dir' => realpath($this->getParameter('kernel.root_dir').'..').DIRECTORY_SEPARATOR,
//        ));
//    }
//
//    /**
//     * @Route("/professor/registrations/make", name="professorRegistrationsMake")
//     */
//    public function showRegistrationsMakeAction(Request $request)
//    {
//        $registration = new Registration();
//        $registrationCode = $this->generateSignupCode();
//        $manager = $this->getDoctrine()->getManager();
//
//        $regInfo = array(
//            'dateStart' => new DateTime('@' . time(), new DateTimeZone($this->getUser()->getTimezone())),
//            'dateEnd' => new DateTime('@' . time(), new DateTimeZone($this->getUser()->getTimezone()))
//        );
//        $form = $this->createFormBuilder($regInfo)
//            ->add('dateStart', DateTimeType::class)
//            ->add('dateEnd', DateTimeType::class)
//            ->add('save', SubmitType::class, array('label' => 'Edit Registration'))
//            ->getForm();
//
//        $form->handleRequest($request);
//
//        if($form->isSubmitted() && $form->isValid()) {
//            $regInfo = $form->getData();
//            $registration->setDateStart($regInfo['dateStart']->getTimestamp());
//            $registration->setDateEnd($regInfo['dateEnd']->getTimestamp());
//            $registration->setDateCreated(time());
//            $registration->setSignupCode($registrationCode);
//            $registration->setOwner($this->getUser());
//            $manager->persist($registration);
//            $manager->flush();
//
//            return $this->render('professor/makeRegistrations.2.html.twig', array(
//                'base_dir' => realpath($this->getParameter('kernel.root_dir').'..').DIRECTORY_SEPARATOR,
//                'signup_code' => $registrationCode
//            ));
//        }
//
//        return $this->render('professor/makeRegistrations.html.twig', array(
//            'base_dir' => realpath($this->getParameter('kernel.root_dir').'..').DIRECTORY_SEPARATOR,
//            'form' => $form->createView(),
//        ));
//    }
//
//    /**
//     * @Route("/professor/registrations/edit/{id}", name="professorRegistrationsEdit")
//     */
//    public function showRegistrationEditAction(Request $request, $id)
//    {
//        $registration = $this->getDoctrine()->getRepository('AppBundle:Registration')->findOneById($id);
//        $manager = $this->getDoctrine()->getManager();
//
//        $regInfo = array(
//            'dateStart' => new DateTime('@' . $registration->getDateStart(), new DateTimeZone($this->getUser()->getTimezone())),
//            'dateEnd' => new DateTime('@' . $registration->getDateEnd(), new DateTimeZone($this->getUser()->getTimezone()))
//        );
//        $form = $this->createFormBuilder($regInfo)
//            ->add('dateStart', DateTimeType::class)
//            ->add('dateEnd', DateTimeType::class)
//            ->add('save', SubmitType::class, array('label' => 'Edit Registration'))
//            ->getForm();
//
//        $form->handleRequest($request);
//
//        if($form->isSubmitted() && $form->isValid()) {
//            $regInfo = $form->getData();
//            $registration->setDateStart($regInfo['dateStart']->getTimestamp());
//            $registration->setDateEnd($regInfo['dateEnd']->getTimestamp());
//            $users = $registration->getUsers();
//            foreach($users as $user) {
//                $user->setDateStart($registration->getDateStart());
//                $user->setDateEnd($registration->getDateEnd());
//            }
//            $manager->persist($registration);
//            $manager->flush();
//
//            return $this->redirectToRoute('professorRegistrations');
//        }
//
//        return $this->render('professor/makeRegistrations.html.twig', array(
//            'base_dir' => realpath($this->getParameter('kernel.root_dir').'..').DIRECTORY_SEPARATOR,
//            'form' => $form->createView(),
//        ));
//    }
//
//    private function generateSignupCode() {
//        $randString = "";
//        for($i = 0; $i < 16; $i++) {
//            $randVal = rand(0,35);
//            if($randVal > 25) {
//                $randString .= $randVal - 26;
//            } else {
//                $randString .= chr($randVal + 97);
//            }
//        }
//        return $randString;
//
//    }
}
