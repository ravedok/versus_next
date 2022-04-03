<?php

namespace VS\Next\Promotions\Domain\Promotion\Services;

use VS\Next\Checkout\Domain\Cart\Cart;
use VS\Next\Checkout\Domain\Cart\CartLine;
use VS\Next\Promotions\Domain\Judgment\Judgment;
use VS\Next\Promotions\Domain\Judgment\JudgmentRepository;

class ApplyPromotionsToCart
{
    public function __construct(private JudgmentRepository $judgmentRepository)
    {
    }
    public function __invoke(Cart $cart): void
    {
        $judgments = $this->judgmentRepository->findActives();

        $this->applyToLines($judgments, $cart->getLines()->toArray());
    }

    /** 
     * @param Judgment[] $judgments 
     * @param CartLine[] $lines
     * */
    private function applyToLines(array $judgments, array $lines): void
    {
        foreach ($lines as $line) {
            if (!$line->getProduct()->isAllowPromotions()) {
                continue;
            }

            $this->applyToLine($judgments, $line);
        }
    }

    /** @param Judgment[] $judgments  */
    private function applyToLine(array $judgments, CartLine $cartLine): void
    {
        $candidates = [];

        foreach ($judgments as $judgment) {
            if ($judgment->applicableToCartLine($cartLine)) {
                $candidates[] = $judgment->applyToCartLine($cartLine);
            }
        }
    }
}
