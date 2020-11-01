<?php
class login_model extends CI_Model {
	
	public function __construct() {
		parent::__construct ();
		$this->load->database (); //database baglan.
	}
	
	
	public function loginCheck($email, $pass) {
	   
		$this->db->select ( '*' );
		$this->db->from ( 'admin' );
		$this->db->where ( 'email = \'' .$email . '\'' );
		$this->db->where ( 'pass = \'' . $pass  . '\'' );
		
		$query = $this->db->get ();
		return $query;
	}

}
?>