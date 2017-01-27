<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class StudentController extends Controller
{
    /**
     * @Route("/student/", name="studentIndex")
     */
    public function indexAction(Request $request)
    {
        return $this->render('student/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'..').DIRECTORY_SEPARATOR,
        ]);
    }
}
