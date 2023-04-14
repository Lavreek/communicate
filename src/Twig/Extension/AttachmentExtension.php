<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\AttachmentRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AttachmentExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            new TwigFilter('filter_name', [AttachmentRuntime::class, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('revertFormFloating', [AttachmentRuntime::class, 'revertFormFloating']),
            new TwigFunction('getAttachment', [AttachmentRuntime::class, 'getAttachment']),
            new TwigFunction('function_name', [AttachmentRuntime::class, 'doSomething']),
        ];
    }
}
