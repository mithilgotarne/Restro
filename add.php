<?php
/**
 * Created by IntelliJ IDEA.
 * User: mithishri
 * Date: 9/9/2016
 * Time: 6:16 PM
 */

include('conn.php');

$rest = $_POST['rest'];

$restObj = json_decode($rest, true);

$id = $restObj['id'];

$details = mysqli_real_escape_string($link, $rest);

$results = 0;

$query = "SELECT * FROM restaurants WHERE id = '$id'";

if ($result = mysqli_query($link, $query)) {
    $results = mysqli_num_rows($result);
}

if ($results == 0) {

    $query = "INSERT INTO restaurants (id, details) 
                      VALUES ('$id', '$details')";

    if ($result = mysqli_query($link, $query)) {

        echo 'update done';

    }
} else {

    echo 'restaurant exists';

}

