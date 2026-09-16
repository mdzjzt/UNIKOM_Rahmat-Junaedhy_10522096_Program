<?php

/**
 * Description of user_model
 *
 * @author Warman Suganda
 */
class user_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = 'm_user';
    private $_table2 = 'm_role';
    private $_table3 = 'hr_pegawai';
    private $_table4 = 'hr_ref_unit_kerja';
    private $_table5 = 'hr_ref_cabang';
    private $_table6 = 'hr_mapping_jabatan';
    //private $_table5 = 'm_lokasi_kerja';

    private function _key($key, $alias = TRUE) {
        if (!is_array($key)) {
            $primary_key = $alias ? 'a.id_user' : 'id_user';
            $key = array($primary_key => $key);
        }
        return $key;
    }

    public function data($key = array(), $order_by = '', $direction = 'asc', $limit = NULL, $offset = 0) {
        $this->db->select('a.*, b.nama_role, c.pegawai_nama, c.pegawai_nik');
        $this->db->from($this->_table1 . ' a');
        $this->db->join($this->_table2 . ' b', 'a.id_role = b.id_role');
        $this->db->join($this->_table3 . ' c', 'a.id_pegawai = c.pegawai_id');
        // $this->db->join($this->_table4 . ' d', 'd.unit_kerja_id = c.unit_kerja_id');
        // $this->db->join($this->_table5 . ' e', 'e.cabang_id = c.cabang_id');
        //$this->db->join($this->_table5 . ' e', 'e.kd_jabatan = c.jabatan_id AND e.kd_unit_kerja = c.unit_kerja_id AND e.kd_cabang = c.cabang_id','left outer');
        //$this->db->join($this->_table5 . ' e', 'e.id_lokasi_kerja = c.id_lokasi_kerja', 'left');

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
        return $this->db->insert($this->_table1, $data);
    }

    public function update($key, $data) {
        return $this->db->update($this->_table1, $data, $this->_key($key, FALSE));
    }

    public function delete($key) {
        return $this->db->delete($this->_table1, $this->_key($key, FALSE));
    }

    public function options($key = array(), $default = array()) {
        if (count($default) == 0) {
            $default = array('' => '--Select--');
        }

        $option = $default;
        $data   = $this->data($key)->get();

        foreach ($data->result() as $value) {
            $option[$value->id_user] = $value->id_user.'-'.$value->nama_user;
        }

        return $option;
    }

    public function is_exist($kode)
    {
        $data = array();
        $data["(LOWER(a.username_user) = LOWER('{$kode}') )"] = NULL;

        $query = $this->data($data);

        if($query->count_all_results()):
            return 1;
        endif;


    }

}
