<?php

namespace AppBundle\Repository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Database;

/**
 * HelperRepository
 * 
 * Helper functions for the repository classes
 */
class HelperRepository extends \Doctrine\ORM\EntityRepository
{
    public static function getUser($user_id) {
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('is_student', 'is_professor', 'is_designer', 'is_administrator')->from('app_users')->where('app_users.id = ?')
            ->setParameter(0, $user_id)->execute()->fetchAll();
        if (count($results) < 1) {
            return null;
        }
        return $results[0];
    }

    public static function template(Request $request, $user_id, $user_type) {
        return null;
    }
}
