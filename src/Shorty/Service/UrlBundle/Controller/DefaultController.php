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

/**
 * @Route("/")
 */
class DefaultController extends ServiceAppController
{

	/**
	 * Lists all Urls entities.
     *
	 * @Route("/{short_url}", name="redirect")
     * @Method("GET")
	 */
	public function redirectAction(Request $request, $short_url)
    {
        $em  = $this->getDoctrine()->getManager();
        $res = $em->getRepository('ShortyServiceUrlBundle:Url')
                  ->findBy( 
                        array('short_url' => $short_url )
                    );
        if( !isset($res[0]) ) {
            return new Response('', 404);
        } else {
            $url = $res[0];
        }

        $url->setHits( $url->getHits() + 1 );
        $em->persist($url);
        $em->flush();

        $server  = $request->createFromGlobals()->server;

        $click = new Click();
        $click->setCreated( new \Datetime );
        $click->setIp($request->getClientIp());
        $click->setReferer($server->get('HTTP_REFERER'));
        $click->setUserAgent($server->get('HTTP_USER_AGENT'));
        $click->setUrl($url);

        $em->persist($click);
        $em->flush();

        return $this->redirect( $url->getLongUrl() );
    }
}
