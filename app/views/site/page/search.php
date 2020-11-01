<section style="min-height: 600px">
      <div class="header-about header-terms">
        <div class="head-table">
          <div class="head-cell">
            <h3>
              
            </h3>
          </div>
        </div>
      </div>
      <div class="content-about content-terms">
        <div class="container">
          <div class="detail-about">
            <div class="row">
            <?php foreach($search_list as $s=>$v){?>
            
            <div class="search-result">
                <h4><a href="<?php echo $this->user_lang.'/'.$v['url']; ?>"><i class="fa fa-arrow-right" aria-hidden="true"></i>
                <?php echo $v['header'];?></a></h4>
                <p><?php echo substr(strip_tags(htmlspecialchars_decode($v['longtext'])),0,160);?></p>
            </div>
            <?php }?>
            <div class="search-result">
               <div class="pagination-container">
                    <?php echo $pagination;?>
               </div> 
            </div>
            </div>
         </div>
        </div>
       </div>
       
</section>
 
<style>
.search-result{display: inline-block !important;
border-bottom: solid 1px #ddd;
padding: 20px;
width: 100%; }
.pagination-container{display:block;position:relative;display: block;
text-align: center;padding:20px;}
.x_pagination { display: inline-block;}
.x_pagination li { color: black;float: left; padding: 8px 8px;text-decoration: none;border-bottom:none !important;border-radius:8px;}
.x_pagination li.active { background-color: #337ab7;color: white;font-weight: bold;}
.x_pagination li a{display:block;width:100%;height:100%}
.x_pagination li:hover:not(.active) {background-color: #cdf1f6;}
</style>