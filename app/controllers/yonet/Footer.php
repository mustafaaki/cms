<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class footer extends CI_Controller {
    public $footer_file="footer.json";
    public $json_file;
	public $jsonContent;
	public $data;
    public $frmVal;
    public $footerDefaulObj = Array('footerSign'=>Array(),"footerLinkCat"=>Array());
    
    public function __construct()
	{  /*onceki sinifin degerleri bu sinifa uygulaniyor*/
	    parent::__construct();
	    /*oturum acmak icin class yukleniyor*/
    	$this->load->library ( Array('form_validation','logincheck') );
    	$this->load->helper(Array('password','form'));
    	$this->load->model(Array('yonet/template_model','simple_model'));
    	/*kullanici girisi kontrolu*/
    	$this->logincheck->check();
    	$this->my_lang->getSessionLng();
    	$this->json_file= './json/'.$this->session->userdata('activeLng')['alias'].'_'.$this->footer_file;
	}
	
	/*footer  imza ve copyright kısmı yazısı end */
	/*footer link oluşturma started*/
	function link_cat($catId="",$linkId=""){
	    $this->data['error']= $this->session->flashdata('error');
        $catId = xss_clean($catId);
       
	    $this->data['error']= $this->session->flashdata('error');
	    $this->jsonRead($this->json_file);
	   
        if($catId!="" && $linkId!=""){
            $this->data['inc_page_header']="Foter için Categori Düzenle.";
        }else if($catId!="" && $linkId==""){
            $this->data['inc_page_header']="Foter için Alt Link Oluştur.";
        }else if($catId=="" && $linkId==""){
            $this->data['inc_page_header']="Footer Link Gurupları";
        }
	    $this->data["footerCatList"]=$this->obj["footerLinkCat"];
        $name= $this->obj["footerLinkCat"][$catId]["name"];
        $order= $this->obj["footerLinkCat"][$catId]["order"] ;
	    $this->cat_frm($catId,$name,$order);
	    
	    if($catId!="" && is_numeric($catId)){
	        
	        $url=$this->obj["footerLinkCat"][$catId]["footerLinks"][$linkId]["url"];
	        $urlName = $this->obj["footerLinkCat"][$catId]["footerLinks"][$linkId]["urlName"];
	        $urlOrder= $this->obj["footerLinkCat"][$catId]["footerLinks"][$linkId]["urlOrder"];
	        $target =$this->obj["footerLinkCat"][$catId]["footerLinks"][$linkId]["target"];
	        $this->link_frm($catId,$linkId,$url,$urlName,$urlOrder,$target);
	        $this->data["catTitle"] = $this->obj["footerLinkCat"][$catId]["name"] . " isimli kategori başlığını düzenleyin";
	    }else{
	       $this->data["catTitle"] = "Yeni kategori oluşturun";
	    }
	    $this->data["catId"]=$catId;
	    
	    $this->my_lang->singleTranslateLng($this->session->userdata('activeLng')['alias']);
	   
        $this->data['page_options']=$this->load->view('yonet/module/v_page_options',$this->data,TRUE);
        
        $this->data['menu']=$this->load->view('yonet/inc/v_sidebar','',TRUE);
        $this->data['page']=$this->load->view('yonet/inc/v_footer_link',$this->data,TRUE);
        $this->data['footer']=$this->load->view('yonet/inc/v_footer','',TRUE);
        $this->load->view('yonet/v_home',$this->data);
	    
	}
	
	function cat_frm($catId="",$name="",$order=""){
		$this->data ["formCat"] ["open"]   = form_open_multipart ( adminbase('footer/cat_save') );
		$this->data ["formCat"] ["name"]   = form_input ( 'name',$name,'class="form-control"' );
		$this->data ["formCat"] ["order"]  = form_input ( 'order',$order,'class="form-control"'  );
		$this->data ["formCat"] ["catId"]  = form_hidden ( 'catId',$catId );
		$this->data ["formCat"] ["submit"] = form_submit ( 'submit','Kaydet','class="form-control"' );
		$this->data ["formCat"] ["close"]  = form_close ();
	}
	
	
	function cat_save(){
	  
		$name  = strip_tags(xss_clean( $this->input->post('name')  ));
		$id  = xss_clean( $this->input->post('catId') ) ;
		$order = xss_clean( $this->input->post('order') );
		
		if(!is_numeric($order)){
		    $this->session->set_flashdata("error",Array('txt'=>"Hatalı Bilgi Girişi,Sıra Numarası Sayı Olmalı",'logic'=>'false'));
		    $this->session->set_flashdata("name",$name);
		    redirect(adminbase('footer/link_cat'));
		}
		
		$this->jsonRead($this->json_file);
		if($this->obj==""){
		    $this->jsonWrite($this->footerDefaulObj, $this->json_file);
		    $this->jsonRead($this->json_file);
		}
		
		if($id==""){
		    
		    $x = array("name"=>$name,"order"=>$order,"footerLinks"=>array());
		   
		    array_push($this->obj["footerLinkCat"], $x );
		    print_r($this->obj);
		}else{
	
		    if(sizeof($this->obj["footerLinkCat"][$id]["footerLinks"]) > 0) {
		       $arr = $this->obj["footerLinkCat"][$id]["footerLinks"];
		    }else{
		        $arr = Array();
		    }
		    $arrayChange=Array($id=>Array("name"=>$name,"order"=>$order,"footerLinks"=>$arr ));
		    $this->obj["footerLinkCat"] = array_replace( $this->obj["footerLinkCat"],$arrayChange );
		  
		    
		}
		
	    $this->jsonWrite($this->obj,$this->json_file);
		redirect(adminbase('footer/link_cat/'));
	}
	
	function link_frm($catId,$linkId="",$url="",$name="",$order="",$target=""){
		$this->data ["form"] ["open"] 	   = form_open_multipart ( adminbase('footer/link_save') );
		$this->data ["form"] ["url"] 	   = form_input ('url',$url );
		$this->data ["form"] ["name"]      = form_input ('name',$name );
		$this->data ["form"] ["order"] 	   = form_input ('order',$order);
		$this->data ["form"] ["target"]    = form_dropdown ('target',Array("_blank"=>"Yeni Sayfada","self"=>"Bulunduğu Sayfada"),$target,"class=\"selectDown\"");
		$this->data ["form"] ["catId"] 	   = form_hidden ('catId',$catId );
		$this->data ["form"] ["linkId"]    = form_hidden ('linkId',$linkId );
		$this->data ["form"] ["submit"]    = form_submit ('submit',"kaydet",'class=""' );
		$this->data ["form"] ["close"] 	   = form_close ();
	}
	

	
	function link_save(){
	    
		$url    = xss_clean( $this->input->post('url')   );
		$name   = xss_clean( $this->input->post('name')  );
		$order  = xss_clean( $this->input->post('order') );
		$target = xss_clean( $this->input->post('target'));
		$linkId = xss_clean( $this->input->post('linkId'));
		$catId  = xss_clean( $this->input->post('catId') );
		if(!is_numeric($order)){
		    $this->session->set_flashdata("error",Array('txt'=>"Hatalı Bilgi Girişi,Sıra Numarası Sayı Olmalı",'logic'=>'false'));
		    $this->session->set_flashdata("name",$name);
		    redirect(adminbase('footer/link_cat/'.$catId));
		}
		$this->jsonRead($this->json_file);
		$arr = array("url"=>$url,"urlName"=>$name,"urlOrder"=>$order,"target"=>$target);
		if($linkId==""){
				array_push($this->obj["footerLinkCat"][$catId]['footerLinks'],$arr);
				$this->jsonWrite($this->obj,$this->json_file);
		}else{
		    $this->obj["footerLinkCat"][$catId]['footerLinks'][$linkId]=$arr;
		    $this->jsonWrite($this->obj,$this->json_file);
		}
		redirect(adminbase('footer/link_cat/'.$catId));
	}
	


	function cat_delete($id){
		$id = xss_clean($id);
		
		$this->jsonRead($this->json_file);
		
			$size=sizeof($this->obj['footerLinkCat'][$id]["footerLinks"]);
			
			echo $size;
			
			if($size==0){
				unset($this->obj['footerLinkCat'][$id]);	
			    $this->jsonWrite($this->obj,$this->json_file);
			    
			}else{
			    $this->session->set_flashdata("error",Array('txt'=>"Bu katagoriye bağlı linkler bulunmaktadır, bu kategori silinemez.",'logic'=>'false'));
			}
			
		redirect(adminbase('footer/link_cat'));
	}
	
    function link_delete($catId,$linkid){
    	$catId   = xss_clean($catId);
    	$linkid      = xss_clean($linkid);
    	$this->jsonRead($this->json_file);
			
			$size=sizeof($this->obj["footerLinkCat"][$catId]["footerLinks"][$linkid]);
			if($size>0){
				unset($this->obj["footerLinkCat"][$catId]["footerLinks"][$linkid]);	
				$this->jsonWrite($this->obj,$this->json_file);
			}
    	redirect(adminbase('footer/link_cat/'.$catId));
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
    
    function array_sort($array, $on, $order=SORT_ASC){
        $new_array = array();
        $sortable_array = array();
    
        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }
    
            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }
    
            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }
    
        return $new_array;
    }
}