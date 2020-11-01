<?php
class file_model extends CI_Model {
	
	function __construct() {
		parent::__construct ();
		$this->load->database (); //database bağlantısı yapıyoruz.
	}
	
	function search_file($where,$like,$lng){
		$this->db->select('file.id as file_id,file.name,file.ext,filetxt.header as header');
		$this->db->from('file');
		$this->db->join('filetxt','filetxt.refId = file.id and filetxt.lng =\''.$lng.'\'','left');
		$this->db->where( $where );
		$this->db->group_start();
		$this->db->like('file.name', $like);
		$this->db->or_like('filetxt.tag', $like);
		$this->db->or_like('filetxt.header', $like);
		$this->db->group_end();
		$rows=$this->db->get();
		$result=$rows->result_array();
	    //echo $this->db->last_query();
		return $result;
	}	
	
	
	function file_list_for_page($where,$lng){
	    $this->db->select('file.id as file_id,file.name,file.ext,filetxt.header,filecross.master,filecross.position,filecross.id as cross_id,filecross.order,filecross.pub ');
	    $this->db->from('file');
	    $this->db->join('filecross','file.id = filecross.detail','left');
	    $this->db->join('filetxt','filecross.detail=filetxt.refId and filetxt.lng=\''.$lng.'\'','left');
	    $this->db->where( $where );
	    $this->db->order_by('filecross.order', 'desc');
	    
	    $rows=$this->db->get();
	    $result=$rows->result_array();
	    //echo $this->db->last_query();
	    return $result;
	    
	}
	
	function get_filtxt_id($lng,$imgid){
	    
	}
}