<?php
namespace Amazon;

use Amazon\Exceptions\InvalidAsinException;


/**
 * Class AsinFetcher
 * @see https://de.wikipedia.org/wiki/Amazon_Standard_Identification_Number
 * @package Amazon
 */
class AsinParser extends Parser
{

    const LENGTH_ASIN = 10;

    /**
     * @var string
     */
    private $asin = null;

    public function __construct($url)
    {
        parent::__construct($url);
        $urlParameter = parse_url($this->getUrl());

        $this->processAsin($urlParameter['host'], $urlParameter['path']);
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

        foreach ($pathParts as $index => $part) {
            if (strlen($part) === self::LENGTH_ASIN) {
                if (array_key_exists($index - 1, $pathParts) && $pathParts[$index - 1] === 'dp') {
                    $this->setAsin($part);
                    return;
                }

            }
        }

        if (strlen($pathParts[2]) !== self::LENGTH_ASIN) {
            throw new InvalidAsinException(sprintf('Url %s has no valid ASIN', $this->getUrl()));

        }
        //@todo length of ASIN!
        $this->setAsin($pathParts[2]);
        return;
    }

    /**
     * @return string
     */
    public function getAsin()
    {
        return $this->asin;
    }

    /**
     * @param string $asin
     */
    protected function setAsin($asin)
    {
        $this->asin = $asin;
    }
}