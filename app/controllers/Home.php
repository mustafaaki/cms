<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class home extends MY_Controller {


	public function index()
	{
    	  $this->load->model('site/home_model');
    	  $menu = $this->get_menu();
    	  $footer = $this->get_footer();
    	  $this->data["banner"]= $this->get_banner();
    	  $news = $this->home_model->news(Array('news.lng'=>$this->user_lang,'news.order <> '=>NULL),'news.order asc');
    	  $this->get_cons();
    	  $group_news=Array();
    	  foreach($news as $v=>$l){
    	    $count++;
    	    $group_news[$l['position']][$count]=$l;
    	  }
    	  $this->data['news']=$group_news;
    	  $this->data['count_adv_show']=$this->promo(array_shift($group_news[5]));
    	  $this->data['header'] = $this->load->view ( 'site/header', $menu, TRUE );
    	  $this->data['footer'] = $this->load->view ( 'site/footer', $footer, TRUE );
    	  $this->data['page']   = $this->load->view ( 'site/page/home', $this->data, TRUE );
    	  $this->load->view('master',$this->data);
	}

}
