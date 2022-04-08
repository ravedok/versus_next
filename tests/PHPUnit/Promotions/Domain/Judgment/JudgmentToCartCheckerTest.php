<?php

namespace VS\Next\Tests\PHPUnit\Promotions\Domain\Judgment;

use PHPUnit\Framework\TestCase;
use VS\Next\Checkout\Domain\Cart\Cart;
use VS\Next\Promotions\Domain\Judgment\Judgment;
use VS\Next\Promotions\Domain\Judgment\JudgmentProductIncluded;
use VS\Next\Tests\PHPUnit\Checkout\Domain\Cart\CartMother;
use VS\Next\Promotions\Domain\Judgment\JudgmentToCartChecker;
use VS\Next\Promotions\Domain\Profit\Profit;
use VS\Next\Tests\PHPUnit\Catalog\Domain\Category\CategoryMother;
use VS\Next\Tests\PHPUnit\Catalog\Domain\Product\ProductMother;
use VS\Next\Tests\PHPUnit\Checkout\Domain\Cart\NormalCartLineMother;
use VS\Next\Tests\PHPUnit\Promotions\Domain\Profit\CartAmountDiscountProfitMother;
use VS\Next\Tests\PHPUnit\Promotions\Domain\Profit\ProductAmountProfitMother;

class JudgmentToCartCheckerTest extends TestCase
{
    public function test_if_applicable_judment_then_true(): void
    {
        $judgment = $this->getJudgment();
        $cart = $this->getCart();

        $cheker = new JudgmentToCartChecker($judgment, $cart);
        $applicable = $cheker();

        $this->assertTrue($applicable);
    }

    public function test_if_is_profit_is_null_then_false(): void
    {
        $judgment = $this->getJudgment()->setProfit(null);
        $cart = $this->getCart();

        $cheker = new JudgmentToCartChecker($judgment, $cart);
        $applicable = $cheker();

        $this->assertFalse($applicable);
    }

    public function test_if_is_line_profit_then_false(): void
    {
        $invalidProfit = ProductAmountProfitMother::get();
        $judgment = $this->getJudgment($invalidProfit);
        $cart = $this->getCart();

        $cheker = new JudgmentToCartChecker($judgment, $cart);
        $applicable = $cheker();

        $this->assertFalse($applicable);
    }

    public function test_if_category_not_match_then_false(): void
    {
        $category = CategoryMother::get();
        $product = ProductMother::get(category: $category);
        $cartLine = NormalCartLineMother::get($product);
        $cart = $this->getCart()->addLine($cartLine);

        $judgment = $this->getJudgment()->addCategory(CategoryMother::get());

        $cheker = new JudgmentToCartChecker($judgment, $cart);
        $applicable = $cheker();

        $this->assertFalse($applicable);
    }

    public function test_if_products_included_not_match_then_false(): void
    {
        $product = ProductMother::get();
        $cartLine = NormalCartLineMother::get($product);
        $cart = $this->getCart()->addLine($cartLine);

        $otherProduct = ProductMother::get();

        $judgment = $this->getJudgment()->addProductIncluded($otherProduct);

        $cheker = new JudgmentToCartChecker($judgment, $cart);
        $applicable = $cheker();

        $this->assertFalse($applicable);
    }

    public function test_if_products_included_match_then_true(): void
    {
        $product = ProductMother::get();
        $cartLine = NormalCartLineMother::get($product);
        $cart = $this->getCart()->addLine($cartLine);

        $judgment = $this->getJudgment()->addProductIncluded($product);

        $cheker = new JudgmentToCartChecker($judgment, $cart);
        $applicable = $cheker();

        $this->assertTrue($applicable);
    }

    private function getJudgment(Profit $profit = null): Judgment
    {
        $profit = $profit ?: CartAmountDiscountProfitMother::get();

        return JudgmentMother::get($profit);
    }

    private function getCart(): Cart
    {
        return CartMother::get();
    }
}
