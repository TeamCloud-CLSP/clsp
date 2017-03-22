<?php
namespace AppBundle\Repository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Repository\ProfessorRegistrationRepository;
use AppBundle\Database;

/**
 * StudentRegistrationRepository
 *
 * Database interaction methods for student registrations
 */
class StudentRegistrationRepository extends \Doctrine\ORM\EntityRepository
{

    public static function getStudentRegistrationsByProfessorRegistration(Request $request, $user_id, $user_type, $pr_id) {
        // a user MUST be a designer to get student registrations based on their professor registrations
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }
        
        // make sure professor registration is numeric
        if (!is_numeric($pr_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the professor registration belongs to the designer
        $result = ProfessorRegistrationRepository::getProfessorRegistration($request, $user_id, $user_type, $pr_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }
        
        // get the student registrations that belong to the professor registration
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $result = $queryBuilder->select('sr.id', 'sr.name', 'sr.date_created', 'sr.date_deleted', 'sr.date_start', 'sr.date_end', 'sr.signup_code')
            ->from('app_users', 'designers')
            ->innerJoin('designers', 'professor_registrations', 'pr', 'designers.id = pr.owner_id')
            ->innerJoin('pr', 'student_registrations', 'sr', 'sr.prof_registration_id = pr.id')
            ->where('designers.id = ?')->andWhere('pr.id = ?')
            ->setParameter(0, $user_id)->setParameter(1, $pr_id)->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($result), 'data' => $result));
        $jsr->setStatusCode(200);
        return $jsr;
    }
}