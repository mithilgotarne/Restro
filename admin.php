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
        <title>Restaurants - Mumbai Restaurants | Restro</title>

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

        </style>

    </head>
<body>

<?php if (isset($_GET['res_id'])
    && $_GET['res_id'] != ''
    && isset($_SESSION['id'])
    && isset($_SESSION['type'])
    && $_SESSION['type'] == 'admin'
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

                            <div class="btn-group">
                                <button type="button" class="btn btn-success dropdown-toggle"
                                        style="margin-left: 10px; margin-top: 8px"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="glyphicon glyphicon-user"></i> <?php echo explode(' ', $_SESSION["name"])[0] ?>
                                    <span
                                        class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
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

                        <h2 class="pacifico-font"><?php echo $details['name'] ?></h2>

                    </div>

                </div>

                <div class="row" style="margin-top: 20px">

                    <div class="col-md-12 well">

                        <ul class="nav nav-tabs nav-justified" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#tablebookings" aria-controls="tablebookings" role="tab"
                                   data-toggle="tab">Table Bookings</a>
                            </li>
                            <li role="presentation">
                                <a href="#orders" aria-controls="orders" role="tab" data-toggle="tab">Orders</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="tablebookings">

                                <table class="table table-hover" style="padding-top: 20px">
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

                                <script src="js/progress-modal.js"></script>

                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="orders">


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