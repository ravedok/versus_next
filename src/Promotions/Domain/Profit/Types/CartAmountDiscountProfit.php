<?php

namespace VS\Next\Promotions\Domain\Profit\Types;

use VS\Next\Checkout\Domain\Cart\Cart;
use VS\Next\Promotions\Domain\Profit\Profit;
use VS\Next\Promotions\Domain\Profit\ProfitId;
use VS\Next\Catalog\Domain\Product\Entity\DiscountType;
use VS\Next\Promotions\Domain\Profit\CartProfitInterface;
use VS\Next\Promotions\Domain\Shared\CalculatedCartDiscount;

final class CartAmountDiscountProfit extends Profit implements CartProfitInterface
{
    public function __construct(protected ProfitId $id, private float $amount)
    {
    }

    public function calculateProfitToCart(Cart $cart): CalculatedCartDiscount
    {
        return new CalculatedCartDiscount(
            $cart,
            DiscountType::createAmount(),
            $this->amount
        );
    }
}
