<?php

namespace VS\Next\Checkout\Infrastructure\Service\CheckoutNormalizer;

use VS\Next\Checkout\Domain\Cart\CartRepository;
use VS\Next\Checkout\Infrastructure\Service\VatCalculatorTrait;
use VS\Next\Checkout\Application\Content\Shared\DestinationService;

class ResumeNormalizer
{
    use VatCalculatorTrait;

    public function __construct(private CartRepository $cartRepository, private DestinationService $destination)
    {
    }

    /** @return array<string, float> */
    public function __invoke(): mixed
    {
        $cart = $this->cartRepository->current();

        return [
            'total' => $this->amountWithVat($cart->getTotal())
        ];
    }
}
