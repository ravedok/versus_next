<?php

namespace VS\Next\Promotions\Domain\Profit;

use VS\Next\Promotions\Domain\Profit\ProfitId;

class ProductAmountProfit extends Profit
{
    public function __construct(protected ProfitId $id, private float $amount)
    {
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}
