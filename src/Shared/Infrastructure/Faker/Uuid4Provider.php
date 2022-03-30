<?php

namespace VS\Next\Shared\Infrastructure\Faker;

use Faker\Provider\Base;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Uuid4Provider extends Base
{
    public static function uuid4(): UuidInterface
    {
        return Uuid::uuid4();
    }
}
