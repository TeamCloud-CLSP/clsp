<?php

namespace AppBundle\Listener;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Database;
use AppBundle\Controller\AuthenticationRequiredController;
use AppBundle\Controller\AdminRequiredController;
use AppBundle\Controller\ErrorController;

/**
 * This listener adds CORS headers to every response.
 */
class CORSListener
{

    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();
        $response->headers->set('Access-Control-Allow-Origin', 'http://localhost:3000');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');
        $response->headers->set('Access-Control-Allow-Headers', 'content-type');
    }


}
