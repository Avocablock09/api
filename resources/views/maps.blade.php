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
    {{-- {{ jalan::count() }} --}}
    <script>
        var map = L.map('map').setView({
            lon: 115.2629667,
            lat: -8.6875217
        }, 16);

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
        // sites.forEach(setupMapMarker)

        var marker = new L.marker;
        var marks1 = undefined;
        var marks2 = undefined;

        var circle = undefined;
        var group;
        
        map.on('click', MapClick);

        function buttonClick() {
        }

        function distances(loc1, loc2) {
            var dist = Math.sqrt(Math.pow((loc1.lng - loc2.lng), 2) + Math.pow((Math.abs(loc1.lat) - Math.abs(
                loc2.lat)), 2)) / 0.0001 * 11.1;
            return dist.toFixed(5);
        }

        function setupMapMarker(item, index, arr) {
            marker = L.marker(
                    [arr[index].latitude, arr[index].longitude], {
                        draggable: true,
                        tileLayer: arr[index].point_id
                    }
                )
                .bindPopup(arr[index].point_id.toString())
                .addTo(map);
            marker.myID = arr[index].point_id;
            if (arr[index].status == '1') {
                circle = L.circle([arr[index].latitude, arr[index].longitude], {
                    color: 'red',
                    fillColor: '#f03',
                    radius: 30,
                    fillOpacity: 0.5,
                    tileLayer: arr[index].point_id
                });
            } else {
                circle = L.circle([arr[index].latitude, arr[index].longitude], {
                    color: 'blue',
                    fillColor: 'blue',
                    radius: 30,
                    fillOpacity: 0.3,
                    tileLayer: arr[index].point_id
                });
            }
            marker.addTo(map);
            circle.addTo(map);

            marker.on('click', function(event) {
                if (window.event.ctrlKey) {
                    dist1 = event.target['_latlng'];
                    console.log(event.target);
                    L.circle([arr[index].latitude, arr[index].longitude], {
                        color: 'green',
                        fillColor: 'green',
                        radius: 30,
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
                            radius: 10.5,
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
            console.log(e.target);
            var marker = e.target;
            var position = e.target.getLatLng();
            marker.setLatLng(position, {
                draggable: 'true'
            }).bindPopup(
                '<form method="POST" action="map">'+
                    '@method("PUT")'+
                    '<input type="hidden" name="id" value='+e.target['options'].tileLayer+'></input>'+
                    '<input type="hidden" name="lat" value='+e.target['_latlng'].lat+'></input>'+
                    '<input type="hidden" name="lng" value='+e.target['_latlng'].lng+'></input>'+
                    '<button type="submit">Pindah Marker</button>'+
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

        function getMarkerAround(marker){
            // LatLng(-8.689029, 115.263649)
                    var xhr = new XMLHttpRequest();
                    var list = new Array();
                    var data = "lat=" + marker['_latlng'].lat + "&lon=" + marker['_latlng'].lng;
                    xhr.open("POST", '/mainalgo', true);
                    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhr.onload = function() 
                    {
                        test = JSON.parse(this.response);
                        for (let i = 0; i < test['list'].length; i++) {
                            list[i] = test['list'][i];
                        }
                        // list = test['list'];
                        var sigma = 0;
                        var dists = new Array();
                        var ncij = new Array();
                        // var dists = new Array();
                        list.forEach((element,index)=>{
                            markers = new L.marker([element.latitude, element.longitude]);
                            dists[index] = Number(distances(marker['_latlng'],markers['_latlng']));
                            sigma= sigma + dists[index];
                        });
                        var mu= sigma/list.length;
                        var dev = deviation(mu,dists);
                        // var dev = 20;
                        // let max = ;
                        var pos = [0,Number.MIN_VALUE];
                        console.log(pos);
                        list.forEach((element,index) => {
                            // console.log(element);
                            markers = new L.marker([element.latitude, element.longitude]).addTo(map);
                            markers.bindPopup(''+dists[index]);
                            // console.log('1/pi'+(1/Math.sqrt(2*3.14*dev)));
                            // console.log('dist'+(dists[index]-mu));
                            // console.log('2powdev^2 = '+(2*Math.pow(dev,2)))
                            ncij[index] = (1/Math.sqrt(2*3.14*dev))*
                            (Math.pow(Math.exp(1),(
                                -
                                (
                                    (dists[index]-mu)/(2*Math.pow(dev,2))
                                )
                                )));
                            ncij[index] = ncij[index].toFixed(5);
                            console.log(ncij[index]);
                            if(ncij[index]>pos[1]){
                                pos[1] = ncij[index];
                                pos[0] = index;
                            }
                            // console.log(pos[0])
                        });
                        console.log(list[0].latitude);
                        new L.circle([list[pos[0]].latitude,list[pos[0]].longitude], {
                                    color: 'red',
                                    fillColor: 'red',
                                    radius: 30,
                                    fillOpacity: 0.3
                                }).addTo(map);
                            // console.log('2pidev'+Math.sqrt(2*3.14*dev))
                            // console.log(ncij[index]);
                            // markers.bindPopup(''+dists[index]);

                            // if (element.status == 1) {
                            //     circle = new L.circle([element.latitude, element.longitude], {
                            //         color: 'red',
                            //         fillColor: 'red',
                            //         radius: 30,
                            //         fillOpacity: 0.3,
                            //         tileLayer: element.point_id
                            //     }).addTo(map);
                            // } else {
                            //     circle = new L.circle([element.latitude, element.longitude], {
                            //         color: 'blue',
                            //         fillColor: 'blue',
                            //         radius: 30,
                            //         fillOpacity: 0.3,
                            //         tileLayer: element.point_id
                            //     }).addTo(map);
                            // }
                        // });
                        // console.log(pos);
                        // console.log(ncij);
                        // console.log(typeof(dists))
                        // var e = Math.exp(1);
                        // console.log(e);
                        // console.log(mu);
                    };
                    xhr.send(data);
        }
        function deviation(mu,dists){
            var dev=0;
            dists.forEach((element,index)=>{
                dev = dev + Math.pow((element-mu),2);
            });
            dev = Math.sqrt(dev / dists.length);
            return Number(dev);
            // console.log(mu,list);
        }

        function MapClick(e) {

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
                getMarkerAround(marker);
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
        }
    </script>
</body>

</html>
