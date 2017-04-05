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
        $result = $queryBuilder->select('sr.id', 'sr.name', 'sr.date_created', 'sr.date_deleted', 'sr.date_start', 'sr.date_end', 'sr.signup_code', 'sr.max_registrations')
            ->from('app_users', 'designers')
            ->innerJoin('designers', 'professor_registrations', 'pr', 'designers.id = pr.owner_id')
            ->innerJoin('pr', 'student_registrations', 'sr', 'sr.prof_registration_id = pr.id')
            ->where('designers.id = ?')->andWhere('pr.id = ?')
            ->setParameter(0, $user_id)->setParameter(1, $pr_id)->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($result), 'data' => $result));
        $jsr->setStatusCode(200);
        return $jsr;
    }
    
    public static function getStudentRegistration(Request $request, $user_id, $user_type, $sr_id) {
        // makes sure that the class id is numeric
        if (!is_numeric($sr_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = null;
        if (strcmp($user_type, 'professor') == 0) {
            $results = $queryBuilder->select('classes.id AS class_id', 'classes.name AS class_name', 'classes.description AS class_description',
                'sr.id AS student_registration_id', 'sr.date_start AS student_registration_date_start', 'sr.date_end AS student_registration_date_end',
                'sr.max_registrations AS student_registration_max_registrations')
                ->from('professor_registrations', 'pr')->innerJoin('pr', 'courses', 'courses', 'pr.course_id = courses.id')
                ->innerJoin('pr', 'classes', 'classes', 'pr.id = classes.registration_id')
                ->innerJoin('pr', 'app_users', 'professors', 'pr.professor_id = professors.id')
                ->innerJoin('classes', 'student_registrations', 'sr', 'sr.class_id = classes.id')
                ->where('sr.id = ?')->andWhere('professors.id = ?')
                ->setParameter(0, $sr_id)->setParameter(1, $user_id)->execute()->fetchAll();
        } else {
            $jsr = new JsonResponse(array('error' => 'Internal server error.'));
            $jsr->setStatusCode(500);
            return $jsr;
        }

        // if nothing was returned, give error. if multiple results, also give error (each key should be unique)
        if (count($results) < 1) {
            $jsr = new JsonResponse(array('error' => 'Student registration does not exist or does not belong to the currently authenticated user.'));
            $jsr->setStatusCode(503);
            return $jsr;
        } else if (count($results) > 1) {
            $jsr = new JsonResponse(array('error' => 'An error has occurred. Check for duplicate keys in the database.'));
            $jsr->setStatusCode(500);
            return $jsr;
        }

        return new JsonResponse($results[0]);
    }

    public static function getStudentRegistrationByClass(Request $request, $user_id, $user_type, $class_id) {
        // a user MUST be a professor to get student registrations by class
        if (strcmp($user_type, 'professor') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        // makes sure that the class id is numeric
        if (!is_numeric($class_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('classes.id AS class_id', 'classes.name AS class_name', 'classes.description AS class_description',
            'sr.id AS student_registration_id', 'sr.date_start AS student_registration_date_start', 'sr.date_end AS student_registration_date_end', 
            'sr.max_registrations AS student_registration_max_registrations')
            ->from('professor_registrations', 'pr')->innerJoin('pr', 'courses', 'courses', 'pr.course_id = courses.id')
            ->innerJoin('pr', 'classes', 'classes', 'pr.id = classes.registration_id')
            ->innerJoin('pr', 'app_users', 'professors', 'pr.professor_id = professors.id')
            ->innerJoin('classes', 'student_registrations', 'sr', 'sr.class_id = classes.id')
            ->where('classes.id = ?')->andWhere('professors.id = ?')
            ->setParameter(0, $class_id)->setParameter(1, $user_id)->execute()->fetchAll();

        // if nothing was returned, give error. if multiple results, also give error (each key should be unique)
        if (count($results) < 1) {
            $jsr = new JsonResponse(array('error' => 'Student registration does not exist or does not belong to the currently authenticated user.'));
            $jsr->setStatusCode(503);
            return $jsr;
        } else if (count($results) > 1) {
            $jsr = new JsonResponse(array('error' => 'An error has occurred. Check for duplicate keys in the database.'));
            $jsr->setStatusCode(500);
            return $jsr;
        }

        return new JsonResponse($results[0]);
    }

    public static function getStudentRegistrations(Request $request, $user_id, $user_type) {
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = null;
        if (strcmp($user_type, 'professor') == 0) {
            $results = $queryBuilder->select('classes.id AS class_id', 'classes.name AS class_name', 'classes.description AS class_description',
                'sr.id AS student_registration_id', 'sr.date_start AS student_registration_date_start', 'sr.date_end AS student_registration_date_end',
                'sr.max_registrations AS student_registration_max_registrations')
                ->from('professor_registrations', 'pr')->innerJoin('pr', 'courses', 'courses', 'pr.course_id = courses.id')
                ->innerJoin('pr', 'classes', 'classes', 'pr.id = classes.registration_id')
                ->innerJoin('pr', 'app_users', 'professors', 'pr.professor_id = professors.id')
                ->innerJoin('classes', 'student_registrations', 'sr', 'sr.class_id = classes.id')
                ->andWhere('professors.id = ?')
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

    public static function createStudentRegistration(Request $request, $user_id, $user_type) {
        // a user MUST be a professor to create student registrations
        if (strcmp($user_type, 'professor') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        $post_parameters = $request->request->all();
        if (array_key_exists('date_start', $post_parameters) && array_key_exists('date_end', $post_parameters) && array_key_exists('class_id', $post_parameters)
            && array_key_exists('max_registrations', $post_parameters)) {
            $date_start = $post_parameters['date_start'];
            $date_end = $post_parameters['date_end'];
            $class_id = $post_parameters['class_id'];
            $max_registrations = $post_parameters['max_registrations'];
            if (!is_numeric($date_start) || !is_numeric($date_end) || !is_numeric($class_id) || !is_numeric($max_registrations)) {
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

            // check to make sure the class being paired with the student registration is valid, and professor has access to it
            $queryBuilder = $conn->createQueryBuilder();
            $results = $queryBuilder->select('classes.id', 'classes.name', 'pr.owner_id', 'pr.id AS prof_reg_id', 'pr.date_end', 'pr.date_start')
                ->from('professor_registrations', 'pr')->innerJoin('pr', 'courses', 'courses', 'pr.course_id = courses.id')
                ->innerJoin('pr', 'classes', 'classes', 'pr.id = classes.registration_id')
                ->where('pr.professor_id = ?')->andWhere('classes.id = ?')->setParameter(0, $user_id)->setParameter(1, $class_id)->execute()->fetchAll();
            if (count($results) < 1) {
                $jsr = new JsonResponse(array('error' => 'Invalid class ID.'));
                $jsr->setStatusCode(500);
                return $jsr;
            }
            $designer_id = $results[0]['owner_id'];
            $prof_reg_id = $results[0]['prof_reg_id'];
            $pr_date_end = $results[0]['date_end'];
            $pr_date_start = $results[0]['date_start'];

            // check to make sure the given date_start and date_end are not out of the range specified by the professor registration
            if ($date_start < $pr_date_start) {
                $jsr = new JsonResponse(array('error' => 'The start date cannot be before the professor registration is active.'));
                $jsr->setStatusCode(503);
                return $jsr;
            }

            if ($date_end > $pr_date_end) {
                $jsr = new JsonResponse(array('error' => 'The end date cannot be after the professor registration expires.'));
                $jsr->setStatusCode(503);
                return $jsr;
            }

            // make sure a student registration between this professor and the same class doesn't already exist
            $queryBuilder = $conn->createQueryBuilder();
            $results = $queryBuilder->select('sr.id')
                ->from('student_registrations', 'sr')->innerJoin('sr', 'professor_registrations', 'pr', 'sr.prof_registration_id = pr.id')
                ->where('pr.professor_id = ?')->andWhere('sr.class_id = ?')->setParameter(0, $user_id)->setParameter(1, $class_id)->execute()->fetchAll();
            if (count($results) >= 1) {
                $jsr = new JsonResponse(array('error' => 'A registration code for this class already exists.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->insert('student_registrations')
                ->values(
                    array(
                        'date_start' => '?',
                        'date_end' => '?',
                        'class_id' => '?',
                        'designer_id' => '?',
                        'prof_registration_id' => '?',
                        'date_created' => '?',
                        'signup_code' => '?',
                        'name' => '?',
                        'max_registrations' => '?'
                    )
                )
                ->setParameter(0, $date_start)->setParameter(1, $date_end)->setParameter(2, $class_id)->setParameter(3, $designer_id)->setParameter(4, $prof_reg_id)
                ->setParameter(5, time())->setParameter(6, md5(mt_rand()))->setParameter(7, '')->setParameter(8, $max_registrations)->execute();

            $sr_id = $conn->lastInsertId();

            return StudentRegistrationRepository::getStudentRegistration($request, $user_id, 'professor', $sr_id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }

    public static function editStudentRegistration(Request $request, $user_id, $user_type, $sr_id) {
        // a user MUST be a professor to edit student registrations
        if (strcmp($user_type, 'professor') != 0) {
            $jsr = new JsonResponse(array('error' => 'Permissions are invalid.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        // make sure student registration id is numeric
        if (!is_numeric($sr_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the student registration belongs to the professor
        $result = StudentRegistrationRepository::getStudentRegistration($request, $user_id, $user_type, $sr_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        $post_parameters = $request->request->all();
        $conn = Database::getInstance();
        if (array_key_exists('date_start', $post_parameters) && array_key_exists('date_end', $post_parameters) && array_key_exists('max_registrations', $post_parameters)) {
            $date_start = $post_parameters['date_start'];
            $date_end = $post_parameters['date_end'];
            $max_registrations = $post_parameters['max_registrations'];
            // check that integer fields are numeric
            if (!is_numeric($date_start) || !is_numeric($date_end) || !is_numeric($max_registrations)) {
                $jsr = new JsonResponse(array('error' => 'Incorrect type for values.'));
                $jsr->setStatusCode(503);
                return $jsr;
            }
            // make sure date interval is valid
            if ($date_start > $date_end) {
                $jsr = new JsonResponse(array('error' => 'The start date cannot be after the end date.'));
                $jsr->setStatusCode(503);
                return $jsr;
            }
            // obtain date information from the professor registration
            $queryBuilder = $conn->createQueryBuilder();
            $results = $queryBuilder->select('pr.owner_id', 'pr.id AS prof_reg_id', 'pr.date_end', 'pr.date_start')
                ->from('professor_registrations', 'pr')->innerJoin('pr', 'student_registrations', 'sr', 'pr.id = sr.prof_registration_id')
                ->where('sr.id = ?')->setParameter(0, $sr_id)->execute()->fetchAll();
            $pr_date_end = $results[0]['date_end'];
            $pr_date_start = $results[0]['date_start'];

            // check to make sure the given date_start and date_end are not out of the range specified by the professor registration
            if ($date_start < $pr_date_start) {
                $jsr = new JsonResponse(array('error' => 'The start date cannot be before the professor registration is active.'));
                $jsr->setStatusCode(503);
                return $jsr;
            }
            if ($date_end > $pr_date_end) {
                $jsr = new JsonResponse(array('error' => 'The end date cannot be after the professor registration expires.'));
                $jsr->setStatusCode(503);
                return $jsr;
            }

            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->update('student_registrations');
            $queryBuilder->set('date_start', '?')
                ->set('date_end', '?')->set('max_registrations', '?')->where('id = ?')
                ->setParameter(0, $date_start)->setParameter(1, $date_end)->setParameter(2, $max_registrations)->setParameter(3, $sr_id)->execute();

            return StudentRegistrationRepository::getStudentRegistration($request, $user_id, $user_type, $sr_id);
        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }
    }

    public static function deleteStudentRegistration(Request $request, $user_id, $user_type, $sr_id) {
        // makes sure that the student registration id is numeric
        if (!is_numeric($sr_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the student registration belongs to the professor
        $result = StudentRegistrationRepository::getStudentRegistration($request, $user_id, $user_type, $sr_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        // delete the student registration
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $queryBuilder->delete('student_registrations')->where('student_registrations.id = ?')
            ->setParameter(0, $sr_id)->execute();

        return new Response();
    }
}