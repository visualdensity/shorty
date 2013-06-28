<?php
namespace Shorty\Service\UrlBundle\Tests\Entity;

use Shorty\Service\UrlBundle\Entity\Url;
use Shorty\Service\UrlBundle\Entity\Click;

use Shorty\Service\UrlBundle\Tests\DoctrineEnabledTestCase;

class UrlTest extends DoctrineEnabledTestCase
{
    protected $url;

    public function __construct()
    {
        $this->url = new Url();
    }

    public function testObject()
    {
        self::assertInternalType('object', $this->url);
    }

    public function testProperties()
    {
        self::assertObjectHasAttribute('id',        $this->url);
        self::assertObjectHasAttribute('checksum',  $this->url);
        self::assertObjectHasAttribute('long_url',  $this->url);
        self::assertObjectHasAttribute('short_url', $this->url);
        self::assertObjectHasAttribute('created',   $this->url);
        self::assertObjectHasAttribute('creator',   $this->url);
        self::assertObjectHasAttribute('hits',      $this->url);
    }

    public function testGettersSetters()
    {
        $this->assertTrue( method_exists($this->url, 'getId') );
        $this->assertTrue( method_exists($this->url, 'getChecksum') );
        $this->assertTrue( method_exists($this->url, 'getLongUrl') );
        $this->assertTrue( method_exists($this->url, 'setLongUrl') );
        $this->assertTrue( method_exists($this->url, 'getShortUrl') );
        $this->assertTrue( method_exists($this->url, 'setShortUrl') );
        $this->assertTrue( method_exists($this->url, 'getCreated') );
        $this->assertTrue( method_exists($this->url, 'setCreated') );
        $this->assertTrue( method_exists($this->url, 'getCreator') );
        $this->assertTrue( method_exists($this->url, 'setCreator') );
        $this->assertTrue( method_exists($this->url, 'setHits') );
        $this->assertTrue( method_exists($this->url, 'getHits') );
    }

    public function testSave() 
    {
        $testUrl = 'http://google.com';

        $url = new Url();
        $url->setLongUrl( $testUrl );
        $url->setCreated( new \Datetime );
        $url->setHits( 0 );

        $this->em->persist($url);
        $this->em->flush();

        $this->assertInstanceOf( 'Shorty\Service\UrlBundle\Entity\Url', $url );

        $this->assertInternalType('integer', $url->getId() );
        $this->assertEquals( $testUrl, $url->getLongUrl() );
        $this->assertEquals( md5($testUrl), $url->getChecksum() );
        $this->assertInstanceOf( 'Datetime', $url->getCreated() );
        $this->assertInternalType('integer', $url->getHits() );
    }
}//UrlTest
