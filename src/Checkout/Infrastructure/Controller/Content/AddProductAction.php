<?php

namespace VS\Next\Checkout\Infrastructure\Controller\Content;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use VS\Next\Checkout\Application\Content\AddProduct\AddProductRequest;
use VS\Next\Checkout\Infrastructure\Controller\Shared\AbstractHandlerController;

class AddProductAction extends AbstractHandlerController
{
    #[Route('/add', name: 'add', methods: ['POST'])]
    public function __invoke(Request $request): void
    {
        $this->handle(AddProductRequest::fromArray($request->toArray()));
    }
}
