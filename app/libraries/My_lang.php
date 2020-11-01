<?php 
class my_lang {
    protected $CI;
    public $activeLng;
    public $deactiveLng;
    public $contentLng;
    public $translateLng;
    public $translateList;
    public $singleLngName="Türkçe";
    public $singleLngAlias="tr";
    public $singleLngFlag="tr.png";
    public $flagPath="img/lang/";
    public $lngFile;
    
    public function __construct()
    {
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
        $this->lngFile = json_decode(file_get_contents(base_url("json/langSettings.php")),TRUE);
    }

    public function getLang()
    {  
        /*json dosyasi okunuyor*/
        
        
        /*dil verisine gore (tek yada coklu dil secenegine gore obje oluşturuluyor) */
        $size=sizeof($this->lngFile["lang"]);
        foreach($this->lngFile["lang"] as $x=>$y){
            if($y["default"]=="y"){
                $this->activeLng=array("alias"=>$x,"name"=>$y["name"],"flag"=>$this->flagPath."bw-".$y["flag"]);
            }else{
                
                $this->deactiveLng[$x]=Array("alias"=>$x,"name"=>$y["name"],"flag"=>$this->flagPath.$y["flag"]);
            }
        }
    }
    
   /* dil degerleri oturuma kaydediliyor, burasi ayrica paneldeki dil seceneklerinin gosterimi icin onemli */
   public function setSessionLng(){
       $this->CI->session->set_userdata(Array("activeLng"=>$this->activeLng));
       $this->CI->session->set_userdata(Array("deactiveLng"=>$this->deactiveLng));
   }
    
   /*oturumdaki dil degerleri degistiriliyor, burasi ayrica paneldeki dil seceneklerinin gosterimi icin onemli*/
    public function changeAdminLng($lng){
       
        
        /*dil verisine gore (tek yada coklu dil secenegine gore obje oluşturuluyor) */
        $size=sizeof($this->lngFile["lang"]);
        /*dosyadaki dil secenekleri sabit degerlerler default secilen dile gore ataniyor*/
        foreach($this->lngFile["lang"] as $x=>$y){
            if($x==$lng){
                $this->activeLng=array("alias"=>$x,"name"=>$y["name"],"flag"=>$this->flagPath."bw-".$y["flag"]);
            }else{
                $count++;
                $this->deactiveLng[$count]=Array("alias"=>$x,"name"=>$y["name"],"flag"=>$this->flagPath.$y["flag"]);
            }
        }
        /*degistirilen degerler ataniyor*/
        $this->setSessionLng();
        
        
    }
    public function getSessionLng(){
        $this->activeLng=$this->CI->session->userdata("activeLng");
        $this->deactiveLng=$this->CI->session->userdata("deactiveLng");
    }
        
    public function translateLng($contentLng,$languages){
        /*dil verisine gore (tek yada coklu dil secenegine gore obje oluşturuluyor) */
        $size=sizeof($this->lngFile["lang"]);
        /*dosyadaki dil secenekleri sabit degerlerler default secilen dile gore ataniyor*/
        foreach($this->lngFile["lang"] as $x=>$y){
            if($x==$contentLng){
                $this->contentLng=array("alias"=>$x,"name"=>$y["name"],"flag"=>$this->flagPath."bw-".$y["flag"]);
            }else{
                $count++;
                $this->translateLng[$count]=array("alias"=>$x,"name"=>$y["name"],"flag"=>$this->flagPath.$y["flag"],"id"=>$languages['lngid'],"pageId"=>$languages[$x]);
            }
        }
    }
    
    function singleTranslateLng($contentLng){
       
        
        /*dil verisine gore (tek yada coklu dil secenegine gore obje oluşturuluyor) */
        $size=sizeof($this->lngFile["lang"]);
        /*dosyadaki dil secenekleri sabit degerlerler default secilen dile gore ataniyor*/
        foreach($this->lngFile["lang"] as $x=>$y){
            if($x==$contentLng){
            $this->contentLng = $this->contentLng=array("alias"=>$x,"name"=>$y["name"],"flag"=>$this->flagPath."bw-".$y["flag"]);
            }
        }
    }
    
    function  getTranslateList(){
        /*dil verisine gore (tek yada coklu dil secenegine gore obje oluşturuluyor) */
        $size=sizeof($this->lngFile["lang"]);
        /*dosyadaki dil secenekleri sabit degerlerler default secilen dile gore ataniyor*/
        foreach($this->lngFile["lang"] as $x=>$y){
                $count++;
                $this->translateList[$count]=array("alias"=>$x,"name"=>$y["name"],"flag"=>$this->flagPath.$y["flag"],"id"=>$languages['lngid'],"pageId"=>$languages[$x]);
        }
        return $this->translateList;
    }
    
    /*icerigin idsine gore language tablosundaki verileri geri dondurur.*/
    public function searchLanguageId($objectId,$table){
        $arr = $this->getLangArr();
        
        $this->CI->load->model("yonet/lang_model");
        
        $val=$this->CI->lang_model->where_in_id($objectId,$table,$arr);
        return $val;
    }
    
    /*lngid verisine göre verileri dondurur*/
    public function getLanguageVal($id){
        $val=$this->CI->simple_model->selectValue('language',Array('lngid'=>$id));
        
        return $val;
    }
    
    public function getLangArr(){
       // print_r($this->lngFile);
        foreach($this->lngFile["lang"] as $x=>$y){
            $count++;
            $arr[$count]=$x;
        }
        return $arr;
    }
    
    public function getFullLang(){
       return $this->lngFile["lang"];
    }
    
    
   
}

?>