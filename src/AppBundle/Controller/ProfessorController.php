<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Registration;
use AppBundle\Tests\Controller\ProfessorControllerTest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ProfessorController extends Controller
{
    /**
     * @Route("/professor/", name="professorIndex")
     */
    public function indexAction(Request $request)
    {
        return $this->render('professor/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/professor/registrations", name="professorRegistrations")
     */
    public function showRegistrationsAction(Request $request)
    {
        //$owned_registrations = $this->getUser()->getOwnedRegistrations();
        return $this->render('professor/registrations.html.twig', array(
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'..').DIRECTORY_SEPARATOR,
        ));
    }

    /**
     * @Route("/professor/registrations/make", name="professorRegistrationsMake")
     */
    public function showRegistrationsMakeAction(Request $request)
    {
        $registration = new Registration();
        $registrationCode = $this->generateSignupCode();
        $manager = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder($registration)
            ->add('dateStart', IntegerType::class)
            ->add('dateEnd', IntegerType::class)
            ->add('save', SubmitType::class, array('label'=> 'Create Signup'))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $registration = $form->getData();
            $registration->setDateCreated(time());
            $registration->setSignupCode($registrationCode);
            $registration->setOwner($this->getUser());
            $manager->persist($registration);
            $manager->flush();

            return $this->render('professor/makeRegistrations.2.html.twig', array(
                'base_dir' => realpath($this->getParameter('kernel.root_dir').'..').DIRECTORY_SEPARATOR,
                'signup_code' => $registrationCode
            ));
        }

        return $this->render('professor/makeRegistrations.html.twig', array(
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'..').DIRECTORY_SEPARATOR,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/professor/registrations/edit/{id}", name="professorRegistrationsMake")
     */
    public function showRegistrationEditAction(Request $request, $id)
    {
        $registration = $this->getDoctrine()->getRepository('AppBundle:Registration')->findOneById($id);
        $manager = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder($registration)
            ->add('dateStart', IntegerType::class)
            ->add('dateEnd', IntegerType::class)
            ->add('save', SubmitType::class, array('label'=> 'Edit Signup'))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $registration = $form->getData();
            $manager->persist($registration);
            $manager->flush();

            return $this->render('professor/makeRegistrations.2.html.twig', array(
                'base_dir' => realpath($this->getParameter('kernel.root_dir').'..').DIRECTORY_SEPARATOR,
                'signup_code' => $registration->getSignupCode()
            ));
        }

        return $this->render('professor/makeRegistrations.html.twig', array(
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'..').DIRECTORY_SEPARATOR,
            'form' => $form->createView(),
        ));
    }

    private function generateSignupCode() {
        $randString = "";
        for($i = 0; $i < 16; $i++) {
            $randVal = rand(0,36);
            if($randVal < 10) {
                $randString .= $randVal;
            } else {
                $randString .= chr($randVal - 10 + 97);
            }
        }
        return $randString;

    }
}
