<?php
namespace Shorty\Service\UrlBundle\Controller;

use Nocarrier\Hal;

use Symfony\Component\HttpFoundation\Request;
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
class UrlController extends Controller
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

        print_r($urls);
        die;

        return array(
            'entities'  => $urls,
            'base_href' => $this->container->getParameter('base_href'),
        );
    }

	/**
     * Create a new URL 
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

        $data = array(
            'long_url'  => $url->getLongUrl(),
            'short_url' => $this->container->getParameter('base_href') . '/' . $url->getShortUrl(),
            'created'   => $url->getCreated()->format('Y-m-d H:i:s')
        );

        $hal = new Hal(
            $this->generateUrl( 'url_view', array('id' => $url->getId()) ),
            $data
        );

        $hal->addLink('shortened', $this->container->getParameter('base_href') . '/' . $url->getShortUrl());

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

        $url = new Url();
        $url->setLongUrl( $longUrl );
        $url->setHits(0);
        $url->setCreated( new \DateTime );


        $em = $this->getDoctrine()->getManager();
        $em->persist($url);
        $em->flush();

        $url->setShortUrl( $encoder->encode($url->getId()) );
        $em->flush();

        $data = array(
            'long_url'  => $url->getLongUrl(),
            'short_url' => $this->generateUrl( 'url_view', array('id' => $url->getId()) ),
            'created'   => $url->getCreated()->format('Y-m-d H:i:s')
        );

        $hal = new Hal(
            $this->generateUrl( 'url_view', array('id' => $url->getId()) ),
            $data
        );

        $hal->addLink('shortened', $this->container->getParameter('base_href') . '/' . $url->getShortUrl());

        return array(
            'result' => $hal->asJson()
        );
    }

}
