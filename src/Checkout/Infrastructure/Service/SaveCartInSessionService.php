<?php

namespace VS\Next\Checkout\Infrastructure\Service;

use Argent\ShopBundle\Entity\CartLine;
use Argent\ShopBundle\Model\CartLineInterface;
use VS\Next\Checkout\Domain\Cart\Cart;
use VS\Next\Checkout\Infrastructure\Helper\CartSessionHelper;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use VS\Next\Checkout\Domain\Cart\CartLine as CartCartLine;

class SaveCartInSessionService
{
    public function __construct(private SessionInterface $session)
    {
    }

    public function __invoke(Cart $cart): void
    {
        $data = $this->cartToArray($cart);

        $this->session->set(CartSessionHelper::SESSION_CART_KEY, $data);
    }

    /** @return array<string, array<int, array<string, int>>> */
    private function cartToArray(Cart $cart): array
    {
        $data = [];

        $data['lines'] = $cart->getLines()->map(function (CartCartLine $line) {
            $product = $line->getProduct();
            return [
                'id'         => $product->getId()->value(),
                'units'      => $line->getUnits()
            ];
        })->toArray();

        return $data;
    }
}
