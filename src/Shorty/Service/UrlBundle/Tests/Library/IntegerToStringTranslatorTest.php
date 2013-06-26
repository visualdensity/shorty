<?php
namespace Shorty\Service\UrlBundle\Tests\Library;

use Shorty\Service\UrlBundle\Library\IntegerToStringTranslator;

class IntegerToStringTranslatorTest extends \PHPUnit_Framework_TestCase
{
    protected $shortener;
    protected $testIds;
    protected $shortenedUrls = Array();

    public function __construct()
    {
        $allowedChars    = "0a1b2c3d4e5f6g7h8i9jklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $this->testIds   = array( 1, 222, 543, 9483, 11997, 2047931 );
        $this->shortener = new IntegerToStringTranslator($allowedChars);
    }

    public function testShortenerInstance()
    {
        self::assertInternalType('object', $this->shortener);
    }//testShortenerInstance

    public function testEndcode()
    {
        foreach($this->testIds as $id) {
            $shortenedUrl = $this->shortener->encode($id);

            self::assertGreaterThan(0, strlen($shortenedUrl));
            self::assertInternalType('string', $shortenedUrl);

            $this->shortenedUrls[$id] = $shortenedUrl;
        }

    }//testEncode

    public function testDecode()
    {
        foreach($this->shortenedUrls as $original_id => $url) {
            $decoded_id = $this->shortener->decode($url);
            self::assertInternalType('integer', $decoded_id);
            self::assertEquals($original_id, $decoded_id);
        }
    }//testDecode
}
