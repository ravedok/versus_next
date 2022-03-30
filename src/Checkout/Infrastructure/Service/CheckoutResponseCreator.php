<?php

namespace VS\Next\Checkout\Infrastructure\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use VS\Next\Checkout\Infrastructure\Service\CheckoutResponse\ContentCreator;

class CheckoutResponseCreator
{
    public function __construct(
        private ContentCreator $contentCreator
    ) {
    }

    /** @return array<string, mixed> */
    public function __invoke(): array
    {
        return [
            'content' => ($this->contentCreator)()
        ];
    }
}
