<?php
/**
 * Created by IntelliJ IDEA.
 * User: mithishri
 * Date: 9/30/2016
 * Time: 9:52 PM
 */

if(isset($_GET['id'])&&isset($_GET['key'])){

    include ('conn.php');
    $email = mysqli_real_escape_string($link,$_GET['id']);
    $key = mysqli_real_escape_string($link,$_GET['key']);
    $query = "UPDATE users
              SET activated = 1
              WHERE email = '$email' AND password = '$key'";

    if($result = mysqli_query($link, $query)) {
        echo 'Your account is activated.';
        include ('sendmail.php');
        $subject = "Activation Successful";
        $body = "
            <p>Congrats, your account has been activated. <br>
            Now you can login and can access fully featured Restro Website. <br>
            Have a great day.
            Cheers!<br>
            Restro Team
            </p>
        ";
        send_mail($email, $subject, $body);

    }

}
else
    echo 'Activation failed. Contact support team.';