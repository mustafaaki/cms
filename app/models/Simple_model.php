<?php
class simple_model extends CI_Model {
	function __construct() {
		parent::__construct ();
		$this->load->database (); //database bağlantısı yapıyoruz.
	}
	
	function insert($table, $data) {
		if ($this->db->insert ( $table, $data )) {
			return $this->db->insert_id();
		}else{ 
			return false;
		}
	}
	function insert_batch($table, $data) {
	    if ($this->db->insert_batch( $table, $data ))
	        return true;
	    else
	        return false;
	}
	
	function update($table, $data, $id ) {
		$where = $id[0] . " = ". $id[1];
		if ($this->db->update ( $table, $data, $where ))
			return true;
		else
			return false;
	}
	
	function updateWhere($table,$data,$where){
		if ($this->db->update ( $table, $data, $where ))
			return true;
		else
			return false;
	}
	
	function updateSetSum($table, $sum, $id="" ) {
		$this->db->where($id);
		if($sum>0)
			$this->db->set('pageStep' , 'pageStep+'.$sum,FALSE);
		else if($sum<0)
			$this->db->set('pageStep' , 'pageStep'.$sum,FALSE);
		if ($this->db->update ($table))
			return true;
		else
			return false;
	}
	
	function selectedValues($table,$id,$idCname=""){
		$this->db->select ( "*" );
		$this->db->from ( $table );
		if($idCname=="")
		$this->db->where ( $id);
		else
		$this->db->where ( $idCname . " = " . $id );
		
		$query = $this->db->get ();
		$values = $query->row ();
		//echo $this->db->last_query();
		return $values;
	}
	function selected_vvalues($table,$id,$idCname=""){
	    $this->db->select ( "*" );
	    $this->db->from ( $table );
	    if($idCname=="")
	        $this->db->where ( $id);
	    else
	        $this->db->where ( $idCname . " = " . $id );
	
	    $query = $this->db->get ();
	    $values = $query->row ();
	    //echo $this->db->last_query();
	    return $values;
	}
	function selectValue($table,$arr){
	    $this->db->select ( "*" );
	    $this->db->from ( $table );
        $this->db->where ( $arr);
	    $query = $this->db->get ();
	    $values = $query->result_array ();
	    //echo $this->db->last_query();
	    return $values;
	}
	function selectValuesOrder($table,$arr,$order){
	    $this->db->select ( "*" );
	    $this->db->from ( $table );
	    $this->db->where ( $arr);
	    $this->db->order_by($order);
	    $query = $this->db->get ();
	    $values = $query->result_array ();
	    //echo $this->db->last_query();
	    return $values;
	}
	
	function selectOrWhere($table,$arr){
	    $this->db->select ( "*" );
	    $this->db->from ( $table );
	    $this->db->or_where_in ( $arr);
	    $query = $this->db->get ();
	    $values = $query->row ();
	    //echo $this->db->last_query();
	    return $values;
	}
	function delete($table, $arr){
	
		if($this->db->delete($table, $arr))
			return true;
		else
			return false;
	}
	function deleteWhereIn($table,$ref,$arr){
		$this->db->where_in($ref,$arr);
		if($this->db->delete($table))
			return true;
		else
			return false;
	}
	
	function select($table){
		$this->db->select ( "*" );
		$this->db->from ( $table );
		$query = $this->db->get ();
		$result=$query->result();
		return $result;
	}
	
	function selectLimit($table,$perPage,$start,$where="",$orderBy="") {
		$this->db->select ( "*" );
		$this->db->from ( $table );
		if(is_array($where) || $where!="")
			$this->db->where($where);
		
		$this->db->limit($perPage,$start);
		
		if($orderBy!="")
			$this->db->order_by($orderBy);
		
		$query = $this->db->get ();
		//echo $this->db->last_query();
		$result=$query->result_array();
		return $result;
	}
	
	function selectCount($table, $where=""){
		$this->db->select();
		$this->db->from($table);
		if($where!="")
			$this->db->where ( $where );
		return $this->db->count_all_results();
	}
	
	function selectNumRows($table,$where){
	    $this->db->select('*');
	    $this->db->from($table);
	    $this->db->where($where);
	    $query = $this->db->get();
	    $num_rows= $query->num_rows();
	    return $num_rows;
	}
	
	function selectWhere($table,$where){
		$this->db->select();
		$this->db->from($table);
		if($where!="")
			$this->db->where ( $where );
		//$result["count"]=$this->db->count_all_results();
		
		$result = $this->db->get ();
		
		//$result["val"]= $result["list"]->result();
		
		return $result;
	}
	
	function sqlrun($sql){
	    $rows=$this->db->query($sql);
	    $val=$rows->result_array();
	    return $val;
	}
	function sqlcount($sql){
	    $rows=$this->db->query($sql);
	    $num_rows= $rows->num_rows();
	    return $num_rows;
	}
	
	function select_count($table,$arr){
	    $this->db->select ( "*" );
	    $this->db->from ( $table );
	    $this->db->where ( $arr);
	    $values =  $this->db->count_all_results();
	    return $values;
	}
}