<?php

namespace VS\Next\Checkout\Infrastructure\Messenger;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use VS\Next\Checkout\Domain\Cart\CartRepository;

class SaveCartMiddleware implements MiddlewareInterface
{
    public function __construct(private CartRepository $cartRepository)
    {
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $envelope = $stack->next()->handle($envelope, $stack);

        $this->cartRepository->save();

        return $envelope;
    }
}
