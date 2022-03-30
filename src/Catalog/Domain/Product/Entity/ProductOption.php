<?php

namespace VS\Next\Catalog\Domain\Product\Entity;

use Ramsey\Uuid\UuidInterface;
use VS\Next\Catalog\Domain\Product\VariableProduct;
use VS\Next\Catalog\Domain\Product\Entity\Product;
use VS\Next\Catalog\Domain\Product\Exception\ProductVariableCannotBeAnProductOptionException;

class ProductOption
{
    private UuidInterface $id;
    private Product $productParent;
    private Product $productOption;
    private bool $default;
    private ?string $type;

    public function __construct(UuidInterface $id, Product $productOption, bool $default = false, ?string $type = null)
    {
        $this->id = $id;
        $this->default = $default;
        $this->type = $type;
        $this->productOption = $productOption;

        $this->ensureOptionIsValid();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getProductParent(): Product
    {
        return $this->productParent;
    }

    public function setProductParent(Product $productParent): self
    {
        $this->productParent = $productParent;

        return $this;
    }

    public function getProductOption(): Product
    {
        return $this->productOption;
    }

    public function isDefault(): bool
    {
        return $this->default;
    }

    public function setDefault(bool $default): self
    {
        $this->default = $default;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    private function ensureOptionIsValid(): void
    {
        $productOption = $this->getProductOption();

        if ($productOption instanceof VariableProduct) {
            throw ProductVariableCannotBeAnProductOptionException::fromProduct($productOption);
        }
    }
}
