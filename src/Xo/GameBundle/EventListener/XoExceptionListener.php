<?php

namespace Xo\GameBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class XoExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        
        if ($event->getRequest()->isXmlHttpRequest())
        {
            $message = new \stdClass();
            $message->type = 'error';
            
            $message->body = $exception instanceof \Exception ? $exception->getMessage() : 'Unknown error';            
                    
            $data = new \stdClass();            
            $data->messages = array($message);
            $resp = new \Symfony\Component\HttpFoundation\JsonResponse($data);
            $resp->setStatusCode(200);
            $event->setResponse($resp);
        }        
        else 
        {        
            // You get the exception object from the received event
            
            $message = sprintf(
                'My Error says: %s with code: %s',
                $exception->getMessage(),
                $exception->getCode()
            );

            // Customize your response object to display the exception details
            $response = new Response();
            $response->setContent($message.' - custom');

            // HttpExceptionInterface is a special type of exception that
            // holds status code and header details
            if ($exception instanceof HttpExceptionInterface) {
                $response->setStatusCode($exception->getStatusCode());
                $response->headers->replace($exception->getHeaders());
            } 
            else 
            {
                $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            
            $event->setResponse($response);
        }

        // Send the modified response object to the event
        //$event->setResponse($response); 

        $event->stopPropagation();
        
        return true;
        
    }
}