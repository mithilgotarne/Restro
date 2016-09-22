<?php

error_reporting(E_ALL);

$lat = '';
$lng = '';
$url = '';

if (isset($_GET['lat']) && isset($_GET['lng'])) {

    $lat = $_GET['lat'];
    $lng = $_GET['lng'];

    if (isset($_GET['q']))
        $url = 'https://developers.zomato.com/api/v2.1/search?q=' . $_GET['q'] . '&lat=' . $lat . '&lon=' . $lng . '&radius=100000';

    else
        $url = 'https://developers.zomato.com/api/v2.1/geocode?lat=' . $lat . '&lon=' . $lng;

} else if (isset($_GET['res-id'])) {

    $url = 'https://developers.zomato.com/api/v2.1/reviews?res_id=' . $_GET['res-id'];
}


// Get cURL resource
$curl = curl_init();

// Curl options
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => ['Accept: application/json', 'user-key: 695e1a81943b0369c439ca00f7c177b2'],
    CURLOPT_URL => $url
));

// Send the request & save response to $resp
// Check for errors if curl_exec fails
if (!$resp = curl_exec($curl)) {
    die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
}

// Close request to clear up some resources
curl_close($curl);

$php_array = json_decode($resp, true);

if (isset($_GET['res-id'])) {

    echo json_encode($php_array['user_reviews']);

} else if (isset($php_array['nearby_restaurants'])) {

    echo json_encode($php_array['nearby_restaurants']);

} else {

    echo json_encode($php_array['restaurants']);
}


?>

