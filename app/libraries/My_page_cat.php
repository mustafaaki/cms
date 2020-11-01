<?php 
class my_page_cat {
    protected $CI;
    public $whereAdd;
    public function __construct()
    {
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
    }

    public function listArray($lng,$where=''){
        /*ana kategori listesi*/
       
        if($where!='')
                $this->whereAdd = 'and '.$where;
        $this->CI->load->model("simple_model");
        $sql='select id,typ,header,pub,page.order,page.url from page where typ="cat" and id not in (select detail from pagecross where pagecross.typ="cat") and'.
        ' page.lng="'.$lng.'" '.$this->whereAdd.' order by page.order asc ,cdate asc ';
        $val=$this->CI->simple_model->sqlrun($sql);//tum ana kategoriler
      
        foreach($val as $x=>$y){
            $listArray[$y["id"]]=Array("id"=>$y["id"],"alias"=>$y["header"],"pub"=>$y["pub"],"order"=>$y["order"],"url"=>$y['url']);
            $val2=$this->queryForCatList($y["id"],$lng);//id si 1.derece  alt kategorisi olanlar
           
            foreach($val2 as $x2=>$y2){
              $count2++;
              $listArray2[$y2["detail"]]=Array("id"=>$y2["detail"],"alias"=>$y2["dheader"],"pub"=>$y2["pub"],"order"=>$y2["order"],"url"=>$y2['url']);
              $val3=$this->queryForCatList($y2["detail"],$lng);//ana kategoriye bagli olanlarin bilgileri
                  foreach($val3 as $x3=>$y3){
                      $count3++;
                      $listArray3[$y3["detail"]]=Array("id"=>$y3["detail"],"alias"=>$y3["dheader"],"pub"=>$y3["pub"],"order"=>$y3["order"],"url"=>$y3['url']);
                      $val4=$this->queryForCatList($y3["detail"],$lng);
                      foreach($val4 as $x4=>$y4){
                          $count4++;
                          $listArray4[$y4["detail"]]=Array("id"=>$y4["detail"],"alias"=>$y4["dheader"],"pub"=>$y4["pub"],"order"=>$y4["order"],"url"=>$y4['url']);
                          $val5=$this->queryForCatList($y4["detail"],$lng);;
                          foreach($val5 as $x5=>$y5){
                              $count5++;
                              $listArray5[$x5]=Array("id"=>$y5["detail"],"alias"=>$y5["dheader"],"pub"=>$y5["pub"],"order"=>$y5["order"],"url"=>$y5['url']);
                              
                          }
                          if($count5>0){$listArray4[$y4["detail"]]["sub"]=$listArray5;}
                         
                      }
                      if($count4>0){ $listArray3[$y3["detail"]]["sub"]=$listArray4;}
                     
                  }
                  if($count3>0){ $listArray2[$y2["detail"]]["sub"]=$listArray3;}  
            }
            if($count2>0){$listArray[$y["id"]]["sub"]=$listArray2;}
        }
        
        return $listArray;
    }
    
    function getPagecrossValues($id){
       
       $value=$this->CI->simple_model->selectValue("pagecross",Array('detail'=>$id));
       $this->CI->db->last_query();
       return $value;
    }
    
    function queryForCatList($id,$lng){
        $sql='select p.id,pc.detail,(select header from page where page.id=pc.detail) as dheader,p.pub,p.order  from pagecross as pc LEFT JOIN page as p ON(pc.detail=p.id)
            where p.typ="cat" and p.lng="'.$lng.'" and pc.typ="cat" and pc.master='.$id.' '.$this->whereAdd . ' order by p.order asc ,p.cdate asc ';
        return $this->CI->simple_model->sqlrun($sql);
    }
    
    function selectBoxList($list,$id=""){

        foreach( $list as $x=>$y){
            //if($y['id']==$id && $id!=""){ continue;}
            $select[$y['id']] = $y["alias"];
            if(is_array($y['sub'])){
                foreach($y['sub'] as $x2=>$y2){
                    if($y2['id']==$id && $id!=""){ continue;}
                    $select[$y2['id']] = "----".$y2["alias"];
                    if(is_array($y2['sub'])){
                        foreach($y2['sub'] as $x3=>$y3){
                            if($y3['id']==$id && $id!=""){ continue;}
                            $select[$y3['id']] = "------".$y3["alias"];
                            if(is_array($y3['sub'])){
                                foreach($y3['sub'] as $x4=>$y4){
                                    if($y4['id']==$id && $id!=""){ continue;}
                                    $select[$y4['id']] = "--------".$y4["alias"];
                                    if(is_array($y4['sub'])){
                                        foreach($y4['sub'] as $x5=>$y5){
                                            if($y4['id']==$id && $id!=""){ continue;}
                                            $select[$y5['id']] = "----------".$y5["alias"];
                                        }
                                    } 
                                }
                            }
                            
                        }
                    }
                    
                }
            }
        
        }
        return $select;
    }
    
    function selectFullList($list,$nbr=1){
        
        foreach( $list as $x=>$y){
            $select[$y['id']] = array("nbr"=>1*$nbr,"alias"=>$y["alias"],"pub"=>$y["pub"],"order"=>$y["order"]);
            if(is_array($y['sub'])){
                foreach($y['sub'] as $x2=>$y2){
                    $select[$y2['id']] = array("nbr"=>5*$nbr,"alias"=>$y2["alias"],"pub"=>$y2["pub"],"order"=>$y2["order"]);
                    if(is_array($y2['sub'])){
                        foreach($y2['sub'] as $x3=>$y3){
                            $select[$y3['id']] = array("nbr"=>10*$nbr,"alias"=>$y3["alias"],"pub"=>$y3["pub"],"order"=>$y3["order"]);
                            if(is_array($y3['sub'])){
                                foreach($y3['sub'] as $x4=>$y4){
                                    $select[$y4['id']] = array("nbr"=>15*$nbr,"alias"=>$y4["alias"],"pub"=>$y4["pub"],"order"=>$y4["order"]);
                                    if(is_array($y4['sub'])){
                                        foreach($y4['sub'] as $x5=>$y5){
                                            $select[$y5['id']] = array("nbr"=>20*$nbr,"alias"=>$y5["alias"],"pub"=>$y5["pub"],"order"=>$y5["order"]);
                                        }
                                    }
                                }
                            }
    
                        }
                    }
    
                }
            }
    
        }
        return $select;
    }
    
    
   
}

?>