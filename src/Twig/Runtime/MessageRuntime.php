<?php

namespace App\Twig\Runtime;

use App\Entity\Messages\Letter;
use Doctrine\Persistence\ManagerRegistry;
use Twig\Extension\RuntimeExtensionInterface;

class MessageRuntime implements RuntimeExtensionInterface
{
    private ManagerRegistry $registry;

    public function __construct(ManagerRegistry $registry)
    {
        // Inject dependencies if needed
        $this->registry = $registry;
    }

    public function getMessage($message_id)
    {
        /** @var Letter $letter */
        $letter = $this->registry->getRepository(Letter::class)->findOneBy(['id' => $message_id]);

        echo $letter->getMessage();
    }
}
