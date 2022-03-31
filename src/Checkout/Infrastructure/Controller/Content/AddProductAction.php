<?php

namespace VS\Next\Checkout\Infrastructure\Controller\Content;

use Symfony\Component\Routing\Annotation\Route;
use VS\Next\Checkout\Application\Content\AddProduct\AddProductRequest;
use VS\Next\Checkout\Infrastructure\Controller\Shared\AbstractHandlerController;

class AddProductAction extends AbstractHandlerController
{
    #[Route('/add', name: 'add', methods: ['POST'])]
    public function __invoke(): void
    {
        $this->handleFromRequest(AddProductRequest::class);
    }
}
