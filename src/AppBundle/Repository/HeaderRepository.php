<?php

namespace AppBundle\Repository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Database;
use AppBundle\Repository\ModuleRepository;
use AppBundle\Repository\SongRepository;

/**
 * HeaderRepository
 *
 * Database interaction methods for headings
 */
class HeaderRepository extends \Doctrine\ORM\EntityRepository
{
    public static function getHeaders(Request $request, $user_id, $user_type, $moduleName, $module_id_name, $song_id) {
        // make sure song id is numeric
        if (!is_numeric($song_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the module belongs to or is accessible to the current user
        $result = ModuleRepository::getModule($request, $user_id, $user_type, $moduleName, $song_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('module_question_heading.id', 'module_question_heading.name')
            ->from('song')->innerJoin('song', $moduleName, 'module', 'song.id = module.song_id')
            ->innerJoin('module', 'module_question_heading', 'module_question_heading', 'module.id = module_question_heading.' . $module_id_name)
            ->where('song.id = ?')
            ->setParameter(0, $song_id)->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($results), 'data' => $results));
        $jsr->setStatusCode(200);
        return $jsr;
    }
    
    public static function getHeader(Request $request, $user_id, $user_type, $heading_id) {
        // make sure heading id is numeric
        if (!is_numeric($heading_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // do a whole bunch of joins to see if the currently registered designer has access to this keyword
        $conn = Database::getInstance();

        // first, find the heading that the user is looking for
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('module_question_heading.id', 'module_question_heading.name', 'dw_id', 'ge_id', 'ls_id', 'lt_id', 'qu_id')
            ->from('module_question_heading')->where('id = ?')->setParameter(0, $heading_id)->execute()->fetchAll();
        if (count($results) < 1) {
            $jsr = new JsonResponse(array('error' => 'Heading does not exist or does not belong to the currently authenticated user.'));
            $jsr->setStatusCode(503);
            return $jsr;
        } else if (count($results) > 1) {
            $jsr = new JsonResponse(array('error' => 'An error has occurred. Check for duplicate keys in the database.'));
            $jsr->setStatusCode(500);
            return $jsr;
        }

        // now, if it exists, find what module it belongs to
        $hits = 0;
        $moduleName = null;
        $module_id_name = null;
        $module_id_list = ['dw_id', 'ge_id', 'ls_id', 'lt_id', 'qu_id'];
        $module_name_list = ['module_dw', 'module_ge', 'module_ls', 'module_lt', 'module_qu'];
        // determine the module type so we know what to join on in the up-chain
        for ($i = 0; $i < count($module_id_list); $i++) {
            $check = $module_id_list[$i];
            if ($results[0][$check] != null) {
                $moduleName = $module_name_list[$i];
                $module_id_name = $check;
            }
        }

        if ($hits > 1) {
            $jsr = new JsonResponse(array('error' => 'An error has occurred. Check for duplicate keys in the database.'));
            $jsr->setStatusCode(500);
            return $jsr;
        }

        // now, make sure the heading belongs to the user
        $queryBuilder = $conn->createQueryBuilder();
        $results = null;
        if (strcmp($user_type, 'designer') == 0) { // if designer, make sure that the designer owns the heading
            $results = $queryBuilder->select('module_question_heading.id', 'module_question_heading.name', 'song.id AS song_id')
                ->from('app_users', 'designers')->innerJoin('designers', 'courses', 'courses', 'designers.id = courses.user_id')
                ->innerJoin('courses', 'unit', 'unit', 'unit.course_id = courses.id')
                ->innerJoin('unit', 'song', 'song', 'song.unit_id = unit.id')
                ->innerJoin('song', $moduleName, 'module', 'song.id = module.song_id')
                ->innerJoin('module', 'module_question_heading', 'module_question_heading', 'module.id = module_question_heading.' . $module_id_name)
                ->where('designers.id = ?')->andWhere('module_question_heading.id = ?')
                ->setParameter(0, $user_id)->setParameter(1, $heading_id)->execute()->fetchAll();
        } else if (strcmp($user_type, 'professor') == 0) {
            $results = $queryBuilder->select('module_question_heading.id', 'module_question_heading.name', 'song.id AS song_id')
                ->from('professor_registrations', 'pr')->innerJoin('pr', 'courses', 'courses', 'pr.course_id = courses.id')
                ->innerJoin('courses', 'unit', 'unit', 'unit.course_id = courses.id')
                ->innerJoin('unit', 'song', 'song', 'song.unit_id = unit.id')
                ->innerJoin('song', $moduleName, 'module', 'song.id = module.song_id')
                ->innerJoin('module', 'module_question_heading', 'module_question_heading', 'module.id = module_question_heading.' . $module_id_name)
                ->where('pr.professor_id = ?')->andWhere('pr.date_start < ?')->andWhere('pr.date_end > ?')->andWhere('module_question_heading.id = ?')
                ->setParameter(0, $user_id)->setParameter(1, time())->setParameter(2, time())->setParameter(3, $heading_id)->execute()->fetchAll();
        } else {
            $jsr = new JsonResponse(array('error' => 'Internal server error.'));
            $jsr->setStatusCode(500);
            return $jsr;
        }

        // check for invalid response
        if (count($results) < 1) {
            $jsr = new JsonResponse(array('error' => 'Heading does not exist or does not belong to the currently authenticated user.'));
            $jsr->setStatusCode(503);
            return $jsr;
        } else if (count($results) > 1) {
            $jsr = new JsonResponse(array('error' => 'An error has occurred. Check for duplicate keys in the database.'));
            $jsr->setStatusCode(500);
            return $jsr;
        }
        $results[0]['module_name'] = $moduleName;
        return new JsonResponse($results[0]);
    }

    public static function createHeader(Request $request, $user_id, $user_type, $moduleName, $module_id_name, $song_id) {
        // a user MUST be a designer to create a header
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        // get post parameters
        $post_parameters = $request->request->all();
        if (array_key_exists('name', $post_parameters)) {
            $name = $post_parameters['name'];

            if (!is_numeric($song_id)) {
                $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            // check if module we're looking for exists and belongs to the currently logged in user
            $result = ModuleRepository::getModule($request, $user_id, $user_type, $moduleName, $song_id);
            if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
                return $result;
            }

            // get the module id out from the result
            $result = json_decode($result->getContent());
            $module_id = $result->id;

            // create the header
            $conn = Database::getInstance();
            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->insert('module_question_heading')
                ->values(
                    array(
                        'name' => '?',
                        $module_id_name => '?'
                    )
                )
                ->setParameter(0, $name)->setParameter(1, $module_id)->execute();

            $header_id = $conn->lastInsertId();
            return HeaderRepository::getHeader($request, $user_id, $user_type, $header_id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }

    public static function editHeader(Request $request, $user_id, $user_type, $heading_id) {
        // a user MUST be a designer to edit a header
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        // get post parameters
        $post_parameters = $request->request->all();
        if (array_key_exists('name', $post_parameters)) {
            $name = $post_parameters['name'];

            if (!is_numeric($heading_id)) {
                $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            // check if keyword belongs to currently logged in user
            $result = HeaderRepository::getHeader($request, $user_id, $user_type, $heading_id);
            if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
                return $result;
            }

            // update the heading in the database
            $conn = Database::getInstance();
            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->update('module_question_heading')
                ->set('name', '?')
                ->where('id = ?')
                ->setParameter(0, $name)->setParameter(1, $heading_id)->execute();

            return HeaderRepository::getHeader($request, $user_id, $user_type, $heading_id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }

    public static function deleteHeader(Request $request, $user_id, $user_type, $heading_id) {
        if (!is_numeric($heading_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if keyword belongs to currently logged in user
        $result = HeaderRepository::getHeader($request, $user_id, $user_type, $heading_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        // if so, delete the keyword
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $queryBuilder->delete('module_question_heading')->where('id = ?')->setParameter(0, $heading_id)->execute();

        return new Response();
    }
}
