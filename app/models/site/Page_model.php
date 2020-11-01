<?php
class page_model extends CI_Model {
	
	function __construct() {
		parent::__construct ();
		$this->load->database (); //database bağlantısı yapıyoruz.
	}
	
	function get_page_file($page_id){
	   
	    $this->db->select ( '*' );
	    $this->db->from ( 'filecross' );
	    $this->db->join('file', 'file.id = filecross.detail');
	    $this->db->join('filetxt', 'filetxt.refId = file.id and filetxt.lng="'.$this->user_lang.'"','left');
	    $this->db->where(Array('filecross.master'=>$page_id));
	    $this->db->order_by('filecross.order','asc');
	    $query = $this->db->get ();
	    $values = $query->result_array ();
	    
	    return $values;
	}
	
	function get_map($page_id){
	    $this->db->select ( '*' );
	    $this->db->from ( 'map' );
	   
	    $this->db->where(Array('refId'=>$page_id));
	    $query = $this->db->get ();
	    $values = $query->result_array ();
	    return $values;
	}
	
	function get_template($templateId){
	    $this->db->select ( '*' );
	    $this->db->from ( 'template' );
	    $this->db->where(Array('templateId'=>$templateId));
	    $query = $this->db->get ();
	    $values = $query->result_array ();
	    return $values[0];
	}
	
	function sub_order_content(){
	    
	}
	function get_sub_content($page_id,$limit,$start,$order){
	   
	    $array=Array('pagecross.master'=>$page_id,'page.pub'=>'y');
	    $this->db->select ( 'file.name,file.ext,filetxt.alt,page.header,page.content,page.url,page.longtext' );
	    $this->db->from ( 'pagecross' );
	    $this->db->join('page', 'page.id = pagecross.detail' , 'left');
	    $this->db->join('filecross', 'filecross.master = pagecross.detail && filecross.position=\'top\'' , 'left');
	    $this->db->join('file', 'file.id = filecross.detail && file.typ=\'img\' ','left');
	    $this->db->join('filetxt', 'filetxt.refId = file.id && filetxt.lng=\''.$this->user_lang.'\'','left');
	    $this->db->where($array);
	    $this->db->group_by("pagecross.detail");
	    $this->db->limit($limit,$start);
	    $this->db->order_by($order);
	    $query = $this->db->get ();
	    $values = $query->result_array ();
	    //echo $this->db->last_query();
	    return $values;
	}
	
	function sub_content_size($page_id,$limit,$start,$order){
	    $array=Array('pagecross.master'=>$page_id,'page.pub'=>'y');
	    $this->db->select ( 'file.name,file.ext,filetxt.alt,page.header,page.content,page.url,page.longtext' );
	    $this->db->from ( 'pagecross' );
	    $this->db->join('page', 'page.id = pagecross.detail' , 'left');
	    $this->db->join('filecross', 'filecross.master = pagecross.detail && filecross.position=\'top\'' , 'left');
	    $this->db->join('file', 'file.id = filecross.detail && file.typ=\'img\' ','left');
	    $this->db->join('filetxt', 'filetxt.refId = file.id && filetxt.lng=\''.$this->user_lang.'\'','left');
	    $this->db->where($array);
	    $this->db->group_by("pagecross.detail");
	    $values =  $this->db->count_all_results();
	    //echo $this->db->last_query();
	    return $values;
	}
	function parent_cat(){
	    
	}
	
	function other_cat(){
	    
	}
	
	/*pagecross tablosunda master varmi yokmu ona bakar varsa sayfa bilgilerini doner*/
	function parent_page($page_id){
	    $this->db->select ( 'master, (select header from page where page.id=master) as header,(select url from page where page.id=master) as url' );
	    $this->db->from ( 'pagecross' );
	    $this->db->where(Array('detail'=>$page_id));
	    $query = $this->db->get ();
	    $values = $query->result_array ();
	    $master = $values[0];
	    
	    return $master;
	}
	
	function news($array,$order,$limit){
	  
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
	    $this->db->join('filetxt', 'filetxt.refId = file.id and filetxt.lng="'.$array['news.lng'].'"','left');
	    $this->db->where($array);
	    $this->db->limit($limit,0);
	    $this->db->order_by($order);
	    $query = $this->db->get ();
	    $values = $query->result_array ();
	    
	    return $values;
	}
	
}