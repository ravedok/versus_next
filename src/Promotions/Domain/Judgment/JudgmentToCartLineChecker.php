<?php

namespace VS\Next\Promotions\Domain\Judgment;

use VS\Next\Checkout\Domain\Cart\CartLine;
use VS\Next\Promotions\Domain\Judgment\Judgment;

class JudgmentToCartLineChecker
{
    public function __construct(private Judgment $judgment, private CartLine $cartline)
    {
    }

    public function __invoke(): bool
    {
        if (!$this->isValidProfit()) {
            return false;
        }

        if (!$this->isValidCategory()) {
            return false;
        }

        return true;
    }

    private function isValidProfit(): bool
    {
        if ($this->judgment->getProfit() === null) {
            return false;
        }

        return true;
    }

    private function isValidCategory(): bool
    {
        $judgmentCategories = $this->judgment->getCategories()->toArray();

        if (empty($judgmentCategories)) {
            return true;
        }

        $category = $this->cartline->getProduct()->getCategory();

        if (null === $category) {
            return false;
        }

        return in_array($category, $judgmentCategories);
    }

    public static function check(Judgment $judgment, CartLine $cartline): bool
    {
        return (new self($judgment, $cartline))();
    }
}
