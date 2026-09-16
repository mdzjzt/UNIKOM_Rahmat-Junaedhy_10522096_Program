<?php


class master_project_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		// $this->db = $this->load->database('second', TRUE);
	}

	private $_table  = 'master_project';

	private function _key($key,$alias = TRUE)
	{
		if(!is_array($key)):
			$primary_key = $alias ? 'id_m_project' : 'id_m_project';
			$key 		 = array($primary_key => $key);
		endif;

		return $key;
	}

     public function get($id){
        return $this->db->get_where($_table, array('id_m_project' => $id))->row();
    }

    public function get_all() {
        $query = $this->db->get('posts');
        return $query->result();
    }

	public function data_detail($id, $order_by = '', $direction = 'asc' , $limit = NULL, $offset = 0){
		$this->db->select("  a.*, b.*, e.pegawai_nama
							, f.jabatan_nama, d.kota_nama, c.*, l.nama_role FROM master_project a 
							 LEFT OUTER JOIN user_master_project b on b.id_master_project = a.id_m_project
							 LEFT OUTER JOIN m_user c on c.id_user = b.id_user
							 LEFT OUTER JOIN m_m_kota d on d.kota_id = a.kota_id
							 LEFT OUTER JOIN hr_pegawai e on e.pegawai_id = c.id_pegawai
							 LEFT OUTER JOIN hr_ref_jabatan f on f.jabatan_id = e.jabatan_id
							
							 LEFT OUTER JOIN m_role l on l.id_role = c.id_role
							where a.id_m_project = '".$id."' ", FALSE);
		if(!is_null($limit)):
			$this->db->limit($limit,$offset);
		endif;

		return $this->db;
	}


	public function data_kota($id, $order_by = '', $direction = 'asc' , $limit = NULL, $offset = 0){
		$this->db->select(" * FROM kota_master_projek a
							LEFT  JOIN m_m_kota b on b.kota_id = a.id_kota 
							WHERE id_master_project = '".$id."' ", FALSE);
		if(!is_null($limit)):
			$this->db->limit($limit,$offset);
		endif;

		return $this->db;
	}

	public function data($key = array(), $order_by = '', $direction = 'asc' , $limit = NULL, $offset = 0)
	{	
		

		// $this->db->select(" a.*,b.* FROM master_project a
		// 					LEFT OUTER JOIN m_m_kota b on b.kota_id = a.kota_id ", FALSE);
		$this->db->select(" * FROM master_project ");
		
		#condition
		$this->db->where_condition($this->_key($key));

		// #order
		// if(!empty($order_by)):
  //                   if($order_by == 'id_m_project'){
  //                       $this->db->order_by($order_by, $direction);
  //                   }else{
  //                       $this->db->order_by($order_by, $direction);
  //                       $this->db->order_by('id_m_project','ASC');
  //                   }
		// else:
  //                   $this->db->order_by('id_m_project','ASC');
  //               endif;
                
		// #limit
		// if(!is_null($limit)):
		// 	$this->db->limit($limit,$offset);
		// endif;

		// return $this->db;
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

	public function data_edit($id){
		$this->db->select(" * FROM master_project where id_m_project = '".$id."' ", FALSE);
		return $this->db;
	}

	public function data_edit_user($id){
		$this->db->select(" * FROM user_master_project where id_master_project = '".$id."' ", FALSE);
		return $this->db;
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

	public function getkodeho() { 
            $q = $this->db->query("SELECT * FROM master_project where kode_project = '001' ")->row()->kode_project;

         	if(is_null($q)){
                $kodeho = "001";
         	}else{
         		$kodeho = "002";
         	}
         
            return $kodeho;
       } 
  
    
     public function getkodeunik() { 
     	$d = $this->db->query(" SELECT * FROM master_project where kode_project = '003' ")->result();
     		if (empty($d)) {
     			return $kodemax = "004";
     		}else{
     			 $q = $this->db->query("SELECT MAX(kode_project) AS form_code FROM master_project");
	           // var_dump($q);
	            $qs=$q->row();
	            $qk=$qs->form_code;
	            if(!empty($qk)){ //jika data ada
	                foreach($q->result() as $k){
	                    $tmp = ((int)$k->form_code)+1; //string kode diset ke integer dan ditambahkan 1 dari kode terakhir
	                    $kodemax = str_pad($tmp, 3, "0", STR_PAD_LEFT);
	                }
	            }else{ //jika data kosong diset ke kode awal
	                $kodemax = "004";
	            }
	            //$kar = "EMP";
	            return $kodemax;
     		}
           
       } 

}