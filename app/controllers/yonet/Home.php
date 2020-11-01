<?php
class home extends CI_Controller {
    public $data;
    
    public function index(){
        $this->load->library ( Array('form_validation','session','logincheck') );
        $this->load->helper(Array('password','form',));
        $this->logincheck->check();
        /*kullanici girisi kontrolu*/
        $this->logincheck->check();
        /* language bilgileri aliniyor*/
        $this->my_lang->getSessionLng();
      
        
        $this->data['menu']=$this->load->view('yonet/inc/v_sidebar','',TRUE);
        $this->data['page']=$this->load->view('yonet/inc/v_home_body','',TRUE);
        $this->data['footer']=$this->load->view('yonet/inc/v_footer','',TRUE);
        
        $this->load->view('yonet/v_home',$this->data);
        session_write_close();
    }
    
    
    
}