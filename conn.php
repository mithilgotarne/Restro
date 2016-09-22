<?php
/**
 * Created by IntelliJ IDEA.
 * User: mithishri
 * Date: 9/9/2016
 * Time: 6:29 PM
 */

$host = "localhost"; //LocalHost
$user = "root";        //username
$pass = "1234";        //passworf
$db_name = "restrodb"; //datanase name
$port = "3306";        //host
$error = "";            //for collecting error through out the site
//Create a mysqli object for connection with database
$link = new mysqli($host, $user, $pass, $db_name, $port);

if (mysqli_connect_error()) {
    $error .= "Could not connect to the database.<br />";
}

?>