<?php

namespace VS\Next\Tests\PHPUnit\Checkout\Domain\Cart;

use PHPUnit\Framework\TestCase;
use VS\Next\Tests\PHPUnit\Catalog\Domain\Product\ProductMother;

class CartLineOptionTest extends TestCase
{
    public function test_if_compare_similar(): void
    {
        $product = ProductMother::get();
        $baseOption = CartLineOptionMother::get(product: $product);
        $coparedOption = CartLineOptionMother::get(product: $product);

        $this->assertEquals(true, $baseOption->similar($coparedOption));
    }

    public function test_if_compare_distint_product(): void
    {
        $baseOption = CartLineOptionMother::get();
        $coparedOption = CartLineOptionMother::get();

        $this->assertEquals(false, $baseOption->similar($coparedOption));
    }

    public function test_if_compare_distinct_type(): void
    {
        $product = ProductMother::get();
        $baseOption = CartLineOptionMother::get(product: $product);
        $coparedOption = CartLineOptionMother::get(product: $product, type: 'TYPE');

        $this->assertEquals(false, $baseOption->similar($coparedOption));
    }

    public function test_if_compare_distinct_units(): void
    {
        $product = ProductMother::get();
        $baseOption = CartLineOptionMother::get(product: $product);
        $coparedOption = CartLineOptionMother::get(product: $product, units: 2);

        $this->assertEquals(false, $baseOption->similar($coparedOption));
    }
}
