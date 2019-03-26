<html>
<head>
<title> OR7 GIS</title>
<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
</head>
<body>
	<h3>OR 7 GIS</h3>
    <div id="container">

       <div id="menu">
       
            <a href="index.php" target="_blank">Cek GeoJson</a>
       </div>
       <div id="content">
       <!-- <div style="width:50%; border-style: groove; float:left;">  -->
        <div style="width:100%; height: 600px;" id="map"></div>
          
       
      </div>
     </div>
       </div>
       <div id="footer">
       </div>
     </div>
     
     <script>
      var map;

	function initMap() {
		map = new google.maps.Map(document.getElementById('map'), {
		  center: {lat: -0.9594256, lng: 123.7049278},
		  zoom: 5,
		  mapTypeId: 'roadmap'
		});
		
		var show_digitation ;
		$.ajax({ url: 'index.php', dataType: 'json', cache: false, success: function(arrays){
			for(i=0;i<arrays.features.length;i++){
				var data = arrays.features[i];
				var arrayGeometries = data.geometry.coordinates;
				var p1 = '<p> Prov : '+data.properties.propinsi+'</p>';
				
				var idTitik = 0;
				var hitungTitik=[];
				while(idTitik < arrayGeometries[0][0].length){
					var aa = arrayGeometries[0][0][idTitik][0];
					var bb = arrayGeometries[0][0][idTitik][1];
					hitungTitik[idTitik]= {lat:bb,lng: aa};
					idTitik += 1;
				}
				var warna = 'yellow';

				show_digitation = new google.maps.Polygon({
				  paths: hitungTitik,
				  strokeColor: warna,
				  strokeOpacity: 1,
				  strokeWeight: 0.5,
				  fillColor: 'red',
				  fillOpacity: 0.35,
				  content: p1
				});
				show_digitation.setMap(map);
				show_digitation.addListener('click', function(event) {
					var lat = event.latLng.lat();
					var lng = event.latLng.lng();
					var info = {lat:lat, lng:lng};
					infoWindow.setContent(this.content);
					infoWindow.setPosition(info);
					map.setCenter(info);
					infoWindow.open(map);
				  });
				
			}
		}});
		
       // Geolokasi / lokasi sendiri
  		var infoWindow = new google.maps.InfoWindow({map: map});
      }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyANIx4N48kL_YEfp-fVeWmJ_3MSItIP8eI&callback=initMap"
    async defer></script>
</body>
</html>