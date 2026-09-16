<?php

/**
 * Description of Model Sys Setting
 *
 * @author Candra Daniswara
 */
class syssetings_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $tbl_currency = 'sys_settings';

    private function _key($key, $alias = TRUE) {
        if (!is_array($key)) {
            $primary_key = $alias ? 'a.id_setting' : 'id_setting';
            $key = array($primary_key => $key);
        }
        return $key;
    }

    public function data($key = array(), $order_by = '', $direction = 'asc', $limit = NULL, $offset = 0) {
        $this->db->select('a.*');
        $this->db->from($this->tbl_currency . ' a');

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
        return $this->db->insert($this->tbl_currency, $data);
    }

    public function update($key, $data) {
        return $this->db->update($this->tbl_currency, $data, $this->_key($key, FALSE));
    }

    public function delete($key) {
        return $this->db->delete($this->tbl_currency, $this->_key($key, FALSE));
    }

    public function options($key = array(), $default = array()) {
        if (count($default) == 0) {
            $default = array('' => '--Select--');
        }

        $option = $default;
        $data   = $this->data($key)->get();

        foreach ($data->result() as $value) {
            $option[$value->id_currency] = $value->nama_currency;
        }
        return $option;
    }

}
