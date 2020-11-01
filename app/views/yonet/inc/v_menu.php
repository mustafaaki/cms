<!-- panel default start -->
<div class="panel panel-default">
    <?php  echo $page_options;	?>
     <div class="panel-body">
    <div class="container-fluid">	 
    <div class="form-group col-sm-8">
        
        <?=$form["open"]?>
    
       
       
	    <div class="form-group col-sm-12">
	       <label class="col-sm-2 pull-left"> Adı</label>
	       <div class="col-sm-6"><?=$form["name"]?></div>
	    </div>
		<div class="form-group col-sm-12">
		   <label class="col-sm-2 pull-left">Kısa Metin</label>
		   <div class="col-sm-6"><?=$form["text"]?></div>
		</div>
		<div class="form-group col-sm-12"><label class="col-sm-2 pull-left">Link</label><div class="col-sm-6"><?=$form["url"]?></div></div>
		
		<div class="form-group col-sm-8">
		          <label class="col-sm-2 pull-left">SIRA</label>
		          <div class="col-sm-2 pull-left"><?=$form["order"]?></div>
		          <div class="col-sm-3 pull-right"><?=$form["submit"]?></div>
		</div>
		
    	<?=$form["id"];?>
    	<?=$form["master"];?>
    	<?=$form["step"];?>
	    <?=$form["close"]?>
	</div>
	


<div class="col-sm-12">

<?php 
$count=0;
$imgArrow=img('img/icon/list-arrow.png');
$imgDel=img('img/icon/delete-red.png');


foreach($list  as $no=>$obj){
	$count++;
	$sub= '<a title="Alt  Ekle" href="'.adminbase ("menu/makemenu/".$no).'">'.$imgArrow.'</a>';
		
		if($obj["step"]=="1"){
			echo '<div class="form-group row">'.
			'<div class="w-2 pull-left">'.$count.'</div>'. 
			'<div class="col-sm-7">'.
			'<a href="'.adminbase("menu/menu_update/".$no).'">'.$obj["name"].'</a>'.'</div>'.
			'<div class="col-sm-1 pull-right"><input type="text" class="form-control" id="json_order-menu-'.$no.'" value="'.$obj["order"].'"></div>'.
			'<div class="col-sm-1 pull-right">'.$sub.'</div>'.
			'<div class="col-sm-1 pull-right"><a href="'.adminbase("menu/menu_del/".$no).'">'.$imgDel.'</a></div>'.
			"</div>";
			
			foreach($list as $n=>$k){
				if($k["step"]=="2" && $k["master"]==$no){
					$sub= '<a title="Alt  Ekle" href="'.adminbase("menu/makemenu/".$n).'">'.$imgArrow.'</a>';
					echo '<div class="form-group row">'.
					'<div class="w-2 pull-left"></div>'. 
					'<div class="col-sm-7">'.nbs($k["step"]*4).
					'<a href="'.adminbase("menu/update/".$n).'">'.$k["name"].'</a></div>'.
					'<div class="col-sm-1 pull-right"><input type="text" class="form-control"  id="json_order-menu-'.$n.'" value="'.$k["order"].'">&nbsp;</div>'.
					'<div class="col-sm-1 pull-right">'.$sub.'</div>'.
					'<div class="col-sm-1 pull-right"><a href="'.adminbase("menu/menu_del/".$n).'">'.$imgDel.'</a></div>'.
					"</div>";
						foreach($list as $m=>$l){
							if($l["step"]=="3" && $l["master"]==$n){
								$sub= '<a title="Alt  Ekle" href="'.adminbase("menu/makemenu/".$m).'">'.$imgArrow.'</a>';
								echo '<div class="row">'.
								'<div class="col-sm-1"></li>'.nbs($l["step"]*4). 
								'<div class="col-sm-7" style="text-indent:30px;">'.
								'<a href="'.adminbase("menu/menu_update/".$m).'">'.$l["name"].'</a>'.'</li>'.
								'<div class="col-sm-1 pull-right"><input class="form-control" type="text" id="json_order-menu-'.$m.'" value="'.$l["order"].'">&nbsp;</li>'.
								'<div class="col-sm-1 pull-right">'.$sub.'</li>'.
								'<div class="col-sm-1 pull-right"><a href="'.adminbase("menu/menu_del/".$m).'">'.$imgDel.'</a></li>'.
								'</div>';	
								foreach($list as $t=>$f){
									
									if($f["step"]=="4" && $f["master"]==$m){
										//$sub= '<a title="Alt  Ekle" href="'.adminbase("/make/".$t).'">'.$imgArrow.'</a>';
										echo '<div class="form-group row">'.
										'<div class="col-sm-1" style="width:'.(15*($f["step"])).'px">'.$m.'</div>'. 
										'<div class="col-sm-7" >'.nbs($f["step"]*4).
			                            '<a href="'.adminbase("menu/update/".$t).'">'.$f["name"].'</a>'.'</div>'.
										'<div class="col-sm-1 pull-right"> &nbsp;<input type="text" class="form-control"  id="json_order-menu-'.$t.'" value="'.$f["order"].'">&nbsp;</div>'.
										'<div class="col-sm-1 pull-right"></div>'.
										'<div class="col-sm-1 pull-right"><a href="'.adminbase("menu/menu_del/".$t).'">'.$imgDel.'</a></div>'.
										"</div>";							
									}
								}
									
							}
						}
				}
			}
		
		}
}

	
		
?>
</div>
</div><!-- container-fluid -->
</div><!-- panel-body -->
</div>

