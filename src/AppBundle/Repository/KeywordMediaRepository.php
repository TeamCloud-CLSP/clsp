<?php

namespace AppBundle\Repository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Database;
use AppBundle\Repository\KeywordRepository;
use AppBundle\Repository\MediaRepository;

/**
 * KeywordMediaRepository
 *
 * Database interaction methods for keyword-media links (relationships)
 */
class KeywordMediaRepository extends \Doctrine\ORM\EntityRepository
{
    public static function getKeywordMedia(Request $request, $user_id, $user_type, $keyword_id) {
        // make sure keyword id is numeric
        if (!is_numeric($keyword_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the keyword belongs to the user
        $result = KeywordRepository::getKeyword($request, $user_id, $user_type, $keyword_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        // query database for the media links
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('media.id', 'media.name', 'media.filename', 'media.file_type')
            ->from('media')->innerJoin('media', 'module_cn_keywords_media', 'mck_media', 'media.id = mck_media.media_id')
            ->innerJoin('mck_media', 'module_cn_keyword', 'mck', 'mck.id = mck_media.module_cn_keyword_id')->where('mck_media.module_cn_keyword_id = ?')
            ->setParameter(0, $keyword_id)->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($results), 'data' => $results));
        $jsr->setStatusCode(200);
        return $jsr;
    }

    public static function getMediaKeywords(Request $request, $user_id, $user_type, $media_id) {
        // a user MUST be a designer to search for media usage
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }
        
        // make sure media id is numeric
        if (!is_numeric($media_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the song belongs to the designer
        $result = MediaRepository::getMedia($request, $user_id, $user_type, $media_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        // query database for the keywords that use the media
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('mck.id', 'mck.phrase', 'mck.description', 'mck.link')
            ->from('media')->innerJoin('media', 'module_cn_keywords_media', 'mck_media', 'media.id = mck_media.media_id')
            ->innerJoin('mck_media', 'module_cn_keyword', 'mck', 'mck.id = mck_media.module_cn_keyword_id')->where('mck_media.media_id = ?')
            ->setParameter(0, $media_id)->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($results), 'data' => $results));
        $jsr->setStatusCode(200);
        return $jsr;
    }
    
    public static function getKeywordMediaLink(Request $request, $user_id, $user_type, $keyword_id, $media_id) {
        // make sure ids are numeric
        if (!is_numeric($keyword_id) || !is_numeric($media_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if keyword given belongs to the currently logged in user
        $result = KeywordRepository::getKeyword($request, $user_id, $user_type, $keyword_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        // check if media given belongs to the currently logged in user
        $result = MediaRepository::getMedia($request, $user_id, $user_type, $media_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        // get the media link
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('mck_media.module_cn_keyword_id', 'mck_media.media_id')
            ->from('module_cn_keywords_media', 'mck_media')->innerJoin('mck_media', 'media', 'media', 'mck_media.media_id = media.id')
            ->where('mck_media.module_cn_keyword_id = ?')->andWhere('mck_media.media_id = ?')->andWhere('media.user_id = ?')
            ->setParameter(0, $keyword_id)->setParameter(1, $media_id)->setParameter(2, $user_id)->execute()->fetchAll();
        if (count($results) < 1) {
            $jsr = new JsonResponse(array('error' => 'Link does not exist or does not belong to the currently authenticated user.'));
            $jsr->setStatusCode(503);
            return $jsr;
        } else if (count($results) > 1) {
            $jsr = new JsonResponse(array('error' => 'An error has occurred. Check for duplicate keys in the database.'));
            $jsr->setStatusCode(500);
            return $jsr;
        }

        return new JsonResponse($results[0]);
    }

    public static function createKeywordMediaLink(Request $request, $user_id, $user_type) {
        // a user MUST be a designer to create media links
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        // get post parameters
        $post_parameters = $request->request->all();
        if (array_key_exists('keyword_id', $post_parameters) && array_key_exists('media_id', $post_parameters)) {

            $keyword_id = $post_parameters['keyword_id'];
            $media_id = $post_parameters['media_id'];

            if (!is_numeric($keyword_id) || !is_numeric($media_id)) {
                $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            // check if keyword given belongs to the currently logged in user
            $result = KeywordRepository::getKeyword($request, $user_id, $user_type, $keyword_id);
            if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
                return $result;
            }

            // check if media given belongs to the currently logged in user
            $result = MediaRepository::getMedia($request, $user_id, $user_type, $media_id);
            if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
                return $result;
            }

            // check if this media link already exists
            $result = KeywordMediaRepository::getKeywordMediaLink($request, $user_id, $user_type, $keyword_id, $media_id);
            if ($result->getStatusCode() >= 200 && $result->getStatusCode() <= 299) {
                $jsr = new JsonResponse(array('error' => 'The link already exists.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            // create the link in the database
            $conn = Database::getInstance();
            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->insert('module_cn_keywords_media')
                ->values(
                    array(
                        'module_cn_keyword_id' => '?',
                        'media_id' => '?',
                    )
                )
                ->setParameter(0, $keyword_id)->setParameter(1, $media_id)->execute();

            // return the newly created media link
            return KeywordMediaRepository::getKeywordMediaLink($request, $user_id, $user_type, $keyword_id, $media_id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }

    public static function deleteKeywordMediaLink(Request $request, $user_id, $user_type, $keyword_id, $media_id) {
        // a user MUST be a designer to delete media links
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        // make sure ids are numeric
        if (!is_numeric($keyword_id) || !is_numeric($media_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if media link given belongs to currently logged in user
        $result = KeywordMediaRepository::getKeywordMediaLink($request, $user_id, $user_type, $keyword_id, $media_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        // delete the link from the database
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $queryBuilder->delete('module_cn_keywords_media')->where('module_cn_keyword_id = ?')->andWhere('media_id = ?')
            ->setParameter(0, $keyword_id)->setParameter(1, $media_id)->execute();

        return new Response();
    }
}
