<?php

namespace AppBundle\Repository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Database;
use AppBundle\Repository\SongRepository;
use AppBundle\Repository\ModuleRepository;

/**
 * KeywordRepository
 *
 * Database interaction methods for keywords
 */
class KeywordRepository extends \Doctrine\ORM\EntityRepository
{
    public static function getKeywords(Request $request, $user_id, $user_type, $song_id) {
        // make sure song id is numeric
        if (!is_numeric($song_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the module belongs to or is accessible to the current user
        $result = ModuleRepository::getModule($request, $user_id, $user_type, 'module_cn', $song_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }
        
        // decode result to get the module id
        $result = json_decode($result->getContent());
        $module_id = $result->id;

        // query to get the keywords that belong to the module
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('id', 'phrase', 'description', 'link')
            ->from('module_cn_keyword')->where('cn_id = ?')
            ->setParameter(0, $module_id)->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($results), 'data' => $results));
        $jsr->setStatusCode(200);
        return $jsr;
    }

    public static function getKeyword(Request $request, $user_id, $user_type, $keyword_id) {
        // make sure keyword id is numeric
        if (!is_numeric($keyword_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // query for the keyword
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = null;
        if (strcmp($user_type, 'designer') == 0) { // if designer, make sure that the designer owns the keyword
            $results = $queryBuilder->select('mck.id', 'mck.phrase', 'mck.description', 'mck.link', 'song.id AS song_id')
                ->from('app_users', 'designers')->innerJoin('designers', 'courses', 'courses', 'designers.id = courses.user_id')
                ->innerJoin('courses', 'unit', 'unit', 'unit.course_id = courses.id')
                ->innerJoin('unit', 'song', 'song', 'song.unit_id = unit.id')
                ->innerJoin('song', 'module_cn', 'module_cn', 'song.id = module_cn.song_id')
                ->innerJoin('module_cn', 'module_cn_keyword', 'mck', 'module_cn.id = mck.cn_id')
                ->where('designers.id = ?')->andWhere('mck.id = ?')
                ->setParameter(0, $user_id)->setParameter(1, $keyword_id)->execute()->fetchAll();
        } else if (strcmp($user_type, 'professor') == 0) {
            $results = $queryBuilder->select('mck.id', 'mck.phrase', 'mck.description', 'mck.link', 'song.id AS song_id')
                ->from('professor_registrations', 'pr')->innerJoin('pr', 'courses', 'courses', 'pr.course_id = courses.id')
                ->innerJoin('courses', 'unit', 'unit', 'unit.course_id = courses.id')
                ->innerJoin('unit', 'song', 'song', 'song.unit_id = unit.id')
                ->innerJoin('song', 'module_cn', 'module_cn', 'song.id = module_cn.song_id')
                ->innerJoin('module_cn', 'module_cn_keyword', 'mck', 'module_cn.id = mck.cn_id')
                ->where('pr.professor_id = ?')->andWhere('pr.date_start < ?')->andWhere('pr.date_end > ?')->andWhere('mck.id = ?')
                ->setParameter(0, $user_id)->setParameter(1, time())->setParameter(2, time())->setParameter(3, $keyword_id)->execute()->fetchAll();
        } else {
            $jsr = new JsonResponse(array('error' => 'Internal server error.'));
            $jsr->setStatusCode(500);
            return $jsr;
        }

        // check for invalid results
        if (count($results) < 1) {
            $jsr = new JsonResponse(array('error' => 'Keyword does not exist or does not belong to the currently authenticated user.'));
            $jsr->setStatusCode(503);
            return $jsr;
        } else if (count($results) > 1) {
            $jsr = new JsonResponse(array('error' => 'An error has occurred. Check for duplicate keys in the database.'));
            $jsr->setStatusCode(500);
            return $jsr;
        }

        $results[0]['module_type'] = 'module_cn';
        return new JsonResponse($results[0]);
    }

    public static function createKeyword(Request $request, $user_id, $user_type) {
        // a user MUST be a designer to create a keyword
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        // get required post parameters
        $post_parameters = $request->request->all();
        if (array_key_exists('phrase', $post_parameters) && array_key_exists('song_id', $post_parameters)) {
            $phrase = $post_parameters['phrase'];
            $song_id = $post_parameters['song_id'];

            // make sure song id is numeric
            if (!is_numeric($song_id)) {
                $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            // check if song + module cn given belongs to the currently logged in user
            $result = ModuleRepository::getModule($request, $user_id, $user_type, 'module_cn', $song_id);
            if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
                return $result;
            }
            $result = json_decode($result->getContent());
            $module_id = $result->id;

            // check for optional parameters
            $description = null;
            $link = null;
            if (array_key_exists('description', $post_parameters)) {
                $description = $post_parameters['description'];
            }
            if (array_key_exists('link', $post_parameters)) {
                $link = $post_parameters['link'];
            }

            // creates the keyword in the database
            $conn = Database::getInstance();
            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->insert('module_cn_keyword')
                ->values(
                    array(
                        'phrase' => '?',
                        'description' => '?',
                        'link' => '?',
                        'cn_id' => '?'
                    )
                )
                ->setParameter(0, $phrase)->setParameter(1, $description)->setParameter(2, $link)->setParameter(3, $module_id)->execute();

            // returns the newly created keyword
            $keyword_id = $conn->lastInsertId();
            return KeywordRepository::getKeyword($request, $user_id, $user_type, $keyword_id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }

    public static function editKeyword(Request $request, $user_id, $user_type, $keyword_id) {
        // a user MUST be a designer to edit a keyword
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        // get required post parameters
        $post_parameters = $request->request->all();
        if (array_key_exists('phrase', $post_parameters)) {
            $phrase = $post_parameters['phrase'];

            if (!is_numeric($keyword_id)) {
                $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            // check if keyword belongs to currently logged in user
            $result = KeywordRepository::getKeyword($request, $user_id, $user_type, $keyword_id);
            if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
                return $result;
            }

            // check for optional parameters
            $description = null;
            $link = null;
            if (array_key_exists('description', $post_parameters)) {
                $description = $post_parameters['description'];
            }

            if (array_key_exists('link', $post_parameters)) {
                $link = $post_parameters['link'];
            }

            // update the keyword in the database
            $conn = Database::getInstance();
            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->update('module_cn_keyword')
                ->set('phrase', '?')
                ->set('description', '?')
                ->set('link', '?')
                ->where('id = ?')
                ->setParameter(0, $phrase)->setParameter(1, $description)->setParameter(2, $link)->setParameter(3, $keyword_id)->execute();

            return KeywordRepository::getKeyword($request, $user_id, $user_type, $keyword_id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }

    public static function deleteKeyword(Request $request, $user_id, $user_type, $keyword_id) {
        // a user MUST be a designer to delete a keyword
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        // make sure keyword id is numeric
        if (!is_numeric($keyword_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if keyword belongs to currently logged in user
        $result = KeywordRepository::getKeyword($request, $user_id, $user_type, $keyword_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        // if so, delete the keyword
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $queryBuilder->delete('module_cn_keyword')->where('id = ?')->setParameter(0, $keyword_id)->execute();

        return new Response();
    }
}
