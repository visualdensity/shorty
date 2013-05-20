<?php
/**
 * @TODO: 
 *  - existing URLs
 *  - REST service (with security)
 *  - ACL
 *  - reporting
 *  - export (records & reports)
 *  - direct post to Twitter (ala Bit.ly)
 */
namespace Scoopon\UrlShortenerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Scoopon\UrlShortenerBundle\Entity\Urls;
use Scoopon\UrlShortenerBundle\Entity\Clicks;

/**
 * Urls controller.
 *
 * @Route("/shorten")
 */
class UrlsController extends Controller
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
	* @Route("/list/{page}/{limit}", name="shorten_list")
    * @Method("GET")
    * @Template()
	*/
	public function listAction($page = 1, $limit = 5)
    {	

		$this->setSession('list_page',$page);
		$this->setSession('list_limit',$limit);
		
		$em = $this->getDoctrine()->getManager();
		
		// Paging
		$itemsCount = count($em->getRepository('StubbyShorteningServiceBundle:Urls')->findAll());
        $query = $em->createQuery( 'select u from StubbyShorteningServiceBundle:Urls u' );
		$query->setFirstResult($offset);
		$query->setMaxResults($this->getListLimit());
        $entities = $query->getResult();

        return array(
            'entities'  => $entities,
            'base_href' => $this->container->getParameter('base_href'),
        );
    }
	
	//Set session Key
	private function setSession($key,$value)
	{
		$session  = $this->get("session");
		$session->set($key, $value);
	}
	
	//Get session Key
	private function getSession($key)
	{
		$session  = $this->get("session");
		return $session->get($key);
	}
	
	//Get List page limit
	private function getListLimit()
	{
		return $this->getSession('list_limit');
	}
	
	//Get Show page limit
	private function getShowLimit()
	{
		return $this->getSession('show_limit');
	}
	
	/**
     * Finds and displays a Urls entity.
     *
     * @Route("/{id}/show/{page}/{limit}", name="shorten_show")
     * @Template()
     */
    public function showAction($id, $page = 1, $limit = 5)
    {
		$this->setSession('show_page',$page);
		$this->setSession('show_limit',$limit);
		
        $click_cache_id = md5('url_clicks_id='.$id);

        $em = $this->getDoctrine()->getManager();
        $urls = $em->getRepository('StubbyShorteningServiceBundle:Urls')->find($id);

        if (!$urls) {
            throw $this->createNotFoundException('Unable to find Urls urls.');
        }

        $deleteForm = $this->createDeleteForm($id);

		// Paging
		$itemsCount = $urls->getClicks()->count();
        $offset = ($page - 1) * $this->getShowLimit();
		//

        $clicks = $urls->getClicks()->slice($offset,$this->getShowLimit());

        return array(
            'urls'        => $urls,
            'clicks'      => $clicks,
            'delete_form' => $deleteForm->createView(),        
            'base_href'   => $this->container->getParameter('base_href'),
        );
    }
	
    /**
     * Creates a new Urls entity.
     *
     * @Route("/create", name="shorten_create")
     * @Method("post")
     * @Template()
     */
    public function createAction()
    {
        $url     = new Urls();
        $request = $this->getRequest();
        $form    = $this->createForm(new UrlsType(), $url);
        $em = $this->getDoctrine()->getManager();

        //check if url already exists
        $r = $request->request->get('scoopon_urlshorterner_urlstype'); 
        $long_url = $r['long_url'];

        $urlQ = $em->createQuery('SELECT u FROM StubbyShorteningServiceBundle:Urls u where u.long_url = :url');
        $urlQ->setParameters( array( 'url'=> $long_url ) );
        $url_check = $urlQ->getResult();;

        if( count($url_check) > 0 )
        {
            $url = $url_check[0];
        } 
        else 
        {
            $form->bindRequest($request);

            if ($form->isValid()) {

                $url->setShortUrl( '' );
                $url->setCreated( new \DateTime() );
                $url->setCreator( $request->getClientIp() );
                $url->setHits(0);

                $em->persist($url);
                $em->flush();

                $url->setShortUrl( self::shortenUrl( $url->getId() ) );
                $em->flush();
            }
        }

        $show_page = $this->getSession('show_page') ? $this->getSession('show_page'):5;

        return $this->redirect(
            $this->generateUrl(
                'shorten_show', 
                array(
                    'id'    => $url->getId(), 
                    'page'  => $show_page, 
                    'limit' => $this->getListLimit()
                )
            )
        );//redirect
    }

    /**
     * Redirect Urls 
     *
     * @Route("/{shortUrl}", name="shorten_redirect")
     * @Template()
     */
    public function redirectAction($shortUrl) 
    {
        //Decode shortURL back to its ID
        $id = self::expandUrl($shortUrl);

        //Get required stuff
        $request = $this->getRequest();
        $server  = $request->createFromGlobals()->server;
        $em      = $this->getDoctrine()->getManager();

        $urls = $em->getRepository('ScooponUrlShortenerBundle:Urls')->find($id);
        if (!$urls) {
            throw $this->createNotFoundException('Unable to find Urls entity.');
        }

        //Record the clicks
        $clicks = new Clicks();
        $clicks->setCreated( new \DateTime() );
        $clicks->setUrls( $urls );
        $clicks->setIp($request->getClientIp());
        $clicks->setReferer($server->get('HTTP_REFERER'));
        $clicks->setUserAgent($server->get('HTTP_USER_AGENT'));

        //Increment clickthrough count
        $urls->setHits( $urls->getHits()+1 );
        $urls->addClicks($clicks);


        $em->persist($clicks);
        $em->persist($urls);
        $em->flush();

        //Send them on their way
        return $this->redirect($urls->getLongUrl());
        exit; //if, for some reason it reaches here, DIE!!

    }//redirect

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    private function shortenUrl($integer)
    {
        $out    = null;
        $base   = $this->container->getParameter('allowed_chars');
        $length = strlen($base);

        while($integer > $length - 1)
        {
            $out = $base[fmod($integer, $length)] . $out;
            $integer = floor( $integer / $length );
        }
        return $base[$integer] . $out;
    }//shortenUrl

    private function expandUrl($string)
    {
        $base   = $this->container->getParameter('allowed_chars');
        $length = strlen($base);
        $size   = strlen($string) - 1;
        $string = str_split($string);
        $out    = strpos($base, array_pop($string));

        foreach($string as $i => $char)
        {
            $out += strpos($base, $char) * pow($length, $size - $i);
        }
        return $out;
    }
}


