<?php

namespace VS\Next\Promotions\Domain\Judgment;

use VS\Next\Checkout\Domain\Cart\CartLine;
use VS\Next\Promotions\Domain\Judgment\Judgment;
use VS\Next\Promotions\Domain\Profit\LineProfitInterface;

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

        if (!$this->isValidProduct()) {
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

        if (!$profit instanceof LineProfitInterface) {
            return false;
        }

        return true;
    }

    private function isValidProduct(): bool
    {
        if (!$this->cartline->getProduct()->isAllowPromotions()) {
            return false;
        }

        $productsIncluded = $this->judgment
            ->getProductsIncluded()
            ->map(fn (JudgmentProductIncluded $productIncluded) => $productIncluded->getProduct())
            ->toArray();

        if (empty($productsIncluded)) {
            return true;
        }

        $productInCart = $this->cartline->getProduct();

        return in_array($productInCart, $productsIncluded);
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
