<?php

namespace VS\Next\Checkout\Infrastructure\Service\CheckoutResponse;

use VS\Next\Checkout\Domain\Cart\CartLine;
use VS\Next\Checkout\Domain\Cart\CartRepository;

class ContentCreator
{
    public function __construct(private CartRepository $cartRepository)
    {
    }

    /** @return array<string, mixed>  */
    public function __invoke(): array
    {
        return [
            'lines' => $this->getLines()
        ];
    }

    /** @return array<int, array<string, array<string, int|string>|int>>  */
    private function getLines(): array
    {
        $cart = $this->cartRepository->current();

        return $cart->getLines()->map(function (CartLine $line) {

            $product = $line->getProduct();

            return [
                'product' => [
                    'id' => $product->getId()->value(),
                    'sku'   => $product->getSku()->value(),
                    'name' => $product->getName()->value()
                ],
                'units' => $line->getUnits(),
            ];
        })->toArray();
    }
}
