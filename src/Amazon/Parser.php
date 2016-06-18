<?php
/**
 * User: ms
 * Date: 12.10.15
 * Time: 22:16
 */

namespace Amazon;

use Amazon\Exceptions\InvalidDomainException;

abstract class Parser
{
	/**
	 * @var string
	 */
	private $tld = null;

	/**
	 * @var array
	 */
	private $unusedDomainParts = array(
		'amazon'
	, 'amzn'
	, 'www'
	);

	/**
	 * @var array
	 */
	private $amazonDomains = array(
		'amazon'
	, 'amzn'
	);

	/**
	 * @var string
	 */
	protected $url = null;

	public function __construct($url)
	{

		$this->url = $url;
		//Question Marks
		if (preg_match('/%3F/', $url)) {
			$this->url = substr($url, 0, strpos($url, "%3F"));

		}

		$urlParameter = parse_url($this->getUrl());
		$this->processUrl($urlParameter);
		$this->processTld($urlParameter['host']);

	}

	/**
	 * @param string $url
	 */
	protected function setUrl($url)
	{
		$this->url = $url;
	}

	/**
	 * @return string
	 */
	protected function getUrl()
	{
		return $this->url;
	}

	/**
	 * @param $urlParameter
	 * @throws InvalidDomainException
	 */
	protected function processUrl($urlParameter)
	{
		if (false === array_key_exists('path', $urlParameter)) {
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
	public function getTld()
	{
		return $this->tld;
	}

	/**
	 * @param string $tld
	 */
	protected function setTld($tld)
	{
		$this->tld = $tld;
	}

}