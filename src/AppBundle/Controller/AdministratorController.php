<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Database;
use AppBundle\Entity\User;

/**
 * Methods:
 *
 * getUsers - /api/admin/users - can filter by a username parameter
 * getUser - /api/admin/users/{id}
 * deleteUser - /api/admin/users/{id} (DELETE)
 * createDesigner - /api/admin/designer (POST) - takes in username, password, email - the admin must tell the designer their password
 *
 * Class AdministratorController
 * @package AppBundle\Controller
 */
class AdministratorController extends Controller
{

    /**
     * Gets a list of all non-admin users
     *
     * Can filter by username or name
     *
     * @Route("/api/admin/users", name="getUsersAsAdministrator")
     * @Method({"GET", "OPTIONS"})
     */
    public function getUsers(Request $request) {
        $request_parameters = $request->query->all();

        // gets the name parameter from request parameters, or just leaves it as double wildcard
        $username = "%%";
        $name = "%%";
        if (array_key_exists('username', $request_parameters)) {
            $username = '%' . $request_parameters['username'] . '%';
        }

        if (array_key_exists('name', $request_parameters)) {
            $name = '%' . $request_parameters['name'] . '%';
        }

        $conn = $this->get('app.database')->getConn();
        $queryBuilder = $conn->createQueryBuilder();
        $result = $queryBuilder->select('id', 'username', 'name', 'email', 'is_active', 'date_created', 'date_deleted', 'date_start', 'date_end', 'timezone', 'is_student', 'is_professor', 'is_designer', 'is_administrator')
            ->from('app_users', 'users')
            ->where('users.username LIKE ?')->andWhere('users.is_administrator = 0')->andWhere('users.name LIKE ?')
            ->setParameter(0, $username)->setParmameter(1, $name)->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($result), 'data' => $result));
        return $jsr;
    }

    /**
     * Gets information on a specific user
     *
     * @Route("/api/admin/users/{id}", name="getUserAsAdministrator")
     * @Method({"GET", "OPTIONS"})
     */
    public function getUserAsAdmin(Request $request, $id) {
        $user_id = $id;

        // makes sure that the user id is numeric
        if (!is_numeric($user_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        $conn = $this->get('app.database')->getConn();
        $queryBuilder = $conn->createQueryBuilder();
        $result = $queryBuilder->select('id', 'username', 'name', 'email', 'is_active', 'date_created', 'date_deleted', 'date_start', 'date_end', 'timezone', 'is_student', 'is_professor', 'is_designer', 'is_administrator')
            ->from('app_users', 'users')
            ->where('users.id = ?')->andWhere('users.is_administrator = 0')
            ->setParameter(0, $user_id)->execute()->fetchAll();

        if (count($result) < 1) {
            $jsr = new JsonResponse(array('error' => 'The user does not exist, or is an administrator.'));
            $jsr->setStatusCode(500);
            return $jsr;
        }

        $jsr = new JsonResponse($result[0]);
        return $jsr;
    }

    /**
     * Deletes a user by id
     *
     * @Route("/api/admin/users/{id}", name="deleteUsersAsAdministrator")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteUser(Request $request, $id) {
        $user_id = $id;

        // makes sure that the user id is numeric
        if (!is_numeric($user_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
        $conn = $this->get('app.database')->getConn();
        $queryBuilder = $conn->createQueryBuilder();
        $result = $queryBuilder->select('id', 'username', 'email', 'is_active', 'date_created', 'date_deleted', 'date_start', 'date_end', 'timezone', 'is_student', 'is_professor', 'is_designer', 'is_administrator')
            ->from('app_users', 'users')
            ->where('users.id = ?')->andWhere('users.is_administrator = 0')
            ->setParameter(0, $user_id)->execute()->fetchAll();

        if (count($result) < 1) {
            $jsr = new JsonResponse(array('error' => 'The user does not exist, or is an administrator.'));
            $jsr->setStatusCode(500);
            return $jsr;
        }

        $queryBuilder = $conn->createQueryBuilder();
        $queryBuilder->delete('app_users')->where('app_users.id = ?')
            ->setParameter(0, $user_id)->execute();

        return new Response();
    }

    /**
     * Creates a designer account
     * 
     * Takes: username, password, email, name
     * 
     * @Route("/api/admin/designer", name="createDesignerAsAdministrator")
     * @Method({"POST", "OPTIONS"})
     * @return mixed
     * @param Request $request
     */
    public function createDesigner(Request $request) {
        $encoder = $this->container->get('security.password_encoder');
        $post_parameters = $request->request->all();
        if (array_key_exists('username', $post_parameters) && array_key_exists('password', $post_parameters) && array_key_exists('email', $post_parameters) && array_key_exists('name', $post_parameters)) {
            $conn = $this->get('app.database')->getConn();
            $username = $post_parameters['username'];
            $password = $post_parameters['password'];
            $email = $post_parameters['email'];
            $name = $post_parameters['name'];
            $user = new User();

            // check to make sure username and email are unique
            $queryBuilder = $conn->createQueryBuilder();
            $results = $queryBuilder->select('users.id')->from('app_users', 'users')->where('users.username = ?')
                ->orWhere('users.email = ?')
                ->setParameter(0, $username)->setParameter(1, $email)->execute()->fetchAll();
            if (count($results) > 0) {
                $jsr = new JsonResponse(array('error' => 'The username or email already exists.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            // create the designer account
            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->insert('app_users')
                ->values(
                    array(
                        'username' => '?',
                        'password' => '?',
                        'email' => '?',
                        'is_active' => '?',
                        'date_created' => '?',
                        'date_start' => '?',
                        'date_end' => '?',
                        'timezone' => '?',
                        'is_student' => '?',
                        'is_professor' => '?',
                        'is_designer' => '?',
                        'is_administrator' => '?',
                        'name' => '?'
                    )
                )
                ->setParameter(0, $username)->setParameter(1, $encoder->encodePassword($user, $password))->setParameter(2, $email)->setParameter(3, 1)->setParameter(4, time())
                ->setParameter(5, time())->setParameter(6, time() + 365*24*60*60)->setParameter(7, date_default_timezone_get())
                ->setParameter(8, 0)->setParameter(9, 0)->setParameter(10, 1)->setParameter(11, 0)->setParameter(12, $name)->execute();

            $student_id = $conn->lastInsertId();

            $queryBuilder = $conn->createQueryBuilder();
            $results = $queryBuilder->select('id', 'username', 'name', 'email', 'is_active', 'date_created', 'date_deleted', 'date_start', 'date_end', 'timezone', 'is_student', 'is_professor', 'is_designer', 'is_administrator')
                ->from('app_users', 'users')->where('users.id = ?')->setParameter(0, $student_id)->execute()->fetchAll();
            if (count($results) < 1) {
                $jsr = new JsonResponse(array('error' => 'An error upon account creation has occurred.'));
                $jsr->setStatusCode(500);
                return $jsr;
            }
            return new JsonResponse($results[0]);
            
        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        
        
        
    }

//    /**
//     * @Route("/admin/", name="adminIndex")
//     */
//    public function indexAction(Request $request)
//    {
//        return $this->render('administrator/index.html.twig', [
//            'base_dir' => realpath($this->getParameter('kernel.root_dir').'..').DIRECTORY_SEPARATOR,
//        ]);
//    }
}
