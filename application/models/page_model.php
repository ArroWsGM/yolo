<?php
class Page_model extends CI_Model {

	public function __construct(){
		$this->load->database();
		$this->load->library('session');
		//$this->load->library('crypt');
	}
	
	public function getAll($tbl = 'config', $order=array('field'=>'id', 'order'=>'desc'), $limit=null, $offset=null){
		$this->db->order_by($order['field'], $order['order']);
		$query = $this->db->get($tbl, $limit, $offset);
		return $query->result_array();
	}
	
	public function getRow($tbl, $id){
		$this->db->where('id', $id);
		$query = $this->db->get($tbl);
		return $query->row_array();
	}
	
	public function getWhere($tbl, $where, $limit=null, $offset=null, $order='desc'){
		//var_dump($tbl);
		//var_dump($where);
		if (is_array($where['value'])) $this->db->where_in($where['field'], $where['value'])->order_by('id', $order);
		else $this->db->where($where['field'], $where['value'])->order_by('id', $order);
		$query = $this->db->get($tbl, $limit, $offset);
		//var_dump($query->result_array());
		return $query->result_array();
	}
	
	public function getWhereCount($tbl, $where){
		if (is_array($where['value'])) $this->db->where_in($where['field'], $where['value'])->order_by('id', 'desc');
		else $this->db->where($where['field'], $where['value'])->order_by('id', 'desc');
		$this->db->from($tbl);
		return $this->db->count_all_results();
	}

	public function getBetween($tbl, $where, $limit=null, $offset=null){
		if ($where['max']=='0'){
			$this->db->where("{$where['field']} >= {$where['min']}")->order_by($where['field'], 'asc');
		}
		else $this->db->where("{$where['field']} BETWEEN {$where['min']} AND {$where['max']}")->order_by($where['field'], 'asc');
		$query = $this->db->get($tbl, $limit, $offset);
		//var_dump($query->result_array());
		return $query->result_array();
	}

	public function getBetweenCount($tbl, $where){
		if ($where['max']=='0'){
			$this->db->where("{$where['field']} >= {$where['min']}")->order_by($where['field'], 'asc');
		}
		else $this->db->where("{$where['field']} BETWEEN {$where['min']} AND {$where['max']}")->order_by($where['field'], 'asc');
		$this->db->from($tbl);
		return $this->db->count_all_results();
	}
	
	public function getMaxID($tbl){
		$sql = "SELECT `AUTO_INCREMENT` inc FROM `information_schema`.`TABLES` WHERE (`TABLE_NAME`='$tbl')";
        return $this->db->query($sql)->row()->inc;
	}
	
	public function selectMax($tbl, $col){
		$this->db->select_max($col);
		return $this->db->get($tbl);
	}
	
	public function getEmpl($id){
		$this->db->select('employee.id, employee.name, employee.photo, employee.qualification, spec.name AS specname, GROUP_CONCAT(terms.term_text SEPARATOR "%|%") AS term_text');
		$this->db->where('employee.id', $id);
		$this->db->from('employee');
		$this->db->join('spec', 'spec.id = employee.spec_id', 'left');
		$this->db->join('terms', 'terms.eployee_id = employee.id', 'left');
		$query = $this->db->get();
		return $query->row_array();
	}
	
	public function insert($table, $array){
		return $this->db->insert($table, $array); 
	}
	
	public function insert_batch($table, $array){
		return $this->db->insert_batch($table, $array); 
	}
	
	public function update($table, $id, $array){
		$this->db->where('id', $id);
		return $this->db->update($table, $array);
	}
	
	public function getConParam($param){
		//var_dump($param);
		$this->db->select($param);
		//exit;
		$query = $this->db->get('config');
		return $query->row_array()[$param];
	}
}