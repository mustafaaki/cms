<!-- panel default start -->
<div class="panel panel-default">
     <?php 	echo $page_options; 	?>
    <div class="panel-body">
    <div class="container-fluid">	  	
    <?=$form["open"]?>	
    
	<div class="form-group col-sm-12">
	    	    
	    	    
		        <div class="form-group col-sm-5">
                   <div class="form-group row"><label class="col-sm-3" >Başlık</label><div class="col-sm-9"><?=$form["header"]?></div></div>
                   <div class="form-group row"><label class="col-sm-3">Açıklama</label><div class="col-sm-9"><?=$form["content"]?></div></div>
                   <div class="form-group row"><label class="col-sm-3">Flash</label><div class="col-sm-9"><?=$form["flash"]?></div></div>
                   <div class="form-group row"><label class="col-sm-3">Url</label><div class="col-sm-9"><?=$form["url"]?></div></div>
                   
                   <div class="row"><hr>İçeriğin Konumunu Seçin<hr>
                    
	            <?php 
    	            foreach($radio  as $r=>$t){
        	             if($frm['position']==$r){
        	                $positionChecked = TRUE;
        	             }else{
        	                $positionChecked = FALSE;
        	             }
	                 echo ' <div class="col-sm-2 pull-left">'.
	                 form_radio('position', $r, $positionChecked,'class=""') .
	                 '<img width="12" src="'.base_url($t).'" align="left" ></div>'; 
                    }
    	        ?>
    	        </div>
    	        <div class="col-sm-12">
	               <hr>
	            </div>
	              
                <div class="row">
                   <div class="col-sm-1 pull-left">Sıra&nbsp;</div>
                   <div class="col-sm-2 pull-left"><?=$form["order"]?></div>
                   <div class="col-sm-1 pull-left">Yayın</div>
                   <div class="col-sm-1 pull-left"><?=$form["pub"]?></div>
                   <div class="col-sm-3 pull-right"><?=$form["submit"]?></div>
                </div>
                
                </div>
				<div class="form-group col-lg-7">
    				<label class="col-lg-3 pull-left">Kapak Resmi Ara</label>
    				    <div class="form-group col-lg-6">
    				            <input type="text" name="addSearchImg" class="form-control" id="add-search-image" placeholder="Atanacak resim için Anahtar Kelime"/>
    	                </div> 
    	                <div class="col-lg-12" id="add-search-image-list"><?php echo $img_selected_html;?></div>
    	                <div class="clear"></div>  
    	                               <?=$form["id"]?>
    	                               <?=$form["img"]?>
    	                               <?=$form["lng"]?>
    				<div class="form-group col-lg-12" id="alertMsg"> </div>
	            </div>
	  
    </div>
     <?=$form["close"]?>
</div>   




<div class="col-lg-12" style="margin-top:30px">
<hr>
<div class="col">
<?php
echo '<a href="'.adminbase('news/news_list/all').'">Tumu</a>&nbsp;|&nbsp;';  
foreach($radio  as $r=>$t){
    echo '<a href="'.adminbase('news/news_list/'.$linkAdd['id']."/" . $linkAdd["order"] . '-' .$r. "/".$linkAdd['page']).'"> Konum '. $r.'</a> &nbsp;|&nbsp;';
}
?>
<a href="<?=adminbase('news/news_list/'.$linkAdd['id'].'/cdate-'.$linkAdd["reverse"].'-'.$linkAdd['position']."/".$linkAdd['page']);?>">Tarihe Göre Listele</a> | 
<a href="<?=adminbase('news/news_list/'.$linkAdd['id'].'/order-'.$linkAdd['reverse'].'-'.$linkAdd['position']."/".$linkAdd['page']);?>">Yayına Göre Listele</a>
</div>

    <?php 
    
    
    $pubInvers="";
   
    echo '<div class="col-sm-12">'.
        
        '<div class="col col-sm-1 pull-left">Kapak</div>'.
        '<div class="col col-sm-6 pull-left">Başlık</div>'.
        '<div class="col col-sm-1 pull-right">Yayın</div>'.
        '<div class="col col-sm-1 pull-right">Sıra</div>'.
        '<div class="col col-sm-1 pull-right">Sil</div>'.
        "</div>";
    foreach($list  as $menu=>$obj){
    	$count++;
    	if($obj->img!="")
    		$newsImg='<img width="75" height="50"  src="'.base_url('image/150x150/'.$obj->fileName.".".$obj->fileExt).'" align="left">';
    	else
    		$newsImg="";
    	
    	$pub='<span class="publish-'.$obj->pub.' fa fa-circle" data="published-news-'.$obj->id.'-'.$obj->pub.'"></span>';
    	
    	echo '<div class="col-lg-12" style="margin-bottom:3px; border:solid 1px  #ddd;padding:3px;">'.
    		  
    		 '<div class="col col-sm-9 pull-left"><a href="'.adminbase('news/news_list/'.$obj->id.'/'.$linkAdd["fix"]).'">'.$newsImg.mb_substr($obj->header,0,30).'...</a></div>'.
    		 '<div class="col col-sm-1 pull-right ">'.$pub.'</div>'.
    		 '<div class="col col-sm-1 pull-right "><input style="width:33px;text-align:center" data="orderbox-news-'.$obj->id.'-int-6" type="text" value="'.$obj->order.'"></div>'.
    		 '<div class="col col-sm-1 pull-right "><span class="delete-obj pull-right" data="delete-news-'.$obj->id.'"><i  class="fa fa-window-close"></i></span></div>'.
    		 '</div>';
    }
    ?>
</div>
<?=$pageLinks?>

</div><!-- container-fluid -->
</div><!-- panel-body -->

<script src="<?=base_url('../js/admin.my.img.js')?>"></script>