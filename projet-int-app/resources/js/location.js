//https://www.freecodecamp.org/news/how-to-get-user-location-with-javascript-geolocation-api
const successCallback = (position) => {
    return position;
};

const errorCallback = (error) => {
    console.log(error);
};

export function askUserLocation() {
    navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
}

export function getDistanceByTransportMethod(waypointA,waypointB) {

    var map;
    var directionsManager;

    //https://learn.microsoft.com/en-us/bingmaps/v8-web-control/map-control-concepts/directions-module-examples/calculate-driving-directions
    map = new Microsoft.Maps.Map('#myMap', {});

    //Load the directions module.
    Microsoft.Maps.loadModule('Microsoft.Maps.Directions', function () {
        //Create an instance of the directions manager.
        directionsManager = new Microsoft.Maps.Directions.DirectionsManager(map);

        //Create waypoints to route between.
        var addressFrom = new Microsoft.Maps.Directions.Waypoint({
            location: new Microsoft.Maps.Location(waypointA)
        });
        directionsManager.addWaypoint(addressFrom);

        var addressTo = new Microsoft.Maps.Directions.Waypoint({
            location: new Microsoft.Maps.Location(waypointB)
        });
        directionsManager.addWaypoint(addressTo);


        //Specify the element in which the itinerary will be rendered.

        // directionsManager.setRenderOptions({
        //     itineraryContainer: '#directionsItinerary'
        // });
        
        // Subscribe to the directionsUpdated event. https://learn.microsoft.com/en-us/bingmaps/
        // Microsoft.Maps.Events.addHandler(directionsManager, 'directionsUpdated', function (eventArgs) {
        //     if (eventArgs && eventArgs.route[0]) {
        //         var routeSummary = eventArgs;
        //         console.log(routeSummary.routeSummary[0].distance);
        //     }
        // });

        //Calculate directions.
        directionsManager.calculateDirections(function (eventArgs) {
            if (eventArgs && eventArgs.route[0]) {
                var routeSummary = eventArgs;
                let distance = routeSummary.routeSummary[0].distance;
                console.log(distance);
                return distance;
            }
        });

    });
}
