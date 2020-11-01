<!-- panel default start -->
<div class="panel panel-default">
    <?php echo $page_options;?>
   
    <!-- panel-heading end -->
    <div class="panel-body">
    <div class="container-fluid">
    
        <ul class="list-group content-list">
        
        <?php     
        foreach($catList as $x=>$y){
            $catListHtml.= '<li class="list-group-item nav row">'.
            '<a class="list-link" title="Düzenle" href="'.adminbase("page/create/cat/").$x.'">'.nbs($y["nbr"]).$y["alias"].'</a>'.
            '<div class="col col-sm-1 pull-right"><input class="orderbox form-control" placeholder="sıra" data="orderbox-page-'.$x.'" type="text" value="'.$y["order"].'"></div>'.
            '<div class="col col-sm-1 pull-right"><span title="Yayın" data="publish-page-'.$x.'-'.$y['pub'].'" class="publish-'.$y['pub'].'"><i class="fa fa-circle"></i></span></div>'.
            '<div class="col col-sm-1 pull-right"><span title="Sil" data="delete-page-'.$x.'" class="delete-obj pull-right"><i class="fa fa-window-close"></i></span></div></li>';
        }/*foreach*/
        echo $catListHtml;
        ?>
        </ul>
  
    </div>
    <!-- panel body end -->	

</div>
</div>
