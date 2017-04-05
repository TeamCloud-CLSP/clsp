<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Repository\LanguageRepository;
use AppBundle\Repository\UserRepository;
use AppBundle\Repository\StudentRegistrationRepository;
use AppBundle\Repository\ProfessorRegistrationRepository;
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
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return LanguageRepository::getLanguages($request, $user_id, 'designer');
    }

    /**
     * Gets detailed information on a specific language
     * @Route("/api/designer/language/{$id}", name="getLanguageAsDesigner")
     * @Method({"GET", "OPTIONS"})
     * @param Request $request
     * @return JsonResponse
     */
    public function getLanguage(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return LanguageRepository::getLanguage($request, $user_id, 'designer', $id);
    }

    /**
     * Gets all student registrations associated with a professor registration (that the designer owns!)
     * @Route("/api/designer/registrations/professor/{id}/student", name="getStudentRegistrationsByProfessorRegistrationAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getStudentRegistrations(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return StudentRegistrationRepository::getStudentRegistrationsByProfessorRegistration($request, $user_id, 'designer', $id);
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
        return UserRepository::getProfessors($request, $user_id, 'designer');
    }

    /**
     * Gets all professor registrations that the designer owns
     * @Route("/api/designer/registrations/professor", name="getProfessorRegistrationsAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getProfessorRegistrations(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ProfessorRegistrationRepository::getProfessorRegistrations($request, $user_id, 'designer');
    }

    /**
     * Gets all professor registrations that the designer owns by course
     * @Route("/api/designer/course/{id}/registrations/professor", name="getProfessorRegistrationsByCourseAsDesigner")
     * @Method({"GET", "OPTIONS"})
     */
    public function getProfessorRegistrationsbyCourse(Request $request, $id) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ProfessorRegistrationRepository::getProfessorRegistrationsByCourse($request, $user_id, 'designer', $id);
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
        return ProfessorRegistrationRepository::getProfessorRegistration($request, $user_id, 'designer', $id);
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
        return ProfessorRegistrationRepository::editProfessorRegistration($request, $user_id, 'designer', $id);
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
     * @Route("/api/designer/registrations/professor", name="createProfessorRegistration")
     * @Method({"POST", "OPTIONS"})
     */
    public function createProfessorRegistration(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();
        return ProfessorRegistrationRepository::createProfessorRegistration($request, $user_id, 'designer');
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
        return ProfessorRegistrationRepository::deleteProfessorRegistration($request, $user_id, 'designer', $id);
    }
}
