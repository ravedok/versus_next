<?php

namespace VS\Next\Catalog\Domain\Product;

use VS\Next\Catalog\Domain\Product\Entity\ProductName;
use VS\Next\Catalog\Domain\Product\Entity\Product;
use VS\Next\Catalog\Domain\Product\Entity\ProductId;
use VS\Next\Catalog\Domain\Product\Entity\ProductType;
use VS\Next\Catalog\Domain\Product\Entity\ProductStockableTrait;
use VS\Next\Catalog\Domain\Product\Entity\ProductStockableInterface;
use VS\Next\Catalog\Domain\Product\Entity\ProductReconditionedStockTrait;
use VS\Next\Catalog\Domain\Product\Entity\ProductReconditionedStockInterface;
use VS\Next\Catalog\Domain\Product\Entity\ProductSku;
use VS\Next\Catalog\Domain\Product\Exception\ProductVariationParentIsNotActiveException;

class VariationProduct extends Product implements ProductStockableInterface, ProductReconditionedStockInterface
{
    use ProductStockableTrait;
    use ProductReconditionedStockTrait;

    private VariableProduct $parent;

    public function __construct(ProductId $id, ProductSku $sku, ProductName $name, VariableProduct $parent)
    {
        parent::__construct($id, $sku, $name);
        $this->type = ProductType::createNormal();
        $this->parent = $parent;
        $this->stockableDefaultValues();
        $this->reconditionedDefaultValues();
    }

    public function getParent(): VariableProduct
    {
        return $this->parent;
    }

    public function ensureIsForDirectSale(): void
    {
        parent::ensureIsForDirectSale();

        if (!$this->getParent()->getStatus()->isActive()) {
            throw ProductVariationParentIsNotActiveException::fromProduct($this);
        }
    }
}
