<?php

namespace VS\Next\Checkout\Infrastructure\Repository;

use VS\Next\Checkout\Domain\Cart\Cart;
use Doctrine\Persistence\ManagerRegistry;
use VS\Next\Checkout\Domain\Cart\CartLine;
use VS\Next\Checkout\Domain\Cart\CartRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends  ServiceEntityRepository<Cart>
 */
class CartDoctrineRepository extends ServiceEntityRepository implements CartRepository
{
    private ?Cart $cart = null;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cart::class);
    }

    public function save(): void
    {
    }

    public function current(): Cart
    {
        if ($this->cart === null) {
            $this->cart = $this->fromSession();
        }

        return $this->cart;
    }

    public function undoChanges(Cart | CartLine $object): void
    {
        $this->getEntityManager()->refresh($object);
    }

    public function removeLine(CartLine $cartLine): void
    {
        $this->getEntityManager()->remove($cartLine);
    }

    private function fromSession(): Cart
    {
        $cart = new Cart();



        return $cart;
    }
}
