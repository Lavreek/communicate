<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    #[Route('/users', name: 'app_route_users')]
    public function index(ManagerRegistry $registry): Response
    {
        $users = $registry->getRepository(User::class)->findAll();

        return $this->render('users/index.html.twig', [
            'users' => $users,
            'controller_name' => 'UsersController',
        ]);
    }
}
