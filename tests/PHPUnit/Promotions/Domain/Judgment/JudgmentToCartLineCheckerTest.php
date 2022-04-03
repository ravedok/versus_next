<?php

namespace VS\Next\Tests\PHPUnit\Promotions\Domain\Judgment;

use PHPUnit\Framework\TestCase;
use VS\Next\Promotions\Domain\Judgment\Judgment;
use VS\Next\Tests\PHPUnit\Catalog\Domain\Product\ProductMother;
use VS\Next\Promotions\Domain\Judgment\JudgmentToCartLineChecker;
use VS\Next\Tests\PHPUnit\Catalog\Domain\Category\CategoryMother;
use VS\Next\Tests\PHPUnit\Checkout\Domain\Cart\NormalCartLineMother;
use VS\Next\Tests\PHPUnit\Promotions\Domain\Profit\ProductPercentProfitMother;

class JudgmentToCartLineCheckerTest extends TestCase
{
    public function test_if_cart_line_is_valid_success(): void
    {
        $category = CategoryMother::get();

        $judgment = $this->getJudgment()
            ->addCategory($category);

        $product = ProductMother::get()
            ->setCategory($category);

        $cartLine = NormalCartLineMother::get($product);

        $applicable = JudgmentToCartLineChecker::check($judgment, $cartLine);

        $this->assertEquals(true, $applicable);
    }

    public function test_is_product_category_is_empty_fail(): void
    {
        $judgment = $this->getJudgment()
            ->addCategory(CategoryMother::get());

        $product = (ProductMother::get())->setCategory(null);

        $cartLine = NormalCartLineMother::get($product);

        $applicable = JudgmentToCartLineChecker::check($judgment, $cartLine);

        $this->assertEquals(false, $applicable);
    }

    public function test_is_product_category_is_invalid_fail(): void
    {
        $judgmentCategory = CategoryMother::get();
        $otherCategory = CategoryMother::get();

        $judgment = $this->getJudgment()
            ->addCategory($judgmentCategory);

        $product = (ProductMother::get())->setCategory($otherCategory);

        $cartLine = NormalCartLineMother::get($product);

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

    private function getJudgment(): Judgment
    {
        $profit = ProductPercentProfitMother::get();
        return JudgmentMother::get($profit);
    }
}
