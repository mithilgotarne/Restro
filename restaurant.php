<?php
session_start();
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
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="stylesheet" href="css/map-icons.min.css">
    <!--Custom CSS-->
    <link rel="stylesheet" href="css/custom.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
</head>
<body>

<?php if (isset($_GET['res_id']) && $_GET['res_id'] != '') {

    include('simple_html_dom.php');
    include('conn.php');

    $id = mysqli_real_escape_string($link, $_GET['res_id']);

    $query = "SELECT * from restaurants WHERE id = '$id' LIMIT 1";

    if ($result = mysqli_query($link, $query)) {

        if ($row = mysqli_fetch_array($result)) {

            $details = json_decode($row['details'], true);

            $url = $details['photos_url'];

            $html = file_get_html($url);

            $array = [];
            foreach ($html->find('img') as $element) {

                $src = $element->getAttribute('data-original');
                $class = $element->getAttribute('class');
                if (strpos($class, 'photo-thumb'))
                    array_push($array, preg_split('/(\?)/', $src)[0]);
            }

            $pictures = [
                "images/res_main_1.jpg",
                "images/res_main_2.jpg",
                "images/res_main_3.jpg",
                "images/res_main_4.jpg",
                "images/res_main_5.jpg",
            ];

            ?>

            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="container">

                    <div class="navbar-header">
                        <a class="navbar-brand" href="/"><i class="glyphicon glyphicon-cutlery"></i> Restro</a>
                    </div>

                </div>
            </nav>

            <div class="container-fluid"
                 style="height: 60vh;
                     background-image: url('<?php echo $pictures[array_rand($pictures)] ?>');
                     background-attachment: fixed;
                     background-position-y: -200px;
                     background-position-x: center;
                     background-repeat: no-repeat;
                     background-size: cover;">

                <div class="row" style="background-color: rgba(0,0,0,0.6); height: 100%">

                    <h1 class="text-center pacifico-font"
                        style="color: white; margin-top: 15vh; font-size: 4em;">
                        <?php echo $details['name'] ?>
                        <br>
                        <small style="color: #dadada"><?php echo $details['locality'] ?></small>
                    </h1>

                </div>

            </div>

            <div class="container text-center">

                <div class="row"><h2 class="pacifico-font">Overview</h2></div>

                <div class="row">

                    <div class="col-md-3">

                        <h3>Phone Numbers</h3>
                        <span class="text-success">
                        <b style="font-size: large">022 61701331<br>022 61701332</b>
                    </span>

                    </div>
                    <div class="col-md-3">

                        <h3>Cuisines</h3>
                        <b style="font-size: larger">
                            <?php foreach (explode(", ", $details['cuisines']) as $i => $cuisine) { ?>
                                <?php if ($i != 0) echo '/' ?> <a
                                    href="search.php?q=<?php echo $cuisine ?>"><?php echo $cuisine ?></a>
                            <?php } ?></b>


                    </div>
                    <div class="col-md-3">

                        <h3>Cost</h3>
                        <p><span style="color: #b3b3b3">AVERAGE</span><br>₹<?php echo $details['avgCost'] ?> for two
                            people
                            (approx.)</p>

                    </div>
                    <div class="col-md-3">

                        <h3>Address</h3>
                        <address><?php echo $details['address'] ?>.</address>

                    </div>

                </div>

                <div class="row" style="min-height: calc(100vh - 50px)">

                    <?php


                    $url = $details['menu_url'];

                    $html = file_get_html($url);

                    $array = [];
                    $element = $html->find('script')[15];

                    $str = $element->innertext;

                    $res = preg_split('/(=)/', $str);

                    $array = json_decode(preg_split('/(\])/', $res[2])[0] . ']', true);

                    //print_r($array);
                    ?>

                    <div class="col-md-6">

                        <h2 class="pacifico-font">Menu</h2>

                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                            <!-- Indicators -->
                            <ol class="carousel-indicators">
                                <?php foreach ($array as $i => $slide) { ?>
                                    <li data-target="#carousel-example-generic" data-slide-to="<?php echo $i ?>"
                                        class="<?php if ($i == 0) echo 'active' ?>"></li>
                                <?php } ?>
                            </ol>

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" role="listbox">
                                <?php foreach ($array as $i => $slide) { ?>
                                    <div class="item <?php if ($i == 0) echo 'active' ?>">
                                        <img class="center-block"
                                             style="height: 80vh; width: auto"
                                             src="<?php echo $slide['url'] ?>"
                                             alt="<?php echo $details['name'] . 's Menu' ?>">
                                    </div>
                                <?php } ?>
                            </div>

                            <!-- Controls -->
                            <a class="left carousel-control" href="#carousel-example-generic" role="button"
                               data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control" href="#carousel-example-generic" role="button"
                               data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>


                    </div>

                    <div class="col-md-6" style="padding-left: 30px; padding-right: 30px">

                        <h2 class="pacifico-font">Book Table</h2>

                        <form class="form-horizontal text-left" id="booking-form">

                            <br>

                            <h4>1. Please select your booking details</h4>

                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="booking-date">SELECT A DATE</label>
                                    <br>
                                    <select required class="form-control" id="booking-date">
                                        <?php for ($i = 0; $i < 7; $i++) { ?>
                                            <option value="<?php echo date("Y-m-d", strtotime("+" . $i . " days")) ?>">
                                                <?php
                                                if ($i == 0)
                                                    echo 'Today, ' . date("D, d F", strtotime("+" . $i . " days"));
                                                else if ($i == 1)
                                                    echo 'Tomorrow, ' . date("D, d F", strtotime("+" . $i . " days"));
                                                else
                                                    echo date("D, d F", strtotime("+" . $i . " days"));

                                                ?>
                                            </option>
                                        <?php } ?>

                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="no-of-guests">GUESTS</label>
                                    <br>
                                    <select required class="form-control" id="no-of-guests">
                                        <?php for ($i = 1; $i <= 20; $i++) { ?>
                                            <option <?php if ($i == 2) echo 'selected' ?>value="<?php echo $i ?>">
                                                <?php echo $i ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-3">

                                    <label for="booking-time">Time</label>
                                    <br>
                                    <select required class="form-control" id="booking-time">
                                        <?php
                                        if (date('H') < 10) {

                                            $i = 10;

                                        } else {
                                            $i = date('H') + 1;
                                        }

                                        for (; $i < 24; $i++) {
                                            echo '<option value="' . $i . ':00:00">' . date("h:00 A", strtotime($i . ":00:00")) . '</option>';
                                            echo '<option value="' . $i . ':30:00">' . date("h:30 A", strtotime($i . ":00:00")) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>


                                <script>

                                    function formatAMPM(date) {
                                        var hours = date.getHours();
                                        var minutes = date.getMinutes();
                                        var ampm = hours >= 12 ? 'PM' : 'AM';
                                        hours = hours % 12;
                                        hours = hours ? hours : 12; // the hour '0' should be '12'
                                        minutes = minutes < 10 ? '0' + minutes : minutes;
                                        var strTime = hours + ':' + minutes + ' ' + ampm;
                                        return strTime;
                                    }

                                    $('#booking-date').change(function () {

                                        $('#booking-time option').remove();

                                        var selectedDate = new Date(Date.parse($('#booking-date').val()));
                                        var date = new Date();

                                        var i = 10;

                                        if (selectedDate.getDate() == date.getDate() && date.getHours() > 10)
                                            i = date.getHours() + 1;

                                        for (; i < 24; i++) {
                                            selectedDate.setHours(i);
                                            selectedDate.setMinutes(0);
                                            selectedDate.setMilliseconds(0);
                                            $('#booking-time').append('<option value="' + i + ':00:00">' + formatAMPM(selectedDate) + '</option>');
                                            selectedDate.setMinutes(30);
                                            $('#booking-time').append('<option value="' + i + ':00:00">' + formatAMPM(selectedDate) + '</option>');
                                        }

                                    });

                                </script>


                            </div>

                            <br>


                            <h4>2. Enter guest details</h4>


                            <div class="form-group">

                                <div class="col-md-6">

                                    <label for="guest-name">FULL NAME</label>
                                    <br>
                                    <input value="<?php if (isset($_SESSION['name'])) echo $_SESSION['name'] ?>"
                                           required type="text" class="form-control" id="guest-name"
                                           placeholder="Enter your full name">


                                </div>

                            </div>

                            <div class="form-group">
                                <div class="col-md-6">

                                    <label for="guest-email">EMAIL</label>
                                    <br>
                                    <input value="<?php if (isset($_SESSION['name'])) echo $_SESSION['email'] ?>"
                                           required type="email" class="form-control" id="guest-email"
                                           placeholder="Enter email your address">


                                </div>
                                <div class="col-md-6">

                                    <label for="guest-phone">PHONE NUMBER</label>
                                    <br>
                                    <input required type="tel" class="form-control" id="guest-phone"
                                           placeholder="Enter your phone number">


                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">

                                    <label for="requests">ADDITIONAL REQUESTS</label>
                                    <br>
                                    <textarea class="form-control" rows="2" id="requests"
                                              placeholder="Let us know if any additional requests"></textarea>


                                </div>
                            </div>

                            <?php if (!isset($_SESSION['id'])) { ?>
                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">&times;</button>
                                    <strong>Please Log In to book your table.</strong>
                                </div>
                            <?php } else echo '<br>';
                            ?>

                            <button type="submit" <?php if (!isset($_SESSION['id'])) echo 'disabled' ?>
                                    class="btn btn-info btn-lg">Send Booking Request
                            </button>
                        </form>

                        <script>

                            $('#booking-form').on('submit', function (e) {
                                e.preventDefault();
                                $.post('')

                            });

                        </script>

                    </div>

                </div>
                <div class="row">


                </div>
            </div>


        <?php }
    }
} else {
    header('Location:search.php');
}
?>
</body>
</html>