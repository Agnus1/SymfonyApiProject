<?php

namespace App\Common\Subscribers;

use App\Common\Exceptions\RequestException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ApiRequestSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [KernelEvents::REQUEST => "onRequest"];
    }

    public static function onRequest(RequestEvent $event)
    {
        if (!$event->isMainRequest()) {
            return;
        }
        $request = $event->getRequest();

        if ($request->getContentType() !== 'json' ||
            is_resource($request->getContent())
        ) {
            throw (new RequestException())->setErrorBag(["Invalid content type"]);
        }
    }

}