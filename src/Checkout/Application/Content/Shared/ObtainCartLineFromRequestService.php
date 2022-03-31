<?php

namespace VS\Next\Checkout\Application\Content\Shared;

use VS\Next\Checkout\Domain\Cart\CartLine;
use VS\Next\Checkout\Domain\Cart\CartLineOption;
use VS\Next\Checkout\Domain\Cart\CartRepository;
use VS\Next\Checkout\Domain\Cart\NormalCartLine;
use VS\Next\Catalog\Domain\Product\Entity\ProductSku;
use VS\Next\Checkout\Domain\Cart\GiftCardCartLine;
use VS\Next\Catalog\Domain\Product\GiftCardProduct;
use VS\Next\Checkout\Domain\Cart\CustomizedCartLine;
use VS\Next\Checkout\Domain\Cart\RedeemableCartLine;
use VS\Next\Catalog\Domain\Product\ProductRepository;
use VS\Next\Catalog\Domain\Product\RedeemableProduct;
use VS\Next\Checkout\Domain\Cart\ReconditionedCartLine;
use VS\Next\Checkout\Application\Content\Shared\AbstractContentRequest;
use VS\Next\Checkout\Infrastructure\Controller\Shared\CartLineOptionDto;

class ObtainCartLineFromRequestService
{
    public function __construct(private ProductRepository $productRepository, private CartRepository $cartRepository)
    {
    }

    public function findOrCreate(AbstractContentRequest $request): CartLine
    {
        $newLine = $this->createNewCartLine($request);

        $cart = $this->cartRepository->current();

        $lineInCart = $cart->findLine($newLine);

        if ($lineInCart) {
            return $lineInCart;
        }

        $cart->addLine($newLine);

        return $newLine;
    }

    public function find(AbstractContentRequest $request): ?CartLine
    {
        $newLine = $this->createNewCartLine($request);

        $cart = $this->cartRepository->current();

        return $cart->findLine($newLine);
    }

    private function createNewCartLine(AbstractContentRequest $request): CartLine
    {
        $productSku = ProductSku::fromString($request->productSku);

        // $product  = $this->getProductFromSku($productSku);

        $product = $this->productRepository->findOneBySkuOrFail($productSku);

        $product->ensureIsForDirectSale();

        if ($request->isReconditioned) {
            return new ReconditionedCartLine($product);
        }

        if ($product instanceof RedeemableProduct) {
            return new RedeemableCartLine($product);
        }

        if ($product instanceof GiftCardProduct) {
            return new GiftCardCartLine($product);
        }

        $options = $request->options;

        if (count($options)) {

            $customizedCartLine = new CustomizedCartLine($product);

            $this->addCartLineOptionsFromRequest($customizedCartLine, $options);

            return $customizedCartLine;
        }

        return new NormalCartLine($product);
    }

    /**
     * @param CartLineOptionDto[] $options
     * */
    private function addCartLineOptionsFromRequest(CustomizedCartLine $cartLine, array $options): void
    {
        foreach ($options as $option) {
            $optionProductSku = ProductSku::fromString($option->getProductSku());
            $product = $this->productRepository->findOneBySkuOrFail($optionProductSku);

            $product->ensureIsAllowedAsAnOption();

            $carLineOption = new CartLineOption($product, $option->getType(), $option->getUnits());

            $cartLine->addOption($carLineOption);
        }
    }
}
