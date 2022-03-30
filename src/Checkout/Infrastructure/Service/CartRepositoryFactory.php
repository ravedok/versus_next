<?php

namespace VS\Next\Checkout\Infrastructure\Service;

use Psr\Container\ContainerInterface;
use VS\Next\Checkout\Domain\Cart\CartRepository;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use VS\Next\Checkout\Infrastructure\Repository\CartSessionRepository;
use VS\Next\Checkout\Infrastructure\Repository\CartDoctrineRepository;

class CartRepositoryFactory implements ServiceSubscriberInterface
{
    /** @var ContainerInterface */
    private $locator;

    public function __construct(ContainerInterface $locator)
    {
        $this->locator = $locator;
    }

    public static function getSubscribedServices(): array
    {
        return [
            CartDoctrineRepository::class,
            CartSessionRepository::class
        ];
    }

    public function __invoke(): CartRepository
    {        
        /** @var CartRepository */
        return $this->locator->get(CartSessionRepository::class);
    }
}
