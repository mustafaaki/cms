<!-- panel default start -->
<div class="panel panel-default">
    <?php echo $page_options;?>
   
    <!-- panel-heading end -->
    <div class="panel-body">
    <div class="container-fluid">
    
        <ul class="list-group content-list">
        <?php         
        foreach($txtList as $x=>$y){
            $txtListHtml.= '<li class="list-group-item nav">'.
            '<a title="Düzenle" href="'.adminbase("page/create/txt/").$y["id"].'">'.$y["name"].'</a>'.
            '<div class="col col-sm-1 pull-right"><input data="orderbox-page-'.$y['id'].'" placeholder="sıra" type="text" value="'.$y["order"].'" class="orderbox form-control"></div>'.
            '<div class="col col-sm-1 pull-right"><span title="Yayın" data="publish-page-'.$y['id'].'-'.$y['pub'].'" class="publish-'.$y['pub'].'"><i class="fa fa-circle"></i></span></div>'.
            '<div class="col col-sm-1 pull-right"><span title="Sil" data="delete-page-'.$y['id'].'" class="delete-obj pull-right"><i  class="fa fa-window-close"></i></span></div></li>';
           
    
        }/*foreach*/
        echo $txtListHtml;
        
        
        ?>
        </ul>
  
    </div>
    <!-- panel body end -->	
<?php echo $pagination;?>
</div>
</div>
