<?php

namespace VS\Next\Catalog\Domain\Product\Entity;

class ProductOnDemandStock
{
    private int $stock;
    private float $cost;

    public function __construct()
    {
        $this->stock = 0;
        $this->cost = 0;
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

    public function getCost(): float
    {
        return $this->cost;
    }

    public function setCost(float $cost): self
    {
        $this->cost = $cost;

        return $this;
    }
}
