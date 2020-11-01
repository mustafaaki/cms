<?php
class template_model extends CI_Model {
	
	function __construct() {
		parent::__construct ();
		$this->load->database (); //database bağlantısı yapıyoruz.
	}
	
	function templateList($typ="cat"){
		$this->db->select('templateId,templateName');
		$this->db->from('template');
		$this->db->where('templateGroup', $typ);
		//$sql="select * from ci_template where templateGroup='".$typ."'";
		$rows=$this->db->get();
		$result=$rows->result_array();
		foreach($result as $k=>$c){
			$val[$c['templateId']]=$c['templateName'];
		}
	
		return $val;
	}	
}