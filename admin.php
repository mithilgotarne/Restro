<?php
/**
 * Created by IntelliJ IDEA.
 * User: mithishri
 * Date: 9/30/2016
 * Time: 9:19 AM
 */
session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    $message = "You are successfully logged out. Have a nice day!";
    //header('location:');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Admin Panel | Restro</title>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>

    <!--Maps API Script-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC8g6dEvdguylYmEBQCFT3tuaqP5b4t-QU"></script>

    <script src="js/map-icons.js"></script>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
          crossorigin="anonymous">

    <link rel="stylesheet" href="css/map-icons.min.css">
    <link rel="stylesheet" href="css/rating.css">
    <!--Custom CSS-->
    <link rel="stylesheet" href="css/custom.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">


    <style>
        .table-hover > tbody > tr:hover {
            background-color: #dadada;
        }

        .table th, .table tr {
            text-align: center;
        }

        .input-group {
            width: 100%;
        }

        input {
            text-align: center;
        }

        .floating-alert {
            position: absolute;
            bottom: 10px;
            right: 50%;
            z-index: 5000;
        }

    </style>

</head>
<body>

<?php if (isset($_GET['res_id'])
    && $_GET['res_id'] != ''
    && isset($_SESSION['id'])
    && isset($_SESSION['type'])
    && $_SESSION['type'] == "admin" && isset($_SESSION['rest'])
    && $_SESSION['rest'] == $_GET['res_id']
) {
    include('conn.php');
    $id = mysqli_real_escape_string($link, $_GET['res_id']);

    $query = "SELECT * from restaurants WHERE id = '$id' LIMIT 1";

    if ($result = mysqli_query($link, $query)) {

        if ($row = mysqli_fetch_array($result)) {

            $_SESSION['res_id'] = $id;

            $details = json_decode($row['details'], true);


            ?>

            <nav class="navbar navbar-inverse navbar-fixed-top">
                <div class="container">

                    <div class="navbar-header">
                        <a class="navbar-brand pacifico-font" href="/"><i
                                class="glyphicon glyphicon-cutlery"></i> Restro</a>
                    </div>
                    <div class="navbar-right">
                        <?php if (isset($_SESSION['id'])) { ?>

                            <ul class="nav navbar-nav" role="tablist">
                                <li>
                                    <a style="color: rgb(210,210,210);"
                                       href="restaurant.php?res_id=<?php echo $_GET['res_id'] ?>">Restaurant Page</a>
                                </li>
                            </ul>


                            <div class="btn-group">
                                <button type="button" class="btn btn-success dropdown-toggle"
                                        style="margin-left: 10px; margin-top: 8px"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="glyphicon glyphicon-user"></i> <?php echo explode(' ', $_SESSION["name"])[0] ?>
                                    <span
                                        class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <?php if (isset($_SESSION['rest'])) { ?>
                                        <li>
                                            <a href="#"><i class="glyphicon glyphicon-user"></i> My Profile</a>
                                        </li>
                                        <li>
                                            <a href="admin.php?res_id=<?php echo $_SESSION['rest'] ?>">
                                                <i class="glyphicon glyphicon-cutlery"></i> My Restaurant
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <li style=""><a href="?logout"><i class="glyphicon glyphicon-log-out"></i>
                                            Logout</a>
                                    </li>
                                </ul>
                            </div>


                        <?php } else { ?>
                            <button id="login" class="btn btn-success navbar-btn" data-toggle="modal"
                                    data-target="#login-modal">Log In
                                <i class="glyphicon glyphicon-log-in"></i>
                            </button>
                        <?php } ?>
                    </div>
                </div>
            </nav>

            <div class="container" style="padding-top: 20px">


                <div class="row">

                    <div style="height: 140px;
                        background-image: url(<?php echo $details['thumb']; ?>);
                        background-size: cover;"
                         class="img-responsive img-rounded col-md-3"></div>

                    <div class="col-md-offset-1 col-md-6">

                        <h2 class="pacifico-font">
                            <?php echo $details['name'] ?>,
                            <small><?php echo $details['locality'] ?></small>
                            <span class="default-font">  |  Admin Panel</span>
                        </h2>
                        <p class="lead"><?php echo $details['address'] ?></p>

                    </div>

                </div>

                <div class="row" style="margin-top: 20px">

                    <div class="col-md-12 well">

                        <ul class="nav nav-tabs nav-justified" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#tablebookings" aria-controls="tablebookings" role="tab"
                                   style="border-color: #3F51B5; border-right: none"
                                   data-toggle="tab">Table Bookings</a>
                            </li>
                            <li role="presentation">
                                <a href="#orders" aria-controls="orders" role="tab"
                                   style="border-color: #3F51B5; border-right: none"
                                   data-toggle="tab">Orders</a>
                            </li>
                            <li role="presentation">
                                <a href="#menu" aria-controls="menu" role="tab" style="border-color: #3F51B5"
                                   data-toggle="tab">Menu</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="tablebookings">

                                <table class="table table-hover" style="margin-top: 20px">
                                    <thead>
                                    <tr>
                                        <th>NAME</th>
                                        <th>NO. OF GUESTS</th>
                                        <th>EMAIL</th>
                                        <th>BOOKED ON</th>
                                        <th>BOOKING FOR</th>
                                        <th>REQUEST</th>
                                        <th>ACTION</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    $query = "SELECT * FROM bookings 
                                              WHERE res_id = '" . $details['id'] . "' 
                                              AND NOT accepted = 2 ";

                                    if ($result = mysqli_query($link, $query)) {

                                        while ($row = mysqli_fetch_assoc($result)) {


                                            ?>

                                            <tr id="<?php echo $row['b_id'] ?>">
                                                <td><?php echo $row['guest-name'] ?></td>
                                                <td><?php echo $row['guests'] ?></td>
                                                <td><?php echo $row['guest-email'] ?></td>
                                                <td><?php echo $row['when_booked'] ?></td>
                                                <td><?php echo $row['b_date'] ?></td>
                                                <td><?php echo $row['requests'] ?></td>
                                                <td class="accepted">
                                                    <?php
                                                    if ($row['accepted'] == 0) {

                                                        echo '<button 
                                                            onclick="reject(' . $row['b_id'] . ')" 
                                                            class="btn btn-danger">
                                                                <i class="glyphicon glyphicon-remove"></i>
                                                              </button>
                                                              <button 
                                                              onclick="accept(' . $row['b_id'] . ')" 
                                                              class="btn btn-success">
                                                                <i class="glyphicon glyphicon-ok"></i>
                                                               </button>';

                                                    } else if ($row['accepted'] == 1)
                                                        echo '<span class="text-success"><b>Accepted</b></span>';
                                                    ?>
                                                </td>
                                            </tr>

                                        <?php }

                                    } ?>

                                    </tbody>
                                </table>

                                <script>

                                    var reject = function (bid) {

                                        waitingDialog.show('Sending Mail...');

                                        $.get('respondbooking.php',
                                            {
                                                b_id: bid, accepted: 2
                                            }
                                            ,
                                            function (data) {
                                                console.log(data);
                                                location.reload();
                                            }
                                        );

                                    };

                                    var accept = function (bid) {

                                        waitingDialog.show('Sending Mail...');

                                        $.get('respondbooking.php',
                                            {b_id: bid, accepted: 1},
                                            function (data) {
                                                console.log(data);
                                                location.reload();
                                            }
                                        );


                                    };

                                </script>


                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="orders">

                                <table class="table table-hover" style="margin-top: 20px">
                                    <thead>
                                    <tr>
                                        <th>NAME</th>
                                        <th>ADDRESS</th>
                                        <th>PHONE</th>
                                        <th>TIME</th>
                                        <th>ITEMS</th>
                                        <th>REQUEST</th>
                                        <th>BILL</th>
                                        <th>ACTION</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    $query = "SELECT * 
                                    FROM orders 
                                    JOIN order_items 
                                    ON orders.o_id = order_items.o_id
                                    WHERE orders.res_id = '" . $_GET['res_id'] . "'";

                                    $orders = array();

                                    if ($result = mysqli_query($link, $query)) {

                                        while ($row = mysqli_fetch_assoc($result)) {

                                            //print_r($row);
                                            if (!isset($orders[$row['o_id']])) {
                                                $orders[$row['o_id']]['o_id'] = $row['o_id'];
                                                $orders[$row['o_id']]['u_name'] = $row['u_name'];
                                                $orders[$row['o_id']]['address'] = $row['address'];
                                                $orders[$row['o_id']]['bill'] = $row['bill'];
                                                $orders[$row['o_id']]['phone'] = $row['phone'];
                                                $orders[$row['o_id']]['status'] = $row['status'];
                                                $orders[$row['o_id']]['o_time'] = $row['o_time'];
                                                $orders[$row['o_id']]['request'] = $row['request'];
                                                $orders[$row['o_id']]['items'] = array();
                                            }
                                            array_push($orders[$row['o_id']]['items'], $row);

                                        }

                                        //print_r($orders);

                                    }

                                    foreach ($orders as $order) {

                                        ?>

                                        <tr>
                                            <td><?php echo $order['u_name']; ?></td>
                                            <td><?php echo $order['address']; ?></td>
                                            <td><?php echo $order['phone']; ?></td>
                                            <td><?php echo $order['o_time']; ?></td>
                                            <td><?php
                                                foreach ($order['items'] as $item) {
                                                    echo $item['item']
                                                        . '(' . $item['rate'] . ')'
                                                        . ' x ' . $item['quantity'] . '<br>';
                                                }
                                                ?></td>
                                            <td><?php echo $order['request']; ?></td>
                                            <td><?php echo '₹' . $order['bill']; ?></td>
                                            <td><?php if ($order['status'] == 'Ordered') {

                                                    echo '<button
                                                    onclick="rejectOrder(' . $order['o_id'] . ')"
                                                    class="btn btn-danger">
                                                    <i class="glyphicon glyphicon-remove"></i>
                                                </button>
                                                <button
                                                    onclick="acceptOrder(' . $order['o_id'] . ')"
                                                    class="btn btn-success">
                                                    <i class="glyphicon glyphicon-ok"></i>
                                                </button>';

                                                } else if ($order['status'] == "Accepted")
                                                    echo '<span class="text-success"><b>Accepted</b></span>';
                                                else{
                                                    echo '<span class="text-danger"><b>Rejected</b></span>';
                                                }?>
                                            </td>
                                        </tr>


                                    <?php } ?>
                                    </tbody>
                                </table>
                                <script>

                                    var acceptOrder = function (oid) {

                                        waitingDialog.show('Sending Mail...');

                                        $.get('respondorder.php',
                                            {
                                                o_id: oid, accepted: 'Accepted'
                                            }
                                            ,
                                            function (data) {
                                                console.log(data);
                                                location.reload();
                                            }
                                        );

                                    };

                                    var rejectOrder = function (oid) {

                                        waitingDialog.show('Sending Mail...');

                                        $.get('respondorder.php',
                                            {
                                                o_id: oid, accepted: 'Rejected'
                                            }
                                            ,
                                            function (data) {
                                                console.log(data);
                                                location.reload();
                                            }
                                        );


                                    };

                                </script>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="menu">

                                <table class="table table-hover" style="margin-top: 20px">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>NAME</th>
                                        <th>CATEGORY</th>
                                        <th>RATE</th>
                                        <th>ACTION</th>
                                    </tr>
                                    </thead>
                                    <tbody id="menu-items">

                                    <?php

                                    $query = "SELECT * FROM menu_items
                                              WHERE res_id = '" . $_GET['res_id'] . "'";

                                    if ($result = mysqli_query($link, $query)) {

                                        while ($row = mysqli_fetch_assoc($result)) {

                                            $id = $row['id'];
                                            ?>

                                            <tr id="<?php echo $id ?>">
                                                <td><?php echo $id ?></td>
                                                <td>
                                                    <div class="input-group">
                                                        <input class="form-control"
                                                               id="<?php echo $id ?>item-name" readonly
                                                               type="text" value="<?php echo $row['name'] ?>">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <input class="form-control"
                                                               id="<?php echo $id ?>item-category" readonly
                                                               type="text"
                                                               value="<?php echo $row['category'] ?>"></div>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <input class="form-control "
                                                               id="<?php echo $id ?>item-rate" readonly step="0.01"
                                                               type="number" value="<?php echo $row['rate'] ?>">
                                                    </div>
                                                </td>
                                                <td>


                                                    <button style="display: none;" class="btn btn-success"
                                                            id="<?php echo $id ?>btn-save"
                                                            data-toggle="tooltip"
                                                            onclick="save(<?php echo $id ?>, 'update')"
                                                            data-placement="top" title="Save">
                                                        <i class="glyphicon glyphicon-ok"></i>
                                                    </button>

                                                    <button style="display: none;" class="btn btn-primary"
                                                            id="<?php echo $id ?>btn-cancel"
                                                            data-toggle="tooltip"
                                                            onclick="cancel(<?php echo $id ?>)"
                                                            data-placement="top" title="Cancel">
                                                        <i class="glyphicon glyphicon-remove"></i>
                                                    </button>

                                                    <button class="btn btn-info"
                                                            id="<?php echo $id ?>btn-edit"
                                                            data-toggle="tooltip"
                                                            onclick="edit(<?php echo $id ?>)"
                                                            data-placement="top" title="Edit">
                                                        <i class="glyphicon glyphicon-pencil"></i>
                                                    </button>

                                                    <button class="btn btn-danger"
                                                            id="<?php echo $id ?>btn-delete"
                                                            data-toggle="tooltip"
                                                            onclick="remove(<?php echo $id ?>)"
                                                            data-placement="top" title="Delete">
                                                        <i class="glyphicon glyphicon-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                        <?php } //end while

                                    } //end if

                                    ?>

                                    </tbody>
                                </table>

                                <button id="add-item" class="btn btn-warning pull-right">
                                    <i class="glyphicon glyphicon-plus"></i> Add Item
                                </button>


                                <script>

                                    $(function () {
                                        $('[data-toggle="tooltip"]').tooltip({
                                            trigger: 'hover'
                                        })
                                    });

                                    $('#add-item').click(function () {

                                        $('#add-item').hide();

                                        $('tbody#menu-items').append(`

                                            <tr>
                                                <td></td>
                                                <td>
                                                    <div class="input-group">
                                                        <input class="form-control"
                                                               id="item-name"
                                                               type="text">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <input class="form-control"
                                                               id="item-category"
                                                               type="text">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <input class="form-control "
                                                               id="item-rate" step="0.01"
                                                               type="number">
                                                    </div>
                                                </td>
                                                <td>
                                                    <button class="btn btn-success"
                                                            id="btn-save"
                                                            data-toggle="tooltip"
                                                            onclick="save('', 'insert')"
                                                            data-placement="top" title="Save">
                                                        <i class="glyphicon glyphicon-ok"></i>
                                                    </button>

                                                    <button class="btn btn-primary"
                                                            id="btn-cancel"
                                                            data-toggle="tooltip"
                                                            onclick="cancel('')"
                                                            data-placement="top" title="Cancel">
                                                        <i class="glyphicon glyphicon-remove"></i>
                                                    </button>

                                                    <button style="display: none;"
                                                            class="btn btn-info" id="btn-edit"
                                                            data-toggle="tooltip"
                                                            onclick="edit('')"
                                                            data-placement="top" title="Edit">
                                                        <i class="glyphicon glyphicon-pencil"></i>
                                                    </button>

                                                    <button style="display: none;"
                                                            class="btn btn-danger" id="btn-delete"
                                                            data-toggle="tooltip"
                                                            onclick="remove('')"
                                                            data-placement="top" title="Delete">
                                                        <i class="glyphicon glyphicon-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                        `);

                                        $('[data-toggle="tooltip"]').tooltip({
                                            trigger: 'hover'
                                        });


                                    });

                                    var edit = function (id) {

                                        $('#' + id + 'item-rate').removeAttr('readonly');
                                        $('#' + id + 'item-name').removeAttr('readonly');
                                        $('#' + id + 'item-category').removeAttr('readonly');
                                        $('#' + id + 'btn-edit').hide();
                                        $('#' + id + 'btn-delete').hide();
                                        $('#' + id + 'btn-save').show();
                                        $('#' + id + 'btn-cancel').show();

                                    };

                                    var remove = function (id) {

                                        $.post('editmenu.php', {
                                            item_id: id,
                                            type: 'delete'
                                        }, function (data) {

                                            data = JSON.parse(data);
                                            console.log(data);

                                            $(data.message).appendTo('body');
                                            $('tr#' + id).remove();
                                            setTimeout(function () {
                                                $('.floating-alert').remove();
                                            }, 2000);

                                        });

                                    };

                                    var cancel = function (id) {

                                        var name = $('#' + id + 'item-name');
                                        var cat = $('#' + id + 'item-category');
                                        var rate = $('#' + id + 'item-rate');

                                        if (id == '') { // new item cancel

                                            $('tbody#menu-items tr').last().remove();
                                            $('#add-item').show();

                                        } else {
                                            name.val(function () {
                                                return this.defaultValue;
                                            });
                                            cat.val(function () {
                                                return this.defaultValue;
                                            });
                                            rate.val(function () {
                                                return this.defaultValue;
                                            });

                                            rate.attr('readonly', true);
                                            name.attr('readonly', true);
                                            cat.attr('readonly', true);
                                            $('#' + id + 'btn-edit').show();
                                            $('#' + id + 'btn-delete').show();
                                            $('#' + id + 'btn-save').hide();
                                            $('#' + id + 'btn-cancel').hide();
                                        }


                                    };

                                    var save = (function (id, type) {

                                        var name = $('#' + id + 'item-name');
                                        var cat = $('#' + id + 'item-category');
                                        var rate = $('#' + id + 'item-rate');

                                        if (name.val().length > 0 && cat.val().length > 0 && rate.val() > 0)


                                            $.post('editmenu.php', {
                                                    res_id: <?php echo $_GET['res_id']?>,
                                                    item_id: id,
                                                    name: name.val(),
                                                    category: cat.val(),
                                                    rate: rate.val(),
                                                    type: type
                                                },
                                                function (data) {

                                                    data = JSON.parse(data);
                                                    console.log(data);

                                                    $(data.message).appendTo('body');
                                                    rate.attr('readonly', true);
                                                    name.attr('readonly', true);
                                                    cat.attr('readonly', true);
                                                    $('#' + id + 'btn-edit').show();
                                                    $('#' + id + 'btn-delete').show();
                                                    $('#' + id + 'btn-save').hide();
                                                    $('#' + id + 'btn-cancel').hide();
                                                    if (id == '') {
                                                        $('#menu-items' + ' tr').last().attr('id', data.id);
                                                        $('#' + data.id).find('td').first().text(data.id);
                                                        name.attr('id', data.id + 'item-name');
                                                        cat.attr('id', data.id + 'item-category');
                                                        rate.attr('id', data.id + 'item-rate');
                                                        $('#' + id + 'btn-edit')
                                                            .attr('id', data.id + 'btn-edit')
                                                            .attr('onclick', 'edit(' + data.id + ')');
                                                        $('#' + id + 'btn-delete')
                                                            .attr('id', data.id + 'btn-delete')
                                                            .attr('onclick', 'remove(' + data.id + ')');
                                                        $('#' + id + 'btn-save')
                                                            .attr('id', data.id + 'btn-save')
                                                            .attr('onclick', 'save(' + data.id + ', \'update\')');
                                                        $('#' + id + 'btn-cancel')
                                                            .attr('id', data.id + 'btn-cancel')
                                                            .attr('onclick', 'cancel(' + data.id + ')');
                                                    }

                                                    setTimeout(function () {
                                                        $('.floating-alert').remove();
                                                    }, 2000);

                                                    $('#add-item').show();

                                                }
                                            );
                                        else {
                                            $(`<div class="floating-alert alert alert-danger">
        	                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        	                                        Invalid Input.
                                               </div>`).appendTo('body');
                                            setTimeout(function () {
                                                $('.floating-alert').remove();
                                            }, 2000);
                                        }


                                    });


                                </script>


                            </div>

                        </div>

                    </div>

                </div>


            </div>


        <?php }
    }
} else
    header('Location:index.php');
?>


<script src="js/progress-modal.js"></script>

