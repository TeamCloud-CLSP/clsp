<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Registration;
use AppBundle\Entity\User;
use AppBundle\Tests\Controller\ProfessorControllerTest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use \DateTime;
use \DateTimeZone;

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

        $regInfo = array(
            'dateStart' => new DateTime('@' . time(), new DateTimeZone($this->getUser()->getTimezone())),
            'dateEnd' => new DateTime('@' . time(), new DateTimeZone($this->getUser()->getTimezone()))
        );
        $form = $this->createFormBuilder($regInfo)
            ->add('dateStart', DateTimeType::class)
            ->add('dateEnd', DateTimeType::class)
            ->add('save', SubmitType::class, array('label' => 'Edit Registration'))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $regInfo = $form->getData();
            $registration->setDateStart($regInfo['dateStart']->getTimestamp());
            $registration->setDateEnd($regInfo['dateEnd']->getTimestamp());
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
     * @Route("/professor/registrations/edit/{id}", name="professorRegistrationsEdit")
     */
    public function showRegistrationEditAction(Request $request, $id)
    {
        $registration = $this->getDoctrine()->getRepository('AppBundle:Registration')->findOneById($id);
        $manager = $this->getDoctrine()->getManager();

        $regInfo = array(
            'dateStart' => new DateTime('@' . $registration->getDateStart(), new DateTimeZone($this->getUser()->getTimezone())),
            'dateEnd' => new DateTime('@' . $registration->getDateEnd(), new DateTimeZone($this->getUser()->getTimezone()))
        );
        $form = $this->createFormBuilder($regInfo)
            ->add('dateStart', DateTimeType::class)
            ->add('dateEnd', DateTimeType::class)
            ->add('save', SubmitType::class, array('label' => 'Edit Registration'))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $regInfo = $form->getData();
            $registration->setDateStart($regInfo['dateStart']->getTimestamp());
            $registration->setDateEnd($regInfo['dateEnd']->getTimestamp());
            $users = $registration->getUsers();
            foreach($users as $user) {
                $user->setDateStart($registration->getDateStart());
                $user->setDateEnd($registration->getDateEnd());
            }
            $manager->persist($registration);
            $manager->flush();

            return $this->redirectToRoute('professorRegistrations');
        }

        return $this->render('professor/makeRegistrations.html.twig', array(
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'..').DIRECTORY_SEPARATOR,
            'form' => $form->createView(),
        ));
    }

    private function generateSignupCode() {
        $randString = "";
        for($i = 0; $i < 16; $i++) {
            $randVal = rand(0,35);
            if($randVal > 25) {
                $randString .= $randVal - 26;
            } else {
                $randString .= chr($randVal + 97);
            }
        }
        return $randString;

    }
}
