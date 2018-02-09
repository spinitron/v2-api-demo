<?php

/**
 * @var SpinitronApiClient $client a client instance available in any including context
 */

if (!isset($client)) {
    include_once __DIR__ . '/SpinitronApiClient.php';

    // Put your station's API key in the first param of the constructor.
    // You can change the cache directory but it must be writable by the web server.
    $client = new SpinitronApiClient('Your-API-Key', __DIR__ . '/../cache');
}
