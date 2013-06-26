<?php
namespace Shorty\Service\UrlBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Shorty\Service\UrlBundle\Entity\Url;

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
