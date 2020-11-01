<?php
class page extends CI_Controller {
    public $data;
    public $frmVal = array( 'url'			=>'',
                            'name'		    =>'',
                            'header'		=>'',
                            'title'			=>'',
                            'key'			=>'',
                            'desc'	        =>'',
                            'order'			=>'',
                            'template'		=>'',
                            'index'			=>'y',
                            'id'			=>'',
                            'cross'			=>'',
                            'user'			=>'',
                            'content'		=>'',
                            'typ'			=>'',
                            'text'			=>'',
                            'redirect'	    =>'',
                            'pub'			=>'y',
                            'delete'		=>'n',
                            'cdate'		    =>'',
                            'edate'		    =>'',
                            'cuser'		    =>'',
                            'language'	    =>'',
                            'tag'		    =>'');
    public $templateList;
    public $pageTyp=Array("cat","txt","fol");
    public $selectPageTyp;
    public $id;
    public $limit_page=20;
    
    public function __construct()
    {  /*onceki sinifin degerleri bu sinifa uygulaniyor*/   
       parent::__construct();
       /*oturum acmak icin class yukleniyor*/
       $this->load->library ( Array('form_validation','logincheck') );
       $this->load->helper(Array('password','form'));
       $this->load->model(Array('yonet/template_model','simple_model'));
       /*kullanici girisi kontrolu*/
       $this->logincheck->check();
       $this->my_lang->getSessionLng();  
    }
    
    /*yeni sayfa olusturma $typ sayfa tipi $id translate bos iken sayfa idsidir 
     * translate dolu iken language tablosu id sidir */
    public function create($typ,$id="",$translate=""){
        $this->selectPageTyp = xss_clean(strip_tags($typ));
        $this->data['error'] = $this->session->flashdata('error');/*form kayittan geliyorsa form kayit durumu cekiliyor*/
        $sesFrmValue=$this->session->flashdata('frmVal');/*hatali giris ise form verileri tekrar aliniyor*/
        
        /*page typ kontrol ediliyor*/
        $isTypTrue=in_array($typ, $this->pageTyp);
        if(!$isTypTrue){ echo "Şişt urlye dokunma'"; exit;}
        
        $this->frmVal['language']="";
        $this->frmVal['lng']=$this->session->userdata('activeLng')[alias];
        /*urlden gelen veri suzuluyor*/
        if( $id!="" && $translate==""){
            $this->id = (int) $id;/*id temizleniyor*/
            
            $values = $this->simple_model->selectedValues('page',Array('id'=>$this->id));/*gelen id degeri datadan cekiliyor*/
            //echo $this->db->last_query();
            $languages = $this->my_lang->searchLanguageId($id,"page");/*gelen id dogrultusunda language tablosundan veriler cekiliyor*/
            
        }else if($id!="" and $translate!=""){ /*buradaki id language tablosundaki iddir.*/
            $val=$this->my_lang->getLanguageVal($id);/* language tablosundaki lngid ye gore veri cekiliyor*/
            $languages=$val[0];
            $this->frmVal['language']=$languages["lngid"];
            $this->frmVal['lng']=$translate;
            $pageId= $languages[$translate]!=""? $languages[$translate]:"" ;/* ceviri girilmiste icerik idsi ataniyor*/
            
            if($pageId!=""){
                $this->my_lang->translateLng($translate,$languages);
                $values = $this->simple_model->selectedValues('page',Array('id'=>$pageId),"id");
            }
            
        }
        /* urlden gelen id kontrol ediliyor id bir degere karsilikmi degilmi bakiliyor*/
        if(is_object($values)){
            $this->frmVal=array('url'		    =>$values->url,
                'name'			=>$values->name,
                'header'		=>$values->header,
                'key'			=>$values->key,
                'desc'	        =>$values->desc,
                'template'		=>$values->template,
                'index'			=>$values->index,
                'id'			=>$values->id,
                'typ'			=>$values->typ,
                'cuser'			=>$values->cuser,
                'content'		=>$values->content,
                'longtext'		=>$values->longtext,
                'tag'		    =>$values->tag,
                'lng'		    =>$values->lng,
                'language'		=>$languages["lngid"],
                'pub'			=>$values->pub );
                 
            if($sesFrmValue!=""){
                $this->frmVal=$sesFrmValue;
            }
        }
        
        $this->my_lang->translateLng($this->frmVal['lng'],$languages);
        $this->translateBar();
        /*Template tablosundan sayfa arayuz listesi aliniyor*/
        $this->templateList	= $this->template_model->templateList($typ);
        /*pageType gore fonksiyon cagriliyor*/
        $this->$typ($id,$translate);
        $this->form_create($this->frmVal);
        
        $this->data['page_options']=$this->load->view('yonet/module/v_page_options',$this->data,TRUE);
        $this->data['menu']=$this->load->view('yonet/inc/v_sidebar','',TRUE);
        $this->data['page']=$this->load->view('yonet/inc/v_frm_page',$this->data,TRUE);
        $this->data['footer']=$this->load->view('yonet/inc/v_footer','',TRUE);
        $this->load->view('yonet/v_home',$this->data);
        session_write_close();
    }
    /*tip cat ise form harici cat verilerini hazirlar*/
    function cat($id='',$translate=''){
        $add='';
        if($translate!=""){
            $add=" (Yeni Çeviri Sayfası) ";
        }
        if($id!="" && $translate==""){
            $this->data['inc_page_header']="KATEGORİYİ  GÜNCELLE ".$add;
        }else if($id=='' && $tranlsate==''){
            $this->data['inc_page_header']="YENİ KATEGORİ";
        }else if($id!="" && $translate!=""){
            $this->data['inc_page_header']="KATEGORİ ÇEVİRİSİ";
        }
        $this->data['page_options']=$this->load->view('yonet/module/v_page_options',$this->data,TRUE);
        
    }
    /*tip con ise form harici con verileri hazirlar*/
    function txt($id,$translate){
     $add='';
        if($translate!=""){
            $add=" (Yeni Çeviri Sayfası) ";
        }
        if($id!="" && $translate==""){
            $this->data['inc_page_header']="SAYFAYI  GÜNCELLE ".$add;
        }else if($id=='' && $tranlsate==''){
            $this->data['inc_page_header']="YENİ SAYFA";
        }else if($id!="" && $translate!=""){
            $this->data['inc_page_header']="SAYFA ÇEVİRİSİ";
        }
        $this->data['page_options']=$this->load->view('yonet/module/v_page_options',$this->data,TRUE);
    }
    /*tip fol ise form harici fol verileri hazirlar*/
    function fol(){
        $this->data['pageTypeName']="KLASÖR İÇERİĞİ";
    }
    
    public function form_create($frmVal){
        $pub= ($frmVal["pub"]=="y")? 1:0;
        $index= ($frmVal["index"]=="y")? 1:0;
        
        $this->data ["form"] ["open"] 			= form_open ( 'yonet/page/save','enctype="multipart/form-data"  class="form-horizontal" id="pageFrm"' );
        $this->data ["form"] ["url"] 			= form_input ( 'url',htmlspecialchars_decode($frmVal['url'],ENT_QUOTES),'id="url" class="form-control" data-fv-field="url"' );
        $this->data ["form"] ["name"] 		    = form_input ( 'name',htmlspecialchars_decode($frmVal['name'],ENT_QUOTES),'id="name" class="form-control"' );
        $this->data ["form"] ["header"] 		= form_input ( 'header',htmlspecialchars_decode($frmVal['header'],ENT_QUOTES),'id="header" class="form-control"' );
        $this->data ["form"] ["key"] 			= form_input ( 'key',htmlspecialchars_decode($frmVal['key'],ENT_QUOTES),'id="key" class="form-control"' );
        $this->data ["form"] ["desc"] 	        = form_input ( 'desc',htmlspecialchars_decode($frmVal['desc'],ENT_QUOTES),'id="desc" class="form-control"' ); 
        $this->data ["form"] ["template"] 		= form_dropdown ( 'template',$this->templateList,$frmVal['template'],'class="form-control"' );
        $this->data ["form"] ["index"] 			= form_checkbox ( 'index','y',$index,'class="checkbox"' );
        $this->data ["form"] ["pub"] 			= form_checkbox ( 'pub','y' ,$pub,'class="checkbox"');
        $this->data ["form"] ["content"] 		= form_textarea( 'content',htmlspecialchars_decode($frmVal['content'],ENT_QUOTES),'class="form-control short-text" ng-model="myform.comment" id="content" style="margin-top: 0px;" ' );
        $this->data ["form"] ["longtext"] 		= form_textarea( 'longtext',htmlspecialchars_decode($frmVal['longtext'],ENT_QUOTES),'class="form-control" id="summernote" style="margin-top: 0px;"' );
        $this->data ["form"] ["id"] 			= form_hidden ( 'id',$frmVal['id'] );
        $this->data ["form"] ["typ"] 			= form_hidden ( 'typ',$this->selectPageTyp );
        $this->data ["form"] ["cuser"] 			= form_hidden ( 'cuser',$this->session->userdata('id') );
        $this->data ["form"] ["lng"] 			= form_hidden ( 'lng',$frmVal['lng'] );
        $this->data ["form"] ["language"] 		= form_hidden ( 'language',$frmVal["language"] );
        $this->data ["form"] ["tag"] 			= form_input ('tag',$frmVal['tag'],'id="desc" class="form-control"' );
        $this->data ["form"] ["button"] 		= form_submit ( 'kaydet', "Kaydet",'class="form-control btn-success pull-right"' );
        $this->data ["form"] ["close"] 			= form_close ();
    }
    
    
    public function save(){
    
        $lastInsertId="";
        if($_POST){
            $this->load->library('form_validation');
            $this->form_validation->set_rules ( 'url', "url", "required|regex_match[/^[a-zA-Z0-9\s\-]+$/]|strip_tags|xss_clean|min_length[3]|max_length[255]" );
            $this->form_validation->set_rules ( 'name', "Link adı", "required|strip_tags|xss_clean|min_length[3]|max_length[255]" );
            $this->form_validation->set_rules ( 'header', "Title", "required|strip_tags|xss_clean|min_length[3]|max_length[255]" );
            $this->form_validation->set_rules ( 'key', "key", "strip_tags|xss_clean|max_length[170]" );
            $this->form_validation->set_rules ( 'desc', "description", "strip_tags|xss_clean|max_length[170]" );
            $this->form_validation->set_rules ( 'template', "template", "required|strip_tags|xss_clean" );
            $this->form_validation->set_rules ( 'index', "index", "strip_tags|xss_clean" );
            $this->form_validation->set_rules ( 'pub', "yayın", "strip_tags|xss_clean" );
            $this->form_validation->set_rules ( 'content', "Kısa Metin", "xss_clean" );
            $this->form_validation->set_rules ( 'longtext', "İçerik Metni", "xss_clean" );
            $this->form_validation->set_rules ( 'typ', "type", "xss_clean" );
            $this->form_validation->set_rules ( 'tag', "etiketler", "xss_clean" );
            $this->form_validation->set_rules ( 'lng', "dil", "xss_clean" );
          
            
            $error = $this->form_validation->run ();
            $val=array( 'url'			=>set_value('url'),
                        'name'			=>set_value('name'),
                        'header'		=>set_value('header'),
                        'key'			=>set_value('key'),
                        'desc'	        =>set_value('desc'),
                        'template'		=>set_value('template'),
                        'index'			=>set_value('index') == "" ? "n":"y",
                        'id'			=>set_value('id'),
                        'cuser'			=>set_value('cuser'),
                        'content'		=>set_value('content'),
                        'longtext'		=>set_value('longtext'),
                        'typ'			=>set_value('typ'),
                        'lng'			=>set_value('lng'),
                        'tag'			=>set_value('tag'),
                        'pub'			=>set_value('pub') );
           $language=set_value('language');
           if($error){
                if($val["id"]==""){
                    if(! $lastInsertId = $this->simple_model->insert('page',$val)){
                        $this->session->set_flashdata("error",Array('txt'=>'Veriler Yazdırılırken Hata Oluştu','logic'=>'false'));
                    }else{
                        if($language=="" && multi_language){
                            $this->simple_model->insert("language",Array("table"=>'page',$val["lng"]=>$lastInsertId));
                        }else if($language!="" && multi_language){
                            $this->simple_model->updateWhere('language',Array($val['lng']=>$lastInsertId),Array('lngid'=>$language));
                        }
                        
                        $this->session->set_flashdata("error",Array('txt'=>'Veriler Başarıyla Kaydedildi','logic'=>'true'));
                        
                    }
                }else{
                    $this->simple_model->update('page',$val,array("id",$val["id"]));
                    $lastInsertId = $val["id"];
                    $this->session->set_flashdata("error",Array('txt'=>'Veriler Başarıyla Güncellendi','logic'=>'true'));
                }
            }else{
                $this->session->set_flashdata("frmVal",$val);
                $this->session->set_flashdata("error",Array('txt'=>validation_errors(),'logic'=>'false'));
            }
            redirect(adminbase('page/create/'.$val['typ'].'/'.$lastInsertId));
        }
    }
    
    
    
    function cat_list(){
        $this->load->library("my_page_cat");
        $list=$this->my_page_cat->listArray($this->session->userdata("activeLng")["alias"]);
        $this->data["catList"]=$this->my_page_cat->selectFullList($list,1);
        
        $this->data['inc_page_header']="TÜM KATEGORİLER";
        $this->my_lang->singleTranslateLng($this->session->userdata('activeLng')['alias']);
        $this->data['page_options']=$this->load->view('yonet/module/v_page_options',$this->data,TRUE);
        $this->data['menu']=$this->load->view('yonet/inc/v_sidebar','',TRUE);
        $this->data['page']=$this->load->view('yonet/inc/v_list_category',$this->data,TRUE);
        $this->data['footer']=$this->load->view('yonet/inc/v_footer','',TRUE);
        $this->load->view('yonet/v_home',$this->data);
        session_write_close();
    }
    
    function txt_list($orderBy="cdate-desc",$page='0'){
        $arrOrderBy=explode("-", $orderBy);
        $lng=$this->session->userdata('activeLng')['alias'];
        $sizeTxt = $this->simple_model->selectCount('page',Array('lng'=>$lng,'typ'=>'txt'));
        $this->data["txtList"] = $this->simple_model->selectLimit('page',$this->limit_page,$page,Array('lng'=>$lng,'typ'=>'txt'),$arrOrderBy[0].' '.$arrOrderBy[1]);
       
        $this->data['inc_page_header'] = 'TÜM İÇERİK SAYFALARI';
        $this->my_lang->singleTranslateLng($this->session->userdata('activeLng')['alias']);
        $this->data['page_options'] = $this->load->view('yonet/module/v_page_options',$this->data,TRUE);
        $this->data["pagination"] = $this->createPagination('txt_list',$sizeTxt, $orderBy, $page);
        $this->data['menu']=$this->load->view('yonet/inc/v_sidebar','',TRUE);
        $this->data['page']=$this->load->view('yonet/inc/v_list_txt',$this->data,TRUE);
        $this->data['footer']=$this->load->view('yonet/inc/v_footer','',TRUE);
        $this->load->view('yonet/v_home',$this->data);
        session_write_close();
    }    
   
    function translateBar(){
        foreach ($this->my_lang->translateLng as $tIndex=>$tVal){
            if($tVal['id']!=""){
                if($tVal["pageId"]==""){
                    $this->data["translateLink"] .= '&nbsp;<a href="'.adminbase("page/create/".$this->selectPageTyp.'/'.$tVal['id'].'/'.$tVal['alias']).'">'.
                        img($tVal['flag']).' </a>';
                }else{
                    $this->data["translateLink"] .= '&nbsp;<a href="'.adminbase("page/create/".$this->selectPageTyp.'/'.$tVal['pageId']).'">'.
                        img($tVal['flag']).' </a>';
                }
            }
        }
    }
    
    function createPagination($page_alias,$listSize,$order,$start){
    
        $this->load->library('pagination');
        $config['base_url'] = adminbase('page/'.$page_alias.'/'.$order.'/');
        $config['total_rows'] = $listSize;
        $config['per_page'] = $this->limit_page;
        $config['uri_segment']=5;
        //$config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($config);
        $pageLinks=$this->pagination->create_links();
        return $pageLinks;
    }
    
    function page_delete(){
        $id = $this->input->post('id');
        if( is_numeric($id)){
           
           $values= $this->simple_model->selectValue('page',Array('id'=>$id))[0];
          
          
           switch ($values['typ']){
               case 'cat':
                    $this->simple_model->delete('pagecross',Array('detail'=>$id));        
                    $this->simple_model->delete('pagecross',Array('master'=>$id));        
                    $this->simple_model->delete('filecross',Array('master'=>$id));        
                    if($this->simple_model->delete('page',Array('id'=>$id))){
                        
                        echo 'true';
                    }else{
                         echo 'false';
                    }        
                   break;
               case 'txt':
                  
                   $this->simple_model->delete('pagecross',Array('detail'=>$id));
                  
                   if($this->simple_model->delete('page',Array('id'=>$id))){
                       
                        echo 'true';
                   }else{
                       echo 'false';
                   }
                   break;
               case 'fol':
                   break;
           }
           
           if(multi_language){
                /*language tablosundan silinecekler*/
           }
        }else{
          
        }
       
        
    } 
}