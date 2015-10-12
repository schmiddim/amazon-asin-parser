<?php
namespace Amazon;

use Amazon\Exceptions\InvalidAsinException;
use Amazon\Exceptions\InvalidDomainException;

/**
 * Class AsinFetcher
 * @see https://de.wikipedia.org/wiki/Amazon_Standard_Identification_Number
 * @package Amazon
 */
class AsinFetcher
{

    /**
     * China: http://amazon.cn/dp/0596519796
     * Deutschland: http://amazon.de/dp/0596519796
     * Frankreich: http://amazon.fr/dp/0596519796
     * Italien: http://amazon.it/dp/0596519796
     * Japan: http://amazon.co.jp/dp/0596519796
     * Kanada: http://amazon.ca/dp/0596519796
     * Spanien: http://amazon.es/dp/0596519796
     * Vereinigte Staaten: http://amazon.com/dp/0596519796
     * Vereinigtes Königreich: http://amazon.co.uk/dp/0596519796
     */


    const LENGTH_ASIN = 10;
    /**
     * @var string
     */
    private $url = null;

    /**
     * @var string
     */
    private $tld = null;

    /**
     * @var string
     */
    private $asin = null;

    private $unusedDomainParts = array(
        'amazon'
    , 'amzn'
    , 'www'
    );

    private $amazonDomains = array(
        'amazon'
    , 'amzn'
    );

    public function __construct($url)
    {

        $this->url = $url;
        $this->processUrl();
    }

    protected function processUrl()
    {
        $params = parse_url($this->getUrl());
        if (false === array_key_exists('path', $params)) {
            throw new InvalidDomainException(sprintf('Url %s has no path', $this->getUrl()));
        }

        //Check if we have an Amazon Domain
        $isAmazonDomain = false;
        //ShortUrl
        foreach ($this->amazonDomains as $domain) {
            if (preg_match('/' . $domain . '/', $this->getUrl())) {
                $isAmazonDomain = true;
            }
        }
        if (false === $isAmazonDomain) {
            throw new InvalidDomainException(sprintf('Url %s does not belong to Amazon', $this->getUrl()));
        }


        $this->processTld($params['host']);
        $this->processAsin($params['host'], $params['path']);
    }

    protected function processAsin($host, $path)
    {
        $path = str_replace('/product', '', $path);
        $pathParts = explode('/', $path);

        //ShortUrl
        if (preg_match('/amzn/', $host)) {
            $this->setAsin(end($pathParts));
            return;
        }

        if (false === array_key_exists(2, $pathParts)) {
            throw new InvalidAsinException(sprintf('Url %s has no ASIN', $this->getUrl()));
        }
        if (strlen($pathParts[2]) !== self::LENGTH_ASIN) {
            throw new InvalidAsinException(sprintf('Url %s has no valid ASIN', $this->getUrl()));

        }
        //@todo length of ASIN!
        $this->setAsin($pathParts[2]);
        return;
    }

    /**
     * @param $host
     * @return string
     */
    protected function processTld($host)
    {
        $tldStrings = [];
        $parts = explode('.', $host);
        foreach ($parts as $part) {

            if (false === in_array($part, $this->unusedDomainParts)) {
                $tldStrings[] = $part;
            }
        }

        $this->setTld(implode('.', $tldStrings));
    }

    /**
     * @return string
     */
    public function getAsin()
    {
        return $this->asin;
    }

    /**
     * @return string
     */
    protected function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getTld()
    {
        return $this->tld;
    }

    /**
     * @param string $asin
     */
    protected function setAsin($asin)
    {
        $this->asin = $asin;
    }

    /**
     * @param string $tld
     */
    protected function setTld($tld)
    {
        $this->tld = $tld;
    }

    /**
     * @param string $url
     */
    protected function setUrl($url)
    {
        $this->url = $url;
    }
}