<?php
namespace Shorty\Service\UrlBundle\Tests\Entity;

use Shorty\Service\UrlBundle\Entity\Url;
use Shorty\Service\UrlBundle\Entity\Click;

use Shorty\Service\UrlBundle\Tests\DoctrineEnabledTestCase;

class ClickTest extends DoctrineEnabledTestCase
{
    protected $click;

    public function __construct()
    {
        $this->click = new Click();
    }

    public function testObject()
    {
        self::assertInternalType('object', $this->click);
    }

    public function testProperties()
    {
        self::assertObjectHasAttribute('id', $this->click);
        self::assertObjectHasAttribute('created', $this->click);
        self::assertObjectHasAttribute('ip', $this->click);
        self::assertObjectHasAttribute('referer', $this->click);
        self::assertObjectHasAttribute('referer_domain', $this->click);
        self::assertObjectHasAttribute('user_agent', $this->click);
        self::assertObjectHasAttribute('browser', $this->click);
        self::assertObjectHasAttribute('browser_version', $this->click);
        self::assertObjectHasAttribute('platform', $this->click);
        self::assertObjectHasAttribute('platform_version', $this->click);
        self::assertObjectHasAttribute('url', $this->click);
    }

    public function testGettersSetters()
    {
        $this->assertTrue( method_exists($this->click, 'getId') );
        $this->assertTrue( method_exists($this->click, 'setCreated') );
        $this->assertTrue( method_exists($this->click, 'getCreated') );
        $this->assertTrue( method_exists($this->click, 'setIp') );
        $this->assertTrue( method_exists($this->click, 'getIp') );
        $this->assertTrue( method_exists($this->click, 'setReferer') );
        $this->assertTrue( method_exists($this->click, 'getReferer') );
        $this->assertTrue( method_exists($this->click, 'setUserAgent') );
        $this->assertTrue( method_exists($this->click, 'getUserAgent') );
        $this->assertTrue( method_exists($this->click, 'setBrowser') );
        $this->assertTrue( method_exists($this->click, 'getBrowser') );
        $this->assertTrue( method_exists($this->click, 'setBrowserVersion') );
        $this->assertTrue( method_exists($this->click, 'getBrowserVersion') );
        $this->assertTrue( method_exists($this->click, 'setPlatform') );
        $this->assertTrue( method_exists($this->click, 'getPlatform') );
        $this->assertTrue( method_exists($this->click, 'setPlatformVersion') );
        $this->assertTrue( method_exists($this->click, 'getPlatformVersion') );
        $this->assertTrue( method_exists($this->click, 'setUrl') );
        $this->assertTrue( method_exists($this->click, 'getUrl') );
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

        $click = new Click();
        $click->setCreated( new \Datetime );
        $click->setIp('127.0.0.1');
        $click->setReferer('string');
        $click->setUserAgent('string');
        $click->setBrowser('string');
        $click->setBrowserVersion('string');
        $click->setPlatform('string');
        $click->setPlatformVersion('string');
        $click->setUrl($url);

        $this->em->persist($click);
        $this->em->flush();

        $this->assertInstanceOf('\Shorty\Service\UrlBundle\Entity\Click', $click);
        $this->assertInstanceOf('\Shorty\Service\UrlBundle\Entity\Url', $click->getUrl());

        $this->assertInstanceOf('\Datetime', $click->getCreated());
        $this->assertEquals('127.0.0.1', $click->getIp());
    }
}//UrlTest
