<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class page extends MY_Controller {

    public $breadcrumb_step=0;
    public $list_size=8;
    
	public function index($page="1")
	{
	    $this->load->model('site/page_model');
	    /*sayfa bagli dosyalar cagriliyor img pdf video vs- ve explode ile turkerine gore ayristiriliyor*/
	    $this->data['file'] = $this->explode_file( $this->page_model->get_page_file($this->data['values']['id']) );
	   
	   
	    $menu = $this->get_menu();
	    $footer = $this->get_footer();
	    $this->get_cons();
	    /*varsa sayfaya bagli harita */
	    $this->data['map'] = $this->page_model->get_map($this->data['values']['id'])[0];
	    
	    /*sayfanin arayuzu*/
	    $template = $this->page_model->get_template($this->data['values']['template']);
	   
	    /*news ikinci sayfalarda gosterilecek guncel haberler*/
	    $news_options = Array('news.lng'=>$this->user_lang,'news.pub'=>'y','news.order <>'=>NULL,'news.position'=>4);
	    $this->data['news']   = $this->page_model->news($news_options,'order asc',6);
	  
	    $news_options = Array('news.lng'=>$this->user_lang,'news.pub'=>'y','news.order <>'=>NULL,'news.position'=>3);
	    $this->data['latest'] = $this->page_model->news($news_options,'order asc',4);
	   
	    /*sayfa tipine gore islemler icin fonksiyon cagriliyor*/
		$function_name = $this->data['values']['typ'].'_page';
		$this->load->library('my_page_cat');
		$this->data["categories"]= $this->my_page_cat->listArray($this->user_lang,"pub='y'");
		
		$this->$function_name($page);
		
		$this->breadcrumb($this->data['values']['id']);
		$this->data['header'] = $this->load->view ( 'site/header', $menu, TRUE );
		$this->data['footer'] = $this->load->view ( 'site/footer', $footer, TRUE );
		$this->data['page']   = $this->load->view ( 'site/page/'.$template['templateAlias'], $this->data,TRUE );
		$this->load->view('master',$this->data);
	}
	
	public function cat_page($page){  
	   //echo $this->data['values']['id'];
	     if($page!="" && $page!=1){
	         $start=($page-1)*$this->list_size;
	     }else if($page==1 or $page==0){
	         $start=0;
	     }
	    $sub_content= $this->page_model->get_sub_content($this->data['values']['id'],$this->list_size,$start,'page.cdate desc');
	    //echo $this->db->last_query();
	    $total_row = $this->page_model->sub_content_size($this->data['values']['id'],$this->list_size,$page,'page.cdate desc');
	    $this->data['pagination']= $this->create_pagination($this->data['values']['url'],  $total_row, $page);
	    $this->data['sub_content']=$sub_content;
	}
	
	public function txt_page($page){
	   
	}
	
	/*file ile gelen verileri tipine gore ayristiriyor img vid ve doc olarak*/
	public function explode_file($file){
	    foreach($file as $x=>$y){
	        $update_file[$y['typ']][$y['position']][$x]=$y;
	    }
	   return $update_file;
	}
	
    /*kategori veya sayfanin ebeveyni varmı diye kontrol eder*/		
	function breadcrumb($id){
	    $breadcrumb = $this->page_model->parent_page($id);
	    
	    if(is_array($breadcrumb)){
	       $this->breadcrumb_step++;
	       $this->data['breadcrumb'][$this->breadcrumb_step]=$breadcrumb;
	       $this->breadcrumb($breadcrumb['master']);
	    }
	}
	
	function create_pagination($url, $total_row, $page=1){
	  
	    $this->load->library('pagination');
	    $config['base_url'] = base_url($this->user_lang.'/'.$url);
	    $config['total_rows'] = $total_row;
	    $config['per_page'] = $this->list_size;
	    $config['uri_segment']=3;
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
	    
	    $this->pagination->initialize($config);
	    $pageLinks=$this->pagination->create_links();
	   
	    return $pageLinks;
	}
}