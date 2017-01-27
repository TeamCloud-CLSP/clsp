<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class AdministratorController extends Controller
{
    /**
     * @Route("/admin/", name="adminIndex")
     */
    public function indexAction(Request $request)
    {
        return $this->render('administrator/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'..').DIRECTORY_SEPARATOR,
        ]);
    }
}
