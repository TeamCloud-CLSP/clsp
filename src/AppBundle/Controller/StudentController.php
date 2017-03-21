<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Tests\Controller\ProfessorControllerTest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use \DateTime;
use \DateTimeZone;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Database;

/**
 * Methods:
 * 
 * getClass - /api/student/class
 * 
 * Class StudentController
 * @package AppBundle\Controller
 */
class StudentController extends Controller
{
    /**
     * Gets information on the class the student belongs to
     *
     * @Route("/api/student/class", name="getClassAsStudent")
     * @Method({"GET", "OPTIONS"})
     */
    public function getClass(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();

        // runs query to get the class specified
        $conn = $this->get('app.database')->getConn();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('classes.id', 'classes.name')
            ->from('app_users', 'students')->innerJoin('students', 'student_registrations', 'sr', 'students.student_registration_id = sr.id')
            ->innerJoin('sr', 'classes', 'classes', 'sr.class_id = classes.id')
            ->where('students.id = ?')->andWhere('sr.date_start < ?')->andWhere('sr.date_end > ?')
            ->setParameter(0, $user_id)->setParameter(1, time())->setParameter(2, time())->execute()->fetchAll();

        // if nothing was returned, give error. if multiple results, also give error (each key should be unique)
        if (count($results) < 1) {
            $jsr = new JsonResponse(array('error' => 'Class does not exist, or has expired.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        return new JsonResponse($results[0]);
    }
}
