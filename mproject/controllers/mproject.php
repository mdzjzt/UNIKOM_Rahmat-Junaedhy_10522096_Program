<?php

class mproject extends MX_Controller {

    private $_class_name = NULL;
    private $_title = ' MASTER TRANSAKSI & PROJECT CPM ';
    private $_module = 'mproject';

    function __construct() {
        parent::__construct();

        hprotection::login();
        $this->laccess->check();
        //$this->laccess->otoritas('view', TRUE);

        $this->_class_name = get_class($this);
        $this->_module .= '/' . $this->_class_name;

        $this->load->model('master_project_model');
        $this->load->model('user_model');
        $this->load->model('role_model');
       // $this->load->model('app_config_model');
        $this->load->model('pegawai_model');
        $this->load->model('cabang_model'); 
        $this->load->model('provinsi_model'); 
        $this->load->model('kotamadya_model'); 
       
    }

    public function index() {
        if (hprotection::must_ajax($this->_module)) {

            $data = [
                'pageTitle'  => $this->_title,
                '_modul'     => $this->_module,
                '_title'     => $this->_title,
               
            ];

            # LOG
            $this->log_activity_model->save([
                        'module'   => $this->_module,
                        'event'    => 'View',
                        'activity' => 'View List Inventaris'
            ]);

            $this->load->view($this->_module . '/index', $data);
        }
    }

     public function form($id = NULL)
    {
        if ($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {

            $project_code = $this->master_project_model->getkodeunik();
            // var_dump($project_code);
            // exit();

            $data['page_title']  = 'FORM' . $this->_title;
            $data['_modul']      = $this->_module;
            $data['form_action'] = $this->_module .'/save/'. $id;

            $data['project_code'] = $project_code;


            # OPTION
            $data['id']         = $id;
            // $this->load->model('kotamadya_model');
            $data['kotamadya'] = $this->kotamadya_model->options(array(), array('' => '--Pilih Kota--'));

            
            if ($id) {
                
                $query = $this->master_project_model->data_edit($id)->get()->row();
                $query_user = $this->master_project_model->data_edit_user($id)->get();

                $data['page_title'] = 'UBAH ' . $this->_title;
                $data['data']       = $query;
                $data['data_user']  = $query_user;
                $data['jumlah']  = count($query_user->result());


            }

             $this->load->view($this->_module . '/form', $data);

        } else {
            echo Modules::run('template/error_message/error_forbidden');
        }
    }

     public function save($id = NULL) {
         if ($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {
            if (hprotection::must_ajax($this->_module . '/404')) {

                $this->form_validation->set_rules('nama_project', '<i class="fa fa-warning"> Nama Project</i>', 'trim|required');
                

                if ($this->form_validation->run($this)) {

                    if ($this->input->post('site_project') == 1) {
                        $singkatan = 'HO';
                    }else if($this->input->post('site_project') == 2){
                        $singkatan = 'SITE';
                    }else{
                        $singkatan = NULL;
                    }

                 $data = [
                        'nama_project' => $this->input->post('nama_project'),
                        'kode_project'     => $this->input->post('kode_project'),
                        'create_at'  => date('Y-m-d H:i:s',strtotime($this->input->post('tanggal_pembuatan_project'))) ,
                        'status_buat_projek' =>  $this->input->post('chosee_project'),
                        'create_by' => $this->session->userdata('id_user'),
                        'site_project' => $this->input->post('site_project') ? $this->input->post('site_project') : 0,
                        'client_project' =>  $this->input->post('client_project'),
                        'end_user' =>  $this->input->post('end_user'),
                        'no_kontrak' =>  $this->input->post('no_kontrak'),
                        'singkatan' =>  $singkatan,
                        ];
                    // var_dump($data);
                    // exit();

                 if ($id) {
                        if ($this->master_project_model->update($id, $data)) {
                            $message = ['type' => 'info', 'message' => 'Data Berhasil Diupdate','return' => '__afterSubmit()'];
                        }

                        # LOG
                        $this->log_activity_model->save([
                                    'module'   => $this->_module,
                                    'sistem'   => TRUE,
                                    'event'    => 'Update',
                                    'activity' => 'Update Master project'
                        ]);
                    } else {

                        if ($id = $this->master_project_model->create($data)) {
                            $id_pro = $this->db->insert_id();
                            $id_user= $this->input->post('user_id');
                            $id_kota= $this->input->post('kota_id');

                                foreach($id_user as $user){
                                $data_user_project= array(
                                    'id_master_project' => $id_pro,
                                    'id_user' => $user
                                    );
                                $this->db->insert('user_master_project',  $data_user_project);
                                 }


                                foreach($id_kota as $kota){
                                $data_kota_project= array(
                                    'id_master_project' => $id_pro,
                                    'id_kota' => $kota
                                    );
                                $this->db->insert('kota_master_projek',  $data_kota_project);
                                 }

                         
                            $message = ['type' => 'info', 'message' => 'Data Berhasil Disimpan', 'return' => '__afterSubmit()'];
                        }

                        # LOG
                        $this->log_activity_model->save([
                                    'module'   => $this->_module,
                                    'sistem'   => TRUE,
                                    'event'    => 'Insert',
                                    'activity' => 'Insert Master Project'
                        ]);
                    }
                   
                    } else {
                        $message = ['error' => true, 'message' => 'Terjadi Kesalahan <br> Periksa kembali data input', 'callback' => $this->form_validation->get_errors_array()];
                }
                  echo json_encode($message);    

                
            }
            else {
                echo Modules::run('template/error_message/error_forbidden');
             }
        }
     }

    public function load() {
        # Init
        $limit  = $this->input->post('length');
        $offset = $this->input->post('start');
        $draw   = $this->input->post('draw');
        $extraColumn = $this->input->post('columns');
        $extraOrder  = $this->input->post('order');

        # Ordering
        $orderBy   = 'id_m_project';
        $direction = NULL;
        $cond = [];
        $cond["status_delete = '0' "] = NULL;

        if (!empty($this->input->post('name'))) {

            $searchname = strtolower($this->input->post('name'));

            $cond["LOWER(nama_project) LIKE '%{$searchname}%'"] = NULL;
        }

        if (!empty($this->input->post('tanggal'))) {

            $cond['create_at'] = date('Y-m-d',strtotime($this->input->post('tanggal')));
        }
        if (!empty($this->input->post('kode'))) {

           $cond["LOWER(kode_project) LIKE '%{$this->input->post('kode')}%'"] = NULL;
        }
        if (!empty($this->input->post('client_name'))) {

            $searchclient = strtolower($this->input->post('client_name'));

            $cond["LOWER(client_project) LIKE '%{$searchclient}%'"] = NULL;
        }

         if (!empty($this->input->post('project'))) {

            $cond["status_buat_projek = '{$this->input->post('project')}'"] = NULL;
        }

          $cond["status_buat_projek"] = 3;
        // print_debug($cond);
        $dataCount          = $this->master_project_model->data($cond)->get()->num_rows();
        $dataCountFiltered  = $this->master_project_model->data($cond)->get()->num_rows();
        $dataResult         = $this->master_project_model->data($cond, $orderBy, $direction, $limit, $offset)->get();
        
        $rows = [];
        $no   = $offset;
       
        foreach ($dataResult->result() as $dt) {
            
            $nama_project = $dt->nama_project;
            if ($dt->status_buat_projek == 1) {
                $chosee_projec = 'HEAD OFFICE';
                 $site = "";
            }else if ($dt->status_buat_projek == 2){
                $chosee_projec = 'EQUIPMENT';
                 $site = "";
            }else if($dt->status_buat_projek == 3){
                 $chosee_projec = 'PROJECT';
                 if($dt->site_project == 1){
                    $site = "HEAD OFFICE";
                 }else{
                     $site = "SITE";
                 }
                 
            }
            $action = NULL;

             // $action .=  anchor($this->_module . '/detail/' . $dt->id_m_project,'<i class="fa fa-user"> </i> ',
             //        [
             //            'data-module'   => $this->_module,
             //            'data-toggle'   => "modal",
             //            'data-target'   => "#modalDetail",
             //            'rel' => 'tooltip',
             //            'data-placement' => 'top',
             //            'title' => 'Lihat User',
             //            'class'          => 'btn btn-info btn-xs margin-right-2',
             //    ]);

          
            $action .= anchor(NULL, '<i class="fa fa-edit"></i></a>', 
                [   
                    'data-href'      => $this->_module . '/form/' . $dt->id_m_project,
                    'class'          => 'btn btn-warning btn-xs margin-right-2',
                    'rel'            => 'tooltip',
                    'data-placement' => "top",
                    'title'          => 'Edit',
                ]);

             if($this->laccess->otoritas('delete')) {
                $action .= anchor(NULL, '<i class="fa fa-trash-o"></i></a>', [
                    'class'          => 'btn btn-danger btn-xs',
                    'rel'            => 'tooltip',
                    'data-placement' => "top",
                    'data-title'     => 'Hapus',
                    'data-url'       => base_url() . $this->_module . '/delete/'. $dt->id_m_project,  
                    'onclick'        => '$(this).myForm().submit(\'delete\')'
                ]);
            }

            $jumlah_user = $this->db->query("select * from user_master_project where id_master_project = '".$dt->id_m_project."' ")->num_rows();

            // $jumlah_kota = $this->db->query("select * from kota_master_projek where id_master_project = '".$dt->id_m_project."' ")->num_rows();


            $no++;
            $rows[] = [
                hgenerator::columns_align($no, 'center'),
                $chosee_projec,
                $site,
                $dt->kode_project,
                $nama_project,
                $dt->client_project,

                $jumlah_user ? anchor($this->_module . '/detail/' . $dt->id_m_project,  $jumlah_user.' <i class="fa fa-eye"></i>',
                    [
                        'data-module'   => $this->_module,
                        'data-toggle'   => "modal",
                        'data-target'   => "#modalDetail",
                        'rel' => 'tooltip',
                        'data-placement' => 'top',
                        'title' => 'Lihat User',
                    ]) : '-',

                
                
                date("d-M-Y", strtotime($dt->create_at)),
                hgenerator::button_action($action),
            ];
        }

        $data = [
                'draw'            => $draw,
                'recordsTotal'    => $dataCount,
                'recordsFiltered' => $dataCountFiltered,
                'data'            => $rows
            ];

            echo json_encode($data);
    }

    public function kota_master_project($id){
        $data['id']     = $id;
        $data['_modul'] = $this->_module;
        $data['datauser']   = $this->master_project_model->data_detail($id)->get();
        $data['nama_project']   = $data['datauser']->row()->nama_project;
        $data['form_action'] = $this->_module .'/save_kota_project/'. $id;
        
        $this->load->view($this->_module . '/kota_project', $data);

    }

    public function save_kota_project($id){
       
                $id_user= $this->input->post('kota_id');
                foreach($id_user as $user){
                    $data_user_project = array(
                            'id_master_project' => $id,
                            'id_kota' => $user
                            );
                    $this->db->insert('kota_master_projek',  $data_user_project);
                }
                         
            $message = ['type' => 'info', 'message' => 'Data Berhasil Ditambah','return' => '__afterSubmit(false)'];
            echo json_encode($message);
    }

    public function detail($id)
    {
        $data['id']     = $id;
        $data['_modul'] = $this->_module;
        $data['datauser']   = $this->master_project_model->data_detail($id)->get();
        $data['nama_project']   = $data['datauser']->row()->nama_project;
        $data['form_action'] = $this->_module .'/save_user_project/'. $id;
        // var_dump($data['data']);
        // exit();
        $this->load->view($this->_module . '/detail', $data);
    }

    public function save_user_project(){
                $id_pro = $this->input->post('id');
                $id_user= $this->input->post('user_id');
                foreach($id_user as $user){
                    $data_user_project = array(
                            'id_master_project' => $id_pro,
                            'id_user' => $user
                            );
                    $this->db->insert('user_master_project',  $data_user_project);
                }
                         
            $message = ['type' => 'info', 'message' => 'Data Berhasil Ditambah','return' => '__afterSubmit(false)'];
            echo json_encode($message);
    }

     public function load_data_kota_project($id){
        $limit  = $this->input->post('length');
        $offset = $this->input->post('start');
        $draw   = $this->input->post('draw');
        $extraColumn = $this->input->post('columns');
        $extraOrder  = $this->input->post('order');

        $dataCount          = $this->master_project_model->data_kota($id)->get()->num_rows();
        $dataCountFiltered  = $this->master_project_model->data_kota($id)->get()->num_rows();
        $dataResult         =  $this->master_project_model->data_kota($id)->get();
        
        $rows = [];
        $no   = $offset;
       
        foreach ($dataResult->result() as $dt) {
            
            $action = NULL;

             if($this->laccess->otoritas('delete')) {
                $action .= anchor(NULL, '<i class="fa fa-trash-o"></i></a>', [
                    'class'          => 'btn btn-danger btn-xs',
                    'rel'            => 'tooltip',
                    'data-placement' => "top",
                    'data-title'     => 'Hapus',
                    'data-url'       => base_url() . $this->_module . '/delete_kota/'. $dt->id_kota_projek,  
                    'onclick'        => '$(this).myForm().submit(\'delete\')'
                ]);
            }


            $no++;
            $rows[] = [
                hgenerator::columns_align($no, 'center'),
                $dt->kota_nama,
                $dt->kota_id,
                hgenerator::button_action($action),
            ];
        }

        $data = [
                'draw'            => $draw,
                'recordsTotal'    => $dataCount,
                'recordsFiltered' => $dataCountFiltered,
                'data'            => $rows
            ];

            echo json_encode($data);
    }

    public function load_data_user_project($id){
        $limit  = $this->input->post('length');
        $offset = $this->input->post('start');
        $draw   = $this->input->post('draw');
        $extraColumn = $this->input->post('columns');
        $extraOrder  = $this->input->post('order');

        $dataCount          = $this->master_project_model->data_detail($id)->get()->num_rows();
        $dataCountFiltered  = $this->master_project_model->data_detail($id)->get()->num_rows();
        $dataResult         =  $this->master_project_model->data_detail($id)->get();
        
        $rows = [];
        $no   = $offset;
       
        foreach ($dataResult->result() as $dt) {
            
            $action = NULL;

             if($this->laccess->otoritas('delete')) {
                $action .= anchor(NULL, '<i class="fa fa-trash-o"></i></a>', [
                    'class'          => 'btn btn-danger btn-xs',
                    'rel'            => 'tooltip',
                    'data-placement' => "top",
                    'data-title'     => 'Hapus',
                    'data-url'       => base_url() . $this->_module . '/delete_user/'. $dt->id_user_m_project,  
                    'onclick'        => '$(this).myForm().submit(\'delete\')'
                ]);
            }


            $no++;
            $rows[] = [
                hgenerator::columns_align($no, 'center'),
                $dt->pegawai_nama,
                $dt->nama_role,
                hgenerator::button_action($action),
            ];
        }

        $data = [
                'draw'            => $draw,
                'recordsTotal'    => $dataCount,
                'recordsFiltered' => $dataCountFiltered,
                'data'            => $rows
            ];

            echo json_encode($data);
    }

    public function load_data_kota($type = NULL) {
        if (hprotection::must_ajax($this->_module)) {
                # Data Table
                $limit  = $this->input->post('length');
                $offset = $this->input->post('start');
                $draw   = $this->input->post('draw');
                $extraColumn = $this->input->post('columns');
                $extraOrder  = $this->input->post('order');

                # Ordering
                $orderBy   = 'provinsi_nama';
                $direction = NULL;

                if($extraColumn[$extraOrder[0]['column']]['orderable'] == 'true') {
                    $orderBy = isset($extraColumn[$extraOrder[0]['column']]['name']) ? $extraColumn[$extraOrder[0]['column']]['name'] : NULL;
                    $direction   = $extraOrder[0]['dir'];
                }

                # Condition
                $cond = array();

                if(!empty($this->input->post('provinsi_id'))) {
                    $cond["(a.provinsi_id = '{$this->input->post('provinsi_id')}')"] = NULL;
                }

                if(!empty($this->input->post('keyword'))) {
                    $cond["LOWER(a.kota_nama) LIKE '%{$this->input->post('keyword')}%'"] = NULL;
                }

                $data_count  = $this->kotamadya_model->data($cond)->count_all_results();
                $data_result = $this->kotamadya_model->data($cond, $orderBy, $direction, $limit, $offset)->get();

                $rows = array();
                $no   = $offset;
                 foreach ($data_result->result() as $dt):
                    
                    $id     = $dt->kota_id;

                    $no++;

                    $rows[] = array(
                                hgenerator::columns_align($no,'center'),
                                '<span class="id_kota" data-id="'.$id.'"><a href="javascript:;" class="a-kode-kota">'.$id.'</a></span>',
                                 '<span class="nama_kota" data-id="'.$dt->kota_nama.'"><a href="javascript:;" class="a-nama-kota">'.$dt->kota_nama.' </a></span>',
                                 $dt->ibu_kota,
                                 $dt->singkatan
                                
                               
                            );

                endforeach;

                $data = array(
                            'draw'            => $draw,
                            'recordsTotal'    => $data_count,
                            'recordsFiltered' => $data_count,
                            'data'            => $rows, 
                        );
                echo json_encode($data);

        }
    }

    public function load_data_user($type = NULL) {
        if (hprotection::must_ajax($this->_module)) {

            # Init
            $limit  = $this->input->post('length');
            $offset = $this->input->post('start');
            $draw   = $this->input->post('draw');
            $extraColumn = $this->input->post('columns');
            $extraOrder  = $this->input->post('order');

            # Ordering
            $orderBy   = 'pegawai_nama';
            $direction = NULL;

            if($extraColumn[$extraOrder[0]['column']]['orderable'] == 'true') {
                $orderBy = isset($extraColumn[$extraOrder[0]['column']]['name']) ? $extraColumn[$extraOrder[0]['column']]['name'] : NULL;
                $direction   = $extraOrder[0]['dir'];
            }

            # Condition
            $cond = [];

            if (!empty($this->input->post('keyword'))) {
                $cond["LOWER(pegawai_nama) ILIKE '%{$this->input->post('keyword')}%' OR LOWER(username_user) ILIKE '%{$this->input->post('keyword')}%' "] = NULL;
            }

            if (!empty($this->input->post('cabang_id'))) {
                $cond['e.cabang_id'] = $this->input->post('cabang_id');
            }

            if (!empty($this->input->post('role_id'))) {
                $cond['a.id_role'] = $this->input->post('role_id');
            }

            if (!empty($this->input->post('status'))) {
                $cond['a.active_user'] = $this->input->post('status');
            }

            $dataCount          = $this->user_model->data()->count_all_results();
            $dataCountFiltered  = $this->user_model->data($cond)->count_all_results();
            $dataResult         = $this->user_model->data($cond, $orderBy, $direction, $limit, $offset)->get();

           // $gs = $this->app_config_model->data_array(['a.key_setting' => 'STTF']);

            $rows = [];
            $no   = $offset;

            foreach ($dataResult->result() as $value) {

                $id = $value->id_user;

                $action = NULL;
                if ($this->laccess->otoritas('edit')) {
                    $action .= anchor(NULL, '<i class="fa fa-edit"></i></a>', [
                        'class'          => 'btn btn-warning btn-xs',
                        'rel'            => 'tooltip',
                        'data-placement' => 'top',
                        'title'          => 'Ubah',
                        'data-href'      => $this->_module . '/edit/' . $id
                    ]);

                    $action .= anchor(NULL, '<i class="fa fa-undo"></i></a>', array(
                        'class'        => 'btn btn-success btn-xs margin-right-2',
                        'data-confirm' => 'Anda yakin akan mereset password?',
                        'data-url'     => base_url() . $this->_module . '/reset_password/' . $id,
                        'onclick'      => '$(this).myForm().submit()'
                    ));
                }

                if ($this->laccess->otoritas('delete')) {
                    $action .= anchor(NULL, '<i class="fa fa-trash-o"></i></a>', array(
                        'class'          => 'btn btn-danger btn-xs',
                        'rel'            => 'tooltip',
                        'data-placement' => "top",
                        'data-title'     => 'Hapus',
                        'data-url'       => base_url() . $this->_module . '/delete/'. $id,  
                        'onclick'        => '$(this).myForm().submit(\'delete\')'
                    ));
                }

                $no++;
                $rows[] = array(
                    hgenerator::columns_align($no, 'center'),
                   '<span class="id" data-id="'.$id.'"><a href="javascript:;" class="a-kode">'.$id.'</a></span>',
                    '<span class="nama" data-id="'.$value->pegawai_nama .'"><a href="javascript:;" class="a-nama">'.$value->pegawai_nama .' </a></span>',
                    $value->username_user,
                    $value->nama_role
                   
                );
            }

            $data = [
                'draw'            => $draw,
                'recordsTotal'    => $dataCount,
                'recordsFiltered' => $dataCountFiltered,
                'data'            => $rows
            ];

            echo json_encode($data);
        }
    }

     public function delete($id) 
    {
        $this->master_project_model->update($id, ['status_delete' => TRUE]);

        # LOG
        $this->log_activity_model->save([
                    'module'   => $this->_module,
                    'sistem'   => TRUE,
                    'event'    => 'Delete',
                    'activity' => 'Hapus Master Project'
        ]);

        $message = ['type' => 'info', 'message' => 'Data Berhasil Dihapus','return' => '__reloadTable(false)'];
        echo json_encode($message);
    }

    public function delete_user($id){
        $this->db->where('id_user_m_project',$id);
        $this->db->delete('user_master_project');
        $message = ['type' => 'info', 'message' => 'Data Berhasil Dihapus','return' => '__reloadTable(false)'];
        echo json_encode($message);
    }


    public function delete_kota($id){
        $this->db->where('id_kota_projek',$id);
        $this->db->delete('kota_master_projek');
        $message = ['type' => 'info', 'message' => 'Data Berhasil Dihapus','return' => '__reloadTable(false)'];
        echo json_encode($message);
    }

    public function cek_ho_kode(){
        $q = $this->db->query(" SELECT * FROM master_project where kode_project = '001' ")->result();
        $k = $this->db->query(" SELECT * FROM master_project where kode_project = '002' ")->result();
         $j = $this->db->query(" SELECT * FROM master_project where kode_project = '003' ")->result();

            if(empty($q)){
                $kodeho = ['id' => '001'];

            }else if(empty($k)){
                    $kodeho = ['id' => '002'];
                 
            }else if(empty($j)){
                 $kodeho = ['id' => '003'];
            }else{
                 $kodeho = ['id' => 'Hubungi Admin Untuk menambah Kode Head Office'];
            }
        
        echo json_encode($kodeho);
    }

    public function kode_pro(){
         $project_code = $this->master_project_model->getkodeunik();

         $kodeho = ['id' => $project_code];

         echo json_encode($kodeho);


    }
}
