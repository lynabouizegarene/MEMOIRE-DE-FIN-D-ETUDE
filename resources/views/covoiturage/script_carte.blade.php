    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>

    <style>
        #map-canvas {
        height: 400px;
        width: 100%;
        }
        .adp-legal{visibility:hidden;}
    </style>

    <script>
        var map;
        var geocoder;
        var bounds = new google.maps.LatLngBounds();
        var directionsService = new google.maps.DirectionsService();
        var directionsDisplay = new google.maps.DirectionsRenderer();
        var origin1 = '{{$depart->nom}}'+' , '+'{{$depart->wilaya}}';
        var destinationA = '{{$arrivee->nom}}'+' , '+'{{$arrivee->wilaya}}';

        var destinationIcon = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=A|FF0000|000000';
        var originIcon = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=D|297FB8|000000';

        function initialize() {
            map = new google.maps.Map(document.getElementById('map-canvas'));
            geocoder = new google.maps.Geocoder();
            calculateDistances();
            // Try HTML5 geolocation
            if(navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = new google.maps.LatLng(position.coords.latitude,
                                                     position.coords.longitude);

                    new google.maps.InfoWindow({
                      map: map,
                      position: pos,
                      content: 'Location found using HTML5.'
                    });
                });
            }
            directionsDisplay.setMap(map);
            calcRoute();
        }

        function calculateDistances() {
            var service = new google.maps.DistanceMatrixService();
            service.getDistanceMatrix(
                    {
                        origins: [origin1],
                        destinations: [destinationA],
                        travelMode: google.maps.TravelMode.DRIVING,
                        unitSystem: google.maps.UnitSystem.METRIC,
                        avoidHighways: false,
                        avoidTolls: false
                    }, callback);
        }

        function callback(response, status) {
            if (status != google.maps.DistanceMatrixStatus.OK) {
                alert('Error was: ' + status);
            } else {
                var origins = response.originAddresses;
                var destinations = response.destinationAddresses;
                var outputDivDist = document.getElementById('outputDivDist');
                var outputDivTime = document.getElementById('outputDivTime');
                outputDivDist.innerHTML = '';
                outputDivTime.innerHTML = '';

                    var results = response.rows[0].elements;
                    outputDivDist.innerHTML += results[0].distance.text;
                    outputDivTime.innerHTML += results[0].duration.text;

            }
        }
        function calcRoute() {
            var request = {
                origin:origin1,
                destination:destinationA,
                travelMode: google.maps.TravelMode.DRIVING
            };
            directionsService.route(request, function(response, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                  directionsDisplay.setDirections(response);
                }
            });
        }

        google.maps.event.addDomListener(window, 'load', initialize);
    </script>



