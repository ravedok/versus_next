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
    private Category $category;

    public function test_if_cart_line_is_valid_success(): void
    {
        $judgment = $this->getJudgment();
        $cartLine = $this->getCartLine();

        $applicable = JudgmentToCartLineChecker::check($judgment, $cartLine);

        $this->assertEquals(true, $applicable);
    }

    public function test_is_product_category_is_empty_fail(): void
    {
        $judgment = $this->getJudgment();

        $product = (ProductMother::get())->setCategory(null);

        $cartLine = $this->getCartLine(product: $product);

        $applicable = JudgmentToCartLineChecker::check($judgment, $cartLine);

        $this->assertEquals(false, $applicable);
    }

    public function test_is_product_category_is_invalid_fail(): void
    {

        $otherCategory = CategoryMother::get();

        $product = (ProductMother::get())->setCategory($otherCategory);

        $judgment = $this->getJudgment();
        $cartLine = $this->getCartLine($product);

        $applicable = JudgmentToCartLineChecker::check($judgment, $cartLine);

        $this->assertEquals(false, $applicable);
    }

    public function test_profit_does_not_affect_a_line_fail(): void
    {
        $profit = CartAmountDiscountProfitMother::get();
        $judgment = $this->getJudgment(profit: $profit);
        $cartLine = $this->getCartLine();

        $applicable = JudgmentToCartLineChecker::check($judgment, $cartLine);

        $this->assertEquals(false, $applicable);
    }

    public function test_is_profit_is_null_fail(): void
    {
        $judgment = $this->getJudgment()
            ->setProfit(null);

        $cartLine = NormalCartLineMother::get();

        $applicable = JudgmentToCartLineChecker::check($judgment, $cartLine);

        $this->assertEquals(false, $applicable);
    }

    private function getJudgment(?Profit $profit = null): Judgment
    {
        if ($profit === null) {
            $profit = ProductPercentProfitMother::get();
        }

        $judgment = JudgmentMother::get($profit)
            ->addCategory($this->getCategory());


        return $judgment;
    }

    private function getCartLine(?Product $product = null): CartLine
    {
        if ($product === null) {
            $product = ProductMother::get()
                ->setCategory($this->category);
        }

        return NormalCartLineMother::get($product);
    }

    private function getCategory(): Category
    {
        if (!isset($this->category)) {
            $this->category = CategoryMother::get();
        }

        return $this->category;
    }
}
