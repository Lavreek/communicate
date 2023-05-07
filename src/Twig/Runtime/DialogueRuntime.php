<?php

namespace App\Twig\Runtime;

use App\Entity\User\Account;
use App\Entity\User\Profile;
use Doctrine\Persistence\ManagerRegistry;
use Twig\Environment;
use Twig\Extension\RuntimeExtensionInterface;

class DialogueRuntime implements RuntimeExtensionInterface
{
    private Environment $twig;
    private ManagerRegistry $registry;

    public function __construct(ManagerRegistry $registry, Environment $twig)
    {
        $this->twig = $twig;
        $this->registry = $registry;
    }

    public function getProfileCard($user_id)
    {
        /** @var Account $profile */
        $profile = $this->registry->getRepository(Account::class)->findOneBy(['id' => $user_id]);

        return $this->twig->render('blocks/user/card.html.twig', [
            'username' => $profile->getUsername(),
            'email' => $profile->getEmail(),
            'id' => $profile->getId()
        ]);
    }
}
