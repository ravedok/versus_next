<?php

namespace VS\Next\Promotions\Domain\Judgment;

use Ramsey\Uuid\UuidInterface;
use VS\Next\Promotions\Domain\Judgment\Judgment;
use VS\Next\Catalog\Domain\Product\Entity\Product;

class JudgmentProductIncluded
{
    public function __construct(
        private UuidInterface $id,
        private Judgment $judgment,
        private Product $product,
        private int $group
    ) {
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getJudgment(): Judgment
    {
        return $this->judgment;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getGroup(): int
    {
        return $this->group;
    }
}
