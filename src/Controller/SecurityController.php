<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/connexion', name: 'security.login', methods: ['get','post'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        // last email entered by the user
        $lastEmail = $authenticationUtils->getLastUsername();

        return $this->render('pages/security/login.html.twig', [
            'last_email' => $lastEmail,
            'error' => $error,
        ]);
    }


    #[Route('/deconnexion', name: 'security.logout', methods: ['GET'])]
    public function logout(): never
    {
        // controller can be blank: it will never be called!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}
