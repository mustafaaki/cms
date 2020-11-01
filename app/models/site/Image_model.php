<?php
class image_model extends CI_Model {
	
	function __construct() {
		parent::__construct ();
		$this->load->database (); //database bağlantısı yapıyoruz.
	}
	
	function get_image($array,$limit,$start,$order){
	    
	    $this->db->select ( '*' );
	    $this->db->from ( 'file' );
	    $this->db->join('filetxt', 'filetxt.refId = file.id and filetxt.lng="'.$this->user_lang.'"','left');
	    $this->db->where($array);
	    $this->db->limit($limit,$start);
	    $this->db->order_by($order);
	    $query = $this->db->get ();
	    $values = $query->result_array ();
	    
	    return $values;
	}
	
}