<!DOCTYPE html>
<html>
<head>
    <title>Geolocated Image on Google Maps</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
        }
        #panel {
            width: 200px;
            height: 600px;
            background-color: #f8f8f8;
            padding: 10px;
            font-family: Arial, sans-serif;
            font-size: 14px;
            border-right: 1px solid #ddd;
        }
        #datetime {
            margin-bottom: 20px;
        }
        #coordinates {
            margin-top: 10px;
        }
        #map {
            height: 600px;
            width: calc(100% - 200px);
        }
    </style>
</head>
<body>
    <div id="panel">
        <div id="datetime"><strong>Radar Image Time:</strong><br>{{DATETIME}}</div>
        <div id="coordinates"><strong>Selected Coordinates:</strong><br>Click the map to select a point</div>
        <div><img src="radarimage_colorscale.png" alt="Radar Image Color Scale"></div>
    </div>
    <div id="map"></div>

    <script>
        function initMap() {
            console.log("initMap called"); // Debug: Confirm map initialization

            // Map options
            const mapOptions = {
                zoom: 6,
                center: { lat: {{center_lat}}, lng: {{center_lon}} },
                styles: [
                    { featureType: "all", elementType: "all", stylers: [{ saturation: -50 }, { lightness: 40 }] },
                    { featureType: "water", elementType: "geometry", stylers: [{ color: "#e0f7fa" }] },
                    { featureType: "road", elementType: "geometry", stylers: [{ color: "#f5f5f5" }, { visibility: "simplified" }] },
                    { featureType: "administrative", elementType: "geometry", stylers: [{ color: "#d0d0d0" }] },
                    { featureType: "administrative", elementType: "labels", stylers: [{ visibility: "on" }] },
                    { featureType: "poi", elementType: "all", stylers: [{ visibility: "off" }] },
                    { featureType: "transit", elementType: "all", stylers: [{ visibility: "off" }] }
                ]
            };

            // Create the map
            const map = new google.maps.Map(document.getElementById("map"), mapOptions);
            console.log("Map created"); // Debug: Confirm map creation

            // Image bounds
            const imageBounds = {
                south: {{lat_min}},
                west: {{lon_min}},
                north: {{lat_max}},
                east: {{lon_max}}
            };

            // Add GroundOverlay with clickable: false
            const overlay = new google.maps.GroundOverlay(
                "radarimage_www.png",
                imageBounds,
                { opacity: 0.8, clickable: false }
            );
            overlay.setMap(map);
            console.log("Overlay added"); // Debug: Confirm overlay addition

            // Variable to store the current marker
            let currentMarker = null;

            // Add click event listener
            map.addListener("click", (event) => {
                console.log("Map clicked at:", event.latLng.lat(), event.latLng.lng()); // Debug: Confirm click

                // Remove existing marker
                if (currentMarker) {
                    currentMarker.setMap(null);
                }

                // Get coordinates
                const lat = event.latLng.lat();
                const lng = event.latLng.lng();

                // Create new marker
                currentMarker = new google.maps.Marker({
                    position: { lat, lng },
                    map: map
                });
                console.log("Marker placed"); // Debug: Confirm marker placement

                // Update coordinates in panel
                const coordinatesDiv = document.getElementById("coordinates");
                if (coordinatesDiv) {
                    coordinatesDiv.innerHTML = `
                        <strong>Selected Coordinates:</strong><br>
                        Latitude: ${lat.toFixed(6)}<br>
                        Longitude: ${lng.toFixed(6)}
                    `;
                    console.log("Coordinates updated in panel"); // Debug: Confirm panel update
                } else {
                    console.error("Coordinates div not found");
                }
            });
        }
    </script>

    <!-- Load Google Maps API -->
    <script async
        src="https://maps.googleapis.com/maps/api/js?key={{API_KEY}}&callback=initMap">
    </script>
</body>
</html>