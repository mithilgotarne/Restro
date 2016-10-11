<?php

session_start();
$message = "";

if (isset($_GET['logout'])) {
    session_destroy();
    $message = "You are successfully logged out. Have a nice day!";
    header('location:/');
}
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
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
        <?php
        if(isset($_SESSION['dob']))
            if (date("m-d", strtotime($_SESSION['dob'])) == date("m-d"))
                echo "
                   body {
                        padding: 0;
                        background: url('images/birthday.jpg') no-repeat;
                        background-size: cover;
                        color: white;
                    }
                    .main-container, .navbar{
                        background: rgba(0,0,0,0.2)
                    }
                    
                    #happy-birthday-audio{
                        display: none;
                    }
                ";
            else

                echo "
                
                     body {
                        padding: 0;
                        background: url('images/landing-bg.jpg') no-repeat;
                        background-size: cover;
                        color: white;
                    }
                    
                    .main-container, .navbar{
                        background: rgba(0,0,0,0.5)
                    }
                
                ";
        else

                echo "
                
                     body {
                        padding: 0;
                        background: url('images/landing-bg.jpg') no-repeat;
                        background-size: cover;
                        color: white;
                    }
                    
                    .main-container, .navbar{
                        background: rgba(0,0,0,0.5)
                    }
                
                ";


        ?>

        h1 a, h1 a:link, h1 a:hover, h1 a:visited {
            color: white;
            text-decoration: none;
        }

        .navbar {
            margin: 0;
            border: none;
            border-radius: 0;
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
            display: none;

        }

        #search-btn-group {

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
            margin: 15px 15px 0 0;
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
            <?php if (isset($_SESSION['id'])) { ?>
            <h4>
                <span style="font-family:\'Pacifico\', cursive;">Welcome, </span>
                <div class="btn-group">
                    <button type="button" class="btn btn-success dropdown-toggle"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="glyphicon glyphicon-user"></i> <?php echo explode(' ', $_SESSION["name"])[0] ?> <span
                            class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <!--<li style=""><a href="#"><i class="glyphicon glyphicon-user"></i> My Profile</a></li>-->
                        <?php if (isset($_SESSION['rest'])) { ?>
                            <li>
                                <a href="admin.php?res_id=<?php echo $_SESSION['rest'] ?>">
                                    <i class="glyphicon glyphicon-cutlery"></i> My Restaurant
                                </a>
                            </li>
                        <?php } ?>
                        <li role="separator" class="divider"></li>
                        <li style=""><a href="?logout"><i class="glyphicon glyphicon-log-out"></i> Logout</a></li>
                    </ul>
                </div>
                <h4>


                    <?php } else { ?>
                        <button id="login" class="btn btn-success navbar-btn" data-toggle="modal"
                                data-target="#login-modal">Log In
                            <i class="glyphicon glyphicon-log-in"></i>
                        </button>
                    <?php } ?>
        </div>
    </div>
</nav>

<div class="container-fluid text-center main-container">

    <h1 id="heading"><a href=""><i class="glyphicon glyphicon-cutlery"></i> Restro</a></h1>

    <form class="form-horizontal row" action="search.php">

        <div class="col-md-offset-3 col-md-6">

            <div class="input-group input-group-lg" id="search-input-group">

                <input required type="text" class="form-control"
                       placeholder="Search for restaurant, cuisine or a dish..."
                       aria-describedby="search-icon" id="search-input" name="q">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-lg btn-primary">
                        <i class="glyphicon glyphicon-search" id="search-btn"></i> Search
                    </button>
                </span>
            </div>
        </div>

    </form>

    <br>

    <div class="row" id="search-btn-group">


        <a class="btn btn-lg btn-danger" href="search.php">
            <i class="glyphicon glyphicon-send" id="nearby-btn"></i> Nearby Restaurants
        </a>


    </div>

    <div class="row">

        <div class="container" id="quick-search">

            <h2>Quick Searches</h2>

            <a class="col-md-2" href="search.php?q=delivery">

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
<?php

if (isset($_SESSION['dob'])) {

    if (date("m-d", strtotime($_SESSION['dob'])) == date("m-d")) {

        echo '
            <div class="modal fade" id="happy-birthday">
            	<div class="modal-dialog modal-sm">
            		<div class="modal-content">
            			<div class="modal-header">
            				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            				<h4 class="modal-title">Happy Birthday, ' . $_SESSION['name'] . '!</h4>
            			</div>
            			<div class="modal-body">
            				<img src="icons/db.png" class="img-responsive center-block" alt="Happy Birthday">
            				Treat from our side.<br>
            				Get <b>10% Discount</b> on your bill.
            				<audio id="happy-birthday-audio">
            				    <source src="birthday.mp3" type="audio/mp3">
            				</audio>
            			</div>
            		</div><!-- /.modal-content -->
            	</div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <script>
            
                var audio = document.getElementById("happy-birthday-audio");
                
                //audio.currentTime = 30;
                              
                $("#happy-birthday").on("shown.bs.modal", function (e) {
                        audio.play();
                     
                });
                
                $("#happy-birthday").on("hidden.bs.modal", function (e) {
                     audio.pause(); 
                     //audio.currentTime = 30;
                });
                
                $("#happy-birthday").modal("show");
            
            </script>
                        
            ';

    }

}


?>


<?php

if (!isset($_SESSION['id'])) { ?>
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

                                    <button type="submit" class="btn btn-success pull-right form-control">Log In
                                    </button>

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

                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                    <input required id="dob" name="dob" type="date" class="form-control"
                                           placeholder="Date of Birth">

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
                                    <input required id="r-password" name="r-password" type="password"
                                           class="form-control"
                                           placeholder="Re-Enter Password">

                                </div>
                                <br>
                                <button name="submit" type="submit" class="btn btn-success form-control" id="signup-btn"
                                        value="Sign Up!">Sign Up!
                                </button>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<script>

    $(document).ready(function () {
        $('#heading').fadeIn(2000);
        //$('#search-input-group').show("slide", {direction: "left"}, 500);
        $('#search-btn-group').show("slide", {direction: "right"}, 500);
        $('#quick-search .col-md-2').each(function (index) {
            $(this).fadeIn(500 * (index + 1));
        });
    });

</script>

<script type="text/javascript" src="js/sign.js"></script>

</body>
</html>