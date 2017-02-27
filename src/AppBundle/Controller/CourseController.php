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
 * getCourses - /api/designer/courses - get courses
 * getCourse - /api/designer/course/{id} - get a single course by its id
 * createCourse - /api/designer/course (POST) - create a course - takes in name, description, language_id request parameter
 * editCourse - /api/designer/course/{id} (POST) - edits a course by its id, takes in name, description, language_id request parameter
 * deleteCourse - /api/designer/course/{id} (DELETE) - deletes a course by id
 *
 * Class CourseController
 * @package AppBundle\Controller
 */
class CourseController extends Controller
{
    /**
     * Gets all courses that the designer owns
     *
     * Can filter by name
     *
     * @Route("/api/designer/courses", name="getCoursesAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getCourses(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        $request_parameters = $request->query->all();
        $name = "%%";
        if (array_key_exists('name', $request_parameters)) {
            $name = '%' . $request_parameters['name'] . '%';
        }
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $result = $queryBuilder->select('courses.id', 'courses.name', 'courses.description', 'language.name AS language_name', 'language.id AS language_id')
            ->from('app_users')->innerJoin('app_users', 'courses', 'courses', 'app_users.id = courses.user_id')
            ->innerJoin('courses', 'language', 'language', 'courses.language_id = language.id')->where('app_users.id = ?')->andWhere('courses.name LIKE ?')
            ->setParameter(0, $user_id)->setParameter(1, $name)->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($result), 'data' => $result));
        $jsr->setStatusCode(200);
        return $jsr;
    }

    /**
     * Gets specific information on a specific course that belongs to the designer
     *
     * @Route("/api/designer/course/{id}", name="getCourseAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getCourse(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        $course_id = $id;

        if (!is_numeric($course_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the course belongs to the designer
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('courses.id', 'courses.name', 'courses.description', 'language.name AS language_name', 'language.id AS language_id')->from('app_users', 'designers')
            ->innerJoin('designers', 'courses', 'courses', 'designers.id = courses.user_id')->innerJoin('courses', 'language', 'language', 'courses.language_id = language.id')
            ->where('designers.id = ?')->andWhere('courses.id = ?')
            ->setParameter(0, $user_id)->setParameter(1, $course_id)->execute()->fetchAll();
        if (count($results) < 1) {
            $jsr = new JsonResponse(array('error' => 'Course does not exist or does not belong to the currently authenticated user.'));
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
     * Creates a new course object tied to the currently logged in designer
     *
     * Takes in:
     *      "name" - Name of course
     *      "description" - Description of course
     *      "language_id" - ID of the language of the course
     *
     * @Route("/api/designer/course", name="createCourseAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function createCourse(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();

        $post_parameters = $request->request->all();

        if (array_key_exists('name', $post_parameters) && array_key_exists('description', $post_parameters) && array_key_exists('language_id', $post_parameters)) {
            $name = $post_parameters['name'];
            $description = $post_parameters['description'];
            $language_id = $post_parameters['language_id'];
            if (!is_numeric($language_id)) {
                $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }
            $conn = Database::getInstance();

            $queryBuilder = $conn->createQueryBuilder();
            $results = $queryBuilder->select('language.id', 'language.language_code', 'language.name')
                ->from('language')->where('language.id = ?')->setParameter(0, $language_id)->execute()->fetchAll();
            if (count($results) < 1) {
                $jsr = new JsonResponse(array('error' => 'Invalid language ID specified.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->insert('courses')
                ->values(
                    array(
                        'name' => '?',
                        'user_id' => '?',
                        'description' => '?',
                        'language_id' => '?'
                    )
                )
                ->setParameter(0, $name)->setParameter(1, $user_id)->setParameter(2, $description)->setParameter(3, $language_id)->execute();
            $id = $conn->lastInsertId();

            return $this->getCourse($request, $id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(200);
            return $jsr;
        }
    }

    /**
     * Edits an existing course object tied to the currently logged in designer
     *
     * Takes in:
     *      "name" - Name of course
     *      "description" - Description of course
     *      "language_id" - ID of the language of the course
     *
     * @Route("/api/designer/course/{id}", name="editCourseAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function editCourse(Request $request, $id) {
        $course_id = $id;

        if (!is_numeric($course_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the course belongs to the designer
        $result = $this->getCourse($request, $course_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        $post_parameters = $request->request->all();

        if (array_key_exists('name', $post_parameters) && array_key_exists('description', $post_parameters) && array_key_exists('language_id', $post_parameters)) {
            $name = $post_parameters['name'];
            $description = $post_parameters['description'];
            $language_id = $post_parameters['language_id'];
            if (!is_numeric($language_id)) {
                $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            $conn = Database::getInstance();
            $queryBuilder = $conn->createQueryBuilder();
            $results = $queryBuilder->select('language.id', 'language.language_code', 'language.name')
                ->from('language')->where('language.id = ?')->setParameter(0, $language_id)->execute()->fetchAll();
            if (count($results) < 1) {
                $jsr = new JsonResponse(array('error' => 'Invalid language ID specified.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->update('courses')
                ->set('courses.name', '?')
                ->set('courses.description', '?')
                ->set('courses.language_id', '?')
                ->where('courses.id = ?')
                ->setParameter(0, $name)->setParameter(3, $course_id)->setParameter(1, $description)->setParameter(2, $language_id)->execute();

            return $this->getCourse($request, $course_id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(200);
            return $jsr;
        }
    }

    /**
     * Deletes a course that belongs to the designer
     *
     * @Route("/api/designer/course/{id}", name="deleteCourseAsDesigner")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteCourse(Request $request, $id) {
        $course_id = $id;

        if (!is_numeric($course_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the course belongs to the designer
        $result = $this->getCourse($request, $course_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $queryBuilder->delete('courses')->where('courses.id = ?')->setParameter(0, $course_id)->execute();

        return new Response();
    }

    /**
     * Gets all units that belong to the given course, ordered by their weight
     *
     * @Route("/api/designer/course/{id}/units", name="getUnitsAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getUnits(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        $course_id = $id;

        if (!is_numeric($course_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('unit.name', 'unit.description', 'unit.id', 'unit.weight')
            ->from('app_users', 'designers')->innerJoin('designers', 'courses', 'courses', 'designers.id = courses.user_id')
            ->innerJoin('courses', 'unit', 'unit', 'unit.course_id = courses.id')->where('designers.id = ?')->andWhere('course_id = ?')
            ->orderBy('unit.weight', 'ASC')
            ->setParameter(0, $user_id)->setParameter(1, $course_id)->execute()->fetchAll();

        $jsr = new JsonResponse(array('size' => count($results), 'data' => $results));
        $jsr->setStatusCode(200);
        return $jsr;
    }

    /**
     * Gets specific information on a specific unit that belongs to the designer
     *
     * @Route("/api/designer/unit/{id}", name="getUnitInformation")
     * @Method({"GET", "OPTIONS"})
     */
    public function getUnit(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        $unit_id = $id;

        if (!is_numeric($unit_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the course belongs to the designer
        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $results = $queryBuilder->select('unit.name', 'unit.description', 'unit.id', 'unit.weight')
            ->from('app_users', 'designers')->innerJoin('designers', 'courses', 'courses', 'designers.id = courses.user_id')
            ->innerJoin('courses', 'unit', 'unit', 'unit.course_id = courses.id')->where('designers.id = ?')->andWhere('unit.id = ?')
            ->orderBy('unit.weight', 'ASC')
            ->setParameter(0, $user_id)->setParameter(1, $unit_id)->execute()->fetchAll();
        if (count($results) < 1) {
            $jsr = new JsonResponse(array('error' => 'Unit does not exist or does not belong to the currently authenticated user.'));
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
     * Creates a new unit object tied to the current course
     *
     * Takes in:
     *      "name" - Name of unit
     *      "description" - Description of unit
     *      "course_id" - ID of the course that the unit belongs to
     *      "weight" - order by which this unit should be displayed (number)
     *
     * @Route("/api/designer/unit", name="createUnit")
     * @Method({"POST", "OPTIONS"})
     */
    public function createUnit(Request $request) {
        $post_parameters = $request->request->all();

        if (array_key_exists('name', $post_parameters) && array_key_exists('description', $post_parameters) && array_key_exists('course_id', $post_parameters) && array_key_exists('weight', $post_parameters)) {
            $name = $post_parameters['name'];
            $description = $post_parameters['description'];
            $course_id = $post_parameters['course_id'];
            $weight = $post_parameters['weight'];
            if (!is_numeric($course_id)) {
                $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
                $jsr->setStatusCode(400);
                return $jsr;
            }

            // check if course given belongs to the currently logged in user
            $result = $this->getCourse($request, $course_id);
            if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
                return $result;
            }
            $conn = Database::getInstance();

            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->insert('unit')
                ->values(
                    array(
                        'name' => '?',
                        'weight' => '?',
                        'description' => '?',
                        'course_id' => '?'
                    )
                )
                ->setParameter(0, $name)->setParameter(1, $weight)->setParameter(2, $description)->setParameter(3, $course_id)->execute();
            $id = $conn->lastInsertId();

            return $this->getUnit($request, $id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(200);
            return $jsr;
        }
    }

    /**
     * Edits an existing unit object tied to the current course.
     *
     * The course tied to the unit cannot be changed, for good reason.
     *
     * Takes in:
     *      "name" - Name of course
     *      "description" - Description of course
     *      "weight" - order by which this unit should be displayed (number)
     *
     * @Route("/api/designer/unit/{id}", name="editUnitAsDesigner")
     * @Method({"POST", "OPTIONS"})
     */
    public function editUnit(Request $request, $id) {
        $unit_id = $id;

        if (!is_numeric($unit_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the unit belongs to the designer
        $result = $this->getUnit($request, $unit_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        $post_parameters = $request->request->all();

        if (array_key_exists('name', $post_parameters) && array_key_exists('description', $post_parameters) && array_key_exists('weight', $post_parameters)) {
            $name = $post_parameters['name'];
            $description = $post_parameters['description'];
            $weight = $post_parameters['weight'];

            $conn = Database::getInstance();
            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->update('unit')
                ->set('unit.name', '?')
                ->set('unit.description', '?')
                ->set('unit.weight', '?')
                ->where('unit.id = ?')
                ->setParameter(0, $name)->setParameter(1, $description)->setParameter(2, $weight)->setParameter(3, $unit_id)->execute();

            return $this->getUnit($request, $unit_id);

        } else {
            $jsr = new JsonResponse(array('error' => 'Required fields are missing.'));
            $jsr->setStatusCode(200);
            return $jsr;
        }
    }

    /**
     * Deletes a unit that belongs to the current course
     *
     * @Route("/api/designer/unit/{id}", name="deleteUnitAsDesigner")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteUnit(Request $request, $id) {
        $unit_id = $id;

        if (!is_numeric($unit_id)) {
            $jsr = new JsonResponse(array('error' => 'Invalid non-numeric ID specified.'));
            $jsr->setStatusCode(400);
            return $jsr;
        }

        // check if the course belongs to the designer
        $result = $this->getUnit($request, $unit_id);
        if ($result->getStatusCode() < 200 || $result->getStatusCode() > 299) {
            return $result;
        }

        $conn = Database::getInstance();
        $queryBuilder = $conn->createQueryBuilder();
        $queryBuilder->delete('unit')->where('unit.id = ?')->setParameter(0, $unit_id)->execute();

        return new Response();
    }

}