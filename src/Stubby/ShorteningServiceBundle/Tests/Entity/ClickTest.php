<?php
namespace Stubby\ShorteningServiceBundle\Tests\Entity;

use Stubby\ShorteningServiceBundle\Entity\Url;

class UrlTest extends \PHPUnit_Framework_TestCase
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
        self::assertObjectHasAttribute('clicks',    $this->url);
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
}//UrlTest
