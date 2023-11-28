<!DOCTYPE html>
<html>

<head>
    <title></title>
    <meta charset="utf-8" />
    <script type='text/javascript'>
        var map;
        var directionsManager;

        function GetMap() {
            map = new Microsoft.Maps.Map('#myMap', {});

            //Load the directions module.
            Microsoft.Maps.loadModule('Microsoft.Maps.Directions', function() {
                //Create an instance of the directions manager.
                directionsManager = new Microsoft.Maps.Directions.DirectionsManager(map);

                //Create waypoints to route between.
                var seattleWaypoint = new Microsoft.Maps.Directions.Waypoint({
                    address: 'Seattle, WA'
                });
                directionsManager.addWaypoint(seattleWaypoint);

                var workWaypoint = new Microsoft.Maps.Directions.Waypoint({
                    address: 'Work',
                    location: new Microsoft.Maps.Location(47.64, -122.1297)
                });
                directionsManager.addWaypoint(workWaypoint);


                //Specify the element in which the itinerary will be rendered.
                // directionsManager.setRenderOptions({
                //     itineraryContainer: '#directionsItinerary'
                // });
                // Subscribe to the directionsUpdated event.

                Microsoft.Maps.Events.addHandler(directionsManager, 'directionsUpdated', function(eventArgs) {
                    if (eventArgs && eventArgs.route[0]) {
                        var routeSummary = eventArgs;
                        //console.log(routeSummary.routeSummary[0].distance);
                    }
                });
                
                //Calculate directions.
                directionsManager.calculateDirections();
               

            });
        }
    </script>
    <script type='text/javascript'
        src='http://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=AtND6We4q6ydLy0dVPwZ1NGD__tCGQzhVSIhMA4EQnSTMVgtOg9TwWhOYzYvVzVC'
        async defer></script>
</head>

<body>
    <div id="myMap" style="position:relative;width:800px;height:600px;"></div>
    <div id='directionsItinerary'></div>
</body>

</html>
