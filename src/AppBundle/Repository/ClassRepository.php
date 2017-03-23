<?php

namespace AppBundle\Repository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Database;
/**
 * ClassRepository
 *
 * Database interaction methods for courses
 */
class ClassRepository extends \Doctrine\ORM\EntityRepository
{
    public static function getClasses(Request $request, $user_id, $user_type) {
        // a user MUST be a professor to get all classes
        if (strcmp($user_type, 'professor') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }
        
        $request_parameters = $request->query->all();

        // gets the name parameter from request parameters, or just leaves it as double wildcard
        $name = "%%";
        if (array_key_exists('name', $request_parameters)) {
            $name = '%' . $request_parameters['name'] . '%';
        }
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('classes.id', 'classes.name', 'classes.description', 'classes.course_id', 'classes.registration_id')
            ->from('professor_registrations', 'pr')->innerJoin('pr', 'courses', 'courses', 'pr.course_id = courses.id')
            ->innerJoin('pr', 'classes', 'classes', 'pr.id = classes.registration_id')
            ->where('pr.professor_id = ?')->andWhere('classes.name LIKE ?')
            ->setParameter(0, $user_id)->setParameter(1, $name)->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($results), 'data' => $results));
        $jsr->setStatusCode(200);
        return $jsr;
    }

    public static function getClass(Request $request, $user_id, $user_type, $class_id) {
        // makes sure that the class id is numeric
        if (!is_numeric($class_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // runs query to get the class specified
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = null;
        if (strcmp($user_type, 'professor') == 0) {
            $results = $queryBuilder->select('classes.id', 'classes.name', 'classes.description', 'classes.course_id', 'classes.registration_id')
                ->from('professor_registrations', 'pr')->innerJoin('pr', 'courses', 'courses', 'pr.course_id = courses.id')
                ->innerJoin('pr', 'classes', 'classes', 'pr.id = classes.registration_id')
                ->where('pr.professor_id = ?')->andWhere('classes.id = ?')
                ->setParameter(0, $user_id)->setParameter(1, $class_id)->execute()->fetchAll();
        } else if (strcmp($user_type, 'student') == 0) {
            $results = $queryBuilder->select('classes.id', 'classes.name', 'classes.description', 'sr.date_start', 'sr.date_end', 'classes.course_id', 'classes.registration_id')
                ->from('app_users', 'students')->innerJoin('students', 'student_registrations', 'sr', 'students.student_registration_id = sr.id')
                ->innerJoin('sr', 'classes', 'classes', 'sr.class_id = classes.id')
                ->where('students.id = ?')->andWhere('sr.date_start < ?')->andWhere('sr.date_end > ?')
                ->setParameter(0, $user_id)->setParameter(1, time())->setParameter(2, time())->execute()->fetchAll();
        } else {
            $jsr = new JsonResponse(array('error' => 'Internal server error.'));
            $jsr->setStatusCode(500);
            return $jsr;
        }

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

    public static function createClass(Request $request, $user_id, $user_type) {
        // a user MUST be a professor to create a class
        if (strcmp($user_type, 'professor') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        $post_parameters = $request->request->all();

        // check for required parameters
        if (array_key_exists('name', $post_parameters) && array_key_exists('course_id', $post_parameters) && array_key_exists('description', $post_parameters)) {
            $name = $post_parameters['name'];
            $course_id = $post_parameters['course_id'];
            $description = $post_parameters['description'];

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
                        'course_id' => '?',
                        'description' => '?'
                    )
                )
                ->setParameter(0, $name)->setParameter(1, $prof_reg_id)->setParameter(2, $course_id)->setParameter(3, $description)->execute();

            $class_id = $conn->lastInsertId();

            return ClassRepository::getClass($request, $user_id, $user_type, $class_id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }

    public static function editClass(Request $request, $user_id, $user_type, $class_id) {
        // a user MUST be a professor to edit a class
        if (strcmp($user_type, 'professor') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }
        $post_parameters = $request->request->all();

        if (array_key_exists('name', $post_parameters) && array_key_exists('description', $post_parameters)) {
            $name = $post_parameters['name'];
            $description = $post_parameters['description'];
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
            $queryBuilder->update('classes')->set('classes.name', '?')->set('classes.description', '?')->where('classes.id = ?')
                ->setParameter(0, $name)->setParameter(1, $description)->setParameter(2, $class_id)->execute();

            return ClassRepository::getClass($request, $user_id, $user_type, $class_id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }

    public static function deleteClass(Request $request, $user_id, $user_type, $class_id) {
        // a user MUST be a professor to delete a class
        if (strcmp($user_type, 'professor') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        // makes sure that the class id is numeric
        if (!is_numeric($class_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if class given belongs to the currently logged in user
        $result = ClassRepository::getClass($request, $user_id, $user_type, $class_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $queryBuilder->delete('classes')->where('classes.id = ?')
            ->setParameter(0, $class_id)->execute();

        return new Response();
    }
}