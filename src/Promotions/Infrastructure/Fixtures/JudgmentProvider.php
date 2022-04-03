<?php

namespace VS\Next\Promotions\Infrastructure\Fixtures;

use Faker\Provider\Base;
use VS\Next\Promotions\Domain\Judgment\JudgmentId;
use VS\Next\Promotions\Domain\Judgment\JudgmentName;

class JudgmentProvider extends Base
{
    public static function judgmentId(): JudgmentId
    {
        return JudgmentId::random();
    }

    public static function judgmentNameFromString(string $name): JudgmentName
    {
        return JudgmentName::fromString($name);
    }
}
