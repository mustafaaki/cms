<section>
          <div class="top-destination">
            <div class="img-relative">
            <?php foreach($file['img']['top'] as $img=>$imgVal){
                $ban_count++;
		        $banner_act = ($ban_count>1)?"hide":"";
		    ?>
              <div class="animated fadeIn des-<?php echo $ban_count;?> <?php echo $banner_act; ?>" >
              <div class="overlay-banner-shadow"></div>
                <img alt="des-<?php echo $ban_count;?>-lg" class="img-responsive img-100" src="image/<?php echo $imgVal['name'].'.'.$imgVal['ext'];?>">
                <!-- <div class="text-destination">
                  <div class="text-table">
                    <div class="text-cell">
                      <h1>
                       <?php echo $values['header']?>
                      </h1>
                      <p>
                        <?php echo $values['content']?>
                      </p>
                    </div>
                  </div>
                </div> -->
              </div>
              <?php }?>
              
 
              <div class="wrap-info-destination">
                <div class="container">
                  <ul class="left-icon-destination">
                    <li class="active">
                      <div class="icon-wrap">
                        <i aria-hidden="true" class="fa fa-heart md-size"></i>
                        
                      </div>
                      <div class="count-text">
                        <?php echo $like_user;?>
                      </div>
                      
                    </li>
                  </ul>
                  <div class="right-icon-destination">
                        
                        <div class="info-place">
                              <div class="row">
                                <div class="col">
                                  
                                 <div class="text-destination">
                  <div class="text-table">
                    <div class="text-cell">
                      <h1>
                       <?php echo $values['header']?>
                      </h1>
                     
                    </div>
                  </div>
                </div>
                                </div>
                           
                              </div>
                            </div>
                        
                        
                        </div>
                </div>
              </div>
            </div>
            <div class="point-destination">
              <div class="container">
                <div class="point-slider-image-destination auto-position">
                  <ul>
                    <?php 
                    $ban_count=0;
                    foreach($file['img']['top'] as $img=>$imgVal){
                            $ban_count++;
		                    $banner_act = ($ban_count>1)?"hide":"";
		   
		            ?>
                    <li class="active active-<?php echo $ban_count;?>" style="background: url(image/150x150/<?php echo $imgVal['name'].'.'.$imgVal['ext'];?>)">
                      <div class="hover-active">&nbsp;</div>
                      <div class="span-active act-<?php echo $ban_count.' '.$banner_act;?>">
                        <div class="svg-table">
                          <div class="svg-cell">
                            <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"><circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
                          </div>
                        </div>
                      </div>
                    </li>
                    <?php } ?>
                   
                    <li style="width:0px;"></li>
                   
                    
                  </ul>
                </div>
                
              </div>
            </div>
          </div>
          <div class="description">
            <div class="container">
              <div class="row">
                <div class="col-sm-8">
                  <div class="content-des">
                    <h3>
                     <?php echo $values['header']?>
                    </h3>
                    <hr>
                     <p>
                        <?php echo $values['content']?>
                      </p>
                    <?php echo htmlspecialchars_decode($values['longtext'])?>
                  </div>
                  <div class="content-highlights">
                    <h3>
                      <?php echo $this->lang->line('destinations');?>
                    </h3>
                    <ul class="box-img">
                    <?php foreach($news as $news_index=>$news_val){?>
                      <li><a href="<?php echo $news_val["url"]?>">
                        <div class="span-img">
                          <img alt="high-<?php echo $news_index;?>" class="img-full img-100" src="image/200x180/<?php echo $news_val['file_name'].'.'.$news_val['file_ext'];?>">
                          <div class="wrap-text-high">
                            <div class="top-section-high">
                              <?php echo $news_val['header'];?>
                            </div>
                            <div class="bottom-section-high">
                              <i aria-hidden="true" class="fa fa-long-arrow-right md-size"></i>
                            </div>
                          </div>
                        </div>
                        </a>
                      </li>
                    <?php }?>
           
          
      
                     
                    </ul>
                  </div>
                  
                </div>
                <div class="col-sm-4 hidden-xs">
                  <div class="box-wrap">
                    <?php if($map['lat']!="" or $map['lat']!=NULL){?>
                    <div class="location">
                    
                     <h2>
                        <?php echo $this->lang->line('location')?>
                      </h2>
                      <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCprpnUZtr-OPi5p6kuhcpMGT6FORgdip0&libraries=places&callback=initAutocomplete"></script>
                      <div class="box-location" id="map">
                        
                        <div style='overflow:hidden;height:100%;width:100%;'>
                        <div id='gmap_canvas' style='height:100%;width:100%;'></div>
                        
                        <style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div> </div>
                        <script type='text/javascript'>
                        var mapZoom= <?php echo $map['zoom'] ?>;
                        var mapLat = <?php echo $map['lat'] ?>;
                        var mapLon = <?php echo $map['lon'] ?>;
                      
                      
                      function initAutocomplete() {
                    	
                    	 myLatLon={lat: mapLat, lng: mapLon}
                        
                        var map = new google.maps.Map(document.getElementById('map'), {
                          center: myLatLon,
                          zoom: mapZoom,
                          mapTypeId: 'roadmap'
                        });

                         var marker = new google.maps.Marker({
                            position:myLatLon,
                            title:"<?php echo $map['address'] ?>"
                        });
                        marker.setMap(map);
                      }
                        </script>
                     
                    </div>
                    <?php }?>
                    <div class="box-blog">
                      <h2>
                       <?php echo $this->lang->line('highlights');?>
                      </h2>
                      <?php foreach($latest as $lat=>$lVal){?>
                      <div class="content-blog">
                        <img alt="latest-blog" class="img-100" src="image/<?php echo $lVal['file_name'].'.'.$lVal['file_ext']?>">
                        <div class="title-blog">
                          <?php echo $lVal['header'];?>
                        </div>
                        
                        
                        
                        <a href="<?php echo $lVal['url']?>"><?php echo $this->lang->line('read-more')?></a>&nbsp;
                        <hr>
                      </div>
                      <?php } ?>
                      
                      <div class="form-group pull-left">
                       <hr>
                          <h4>
                            <?php echo $this->lang->line('categories');?>
                          </h4>
                          <ul class="categories">
                            <?php foreach($categories as $cat_ind=>$cat_val){?>
                            <li>
                              <a href="<?php echo lngFix($cat_val['url'],$this->user_lang);?>"><i aria-hidden="true" class="fa fa-long-arrow-right"></i><?php echo $cat_val['alias']?></a>
                            </li>
                            <?php }?>
                            
                          </ul>
                     
                      </div> 
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
        </section>