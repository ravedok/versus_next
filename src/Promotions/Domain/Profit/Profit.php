<?php

namespace VS\Next\Promotions\Domain\Profit;

use VS\Next\Promotions\Domain\Judgment\Judgment;

abstract class Profit
{
    protected ProfitId $id;
    protected Judgment $judgment;

    public function getId(): ProfitId
    {
        return $this->id;
    }

    public function getJudgment(): Judgment
    {
        return $this->judgment;
    }

    public function setJudgment(Judgment $judgment): self
    {
        $this->judgment = $judgment;

        return $this;
    }
}
