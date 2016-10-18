<?php

require __DIR__ . '/../vendor/autoload.php';

include 'es_login.php';
include 'es_functions.php';

/*
 * TODO
 */

if (isset($_POST['search_query']) and $_POST['search_query'] != '') {
    $query = [
        'multi_match' => [
            'query'  => $_POST['search_query'],
            'fields' => ['representative_tweet', 'variations.text'],
        ],
    ];
} else {
    $query = [
        'match_all' => [],
    ];
}
$params = [
    'index' => 'my_index',
    'type'  => 'rumor',
    'body'  => [
        'size'  => '10',
        'query' => $query,
    ],
];
$rumors = es_extract_sources_from_search($client->search($params));
