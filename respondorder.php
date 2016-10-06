<?php
/**
 * Created by IntelliJ IDEA.
 * User: mithishri
 * Date: 10/6/2016
 * Time: 12:31 PM
 */
session_start();

if (isset($_SESSION['id'])
    && isset($_SESSION['type'])
    && $_SESSION['type'] == 'admin'
    && isset($_GET['o_id'])
    && isset($_GET['accepted'])
) {

    include('conn.php');

    $query = "UPDATE orders
            SET status = '" . $_GET['accepted'] . "'
            WHERE o_id = " . $_GET['o_id'];

    if (mysqli_query($link, $query)) {

        $id = $_GET['o_id'];

        $query = "SELECT * FROM orders 
                  JOIN restaurants
                  ON orders.res_id = restaurants.id
                  JOIN users 
                  ON orders.u_id = users.id
                  WHERE o_id = $id";

        if ($results = mysqli_query($link, $query)) {

            if ($row = mysqli_fetch_assoc($results)) {

                print_r($row);

                $details = json_decode($row['details'], true);

                if ($_GET['accepted'] == "Accepted") { //accepted

                    echo 'accepted';
                    $subject = 'Order Accepted | ' . $details['name'];
                    $body = "
                    <p>
                    Hi, " . $row['name'] . " <br>
                    Your order has been accepted. <br> 
                    You order will reach in <b>45 min</b> 
                    Keep change of <b>Rs." . $row['bill'] . "</b>
                    Thank you, for using our services.<br>
                    Have a nice day.<br>
                    Cheers!<br>
                    Restro Team.
                    </p>
                    ";

                } else if ($_GET['accepted'] == "Rejected") { //rejected

                    echo 'rejected';
                    $subject = 'Order Rejected | ' . $details['name'];
                    $body = "
                    <p>
                    Hi, " . $row['name'] . " <br>
                    Your order is rejected. <br>
                    Sorry, for the inconvenience.<br>
                    Have a nice day.<br>
                    Restro Team.
                    </p>
                    ";

                }

                include('sendmail.php');

                echo send_mail($row['email'], $subject, $body);

            }
        }

    }


}
?>