<?php

namespace App\Controller;

use App\Entity\User\Account;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    #[Route('/users', name: 'app_users')]
    public function index(ManagerRegistry $registry): Response
    {
        $users = $registry->getRepository(Account::class)->findAll();

        return $this->render('users/dialogs.html.twig', [
            'users' => $users,
        ]);
    }
}
