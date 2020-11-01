<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class map extends CI_Controller {
	public $data;
    public $map_lat='39.8688';
    public $map_lon='32.2195';
    public $map_zoom='8';
    public $map_pub='y';
    public $map_address='Ankara';
    public $map_id;
    
    public function __construct(){
        parent::__construct();
        $this->load->library ( Array('logincheck','user_agent') );
        $this->load->model ( Array('simple_model') );
        $this->load->helper(Array('password','form'));
        $this->logincheck->check();
        $this->my_lang->getSessionLng();
    }
    
	public function create(){
	    $this->data["page_id"] = $this->input->post('id');
	    
	    $value=$this->simple_model->selectValue('map',Array('refId'=>$this->data["page_id"]));
	  
	    if(sizeof($value)>0){
	        $value= $value[0];
	        
	        $this->map_lat=$value['lat'];
	        $this->map_lon=$value['lon'];
	        $this->map_zoom=$value['zoom'];
	        $this->map_pub=$value['pub'];
	        $this->map_address=$value['address'];
	        $this->map_id=$value['id'];
	        
	    }
	    $this->load->view('yonet/module/v_frm_map',$this->data);
	}
	
	public function save(){
	    
	    $arr=[];
	    $arr['refId'] = $this->input->post("page_id");
	    $arr['lon'] = $this->input->post("lon");
	    $arr['lat'] = $this->input->post("lat");
	    $arr['address'] = $this->input->post("address");
	    $arr['zoom'] = $this->input->post("zoom");
	    $arr['pub'] = $this->input->post("pub")=='y'? 'y':'n';
	    $translate_page = $this->input->post("translate_page");
	    if($translate_page=="y"){
	       $lang =  $this->my_lang->searchLanguageId($arr['refId'],"page");
	       unset( $lang['lngid'] );
	       unset( $lang['table'] );
	       foreach($lang as $x=>$y){
	           if($y!=""){
    	           $arr['refId']=$y;
    	           $this->simple_model->delete('map',Array('refId'=>$y));
    	           $this->simple_model->insert('map',$arr);
	           } 
	       }
	    }else{
	       $this->simple_model->delete('map',Array('refId'=>$arr['refId']));
	       $this->simple_model->insert('map',$arr);
	    }
	}
}