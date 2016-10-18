<?php

require '../vendor/autoload.php';

include "es_login.php";

/*
 * This script deletes and recreates the index with given mapping.
 */

if ($client->indices()->exists(['index' => 'my_index'])) {
    $client->indices()->delete(['index' => 'my_index']);
}

$params = [
    'index' => 'my_index',
    'body'  => [
        'mappings' => [
            'user'  => [
                '_source'    => [
                    'enabled' => true,
                ],
                'properties' => [
                    'user_id'             => [
                        'type' => 'string',
                    ],
                    'user_screen_name'    => [
                        'type' => 'string',
                    ],
                    'influence'           => [
                        'type' => 'float',
                    ],
                    'credibility'         => [
                        'type' => 'float',
                    ],
                    'n_rumors'            => [
                        'type' => 'integer',
                    ],
                    'n_rumors_produced'   => [
                        'type' => 'integer',
                    ],
                    'n_rumors_propagated' => [
                        'type' => 'integer',
                    ],
                    'n_rumors_stifled'    => [
                        'type' => 'integer',
                    ],
                ],
            ],
            'tweet' => [
                '_source'    => [
                    'enabled' => 'true',
                ],
                'properties' => [
                    'tweet_id'      => [
                        'type' => 'string',
                    ],
                    'text'          => [
                        'type' => 'string',
                    ],
                    'created_at'    => [
                        'type'   => 'date',
                        'format' => 'dd-MM-yyyy HH:mm',
                    ],
                    'retweet_count' => [
                        'type' => 'integer',
                    ],
                    'user_id'       => [
                        'type' => 'string',
                    ],
                    'screen_name'   => [
                        'type' => 'string',
                    ],
                    '#followers'    => [
                        'type' => 'integer',
                    ],
                    '#followings'   => [
                        'type' => 'integer',
                    ],
                    '#statuses'     => [
                        'type' => 'integer',
                    ],
                    'keywords'      => [
                        'type' => 'string',
                    ],
                    'hashtags'      => [
                        'type' => 'string',
                    ],
                    'urls'          => [
                        'type' => 'string',
                    ],
                ],
            ],
            'rumor' => [
                '_source'    => [
                    'enabled' => 'true',
                ],
                'properties' => [
                    'rumor_id'          => [
                        'type' => 'integer',
                    ],
                    'representative_id' => [
                        'type' => 'string',
                    ],
                    'variations_ids'    => [
                        'type' => 'string',
                    ],
                    'popularity'        => [
                        'type' => 'integer',
                    ],
                    'veracity'          => [
                        'type' => 'float',
                    ],
                    'producer_ids'      => [
                        'type' => 'string',
                    ],
                    'propagator_ids'    => [
                        'type' => 'string',
                    ],
                    'stifler_ids'       => [
                        'type' => 'string',
                    ],
                ],
            ],
        ],
    ],
];

$client->indices()->create($params);
