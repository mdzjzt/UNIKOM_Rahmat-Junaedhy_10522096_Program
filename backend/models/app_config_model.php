<?php

/**
 * @module Template
 * @author  Warman Suganda
 */
class app_config_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "sys_settings";

    private function _key($key = array()) {
        if (is_string($key)) {
            return array('a.id_setting');
        } else {
            return $key;
        }
    }

    public function data($key = array()) {
        $this->db->from($this->_table1 . ' a');
        $this->db->where_condition($this->_key($key));
        return $this->db;
    }

    public function get_data($key = array()) {
        return $this->data($key)->get();
    }

    public function data_array($key = array()) {
        $data = $this->data($key)->get();
        $option = array();
        foreach ($data->result() as $value) {
            $option[$value->name_setting] = $value->value_setting;
        }

        return $option;
    }

    public function options($key = array(), $default = array()) {
        if (is_array($default) && count($default) == 0) {
            $default = array('' => '--Pilih--');
        }
        $option = $default;
        $data = $this->data($key)->get();
        foreach ($data->result() as $value) {
            $option[$value->name_setting] = $value->value_setting;
        }
        return $option;
    }

}
