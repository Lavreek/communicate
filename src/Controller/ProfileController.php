<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserInfo;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_route_profile')]
    public function getProfile(ManagerRegistry $registry): Response
    {
        $user = $this->getUser();
        $info = $registry->getRepository(UserInfo::class)->findOneBy(['user_id' => $user->getId()]);

        return $this->render('profile/index.html.twig', [
            'user' => $user,
            'info' => $info,
        ]);
    }
}
