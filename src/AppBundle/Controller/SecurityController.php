<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class SecurityController extends Controller
{
    /**
     * Sends an email to the specified user with a password reset email
     *
     * Takes in:
     *      "email" - email of user trying to reset their password
     *
     * @Route("/api/security/forgotPass", name="sendPasswordResetEmail")
     * @Method({"POST", "OPTIONS"})
     */
    public function sendPasswordResetEmail(Request $request) {

        $post_parameters = $request->request->all();

        if ( array_key_exists('email', $post_parameters) ) {
            $email = $post_parameters['email'];
            $realUser = $this->getDoctrine()->getRepository('AppBundle:User')->findOneByEmail($email);

            if(is_null($realUser)) {
                $jsr = new JsonResponse(["error" => "No user with the specified email found"]);
                $jsr->setStatusCode(400);
                return $jsr;
            }

            $resetCode = $this->generateSignupCode();
            $resetLink = $this->getParameter('site_domain') . '/forgotPass/' . $resetCode;
            $realUser->setForgotPasswordKey($resetCode);
            $realUser->setForgotPasswordExpiry(time() + 2 * 60 * 60);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($realUser);
            $manager->flush();

            $email = \Swift_Message::newInstance()
                ->setSubject('Forgotten Password Reset - CLSP')
                ->setFrom($this->getParameter('mailer_from_address'))
                ->setTo($realUser->getEmail())
                ->setBody(
                    $this->renderView(
                        'email/forgotPassword.html.twig',
                        array(
                            'base_dir' => realpath($this->getParameter('kernel.root_dir').'..').DIRECTORY_SEPARATOR,
                            'reset_link' => $resetLink
                        )
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($email);
            $jsr = new JsonResponse(['msg' => 'Password reset email sent']);
            $jsr->setStatusCode(200);
            return $jsr;
        } else {
            $jsr = new JsonResponse(['error' => 'Required fields are missing.']);
            $jsr->setStatusCode(400);
            return $jsr;
        }
    }

    /**
     * Resets the user's password if the correct forgot password code is given
     *
     * Takes in:
     *      "forgot_pass_code" - the code emailed to the user
     *      "new_password" - new password that should be set
     *
     * @Route("/api/security/resetPass", name="resetUserPassword")
     * @Method({"POST", "OPTIONS"})
     */
    public function resetUserPassword(Request $request)
    {

        $post_parameters = $request->request->all();

        if ( array_key_exists('forgot_pass_code', $post_parameters) && array_key_exists('new_password', $post_parameters) ) {
            $forgot_pass_code = $post_parameters['forgot_pass_code'];
            $new_password = $post_parameters['new_password'];
            $realUser = $this->getDoctrine()->getRepository('AppBundle:User')->findOneByForgotPasswordKey($forgot_pass_code);

            if(is_null($realUser) || $realUser->getForgotPasswordExpiry() < time()) {
                $jsr = new JsonResponse(["error" => "Invalid password reset code"]);
                $jsr->setStatusCode(400);
                return $jsr;
            }

            $resetCode = $this->generateSignupCode();
            $resetLink = $this->getParameter('site_domain') . '/forgotPass/' . $resetCode;
            $realUser->setForgotPasswordKey($resetCode);
            $realUser->setForgotPasswordExpiry(time() + 2 * 60 * 60);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($realUser);
            $manager->flush();

            $password = $this->get('security.password_encoder')
                ->encodePassword($realUser, $new_password);
            $realUser->setPassword($password);
            $realUser->setForgotPasswordKey(null);
            $realUser->setForgotPasswordExpiry(null);

            $em = $this->getDoctrine()->getManager();

            $em->persist($realUser);
            $em->flush();

            $jsr = new JsonResponse(['msg' => 'Password Reset']);
            $jsr->setStatusCode(200);
            return $jsr;
        } else {
            $jsr = new JsonResponse(['error' => 'Required fields are missing.']);
            $jsr->setStatusCode(400);
            return $jsr;
        }
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

    /**
     * Tries to login a user with the given credentials
     * returns a valid JWT on success, error message on failure
     *
     * Takes in:
     *      "username" - attempted user's username
     *      "password" - attempted user's password
     *
     * @Route("/api/security/loginToken", name="getLoginToken")
     * @Method({"POST", "OPTIONS"})
     */
    public function getLoginToken(Request $request) {

        $post_parameters = $request->request->all();

        if ( array_key_exists('username', $post_parameters) && array_key_exists('password', $post_parameters) ) {
            $username = $post_parameters['username'];
            $password = $post_parameters['password'];

            if($this->testUserCredentials($username, $password)) {
                $user = $this->getUserFromUsername($username);
                return new JsonResponse($this->getUserTokenFromUser($user));
            } else {
                $jsr = new JsonResponse(["error" => "Could not authenticate with the given credentials"]);
                $jsr->setStatusCode(400);
                return $jsr;
            }

        } else {
            $jsr = new JsonResponse(['error' => 'Required fields are missing.']);
            $jsr->setStatusCode(400);
            return $jsr;
        }

    }

    /**
     * Refreshes a user's JWT token
     * Assuming the user is already logged in
     * returns a valid JWT token on success, error message on failure
     *
     * @Route("/api/security/refreshToken", name="refreshLoginToken")
     * @Method({"GET", "OPTIONS"})
     */
    public function refreshLoginToken(Request $request) {

        $user = $this->get('security.token_storage')->getToken()->getUser();

        // this case should never happen - since this endpoint is protected, a user should always
        // be logged in if they reach this point
        if($user == null) {
            $jsr = new JsonResponse(['error' => 'User did not provide a valid token']);
            $jsr->setStatusCode(400);
            return $jsr;
        }

        return new JsonResponse($this->getUserTokenFromUser($user));

    }

    private function testUserCredentials($username, $password) {
        $user = $this->getUserFromUsername($username);

        if($user == null) {
            return false;
        }

        return $this->container->get('security.password_encoder')->isPasswordValid($user, $password);
    }

    private function getUserFromUsername($username) {
        $repository = $this->getDoctrine()->getRepository("AppBundle:User");
        $user = $repository->findOneBy(
            array('username' => $username)
        );
        return $user;
    }

    private function getUserTokenFromUser($user) {
        return [
            "token" => $this->container->get('lexik_jwt_authentication.jwt_manager')->create($user),
            "user_info" => [
                "id" => $user->getId(),
                "name" => $user->getName(),
                "username" => $user->getUsername(),
                "email" => $user->getEmail(),
                "is_active" => $user->getIsActive(),
                "date_created" => $user->getDateCreated(),
                "date_deleted" => $user->getDateDeleted(),
                "date_start" => $user->getDateStart(),
                "date_end" => $user->getDateEnd(),
                "timezone" => $user->getTimezone(),
                "is_student" => $user->getIsStudent(),
                "is_professor" => $user->getIsProfessor(),
                "is_designer" => $user->getIsDesigner(),
                "is_administrator" => $user->getIsAdministrator(),
                "password" => ""
            ]
        ];
    }
}