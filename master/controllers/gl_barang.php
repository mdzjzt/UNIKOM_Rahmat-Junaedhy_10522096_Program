<?php

    class gl_barang extends MX_Controller
    {
        
        private $_class_name = NULL;
        private $_title      = 'GOLONGAN BARANG';
        private $_module     = 'master';

        function __construct()
        {
            parent::__construct();

            # PROTECTION
            hprotection::login();
            $this->laccess->check();
            $this->laccess->otoritas('view',TRUE);

            $this->_class_name = get_class($this);
            $this->_module    .= '/' . $this->_class_name;

            # LOAD MODEL
            $this->load->model('golongan_barang_model'); 
        }
  

        public function index($id = null)
        {
            /*if(hprotection::must_ajax($this->_module)):
                $data = array(
                                'page_title' => 'MASTER '.$this->_title,
                                '_modul'     => $this->_module,
                                '_title'     => $this->_title, 
                            );
                $this->load->view($this->_module.'/index',$data);
            endif;*/

            $data['pageTitle']  = 'Tambah Golongan Barang';
            $data['_modul']      = $this->_module;
            $data['formAction'] = $this->_module .'/save/' . $id;

            if($id) {

                $data['pageTitle']  = 'Ubah Golongan Barang';
                $data['data'] = $this->golongan_barang_model->data($id)->get()->row();
            }

            $data['nkb1'] = $this->golongan_barang_model->options2(NULL,NULL,NULL,NULL,NULL,NULL,'');

            $this->load->view($this->_module . '/index' ,$data);
        }

        public function add($id = NULL)
        {
            $data['pageTitle']  = 'Tambah Golongan Barang';
            $data['_modul']      = $this->_module;
            $data['formAction'] = $this->_module .'/save/' . $id;

            if($id) {

                $data['pageTitle']  = 'Ubah Golongan Barang';
                $data['data'] = $this->golongan_barang_model->data($id)->get()->row();
            }

            $data['nkb1'] = $this->golongan_barang_model->options2(NULL,NULL,NULL,NULL,NULL,NULL,'');

            $this->load->view($this->_module . '/form' ,$data);
        }

        public function add_nkb()
        {

            $type = $this->input->get('type');
            $data['type'] = $type;
            $data['pageTitle']  = 'Tambah ';
            $data['_modul']     = $this->_module;
            $data['formAction'] = $this->_module .'/create_nkb?type=' . $type;

            $data['optNkb1'] = $this->golongan_barang_model->options2(NULL,NULL,NULL,NULL,NULL,NULL,'');
            $data['optNkb2'] = [];
            $data['optNkb3'] = [];
            $data['optNkb4'] = [];

            $data['nkb1'] = $this->input->get('nkb1');
            $data['nkb2'] = $this->input->get('nkb2');
            $data['nkb3'] = $this->input->get('nkb3');
            $data['nkb4'] = $this->input->get('nkb4');

            $nk1 = NULL ; $nk2 = NULL; $nk3 = NULL; $nk4 = NULL; $nk5 = NULL;

            if($data['nkb1']) {
                $rek  = $data['nkb1'] ;
                $nk1  = (string)$this->golongan_barang_model->get_nkb($rek)->Rek1;
                $data['optNkb2'] = $this->golongan_barang_model->options($nk1,$nk2,$nk3,$nk4,$nk5);
            }

            if($data['nkb2']) {
                $rek  = $data['nkb2'];
                $nk2 = (string)$this->golongan_barang_model->get_nkb($rek)->Rek2;
                $data['optNkb3'] = $this->golongan_barang_model->options($nk1,$nk2,$nk3,$nk4,$nk5);
            }

            if($data['nkb3']) {
                $rek  = $data['nkb3'];
                $nk3 = (string)$this->golongan_barang_model->get_nkb($rek)->Rek3;
                $data['optNkb4'] = $this->golongan_barang_model->options($nk1,$nk2,$nk3,$nk4,$nk5);
            }

            $this->load->view($this->_module . '/form-nkb' ,$data);
        }

        public function edit_nkb()
        {
            $type = $this->input->get('type');
            $data['type'] = $type;
            $data['pageTitle']  = 'Sunting ';
            $data['_modul']     = $this->_module;
            $data['formAction'] = $this->_module .'/update_nkb?type=' . $type;

            $data['qNkb1'] = [];
            $data['qNkb2'] = [];
            $data['qNkb3'] = [];
            $data['qNkb4'] = [];

            $nkb1 = $this->input->get('nkb1');
            $nkb2 = $this->input->get('nkb2');
            $nkb3 = $this->input->get('nkb3');
            $nkb4 = $this->input->get('nkb4');
            
            if($nkb1) {
                $data['qNkb1']  = $this->golongan_barang_model->data($nkb1)->get()->row();
            }

            if($nkb2) {
                $data['qNkb2']  = $this->golongan_barang_model->data($nkb2)->get()->row();
            }

            if($nkb3) {
                $data['qNkb3']  = $this->golongan_barang_model->data($nkb3)->get()->row();
            }

            if($nkb4) {
                $data['qNkb4']  = $this->golongan_barang_model->data($nkb4)->get()->row();
            }

            switch ($type) {
                case '01':
                    $query = $data['qNkb1'];
                    $data['data'] = $query;
                    $data['code'] = $query->Rek1;
                    break;

                case '02':
                    $query = $data['qNkb2'];
                    $data['data'] = $query;
                    $data['code'] = $query->Rek2;
                    break;

                case '03':
                    $query = $data['qNkb3'];
                    $data['data'] = $query;
                    $data['code'] = $query->Rek3;
                    break;

                case '04':
                    $query = $data['qNkb4'];
                    $data['data'] = $query;
                    $data['code'] = $query->Rek4;
                    break;

                case '05':
                    $query = $data['qNkb5'];
                    $data['data'] = $query;
                    $data['code'] = $query->Rek5;
                    break;
            }

            $this->load->view($this->_module . '/form-edit-nkb' ,$data);
        }

        public function get_nkb()
        {
            $id = $this->input->post('key');
            $target = $this->input->get('target');

            $nkb1 = NULL;
            $nkb2 = NULL;
            $nkb3 = NULL;
            $nkb4 = NULL;
            $nkb5 = NULL;
            
            if ($this->input->post('nkb1')):
                $rek = $this->input->post('nkb1');
                $nkb1 = (string) $this->golongan_barang_model->get_nkb($rek)->Rek1;
            endif;

            if ($this->input->post('nkb2')):
                $rek = $this->input->post('nkb2');
                $nkb2 = (string) $this->golongan_barang_model->get_nkb($rek)->Rek2;
            endif;

            if ($this->input->post('nkb3')):
                $rek = $this->input->post('nkb3');
                $nkb3 = (string) $this->golongan_barang_model->get_nkb($rek)->Rek3;
            endif;

            if ($this->input->post('nkb4')):
                $rek = $this->input->post('nkb4');
                $nkb4 = (string) $this->golongan_barang_model->get_nkb($rek)->Rek4;
            endif;

            if ($this->input->post('nkb5')):
                $rek = $this->input->post('nkb3');
                $nkb5 = (string) $this->golongan_barang_model->get_nkb($rek)->Rek5;
            endif;

            $data = [];
            switch ($target) {
                case 'nkb2':
                    $query = $this->golongan_barang_model->option_ajax($nkb1, $nkb2, $nkb3, $nkb4, 'Rek2');

                    $response = [
                        'target' => 'nkb2',
                        'nkb3'   => false,
                        'nkb4'   => false,
                        'nkb5'   => false,
                    ];

                    foreach ($query as $dt) {

                        $data[] = [
                            'id'     => $dt->ID,
                            'name' => $dt->Rek2 .' - '. $dt->Uraian,
                        ]; 
                    }
                    break;

                case 'nkb3':
                    $query = $this->golongan_barang_model->option_ajax($nkb1, $nkb2, $nkb3, $nkb4, 'Rek3');

                    $response = [
                        'target' => 'nkb3',
                        'nkb4'   => false,
                        'nkb5'   => false,
                    ];

                    foreach ($query as $dt) {

                        $data[] = [
                            'id'     => $dt->ID,
                            'name' => $dt->Rek3 .' - '. $dt->Uraian,
                        ]; 
                    }
                    break;

                case 'nkb4':
                    $query = $this->golongan_barang_model->option_ajax($nkb1, $nkb2, $nkb3, $nkb4, 'Rek4');

                    $response = [
                        'target' => 'nkb4',
                        'nkb5'   => false,
                    ];

                    foreach ($query as $dt) {

                        $data[] = [
                            'id'     => $dt->ID,
                            'name' => $dt->Rek4 .' - '. $dt->Uraian,
                        ]; 
                    }
                    break;

                case 'nkb5':
                    $query = $this->golongan_barang_model->option_ajax($nkb1, $nkb2, $nkb3, $nkb4, 'Rek5');

                    $response = [
                        'target' => 'nkb5',
                        'nkb5'   => false,
                    ];

                    foreach ($query as $dt) {

                        $data[] = [
                            'id'     => $dt->ID,
                            'name' => $dt->Rek5 .' - '. $dt->Uraian,
                        ]; 
                    }
                    break;
            }

            header('Content-Type: application/json');
            echo json_encode(array('data' => $data, 'response' => $response));
        }

        public function create_nkb()
        {
            $type = $this->input->get('type');
            $code = $this->input->post('code');

            $this->form_validation->set_rules('code', '<i class="fa fa-warning"> Kode</i>', 'trim|required|max_length[2]');
            $this->form_validation->set_rules('name', '<i class="fa fa-warning"> Nama</i>', 'trim|required');

            $data = [];
            if($type == '01') {
                $data['Rek1'] = $code;
            }

            if($type == '02') {
                $this->form_validation->set_rules('nkb1', '<i class="fa fa-warning"> NKB 1</i>', 'trim|required');
                
                $nkb1 = $this->input->post('nkb1');
                $q = $this->golongan_barang_model->data($nkb1)->get()->row();

                $data['Rek1'] = $q->Rek1;
                $data['Rek2'] = $code;
            }

            if($type == '03') {
                $this->form_validation->set_rules('nkb2', '<i class="fa fa-warning"> NKB 2</i>', 'trim|required');

                $nkb2 = $this->input->post('nkb2');
                $q = $this->golongan_barang_model->data($nkb2)->get()->row();

                $data['Rek1'] = $q->Rek1;
                $data['Rek2'] = $q->Rek2;
                $data['Rek3'] = $code;
            }

            if($type == '04') {

                $this->form_validation->set_rules('nkb3', '<i class="fa fa-warning"> NKB 3</i>', 'trim|required');

                $nkb3 = $this->input->post('nkb3');
                $q = $this->golongan_barang_model->data($nkb3)->get()->row();

                $data['Rek1'] = $q->Rek1;
                $data['Rek2'] = $q->Rek2;
                $data['Rek3'] = $q->Rek3;
                $data['Rek4'] = $code;
            }

            if($type == '05') {

                $this->form_validation->set_rules('nkb4', '<i class="fa fa-warning"> NKB 4</i>', 'trim|required');

                $nkb4 = $this->input->post('nkb4');
                $q = $this->golongan_barang_model->data($nkb4)->get()->row();

                $data['Rek1'] = $q->Rek1;
                $data['Rek2'] = $q->Rek2;
                $data['Rek3'] = $q->Rek3;
                $data['Rek4'] = $q->Rek4;
                $data['Rek5'] = $code;
            }

            $data['Uraian'] = $this->input->post('name');
            $data['CreatedDate'] = date('Y-m-d H:i:s');
            
            if($this->form_validation->run($this)) {

                $id = $this->golongan_barang_model->create($data);
                $message = ['type' => 'info', 'message' => 'Data Berhasil Ditambahkan', 'nType' => $type, 'id' => $id, 'code' => $code, 'name' => $data['Uraian']];

            } else {
                $message = ['error' => true, 'message' => 'Periksa kembali data input', 'callback' => $this->form_validation->get_errors_array()];
            }

            echo json_encode($message);
        }

        public function update_nkb()
        {
            $type = $this->input->get('type');
            
            $id   = $this->input->post('id');
            $code = $this->input->post('code');

            $this->form_validation->set_rules('id', '<i class="fa fa-warning"> Id</i>', 'trim|required');
            $this->form_validation->set_rules('code', '<i class="fa fa-warning"> Kode</i>', 'trim|required|max_length[2]');
            $this->form_validation->set_rules('name', '<i class="fa fa-warning"> Nama</i>', 'trim|required');

            $data = [];
            switch ($type) {
                case '01':
                    $data['Rek1'] = $code;
                    break;

                case '02':
                    $data['Rek2'] = $code;
                    break;

                case '03':
                    $data['Rek3'] = $code;
                    break;

                case '04':
                    $data['Rek4'] = $code;
                    break;

                case '05':
                    $data['Rek5'] = $code;
                    break;
            }

            $data['Uraian'] = $this->input->post('name');
            $data['LastModifiedDate'] = date('Y-m-d H:i:s');

            if($this->form_validation->run($this)) {

                $this->golongan_barang_model->update($id, $data);
                $message = ['type' => 'info', 'message' => 'Data Berhasil Diperbarui', 'nType' => $type, 'id' => $id, 'code' => $code, 'name' => $data['Uraian']];

            } else {
                $message = ['error' => true, 'message' => 'Periksa kembali data input', 'callback' => $this->form_validation->get_errors_array()];
            }

            echo json_encode($message);
        }

        public function delete_nkb()
        {
            $type = $this->input->get('type');
            $id   = $this->input->post('id');

            $nkb1 = $this->input->post('nkb1');
            $nkb2 = $this->input->post('nkb2');
            $nkb3 = $this->input->post('nkb3');
            $nkb4 = $this->input->post('nkb4');
            $nkb5 = $this->input->post('nkb5');

            switch ($type) {
                case '01':
                    $list = [
                        'Rek1' => $nkb1
                    ];
                    
                    $this->golongan_barang_model->delete($list);
                    $this->golongan_barang_model->delete($nkb1);
                    break;

                case '02':
                    $list = [
                        'Rek1' => $nkb1,
                        'Rek2' => $nkb2,
                    ];
                    
                    $this->golongan_barang_model->delete($list);
                    $this->golongan_barang_model->delete($nkb2);
                    break;

                case '03':
                    $this->golongan_barang_model->delete($nkb3);
                    break;

                case '04':
                    $this->golongan_barang_model->delete($nkb4);
                    break;

                case '05':
                    $this->golongan_barang_model->delete($nkb5);
                    break;
            }

            echo json_encode(['message' => 'Data telah dihapus..', 'type' => $type]);
        }

    }