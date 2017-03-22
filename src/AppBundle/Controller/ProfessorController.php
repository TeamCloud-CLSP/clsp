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
use AppBundle\Repository\CourseRepository;
use AppBundle\Repository\StudentRegistrationRepository;
use AppBundle\Repository\ProfessorRegistrationRepository;
use AppBundle\Repository\UserRepository;
use AppBundle\Database;

/**
 * Available functions:
 *
 * getCourses - /api/professor/courses
 * getRegistrations - /api/professor/registrations/professor
 * getMainPageStructure - /api/professor/main - (told Yuanhan about this - this should be how he wants to set up the main professor page - see the function for more details)
 * getStudentRegistration - /api/professor/registrations/student/{id}
 * getStudentRegistrationByClass - /api/professor/classes/{id}/registrations/student
 * getStudentRegistrations - /api/professor/registrations/student
 * createStudentRegistration - /api/professor/registrations/student (POST) - takes in date_start, date_end, class_id, max_registrations
 * editStudentRegistration - /api/professor/registrations/student/{id} (POST) - takes in date_start, date_end, max_registrations
 * deleteStudentRegistration - /api/professor/registrations/student/{id} (DELETE)
 * getClasses - /api/professor/classes - /api/professor/classes/{id}
 * getClass - /api/professor/classes/{id}
 * createClass - /api/professor/classes (POST) - takes in name, course_id, description
 * editClass - /api/professor/classes/{id} (POST) - takes in name, description
 * deleteClass - /api/professor/classes/{id} (DELETE)
 * getStudentsByRegistration - /api/professor/registrations/student/{id}/students
 * deleteStudent - /api/professor/student/{id} - will only delete the student if the student belongs to one of the professor's classes
 * 
 * Remember that each student account can only have one class.
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
     * @Method({"GET", "OPTIONS"})
     */
    public function getCourses(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return CourseRepository::getCourses($request, $user_id, 'professor');
    }

    /**
     * Gets all professor registrations that the professor has
     *
     * @Route("/api/professor/registrations/professor", name="getProfRegistrationsAsProfessor")
     * @Method({"GET", "OPTIONS"})
     */
    public function getRegistrations(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ProfessorRegistrationRepository::getProfessorRegistrations($request, $user_id, 'professor');
    }

    /**
     * Gets the structure of the professor's main page.
     *
     * Professor Registration + Basic Course Information
     *      -Classes + Student Registration with the class
     *
     *
     * @Route("/api/professor/main", name="getMainStructureProfessor")
     * @Method({"GET", "OPTIONS"})
     */
    public function getMainPageStructure(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return UserRepository::getProfessorDashboard($request, $user_id, 'professor');
    }

    /**
     * Gets detailed information on a student registrations that the professor has
     *
     * @Route("/api/professor/registrations/student/{id}", name="getStudentRegistrationSingleAsProfessor")
     * @Method({"GET", "OPTIONS"})
     */
    public function getStudentRegistration(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return StudentRegistrationRepository::getStudentRegistration($request, $user_id, 'professor', $id);
    }

    /**
     * Gets detailed information on a student registrations that the professor has given a class id
     *
     * @Route("/api/professor/classes/{id}/registrations/student", name="getStudentRegistrationSingleAsProfessorByClass")
     * @Method({"GET", "OPTIONS"})
     */
    public function getStudentRegistrationByClass(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return StudentRegistrationRepository::getStudentRegistrationByClass($request, $user_id, 'professor', $id);
    }

    /**
     * Gets student registrations that the professor has
     *
     * @Route("/api/professor/registrations/student", name="getStudentRegistrationAsProfessor")
     * @Method({"GET", "OPTIONS"})
     */
    public function getStudentRegistrations(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return StudentRegistrationRepository::getStudentRegistrations($request, $user_id, 'professor');
    }

    /**
     * Creates a student registration
     * 
     * Takes in: date_start, date_end, class_id, max_registrations
     *
     * @Route("/api/professor/registrations/student", name="createStudentRegistrationAsProfessor")
     * @Method({"POST", "OPTIONS"})
     */
    public function createStudentRegistration(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return StudentRegistrationRepository::createStudentRegistration($request, $user_id, 'professor');
    }

    /**
     * Edits an existing professor registration tied to the currently logged in designer
     * Editing of foreign relationships is currently not supported.
     *
     * Takes in:
     *      "date_start" - start date of activation
     *      "date_end" - end date of activation
     *      "max_registrations"
     *
     * @Route("/api/professor/registrations/student/{id}", name="editStudentRegistrationAsProfessor")
     * @Method({"POST", "OPTIONS"})
     */
    public function editStudentRegistration(Request $request, $id)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return StudentRegistrationRepository::editStudentRegistration($request, $user_id, 'professor', $id);
    }

    /**
     * Deletes a student registrations that the professor has
     *
     * @Route("/api/professor/registrations/student/{id}", name="deleteStudentRegistrationSingleAsProfessor")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteStudentRegistration(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        
    }

    /**
     * Gets all classes that the professor owns
     *
     * Can filter by name
     *
     * @Route("/api/professor/classes", name="getClassesAsProfessor")
     * @Method({"GET", "OPTIONS"})
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
     * @Method({"GET", "OPTIONS"})
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
            $jsr = new JsonResponse(array('error' => 'Class does not exist or does not belong to the currently authenticated user.'));
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
     * @Method({"POST", "OPTIONS"})
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

            $class_id = $conn->lastInsertId();

            return $this->getClass($request, $class_id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }


    /**
     * Edits a class from a course that the professor can use
     *
     * Takes in:
     *      name - name of the course
     *
     * @Route("/api/professor/classes/{id}", name="editClass")
     * @Method({"POST", "OPTIONS"})
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

            return $this->getClass($request, $class_id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }


    /**
     * Deletes a specific class that the professor owns
     *
     * @Route("/api/professor/classes/{id}", name="deleteClass")
     * @Method({"DELETE", "OPTIONS"})
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
            $jsr = new JsonResponse(array('error' => 'Class does not exist or does not belong to the currently authenticated user.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->delete('classes')->where('classes.id = ?')
            ->setParameter(0, $class_id)->execute();

        return new Response();
    }

    /**
     * Gets list of students that belong to a student registration a professor has
     *
     * Can filter by username and name
     *
     * @Route("/api/professor/registrations/student/{id}/students", name="getStudentsbyStudentRegistration")
     * @Method({"GET", "OPTIONS"})
     */
    public function getStudentsByRegistration(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();

        $sr_id = $id;

        // makes sure that the class id is numeric
        if (!is_numeric($sr_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        $request_parameters = $request->query->all();

        // gets the name parameter from request parameters, or just leaves it as double wildcard
        $username = "%%";
        $name = "%%";
        if (array_key_exists('username', $request_parameters)) {
            $username = '%' . $request_parameters['username'] . '%';
        }

        if (array_key_exists('name', $request_parameters)) {
            $name = '%' . $request_parameters['name'] . '%';
        }

        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('students.id', 'students.username', 'students.name')
            ->from('professor_registrations', 'pr')
            ->innerJoin('pr', 'classes', 'classes', 'pr.id = classes.registration_id')
            ->innerJoin('pr', 'app_users', 'professors', 'pr.professor_id = professors.id')
            ->innerJoin('classes', 'student_registrations', 'sr', 'sr.class_id = classes.id')
            ->innerJoin('sr', 'app_users', 'students', 'students.student_registration_id = sr.id')
            ->where('professors.id = ?')->andWhere('sr.id = ?')->andWhere('students.username LIKE ?')->andWhere('students.name LIKE ?')
            ->setParameter(0, $user_id)->setParameter(1, $sr_id)->setParameter(2, $username)->setParameter(3, $name)->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($results), 'data' => $results));
        $jsr->setStatusCode(200);
        return $jsr;
    }

    /**
     * Deletes a student given its id (the student must belong to one of the professor's classes to be deleted)
     *
     * @Route("/api/professor/student/{id}", name="deleteStudent")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteStudent(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();

        $student_id = $id;

        // makes sure that the class id is numeric
        if (!is_numeric($student_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('students.id', 'students.username', 'students.name')
            ->from('professor_registrations', 'pr')
            ->innerJoin('pr', 'classes', 'classes', 'pr.id = classes.registration_id')
            ->innerJoin('pr', 'app_users', 'professors', 'pr.professor_id = professors.id')
            ->innerJoin('classes', 'student_registrations', 'sr', 'sr.class_id = classes.id')
            ->innerJoin('sr', 'app_users', 'students', 'students.student_registration_id = sr.id')
            ->where('professors.id = ?')->andWhere('students.id = ?')
            ->setParameter(0, $user_id)->setParameter(1, $student_id)->execute()->fetchAll();

        if (count($results) < 1) {
            $jsr = new JsonResponse(array('error' => "Student does not exist, or does not belong to one of the professor's classes."));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->delete('app_users')->where('app_users.id = ?')
            ->setParameter(0, $student_id)->execute();

        return new Response();
    }

}
