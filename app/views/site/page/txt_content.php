<section>
  <div class="header-about header-terms">
    <div class="head-table">
      <div class="head-cell">
        <!-- <h3>
          <?php echo $values['header']; ?>
        </h3> -->
      </div>
    </div>
  </div>
  <div class="content-about content-terms">
    <div class="container">
      <div class="detail-blog">
        <div class="row">
          <div class="col-sm-12">
            <ul class="breadcrumb breadcrumb-custom">
              <li><a href="<?php echo base_url($this->user_lang);?>"><?php echo $this->lang->line('home'); ?></a></li>
              <?php 
              
              foreach($breadcrumb as $bc=>$bcVal){
                  
                  $breadcrum_txt = strlen($bcVal['header'])>15 ? (substr($bcVal['header'],0,15).'...'): $bcVal['header'];
              echo '<li><a href="'.$this->user_lang.'/'.$bcVal['url'].'">'.$breadcrum_txt.'</a></li>';
                  
              }
              echo '<li>'.substr($values['header'],0,15).'</li>';
              ?>
            </ul>
            <hr>
          
          <div class="col-sm-8">
            <div class="blog-list-content">
               <h3><?php echo $values['header']; ?></h3> 
              <div>
              <div><img alt="<?php echo $file['img'][0]['header'];?>" class="img-responsive" src="image/<?php echo $file['img']['top'][0]['name'].'.'.$file['img']['top'][0]['ext'];?>"></div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                 
                </div>
                <div class="col-sm-6">
                 <!--  <h4 class="text-right mar-top-20 mar-btm-0i">
                    <i aria-hidden="true" class="fa fa-clock-o mar-right-15"></i><?php echo  $values['cdate']?>
                  </h4> -->
                </div>
              </div>
               <?php echo  htmlspecialchars_decode($values['content']); ?>
              <hr>
                <?php echo  htmlspecialchars_decode($values['longtext']); ?>
              <hr>
              
               <?php foreach($file['doc']['top'] as $doc=>$docVal){
                
		    ?>
             
                <div>
                <a target="_blank" title="<?php echo $docVal['name'];?>" class="file-img-<?php echo $docVal['ext'];?>" href="files/<?php echo $docVal['name'].'.'.$docVal['ext'];?>">
                <img class="thumb" src="img/thumb/<?php echo $docVal['ext'];?>.png" align="left" width="80">
                 <?php echo '<b>'.$docVal['header'].'</b><br>'.$docVal['content']; ?></a>
                </div>
              
              <?php }?>
            </div>
          </div>
          <div class="col-sm-4 hidden-xs">
    
            <div class="form-group pull-left mar-btm-0">
              <h4>
                <?php echo $this->lang->line('highlights');?>
              </h4>
              <div class="wrap-latest-blog">
                <ul>
                   <?php foreach($latest as $l=>$lVal){ ?>
                  <li>
                   <a href="<?php echo $lVal['url'];?>">
                    <div class="left-img-blog">
                      <img alt="point1" class="img-100" src="image/150x150/<?php echo $lVal['file_name'].'.'.$lVal['file_ext'];?>">
                    </div>
                    <div class="right-text-info">
                      <div class="title-blog-info">
                        <div class="date">
                          <?php echo $lVal['flash']?>
                        </div>
                        <div class="title-blog-left">
                          <?php 
                          
                          echo (strlen($lVal['header'])>42)?mb_substr($lVal['header'],0,42).'...':$lVal['header'] ?>
                        </div>
                      </div>
                    </div>
                    </a>
                  </li>
                  <?php } ?>
                </ul>
              </div>
            </div>
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
          </div><!-- col 12 end -->
        </div><!-- row END -->
      </div><!-- detail blog END -->
    </div>
  </div>
</section>
