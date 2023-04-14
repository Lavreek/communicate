<?php

namespace App\Controller\Profile;

use App\Entity\Profile\Profiles;
use App\Entity\User\Account;
use App\Form\Profile\ProfileType;
use App\Form\User\AccountType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function getProfile(Request $request, ManagerRegistry $registry): Response
    {
        $profile = $this->createForm(ProfileType::class);
        $profile->handleRequest($request);

        if ($profile->isSubmitted() && $profile->isValid()) {

        }

        $user = $this->createForm(AccountType::class);
        $user->handleRequest($request);

        if ($user->isSubmitted() && $user->isValid()) {

        }
        $account = $this->getUser();
        $info = $registry->getRepository(Profiles::class)->findOneBy(['user_id' => $user->getId()]);

        return $this->render('profile/index.html.twig', [
            'form-profile' => $profile,
            'form-user' => $user,
            'account' => $account,
        ]);
    }

    #[Route('/profile/{id}', name: 'app_route_profile_page')]
    public function getProfilePage(ManagerRegistry $registry, $id): Response
    {
        $auth = $this->getUser();
        $control = true;
        $user = $registry->getRepository(Account::class)->findOneBy(['id' => $id]);
        $info = $registry->getRepository(Profiles::class)->findOneBy(['user_id' => $id]);

        if ($auth->getUserIdentifier() != $id) {
            $control = false;
        }

        return $this->render('profile/profile_page.html.twig', [
            'user' => $user,
            'info' => $info,
            'control' => $control,
        ]);
    }

}
