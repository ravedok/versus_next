<?php

namespace VS\Next\Promotions\Domain\Promotion;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use VS\Next\Promotions\Domain\Judgment\Judgment;
use VS\Next\Promotions\Domain\Promotion\PromotionDuration;
use VS\Next\Promotions\Domain\Promotion\PromotionId;
use VS\Next\Promotions\Domain\Promotion\PromotionName;

class Promotion
{
    private PromotionDuration $duration;
    /** @var Collection<int, Judgment> */
    private Collection $judgments;

    public function __construct(
        private PromotionId $id,
        private bool $active,
        private PromotionName $name,
        ?PromotionDuration $duration = null
    ) {

        $this->duration = $duration ?: new PromotionDuration();
        $this->judgments = new ArrayCollection();
    }

    public function getId(): PromotionId
    {
        return $this->id;
    }

    public function getName(): PromotionName
    {
        return $this->name;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setDuration(PromotionDuration $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getDuration(): PromotionDuration
    {
        return $this->duration;
    }

    public function addJudgment(Judgment $judgment): self
    {
        if ($this->judgments->contains($judgment)) {
            return $this;
        }

        $judgment->setPromotion($this);
        $this->judgments->add($judgment);

        return $this;
    }

    public function removeJudgment(Judgment $judgment): self
    {
        if (!$this->judgments->contains($judgment)) {
            return $this;
        }

        $this->judgments->removeElement($judgment);
        return $this;
    }

    /** @return Collection<int, Judgment> */
    public function getJudgments(): Collection
    {
        return $this->judgments;
    }
}
