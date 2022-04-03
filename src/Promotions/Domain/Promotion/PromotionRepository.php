<?php

namespace VS\Next\Promotions\Domain\Promotion;

use VS\Next\Promotions\Domain\Promotion\Promotion;

interface PromotionRepository
{
    /** @return Promotion[] */
    public function findActives(): array;
}
