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

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">

        <div class="navbar-header">
            <a class="navbar-brand" style="font-family: 'Pacifico', cursive;" href=""><i
                    class="glyphicon glyphicon-cutlery"></i> Restro</a>
        </div>
        <div class="navbar-right">
            <button id="login" class="btn btn-success navbar-btn">Log In</button>
            <button id="signup" class="btn btn-info navbar-btn">Sign Up</button>
        </div>
    </div>
</nav>
<div class="container-fluid">

    <div id="map-row" class="row row-eq-height">

        <div id="sidebar" class="col-md-3">

            <form style="width: 100%; padding: 0 10px;">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control" id="q" name="q"
                               placeholder="Search for restaurant, cuisine or a dish...">
                        <span class="input-group-btn">
                            <button type="submit" id="search" class="btn btn-primary"><i
                                    class="glyphicon glyphicon-search"></i></button>
                        </span>
                    </div>
                </div>
            </form>

            <ul id="search-result" class="media-list"></ul>

        </div>
        <div id="map-col" class="col-md-9">


            <div id="map"></div>
            <div id="panel-1">
                <div class="row" style="height: 20px; margin-right: 0"></div>

                <div class="col-md-1" style="width: 4%"><i id="close" class="glyphicon glyphicon-remove"></i></div>
                <div class="col-md-8">

                    <div class="row" style="padding-bottom: 10px; border-bottom: solid 1px #dcdcdc">

                        <img id="res-thumb" src="icons/restaurant-icon.png" style="height: auto;" alt=""
                             class="col-md-3 img-rounded">

                        <div class="col-md-9">

                            <h3><b id="res-title">Title</b> <span id="res-rating" class="badge pull-right"
                                                                  style="border-radius: 4px;
                                            font-size: 1em;">4.5</span><br>
                                <small><b id="res-locality">Locality</b></small>
                            </h3>
                            <p id="res-address">Address</p>


                        </div>

                    </div>

                    <table class="table borderless row" style="margin-bottom: 0">

                        <tbody>

                        <tr>

                            <td>CUISINES</td>
                            <td id="res-cuisines">North Indian, Chinese, Seafood</td>

                        </tr>

                        <tr>

                            <td>COST FOR TWO:</td>
                            <td id="res-avg-cost">₹800</td>

                        </tr>

                        </tbody>

                    </table>

                    <div class="row" style="padding-top: 10px; border-top: solid 1px #dcdcdc">

                        <div class="col-md-3">
                            <button style="width: 100%" class="btn btn-lg btn-primary" data-toggle="modal"
                                    data-target="#phone-no-modal"><i
                                    class="glyphicon glyphicon-earphone"></i> Call
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button style="width: 100%" class="btn btn-lg btn-warning"><i
                                    class="glyphicon glyphicon-list"></i> View Menu
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button style="width: 100%" class="btn btn-lg btn-success"><i
                                    class="glyphicon glyphicon-shopping-cart"></i> Order Now
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button style="width: 100%" class="btn btn-lg btn-info"><i
                                    class="glyphicon glyphicon-calendar"></i> Book Table
                            </button>
                        </div>

                    </div>

                </div>
                <div class="col-md-3" style="width: 29.333%">

                    <h4 style="margin: 0">User Reviews</h4>
                    <div class="row" style="padding-bottom: 10px; border-bottom: solid 1px #dcdcdc"></div>
                    <ul id="res-reviews"></ul>

                </div>

            </div>

        </div>

    </div>

</div>

<div class="modal fade" id="phone-no-modal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Name</h4>
            </div>
            <div class="modal-body text-center">
                <h4><b>Phone number :
                        <br><br>
                        <span class="text-primary" style="padding-top: 8px">022 33126791</span></b>
                </h4>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script src="js/maps.js"></script>
</body>
</html>