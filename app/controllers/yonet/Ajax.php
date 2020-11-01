<?php
class ajax extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->library ( Array('logincheck','user_agent') );
        $this->load->model ( Array('simple_model') );
        $this->load->helper(Array('password','form'));
        $this->logincheck->check();
    }
    
    /* dile göre sayfa urlsi  varmi yokmu diye  kontrol eder*/
    public function url_check()
    {
        $url = $this->input->post('url');
        $id = $this->input->post('id');
        $lng = $this->input->post('lng');
        if($id!=""){
            if($this->simple_model->selectCount("page",Array("url"=>$url,"id <>"=>$id,'lng'=>$lng))){
                $isAvailable = false;
            }else{
                $isAvailable = true; // or false
            }
        }else{
            if($this->simple_model->selectCount("page",Array("url"=>$url,'lng'=>$lng))){
                $isAvailable = false;
            }else{
                $isAvailable = true; // or false
            } 
        }
       
        // Finally, return a JSON
        echo json_encode(array(
            'valid' => $isAvailable,
        ));
    }
    
    /*yonetim sisteminde goruntulenecek iceriklerin dili seciliyor*/
    public function change_lng($lng){
        if(strlen($lng<4)){
        $this->my_lang->changeAdminLng($lng);
        redirect($_SERVER['HTTP_REFERER']);
        }
    }
    
    /*page typ cat baglama formu cagirir*/
    function page_frm_load(){
        $this->load->model ( Array ('simple_model') );
        /*cagrilacak  formun hangi sayfaya  baglanacaginin id-si adi*/
        $pageId  = xss_clean($this->input->post('id'));
        $frm     = xss_clean($this->input->post('frm'));
        
        $values  = $this->simple_model->selectedValues('page',Array('id'=>$pageId));/*gelen id degeri datadan cekiliyor*/
        $this->load->library('my_page_cat');
        $list=$this->my_page_cat->listArray($values->lng);
        if($values->typ=="cat"){
        $frmVal["options"]=Array(""=>"Ana Kategori Yap") + $this->my_page_cat->selectBoxList($list,$pageId);
        }else if($values->typ=="con"){
            $frmVal["options"]=Array(""=>"Hiçbir kategoriyle ilişkilendirme") + $this->my_page_cat->selectBoxList($list,$pageId);
        }
        $frmVal["options"]=Array(""=>"Ana Kategori Yap") + $this->my_page_cat->selectBoxList($list,$pageId);
        $crossValue=$this->my_page_cat->getPagecrossValues($values->id)[0];/*pagecross tablosundaki veri çekiliyor*/
        $frmVal["options"][$crossValue["master"]]=$frmVal["options"][$crossValue["master"]]." (seçili)";/* varsa */
        
        //unset($frmVal["options"][$values->id]);
        $frmVal['pageId']=$values->id;
        $frmVal['id']=$crossValue["id"];
        $frmVal['typ']=$values->typ;
        $frmVal["selected"]=$crossValue["master"];
        $frmVal["frmName"]= $crossValue["master"];
        $this->page_cross_frm($frmVal); 
    }
    
    /*page  tablosunda typ con(content) yada cat olan veriyi  klasore fol baglamak icin form*/
    function page_cross_frm($frmVal){
        $this->load->helper('form');
        echo '<h4>Kategoriye Bağla</h4>'; 
        echo form_open ( '','id="crossFrm"' );
        echo form_dropdown ( 'master',$frmVal["options"],$frmVal["selected"],"id=\"master\"");
        echo form_hidden ( 'detail',$frmVal['pageId'] );
        echo form_hidden ( 'id',$frmVal['id'] );
        echo form_hidden ( 'typ',$frmVal['typ'] );
        echo form_hidden ( 'pageId',$frmVal['pageId'] );
        echo form_button ( 'kaydet', "Kaydet",'class="btn btn-primary" onclick="pagecross()"' );
        echo form_close ();
    }
    /*page  tablosunda typ con(content) yada cat olan veriyi  klasore fol baglamak icin form islemi*/
    function pagecross_proccess(){
        $id     = (int) xss_clean($this->input->post('id'));
        $pageId = (int) xss_clean($this->input->post('pageId'));
        $typ    = xss_clean($this->input->post('typ'));
        $master = xss_clean($this->input->post('master'));
        $detail = xss_clean($this->input->post('detail'));
        if($master==""){
             $this->db->delete("pagecross",Array("typ"=>$typ,"detail"=>$detail,"id"=>$id));
             exit;
        }
        
        if($id!=""){
            if($this->db->update("pagecross",Array("master"=>$master,"detail"=>$detail,"typ"=>$typ),Array("id"=>$id))){
                echo "Veri Güncellendi";
            }else{
                echo "Hata Bilgi Güncellenemedi.";
            }
        }else{
            if($this->db->insert("pagecross",Array("master"=>$master,"detail"=>$detail,"typ"=>$typ))){
                echo "Veri Kategoriye Bağlandı";
            }else{
                echo "Bağlanamadı.";
            }
        }
    }
    
    function publish_update(){
        $id    = (int) xss_clean($this->input->post('id'));
        $table = xss_clean($this->input->post('table'));
        $pub =  xss_clean($this->input->post('pub'));
        if($pub=='y' || $pub=='n')
        $this->db->update($table,array('pub'=>$pub),array('id'=>$id));
    }
    
    
    function delete(){
        
    }
    
    /*tablolarda sira degeri atama or:page.order news.order*/
    function list_order(){
        $id    = (int) xss_clean($this->input->post('id'));
        $table = xss_clean($this->input->post('table'));
        $order = (int) xss_clean($this->input->post('order'));
        $order = ($order == 0) ? NUll : $order;
        $this->db->update($table,array('order'=>$order),array('id'=>$id));
        echo $order;
    }
    
    /*konum degeri atama*/
    function position_update(){
        $id    = (int) xss_clean($this->input->post('id'));
        $table = xss_clean($this->input->post('table'));
        $position = (int) xss_clean($this->input->post('position'));
        $this->db->update($table,array('position'=>$position),array('id'=>$id));
    }
    
    function img_upload_frm(){
        $this->data['page']=$this->load->view('yonet/inc/v_frm_upload',$this->data,TRUE);
    }
    
    
    /*news tablosuna baglanacak olan image atamasi*/
    function search_image_for_news(){
        //aranacak anahtar kelime
       $key=xss_clean($this->input->post('key'));
        /*baglanacak tablo*/
       
        /*baglanacak id */
       $table=$this->input->post('id');
       $this->load->model('file_model');
      
       $result=$this->file_model->search_file(Array('file.typ'=>"img"),$key,$this->session->userdata('activeLng')['alias']);
       foreach ($result as $x=>$y){
           echo '<div class="col-lg-12 thumb-search-image" onclick="setImageNews('.$y["file_id"].')">'.img("image/200x180/".$y["name"].".".$y["ext"],"",'class="getImageId-'.$y["file_id"].'"').'</div>';
           
       }
       
    }
}