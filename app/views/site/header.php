<?
foreach($menu  as $no=>$obj){
      $globCount++;
		if($obj["step"]=="1"){
			$menu_list.='<div class="col-sm-4  menu-item style-menu-item">'.
			'<a href="'.$obj["url"].'">'.$obj["name"]."</a></div>";
			
			foreach($menu as $n=>$k){
			    $globCount++;
				if($k["step"]=="2" && $k["master"]==$no){
					$count2++;
					if($count2==1)
					$menu_list.='<div class="col-sm-4  menu-item style-menu-item">'.
					'<a href="'.$k["url"].'">'.$k["name"]."</a></div>";
						foreach($menu as $m=>$l){
						    $globCount++;
							if($l["step"]=="3" && $l["master"]==$n){
								$count3++;
								if($count3==1)
								$menu_list.='<div class="col-sm-4  menu-item style-menu-item">'.
								       '<a href="'.$l["url"].'">'.$l["name"]."</a></div>";
									foreach($menu as $t=>$f){
									    $globCount++;
										if($f["step"]=="4" && $f["master"]==$m){
											$count4++;
											if($count4==1)
											    $menu_list.='<div class="col-sm-4  menu-item style-menu-item">'.
												'<a href="'.$f["url"].'">'.$f["name"]."</a></div>";													
										}
									}
								if($count4>0){
									$count4=0;
									//$list.="</ul>";
								}
								//$list.="</li>";
									
							}
						}
						if($count3>0){
						   $count3=0;
						  // $list.="</ul>";
						}
						//$list.="</li>";
				}
			}
			if($count2>0){
			   $count2=0;
			   //$list.="</ul>";
			}
			//$list.="</li>";
		}
}
?>		
<!-- pop up search  -->				
<div class="search-wrap hide" id="js-search">
  <div class="content-search">
    <div class="container">
      <h2>
        <?php echo $this->lang->line('search-header');?>
      </h2>
      <div class="form-group">
        <span class="input input--kohana"><form action="<?php echo lngFix('search',$this->user_lang)?>" method="get"><input type="text" name="key" class="input__field input__field--kohana" ><label class="input__label input__label--kohana"><i class="fa fa-fw fa-search icon icon--kohana"></i><span class="input__label-content input__label-content--kohana">Search</span></label></form></span>
      </div>
    </div>
    <div class="close-pop">
      <a href="javascript:void(0);"><i class="fa fa-times-circle"></i></a>
    </div>
  </div>
</div>
<!-- pop up search END  -->	
        <div class="login-wrap hide" id="js-login">
          <div class="content-login">
            <div class="box-login">
              <div class="box-content-login">
                <div class="form-group">
                <?php 
                    foreach($this->full_list_lang as $lng=>$list){
                      
                         echo '<a href="'.$lng.'" style="diplay:inline-block;float:left">'.img('img/lang/'.$list['flag']).'</a>&nbsp;';
                       
                    }
                ?>
                </div>
                
              </div>
            </div>
          </div>
          <div class="close-pop">
            <a href="javascript:void(0);"><i class="fa fa-times-circle"></i></a>
          </div>
        </div>
        <div class="menu-wrap hide" id="js-menu">
          <div class="col-sm-12 col-md-9">
            <div class="w-24 visible-lg">
              <a class="navbar-brand" href="<?php echo base_url($this->user_lang);?>"><img alt="big-logo" class="img-responsive" src="img/home-turkey-big-logo-transparent.png"></a>
            </div>
            <div class="w-76">
              <h3 class="nav-menu text-center">
                <?php echo $this->lang->line('navigation');?>
              </h3>
              <div class="row">
                <?php echo $menu_list;?>
              </div>
              <h3 class="nav-menu text-center mar-top-20">
                <?php echo $this->lang->line('social-media');?>
              </h3>
              <div class="socmed-list text-center">
                <ul>
                  
                 <?php foreach($this->my_cons['social'] as $cons_ind=>$cons_val){
                    echo  ($cons_val !='' ) ? '<li><a href="'.$cons_val['url'].'">'.'<i aria-hidden="true" class="fa fa-'.$cons_ind.'"></a></i></li>':'';
                 
                     
                 }?>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-sm-3 hidden-sm hidden-xs">
            <h3 class="nav-menu">
              <?php echo $this->lang->line('about-us');?>
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
          <div class="close-pop">
            <a href="javascript:void(0);"><i class="fa fa-times-circle"></i></a>
          </div>
        </div>	

        <header>
          <div id="header-wrap">
            <nav class="navbar navbar-safaria">
              <div class="container">
                <div class="navbar-header">
                  <a class="navbar-brand" href="<?php echo base_url($this->user_lang);?>"><img alt="logo-white" src="img/home-turkey-small-logo.png"></a>
                  <ul class="navbar-mobile visible-xs">
                    <li>
                      <a class="js-search md-size" href="javascript:void(0);"><i aria-hidden="true" class="fa fa-search"></i></a>
                    </li>
                    <li>
                      <a class="js-menu" href="javascript:void(0);">
                        <div class="burger-icon">
                          <div class="strip-icon">
                            &nbsp;
                          </div>
                          <div class="strip-icon">
                            &nbsp;
                          </div>
                        </div>
                      </a>
                    </li>
                  </ul>
                </div>
                <div class="hidden-xs" id="navbar">
                  <ul class="nav navbar-nav navbar-right">
                    <li>
                      <a class="js-search md-size" href="javascript:void(0);"><i aria-hidden="true" class="fa fa-search"></i></a>
                    </li>
                    <li>
                    <?php 
                    foreach($this->full_list_lang as $lng=>$list){
                       
                         echo '<a href="'.$lng.'" style="diplay:inline-block;float:left">'.img('img/lang/'.$list['flag']).'</a>&nbsp;';
                       
                    }
                    ?>
                    </li>
                    <li>
                      <a class="js-menu" href="javascript:void(0);"><?php echo $this->lang->line('menu'); ?>
                        <div class="burger-icon">
                          <div class="strip-icon">&nbsp;</div>
                          <div class="strip-icon">&nbsp;</div>
                        </div>
                      </a>
                    </li>
                  </ul>
                </div>
                <!--/.nav-collapse-->
              </div>
            </nav>
          </div>
        </header>
