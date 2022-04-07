<?php

namespace VS\Next\Promotions\Domain\Profit\Types;

use VS\Next\Checkout\Domain\Cart\CartLine;
use VS\Next\Promotions\Domain\Profit\Profit;
use VS\Next\Promotions\Domain\Profit\ProfitId;
use VS\Next\Catalog\Domain\Product\Entity\DiscountType;
use VS\Next\Promotions\Domain\Shared\CalculatedLineDiscount;
use VS\Next\Promotions\Domain\Profit\LineProfitInterface;

class ProductPercentProfit extends Profit implements LineProfitInterface
{
    public function __construct(protected ProfitId $id, private int $percent)
    {
    }

    public function calculateProfitToCartLine(CartLine $cartLine): ?CalculatedLineDiscount
    {
        return new CalculatedLineDiscount(
            $cartLine,
            DiscountType::createPercent(),
            $this->percent,
            $cartLine->getUnits(),
            $this->getJudgment()
        );
    }

    public function getPercent(): float
    {
        return $this->percent;
    }
}
