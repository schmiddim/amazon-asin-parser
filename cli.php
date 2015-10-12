<?php


require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$url = 'http://www.amazon.co.uk/dp/3836227622/ref=wl_it_dp_v_S_ttl/275-8449783-2161748?_encoding=UTF8&colid=3PNTY4VFL6H2Q&coliid=I1MY7ZKTP1IFRJ';
$fetcher = new \Amazon\AsinFetcher($url);
echo $fetcher->getAsin();
