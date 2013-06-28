<?php
namespace Shorty\Service\UrlBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\AcceptHeader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Shorty\Service\UrlBundle\Entity\Url;
use Shorty\Service\UrlBundle\Entity\Click;

class DefaultController extends ServiceAppController
{

	/**
	 * Lists all Urls entities.
     *
	 * @Route("/{shortUrl}", name="redirect")
     * @Method("GET")
	 */
	public function listAction($shortUrl)
    {
        $url = $this->getDoctrine()
                    ->getRepository('ShortyServiceUrlBundle:Url')
                    ->findBy( 
                        array('short_url' => $shortUrl )
                    );

        if( !$url) {
            return new Response('', 404);
        }
        return $this->redirect( $url[0]->getLongUrl() );
    }
}
