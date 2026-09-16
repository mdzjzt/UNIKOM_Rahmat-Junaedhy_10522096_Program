<?php

/**
 * Description of activity_log_model
 *
 * @author Warman Suganda
 */
class activity_log_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = 'log_activity';

    private function _key($key, $alias = TRUE) {
        if (!is_array($key)) {
            $primary_key = $alias ? 'a.id_activity_log' : 'id_activity_log';
            $key = array($primary_key => $key);
        }
        return $key;
    }

    public function data($key = array(), $order_by = '', $direction = 'asc', $limit = NULL, $offset = 0) {
        $this->db->from($this->_table1 . ' a');

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

    public function update($data, $key) {
        return $this->db->update($this->_table1, $data, $this->_key($key, FALSE));
    }

    public function delete($key) {
        return $this->db->delete($this->_table1, $this->_key($key, FALSE));
    }

}
