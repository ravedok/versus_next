<?php

namespace VS\Next\Catalog\Domain\Product\Entity;

class ProductCustomizableStock
{
    private bool $customizable;
    private int $stock;

    public function __construct()
    {
        $this->customizable = false;
        $this->stock = 0;
    }

    public function isCustomizable(): bool
    {
        return $this->customizable;
    }

    public function setCustomizable(bool $customizable): self
    {
        $this->customizable = $customizable;

        return $this;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }
}
