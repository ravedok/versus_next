<?php

namespace VS\Next\Catalog\Domain\Product\Entity;

class ProductReconditionedStock
{
    private int $stock;
    private float $cost;
    private float $price;

    public function __construct()
    {
        $this->stock = 0;
        $this->cost = 0;
        $this->price = 0;
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

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }
}
