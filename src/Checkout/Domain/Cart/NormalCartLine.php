<?php

namespace VS\Next\Checkout\Domain\Cart;

use VS\Next\Catalog\Domain\Product\Entity\Product;
use VS\Next\Checkout\Domain\Cart\CustomizedCartLine;

class NormalCartLine extends CartLine
{
    public function __construct(Product $product, int $units = 0)
    {
        $this->type = CartLineType::createNormal();
        parent::__construct($product, $units);
    }

    public function maxUnits(): ?int
    {
        $availableStock = $this->getProduct()->getAvailableStock();

        foreach ($this->getCart()->getLines() as $cartLine) {

            if (!$cartLine instanceof NormalCartLine && !$cartLine instanceof CustomizedCartLine) {
                continue;
            }

            if ($this->getProduct() === $cartLine->getProduct()) {
                $availableStock -= $cartLine->getUnits();
            }

            /** @var CustomizedCartLine $cartLine */
            if (!$cartLine instanceof CustomizedCartLine) {
                continue;
            }

            foreach ($cartLine->getOptions() as $option) {
                if ($this->getProduct() === $option->getProduct()) {
                    $availableStock -= $cartLine->getUnits() * $option->getUnits();
                }
            }
        }

        return $availableStock + $this->getUnits();
    }

    public function similar(CartLine $otherLine): bool
    {
        if (!$otherLine instanceof NormalCartLine) {
            return false;
        }

        return $this->getProduct()->getId()->equals($otherLine->getProduct()->getId());
    }
}
