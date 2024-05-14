<?php

namespace App\Controller;

use App\Service\CallUserApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login", methods={"GET", "POST"})
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        
        // dd($authenticationUtils);
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/index.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    /**
     * @Route("/api/login", name="api_login", methods={"POST"})
     */
    public function apiLogin(AuthenticationUtils $authenticationUtils) : Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApiLoginController.php',
        ]);
    }

    /**
     * @Route("/api/getuserinfos", name="api_login_user_infos", methods={"GET", "POST"})
     */
    public function getCurrentUser(CallUserApiService $callUserApiService): Response
    {
        // Retrieves the current user with its JWT token
        $user = $callUserApiService->getCurrentUser();

        return $user ?
            // if the user is found, we return it
            $this->json($user, Response::HTTP_OK, [], ["groups" => "users"]) :
            // else we return an error code and an error message
            $this->json(["erreur" => "Utilisateur inconnu"], Response::HTTP_NOT_FOUND);
    }

     /**
     * @Route("/logout/redirect", name="app_logout_redirect", methods={"GET"})
     */
    public function logoutRedirect(): Response
    {
        return $this->redirect($this->getParameter("app.domain"));
    }
}
