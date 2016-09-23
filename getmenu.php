<?php
/**
 * Created by IntelliJ IDEA.
 * User: mithishri
 * Date: 9/15/2016
 * Time: 2:43 PM
 */
include('simple_html_dom.php');

$url = $_GET['url'];

$html = file_get_html($url);

//preg_match_all('/data-original="(.*?)fit=around%7C200%3A200&crop=200%3A200%3B%2A%2C%2A&output-format=webp"/s', $html, $matches);
$array = [];
$element = $html->find('script')[15];


//print_r($element);

//$src = $element->plaintext; //getAttribute('data-original');
//if (strpos($src, 'chains'))
//  array_push($array, preg_split('/(\?)/',$src)[0]);

$str = $element->innertext;



//echo $str;

$res = preg_split('/(=)/', $str);

print_r(preg_split('/(\])/', $res[2])[0].']');

//print_r(json_encode($array));