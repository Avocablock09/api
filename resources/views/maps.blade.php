<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script type="text/javascript" src="{{ URL::asset('js/maps.js') }}"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        html,
        body {
            height: 100%;
            padding: 0;
            margin: 0;
        }

        #map {
            /* configure the size of the map */
            width: 100%;
            height: 100%;
        }

    </style>
</head>

<body>

    {{-- -8.690674,115.2637692 --}}
    <div id="map">

    </div>

    <script>
        var map = L.map('map').setView({
            lon: 115.2629667,
            lat: -8.6875217
        }, 16);

        var dist = Math.sqrt(Math.pow((115.2635449 - 115.263442), 2) + Math.pow((Math.abs(-8.6892484) - Math.abs(-
            8.688898)), 2)) / 0.0001 * 11.1;
        // document.write("Vector" + dist + "meters");
        var sites = {!! json_encode($data->toArray()) !!};
        var list = {!! json_encode($list->toArray()) !!};
        if (list != null) {
            L.marker({
                lon: 115.2637692,
                lat: -8.690774
            }).bindPopup("POSISI ANDA").addTo(map);
        }

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap contributors</a>'
        }).addTo(map);

        // show the scale bar on the lower left corner
        L.control.scale({
            imperial: true,
            metric: true
        }).addTo(map);
        // show a marker on the map

        var dist1 = undefined;
        var dist2 = undefined;
        sites.forEach(setupMapMarker)

        var marker = new L.marker;
        var marks1 = undefined;
        var marks2 = undefined;

        map.on('click', function(e) {
            if (window.event.ctrlKey) {
                map.removeLayer(marker);
                marker = new L.marker({
                    lat: e.latlng.lat,
                    lon: e.latlng.lng
                }, {
                    draggable: true
                }).bindPopup('<button onclick=buttonClick()>Hello</button>' + e.latlng);
                marker.on('dragend', function(event) {
                    var marker = event.target;
                    var position = marker.getLatLng();
                    marker.setLatLng(position, {
                        draggable: 'true'
                    }).bindPopup(position).update();
                });
                map.addLayer(marker);
            } 
            else if (window.event.shiftKey) {
                if (marks1 == undefined) {
                    marks1 = L.marker({
                        lat: e.latlng.lat,
                        lon: e.latlng.lng
                    }, {
                        draggable: true
                    }).bindPopup('mark 1<br>' + e.latlng);
                    marks1.on('click', function(event) {
                        if (window.event.shiftKey) {
                            map.removeLayer(marks1);
                            marks1 = void 0;
                        }
                    });
                    marks1.on('dragend', function(event) {
                        var marks1 = event.target;
                        var position = marks1.getLatLng();
                        marks1.setLatLng(position, {
                            draggable: 'true'
                        }).bindPopup(position).update();
                    });
                    marks1.addTo(map);
                } else if (marks2 == undefined) {
                    marks2 = L.marker({
                        lat: e.latlng.lat,
                        lon: e.latlng.lng
                    }, {
                        draggable: true
                    });
                    marks2.on('click', function(event) {
                        dists = distances(marks1['_latlng'], marks2['_latlng']);
                        marks2.bindPopup('Distance<br>' + dists + ' Meters');
                        if (window.event.shiftKey) {
                            map.removeLayer(marks2);
                            marks2 = void 0;
                        }
                    });
                    marks2.on('dragend', function(event) {
                        var marks2 = event.target;
                        var position = marks2.getLatLng();
                        marks2.setLatLng(position, {
                            draggable: 'true'
                        }).bindPopup(position).update();
                    });
                    marks2.addTo(map);
                }

            }
        });

        function buttonClick(){
            console.log('button clicked');
        }
        function distances(loc1, loc2) {
            var dist = Math.sqrt(Math.pow((loc1.lng - loc2.lng), 2) + Math.pow((Math.abs(loc1.lat) - Math.abs(
                loc2.lat)), 2)) / 0.0001 * 11.1;
            return dist.toFixed(5);
        }

        function setupMapMarker(item, index, arr) 
        {
            marker = L.marker(
                [arr[index].latitude,arr[index].longitude],
            )
            .bindPopup(arr[index].point_id.toString())
            .addTo(map);
            console.log(marker);
            marker;
            marker.on('click',function(event){
                if(window.event.ctrlKey){
                    dist1 = event.target['_latlng'];
                    L.circle([arr[index].latitude, arr[index].longitude], {
                        color: 'green',
                        fillColor: 'green',
                        radius: 10.5,
                        fillOpacity: 1
                    }).addTo(map);
                }
                else if(window.event.shiftKey){
                    dist2 = event.target['_latlng'];
                    var dists = distances(dist1,dist2);
                    event.target.bindPopup(''+dists+' Meters');
                    L.circle([arr[index].latitude, arr[index].longitude], {
                        color: 'green',
                        fillColor: 'green',
                        radius: 10.5,
                        fillOpacity: 1
                    }).addTo(map);
                }
            })
            if (arr[index].status == '1') {
                L.circle([arr[index].latitude, arr[index].longitude], {
                    color: 'red',
                    fillColor: '#f03',
                    radius: 30,
                    fillOpacity: 0.5
                }).addTo(map);
            } else {
                L.circle([arr[index].latitude, arr[index].longitude], {
                    color: 'blue',
                    fillColor: 'blue',
                    radius: 3,
                    fillOpacity: 0.3
                }).addTo(map);
            }//167,177
        }
    </script>
</body>

</html>
