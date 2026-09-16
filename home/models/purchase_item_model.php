<?php


class purchase_item_model extends CI_Model
{
    
    function __construct()
    {
        parent::__construct();
    }

    
    private $_table  = 'purchase_order_item';
    

    private function _key($key,$alias = TRUE)
    {
        if(!is_array($key)):
            $primary_key = $alias ? 'id_item_po' : 'id_item_po';
            $key         = array($primary_key => $key);
        endif;

        return $key;
    }

    public function data($key = array(), $order_by = '', $direction = 'asc' , $limit = NULL, $offset = 0)
    {
        $this->db->from($this->_table );

        #condition
        $this->db->where_condition($this->_key($key));

        #order
        if(!empty($order_by)):
            $this->db->order_by($order_by,$direction);
        endif;

        #limit
        if(!is_null($limit)):
            $this->db->limit($limit,$offset);
        endif;

        return $this->db;
    }
    

    public function is_exist($kode)
    {
        $query = $this->db->where('id_po',$kode)->get($this->_table);

        if($query->num_rows() > 0):
            return 1;
        endif;
    }


    public function create($data)
    {
        $this->db->insert($this->_table,$data);
        return $this->db->insert_id();
    }

    public function update($key,$data)
    {
        return $this->db->update($this->_table, $data ,$this->_key($key,FALSE));
    }

    public function delete($key)
    {
        return $this->db->delete($this->_table, $this->_key($key,FALSE));
    }
        

    
        
}