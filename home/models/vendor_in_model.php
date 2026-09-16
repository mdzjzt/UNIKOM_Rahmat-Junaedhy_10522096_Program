<?php

/**
 * Description of vendor_model
 *
 * @author ?
 */
class vendor_in_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
		$this->db2 = $this->load->database('second', TRUE);
	}

	private $_table = 'm_vendor';
	private $_table2 = 'jenis_usaha';
        private $_table3 = 'm_provinsi';
        private $_table4 = 'm_kotamadya';
        

	private function _key($key,$alias = TRUE)
	{
		if(!is_array($key)):
			$primary_key = $alias ? 'a.id' : 'id';
			$key 		 = array($primary_key => $key);
		endif;

		return $key;
	}

	public function data($key = array(), $order_by = '', $direction = 'asc' , $limit = NULL, $offset = 0)
	{
		$this->db2->select('a.*, b.provinsi_name, c.kotamadya_name');            
		$this->db2->from($this->_table . ' a')
                        ->join($this->_table3 . ' b', 'b.provinsi_id = a.propinsi')
                        ->join($this->_table4 . ' c', 'c.kotamadya_id = a.kota_id');

		#condition
		$this->db2->where_condition($this->_key($key));

		#order
		if(!empty($order_by)):
			$this->db2->order_by($order_by,$direction);
		endif;

		#limit
		if(!is_null($limit)):
			$this->db2->limit($limit,$offset);
		endif;

		return $this->db2;
	}

	public function is_exist($kode)
	{
		$query = $this->db2->where('nama_perusahaan',$kode)->get($this->_table);

		if($query->num_rows() > 0):
			return 1;
		endif;
	}

	public function create($data)
	{
		return $this->db2->insert($this->_table,$data);
	}

	public function update($key,$data)
	{
		return $this->db2->update($this->_table, $data ,$this->_key($key,FALSE));
	}

	public function delete($key)
	{
		return $this->db2->delete($this->_table, $this->_key($key,FALSE));
	}

	public function options($key = array(), $default = array())
	{
		if(count($default) == 0):
			$default = array('' => '--Pilih--');
		endif;

		$option = $default;
		$data = $this->data($key)->get();

		foreach ($data->result() as $dt):
		 	$option[$dt->id] = $dt->kode_bidang_lbu;
		endforeach;

		return $option;
	}
        
	public function options_jenis_usaha($key = array(), $default = array())
	{
		if(count($default) == 0):
			$default = array('' => '--Pilih--');
		endif;

		$option = $default;
		$data = $this->db2->get_where($this->_table2 . ' b', array('parent_id' => NULL));

		foreach ($data->result() as $dt):
		 	$option[$dt->id] = $dt->bidang;
		endforeach;

		return $option;
	}
	public function options_jenis_sub_bidang($id = NULL, $default = array())
	{
                
		if(count($default) == 0):
			$default = array('' => '--Pilih--');
		endif;

		$option = $default;
		$data = $this->db2->get_where($this->_table2 . ' b', array('parent_id' => $id));

		foreach ($data->result() as $dt):
		 	$option[$dt->id] = $dt->bidang;
		endforeach;

		return $option;
	}        
}
