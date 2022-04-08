<?php

namespace VS\Next\Tests\PHPUnit\Promotions\Domain\Judgment;

use PHPUnit\Framework\TestCase;
use VS\Next\Checkout\Domain\Cart\CartLine;
use VS\Next\Promotions\Domain\Profit\Profit;
use VS\Next\Catalog\Domain\Category\Category;
use VS\Next\Promotions\Domain\Judgment\Judgment;
use VS\Next\Catalog\Domain\Product\Entity\Product;
use VS\Next\Tests\PHPUnit\Catalog\Domain\Product\ProductMother;
use VS\Next\Promotions\Domain\Judgment\JudgmentToCartLineChecker;
use VS\Next\Tests\PHPUnit\Catalog\Domain\Category\CategoryMother;
use VS\Next\Tests\PHPUnit\Checkout\Domain\Cart\NormalCartLineMother;
use VS\Next\Tests\PHPUnit\Promotions\Domain\Profit\CartAmountDiscountProfitMother;
use VS\Next\Tests\PHPUnit\Promotions\Domain\Profit\ProductPercentProfitMother;

class JudgmentToCartLineCheckerTest extends TestCase
{
    public function test_if_cart_line_is_valid_success(): void
    {
        $category = CategoryMother::get();
        $product = ProductMother::get()
            ->setCategory($category);
        $judgment = $this->createJudgment()
            ->addProductIncluded($product)
            ->addCategory($category);
        $cartLine = $this->createCartLine($product);

        $applicable = JudgmentToCartLineChecker::check($judgment, $cartLine);

        $this->assertTrue($applicable);
    }

    public function test_is_product_category_is_empty_fail(): void
    {
        $category = CategoryMother::get();
        $judgment = $this->createJudgment()->addCategory($category);

        $product = (ProductMother::get())->setCategory(null);

        $cartLine = $this->createCartLine(product: $product);

        $applicable = JudgmentToCartLineChecker::check($judgment, $cartLine);

        $this->assertFalse($applicable);
    }

    public function test_is_product_category_is_invalid_fail(): void
    {
        $category = CategoryMother::get();
        $otherCategory = CategoryMother::get();

        $product = (ProductMother::get())->setCategory($category);

        $judgment = $this->createJudgment()->addCategory($otherCategory);
        $cartLine = $this->createCartLine($product);

        $applicable = JudgmentToCartLineChecker::check($judgment, $cartLine);

        $this->assertFalse($applicable);
    }

    public function test_profit_does_not_affect_a_line_fail(): void
    {
        $profit = CartAmountDiscountProfitMother::get();
        $judgment = $this->createJudgment(profit: $profit);
        $cartLine = $this->createCartLine();

        $applicable = JudgmentToCartLineChecker::check($judgment, $cartLine);

        $this->assertFalse($applicable);
    }

    public function test_is_profit_is_null_fail(): void
    {
        $judgment = $this->createJudgment()
            ->setProfit(null);

        $cartLine = NormalCartLineMother::get();

        $applicable = JudgmentToCartLineChecker::check($judgment, $cartLine);

        $this->assertFalse($applicable);
    }

    public function test_if_product_not_included_fail(): void
    {
        $product = ProductMother::get();
        $cartLine = $this->createCartLine($product);
        $otherProduct = ProductMother::get();
        $judgment = $this->createJudgment()->addProductIncluded($otherProduct);


        $applicable = JudgmentToCartLineChecker::check($judgment, $cartLine);

        $this->assertFalse($applicable);
    }

    public function test_if_product_included_true(): void
    {
        $product = ProductMother::get();
        $cartLine = $this->createCartLine($product);
        $judgment = $this->createJudgment()->addProductIncluded($product);

        $applicable = JudgmentToCartLineChecker::check($judgment, $cartLine);

        $this->assertTrue($applicable);
    }

    private function createJudgment(?Profit $profit = null): Judgment
    {
        if ($profit === null) {
            $profit = ProductPercentProfitMother::get();
        }

        $judgment = JudgmentMother::get($profit);


        return $judgment;
    }

    private function createCartLine(?Product $product = null): CartLine
    {
        if ($product === null) {
            $product = ProductMother::get();
        }

        return NormalCartLineMother::get($product);
    }
}
