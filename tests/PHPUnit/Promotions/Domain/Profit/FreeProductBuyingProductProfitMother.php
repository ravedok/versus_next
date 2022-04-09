<?php

namespace VS\Next\Tests\PHPUnit\Promotions\Domain\Profit;

use VS\Next\Promotions\Domain\Profit\ProfitId;
use VS\Next\Catalog\Domain\Product\Entity\Product;
use VS\Next\Tests\PHPUnit\Catalog\Domain\Product\ProductMother;
use VS\Next\Promotions\Domain\Profit\Types\FreeProductBuyingProductProfit;

class FreeProductBuyingProductProfitMother
{
    public static function get(?Product $product = null): FreeProductBuyingProductProfit
    {
        return new FreeProductBuyingProductProfit(
            ProfitId::random(),
            $product ?: ProductMother::get()
        );
    }
}
