<?php

namespace VS\Next\Checkout\Infrastructure\Service\CheckoutNormalizer;

use VS\Next\Checkout\Application\Content\Shared\DestinationService;
use VS\Next\Checkout\Domain\Cart\CartLine;
use VS\Next\Checkout\Domain\Cart\CartRepository;
use VS\Next\Checkout\Infrastructure\Service\VatCalculatorTrait;

class ContentNormalizer
{
    use VatCalculatorTrait;

    public function __construct(private CartRepository $cartRepository, private DestinationService $destination)
    {
    }

    /** @return array<string, mixed>  */
    public function __invoke(): array
    {
        return [
            'lines' => $this->getLines()
        ];
    }

    /** @return array<int, array<string, mixed>>  */
    private function getLines(): array
    {
        $cart = $this->cartRepository->current();

        return $cart->getLines()->map(function (CartLine $line) {

            $product = $line->getProduct();

            return [
                'product' => [
                    'id' => $product->getId()->value(),
                    'sku'   => $product->getSku()->value(),
                    'name' => $product->getName()->value(),
                    'price' => $this->amountWithVat($product->getPrice())
                ],
                'units' => $line->getUnits(),
                'total' => $this->amountWithVat($line->getTotal())
            ];
        })->toArray();
    }
}
