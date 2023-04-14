<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LogoutController extends AbstractController
{
    #[Route('/logout', name: 'app_route_logout')]
    public function index(): Response
    {
        return $this->render('logout/dialogs.html.twig', [
            'controller_name' => 'LogoutController',
        ]);
    }
}
