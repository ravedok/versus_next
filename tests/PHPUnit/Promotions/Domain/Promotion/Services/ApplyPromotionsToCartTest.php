<?php

namespace VS\Next\Tests\PHPUnit\Promotions\Domain\Promotion\Services;

use PHPUnit\Framework\TestCase;
use VS\Next\Checkout\Domain\Cart\Cart;
use VS\Next\Catalog\Domain\Category\Category;
use VS\Next\Promotions\Domain\Judgment\Judgment;
use VS\Next\Catalog\Domain\Product\Entity\ProductOffer;
use VS\Next\Promotions\Domain\Judgment\JudgmentRepository;
use VS\Next\Tests\PHPUnit\Checkout\Domain\Cart\CartMother;
use VS\Next\Catalog\Domain\Product\Entity\ProductStoredStock;
use VS\Next\Tests\PHPUnit\Catalog\Domain\Product\ProductMother;
use VS\Next\Tests\PHPUnit\Catalog\Domain\Category\CategoryMother;
use VS\Next\Tests\PHPUnit\Checkout\Domain\Cart\NormalCartLineMother;
use VS\Next\Tests\PHPUnit\Promotions\Domain\Judgment\JudgmentMother;
use VS\Next\Promotions\Domain\Profit\Types\CartPercentDiscountProfit;
use VS\Next\Promotions\Domain\Promotion\Services\ApplyPromotionsToCart;
use VS\Next\Promotions\Domain\Promotion\Services\ApplyPromotionsToCartLine;
use VS\Next\Tests\PHPUnit\Promotions\Domain\Profit\ProductAmountProfitMother;
use VS\Next\Tests\PHPUnit\Promotions\Domain\Profit\ProductPercentProfitMother;
use VS\Next\Tests\PHPUnit\Promotions\Domain\Profit\CartAmountDiscountProfitMother;
use VS\Next\Tests\PHPUnit\Promotions\Domain\Profit\CartPercentDiscountProfitMother;

class ApplyPromotionsToCartTest extends TestCase
{
    private ?Cart $cart = null;
    private ?Category $category = null;

    public function test_if_apply_amount_discount_correctly(): void
    {
        $amountDiscount = 15;
        $percentDiscount = 5;

        $profit = CartAmountDiscountProfitMother::get($amountDiscount);
        $bestJudgment = JudgmentMother::get($profit)->addCategory($this->getCategory());

        $otherProfit = CartPercentDiscountProfitMother::get($percentDiscount);
        $otherJudgment = JudgmentMother::get($otherProfit)->addCategory($this->getCategory());

        $cart = $this->getCart();

        $service = $this->getApplyPromotionsToCart([$bestJudgment, $otherJudgment]);
        $service($cart);

        $this->assertEquals($amountDiscount, $cart->getAppliedDiscount()->getDiscountedAmount());
    }

    public function test_if_apply_percent_discount_correctly(): void
    {
        $amountDiscount = 15;
        $percentDiscount = 20;

        $profit = CartAmountDiscountProfitMother::get($amountDiscount);
        $bestJudgment = JudgmentMother::get($profit)->addCategory($this->getCategory());

        $otherProfit = CartPercentDiscountProfitMother::get($percentDiscount);
        $otherJudgment = JudgmentMother::get($otherProfit)->addCategory($this->getCategory());

        $cart = $this->getCart();

        $service = $this->getApplyPromotionsToCart([$bestJudgment, $otherJudgment]);
        $service($cart);

        $this->assertEquals(18, $cart->getAppliedDiscount()->getDiscountedAmount());
    }


    private function getCart(): Cart
    {
        if ($this->cart !== null) {
            return $this->cart;
        }

        $category = CategoryMother::get();
        $product = ProductMother::get()
            ->setCategory($this->getCategory())
            ->setStored(
                (new ProductStoredStock())
                    ->setPrice(100)
            )
            ->setOffer(
                new ProductOffer(true, 90)
            );

        $cart = CartMother::get();
        $cartLine = NormalCartLineMother::get($product);

        $cart->addLine($cartLine);

        $this->cart = $cart;

        return $this->cart;
    }

    private function getCategory(): Category
    {
        if ($this->category === null) {
            $this->category = CategoryMother::get();
        }

        return $this->category;
    }

    /** @param Judgment[] $judgments */
    private function getApplyPromotionsToCart(array $judgments): ApplyPromotionsToCart
    {
        return new ApplyPromotionsToCart(
            $this->getJudgmentRepository($judgments),
            new ApplyPromotionsToCartLine()
        );
    }

    /** @param Judgment[] $judgments */
    private function getJudgmentRepository(array $judgments): JudgmentRepository
    {
        $stub = $this->getMockBuilder(JudgmentRepository::class)
            ->getMock();

        $stub->method('findActives')
            ->willReturn($judgments);


        /** @var JudgmentRepository $stub */
        return $stub;
    }
}
