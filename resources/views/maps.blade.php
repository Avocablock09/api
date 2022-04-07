<?php
use App\Models\jalan;
?>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script type="text/javascript" src="{{ URL::asset('js/maps.js') }}"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

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
            z-index: 1;
        }

    </style>
</head>

<body>

    {{-- -8.690674,115.2637692 --}}
    <div class="content">

        <div class="container-md position-absolute" style="width:18% !important; margin-left:82%; margin-right:0; z-index:2">
                <div class="bg-secondary text-center px-3 py-2">
                    <input class="form-control mb-2" type="text" id="latlng" placeholder="latlng">
                    <p class="mb-2">or</p>
                    <input class="form-control mb-2" type="text" id="lat" placeholder="latitude">
                    <input class="form-control mb-2" type="text" id="lng" placeholder="longitude">
                    <button class="btn btn-primary my-1" onclick="findCoordinate()">Find Coordinate</button>
                </div>
        </div>
        <div id="map"></div>
    </div>
    
    

    {{-- {{ jalan::count() }} --}}
    <script>
        // print();

        var map = L.map('map').setView({
            lon: 115.2629667,
            lat: -8.6875217
        }, 16);

        function findCoordinate(){
            var lat1 = document.getElementById('lat').value;
            var lng1 = document.getElementById('lng').value;
            var latlng = document.getElementById('latlng').value;
            if(lat1 == '' && latlng == ''){
                alert('latitude tidak boleh kosong!');
            }
            else if(lng1=='' && latlng == ''){
                alert('longitude tidak boleh kosong!');
            }
            else if(latlng != ''){
                latlng = latlng.split(', ');
                lat1 = latlng[0];
                lng1 = latlng[1];
            }
            if(lat1!=''&&lng1!=''){
                marker = new L.marker({
                    // TESTING DATA
                    // lat: -8.6847707,
                    // lon: 115.2605087
                    lat: lat1,
                    lon: lng1

                    // REAL DATA
                    // lat: e.latlng.lat,
                    // lon: e.latlng.lng
                });
                marker.bindPopup('' + marker['_latlng']);
                map.addLayer(marker);
                getMarkerAround(marker);
            }
        }

        

        var dist = Math.sqrt(Math.pow((115.2635449 - 115.263442), 2) + Math.pow((Math.abs(-8.6892484) - Math.abs(-
            8.688898)), 2)) / 0.0001 * 11.1;
        // document.write("Vector" + dist + "meters");
        var sites = {!! json_encode($data->toArray()) !!};

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
        var markers;

        sites.forEach(setupMapMarker)
        var prev = 0;
        var marker = new L.marker;
        var marks1 = undefined;
        var marks2 = undefined;

        var circle = undefined;
        var group;

        map.on('click', MapClick);

        function buttonClick() {}

        function distances(loc1, loc2) {
            var dist = Math.sqrt(Math.pow((loc1.lng - loc2.lng), 2) + Math.pow((Math.abs(loc1.lat) - Math.abs(
                loc2.lat)), 2)) / 0.0001 * 11.1;
            return dist.toFixed(5);
        }

        function setupMapMarker(item, index, arr) {
            var myIcon = L.icon({
            iconUrl: 'img/marker-red.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            // popupAnchor: [-3, -76],
            shadowUrl: 'img/marker-shadow.png',
            shadowSize: [68, 95],
            shadowAnchor: [22, 94]
        });
        
            marker = L.marker(
                    [arr[index].latitude, arr[index].longitude], {
                        draggable: true,
                        tileLayer: arr[index].point_id,
                        icon: myIcon
                    }
                )
                .bindPopup('' + arr[index].point_id + '<br>' + arr[index].latitude.toFixed(5) + '<br>' + arr[index]
                    .longitude.toFixed(5)+
                    '<form method="POST" action="map">' +
                    '@method("PUT")' +
                    '<input type="text" name="id" value='+arr[index].point_id+'></input>' +
                    '<input type="text" name="lat" value='+arr[index].latitude+'></input>' +
                    '<input type="text" name="lng" value='+arr[index].longitude+'></input>' +
                    '<button type="submit">Pindah Marker</button>' +
                    '</form>'
                );
                console.log(marker['_icon']);
            // marker.addTo(map);
            marker.myID = arr[index].point_id;
            if (arr[index].status == '1' && arr[index].point_id == '177') {
                circle = L.circle([arr[index].latitude, arr[index].longitude], {
                    color: 'red',
                    fillColor: '#f03',
                    radius: 30,
                    fillOpacity: 0.1,
                    tileLayer: arr[index].point_id
                });
                circle.on('click', removeCircle);
            } else if (arr[index].status == '1') {
                circle = L.circle([arr[index].latitude, arr[index].longitude], {
                    color: 'red',
                    fillColor: '#f03',
                    radius: 30,
                    fillOpacity: 0.1,
                    tileLayer: arr[index].point_id
                });
            } else {
                circle = L.circle([arr[index].latitude, arr[index].longitude], {
                    color: 'blue',
                    fillColor: 'blue',
                    radius: 30,
                    fillOpacity: 0.1,
                    tileLayer: arr[index].point_id
                });
                circle.on('click', removeCircle);
            }
            // marker.addTo(map);
            circle.addTo(map);

            marker.on('click', function(event) {
                if (window.event.ctrlKey) {
                    dist1 = event.target['_latlng'];
                    console.log(event.target);
                    L.circle([arr[index].latitude, arr[index].longitude], {
                        color: 'green',
                        fillColor: 'green',
                        radius: 3,
                        fillOpacity: 1
                    }).addTo(map);
                } else if (window.event.shiftKey) {
                    if (dist1 == undefined) {} 
                    else {
                        dist2 = event.target['_latlng'];
                        var dists = distances(dist1, dist2);
                        event.target.bindPopup('' + dists + ' Meters');

                        L.circle([arr[index].latitude, arr[index].longitude], {
                            color: 'green',
                            fillColor: 'green',
                            radius: 3,
                            fillOpacity: 1
                        }).addTo(map);
                    }

                }
            });

            marker.on('dragend', dragEnd).addTo(map);
            circle.on('click', removeCircle);
            167, 177
        }

        function dragEnd(e) {
            // console.log(e.target);
            var marker = e.target;
            var position = e.target.getLatLng();
            marker.setLatLng(position, {
                draggable: 'true'
            }).bindPopup(
                '<form method="POST" action="map">' +
                '@method("PUT")' +
                '<input type="hidden" name="id" value=' + e.target['options'].tileLayer + '></input>' +
                '<input type="hidden" name="lat" value=' + e.target['_latlng'].lat + '></input>' +
                '<input type="hidden" name="lng" value=' + e.target['_latlng'].lng + '></input>' +
                '<button type="submit">Pindah Marker</button>' +
                '</form>'
            ).update();
            // marker
        }

        function removeCircle(e) {
            if (window.event.altKey) {
                var circle = e.target;
                map.removeLayer(circle);
            }
        }

        function getMarkerAround(marker) {
            var myIcon = L.icon({
            iconUrl: 'img/marker-red.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            // popupAnchor: [-3, -76],
            // shadowUrl: 'img/marker-shadow.png',
            // shadowSize: [68, 95],
            // shadowAnchor: [22, 94]
        });
            // LatLng(-8.689029, 115.263649)
            var xhr = new XMLHttpRequest();
            var list = new Array();
            var data = "lat=" + marker['_latlng'].lat + "&lon=" + marker['_latlng'].lng;
            xhr.open("POST", '/mainalgo', true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                test = JSON.parse(this.response);
                for (let i = 0; i < test['list'].length; i++) {
                    list[i] = test['list'][i];
                }
                // list = test['list'];
                var sigma = 0;
                var dists = new Array();
                var ncij = new Array();
                // var dists = new Array();
                list.forEach((element, index) => {
                    markers = new L.marker([element.latitude, element.longitude]);
                    dists[index] = Number(distances(marker['_latlng'], markers['_latlng']));
                    sigma = sigma + dists[index];
                });
                var mu = sigma / list.length;
                // var mu = 14.03587;
                var dev = deviation(mu, dists);
                console.log('mu='+mu);
                console.log('dev='+Math.pow(dev,2));
                // var dev = 20;
                // let max = ;

                //defining POS
                var pos = [0, Number.MIN_VALUE]; //SET MAX AS CORE
                // var pos = [0, Number.MAX_VALUE];
                // console.log(pos);
                list.forEach((element, index) => {
                    // console.log(element);

                    //MARKER AROUND GET TO MAP
                    markers = new L.marker([element.latitude, element.longitude],{
                        icon: myIcon
                    }).addTo(map);

                    markers.bindPopup('' +element.latitude+', '+element.longitude+'<br>dist: '+dists[index]);
                    // -8.688667, 115.263376
                    // (-8.68872, 115.26339)
                    // -8.688977, 115.263586

                    var atas = Math.pow((dists[index] - mu),2);
                    var bawah = 2 * Math.pow(dev, 2);
                    var pow =  -(atas)/bawah;
                    pow = pow.toFixed(5);

                    e = Math.exp(1);

                    ncij[index] = (1 / (Math.sqrt(2 * 3.14*dev))) * Math.pow(e,(pow));
                        // (Math.pow(e,(-pow)));

                    ncij[index] = ncij[index].toFixed(5);
                    console.log(dists[index]+'-'+pow+'-'+ncij[index]);
                    if (ncij[index] > pos[1]) { //SET MAX TO CORE
                        pos[1] = ncij[index];
                        pos[0] = index;
                    }
                    // console.log(pos[0])
                });
                if(prev == 0){
                    prev = L.marker([list[pos[0]].latitude, list[pos[0]].longitude]);
                }
                // console.log(list[0].latitude);
                // new L.marker([list[pos[0]].latitude, list[pos[0]].longitude]).addTo(map);
                if(list[pos[0]].status==1){
                    new L.circle([list[pos[0]].latitude, list[pos[0]].longitude], {
                    color: 'green',
                    fillColor: 'red',
                    radius: 5,
                    fillOpacity: 0.3
                }).addTo(map);
                }
                else{
                    new L.circle([list[pos[0]].latitude, list[pos[0]].longitude], {
                    color: 'green',
                    fillColor: 'blue',
                    radius: 5,
                    fillOpacity: 0.3
                }).addTo(map);
                }
                
            };
            xhr.send(data);
        }

        function deviation(mu, dists) {
            var dev = 0;
            dists.forEach((element, index) => {
                dev = dev + Math.pow((element - mu), 2);
            });
            dev = Math.sqrt(dev / dists.length);
            return Number(dev);
            // console.log(mu,list);
        }

        function MapClick(e) {

            if (window.event.ctrlKey) {
                map.removeLayer(marker);
                marker = new L.marker({
                    // TESTING DATA
                    // lat: -8.6847707,
                    // lon: 115.2605087

                    // REAL DATA
                    lat: e.latlng.lat,
                    lon: e.latlng.lng
                }, {
                    draggable: true
                });
                
                L.circle([e.latlng.lat, e.latlng.lng], {
                    color: 'red',
                    fillColor: '#f03',
                    radius: 30,
                    fillOpacity: 0.1
                }).addTo(map);

                marker.bindPopup('' + marker['_latlng']);
                // <button onclick=buttonClick()>Hello</button>
                // console.log(marker['_latlng'])
                marker.on('dragend', function(event) {
                    var marker = event.target;
                    var position = marker.getLatLng();
                    marker.setLatLng(position).update();
                });

                map.addLayer(marker);

                getMarkerAround(marker);
            }


            // else if (window.event.shiftKey) {
            //     if (marks1 == undefined) {
            //         marks1 = L.marker({
            //             lat: e.latlng.lat,
            //             lon: e.latlng.lng
            //         }, {
            //             draggable: true
            //         }).bindPopup('mark 1<br>' + e.latlng);



            //         marks1.on('click', function(event) {
            //             if (window.event.shiftKey) {
            //                 map.removeLayer(marks1);
            //                 marks1 = void 0;
            //             }
            //         });
            //         marks1.on('dragend', function(event) {
            //             var marks1 = event.target;
            //             var position = marks1.getLatLng();
            //             marks1.setLatLng(position, {
            //                 draggable: 'true'
            //             }).bindPopup(position).update();
            //         });
            //         marks1.addTo(map);
            //     } 
            //     else if (marks2 == undefined) {
            //         marks2 = L.marker({
            //             lat: e.latlng.lat,
            //             lon: e.latlng.lng
            //         }, {
            //             draggable: true
            //         });
            //         marks2.on('click', function(event) {
            //             dists = distances(marks1['_latlng'], marks2['_latlng']);
            //             marks2.bindPopup('Distance<br>' + dists + ' Meters');
            //             if (window.event.shiftKey) {
            //                 map.removeLayer(marks2);
            //                 marks2 = void 0;
            //             }
            //         });
            //         marks2.on('dragend', function(event) {
            //             var marks2 = event.target;
            //             var position = marks2.getLatLng();
            //             marks2.setLatLng(position, {
            //                 draggable: 'true'
            //             }).bindPopup(position).update();
            //         });
            //         marks2.addTo(map);
            //     }

            // }
        }
    </script>
</body>

</html>
