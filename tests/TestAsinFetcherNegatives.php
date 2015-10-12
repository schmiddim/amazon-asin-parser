<?php
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

class TestAsinFetcherNegatives extends PHPUnit_Framework_TestCase
{


    public function testWithoutPath()
    {

        $this->setExpectedException('\Amazon\Exceptions\InvalidDomainException');
        $url = 'http://www.amazon.de';
        $fetcher = new \Amazon\AsinParser($url);
        echo $fetcher->getAsin();
    }

    public function testWithoutASIN()
    {
        $this->setExpectedException('\Amazon\Exceptions\InvalidAsinException');
        $url = 'http://www.amazon.de/blabla';
        $fetcher = new \Amazon\AsinParser($url);
        echo $fetcher->getAsin();
    }

    public function testWithWrongUrl()
    {
        $this->setExpectedException('\Amazon\Exceptions\InvalidDomainException');
        $url = 'http://www.googl.de/dp/3836227622/';
        $fetcher = new \Amazon\AsinParser($url);
        echo $fetcher->getAsin();
    }

    public function testWithInvalidAsin()
    {
        $this->setExpectedException('\Amazon\Exceptions\InvalidAsinException');
        $url = 'http://www.amazon.de/dp/3836220007622/';
        $fetcher = new \Amazon\AsinParser($url);
        echo $fetcher->getAsin();
    }

}
