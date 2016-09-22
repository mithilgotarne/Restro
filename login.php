<?php

include('conn.php');

session_start();
$error = "";

//email entered by user
$email = mysqli_real_escape_string($link, $_POST['email']);

//password entered by user md5 method is used for password encryption
$password = md5(md5($_POST['email']) . $_POST['password']);

//Query to see whether user and password combination exists
$query = "SELECT * FROM users WHERE email = '$email' AND password = '$password' LIMIT 1";

if ($result = mysqli_query($link, $query)) {
    if ($row = mysqli_fetch_array($result)) {
        $_SESSION['id'] = $row['id']; // Creating session id
        $_SESSION['name'] = $row['name'];
        $_SESSION['email'] = $row['email'];
    } else {
        $error .= "User does not exists with that combination of email and password.<br />";
    }
} else {
    $error .= "User does not exists with that combination of email and password.<br />";
}

if($error != "")
    echo $error;
?>