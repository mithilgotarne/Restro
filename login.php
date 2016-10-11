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
        if ($row['activated'] == 1) {
            $_SESSION['id'] = $row['id']; // Creating session id
            $_SESSION['name'] = $row['name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['type'] = $row['type'];
            $_SESSION['dob'] = $row['dob'];
            if (isset($row['rest']))
                $_SESSION['rest'] = $row['rest'];
        } else echo '<div class="alert alert-info alert-dismissible fade in" role="alert" style="margin-top: 20px">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Check your email to activate your account.</div>';

    } else {
        $error .= "User does not exists with that combination of email and password.<br />";
    }
} else {
    $error .= "User does not exists with that combination of email and password.<br />";
}

if ($error != "")
    echo '<div class="alert alert-danger alert-dismissible fade in" role="alert" style="margin-top: 20px">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                ' . $error . '</div>';
?>