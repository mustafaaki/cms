
<input id="pac-input" class="form-control" type="text" placeholder="Search Box" value="<?php echo $this->map_address ?>">

<div id="map"></div>
<div class="row">
    Lat: <input type="text" id="map_lat" name="lat" value="<?php echo $this->map_lat ?>"><?php echo nbs(8)?>
    Lng: <input type="text" id="map_lon" name="lng" value="<?php echo $this->map_lon ?>"><?php echo nbs(8)?>
     Zoom: <select id="map_zoom" name="value">
        <?php 
        for($xi=1; $xi<=22 ;$xi++){
           $selectedzoom = ($this->map_zoom==$xi)?'selected':'';
            echo '<option value="'.$xi.'" '.$selectedzoom.'>'.$xi.'</option>';    
        }
        ?>
    </select>
</div>
<div class="row">
    Yayın: <input type="checkbox" id="map_pub" name="pub" value="<?php echo $this->map_pub ?>" <?php echo $this->map_pub =='y' ? 'checked':''; ?>><?php echo nbs(8)?>
    <input type="hidden" id="map_id" name="map_id" value="<?php echo $this->map_id ?>">
    <input type="hidden" id="page_id" name="page_id" value="<?php echo $page_id;?>">
    <?php 
    if(multi_language==TRUE){
        echo 'Çeviri Sayfalarınada ekle: <input type="checkbox" id="translate_page" name="translate_page" value="y">';
    }
    ?>
    <input type="button" id="map_save" value="Kaydet" onclick="map_save()">
</div>

<style>
#map{width:100%;;height:300px;display:block;z-index:0}
#pac-input{position:relative;z-index:100}
</style>
<script>


      // This example adds a search box to a map, using the Google Place Autocomplete
      // feature. People can enter geographical searches. The search box will return a
      // pick list containing a mix of places and predicted search terms.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
        var mapZoom= <?php echo $this->map_zoom ?>;
        var mapLat = <?php echo $this->map_lat ?>;
        var mapLon = <?php echo $this->map_lon ?>;
      $("body").on('change','#map_zoom',function(event) {
    	  
    	  
    	   initAutocomplete();
      });
      
      function initAutocomplete() {
    	 var mapZoom = parseInt(document.getElementById('map_zoom').value);
      	 var mapLat  = parseFloat(document.getElementById('map_lat').value);
      	 var mapLon = parseFloat(document.getElementById('map_lon').value);
    	 myLatLon={lat: mapLat, lng: mapLon}
        
        var map = new google.maps.Map(document.getElementById('map'), {
          center: myLatLon,
          zoom: mapZoom,
          mapTypeId: 'roadmap'
        });

         var marker = new google.maps.Marker({
            position:myLatLon,
            title:"Position"
        });
        marker.setMap(map);
        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
       // map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
         
        
          var places = searchBox.getPlaces();
          
          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              icon: icon,
              zoom: mapZoom,
              title: place.name,
              position: place.geometry.location
            }));
            $('#map_lat').val(place.geometry.location.lat());
            $('#map_lon').val(place.geometry.location.lng());
            
            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
             bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
          map.setZoom(mapZoom);
        });

        google.maps.event.addDomListener(map, 'zoom_changed', function() {
        	  var zoom = map.getZoom();
        	  $('#map_zoom').val(zoom);
          });
      }
      
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCprpnUZtr-OPi5p6kuhcpMGT6FORgdip0&libraries=places&callback=initAutocomplete"></script>