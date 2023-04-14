<?php

namespace App\Twig\Runtime;

use App\Entity\Messages\Attachments;
use Doctrine\Persistence\ManagerRegistry;
use Twig\Extension\RuntimeExtensionInterface;

class AttachmentRuntime implements RuntimeExtensionInterface
{
    private readonly ManagerRegistry $registry;

    public function __construct(ManagerRegistry $registry)
    {
        // Inject dependencies if needed
        $this->registry = $registry;
    }

    public function getAttachment($id)
    {
        return $this->registry->getRepository(Attachments::class)->findOneBy(['id' => $id]);
    }

    public function revertFormFloating($formRow) {
        preg_match('#\<label.+label\>#', $formRow, $match);
        $formRow = str_replace($match[0], '', $formRow);
        echo str_replace('</div>', $match[0] . "</div>", $formRow);
    }

    public function doSomething($value)
    {
        // ...
    }
}
