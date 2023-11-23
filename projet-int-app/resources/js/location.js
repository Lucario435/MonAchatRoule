//https://www.freecodecamp.org/news/how-to-get-user-location-with-javascript-geolocation-api
const lionelGroulxCoordinates = { lat: 45.64297212030824, long: -73.84121858682752 }

const successCallback = (position) => {
    return position;
};

const noPosGiven = () => {
    return lionelGroulxCoordinates;
};
// https://stackoverflow.com/a/63268328
// Inspired for async and await 
const getLocation = () => {
    return new Promise((resolve, reject) => {
      navigator.geolocation.getCurrentPosition(
        (pos) => {
          // This is the success function
          resolve({
            long: pos.coords.longitude,
            lat: pos.coords.latitude
          });
        },
        (error) => {
          // Even if this is for failed demand, we give default value
          resolve(
            {
                long: lionelGroulxCoordinates.long,
                lat: lionelGroulxCoordinates.lat
            }
          );
        }
      );
    });
  };

export const UserLocation =  await getLocation().then((location) => [location.lat,location.long]);

export function getDistanceByTransportMethod(waypointA, waypointB) {

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
                //console.log(distance);
                return distance;
            }
        });

    });
}
export function getWayPointFromZipCode(zipcode) {
    //http://dev.virtualearth.net/REST/v1/Locations?countryRegion=Canada&postalCode=postalCode/&key={BingMapsKey}
    let response;
    $.ajax({
        url: `http://dev.virtualearth.net/REST/v1/Locations?countryRegion=Canada/&postalCode=${zipcode}/&key=AtND6We4q6ydLy0dVPwZ1NGD__tCGQzhVSIhMA4EQnSTMVgtOg9TwWhOYzYvVzVC`,
        async: false,
        dataType: 'json',
        success: function (data) {
            console.log(data.resourceSets[0].resources[0].point.coordinates);
            response = data.resourceSets[0].resources[0].point.coordinates;
        },
        error: (xhr) => { console.log(xhr); }
    });
    return response;
    //http://dev.virtualearth.net/REST/v1/Locations/CA/{postalCode}
}

export function getTravelDistance(wp1, wp2) {
    //http://dev.virtualearth.net/REST/V1/Routes/Driving?o=xml&wp.0=london&wp.1=leeds&avoid=minimizeTolls&key={BingMapsKey}
    let response;
    let waypoint1 = wp1[0] + ',' + wp1[1];
    let waypoint2 = wp2[0] + ',' + wp2[1];
    $.ajax({
        url: `http://dev.virtualearth.net/REST/V1/Routes/Driving?o=json&wp.0=${waypoint1}&wp.1=${waypoint2}&key=AtND6We4q6ydLy0dVPwZ1NGD__tCGQzhVSIhMA4EQnSTMVgtOg9TwWhOYzYvVzVC`,
        async: false,
        dataType: 'json',
        success: function (data) {
            //console.log(data.resourceSets[0].resources[0].travelDistance);
            response = data.resourceSets[0].resources[0].travelDistance;
        },
        error: (xhr) => { console.log(xhr); }
    });
    return response;
}
