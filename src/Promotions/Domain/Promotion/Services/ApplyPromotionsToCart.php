<?php

namespace VS\Next\Promotions\Domain\Promotion\Services;

use VS\Next\Checkout\Domain\Cart\Cart;
use VS\Next\Promotions\Domain\Judgment\Judgment;
use VS\Next\Promotions\Domain\Judgment\JudgmentRepository;
use VS\Next\Promotions\Domain\Shared\CalculatedCartDiscount;

class ApplyPromotionsToCart
{
    public function __construct(
        private JudgmentRepository $judgmentRepository,
        private ApplyPromotionsToCartLine $applyPromotionsToCartLine
    ) {
    }
    public function __invoke(Cart $cart): void
    {
        $judgments = $this->judgmentRepository->findActives();

        $this->applyToLines($judgments, $cart);

        $this->applyToCart($judgments, $cart);
    }

    /** @param Judgment[] $judgments */
    private function applyToCart(array $judgments, Cart $cart): void
    {
        $candidates = [];

        foreach ($judgments as $judgment) {
            if ($judgment->isApplicableToCart($cart)) {
                $candidates[] = $judgment->applyToCart($cart);
            }
        }

        $discount = $this->reduceCandidates($candidates);
        $cart->setAppliedDiscount($discount);
    }

    /** @param CalculatedCartDiscount[] $candidates */
    private function reduceCandidates(array $candidates): ?CalculatedCartDiscount
    {
        return array_reduce($candidates, function (?CalculatedCartDiscount $carry, CalculatedCartDiscount $current) {
            if ($carry === null) {
                return $current;
            }

            if ($current->getDiscountedAmount() > $carry->getDiscountedAmount()) {
                return $current;
            }

            return $carry;
        }, null);
    }

    /** 
     * @param Judgment[] $judgments 
     * */
    private function applyToLines(array $judgments, Cart $cart): void
    {
        foreach ($cart->getLines() as $line) {
            ($this->applyPromotionsToCartLine)($judgments, $line);
        }
    }
}
