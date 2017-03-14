<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Database;
use AppBundle\Repository\ModuleRepository;
use AppBundle\Repository\KeywordRepository;
use AppBundle\Repository\HeaderRepository;
use AppBundle\Repository\ItemRepository;
use AppBundle\Repository\KeywordMediaRepository;

/**
 *
 * Everything in this file is kind of a giant mess. I will be restructuring most of it next week (3/8/2017)
 * when I have more time to work on this.
 *
 * Available functions:
 *
 * XX - name of module (cn, dw, ge, ls, lt, qu)
 *
 * --NOTE--: If there is no password, pass in an empty string into the password field - do not leave the field out of the JSON.
 * getModuleXX - /api/designer/song/{id}/module_xx
 * createModuleXX - /api/designer/song/{id}/module_xx/create (POST) - takes password, has_password, is_enabled - song_id is given through URL
 * editModuleXX - /api/designer/song/{id}/module_xx/edit (POST) - takes password, has_password, is_enabled
 * deleteModuleXX - /api/designer/song/{id}/module_xx (DELETE)
 *
 * getModules - /api/designer/song/{id}/modules - get ALL modules that a song has
 *
 * getKeywords - /api/designer/song/{id}/keywords - get keywords that a song has - song must have a CN module for this to work
 * getKeyword - /api/designer/keyword/{id}
 * createKeyword - /api/designer/keyword (POST) - takes phrase, song_id | OPTIONAL: description, link
 * editKeyword - /api/designer/keyword/{id} (POST) - takes phrase | OPTIONAL: description, link
 * deleteKeyword - /api/designer/keyword/{id} (DELETE)
 *
 * getKeywordMedia - /api/designer/keyword/{id}/media - get all media that belongs to a keyword
 * getMediaKeywords - /api/designer/media/{id}/keyword - get all keywords that a media is attached to
 *
 * getKeywordMediaLink - /api/designer/keyword/{keyword_id}/media/{media_id}
 * createKeywordMediaLink - /api/designer/keyword-media (POST) - takes keyword_id, media_id
 * deleteKeywordMediaLink - /api/designer/keyword/{keyword_id}/media/{media_id} (DELETE)
 *
 * getModuleXXHeadersStructure - /api/designer/song/{id}/module_xx/structure - gets all the headers and items that a specific module has in a nested list
 *
 * getModuleXXHeaders - /api/designer/song/{id}/module_xx/structure - get just the headers associated with a specific module
 * getHeading - /api/designer/header/{id}
 * createModuleXXHeaders - /api/designer/song/{id}/module_ge/headers (POST) - takes name; song_id given through URL
 * editHeader - /api/designer/header/{id} (POST) - takes name
 * deleteHeading - /api/designer/header/{id} (DELETE)
 *
 * getItems - /api/designer/header/{id}/items - get items that belong to an item
 * getItem - /api/designer/item/{id}
 * createItem - /api/designer/item (POST) - takes content, type, weight, heading_id | optional: choices, answers
 * editItem - /api/designer/item/{id} (POST) - takes content, type, weight | optional: choices, answers
 * deleteItem - /api/designer/item/{id} (DELETE)
 *
 * Class ModuleController
 * @package AppBundle\Controller
 */
class ModuleController extends Controller
{

    /**
     * Returns the CN module
     *
     * @Route("/api/designer/song/{id}/module_cn", name="getModuleCnAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleCN(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::getModule($request, $user_id, 'designer', 'module_cn', $id);
    }

    /**
     * Creates a CN module
     *
     * @Route("/api/designer/song/{id}/module_cn/create", name="createModuleCnAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function createModuleCN(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::createModule($request, $user_id, 'designer', 'module_cn', $id);
    }

    /**
     * Edits a CN module
     *
     * @Route("/api/designer/song/{id}/module_cn/edit", name="editModuleCnAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function editModuleCN(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::editModule($request, $user_id, 'designer', 'module_cn', $id);
    }

    /**
     * Deletes a CN module
     *
     * @Route("/api/designer/song/{id}/module_cn", name="deleteModuleCnAsDesigner")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteModuleCN(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::deleteModule($request, $user_id, 'designer', 'module_cn', $id);
    }

    /**
     * Returns the DW module
     *
     * @Route("/api/designer/song/{id}/module_dw", name="getModuleDwAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleDW(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::getModule($request, $user_id, 'designer', 'module_dw', $id);
    }

    /**
     * Creates a DW module
     *
     * @Route("/api/designer/song/{id}/module_dw/create", name="createModuleDwAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function createModuleDW(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::createModule($request, $user_id, 'designer', 'module_dw', $id);
    }

    /**
     * Edits a DW module
     *
     * @Route("/api/designer/song/{id}/module_dw/edit", name="editModuleDwAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function editModuleDW(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::editModule($request, $user_id, 'designer', 'module_dw', $id);
    }

    /**
     * Deletes a DW module
     *
     * @Route("/api/designer/song/{id}/module_dw", name="deleteModuleDwAsDesigner")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteModuleDW(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::deleteModule($request, $user_id, 'designer', 'module_dw', $id);
    }

    /**
     * Returns the GE module
     *
     * @Route("/api/designer/song/{id}/module_ge", name="getModuleGeAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleGE(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::getModule($request, $user_id, 'designer', 'module_ge', $id);
    }

    /**
     * Creates a GE module
     *
     * @Route("/api/designer/song/{id}/module_ge/create", name="createModuleGeAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function createModuleGE(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::createModule($request, $user_id, 'designer', 'module_ge', $id);
    }

    /**
     * Edits a GE module
     *
     * @Route("/api/designer/song/{id}/module_ge/edit", name="editModuleGeAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function editModuleGE(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::editModule($request, $user_id, 'designer', 'module_ge', $id);
    }

    /**
     * Deletes a GE module
     *
     * @Route("/api/designer/song/{id}/module_ge", name="deleteModuleGeAsDesigner")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteModuleGE(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::deleteModule($request, $user_id, 'designer', 'module_ge', $id);
    }

    /**
     * Returns the LS module
     *
     * @Route("/api/designer/song/{id}/module_ls", name="getModuleLsAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleLS(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::getModule($request, $user_id, 'designer', 'module_ls', $id);
    }

    /**
     * Creates a LS module
     *
     * @Route("/api/designer/song/{id}/module_ls/create", name="createModuleLsAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function createModuleLS(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::createModule($request, $user_id, 'designer', 'module_ls', $id);
    }

    /**
     * Edits a LS module
     *
     * @Route("/api/designer/song/{id}/module_ls/edit", name="editModuleLsAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function editModuleLS(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::editModule($request, $user_id, 'designer', 'module_ls', $id);
    }

    /**
     * Deletes a LS module
     *
     * @Route("/api/designer/song/{id}/module_ls", name="deleteModuleLsAsDesigner")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteModuleLS(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::deleteModule($request, $user_id, 'designer', 'module_ls', $id);
    }

    /**
     * Returns the LT module
     *
     * @Route("/api/designer/song/{id}/module_lt", name="getModuleLtAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleLT(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::getModule($request, $user_id, 'designer', 'module_lt', $id);
    }

    /**
     * Creates a LT module
     *
     * @Route("/api/designer/song/{id}/module_lt/create", name="createModuleLtAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function createModuleLT(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::createModule($request, $user_id, 'designer', 'module_lt', $id);
    }

    /**
     * Edits a LT module
     *
     * @Route("/api/designer/song/{id}/module_lt/edit", name="editModuleLtAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function editModuleLT(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::editModule($request, $user_id, 'designer', 'module_lt', $id);
    }

    /**
     * Deletes a LT module
     *
     * @Route("/api/designer/song/{id}/module_lt", name="deleteModuleLtAsDesigner")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteModuleLT(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::deleteModule($request, $user_id, 'designer', 'module_lt', $id);
    }

    /**
     * Returns the QU module
     *
     * @Route("/api/designer/song/{id}/module_qu", name="getModuleQuAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleQU(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::getModule($request, $user_id, 'designer', 'module_qu', $id);
    }

    /**
     * Creates a QU module
     *
     * @Route("/api/designer/song/{id}/module_qu/create", name="createModuleQuAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function createModuleQU(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::createModule($request, $user_id, 'designer', 'module_qu', $id);
    }

    /**
     * Edits a QU module
     *
     * @Route("/api/designer/song/{id}/module_qu/edit", name="editModuleQuAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function editModuleQU(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::editModule($request, $user_id, 'designer', 'module_qu', $id);
    }

    /**
     * Deletes a QU module
     *
     * @Route("/api/designer/song/{id}/module_qu", name="deleteModuleQuAsDesigner")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteModuleQU(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ModuleRepository::deleteModule($request, $user_id, 'designer', 'module_qu', $id);
    }

    /**
     * Returns all modules associated with a song
     *
     * @Route("/api/designer/song/{id}/modules", name="getModulesAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModules(Request $request, $id) {
        $modules = array();
        $result = $this->getModuleCN($request, $id);
        if ($result->getStatusCode() > 199 && $result->getStatusCode() < 300) {
            array_push($modules, json_decode($result->getContent()));
        }
        $result = $this->getModuleDW($request, $id);
        if ($result->getStatusCode() > 199 && $result->getStatusCode() < 300) {
            array_push($modules, json_decode($result->getContent()));
        }
        $result = $this->getModuleGE($request, $id);
        if ($result->getStatusCode() > 199 && $result->getStatusCode() < 300) {
            array_push($modules, json_decode($result->getContent()));
        }
        $result = $this->getModuleLS($request, $id);
        if ($result->getStatusCode() > 199 && $result->getStatusCode() < 300) {
            array_push($modules, json_decode($result->getContent()));
        }
        $result = $this->getModuleLT($request, $id);
        if ($result->getStatusCode() > 199 && $result->getStatusCode() < 300) {
            array_push($modules, json_decode($result->getContent()));
        }
        $result = $this->getModuleQU($request, $id);
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
     * @Route("/api/designer/song/{id}/keywords", name="getKeywordsAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getKeywords(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return KeywordRepository::getKeywords($request, $user_id, 'designer', $id);
    }

    /**
     * Gets information on a specific keyword
     *
     * @Route("/api/designer/keyword/{id}", name="getKeywordAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getKeyword(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return KeywordRepository::getKeyword($request, $user_id, 'designer', $id);
    }

    /**
     * Creates a new keyword tied to the module_cn of the current song
     *
     * Takes in:
     *      "song_id" - Song keyword is associated with
     *      "phrase" - Phrase of the keyword to match against
     *      "description" - description of phrase (OPTIONAL)
     *      "link" - link to which the phrase should take you (OPTIONAL)
     *
     * @Route("/api/designer/keyword", name="createKeywordAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function createKeyword(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return KeywordRepository::createKeyword($request, $user_id, 'designer');
    }

    /**
     * Edits an existing keyword tied to the module_cn of the current song
     *
     * Takes in:
     *      "phrase" - Phrase of the keyword to match against
     *      "description" - description of phrase (OPTIONAL)
     *      "link" - link to which the phrase should take you (OPTIONAL)
     *
     * @Route("/api/designer/keyword/{id}", name="editKeywordAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function editKeyword(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return KeywordRepository::editKeyword($request, $user_id, 'designer', $id);
    }

    /**
     * Deletes a specific keyword
     *
     * @Route("/api/designer/keyword/{id}", name="deleteKeywordAsDesigner")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteKeyword(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return KeywordRepository::deleteKeyword($request, $user_id, 'designer', $id);
    }

    // ------------ methods below are for media linking for keywords - they should essentially be the SAME functions as the ones in course controller for song ----------

    /**
     * Gets all media that belongs to a keyword
     *
     * @Route("/api/designer/keyword/{id}/media", name="getKeywordMediaAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getKeywordMedia(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return KeywordMediaRepository::getKeywordMedia($request, $user_id, 'designer', $id);
    }

    /**
     * Gets all keywords that use a particular piece of media
     *
     * @Route("/api/designer/media/{id}/keyword", name="getMediaKeywordsAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getMediaKeywords(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return KeywordMediaRepository::getMediaKeywords($request, $user_id, 'designer', $id);
    }

    /**
     * Checks if media link exists between the two objects
     *
     * @Route("/api/designer/keyword/{keyword_id}/media/{media_id}", name="getKeywordMediaLinkAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getKeywordMediaLink(Request $request, $keyword_id, $media_id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return KeywordMediaRepository::getKeywordMediaLink($request, $user_id, 'designer', $keyword_id, $media_id);
    }

    /**
     * Creates a new link from media content to keyword
     *
     * Takes in:
     *      "keyword_id" - id of keyword to link to
     *      "media_id" - id of media to link to
     *
     * @Route("/api/designer/keyword-media", name="createKeywordMediaLinkAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function createKeywordMediaLink(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return KeywordMediaRepository::createKeywordMediaLink($request, $user_id, 'designer');
    }

    /**
     * delete a media link
     *
     * @Route("/api/designer/keyword/{keyword_id}/media/{media_id}", name="deleteKeywordMediaLinkAsDesigner")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteKeywordMediaLink(Request $request, $keyword_id, $media_id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return KeywordMediaRepository::deleteKeywordMediaLink($request, $user_id, 'designer', $keyword_id, $media_id);
    }

    // ------------ methods above are for media linking for keywords - they should essentially be the SAME functions as the ones in course controller for song ----------

    /**
     * Generic function that returns question headers that belong to a module of a song
     */
    public function getGenericHeaders($request, $moduleName, $module_id_name, $song_id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return HeaderRepository::getHeaders($request, $user_id, 'designer', $moduleName, $module_id_name, $song_id);
    }

    /**
     * Gets information on a specific header
     *
     * @Route("/api/designer/header/{id}", name="getHeadingAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getHeading(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return HeaderRepository::getHeader($request, $user_id, 'designer', $id);
    }

    /**
     * Creates a new heading based on the module type - not a route.
     *
     * Takes in:
     *      "song_id" - Song keyword is associated with (passed through URL)
     *      "name" - name of the heading
     */
    public function createGenericHeader(Request $request, $moduleName, $module_id_name, $song_id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return HeaderRepository::createHeader($request, $user_id, 'designer', $moduleName, $module_id_name, $song_id);
    }

    /**
     * Edit a header
     *
     * Takes in:
     *      "name" - name of the header
     *
     * @Route("/api/designer/header/{id}", name="editHeaderAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function editHeader(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return HeaderRepository::editHeader($request, $user_id, 'designer', $id);
    }

    /**
     * Deletes a specific heading
     *
     * @Route("/api/designer/header/{id}", name="deleteHeadingAsDesigner")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteHeading(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return HeaderRepository::deleteHeader($request, $user_id, 'designer', $id);
    }

    /**
     * Returns the headers associated with the module
     *
     * @Route("/api/designer/song/{id}/module_dw/headers", name="getModuleDwHeadersAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleDWHeaders(Request $request, $id) {
        return $this->getGenericHeaders($request, 'module_dw', 'dw_id', $id);
    }

    /**
     * Creates a header for the module
     *
     * @Route("/api/designer/song/{id}/module_dw/headers", name="createModuleDwHeadersAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function createModuleDWHeaders(Request $request, $id) {
        return $this->createGenericHeader($request, 'module_dw', 'dw_id', $id);
    }

    /**
     * Returns the header-item structure  associated with the module
     *
     * @Route("/api/designer/song/{id}/module_dw/structure", name="getModuleDwStructureAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleDWHeadersStructure(Request $request, $id) {
        return $this->getGenericHeaderItemStructure($request, 'module_dw', 'dw_id', $id);
    }

    /**
     * Returns the headers associated with the module
     *
     * @Route("/api/designer/song/{id}/module_ge/headers", name="getModuleGeHeadersAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleGEHeaders(Request $request, $id) {
        return $this->getGenericHeaders($request, 'module_ge', 'ge_id', $id);
    }

    /**
     * Creates a header for the module
     *
     * @Route("/api/designer/song/{id}/module_ge/headers", name="createModuleGeHeadersAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function createModuleGEHeaders(Request $request, $id) {
        return $this->createGenericHeader($request, 'module_ge', 'dw_ge', $id);
    }

    /**
     * Returns the header-item structure  associated with the module
     *
     * @Route("/api/designer/song/{id}/module_ge/structure", name="getModuleGeStructureAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleGEHeadersStructure(Request $request, $id) {
        return $this->getGenericHeaderItemStructure($request, 'module_ge', 'ge_id', $id);
    }

    /**
     * Returns the headers associated with the module
     *
     * @Route("/api/designer/song/{id}/module_ls/headers", name="getModuleLsHeadersAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleLSHeaders(Request $request, $id) {
        return $this->getGenericHeaders($request, 'module_ls', 'ls_id', $id);
    }

    /**
     * Creates a header for the module
     *
     * @Route("/api/designer/song/{id}/module_ls/headers", name="createModuleLsHeadersAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function createModuleLSHeaders(Request $request, $id) {
        return $this->createGenericHeader($request, 'module_ls', 'dw_ls', $id);
    }

    /**
     * Returns the header-item structure  associated with the module
     *
     * @Route("/api/designer/song/{id}/module_ls/structure", name="getModuleLsStructureAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleLSHeadersStructure(Request $request, $id) {
        return $this->getGenericHeaderItemStructure($request, 'module_ls', 'ls_id', $id);
    }

    /**
     * Returns the headers associated with the module
     *
     * @Route("/api/designer/song/{id}/module_lt/headers", name="getModuleLtHeadersAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleLTHeaders(Request $request, $id) {
        return $this->getGenericHeaders($request, 'module_lt', 'lt_id', $id);
    }

    /**
     * Creates a header for the module
     *
     * @Route("/api/designer/song/{id}/module_lt/headers", name="createModuleLtHeadersAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function createModuleLTHeaders(Request $request, $id) {
        return $this->createGenericHeader($request, 'module_lt', 'lt_id', $id);
    }

    /**
     * Returns the header-item structure  associated with the module
     *
     * @Route("/api/designer/song/{id}/module_lt/structure", name="getModuleLtStructureAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleLTHeadersStructure(Request $request, $id) {
        return $this->getGenericHeaderItemStructure($request, 'module_lt', 'lt_id', $id);
    }

    /**
     * Returns the headers associated with the module
     *
     * @Route("/api/designer/song/{id}/module_qu/headers", name="getModuleQuHeadersAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleQUHeaders(Request $request, $id) {
        return $this->getGenericHeaders($request, 'module_qu', 'qu_id', $id);
    }

    /**
     * Creates a header for the module
     *
     * @Route("/api/designer/song/{id}/module_qu/headers", name="createModuleQuHeadersAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function createModuleQUHeaders(Request $request, $id) {
        return $this->createGenericHeader($request, 'module_qu', 'qu_id', $id);
    }

    /**
     * Returns the header-item structure  associated with the module
     *
     * @Route("/api/designer/song/{id}/module_qu/structure", name="getModuleQuStructureAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleQUHeadersStructure(Request $request, $id) {
        return $this->getGenericHeaderItemStructure($request, 'module_qu', 'qu_id', $id);
    }

    /**
     * Gets items that belong to a header that belongs to a module of a song
     *
     * @Route("/api/designer/header/{id}/items", name="getHeaderItemsAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getItems(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ItemRepository::getItems($request, $user_id, 'designer', $id);
    }

    /**
     * Gets information on a specific item
     *
     * @Route("/api/designer/item/{id}", name="getItemAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getItem(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ItemRepository::getItem($request, $user_id, 'designer', $id);
    }

    /**
     * Creates a new item tied to the current song
     *
     * Takes in:
     *      "heading_id" - Heading that the item is associated with
     *      "content" - Content of the question item (or label)
     *      "type" - Type of the question (processed by front-end)
     *      "weight" - Order by which the items will be sorted
     *      "choices" - Answer choices if it is a multiple choice question (OPTIONAL)
     *      "answers" - Correct answers to the question (OPTIONAL)
     *
     * @Route("/api/designer/item", name="createItemAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function createItem(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ItemRepository::createItem($request, $user_id, 'designer');
    }

    /**
     * Edits an existing question item
     *
     * Takes in:
     *      "content" - Content of the question item (or label)
     *      "type" - Type of the question (processed by front-end)
     *      "weight" - Order by which the items will be sorted
     *      "choices" - Answer choices if it is a multiple choice question (OPTIONAL)
     *      "answers" - Correct answers to the question (OPTIONAL)
     *
     * @Route("/api/designer/item/{id}", name="editItemAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function editItem(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ItemRepository::editItem($request, $user_id, 'designer', $id);
    }

    /**
     * Deletes a specific item
     *
     * @Route("/api/designer/item/{id}", name="deleteItemAsDesigner")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteItem(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ItemRepository::deleteItem($request, $user_id, 'designer', $id);
    }

    /**
     * Generic function that returns question headers and items with it for a given module of a song
     */
    public function getGenericHeaderItemStructure($request, $moduleName, $module_id_name, $song_id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ItemRepository::getHeaderItemStructure($request, $user_id, 'designer', $moduleName, $module_id_name, $song_id);
    }

}