<?php

namespace VS\Next\Catalog\Infrastructure\Faker;

use DateTime;
use Faker\Provider\Base;
use VS\Next\Catalog\Domain\Product\Entity\DiscountType;
use VS\Next\Catalog\Domain\Product\Entity\ProductId;
use VS\Next\Catalog\Domain\Product\Entity\ProductSku;
use VS\Next\Catalog\Domain\Product\Entity\ProductName;
use VS\Next\Catalog\Domain\Product\Entity\ProductOffer;
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

    public static function productOffer(bool $active = false, float $price = 0, ?DiscountType $type = null, ?DateTime $start = null, ?DateTime $end = null): ProductOffer
    {
        return (new ProductOffer($active, $price, $type, $start, $end));
    }

    public static function discountTypeAmount(): DiscountType
    {
        return DiscountType::createAmount();
    }

    public static function discountTypePercent(): DiscountType
    {
        return DiscountType::createPercent();
    }
}
