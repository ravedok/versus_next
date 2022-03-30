<?php

namespace VS\Next\Checkout\Domain\Cart;

interface CartRepository
{
    public function current(): Cart;
    public function undoChanges(Cart | CartLine $object): void;
    public function removeLine(CartLine $cartLine): void;
    public function save(): void;
}
