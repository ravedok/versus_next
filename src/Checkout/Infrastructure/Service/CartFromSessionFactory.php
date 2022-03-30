<?php

namespace VS\Next\Checkout\Infrastructure\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use VS\Next\Catalog\Domain\Product\Entity\ProductId;
use VS\Next\Catalog\Domain\Product\ProductRepository;
use VS\Next\Checkout\Domain\Cart\Cart;
use VS\Next\Checkout\Domain\Cart\NormalCartLine;
use VS\Next\Checkout\Infrastructure\Helper\CartSessionHelper;

class CartFromSessionFactory
{

    public function __construct(private SessionInterface $session, private ProductRepository $productRepository)
    {
    }

    public function __invoke(): Cart
    {
        $cart = new Cart();

        if (!$this->session->has(CartSessionHelper::SESSION_CART_KEY)) {
            return $cart;
        }

        $sessionCart = $this->session->get(CartSessionHelper::SESSION_CART_KEY);

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
