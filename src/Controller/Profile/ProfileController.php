<?php

namespace App\Controller\Profile;

use App\Entity\User\Account;
use App\Entity\User\Profile;
use App\Form\User\ProfileType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function profile(Request $request, ManagerRegistry $registry): Response
    {
        $profile = $registry->getRepository(Profile::class)->findOneBy(['u_id' => $this->getUser()->getId()]);

        return $this->render('profile/index.html.twig', [
            'profile' => $profile,
        ]);
    }

    #[Route('/profile/edit', name: 'app_profile_edit')]
    public function profileEdit(Request $request, ManagerRegistry $registry): Response
    {
        $profileRepo = $registry->getRepository(Profile::class);
        $profileForm = $this->createForm(ProfileType::class);
        $profileForm->handleRequest($request);

        /** @var Profile $profile */
        $profile = $profileRepo->findOneBy(['u_id' => $this->getUser()->getId()]);

        if ($profileForm->isSubmitted() and $profileForm->isValid()) {
            /** @var Profile $task */
            $task = $profileForm->getData();

            $profile->setFirstname($task->getFirstname());
            $profile->setSecondname($task->getSecondname());
            $profile->setBirthday($task->getBirthday());

            $profileRepo->save($profile, true);

            return $this->redirectToRoute('app_profile');
        }

        if (!$profileForm->isSubmitted()) {
            $profileForm->setData($profile);
        }

        return $this->render('profile/edit.html.twig', [
            'profile' => $profileForm->createView(),
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
