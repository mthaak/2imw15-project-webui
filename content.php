<?php

function round_floats($array)
{
    foreach ($array as &$item) {
        if (floatval($item) > 0) {
            $item = strval(round(floatval($item), 2));
        }
    }

    return $array;
}

function str_replace_assoc($replace_array, $subject)
{
    foreach ($replace_array as $search => $replace) {
        if (is_string($search) and is_string($replace))
            $subject = str_replace("%$search%", $replace, $subject);
    }

    return $subject;
}

function convertUserToHtml($user, $user_html_template)
{
    $user = round_floats($user);

    $user['credibility'] = number_format($user['credibility'] * 100, 1) . '%';

    return str_replace_assoc($user, $user_html_template);
}

function emphasize_search_terms($subject, $search_query)
{
    foreach (explode(' ', $search_query) as $search_term) {
        $subject = preg_replace("/(^|[ #>])(" . $search_term . ")([^a-z0-9]|$)/i", "$1<b class='text-primary'>$2</b>$3", $subject);
    }

    return $subject;
}

function convertRumorToHtml($rumor, $rumor_html_template, $search_query)
{
    $variation_html = '
        <li class="Variation">%variation%</li>';
    $rumor["variations"] = join("\n", array_map(function ($variation) use ($variation_html) { return str_replace("%variation%", $variation, $variation_html); }, array_column($rumor["variations"], 'text')));

    $rumor['variations'] = emphasize_search_terms($rumor['variations'], $search_query);
    $rumor['representative_tweet'] = emphasize_search_terms($rumor['representative_tweet'], $search_query);

    $rumor['veracity'] = number_format($rumor['veracity'] * 100, 1) . '%';

    $rumor['propagators'] = implode(', ', array_column($rumor['propagators'], 'user_screen_name'));
    $rumor['stiflers'] = implode(', ', array_column($rumor['stiflers'], 'user_screen_name'));

    $rumor_html = str_replace_assoc($rumor, $rumor_html_template);

    return $rumor_html;
}
