<div class="panel-heading">
<?php 

echo img($this->my_lang->contentLng["flag"]).' '.$inc_page_header;

switch ($this->router->fetch_class()){
    case 'news':
        $option_links.='<span align="center"><a href="'.adminbase('news/news_list').'">'.
        img('img/icon/content-create.png').'</a></span>';
       break;
    case 'page':
        if($this->id!=""){
            if($this->selectPageTyp=="cat" or $this->selectPageTyp=="txt"){
                $option_links.='&nbsp; <span class="popup-trigger"  onclick="frmLoad(\'ajax/page_frm_load\','.$this->id.',\'cat_con\')"><img src="'.base_url('img/icon/small-category.png').'" align="center"></span>';
                $option_links.='&nbsp; <span class="popup-trigger"  onclick="frmLoad(\'file/upload_frm\','.$this->id.')"><img src="'.base_url('img/icon/small-file-upload.png').'" align="center"></span>';
                $option_links.='&nbsp; <span class="popup-trigger"  onclick="frmLoad(\'file/attachment\','.$this->id.',\'img\')"><img src="'.base_url('img/icon/small-img.png').'" align="center"></span>';
                $option_links.='&nbsp; <span class="popup-trigger"  onclick="frmLoad(\'file/attachment\','.$this->id.',\'doc\')"><img src="'.base_url('img/icon/file.png').'" align="center"></span>';
                $option_links.='&nbsp; <span class="popup-trigger"  onclick="frmLoad(\'map/create\','.$this->id.',\'map\')"><img src="'.base_url('img/icon/map.png').'" align="center"></span>';   
            }
        }
       
       break;
    case 'banner':
       $option_links.='<div><span align="center"><a href="'.adminbase('banner/index').'">'.
            img('img/icon/banner-new.png').'</a></span></div>';
       break;
   case 'menu':
       $option_links.='<div><span align="center"><a href="'.adminbase('menu/makemenu').'">'.
           img('img/icon/menu-create.png').'</a></span></div>';
           break;
           
   case 'footer':      
       $option_links.='<div><span align="center"><a href="'.adminbase('menu/makemenu').'">'.
           img('img/icon/menu-create.png').'</a></span></div>';
           break;
    case 'image':
       break;
    case 'file':
       break;
    case 'video':
       break;
    default:
         
}
?>
    	 <div class="pull-right">
           <?php echo $translateLink ;?>
    	   <?php echo $option_links;?>
    	  </div>
    	
  </div>
  <?php 
  $alert = $error['logic']=="true"? 'alert-success':'alert-danger';
  echo  $error['txt'] != "" ? '<div class="alert '.$alert.'">'.$error['txt'].'</div>':""; 
  ?>