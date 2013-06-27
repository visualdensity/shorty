<?php
namespace Shorty\Service\UrlBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class ServiceAppController extends Controller
{
    protected function getResult(\Nocarrier\Hal $hal) 
    {
        $format = $this->getRequest()->getRequestFormat();
        $method = "as" . ucfirst(strtolower($format));
        $result = $hal->{$method}();

        return $result;
    }
}
