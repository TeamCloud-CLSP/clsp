<?php

namespace AppBundle\Repository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Database;

/**
 * SongRepository
 *
 * Database interaction methods for songs
 */
class SongRepository extends \Doctrine\ORM\EntityRepository
{
    public static function getSongs(Request $request, $user_id, $user_type, $unit_id) {
        // make sure unit id is numeric
        if (!is_numeric($unit_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the unit is accessible to the currently logged in user
        $result = UnitRepository::getUnit($request, $user_id, $user_type, $unit_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        // run query to get the songs that belong to the unit
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('song.id', 'song.title', 'song.album', 'song.artist', 'song.description', 'song.lyrics', 'song.embed', 'song.weight')
            ->from('unit')->innerJoin('unit', 'song', 'song', 'song.unit_id = unit.id')->where('unit_id = ?')
            ->orderBy('song.weight', 'ASC')->addOrderBy('song.id', 'ASC')
            ->setParameter(0, $unit_id)->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($results), 'data' => $results));
        return $jsr;
    }

    public static function getSong(Request $request, $user_id, $user_type, $song_id) {
        // make sure song id is numeric
        if (!is_numeric($song_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // run query to get the song
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = null;
        if (strcmp($user_type, 'designer') == 0) { // if designer, make sure that the designer owns the song
            $results = $queryBuilder->select('song.id', 'song.title', 'song.album', 'song.artist', 'song.description', 'song.lyrics', 'song.embed', 'song.weight', 'unit.id AS unit_id')
                ->from('app_users', 'designers')->innerJoin('designers', 'courses', 'courses', 'designers.id = courses.user_id')
                ->innerJoin('courses', 'unit', 'unit', 'unit.course_id = courses.id')
                ->innerJoin('unit', 'song', 'song', 'song.unit_id = unit.id')
                ->where('designers.id = ?')->andWhere('song.id = ?')
                ->setParameter(0, $user_id)->setParameter(1, $song_id)->execute()->fetchAll();
        } else if (strcmp($user_type, 'professor') == 0) {
            $results = $queryBuilder->select('song.id', 'song.title', 'song.album', 'song.artist', 'song.description', 'song.lyrics', 'song.embed', 'song.weight', 'unit.id AS unit_id')
                ->from('professor_registrations', 'pr')->innerJoin('pr', 'courses', 'courses', 'pr.course_id = courses.id')
                ->innerJoin('courses', 'unit', 'unit', 'unit.course_id = courses.id')
                ->innerJoin('unit', 'song', 'song', 'song.unit_id = unit.id')
                ->where('pr.professor_id = ?')->andWhere('pr.date_start < ?')->andWhere('pr.date_end > ?')->andWhere('song.id = ?')
                ->setParameter(0, $user_id)->setParameter(1, time())->setParameter(2, time())->setParameter(3, $song_id)->execute()->fetchAll();
        } else if (strcmp($user_type, 'student') == 0) {
            $results = $queryBuilder->select('song.id', 'song.title', 'song.album', 'song.artist', 'song.description', 'song.lyrics', 'song.embed', 'song.weight', 'unit.id AS unit_id')
                ->from('app_users', 'students')->innerJoin('students', 'student_registrations', 'sr', 'students.student_registration_id = sr.id')
                ->innerJoin('sr', 'classes', 'classes', 'sr.class_id = classes.id')
                ->innerJoin('classes', 'courses', 'courses', 'classes.course_id = courses.id')
                ->innerJoin('courses', 'unit', 'unit', 'unit.course_id = courses.id')
                ->innerJoin('unit', 'song', 'song', 'song.unit_id = unit.id')
                ->where('students.id = ?')->andWhere('sr.date_start < ?')->andWhere('sr.date_end > ?')->andWhere('song.id = ?')
                ->setParameter(0, $user_id)->setParameter(1, time())->setParameter(2, time())->setParameter(3, $song_id)->execute()->fetchAll();
        } else {
            $jsr = new JsonResponse(array('error' => 'Internal server error.'));
            $jsr->setStatusCode(500);
            return $jsr;
        }

        // check for invalid results
        if (count($results) < 1) {
            $jsr = new JsonResponse(array('error' => 'Song does not exist or does not belong to the currently authenticated user.'));
            $jsr->setStatusCode(503);
            return $jsr;
        } else if (count($results) > 1) {
            $jsr = new JsonResponse(array('error' => 'An error has occurred. Check for duplicate keys in the database.'));
            $jsr->setStatusCode(500);
            return $jsr;
        }

        return new JsonResponse($results[0]);
    }

    public static function createSong(Request $request, $user_id, $user_type) {
        // a user MUST be a designer to create a song
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        // get required post parameters
        $post_parameters = $request->request->all();
        if (array_key_exists('title', $post_parameters) && array_key_exists('album', $post_parameters) && array_key_exists('artist', $post_parameters)
            && array_key_exists('description', $post_parameters) && array_key_exists('lyrics', $post_parameters) && array_key_exists('weight', $post_parameters)
            && array_key_exists('unit_id', $post_parameters)) {

            $title = $post_parameters['title'];
            $album = $post_parameters['album'];
            $artist = $post_parameters['artist'];
            $description = $post_parameters['description'];
            $lyrics = $post_parameters['lyrics'];
            $weight = $post_parameters['weight'];
            $unit_id = $post_parameters['unit_id'];
            $embed = null;

            // check for optional parameters
            if (array_key_exists('embed', $post_parameters)) {
                $embed = $post_parameters['embed'];
            }

            if (!is_numeric($unit_id)) {
                $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            if (!is_numeric($weight)) {
                $jsr = new JsonResponse(array('error' => 'Invalid non-numeric value specified for a numeric field.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            // check if unit given belongs to the currently logged in user
            $result = UnitRepository::getUnit($request, $user_id, $user_type, $unit_id);
            if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
                return $result;
            }

            // create a new song in the database
            $conn = Database::getInstance();
            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->insert('song')
                ->values(
                    array(
                        'title' => '?',
                        'album' => '?',
                        'artist' => '?',
                        'description' => '?',
                        'lyrics' => '?',
                        'embed' => '?',
                        'weight' => '?',
                        'unit_id' => '?'
                    )
                )
                ->setParameter(0, $title)->setParameter(1, $album)->setParameter(2, $artist)->setParameter(3, $description)
                ->setParameter(4, $lyrics)->setParameter(5, $embed)
                ->setParameter(6, $weight)->setParameter(7, $unit_id)->execute();

            // get the id of the song that was just created
            $song_id = $conn->lastInsertId();

            // create modules for the song (all 6) that are by default disabled and no password
            $conn = Database::getInstance();
            $queryBuilder = $conn->createQueryBuilder();
            $moduleNames = ['module_cn', 'module_dw', 'module_ge', 'module_ls', 'module_lt', 'module_qu'];
            for ($i = 0; $i < count($moduleNames); $i++) {
                $moduleName = $moduleNames[$i];
                $queryBuilder->insert($moduleName)
                    ->values(
                        array(
                            'song_id' => '?',
                            'password' => '?',
                            'has_password' => '?',
                            'is_enabled' => '?',
                            'song_enabled' => '?'
                        )
                    )
                    ->setParameter(0, $song_id)->setParameter(1, '')->setParameter(2, 0)
                    ->setParameter(3, 0)->setParameter(4, 0)->execute();
            }

            // return the info of the newly created song
            return SongRepository::getSong($request, $user_id, $user_type, $song_id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }

    public static function editSong(Request $request, $user_id, $user_type, $song_id) {
        // a user MUST be a designer to edit a song
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        // make sure song id is numeric
        if (!is_numeric($song_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check required post parameters
        $post_parameters = $request->request->all();
        if (array_key_exists('title', $post_parameters) && array_key_exists('album', $post_parameters) && array_key_exists('artist', $post_parameters)
            && array_key_exists('description', $post_parameters) && array_key_exists('lyrics', $post_parameters) && array_key_exists('weight', $post_parameters)) {
            $title = $post_parameters['title'];
            $album = $post_parameters['album'];
            $artist = $post_parameters['artist'];
            $description = $post_parameters['description'];
            $lyrics = $post_parameters['lyrics'];
            $weight = $post_parameters['weight'];
            $embed = null;

            // check for optional parameter
            if (array_key_exists('embed', $post_parameters)) {
                $embed = $post_parameters['embed'];
            }

            if (!is_numeric($weight)) {
                $jsr = new JsonResponse(array('error' => 'Invalid non-numeric value specified for a numeric field.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            // check if song given belongs to the currently logged in user
            $result = SongRepository::getSong($request, $user_id, $user_type, $song_id);
            if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
                return $result;
            }

            // update song in the database
            $conn = Database::getInstance();
            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->update('song')
                ->set('title', '?')
                ->set('album', '?')
                ->set('artist', '?')
                ->set('description', '?')
                ->set('lyrics', '?')
                ->set('embed', '?')
                ->set('weight', '?')
                ->where('song.id = ?')
                ->setParameter(0, $title)->setParameter(1, $album)->setParameter(2, $artist)->setParameter(3, $description)
                ->setParameter(4, $lyrics)->setParameter(5, $embed)
                ->setParameter(6, $weight)->setParameter(7, $song_id)->execute();

            // return the updated song information
            return SongRepository::getSong($request, $user_id, $user_type, $song_id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }

    public static function deleteSong(Request $request, $user_id, $user_type, $song_id) {
        // a user MUST be a designer to delete a song
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        // make sure song id is numeric
        if (!is_numeric($song_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the unit belongs to the designer
        $result = SongRepository::getSong($request, $user_id, $user_type, $song_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        // delete song from database
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $queryBuilder->delete('song')->where('song.id = ?')->setParameter(0, $song_id)->execute();
        return new Response();
    }
}
