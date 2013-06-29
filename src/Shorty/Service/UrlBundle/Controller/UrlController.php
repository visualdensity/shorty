<?php
namespace Shorty\Service\UrlBundle\Controller;

use Nocarrier\Hal;
use Shorty\Service\UrlBundle\Controller\ServiceAppController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\AcceptHeader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Shorty\Service\UrlBundle\Entity\Url;
use Shorty\Service\UrlBundle\Entity\Click;

/**
 * @Route("/api/url")
 */
class UrlController extends ServiceAppController
{

	/**
	 * Lists all Urls entities.
     *
	 * @Route("/", name="url_list")
     * @Method("GET")
     * @Template()
	 */
	public function listAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();

        $query = $em->createQuery('SELECT u FROM ShortyServiceUrlBundle:Url u');
        $urls= $query->getResult();

		$itemsCount = count($em->getRepository('ShortyServiceUrlBundle:Url')->findAll());
        $query = $em->createQuery( 'select u from ShortyServiceUrlBundle:Url u' );
        $urls = $query->getResult();

        $rootData = array(
            'totalRecords' => count($urls)
        );

        $hal = new Hal(
            $this->generateUrl('url_list'),
            $rootData
        );

        foreach($urls as $u) {
            $resource = new Hal(
                $this->generateUrl('url_view', array('id'=>$u->getId()) ),
                $u->toArray()
            );

            $resource->addLink(
                'shortened', 
                $this->container->getParameter('base_href') . $this->generateUrl('redirect',  array('short_url' => $u->getShortUrl() ) )
            );

            $hal->addResource('url', $resource);
        }

        return array(
            'result'  => static::getResult($hal),
        );
    }

	/**
     * View URL
     *
	 * @Route("/{id}", name="url_view")
     * @Method("GET")
     * @Template()
	 */
    public function showAction($id) {
        $url = $this->getDoctrine()
                    ->getRepository('ShortyServiceUrlBundle:Url')
                    ->find($id);

        if( !$url) {
            return new Response('', 404);
        }

        $hal = new Hal(
            $this->generateUrl( 'url_view', array('id' => $url->getId()) ),
            $url->toArray()
        );

        $hal->addLink(
            'shortened', 
            $this->container->getParameter('base_href') . $this->generateUrl('redirect',  array('short_url' => $url->getShortUrl() ) )
        );

        return array(
            'result' => $hal->asJson()
        );
    }

	/**
     * Create a new URL
     *
	 * @Route("/", name="url_create")
     * @Method("PUT|POST")
     * @Template()
	 */
    public function createAction(Request $request)
    {
        $encoder = $this->get('shorty.url_encoder');
        $longUrl = $request->query->get('url');

        $em = $this->getDoctrine()->getManager();
        $urlCheck = $em->getRepository('ShortyServiceUrlBundle:Url')
                        ->findByChecksum( md5($longUrl) );

        if( !$urlCheck ) {
            $url = new Url();
            $url->setChecksum( md5($longUrl) );
            $url->setLongUrl( $longUrl );
            $url->setHits(0);
            $url->setCreated( new \DateTime );


            $em = $this->getDoctrine()->getManager();
            $em->persist($url);
            $em->flush();

            $url->setShortUrl( $encoder->encode($url->getId()) );
            $em->flush();
        } else {
            $url = $urlCheck[0];
        }

        $hal = new Hal(
            $this->generateUrl( 'url_view', array('id' => $url->getId()) ),
            $url->toArray()
        );

        $hal->addLink(
            'shortened', 
            $this->container->getParameter('base_href') . $this->generateUrl('redirect',  array('short_url' => $url->getShortUrl() ) )
        );

        return array(
            'result' => $hal->asJson()
        );
    }

}
