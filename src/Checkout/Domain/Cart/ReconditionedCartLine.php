<?php

namespace VS\Next\Checkout\Domain\Cart;

use VS\Next\Catalog\Domain\Product\Entity\Product;
use VS\Next\Catalog\Domain\Product\Entity\ProductReconditionedStockInterface;
use Versus\Checkout\ShoppingCart\Exception\Content\ProductNotAllowRencoditionedStockException;

class ReconditionedCartLine extends CartLine
{
    /** @var Product&ProductReconditionedStockInterface */
    protected Product $product;

    public function __construct(Product $product, int $units = 0)
    {
        $this->ensureReconditionedAllowed($product);
        $this->type = CartLineType::createReconditioned();
        parent::__construct($product, $units);
    }

    /** @return Product&ProductReconditionedStockInterface */
    public function getProduct(): Product
    {
        return $this->product;
    }

    public function maxUnits(): ?int
    {
        $availableStock = $this->getProduct()->getReconditioned()->getStock();

        foreach ($this->getCart()->getLines() as $cartLine) {
            if (!$cartLine instanceof ReconditionedCartLine) {
                continue;
            }

            if ($this->getProduct() !== $cartLine->getProduct()) {
                continue;
            }

            $availableStock -= $cartLine->getUnits();
        }

        return $availableStock + $this->getUnits();
    }

    public function similar(CartLine $otherLine): bool
    {
        if (!$otherLine instanceof ReconditionedCartLine) {
            return false;
        }

        return $this->getProduct() === $otherLine->getProduct();
    }

    private function ensureReconditionedAllowed(Product $product): void
    {
        if (!($product instanceof ProductReconditionedStockInterface)) {
            throw ProductNotAllowRencoditionedStockException::fromProduct($product);
        }
    }
}
