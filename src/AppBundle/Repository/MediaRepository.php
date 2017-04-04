<?php

namespace AppBundle\Repository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Database;


/**
 * MediaRepository
 *
 * Database interaction methods for media
 */
class MediaRepository extends \Doctrine\ORM\EntityRepository
{

    public static function getAllMedia(Request $request, $user_id, $user_type) {
        // a user MUST be a designer to have media that belongs to them
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        // get request parameters
        $request_parameters = $request->query->all();

        // check for optional parameters
        $name = "%%";
        $file_type = "%%";
        if (array_key_exists('name', $request_parameters)) {
            $name = '%' . $request_parameters['name'] . '%';
        }
        if (array_key_exists('file_type', $request_parameters)) {
            $file_type = '%' . $request_parameters['file_type'] . '%';
        }

        // get media that belongs to the user
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('id', 'name', 'filename', 'file_type')
            ->from('media')
            ->where('user_id = ?')
            ->andWhere('name LIKE ?')
            ->andWhere('file_type LIKE ?')
            ->setParameter(0, $user_id)->setParameter(1, $name)->setParameter(2, $file_type)->execute()->fetchAll();

        return new JsonResponse(array('size' => count($results), 'data' => $results));
    }

    public static function getMedia(Request $request, $user_id, $user_type, $file_id) {
        // a user MUST be a designer to have media that belongs to them
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        // make sure file id is numeric
        if (!is_numeric($file_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the file belongs to the user
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

    public static function createMedia(Request $request, $user_id, $user_type) {
        // a user MUST be a designer to upload media
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        // get post parameters (and uploaded file)
        $post_parameters = $request->request->all();
        $file_post_parameters = $request->files->all();
        if (array_key_exists('file', $file_post_parameters)) {
            $file = $file_post_parameters['file'];
            $file_type = null;
            $name = null;

            // get file name and extension from here, unless the user overwrote them for some reason
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

            // create a random md5 name for the file
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

            // create the file record in the database
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

            $file_id = $conn->lastInsertId();
            return MediaRepository::getMedia($request, $user_id, $user_type, $file_id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }
    
    public static function editMedia(Request $request, $user_id, $user_type, $file_id) {
        // a user MUST be a designer to edit media
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }
        
        // make sure file id is numeric
        if (!is_numeric($file_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // get post parameters
        $post_parameters = $request->request->all();
        if (array_key_exists('name', $post_parameters)) {
            $name = $post_parameters['name'];

            // check if file given belongs to the currently logged in user
            $result = MediaRepository::getMedia($request, $user_id, $user_type, $file_id);
            if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
                return $result;
            }

            // update the file
            $conn = Database::getInstance();
            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->update('media')
                ->set('name', '?')->where('id = ?')
                ->setParameter(0, $name)->setParameter(1, $file_id)->execute();

            return MediaRepository::getMedia($request, $user_id, $user_type, $file_id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }

    public static function deleteMedia(Request $request, $user_id, $user_type, $file_id) {
        // a user MUST be a designer to delete media
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        // make sure file id is numeric
        if (!is_numeric($file_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if file given belongs to the currently logged in user
        $result = MediaRepository::getMedia($request, $user_id, $user_type, $file_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        // find filename/location of file on server from the database
        $conn = Database::getInstance();
        $result = $conn->createQueryBuilder()->select('filename')->from('media')->where('id = ?')->setParameter(0, $file_id)->execute()->fetchAll();
        $filename = $result[0]['filename'];

        // delete file
        unlink('files/' . $filename);

        // delete record in the database
        $queryBuilder = $conn->createQueryBuilder();
        $queryBuilder->delete('media')->where('id = ?')->setParameter(0, $file_id)->execute();

        return new Response();
    }
}
