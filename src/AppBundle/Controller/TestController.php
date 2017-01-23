<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 1/23/2017
 * Time: 11:27 AM
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class TestController extends Controller
{
    /**
     * @Route("/ass")
     * @return Response
     */
    public function getAction() {
        return new Response("hello");
    }
}