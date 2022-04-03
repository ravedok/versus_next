<?php

namespace VS\Next\Promotions\Domain\Judgment;

interface JudgmentRepository
{
    /** @return Judgment[] */
    public function findActives(): array;
}
