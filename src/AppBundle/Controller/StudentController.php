<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Tests\Controller\StudentControllerTest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use \DateTime;
use \DateTimeZone;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Database;
use AppBundle\Repository\CourseRepository;
use AppBundle\Repository\UnitRepository;
use AppBundle\Repository\SongRepository;
use AppBundle\Repository\MediaRepository;
use AppBundle\Repository\SongMediaRepository;
use AppBundle\Repository\ModuleRepository;
use AppBundle\Repository\KeywordRepository;
use AppBundle\Repository\HeaderRepository;
use AppBundle\Repository\ItemRepository;
use AppBundle\Repository\KeywordMediaRepository;
use AppBundle\Repository\ClassRepository;

/**
 * Available functions:
 *
 * getClass - /api/student/class
 *
 * getCourses - /api/student/courses - get courses
 * getCourse - /api/student/course/{id} - get a single course by its id
 *
 * getUnits - /api/student/course/{id}/units - get the units that belong to a course
 * getUnit - /api/student/unit/{id}
 *
 * getSongs - /api/student/unit/{id}/songs - gets the songs that belong to a unit
 * getSong - /api/student/song/{id}
 *
 * getSongMedia - /api/student/song/{id}/media - gets all media that belongs to a song
 *
 * getModuleXX - /api/student/song/{id}/module_xx
 * getModules - /api/student/song/{id}/modules - get ALL modules that a song has
 *
 * KEYWORD FUNCTIONS BELOW: if the module_cn requires a password, a password parameter must be sent with the request to authenticate.
 * getKeywords - /api/student/song/{id}/keywords - get keywords that a song has - can filter by phrase
 * getKeyword - /api/student/keyword/{id}
 *
 * getKeywordMedia - /api/student/keyword/{id}/media - get all media that belongs to a keyword
 *
 * getModuleXXHeadersStructure - /api/student/song/{id}/module_xx/structure - gets all the headers and items that a specific module has in a nested list
 *
 * getModuleXXHeaders - /api/student/song/{id}/module_xx/structure - get just the headers associated with a specific module
 * getHeading - /api/student/header/{id}
 *
 * getItems - /api/student/header/{id}/items - get items that belong to an item
 * getItem - /api/student/item/{id}
 *
 * Class StudentController
 * @package AppBundle\Controller
 */
class StudentController extends Controller
{
    /**
     * Gets information on the class the student belongs to
     *
     * @Route("/api/student/class", name="getClassAsStudent")
     * @Method({"GET", "OPTIONS"})
     */
    public function getClass(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ClassRepository::getClass($request, $user_id, 'student', -1);
    }

    /**
     * Gets specific information on a specific course that the student can view
     *
     * @Route("/api/student/course/{id}", name="getCourseAsStudent")
     * @Method({"GET", "OPTIONS"})
     */
    public function getCourse(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return CourseRepository::getCourse($request, $user_id, 'student', $id);
    }

    /**
     * Gets all units that belong to the given course, ordered by their weight
     *
     * @Route("/api/student/course/{id}/units", name="getUnitsAsStudent")
     * @Method({"GET", "OPTIONS"})
     */
    public function getUnits(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return UnitRepository::getUnits($request, $user_id, 'student', $id);
    }

    /**
     * Gets specific information on a specific unit that belongs to the student
     *
     * @Route("/api/student/unit/{id}", name="getUnitInformationAsStudent")
     * @Method({"GET", "OPTIONS"})
     */
    public function getUnit(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return UnitRepository::getUnit($request, $user_id, 'student', $id);
    }

    /**
     * Gets all songs that belong to the given unit, ordered by their weight
     *
     * @Route("/api/student/unit/{id}/songs", name="getSongsAsStudent")
     * @Method({"GET", "OPTIONS"})
     */
    public function getSongs(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return SongRepository::getSongs($request, $user_id, 'student', $id);
    }

    /**
     * Gets specific information on a specific song
     *
     * @Route("/api/student/song/{id}", name="getSongInformationAsStudent")
     * @Method({"GET", "OPTIONS"})
     */
    public function getSong(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return SongRepository::getSong($request, $user_id, 'student', $id);
    }

    /**
     * Gets all media that belongs to a song
     *
     * @Route("/api/student/song/{id}/media", name="getSongMediaAsStudent")
     * @Method({"GET", "OPTIONS"})
     */
    public function getSongMedia(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return SongMediaRepository::getSongMedia($request, $user_id, 'student', $id);
    }

    /**
     * Returns the CN module
     *
     * @Route("/api/student/song/{id}/module_cn", name="getModuleCnAsStudent")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleCN(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::getModule($request, $user_id, 'student', 'module_cn', $id);
    }

    /**
     * Returns the DW module
     *
     * @Route("/api/student/song/{id}/module_dw", name="getModuleDwAsStudent")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleDW(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::getModule($request, $user_id, 'student', 'module_dw', $id);
    }

    /**
     * Returns the GE module
     *
     * @Route("/api/student/song/{id}/module_ge", name="getModuleGeAsStudent")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleGE(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::getModule($request, $user_id, 'student', 'module_ge', $id);
    }

    /**
     * Returns the LS module
     *
     * @Route("/api/student/song/{id}/module_ls", name="getModuleLsAsStudent")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleLS(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::getModule($request, $user_id, 'student', 'module_ls', $id);
    }

    /**
     * Returns the LT module
     *
     * @Route("/api/student/song/{id}/module_lt", name="getModuleLtAsStudent")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleLT(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::getModule($request, $user_id, 'student', 'module_lt', $id);
    }

    /**
     * Returns the QU module
     *
     * @Route("/api/student/song/{id}/module_qu", name="getModuleQuAsStudent")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleQU(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::getModule($request, $user_id, 'student', 'module_qu', $id);
    }

    /**
     * Returns all modules associated with a song
     *
     * @Route("/api/student/song/{id}/modules", name="getModulesAsStudent")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModules(Request $request, $id) {
        $modules = array();
        $result = $this->getModuleLT($request, $id);
        if ($result->getStatusCode() > 199 && $result->getStatusCode() < 300) {
            array_push($modules, json_decode($result->getContent()));
        }
        $result = $this->getModuleCN($request, $id);
        if ($result->getStatusCode() > 199 && $result->getStatusCode() < 300) {
            array_push($modules, json_decode($result->getContent()));
        }
        $result = $this->getModuleQU($request, $id);
        if ($result->getStatusCode() > 199 && $result->getStatusCode() < 300) {
            array_push($modules, json_decode($result->getContent()));
        }
        $result = $this->getModuleGE($request, $id);
        if ($result->getStatusCode() > 199 && $result->getStatusCode() < 300) {
            array_push($modules, json_decode($result->getContent()));
        }
        $result = $this->getModuleDW($request, $id);
        if ($result->getStatusCode() > 199 && $result->getStatusCode() < 300) {
            array_push($modules, json_decode($result->getContent()));
        }
        $result = $this->getModuleLS($request, $id);
        if ($result->getStatusCode() > 199 && $result->getStatusCode() < 300) {
            array_push($modules, json_decode($result->getContent()));
        }

        if (count($modules) < 1) {
            return $result;
        }

        return new JsonResponse(array('size' => count($modules), 'data' => $modules));
    }

    /**
     * Gets all keywords that belong to a song
     *
     * @Route("/api/student/song/{id}/keywords", name="getKeywordsAsStudent")
     * @Method({"GET", "OPTIONS"})
     */
    public function getKeywords(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return KeywordRepository::getKeywords($request, $user_id, 'student', $id);
    }

    /**
     * Gets information on a specific keyword
     *
     * @Route("/api/student/keyword/{id}", name="getKeywordAsStudent")
     * @Method({"GET", "OPTIONS"})
     */
    public function getKeyword(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return KeywordRepository::getKeyword($request, $user_id, 'student', $id);
    }

    /**
     * Gets all media that belongs to a keyword
     *
     * @Route("/api/student/keyword/{id}/media", name="getKeywordMediaAsStudent")
     * @Method({"GET", "OPTIONS"})
     */
    public function getKeywordMedia(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return KeywordMediaRepository::getKeywordMedia($request, $user_id, 'student', $id);
    }

    /**
     * Generic function that returns question headers that belong to a module of a song
     */
    public function getGenericHeaders($request, $moduleName, $module_id_name, $song_id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return HeaderRepository::getHeaders($request, $user_id, 'student', $moduleName, $module_id_name, $song_id);
    }

    /**
     * Gets information on a specific header
     *
     * @Route("/api/student/header/{id}", name="getHeadingAsStudent")
     * @Method({"GET", "OPTIONS"})
     */
    public function getHeading(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return HeaderRepository::getHeader($request, $user_id, 'student', $id);
    }

    /**
     * Returns the headers associated with the module
     *
     * @Route("/api/student/song/{id}/module_dw/headers", name="getModuleDwHeadersAsStudent")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleDWHeaders(Request $request, $id) {
        return $this->getGenericHeaders($request, 'module_dw', 'dw_id', $id);
    }

    /**
     * Returns the header-item structure  associated with the module
     *
     * @Route("/api/student/song/{id}/module_dw/structure", name="getModuleDwStructureAsStudent")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleDWHeadersStructure(Request $request, $id) {
        return $this->getGenericHeaderItemStructure($request, 'module_dw', 'dw_id', $id);
    }

    /**
     * Returns the headers associated with the module
     *
     * @Route("/api/student/song/{id}/module_ge/headers", name="getModuleGeHeadersAsStudent")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleGEHeaders(Request $request, $id) {
        return $this->getGenericHeaders($request, 'module_ge', 'ge_id', $id);
    }

    /**
     * Returns the header-item structure  associated with the module
     *
     * @Route("/api/student/song/{id}/module_ge/structure", name="getModuleGeStructureAsStudent")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleGEHeadersStructure(Request $request, $id) {
        return $this->getGenericHeaderItemStructure($request, 'module_ge', 'ge_id', $id);
    }

    /**
     * Returns the headers associated with the module
     *
     * @Route("/api/student/song/{id}/module_ls/headers", name="getModuleLsHeadersAsStudent")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleLSHeaders(Request $request, $id) {
        return $this->getGenericHeaders($request, 'module_ls', 'ls_id', $id);
    }

    /**
     * Returns the header-item structure  associated with the module
     *
     * @Route("/api/student/song/{id}/module_ls/structure", name="getModuleLsStructureAsStudent")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleLSHeadersStructure(Request $request, $id) {
        return $this->getGenericHeaderItemStructure($request, 'module_ls', 'ls_id', $id);
    }

    /**
     * Returns the headers associated with the module
     *
     * @Route("/api/student/song/{id}/module_lt/headers", name="getModuleLtHeadersAsStudent")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleLTHeaders(Request $request, $id) {
        return $this->getGenericHeaders($request, 'module_lt', 'lt_id', $id);
    }

    /**
     * Returns the header-item structure  associated with the module
     *
     * @Route("/api/student/song/{id}/module_lt/structure", name="getModuleLtStructureAsStudent")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleLTHeadersStructure(Request $request, $id) {
        return $this->getGenericHeaderItemStructure($request, 'module_lt', 'lt_id', $id);
    }

    /**
     * Returns the headers associated with the module
     *
     * @Route("/api/student/song/{id}/module_qu/headers", name="getModuleQuHeadersAsStudent")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleQUHeaders(Request $request, $id) {
        return $this->getGenericHeaders($request, 'module_qu', 'qu_id', $id);
    }

    /**
     * Returns the header-item structure  associated with the module
     *
     * @Route("/api/student/song/{id}/module_qu/structure", name="getModuleQuStructureAsStudent")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleQUHeadersStructure(Request $request, $id) {
        return $this->getGenericHeaderItemStructure($request, 'module_qu', 'qu_id', $id);
    }

    /**
     * Gets items that belong to a header that belongs to a module of a song
     *
     * @Route("/api/student/header/{id}/items", name="getHeaderItemsAsStudent")
     * @Method({"GET", "OPTIONS"})
     */
    public function getItems(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ItemRepository::getItems($request, $user_id, 'student', $id);
    }

    /**
     * Gets information on a specific item
     *
     * @Route("/api/student/item/{id}", name="getItemAsStudent")
     * @Method({"GET", "OPTIONS"})
     */
    public function getItem(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ItemRepository::getItem($request, $user_id, 'student', $id);
    }

    /**
     * Generic function that returns question headers and items with it for a given module of a song
     */
    public function getGenericHeaderItemStructure(Request $request, $moduleName, $module_id_name, $song_id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ItemRepository::getHeaderItemStructure($request, $user_id, 'student', $moduleName, $module_id_name, $song_id);

    }

    /**
     * Checks answer to a specific item (key must be "answer")
     *
     * @Route("/api/student/item/{id}/check", name="checkItemAsStudent")
     * @Method({"POST", "OPTIONS"})
     */
    public function checkAnswer(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ItemRepository::checkAnswer($request, $user_id, 'student', $id);
    }

    /**
     * Checks answers to a list of items (key must be id of the item to check)
     *
     * @Route("/api/student/checkitems", name="checkItemsAsStudent")
     * @Method({"POST", "OPTIONS"})
     */
    public function checkAnswers(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ItemRepository::checkAnswers($request, $user_id, 'student');
    }
}
