<?php
// Requiring composer autoloader (local or global)
foreach ([__DIR__ . '/../../autoload.php', __DIR__ . '/vendor/autoload.php'] as $file) {
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

$url ='http://www.amazon.de/gp/registry/wishlist/3PNTY4VFL6H2Q/ref=cm_wl_rlist_go_o?';

$wishlistParser = new \Amazon\WishlistParser($url);
