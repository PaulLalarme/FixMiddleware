<?php

namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Logs each route access except excluded ones.
 */
class RouteTraceSubscriber implements EventSubscriberInterface
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        // only handle the main request to avoid duplicates
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();
        $route = $request->attributes->get('_route');

        // Skip if route is not defined or excluded
        if (null === $route || in_array($route, ['app_login', 'app_register'], true)) {
            return;
        }

        $this->logger->info(sprintf('Route "%s" called', $route), [
            'route' => $route,
            'path' => $request->getPathInfo(),
            'method' => $request->getMethod(),
        ]);
    }
}
