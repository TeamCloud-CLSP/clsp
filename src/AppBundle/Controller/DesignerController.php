<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Database;

/**
 * Available functions:
 *
 * getLanguages - /api/designer/languages - gets all available languages
 * getStudentRegistrations - /api/designer/registrations/professor/{professor_registration_id}/student - gets all student registrations that are tied to a professor registration
 * getProfessors - /api/designer/professors - (list of professors)
 * getProfessorRegistrations - /api/designer/registrations/professor
 * getProfessorRegistrationsbyCourse - /api/designer/course/{course_id}/registrations/professor
 * getProfessorRegistration - /api/designer/registrations/professor/{id}
 * editProfessorRegistration - /api/designer/registrations/professor/{id} (POST) - takes in "date_start" and "date_end"
 * createProfessorRegistration - /api/designer/registrations/professor (POST) - takes in date_start, date_end, course_id. optional: professor_id
 * deleteProfessorRegistration - /api/designer/registrations/professor/{id} (DELETE)
 * 
 * Class DesignerController
 * @package AppBundle\Controller
 */
class DesignerController extends Controller
{

    /**
     * Gets list of available languages
     * @Route("/api/designer/languages", name="getLanguagesAsDesigner")
     * @Method({"GET", "OPTIONS"})
     * @param Request $request
     * @return JsonResponse
     */
    public function getLanguages(Request $request) {
        $conn = Database::getInstance();

        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('language.id', 'language.language_code', 'language.name')
            ->from('language')->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($results), 'data' => $results));
        $jsr->setStatusCode(200);
        return $jsr;
    }

    /**
     * Gets all student registrations associated with a professor registration (that the designer owns!)
     * @Route("/api/designer/registrations/professor/{id}/student", name="getStudentRegistrationsByProfessorRegistrationAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getStudentRegistrations(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        $pr_id = $id;

        if (!is_numeric($pr_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

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

    /**
     * Gets all professor accounts (for assigning professor to registration code if needed)
     *
     * Can filter by username and name
     *
     * @Route("/api/designer/professors", name="getProfessors")
     * @Method({"GET", "OPTIONS"})
     */
    public function getProfessors(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        $request_parameters = $request->query->all();

        // gets the name parameter from request parameters, or just leaves it as double wildcard
        $username = "%%";
        $name = "%%";
        if (array_key_exists('username', $request_parameters)) {
            $username = '%' . $request_parameters['username'] . '%';
        }

        if (array_key_exists('name', $request_parameters)) {
            $name = '%' . $request_parameters['name'] . '%';
        }
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $result = $queryBuilder->select('app_users.id', 'app_users.username', 'app_users.name')
            ->from('app_users')->where('app_users.is_professor = 1')->andWhere('app_users.username LIKE ?')->andWhere('app_users.name LIKE ?')
            ->setParameter(0, $username)->setParameter(1, $name)->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($result), 'data' => $result));
        $jsr->setStatusCode(200);
        return $jsr;
    }

    /**
     * Gets all professor registrations that the designer owns
     * @Route("/api/designer/registrations/professor", name="getProfessorRegistrationsAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getProfessorRegistrations(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $result = $queryBuilder->select('pr.id', 'pr.date_created', 'pr.date_deleted', 'pr.date_start', 'pr.date_end', 'pr.signup_code',
            'professors.id AS professor_id', 'professors.username AS professor_username', 'professors.name AS professor_name',
            'courses.id AS course_id', 'courses.name AS course_name', 'courses.description AS course_description', 'language.name AS language_name')
            ->from('app_users', 'designers')
            ->innerJoin('designers', 'professor_registrations', 'pr', 'designers.id = pr.owner_id')
            ->leftJoin('pr', 'app_users', 'professors', 'pr.professor_id = professors.id')
            ->innerJoin('pr', 'courses', 'courses', 'pr.course_id = courses.id')->innerJoin('courses', 'language', 'language', 'courses.language_id = language.id')
            ->where('designers.id = ?')
            ->setParameter(0, $user_id)->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($result), 'data' => $result));
        $jsr->setStatusCode(200);
        return $jsr;
    }

    /**
     * Gets all professor registrations that the designer owns by course
     * @Route("/api/designer/course/{id}/registrations/professor", name="getProfessorRegistrationsByCourseAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getProfessorRegistrationsbyCourse(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        $course_id = $id;

        // make sure int values should be numeric
        if (!is_numeric($course_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }


        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $result = $queryBuilder->select('pr.id', 'pr.date_created', 'pr.date_deleted', 'pr.date_start', 'pr.date_end', 'pr.signup_code',
            'professors.id AS professor_id', 'professors.username AS professor_username', 'professors.name AS professor_name',
            'courses.id AS course_id', 'courses.name AS course_name', 'courses.description AS course_description', 'language.name AS language_name')
            ->from('app_users', 'designers')
            ->innerJoin('designers', 'professor_registrations', 'pr', 'designers.id = pr.owner_id')
            ->leftJoin('pr', 'app_users', 'professors', 'pr.professor_id = professors.id')
            ->innerJoin('pr', 'courses', 'courses', 'pr.course_id = courses.id')->innerJoin('courses', 'language', 'language', 'courses.language_id = language.id')
            ->where('designers.id = ?')->andWhere('course_id = ?')
            ->setParameter(0, $user_id)->setParameter(1, $course_id)->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($result), 'data' => $result));
        $jsr->setStatusCode(200);
        return $jsr;
    }

    /**
     * Gets specific information on a specific professor registration that belongs to the designer
     *
     * @Route("/api/designer/registrations/professor/{id}", name="getProfRegistrationInformation")
     * @Method({"GET", "OPTIONS"})
     */
    public function getProfessorRegistration(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        $pr_id = $id;

        if (!is_numeric($pr_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the registration belongs to the designer
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('pr.id', 'pr.date_created', 'pr.date_deleted', 'pr.date_start', 'pr.date_end', 'pr.signup_code',
                                'professors.id AS professor_id', 'professors.username AS professor_username', 'professors.name AS professor_name',
                                'courses.id AS course_id', 'courses.name AS course_name', 'courses.description AS course_description', 'language.name AS language_name')
            ->from('app_users', 'designers')
            ->innerJoin('designers', 'professor_registrations', 'pr', 'designers.id = pr.owner_id')
            ->leftJoin('pr', 'app_users', 'professors', 'pr.professor_id = professors.id')
            ->innerJoin('pr', 'courses', 'courses', 'pr.course_id = courses.id')->innerJoin('courses', 'language', 'language', 'courses.language_id = language.id')
            ->where('designers.id = ?')->andWhere('pr.id = ?')
            ->setParameter(0, $user_id)->setParameter(1, $pr_id)->execute()->fetchAll();
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

    /**
     * Edits an existing professor registration tied to the currently logged in designer
     * Editing of foreign relationships is currently not supported.
     *
     * Takes in:
     *      "date_start" - start date of activation
     *      "date_end" - end date of activation
     *
     * @Route("/api/designer/registrations/professor/{id}", name="editProfRegistration")
     * @Method({"POST", "OPTIONS"})
     */
    public function editProfessorRegistration(Request $request, $id)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        $pr_id = $id;

        if (!is_numeric($pr_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the registration belongs to the designer
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('pr.signup_code')->from('app_users', 'designers')
            ->innerJoin('designers', 'professor_registrations', 'pr', 'designers.id = pr.owner_id')
            ->where('designers.id = ?')->andWhere('pr.id = ?')
            ->setParameter(0, $user_id)->setParameter(1, $pr_id)->execute()->fetchAll();
        if (count($results) < 1) {
            $jsr = new JsonResponse(array('error' => 'Registration does not exist or does not belong to the currently authenticated user.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        $post_parameters = $request->request->all();

        $queryBuilder = $conn->createQueryBuilder();
        $queryBuilder->update('professor_registrations');
        if (array_key_exists('date_start', $post_parameters) && array_key_exists('date_end', $post_parameters)) {
            $date_start = $post_parameters['date_start'];
            $date_end = $post_parameters['date_end'];
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
            $queryBuilder->set('date_start', '?');
            $queryBuilder->set('date_end', '?')->where('id = ?')
                ->setParameter(0, $date_start)->setParameter(1, $date_end)->setParameter(2, $pr_id)->execute();

            return $this->getProfessorRegistration($request, $pr_id);
        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

    }

    /**
     * Creates a new professor registration object tied to the currently logged in designer
     *
     * Takes in:
     *      date_start
     *      date_end
     *      course_id (fk)
     *
     * Optional:
     *      professor_id (fk) - this should probably be assigned when the professor registers with the code
     *
     *
     *
     * @Route("/api/designer/registrations/professor", name="createProfessorRegistration")
     * @Method({"POST", "OPTIONS"})
     */
    public function createProfessorRegistration(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();

        $post_parameters = $request->request->all();

        if (array_key_exists('date_start', $post_parameters) && array_key_exists('date_end', $post_parameters) && array_key_exists('course_id', $post_parameters)) {
            $date_start = $post_parameters['date_start'];
            $date_end = $post_parameters['date_end'];
            $course_id = $post_parameters['course_id'];
            $professor_id = -1;
            if (array_key_exists('professor_id', $post_parameters)) {
                $professor_id = $post_parameters['professor_id'];
            }
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

            $queryBuilder = $conn->createQueryBuilder();
            $results = $queryBuilder->select('courses.id')->from('courses')->where('courses.id = ?')->andWhere('courses.user_id = ?')
                ->setParameter(0, $course_id)->setParameter(1, $user_id)->execute()->fetchAll();
            if (count($results) < 1) {
                $jsr = new JsonResponse(array('error' => 'Invalid course ID.'));
                $jsr->setStatusCode(500);
                return $jsr;
            }

            if ($professor_id > -1) {
                $queryBuilder = $conn->createQueryBuilder();
                $results = $queryBuilder->select('id')->from('app_users')->where('id = ?')->setParameter(0, $professor_id)->execute()->fetchAll();
                if (count($results) < 1) {
                    $jsr = new JsonResponse(array('error' => 'Invalid professor ID.'));
                    $jsr->setStatusCode(500);
                    return $jsr;
                }

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

            return $this->getProfessorRegistration($request, $pr_id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }

    /**
     * Deletes a specific professor registration that belongs to the designer
     *
     * @Route("/api/designer/registrations/professor/{id}", name="deleteProfessorRegistration")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteProfessorRegistration(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        $pr_id = $id;

        if (!is_numeric($pr_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the course belongs to the designer
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('pr.id')->from('app_users', 'designers')
            ->innerJoin('designers', 'professor_registrations', 'pr', 'designers.id = pr.owner_id')
            ->leftJoin('pr', 'app_users', 'professors', 'pr.professor_id = professors.id')
            ->innerJoin('pr', 'courses', 'courses', 'pr.course_id = courses.id')
            ->where('designers.id = ?')->andWhere('pr.id = ?')
            ->setParameter(0, $user_id)->setParameter(1, $pr_id)->execute()->fetchAll();
        if (count($results) < 1) {
            $jsr = new JsonResponse(array('error' => 'Registration does not exist or does not belong to the currently authenticated user.'));
            $jsr->setStatusCode(503);
            return $jsr;
        }

        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->delete('professor_registrations')->where('professor_registrations.id = ?')
            ->setParameter(0, $pr_id)->execute();

        return new Response();
    }
}
