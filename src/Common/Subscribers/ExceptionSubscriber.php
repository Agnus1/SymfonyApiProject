<?php

namespace App\Common\Subscribers;

use App\Common\Exceptions\ApiException;
use App\Common\Exceptions\RequestException;
use App\Common\Exceptions\ValidationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Psr\Log\LoggerInterface;

class ExceptionSubscriber implements EventSubscriberInterface
{

    private static LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        self::$logger = $logger;
    }

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

        self::$logger->error(date("d.m.y h:i:s") . " Error occured: " . $exception->getMessage());
        $event->setResponse(new JsonResponse(
            [
                "status" => "failed",
                "code" => $code,
                "messages" => $message
            ], 
            $code));
    }
}