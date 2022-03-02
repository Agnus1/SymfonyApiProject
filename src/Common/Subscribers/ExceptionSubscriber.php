<?php

namespace App\Common\Subscribers;

use App\Common\Exceptions\ApiException;
use App\Common\Exceptions\RequestException;
use App\Common\Exceptions\ValidationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;


class ExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [KernelEvents::EXCEPTION => "onException"];
    }

    public static function onException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof ApiException && !$exception->getPrevious() instanceof  ApiException) {
            $code = 500;
            $message = "Internal server error";
        } else {
            $exception = $exception instanceof ApiException ? $exception : $exception->getPrevious();
            $code = $exception->getCode();
            $message = $exception->getErrorbag();
        }

        $event->setResponse(new JsonResponse(["status" => "failed", "code" => $code, "messages" => $message], $code));
    }
}