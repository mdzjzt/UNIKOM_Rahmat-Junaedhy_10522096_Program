<?php


class mr_pusat_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    private $_table  = 'material_requisition';
    private $_table_equippment = 'mr_equipment';
    private $table_master_project =  'master_project';
    private $user_master_project =  'user_master_project';
    private $kota_master_project =  'kota_master_projek';
    private $_table_approve = 'm_approve_mr';
    private $_table_workflow = 'sys_workflow_detail';
    private $_table_print_mr = 'mr_print';
    private $_account = 'm_account_code';
    private $_m_user = 'm_user';
    private $_pegawai = 'hr_pegawai';
    private $_lampiran_mr = 'lampiran_mr';


    private function _key($key,$alias = TRUE)
    {
        if(!is_array($key)):
            $primary_key = $alias ? 'a.mr_id' : 'mr_id';
            $key         = array($primary_key => $key);
        endif;

        return $key;
    }

     private function _keyy($keyy,$aliass = TRUE)
    {
        if(!is_array($keyy)):
            $primary_keyy = $aliass ? 'a.id_lampiran' : 'id_lampiran';
            $keyy         = array($primary_keyy => $keyy);
        endif;

        return $keyy;
    }

    public function table($key = array(), $order_by = '', $direction = 'asc' , $limit = NULL, $offset = 0)
    {
        $this->db->select('*');

        $this->db->from('material_requisition');

        #condition
        $this->db->where_condition($this->_key($key));

        #order
        if(!empty($order_by)):
            $this->db->order_by($order_by, $direction);
        endif;

        #limit
        if(!is_null($limit)):
            $this->db->limit($limit,$offset);
        endif;

        return $this->db;
    }

     public function data_project($key = array() , $order_by = '', $direction = 'asc' , $limit = NULL, $offset = 0){

        // $this->db->select(" * FROM user_master_project a
        //     left outer join master_project b on a.id_master_project = b.id_m_project
        //     where id_user = '".$id_user."' and status_buat_projek = '1' ");
        $this->db->select('b.nama_project,b.create_at,b.id_m_project,b.client_project,b.kode_project')
                ->from($this->user_master_project . ' a')
                ->join($this->table_master_project . ' b', 'a.id_master_project = b.id_m_project', 'left')
                ->where_condition($key);

        #order
        if(!empty($order_by)):
            $this->db->order_by($order_by, $direction);
        endif;

        #limit
        if(!is_null($limit)):
            $this->db->limit($limit,$offset);
        endif;


        return $this->db;
    }

    public function data_file($idmr){
         $this->db->select(" * FROM lampiran_mr where mr_id_lampiran = '".$idmr."' ");

        return $this->db;
    }

    public function deletefilelampiran($keyy)
    {
        return $this->db->delete($this->_lampiran_mr, $this->_keyy($keyy,FALSE));
    }


     public function data_mr($key = array() , $order_by = '', $direction = 'asc' , $limit = NULL, $offset = 0){

        // $this->db->select(" * FROM material_requisition
        //     where id_master_project = '".$id."'  ");
        $this->db->select('a.*,b.*,c.*')
                ->from($this->_table . ' a')
                ->join($this->_m_user . ' b', 'b.id_user = a.create_by', 'left')
                ->join($this->_pegawai . ' c', 'c.pegawai_id = b.id_pegawai', 'left')
                ->where_condition($key);

        #order
        if(!empty($order_by)):
            $this->db->order_by($order_by, $direction);
        endif;

        #limit
        if(!is_null($limit)):
            $this->db->limit($limit,$offset);
        endif;


        return $this->db;
    }

    public function data_mr_approve($key = array(), $order_by = '', $direction = 'asc' , $limit = NULL, $offset = 0){

      $this->db->from($this->_table . ' a');
      $this->db->join($this->_table_workflow . ' b', 'b.project_id = a.id_master_project', 'LEFT OUTER');

        $this->db->where_condition($this->_key($key));

        #order
        if(!empty($order_by)):
            $this->db->order_by($order_by, $direction);
        endif;

        #limit
        if(!is_null($limit)):
            $this->db->limit($limit,$offset);
        endif;


        return $this->db;
    }

    public function data_mr_detail($key = array(), $order_by = '', $direction = 'asc' , $limit = NULL, $offset = 0){

        $this->db->select('a.*, b.*,d.no_po ')
                ->from($this->_table . ' a')
                ->join($this->_table_equippment . ' b', 'b.mr_id = a.mr_id','left')
                ->join('purchase_equipment c', 'c.id_mr_equipment = b.mr_equipment_id','left')
                ->join('purchase_order d', 'd.id_po = c.id_po','left');
        #condition
        $this->db->where_condition($this->_key($key));

        #order
        if (!empty($order_by)):
            $this->db->order_by($order_by, $direction);
        endif;

        #limit
        if (!is_null($limit)):
            $this->db->limit($limit, $offset);
        endif;
      
        return $this->db;
    }

    public function data_edit($key = array(), $order_by = '', $direction = 'asc' , $limit = NULL, $offset = 0){
        $this->db->select('a.*, b.*,c.code_account ')
                ->from($this->_table . ' a')
                ->join($this->_table_equippment . ' b', 'b.mr_id = a.mr_id','left')
                ->join($this->_account . ' c', 'c.id_account_code = b.acc_no','left');
        #condition
        $this->db->where_condition($this->_key($key));

        #order
        if (!empty($order_by)):
            $this->db->order_by($order_by, $direction);
        endif;

        #limit
        if (!is_null($limit)):
            $this->db->limit($limit, $offset);
        endif;

        return $this->db;
    }


    public function data_revisi($id){
        $this->db->select(" * FROM m_approve_mr where mr_id = '".$id."' and status_approve = '2' ;");

        return $this->db;
    }

    public function data_so($id){
        $this->db->select(" * FROM so_equipment a
                            left join purchase_so b  on b.id_so = a.id_so
                            where id_mr_equipment = '".$id."' and status_approve_so = '1' ;");

        return $this->db;
    }

    public function data_approve($key = array(), $order_by = '', $direction = 'asc' , $limit = NULL, $offset = 0){

         $this->db->select('a.*, b.* ')
                ->from($this->_table . ' a')
                ->join($this->_table_equippment . ' b', 'b.mr_id = a.mr_id','left');
        #condition
        $this->db->where_condition($this->_key($key));

        #order
        if (!empty($order_by)):
            $this->db->order_by($order_by, $direction);
        endif;

        #limit
        if (!is_null($limit)):
            $this->db->limit($limit, $offset);
        endif;

        return $this->db;
    }

    public function data_info_approve($id){
        $this->db->select(" * FROM m_approve_mr a
                        left join m_user b on b.id_user = a.id_user_approve
                        left join m_role c on c.id_role = a.role_id
                         where a.mr_id = '".$id."'
                          ORDER BY a.id_approve_mr ");
        return $this->db;
    }

    public function data_info_list_approve($id, $param = NULL){
         if ($param == '2') {
             $flow = 'PRO-BID-01';
         }else if($param == '3'){
            $flow = 'PRO-PO-05';
         }
         else{
            $flow = 'PRO-MR-01';
         }
        $this->db->select(" * from sys_workflow_detail a
                            left join m_role b on b.id_role = a.role_id
                            left join m_user c on c.id_user = a.id_user
                            left join hr_pegawai d on d.pegawai_id = c.id_pegawai
                            left join mrange_approval j on j.id_range = a.id_range
                            where a.workflow_id = '".$flow."' and a.project_id = '".$id."' and a.or_order = '0'
                            ORDER BY a.flow_order ");
        return $this->db;
    }



    public function get_data_project($id_project){

        $this->db->select(" * FROM master_project a
            left outer join user_master_project b on b.id_master_project = a.id_m_project
            left outer join kota_master_projek c on c.id_master_project = a.id_m_project
            LEFT OUTER JOIN m_m_kota d on d.kota_id = c.id_kota
            where id_m_project = '".$id_project."' and status_delete = '0' ");

        return $this->db;
    }


    public function create($data)
    {
        $this->db->insert($this->_table,$data);
        return $this->db->insert_id();
    }

    public function create_approve($data){
         $this->db->insert($this->_table_approve,$data);
        return $this->db->insert_id();
    }

    public function update($key,$data)
    {
        return $this->db->update($this->_table, $data ,$this->_key($key,FALSE));
    }

     public function update_equipment($key,$data)
    {
        return $this->db->update($this->_table_equippment, $data ,$this->_key($key,FALSE));
    }

    public function delete($key)
    {
        return $this->db->delete($this->_table, $this->_key($key,FALSE));
    }

    public function table_equipment($key=array())
    {
        $this->db->select('*');

        $this->db->from('mr_equipment');

        #condition
        $this->db->where_condition($this->_key($key));
        #order
        if (!empty($order_by)):
            $this->db->order_by($order_by, $direction);
        endif;


        return $this->db;
    }

    public function data_result_print($key=array())
    {
        $this->db->select('a.*, b.* ')
                ->from($this->_table . ' a')
                ->join($this->table_master_project . ' b', 'b.id_m_project = a.id_master_project','left');
        #condition
        $this->db->where_condition($this->_key($key));

        #order
        if (!empty($order_by)):
            $this->db->order_by($order_by, $direction);
        endif;
        return $this->db;
    }
    public function update_count_print_mr($key,$data)
    {
        return $this->db->update($this->_table_print_mr, $data ,$this->_key($key,FALSE));
    }
    public function count_print_mr($key=array())
    {
        $this->db->select('*');

        $this->db->from($this->_table_print_mr);

        #condition
        $this->db->where_condition($this->_key($key));
        #order
        if (!empty($order_by)):
            $this->db->order_by($order_by, $direction);
        endif;


        return $this->db;
    }

    public function is_exist($kode)
    {
        $query = $this->db->where('kode_mr',$kode)->get($this->_table);

        if($query->num_rows() > 0):
            return 1;
        endif;
    }

    public function is_exist_approve($id_mr, $role, $status, $apnew)
    {
        $query = $this->db->select(" * from m_approve_mr where mr_id ='".$id_mr."' and role_id ='".$role."' and status_approve ='".$status."' and approve_new = '0' ")->get();

        if($query->num_rows() > 0):
            return 1;
        endif;
    }

}
