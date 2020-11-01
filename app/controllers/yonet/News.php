<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class news extends CI_Controller {
	public $data;
	public $frmVal=array("url"=>"","header"=>"","img"=>"","order"=>"","content"=>"","pub"=>"y");
	public $width="200";
	public $height="150";
	public $quality=20;
	public $imgPath="./../images/_news/";
	public $fname="../json/news_json.php";
	public $limit_page=5;
	public $radio = Array("1"=>"img/admin/1.jpg" , "2"=>"img/admin/2.jpg"  , "3"=>"img/admin/3.jpg", "4"=>"img/admin/4.jpg", "5"=>"img/admin/5.jpg");

	
	public function __construct(){
	    parent::__construct();
	    $this->load->library ( Array('logincheck','user_agent') );
	    $this->load->model ( Array('simple_model') );
	    $this->load->helper(Array('password','form'));
	    $this->logincheck->check();
	    $this->my_lang->getSessionLng();
	}
	
    function news_list($id="all",$order="cdate-desc-position",$page="0"){
	    if($page==""){	$page=0;  }
	    
	    $this->data['frm']   = $this->session->flashdata('data');//önceden girilmiş form verileri alınıyor 
	    $this->data['error'] = $this->session->flashdata('error');// varsa hata yada yapilmis islem sonucu
	    
	    
	    $orderArr=explode("-",xss_clean($order));
	    $where['lng'] = $this->session->userdata("activeLng")["alias"];
	    if($orderArr[2]!="position" && $orderArr["2"]!=""){
	        $where['news.position'] = $orderArr[2];
	        $position=$orderArr[2];
	    }else{
	        $position="position";
	    }
	    
	    if($orderArr[1]=="desc"){    $reverse="asc";   }else{     $reverse="desc"; }
	   
	    $this->load->model(Array("simple_model",'yonet/news_model'));
		
	   
		if($id=="" or $id=="all"){
		    $this->data["inc_page_header"]='YENİ DUYURU EKLE';
		}else{
		    $news = $this->simple_model->selectWhere("news",Array("id"=>$id))->result_array();
		    $this->data["frm"] = $news[0];
		    $this->data["inc_page_header"]='SEÇİLİ DUYURUYU GÜNCELLE';
		    $id=(int) $id;
		    /*guncellenecek icerik verisi cekiliyor*/
		    
		    /*guncellenecek icerigin secili resmi ataniyor*/
		    $img= $this->simple_model->selectWhere("file",Array("id"=>$this->data['frm']['img']))->result_array();
		    $this->data["img_selected_html"]='<div class="selectedNewsImg"><b>Seçili Haber Resmi</b><br><img src="'.base_url('image/150x150/'.$img[0]["name"].".".$img[0]["ext"]).'"></div>';
		}
		
		/*sayfa yonlendirme linkleri icin ayarlar*/
		$this->data["linkAdd"]["order"]=$orderArr[0]."-".$reverse;
		$this->data["linkAdd"]["reverse"]=$reverse;
		$this->data["linkAdd"]["id"]= $id == "" ? "all":$id;
		$this->data["linkAdd"]["page"]= $page;
		$this->data["linkAdd"]["position"]= $position;
		$this->data["linkAdd"]["fix"]= $orderArr[0].'-'.$orderArr[1].'-'.$position.'/'.$page;
	   	   
		$this->data["list"]=$this->news_model->selectLimitJoin($this->limit_page,$page,$where,$orderArr[0],$orderArr[1]);
		
		$listSize= $this->simple_model->selectCount("news",$where);
		$this->data["area"]=xss_clean($area);
		$this->data["listDate"]=xss_clean($order);
		$this->news_frm($id);
		
		
		
		
		$this->data["pageLinks"] = $this->createPagination($listSize,$id.'/'.$orderArr[0]."-".$orderArr[1].'-'.$position,$page,$area);
		$this->data["count"]     = $page;
		$this->data["order"]     = $order;
		$this->data["page"]      = $page;
		
		
		
		$this->data["radio"]=$this->radio;
		$this->my_lang->singleTranslateLng($this->session->userdata('activeLng')['alias']);
		
		$this->data['page_options']=$this->load->view('yonet/module/v_page_options',$this->data,TRUE);
		$this->data['menu']=$this->load->view('yonet/inc/v_sidebar','',TRUE);
		$this->data['page']=$this->load->view('yonet/inc/v_news',$this->data,TRUE);
		$this->data['footer']=$this->load->view('yonet/inc/v_footer','',TRUE);
		$this->load->view('yonet/v_home',$this->data);
		session_write_close();
	}
	


	function news_frm($id=""){
	    $frm=$this->data["frm"];
	    if($frm['pub']=="y"){
	        $checked='checked="checked"';
	    }
		$this->data ["form"] ["open"]  	  = form_open_multipart ( 'yonet/news/save' );
		$this->data ["form"] ["url"] 	  = form_input ( 'url',htmlspecialchars_decode($frm['url'],ENT_QUOTES),'class="form-control"' );
		$this->data ["form"] ["header"]   = form_input ( 'header',htmlspecialchars_decode($frm['header'],ENT_QUOTES),'class="form-control"' );
		$this->data ["form"] ["flash"] 	  = form_input ( 'flash',htmlspecialchars_decode($frm['flash'],ENT_QUOTES),'class="form-control"' );
		$this->data ["form"] ["content"]  = form_input ( 'text',htmlspecialchars_decode($frm['text'],ENT_QUOTES),'class="form-control"' );
		$this->data ["form"] ["order"] 	  = form_input ( 'order',$frm['order'],'id="order" class="form-control" style="width:45px;"' );
		$this->data ["form"] ["pub"] 	  = form_checkbox ( 'pub',"y",$checked );
		$this->data ["form"] ["id"] 	  = form_hidden ( 'id',$id );
		$this->data ["form"] ["img"] 	  = form_hidden ( 'img',$frm['img'] );
		$this->data ["form"] ["lng"] 	  = form_hidden ( 'lng',$this->session->userdata('activeLng')["alias"] );
		$this->data ["form"] ["table"] 	  = form_hidden ( 'frm-table',"news");
		$this->data ["form"] ["submit"]   = form_submit ( 'submit',"Kaydet",'id="newsSubmitButton" class="form-control btn-success pull-right"' );
		$this->data ["form"] ["close"]    = form_close ();
	}
	
	function save($master="",$id=""){
		
		$this->load->helper('format_character');
		
				
		if($_POST){
		   
			/*form verileri cekiliyor*/
			$this->load->library('form_validation');
			$this->form_validation->set_rules ( 'url', "Url", "required|trim|regex_match[/^[a-zA-Z0-9\s\-\_:.#\/]+$/]|strip_tags|xss_clean|min_length[0]|max_length[255]" );
			$this->form_validation->set_rules ( 'header', "Başlık", "required|trim|strip_tags|xss_clean|min_length[3]|max_length[250]" );
			$this->form_validation->set_rules ( 'flash', "FlashText", "strip_tags|xss_clean|min_length[3]|max_length[75]" );
			$this->form_validation->set_rules ( 'text', "Kısa Metin", "trim|strip_tags|xss_clean|min_length[3]|max_length[255]" );
			$this->form_validation->set_rules ( 'order', "Sıra", "trim|strip_tags|xss_clean|regex_match[/^[0-9]+$/]" );
			$this->form_validation->set_rules ( 'pub', "Yayın", "trim|strip_tags|xss_clean" );
			$this->form_validation->set_rules ( 'id', "Haber Id", "strip_tags|xss_clean" );
			$this->form_validation->set_rules ( 'position', "Konum", "required|strip_tags|xss_clean" );
			$this->form_validation->set_rules ( 'img', "Resim Seçimi", "required|strip_tags|xss_clean" );
			$this->form_validation->set_rules ( 'lng', "Dil", "required|strip_tags|xss_clean" );
			
			$error = $this->form_validation->run ();
			
			$this->data["url"]=set_value("url");
			$this->data["header"]=set_value("header");
			$this->data["flash"]=set_value("flash");
			$this->data["text"]=set_value("text");
			$this->data["order"]= set_value("order");
			$this->data["pub"]=set_value("pub");
			$this->data["position"]=set_value("position");
			$this->data["img"]=set_value("img");
			$this->data["lng"]=set_value("lng");
			$id=set_value("id");
			$id = $id=="all"? "": (int) $id;
			if($this->data["pub"]!="y"){
				$this->data["pub"]="n";
			}
			
			if($error){
				$this->load->model("simple_model");
				
				if($id==""){
				  
				    if($this->data["img"]==""){
				        $error=Array('txt'=>'Hata;resim seçimi yapmadınız! Lütfen Resim seçimi yapınız!','logic'=>'false');
				        redirect(adminbase('news/news_list'));
				    }else{
				        
    					$id=$this->simple_model->insert("news",$this->data);
    						$error=Array('txt'=>'Haber Kaydedildi.','logic'=>'true');
    				
				    }
				}else{
					if($this->simple_model->updateWhere("news",$this->data,Array("id"=>$id)))
						$error=Array('txt'=>'Haber Güncellendi.','logic'=>'true');
				}
			}else{
				$error=Array('txt'=>validation_errors(),'logic'=>'false'); ;
				
			}
			
			$this->session->set_flashdata("data",$this->data);
		}
		$this->session->set_flashdata('error',$error);
		//$this->news_json($id);
		redirect(adminbase('news/news_list/'.$id));
	}
	
	
	function menuImgUpload(){
		$this->load->library ( "My_upload" );
		$this->load->helper('format_character');
		
		$this->my_upload->upload ( $_FILES ["upl"] );
		$imgName=formatUrl(mb_substr(mb_strtolower($this->data["newsHeader"]),0,70)."-".time());
		if ($this->my_upload->uploaded === true) {
				$this->my_upload->file_new_name_body = $imgName;
				$this->my_upload->image_resize = true;
				$this->my_upload->jpeg_quality = $this->quality;	
				$this->my_upload->image_x= $this->width;
				$this->my_upload->image_y= $this->height;
				$this->my_upload->image_ratio_crop = true;
				$this->my_upload->image_convert = 'jpg';
				$this->my_upload->process ( $this->imgPath);
				if($this->my_upload->processed){
					return $this->my_upload->file_dst_name;
				}else{
					return false;
				}
		}
	}
	
	function createPagination($listSize,$order,$start,$area){
	   
		 $this->load->library('pagination');
		 $config['base_url'] = adminbase("news/news_list/".$area."/".$order."/");
		 $config['total_rows'] = $listSize;
		 $config['per_page'] = $this->limit_page;
		 $config['uri_segment']=6;
		 //$config['use_page_numbers'] = TRUE;
		 $this->pagination->initialize($config);
		 $pageLinks=$this->pagination->create_links();
		 return $pageLinks;
	}
	
	
	function ajaxPublished(){
		$this->load->model("simple_model");
		$id = xss_clean( $this->input->post("id") );
		$pub = xss_clean($this->input->post("pub"));
		$where = array("newsId"=> $id);
			if($this->simple_model->updateWhere("news",Array("newsPub"=>$pub),$where))	
				echo "değiştirildi";
			else
				echo "değiştirilemedi";
	}
	
	function news_delete(){
	    $id = $this->input->post('id');
        if( is_numeric($id)){
		
			
                  
                   if($this->simple_model->delete('news',Array('id'=>$id))){
                       
                        echo 'true';
                   }else{
                       echo 'false';
                   }
                   
		}
		//redirect(base_url("news/newsList/".xss_clean($area)."/".$order."/".$page));
	}
	
}