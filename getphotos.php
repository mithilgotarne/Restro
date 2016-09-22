<?php
/**
 * Created by IntelliJ IDEA.
 * User: mithishri
 * Date: 9/15/2016
 * Time: 1:34 AM
 */
include('simple_html_dom.php');

$url = $_GET['url'];

$html = file_get_html($url);

//preg_match_all('/data-original="(.*?)fit=around%7C200%3A200&crop=200%3A200%3B%2A%2C%2A&output-format=webp"/s', $html, $matches);
$array = [];
foreach ($html->find('img') as $element) {

    $src = $element->getAttribute('data-original');
    if (strpos($src, 'chains'))
        array_push($array, preg_split('/(\?)/',$src)[0]);
}

print_r(json_encode($array));