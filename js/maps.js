/**
 * Created by mithishri on 9/8/2016.
 */
var map;
var bounds;
var currentPosition;
var currentPositionMarker;
var commonInfoWindow;
var restaurants = [];
var markers = [];
var selectedRestaurant = 0;

var initMap = function () {

    map = new google.maps.Map($('#map')[0], {
        center: {lat: 19.1237519, lng: 72.8339179},
        zoom: 15,
        mapTypeControl: false,
        styles: [
            {
                featureType: "poi.business",
                elementType: "labels",
                stylers: [
                    {visibility: "off"}
                ]
            },
            {
                "stylers": [
                    {
                        "saturation": 100
                    },
                    {
                        "gamma": 0.6
                    }
                ]
            }
        ]
    });

    getLocation();
};

var getLocation = function () {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {

            currentPosition = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            setCurrentLocation()

        });
    } else {
        alert("Geolocation is not supported by this browser.");
    }
};


var setCurrentLocation = function () {
    if (currentPositionMarker) {
        currentPositionMarker.setMap(null);
    }
    else {
        currentPositionMarker = new google.maps.Marker({
            icon: 'icons/ic_my_location.svg',
            title: "You're here"
        });
    }
    currentPositionMarker.setMap(map);
    currentPositionMarker.setPosition(currentPosition);
    map.setCenter(currentPosition);


    var q = getParameterByName('q');
    if (q)
        searchByQuery(q);
    else
        getRestaurantsList(currentPosition);
};

var getRestaurantsList = function (position) {

    console.log(position);

    $.ajax({
        url: '/rest.php?lat=' + position.lat + '&lng=' + position.lng,
        success: generateListFromResponse
    });

};

var searchByQuery = function (query) {

    $('#q').val(query);

    if (query && query.length > 0)
        $.ajax({
            url: '/rest.php?q=' + query.replace(new RegExp(' ', 'g'), '20%') + '&lat=' + currentPosition.lat + '&lng=' + currentPosition.lng,
            success: function (reponse) {
                generateListFromResponse(reponse);
            }
        });

};

var generateListFromResponse = function (response) {

    response = JSON.parse(response);

    console.log(response);

    restaurants = [];
    $('#search-result .media').remove();
    $('#search-result p').remove();
    clearMarkers();
    markers = [];

    if (!response || response.length == 0) {

        $('#search-result').append('<p class="text-center lead">Sorry, No results found.</p>');
        return;
    }

    for (var r of response) {

        var thumb = !r.restaurant.thumb || r.restaurant.thumb == '' ? 'images/default.jpg' : r.restaurant.thumb;

        if (r.restaurant.location.latitude != 0 || r.restaurant.location.longitude != 0)

            restaurants.push({
                id: r.restaurant.id,
                name: r.restaurant.name,
                cuisines: r.restaurant.cuisines,
                avgCost: r.restaurant.average_cost_for_two,
                thumb: thumb,
                locality: r.restaurant.location.locality,
                address: r.restaurant.location.address,
                city: r.restaurant.location.city,
                rating: r.restaurant.user_rating.aggregate_rating,
                fillColor: '#' + r.restaurant.user_rating.rating_color,
                position: {
                    lat: +r.restaurant.location.latitude,
                    lng: +r.restaurant.location.longitude
                },
                photos_url: r.restaurant.photos_url,
                menu_url: r.restaurant.menu_url
            });

    }

    if (restaurants.length == 0)
        return;

    console.log(restaurants);

    bounds = new google.maps.LatLngBounds();
    commonInfoWindow = new google.maps.InfoWindow();

    for (var i = 0; i < restaurants.length; i++) {
        var icon = {
            path: SQUARE_PIN,
            fillColor: restaurants[i].fillColor,
            fillOpacity: 1,
            strokeColor: '',
            strokeWeight: 0
        };


        var marker = new Marker({
            position: restaurants[i].position,
            map: map,
            title: restaurants[i].name,
            icon: icon,
            map_icon_label: '<i class="map-icon map-icon-restaurant"></i>',
            id: i
        });
        const res = restaurants[i];
        bounds.extend(marker.position);
        marker.addListener('mouseover', function () {
            addInfoWindow(this, commonInfoWindow, res);
        });
        marker.addListener('mouseout', function () {
            commonInfoWindow.close();
        });

        marker.addListener('click', function () {
            openRestaurant(this.id);
        });

        markers.push(marker);

        addRestaurantToDOM(i, res);
    }

    map.fitBounds(bounds);
    map.addListener('click', function () {
        commonInfoWindow.close();
    });


};

var addInfoWindow = function (marker, infoWindow, restaurant) {
    infoWindow.marker = marker;
    infoWindow.setContent(
        '<div>' +
        '<img style="width: 80px; height: 80px; position: relative; float: left;" src="' + restaurant.thumb + '">' +
        '<h4 style="position: relative; float: left; margin-left: 8px">' + restaurant.name + '' +
        '<small><br>' + restaurant.locality + '</small></h4>' +
        '</div>'
    );
    infoWindow.open(map, marker);
    infoWindow.addListener('closeclick', function () {
        infoWindow.marker = null;
    });
};


var addRestaurantToDOM = function (i, restaurant) {

    var string = `<li class="media" id="` + i + `">
        <div class="media-left">
            <a href="#">
                <img class="media-object" src="` + restaurant.thumb + `" alt="` + restaurant.name + `">
            </a>
        </div>
        <div class="media-body">
            <h4 class="media-heading">` + restaurant.name + `<span class="badge pull-right" style="background: ` + restaurant.fillColor + `">` + restaurant.rating + `</span></h4>
            <p>` + restaurant.address + `
            </p>
        </div>
    </li>`;

    $('#search-result').append(string);

    $('#' + i).click(function () {

        openRestaurant($(this).attr('id'));

    });

};

var clearMarkers = function () {

    for (var i = 0; i < markers.length; i++) {

        markers[i].setMap(null);

    }

};

$('#close').click(function () {

    $('#' + selectedRestaurant).removeClass('media-active');

    $('#map').animate({
        height: '100%'
    }, function () {
        google.maps.event.trigger(map, 'resize');
        map.fitBounds(bounds);
    });

    $('#panel-1').animate({
        height: '0'
    });

});


var openRestaurant = function (id) {
    console.log(restaurants[id]);

    var res = restaurants[id];

    $('#' + selectedRestaurant).removeClass('media-active');

    selectedRestaurant = id;

    $('#' + id).addClass('media-active');

    $('#map').animate({
        height: '40%'
    });

    $('#panel-1').animate({
        height: '60%'
    }, function () {
        google.maps.event.trigger(map, 'resize');
        map.setZoom(18);
        map.panTo(markers[id].getPosition());
        google.maps.event.trigger(markers[id], 'mouseover');
    });

    $.post(
        '/add.php',
        {
            rest: JSON.stringify(restaurants[id])
        },
        function (data, success) {

            console.log(success);
            console.log(data);
        }
    );

    var reviews = [];

    $.get('/rest.php?res-id=' + res.id, function (data) {
        reviews = JSON.parse(data);
        console.log(reviews);

        $('#res-reviews li').remove();

        for (r of reviews) {


            var string = `<li><blockquote>
                                <p>` + r.review.rating_text + `<span class="badge pull-right" style="background: #`
                + r.review.rating_color + `">RATED ` + r.review.rating + `</span></p>
                                <footer>` + r.review.review_time_friendly + ` <cite>` + r.review.user.name + `</cite></footer>
                          </blockquote></li>`;

            $('#res-reviews').append(string);

        }

    });


    $('#phone-no-modal .modal-title').html(res.name);
    $('#res-title').html(res.name);
    $('#res-locality').html(res.locality);
    $('#res-address').html(res.address);
    $('#res-cuisines').html(res.cuisines);
    $('#res-avg-cost').html(res.avgCost);
    $('#res-rating').html(res.rating).css('background', res.fillColor);
    $('#res-thumb').attr('src', res.thumb);

    $('#view-menu').attr('href', 'restaurant.php?res_id=' + res.id + '#viewmenu');
    $('#book-table').attr('href', 'restaurant.php?res_id=' + res.id + '#booktable');
    $('#order-now').attr('href', 'restaurant.php?res_id=' + res.id + '');

};

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

initMap();