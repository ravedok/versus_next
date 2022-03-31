<?php

namespace VS\Next\Shared\Infrastructure\Doctrine;

use Doctrine\DBAL\Types\StringType;
use function Symfony\Component\String\u;
use VS\Next\Shared\Domain\ValueObject\Uuid;

use Doctrine\DBAL\Platforms\AbstractPlatform;


abstract class UuidType extends StringType
{
    abstract protected function typeClassName(): string;

    public static function customTypeName(): string
    {
        $classNameFragments = explode('\\', static::class);
        return u(str_replace('Type', '', end($classNameFragments)))->camel();
    }

    public function getName(): string
    {
        return self::customTypeName();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        if ($value === null) {
            return null;
        }

        $className = $this->typeClassName();

        return new $className($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        /** @var Uuid $value */
        return $value->value();
    }
}
