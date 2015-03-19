<?php
class Admin_model extends CI_Model {

	public function __construct(){
		$this->load->database();
		$this->load->library('session');
		$this->load->library('crypt');
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
	
	public function getWhere($tbl, $where, $limit=null, $offset=null, $order=array('id', 'desc')){
		if (is_array($where['value'])) $this->db->where_in($where['field'], $where['value'])->order_by($order[0], $order[1]);
		else $this->db->where($where['field'], $where['value'])->order_by($order[0], $order[1]);
		$query = $this->db->get($tbl, $limit, $offset);
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
	
	public function setConfig($array){
		$this->db->where('id', '1');
		return $this->db->update('config', $array); 
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
	
	public function delete($table, $id){
		if(is_array($id))
			$this->db->where_in('id', $id);
		else
			$this->db->where('id', $id);
		return $this->db->delete($table);
	}
	
	public function getConParam($param){
		//var_dump($param);
		$this->db->select($param);
		//exit;
		$query = $this->db->get('config');
		return $query->row_array()[$param];
	}
}