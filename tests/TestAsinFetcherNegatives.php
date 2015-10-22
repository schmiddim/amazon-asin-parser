<?php
// Requiring composer autoloader (local or global)
foreach ([__DIR__ . '/../../../autoload.php', __DIR__ . '/vendor/autoload.php'] as $file) {
    if (file_exists($file) && !defined('COMPOSER_AUTOLOADER')) {
        define('COMPOSER_AUTOLOADER', $file);
        break;
    }
}
if (!defined('COMPOSER_AUTOLOADER')) {
    die(
        'You need to set up the project dependencies using the following commands:' . PHP_EOL .
        'php -r "readfile(\'https://getcomposer.org/installer\');" | php' . PHP_EOL .
        'php composer.phar install' . PHP_EOL
    );
}
require COMPOSER_AUTOLOADER;

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
