<?php

namespace VS\Next\Promotions\Domain\Shared;

class DiscountHelper
{
    public static function calculateDiscountPercent(float $previous, float $current): float
    {
        return round(($previous - $current) * 100 / $previous, 4);
    }

    public static function calculateDiscountedAmount(float $price, float $percent): float
    {
        return round($price * ($percent / 100), 2);
    }
}
