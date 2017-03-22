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
}
