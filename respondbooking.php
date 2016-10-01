<?php
/**
 * Created by IntelliJ IDEA.
 * User: mithishri
 * Date: 9/30/2016
 * Time: 11:57 AM
 */
session_start();

if (isset($_SESSION['id'])
    && isset($_SESSION['type'])
    && $_SESSION['type'] == 'admin'
    && isset($_GET['b_id'])
    && isset($_GET['accepted'])
) {

    include('conn.php');

    $query = "UPDATE bookings
            SET accepted = " . $_GET['accepted'] . "
            WHERE b_id = " . $_GET['b_id'];

    if ($result = mysqli_query($link, $query)) {

        $query = "SELECT bookings.`guest-name`, bookings.`guest-email`, bookings.b_date, bookings.guests,restaurants.details 
                  FROM bookings JOIN restaurants 
                  ON bookings.res_id = restaurants.id 
                  WHERE bookings.b_id = " . $_GET['b_id'];

        if ($result = mysqli_query($link, $query)) {

            if ($row = mysqli_fetch_assoc($result)) {

                $details = json_decode($row['details'], true);

                if ($_GET['accepted'] == 1) { //accepted

                    echo 'accepted';
                    $subject = 'Table Booked | ' . $details['name'];
                    $body = "
                    <p>
                    Hi, " . $row['guest-name'] . " <br>
                    Your table for <b>" . $row['guests'] . "</b> is booked at <b>" . date("D, d F", strtotime($row['b_date'])) . "</b> in <b>" . $details['name'] . "</b> Restaurant.<br>
                    Thank you, for using our services.<br>
                    Have a nice day.<br>
                    Cheers!<br>
                    Restro Team. 
                    </p>               
                    ";

                } else if ($_GET['accepted'] == 2) { //rejected

                    echo 'rejected';
                    $subject = 'Request Rejected';
                    $body = "
                    <p>
                    Hi, " . $row['guest-name'] . " <br>
                    Your request of table for <b>" . $row['guests'] . "</b> on <b>" . date("D, d F", strtotime($row['b_date'])) . "</b> has been rejected by <b>" . $details['name'] . "</b> Restaurant.<br>
                    Sorry, for the inconvenience.<br>
                    Have a nice day.<br>
                    Restro Team. 
                    </p>
                    ";

                }

                include('sendmail.php');

                echo send_mail($row['guest-email'], $subject, $body);


            }

        }

    }

} else echo 'Access Denied';


?>