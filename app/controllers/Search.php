<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class search extends MY_Controller {

    public $breadcrumb_step=0;
    public $per_page=10;
    
    public function index()
    {
        $key = $this->input->get('key');
        $page = $this->input->get('page');
       
        if( $page!=0){
            $page=$page -1;
            $start= $page*$this->per_page;
        }else{
            $start=0;
        }
      
        $keys= xss_clean($key);
       
        $menu = $this->get_menu();
        $footer = $this->get_footer();
       // $this->get_cons();
        $this->load->model('site/search_model');
       
        $this->data["search_counter"]=$this->search_model->search_key_count($keys);
        
        $this->data["search_list"]=$this->search_model->search_key($keys,$this->per_page,$start);
        $this->data["pagination"] = $this->create_pagination($this->data["search_counter"], $this->per_page, $page, $keys);
        
        $this->data['header'] = $this->load->view ( 'site/header', $menu, TRUE );
        $this->data['footer'] = $this->load->view ( 'site/footer', $footer, TRUE );
        $this->data['page'] = $this->load->view ( 'site/page/search', $this->data,TRUE );
        $this->load->view('master',$this->data);
    }
    
    function create_pagination($count,$list_size,$page,$keys){
        
	    
	    $this->load->library('pagination');
		 $config['base_url'] = base_url($this->user_lang.'/search?key='.$keys);
		 $config['total_rows'] = $count;
		 $config['per_page'] = $list_size;
		 //$config['uri_segment']=2;// sayfa numarasi degerinin urledeki yeri.
		 //$config['suffix'] = '&key='.$this->key;//url  sonunu  duzenler
		 $config['first_url'] =$this->user_lang."/search?key=".$keys;//url ilk sayfayi atar
		 $config['use_page_numbers'] = TRUE;
		 $config['full_tag_open'] = '<ul class="x_pagination">';
         $config['full_tag_close'] = '</ul>';
         $config['prev_link'] = '&lt;';
         $config['prev_tag_open'] = '<li>';
         $config['prev_tag_close'] = '</li>';
         $config['next_link'] = '&gt;';
         $config['next_tag_open'] = '<li>';
         $config['next_tag_close'] = '</li>';
         $config['cur_tag_open'] = '<li class="active">';
         $config['cur_tag_close'] = '</li>';
         $config['num_tag_open'] = '<li>';
         $config['num_tag_close'] = '</li>';
         $config['first_tag_open'] = '<li>';
         $config['first_tag_close'] = '</li>';
         $config['last_tag_open'] = '<li>';
         $config['last_tag_close'] = '</li>';
         
         $config['first_link'] = '&lt;&lt;';
         $config['last_link'] = '&gt;&gt;';
		 $config['query_string_segment'] = "page";
		 //$config['reuse_query_string'] = "TRUE";
		 $config['page_query_string'] = TRUE;
		 
		 $this->pagination->initialize($config);
		 $pageLinks=$this->pagination->create_links();
		 return $pageLinks;
	}
	
}