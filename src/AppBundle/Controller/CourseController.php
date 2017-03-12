<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Database;

/**
 * Available functions:
 *
 * getCourses - /api/designer/courses - get courses
 * getCourse - /api/designer/course/{id} - get a single course by its id
 * createCourse - /api/designer/course (POST) - create a course - takes in name, description, language_id request parameter
 * editCourse - /api/designer/course/{id} (POST) - edits a course by its id, takes in name, description, language_id request parameter
 * deleteCourse - /api/designer/course/{id} (DELETE) - deletes a course by id
 *
 * getUnits - /api/designer/course/{id}/units - get the units that belong to a course
 * getUnit - /api/designer/unit/{id}
 * createUnit - /api/designer/unit (POST) - takes name, description, course_id, weight
 * editUnit - /api/designer/unit/{id} (POST) - takes name, description, weight
 * deleteUnit - /api/designer/unit/{id} (DELETE)
 *
 * getSongs - /api/designer/unit/{id}/songs - gets the songs that belong to a unit
 * getSong - /api/designer/song/{id}
 * createSong - /api/designer/song (POST) - takes title, album, artist, description, lyrics, weight, unit_id | optional: embed
 * editSong - /api/designer/song/{id} (POST) - takes title, album, artist, description, lyrics, weight | optional: embed
 * deleteSong - /api/designer/song/{id} (DELETE)
 *
 * getAllMedia - /api/designer/media - gets all files the designer owns
 * getMedia - /api/designer/media/{id}
 * createMedia - /api/designer/media (POST) - takes file (the actual file) | optional: name, file_type
 * editMedia - /api/designer/media/{id} (POST) - takes name
 * deleteMedia - /api/designer/media/{id} (DELETE)
 *
 * getSongMedia - /api/designer/song/{id}/media - gets all media that belongs to a song
 * getMediaSongs - /api/designer/media/{id}/song - gets all songs that belong to a media
 *
 * getSongMediaLink - /api/designer/song/{song_id}/media/{media_id}
 * createSongMediaLink - /api/designer/song-media (POST) - takes song_id, media_id
 * deleteSongMediaLink - /api/designer/song/{song_id}/media/{media_id} (DELETE)
 *
 * Class CourseController
 * @package AppBundle\Controller
 */
class CourseController extends Controller
{
    /**
     * Gets all courses that the designer owns
     *
     * Can filter by name
     *
     * @Route("/api/designer/courses", name="getCoursesAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getCourses(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        $request_parameters = $request->query->all();
        $name = "%%";
        if (array_key_exists('name', $request_parameters)) {
            $name = '%' . $request_parameters['name'] . '%';
        }
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $result = $queryBuilder->select('courses.id', 'courses.name', 'courses.description', 'language.name AS language_name', 'language.id AS language_id')
            ->from('app_users')->innerJoin('app_users', 'courses', 'courses', 'app_users.id = courses.user_id')
            ->innerJoin('courses', 'language', 'language', 'courses.language_id = language.id')->where('app_users.id = ?')->andWhere('courses.name LIKE ?')
            ->setParameter(0, $user_id)->setParameter(1, $name)->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($result), 'data' => $result));
        $jsr->setStatusCode(200);
        return $jsr;
    }

    /**
     * Gets specific information on a specific course that belongs to the designer
     *
     * @Route("/api/designer/course/{id}", name="getCourseAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getCourse(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        $course_id = $id;

        if (!is_numeric($course_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the course belongs to the designer
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('courses.id', 'courses.name', 'courses.description', 'language.name AS language_name', 'language.id AS language_id')->from('app_users', 'designers')
            ->innerJoin('designers', 'courses', 'courses', 'designers.id = courses.user_id')->innerJoin('courses', 'language', 'language', 'courses.language_id = language.id')
            ->where('designers.id = ?')->andWhere('courses.id = ?')
            ->setParameter(0, $user_id)->setParameter(1, $course_id)->execute()->fetchAll();
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

    /**
     * Creates a new course object tied to the currently logged in designer
     *
     * Takes in:
     *      "name" - Name of course
     *      "description" - Description of course
     *      "language_id" - ID of the language of the course
     *
     * @Route("/api/designer/course", name="createCourseAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function createCourse(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();

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
            $conn = Database::getInstance();

            $queryBuilder = $conn->createQueryBuilder();
            $results = $queryBuilder->select('language.id', 'language.language_code', 'language.name')
                ->from('language')->where('language.id = ?')->setParameter(0, $language_id)->execute()->fetchAll();
            if (count($results) < 1) {
                $jsr = new JsonResponse(array('error' => 'Invalid language ID specified.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

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
            
            $id = $conn->lastInsertId();
            return $this->getCourse($request, $id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }

    /**
     * Edits an existing course object tied to the currently logged in designer
     *
     * Takes in:
     *      "name" - Name of course
     *      "description" - Description of course
     *      "language_id" - ID of the language of the course
     *
     * @Route("/api/designer/course/{id}", name="editCourseAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function editCourse(Request $request, $id) {
        $course_id = $id;

        if (!is_numeric($course_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the course belongs to the designer
        $result = $this->getCourse($request, $course_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

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

            $conn = Database::getInstance();
            $queryBuilder = $conn->createQueryBuilder();
            $results = $queryBuilder->select('language.id', 'language.language_code', 'language.name')
                ->from('language')->where('language.id = ?')->setParameter(0, $language_id)->execute()->fetchAll();
            if (count($results) < 1) {
                $jsr = new JsonResponse(array('error' => 'Invalid language ID specified.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->update('courses')
                ->set('courses.name', '?')
                ->set('courses.description', '?')
                ->set('courses.language_id', '?')
                ->where('courses.id = ?')
                ->setParameter(0, $name)->setParameter(3, $course_id)->setParameter(1, $description)->setParameter(2, $language_id)->execute();

            return $this->getCourse($request, $course_id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }

    /**
     * Deletes a course that belongs to the designer
     *
     * @Route("/api/designer/course/{id}", name="deleteCourseAsDesigner")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteCourse(Request $request, $id) {
        $course_id = $id;

        if (!is_numeric($course_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the course belongs to the designer
        $result = $this->getCourse($request, $course_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $queryBuilder->delete('courses')->where('courses.id = ?')->setParameter(0, $course_id)->execute();

        return new Response();
    }

    /**
     * Gets all units that belong to the given course, ordered by their weight
     *
     * @Route("/api/designer/course/{id}/units", name="getUnitsAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getUnits(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        $course_id = $id;

        if (!is_numeric($course_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('unit.name', 'unit.description', 'unit.id', 'unit.weight')
            ->from('app_users', 'designers')->innerJoin('designers', 'courses', 'courses', 'designers.id = courses.user_id')
            ->innerJoin('courses', 'unit', 'unit', 'unit.course_id = courses.id')->where('designers.id = ?')->andWhere('course_id = ?')
            ->orderBy('unit.weight', 'ASC')
            ->setParameter(0, $user_id)->setParameter(1, $course_id)->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($results), 'data' => $results));
        return $jsr;
    }

    /**
     * Gets specific information on a specific unit that belongs to the designer
     *
     * @Route("/api/designer/unit/{id}", name="getUnitInformationAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getUnit(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        $unit_id = $id;

        if (!is_numeric($unit_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the course belongs to the designer
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('unit.name', 'unit.description', 'unit.id', 'unit.weight', 'courses.id AS course_id')
            ->from('app_users', 'designers')->innerJoin('designers', 'courses', 'courses', 'designers.id = courses.user_id')
            ->innerJoin('courses', 'unit', 'unit', 'unit.course_id = courses.id')->where('designers.id = ?')->andWhere('unit.id = ?')
            ->orderBy('unit.weight', 'ASC')
            ->setParameter(0, $user_id)->setParameter(1, $unit_id)->execute()->fetchAll();
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

    /**
     * Creates a new unit object tied to the current course
     *
     * Takes in:
     *      "name" - Name of unit
     *      "description" - Description of unit
     *      "course_id" - ID of the course that the unit belongs to
     *      "weight" - order by which this unit should be displayed (number)
     *
     * @Route("/api/designer/unit", name="createUnitAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function createUnit(Request $request) {
        $post_parameters = $request->request->all();

        if (array_key_exists('name', $post_parameters) && array_key_exists('description', $post_parameters) && array_key_exists('course_id', $post_parameters) && array_key_exists('weight', $post_parameters)) {
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
            $result = $this->getCourse($request, $course_id);
            if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
                return $result;
            }
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
            
            $id = $conn->lastInsertId();
            return $this->getUnit($request, $id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }

    /**
     * Edits an existing unit object tied to the current course.
     *
     * The course tied to the unit cannot be changed, for good reason.
     *
     * Takes in:
     *      "name" - Name of course
     *      "description" - Description of course
     *      "weight" - order by which this unit should be displayed (number)
     *
     * @Route("/api/designer/unit/{id}", name="editUnitAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function editUnit(Request $request, $id) {
        $unit_id = $id;

        if (!is_numeric($unit_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the unit belongs to the designer
        $result = $this->getUnit($request, $unit_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

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

            $conn = Database::getInstance();
            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->update('unit')
                ->set('unit.name', '?')
                ->set('unit.description', '?')
                ->set('unit.weight', '?')
                ->where('unit.id = ?')
                ->setParameter(0, $name)->setParameter(1, $description)->setParameter(2, $weight)->setParameter(3, $unit_id)->execute();

            return $this->getUnit($request, $unit_id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }

    /**
     * Deletes a unit that belongs to the current course
     *
     * @Route("/api/designer/unit/{id}", name="deleteUnitAsDesigner")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteUnit(Request $request, $id) {
        $unit_id = $id;

        if (!is_numeric($unit_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the unit belongs to the designer
        $result = $this->getUnit($request, $unit_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $queryBuilder->delete('unit')->where('unit.id = ?')->setParameter(0, $unit_id)->execute();

        return new Response();
    }

    /**
     * Gets all songs that belong to the given unit, ordered by their weight
     *
     * @Route("/api/designer/unit/{id}/songs", name="getSongsAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getSongs(Request $request, $id) {
        $unit_id = $id;

        if (!is_numeric($unit_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the unit belongs to the designer
        $result = $this->getUnit($request, $unit_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('song.id', 'song.title', 'song.album', 'song.artist', 'song.description', 'song.lyrics', 'song.embed', 'song.weight')
            ->from('unit')->innerJoin('unit', 'song', 'song', 'song.unit_id = unit.id')->where('unit_id = ?')
            ->orderBy('song.weight', 'ASC')
            ->setParameter(0, $unit_id)->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($results), 'data' => $results));
        return $jsr;
    }

    /**
     * Gets specific information on a specific song
     *
     * @Route("/api/designer/song/{id}", name="getSongInformationAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getSong(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        $song_id = $id;

        if (!is_numeric($song_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the course belongs to the designer
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('song.id', 'song.title', 'song.album', 'song.artist', 'song.description', 'song.lyrics', 'song.embed', 'song.weight', 'unit.id AS unit_id')
            ->from('app_users', 'designers')->innerJoin('designers', 'courses', 'courses', 'designers.id = courses.user_id')
            ->innerJoin('courses', 'unit', 'unit', 'unit.course_id = courses.id')
            ->innerJoin('unit', 'song', 'song', 'song.unit_id = unit.id')
            ->where('designers.id = ?')->andWhere('song.id = ?')
            ->setParameter(0, $user_id)->setParameter(1, $song_id)->execute()->fetchAll();
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

    /**
     * Creates a new song object tied to the current unit
     *
     * Takes in:
     *      "title" - Title of song
     *      "album" - Album of song
     *      "artist" - Artist of song
     *      "description" - description of song
     *      "lyrics" - lyrics for the song
     *      "embed" - link to an embed resource for the song (OPTIONAL)
     *      "weight" - order by which this unit should be displayed
     *      "unit_id" - ID of the unit that the song belongs to
     *
     * @Route("/api/designer/song", name="createSongAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function createSong(Request $request) {
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
            $result = $this->getUnit($request, $unit_id);
            if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
                return $result;
            }

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
            
            $song_id = $conn->lastInsertId();

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
                            'is_enabled' => '?'
                        )
                    )
                    ->setParameter(0, $song_id)->setParameter(1, '')->setParameter(2, 0)
                    ->setParameter(3, 0)->execute();
            }

            return $this->getSong($request, $song_id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }

    /**
     * Edits a song object tied to the current unit
     *
     * Takes in:
     *      "title" - Title of song
     *      "album" - Album of song
     *      "artist" - Artist of song
     *      "description" - description of song
     *      "lyrics" - lyrics for the song
     *      "embed" - link to an embed resource for the song (OPTIONAL)
     *      "weight" - order by which this unit should be displayed
     *
     * @Route("/api/designer/song/{id}", name="editSongAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function editSong(Request $request, $id) {
        $post_parameters = $request->request->all();

        $song_id = $id;
        if (!is_numeric($song_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        if (array_key_exists('title', $post_parameters) && array_key_exists('album', $post_parameters) && array_key_exists('artist', $post_parameters)
            && array_key_exists('description', $post_parameters) && array_key_exists('lyrics', $post_parameters) && array_key_exists('weight', $post_parameters)) {

            $title = $post_parameters['title'];
            $album = $post_parameters['album'];
            $artist = $post_parameters['artist'];
            $description = $post_parameters['description'];
            $lyrics = $post_parameters['lyrics'];
            $weight = $post_parameters['weight'];

            $embed = null;

            if (array_key_exists('embed', $post_parameters)) {
                $embed = $post_parameters['embed'];
            }


            if (!is_numeric($weight)) {
                $jsr = new JsonResponse(array('error' => 'Invalid non-numeric value specified for a numeric field.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            // check if song given belongs to the currently logged in user
            $result = $this->getSong($request, $song_id);
            if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
                return $result;
            }

            $conn = Database::getInstance();
            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->update('song')
                ->set('title', '?')
                ->set('album', '?')
                ->set('artist', '?')
                ->set('description', '?')
                ->set('lyrics', '?')
                ->set('file_name', '?')
                ->set('file_type', '?')
                ->set('embed', '?')
                ->set('weight', '?')
                ->where('song.id = ?')
                ->setParameter(0, $title)->setParameter(1, $album)->setParameter(2, $artist)->setParameter(3, $description)
                ->setParameter(4, $lyrics)->setParameter(5, $embed)
                ->setParameter(6, $weight)->setParameter(7, $song_id)->execute();

            return $this->getSong($request, $song_id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }

    /**
     * Deletes a song that belongs to the current course
     *
     * @Route("/api/designer/song/{id}", name="deleteSongAsDesigner")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteSong(Request $request, $id) {
        $song_id = $id;

        if (!is_numeric($song_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the unit belongs to the designer
        $result = $this->getSong($request, $song_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $queryBuilder->delete('song')->where('song.id = ?')->setParameter(0, $song_id)->execute();

        return new Response();
    }

    /**
     * Gets all files a designer has
     *
     * @Route("/api/designer/media", name="getFilesAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getAllMedia(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();

        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('id', 'name', 'filename', 'file_type')
            ->from('media')
            ->where('user_id = ?')
            ->setParameter(0, $user_id)->execute()->fetchAll();

        return new JsonResponse($results);
    }

    /**
     * Gets information on a file
     *
     * @Route("/api/designer/media/{id}", name="getFileInformationAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getMedia(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        $file_id = $id;

        if (!is_numeric($file_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the file belongs to the designer
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('id', 'name', 'filename', 'file_type')
            ->from('media')
            ->where('user_id = ?')->andWhere('id = ?')
            ->setParameter(0, $user_id)->setParameter(1, $file_id)->execute()->fetchAll();
        if (count($results) < 1) {
            $jsr = new JsonResponse(array('error' => 'File does not exist or does not belong to the currently authenticated user.'));
            $jsr->setStatusCode(503);
            return $jsr;
        } else if (count($results) > 1) {
            $jsr = new JsonResponse(array('error' => 'An error has occurred. Check for duplicate keys in the database.'));
            $jsr->setStatusCode(500);
            return $jsr;
        }

        return new JsonResponse($results[0]);
    }

    /**
     * endpoint for uploading a file
     *
     * Takes:
     *      "file" = the file being uploaded
     *
     * Optional:
     *      "file_type" = overrides the file type being processed from the file
     *      "name" = overrides the default name of the file
     *
     * @Route("/api/designer/media", name="uploadFileAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function createMedia(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();

        $post_parameters = $request->request->all();
        $file_post_parameters = $request->files->all();

        if (array_key_exists('file', $file_post_parameters)) {
            $file = $file_post_parameters['file'];
            $file_type = null;
            $name = null;

            $sections = explode('.', $file->getClientOriginalName());
            $extension = $sections[count($sections) - 1];

            if (array_key_exists('file_type', $post_parameters)) {
                $file_type = $post_parameters['file_type'];
            } else {
                $file_type = $extension;
            }

            if (array_key_exists('name', $post_parameters)) {
                $name = $post_parameters['name'];
            } else {
                $name = $file->getClientOriginalName();
                $name = substr($name, 0, -1 * (strlen($extension) + 1 ));
            }

            $filename = md5(uniqid(rand(), true)) . '.' . $extension;
            // make sure generated md5 hash is unique
            $conn = Database::getInstance();
            $breakOut = 0;
            while ($breakOut = 0) {

                $queryBuilder = $conn->createQueryBuilder();
                $results = $queryBuilder->select('id')->from('media')->where('filename = ?')->setParameter(0, $filename)->execute()->fetchAll();
                if (count($results) < 1) {
                    $breakOut = 1;
                } else {
                    $filename = md5(uniqid(rand(), true)) . '.' . $extension;
                }
            }

            // save the file
            $file = $file->move('files', $filename);

            $conn = Database::getInstance();

            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->insert('media')
                ->values(
                    array(
                        'name' => '?',
                        'filename' => '?',
                        'file_type' => '?',
                        'user_id' => '?'
                    )
                )
                ->setParameter(0, $name)->setParameter(1, $filename)->setParameter(2, $file_type)->setParameter(3, $user_id)->execute();

            $id = $conn->lastInsertId();
            return $this->getMedia($request, $id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }

    /**
     * endpoint for editing a file
     *
     * Takes:
     *      "name" - changes name of the file - visible name, not stored name
     *
     * @Route("/api/designer/media/{id}", name="editFileAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function editMedia(Request $request, $id) {
        $file_id = $id;
        if (!is_numeric($file_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        $post_parameters = $request->request->all();

        if (array_key_exists('name', $post_parameters)) {
            $name = $post_parameters['name'];

            // check if file given belongs to the currently logged in user
            $result = $this->getMedia($request, $file_id);
            if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
                return $result;
            }

            $conn = Database::getInstance();
            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->update('media')
                ->set('name', '?')->where('id = ?')
                ->setParameter(0, $name)->setParameter(1, $file_id)->execute();

            return $this->getMedia($request, $file_id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }

    /**
     * endpoint for deleting a file
     *
     * @Route("/api/designer/media/{id}", name="deleteFileAsDesigner")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteMedia(Request $request, $id) {
        $file_id = $id;
        if (!is_numeric($file_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if file given belongs to the currently logged in user
        $result = $this->getMedia($request, $file_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        $conn = Database::getInstance();
        $result = $conn->createQueryBuilder()->select('filename')->from('media')->where('id = ?')->setParameter(0, $file_id)->execute()->fetchAll();
        $filename = $result[0]['filename'];

        // delete file
        unlink('files/' . $filename);

        $queryBuilder = $conn->createQueryBuilder();
        $queryBuilder->delete('media')->where('id = ?')->setParameter(0, $file_id)->execute();

        return new Response();
    }

    /**
     * Gets all media that belongs to a song
     *
     * @Route("/api/designer/song/{id}/media", name="getSongMediaAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getSongMedia(Request $request, $id) {
        $song_id = $id;

        if (!is_numeric($song_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the song belongs to the designer
        $result = $this->getSong($request, $song_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('media.id', 'media.name', 'media.filename', 'media.file_type')
            ->from('media')->innerJoin('media', 'songs_media', 'songs_media', 'media.id = songs_media.media_id')
            ->innerJoin('songs_media', 'song', 'song', 'songs_media.song_id = song.id')->where('song.id = ?')
            ->setParameter(0, $song_id)->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($results), 'data' => $results));
        return $jsr;
    }

    /**
     * Gets all songs that use a particular piece of media
     *
     * @Route("/api/designer/media/{id}/song", name="getMediaSongsAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getMediaSongs(Request $request, $id) {
        $media_id = $id;

        if (!is_numeric($media_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the song belongs to the designer
        $result = $this->getMedia($request, $media_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('song.id', 'song.unit_id', 'song.title', 'song.album', 'song.artist', 'song.description', 'song.lyrics', 'song.embed', 'song.weight')
            ->from('media')->innerJoin('media', 'songs_media', 'songs_media', 'media.id = songs_media.media_id')
            ->innerJoin('songs_media', 'song', 'song', 'songs_media.song_id = song.id')->where('media.id = ?')
            ->setParameter(0, $media_id)->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($results), 'data' => $results));
        return $jsr;
    }

    /**
     * Checks if media link exists between the two objects
     *
     * @Route("/api/designer/song/{song_id}/media/{media_id}", name="getSongMediaLinkAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getSongMediaLink(Request $request, $song_id, $media_id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();

        if (!is_numeric($song_id) || !is_numeric($media_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
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

    /**
     * Creates a new link from media content to song
     *
     * Takes in:
     *      "song_id" - id of song to link to
     *      "media_id" - id of media to link to
     *
     * @Route("/api/designer/song-media", name="createSongMediaLinkAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function createSongMediaLink(Request $request) {
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
            $result = $this->getSong($request, $song_id);
            if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
                return $result;
            }

            // check if media given belongs to the currently logged in user
            $result = $this->getMedia($request, $media_id);
            if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
                return $result;
            }

            // check if this media link already exists
            $result = $this->getSongMediaLink($request, $song_id, $media_id);
            if ($result->getStatusCode() >= 200 && $result->getStatusCode() <= 299) {
                $jsr = new JsonResponse(array('error' => 'The link already exists.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

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

            $id = $conn->lastInsertId();
            return $this->getSongMediaLink($request, $song_id, $media_id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }

    /**
     * delete a media link
     *
     * @Route("/api/designer/song/{song_id}/media/{media_id}", name="deleteSongMediaLinkAsDesigner")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteSongMediaLink(Request $request, $song_id, $media_id) {
        if (!is_numeric($song_id) || !is_numeric($media_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if media link given belongs to currently logged in user
        $result = $this->getSongMediaLink($request, $song_id, $media_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $queryBuilder->delete('songs_media')->where('song_id = ?')->andWhere('media_id = ?')
            ->setParameter(0, $song_id)->setParameter(1, $media_id)->execute();

        return new Response();
    }



}