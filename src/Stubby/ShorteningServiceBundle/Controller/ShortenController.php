<?php
namespace Stubby\ShorteningServiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\AcceptHeader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Stubby\ShorteningServiceBundle\Entity\Url;
use Stubby\ShorteningServiceBundle\Entity\Click;

/**
 * @Route("/api/shorten")
 */
class ShortenController extends Controller
{
    /**
     * Lists all Urls entities.
     *
     * @Route("/", name="shorten")
     * @Template()
     */
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('shorten_list'));
    }

	/**
	 * Lists all Urls entities.
	 * @Route("/list", name="shorten_list")
     * @Method("GET")
     * @Template()
	 */
	public function listAction(Request $request)
    {	
		$em = $this->getDoctrine()->getManager();
		
        $query = $em->createQuery('SELECT u FROM StubbyShorteningServiceBundle:Url u');
        $urls= $query->getResult();
        print_r($urls);
        die;
		$itemsCount = count($em->getRepository('StubbyShorteningServiceBundle:Url')->findAll());
        $query = $em->createQuery( 'select u from StubbyShorteningServiceBundle:Url u' );
        $entities = $query->getResult();

        return array(
            'entities'  => $entities,
            'base_href' => $this->container->getParameter('base_href'),
        );
    }

}
