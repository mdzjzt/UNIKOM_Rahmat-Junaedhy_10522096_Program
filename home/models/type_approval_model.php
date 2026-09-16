<?php


class type_approval_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	private $_table = 'master_type_approval';
	

	private function _key($key,$alias = TRUE)
	{
		if(!is_array($key)):
			$primary_key = $alias ? 'id_type' : 'id_type';
			$key 		 = array($primary_key => $key);
		endif;

		return $key;
	}

	public function data($key = array(), $order_by = 'id_type', $direction = 'asc' , $limit = NULL, $offset = 0)
	{
		$this->db->from($this->_table);

		#condition
		$this->db->where_condition($this->_key($key));

		#order
		if(!empty($order_by)):
			$this->db->order_by($order_by,$direction);
		endif;

		#limit
		if(!is_null($limit)):
			$this->db->limit($limit,$offset);
		endif;

		return $this->db;
	}

	public function is_exist($kode)
	{
		$query = $this->db->where('code',$kode)->get($this->_table);

		if($query->num_rows() > 0):
			return 1;
		endif;
	}

	public function create($data)
	{
		return $this->db->insert($this->_table,$data);
	}

	public function update($key,$data)
	{
		return $this->db->update($this->_table, $data ,$this->_key($key,FALSE));
	}

	public function delete($key)
	{
		return $this->db->delete($this->_table, $this->_key($key,FALSE));
	}

	public function options($key = array(), $default = array())
	{
		if(count($default) == 0):
			$default = array('' => '--Pilih--');
		endif;

		$option = $default;
		$data = $this->data($key)->get();

		foreach ($data->result() as $dt):
		 	$option[$dt->id_type] = $dt->nama_type;
		endforeach;

		return $option;
	}
}