<?php 
namespace Shorty\Service\UrlBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Shorty\Service\UrlBundle\Entity\Url
 *
 * @ORM\Table(name="urls")
 * @ORM\Entity(repositoryClass="Shorty\Service\UrlBundle\Repository\UrlRepository")
 */
class Url
{

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $checksum
     *
     * @ORM\Column(name="checksum", type="string", length=255, nullable=true)
     */
    private $checksum;

    /**
     * @var string $long_url
     *
     * @ORM\Column(name="long_url", type="string", length=255)
     */
    private $long_url;

    /**
     * @var string $short_url
     *
     * @ORM\Column(name="short_url", type="string", length=255)
     */
    private $short_url;

    /**
     * @var datetime $created
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var string $creator
     *
     * @ORM\Column(name="creator", type="string", length=64)
     */
    private $creator;

    /**
     * @var integer $hits
     *
     * @ORM\Column(name="hits", type="integer")
     */
    private $hits;

    /**
     * @ORM\OneToMany(targetEntity="Click", mappedBy="url")
     */
    protected $clicks;

    public function __construct()
    {
        $this->clicks = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set checksum
     *
     * @param string $checksum
     */
    public function setChecksum($checksum)
    {
        $this->checksum = $checksum;
    }

    /**
     * Get checksum
     *
     * @return string 
     */
    public function getChecksum()
    {
        return $this->checksum;
    }

    /**
     * Set long_url
     *
     * @param string $longUrl
     */
    public function setLongUrl($longUrl)
    {
        $this->long_url = $longUrl;
    }

    /**
     * Get long_url
     *
     * @return string 
     */
    public function getLongUrl()
    {
        return $this->long_url;
    }

    /**
     * Set short_url
     *
     * @param string $shortUrl
     */
    public function setShortUrl($shortUrl)
    {
        $this->short_url = $shortUrl;
    }

    /**
     * Get short_url
     *
     * @return string 
     */
    public function getShortUrl()
    {
        return $this->short_url;
    }

    /**
     * Set created
     *
     * @param datetime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * Get created
     *
     * @return datetime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set creator
     *
     * @param string $creator
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;
    }

    /**
     * Get creator
     *
     * @return string 
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * Set hits
     *
     * @param integer $hits
     */
    public function setHits($hits)
    {
        $this->hits = $hits;
    }

    /**
     * Get hits
     *
     * @return integer 
     */
    public function getHits()
    {
        return $this->hits;
    }

    /**
     * Add click
     *
     * @param \Stubby\ShorteningServiceBundle\Entity\Click $clicks
     */
    public function addClick(\Stubby\ShorteningServiceBundle\Entity\Click $click)
    {
        $this->clicks[] = $click;
    }

    /**
     * Get clicks
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getClicks()
    {
        return $this->clicks;
    }

}
