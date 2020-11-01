 <?php 
 if($count_adv_show==0){
 ?>
 
<div id="popup" class="popup-model" tabindex="-1">
				<div class="wrapper popup-container">
				    <?php foreach($news[5] as $kam=>$kval){
				            
				        echo htmlspecialchars_decode($kval['header']);
				        echo '<a href="'.$kval['url'].'">';
				        echo '<img src="image/'.$kval['file_name'].'.'.$kval['file_ext'].'" align="middle" style="width:100%;max-width: 600px;"></a>';

                        }?>
				</div>
				
				<button class="popup-close close"  onclick="popupClose()"><i class="fa fa-close">&nbsp;</i></button>
				
</div>

<style>
#popup{
	margin:0 ;padding:0;
	width:100%;
	height:100%;
	background: #fff;
	z-index:9999;	
	background: rgb(0, 0, 0);
    
    /* RGBa with 0.6 opacity */
    background: rgba(0, 0, 0, 0.6);
    
    /* For IE 5.5 - 7*/
    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);
    
    /* For IE 8*/
-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";
	position: fixed;
	left:0;
	top:0;	
}
.popup-close{
	position:absolute;
	right:10px;top:10px;
	
	
}
.popup-close i{font-size:30px;color:#fff;
	
}
#popup div.popup-container{margin: auto;
    width: 75%;
    max-width:460px;
    top: 50%;left: 50%;
    border: 3px solid #666;
    padding: 10px;
    text-align: center;border:none;background: #fff;
    margin-top:80px;
}
.#popup img{
	margin:0 auto;padding:0;text-align: center
}
.popup-remove{
	display:none;
}
</style>

<script>

function popupClose(){
	
	$("#popup").hide(0);
}
</script>  
 <?php }?>

<section>
          <div class="animated fadeIn hide" id="banner-video">
            <video class="vid-100"  id="vid-100"><source src="video/turkey.mp4" type="video/mp4"></video>
            <div class="title-video hidden-sm hidden-xs">
              <div class="content-text-video">
                <h2>
                 Wonderfull Turkey
                </h2>
                <p>
                 
                </p>
              </div>
            </div>
          </div>
          
         
    <?php 	
   
	foreach($news[1] as $banner=>$bval){
	$ban_count++;
	$fade  = ($ban_count==1)?"fadeIn":"fadeIn hide";
	$banner_url = "";
	if($bval['url']!="#"){
	    $banner_url= '<a href="'.$bval['url'].'"><span class="text-right text-block">'.$this->lang->line('read-more').'</span></a>';
	}
	 
	$slide.= '<div class="banner-item banner-'.$ban_count.' animated '.$fade.'" id="banner-'.$ban_count.'">
             
            <div class="overlay-banner" >&nbsp;</div>
            <div class="layer-slide-'.$ban_count.' layer hidden-xs"  data-image-big="image/'.$bval['file_name'].'.'.$bval['file_ext'].'" data-depth="0.50" data-type="parallax"><img  class="img-responsive img-100"  src="image/'.$bval['file_name'].'.'.$bval['file_ext'].'"></div>
            <div class="layer-slide-'.$ban_count.' layer visible-xs" ><img  class="img-responsive img-100"  src="image/'.$bval['file_name'].'.'.$bval['file_ext'].'"></div>
            <div class="layer-3 text-banner pull-top-100 hidden-xs hidden-sm">
              <div class="container">
                <div class="row">
                  <div class="col-sm-5">
                    <h1>'.$bval['header'].'</h1>
                  </div>
                  <div class="col-sm-7" style="text-align:right">
                    <h2 style="font-family: Kaushan Script, cursive;">'.$bval['text'].'</h2>'.
                    (($bval['flash']!="")? '<hr>':'').
                    '<p>'.$bval['flash'].'</p>
                    <p class="text-right">'.$banner_url.'</p>
                  </div>
                  <div class="col-sm-1">
                   
                  </div>
                </div>
              </div>
            </div>
                
            </div>';
			 }		
	       echo $slide;
        ?>
        
          <div id="banner-mobile"></div>
          <div id="about">
            <div class="intro-safaria hidden-xs">
                        <div class="container">
                            <div class="wrap-intro">
                              <span class="button-intro"><a href="javascript:void(0);" id="js-intro"><i aria-hidden="true" class="fa fa-play"></i></a></span><span class="text-intro">Turkey</span>
                            </div>
                        </div>
                    </div>
            <div class="point-slider-image">
              <div class="container">
                <ul>
                <?php 
                $ban_count=0;
        	    foreach($news[1] as $banner=>$bval){
        	        $ban_count++;
        		    $banner_act = ($ban_count==1)?"":" hide";
        		    
        			$slide_button.='<li class="active active-'.$ban_count.'" style="background:url(image/150x150/'.$bval['file_name'].'.'.$bval['file_ext'].');">
                            <div class="hover-active">&nbsp;</div>
                            <div class="span-active act-'.$ban_count.$banner_act.'">
                              <div class="svg-table">
                                <div class="svg-cell">
                                  <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"><circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
                                </div>
                              </div>
                            </div>
                          </li>';
        			
        		 }
        		 
		         echo $slide_button;
		          ?>
                  <li class="video-click-container" style="width:0px;">
                    
                  </li>
                </ul>
              </div>
            </div>
            <div class="about-content">
              <div class="testimonials">
              <div class="container">
                <h2 >
                  <?php echo $this->lang->line('highlights')?>
                </h2>
              </div>
              <div class="slidetestimony">
                <?php 
                
                foreach($news[2] as $n2=>$n2v){?>
                <div align="center"><a href="<?php echo $n2v['url']?>" style="color:#ede0d5"><img src="image/350x220/<?php echo $n2v['file_name'].'.'.$n2v['file_ext']; ?>" width="460" align="center">
                  <div class="br"></div>
                  
                  <div class="br">&nbsp;</div>
                  <div class="br">&nbsp;</div>
                 <div><?php echo $n2v['header'];?><?php echo $n2v['text']?> <br><b><?php echo $n2v['flash']?></b></a></div>
                </div>
                
                <?php } ?>
              </div>
                </div><!-- teslimonials END -->
       
            </div>
            <div class="promo-content">
              <div class="container">
                <h2 style="color:#0162d5"><?php echo $this->lang->line("news");?></h2>
                <div class="br">
                  &nbsp;
                </div>
                <div class="br">
                  &nbsp;
                </div> 
              </div>
              <div class="homeslick">
                 <?php 
                 $color=array('1'=>'purple','2'=>'green','3'=>'orange','4'=>'pink','5'=>'blue','6'=>'yellow','7'=>'red');
                 foreach($news[3] as $n3=>$n3v){
                 $color_count++;
                     ?>
                <div>
                  <div class="box-ex-promo box-<?php echo $color[$color_count]?>">
                    <div class="top-section">
                      <div class="ex-one"  style="background:url(image/350x220/<?php echo $n3v['file_name'].'.'.$n3v['file_ext']; ?>) no-repeat center top;background-size:cover">
                        <div class="left-ex">
                          <h4 class="bold-font"></h4>
                          <p class="text-left"></p>
                        </div>
                      </div>
                      <div class="bottom-section">
                        <div class="bottom-wrap">
                          <div class="bottom-table">
                            <div class="bottom-cell">
                              <a class="btn button-default btn-<?php echo $color[$color_count]?>" href="<?php echo $n3v['url']?>"><?php echo $this->lang->line('read-more')?></a>
                            </div>
                          </div>
                        </div>
                        <span>
                         <a style="color:white" href="<?php echo $n3v['url']?>"><?php echo $n3v['header']?></a>
                        </span>
                        <div class="bar-section">&nbsp;</div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div><!-- homeslick END -->
            </div><!-- promo-content END -->
            <div class="destination">
              <div class="container">
                <h2><?php echo $this->lang->line('destination')?></h2>
                <ul class="destination-list">
                <?php
                    foreach($news[4] as $n4=>$n4v){?>
                  <li>
                    <a href="<?php echo $n4v['url']?>">
                      <div class="span-img">
                        <img alt="des-1" class="img-100 img-full" src="image/725x420/<?php echo $n4v['file_name'].'.'.$n4v['file_ext']; ?>">
                        <div class="wrap-text-destination">
                          <div class="top-section-des">
                           <!--  <div class="round-des"></div> -->
                          </div>
                          <div class="bottom-section-des">
                            <?php echo $n4v['header']?>
                          </div>
                        </div>
                      </div>
                    </a>
                  </li>
                <?php } ?>
                </ul>
              </div>
            </div><!-- destination END -->
          <!-- <div class="testimonials">
              <div class="container">
                <h2>
                  <?php echo $this->lang->line('activities')?>
                </h2>
              </div>
              <div class="slidetestimony">
                 <?php foreach($news[5] as $n5=>$n5v){?>
                <div>
                  <?php echo $n5v['text']?>
                  <div class="br"></div>
                  <div class="br">&nbsp;</div>
                  <div class="br">&nbsp;</div>
                  <b><?php echo $n5v['flash']; ?></b>
                </div>
                <?php } ?>
              </div>
            </div> <!-- teslimonials END -->
            
          </div><!-- about END -->
          
        </section>