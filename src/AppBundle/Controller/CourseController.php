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
use AppBundle\Repository\SongMediaRepository;

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
 * getAudioVideoMedia - /api/designer/avmedia - same as above, but only returns audio and video files supported by the HTML5 player
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
     * Gets all audio/video files supported by the HTML5 player a designer has
     *
     * Can filter by name and file_type
     *
     * @Route("/api/designer/avmedia", name="getAudioVideoFilesAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getAudioVideoMedia(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return MediaRepository::getAudioVideoMedia($request, $user_id, 'designer');
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
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return SongMediaRepository::getSongMedia($request, $user_id, 'designer', $id);
    }

    /**
     * Gets all songs that use a particular piece of media
     *
     * @Route("/api/designer/media/{id}/song", name="getMediaSongsAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getMediaSongs(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return SongMediaRepository::getMediaSong($request, $user_id, 'designer', $id);
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
        return SongMediaRepository::getSongMediaLink($request, $user_id, 'designer', $song_id, $media_id);
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
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return SongMediaRepository::createSongMediaLink($request, $user_id, 'designer');
    }

    /**
     * delete a media link
     *
     * @Route("/api/designer/song/{song_id}/media/{media_id}", name="deleteSongMediaLinkAsDesigner")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteSongMediaLink(Request $request, $song_id, $media_id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return SongMediaRepository::deleteSongMediaLink($request, $user_id, 'designer', $song_id, $media_id);
    }



}