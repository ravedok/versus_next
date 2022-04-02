<?php

namespace VS\Next\Catalog\Infrastructure\Faker;

use Faker\Provider\Base;
use VS\Next\Catalog\Domain\Product\Entity\ProductId;
use VS\Next\Catalog\Domain\Product\Entity\ProductSku;
use VS\Next\Catalog\Domain\Product\Entity\ProductName;
use VS\Next\Catalog\Domain\Product\Entity\ProductStoredStock;
use VS\Next\Catalog\Domain\Product\Entity\ProductVirtualStock;

class ProductProvider extends Base
{
    public static function productId(): ProductId
    {
        return ProductId::random();
    }

    public static function productSkuFromString(string $sku): ProductSku
    {
        return ProductSku::fromString($sku);
    }

    public static function productNameFromString(string $name): ProductName
    {
        return ProductName::fromString($name);
    }

    public static function productStoredStock(int $stock, float $cost, float $price): ProductStoredStock
    {
        return (new ProductStoredStock())
            ->setStock($stock)
            ->setCost($cost)
            ->setPrice($price);
    }

    public static function productVirtualStock(int $stock, float $cost, float $price): ProductVirtualStock
    {
        return (new ProductVirtualStock())
            ->setStock($stock)
            ->setCost($cost)
            ->setPrice($price);
    }
}
