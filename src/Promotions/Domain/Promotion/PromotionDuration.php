<?php

namespace VS\Next\Promotions\Domain\Promotion;

class PromotionDuration
{
    public function __construct(
        private ?\DateTime $startAt = null,
        private ?\DateTime $endAt = null
    ) {
    }

    public function getStartAt(): ?\DateTime
    {
        return $this->startAt;
    }

    public function getEndAt(): ?\DateTime
    {
        return $this->endAt;
    }
}
