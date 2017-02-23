<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends Controller
{
    /**
     * @Route("/dashboard", name="dashboardIndex")
     */
    public function indexAction(Request $request)
    {
        $roleChecker = $this->get('security.authorization_checker');
        if ($roleChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirect('http://localhost:3000/admin');
        }

        if ($roleChecker->isGranted('ROLE_DESIGNER')) {
            return $this->redirect('http://localhost:3000/designer/courses');
        }

        if ($roleChecker->isGranted('ROLE_PROFESSOR')) {
            return $this->redirect('http://localhost:3000/professor');
        }

        if ($roleChecker->isGranted('ROLE_STUDENT')) {
            return $this->redirectToRoute('studentIndex');
        }


        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
}
