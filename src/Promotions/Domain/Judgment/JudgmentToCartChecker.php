<?php

namespace VS\Next\Promotions\Domain\Judgment;

use VS\Next\Checkout\Domain\Cart\Cart;
use VS\Next\Promotions\Domain\Judgment\Judgment;
use VS\Next\Promotions\Domain\Profit\CartProfitInterface;

class JudgmentToCartChecker
{
    public function __construct(private Judgment $judgment, private Cart $cart)
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
        $profit = $this->judgment->getProfit();

        if ($profit === null) {
            return false;
        }

        if (!$profit instanceof CartProfitInterface) {
            return false;
        }

        return true;
    }

    private function isValidCategory(): bool
    {
        $categories = $this->judgment->getCategories()->toArray();

        if (empty($categories)) {
            return true;
        }

        foreach ($this->cart->getLines() as $line) {
            $productCategory = $line->getProduct()->getCategory();

            if (in_array($productCategory, $categories)) {
                return true;
            }
        }

        return false;
    }
}
