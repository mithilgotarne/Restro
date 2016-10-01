<?php
/**
 * Created by IntelliJ IDEA.
 * User: mithishri
 * Date: 9/29/2016
 * Time: 3:09 AM
 */
session_start();

include('conn.php');
print_r($_POST);

$rating = $_POST['rating'];
$review = $_POST['review'];
$now = date('Y-m-d H:i:s');
$resid = $_SESSION['res_id'];
$uid = $_SESSION['id'];
$uname = $_SESSION['name'];

$query = "SELECT * FROM reviews where u_id = $uid AND res_id = '$resid' LIMIT 1";
if ($results = mysqli_query($link, $query)) {

    if (mysqli_num_rows($results)) {

        $query = "UPDATE reviews SET review = '$review', rating = '$rating', r_date = '$now' WHERE u_id = $uid AND res_id = '$resid'";


    } else {

        $query = "INSERT INTO reviews (rating, review, res_id, u_id , r_date, u_name) 
                  VALUES ($rating, '$review', '$resid',$uid,'$now', '$uname' )";


    }

    if ($results = mysqli_query($link, $query)) {

        echo 'done';

    }


} else
    echo mysqli_error($link);
echo $query;