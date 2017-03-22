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
use AppBundle\Repository\ClassRepository;
use AppBundle\Database;

/**
 * Available functions:
 *
 * getRegistrations - /api/professor/registrations/professor
 * getRegistration - /api/professor/registrations/professor/{id}
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
     * Gets all professor registrations that the professor has
     *
     * @Route("/api/professor/registrations/professor/{id}", name="getProfRegistrationAsProfessor")
     * @Method({"GET", "OPTIONS"})
     */
    public function getRegistration(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ProfessorRegistrationRepository::getProfessorRegistration($request, $user_id, 'professor', $id);
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
        return ClassRepository::getClasses($request, $user_id, 'professor');
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
        return ClassRepository::getClass($request, $user_id, 'professor', $id);
    }

    /**
     * Creates a class from a course that the professor can use
     *
     * Takes in:
     *      name - name of the class
     *      course_id - id of the course
     *      description
     *
     * @Route("/api/professor/classes", name="createClass")
     * @Method({"POST", "OPTIONS"})
     */
    public function createClass(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ClassRepository::createClass($request, $user_id, 'professor');
    }


    /**
     * Edits a class from a course that the professor can use
     *
     * Takes in:
     *      name - name of the course
     *      description
     *
     * @Route("/api/professor/classes/{id}", name="editClass")
     * @Method({"POST", "OPTIONS"})
     */
    public function editClass(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ClassRepository::editClass($request, $user_id, 'professor', $id);
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
        return ClassRepository::deleteClass($request, $user_id, 'professor', $id);
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
        return UserRepository::getStudentsByRegistration($request, $user_id, 'professor', $id);
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
        return UserRepository::deleteStudent($request, $user_id, 'professor', $id);
    }

}
