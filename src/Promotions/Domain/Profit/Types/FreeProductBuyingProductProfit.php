<?php

namespace VS\Next\Promotions\Domain\Profit\Types;

use VS\Next\Promotions\Domain\Profit\Profit;
use VS\Next\Promotions\Domain\Profit\ProfitId;
use VS\Next\Catalog\Domain\Product\Entity\Product;
use VS\Next\Checkout\Domain\Cart\CartLine;
use VS\Next\Checkout\Domain\Cart\NormalCartLine;
use VS\Next\Promotions\Domain\Profit\LineProfitInterface;
use VS\Next\Promotions\Domain\Shared\CalculatedLineDiscount;

class FreeProductBuyingProductProfit extends Profit implements LineProfitInterface
{
    public function __construct(protected ProfitId $id, private Product $product)
    {
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function calculateProfitToCartLine(CartLine $cartLine): ?CalculatedLineDiscount
    {
        $freeCartLine = new NormalCartLine($this->product, $cartLine->getUnits(), true);

        $cart = $cartLine->getCart();

        $cart->addLine($freeCartLine);

        return null;
    }
}
