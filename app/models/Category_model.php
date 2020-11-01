<?php
class category_model extends CI_Model {
	
	function __construct() {
		parent::__construct ();
		$this->load->database (); //database bağlantısı yapıyoruz.
	}
	
	function list_master_cat(){
		$this->db->select('*');
		$this->db->from('page');
		$this->db->where('templateGroup', $typ);
		//$sql="select * from ci_template where templateGroup='".$typ."'";
		$rows=$this->db->get();
		$result=$rows->result_array();
		foreach($result as $k=>$c){
			$val[$c['templateId']]=$c['templateName'];
		}
	
		return $val;
	}
	function master_cat($lng,$where){
	    $sql='select id,typ,header,pub,page.order from page'.
	         'where typ="cat" and id not in '.
	         '(select detail from pagecross where pagecross.typ="cat") and '.
	         'page.lng="'.$lng.'" '.$where.' order by page.order asc ,cdate asc ';
	    
	    
	    $rows=$this->db->query($sql);
	    $val=$rows->result_array();
	    return $val;
	}
}