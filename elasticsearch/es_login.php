<?php

use Elasticsearch\ClientBuilder;

/*
 * This script sets up a elasticsearch client.
 */

$client = ClientBuilder::create()
                       ->setHosts(['host' => 'admin:geqxf4lgoa65cdeasm@09f5609c2faaf618895cb6cefae88fda.eu-west-1.aws.found.io:9200'])
                       ->build();
