<?php
require 'PHPMailer/PHPMailerAutoload.php';

function send_mail($sendto, $subject, $body)
{

    $mail = new PHPMailer;

//$mail->SMTPDebug = 2;                               // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'restrowebsite@gmail.com';                 // SMTP username
    $mail->Password = '7208152371';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->setFrom('restrowebsite@gmail.com', 'Restro | Restaurants in Mumbai');
    $mail->addAddress($sendto);               // Name is optional
    $mail->addReplyTo('restrowebsite@gmail.com', 'Restro | Restaurants in Mumbai');

    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AltBody = 'Please open this on Chrome';

    if (!$mail->send()) {
        //echo 'Message could not be sent.';
        return 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        return 'Message has been sent';
    }
}