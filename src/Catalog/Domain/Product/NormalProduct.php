<?php

namespace VS\Next\Catalog\Domain\Product;

use VS\Next\Catalog\Domain\Product\Entity\Product;
use VS\Next\Catalog\Domain\Product\Entity\ProductId;
use VS\Next\Catalog\Domain\Product\Entity\ProductSku;
use VS\Next\Catalog\Domain\Product\Entity\ProductName;
use VS\Next\Catalog\Domain\Product\Entity\ProductType;
use VS\Next\Catalog\Domain\Product\Entity\ProductStockableTrait;
use VS\Next\Catalog\Domain\Product\Entity\ProductStockableInterface;
use VS\Next\Catalog\Domain\Product\Entity\ProductCustomizableStockTrait;
use VS\Next\Catalog\Domain\Product\Entity\ProductReconditionedStockTrait;
use VS\Next\Catalog\Domain\Product\Entity\ProductCustomizableStockInterface;
use VS\Next\Catalog\Domain\Product\Entity\ProductReconditionedStockInterface;

class NormalProduct extends Product implements ProductStockableInterface, ProductReconditionedStockInterface, ProductCustomizableStockInterface
{
    use ProductStockableTrait;
    use ProductReconditionedStockTrait;
    use ProductCustomizableStockTrait;

    public function __construct(ProductId $id, ProductSku $sku, ProductName $name)
    {
        parent::__construct($id, $sku, $name);
        $this->type = ProductType::createNormal();
        $this->stockableDefaultValues();
        $this->reconditionedDefaultValues();
        $this->customizableDefaultValues();
    }
}
