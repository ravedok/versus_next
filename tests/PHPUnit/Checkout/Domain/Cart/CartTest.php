<?php

namespace VS\Next\Tests\PHPUnit\Checkout\Domain\Cart;

use PHPUnit\Framework\TestCase;
use VS\Next\Tests\PHPUnit\Catalog\Domain\Product\ProductMother;
use VS\Next\Tests\PHPUnit\Checkout\Domain\Cart\NormalCartLineMother;
use VS\Next\Tests\PHPUnit\Checkout\Domain\Cart\CartMother;

class CartTest extends TestCase
{
    public function test_find_line_succesfully(): void
    {
        $product = ProductMother::get();
        $line = NormalCartLineMother::get($product);
        $searchedLine = NormalCartLineMother::get($product);
        $cart = CartMother::get([
            NormalCartLineMother::get(),
            $line,
            NormalCartLineMother::get()
        ]);

        $lineFound = $cart->findLine($searchedLine);

        $this->assertEquals(true, $lineFound === $line);
    }
}
