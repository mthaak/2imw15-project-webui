<?php

require __DIR__ . '/../vendor/autoload.php';

include 'es_login.php';
include 'es_functions.php';

/*
 * TODO
 */

$params = [
    'index' => 'my_index',
    'type'  => 'rumor',
    'body'  => [
        'size' => '10',
    ],
];
$rumors = es_extract_sources_from_search($client->search($params));
foreach ($rumors as $rumor) {
    $params = [
        'index' => 'my_index',
        'type'  => 'tweet',
        'id'    => $rumor['representative_id'],
    ];
    $rumor['representative_tweet'] = $client->get($params)['_source']['text'];

    $ids = [];
    $params = [
        'index' => 'my_index',
        'type'  => 'tweet',
        'body'  => [
            'ids' => $rumor['variation_ids'],
        ],
    ];
    $rumor['variations'] = es_extract_sources_from_mget($client->mget($params));

    $params = [
        'index' => 'my_index',
        'type'  => 'user',
        'body'  => [
            'ids' => $rumor['producer_ids'],
        ],
    ];
    $rumor['producers'] = es_extract_sources_from_mget($client->mget($params));

    $params = [
        'index' => 'my_index',
        'type'  => 'user',
        'body'  => [
            'ids' => $rumor['propagator_ids'],
        ],
    ];
    $rumor['propagators'] = es_extract_sources_from_mget($client->mget($params));

    $params = [
        'index' => 'my_index',
        'type'  => 'user',
        'body'  => [
            'ids' => $rumor['stifler_ids'],
        ],
    ];
    $rumor['stiflers'] = es_extract_sources_from_mget($client->mget($params));

    $params = [
        'index' => 'my_index',
        'type'  => 'rumor',
        'id'    => $rumor['rumor_id'],
        'body'  => $rumor,
    ];
    $response = $client->index($params);
    $a = 3;
}