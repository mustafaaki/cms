<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class my_app extends CI_Controller {


	public function email_list_save()
	{
	    $msg_success = Array('tr'=>'Email listemize kaydedildi.','en'=>'Your email saved','arb'=>'بريدك الالكتروني محفوظ');
	    $msg_error   = Array('tr'=>'Bu email adresi kayıtlı.','en'=>'This email is exist','arb'=>'هذا البريد الإلكتروني موجود'); 
	    $email = $this->input->post('email');
	    $lng =  $this->input->post('lng');
	    $this->load->model('simple_model');
	   if(!$this->simple_model->insert('ebulletin',Array('email'=>$email))){
	       echo $msg_error[$lng];
	   }else{
	      echo $msg_success[$lng];    
	   }
	    
	    
	}
	
}