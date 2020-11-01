<?php
class home_model extends CI_Model {
	
	function __construct() {
		parent::__construct ();
		$this->load->database (); //database bağlantısı yapıyoruz.
	}
	
	function news($array,$order){
	    
	    $this->db->select ( 'news.cdate as cdate, 
	                         news.lng as lng, 
	                         news.order as order,
	                         file.id as fileId, 
	                         news.img as img, 
	                         file.name as file_name, 
	                         file.ext as file_ext, 
	                         filetxt.header as alt, 
	                         news.id as id, 
	                         news.pub as pub, 
	                         news.position as position, 
	                         news.header as header, 
	                         news.text as text, 
	                         news.flash as flash, 
	                         news.url as url' );
	    $this->db->from ( 'news' );
	    $this->db->join('file', 'news.img = file.id' , 'left');
	    $this->db->join('filetxt', 'filetxt.refId = file.id and filetxt.lng="'.$lng.'"','left');
	    $this->db->where($array);
	    $this->db->order_by($order);
	    $query = $this->db->get ();
	    $values = $query->result_array ();
	    
	    return $values;
	}
	
}