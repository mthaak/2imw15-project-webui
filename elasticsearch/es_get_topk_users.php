<?php

require __DIR__ . '/../vendor/autoload.php';

include 'es_login.php';
include 'es_functions.php';

/*
 * This script gets the top k users with the most rumors produced/propagated/stifled from elasticsearch.
 */

$K = 3;

$params = [
    'index' => 'my_index',
    'type'  => 'user',
    'body'  => [
        'size' => $K,
        'sort' => [['n_rumors_produced' => ['order' => 'desc']]],
    ],
];
$top_producers = es_extract_sources_from_search($client->search($params));

$params = [
    'index' => 'my_index',
    'type'  => 'user',
    'body'  => [
        'size' => $K,
        'sort' => [['n_rumors_propagated' => ['order' => 'desc']]],
    ],
];
$top_propagators = es_extract_sources_from_search($client->search($params));

$params = [
    'index' => 'my_index',
    'type'  => 'user',
    'body'  => [
        'size' => $K,
        'sort' => [['n_rumors_stifled' => ['order' => 'desc']]],
    ],
];
$top_stiflers = es_extract_sources_from_search($client->search($params));
