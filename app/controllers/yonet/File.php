<?php
class file extends CI_Controller {
    public $frmVal=Array("name"=>"",
        "ext"=>"",
        "typ"=>"",
        "pub"=>"",
        "wx"=>"",
        "hx"=>"",
        "id"=>"",
        "size"=>"",
        "cuser"=>"",
        "cdate"=>"",
        "source"=>""
    );
    
    public $translateVal=Array("header"=>"",
        "content"=>"",
        "refId"=>"",
        "lng"=>"",
        "alt"=>"",
        "tag"=>""
        );
    
    public $quality=80;
    public $file_path= Array('img'=>'image/','doc'=>'files/','vid'=>'video/'); //dosya turune gore kayit yerleri
    public $my_upload;
    public $thumb;
    public $ext;
    public $file_position=Array('img'=>Array('top'=>'top','list'=>'list','galleri'=>'galleri','banner'=>'banner'),
                                'doc'=>Array('top'=>'top','right'=>'right','bottom'=>'bottom'),
                                'vid'=>Array('top'=>'top')
                                );
    
    public function __construct(){
        parent::__construct();
        $this->load->library ( Array('logincheck','user_agent') );
        $this->load->model ( Array('simple_model') );
        $this->load->helper(Array('password','form'));
        $this->logincheck->check();
    }
    
    function upload(){
    //header('Content-type:application/json;charset=utf-8');
        try {
            if (
                !isset($_FILES['file']['error']) ||
                is_array($_FILES['file']['error'])
            ) {
                throw new RuntimeException('Invalid parameters.');
            }
    
            switch ($_FILES['file']['error']) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    throw new RuntimeException('No file sent.');
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    throw new RuntimeException('Exceeded filesize limit.');
                default:
                    throw new RuntimeException('Unknown errors.');
            }
        
                /*start my code*/
                $this->load->library ( "my_upload" );
                $this->load->helper('format_character');
                $pageId = xss_clean($this->input->post('pageId'));
               
                $nameAdd=$this->input->post('header-'.$this->session->userdata("activeLng")['alias']);
                
                $this->my_upload->upload ( $_FILES['file'] );
            
                $this->alias = $nameAdd=="" ? substr($this->my_upload->file_src_name_body,0,70) : $nameAdd;
                $this->alias = formatUrl($this->alias.'-'.substr(md5($this->alias),0,3). "-" . time ());
                
                $path = $_FILES['file']['name'];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                
                if($ext=="jpg" || $ext=="JPG" || $ext=="jpeg" || $ext=="JPEG" || $ext=="png" || $ext=="PNG"  || $ext=="gif" || $ext=="GIF"){
                     $this->image_upload("img");
                }else if($ext=="docx" || $ext=="doc" || $ext=="zip"  || $ext=="ppt"  || $ext=="tiff" || $ext=="xls" || $ext=="pdf" ){
                    $this->file_upload('doc');
                }else if($ext=="mp4" || $ext=="avi" || $ext=="mkv" || $ext=="webm"){
                    $this->video_upload('vid');
                }else{
                    $obj = array('error'=>'false','filename'=>'','fileid'=>'');
                    echo json_encode($obj);
                }
        /*end my code*/
                
        } catch (RuntimeException $e) {
    	   // Something went wrong, send the err message as JSON
           
        }
        
    }
    
    
    function upload_frm(){
        $this->data["pageId"]=$this->input->post('id');
        echo $this->load->view('yonet/inc/v_frm_upload',$this->data,TRUE);
        
    }
    
    
    function insert_data($table,$data){    
        $lastInsertId=$this->simple_model->insert($table,$data);
        return $lastInsertId;
    }
    
    function image_upload($typ){
        $page_id=$this->input->post("page_id");
        if ($this->my_upload->uploaded === true) {
            $this->my_upload->allowed=array('image/*');
            $this->my_upload->file_new_name_body = $this->alias;
            $this->my_upload->jpeg_quality = $this->quality;
            $this->my_upload->file_max_size = "30M";
            $this->my_upload->file_auto_rename=TRUE;
            $this->my_upload->file_overwrite = FALSE;
            //$this->my_upload->image_convert = 'jpg';
            $this->my_upload->process ( $this->file_path[$typ]);
             
            if($this->my_upload->processed){
                $fileInfo["name"] = $this->alias;
                $fileInfo["cuser"]=$this->session->userdata('id');
                $fileInfo["typ"]=$typ;
                $fileInfo["pub"]="y";
                $fileInfo["wx"]=$this->my_upload->image_dst_x;
                $fileInfo["hx"]=$this->my_upload->image_dst_y;
                $fileInfo["ext"]=$this->my_upload->file_dst_name_ext;
                $fileInfo["size"]=filesize($this->file_path[$typ].$fileInfo["name"].".".$fileInfo["ext"]);
                
                $this->load->model ( Array ('simple_model' ) );
                $last_file_id = $this->insert_data("file",$fileInfo);
                
                $this->thumb = $this->simple_model->select("thumb");
                if($page_id!=""){
                    $this->insert_data("filecross",Array("master"=>$page_id,"detail"=>$last_file_id,"position"=>"top"));
                }
                $this->load->library('my_lang');
                $translate_list=$this->my_lang->getTranslateList();
                foreach($translate_list as $tl=>$tlVal){
                    $tVal["header"]=$this->input->post('header-'.$tlVal["alias"]);
                    $tVal["content"]=$this->input->post('content-'.$tlVal["alias"]);
                    $tVal["alt"]=$this->input->post('alt-'.$tlVal["alias"]);
                    $tVal["tag"]=$this->input->post('tag-'.$tlVal["alias"]);
                    $tVal["lng"]=$tlVal["alias"];
                    $tVal["refId"]=$last_file_id;
                    if($tVal["header"]!="" || $tVal["alt"]!="" || $tVal["content"]!=""){
                        $this->insert_data("filetxt",$tVal);
                    }
                    unset($tVal);
                }
                 
                foreach ($this->thumb as $x){
                    /*thumbnail*/
                    $this->my_upload->upload ( $_FILES ["file"] );
                    $this->my_upload->file_new_name_body = $this->alias;
                    $this->my_upload->image_resize = true;
                    $this->my_upload->file_auto_rename=false;
                    $this->my_upload->file_overwrite = FALSE;
                    $this->my_upload->jpeg_quality = $this->quality;
                    $this->my_upload->image_x= $x->width;
                    $this->my_upload->image_y= $x->height;
                    $this->my_upload->image_ratio_crop = true;
                    $this->my_upload->process ( $this->file_path['img']. $x->width."x".$x->height."/");
                    $this->my_upload->processed;
                }
                $obj = array('error'=>'true','filename'=>$fileInfo["name"].".".$fileInfo["ext"],'fileid'=>$last_file_id);
            }else{
                $obj = array('error'=>'false','filename'=>'','fileid'=>'');
            }
        } else {
            $obj = array('error'=>'false','filename'=>'','fileid'=>'');
        }
        echo json_encode($obj);
    }
    
    function file_upload($typ){
        $page_id=$this->input->post("page-id");
        if ($this->my_upload->uploaded === true) {
          
            
            $this->my_upload->file_new_name_body = $this->alias;
           
            $this->my_upload->file_max_size = "20M";
            $this->my_upload->file_auto_rename=TRUE;
            $this->my_upload->file_overwrite = TRUE;
            $this->my_upload->allowed = array('application/*'); 
            $this->my_upload->process ( $this->file_path[$typ]);
             
            if($this->my_upload->processed){
                $fileInfo["name"] = $this->alias;
                $fileInfo["cuser"]=$this->session->userdata('id');
                $fileInfo["typ"]=$typ;
                $fileInfo["pub"]="y";
                $fileInfo["ext"]=$this->my_upload->file_dst_name_ext;
                $fileInfo["wx"]='';
                $fileInfo["hx"]='';
                $fileInfo["size"]=filesize($this->file_path[$typ].$fileInfo["name"].".".$fileInfo["ext"]);
                
                
                $this->load->model ( Array ('simple_model' ) );
                $last_file_id = $this->insert_data("file",$fileInfo);
                 
               
               
                if($page_id!=""){
                    $this->insert_data("filecross",Array("master"=>$page_id,"detail"=>$last_file_id));
                }
                $this->load->library('my_lang');
                $translate_list = $this->my_lang->getTranslateList();
                foreach($translate_list as $tl=>$tlVal){
                    $tVal["header"]  = $this->input->post('header-'.$tlVal["alias"]);
                    $tVal["content"] = $this->input->post('content-'.$tlVal["alias"]);
                    $tVal["alt"] = $this->input->post('alt-'.$tlVal["alias"]);
                    $tVal["tag"] = $this->input->post('tag-'.$tlVal["alias"]);
                    $tVal["lng"] = $tlVal["alias"];
                    $tVal["refId"] = $last_file_id;
                    if($tVal["header"]!="" || $tVal["alt"]!="" || $tVal["content"]!=""){
                        $this->insert_data("filetxt",$tVal);
                    }
                    unset($tVal);
                }
                 
                $obj = array('error'=>'true','filename'=>$fileInfo["name"].".".$fileInfo["ext"],'fileid'=>$last_file_id);
            }else{
                $obj = array('error'=>'false','filename'=>$fileInfo["name"].".".$fileInfo["ext"],'fileid'=>'');
            }
        } else {
             $obj = array('error'=>'false','filename'=>'','fileid'=>'');
        }
        echo json_encode($obj);
    }
    function video_upload(){
        $typ='vid';
        $page_id=$this->input->post("page-id");
        if (isset($_FILES['file'])) {
            $errors= array();
            $file_name = $this->alias;
            $file_size = $_FILES['file']['size'];
            $file_tmp = $_FILES['file']['tmp_name'];
            $file_type = $_FILES['file']['type'];
            $file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));
            if($file_size < 300097152) {
                $errors[]='File size must be excately 2 MB';
                if(move_uploaded_file($file_tmp,"video/".$file_name.'.'.$file_ext)){
                    
                    $video = $path . escapeshellcmd($_FILES['file']['name']);
                    $cmd = "ffmpeg -i $video 2>&1";
                    $second = 1;
                    if (preg_match('/Duration: ((\d+):(\d+):(\d+))/s', `$cmd`, $time)) {
                        $total = ($time[2] * 3600) + ($time[3] * 60) + $time[4];
                        $second = rand(1, ($total - 1));
                    }
                    
                    $image  = 'video/'.$this->alias.'.jpg';
                    $cmd = "ffmpeg -i $video -deinterlace -an -ss $second -t 00:00:01 -r 1 -y -vcodec mjpeg -f mjpeg $image 2>&1";
                    $do = `$cmd`;
                    
                    $fileInfo["name"] = formatUrl($this->alias);
                    $fileInfo["cuser"]=$this->session->userdata('id');
                    $fileInfo["typ"]=$typ;
                    $fileInfo["pub"]="y";
                    $fileInfo["ext"]=$file_ext;
                    $fileInfo["size"]=filesize($this->file_path[$typ].$fileInfo["name"].".".$fileInfo["ext"]);
                    $fileInfo["position"]="top";
            
                    $last_file_id = $this->insert_data("file",$fileInfo);
                     
                    $this->load->model ( Array ('simple_model' ) );
                    $this->thumb = $this->simple_model->select("thumb");
                    if($page_id!=""){
                        $this->insert_data("filecross",Array("master"=>$page_id,"detail"=>$last_file_id));
                    }
                    $this->load->library('my_lang');
                    $translate_list=$this->my_lang->getTranslateList();
                    foreach($translate_list as $tl=>$tlVal){
                        $tVal["header"]  = $this->input->post('header-'.$tlVal["alias"]);
                        $tVal["content"] = $this->input->post('content-'.$tlVal["alias"]);
                        $tVal["alt"] = $this->input->post('alt-'.$tlVal["alias"]);
                        $tVal["tag"] = $this->input->post('tag-'.$tlVal["alias"]);
                        $tVal["lng"] = $tlVal["alias"];
                        $tVal["refId"] = $last_img_id;
                        if($tVal["header"]!="" || $tVal["alt"]!="" || $tVal["content"]!=""){
                            $this->insert_data("filetxt",$tVal);
                        }
                        unset($tVal);
                    }
                     
                    echo json_encode(['status' => 'ok','path' => $this->file_path[$typ]]);
                }else{
                    echo json_encode(['status' => 'error','path' => $this->file_path[$typ]]);
                }
            } else{
                echo json_encode(['status' => 'error','path' =>'file_size']);
            }
        } else {
            echo json_encode(['status' => 'error','path' => $e->getMessage()]);
        }
    }
 
    /*page tablosundaki sayfalara bagli olan img doc vid gibi multimedia doyalarını getiren ve arattıran fonksiyon.*/
    function attachment(){
        $page_id  = (int) $this->input->post('id');
        $typ = $this->input->post('typ');
        
        $this->data["form"]['id'] =form_hidden("attachment-id",$page_id);
        $this->data["form"]['typ']=form_hidden("attachment-typ",$typ);
        $this->load->model(Array('file_model','yonet/page_model'));
        $page_lng=$this->page_model->get_value($page_id)[lng];
        
        $this->data["typ"]=$typ;
        $this->data["master"]=$page_id;
        /*bagli olan dosyalar*/
        $this->data['file_list']=$this->file_model->file_list_for_page(Array('filecross.master'=>$page_id,'file.typ'=>$typ),$page_lng);
       
        $this->data['file_list_html']=$this->load->view('yonet/module/v_file_list',$this->data,TRUE);
         
        echo $this->load->view('yonet/module/v_attachment_file',$this->data,TRUE);
    }
    
    /*file tablosundan img doc ve vid dosyalarini aramada kullanilir, 
     * page.id->filecross.master 
     * file.id->filecross.detail*/
    function attachment_search(){
        
        $key = trim(xss_clean($this->input->post('key')));//aranacak anahtar
        $typ = trim(xss_clean($this->input->post('typ')));//tip
        $id  = (int) $this->input->post('id');//dosyanin baglanacagi master id
        $this->load->model(Array('file_model','yonet/page_model'));
        $page_lng=$this->page_model->get_value($id)[lng];
       
        $result=$this->file_model->search_file(Array('file.typ'=>$typ),$key,$page_lng);
        if($typ=="img"){   
            
            foreach ($result as $x=>$y){
                echo '<div class="thumb-search-image-add" onclick="setAttachmentFile('.$y["file_id"].','.$id.')">'.
                img("image/200x180/".$y["name"].".".$y["ext"],"",'class="getImageId-'.$y["file_id"].'"').
                '<div><span class="pull left">'.substr($y["header"],0,25).'</span></div>'.
                '</div>';
               // '<input type="text" class="form-control order-filecross-'.$y['filecross_id'].'">'.
            }
        }else if($typ=="doc"){
            foreach ($result as $x=>$y){
                echo '<div class="thumb-search-image-add" onclick="setAttachmentFile('.$y["file_id"].','.$id.')">'.
                    img("img/thumb/".$y["ext"].'.png','','class="getImageId-'.$y["file_id"].'"').
                    '<div><span class="pull left">'.substr($y["header"],0,25).'</span></div>'.
                    '</div>';
                // '<input type="text" class="form-control order-filecross-'.$y['filecross_id'].'">'.
            }
        }else if($typ=="vid"){
            
        }
        
    }
    
    /*sayfaya bir img doc vid  baglamak icin calistirilir. gelen veri page.id(master) file.id(detail)*/
    function add_attachment(){
        $master = trim(xss_clean($this->input->post('master')));//sayfa id si
        $detail = trim(xss_clean($this->input->post('detail')));//resim idsi
        $this->load->model(Array('simple_model','yonet/page_model','file_model'));
        $page_lng = $this->page_model->get_value($master)[lng];
       
        $select = $this->simple_model->selectValue('file',Array('id'=>$detail))[0];
        if($select['name'] !=""){
            $this->data["master"]=$master;
            $this->data["typ"]=$select["typ"];
            $last_cross_id = $this->simple_model->insert('filecross', Array('master'=>$master,'detail'=>$detail,'position'=>'top') );
            $this->data['file_list']=$this->file_model->file_list_for_page(Array('filecross.id'=>$last_cross_id),$page_lng);
             
            echo $this->load->view('yonet/module/v_file_list',$this->data,TRUE);
        }
    }
    
    /*sayfaya baglanan bir img doc vid  kaldirmak icin calistirilir. gelen veri pagecross.id*/
    function remove_attachment(){
        $id = trim(xss_clean($this->input->post('id')));
        if($this->simple_model->delete('filecross',Array('id'=>$id))){
            echo "Resmin Sayfa İle İlişiği Kesildi";
        }else{
            echo 'Hata : Resmin Sayfa ile ilişiği kesilemedi.';
        }
    }
    
    function deleteid(){
        $fileId = $this->input->post('id');
        
        $this->load->model ( Array ('simple_model' ) );
        $this->simple_model->delete('filecross',Array('detail'=>$fileId));
        $this->simple_model->delete('filetxt',Array('refId'=>$fileId));
        $fileInfo = $this->simple_model->selectValue('file',Array('id'=>$fileId));
        $fileInfo = $fileInfo[0];
        $fileName= './'.$this->file_path[$fileInfo['typ']].$fileInfo['name'].'.'.$fileInfo['ext'];
        
        unlink($fileName);
        $this->simple_model->delete('file',Array('id'=>$fileId));
        
        
    }
}