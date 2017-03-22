<?php
namespace AppBundle\Repository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Repository\CourseRepository;
use AppBundle\Database;

/**
 * ProfessorRegistrationRepository
 *
 * Database interaction methods for professor registrations
 */
class ProfessorRegistrationRepository extends \Doctrine\ORM\EntityRepository
{
    
    public static function getProfessorRegistrations(Request $request, $user_id, $user_type) {
        // gets the connection for the query
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = null;
        if (strcmp($user_type, 'designer') == 0) { // if user is a designer, get the professor registrations that the designer created
            $results = $queryBuilder->select('pr.id', 'pr.date_created', 'pr.date_deleted', 'pr.date_start', 'pr.date_end', 'pr.signup_code',
                'professors.id AS professor_id', 'professors.username AS professor_username', 'professors.name AS professor_name',
                'courses.id AS course_id', 'courses.name AS course_name', 'courses.description AS course_description', 'language.name AS language_name')
                ->from('app_users', 'designers')
                ->innerJoin('designers', 'professor_registrations', 'pr', 'designers.id = pr.owner_id')
                ->leftJoin('pr', 'app_users', 'professors', 'pr.professor_id = professors.id')
                ->innerJoin('pr', 'courses', 'courses', 'pr.course_id = courses.id')->innerJoin('courses', 'language', 'language', 'courses.language_id = language.id')
                ->where('designers.id = ?')
                ->setParameter(0, $user_id)->execute()->fetchAll();
        } else if (strcmp($user_type, 'professor') == 0) {
            $results = $queryBuilder->select('pr.id', 'pr.date_created', 'pr.date_deleted', 'pr.date_start', 'pr.date_end', 'pr.signup_code',
                'designers.id AS designers', 'designers.username AS designers_username', 'designers.name AS designers_name',
                'courses.id AS course_id', 'courses.name AS course_name', 'courses.description AS course_description')
                ->from('app_users', 'professors')
                ->innerJoin('professors', 'professor_registrations', 'pr', 'professors.id = pr.professor_id')
                ->innerJoin('pr', 'app_users', 'designers', 'pr.professor_id = designers.id')
                ->innerJoin('pr', 'courses', 'courses', 'pr.course_id = courses.id')
                ->where('professors.id = ?')
                ->setParameter(0, $user_id)->execute()->fetchAll();
        } else {
            $jsr = new JsonResponse(array('error' => 'Internal server error.'));
            $jsr->setStatusCode(500);
            return $jsr;
        }

        $jsr = new JsonResponse(array('size' => count($results), 'data' => $results));
        $jsr->setStatusCode(200);
        return $jsr;
    }
    
    public static function getProfessorRegistrationsByCourse(Request $request, $user_id, $user_type, $course_id) {
        // a user MUST be a designer to fetch professor registrations by course
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        // make sure course id is numeric
        if (!is_numeric($course_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the course is accessible to the currently logged in user
        $result = CourseRepository::getCourse($request, $user_id, $user_type, $course_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        // get the registrations that apply to the course specified
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('pr.id', 'pr.date_created', 'pr.date_deleted', 'pr.date_start', 'pr.date_end', 'pr.signup_code',
            'professors.id AS professor_id', 'professors.username AS professor_username', 'professors.name AS professor_name',
            'courses.id AS course_id', 'courses.name AS course_name', 'courses.description AS course_description', 'language.name AS language_name')
            ->from('app_users', 'designers')
            ->innerJoin('designers', 'professor_registrations', 'pr', 'designers.id = pr.owner_id')
            ->leftJoin('pr', 'app_users', 'professors', 'pr.professor_id = professors.id')
            ->innerJoin('pr', 'courses', 'courses', 'pr.course_id = courses.id')->innerJoin('courses', 'language', 'language', 'courses.language_id = language.id')
            ->where('designers.id = ?')->andWhere('course_id = ?')
            ->setParameter(0, $user_id)->setParameter(1, $course_id)->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($results), 'data' => $results));
        $jsr->setStatusCode(200);
        return $jsr;
    }
    
    public static function getProfessorRegistration(Request $request, $user_id, $user_type, $pr_id) {
        // make sure professor registration id is numeric
        if (!is_numeric($pr_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // get info on the professor registration
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = null;
        if (strcmp($user_type, 'designer') == 0) { // if user is a designer, check that the designer created the professor registration in question
            $results = $queryBuilder->select('pr.id', 'pr.date_created', 'pr.date_deleted', 'pr.date_start', 'pr.date_end', 'pr.signup_code',
                'professors.id AS professor_id', 'professors.username AS professor_username', 'professors.name AS professor_name',
                'courses.id AS course_id', 'courses.name AS course_name', 'courses.description AS course_description', 'language.name AS language_name')
                ->from('app_users', 'designers')
                ->innerJoin('designers', 'professor_registrations', 'pr', 'designers.id = pr.owner_id')
                ->leftJoin('pr', 'app_users', 'professors', 'pr.professor_id = professors.id')
                ->innerJoin('pr', 'courses', 'courses', 'pr.course_id = courses.id')->innerJoin('courses', 'language', 'language', 'courses.language_id = language.id')
                ->where('designers.id = ?')->andWhere('pr.id = ?')
                ->setParameter(0, $user_id)->setParameter(1, $pr_id)->execute()->fetchAll();
        } else {
            $jsr = new JsonResponse(array('error' => 'Internal server error.'));
            $jsr->setStatusCode(500);
            return $jsr;
        }
        
        // check for invalid results
        if (count($results) < 1) {
            $jsr = new JsonResponse(array('error' => 'Professor Registration does not exist or does not belong to the currently authenticated user.'));
            $jsr->setStatusCode(503);
            return $jsr;
        } else if (count($results) > 1) {
            $jsr = new JsonResponse(array('error' => 'An error has occurred. Check for duplicate keys in the database.'));
            $jsr->setStatusCode(500);
            return $jsr;
        }

        return new JsonResponse($results[0]);
    }

    public static function editProfessorRegistration(Request $request, $user_id, $user_type, $pr_id) {
        // a user MUST be a designer to edit professor registrations
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        // make sure professor registration id is numeric
        if (!is_numeric($pr_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the registration belongs to the designer
        $result = ProfessorRegistrationRepository::getProfessorRegistration($request, $user_id, $user_type, $pr_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        // get the date_start and date_end from the post parameters
        $post_parameters = $request->request->all();
        if (array_key_exists('date_start', $post_parameters) && array_key_exists('date_end', $post_parameters)) {
            $date_start = $post_parameters['date_start'];
            $date_end = $post_parameters['date_end'];

            // make sure the values are numeric and do not conflict (as they are supposed to be a valid time interval)
            if (!is_numeric($date_start) || !is_numeric($date_end)) {
                $jsr = new JsonResponse(array('error' => 'Incorrect type for values.'));
                $jsr->setStatusCode(503);
                return $jsr;
            }
            if ($date_start > $date_end) {
                $jsr = new JsonResponse(array('error' => 'The start date cannot be after the end date.'));
                $jsr->setStatusCode(503);
                return $jsr;
            }

            // updates the registration
            $conn = Database::getInstance();
            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->update('professor_registrations')->set('date_start', '?')->set('date_end', '?')->where('id = ?')
                ->setParameter(0, $date_start)->setParameter(1, $date_end)->setParameter(2, $pr_id)->execute();

            // now, need to go through all student registrations created from this professor registration
            // and make sure that student registration end dates are not after the prof registration's new end date
            // and same constraints for start
            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->update('student_registrations', 'sr')->set('date_end', '?')
                ->where('sr.prof_registration_id = ?')->andWhere('sr.date_end > ?')->setParameter(0, $date_end)
                ->setParameter(1, $pr_id)->setParameter(2, $date_end)->execute();
            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->update('student_registrations', 'sr')->from('student_registrations', 'sr')->set('date_start', '?')
                ->where('sr.prof_registration_id = ?')->andWhere('sr.date_start < ?')->setParameter(0, $date_start)
                ->setParameter(1, $pr_id)->setParameter(2, $date_start)->execute();

            return ProfessorRegistrationRepository::getProfessorRegistration($request, $user_id, $user_type, $pr_id);
        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }
    }

    public static function createProfessorRegistration(Request $request, $user_id, $user_type) {
        // a user MUST be a designer to create professor registrations
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        // get post parameters for creating the new registration
        $post_parameters = $request->request->all();
        if (array_key_exists('date_start', $post_parameters) && array_key_exists('date_end', $post_parameters) && array_key_exists('course_id', $post_parameters)) {
            $date_start = $post_parameters['date_start'];
            $date_end = $post_parameters['date_end'];
            $course_id = $post_parameters['course_id'];

            // check if a professor id was pre-assigned
            $professor_id = -1;
            if (array_key_exists('professor_id', $post_parameters)) {
                $professor_id = $post_parameters['professor_id'];
            }

            // ensure numeric fields are numeric, and also that the date interval given is valid
            if (!is_numeric($date_start) || !is_numeric($date_end) || !is_numeric($course_id) || !is_numeric($professor_id)) {
                $jsr = new JsonResponse(array('error' => 'Incorrect type for values.'));
                $jsr->setStatusCode(503);
                return $jsr;
            }
            if ($date_start > $date_end) {
                $jsr = new JsonResponse(array('error' => 'The start date cannot be after the end date.'));
                $jsr->setStatusCode(503);
                return $jsr;
            }

            $conn = Database::getInstance();

            // check if the course is accessible to the currently logged in user
            $result = CourseRepository::getCourse($request, $user_id, $user_type, $course_id);
            if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
                return $result;
            }

            // if a professor id was given, do some extra checks
            if ($professor_id > -1) {
                // check if the professor id given was valid
                $result = UserRepository::getProfessor($request, $user_id, $user_type, $professor_id);
                if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
                    return $result;
                }

                // make sure that a registration between this professor and course doesn't already exist
                $queryBuilder = $conn->createQueryBuilder();
                $results = $queryBuilder->select('pr.id', 'pr.date_start', 'pr.date_end')->from('professor_registrations', 'pr')->where('pr.professor_id = ?')
                    ->andWhere('pr.course_id = ?')
                    ->setParameter(0, $professor_id)->setParameter(1, $course_id)->execute()->fetchAll();
                if (count($results) > 0) {
                    $jsr = new JsonResponse(array('error' => 'A registration giving the same course to the same professor already exists. Please modify the existing one instead of creating a new one.'));
                    $jsr->setStatusCode(400);
                    return $jsr;
                }
            } else {
                $professor_id = null;
            }

            // create the professor registration
            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->insert('professor_registrations')
                ->values(
                    array(
                        'date_start' => '?',
                        'date_end' => '?',
                        'course_id' => '?',
                        'owner_id' => '?',
                        'professor_id' => '?',
                        'date_created' => '?',
                        'signup_code' => '?'
                    )
                )
                ->setParameter(0, $date_start)->setParameter(1, $date_end)->setParameter(2, $course_id)->setParameter(3, $user_id)->setParameter(4, $professor_id)
                ->setParameter(5, time())->setParameter(6, md5(mt_rand()))->execute();

            $pr_id = $conn->lastInsertId();

            return ProfessorRegistrationRepository::getProfessorRegistration($request, $user_id, $user_type, $pr_id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }

    public static function deleteProfessorRegistration(Request $request, $user_id, $user_type, $pr_id) {
        // a user MUST be a designer to delete professor registrations
        if (strcmp($user_type, 'designer') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        // make sure that professor registration id is numeric
        if (!is_numeric($pr_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the registration belongs to the designer
        $result = ProfessorRegistrationRepository::getProfessorRegistration($request, $user_id, $user_type, $pr_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        // delete the professor registration
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->delete('professor_registrations')->where('professor_registrations.id = ?')
            ->setParameter(0, $pr_id)->execute();

        return new Response();
    }

}