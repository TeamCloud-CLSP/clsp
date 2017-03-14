<?php

namespace AppBundle\Repository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Database;
use AppBundle\Repository\SongRepository;

/**
 * SongMediaRepository
 *
 * Database interaction methods for song media links
 */
class SongMediaRepository extends \Doctrine\ORM\EntityRepository
{
    public static function getSongMedia(Request $request, $user_id, $user_type, $song_id) {
        // function is allowed for use by all users with no specific cases for each user class

        // make sure song id is numeric
        if (!is_numeric($song_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the song belongs to the user
        $result = SongRepository::getSong($request, $user_id, $user_type, $song_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        // query database for the media links
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('media.id', 'media.name', 'media.filename', 'media.file_type')
            ->from('media')->innerJoin('media', 'songs_media', 'songs_media', 'media.id = songs_media.media_id')
            ->innerJoin('songs_media', 'song', 'song', 'songs_media.song_id = song.id')->where('song.id = ?')
            ->setParameter(0, $song_id)->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($results), 'data' => $results));
        return $jsr;
    }

    public static function getMediaSong(Request $request, $user_id, $user_type, $media_id) {
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

        // check if the song belongs to the user
        $result = MediaRepository::getMedia($request, $user_id, $user_type, $media_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        // query database for the songs that use the media
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('song.id', 'song.unit_id', 'song.title', 'song.album', 'song.artist', 'song.description', 'song.lyrics', 'song.embed', 'song.weight')
            ->from('media')->innerJoin('media', 'songs_media', 'songs_media', 'media.id = songs_media.media_id')
            ->innerJoin('songs_media', 'song', 'song', 'songs_media.song_id = song.id')->where('media.id = ?')
            ->setParameter(0, $media_id)->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($results), 'data' => $results));
        return $jsr;
    }

    public static function getSongMediaLink(Request $request, $user_id, $user_type, $song_id, $media_id) {
        // make sure the ids are numeric
        if (!is_numeric($song_id) || !is_numeric($media_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if song given belongs to the currently logged in user
        $result = SongRepository::getSong($request, $user_id, $user_type, $song_id);
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
        $results = $queryBuilder->select('songs_media.song_id', 'songs_media.media_id')
            ->from('songs_media')->innerJoin('songs_media', 'media', 'media', 'songs_media.media_id = media.id')
            ->where('songs_media.song_id = ?')->andWhere('songs_media.media_id = ?')->andWhere('media.user_id = ?')
            ->setParameter(0, $song_id)->setParameter(1, $media_id)->setParameter(2, $user_id)->execute()->fetchAll();
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

    public static function createSongMediaLink(Request $request, $user_id, $user_type) {
        // a user MUST be a designer to create media links
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        // get post parameters
        $post_parameters = $request->request->all();

        if (array_key_exists('song_id', $post_parameters) && array_key_exists('media_id', $post_parameters)) {

            $song_id = $post_parameters['song_id'];
            $media_id = $post_parameters['media_id'];

            if (!is_numeric($song_id) || !is_numeric($media_id)) {
                $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            // check if song given belongs to the currently logged in user
            $result = SongRepository::getSong($request, $user_id, $user_type, $song_id);
            if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
                return $result;
            }

            // check if media given belongs to the currently logged in user
            $result = MediaRepository::getMedia($request, $user_id, $user_type, $media_id);
            if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
                return $result;
            }

            // check if this media link already exists
            $result = SongMediaRepository::getSongMediaLink($request, $user_id, $user_type, $song_id, $media_id);
            if ($result->getStatusCode() >= 200 && $result->getStatusCode() <= 299) {
                $jsr = new JsonResponse(array('error' => 'The link already exists.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            // create the media link in the database
            $conn = Database::getInstance();
            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->insert('songs_media')
                ->values(
                    array(
                        'song_id' => '?',
                        'media_id' => '?',
                    )
                )
                ->setParameter(0, $song_id)->setParameter(1, $media_id)->execute();

            // return the newly created media link
            return SongMediaRepository::getSongMediaLink($request, $user_id, $user_type, $song_id, $media_id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }

    public static function deleteSongMediaLink(Request $request, $user_id, $user_type, $song_id, $media_id) {
        // a user MUST be a designer to delete media links
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        // make sure the ids are numeric
        if (!is_numeric($song_id) || !is_numeric($media_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if media link given belongs to currently logged in user
        $result = SongMediaRepository::getSongMediaLink($request, $user_id, $user_type, $song_id, $media_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        // deletes the media link
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $queryBuilder->delete('songs_media')->where('song_id = ?')->andWhere('media_id = ?')
            ->setParameter(0, $song_id)->setParameter(1, $media_id)->execute();

        return new Response();
    }
}
