<?php

namespace AppBundle\Repository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Database;
/**
 * CourseRepository
 *
 * Database interaction methods for courses
 */
class CourseRepository extends \Doctrine\ORM\EntityRepository
{

    public static function getCourses(Request $request, $user_id, $user_type) {
        // get request parameters, check if name was given
        $request_parameters = $request->query->all();
        $name = "%%";
        if (array_key_exists('name', $request_parameters)) {
            $name = '%' . $request_parameters['name'] . '%';
        }
        
        // run query to get courses that a user can access
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = null;
        if (strcmp($user_type, 'designer') == 0) { // if designer, get only the courses the designer created
            $results = $queryBuilder->select('courses.id', 'courses.name', 'courses.description', 'language.name AS language_name', 'language.id AS language_id')
                ->from('app_users')->innerJoin('app_users', 'courses', 'courses', 'app_users.id = courses.user_id')
                ->innerJoin('courses', 'language', 'language', 'courses.language_id = language.id')->where('app_users.id = ?')->andWhere('courses.name LIKE ?')
                ->setParameter(0, $user_id)->setParameter(1, $name)->execute()->fetchAll();
        } else if (strcmp($user_type, 'professor') == 0) {
            $results = $queryBuilder->select('courses.id', 'courses.name', 'courses.description', 'language.name AS language_name', 'language.id AS language_id', 'pr.date_start', 'pr.date_end')
                ->from('professor_registrations', 'pr')->innerJoin('pr', 'courses', 'courses', 'pr.course_id = courses.id')->innerJoin('courses', 'language', 'language', 'courses.language_id = language.id')
                ->where('pr.professor_id = ?')->andWhere('courses.name LIKE ?')->andWhere('pr.date_start < ?')->andWhere('pr.date_end > ?')
                ->setParameter(0, $user_id)->setParameter(1, $name)->setParameter(2, time())->setParameter(3, time())->execute()->fetchAll();
        } else {
            $jsr = new JsonResponse(array('error' => 'Internal server error.'));
            $jsr->setStatusCode(500);
            return $jsr;
        }
        
        // return data as array
        $jsr = new JsonResponse(array('size' => count($results), 'data' => $results));
        $jsr->setStatusCode(200);
        return $jsr;
    }
    
    public static function getCourse(Request $request, $user_id, $user_type, $course_id) {
        // make sure course id given is numeric
        if (!is_numeric($course_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // run query
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = null;
        if (strcmp($user_type, 'designer') == 0) { // if designer, make sure course was created by designer
            $results = $queryBuilder->select('courses.id', 'courses.name', 'courses.description', 'language.name AS language_name', 'language.id AS language_id')->from('app_users', 'designers')
                ->innerJoin('designers', 'courses', 'courses', 'designers.id = courses.user_id')->innerJoin('courses', 'language', 'language', 'courses.language_id = language.id')
                ->where('designers.id = ?')->andWhere('courses.id = ?')
                ->setParameter(0, $user_id)->setParameter(1, $course_id)->execute()->fetchAll();
        } else if (strcmp($user_type, 'professor') == 0) {
            $results = $queryBuilder->select('courses.id', 'courses.name', 'courses.description', 'language.name AS language_name', 'language.id AS language_id', 'pr.date_start', 'pr.date_end')
                ->from('professor_registrations', 'pr')->innerJoin('pr', 'courses', 'courses', 'pr.course_id = courses.id')->innerJoin('courses', 'language', 'language', 'courses.language_id = language.id')
                ->where('pr.professor_id = ?')->andWhere('pr.date_start < ?')->andWhere('pr.date_end > ?')->andWhere('courses.id = ?')
                ->setParameter(0, $user_id)->setParameter(1, time())->setParameter(2, time())->setParameter(3, $course_id)->execute()->fetchAll();
        } else {
            $jsr = new JsonResponse(array('error' => 'Internal server error.'));
            $jsr->setStatusCode(500);
            return $jsr;
        }
        
        // make sure only one result was returned
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
    
    public static function createCourse(Request $request, $user_id, $user_type) {
        // a user MUST be a designer to create a course
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }
        
        // get post parameters
        $post_parameters = $request->request->all();
        if (array_key_exists('name', $post_parameters) && array_key_exists('description', $post_parameters) && array_key_exists('language_id', $post_parameters)) {
            $name = $post_parameters['name'];
            $description = $post_parameters['description'];
            $language_id = $post_parameters['language_id'];
            if (!is_numeric($language_id)) {
                $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }
            
            // make sure language id specified is valid
            $conn = Database::getInstance();
            $queryBuilder = $conn->createQueryBuilder();
            $results = $queryBuilder->select('language.id', 'language.language_code', 'language.name')
                ->from('language')->where('language.id = ?')->setParameter(0, $language_id)->execute()->fetchAll();
            if (count($results) < 1) {
                $jsr = new JsonResponse(array('error' => 'Invalid language ID specified.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            // create course in the database
            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->insert('courses')
                ->values(
                    array(
                        'name' => '?',
                        'user_id' => '?',
                        'description' => '?',
                        'language_id' => '?'
                    )
                )
                ->setParameter(0, $name)->setParameter(1, $user_id)->setParameter(2, $description)->setParameter(3, $language_id)->execute();

            // fetch the new object, and return it
            $course_id = $conn->lastInsertId();
            return CourseRepository::getCourse($request, $user_id, $user_type, $course_id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }
    
    public static function editCourse(Request $request, $user_id, $user_type, $course_id) {
        // a user MUST be a designer to edit a course
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }
        
        // make sure course id is numeric
        if (!is_numeric($course_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the course belongs to the designer
        $result = CourseRepository::getCourse($request, $user_id, $user_type, $course_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        // get post parameters
        $post_parameters = $request->request->all();
        if (array_key_exists('name', $post_parameters) && array_key_exists('description', $post_parameters) && array_key_exists('language_id', $post_parameters)) {
            $name = $post_parameters['name'];
            $description = $post_parameters['description'];
            $language_id = $post_parameters['language_id'];
            if (!is_numeric($language_id)) {
                $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }
            
            // make sure language id given is valid
            $conn = Database::getInstance();
            $queryBuilder = $conn->createQueryBuilder();
            $results = $queryBuilder->select('language.id', 'language.language_code', 'language.name')
                ->from('language')->where('language.id = ?')->setParameter(0, $language_id)->execute()->fetchAll();
            if (count($results) < 1) {
                $jsr = new JsonResponse(array('error' => 'Invalid language ID specified.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            // update the course information
            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->update('courses')
                ->set('courses.name', '?')
                ->set('courses.description', '?')
                ->set('courses.language_id', '?')
                ->where('courses.id = ?')
                ->setParameter(0, $name)->setParameter(3, $course_id)->setParameter(1, $description)->setParameter(2, $language_id)->execute();

            // return the updated course information
            return CourseRepository::getCourse($request, $user_id, $user_type, $course_id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }
    
    public static function deleteCourse(Request $request, $user_id, $user_type, $course_id) {
        // a user MUST be a designer to delete a course
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }
        
        // make sure course id is numeric
        if (!is_numeric($course_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the course belongs to the designer
        $result = CourseRepository::getCourse($request, $user_id, $user_type, $course_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $queryBuilder->delete('courses')->where('courses.id = ?')->setParameter(0, $course_id)->execute();

        return new Response();
    }
}
