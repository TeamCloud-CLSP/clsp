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
 * Class ModuleController
 * @package AppBundle\Controller
 */
class ModuleController extends Controller
{
    /**
     * Helper only - should remain the SAME function as the one in course controller.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
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
     * Another helper function only - should be the same method as the one in course controller
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
     * Generic function to return information of a specific module. NOT AN ENDPOINT.
     */
    public function getModuleFromDatabase($request, $moduleName, $song_id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();

        if (!is_numeric($song_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('module.id', 'module.password', 'module.has_password', 'module.song_id', 'module.is_enabled', 'song.id AS song_id')
            ->from('app_users', 'designers')->innerJoin('designers', 'courses', 'courses', 'designers.id = courses.user_id')
            ->innerJoin('courses', 'unit', 'unit', 'unit.course_id = courses.id')
            ->innerJoin('unit', 'song', 'song', 'song.unit_id = unit.id')->innerJoin('song', $moduleName, 'module', 'song.id = module.song_id')
            ->where('designers.id = ?')->andWhere('song.id = ?')
            ->setParameter(0, $user_id)->setParameter(1, $song_id)->execute()->fetchAll();
        if (count($results) < 1) {
            $jsr = new JsonResponse(array('error' => 'Module does not exist or does not belong to the currently authenticated user.'));
            $jsr->setStatusCode(503);
            return $jsr;
        } else if (count($results) > 1) {
            $jsr = new JsonResponse(array('error' => 'An error has occurred. Check for duplicate keys in the database.'));
            $jsr->setStatusCode(500);
            return $jsr;
        }

        $results[0]['module_type'] = $moduleName;
        return new JsonResponse($results[0]);
    }

    /**
     * Generic function to create a new module. NOT AN ENDPOINT.
     *
     * Requires: song_id (passed in through URL), password, has_password, is_enabled
     */
    public function createModuleInDatabase($request, $moduleName, $song_id) {
        if (!is_numeric($song_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric value specified for a numeric field.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if song given belongs to the currently logged in user
        $result = $this->getSong($request, $song_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        // check to make sure the same module doesn't already exist for this song
        $result = $this->getModuleFromDatabase($request, $moduleName, $song_id);
        if ($result->getStatusCode() > 199 && $result->getStatusCode() < 300) {
            $jsr = new JsonResponse(array('error' => 'A module of this type already exists for this song.'));
            $jsr->setStatusCode(500);
            return $jsr;
        }

        // check post parameters to make sure required fields exist
        $post_parameters = $request->request->all();
        if (array_key_exists('password', $post_parameters) && array_key_exists('has_password', $post_parameters) && array_key_exists('is_enabled', $post_parameters)) {
            $password = $post_parameters['password'];
            $has_password = $post_parameters['has_password'];
            $is_enabled = $post_parameters['is_enabled'];

            if ($has_password == 0 && ($password != '' || $password != null)) {
                $jsr = new JsonResponse(array('error' => 'Specified a password but did not allow a password.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            if ($has_password == 1 && ($password == '' || $password == null)) {
                $jsr = new JsonResponse(array('error' => 'Forced a password but did not specify one.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            if (strcmp($password, '') == 0) {
                $password = null;
            }

            $conn = Database::getInstance();
            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->insert($moduleName)
                ->values(
                    array(
                        'song_id' => '?',
                        'password' => '?',
                        'has_password' => '?',
                        'is_enabled' => '?'
                    )
                )
                ->setParameter(0, $song_id)->setParameter(1, $password)->setParameter(2, $has_password)
                ->setParameter(3, $is_enabled)->execute();

            return $this->getModuleFromDatabase($request, $moduleName, $song_id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(200);
            return $jsr;
        }
    }

    /**
     * Generic function to edit an existing module. NOT AN ENDPOINT.
     *
     * Requires: song_id (passed in through URL), password, has_password, is_enabled
     */
    public function editModuleInDatabase($request, $moduleName, $song_id) {
        if (!is_numeric($song_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric value specified for a numeric field.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if module given belongs to the currently logged in user
        $result = $this->getModuleFromDatabase($request, $moduleName, $song_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        // check post parameters to make sure required fields exist
        $post_parameters = $request->request->all();
        if (array_key_exists('password', $post_parameters) && array_key_exists('has_password', $post_parameters) && array_key_exists('is_enabled', $post_parameters)) {
            $password = $post_parameters['password'];
            $has_password = $post_parameters['has_password'];
            $is_enabled = $post_parameters['is_enabled'];

            if ($has_password == 0 && ($password != '' || $password != null)) {
                $jsr = new JsonResponse(array('error' => 'Specified a password but did not allow a password.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            if ($has_password == 1 && ($password == '' || $password == null)) {
                $jsr = new JsonResponse(array('error' => 'Forced a password but did not specify one.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            $conn = Database::getInstance();
            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->update($moduleName)
                ->set('password', '?')
                ->set('has_password', '?')
                ->set('is_enabled', '?')
                ->where('song_id = ?')
                ->setParameter(3, $song_id)->setParameter(0, $password)->setParameter(1, $has_password)->setParameter(2, $is_enabled)->execute();

            return $this->getModuleFromDatabase($request, $moduleName, $song_id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(200);
            return $jsr;
        }
    }

    /**
     * Generic function to delete a specific module. NOT AN ENDPOINT.
     */
    public function deleteModuleInDatabase($request, $moduleName, $song_id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();

        if (!is_numeric($song_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if module given belongs to the currently logged in user
        $result = $this->getModuleFromDatabase($request, $moduleName, $song_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $queryBuilder->delete($moduleName)->where('song_id = ?')->setParameter(0, $song_id)->execute();

        return new Response();
    }

    /**
     * Returns the CN module
     *
     * @Route("/api/designer/song/{id}/module_cn", name="getModuleCnAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleCN(Request $request, $id) {
        return $this->getModuleFromDatabase($request, 'module_cn', $id);
    }

    /**
     * Creates a CN module
     *
     * @Route("/api/designer/song/{id}/module_cn/create", name="createModuleCnAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function createModuleCN(Request $request, $id) {
        return $this->createModuleInDatabase($request, 'module_cn', $id);
    }

    /**
     * Edits a CN module
     *
     * @Route("/api/designer/song/{id}/module_cn/edit", name="editModuleCnAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function editModuleCN(Request $request, $id) {
        return $this->editModuleInDatabase($request, 'module_cn', $id);
    }

    /**
     * Deletes a CN module
     *
     * @Route("/api/designer/song/{id}/module_cn", name="deleteModuleCnAsDesigner")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteModuleCN(Request $request, $id) {
        return $this->deleteModuleInDatabase($request, 'module_cn', $id);
    }

    /**
     * Returns the DW module
     *
     * @Route("/api/designer/song/{id}/module_dw", name="getModuleDwAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleDW(Request $request, $id) {
        return $this->getModuleFromDatabase($request, 'module_dw', $id);
    }

    /**
     * Creates a DW module
     *
     * @Route("/api/designer/song/{id}/module_dw/create", name="createModuleDwAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function createModuleDW(Request $request, $id) {
        return $this->createModuleInDatabase($request, 'module_dw', $id);
    }

    /**
     * Edits a DW module
     *
     * @Route("/api/designer/song/{id}/module_dw/edit", name="editModuleDwAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function editModuleDW(Request $request, $id) {
        return $this->editModuleInDatabase($request, 'module_dw', $id);
    }

    /**
     * Deletes a DW module
     *
     * @Route("/api/designer/song/{id}/module_dw", name="deleteModuleDwAsDesigner")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteModuleDW(Request $request, $id) {
        return $this->deleteModuleInDatabase($request, 'module_dw', $id);
    }

    /**
     * Returns the GE module
     *
     * @Route("/api/designer/song/{id}/module_ge", name="getModuleGeAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleGE(Request $request, $id) {
        return $this->getModuleFromDatabase($request, 'module_ge', $id);
    }

    /**
     * Creates a GE module
     *
     * @Route("/api/designer/song/{id}/module_ge/create", name="createModuleGeAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function createModuleGE(Request $request, $id) {
        return $this->createModuleInDatabase($request, 'module_ge', $id);
    }

    /**
     * Edits a GE module
     *
     * @Route("/api/designer/song/{id}/module_ge/edit", name="editModuleGeAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function editModuleGE(Request $request, $id) {
        return $this->editModuleInDatabase($request, 'module_ge', $id);
    }

    /**
     * Deletes a GE module
     *
     * @Route("/api/designer/song/{id}/module_ge", name="deleteModuleGeAsDesigner")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteModuleGE(Request $request, $id) {
        return $this->deleteModuleInDatabase($request, 'module_ge', $id);
    }

    /**
     * Returns the LS module
     *
     * @Route("/api/designer/song/{id}/module_ls", name="getModuleLsAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleLS(Request $request, $id) {
        return $this->getModuleFromDatabase($request, 'module_ls', $id);
    }

    /**
     * Creates a LS module
     *
     * @Route("/api/designer/song/{id}/module_ls/create", name="createModuleLsAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function createModuleLS(Request $request, $id) {
        return $this->createModuleInDatabase($request, 'module_ls', $id);
    }

    /**
     * Edits a LS module
     *
     * @Route("/api/designer/song/{id}/module_ls/edit", name="editModuleLsAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function editModuleLS(Request $request, $id) {
        return $this->editModuleInDatabase($request, 'module_ls', $id);
    }

    /**
     * Deletes a LS module
     *
     * @Route("/api/designer/song/{id}/module_ls", name="deleteModuleLsAsDesigner")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteModuleLS(Request $request, $id) {
        return $this->deleteModuleInDatabase($request, 'module_ls', $id);
    }

    /**
     * Returns the LT module
     *
     * @Route("/api/designer/song/{id}/module_lt", name="getModuleLtAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleLT(Request $request, $id) {
        return $this->getModuleFromDatabase($request, 'module_lt', $id);
    }

    /**
     * Creates a LT module
     *
     * @Route("/api/designer/song/{id}/module_lt/create", name="createModuleLtAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function createModuleLT(Request $request, $id) {
        return $this->createModuleInDatabase($request, 'module_lt', $id);
    }

    /**
     * Edits a LT module
     *
     * @Route("/api/designer/song/{id}/module_lt/edit", name="editModuleLtAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function editModuleLT(Request $request, $id) {
        return $this->editModuleInDatabase($request, 'module_lt', $id);
    }

    /**
     * Deletes a LT module
     *
     * @Route("/api/designer/song/{id}/module_lt", name="deleteModuleLtAsDesigner")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteModuleLT(Request $request, $id) {
        return $this->deleteModuleInDatabase($request, 'module_lt', $id);
    }

    /**
     * Returns the QU module
     *
     * @Route("/api/designer/song/{id}/module_qu", name="getModuleQuAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getModuleQU(Request $request, $id) {
        return $this->getModuleFromDatabase($request, 'module_qu', $id);
    }

    /**
     * Creates a QU module
     *
     * @Route("/api/designer/song/{id}/module_qu/create", name="createModuleQuAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function createModuleQU(Request $request, $id) {
        return $this->createModuleInDatabase($request, 'module_qu', $id);
    }

    /**
     * Edits a QU module
     *
     * @Route("/api/designer/song/{id}/module_qu/edit", name="editModuleQuAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function editModuleQU(Request $request, $id) {
        return $this->editModuleInDatabase($request, 'module_qu', $id);
    }

    /**
     * Deletes a QU module
     *
     * @Route("/api/designer/song/{id}/module_qu", name="deleteModuleQuAsDesigner")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteModuleQU(Request $request, $id) {
        return $this->deleteModuleInDatabase($request, 'module_qu', $id);
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
        $song_id = $id;

        if (!is_numeric($song_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the module belongs to the designer
        $result = $this->getModuleCN($request, $song_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }
        $result = json_decode($result->getContent());
        $module_id = $result->id;

        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('id', 'phrase', 'description', 'link')
            ->from('module_cn_keyword')->where('cn_id = ?')
            ->setParameter(0, $module_id)->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($results), 'data' => $results));
        $jsr->setStatusCode(200);
        return $jsr;
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
        $keyword_id = $id;

        if (!is_numeric($keyword_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // do a whole bunch of joins to see if the currently registered designer has access to this keyword
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('mck.id', 'mck.phrase', 'mck.description', 'mck.link', 'song.id AS song_id')
            ->from('app_users', 'designers')->innerJoin('designers', 'courses', 'courses', 'designers.id = courses.user_id')
            ->innerJoin('courses', 'unit', 'unit', 'unit.course_id = courses.id')
            ->innerJoin('unit', 'song', 'song', 'song.unit_id = unit.id')->innerJoin('song', 'module_cn', 'module_cn', 'song.id = module_cn.song_id')
            ->innerJoin('module_cn', 'module_cn_keyword', 'mck', 'module_cn.id = mck.cn_id')
            ->where('designers.id = ?')->andWhere('mck.id = ?')
            ->setParameter(0, $user_id)->setParameter(1, $keyword_id)->execute()->fetchAll();

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
        $post_parameters = $request->request->all();

        if (array_key_exists('phrase', $post_parameters) && array_key_exists('song_id', $post_parameters)) {
            $phrase = $post_parameters['phrase'];
            $song_id = $post_parameters['song_id'];

            if (!is_numeric($song_id)) {
                $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            // check if song + module cn given belongs to the currently logged in user
            $result = $this->getModuleCN($request, $song_id);
            if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
                return $result;
            }
            $result = json_decode($result->getContent());
            $module_id = $result->id;

            $description = null;
            $link = null;

            if (array_key_exists('description', $post_parameters)) {
                $description = $post_parameters['description'];
            }

            if (array_key_exists('link', $post_parameters)) {
                $link = $post_parameters['link'];
            }

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

            $id = $conn->lastInsertId();
            return $this->getKeyword($request, $id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(200);
            return $jsr;
        }
    }

    /**
     * Creates a new keyword tied to the module_cn of the current song
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
        $post_parameters = $request->request->all();
        $keyword_id = $id;

        if (array_key_exists('phrase', $post_parameters)) {
            $phrase = $post_parameters['phrase'];

            if (!is_numeric($keyword_id)) {
                $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            // check if keyword belongs to currently logged in user
            $result = $this->getKeyword($request, $keyword_id);
            if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
                return $result;
            }

            $description = null;
            $link = null;

            if (array_key_exists('description', $post_parameters)) {
                $description = $post_parameters['description'];
            }

            if (array_key_exists('link', $post_parameters)) {
                $link = $post_parameters['link'];
            }


            $conn = Database::getInstance();

            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->update('module_cn_keyword')
                ->set('phrase', '?')
                ->set('description', '?')
                ->set('link', '?')
                ->where('id = ?')
                ->setParameter(0, $phrase)->setParameter(1, $description)->setParameter(2, $link)->setParameter(3, $keyword_id)->execute();

            return $this->getKeyword($request, $keyword_id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(200);
            return $jsr;
        }
    }

    /**
     * Deletes a specific keyword
     *
     * @Route("/api/designer/keyword/{id}", name="deleteKeywordAsDesigner")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteKeyword(Request $request, $id) {
        $keyword_id = $id;

        if (!is_numeric($keyword_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if keyword belongs to currently logged in user
        $result = $this->getKeyword($request, $keyword_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        // if so, delete the keyword
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $queryBuilder->delete('module_cn_keyword')->where('id = ?')->setParameter(0, $keyword_id)->execute();

        return new Response();
    }

    // ------------ methods below are for media linking for keywords - they should essentially be the SAME functions as the ones in course controller for song ----------

    /**
     * Gets all media that belongs to a keyword
     *
     * @Route("/api/designer/keyword/{id}/media", name="getKeywordMediaAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getKeywordMedia(Request $request, $id) {
        $keyword_id = $id;

        if (!is_numeric($keyword_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the keyword belongs to the designer
        $result = $this->getKeyword($request, $keyword_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

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

    /**
     * Gets all keywords that use a particular piece of media
     *
     * @Route("/api/designer/media/{id}/keyword", name="getMediaKeywordsAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getMediaKeywords(Request $request, $id) {
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
        $results = $queryBuilder->select('mck.id', 'mck.phrase', 'mck.description', 'mck.link')
            ->from('media')->innerJoin('media', 'module_cn_keywords_media', 'mck_media', 'media.id = mck_media.media_id')
            ->innerJoin('mck_media', 'module_cn_keyword', 'mck', 'mck.id = mck_media.module_cn_keyword_id')->where('mck_media.media_id = ?')
            ->setParameter(0, $media_id)->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($results), 'data' => $results));
        $jsr->setStatusCode(200);
        return $jsr;
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

        if (!is_numeric($keyword_id) || !is_numeric($media_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
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
        $post_parameters = $request->request->all();

        if (array_key_exists('keyword_id', $post_parameters) && array_key_exists('media_id', $post_parameters)) {

            $keyword_id = $post_parameters['keyword_id'];
            $media_id = $post_parameters['media_id'];

            if (!is_numeric($keyword_id) || !is_numeric($media_id)) {
                $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            // check if song given belongs to the currently logged in user
            $result = $this->getKeyword($request, $keyword_id);
            if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
                return $result;
            }

            // check if media given belongs to the currently logged in user
            $result = $this->getMedia($request, $media_id);
            if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
                return $result;
            }

            // check if this media link already exists
            $result = $this->getKeywordMediaLink($request, $keyword_id, $media_id);
            if ($result->getStatusCode() >= 200 && $result->getStatusCode() <= 299) {
                $jsr = new JsonResponse(array('error' => 'The link already exists.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

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

            $id = $conn->lastInsertId();
            return $this->getKeywordMediaLink($request, $keyword_id, $media_id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(200);
            return $jsr;
        }
    }

    /**
     * delete a media link
     *
     * @Route("/api/designer/keyword/{keyword_id}/media/{media_id}", name="deleteKeywordMediaLinkAsDesigner")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteKeywordMediaLink(Request $request, $keyword_id, $media_id) {
        if (!is_numeric($keyword_id) || !is_numeric($media_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if media link given belongs to currently logged in user
        $result = $this->getKeywordMediaLink($request, $keyword_id, $media_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $queryBuilder->delete('module_cn_keywords_media')->where('module_cn_keyword_id = ?')->andWhere('media_id = ?')
            ->setParameter(0, $keyword_id)->setParameter(1, $media_id)->execute();

        return new Response();
    }

    // ------------ methods above are for media linking for keywords - they should essentially be the SAME functions as the ones in course controller for song ----------


}