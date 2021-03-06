<?php

namespace AppBundle\Repository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Database;

/**
 * StudentRegistrationRepository
 *
 * Database interaction methods for users
 */
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public static function getProfessors(Request $request, $user_id, $user_type) {
        // a user MUST be a designer to search for professors
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        $request_parameters = $request->query->all();

        // gets the username/name parameter from request parameters, or just leaves it as a wildcard
        $username = "%%";
        $name = "%%";
        if (array_key_exists('username', $request_parameters)) {
            $username = '%' . $request_parameters['username'] . '%';
        }

        if (array_key_exists('name', $request_parameters)) {
            $name = '%' . $request_parameters['name'] . '%';
        }

        // query for list of professors
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $result = $queryBuilder->select('app_users.id', 'app_users.username', 'app_users.name')
            ->from('app_users')->where('app_users.is_professor = 1')->andWhere('app_users.username LIKE ?')->andWhere('app_users.name LIKE ?')
            ->setParameter(0, $username)->setParameter(1, $name)->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($result), 'data' => $result));
        $jsr->setStatusCode(200);
        return $jsr;
    }

    public static function getProfessor(Request $request, $user_id, $user_type, $professor_id) {
        // a user MUST be a designer to receive professor information
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        // get the professor
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('app_users.id', 'app_users.username', 'app_users.name')
            ->from('app_users')->where('app_users.is_professor = 1')->andWhere('app_users.id = ?')
            ->setParameter(0, $professor_id)->execute()->fetchAll();

        // check for invalid results
        if (count($results) < 1) {
            $jsr = new JsonResponse(array('error' => 'Professor account given is invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        } else if (count($results) > 1) {
            $jsr = new JsonResponse(array('error' => 'An error has occurred. Check for duplicate keys in the database.'));
            $jsr->setStatusCode(500);
            return $jsr;
        }

        $jsr = new JsonResponse(array('size' => count($results), 'data' => $results));
        $jsr->setStatusCode(200);
        return $jsr;
    }

    public static function getProfessorDashboard(Request $request, $user_id, $user_type) {
        // a user MUST be a professor to receive professor dashboard information
        if (strcmp($user_type, 'professor') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        // gets the professor registration information (along with course information too)
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $professor_registrations = $queryBuilder->select('pr.id', 'pr.date_created', 'pr.date_deleted', 'pr.date_start', 'pr.date_end', 'pr.signup_code',
            'designers.id AS designers', 'designers.username AS designers_username', 'designers.name AS designers_name',
            'courses.id AS course_id', 'courses.name AS course_name', 'courses.description AS course_description')
            ->from('app_users', 'professors')
            ->innerJoin('professors', 'professor_registrations', 'pr', 'professors.id = pr.professor_id')
            ->innerJoin('pr', 'app_users', 'designers', 'pr.professor_id = designers.id')
            ->innerJoin('pr', 'courses', 'courses', 'pr.course_id = courses.id')
            ->where('professors.id = ?')
            ->setParameter(0, $user_id)->execute()->fetchAll();

        // for each of the prof registrations, loop through and get the classes/student registrations associated with it
        for ($i = 0; $i < count($professor_registrations); $i++) {
            $pr_id = $professor_registrations[$i]['id'];
            $queryBuilder = $conn->createQueryBuilder();
            $results = $queryBuilder->select('classes.id AS class_id', 'classes.name AS class_name', 'classes.description AS class_description',
                'sr.id AS student_registration_id', 'sr.date_start AS student_registration_date_start', 'sr.date_end AS student_registration_date_end', 'sr.max_registrations AS student_registration_max_registrations')
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

    public static function getStudentsByRegistration(Request $request, $user_id, $user_type, $sr_id) {
        // a user MUST be a professor to search students by registration
        if (strcmp($user_type, 'professor') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        // makes sure that the student registration id is numeric
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

    public static function deleteStudent(Request $request, $user_id, $user_type, $student_id) {
        // a user MUST be a professor to delete students in their classes
        if (strcmp($user_type, 'professor') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

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
        $queryBuilder->delete('app_users')->where('app_users.id = ?')
            ->setParameter(0, $student_id)->execute();

        return new Response();
    }

    public static function editUser(Request $request, $user, $encoder) {
        // edits the user

        // check required post parameters
        $post_parameters = $request->request->all();
        if (array_key_exists('name', $post_parameters) && array_key_exists('email', $post_parameters)) {
            $name = $post_parameters['name'];
            $email = $post_parameters['email'];
            $password = null;
            $user_id = $user->getId();

            // check for optional parameter
            if (array_key_exists('password', $post_parameters)) {
                $password = $post_parameters['password'];
                $password = $encoder->encodePassword($user, $password);

                // update user in the database
                $conn = Database::getInstance();
                $queryBuilder = $conn->createQueryBuilder();
                $queryBuilder->update('app_users')
                    ->set('name', '?')
                    ->set('email', '?')
                    ->set('password', '?')
                    ->where('app_users.id = ?')
                    ->setParameter(0, $name)->setParameter(1, $email)->setParameter(2, $password)->setParameter(3, $user_id)->execute();
            } else {
                // update user in the database
                $conn = Database::getInstance();
                $queryBuilder = $conn->createQueryBuilder();
                $queryBuilder->update('app_users')
                    ->set('name', '?')
                    ->set('email', '?')
                    ->where('app_users.id = ?')
                    ->setParameter(0, $name)->setParameter(1, $email)->setParameter(2, $user_id)->execute();
            }
            
            // return the updated song information
            return UserRepository::getUser($request, $user_id);
        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }
    
    public static function getUser(Request $request, $user_id) {
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $result = $queryBuilder->select('id', 'username', 'name', 'email', 'is_active', 'date_created', 'date_deleted', 'date_start', 'date_end', 'timezone', 'is_student',
            'is_professor', 'is_designer', 'is_administrator')
            ->from('app_users')->where('id = ?')->setParameter(0, $user_id)->execute()->fetch();
        $result['is_student']       = ($result['is_student'] == "0" ? false : true);
        $result['is_professor']     = ($result['is_professor'] == "0" ? false : true);
        $result['is_designer']      = ($result['is_designer'] == "0" ? false : true);
        $result['is_administrator'] = ($result['is_administrator'] == "0" ? false : true);
        $jsr = new JsonResponse($result);
        $jsr->setStatusCode(200);
        return $jsr;
    }
}
