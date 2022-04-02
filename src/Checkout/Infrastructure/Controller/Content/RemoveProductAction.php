<?php

namespace VS\Next\Checkout\Infrastructure\Controller\Content;

use Symfony\Component\Routing\Annotation\Route;
use VS\Next\Checkout\Application\Content\RemoveProduct\RemoveProductRequest;
use VS\Next\Checkout\Infrastructure\Controller\Shared\AbstractHandlerController;

class RemoveProductAction extends AbstractHandlerController
{
    #[Route('/remove', name: 'remove', methods: ['POST'])]
    public function __invoke(): void
    {
        $this->handleFromRequest(RemoveProductRequest::class);
    }
}
