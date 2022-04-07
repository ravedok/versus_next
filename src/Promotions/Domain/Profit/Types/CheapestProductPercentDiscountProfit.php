<?php

namespace VS\Next\Promotions\Domain\Profit\Types;

use InvalidArgumentException;
use VS\Next\Catalog\Domain\Product\Entity\DiscountType;
use VS\Next\Checkout\Domain\Cart\Cart;
use VS\Next\Checkout\Domain\Cart\CartLine;
use VS\Next\Promotions\Domain\Profit\LineProfitInterface;
use VS\Next\Promotions\Domain\Profit\Profit;
use VS\Next\Promotions\Domain\Profit\ProfitId;
use VS\Next\Promotions\Domain\Shared\CalculatedLineDiscount;

class CheapestProductPercentDiscountProfit extends Profit implements LineProfitInterface
{
    public function __construct(protected ProfitId $id, private float $percent, private int $unitsNeeded)
    {
        if ($unitsNeeded <= 1) {
            throw new InvalidArgumentException('The required units should be greater than 1');
        }
    }

    public function calculateProfitToCartLine(CartLine $cartLine): ?CalculatedLineDiscount
    {
        $applicableLines = $this->getApplicableLinesSortingByAscenbdingPrice($cartLine->getCart());

        $unitsToApply = $this->getUnitsToApplyToCurrentLine($applicableLines, $cartLine);

        if ($unitsToApply <= 0) {
            return null;
        }

        return new CalculatedLineDiscount(
            $cartLine,
            DiscountType::createPercent(),
            $this->percent,
            $unitsToApply,
            $this->getJudgment()
        );
    }

    /** @return CartLine[] */
    private function getApplicableLinesSortingByAscenbdingPrice(Cart $cart): array
    {
        $lines = $cart->getLines();

        $applicableLines = $lines->filter(fn (CartLine $line) => $this->judgment->isApplicableToCartLine($line))
            ->toArray();

        $this->sortLinesbyAscendingPrice($applicableLines);

        return $applicableLines;
    }

    /** @param CartLine[] $applicableLines */
    private function countApplicableLines(array $applicableLines): int
    {
        return  array_reduce($applicableLines, function (int $carry,  CartLine $line) {
            return $carry + $line->getUnits();
        }, 0);
    }

    private function sortLinesbyAscendingPrice(array &$applicableLines): void
    {
        usort($applicableLines, function (CartLine $a, CartLine $b) {
            $aPrice = $a->getProduct()->getPrice();
            $bPrice = $b->getProduct()->getPrice();
            if ($aPrice === $bPrice) {
                return 0;
            }

            return ($aPrice > $bPrice ? 1 : -1);
        });
    }

    /** @param CartLine[] $applicableLines */
    private function getUnitsToApplyToCurrentLine(array $applicableLines, CartLine $currentLine): int
    {
        $applicableUnits = $this->countApplicableLines($applicableLines);
        $maxUnitsToApply = (int)floor($applicableUnits / $this->unitsNeeded);

        foreach ($applicableLines as $line) {
            if ($line === $currentLine) {
                break;
            }

            $maxUnitsToApply -= $line->getUnits();

            if ($maxUnitsToApply <= 0) {
                $maxUnitsToApply = 0;
                break;
            }
        }

        if ($currentLine->getUnits() >= $maxUnitsToApply) {
            return $maxUnitsToApply;
        }

        return $currentLine->getUnits();
    }
}
