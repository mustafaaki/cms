<?php
class search_model extends CI_Model {
	
	function __construct() {
		parent::__construct ();
		$this->load->database (); //database bağlantısı yapıyoruz.
	}
	
	function search_key($keys,$per_page,$start){ 
	  
	    $this->db->select ( '*' );
	    $this->db->from ( 'page' );
	    $this->db->group_start();
	    $this->db->where ( Array('pub'=>'y',"lng"=>$this->user_lang) );
	    $this->db->group_end();
	    $this->db->group_start();
	    $this->db->like('header', $keys); 
	    $this->db->or_like('tag', $keys);
	    $this->db->group_end();
	    $this->db->limit($per_page,$start);
	    $query = $this->db->get ();
	    $values = $query->result_array ();
	    return $values;
	}
	
	function search_key_count($keys){
	    $this->db->select ( 'count()' );
	    $this->db->from ( 'page' );
	    $this->db->group_start();
	    $this->db->where ( Array('pub'=>'y',"lng"=>$this->user_lang) );
	    $this->db->group_end();
	    $this->db->group_start();
	    $this->db->like('header', $keys);
	    $this->db->or_like('tag', $keys);
	    $this->db->group_end();
	   
	    
	    $count = $this->db->count_all_results();
	    
	    return $count;
	}
	
	
}