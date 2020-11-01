<?php 
class logincheck {
    protected $CI;
    
    public function __construct()
    {
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
    }
    
    public function check()
    {        
        
        if(!$this->CI->session->userdata('connected')){
            redirect(base_url('yonet'));
            exit;
        }
        
        

    }
}