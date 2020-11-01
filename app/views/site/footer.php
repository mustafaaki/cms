<?php
	$count=0;
	$size=count($footerLinkCat);
	foreach($footerLinkCat  as  $k=>$y){
		$count++;
		$footerCup.= '<h2>'.$y["name"].'</h2><p>';
		$sizeList=count($y['footerLinks']);
			if($sizeList>0){
				foreach($y['footerLinks'] as $key=>$val){
					$footerCup.= '<a href="'.$val['url'].'" target="'.$val['target'].'">'.$val['urlName'].'</a><br>';
				} 	
			}
		$footerCup.= '</p>';
	}
?>
<footer>
    <div class="wrap-footer">
            <div class="container">
              <div class="row">
                <div class="col-sm-12 col-md-4">
                  <div class="text-left">
                    <?php  print_r($footerCup); ?>
                    <div class="socmed-list">
                      <ul>
                        <?php foreach($this->my_cons['social'] as $cons_ind=>$cons_val){
                         echo  ($cons_val !='' ) ? ('<li><a href="'.$cons_val['url'].'">'.'<i aria-hidden="true" class="fa fa-'.$cons_ind.'"></i></a></li>'):'';
                        }?>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-md-4">
                  <div class="text-center">
                    <h2>
                      <?php echo $this->lang->line('newsletter')?>
                    </h2>
                    <div class="form-group">
                      <span class="input input--kohana"><input id="mail-list" class="input__field input__field--kohana" type="text"><label class="input__label input__label--kohana"><i class="fa fa-fw fa-envelope icon icon--kohana"></i><span class="input__label-content input__label-content--kohana"><?php echo $this->lang->line('your-email')?></span></label></span>
                      <button type="button"  class="btn btn-primary btn-lg" id="submit-button"><?php echo $this->lang->line('contact-send')?></button>
                    </div>
                  <!--<h2>
                      <?php echo $this->lang->line('latest-photo')?>
                    </h2>
                    <ul class="latest-photo">
                      <li>
                        <a href="gallery.html"><img alt="gallery-1" class="img-100" src="assets/images/point1.jpg"></a>
                      </li>
                      <li>
                        <a href="gallery.html"><img alt="gallery-2" class="img-100" src="assets/images/point2.jpg"></a>
                      </li>
                      <li>
                        <a href="gallery.html"><img alt="gallery-3" class="img-100" src="assets/images/point3.jpg"></a>
                      </li>
                      <li>
                        <a href="gallery.html"><img alt="gallery-4" class="img-100" src="assets/images/point5.jpg"></a>
                      </li>
                    </ul> -->
                  </div>
                </div>
                <div class="col-sm-6 col-md-4">
                  <div class="text-right">
                    <h2>
                     <?php echo $this->lang->line('contact');?>
                    </h2>
                    <p>
                      <i aria-hidden="true" class="fa fa-map-marker"></i> <?php echo $this->lang->line('address');?><br>
                      <i aria-hidden="true" class="fa fa-phone"></i> <?php echo $this->lang->line('phone');?><br>
                      <i aria-hidden="true" class="fa fa-fax"></i> <?php echo $this->lang->line('fax');?><br>
                      <i aria-hidden="true" class="fa fa-envelope"></i> <?php echo $this->lang->line('email');?><br>
                    </p>
                    <div class="logo-footer">
                      <a href="<?php echo base_url($this->user_lang);?>"><img alt="big-logo" src="img/home-turkey-small-logo.png"></a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row mar-top-40">
                <div class="col-sm-6">
                  <p class="text-left">
                   <?php 
                    foreach($this->full_list_lang as $lng=>$list){
                        
                         echo '<a style="padding:5px;" href="'.$lng.'" style="diplay:inline-block;float:left">'.img('img/lang/'.$list['flag']).'</a>&nbsp;';
                       
                    }
                    ?>
                   </p>
                </div>
                <div class="col-sm-6">
                   <p class="text-right">
                    <?php echo $this->lang->line('copy')?>
                  </p>
                </div>
              </div>
         </div><!-- container -->
     </div><!-- footer wrap -->
</footer>			
