<?php

namespace VS\Next\Promotions\Domain\Profit;

use VS\Next\Promotions\Domain\Profit\ProfitId;

class ProductPercentProfit extends Profit
{
    public function __construct(protected ProfitId $id, private int $percent)
    {
    }

    public function getPercent(): float
    {
        return $this->percent;
    }
}
