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
 * @Route("/api/url")
 */
class ShortenController extends Controller
{
	/**
	 * Lists all Urls entities.
	 * @Route("/", name="url_list")
     * @Method("GET")
     * @Template()
	 */
	public function listAction(Request $request)
    {	
		$em = $this->getDoctrine()->getManager();
		
        $query = $em->createQuery('SELECT u FROM ShortyServiceUrlBundle:Url u');
        $urls= $query->getResult();
        print_r($urls);
        die;
		$itemsCount = count($em->getRepository('ShortyServiceUrlBundle:Url')->findAll());
        $query = $em->createQuery( 'select u from ShortyServiceUrlBundle:Url u' );
        $entities = $query->getResult();

        return array(
            'entities'  => $entities,
            'base_href' => $this->container->getParameter('base_href'),
        );
    }

}
