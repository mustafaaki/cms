<?php
class login extends CI_Controller {
    public $data;
    
    public function index()
    {          
        $this->load->library('session');
        $this->load->helper('url');

        if(!$this->session->userdata('connected')){
            /*captcha for bot control*/
            $this->data["captcha"]=$this->captcha_crt();
            $this->data['error']=$this->session->flashdata('error');
            
            $frmValue=Array("email"=>"","pass"=>"",);
            $this->session->sess_destroy();
            $this->loginFrm($frmValue);
            $this->load->view("yonet/v_login",$this->data);
        }else{
            redirect(base_url('yonet/home'));
        }
    }

    function  loginFrm($frmValue){
        $this->load->helper('form');
        $this->data["frm"]["open"]=form_open('yonet/login/check');
        $this->data["frm"]["email"]=form_input('email',$frmValue['email'],' class="form-control" placeholder="Email"');
        $this->data["frm"]["pass"]=form_password('pass','',' class="form-control" placeholder="Şifre"');
        $this->data["frm"]["captcha"]=form_input('captcha','',' class="form-control" placeholder="Resimde Ne Görüyorsun?"');            
        $this->data["frm"]["submit"]=form_submit('submit','Giriş',Array('class'=>'btn btn-success btn-lg'));
        $this->data["frm"]["close"]=form_close();
    }
        
    function captcha_crt(){
        $this->load->helper('captcha');
        $vals = array(
            'img_path'      => './captcha/',
            'img_url'       => base_url('captcha/'),
            'font_path'     => './captcha/font/EpoXY_histoRy.ttf',
            'img_width'     => '190',
            'img_height'    => '40',
            'expiration'    => 3600,
            'word_length'   => 6,
            'font_size'     => 18,
            'img_id'        => 'Imageid',
            'pool'          => '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            //background colors for captcha
            'colors' => array('background'=>array(160, 240, 225),'border' => array(206, 212, 218),'text' => array(0, 48, 78),'grid' => array(110, 180, 224)
            )
        );
            
        $cap = create_captcha($vals);
        $data = array( 'captcha_time'  => $cap['time'], 'ip_address' => $this->input->ip_address(), 'word'=> $cap['word']);
        $query = $this->db->insert_string('captcha', $data);
        $this->db->query($query);
        return $cap['image'];
    }
        
    public function check(){
        
        $this->load->library ( Array('form_validation','session','my_lang') );
        $this->load->helper(Array('password','form'));
        $this->form_validation->set_rules('captcha','resim','required|strip_tags|xss_clean|min_length[5]|max_length[7]' );            
        $this->form_validation->set_rules ( 'email', 'email', 'required|regex_match[/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/]|strip_tags|xss_clean|min_length[6]|max_length[79]' );
        $this->form_validation->set_rules ( 'pass', 'Şifre', "required|xss_clean|strip_tags|min_length[6]|max_length[12]" );
        $validation=$this->form_validation->run();
        if(!$this->captcha_check(set_value('captcha'))){
            $this->session->set_flashdata("error","Doğrulama Resmi Hatalı.");
            redirect("yonet");
        }        
        if ($validation) {
            $this->load->model('yonet/login_model');
            //echo passEncrypt(set_value('pass')).set_value('email');
            $logResponse = $this->login_model->loginCheck(set_value('email'), passEncrypt(set_value('pass')));
            
            if($logResponse->num_rows()){
                $row        = $logResponse->row();
                $sessionData= Array('email'=>$row->email,
                    'id'=>$row->id,
                    'typ'=>$row->typ,
                    'lock'=>$row->lock,
                    'name'=>$row->name,
                    'connected'=>TRUE);
                /*save user information*/
                $this->session->set_userdata($sessionData);
                $this->my_lang->getLang();
                $this->my_lang->setSessionLng();
                redirect('yonet/home');
            }
        }
       
        $this->session->set_flashdata("error","Hatalı email yada şifre.");
       redirect('yonet');
    }
        
    function captcha_check($val){
        $this->load->helper('captcha');
        // First, delete old captchas
        $expiration = time() - 3200; // Two hour limit
        $this->db->where('captcha_time < ', $expiration)->delete('captcha');
    
        // Then see if a captcha exists:
        $sql = 'SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?';
        $binds = array($val, $this->input->ip_address(), $expiration);
        $query = $this->db->query($sql, $binds);
        $row = $query->row();
   
        if ($row->count == 0){
            return false ;
        }else{
            return true;
        }
    }
        
    function out(){
        $this->session->sess_destroy ();
        redirect(base_url('yonet'));
    }
    
}