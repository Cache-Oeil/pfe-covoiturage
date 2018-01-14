var bounds= {
    ne: {
        lat: 47.716000,
        lng: 1.519455
    },
    sw: {
        lat: 47.688394,
        lng: 1.494012
    }
};
var points = [
    {
        name: 'Ecole Primaire Cassandre Salviati',
        coords: {
            lat:47.700603,
            lng:1.502828
        }
    },
    {
        name: 'Ecole Maternelle Les Mérolles',
        coords: {
            lat: 47.706878,
            lng: 1.499612
        }
    },
    {
        name: 'Ecole Maternelle De La Brêche',
        coords: {
            lat: 47.702896,
            lng: 1.508067
        }
    },
    {
        name: 'Ecole De Musique',
        coords: {
            lat: 47.705300,
            lng: 1.518452
        }
    },
    {
        name: 'Complexe Sportif',
        coords: {
            lat: 47.698513,
            lng: 1.498582
        }
    }
];
var Mer = {lat:47.699682, lng:1.508414};
function initMap() {
    var mapOptions = {
            zoom: 15,
            center: Mer,
            streetViewControl: false,
            mapTypeControl: true,
            mapTypeControlOptions: {
                position: google.maps.ControlPosition.RIGHT_BOTTOM
            },
            zoomControl: true,
            zoomControlOptions: {
                position: google.maps.ControlPosition.LEFT_CENTER
            }
    };

    // http://localhost/Covoiturage/{rub}
    var $rub = window.location.href.slice(29,);

    if ($rub === '') {
        var map = new google.maps.Map(document.querySelector('#map'), mapOptions);

        for (var i = 0; i < points.length; i++) {
            addMarker(points[i].coords, points[i].name, map);
        }

        // Lay toa do cua nguoi dung
        $('.geolocation').on('click', function(event) {
            event.preventDefault();
            userPosition(map);
        });
        // toggle grid overlay
        var display = false;
        var grid = new gridOverlay();
        toggleGrid(grid, map, display);

        // Display direction service
        new autocompleteDirectionDisplay(document.querySelector('#start_Address'), document.querySelector('#end_Address'), map);
    } else if ($rub === 'recherche-trip') {

        var map = new google.maps.Map(document.querySelector('#map-2'), mapOptions);

        // Lay toa do cua nguoi dung
        $('.geolocation').on('click', function(event) {
            event.preventDefault();
            userPosition(map);
        });
        // toggle grid overlay
        var display = false;
        var grid = new gridOverlay();
        toggleGrid(grid, map, display);

        // Display direction service
        new autocompleteDirectionDisplay(document.querySelector('#origin_input'), document.querySelector('#destination_input'), map);

        // Hien thi cac tuyen duong cua nhung trip tim duoc
        $('#listTrip .trip').click(function() {
            var directionService = new google.maps.DirectionsService;
            var directionDisplay = new google.maps.DirectionsRenderer;
            directionDisplay.setMap(map);

            var origin = $(this).data("origlatlng");
            var destination = $(this).data("destlatlng");
            if (!origin || !destination) {
                return;
            }
            directionService.route({
                origin: origin,
                destination: destination,
                travelMode: 'DRIVING'
            }, function(response, status) {
                if (status === 'OK') {
                    directionDisplay.setDirections(response);
                } else {
                    alert('Requête de la direction a été échoué à cause de ' + status);
                }
            });
        })
    } else if ($rub === 'post-trip') {

        var postDepart = document.querySelector('#post_depart');
        var searchGeometry = new google.maps.places.Autocomplete(postDepart);
        searchGeometry.addListener('place_changed', function() {
            var place = searchGeometry.getPlace();
            if (!place.geometry) {
                return;
            }
            postDepart.setAttribute("data-lat", place.geometry.location.toJSON().lat);
            postDepart.setAttribute("data-lng", place.geometry.location.toJSON().lng);
        });
    }
}

function addMarker(coords, name, map) {
    var marker = new google.maps.Marker({
        position: coords,
        map: map
    });
    var infoWindow = new google.maps.InfoWindow({
        content: name
    });
    marker.addListener('click', function () {
        infoWindow.open(map, marker);
    })
}

function toggleBounce(marker) {
    if (marker.getAnimation() !== null) {
        marker.setAnimation(null);
    } else {
        marker.setAnimation(google.maps.Animation.BOUNCE);
    }

}

function gridOverlay() {
    this.rectBounds = new google.maps.Rectangle({
        strokeColor: '#000',
        strokeWeight: 2,
        fillOpacity: 0,
        bounds: new google.maps.LatLngBounds(bounds.sw, bounds.ne)
    });
    this.rectangle = [];

    var leftSideDist = bounds.ne.lat - bounds.sw.lat;
    var belowSideDist = bounds.ne.lng - bounds.sw.lng;

    var dividerLat = 10;
    var dividerLng = 10;
    var unitLat = leftSideDist / dividerLat;
    var unitLng = belowSideDist / dividerLng;

    for (var i = 0; i < dividerLat; i++) {
        if (!this.rectangle[i]) this.rectangle[i] = [];
        for (var j = 0; j < dividerLng; j++) {
            if (!this.rectangle[i][j]) this.rectangle[i][j] = {};

            this.rectangle[i][j] = new google.maps.Rectangle({
                strokeColor: '#000',
                strokeWeight: 0.3,
                fillOpacity: 0,
                bounds: new google.maps.LatLngBounds(
                    new google.maps.LatLng(bounds.ne.lat - (i+1)*unitLat, bounds.sw.lng + j*unitLng),
                    new google.maps.LatLng(bounds.ne.lat - i*unitLat, bounds.sw.lng + (j+1)*unitLng)
                )
            });
        }
    }
}
gridOverlay.prototype.setRectangleBounds = function(map) {
    this.rectBounds.setMap(map);
}
gridOverlay.prototype.setRectangle = function(map) {
    var dividerLat = 10;
    var dividerLng = 10;

    for (var i = 0; i < dividerLat; i++) {
        for (var j = 0; j < dividerLng; j++) {
            this.rectangle[i][j].setMap(map);
        }
    }
}

function toggleGrid(grid, map, display) {
    $('.grid-map').on('click', function() {
        if (!display) {
            grid.setRectangleBounds(map);
            grid.setRectangle(map);
            map.setCenter(Mer);
        } else {
            grid.setRectangleBounds(null);
            grid.setRectangle(null);
        }
        display = !display;
    });
}

function autocompleteDirectionDisplay(origin, destination, map) {
    this.map = map;
    this.origin = null;
    this.destination = null;
    this.directionService = new google.maps.DirectionsService;
    this.directionDisplay = new google.maps.DirectionsRenderer;
    this.directionDisplay.setMap(map);

    var originAutocomplete = new google.maps.places.Autocomplete(origin);
    //var destinationAutcomplete = new google.maps.places.Autocomplete(destination);
    var me = this;
    destination.addEventListener('change', function() {
        var dest = this;
        // Ham setTimeout de cho su kien change xay ra sau su kien click lay input
        setTimeout(function() {
            for (var i = 0; i < points.length; i++) {
                if (dest.value === points[i].name) {
                    me.destination = points[i].coords;
                    //console.log(me.destination);
                    me.route();
                }
            }
        }, 150);

    });

    this.placeChangeListener(originAutocomplete, 'ORIG');
    //this.placeChangeListener(destinationAutcomplete, 'DEST');
}
autocompleteDirectionDisplay.prototype.placeChangeListener = function(autocomplete, mode) {
    var me = this;
    autocomplete.bindTo('bounds', this.map);
    autocomplete.addListener('place_changed', function() {
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            alert('Veuillez sélectionner un option parmi la list des places');
            return;
        }
        if (mode === 'ORIG') {
            me.origin = place.geometry.location;
        } else {
            me.destination = place.geometry.location;
        }
        me.route();
    });
};
autocompleteDirectionDisplay.prototype.route = function() {
    var me = this;
    if (!me.origin || !me.destination) {
        return;
    }
    me.directionService.route({
        origin: me.origin,
        destination: me.destination,
        travelMode: 'DRIVING'
    }, function(response, status) {
        if (status === 'OK') {
            me.directionDisplay.setDirections(response);
        } else {
            alert('Requête de la direction a été échoué à cause de ' + status);
        }
    });
};

function userPosition(map) {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            map.setCenter(pos);
            addMarker(pos, 'Vous êtes ici', map);
        }, function (error) {
            handleLocationError(true, map.getCenter());
        });
    } else {
        handleLocationError(false, map.getCenter());
    }
}
function handleLocationError(browserHasGeolocation, pos) {
    var infoWindow = new google.maps.InfoWindow({
        position: pos
    });
    infoWindow.setContent(browserHasGeolocation ? "Error: The Geolocation service failed." : "Error: Your browser doesn't support geolocation.");
}