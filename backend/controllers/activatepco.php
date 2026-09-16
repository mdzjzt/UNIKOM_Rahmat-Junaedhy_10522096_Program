<?php

class activatepco extends MX_Controller {

    private $_class_name = '';
    private $_title = 'activate pco';
    private $_module = 'backend';

    public function __construct() {
        parent::__construct();

        # Protection
        hprotection::login();
        $this->laccess->check();
        //$this->laccess->otoritas('view', TRUE);

        $this->_class_name = get_class($this);
        $this->_module .= '/' . $this->_class_name;

        $this->load->model('activatepco_model');
        $this->load->model('role_model');
        $this->load->model('app_config_model');
        $this->load->model('pegawai_model');
        $this->load->model('cabang_model'); 
        $this->load->model('project_all_model');
        $this->load->model('user_model');
        
    }

    public function index() {
        if (hprotection::must_ajax($this->_module)) {
            # extend model 
            $this->load->model('role_model');

            # Option
            $data['opt_role'] = $this->role_model->options([],NULL);
            $data['opt_st'] = $this->app_config_model->options(array('a.key_setting' => 'STTF'),array('' => ''));

            $data['page_title'] = $this->_title . ' Management';
            $data['_modul'] = $this->_module;
            $data['_title'] = $this->_title;
            $data['cabang'] = $this->cabang_model->options(['status' => true], ['' => '-']);

            # LOG
            $this->log_activity_model->save([
                        'module'   => $this->_module,
                        'event'    => 'View',
                        'activity' => 'View List User'
            ]);

            $this->load->view($this->_module . '/index', $data);
        }
    }

    public function load() {
        if (hprotection::must_ajax($this->_module)) {

            # Init
            $limit  = $this->input->post('length');
            $offset = $this->input->post('start');
            $draw   = $this->input->post('draw');
            $extraColumn = $this->input->post('columns');
            $extraOrder  = $this->input->post('order');

            # Ordering
            $orderBy   = 'a.username_user';
            $direction = NULL;

            if($extraColumn[$extraOrder[0]['column']]['orderable'] == 'true') {
                $orderBy = isset($extraColumn[$extraOrder[0]['column']]['name']) ? $extraColumn[$extraOrder[0]['column']]['name'] : NULL;
                $direction   = $extraOrder[0]['dir'];
            }

            # Condition
            $cond = [];

            if (!empty($this->input->post('keyword'))) {
                $cond["LOWER(username_user) ILIKE '%{$this->input->post('keyword')}%' OR LOWER(username_user) ILIKE '%{$this->input->post('keyword')}%' "] = NULL;
            }

        
            $dataCount          = $this->activatepco_model->data()->count_all_results();
            $dataCountFiltered  = $this->activatepco_model->data($cond)->count_all_results();
            $dataResult         = $this->activatepco_model->data($cond, $orderBy, $direction, $limit, $offset)->get();

            $gs = $this->app_config_model->data_array(['a.key_setting' => 'STTF']);

            $rows = [];
            $no   = $offset;

            foreach ($dataResult->result() as $value) {

                $id = $value->id;

                $action = NULL;
                if ($this->laccess->otoritas('edit')) {
                    $action .= anchor(NULL, '<i class="fa fa-edit"></i></a>', [
                        'class'          => 'btn btn-warning btn-xs',
                        'rel'            => 'tooltip',
                        'data-placement' => 'top',
                        'title'          => 'Ubah',
                        'data-href'      => $this->_module . '/edit/' . $id
                    ]);

                  
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
                 
                    $value->username_user,
                    ''.$value->kode_project.' - '.$value->singkatan.'',
                   
                    hgenerator::button_action($action)
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

    public function add($id = NULL) {
        if ($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {
            if (hprotection::must_ajax($this->_module . '/add')) {                

                # Option
                $data['opt_role']    = $this->role_model->options();
                $data['opt_pegawai'] = $this->pegawai_model->options();
                $data['opt_user'] = $this->activatepco_model->optionsby();
                $data['opt_st']      = $this->app_config_model->options(array('a.key_setting' => 'STTF'), NULL);
                $data['opt_cabang']  = $this->cabang_model->options();
                $data['project']  = $this->project_all_model->options_by(array(), array('' => '--Pilih Project--'));

                $data['page_title']     = 'Tambah ' . $this->_title;
                $data['_modul']         = $this->_module;
                $data['pegawai_source'] = $this->_module . '/get_employee';
                $data['form_action']    = $this->_module . '/save/' . $id;

                # Cek data edit
                if ($id) {
                    $data['page_title'] = 'Edit ' . $this->_title;
                    $data_edit = $this->activatepco_model->data($id)->get();
                    if ($data_edit->num_rows() > 0) {
                        $row = $data_edit->row();
                        $data['data_edit'] = $row;
                    }
                }

                $this->load->view($this->_module . '/form', $data);
            }

        } else {
            echo Modules::run('template/error_message/error_forbidden');
        }
    }
    
    public function edit($id = NULL) {
        # Cek data edit
        if ($this->activatepco_model->data($id)->count_all_results() > 0) {
            $this->add($id);
        } else {
            echo Modules::run('template/error_message/error_404');
        }
    }

   
 
    
    public function save($id = NULL) {

        if($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {

            if(hprotection::must_ajax($this->_module .'/404')) {
                
             
                $this->form_validation->set_rules('id_user', '<i class="fa fa-warning"> Pegawai</i>', 'trim|required');
                $this->form_validation->set_rules('id_project', '<i class="fa fa-warning">Project</i>', 'trim|required');
               

                if ($this->form_validation->run($this)) {

                  

                    $data = [
                       
                        'id_user'      => $this->input->post('id_user'),
                        'id_project'         => $this->input->post('id_project'),
                       
                    ];

                    if($id) {

                        if($this->activatepco_model->update($id,$data)) {
                            $message = ['type' => 'info', 'message' => 'Data Berhasil Diupdate','return' => '__afterSubmit(false)'];
                        }

                        # LOG
                        $this->log_activity_model->save([
                                    'sistem'   => TRUE,
                                    'module'   => $this->_module,
                                    'event'    => 'Update',
                                    'activity' => 'Update User'
                        ]);

                    } else {
                        
                        // $data['password_user'] = hprotection::password_encrypt($username);
                        
                        if($this->activatepco_model->create($data)) {
                            $message = ['message' => 'Data Berhasil Disimpan', 'return' => '__afterSubmit()'];

                            # LOG
                            $this->log_activity_model->save([
                                        'sistem'   => TRUE,
                                        'module'   => $this->_module,
                                        'event'    => 'Insert',
                                        'activity' => 'Insert User'
                            ]);
                        }
                        
                    }

                } else {
                    $message = ['error' => true, 'message' => 'Terjadi Kesalahan <br> Periksa kembali data input', 'callback' => $this->form_validation->get_errors_array()];
                }

                echo json_encode($message);
            }

        } else {
            echo Modules::run('template/error_message/error_forbidden');
        }
    }

    public function delete($id = NULL) {
        if ($this->laccess->otoritas('delete')) {
            # Cek data edit
            if ($this->activatepco_model->data($id)->count_all_results() > 0) {
                if ($this->activatepco_model->delete($id)) {
                    $message = ['type' => 'info', 'message' => 'Data Berhasil Dihapus','return' => '_reloadTable(false)'];
                } else {
                    $message = ['error' => TRUE, 'message' => 'Proses Gagal'];
                }

            } else {
                $message = array('error' => TRUE, 'message' => 'Data yang akan dihapus tidak ditemukan.');
            }

            # LOG
            $this->log_activity_model->save([
                        'sistem'   => TRUE,
                        'module'   => $this->_module,
                        'event'    => 'Delete',
                        'activity' => 'Delete User'
            ]);

            echo json_encode($message);

        } else {
            echo Modules::run('template/error_message/error_forbidden');
        }
    }

   

    public function get_employee() {
        $data = array();

        # Condition Query
        $query = $this->input->get('query');
        $condition = array();
        $condition["LOWER(a.nik_pegawai) + ' - ' + LOWER(a.nama_pegawai)  LIKE  '%{$query}%'"] = NULL;

        #extend model
        $this->load->model('employee_model');
        $source = $this->employee_model->data($condition)->get();

        foreach ($source->result() as $value) {
            $data[] = array(
                'value' => $value->nik_pegawai . ' - ' . $value->nama_pegawai,
                'noreg' => $value->nik_pegawai,
                'id_pegawai' => $value->id_pegawai,
                'name' => $value->nama_pegawai,
                'id_unit_kerja' => $value->id_unit_kerja,
                'nama_unit_kerja' => $value->nama_unit_kerja,
                'id_lokasi_kerja' => $value->id_lokasi_kerja,
                'nama_lokasi_kerja' => $value->nama_lokasi_kerja
            );
        }

        echo json_encode($data);
    }



    public function get_detail()
    {
        $id    = $this->input->post('id');
        $query = $this->user_model->data($id)->get()->row();

        $data = array(
                        'nama_role' => $query->nama_role,
                        // 'nama' => $query->pegawai_nama,
                        // 'cabang' => $query->cabang_nama,
                        // 'jabatan' => $query->jabatan_nama,
                        // 'unitkerja' => $query->unit_kerja_nama,
                    );
        echo json_encode($data);    
    }

}
