<?php

namespace VS\Next\Checkout\Infrastructure\Repository;

use VS\Next\Checkout\Domain\Cart\Cart;
use VS\Next\Checkout\Domain\Cart\CartLine;
use VS\Next\Checkout\Domain\Cart\CartRepository;
use VS\Next\Checkout\Infrastructure\Service\CartFromSessionFactory;
use VS\Next\Checkout\Infrastructure\Service\SaveCartInSessionService;

class CartSessionRepository implements CartRepository
{
    private Cart $cart;

    public function __construct(
        private CartFromSessionFactory $cartFromSessionFactory,
        private SaveCartInSessionService $saveCartInSessionService

    ) {
    }

    public function save(): void
    {
        ($this->saveCartInSessionService)($this->current());
    }

    public function current(): Cart
    {
        if (!isset($this->cart)) {
            $this->cart = ($this->cartFromSessionFactory)();
        }

        return $this->cart;
    }

    public function undoChanges(Cart|CartLine $object): void
    {
    }

    public function removeLine(CartLine $cartLine): void
    {
    }
}
