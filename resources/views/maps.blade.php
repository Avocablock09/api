<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
      html, body {
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
    <div id="map"></div>
    <script>
      
      var dist = Math.sqrt(Math.pow((115.2635449-115.263442),2)+Math.pow((Math.abs(-8.6892484)-Math.abs(-8.688898)),2))/0.0001*11.1;
        // document.write(dist+"meters");
      var sites = {!! json_encode($data->toArray())!!};
      
      
        // document.write(sites[0].longitude);
        
      // initialize Leaflet
      var map = L.map('map').setView({lon:115.2629667, lat: -8.6875217 }, 16);
      var list = {!! json_encode($list->toArray())!!};
      if(list!=null){
        document.write('anda berada di zona larangan berhenti');
        L.marker({lon: 115.2637692, lat: -8.690774}).bindPopup("POSISI ANDA").addTo(map);
      }
      // add the OpenStreetMap tiles
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap contributors</a>'
      }).addTo(map);

      // show the scale bar on the lower left corner
      L.control.scale({imperial: true, metric: true}).addTo(map);
      // show a marker on the map
      sites.forEach(myFunction)

        function myFunction(item, index, arr) {
          L.marker({lon: arr[index].longitude, lat: arr[index].latitude}).bindPopup(arr[index].point_id.toString()).addTo(map);
          // document.write(arr[index].latitude);
          if(arr[index].status=='1'){
            L.circle([arr[index].latitude,arr[index].longitude],{color:'red',fillColor:'#f03',radius:30,fillOpacity:0.5}).addTo(map);
          }
          // 167,177
        } 
        
    </script>
  </body>
</html>