<?php

/**
 * Description of menu_model
 *
 * @author Warman Suganda
 */
class menu_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "m_modul";

    private function _key($key, $alias = TRUE) {
        if (!is_array($key)) {
            $primary_key = $alias ? 'a.id_menu' : 'id_menu';
            $key = array($primary_key => $key);
        }
        return $key;
    }

    public function data($key = array(), $order_by = '', $direction = 'asc', $limit = NULL, $offset = 0) {
        $this->db->select('a.*');
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
        //$this->db->set('id_menu', $this->db->sequence_id($this->_table1), FALSE);
        return $this->db->insert($this->_table1, $data);
    }

    public function update($data, $key) {
        return $this->db->update($this->_table1, $data, $this->_key($key, FALSE));
    }

    public function update_ordering($data) {
        $this->db->trans_begin();
        foreach ($data as $key => $value) {
            $this->db->update($this->_table1, $value, $this->_key($key, FALSE));
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function delete($key) {
        $this->db->trans_begin();
        # Delete Otoritas Modul
        $this->role_authorities_model->delete(array('id_menu' => $key));
        $this->db->delete($this->_table1, $this->_key($key, FALSE));
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

}
