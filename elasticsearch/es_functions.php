<?php

if (!function_exists("es_extract_sources_from_search")) { // Yes I am sorry for the code duplication
    function es_extract_sources_from_search($search_result)
    {
        return array_map(function ($hit) { return $hit['_source']; }, $search_result['hits']['hits']);
    }
}
if (!function_exists("es_extract_sources_from_mget")) {
    function es_extract_sources_from_mget($mget_result)
    {
        return array_map(function ($hit) { return $hit['_source']; }, $mget_result['docs']);
    }
}