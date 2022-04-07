<?php

namespace VS\Next\Tests\PHPUnit\Promotions\Domain\Promotion\Services;

use PHPUnit\Framework\TestCase;
use VS\Next\Checkout\Domain\Cart\Cart;
use VS\Next\Checkout\Domain\Cart\CartLine;
use VS\Next\Promotions\Domain\Profit\Profit;
use VS\Next\Catalog\Domain\Category\Category;
use VS\Next\Promotions\Domain\Judgment\Judgment;
use VS\Next\Catalog\Domain\Product\Entity\Product;
use VS\Next\Catalog\Domain\Product\Entity\ProductOffer;
use VS\Next\Tests\PHPUnit\Checkout\Domain\Cart\CartMother;
use VS\Next\Catalog\Domain\Product\Entity\ProductStoredStock;
use VS\Next\Tests\PHPUnit\Catalog\Domain\Product\ProductMother;
use VS\Next\Tests\PHPUnit\Catalog\Domain\Category\CategoryMother;
use VS\Next\Tests\PHPUnit\Checkout\Domain\Cart\NormalCartLineMother;
use VS\Next\Tests\PHPUnit\Promotions\Domain\Judgment\JudgmentMother;
use VS\Next\Promotions\Domain\Promotion\Services\ApplyPromotionsToCartLine;
use VS\Next\Tests\PHPUnit\Promotions\Domain\Profit\ProductAmountProfitMother;
use VS\Next\Tests\PHPUnit\Promotions\Domain\Profit\ProductPercentProfitMother;
use VS\Next\Tests\PHPUnit\Promotions\Domain\Profit\CheapestProductPercentDiscountProfitMother;

class ApplyPromotionsToCartLineTest extends TestCase
{
    private ?Category $category = null;
    private ?Cart $cart = null;

    public function test_if_apply_best_discount_correctly(): void
    {
        $amountDiscount = 15;

        $profit = ProductAmountProfitMother::get($amountDiscount);
        $bestJudgment = $this->createJudgment($profit);

        $otherProfit = ProductPercentProfitMother::get(5);
        $otherJudgment = $this->createJudgment($otherProfit);

        $cartLine = $this->createCartLine();

        $judgments = [$bestJudgment, $otherJudgment];

        (new ApplyPromotionsToCartLine)($judgments, $cartLine);

        $this->assertEquals($amountDiscount, $cartLine->getAppliedDiscount()->getDiscountedAmount());
    }

    public function test_if_applyt_cheapest_discount_correctly(): void
    {
        $cartLineMostExpensive = $this->createCartLine(
            $this->createProduct(60, 30)
        );

        $cartLineCheapest = $this->createCartLine(
            $this->createProduct(50, 45),
            2
        );

        $cheapestDiscount = CheapestProductPercentDiscountProfitMother::get(50, 3);
        $judgment = $this->createJudgment($cheapestDiscount);

        (new ApplyPromotionsToCartLine)([$judgment], $cartLineCheapest);
        $this->assertEquals(25, $cartLineCheapest->getAppliedDiscount()->getDiscountedAmount());
        $this->assertEquals(1, $cartLineCheapest->getAppliedDiscount()->getUnits());
        $this->assertEquals(1, $cartLineCheapest->getUnits());

        (new ApplyPromotionsToCartLine)([$judgment], $cartLineMostExpensive);
        $this->assertEquals(30, $cartLineMostExpensive->getAppliedDiscount()->getDiscountedAmount());

        $this->assertCount(3, $this->getCart()->getLines(), 'You should create an additional line for units not covered by the benefit');

        /** @var CartLine */
        $partialLine = $this->getCart()->getLines()->last();

        $this->assertEquals(1, $partialLine->getUnits());
        $this->assertEquals(45, $partialLine->getPrice());
    }

    private function createJudgment(Profit $profit): Judgment
    {
        return JudgmentMother::get($profit)->addCategory($this->getCategory());
    }

    private function getCategory(): Category
    {
        if ($this->category === null) {
            $this->category = CategoryMother::get();
        }

        return $this->category;
    }

    private function createProduct(float $price = 100, float $offerPrice = 0): Product
    {
        $product = ProductMother::get()
            ->setCategory($this->getCategory())
            ->setStored(
                (new ProductStoredStock())
                    ->setPrice($price)
            );
        if ($offerPrice) {
            $product->setOffer(
                new ProductOffer(true, $offerPrice)
            );
        }

        return $product;
    }

    private function createCartLine(?Product $product = null, int $units = 1): CartLine
    {
        if ($product === null) {
            $product = $this->createProduct();
        }

        $line = NormalCartLineMother::get($product, $units);

        $this->getCart()->addLine($line);

        return $line;
    }

    private function getCart(): Cart
    {
        if ($this->cart === null) {
            $this->cart = CartMother::get();
        }

        return $this->cart;
    }
}
