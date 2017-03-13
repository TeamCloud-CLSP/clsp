<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Database;
use AppBundle\Repository\CourseRepository;
use AppBundle\Repository\UnitRepository;
use AppBundle\Repository\SongRepository;
use AppBundle\Repository\MediaRepository;

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
 * getAllMedia - /api/designer/media - gets all files the designer owns; can filter by name and file_type
 * getMedia - /api/designer/media/{id}
 * createMedia - /api/designer/media (POST) - takes file (the actual file) | optional: name
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
        return CourseRepository::getCourses($request, $user_id, 'designer');
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
        return CourseRepository::getCourse($request, $user_id, 'designer', $id);
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
        return CourseRepository::createCourse($request, $user_id, 'designer');
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
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return CourseRepository::editCourse($request, $user_id, 'designer', $id);
    }

    /**
     * Deletes a course that belongs to the designer
     *
     * @Route("/api/designer/course/{id}", name="deleteCourseAsDesigner")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteCourse(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return CourseRepository::deleteCourse($request, $user_id, 'designer', $id);
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
        return UnitRepository::getUnits($request, $user_id, 'designer', $id);
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
        return UnitRepository::getUnit($request, $user_id, 'designer', $id);
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
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return UnitRepository::createUnit($request, $user_id, 'designer');
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
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return UnitRepository::editUnit($request, $user_id, 'designer', $id);
    }

    /**
     * Deletes a unit that belongs to the current course
     *
     * @Route("/api/designer/unit/{id}", name="deleteUnitAsDesigner")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteUnit(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return UnitRepository::deleteUnit($request, $user_id, 'designer', $id);
    }

    /**
     * Gets all songs that belong to the given unit, ordered by their weight
     *
     * @Route("/api/designer/unit/{id}/songs", name="getSongsAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getSongs(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return SongRepository::getSongs($request, $user_id, 'designer', $id);
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
        return SongRepository::getSong($request, $user_id, 'designer', $id);
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
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return SongRepository::createSong($request, $user_id, 'designer');
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
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return SongRepository::editSong($request, $user_id, 'designer', $id);
    }

    /**
     * Deletes a song that belongs to the current course
     *
     * @Route("/api/designer/song/{id}", name="deleteSongAsDesigner")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteSong(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return SongRepository::deleteSong($request, $user_id, 'designer', $id);
    }

    /**
     * Gets all files a designer has
     * 
     * Can filter by name and file_type
     *
     * @Route("/api/designer/media", name="getFilesAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getAllMedia(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return MediaRepository::getAllMedia($request, $user_id, 'designer');
        
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
        return MediaRepository::getMedia($request, $user_id, 'designer', $id);
    }

    /**
     * endpoint for uploading a file
     *
     * Takes:
     *      "file" = the file being uploaded
     *
     * Optional:
     *      "file_type" = overrides the file type being processed from the file - this should NOT be used
     *      "name" = overrides the default name of the file
     *
     * @Route("/api/designer/media", name="uploadFileAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function createMedia(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return MediaRepository::createMedia($request, $user_id, 'designer');
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
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return MediaRepository::editMedia($request, $user_id, 'designer', $id);

    }

    /**
     * endpoint for deleting a file
     *
     * @Route("/api/designer/media/{id}", name="deleteFileAsDesigner")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteMedia(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return MediaRepository::deleteMedia($request, $user_id, 'designer', $id);
        
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