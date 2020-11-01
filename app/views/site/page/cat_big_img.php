 <section>
          <div class="header-about header-terms">
            <div class="head-table">
              <div class="head-cell">
                <h3>
                  <?php echo $values['header'];?>
                </h3>
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
              echo '<li><a href="'.$bcVal['url'].'">'.$breadcrum_txt.'</a></li>';
                  
              }
              echo '<li>'.substr($values['header'],0,15).'</li>';
              ?>
                    </ul>
                    <hr>
                  </div>
                  <div class="col-sm-8">
                  <?php foreach($sub_content as $content=>$conVal){?>
                  
                    <div class="blog-list-content">
                      <div class="img-blog-top">
                        <img alt="blog-1" class="img-responsive" src="image/725x420/<?php echo $conVal['name'].'.'.$conVal['ext']?>">
                        <div class="img-blog-abs">
                          <a href="<?php echo lngFix($conVal['url'],$this->user_lang)?>"><span><?php echo $this->lang->line('read-more');?></span></a>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <h4 class="mar-top-20 mar-btm-0i">
                           <?php echo $conVal['header']?>
                          </h4>
                        </div>
                        <div class="col-sm-6">
                          <h4 class="text-right mar-top-20 mar-btm-0i">
                            <i aria-hidden="true" class="fa fa-eye mar-right-15"></i>
                          </h4>
                        </div>
                      </div>
                      <hr>
                      <p>
                       <?php  echo mb_substr(strip_tags(htmlspecialchars_decode($conVal['longtext'])),0,250); ?>
                      </p>
                    </div>
                   <?php } ?> 
                   
                  </div>
                  <div class="col-sm-4">
                    
                   
                    <div class="form-group pull-left mar-btm-0">
                      <h4>
                        <?php echo $this->lang->line('highlights')?>
                      </h4>
                      <div class="wrap-latest-blog">
                        <ul>
                          <?php foreach($latest as $l=>$lVal){?>
                  <li>
                    <a href="<?php echo $lVal['url']?>">
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
                          
                          echo (strlen($lVal['header'])>40)?substr($lVal['header'],0,35).'...':$lVal['header'] ?>
                        </div>
                      </div>
                    </div></a>
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
                 
                </div>
               <div class="row pagination"> <?php echo $pagination;?></div>
              </div>
            </div>
          </div>
        </section>
        
        <style>
        .pagination ul li{display:inline-block;border:solid 1px #ccc; padding:8px 12px 8px 12px;margin:3px;}
        .pagination ul li:hover{background: #ccc}
        </style>