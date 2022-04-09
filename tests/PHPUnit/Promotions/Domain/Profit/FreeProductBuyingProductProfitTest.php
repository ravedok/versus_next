<?php

namespace VS\Next\Tests\PHPUnit\Promotions\Domain\Profit;

use PHPUnit\Framework\TestCase;
use VS\Next\Checkout\Domain\Cart\CartLine;
use VS\Next\Tests\PHPUnit\Checkout\Domain\Cart\CartMother;
use VS\Next\Tests\PHPUnit\Catalog\Domain\Product\ProductMother;
use VS\Next\Tests\PHPUnit\Checkout\Domain\Cart\NormalCartLineMother;

class FreeProductBuyingProductProfitTest extends TestCase
{
    public function test_that_gift_is_added_correctly(): void
    {
        $lineUnits = 4;
        $cartLine = NormalCartLineMother::get(units: $lineUnits);
        $cart = CartMother::get([$cartLine]);

        $freeProduct = ProductMother::get();
        $profit = FreeProductBuyingProductProfitMother::get($freeProduct);

        $result = $profit->calculateProfitToCartLine($cartLine);

        /** @var CartLine */
        $freeLine = $cart->getLines()->last();

        $this->assertNull($result);
        $this->assertCount(2, $cart->getLines());
        $this->assertEquals($freeProduct, $freeLine->getProduct());
        $this->assertEquals($lineUnits, $freeLine->getUnits());
        $this->assertTrue($freeLine->isFree());
    }
}
