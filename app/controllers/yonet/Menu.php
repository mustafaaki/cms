<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class menu extends CI_Controller {
    public $menuFile="topmenu.json";
    public $json_file;
	public $jsonContent;
	public $data;
    public $frmVal;
    public $operation_class_alias="menu";
	public function __construct()
	{  /*onceki sinifin degerleri bu sinifa uygulaniyor*/
	    parent::__construct();
	    /*oturum acmak icin class yukleniyor*/
    	$this->load->library ( Array('form_validation','logincheck') );
    	$this->load->helper(Array('password','form','password','form'));
    	$this->load->model(Array('yonet/template_model','simple_model'));
    	/*kullanici girisi kontrolu*/
    	$this->logincheck->check();
    	$this->my_lang->getSessionLng();
    	$this->json_file= './json/'.$this->session->userdata('activeLng')['alias'].'_'.$this->menuFile;
	}
	
    /*ust menu yapim giris sayfasi */
    function makemenu($masterIndex=""){
        
        $this->frmVal["master"]=htmlspecialchars(xss_clean( $masterIndex));
        $this->load->model(Array("simple_model"));
        $this->data['error']= $this->session->flashdata('error');
       

        $this->jsonRead($this->json_file);
    
        if($masterIndex==""){
            $this->data['inc_page_header']='YENİ MENÜ LİNKİ OLUŞTURUN';
        }else{
            $this->data['inc_page_header']=$this->obj[$masterIndex]["name"]." ALTINA ALT MENÜ OLUŞTUR.";
        }
    
        if($this->obj[$masterIndex]["step"]>4){
            $this->data["error"]="maximum 4 adım alt menü oluşturabilirsiniz!";
        }
        $this->menu_frm();
        
        $this->data['list']=$this->array_sort($this->obj,"order",SORT_ASC);
        
        $this->my_lang->singleTranslateLng($this->session->userdata('activeLng')['alias']);
        $this->data['page_options']=$this->load->view('yonet/module/v_page_options',$this->data,TRUE);
        $this->data['menu']=$this->load->view('yonet/inc/v_sidebar','',TRUE);
        $this->data['page']=$this->load->view('yonet/inc/v_menu',$this->data,TRUE);
        $this->data['footer']=$this->load->view('yonet/inc/v_footer','',TRUE);
        $this->load->view('yonet/v_home',$this->data);
    }
    
    /*site ust menu form*/
    function menu_frm(){
        $this->data ["form"] ["open"] 			= form_open_multipart ( 'yonet/menu/menu_create' );
        $this->data ["form"] ["url"] 			= form_input ( 'url',$this->frmVal['url'],'class="form-control"' );
        $this->data ["form"] ["name"] 			= form_input ( 'name',$this->frmVal['name'],'class="form-control"' );
        $this->data ["form"] ["text"] 			= form_input ( 'text',$this->frmVal['text'],'class="form-control"' );
        $this->data ["form"] ["order"] 			= form_input ( 'order',$this->frmVal['order'],'class="form-control w-20"' );
        $this->data ["form"] ["id"] 			= form_hidden ( 'id',$this->frmVal['id'] );
        $this->data ["form"] ["master"] 		= form_hidden ( 'master',$this->frmVal['master'] );
        $this->data ["form"] ["step"] 		    = form_hidden ( 'step',$this->frmVal['step'] );
        $this->data ["form"] ["submit"] 		= form_submit ( 'submit',"Kaydet",'class="form-control btn-success pull-right"' );
        $this->data ["form"] ["close"] 			= form_close ();
    }
    
    /*json dosyasi veri kontrol, dosya bos ise veri yaziliyor*/

    function menu_create(){
        $this->obj=array();
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    
        $this->data['error'] = $this->session->flashdata('error');
    
        if($_POST){
            $this->jsonRead($this->json_file);
            /*form verileri cekiliyor*/
            $this->load->library('form_validation');
            $this->form_validation->set_rules ( 'url', "url", "regex_match[/^[a-zA-Z0-9\s\-\_:.\/#]+$/]|strip_tags|xss_clean|min_length[0]|max_length[255]" );
            $this->form_validation->set_rules ( 'name', "name", "required|strip_tags|xss_clean|min_length[3]|max_length[75]" );
            $this->form_validation->set_rules ( 'text', "text", "strip_tags|xss_clean|min_length[3]|max_length[75]" );
            $this->form_validation->set_rules ( 'order', "sıra", "strip_tags|xss_clean|regex_match[/^[1-9]+$/]" );
            $this->form_validation->set_rules ( 'id', "id", "strip_tags|xss_clean" );
            $this->form_validation->set_rules ( 'step', "step", "strip_tags|xss_clean" );
            $this->form_validation->set_rules ( 'master', "master", "strip_tags|xss_clean" );
    
            $error = $this->form_validation->run ();
            
            $id=set_value("id");
            if($error){
                if($id==""){
                    $step=$this->menuStep(set_value("master"));
                    if($step<=4){
                        $menu=Array("url"=>set_value("url"),"name"=>set_value("name"),"text"=>set_value("text"),
                            "order"=>set_value("order"),"master"=>set_value("master"),"step"=>$step);
                        $this->session->set_flashdata("error",Array('txt'=>'Menü Kaydedildi','logic'=>'true'));
                        array_push($this->obj,$menu);
                        $this->obj=$this->array_sort($this->obj,"order",SORT_DESC);
                        $this->jsonWrite($this->obj,$this->json_file);
                    }else{
                        $this->session->set_flashdata("error",Array('txt'=>'Hata: Alt menü max 4 adım olmalıdır.','true'));
                    }
                }else if($id>=0){
                    $this->obj[$id]=Array("url"=>set_value("url"),"name"=>set_value("name"),"text"=>set_value("text"),
                        "order"=>set_value("order"),"master"=>set_value("master"),"step"=>set_value("step"));
                     $this->session->set_flashdata("error",Array('txt'=>'Menü Linki Düzenlendi','logic'=>'true'));
                    	
                    $this->obj=$this->array_sort($this->obj,"order",SORT_DESC);
                    
                    //$this->jsonWrite($this->json_file);
                    $this->jsonWrite($this->obj,$this->json_file);
                }
            }else{
                $this->session->set_flashdata("error",Array('txt'=>validation_errors(),'logic'=>'false'));
            }
        }else{
            $this->session->set_flashdata("error",Array('txt'=>'Hata: Alt menü max 4 karakter olmalıdır.','logic'=>'true'));
        }
         
       
        redirect(adminbase('menu/makemenu'));
    }
    
    
    function menuStep($val){
        $menuStep=1;
        if($val!=""){
            while ($val!=""){
                $menuStep++;
                $val=$this->obj[$val]["master"];
            }
        }
        return $menuStep;
    }
    
    function order_update(){
        $order= (int) xss_clean($this->input->post("order"));
        $id = (int) xss_clean($this->input->post("id"));
        $this->jsonRead($this->json_file);
        $this->obj[$id]["order"]=$order;
       
        
        $this->jsonWrite($this->obj,$this->json_file);
       // echo $order."a".$id;
    }
    function menu_update($index){
        $this->data['error']= $this->session->flashdata('error');
        $this->jsonRead($this->json_file);
        $updateObj = $this->obj[$index];
        $this->frmVal["url"]=$updateObj["url"];
        $this->frmVal["text"]=$updateObj["text"];
        $this->frmVal["name"]=$updateObj["name"];
        $this->frmVal["id"]=xss_clean($index);
        $this->frmVal["order"]=$updateObj["order"];
        $this->frmVal["master"]=$updateObj["master"];
        $this->frmVal["step"]=$updateObj["step"];
        
        $this->data['frmHeader'] = $this->obj[$index]["name"]." isimli menu alt linkini güncelleyiniz...";
       
        $this->menu_frm();

        $this->data['list']=$this->array_sort($this->obj,"order",SORT_ASC);
        $this->data['menu']=$this->load->view('yonet/inc/v_sidebar','',TRUE);
        $this->data['page']=$this->load->view('yonet/inc/v_menu',$this->data,TRUE);
        $this->data['footer']=$this->load->view('yonet/inc/v_footer','',TRUE);
        $this->load->view('yonet/v_home',$this->data);
    
    }
    function menu_del($index){
        $this->jsonRead($this->json_file);
         
       
        foreach ($this->obj as $t=>$s){
             
            if($index==$s["master"]){
                $this->session->set_flashdata('error',Array('txt'=>'Bu menü linki altında kayıtlı başka menü öğeleri vardır. <br>
                    Alt menü öğeleri varken silme yapamazsınız.','logic'=>'false'));
                redirect(adminbase('menu/makemenu'));
                	
                exit;
            }
        }
    
        unset($this->obj[$index]);
        $this->jsonWrite($this->obj,$this->json_file);
        redirect(adminbase('menu/makemenu'));
    }
    
    function jsonRead($file){
        $this->jsonContent = file_get_contents($file);
        if($this->jsonContent!=""){
            $this->obj= json_decode($this->jsonContent,true);// sondaki true dizinin array olacagini belirtir.
        }else{
            $this->jsonWrite(false);
        }
        //$f = fopen($this->fname,"w+");
        //fwrite( $f, json_encode($this->obj));
        //fclose( $f );
    }
    
    function jsonWrite($val,$file){
        $f=fopen($file,"w+");
        $this->obj = $val;
        fwrite( $f, json_encode($this->obj));
        fclose( $f );
    }
    
    function array_sort($array, $on, $order=SORT_ASC){
        $new_array = array();
        $sortable_array = array();
    
        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }
    
            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }
    
            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }
    
        return $new_array;
    }
    

 }