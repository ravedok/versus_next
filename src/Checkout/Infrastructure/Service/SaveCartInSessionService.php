<?php

namespace VS\Next\Checkout\Infrastructure\Service;

use VS\Next\Checkout\Domain\Cart\Cart;
use Symfony\Component\HttpFoundation\RequestStack;
use VS\Next\Checkout\Domain\Cart\CartLine as CartCartLine;
use VS\Next\Checkout\Infrastructure\Helper\CartSessionHelper;

class SaveCartInSessionService
{
    public function __construct(private RequestStack $requestStack)
    {
    }

    public function __invoke(Cart $cart): void
    {
        $data = $this->cartToArray($cart);

        $session = $this->requestStack->getSession();

        $session->set(CartSessionHelper::SESSION_CART_KEY, $data);
    }

    /** @return array<string, array<int, array<string, int|string>>> */
    private function cartToArray(Cart $cart): array
    {
        $data = [];

        $data['lines'] = $cart->getLines()->map(function (CartCartLine $line) {
            $product = $line->getProduct();
            return [
                'productId'         => $product->getId()->value(),
                'units'      => $line->getUnits()
            ];
        })->toArray();

        return $data;
    }
}
