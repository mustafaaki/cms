<?php
class lang_model extends CI_Model {
	
	function __construct() {
		parent::__construct ();
		$this->load->database (); //database bağlantısı yapıyoruz.
	}
	
	/*id icerigin idsi, table id nin bulundugu tablo, column ceviri tablosundaki aranacak kolonlar*/
	function where_in_id($id,$table,$column){
	    $sqlAdd="";
	    $sqlWhere="";
		$this->db->select('*');
		$this->db->from('language');
		$sqlWhere='table="'.$table.'" and (';
		$size=sizeof($column);
		
		foreach($column as $y){
		    if($size>1){
		    $count++;
    		    if($count<$size){
    		        $sqlAdd.= $y.' = '.$id.' or ';
    		    }else{
    		        $sqlAdd.= $y.' = '.$id.' )';
    		    }
		    }else{
		        $sqlWhere='table="'.$table.'" and '.$y.'='.$id;
		    }
		}
		$this->db->where($sqlWhere.$sqlAdd);
		$rows=$this->db->get();
		$result=$rows->result_array();
		return $result[0];
	}	
}