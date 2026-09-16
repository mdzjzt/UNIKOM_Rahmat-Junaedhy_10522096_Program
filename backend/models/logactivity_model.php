<?php


class logactivity_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $tbl_log_activity = 'log_activity';
    private $tbl_m_user = 'm_user';

    private function _key($key, $alias = TRUE) {
        if (!is_array($key)) {
            $primary_key = $alias ? 'a.id_activity_log' : 'id_activity_log';
            $key = array($primary_key => $key);
        }
        return $key;
    }

    public function data($key = array(), $order_by = '', $direction = 'asc', $limit = NULL, $offset = 0) {
        $this->db->select('a.*,b.nama_user');
        $this->db->from($this->tbl_log_activity . ' a');
        $this->db->join($this->tbl_m_user.' b','b.id_pegawai=a.id_pegawai');
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
        return $this->db->insert($this->tbl_log_activity, $data);
    }

    public function update($data, $key) {
        return $this->db->update($this->tbl_log_activity, $data, $this->_key($key, FALSE));
    }

    public function delete($key) {
        return $this->db->delete($this->tbl_log_activity, $this->_key($key, FALSE));
    }

    public function options($key = array(), $default = array()) {
        if (count($default) == 0) {
            $default = array('' => '--Select--');
        }

        $option = $default;
        $data   = $this->data($key)->get();

        foreach ($data->result() as $value) {
            $option[$value->id_user] = $value->id_user;
        }
        return $option;
    }


}
