<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct access allowed.' );
class MY_Controller extends CI_Controller {
    public $data;
    public $error='';
    public $user_lang;
    public $list_lang;
    public $full_list_lang;
    public $selected_url;
    public $url_typ = 'lng_group'; /* or lng_folder lng_group_folder */
    public $default_url="home";
    public $cons_json="my_cons.json";
    public $my_cons;
    
    //dashes url tipinde dil secenegi olsa bile
        
    public function __construct() { 
        parent::__construct();
        /*bulundugu sayfa*/
        $this->selected_url = current_url(); 
        try{
            //dil ayarı teklimi coklumu
            if(multi_language){
                $this->get_user_lang();
                switch ($this->url_typ){
                    case 'lng_group':
                       $url=$this->uri->segment(2);
                       
                       if($url==''){
                           $url= $this->default_url;
                       }
                       
                    break;
                }
                $this->load->model('simple_model');
                
                if(! $this->data['values'] = $this->simple_model->selectValue('page', Array('url'=>$url,'lng'=> $this->user_lang,'pub'=>'y'))[0]){
                    throw new Exception("404");// sayfa bulunamadi
                }
            }else{
               if(! $this->data['values'] = $this->simple_model->selectValue('page', Array('url'=>$url,'lng'=> $this->user_lang,'pub'=>'y'))[0]){
                    throw new Exception("404");// sayfa bulunamadi
               }
            }
        }catch (Exception  $e){
           $this->error = $e->getMessage();
           //echo "aaaa";
           echo  $this->load->view('error/'.$this->error.'_page','',TRUE);
           exit();
        }
    }
    

    /*kullanici anasayfaya girdiginde default dil secenegi gelir*/
    /*diger sayfalarda databasede kayitli dil senekleri gelir.*/
    function get_user_lang(){
        $this->load->helper('cookie');
        $this->load->library('my_lang');
        $this->list_lang = $this->my_lang->getLangArr();
        $this->full_list_lang = $this->my_lang->getFullLang();
        $last_lng = get_cookie("user_lang");
        $lng = $this->uri->segment(1);
        
        /*siteye ilk giristeki dil secenegi*/
        if( ($last_lng!=$lng && $last_lng!="") || $last_lng=='' ){
            if(in_array($lng, $this->list_lang) || $lng==''){
                    $this->my_lang->getLang();
                    $this->user_lang = ($lng=='') ? $this->my_lang->activeLng['alias'] : $lng;
                    set_cookie('user_lang',$this->user_lang ,'36000');
            }else{
                throw new Exception('404');//hatali lng
            }
        }else if($lng==$last_lng){
            $this->user_lang=$lng;
        }
        $this->lang->load($this->user_lang.'_lang',$this->user_lang);
        
    }
    
    function get_page_translate($page_id){
        
    }
    
    function get_menu(){
        $this->load->helper('array_sort');
        
		$menu = file_get_contents('json/'.$this->user_lang.'_topmenu.json');
		$obj['menu']=json_decode($menu,TRUE);
		$this->load->helper('array_sort');
		$obj["menu"]=array_sort($obj["menu"],"order",SORT_ASC);
		return $obj;
		
    }
    function get_footer(){
        $footer=file_get_contents('json/'.$this->user_lang.'_footer.json');
		$obj=json_decode($footer,TRUE);
		return $obj;
    }
    function get_banner(){
        $banner=file_get_contents('json/'.$this->user_lang.'_banner.json');
        $obj=json_decode($banner,TRUE);
        return $obj;
    }
    
    function get_cons(){
        $cons  = file_get_contents('json/'.$this->cons_json);
        $this->my_cons = json_decode($cons,TRUE);
        
        return $this->my_cons;
    }
    
    function get_gallery(){
        //$this->image_model->get_image(Array('file.typ="img"'),5,0,)
    }
    
    function promo($name){
        $counter=0;
        $this->load->helper('cookie');
    
        $promo = $this->input->cookie($name['url']);
         
    
        if($promo==0 || $promo==''){
             
            $cookie = array(
                'name'   => $name['url'],
                'value'  => $promo + 1,
                'expire' => time()+86500,
    
            );
    
            $this->input->set_cookie($cookie);
            return 0;
        }else{
            return 1;
        }
         
    
    }
    
            
}