<?php

namespace VS\Next\Catalog\Domain\Product;

use VS\Next\Catalog\Domain\Product\Entity\ProductName;
use VS\Next\Catalog\Domain\Product\Entity\Product;
use VS\Next\Catalog\Domain\Product\Entity\ProductId;
use VS\Next\Catalog\Domain\Product\Entity\ProductType;
use VS\Next\Catalog\Domain\Product\Entity\ProductRedeemableStock;
use VS\Next\Catalog\Domain\Product\Entity\ProductSku;

class RedeemableProduct extends Product
{
    private ProductRedeemableStock $redeemable;

    public function __construct(ProductId $id, ProductSku $sku, ProductName $name)
    {
        parent::__construct($id, $sku, $name);
        $this->type = ProductType::createRedeemable();
        $this->redeemable = new ProductRedeemableStock;
        $this->stockable = true;
    }

    public function getPrice(): float
    {
        return $this->redeemable->getPrice();
    }

    public function isRedeemable(): bool
    {
        return $this->getRedeemable()->isRedeemable();
    }

    public function getRedeemable(): ProductRedeemableStock
    {
        return $this->redeemable;
    }

    public function getAvailableStock(): int
    {
        return $this->getRedeemable()->getStock();
    }
}
