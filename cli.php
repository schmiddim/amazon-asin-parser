<?php

// Requiring composer autoloader (local or global)
foreach ([__DIR__ . '/../../autoload.php', __DIR__ . '/vendor/autoload.php'] as $file) {
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


$url = 'http://www.amazon.co.uk/dp/3836227622/ref=wl_it_dp_v_S_ttl/275-8449783-2161748?_encoding=UTF8&colid=3PNTY4VFL6H2Q&coliid=I1MY7ZKTP1IFRJ';
$fetcher = new \Amazon\AsinParser($url);
echo $fetcher->getAsin() . PHP_EOL;
