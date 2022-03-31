<?php

namespace VS\Next\Catalog\Infrastructure\Faker;

use Faker\Provider\Base;
use VS\Next\Catalog\Domain\Product\Entity\ProductId;
use VS\Next\Catalog\Domain\Product\Entity\ProductSku;
use VS\Next\Catalog\Domain\Product\Entity\ProductName;
use VS\Next\Catalog\Domain\Product\Entity\ProductStoredStock;
use VS\Next\Shared\Domain\ValueObject\Uuid;

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

    public static function productStoredStock(int $stock, float $cost): ProductStoredStock
    {
        return (new ProductStoredStock())
            ->setStock($stock)
            ->setCost($cost);
    }
}
