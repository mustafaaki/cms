<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class banner extends CI_Controller {
	public $data;
	public $translate_file;
	public $json_file;
	
	public function __construct(){
	    parent::__construct();
	    $this->load->library ( Array('logincheck','user_agent') );
	    $this->load->model ( Array('simple_model') );
	    $this->load->helper(Array('password','form'));
	    $this->logincheck->check();
	    $this->my_lang->getSessionLng();
	    $this->json_file = './json/'.$this->session->userdata('activeLng')['alias'].'_'.$this->translate_file;;
	}
	
	/*footer  imza ve copyright kÄ±smÄ± yazÄ±sÄ± baslangic start*/
	function create(){
	    
	    $this->data['error']= $this->session->flashdata('error');
	    $this->jsonRead($this->json_file);
	     
	    $this->txt_frm();
	
	    
	   
	    $this->load->view("home",$this->data);
	}
	
	function txt_frm(){
	    $copy=array(
	        'name'        => 'copy',
	        'id'          => 'copyTextArea',
	        'value'       => $this->obj["footerSign"]["copy"],
	        'rows'        => '',
	        'cols'        => '',
	        'style'       => ''
	    );
	    $text=array(
	        'name'        => 'text',
	        'id'          => 'copyTextArea',
	        'value'       => $this->obj["footerSign"]["text"],
	        'rows'        => '',
	        'cols'        => '',
	        'style'       => '');
	    $this->data ["formCopy"] ["open"]   = form_open_multipart ( adminbase('static/save') );
	    $this->data ["formCopy"] ["copy"]   = form_textarea($copy);
	    $this->data ["formCopy"] ["text"]   = form_textarea($text);
	    $this->data ["formCopy"] ["text"]   = form_textarea($text);
	    $this->data ["formCopy"] ["submit"] = form_submit ( 'submit',"kaydet",'class=""' );
	    $this->data ["formCopy"] ["close"]  = form_close ();
	}
	
	function copy_save(){
	    $copy  = xss_clean( $this->input->post('copy')  );
	    $text  = xss_clean( $this->input->post('text')  );
	    $face  = xss_clean( $this->input->post('face')  );
	    $face  = xss_clean( $this->input->post('face')  );
	    $instagram  = xss_clean( $this->input->post('instagram')  );
	    $yout  = xss_clean( $this->input->post('youtube')  );
	    $linked  = xss_clean( $this->input->post('linked')  );
	    $text  = xss_clean( $this->input->post('link')  );
	    $this->jsonRead($this->json_file);
	    if($this->obj==""){
	        $this->jsonWrite($this->footerDefaulObj, $this->footerFile);
	        $this->jsonRead($this->json_file);
	    }
	    $this->footerCatFrm();
	
	    $this->obj["footerSign"]["copy"]= $copy;
	    $this->obj["footerSign"]["text"] =$text;
	    $this->jsonWrite($this->obj,$this->json_file);
	    redirect(base_url('footer/makefootersign'));
	}

}