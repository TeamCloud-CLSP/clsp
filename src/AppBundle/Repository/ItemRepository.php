<?php

namespace AppBundle\Repository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Database;
use AppBundle\Repository\ModuleRepository;
use AppBundle\Repository\HeaderRepository;

/**
 * ItemRepository
 *
 * Database interaction methods for items
 */
class ItemRepository extends \Doctrine\ORM\EntityRepository
{
    public static function getItems(Request $request, $user_id, $user_type, $heading_id) {
        // make sure heading is numeric
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

        // get items that belong to the given header
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('module_question_item.id', 'module_question_item.content', 'module_question_item.type',
            'module_question_item.weight', 'module_question_item.choices', 'module_question_item.answers')
            ->from('module_question_item')
            ->where('module_question_item.heading_id = ?')
            ->setParameter(0, $heading_id)->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($results), 'data' => $results));
        $jsr->setStatusCode(200);
        return $jsr;
    }

    public static function getItem(Request $request, $user_id, $user_type, $item_id) {
        if (!is_numeric($item_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // do a whole bunch of joins to see if the currently registered designer has access to this keyword
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();

        // find the question item we're looking for by id to make sure it exists and to get the header id
        $results = $queryBuilder->select('module_question_item.id', 'module_question_item.content', 'module_question_item.type',
            'module_question_item.weight', 'module_question_item.choices', 'module_question_item.answers', 'heading_id')
            ->from('module_question_item')->where('id = ?')->setParameter(0, $item_id)->execute()->fetchAll();
        if (count($results) < 1) {
            $jsr = new JsonResponse(array('error' => 'Item does not exist or does not belong to the currently authenticated user.'));
            $jsr->setStatusCode(503);
            return $jsr;
        } else if (count($results) > 1) {
            $jsr = new JsonResponse(array('error' => 'An error has occurred. Check for duplicate keys in the database.'));
            $jsr->setStatusCode(500);
            return $jsr;
        }

        $heading_id = $results[0]['heading_id'];

        // do upcall to make sure heading belongs to the current user (semi-recursion, ok in this case since this is the last element down the tree)
        // getHeader function is nonrecursive
        // to be completely honest, having a full recursive system would mean less work for modifying functions based on user classes,
        // but the recursive tree would likely head down too far and would cause problems in the future
        // recursion is being used here just for sanity's sake though
        $result = HeaderRepository::getHeader($request, $user_id, $user_type, $heading_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            $jsr = new JsonResponse(array('error' => 'Item does not exist or does not belong to the currently authenticated user.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        // return the item
        return new JsonResponse($results[0]);
    }

    public static function createItem(Request $request, $user_id, $user_type) {
        // a user MUST be a designer to create an item
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        // get required post parameters
        $post_parameters = $request->request->all();
        if (array_key_exists('heading_id', $post_parameters) && array_key_exists('content', $post_parameters) && array_key_exists('type', $post_parameters)
            && array_key_exists('weight', $post_parameters)) {
            $heading_id = $post_parameters['heading_id'];
            $content = $post_parameters['content'];
            $type = $post_parameters['type'];
            $weight = $post_parameters['weight'];

            if (!is_numeric($heading_id)) {
                $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            // check if header belongs to currently logged in user
            $result = HeaderRepository::getHeader($request, $user_id, $user_type, $heading_id);
            if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
                return $result;
            }

            // get optional post parameters
            $choices = null;
            $answers = null;
            if (array_key_exists('choices', $post_parameters)) {
                $choices = $post_parameters['choices'];
            }

            if (array_key_exists('answers', $post_parameters)) {
                $answers = $post_parameters['answers'];
            }

            // create the new item in the database
            $conn = Database::getInstance();
            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->insert('module_question_item')
                ->values(
                    array(
                        'content' => '?',
                        'type' => '?',
                        'weight' => '?',
                        'choices' => '?',
                        'answers' => '?',
                        'heading_id' => '?'
                    )
                )
                ->setParameter(0, $content)->setParameter(1, $type)->setParameter(2, $weight)->setParameter(3, $choices)
                ->setParameter(4, $answers)->setParameter(5, $heading_id)->execute();

            // return the newly created item from the database
            $item_id = $conn->lastInsertId();
            return ItemRepository::getItem($request, $user_id, $user_type, $item_id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }

    public static function editItem(Request $request, $user_id, $user_type, $item_id) {
        // a user MUST be a designer to edit an item
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        // get required post parameters
        $post_parameters = $request->request->all();
        if (array_key_exists('content', $post_parameters) && array_key_exists('type', $post_parameters)
            && array_key_exists('weight', $post_parameters)) {
            $content = $post_parameters['content'];
            $type = $post_parameters['type'];
            $weight = $post_parameters['weight'];

            if (!is_numeric($item_id)) {
                $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            // check if keyword belongs to currently logged in user
            $result = ItemRepository::getItem($request, $user_id, $user_type, $item_id);
            if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
                return $result;
            }

            // get optional post parameters
            $choices = null;
            $answers = null;
            if (array_key_exists('choices', $post_parameters)) {
                $choices = $post_parameters['choices'];
            }

            if (array_key_exists('answers', $post_parameters)) {
                $answers = $post_parameters['answers'];
            }

            // update object in database
            $conn = Database::getInstance();
            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->update('module_question_item')
                ->set('content', '?')
                ->set('type', '?')
                ->set('weight', '?')
                ->set('choices', '?')
                ->set('answers', '?')
                ->where('id = ?')
                ->setParameter(0, $content)->setParameter(1, $type)->setParameter(2, $weight)->setParameter(3, $choices)
                ->setParameter(4, $answers)->setParameter(5, $item_id)->execute();

            // return the updated item information
            return ItemRepository::getItem($request, $user_id, $user_type, $item_id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }

    public static function deleteItem(Request $request, $user_id, $user_type, $item_id) {
        // a user MUST be a designer to delete an item
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        // make sure item id is numeric
        if (!is_numeric($item_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if keyword belongs to currently logged in user
        $result = ItemRepository::getItem($request, $user_id, $user_type, $item_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        // if so, delete the keyword
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $queryBuilder->delete('module_question_item')->where('id = ?')->setParameter(0, $item_id)->execute();

        return new Response();
    }
    
    public static function getHeaderItemStructure(Request $request, $user_id, $user_type, $moduleName, $module_id_name, $song_id) {
        $result = HeaderRepository::getHeaders($request, $user_id, $user_type, $moduleName, $module_id_name, $song_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        $result = json_decode($result->getContent());
        $headers = $result->data;

        for ($i = 0; $i < count($headers); $i++) {
            $header = $headers[$i];
            $header_id = $header->id;
            $result = ItemRepository::getItems($request, $user_id, $user_type, $header_id);
            if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
                return $result;
            }
            $result = json_decode($result->getContent());
            $header->items = $result->data;
            $header->item_count = $result->size;
        }

        $jsr = new JsonResponse(array('size' => count($headers), 'data' => $headers));
        $jsr->setStatusCode(200);
        return $jsr;
    }
}
