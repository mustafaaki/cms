<?php
foreach ($file_list as $x=>$y){
    if($typ=='img'){
       $file_thumb= img("image/200x180/".$y["name"].".".$y["ext"],'','class="getImageId-'.$y["file_id"].'"');
    }else if($typ=='doc'){
       $file_thumb= img("img/thumb/".$y["ext"].'.png'.'','class="getImageId-'.$y["file_id"].'"');
    }else if($typ=='vid'){
        
    }
    $pstn = $master != "" ? form_dropdown('position',$this->file_position[$typ],$y['position'],'class=position-filecross-'.$y['cross_id']):"";
    echo '<div class="col cols-sm-12 thumb-search-image">'.$file_thumb.
        
        '<h5 style="padding:3px;">'.$y['header'].'</h5>'.
     '<span class="left-top-id">'.$y["file_id"].'</span>'.
    
     '<div class="col-sm-12">'.
        '<div class="col-sm-1">'.
               '<span data="publish-pagecross-'.$y['cross_id'].'-'.$y['pub'].'" class="publish-y fa fa-circle"></span>'.
        '</div>'.
        '<div class="col-sm-1 pull-left" onclick="removeAttachmentFile('.$y['cross_id'].',$(this))">'.
            '<i class="fa fa-unlink" title="Kaldır"></i>'.
        '</div>'.
        '<div class="col-sm-1 pull-left">'.
            '<a href="'.base_url($this->file_path[$typ].'/'.$y['name'].'.'.$y['ext']).'"  target="_blank">'.
                '<i class="fa fa-eye" title="Bak"></i>'.
            '</a>'.
        '</div>'.
        '<div class="col-sm-3 pull-left">'.
            '<input value="'.$y['order'].'" type="text" data="orderbox-filecross-'.$y['cross_id'].'"  class="orderbox form-control" placeholder="sıra">
        </div>'.
        '<div class="col-sm-2 pull-left">'.$pstn.'</div>'.
     '</div>'.
     '</div>';
}