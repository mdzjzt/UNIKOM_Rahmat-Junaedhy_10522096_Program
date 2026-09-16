<?php

/**
 * Description of employee_model
 *
 * @author Warman Suganda
 */
class employee_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = 'm_pegawai';
    private $_table2 = 'm_unit_kerja';
    private $_table3 = 'm_lokasi_kerja';

    private function _key($key) {
        if (!is_array($key)) {
            $key = array('a.employee_id' => $key);
        }
        return $key;
    }

    public function data($key = array(), $order_by = '', $direction = 'asc', $limit = NULL, $offset = 0) {
        
        $this->db->select('a.*, b.nama_unit_kerja, c.nama_lokasi_kerja');
        
        $this->db->from($this->_table1 . ' a');
        $this->db->join($this->_table2 . ' b', 'b.id_unit_kerja = a.id_unit_kerja', 'left');
        $this->db->join($this->_table3 . ' c', 'c.id_lokasi_kerja = a.id_lokasi_kerja', 'left');
        
        # for condition
        $this->db->where_condition($this->_key($key));

        # for ordering data
        if (!empty($order_by)) {
            $this->db->order_by($order_by, $direction);
        }

        # for limit data
        if (!is_null($limit)) {
            $this->db->limit($limit, $offset);
        }

        return $this->db;
    }

    public function create($data) {
        $this->db->set('employee_id', $this->db->sequence_id('mms_m_employee'), FALSE);
        return $this->db->insert($this->_table1, $data);
    }

    public function update($data, $key) {
        return $this->db->update($this->_table1 . ' a', $data, $this->_key($key));
    }

    public function delete($key) {
        return $this->db->delete($this->_table1 . ' a', $this->_key($key));
    }

    public function options($key = array(), $default = array()) {
        if (count($default) == 0) {
            $default = array('none' => '-- Select Referall --');
        }
        $option = $default;
        $data = $this->data($key)->get();
        foreach ($data->result() as $value) {
            $option[$value->id_pegawai] = $value->nama_pegawai;
        }
        return $option;
    }

}
