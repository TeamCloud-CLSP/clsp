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
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $c = Helper::getAppUsersColumns();
        $result = $queryBuilder->select($c['id'], $c['username'], $c['email'], $c['is_active'], $c['date_created'], $c['date_deleted'], $c['date_start'], $c['date_end'],
            $c['timezone'], $c['is_student'], $c['is_professor'], $c['is_designer'], $c['is_administrator'])
            ->from('app_users')->where('id = ?')->setParameter(0, $user_id)->execute()->fetch();
        $result['is_student']       = ($result['is_student'] == "0" ? false : true);
        $result['is_professor']     = ($result['is_professor'] == "0" ? false : true);
        $result['is_designer']      = ($result['is_designer'] == "0" ? false : true);
        $result['is_administrator'] = ($result['is_administrator'] == "0" ? false : true);
        $jsr = new JsonResponse($result);
        $jsr->setStatusCode(200);
        return $jsr;
    }
}
