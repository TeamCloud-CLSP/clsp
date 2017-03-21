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
}
