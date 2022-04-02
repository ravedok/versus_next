<?php

namespace VS\Next\Catalog\Domain\Product\Entity;

use VS\Next\Catalog\Domain\Product\Entity\ProductVirtualStock;

trait ProductStockableTrait
{
    private ProductStoredStock $stored;
    private ProductVirtualStock $virtual;
    private ProductOnDemandStock $onDemand;

    private function stockableDefaultValues(): void
    {
        $this->stored = new ProductStoredStock;
        $this->virtual = new ProductVirtualStock;
        $this->onDemand = new ProductOnDemandStock;
    }

    public function setStockable(bool $stockable): self
    {
        $this->stockable = $stockable;

        return $this;
    }

    public function getStored(): ProductStoredStock
    {
        return $this->stored;
    }

    public function setStored(ProductStoredStock $productStoredStock): self
    {
        $this->stored = $productStoredStock;
        return $this;
    }

    public function getVirtual(): ProductVirtualStock
    {
        return $this->virtual;
    }

    public function setVirtual(ProductVirtualStock $productVirtualStock): self
    {
        $this->virtual = $productVirtualStock;
        return $this;
    }

    public function getOnDemand(): ProductOnDemandStock
    {
        return $this->onDemand;
    }

    public function getAvailableStock(): int
    {
        if (!$this->isStockable()) {
            return 0;
        }

        if ($this->getStored()->getStock()) {
            return $this->getStored()->getStock();
        }

        if ($this->getVirtual()->getStock()) {
            return $this->getVirtual()->getStock();
        }

        if ($this->getOnDemand()->getStock()) {
            return $this->getOnDemand()->getStock();
        }

        return 0;
    }

    public function getPrice(): float
    {
        if ($this->virtual->getPrice()) {
            return $this->virtual->getPrice();
        }

        return $this->stored->getPrice();
    }
}
