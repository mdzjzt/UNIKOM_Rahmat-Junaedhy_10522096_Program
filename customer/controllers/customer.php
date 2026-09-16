<?php

class customer extends MX_Controller {

    private $_class_name = NULL;
    private $_title = ' MASTER CUSTOMER ';
    private $_module = 'customer';

    function __construct() {
        parent::__construct();

        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', TRUE);

        $this->_class_name = get_class($this);
        $this->_module .= '/' . $this->_class_name;


        $this->load->model('customer_model');


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
                        'activity' => 'View List Currency'
            ]);

            $this->load->view($this->_module . '/index', $data);
        }
    }

    public function load()
    {
        if(hprotection::must_ajax($this->_module)) {

            # Init
            $limit  = $this->input->post('length');
            $offset = $this->input->post('start');
            $draw   = $this->input->post('draw');
            $extraColumn = $this->input->post('columns');
            $extraOrder  = $this->input->post('order');

            # Ordering
            $orderBy   = 'customer_id';
            $direction = NULL;

            if($extraColumn[$extraOrder[0]['column']]['orderable'] == 'true') {
                $orderBy = isset($extraColumn[$extraOrder[0]['column']]['name']) ? $extraColumn[$extraOrder[0]['column']]['name'] : NULL;
                $direction   = $extraOrder[0]['dir'];
            }

            # Condition

            $cond = [];

             if (!empty($this->input->post('acount_code'))) {
            $cond["(LOWER(nama_currency) ILIKE '%{$this->input->post('acount_code')}%')"] = NULL;
                }

                if (!empty($this->input->post('description'))) {
                    $cond["(LOWER(currency) ILIKE '%{$this->input->post('description')}%')"] = NULL;
                }

            // $cond['status_delete'] =  0;

            $dataCount          = $this->customer_model->data_joint($cond)->count_all_results();
            $dataCountFiltered  = $this->customer_model->data_joint($cond)->count_all_results();
            $dataResult         = $this->customer_model->data_joint($cond, $orderBy, $direction, $limit, $offset)->get();
            
            $rows = [];
            $no   = $offset;

            foreach ($dataResult->result() as $dt) {

                $id     = $dt->customer_id;

                $action = NULL;

                if($this->laccess->otoritas('edit')) {

                    $action .= anchor(NULL, '<i class="fa fa-trash-o"></i></a>', [
                    'class'          => 'btn btn-danger btn-xs',
                    'rel'            => 'tooltip',
                    'data-placement' => "top",
                    'data-title'     => 'Hapus',
                    'data-url'       => base_url() . $this->_module . '/delete/'. $id,
                    'onclick'        => '$(this).myForm().submit(\'delete\')'
                    ]);
                }

                if($this->laccess->otoritas('delete')) {

                        $action .= anchor(NULL, '<i class="fa fa-edit"></i></a>', [
                        'data-href'      => $this->_module . '/form/' . $id,
                        'class'          => 'btn btn-warning btn-xs margin-right-2',
                        'rel'            => 'tooltip',
                        'data-placement' => "top",
                        'title'          => 'Edit',
                        ]);
                }

                $no++;

                $rows[] = [
                    hgenerator::columns_align($no,'center'),
                    $dt->nama_customer,
                    $dt->area_code_project,
                    $dt->nama_project,
                    $dt->alamat_customer,
                    $dt->contact_nama,
                    $dt->contact_phone,
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

    }



    public function form($id = NULL){
         if ($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {

            $data['_modul']      = $this->_module;
            $data['form_action'] = $this->_module .'/save/'. $id;

            if ($id) {
                $query = $this->customer_model->data($id)->get()->row();
                $data['page_title'] = 'UBAH ' . $this->_title;
                $data['data']       = $query;


            }else{
                $data['page_title']  = 'Tambah' . $this->_title;

            }

            $this->load->view($this->_module . '/form', $data);

         }else{
             echo Modules::run('template/error_message/error_forbidden');
         }
    }

    public function save($id = NULL) {
        if ($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {
            if (hprotection::must_ajax($this->_module . '/404')) {

                $this->form_validation->set_rules('nama_customer', '<i class="fa fa-warning"> Nama Customer</i>', 'trim|required');
                $this->form_validation->set_rules('alamat_customer', '<i class="fa fa-warning"> Alamat Customer</i>', 'trim|required');
              
                if($this->form_validation->run($this)) {

                    $data = [
                        'nama_customer'    => $this->input->post('nama_customer'),
                        'alamat_customer'     => $this->input->post('alamat_customer'),
                        'contact_nama'     => $this->input->post('contact_nama'),
                        'contact_phone' =>  $this->input->post('contact_phone'),
                        'email_customer' =>  $this->input->post('email_customer'),
                        'nama_tax' =>  $this->input->post('nama_tax'),
                        'tax_number' =>  $this->input->post('tax_number'),
                        'tax_code' =>  $this->input->post('tax_code'),
                         ];

                    if ($id) {

                        if ($id = $this->customer_model->update($id, $data)) {
                            $message = ['message' => 'Data Berhasil Disimpan', 'return' => '__afterSubmit()'];
                        }

                          # LOG
                        $this->log_activity_model->save([
                                    'module'   => $this->_module,
                                    'sistem'   => TRUE,
                                    'event'    => 'Insert',
                                    'activity' => 'Update Master Currency'
                        ]);

                    }else {

                        if ($id = $this->customer_model->create($data)) {
                            $message = ['message' => 'Data Berhasil Disimpan', 'return' => '__afterSubmit()'];
                        }

                        # LOG
                        $this->log_activity_model->save([
                                    'module'   => $this->_module,
                                    'sistem'   => TRUE,
                                    'event'    => 'Insert',
                                    'activity' => 'Insert Master Currency'
                        ]);

                    }

                } else {
                    $message = ['error' => true, 'message' => 'Terjadi Kesalahan <br> Periksa kembali data input', 'callback' => $this->form_validation->get_errors_array()];
                }

                echo json_encode($message);

            }
        }else {
            echo Modules::run('template/error_message/error_forbidden');
        }
    }

      public function delete($id)
    {
        $this->customer_model->delete($id);

        # LOG
        $this->log_activity_model->save([
                    'module'   => $this->_module,
                    'sistem'   => TRUE,
                    'event'    => 'Delete',
                    'activity' => 'Hapus Inventaris'
        ]);

        $message = ['type' => 'info', 'message' => 'Data Berhasil Dihapus','return' => '__reloadTable(false)'];
        echo json_encode($message);
    }


}
