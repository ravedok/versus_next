<?php

namespace VS\Next\Tests\Unitary\Checkout\Domain\Cart;

use PHPUnit\Framework\TestCase;
use VS\Next\Tests\Unitary\Catalog\Domain\Product\VariationProductMother;
use VS\Next\Tests\Unitary\Catalog\Domain\Product\ProductMother;
use VS\Next\Tests\Unitary\Checkout\Domain\Cart\NormalCartLineMother;

class CartLineTest extends TestCase
{
    public function test_compare_similar(): void
    {
        $product = ProductMother::get();
        $cartLine = NormalCartLineMother::get(product: $product);
        $comparedCartLine = NormalCartLineMother::get(product: $product);

        $this->assertEquals(true, $cartLine->similar($comparedCartLine));
    }

    public function test_distinct_product(): void
    {
        $cartLine = NormalCartLineMother::get();
        $comparedCartLine = NormalCartLineMother::get();

        $this->assertEquals(false, $cartLine->similar($comparedCartLine));
    }

    public function test_compare_variation_similar(): void
    {
        $variation = VariationProductMother::get();
        $cartLine = NormalCartLineMother::get($variation);
        $comparedCartLine = NormalCartLineMother::get($variation);

        $this->assertEquals(true, $cartLine->similar($comparedCartLine));
    }

    public function test_distinct_variation(): void
    {
        $cartLine = NormalCartLineMother::get(VariationProductMother::get());
        $comparedCartLine = NormalCartLineMother::get(VariationProductMother::get());

        $this->assertEquals(false, $cartLine->similar($comparedCartLine));
    }

    public function test_compare_reconditioned_similar(): void
    {
        $product = ProductMother::get();
        $cartLine = ReconditionedCartLineMother::get(product: $product);
        $comparedCartLine = ReconditionedCartLineMother::get(product: $product);

        $this->assertEquals(true, $cartLine->similar($comparedCartLine));
    }

    public function test_distinct_reconditioned(): void
    {
        $product = ProductMother::get();
        $cartLine = ReconditionedCartLineMother::get(product: $product);
        $comparedCartLine = NormalCartLineMother::get(product: $product);

        $this->assertEquals(false, $cartLine->similar($comparedCartLine));
    }

    public function test_compare_options_similar(): void
    {
        $product = ProductMother::getCustomizable();
        $options = [
            CartLineOptionMother::get(),
            CartLineOptionMother::get()
        ];

        $cartLine = CustomizedCartLineMother::get(product: $product, options: $options);
        $comparedCartLine = CustomizedCartLineMother::get(product: $product, options: $options);

        $this->assertEquals(true, $cartLine->similar($comparedCartLine));
    }

    public function test_compare_options_distinct(): void
    {
        $product = ProductMother::getCustomizable();
        $cartLine = CustomizedCartLineMother::get(product: $product, options: [
            CartLineOptionMother::get(),
            CartLineOptionMother::get()
        ]);
        $comparedCartLine = CustomizedCartLineMother::get(product: $product, options: $options = [
            CartLineOptionMother::get(),
            CartLineOptionMother::get()
        ]);

        $this->assertEquals(false, $cartLine->similar($comparedCartLine));
    }
}
