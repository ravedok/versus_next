<?php

namespace VS\Next\Checkout\Infrastructure\Controller;

use Symfony\Component\Routing\Annotation\Route;
use VS\Next\Checkout\Infrastructure\Controller\Shared\AbstractHandlerController;

class CheckoutDataAction extends AbstractHandlerController
{
    #[Route('/', name: 'data', methods: ['GET'])]
    public function __invoke(): void
    {
    }
}
