<?php

namespace VS\Next\Checkout\Infrastructure\Service;

use VS\Next\Checkout\Domain\Cart\Cart;
use VS\Next\Checkout\Domain\Cart\NormalCartLine;
use Symfony\Component\HttpFoundation\RequestStack;
use VS\Next\Catalog\Domain\Product\Entity\ProductId;
use VS\Next\Catalog\Domain\Product\ProductRepository;
use VS\Next\Checkout\Infrastructure\Helper\CartSessionHelper;

class CartFromSessionFactory
{
    public function __construct(private RequestStack $requestStack, private ProductRepository $productRepository)
    {
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

        foreach ($sessionCart['lines'] as $line) {

            $productId = new ProductId($line['id']);
            $product = $this->productRepository->findOneById($productId);

            if ($product === null) {
                continue;
            }

            $cartLine = new NormalCartLine($product, $line['units']);

            $cart->addLine($cartLine);
        }

        return $cart;
    }
}
