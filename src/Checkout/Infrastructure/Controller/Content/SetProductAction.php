<?php

namespace VS\Next\Checkout\Infrastructure\Controller\Content;

use Symfony\Component\Routing\Annotation\Route;
use VS\Next\Checkout\Application\Content\SetProduct\SetProductRequest;
use VS\Next\Checkout\Infrastructure\Controller\Shared\AbstractHandlerController;

class SetProductAction extends AbstractHandlerController
{
    #[Route('/set', name: 'set', methods: ['POST'])]
    public function __invoke(): void
    {
        $this->handleFromRequest(SetProductRequest::class);
    }
}
