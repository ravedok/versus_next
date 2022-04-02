<?php

namespace VS\Next\Catalog\Domain\Product;

use VS\Next\Catalog\Domain\Product\Entity\ProductName;
use VS\Next\Catalog\Domain\Product\Entity\Product;
use VS\Next\Catalog\Domain\Product\Entity\ProductType;
use ShoppingCart\Exception\Content\ProductIsNotAllowedAsAnOptionException;
use VS\Next\Catalog\Domain\Product\Entity\ProductId;
use VS\Next\Catalog\Domain\Product\Entity\ProductSku;

class GiftCardProduct extends Product
{
    public function __construct(ProductId $id, ProductSku $sku, ProductName $name)
    {
        parent::__construct($id, $sku, $name);
        $this->stockable = false;
        $this->type = ProductType::createGiftCard();
    }

    public function getPrice(): float
    {
        return 0;
    }

    public function getAvailableStock(): int
    {
        return 9999999;
    }

    public function isStockable(): bool
    {
        return false;
    }

    public function ensureIsAllowedAsAnOption(): void
    {
        throw ProductIsNotAllowedAsAnOptionException::fromProduct($this);
    }
}
