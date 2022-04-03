<?php

namespace VS\Next\Tests\PHPUnit\Promotions\Domain\Judgment;

use VS\Next\Promotions\Domain\Profit\Profit;
use VS\Next\Promotions\Domain\Judgment\Judgment;
use VS\Next\Promotions\Domain\Judgment\JudgmentId;
use VS\Next\Promotions\Domain\Judgment\JudgmentName;

class JudgmentMother
{
    public static function get(Profit $profit = null): Judgment
    {

        $judgment = (new Judgment(
            JudgmentId::random(),
            JudgmentName::fromString('Judgment')
        ))->setProfit($profit);



        return $judgment;
    }
}
