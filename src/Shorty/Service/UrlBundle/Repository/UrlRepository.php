<?php
namespace Shorty\Service\UrlBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Shorty\Service\UrlBundle\Entity\Url;

class UrlRepository extends EntityRepository 
{
    public function urlExists($url)
    {
        $q = $this->_em->createQuery('SELECT u FROM ShortyServiceUrlBundle:Url where u.checksum = :checksum');
        $q->setParameters( array(
            'checksum' => md5($url)
        ));

        return $url = $q->getResult();
    }
}//UrlRepository
