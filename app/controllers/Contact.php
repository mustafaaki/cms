<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class contact extends MY_Controller {

    public $breadcrumb_step=0;
    public $per_page=10;
    
    public function index($call="")
    {
       
        if($call==""){
            $key = $this->input->get($key);
            if($page!=0){
            $page=int( $page -1);
            
                
            }
            $keys= xss_clean($key);
            $menu = $this->get_menu();
            $footer = $this->get_footer();
            $this->get_cons();
            $this->load->model('site/search_model');
            $this->load->model('site/page_model');
            $this->data["search_list"]=$this->search_model->search_key($keys,$per_page,$page*$per_page);
            //print_r($this->data["search_list"]);
            $this->data['map'] = $this->page_model->get_map($this->data['values']['id'])[0];
            $this->data['header'] = $this->load->view ( 'site/header', $menu, TRUE );
            $this->data['footer'] = $this->load->view ( 'site/footer', $footer, TRUE );
            $this->data['page'] = $this->load->view ( 'site/page/contact', $this->data,TRUE );
            $this->load->view('master',$this->data);
        }else if($call=="send"){
           
            $this->send();
        }
    }
    
    public function send(){
       $this->load->library('email');

        //SMTP & mail configuration
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.googlemail.com',
            'smtp_port' => 587,
            'smtp_user' => 'zenitimbilgi@gmail.com',
            'smtp_pass' => 'Melis55315531',
            'mailtype'  => 'html', 
            'charset'   => 'UTF-8'
        );
        $this->email->initialize($config);
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        
        //Email content
        $htmlContent = '<h1>Sending email via SMTP server</h1>';
        $htmlContent .= '<p>This email has sent via SMTP server from CodeIgniter application.</p>';
        
        $this->email->to('mustafa@zenitim.com');
        $this->email->from('zeitimbilgi@gmail.com','MyWebsite');
        $this->email->subject('How to send email via SMTP server in CodeIgniter');
        $this->email->message($htmlContent);

//Send email
        if($this->email->send()){
            echo "gitti";
        }else{
            show_error($this->email->print_debugger());
        }
    }
}