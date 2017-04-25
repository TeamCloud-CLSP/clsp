<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\Connection;
use AppBundle\Database;
use AppBundle\Repository\UserRepository;

class AccountController extends Controller
{
    /**
     * Returns basic account information of the logged in user.
     * @Route("/api/account", name="getAccountInformation")
     * @Method({"GET", "Options"})
     */
    public function getAccountInformation(Request $request)
    {
        // check if valid user is logged in
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $jsr = new JsonResponse(array("error" => "User is not authenticated."));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return UserRepository::getUser($request, $user_id);
    }

    /**
     * Edits account info of logged in user (requires email and name, password optional - if not supplied, it will not be changed
     * @Route("/api/account", name="editAccountInformation")
     * @Method({"POST", "Options"})
     */
    public function editAccount(Request $request) {
        // check if valid user is logged in
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $jsr = new JsonResponse(array("error" => "User is not authenticated."));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $encoder = $this->container->get('security.password_encoder');
        return UserRepository::editUser($request, $user, $encoder);
    }
}
