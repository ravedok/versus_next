<?php

namespace VS\Next\Promotions\Infrastructure\Fixtures;

use Faker\Provider\Base;
use VS\Next\Promotions\Domain\Promotion\PromotionDuration;
use VS\Next\Promotions\Domain\Promotion\PromotionId;
use VS\Next\Promotions\Domain\Promotion\PromotionName;

class PromotionProvider extends Base
{
    public static function promotionId(): PromotionId
    {
        return PromotionId::random();
    }

    public static function promotionNameFromString(string $name): PromotionName
    {
        return PromotionName::fromString($name);
    }

    public static function promotionDuration(?int $daysToStart = null, ?int $daysToEnd = null): PromotionDuration
    {
        $start = $daysToStart !== null ? (new \DateTime())->modify("$daysToStart day") : null;
        $end = $daysToEnd !== null ? (new \DateTime())->modify("$daysToEnd day") : null;
        return new PromotionDuration($start, $end);
    }
}
