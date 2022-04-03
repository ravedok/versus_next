<?php

namespace VS\Next\Promotions\Infrastructure\Fixtures;

use Faker\Provider\Base;
use VS\Next\Promotions\Domain\Profit\ProfitId;

class ProfitProvider extends Base
{
    public static function profitId(): ProfitId
    {
        return ProfitId::random();
    }
}
