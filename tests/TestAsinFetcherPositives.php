<?php

// Requiring composer autoloader (local or global)
foreach ([__DIR__ . '/../vendor/autoload.php', __DIR__ . '/vendor/autoload.php'] as $file) {
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

class TestAsinFetcherPositives extends PHPUnit_Framework_TestCase
{

    public function testAsinShifted()
    {
        $url = 'http://www.amazon.de/Bose-SoundLink-Colour-Bluetooth-Lautsprecher/dp/B00M7Y0GJ2%3Fpsc%3D1%26SubscriptionId%3D1C40MS11Y3T9CRFXPQ82%26tag%3Dhttpwwwradika-21%26linkCode%3Dxm2%26camp%3D2025%26creative%3D165953%26creativeASIN%3DB00M7Y0GJ2';
        $fetcher = new \Amazon\AsinParser($url);


        $this->assertEquals('de', $fetcher->getTld());
        $this->assertEquals('B00M7Y0GJ2', $fetcher->getAsin());
    }

    public function testGermany()
    {
        $url = 'http://www.amazon.de/dp/3836227622/ref=wl_it_dp_v_S_ttl/275-8449783-2161748?_encoding=UTF8&colid=3PNTY4VFL6H2Q&coliid=I1MY7ZKTP1IFRJ';
        $fetcher = new \Amazon\AsinParser($url);


        $this->assertEquals('de', $fetcher->getTld());
        $this->assertEquals('3836227622', $fetcher->getAsin());
    }

    public function testUk()
    {
        $url = 'http://www.amazon.co.uk/gp/product/B012CGVY4A/ref=s9_simh_gw_p74_d0_i2?pf_rd_m=A3P5ROKL5A1OLE&pf_rd_s=desktop-2&pf_rd_r=0W54GM7A83TZS4FB4KQC&pf_rd_t=36701&pf_rd_p=577049067&pf_rd_i=desktop';
        $fetcher = new \Amazon\AsinParser($url);
        $this->assertEquals('co.uk', $fetcher->getTld());
        $this->assertEquals('B012CGVY4A', $fetcher->getAsin());

        $url = 'http://www.amazon.co.uk/gp/product/B00QKS255E/ref=s9_simh_gw_p74_d0_i5?pf_rd_m=A3P5ROKL5A1OLE&pf_rd_s=desktop-2&pf_rd_r=0W54GM7A83TZS4FB4KQC&pf_rd_t=36701&pf_rd_p=577049067&pf_rd_i=desktop';
        $fetcher = new \Amazon\AsinParser($url);
        $this->assertEquals('co.uk', $fetcher->getTld());
        $this->assertEquals('B00QKS255E', $fetcher->getAsin());

        $url = 'http://www.amazon.co.uk/gp/product/B00KDRUCJY/ref=s9_pop_gw_g349_i4?pf_rd_m=A3P5ROKL5A1OLE&pf_rd_s=desktop-3&pf_rd_r=0W54GM7A83TZS4FB4KQC&pf_rd_t=36701&pf_rd_p=577050007&pf_rd_i=desktop';
        $fetcher = new \Amazon\AsinParser($url);
        $this->assertEquals('co.uk', $fetcher->getTld());
        $this->assertEquals('B00KDRUCJY', $fetcher->getAsin());

        $url = 'http://www.amazon.co.uk/gp/product/B014UIWGN6/ref=s9_pop_gw_g340_i3?pf_rd_m=A3P5ROKL5A1OLE&pf_rd_s=desktop-3&pf_rd_r=0W54GM7A83TZS4FB4KQC&pf_rd_t=36701&pf_rd_p=577050007&pf_rd_i=desktop';
        $fetcher = new \Amazon\AsinParser($url);
        $this->assertEquals('co.uk', $fetcher->getTld());
        $this->assertEquals('B014UIWGN6', $fetcher->getAsin());

    }
}
