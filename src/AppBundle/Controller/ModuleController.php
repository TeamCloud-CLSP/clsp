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
        $results = $queryBuilder->select('song.id', 'song.title', 'song.album', 'song.artist', 'song.description', 'song.lyrics', 'song.file_name', 'song.file_type', 'song.embed', 'song.weight')
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
        $results = $queryBuilder->select('module.id', 'module.password', 'module.has_password', 'module.song_id')
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
     * Requires: song_id (passed in through URL), password, has_password
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
        if (array_key_exists('password', $post_parameters) && array_key_exists('has_password', $post_parameters)) {
            $password = $post_parameters['password'];
            $has_password = $post_parameters['has_password'];

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
            $queryBuilder->insert($moduleName)
                ->values(
                    array(
                        'song_id' => '?',
                        'password' => '?',
                        'has_password' => '?'
                    )
                )
                ->setParameter(0, $song_id)->setParameter(1, $password)->setParameter(2, $has_password)->execute();

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
     * Requires: song_id (passed in through URL), password, has_password
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
        if (array_key_exists('password', $post_parameters) && array_key_exists('has_password', $post_parameters)) {
            $password = $post_parameters['password'];
            $has_password = $post_parameters['has_password'];

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
                ->where('song_id = ?')
                ->setParameter(2, $song_id)->setParameter(0, $password)->setParameter(1, $has_password)->execute();

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


}