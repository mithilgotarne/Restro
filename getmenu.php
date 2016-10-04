<?php
/**
 * Created by IntelliJ IDEA.
 * User: mithishri
 * Date: 9/15/2016
 * Time: 2:43 PM
 */
/*include('simple_html_dom.php');

$url = $_GET['url'];

$html = file_get_html($url);

$array = [];
$element = $html->find('script')[15];

$str = $element->innertext;

$res = preg_split('/(=)/', $str);

print_r(preg_split('/(\])/', $res[2])[0].']');*/
include('conn.php');

$id = $_GET['res_id'];

$query = "SELECT * FROM menu_items WHERE res_id = '$id'";

$array = array();

if ($result = mysqli_query($link, $query)) {

    while ($row = mysqli_fetch_assoc($result))
        array_push($array, $row);
}

print_r(json_encode($array));