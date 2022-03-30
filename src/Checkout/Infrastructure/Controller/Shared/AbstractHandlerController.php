<?php

namespace VS\Next\Checkout\Infrastructure\Controller\Shared;

use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class AbstractHandlerController extends AbstractController
{
    use HandleTrait { 
        handle as private handleMessage;
    }

    public function __construct(MessageBusInterface $checkoutBus)
    {
        $this->messageBus = $checkoutBus;
    }

    protected function handle(object $message): mixed
    {
        return $this->handleMessage($message);
    }
        
    /**
     * @required
     */
    public function setMessageBus(MessageBusInterface $messageBus): void
    {
        $this->messageBus = $messageBus;
    }
}
