<?php

// Requiring composer autoloader (local or global)
foreach ([__DIR__ . '/../../../autoload.php', __DIR__ . '/vendor/autoload.php'] as $file) {
    if (file_exists($file) &&!defined('COMPOSER_AUTOLOADER') ) {

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

class TestWishlistParser extends PHPUnit_Framework_TestCase
{

    public function testPositive(){
        $url ='http://www.amazon.de/gp/registry/wishlist/3PNTY4VFL6H2Q/ref=cm_wl_rlist_go_o?';
        $wishlistParser = new \Amazon\WishlistParser($url);
        $this->assertEquals('3PNTY4VFL6H2Q', $wishlistParser->getWishlistId());

        $url='http://www.amazon.de/gp/registry/wishlist/3RNLGV3AW8M4L/ref=cm_sw_em_r_wsl_deRgwb1N585SF_wb';
        $wishlistParser = new \Amazon\WishlistParser($url);
        $this->assertEquals('3RNLGV3AW8M4L', $wishlistParser->getWishlistId());
    }
}
