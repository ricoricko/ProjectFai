<!DOCTYPE html>
<html>
<head>
    <title>Direction Map</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ol3/3.20.1/ol.css" type="text/css">
    <style>
        .map {
            height: 80vh;
            width: 100%;
        }
        .form-container {
            margin: 20px;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ol3/3.20.1/ol.js"></script>
</head>
<body>
    <div class="form-container">
        <label for="origin">Enter your location:</label>
        <input type="text" id="origin" placeholder="Longitude, Latitude">
        <button onclick="showDirections()">Show Directions</button>
    </div>
    <div id="map" class="map"></div>
    <script type="text/javascript">
  
        var isttsCoord = ol.proj.fromLonLat([112.75859207793356, -7.291210170005233]);

        var map = new ol.Map({
            target: 'map',
            layers: [
                new ol.layer.Tile({
                    source: new ol.source.OSM()
                })
            ],
            view: new ol.View({
                center: isttsCoord,
                zoom: 14
            })
        });

        
        var isttsMarker = new ol.Feature({
            geometry: new ol.geom.Point(isttsCoord)
        });

        var vectorSource = new ol.source.Vector({
            features: [isttsMarker]
        });

        var markerVectorLayer = new ol.layer.Vector({
            source: vectorSource,
            style: new ol.style.Style({
                image: new ol.style.Icon({
                    anchor: [0.5, 1],
                    src: 'https://openlayers.org/en/v4.6.5/examples/data/icon.png'
                })
            })
        });

        map.addLayer(markerVectorLayer);

     
        function addDirections(map, origin, destination) {
            var directionsLayer = new ol.layer.Vector({
                source: new ol.source.Vector(),
                style: new ol.style.Style({
                    stroke: new ol.style.Stroke({
                        color: 'red',
                        width: 3
                    })
                })
            });

            map.addLayer(directionsLayer);

            var routeFeature = new ol.Feature({
                geometry: new ol.geom.LineString([origin, destination])
            });

            directionsLayer.getSource().addFeature(routeFeature);
        }

 
        function showDirections() {
            var originInput = document.getElementById('origin').value;
            if (originInput) {
                var coords = originInput.split(',').map(Number);
                var userLocation = ol.proj.fromLonLat([coords[0], coords[1]]);
                addDirections(map, userLocation, isttsCoord);

     
                var extent = ol.extent.boundingExtent([userLocation, isttsCoord]);
                map.getView().fit(extent, { size: map.getSize(), maxZoom: 16 });
            } else {
                alert('Please enter your location in the format: Longitude, Latitude');
            }
        }
    </script>
</body>
</html>
