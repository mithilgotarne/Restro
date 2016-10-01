<?php
/**
 * Created by IntelliJ IDEA.
 * User: mithishri
 * Date: 10/2/2016
 * Time: 12:27 AM
 */
session_start();

if (isset($_SESSION['id'])
    && isset($_SESSION['type'])
    && $_SESSION['type'] == 'admin'
    && isset($_POST['item_id'])
) {

    include('conn.php');


    if ($_POST['type'] == 'update') {

        $query = "UPDATE menu_items
                  SET name = '" . $_POST['name'] . "', 
                  category = '" . $_POST['category'] . "',
                  rate = " . $_POST['rate'] . " 
                  WHERE id = " . $_POST['item_id'];
    } else if ($_POST['type'] == 'insert') {

        $query = "INSERT INTO menu_items (res_id, name, category, rate) 
                  VALUES ('" . $_POST['res_id'] . "', '" . $_POST['name'] . "', '" . $_POST['category'] . "', " . $_POST['rate'] . ");";

    } else if ($_POST['type'] == 'delete') {

        $query = "DELETE FROM menu_items
                  WHERE id = " . $_POST['item_id'];

    }

    if (mysqli_query($link, $query)) {

        $response['message'] = '<div class="floating-alert alert alert-success">
           	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
           	Menu Updated.
           </div>';


    } else $response['message'] = '<div class="floating-alert alert alert-danger">
        	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        	<strong>Oh Snap!</strong> Unable to update.
        </div>';

    $response['id'] = mysqli_insert_id($link);

    print_r(json_encode($response));
}