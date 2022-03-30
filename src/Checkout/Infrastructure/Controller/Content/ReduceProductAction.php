<?php

namespace VS\Next\Checkout\Infrastructure\Controller\Content;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use VS\Next\Checkout\Infrastructure\Controller\Shared\CartLineOptionDto;
use VS\Next\Checkout\Application\Content\ReduceProduct\ReduceProductRequest;
use VS\Next\Checkout\Infrastructure\Controller\Shared\AbstractHandlerController;

class ReduceProductAction extends AbstractHandlerController
{
    #[Route('/reduce', name: 'reduce', methods: ['POST'])]
    public function __invoke(Request $request): void
    {
        $data = $request->toArray();

        $this->handle(ReduceProductRequest::fromArray($data));
    }
}
