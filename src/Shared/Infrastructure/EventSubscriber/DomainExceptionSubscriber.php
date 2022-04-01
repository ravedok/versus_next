<?php

namespace VS\Next\Shared\Infrastructure\EventSubscriber;

use Throwable;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use VS\Next\Shared\Domain\Exception\DomainNotFoundException;
use VS\Next\Shared\Domain\Exception\DomainBadRequestException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DomainExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onException'
        ];
    }

    public function onException(ExceptionEvent $event): void
    {
        $exception = $this->getMainExceptionFromEvent($event);

        $this->handleBadRequestException($event, $exception);
        $this->handleNotFoundException($event, $exception);
    }

    private function getMainExceptionFromEvent(ExceptionEvent $event): Throwable
    {
        $exception = $event->getThrowable();

        if ($exception instanceof HandlerFailedException && $exception->getPrevious() !== null) {
            $exception = $exception->getPrevious();
        }

        return $exception;
    }

    private function handleBadRequestException(ExceptionEvent $event, Throwable $exception): void
    {
        if (!$exception instanceof DomainBadRequestException) {
            return;
        }

        $event->setThrowable(new BadRequestHttpException($exception->getMessage()));
    }

    private function handleNotFoundException(ExceptionEvent $event, Throwable $exception): void
    {
        if (!$exception instanceof DomainNotFoundException) {
            return;
        }

        $event->setThrowable(new NotFoundHttpException($exception->getMessage()));
    }
}
