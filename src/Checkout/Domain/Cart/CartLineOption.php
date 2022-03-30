<?php

namespace VS\Next\Checkout\Domain\Cart;

use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Nonstandard\Uuid;
use VS\Next\Catalog\Domain\Product\Entity\Product;
use VS\Next\Checkout\Domain\Cart\CartLine;

class CartLineOption
{
    private UuidInterface $id;
    private CartLine $cartLine;
    private Product $product;
    private ?string $type;
    private int $units;

    public function __construct(
        Product $product,
        ?string $type,
        int $units
    ) {
        $this->id = Uuid::uuid4();
        $this->product = $product;
        $this->type = $type;
        $this->units = $units;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getCartLine(): CartLine
    {
        return $this->cartLine;
    }

    public function setCartLine(CartLine $cartLine): self
    {
        $this->cartLine = $cartLine;

        return $this;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getUnits(): int
    {
        return $this->units;
    }

    public function similar(CartLineOption $otherOption): bool
    {
        if ($this->getProduct() !== $otherOption->getProduct()) {
            return false;
        }

        if ($this->getType() !== $otherOption->getType()) {
            return false;
        }

        if ($this->getUnits() !== $otherOption->getUnits()) {
            return false;
        }

        return  true;
    }
}
