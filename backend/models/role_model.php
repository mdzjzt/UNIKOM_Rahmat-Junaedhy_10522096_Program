<?php

/**
 * Description of role_model
 *
 * @author Warman Suganda
 */
class role_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = 'm_role';

    private function _key($key, $alias = TRUE) {
        if (!is_array($key)) {
            $primary_key = $alias ? 'a.id_role' : 'id_role';
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

    public function create($data, $authorities) {
        //$this->db->trans_begin();
        //$this->db->set('id_role', $this->db->sequence_id($this->_table1));
        $this->db->insert($this->_table1, $data);
        
        $key = $this->db->last_sequence_id('m_role');
        
        $this->_save_authorities($key, $authorities);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    private function _save_authorities($id_role, $authorities) {
        $this->role_authorities_model->delete($id_role);
        foreach ($authorities as $key => $value) {
            $data = array(
                'id_menu' => (string) $key,
                'id_role' => $id_role,
                'view_otoritas_modul' => isset($value['view_otoritas_modul']) ? $value['view_otoritas_modul'] : '0',
                'insert_otoritas_modul' => isset($value['insert_otoritas_modul']) ? $value['insert_otoritas_modul'] : '0',
                'update_otoritas_modul' => isset($value['update_otoritas_modul']) ? $value['update_otoritas_modul'] : '0',
                'delete_otoritas_modul' => isset($value['delete_otoritas_modul']) ? $value['delete_otoritas_modul'] : '0',
                //'export_otoritas_modul' => isset($value['is_approve']) ? $value['is_approve'] : '0',
                'import_otoritas_modul' => isset($value['import_otoritas_modul']) ? $value['import_otoritas_modul'] : '0',
                'export_otoritas_modul' => isset($value['export_otoritas_modul']) ? $value['export_otoritas_modul'] : '0',
                'data_otoritas_modul' => isset($value['data_otoritas_modul']) ? $value['data_otoritas_modul'] : null,
                'approve_otoritas_modul' => isset($value['approve_otoritas_modul']) ? $value['approve_otoritas_modul'] : '0',
                
            );
            $this->role_authorities_model->create($data);
        }
    }

    public function update($data, $authorities, $key) {
        $this->db->trans_begin();

        $this->db->update($this->_table1, $data, $this->_key($key, FALSE));
        $this->_save_authorities($key, $authorities);

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

        $this->role_authorities_model->delete($key);
        $this->db->delete($this->_table1, $this->_key($key, FALSE));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function options($key = array(), $default = array()) {
        if (!count($default)) {
            $default = array('' => '');
        }

        $option = $default;
        $data = $this->data($key)->get();
        foreach ($data->result() as $value) {
            $option[$value->id_role] = $value->nama_role;
        }
        return $option;
    }

}
