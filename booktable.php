<?php
/**
 * Created by IntelliJ IDEA.
 * User: mithishri
 * Date: 9/27/2016
 * Time: 10:56 PM
 */
include('conn.php');
session_start();
if (isset($_SESSION['res_id'])) {

    $b_date = $_POST['booking-date'] . ' ' . $_POST['booking-time'];
    $when_booked = date("Y-m-d H:i:s");
    $res_id = $_SESSION['res_id'];
    $uid = $_SESSION['id'];
    $guestname = mysqli_real_escape_string($link, $_POST['guest-name']);
    $guestemail = mysqli_real_escape_string($link, $_POST['guest-email']);
    $guests = $_POST['no-of-guests'];
    $guestphone = mysqli_real_escape_string($link, $_POST['guest-phone']);
    $requests = mysqli_real_escape_string($link, $_POST['requests']);

    $query = "INSERT INTO 
bookings 
(res_id, u_id, `guest-name`, `guest-email`, guests, when_booked, b_date, `guest-phone`, `requests`)
VALUES 
('$res_id', $uid, '$guestname', '$guestemail', $guests, '$when_booked', '$b_date', '$guestphone', '$requests')";

    if ($results = mysqli_query($link, $query)) {

        echo 'Your Booking has been requested.';


    }


} else echo 'Sorry, error in submitting the form.';