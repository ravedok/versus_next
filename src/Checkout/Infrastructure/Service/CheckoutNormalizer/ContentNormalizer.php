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
                ],
                'offer' => $this->getOfferFromDiscount($line),
                'price' => $this->currencyWithVat($line->getPrice()),
                'units' => $line->getUnits(),
                'total' => $this->currencyWithVat($line->getTotal())
            ];
        })->toArray();
    }

    private function getOfferFromDiscount(CartLine $line): ?array
    {
        if (!$discount = $line->getAppliedDiscount()) {
            return null;
        }

        $previous = $this->addVat($line->getProduct()->getPrice());
        // $current = $this->addVat($discount->getDiscountedPrice());
        // $type = $discount->getType();
        $amount = $discount->getValue();

        if ($discount->getType()->isAmount()) {
            $amount = $this->currencyWithVat($amount);
        }

        return [
            'amount' => $amount,
            'previous' => round($previous, 2),
            'type' => $discount->getType()->value()
        ];
    }
}
