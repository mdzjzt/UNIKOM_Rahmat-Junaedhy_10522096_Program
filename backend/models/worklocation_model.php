<?php

/**
 * Description of worklocation_model
 *
 * @author Warman Suganda
 */
class worklocation_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = 'm_lokasi_kerja';

    private function _key($key, $alias = TRUE) {
        if (!is_array($key)) {
            $primary_key = $alias ? 'a.id_lokasi_kerja' : 'id_lokasi_kerja';
            $key = array($primary_key => $key);
        }
        return $key;
    }

    public function data($key = array(), $order_by = '', $direction = 'asc', $limit = NULL, $offset = 0) {
        $this->db->select('a.*, b.nama_lokasi_kerja AS nama_lokasi_kerja_main');
        $this->db->from($this->_table1 . ' a');
        $this->db->join($this->_table1 . ' b', 'b.id_lokasi_kerja = a.m_l_id_lokasi_kerja', 'left');

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

    public function create($data, $auto_generate) {
        $this->db->trans_begin();
        $this->db->insert($this->_table1, $data);

        if ($auto_generate == 't') {
            # jika auto generate
            $key = $this->db->last_sequence_id('m_lokasi_kerja');
            $this->db->update($this->_table1, array('no_lokasi_kerja' => $key), $this->_key($key, FALSE));
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function update($data, $key) {
        return $this->db->update($this->_table1, $data, $this->_key($key, FALSE));
    }

    public function delete($key) {
        return $this->db->delete($this->_table1, $this->_key($key, FALSE));
    }

    public function options($key = array(), $default = array()) {
        if (count($default) == 0) {
            $default = array('' => '--Pilih--');
        }
        $option = $default;
        $data = $this->data($key)->get();
        foreach ($data->result() as $value) {
            $option[$value->id_lokasi_kerja] = $value->no_lokasi_kerja . ' - ' . $value->nama_lokasi_kerja;
        }
        return $option;
    }

}
