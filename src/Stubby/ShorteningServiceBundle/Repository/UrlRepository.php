<?php
namespace Stubby\ShorteningServiceBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Stubby\ShorteningServiceBundle\Entity\Url;

class UrlRepository extends EntityRepository 
{
    public function urlExists($url)
    {
        $q = $this->_em->createQuery('SELECT u FROM ScooponUrlShortenerBundle:Url where u.long_url = :url');
        $q->setParameters( array(
            'url' => $url
        ));

        $url = $q->getResults();
    }
}//UrlRepository
