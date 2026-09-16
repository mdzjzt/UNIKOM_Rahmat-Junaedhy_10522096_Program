<?php

class item extends MX_Controller {

    private $_class_name = NULL;
    private $_title = ' MASTER ITEM ';
    private $_module = 'item';

    function __construct() {
        parent::__construct();

        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', TRUE);

        $this->_class_name = get_class($this);
        $this->_module .= '/' . $this->_class_name;

        $this->load->model('item_model');
        $this->load->model('type_item_model');
        $this->load->model('kode_unik_model');
        $this->load->model('master_gl_model');
        $this->load->model('master_coa_model');
        $this->load->model('tbl_account_type_coa_model');
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
                        'activity' => 'View List item'
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
            $orderBy   = 'id_item';
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

            $cond['status_delete_item'] =  0;

            $dataCount          = $this->item_model->data_joint($cond)->count_all_results();
            $dataCountFiltered  = $this->item_model->data_joint($cond)->count_all_results();
            $dataResult         = $this->item_model->data_joint($cond, $orderBy, $direction, $limit, $offset)->get();
            
            $rows = [];
            $no   = $offset;

            foreach ($dataResult->result() as $dt) {

                $id     = $dt->id_item;

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
                    $dt->code_item_number,
                    $dt->nama_item,
                    $dt->qty_item,
                    number_format($dt->unit_price_item),
                    $dt->nama_type,
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
            $data['typeoption'] =  $this->type_item_model->options(array(), array('' => '--Pilih Type Item--'));
            $data['account_type_receipe']      = $this->master_coa_model->options(['type_coa_id' => 3], ['' => '--Pilih Account--']);
            $data['account_type_other_income']      = $this->master_coa_model->options(['type_coa_id' => 15], ['' => '--Pilih Account-- ']);
            $data['account_type_cogs']      = $this->master_coa_model->options(['type_coa_id' => 12], ['' => '--Pilih Account --']);
            $data['account_type_liabilty']      = $this->master_coa_model->options(['type_coa_id' => 8], ['' => '--Pilih Account-- ']);
            $tableho = "data_item";
            $kode_unik = $this->kode_unik_model->getkodeunikitem($tableho);
            $data['kodeitem'] = $kode_unik;

            if ($id) {
                $query = $this->item_model->data($id)->get()->row();
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

                $this->form_validation->set_rules('nama_item', '<i class="fa fa-warning"> Nama Item</i>', 'trim|required');
                $this->form_validation->set_rules('id_type', '<i class="fa fa-warning"> Type Item</i>', 'trim|required');
                $this->form_validation->set_rules('code_item_number', '<i class="fa fa-warning">  Code Item Number</i>', 'trim|required');

                $this->form_validation->set_rules('qty_item', '<i class="fa fa-warning"> Quantity</i>', 'trim|required');
                $this->form_validation->set_rules('unit_price_item', '<i class="fa fa-warning">Unit Price</i>', 'trim|required');
                $this->form_validation->set_rules('as_of_item', '<i class="fa fa-warning">  As Of</i>', 'trim|required');
                $this->form_validation->set_rules('nama_unit', '<i class="fa fa-warning">  Unit</i>', 'trim|required');
                $this->form_validation->set_rules('id_inventory_account', '<i class="fa fa-warning"> Inventory Account</i>', 'trim|required');
                $this->form_validation->set_rules('id_sales_account', '<i class="fa fa-warning">  Sales Account</i>', 'trim|required');
                

                if($this->form_validation->run($this)) {

                    $data = [
                        'nama_item'    => $this->input->post('nama_item'),
                        'id_type'     => $this->input->post('id_type'),
                        'code_item_number'     => $this->input->post('code_item_number') ? $this->input->post('code_item_number') : NULL,
                        'qty_item' =>  $this->input->post('qty_item'),
                        'unit_price_item' =>  $this->input->post('unit_price_item'),
                        'as_of_item' => $this->input->post('as_of_item') ? date('Y-m-d',strtotime($this->input->post('as_of_item'))) : NULL,
                        'nama_unit' =>  $this->input->post('nama_unit'),
                        'create_at' => date('Y-m-d H:i:s'),
                        'create_by' => $this->session->userdata('id_user'),
                        'id_inventory_account'     => $this->input->post('id_inventory_account') ? $this->input->post('id_inventory_account') : NULL,
                        'id_sales_account'     => $this->input->post('id_sales_account') ? $this->input->post('id_sales_account') : NULL,
                        'id_sales_return'     => $this->input->post('id_sales_return') ? $this->input->post('id_sales_return') : NULL,
                        'id_sales_item_discount'     => $this->input->post('id_sales_item_discount') ? $this->input->post('id_sales_item_discount') : NULL,
                        'id_cogs'     => $this->input->post('id_cogs') ? $this->input->post('id_cogs') : NULL,
                        'id_retention_account'     => $this->input->post('id_retention_account') ? $this->input->post('id_retention_account') : NULL,
                        'id_unbilled'     => $this->input->post('id_unbilled') ? $this->input->post('id_unbilled') : NULL,
                         ];

                    if ($id) {

                        if ($id = $this->item_model->update($id, $data)) {
                            $message = ['message' => 'Data Berhasil Disimpan', 'return' => '__afterSubmit()'];
                        }

                          # LOG
                        $this->log_activity_model->save([
                                    'module'   => $this->_module,
                                    'sistem'   => TRUE,
                                    'event'    => 'Insert',
                                    'activity' => 'Update Master Item'
                        ]);

                    }else {

                        if ($id = $this->item_model->create($data)) {
                            $message = ['message' => 'Data Berhasil Disimpan', 'return' => '__afterSubmit()'];
                        }

                        # LOG
                        $this->log_activity_model->save([
                                    'module'   => $this->_module,
                                    'sistem'   => TRUE,
                                    'event'    => 'Insert',
                                    'activity' => 'Insert Master Item'
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
        // $this->item_model->delete($id);
        $data = [
                'status_delete_item' => 1,
                         ];
        $this->item_model->update($id, $data);

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
