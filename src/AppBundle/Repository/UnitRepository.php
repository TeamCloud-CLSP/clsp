<?php

namespace AppBundle\Repository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Database;
use AppBundle\Repository\CourseRepository;

/**
 * UnitRepository
 *
 * Database interaction methods for units
 */
class UnitRepository extends \Doctrine\ORM\EntityRepository
{
    
    public static function getUnits(Request $request, $user_id, $user_type, $course_id) {
        // make sure course id is numeric
        if (!is_numeric($course_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the course is accessible to the currently logged in user
        $result = CourseRepository::getCourse($request, $user_id, $user_type, $course_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        // run query to get units that belong to the course
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('unit.name', 'unit.description', 'unit.id', 'unit.weight')
            ->from('courses')
            ->innerJoin('courses', 'unit', 'unit', 'unit.course_id = courses.id')->where('course_id = ?')
            ->orderBy('unit.weight', 'ASC')
            ->setParameter(0, $course_id)->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($results), 'data' => $results));
        return $jsr;
    }
    
    public static function getUnit(Request $request, $user_id, $user_type, $unit_id) {
        // make sure unit id is numeric
        if (!is_numeric($unit_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // run query to get the unit
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = null;
        if (strcmp($user_type, 'designer') == 0) { // if designer, make sure that the designer owns the unit
            $results = $queryBuilder->select('unit.name', 'unit.description', 'unit.id', 'unit.weight', 'courses.id AS course_id')
                ->from('app_users', 'designers')->innerJoin('designers', 'courses', 'courses', 'designers.id = courses.user_id')
                ->innerJoin('courses', 'unit', 'unit', 'unit.course_id = courses.id')->where('designers.id = ?')->andWhere('unit.id = ?')
                ->orderBy('unit.weight', 'ASC')
                ->setParameter(0, $user_id)->setParameter(1, $unit_id)->execute()->fetchAll();
        } else {
            $jsr = new JsonResponse(array('error' => 'Internal server error.'));
            $jsr->setStatusCode(500);
            return $jsr;
        }
        
        // check for invalid results
        if (count($results) < 1) {
            $jsr = new JsonResponse(array('error' => 'Unit does not exist or does not belong to the currently authenticated user.'));
            $jsr->setStatusCode(503);
            return $jsr;
        } else if (count($results) > 1) {
            $jsr = new JsonResponse(array('error' => 'An error has occurred. Check for duplicate keys in the database.'));
            $jsr->setStatusCode(500);
            return $jsr;
        }

        return new JsonResponse($results[0]);
    }

    public static function createUnit(Request $request, $user_id, $user_type) {
        // a user MUST be a designer to create a unit
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        // get post parameters
        $post_parameters = $request->request->all();
        if (array_key_exists('name', $post_parameters) && array_key_exists('description', $post_parameters)
            && array_key_exists('course_id', $post_parameters) && array_key_exists('weight', $post_parameters)) {
            $name = $post_parameters['name'];
            $description = $post_parameters['description'];
            $course_id = $post_parameters['course_id'];
            $weight = $post_parameters['weight'];

            if (!is_numeric($course_id)) {
                $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            if (!is_numeric($weight)) {
                $jsr = new JsonResponse(array('error' => 'Invalid non-numeric value specified for a numeric field.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }


            // check if course given belongs to the currently logged in user
            $result = CourseRepository::getCourse($request, $user_id, $user_type, $course_id);
            if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
                return $result;
            }

            // create the unit
            $conn = Database::getInstance();
            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->insert('unit')
                ->values(
                    array(
                        'name' => '?',
                        'weight' => '?',
                        'description' => '?',
                        'course_id' => '?'
                    )
                )
                ->setParameter(0, $name)->setParameter(1, $weight)->setParameter(2, $description)->setParameter(3, $course_id)->execute();

            // return the newly created unit
            $unit_id = $conn->lastInsertId();
            return UnitRepository::getUnit($request, $user_id, $user_type, $unit_id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }

    public static function editUnit(Request $request, $user_id, $user_type, $unit_id) {
        // a user MUST be a designer to edit a unit
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        // make sure unit id is numeric
        if (!is_numeric($unit_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the unit belongs to the designer
        $result = UnitRepository::getUnit($request, $user_id, $user_type, $unit_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        // get post parameters
        $post_parameters = $request->request->all();
        if (array_key_exists('name', $post_parameters) && array_key_exists('description', $post_parameters) && array_key_exists('weight', $post_parameters)) {
            $name = $post_parameters['name'];
            $description = $post_parameters['description'];
            $weight = $post_parameters['weight'];

            if (!is_numeric($weight)) {
                $jsr = new JsonResponse(array('error' => 'Invalid non-numeric value specified for a numeric field.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            // update the unit
            $conn = Database::getInstance();
            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->update('unit')
                ->set('unit.name', '?')
                ->set('unit.description', '?')
                ->set('unit.weight', '?')
                ->where('unit.id = ?')
                ->setParameter(0, $name)->setParameter(1, $description)->setParameter(2, $weight)->setParameter(3, $unit_id)->execute();

            // return the updated unit
            return UnitRepository::getUnit($request, $user_id, $user_type, $unit_id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }
    
    public static function deleteUnit(Request $request, $user_id, $user_type, $unit_id) {
        // a user MUST be a designer to delete a unit
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }
        
        if (!is_numeric($unit_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the unit belongs to the designer
        $result = UnitRepository::getUnit($request, $user_id, $user_type, $unit_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        // delete the unit
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $queryBuilder->delete('unit')->where('unit.id = ?')->setParameter(0, $unit_id)->execute();
        return new Response();
    }
}
