<section style="min-height:750px">
         <div class="header-about header-terms">
        <div class="head-table">
          <div class="head-cell">
            <h3>
              <?php echo $this->lang->line('contact')?>
            </h3>
          </div>
        </div>
      </div>
          <div class="content-about content-terms">
            <div class="container">
              <div class="detail-about">
                <div class="row">
                  <div class="col-sm-5">
                 
                  
            <h3 class="nav-menu">
              <?php echo $values["header"]?>
            </h3>
            <p class="style-us">
            <?php echo $this->lang->line('home-title')?>
            </p>
             <hr>
            <p class="style-us">
              <i aria-hidden="true" class="fa fa-map-marker"></i> <?php echo $this->lang->line('address');?><br>
              <i aria-hidden="true" class="fa fa-phone"></i> <?php echo $this->lang->line('phone');?><br>
              <i aria-hidden="true" class="fa fa-fax"></i> <?php echo $this->lang->line('fax');?><br>
              <i aria-hidden="true" class="fa fa-envelope"></i> <?php echo $this->lang->line('email');?><br>
            </p>
          
                  
                    
                  </div>
                  <div class="col-sm-7">
                  <div id="map"></div>
             
                    </div>
                </div>
              </div>
            </div>
          </div>
        </section>
<style>
#map{min-width:100% !important;height:400px;} 
</style>
  
  
<script>
  var map;
  function initMap() {
	var myLatLng={lat: <?php echo $map['lat'] ?>, lng: <?php echo $map['lon'] ?>};
    var map = new google.maps.Map(document.getElementById('map'), {
      center: myLatLng,
      zoom: <?php echo $map['zoom'] ?>
    });
    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        title: '<?php echo $this->lang->line($map['address'])?>'
    });
  }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCprpnUZtr-OPi5p6kuhcpMGT6FORgdip0&callback=initMap"></script>