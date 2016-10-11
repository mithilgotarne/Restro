<?php

include('conn.php');

session_start();

$error = "";

$email = mysqli_real_escape_string($link, $_POST['email']);
$password = md5(md5($_POST['email']) . $_POST['password']);
$name = mysqli_real_escape_string($link, $_POST['name']);
$dob = $_POST['dob'];

$query = "SELECT * FROM users WHERE email = '$email'";

$results = 0;

if ($result = mysqli_query($link, $query)) {
    $results = mysqli_num_rows($result);
}

if ($results)
    echo '<div class="alert alert-info" style="margin-top: 20px">
    	        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    	    User already exists.
            </div>';
else {

    $query = "INSERT INTO users (email, password, name, dob) 
				VALUES ('$email', '$password', '$name', '$dob')";

    if (mysqli_query($link, $query)) {

        include('sendmail.php');

        $body = "
            
            <h3>Welcome to Restro!</h3>
            <p>
                Hi, " . $name . "<br><br>
                Welcome to Restro! Thanks so much for joining us. We're so happy you're here.<br>
                Restro helps you to find your favourite food and deliver it to you.<br> 
                We have about 1000 of the best restaurants in Mumbai for you to choose from.<br><br>
                Please confirm your email and activate your account.<br><br>
                <a href='http://localhost:8000/activate.php?id=" . $email . "&key=" . $password . "'>Click Here to Activate</a><br><br>
                Cheers!<br>
                Restro Team. 
            </p>
        ";

        send_mail($email, 'Welcome to Restro', $body);

        echo '<div class="alert alert-info alert-dismissible fade in" role="alert" style="margin-top: 20px">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Check your email to activate your account.</div>';

    } else {
        echo '<div class="alert alert-danger alert-dismissible fade in" role="alert" style="margin-top: 20px">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Enable to create your account.</div>';
    }

}

?>