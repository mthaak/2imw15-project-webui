<?php

require '../vendor/autoload.php';

include 'es_login.php';

/*
 * This script indexes the data in the .csv file $FILENAME to elasticsearch.
 */

$FILENAME = 'users_testdata.csv';
$DELIMITER = ';';
$TYPE = 'user';

function stringToArray($string)
{
    $array = explode(',', str_replace("'", "", substr($string, 1, strlen($string) - 2)));
    if (count($array) == 0 or $array[0] == '')
        return new \stdClass(); // empty arrays are incorrectly encoded to JSON by PHP
    else
        return $array;
}

$params = ['body' => []];
$row_nr = 0;
if (($handle = fopen($FILENAME, 'r')) !== false) {
    $header = fgetcsv($handle, 10000, $DELIMITER);
    while (($row = fgetcsv($handle, 10000, $DELIMITER)) !== false) {
        $row_nr++;

        $params['body'][] = [
            'index' => [
                '_index' => 'my_index',
                '_type'  => $TYPE,
                '_id'    => $row[0],
            ],
        ];

        if ($TYPE == 'tweet') {
            $row[1] = filter_var($row[1], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); // remove weird characters
            $row[9] = stringToArray($row[9]);
            $row[10] = stringToArray($row[10]);
            $row[11] = stringToArray($row[11]);
        } elseif ($TYPE == 'rumor') {
            $row[2] = stringToArray($row[2]);
            $row[5] = stringToArray($row[5]);
            $row[6] = stringToArray($row[6]);
            $row[7] = stringToArray($row[7]);
        }

        $params['body'][] = array_combine($header, $row);

        if ($row_nr % 1000 == 0) {
            $responses = $client->bulk($params);

            // Erase the old bulk request
            $params = ['body' => []];

            if ($responses['errors']) {
                echo("There were errors for the bulk operation.\n");
            }

            // Unset the bulk response when you are done to save memory
            unset($responses);
        }
    }

    // Send the last batch if it exists
    if (!empty($params['body'])) {
        $responses = $client->bulk($params);
        if ($responses['errors']) {
            echo("There were errors for the bulk operation.\n");
        }
    }
    fclose($handle);
}

