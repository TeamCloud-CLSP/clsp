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
use AppBundle\Repository\ModuleRepository;
use AppBundle\Repository\KeywordRepository;
use AppBundle\Repository\HeaderRepository;
use AppBundle\Repository\ItemRepository;
use AppBundle\Repository\KeywordMediaRepository;

/**
 * Available functions:
 *
 * getCourses - /api/professor/courses - get courses
 * getCourse - /api/professor/course/{id} - get a single course by its id
 *
 * getUnits - /api/professor/course/{id}/units - get the units that belong to a course
 * getUnit - /api/professor/unit/{id}
 *
 * getSongs - /api/professor/unit/{id}/songs - gets the songs that belong to a unit
 * getSong - /api/professor/song/{id}
 *
 * getSongMedia - /api/professor/song/{id}/media - gets all media that belongs to a song
 *
 * getModuleXX - /api/professor/song/{id}/module_xx
 * getModules - /api/professor/song/{id}/modules - get ALL modules that a song has
 * 
 * getKeywords - /api/professor/song/{id}/keywords - get keywords that a song has - can filter by phrase
 * getKeyword - /api/professor/keyword/{id}
 * 
 * getKeywordMedia - /api/professor/keyword/{id}/media - get all media that belongs to a keyword
 * 
 * getModuleXXHeadersStructure - /api/professor/song/{id}/module_xx/structure - gets all the headers and items that a specific module has in a nested list
 *
 * getModuleXXHeaders - /api/professor/song/{id}/module_xx/structure - get just the headers associated with a specific module
 * getHeading - /api/professor/header/{id}
 * 
 * getItems - /api/professor/header/{id}/items - get items that belong to an item
 * getItem - /api/professor/item/{id}
 * 
 * Class CourseController
 * @package AppBundle\Controller
 */
class ProfessorCourseController extends Controller
{
    /**
     * Gets all courses that the professor can view
     *
     * Can filter by name
     *
     * @Route("/api/professor/courses", name="getCoursesAsProfessor")
     * @Method({"GET", "OPTIONS"})
     */
    public function getCourses(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return CourseRepository::getCourses($request, $user_id, 'professor');
    }

    /**
     * Gets specific information on a specific course that the professor can view
     *
     * @Route("/api/professor/course/{id}", name="getCourseAsProfessor")
     * @Method({"GET", "OPTIONS"})
     */
    public function getCourse(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return CourseRepository::getCourse($request, $user_id, 'professor', $id);
    }

    /**
     * Gets all units that belong to the given course, ordered by their weight
     *
     * @Route("/api/professor/course/{id}/units", name="getUnitsAsProfessor")
     * @Method({"GET", "OPTIONS"})
     */
    public function getUnits(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return UnitRepository::getUnits($request, $user_id, 'professor', $id);
    }

    /**
     * Gets specific information on a specific unit that belongs to the professor
     *
     * @Route("/api/professor/unit/{id}", name="getUnitInformationAsProfessor")
     * @Method({"GET", "OPTIONS"})
     */
    public function getUnit(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return UnitRepository::getUnit($request, $user_id, 'professor', $id);
    }

    /**
     * Gets all songs that belong to the given unit, ordered by their weight
     *
     * @Route("/api/professor/unit/{id}/songs", name="getSongsAsProfessor")
     * @Method({"GET", "OPTIONS"})
     */
    public function getSongs(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return SongRepository::getSongs($request, $user_id, 'professor', $id);
    }

    /**
     * Gets specific information on a specific song
     *
     * @Route("/api/professor/song/{id}", name="getSongInformationAsProfessor")
     * @Method({"GET", "OPTIONS"})
     */
    public function getSong(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return SongRepository::getSong($request, $user_id, 'professor', $id);
    }

    /**
     * Gets all media that belongs to a song
     *
     * @Route("/api/professor/song/{id}/media", name="getSongMediaAsProfessor")
     * @Method({"GET", "OPTIONS"})
     */
    public function getSongMedia(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return SongMediaRepository::getSongMedia($request, $user_id, 'professor', $id);
    }

    /**
     * Returns the CN module
     *
     * @Route("/api/professor/song/{id}/module_cn", name="getModuleCnAsProfessor")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleCN(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::getModule($request, $user_id, 'professor', 'module_cn', $id);
    }

    /**
     * Returns the DW module
     *
     * @Route("/api/professor/song/{id}/module_dw", name="getModuleDwAsProfessor")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleDW(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::getModule($request, $user_id, 'professor', 'module_dw', $id);
    }

    /**
     * Returns the GE module
     *
     * @Route("/api/professor/song/{id}/module_ge", name="getModuleGeAsProfessor")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleGE(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::getModule($request, $user_id, 'professor', 'module_ge', $id);
    }

    /**
     * Returns the LS module
     *
     * @Route("/api/professor/song/{id}/module_ls", name="getModuleLsAsProfessor")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleLS(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::getModule($request, $user_id, 'professor', 'module_ls', $id);
    }

    /**
     * Returns the LT module
     *
     * @Route("/api/professor/song/{id}/module_lt", name="getModuleLtAsProfessor")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleLT(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::getModule($request, $user_id, 'professor', 'module_lt', $id);
    }

    /**
     * Returns the QU module
     *
     * @Route("/api/professor/song/{id}/module_qu", name="getModuleQuAsProfessor")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleQU(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::getModule($request, $user_id, 'professor', 'module_qu', $id);
    }

    /**
     * Returns all modules associated with a song
     *
     * @Route("/api/professor/song/{id}/modules", name="getModulesAsProfessor")
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
     * @Route("/api/professor/song/{id}/keywords", name="getKeywordsAsProfessor")
     * @Method({"GET", "OPTIONS"})
     */
    public function getKeywords(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return KeywordRepository::getKeywords($request, $user_id, 'professor', $id);
    }

    /**
     * Gets information on a specific keyword
     *
     * @Route("/api/professor/keyword/{id}", name="getKeywordAsProfessor")
     * @Method({"GET", "OPTIONS"})
     */
    public function getKeyword(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return KeywordRepository::getKeyword($request, $user_id, 'professor', $id);
    }

    /**
     * Gets all media that belongs to a keyword
     *
     * @Route("/api/professor/keyword/{id}/media", name="getKeywordMediaAsProfessor")
     * @Method({"GET", "OPTIONS"})
     */
    public function getKeywordMedia(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return KeywordMediaRepository::getKeywordMedia($request, $user_id, 'professor', $id);
    }

    /**
     * Generic function that returns question headers that belong to a module of a song
     */
    public function getGenericHeaders($request, $moduleName, $module_id_name, $song_id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return HeaderRepository::getHeaders($request, $user_id, 'professor', $moduleName, $module_id_name, $song_id);
    }

    /**
     * Gets information on a specific header
     *
     * @Route("/api/professor/header/{id}", name="getHeadingAsProfessor")
     * @Method({"GET", "OPTIONS"})
     */
    public function getHeading(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return HeaderRepository::getHeader($request, $user_id, 'professor', $id);
    }

    /**
     * Returns the headers associated with the module
     *
     * @Route("/api/professor/song/{id}/module_dw/headers", name="getModuleDwHeadersAsProfessor")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleDWHeaders(Request $request, $id) {
        return $this->getGenericHeaders($request, 'module_dw', 'dw_id', $id);
    }

    /**
     * Returns the header-item structure  associated with the module
     *
     * @Route("/api/professor/song/{id}/module_dw/structure", name="getModuleDwStructureAsProfessor")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleDWHeadersStructure(Request $request, $id) {
        return $this->getGenericHeaderItemStructure($request, 'module_dw', 'dw_id', $id);
    }

    /**
     * Returns the headers associated with the module
     *
     * @Route("/api/professor/song/{id}/module_ge/headers", name="getModuleGeHeadersAsProfessor")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleGEHeaders(Request $request, $id) {
        return $this->getGenericHeaders($request, 'module_ge', 'ge_id', $id);
    }

    /**
     * Returns the header-item structure  associated with the module
     *
     * @Route("/api/professor/song/{id}/module_ge/structure", name="getModuleGeStructureAsProfessor")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleGEHeadersStructure(Request $request, $id) {
        return $this->getGenericHeaderItemStructure($request, 'module_ge', 'ge_id', $id);
    }

    /**
     * Returns the headers associated with the module
     *
     * @Route("/api/professor/song/{id}/module_ls/headers", name="getModuleLsHeadersAsProfessor")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleLSHeaders(Request $request, $id) {
        return $this->getGenericHeaders($request, 'module_ls', 'ls_id', $id);
    }

    /**
     * Returns the header-item structure  associated with the module
     *
     * @Route("/api/professor/song/{id}/module_ls/structure", name="getModuleLsStructureAsProfessor")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleLSHeadersStructure(Request $request, $id) {
        return $this->getGenericHeaderItemStructure($request, 'module_ls', 'ls_id', $id);
    }

    /**
     * Returns the headers associated with the module
     *
     * @Route("/api/professor/song/{id}/module_lt/headers", name="getModuleLtHeadersAsProfessor")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleLTHeaders(Request $request, $id) {
        return $this->getGenericHeaders($request, 'module_lt', 'lt_id', $id);
    }

    /**
     * Returns the header-item structure  associated with the module
     *
     * @Route("/api/professor/song/{id}/module_lt/structure", name="getModuleLtStructureAsProfessor")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleLTHeadersStructure(Request $request, $id) {
        return $this->getGenericHeaderItemStructure($request, 'module_lt', 'lt_id', $id);
    }

    /**
     * Returns the headers associated with the module
     *
     * @Route("/api/professor/song/{id}/module_qu/headers", name="getModuleQuHeadersAsProfessor")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleQUHeaders(Request $request, $id) {
        return $this->getGenericHeaders($request, 'module_qu', 'qu_id', $id);
    }

    /**
     * Returns the header-item structure  associated with the module
     *
     * @Route("/api/professor/song/{id}/module_qu/structure", name="getModuleQuStructureAsProfessor")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleQUHeadersStructure(Request $request, $id) {
        return $this->getGenericHeaderItemStructure($request, 'module_qu', 'qu_id', $id);
    }

    /**
     * Gets items that belong to a header that belongs to a module of a song
     *
     * @Route("/api/professor/header/{id}/items", name="getHeaderItemsAsProfessor")
     * @Method({"GET", "OPTIONS"})
     */
    public function getItems(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ItemRepository::getItems($request, $user_id, 'professor', $id);
    }

    /**
     * Gets information on a specific item
     *
     * @Route("/api/professor/item/{id}", name="getItemAsProfessor")
     * @Method({"GET", "OPTIONS"})
     */
    public function getItem(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ItemRepository::getItem($request, $user_id, 'professor', $id);
    }

    /**
     * Generic function that returns question headers and items with it for a given module of a song
     */
    public function getGenericHeaderItemStructure($request, $moduleName, $module_id_name, $song_id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ItemRepository::getHeaderItemStructure($request, $user_id, 'professor', $moduleName, $module_id_name, $song_id);
    }
    
}