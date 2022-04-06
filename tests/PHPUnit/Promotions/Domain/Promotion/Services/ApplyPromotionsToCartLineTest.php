<?php

namespace VS\Next\Tests\PHPUnit\Promotions\Domain\Promotion\Services;

use PHPUnit\Framework\TestCase;
use VS\Next\Checkout\Domain\Cart\Cart;
use VS\Next\Promotions\Domain\Judgment\Judgment;
use VS\Next\Catalog\Domain\Product\Entity\ProductOffer;
use VS\Next\Promotions\Domain\Judgment\JudgmentRepository;
use VS\Next\Tests\PHPUnit\Checkout\Domain\Cart\CartMother;
use VS\Next\Catalog\Domain\Product\Entity\ProductStoredStock;
use VS\Next\Checkout\Domain\Cart\CartLine;
use VS\Next\Tests\PHPUnit\Catalog\Domain\Product\ProductMother;
use VS\Next\Tests\PHPUnit\Catalog\Domain\Category\CategoryMother;
use VS\Next\Tests\PHPUnit\Checkout\Domain\Cart\NormalCartLineMother;
use VS\Next\Tests\PHPUnit\Promotions\Domain\Judgment\JudgmentMother;
use VS\Next\Promotions\Domain\Promotion\Services\ApplyPromotionsToCart;
use VS\Next\Promotions\Domain\Promotion\Services\ApplyPromotionsToCartLine;
use VS\Next\Tests\PHPUnit\Promotions\Domain\Profit\ProductAmountProfitMother;
use VS\Next\Tests\PHPUnit\Promotions\Domain\Profit\ProductPercentProfitMother;

class ApplyPromotionsToCartLineTest extends TestCase
{
    public function test_if_apply_best_discount_correctly(): void
    {
        $amountDiscount = 15;

        $category = CategoryMother::get();
        $product = ProductMother::get()
            ->setCategory($category)
            ->setStored(
                (new ProductStoredStock())
                    ->setPrice(100)
            )
            ->setOffer(
                new ProductOffer(true, 90)
            );

        $cart = $this->getCart();
        $cartLine = NormalCartLineMother::get($product);
        $profit = ProductAmountProfitMother::get($amountDiscount);
        $bestJudgment = JudgmentMother::get($profit)->addCategory($category);


        $otherProfit = ProductPercentProfitMother::get(5);
        $otherJudgment = JudgmentMother::get($otherProfit)->addCategory($category);

        $cart->addLine($cartLine);

        $judgments = [$bestJudgment, $otherJudgment];

        (new ApplyPromotionsToCartLine)($judgments, $cartLine);

        $this->assertEquals($amountDiscount, $cartLine->getAppliedDiscount()->getDiscountedAmount());
    }

    private function getCart(): Cart
    {
        return CartMother::get();
    }
}
