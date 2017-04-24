<?php

namespace AppBundle\Repository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Database;
use AppBundle\Repository\SongRepository;

/**
 * ModuleRepository
 *
 * Database interaction methods for generic module entities
 */
class ModuleRepository extends \Doctrine\ORM\EntityRepository
{

    public static function getModule(Request $request, $user_id, $user_type, $moduleName, $song_id) {
        // make sure song id is numeric
        if (!is_numeric($song_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // query to get the module info from the database
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = null;
        $select_fields = ['module.id', 'module.password', 'module.has_password', 'module.song_id', 'module.name', 'module.is_enabled', 'module.song_enabled', 'song.id AS song_id'];
        if (strcmp($moduleName, 'module_ls') == 0) {
            array_push($select_fields, 'module.description');
        }
        if (strcmp($user_type, 'designer') == 0) { // if designer, make sure that the designer owns the song and module being accessed
            $results = $queryBuilder->select($select_fields)
                ->from('app_users', 'designers')->innerJoin('designers', 'courses', 'courses', 'designers.id = courses.user_id')
                ->innerJoin('courses', 'unit', 'unit', 'unit.course_id = courses.id')
                ->innerJoin('unit', 'song', 'song', 'song.unit_id = unit.id')
                ->innerJoin('song', $moduleName, 'module', 'song.id = module.song_id')
                ->where('designers.id = ?')->andWhere('song.id = ?')
                ->setParameter(0, $user_id)->setParameter(1, $song_id)->execute()->fetchAll();
        } else if (strcmp($user_type, 'professor') == 0) {
            $results = $queryBuilder->select($select_fields)
                ->from('professor_registrations', 'pr')->innerJoin('pr', 'courses', 'courses', 'pr.course_id = courses.id')
                ->innerJoin('courses', 'unit', 'unit', 'unit.course_id = courses.id')
                ->innerJoin('unit', 'song', 'song', 'song.unit_id = unit.id')
                ->innerJoin('song', $moduleName, 'module', 'song.id = module.song_id')
                ->where('pr.professor_id = ?')->andWhere('pr.date_start < ?')->andWhere('pr.date_end > ?')->andWhere('song.id = ?')
                ->setParameter(0, $user_id)->setParameter(1, time())->setParameter(2, time())->setParameter(3, $song_id)->execute()->fetchAll();
        } else if (strcmp($user_type, 'student') == 0) {
            $results = $queryBuilder->select($select_fields)
                ->from('app_users', 'students')->innerJoin('students', 'student_registrations', 'sr', 'students.student_registration_id = sr.id')
                ->innerJoin('sr', 'classes', 'classes', 'sr.class_id = classes.id')
                ->innerJoin('classes', 'courses', 'courses', 'classes.course_id = courses.id')
                ->innerJoin('courses', 'unit', 'unit', 'unit.course_id = courses.id')
                ->innerJoin('unit', 'song', 'song', 'song.unit_id = unit.id')
                ->innerJoin('song', $moduleName, 'module', 'song.id = module.song_id')
                ->where('students.id = ?')->andWhere('sr.date_start < ?')->andWhere('sr.date_end > ?')->andWhere('song.id = ?')
                ->andWhere('module.is_enabled = 1')
                ->setParameter(0, $user_id)->setParameter(1, time())->setParameter(2, time())->setParameter(3, $song_id)->execute()->fetchAll();
        } else {
            $jsr = new JsonResponse(array('error' => 'Internal server error.'));
            $jsr->setStatusCode(500);
            return $jsr;
        }

        // check for invalid results
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

    // method deprecated
    public static function createModule(Request $request, $user_id, $user_type, $moduleName, $song_id) {
        // a user MUST be a designer to create a module
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        // make sure song id is numeric
        if (!is_numeric($song_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric value specified for a numeric field.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if song given belongs to the currently logged in user
        $result = SongRepository::getSong($request, $user_id, $user_type, $song_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        // check to make sure the same module doesn't already exist for this song
        $result = ModuleRepository::getModule($request, $user_id, $user_type, $moduleName, $song_id);
        if ($result->getStatusCode() > 199 && $result->getStatusCode() < 300) {
            $jsr = new JsonResponse(array('error' => 'A module of this type already exists for this song.'));
            $jsr->setStatusCode(500);
            return $jsr;
        }

        // check post parameters to make sure required fields exist
        $post_parameters = $request->request->all();
        if (array_key_exists('password', $post_parameters) && array_key_exists('has_password', $post_parameters) && array_key_exists('is_enabled', $post_parameters)
            && array_key_exists('song_enabled', $post_parameters)) {
            $password = $post_parameters['password'];
            $has_password = $post_parameters['has_password'];
            $is_enabled = $post_parameters['is_enabled'];
            $song_enabled = $post_parameters['song_enabled'];
            $name = null;

            // do some password logic checking (can't require a password but give no password, can't not have a password but set a password)
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

            // check case where password is empty string, default it to null
            if (strcmp($password, '') == 0) {
                $password = null;
            }

            // makes sure numeric fields are numeric
            if (!is_numeric($is_enabled) || !is_numeric($song_enabled)) {
                $jsr = new JsonResponse(array('error' => 'Expected a numeric value.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            // check for optional parameters
            if (array_key_exists('name', $post_parameters)) {
                $name = $post_parameters['name'];
            }

            $description = null;
            if (strcmp($moduleName, 'module_ls') == 0) {
                if (array_key_exists('description', $post_parameters)) {
                    $description = $post_parameters['description'];
                }
                // create the module
                $conn = Database::getInstance();
                $queryBuilder = $conn->createQueryBuilder();
                $queryBuilder->insert($moduleName)
                    ->values(
                        array(
                            'song_id' => '?',
                            'password' => '?',
                            'has_password' => '?',
                            'is_enabled' => '?',
                            'name' => '?',
                            'song_enabled' => '?',
                            'description' => '?'
                        )
                    )
                    ->setParameter(0, $song_id)->setParameter(1, $password)->setParameter(2, $has_password)
                    ->setParameter(3, $is_enabled)->setParameter(4, $name)->setParameter(5, $song_enabled)
                    ->setParameter(6, $description)->execute();

                // return the newly created module
                return ModuleRepository::getModule($request, $user_id, $user_type, $moduleName, $song_id);
            } else {
                // create the module
                $conn = Database::getInstance();
                $queryBuilder = $conn->createQueryBuilder();
                $queryBuilder->insert($moduleName)
                    ->values(
                        array(
                            'song_id' => '?',
                            'password' => '?',
                            'has_password' => '?',
                            'is_enabled' => '?',
                            'name' => '?',
                            'song_enabled' => '?'
                        )
                    )
                    ->setParameter(0, $song_id)->setParameter(1, $password)->setParameter(2, $has_password)
                    ->setParameter(3, $is_enabled)->setParameter(4, $name)->setParameter(5, $song_enabled)->execute();

                // return the newly created module
                return ModuleRepository::getModule($request, $user_id, $user_type, $moduleName, $song_id);
            }

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }

    public static function editModule(Request $request, $user_id, $user_type, $moduleName, $song_id) {
        // a user MUST be a designer to create a module
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        // make sure song id is numeric
        if (!is_numeric($song_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric value specified for a numeric field.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if module given belongs to the currently logged in user
        $result = ModuleRepository::getModule($request, $user_id, $user_type, $moduleName, $song_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        // check post parameters to make sure required fields exist
        $post_parameters = $request->request->all();
        if (array_key_exists('password', $post_parameters) && array_key_exists('has_password', $post_parameters) && array_key_exists('is_enabled', $post_parameters)
            && array_key_exists('song_enabled', $post_parameters)) {
            $password = $post_parameters['password'];
            $has_password = $post_parameters['has_password'];
            $is_enabled = $post_parameters['is_enabled'];
            $song_enabled = $post_parameters['song_enabled'];
            $name = null;

            // check password requirements/consistency
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

            // makes sure numeric fields are numeric
            if (!is_numeric($is_enabled) || !is_numeric($song_enabled)) {
                $jsr = new JsonResponse(array('error' => 'Expected a numeric value.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            // check for optional parameters
            if (array_key_exists('name', $post_parameters)) {
                $name = $post_parameters['name'];
            }

            $description = null;
            if (strcmp($moduleName, 'module_ls') == 0) {
                if (array_key_exists('description', $post_parameters)) {
                    $description = $post_parameters['description'];
                }
                // update the module in the database
                $conn = Database::getInstance();
                $queryBuilder = $conn->createQueryBuilder();
                $queryBuilder->update($moduleName)
                    ->set('password', '?')
                    ->set('has_password', '?')
                    ->set('is_enabled', '?')
                    ->set('name', '?')
                    ->set('song_enabled', '?')
                    ->set('description', '?')
                    ->where('song_id = ?')
                    ->setParameter(6, $song_id)->setParameter(0, $password)->setParameter(1, $has_password)
                    ->setParameter(3, $name)->setParameter(2, $is_enabled)->setParameter(4, $song_enabled)
                    ->setParameter(5, $description)->execute();

                // return the updated module information
                return ModuleRepository::getModule($request, $user_id, $user_type, $moduleName, $song_id);

            } else {
                // update the module in the database
                $conn = Database::getInstance();
                $queryBuilder = $conn->createQueryBuilder();
                $queryBuilder->update($moduleName)
                    ->set('password', '?')
                    ->set('has_password', '?')
                    ->set('is_enabled', '?')
                    ->set('name', '?')
                    ->set('song_enabled', '?')
                    ->where('song_id = ?')
                    ->setParameter(5, $song_id)->setParameter(0, $password)->setParameter(1, $has_password)
                    ->setParameter(3, $name)->setParameter(2, $is_enabled)->setParameter(4, $song_enabled)->execute();

                // return the updated module information
                return ModuleRepository::getModule($request, $user_id, $user_type, $moduleName, $song_id);
            }
        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }
    
    public static function deleteModule(Request $request, $user_id, $user_type, $moduleName, $song_id) {
        // a user MUST be a designer to create a module
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

        // check if module given belongs to the currently logged in user
        $result = ModuleRepository::getModule($request, $user_id, $user_type, $moduleName, $song_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        // delete the module from the database
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $queryBuilder->delete($moduleName)->where('song_id = ?')->setParameter(0, $song_id)->execute();

        return new Response();
    }
}
