<?php
namespace Stubby\UrlShorteningServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stubby\UrlShorteningServiceBundle\Entity\Clicks
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Clicks
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
     * @var datetime $created
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var string $ip
     *
     * @ORM\Column(name="ip", type="string", length=255)
     */
    private $ip;

    /**
     * @var string $referer
     *
     * @ORM\Column(name="referer", type="string", length=255, nullable=true)
     */
    private $referer;

    /**
     * @var string $referer_domain
     *
     * @ORM\Column(name="referer_domain", type="string", length=255, nullable=true)
     */
    private $referer_domain;


    /**
     * @var string $user_agent
     *
     * @ORM\Column(name="user_agent", type="string", length=255)
     */
    private $user_agent;

    /**
     * @var string $browser
     *
     * @ORM\Column(name="browser", type="string", length=255, nullable=true)
     */
    private $browser;

    /**
     * @var string $browser_version
     *
     * @ORM\Column(name="browser_version", type="string", length=255, nullable=true)
     */
    private $browser_version;

    /**
     * @var string $platform
     *
     * @ORM\Column(name="platform", type="string", length=255, nullable=true)
     */
    private $platform;

    /**
     * @var string $platform_version
     *
     * @ORM\Column(name="platform_version", type="string", length=255, nullable=true)
     */
    private $platform_version;

    /**
     * @ORM\ManyToOne(targetEntity="Urls", inversedBy="clicks")
     * @ORM\JoinColumn(name="url_id", referencedColumnName="id")
     */
    protected $urls;

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
     * Set ip
     *
     * @param string $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * Get ip
     *
     * @return string 
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set referer
     *
     * @param string $referer
     */
    public function setReferer($referer)
    {
        $this->referer = $referer;
    }

    /**
     * Get referer
     *
     * @return string 
     */
    public function getReferer()
    {
        return $this->referer;
    }


    /**
     * Set referer_domain
     *
     * @param string $refererDomain
     */
    public function setRefererDomain($refererDomain)
    {
        $this->referer_domain = $refererDomain;
    }

    /**
     * Get referer_domain
     *
     * @return string 
     */
    public function getRefererDomain()
    {
        return $this->referer_domain;
    }

    /**
     * Set user_agent
     *
     * @param string $userAgent
     */
    public function setUserAgent($userAgent)
    {
        $this->user_agent = $userAgent;
    }

    /**
     * Get user_agent
     *
     * @return string 
     */
    public function getUserAgent()
    {
        return $this->user_agent;
    }

    /**
     * Set browser
     *
     * @param string $browser
     */
    public function setBrowser($browser)
    {
        $this->browser = $browser;
    }

    /**
     * Get browser
     *
     * @return string 
     */
    public function getBrowser()
    {
        return $this->browser;
    }

    /**
     * Set browser_version
     *
     * @param string $browserVersion
     */
    public function setBrowserVersion($browserVersion)
    {
        $this->browser_version = $browserVersion;
    }

    /**
     * Get browser_version
     *
     * @return string 
     */
    public function getBrowserVersion()
    {
        return $this->browser_version;
    }

    /**
     * Set platform
     *
     * @param string $platform
     */
    public function setPlatform($platform)
    {
        $this->platform = $platform;
    }

    /**
     * Get platform
     *
     * @return string 
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * Set platform_version
     *
     * @param string $platformVersion
     */
    public function setPlatformVersion($platformVersion)
    {
        $this->platform_version = $platformVersion;
    }

    /**
     * Get platform_version
     *
     * @return string 
     */
    public function getPlatformVersion()
    {
        return $this->platform_version;
    }

    /**
     * Set urls
     *
     * @param Scoopon\UrlShortenerBundle\Entity\Urls $urls
     */
    public function setUrls(\Scoopon\UrlShortenerBundle\Entity\Urls $urls)
    {
        $this->urls = $urls;
    }

    /**
     * Get urls
     *
     * @return Scoopon\UrlShortenerBundle\Entity\Urls 
     */
    public function getUrls()
    {
        return $this->urls;
    }

    /**
     * Set url
     *
     * @param Scoopon\UrlShortenerBundle\Entity\Urls $url
     */
    public function setUrl(\Scoopon\UrlShortenerBundle\Entity\Urls $url)
    {
        $this->url = $url;
    }

    /**
     * Get url
     *
     * @return Scoopon\UrlShortenerBundle\Entity\Urls 
     */
    public function getUrl()
    {
        return $this->url;
    }
}
