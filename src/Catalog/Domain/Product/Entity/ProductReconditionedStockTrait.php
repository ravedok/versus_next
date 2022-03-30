<?php

namespace VS\Next\Catalog\Domain\Product\Entity;

use VS\Next\Catalog\Domain\Product\Entity\ProductReconditionedStock;

trait ProductReconditionedStockTrait
{
    private ProductReconditionedStock $reconditioned;

    private function reconditionedDefaultValues(): void
    {
        $this->reconditioned = new ProductReconditionedStock;
    }

    public function getReconditioned(): ProductReconditionedStock
    {
        return $this->reconditioned;
    }
}
