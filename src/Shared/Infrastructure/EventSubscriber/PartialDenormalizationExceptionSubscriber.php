<?php

namespace VS\Next\Shared\Infrastructure\EventSubscriber;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Exception\PartialDenormalizationException;

class PartialDenormalizationExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onException'
        ];
    }

    public function onException(ExceptionEvent $event): void
    {
        $th = $event->getThrowable();
        if (!$th instanceof PartialDenormalizationException) {
            return;
        }

        $violations = new ConstraintViolationList();

        /** @var NotNormalizableValueException */
        foreach ($th->getErrors() as $exception) {
            $message = sprintf('The type must be one of "%s" ("%s" given).', implode(', ', $exception->getExpectedTypes()), $exception->getCurrentType());
            $parameters = [];
            if ($exception->canUseMessageForUser()) {
                $parameters['hint'] = $exception->getMessage();
            }
            $violations->add(new ConstraintViolation($message, '', $parameters, null, $exception->getPath(), null));
        };

        throw new ValidationFailedException((string) $violations, $violations);
    }
}
