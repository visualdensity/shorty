<?php
namespace Shorty\Service\UrlBundle\EventListener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class AcceptHeaderListener
{
    private $acceptedFormats;
    private $acceptedFormatsRegex;

    public function __construct($acceptedFormats)
    {
        $formatString = '';

        foreach($acceptedFormats as $format) {
            $formatString .= $format . "|";
        }

        $this->acceptedFormats      = $acceptedFormats;
        $this->acceptedFormatsRegex = "/(" . substr($formatString, 0,-1) . ")/";
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $format = 'json';

        $request = $event->getRequest();
        $acceptHeader = $request->headers->get('Accept');

        if( preg_match( $this->acceptedFormatsRegex, $acceptHeader, $matches) ) {
            if(in_array($matches[1], $this->acceptedFormats)) {
                $format = $matches[1];
            }
        }

        $event->getRequest()->setRequestFormat($format);
    }//onKernelRequest
}
