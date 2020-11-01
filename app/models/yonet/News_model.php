<?php
class news_model extends CI_Model {
	
	function __construct() {
		parent::__construct ();
		$this->load->database (); //database bağlantısı yapıyoruz.
	}
	
	function selectLimitJoin($perPage,$start,$where="",$orderBy="" ,$orderPosition="") {
	    
	    $this->db->select ( "news.cdate as cdate, news.lng as lngs, news.order as order,file.id as fileId,news.img as img, file.name as fileName, file.ext as fileExt, news.id as id, news.pub as pub, news.header as header, news.order as order" );
	    $this->db->from ( "news" );
	    $this->db->join('file', 'news.img = file.id','left');
	    
	   if(is_array($where)){
	        $this->db->where($where);
	        
	    }
	   
	   $this->db->limit($perPage,$start);
	   
	   if($orderBy!="" && $orderPosition!=""){
	      
	        $this->db->order_by($orderBy,$orderPosition);
	   }
	   
	    $query = $this->db->get ();
	    
	    $result=$query->result();
	    //print_r($result);
	    return $result;
   }

}