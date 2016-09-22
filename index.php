<?php

session_start();
$message = "";

if (isset($_GET['logout'])) {
    session_destroy();
    $message = "You are successfully logged out. Have a nice day!";
    session_start();
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
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
    <style>
        body {
            padding: 0;
            background: url('images/landing-bg.jpg') no-repeat;
            background-size: cover;
            color: white;
        }

        h1 a, h1 a:link, h1 a:hover, h1 a:visited {
            color: white;
            text-decoration: none;
        }

        .navbar {
            margin: 0;
            background: rgba(0, 0, 0, 0.5);
            border: none;
            border-radius: 0;
            padding-top: 10px;
        }

        .container-fluid {
            min-height: calc(100vh - 60px);
        }

        .modal {
            color: black;
            text-align: center;
        }

        h1, h2, h3 {
            font-family: 'Pacifico', cursive;
        }

        #heading {

            font-family: 'Pacifico', cursive;
            color: white;
            font-size: 7em;
            margin-top: 10vh;
            margin-bottom: 50px;
            display: none;

        }

        #search-input-group, #search-btn-group {

            display: none;

        }

        #quick-search h3 {
            margin-bottom: 0;
        }

        #quick-search h4 {
            font-weight: 600;
        }

        #quick-search .col-md-2 {
            display: none;
            background: rgba(255, 255, 255, 0.4);
            color: white;
            border-radius: 8px;
            cursor: pointer;
            padding: 0;
            width: 15.3%;
            margin: 15px 15px 15px 0;
        }

        #quick-search .col-md-2:nth-child(2) {
            margin-left: 9px;
        }

        #quick-search .col-md-2:nth-child(7) {
            margin-right: 9px;
        }

        #quick-search .col-md-2:hover {
            background: white;
            color: black;
            text-decoration: none;
        }

    </style>

</head>
<body>

<nav class="navbar navbar-default" style="min-height: 60px;">
    <div class="container">
        <div class="navbar-right">
            <?php
            if (isset($_SESSION['id'])) {

                echo '<h4><span style="font-family:\'Pacifico\', cursive;">Welcome</span>, ' . explode(' ', $_SESSION["name"])[0] . '!</h4>';

            } else {
                echo '<button id="login" class="btn btn-success navbar-btn" data-toggle="modal" data-target="#login-modal">Log In
                            <i class="glyphicon glyphicon-log-in"></i>
                      </button>';
            }


            ?>
        </div>
    </div>
</nav>

<div class="container-fluid text-center" style="background: rgba(0,0,0,0.5)">

    <h1 id="heading"><a href=""><i class="glyphicon glyphicon-cutlery"></i> Restro</a></h1>

    <form class="form-horizontal" action="search.php">

        <div class="form-group form-group-lg" id="search-input-group">
            <div class="col-md-offset-3 col-md-6">
                <input required type="text" class="form-control" style="width: 100%"
                       placeholder="Search for restaurant, cuisine or a dish..."
                       aria-describedby="search-icon" id="search-input" name="q"></div>
        </div>

        <div class="form-group form-group-lg" id="search-btn-group">

            <button type="submit" class="btn btn-lg btn-primary">
                <i class="glyphicon glyphicon-search" id="search-btn"></i> Search
            </button>

            <a class="btn btn-lg btn-danger" href="search.php">
                <i class="glyphicon glyphicon-send" id="nearby-btn"></i> Nearby Restaurants
            </a>

        </div>

    </form>

    <div class="row">

        <div class="container" id="quick-search">

            <h3>Quick Searches</h3>

            <a class="col-md-2" href="search.php?q=pocket friendly">

                <img src="icons/del.png" alt="Delivery">
                <h4>Delivery</h4>

            </a>


            <a class="col-md-2" href="search.php?q=breakfast">

                <img src="icons/bf.png" alt="Breakfast">
                <h4>Breakfast</h4>

            </a>

            <a class="col-md-2" href="search.php?q=lunch">

                <img src=" icons/l.png" alt="Lunch">
                <h4>Lunch</h4>

            </a>

            <a class="col-md-2" href="search.php?q=dinner">

                <img src="icons/d.png" alt="Dinner">
                <h4>Dinner</h4>

            </a>

            <a class="col-md-2" href="search.php?q=cafes">

                <img src="icons/cf.png" alt="Cafés">
                <h4>Cafés</h4>

            </a>

            <a class="col-md-2" href="search.php?q=nightlife">

                <img src="icons/n.png" alt="Nightlife">
                <h4>Nightlife</h4>

            </a>

        </div>

    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h2><i class="glyphicon glyphicon-cutlery"></i> Restro</h2>
            </div>
            <div class="modal-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-justified" role="tablist">
                    <li role="presentation" class="active"><a href="#login-tab" aria-controls="login-tab" role="tab"
                                                              data-toggle="tab">Log In</a></li>
                    <li role="presentation"><a href="#signup-tab" aria-controls="signup-tab" role="tab"
                                               data-toggle="tab">Sign Up</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="login-tab">

                        <form id="login-form" name="login-form" style="padding-top: 20px">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <input required name="email" type="email" class="form-control" placeholder="Email">

                            </div>

                            <br>

                            <div class="input-group">

                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input required name="password" type="password" class="form-control"
                                       placeholder="Password">

                            </div>
                            <br>
                            <div class="clearfix">

                                <div class="checkbox pull-left">
                                    <label>
                                        <input type="checkbox"> Remember me
                                    </label>
                                </div>

                                <button type="submit" class="btn btn-success pull-right">Log In</button>

                            </div>

                        </form>

                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="signup-tab">

                        <form id="signup-form" name="signup-form" style="padding-top: 20px">

                            <div id="form-group-name" class="input-group">

                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input required id="s-name" name="name" type="text" class="form-control"
                                       placeholder="Full Name">


                            </div>
                            <br>
                            <div class="input-group">

                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <input required id="s-email" name="email" type="email" class="form-control"
                                       placeholder="Email">

                            </div>
                            <br>
                            <div class="input-group">

                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input required id="s-password" name="password" type="password" class="form-control"
                                       placeholder="Password">

                            </div>
                            <br>
                            <div class="input-group" id="form-group-r-password">

                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input required id="r-password" name="r-password" type="password" class="form-control"
                                       placeholder="Re-Enter Password">

                            </div>
                            <br>
                            <button name="submit" type="submit" class="btn btn-success"
                                    value="Sign Up!">Sign Up!
                            </button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function () {
        $('#heading').fadeIn(2000);
        $('#search-input-group').show("slide", {direction: "left"}, 500);
        $('#search-btn-group').show("slide", {direction: "right"}, 500);
        $('#quick-search .col-md-2').each(function (index) {
            $(this).fadeIn(500 * (index + 1));
        });
    });

    $('#r-password').change(function () {

        $('#form-group-r-password span').remove();


        if ($(this).val() == $('#s-password').val())
            $('#form-group-r-password')
                .removeClass('has-error')
                .addClass('has-success');
        else
            $('#form-group-r-password')
                .removeClass('has-success')
                .append('<span class="help-block text-left">Passwords are not matching.</span>')
                .addClass('has-error');

    });

    $('#login-form').on('submit', function (event) {

        event.preventDefault();
        $.post('login.php', $('#login-form').serialize(), function (data) {

            $('#login-tab .alert').remove();

            if (data == '') {

                location.href = '';

            }

            else {

                var string = `<div class="alert alert-danger alert-dismissible fade in" role="alert" style="margin-top: 20px">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Oh Snap!</strong> ` + data + `</div>`;

                $('#login-tab').append(string);

            }
        });

    });

    $('#signup-form').on('submit', function (event) {

        event.preventDefault();
        $.post('signup.php', $('#signup-form').serialize(), function (data) {

            $('#signup-tab .alert').remove();

            var string = `<div class="alert alert-danger alert-dismissible fade in" role="alert" style="margin-top: 20px">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Oh Snap!</strong> ` + data + `</div>`;

            $('#signup-tab').append(string);
        });

    });


</script>

</body>
</html>