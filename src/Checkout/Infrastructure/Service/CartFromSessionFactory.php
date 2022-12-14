<?php

namespace VS\Next\Checkout\Infrastructure\Service;

use VS\Next\Checkout\Domain\Cart\Cart;
use Symfony\Component\HttpFoundation\RequestStack;
use VS\Next\Catalog\Domain\Product\Entity\ProductId;
use VS\Next\Catalog\Domain\Product\ProductRepository;
use VS\Next\Checkout\Domain\Cart\CartLineType;
use VS\Next\Checkout\Infrastructure\Helper\CartSessionHelper;

class CartFromSessionFactory
{
    public function __construct(
        private RequestStack $requestStack,
        private ProductRepository $productRepository,
    ) {
    }

    public function __invoke(): Cart
    {
        $cart = new Cart();

        $session = $this->requestStack->getSession();


        if (false === $session->has(CartSessionHelper::SESSION_CART_KEY)) {
            return $cart;
        }

        $sessionCart = $session->get(CartSessionHelper::SESSION_CART_KEY);

        if (!is_array($sessionCart)) {
            return $cart;
        }

        $this->parseLines($cart, $sessionCart);

        return $cart;
    }

    private function parseLines(Cart &$cart, array $sessionCart): void
    {
        foreach ($sessionCart['lines'] as $line) {

            $productIdInSession = $line['productId'] ?? null;

            if (null === $productIdInSession) {
                continue;
            }

            $productId = new ProductId($productIdInSession);
            $product = $this->productRepository->findOneById($productId);

            if ($product === null) {
                continue;
            }

            $type = CartLineType::fromString($line['type']);
            $cartLine = $type->createCartLine($product, $line['units']);
            $cart->addLine($cartLine);
        }
    }
}
