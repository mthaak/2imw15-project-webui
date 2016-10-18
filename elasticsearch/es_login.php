<?php

use Elasticsearch\ClientBuilder;

/*
 * This script sets up a elasticsearch client.
 */

$client = ClientBuilder::create()
                       ->setHosts(['host' => 'admin:7g1o3wiwr5oscamg49@277131d077608ba3df0679f8eeb8842a.eu-west-1.aws.found.io:9200'])
                       ->build();
