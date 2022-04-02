<?php

namespace VS\Next\Checkout\Domain\Cart;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use VS\Next\Checkout\Domain\Cart\CartLine;

class Cart
{
    /** @var ArrayCollection<int, CartLine> */
    private Collection $lines;

    public function __construct()
    {
        $this->lines = new ArrayCollection();
    }

    /** @return ArrayCollection<int, CartLine> */
    public function getLines(): Collection
    {
        return $this->lines;
    }

    public function addLine(CartLine $cartLine): self
    {
        if ($this->lines->contains($cartLine)) {
            return $this;
        }
        $cartLine->setCart($this);

        $this->lines->add($cartLine);

        return $this;
    }

    public function removeLine(CartLine $cartLine): self
    {
        if (!$this->lines->contains($cartLine)) {
            return $this;
        }

        $this->lines->removeElement($cartLine);

        return $this;
    }

    public function findLine(CartLine $lineToFind): ?CartLine
    {
        foreach ($this->lines as $line) {
            if ($line->similar($lineToFind)) {
                return $line;
            }
        }

        return null;
    }

    public function getTotal(): float
    {
        return array_reduce($this->lines->toArray(), function (float $carry, CartLine $line) {
            return $carry + $line->getTotal();
        }, 0);
    }
}
