<?php

namespace AppBundle\Repository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Database;

/**
 * LanguageRepository
 *
 * Database interaction methods for languages
 */
class LanguageRepository extends \Doctrine\ORM\EntityRepository
{
    // anybody can use these methods
    
    // to create a new language, an administrator must add it from the database.
    
    public static function getLanguages(Request $request, $user_id, $user_type) {
        $conn = Database::getInstance();

        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('language.id', 'language.language_code', 'language.name')
            ->from('language')->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($results), 'data' => $results));
        $jsr->setStatusCode(200);
        return $jsr;
    }

    public static function getLanguage(Request $request, $user_id, $user_type, $language_id) {
        $conn = Database::getInstance();

        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('language.id', 'language.language_code', 'language.name')
            ->from('language')->where('language.id = ?')->setParameter(0, $language_id)->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($results), 'data' => $results));
        $jsr->setStatusCode(200);
        return $jsr;
    }
}
