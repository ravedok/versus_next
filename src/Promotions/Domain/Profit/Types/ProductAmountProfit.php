<?php

namespace VS\Next\Promotions\Domain\Profit\Types;

use VS\Next\Checkout\Domain\Cart\CartLine;
use VS\Next\Promotions\Domain\Profit\Profit;
use VS\Next\Promotions\Domain\Profit\ProfitId;
use VS\Next\Catalog\Domain\Product\Entity\DiscountType;
use VS\Next\Promotions\Domain\Shared\CalculatedLineDiscount;
use VS\Next\Promotions\Domain\Profit\LineProfitInterface;

class ProductAmountProfit extends Profit implements LineProfitInterface
{
    public function __construct(protected ProfitId $id, private float $amount)
    {
    }

    public function calculateProfitToCartLine(CartLine $cartLine): CalculatedLineDiscount
    {
        $product = $cartLine->getProduct();
        $price = $product->getPrice();

        return new CalculatedLineDiscount(
            $product,
            DiscountType::createAmount(),
            $this->amount,
            $this->getJudgment()
        );
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}
