<?php
session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    $message = "You are successfully logged out. Have a nice day!";
    header('location:restaurant.php?res_id=' . $_GET['res_id']);
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
    <!---->
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

        .thumbnail {
            padding: 0;
        }

        .panel {
            position: relative;
        }

        .panel > .panel-heading:after, .panel > .panel-heading:before {
            position: absolute;
            top: 11px;
            left: -16px;
            right: 100%;
            width: 0;
            height: 0;
            display: block;
            content: " ";
            border-color: transparent;
            border-style: solid solid outset;
            pointer-events: none;
        }

        .panel > .panel-heading:after {
            border-width: 7px;
            border-right-color: #f7f7f7;
            margin-top: 1px;
            margin-left: 2px;
        }

        .panel > .panel-heading:before {
            border-right-color: #ddd;
            border-width: 8px;
        }

    </style>
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="50" style="padding-top: 0">

<?php if (isset($_GET['res_id']) && $_GET['res_id'] != '') {

    include('simple_html_dom.php');
    include('conn.php');

    $id = mysqli_real_escape_string($link, $_GET['res_id']);

    $query = "SELECT * from restaurants WHERE id = '$id' LIMIT 1";

    if ($result = mysqli_query($link, $query)) {

        if ($row = mysqli_fetch_array($result)) {

            $_SESSION['res_id'] = $id;

            $details = json_decode($row['details'], true);

            /*$url = $details['photos_url'];

            $html = file_get_html($url);

            $array = [];
            foreach ($html->find('img') as $element) {

                $src = $element->getAttribute('data-original');
                $class = $element->getAttribute('class');
                if (strpos($class, 'photo-thumb'))
                    array_push($array, preg_split('/(\?)/', $src)[0]);
            }*/

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
                        <a class="navbar-brand" href="/">
                            <i class="glyphicon glyphicon-cutlery"></i> Restro
                        </a>
                    </div>

                    <div class="navbar-right">

                        <ul class="nav navbar-nav" role="tablist">

                            <li><a href="#overview">Overview</a></li>
                            <li><a href="#viewmenu">View Menu</a></li>
                            <li><a href="#ordernow">Order Now</a></li>
                            <li><a href="#booktable">Book Table</a></li>
                            <li><a href="#reviews">Reviews</a></li>

                        </ul>

                        <?php if (isset($_SESSION['id'])) { ?>

                            <div class="btn-group">
                                <button type="button" class="btn btn-success dropdown-toggle"
                                        style="margin-top: 8px; margin-left: 10px"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="glyphicon glyphicon-user"></i> <?php echo explode(' ', $_SESSION["name"])[0] ?>
                                    <span
                                        class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <?php if (isset($_SESSION['rest'])) { ?>
                                        <li>
                                            <a href="admin.php?res_id=<?php echo $_SESSION['rest'] ?>">
                                                <i class="glyphicon glyphicon-cutlery"></i> My Restaurant
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="?res_id=<?php echo $_GET['res_id'] ?>&logout"><i
                                                class="glyphicon glyphicon-log-out"></i>
                                            Logout</a></li>
                                </ul>
                            </div>


                        <?php } else { ?>
                            <button style="margin-left: 10px"
                                    id="login" class="btn btn-success navbar-btn" data-toggle="modal"
                                    data-target="#login-modal">Log In
                                <i class="glyphicon glyphicon-log-in"></i>
                            </button>
                        <?php } ?>

                    </div>
                </div>
            </nav>

            <script>

                $('.nav a').on('click', function () {

                    // Make sure this.hash has a value before overriding default behavior
                    if (this.hash !== "") {

                        // Prevent default anchor click behavior
                        event.preventDefault();

                        // Store hash (#)
                        var hash = this.hash;

                        // Using jQuery's animate() method to add smooth page scroll
                        // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area (the speed of the animation)
                        $('html, body').animate({
                            scrollTop: $(hash).offset().top
                        }, 800, function () {

                            // Add hash (#) to URL when done scrolling (default click behavior)
                            window.location.hash = hash;
                        });
                    }// End if statement

                });

                document.title = '<?php echo $details['name']?> | Restro'

            </script>

            <div class="container-fluid" id="overview"
                 style="height: calc(60vh + 50px);
                     background-image: url('<?php echo $pictures[array_rand($pictures)] ?>');
                     background-attachment: fixed;
                     background-position-y: -200px;
                     background-position-x: center;
                     background-repeat: no-repeat;
                     background-size: cover;">

                <div class="row" style="background-color: rgba(0,0,0,0.6); height: 100%">

                    <h1 class="text-center pacifico-font"
                        style="color: white; margin-top: 18vh; font-size: 4em;">
                        <?php echo $details['name'] ?>
                        <br>
                        <small style="color: #dadada"><?php echo $details['locality'] ?></small>
                    </h1>

                </div>

            </div>

            <div class="container-fluid text-center">

                <div class="row" style="padding: 15px 60px 30px 0; background-color: #E8EAF6">

                    <div class="col-md-12">

                        <h2 class="pacifico-font">Overview</h2>

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


                </div>

                <div class="row" id="viewmenu" style="
                    min-height: calc(100vh - 50px); color: white;
                    background-image: url('images/menu-bg.jpg');
                    background-attachment: fixed;
                    background-position: center;
                    background-repeat: no-repeat;
                    background-size: cover;">

                    <?php


                    $url = $details['menu_url'];

                    if ($html = file_get_html($url)){


                    $array = [];
                    $element = $html->find('script')[16];


                    $str = $element->innertext;

                    $res = preg_split('/(=)/', $str);

                    $array = json_decode(preg_split('/(\])/', $res[2])[0] . ']', true);

                    //print_r($array);
                    ?>

                    <div class="col-md-12"
                         style="padding: 0; min-height: 100vh;  padding-top: 50px; background-color: rgba(0,0,0,0.5)">


                        <div class="col-md-offset-2 col-md-8">

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


                    </div>


                </div>

                <?php } ?>

                <div class="row" id="ordernow"
                     style="min-height: 100vh; padding-top: 50px;">

                    <div class="col-md-12">

                        <h2 class="pacifico-font">Order Now</h2>

                        <form class="form-horizontal text-left" id="order-form">
                            <div class="row" style="height: 100%;">

                                <div class="col-md-4">

                                    <div class="col-md-12 well">

                                        <h3 class="text-center">1. Select Items</h3>

                                        <div class="form-group" style="margin: 0; margin-top: 15px;">

                                            <label for="item-cat">SELECT A CATEGORY</label>
                                            <br>
                                            <select required name="item-cat" class="form-control"
                                                    id="item-cat"></select>

                                        </div>

                                        <div class="form-group" style="margin-top: 15px;">

                                            <div class="col-md-9">
                                                <label for="item">SELECT AN ITEM</label>
                                                <br>
                                                <select required name="item" class="form-control" id="item"></select>
                                            </div>

                                            <div class="col-md-3">
                                                <label for="quantity">QUANTITY</label>
                                                <br>
                                                <input required type="number" min="1" max="12" step="1" name="quantity"
                                                       value="1"
                                                       class="form-control" id="quantity">
                                            </div>

                                        </div>

                                        <div class="form-group" style="margin: 0; margin-top: 15px;">


                                            <button class="pull-right btn btn-danger" id="add-item">
                                                <i class="glyphicon glyphicon-plus"></i> Add Item
                                            </button>


                                        </div>


                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="col-md-12 well" id="cart-main">

                                        <h3 class="text-center">2. Confirm Cart</h3>

                                        <div class="alert alert-info" id="alert-empty-cart">
                                            <strong>Cart Empty!</strong> No items in cart.
                                        </div>

                                        <div id="cart">


                                        </div>

                                        <div class="clearfix">

                                            <button class="btn btn-danger pull-left"
                                                    style="display: none; margin-top: 15px"
                                                    id="reset-cart">
                                                <i class="glyphicon glyphicon-refresh"></i> Reset
                                            </button>


                                            <button class="btn btn-success pull-right"
                                                    style="display: none; margin-top: 15px"
                                                    id="confirm-cart">
                                                <i class="glyphicon glyphicon-thumbs-up"></i> Confirm
                                            </button>

                                        </div>


                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="col-md-12 well" style="padding-bottom: 0">

                                        <h3 class="text-center">3. Enter delivery details</h3>

                                        <div class="form-group">

                                            <div class="col-md-12">

                                                <label for="order-name">FULL NAME</label>
                                                <br>
                                                <input
                                                    value="<?php if (isset($_SESSION['name'])) echo $_SESSION['name'] ?>"
                                                    required type="text" class="form-control" id="order-name"
                                                    name="order-name" disabled
                                                    placeholder="Enter your full name">


                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-12">

                                                <label for="order-phone">PHONE NUMBER</label>
                                                <br>
                                                <input required type="tel" class="form-control" id="order-phone"
                                                       name="order-phone" disabled pattern="^[789]\d{9}$"
                                                       placeholder="Enter your phone number">


                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-12">

                                                <label for="order-address">DELIVERY ADDRESS</label>
                                                <br>
                                                <textarea class="form-control" rows="2" id="order-address"
                                                          name="order-address" disabled required
                                                          placeholder="Enter delivery address"></textarea>

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-12">

                                                <label for="order-requests">ADDITIONAL REQUESTS</label>
                                                <br>
                                                <textarea class="form-control" rows="2" id="order-requests"
                                                          name="order-requests" disabled
                                                          placeholder="Let us know if any additional requests"></textarea>

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-12" id="bill-text">

                                            </div>
                                        </div>


                                        <?php if (!isset($_SESSION['id'])) { ?>
                                            <div class="form-group">
                                                <div class="alert alert-info">
                                                    <strong>Please Log In to order.</strong>
                                                </div>

                                            </div>
                                        <?php }
                                        ?>


                                        <div class="form-group">

                                            <div class="col-md-12">

                                                <button style="margin-bottom: 20px" id="edit-order-items"
                                                        disabled
                                                        class="pull-left btn btn-danger"><i
                                                        class="glyphicon glyphicon-pencil"></i> Edit Items
                                                </button>

                                                <button style="margin-bottom: 20px"
                                                        type="submit" disabled id="send-order"
                                                        class="pull-right btn btn-success"><i
                                                        class="glyphicon glyphicon-shopping-cart"></i> Send Order
                                                </button>


                                            </div>

                                        </div>


                                    </div>

                                </div>
                            </div>
                        </form>

                        <script>

                            var items = [];
                            var order = {
                                items: [],
                                bill: 0
                            };


                            $.get('getmenu.php?res_id=<?php echo $_GET['res_id'] ?>', function (data) {

                                data = JSON.parse(data);

                                items = groupBy(data);

                                console.log(items);

                                var item_cat = $('#item-cat');

                                for (var i = 0; i < items.length; i++) {
                                    item_cat.append('<option value="' + i + '">' + items[i].category + '</option>');
                                }

                                setItemsOptions(0);

                                item_cat.change(function () {

                                    $('#item option').remove();

                                    setItemsOptions($(this).val());

                                });

                            });

                            function setItemsOptions(index) {

                                var cat = items[index];

                                for (var i = 0; i < cat.items.length; i++) {
                                    $('#item')
                                        .append('<option value="' + i + '">'
                                            + cat.items[i].name + ' (₹' + cat.items[i].rate + ')</option>')
                                }

                            }

                            $('#add-item').click(function (e) {

                                e.preventDefault();

                                var cat = $('#item-cat').val();
                                var item = $('#item').val();
                                var quantity = $('#quantity').val();
                                var itemObject = items[cat].items[item];

                                var found = false;

                                for (var i = 0; i < order.items.length; i++) {

                                    if (order.items[i].item == itemObject) {
                                        order.items[i].quantity += (+quantity);
                                        found = true;
                                        break;
                                    }

                                }
                                if (!found)
                                    order['items'].push({item: itemObject, quantity: +quantity});

                                updateCart();

                                console.log(order);


                            });

                            $('#reset-cart').click(function (e) {
                                e.preventDefault();
                                order.items = [];
                                updateCart();
                            });

                            $('#confirm-cart').click(function (e) {
                                e.preventDefault();
                                $('#confirm-cart').prop("disabled", true);
                                $('#add-item').prop("disabled", true);
                                $('#reset-cart').prop("disabled", true);
                                $('.delete-cart-item').prop("disabled", true);
                                $('#order-name').prop("disabled", false);
                                $('#order-address').prop("disabled", false);
                                $('#order-phone').prop("disabled", false);
                                $('#order-requests').prop("disabled", false);
                                $('#send-order').prop("disabled", false);
                                $('#edit-order-items').prop("disabled", false);

                            });

                            $('#edit-order-items').click(function (e) {
                                e.preventDefault();
                                $('#confirm-cart').prop("disabled", false);
                                $('#add-item').prop("disabled", false);
                                $('#reset-cart').prop("disabled", false);
                                $('.delete-cart-item').prop("disabled", false);
                                $('#order-name').prop("disabled", true);
                                $('#order-address').prop("disabled", true);
                                $('#order-phone').prop("disabled", true);
                                $('#order-requests').prop("disabled", true);
                                $('#send-order').prop("disabled", true);
                                $('#edit-order-items').prop("disabled", true);

                            });

                            $('#order-form').on('submit', function (e) {
                                e.preventDefault();

                                order['name'] = $('#order-name').val();
                                order['phone'] = $('#order-phone').val();
                                order['address'] = $('#order-address').val();
                                order['request'] = $('#order-requests').val();

                                waitingDialog.show('Sending request');

                                $.post('order.php',
                                    {
                                        order: JSON.stringify(order)
                                    },
                                    function (response) {
                                        console.log(response);
                                        waitingDialog.changeMessage(response);
                                        $('#order-form').trigger('reset');
                                        $('#edit-order-items').click();
                                        $('#reset-cart').click();
                                        setTimeout(function () {
                                            waitingDialog.hide();
                                        }, 2000);
                                    });

                            });


                            function updateCart() {

                                order.bill = 0;

                                $('#cart div').remove();

                                if (order.items.length > 0) {

                                    $('#alert-empty-cart').hide();

                                    $('#confirm-cart').show();
                                    $('#reset-cart').show();

                                    for (var i = 0; i < order.items.length; i++) {

                                        $('#cart').append(`

                                        <div class="row" id="cart-item-` + i + `">
                                            <div class="col-md-12"><b>` + order.items[i].item.name + `</b></div>
                                        </div>
                                        <div class="row text-center" id="cart-` + i + `" style="
                                            line-height: 2.66em;">
                                            <div class="col-md-2">` + (order.items[i].quantity) + `</div>
                                            <div class="col-md-2"> X </div>
                                            <div class="col-md-2">` + order.items[i].item.rate + `</div>
                                            <div class="col-md-2"> = </div>
                                            <div class="col-md-2">` + (order.items[i].quantity * order.items[i].item.rate).toFixed(2) + `</div>
                                            <div class="col-md-2">
                                                <button class="delete-cart-item btn btn-default"
                                                    id="` + i + `"><i class="glyphicon glyphicon-trash"></i>
                                                </button>
                                            </div>
                                        </div>

                                        `);


                                        order.bill += (order.items[i].quantity * order.items[i].item.rate);


                                    }

                                    $('.delete-cart-item').click(function (e) {

                                        e.preventDefault();
                                        var id = $(this).attr("id");

                                        $('#cart-item-' + id).remove();
                                        $('#cart-' + id).remove();

                                        order.items.splice(+id, 1);

                                        updateCart();

                                    });
                                }
                                else {
                                    $('#confirm-cart').hide();
                                    $('#reset-cart').hide();
                                    $('#alert-empty-cart').show();
                                }

                                <?php
                                if (isset($_SESSION['dob'])) {

                                    if (date("m-d", strtotime($_SESSION['dob'])) == date("m-d")) {

                                        echo "
                                            $('#bill-text')
                                            .html('<label>BILL: ₹' + order.bill.toFixed(2) + ' + Discount 10% = ' + (order.bill * 0.9).toFixed(2) + '</label>');
                                            order.bill = order.bill * 0.9;
                                        
                                        ";

                                    } else
                                        echo "
                                            $('#bill-text')
                                            .html('<label>BILL: ₹' + order.bill.toFixed(2) + '</label>');                                       
                                        ";


                                } else
                                    echo "
                                            $('#bill-text')
                                            .html('<label>BILL: ₹' + order.bill.toFixed(2) + '</label>');                                       
                                        ";

                                ?>


                            }

                            function groupBy(collection) {
                                var i = 0, j, val, index, curr,
                                    categories = {}, result = [];
                                for (i = 0, j = collection.length; i < j; i++) {
                                    curr = collection[i];
                                    if (!(curr.category in categories)) {

                                        categories[curr.category] = {category: curr.category, items: []};
                                        result.push(categories[curr.category]);

                                    }
                                    categories[curr.category].items.push(curr);
                                }
                                return result;
                            }

                        </script>


                    </div>

                </div>

                <div class="row" id="booktable"
                     style="min-height: 100vh; padding-top: 50px; background-color: #C5CAE9">

                    <div class="col-md-offset-3 col-md-6" style="padding-left: 30px; padding-right: 30px">

                        <h2 class="pacifico-font">Book Table</h2>

                        <form class="form-horizontal text-left" id="booking-form">

                            <br>

                            <h4>1. Please select your booking details</h4>

                            <div class="form-group">
                                <div class="col-md-5">
                                    <label for="booking-date">SELECT A DATE</label>
                                    <br>
                                    <select required name="booking-date" class="form-control" id="booking-date">
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
                                <div class="col-md-4">
                                    <label for="no-of-guests">NUMBER OF GUESTS</label>
                                    <br>
                                    <select required name="no-of-guests" class="form-control" id="no-of-guests">
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
                                    <select required name="booking-time" class="form-control" id="booking-time">
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
                                           required type="text" class="form-control" id="guest-name" name="guest-name"
                                           placeholder="Enter your full name">


                                </div>

                            </div>

                            <div class="form-group">
                                <div class="col-md-6">

                                    <label for="guest-email">EMAIL</label>
                                    <br>
                                    <input data-toggle="tooltip" title="Booking details will be sent to this email."
                                           value="<?php if (isset($_SESSION['name'])) echo $_SESSION['email'] ?>"
                                           required type="email" class="form-control" id="guest-email"
                                           name="guest-email"
                                           placeholder="Enter email your address">


                                </div>
                                <div class="col-md-6">

                                    <label for="guest-phone">PHONE NUMBER</label>
                                    <br>
                                    <input required type="tel" class="form-control" id="guest-phone" name="guest-phone"
                                           pattern="^[789]\d{9}$"
                                           placeholder="Enter your phone number">


                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">

                                    <label for="requests">ADDITIONAL REQUESTS</label>
                                    <br>
                                    <textarea class="form-control" rows="2" id="requests" name="requests"
                                              placeholder="Let us know if any additional requests"></textarea>


                                </div>
                            </div>

                            <?php if (!isset($_SESSION['id'])) { ?>
                                <div class="alert alert-info">
                                    <strong>Please Log In to book your table.</strong>
                                </div>
                            <?php } else echo '<br>';
                            ?>

                            <button style="margin-bottom: 20px"
                                    type="submit" <?php if (!isset($_SESSION['id'])) echo 'disabled' ?>
                                    class="btn btn-info btn-lg">Send Booking Request
                            </button>

                        </form>

                        <script type="text/javascript" src="js/progress-modal.js"></script>

                        <script>

                            $('#guest-email').tooltip({placement: 'top', trigger: 'focus'});

                            $('#booking-form').on('submit', function (e) {

                                e.preventDefault();
                                waitingDialog.show('Submitting your booking request');
                                $.post('booktable.php', $('#booking-form').serialize(), function (data) {

                                    if (data && data != '') {
                                        waitingDialog.changeMessage(data);
                                        setTimeout(function () {
                                            $('#booking-form').trigger('reset');
                                            waitingDialog.hide();
                                        }, 1500);
                                    }
                                });
                            });

                        </script>

                    </div>
                </div>


                <div class="row" id="reviews" style="min-height: 100vh;  padding-top: 50px;">

                    <div class="col-md-12">

                        <h2 class="pacifico-font">Reviews</h2>


                        <div class="row">

                            <div class="col-md-offset-3 col-md-6 text-left well" style="padding-bottom: 0;">

                                <form class="form-horizontal" id="review-form">

                                    <div class="form-group">

                                        <div class="col-md-3 text-center">

                                            <label>YOUR RATING</label><br>

                                            <fieldset id="ratings" class="rating">

                                                <input type="radio" id="star5" name="rating" value="5"/>
                                                <label class="full" for="star5"></label>

                                                <input type="radio" id="star4half" name="rating" value="4.5"/>
                                                <label class="half" for="star4half"></label>

                                                <input type="radio" id="star4" name="rating" value="4"/>
                                                <label class="full" for="star4"></label>

                                                <input type="radio" id="star3half" name="rating" value="3.5"/>
                                                <label class="half" for="star3half"></label>

                                                <input type="radio" id="star3" name="rating" value="3"/>
                                                <label class="full" for="star3"></label>

                                                <input type="radio" id="star2half" name="rating" value="2.5"/>
                                                <label class="half" for="star2half"></label>

                                                <input type="radio" id="star2" name="rating" value="2"/>
                                                <label class="full" for="star2"></label>

                                                <input type="radio" id="star1half" name="rating" value="1.5"/>
                                                <label class="half" for="star1half"></label>

                                                <input type="radio" id="star1" name="rating" value="1"/>
                                                <label class="full" for="star1"></label>

                                                <input type="radio" id="starhalf" name="rating" value="0.5"/>
                                                <label class="half" for="starhalf"></label>

                                            </fieldset>

                                            <label>YOUR REACTION</label><br>
                                            <label id="reaction">None</label>


                                            <script>

                                                var reaction = $('#reaction');

                                                $('#review-form').on('reset', function () {
                                                    reaction.css("color", "#000").text('None');
                                                });


                                                $('.rating :radio').change(function () {

                                                    var rating = $('.rating :radio:checked').val();
                                                    if (rating == 5)
                                                        reaction.css("color", "#3F7E00").text('Legendary');
                                                    else if (rating == 4.5)
                                                        reaction.css("color", "#3F7E00").text('Loved It!');
                                                    else if (rating == 4)
                                                        reaction.css("color", "#5BA886").text('Great!');
                                                    else if (rating == 3.5)
                                                        reaction.css("color", "#9ACD32").text('Good Enough!');
                                                    else if (rating == 3)
                                                        reaction.css("color", "#CDD614").text('Average');
                                                    else if (rating == 2.5)
                                                        reaction.css("color", "#FFBA00").text('Well...');
                                                    else if (rating == 2)
                                                        reaction.css("color", "#FF7800").text('Blah');
                                                    else
                                                        reaction.css("color", "#CB202D").text('Avoid!');


                                                });


                                            </script>


                                        </div>

                                        <div class="col-md-9">

                                        <textarea required name="review" id="review" rows="3" class="form-control"
                                                  placeholder="Write Your Review Here"></textarea>

                                            <br>

                                            <div class="pull-right">
                                                <?php if (!isset($_SESSION['id'])) { ?>
                                                    <div class="alert alert-warning"
                                                         style="display: inline; margin-right: 10px">
                                                        Log In to write a review.
                                                    </div>
                                                <?php } ?>
                                                <button type="reset" class="btn btn-danger"><i
                                                        class="glyphicon glyphicon-remove"></i> Cancel
                                                </button>
                                                <button
                                                    <?php if (!isset($_SESSION['id']))
                                                        echo 'disabled ';
                                                    ?>
                                                    type="submit" class="btn btn-success">
                                                    <i class="glyphicon glyphicon-ok"></i> Submit
                                                </button>

                                            </div>


                                        </div>


                                    </div>

                                    <script>

                                        $('#review-form').on('submit', function (e) {
                                            e.preventDefault();
                                            $.post('addreview.php', $('#review-form').serialize(), function (data) {
                                                console.log(data);
                                                location.reload();
                                            });
                                        });

                                    </script>

                                </form>

                            </div>

                        </div>


                        <div class="row">

                            <div class="col-md-offset-3 col-md-6" style="list-style: none; padding: 0">

                                <?php

                                include('conn.php');
                                $id = mysqli_real_escape_string($link, $_GET['res_id']);

                                $reactions = array("5.0" => "Legendary",
                                    "4.5" => "Loved It!",
                                    "4.0" => "Great",
                                    "3.5" => "Good Enough!",
                                    "3.0" => "Average",
                                    "2.5" => "Well..",
                                    "2.0" => "Blah",
                                    "1.5" => "Avoid!",
                                    "1.0" => "Avoid",
                                    "0.5" => "Avoid"
                                );

                                $colors = array("5.0" => "#3F7E00",
                                    "4.5" => "#3F7E00",
                                    "4.0" => "#5BA886",
                                    "3.5" => "#9ACD32",
                                    "3.0" => "#CDD614",
                                    "2.5" => "#FFBA00",
                                    "2.0" => "#FF7800",
                                    "1.5" => "#CB202D",
                                    "1.0" => "#CB202D",
                                    "0.5" => "#CB202D"
                                );


                                $query = "SELECT * FROM reviews WHERE res_id = '$id' ORDER BY r_date DESC";

                                if ($result = mysqli_query($link, $query)) {

                                    while ($row = mysqli_fetch_assoc($result)) {

                                        $date = new DateTime($row['r_date']);
                                        $now = new DateTime();

                                        $interval = $date->diff($now);
                                        $rating = $row['rating'] . '';

                                        $ago_string = "";

                                        if ($interval->d == 0) {

                                            if ($interval->h == 0) {

                                                $ago_string = $interval->i . " minutes ago";
                                            } else
                                                $ago_string = $interval->h . " hours ago";

                                        } else {

                                            $ago_string = $interval->d . " days ago";

                                        }

                                        ?>

                                        <div class="row text-left">
                                            <div class="col-sm-2">
                                                <div class="thumbnail">
                                                    <img class="img-responsive user-photo"
                                                         src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png">
                                                </div>
                                            </div>

                                            <div class="col-sm-10">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <strong>
                                                            <?php echo $reactions[$rating] ?>
                                                        </strong>
                                                        said,
                                                        <strong>
                                                            <cite class="rev-user">
                                                                <?php
                                                                if (isset($_SESSION['name']) && ($row['u_name'] == $_SESSION['name']))
                                                                    echo 'You';
                                                                else echo $row['u_name'];
                                                                ?>
                                                            </cite>
                                                        </strong> <span
                                                            class="text-muted"> posted <?php echo $ago_string ?>
                                                            </span><span
                                                            style="background-color: <?php echo $colors[$rating] ?>; line-height: 1.5em"
                                                            class="badge pull-right">
                                                            <?php echo 'Rated ' . $row['rating']; ?></span>
                                                    </div>
                                                    <div class="panel-body">
                                                        <?php echo $row['review'] ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <?php }
                                }
                                ?>


                            </div>


                        </div>


                    </div>


                </div>


            </div>


        <?php } else header('Location:');
    } else header('Location:');
} else {
    header('Location:');
}
?>
<?php

if (!isset($_SESSION['id'])) { ?>
    <!-- Modal -->
    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog  modal-sm" role="document">
            <div class="modal-content text-center">
                <div class="modal-header pacifico-font">
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


<script src="js/sign.js"></script>
</body>
</html>