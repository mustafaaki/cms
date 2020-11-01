<?php
class page_model extends CI_Model {
	
	function __construct() {
		parent::__construct ();
		$this->load->database (); //database bağlantısı yapıyoruz.
	}
	
	/*id icerigin idsi, table id nin bulundugu tablo, column ceviri tablosundaki aranacak kolonlar*/
	function get_value($id,$lng='lng'){
	   
		$this->db->select($lng);
		$this->db->from('page');
	
		$this->db->where(Array('id'=>$id));
		$rows=$this->db->get();
		$result=$rows->result_array();
		return $result[0];
	}	
}