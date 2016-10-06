<?php
/**
 * Created by IntelliJ IDEA.
 * User: mithishri
 * Date: 10/1/2016
 * Time: 7:48 PM
 */

session_start();

if (isset($_SESSION['id'])) {

    include('conn.php');

    $order = json_decode($_POST['order'], true);

    $items = $order['items'];
    $uid = $_SESSION['id'];
    $resid = $_SESSION['res_id'];
    $now = date("Y-m-d H:i:s");

    $query = "INSERT INTO orders (res_id, u_id, address, bill, phone, o_time, request, u_name) 
              VALUES ('$resid', '$uid', '" . $order['address'] . "',
               '" . $order['bill'] . "', '" . $order['phone'] . "', '" . $now
        . "', '" . mysqli_real_escape_string($link, $order['request']) . "','" . $order['name'] . "')";
    if (mysqli_query($link, $query)) {

        $id = mysqli_insert_id($link);

        $query = "INSERT INTO order_items(o_id, item, quantity, rate) 
                  VALUES ";

        foreach ($order['items'] as $i => $item) {

            //print_r($item);
            if ($i == 0)
                $query .= "('$id', '" . $item['item']['name'] . "', " . $item['quantity'] . "," . $item['item']['rate'] . ")";
            else
                $query .= " , ('$id', '" . $item['item']['name'] . "', " . $item['quantity'] . "," . $item['item']['rate'] . ")";

        }

        if (mysqli_query($link, $query)) {
            echo 'Successfully placed order.';
        } else
            echo 'Unsuccessfull in placing order.';


    } else {
        echo 'Unsuccessfull in placing order.';
    }


}

?>