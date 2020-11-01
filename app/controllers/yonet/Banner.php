<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class banner extends CI_Controller {
	public $data;
	public $frmVal=array("url"=>"","header"=>"","img"=>"","order"=>"","content"=>"","pub"=>"y");

	public $quality=100;

	public $limit_page=5;
	public $radio = Array("1"=>"img/admin/1.jpg" , "2"=>"img/admin/2.jpg"  , "3"=>"img/admin/3.jpg", "4"=>"img/admin/4.jpg", "5"=>"img/admin/5.jpg");

	public $bannerFile ="";
	public $bannerImgPath ="image/banner/";
	
	public $bannerH=600;
	public $bannerW=1090;
	public $obj;
	
	
	public function __construct(){
	    parent::__construct();
	    $this->load->library ( Array('logincheck','user_agent') );
	    $this->load->model ( Array('simple_model') );
	    $this->load->helper(Array('password','form'));
	    $this->logincheck->check();
	    $this->my_lang->getSessionLng();
	    $this->bannerFile = './json/'.$this->session->userdata('activeLng')['alias'].'_banner.json';
	}
	function index($id=""){
	    $lng=$this->session->userdata('activeLng');
	    $this->data['error']= $this->session->flashdata('error');
	    
	    
	    $this->jsonRead($this->bannerFile);
	    
	    $this->frmVal=$this->obj[$id];
	    if(!$this->data['error']["logic"]){
	       $this->frmVal=$this->session->flashdata('frm');
	         
	    }
	   
	    if($id==""){
	        $this->data["inc_page_header"]="YENİ UST BANNER EKLE";
	        $this->frmVal["lcheck"]=TRUE;
	    }else{
	        $this->data["inc_page_header"]="BANNER'I DÜZENLE";
	        $this->data["title"]="Banneri Duzenle";
	        if($this->obj[$id]["position"]=="l")
	            $this->frmVal["lcheck"]=TRUE;
	        else if($this->obj[$id]["position"]=="r")
	            $this->frmVal["rcheck"]=TRUE;
	        else if($this->obj[$id]["position"]=="c")
	            $this->frmVal["ccheck"]=TRUE;
	
	        $this->frmVal["id"]=$id;
	    }
	  
	    $this->data["list"]=$this->obj;
	    $this->create_frm();
	
	    $this->my_lang->singleTranslateLng($this->session->userdata('activeLng')['alias']);
        $this->data['page_options'] = $this->load->view('yonet/module/v_page_options',$this->data,TRUE);
	    $this->data['menu']=$this->load->view('yonet/inc/v_sidebar','',TRUE);
		$this->data['page']=$this->load->view('yonet/inc/v_banner',$this->data,TRUE);
		$this->data['footer']=$this->load->view('yonet/inc/v_footer','',TRUE);
		$this->load->view('yonet/v_home',$this->data);
		session_write_close();
	}
	
	function create_frm(){
	    $this->data ["form"] ["open"]   = form_open_multipart ( adminbase('banner/save') );
	    $this->data ["form"] ["url"] 			= form_input ( 'url',$this->frmVal['url'],'class="form-control"' );
	    $this->data ["form"] ["header"] 			= form_input ( 'header',$this->frmVal['header'],'class="form-control"' );
	    $this->data ["form"] ["linktext"] 			= form_input ( 'linktext',$this->frmVal['linktext'],'class="form-control"' );
	    $this->data ["form"] ["order"] 			= form_input ( 'order',$this->frmVal['order'],'class="form-control"' );
	    $this->data ["form"] ["radio"] 			= form_radio ( "position","l",$this->frmVal["lcheck"]);
	    $this->data ["form"] ["radio2"] 			= form_radio ( "position","r",$this->frmVal["rcheck"],'');
	    $this->data ["form"] ["radio3"] 			= form_radio ( "position","c",$this->frmVal["ccheck"],'');
	    $this->data ["form"] ["target"]    = form_dropdown ('target',Array("_blank"=>"Yeni Sayfada","self"=>"Bulunduğu Sayfada"),$target,"class=\"selectDown\"");
	    $this->data ["form"] ["id"] 			= form_hidden ( 'id',$this->frmVal['id'] );
	    $this->data ["form"] ["submit"] 		= form_submit ( 'submit',"kaydet",'class="form_control"' );
	    $this->data ["form"] ["close"]  = form_close ();
	}
	
	
	function save(){
	    $frm=Array();
	    $lng=$this->session->userdata('activeLng')['alias'];
	    /*form verileri cekiliyor*/
	    $frm["url"]      = xss_clean( $this->input->post('url')  );
	    $frm["header"]   = xss_clean( $this->input->post('header')  );
	    $frm["linktext"] = xss_clean( $this->input->post('linktext')  );
	    $frm["target"]   = xss_clean( $this->input->post('target')  );
	    $frm["order"]    = xss_clean( $this->input->post('order')  );
	    $frm["position"] = xss_clean( $this->input->post('position')  );
	    $id  = xss_clean($this->input->post('id')  );
	     
	    /*banner sirasi kontrol ediliyor*/
	    if(!is_numeric( $frm["order"])){
	        $this->session->set_flashdata("error",Array('txt'=>'Hata:Sıra Numarası Sayı Olmalı','logic'=>false));
	        $this->session->set_flashdata("frm",$frm);
	        redirect(adminbase('banner/index'));
	    }
	    $this->jsonRead($this->bannerFile);
	     
	    /*dosya kontrolu icin file verisi aliniyor*/
	    $check = getimagesize($_FILES["upl"]["tmp_name"]);
	     
	    /*$id banner idsinin varligi ile ilk giris yada guncellememi kontrolu yapiliyor*/
	    if($id==""){
	        /* resim dosyasi  varmi yokmu kontrol ediliyor*/
	        if($check !== false) {
	            /**resim dosyasi yukleniyor*/
	            $frm["imageName"] = $this->bannerImgUpload( $frm["linktext"]);
	             
	            /**banner icin json dosyasi bosmu dolumu ona bakiliyor*/
	            if(!empty($this->obj)){
	                array_push($this->obj,$frm );
	            }else{
	                $this->obj[0]=$frm;
	            }
	           
	        }else{
	            /*banner yukleme zorunlu oldugundan dosya secilmedi hatasi  donuyor*/
	            $this->session->set_flashdata("error",Array('txt'=>'Hata:Lütfen bir dosya seçin.','logic'=>false));
	            $this->session->set_flashdata("frm",$frm);
	            redirect(adminbase('banner/index'));
	            exit;
	        }
	        
	    }else{
	        /* resim dosyasi  guncellenip guncellenmedigine bakiliyor*/
	        if($check !== false) {
	            /*guncelleme sirasinda eski dosyayi siliyor*/
	            unlink("image/banner/".$this->obj[$id]["imageName"]);
	            /*yeni  resim dosyasinin  ismi*/
	            $frm["imageName"] = $this->bannerImgUpload( $frm["linktext"]);
	             
	        }else{
	            /*resim dosyasi olmadigi icin eski resm dosyasini koruyor*/
	            $frm["imageName"]=$this->obj[$id]["imageName"];
	        }
	        /*guncellenecek resim dosyasi bilgileri json objesine ekleniyor*/
	        $this->obj[$id]=$frm;
	    }
	    /*json dosyasina veriler kaydediliyor....*/
	    $this->jsonWrite($this->obj,$this->bannerFile);
	     
	    redirect(adminbase('banner/index'));
	}
	
	function banner_del($id){
	    $id = xss_clean($id);
	    $this->jsonRead($this->bannerFile);
	
	    unlink('image/banner/'.$this->obj[$id]["imageName"]);
	    unset($this->obj[$id]);
	    $this->jsonWrite($this->obj,$this->bannerFile);
	    redirect(adminbase('banner/index'));
	}
	function jsonRead($file){
	    $this->jsonContent = file_get_contents($file);
	    if($this->jsonContent!=""){
	        $this->obj= json_decode($this->jsonContent,true);// sondaki true dizinin array olacagini belirtir.
	    }else{
	        $this->jsonWrite(false);
	    }
	    //$f = fopen($this->fname,"w+");
	    //fwrite( $f, json_encode($this->obj));
	    //fclose( $f );
	}
	
	function jsonWrite($val,$file){
	    $f=fopen($file,"w+");
	    $this->obj = $val;
	    fwrite( $f, json_encode($this->obj));
	    fclose( $f );
	}
	
	function bannerImgUpload($fileName){
	    $this->load->library ( "my_upload" );
	    $this->load->helper('format_character');
	
	    $this->my_upload->upload ( $_FILES ["upl"] );
	    $imgName=formatUrl(substr($fileName,0,15))."_" .date("d-m-Y");
	    if ($this->my_upload->uploaded === true) {
	        $this->my_upload->file_new_name_body = $imgName;
	        $this->my_upload->image_resize = true;
	        $this->my_upload->jpeg_quality = 100;
	        $this->my_upload->image_x= $this->bannerW;
	        $this->my_upload->image_y= $this->bannerH;
	        $this->my_upload->image_ratio_crop = false;
	        $this->my_upload->image_convert = false;
	        $this->my_upload->process ( $this->bannerImgPath);
	        if($this->my_upload->processed){
	            return $this->my_upload->file_dst_name;
	        }else{
	            $this->session->set_flashdata("error",Array('txt'=>'Dosya Yükleme Hatası','logic'=>false));
	            return false;
	        }
	    }
	}
}