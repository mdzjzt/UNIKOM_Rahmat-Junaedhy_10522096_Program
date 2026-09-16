<?php

class otherpayment extends MX_Controller {

    private $_class_name = NULL;
    private $_title = 'e-accouting';
    private $_module = 'cashbank';

    function __construct() {
        parent::__construct();

        # Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', TRUE);
        
        $this->_class_name = get_class($this);
        $this->_module .= '/' . $this->_class_name;

       
        $this->load->model('logo_tuv_model');
        $this->load->model('master_gl_model');
        $this->load->model('master_coa_model');
        $this->load->model('currency_model');
        $this->load->model('tbl_account_type_coa_model');
        $this->load->model('kode_unik_model');
        $this->load->model('tbl_detail_gl_model');
        $this->load->model('other_payment_model');
        $this->load->model('user_model');
        
     
    }

    public function index() {
        if(hprotection::must_ajax($this->_module)) {
            $data = [
                'page_title' => 'Template Other Payment',
                '_modul'     => $this->_module,
                '_title'     => $this->_title,
                'role_id'     => $this->session->userdata('id_role')
            ];

    
            $this->log_activity_model->save([
                        'module'   => $this->_module,
                        'event' => 'View',
                        'activity' => 'View Other Payment'
            ]);
         
            $this->load->view($this->_module.'/index',$data);
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
            $orderBy   = 'date_op';
            $direction = NULL;

            if($extraColumn[$extraOrder[0]['column']]['orderable'] == 'true') {
                $orderBy = isset($extraColumn[$extraOrder[0]['column']]['name']) ? $extraColumn[$extraOrder[0]['column']]['name'] : NULL;
                $direction   = $extraOrder[0]['dir'];
            }

            # Condition
          
            $cond = [];

            if (!empty($this->input->post('no_other'))) {
                $cond["(LOWER(no_other) ILIKE '%{$this->input->post('no_other')}%')"] = NULL;
            }

             if( !empty($this->input->post('date_by'))) {
                
                switch ($this->input->post('date_by')) {
                    case '1':
                        $cond["(Extract(YEAR from date_op) = '{$this->input->post('tahun')}' )"] = NULL;
                        break;

                    case '2':
                        $cond["(Extract(MONTH from date_op) = '{$this->input->post('bulan')}' )"] = NULL;
                        $cond["(Extract(YEAR from date_op) = '{$this->input->post('tahun')}' )"] = NULL;
                        break;

                    case '3':
                        $cond["( date_op::date >= to_date('".date('Y-m-d', strtotime($this->input->post('tanggal_awal')))."' ,'YYYY-MM-DD') and date_op::date <= to_date('".date('Y-m-d', strtotime($this->input->post('tanggal_akhir')))."' ,'YYYY-MM-DD')  )"] = NULL;
                        break;
                }
            }


            if (!empty($this->input->post('description'))) {
                $cond["(LOWER(payee) ILIKE '%{$this->input->post('description')}%')"] = NULL;
            }

         


            $cond['a.status_delete_op'] =  0;

            $dataCount          = $this->other_payment_model->data($cond)->count_all_results();
            $dataCountFiltered  = $this->other_payment_model->data($cond)->count_all_results();
            $dataResult         = $this->other_payment_model->data($cond, $orderBy, $direction, $limit, $offset)->get()->result();

            $rows = [];
            $no   = $offset;
            // var_dump($dataResult);
            // exit();

            
            foreach ($dataResult as $dt) {
                
                $id     = $dt->id_other_payment;

                $action = NULL;

                // if($this->laccess->otoritas('edit')) {
                    $action .= '<a href="javascript:;"  class="btn btn-success btn-xs" data-row-source="generalledger/generalledger/row_gl/' .$id.'" onClick="myTable.rowDetail(this)"><i class="fa fa-plus-square-o"></i></a> ';

                    $action .= anchor(NULL, '<i class="fa fa-trash-o"></i></a>', [
                    'class'          => 'btn btn-danger btn-xs',
                    'rel'            => 'tooltip',
                    'data-placement' => "top",
                    'data-title'     => 'Hapus',
                    'data-url'       => base_url() . $this->_module . '/delete/'. $id,  
                    'onclick'        => '$(this).myForm().submit(\'delete\')'
                    ]);
                // }

                // if($this->laccess->otoritas('delete')) {
// 
                        $action .= anchor(NULL, '<i class="fa fa-edit"></i></a>', [   
                        'data-href'      => $this->_module . '/form/' . $id,
                        'class'          => 'btn btn-warning btn-xs margin-right-2',
                        'rel'            => 'tooltip',
                        'data-placement' => "top",
                        'title'          => 'Edit',
                        ]);
                // } 

           
               

                $no++;     
                $conddetail = [];

                 // $sum_debit = $this->db->select(" sum(debit_gl) as sum_debit from gl_journal_voucher_detail where id_gl_jurnalvoucher = ".$id." and status_delete_gl_detail = 0 ")->get()->row()->sum_debit;

                $rows[] = [
                    hgenerator::columns_align($no,'center'),
                    $dt->no_other,
                    date('d-m-Y',strtotime($dt->date_op)),
                    number_format($dt->amount_op),
                    $dt->memo_op,
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

     public function row_gl($id_gl_jurnalvoucher)
        {
            $cond=[];
            $cond['a.id_gl_jurnalvoucher'] = $id_gl_jurnalvoucher;
            $data['data'] = $this->tbl_detail_gl_model->data_joint($cond)->get();
            $this->load->view($this->_module.'/row_gl', $data);
        }


    public function form($id = NULL){
         // if ($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {
            $data['_modul']      = $this->_module;
            $data['form_action'] = $this->_module .'/save/'. $id;
            $iduser = $this->session->userdata('id_user');
            $data["id"] = $id;
            $data['account_type']      = $this->tbl_account_type_coa_model->options([], ['' => ' ']);
            $data['coa_account']      = $this->master_coa_model->options(['status_delete_coa' => 0], ['' => '--Pilih Account--']);
            $data['coa_account_cash']      = $this->master_coa_model->options(['status_delete_coa' => 0,'type_coa_id' => 1], ['' => '--Pilih Account--']);
            $data['currency']      = $this->currency_model->options([], ['' => 'Pilih Currency ']);
            $data['sub_coa'] = $this->master_gl_model->options(array('status_delete_gl' => 0), array('' => ' '));
            $tableho = "tbl_cash_bank_other_payment";
            $kode_unik = $this->kode_unik_model->getkodeunikcbother($tableho);
            $data['no_voucher'] =$kode_unik;
            if ($id) {
                $data['page_title'] = 'UBAH ' . $this->_title;
                $query = $this->other_payment_model->data($id)->get()->row();
                $condde=[];
                $condde['id_cb_other_payment'] = $id;
                $condde['cb_no_other'] = 0;
                $data['dtdetail'] = $this->tbl_detail_gl_model->data($condde)->get();
                $data['data']       = $query;
               
              
            }else{
                $data['page_title']  = 'Tambah' . $this->_title;
               
            }

            $this->load->view($this->_module . '/form', $data);

         // }else{
         //     echo Modules::run('template/error_message/error_forbidden');
         // }
    }

    public function load_regency() {
            if ($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {
                if (hprotection::must_ajax($this->_module . '/add')) {

                $id = $this->input->post('key');

                $cond = array();
                $cond["(a.type_coa_id = '{$id}')"] = NULL;
                $data = array();
                $data = $this->master_gl_model->options($cond);
                echo json_encode($data);
                }
            } else {
                echo Modules::run('template/error_message/error_forbidden');
            }
        }

    public function save($id = NULL) {
        
            if (hprotection::must_ajax($this->_module . '/404')) {

                // var_dump($_POST);
                // exit();

                 $this->form_validation->set_rules('no_other', '<i class="fa fa-warning">No Voucher</i>', 'trim|required');
               
                if($this->form_validation->run($this)) {

                    $dataop = [
                                'no_other'    => $this->input->post('no_other') ? $this->input->post('no_other') : NULL,
                                'date_op'     => $this->input->post('date_op') ? date('Y-m-d',strtotime($this->input->post('date_op'))) : NULL,
                                'id_coa_op'     => $this->input->post('id_coa_op') ? $this->input->post('id_coa_op') : NULL,
                                'memo_op'     => $this->input->post('memo_op')? $this->input->post('memo_op') : NULL,
                                'payee' => $this->input->post('payee') ? $this->input->post('payee') : NULL,
                                'void_cheque'     => $this->input->post('void_cheque') ? $this->input->post('void_cheque') : NULL,
                                'cheque_no' => $this->input->post('cheque_no') ? $this->input->post('cheque_no') : NULL,
                                'amount_op'     => $this->input->post('amount_op') ? $this->input->post('amount_op') : NULL,
                                'create_by'     =>  $this->session->userdata('id_user') ,
                                'date_create'     => date('Y-m-d H:i:s'),
                                ];
                    if ($id) {


                        if ($this->other_payment_model->update($id, $dataop)) {

                            if ($this->input->post('id_coa_op')){

                                        $datadetailgl = [
                                                                'id_coa_gl'    => $this->input->post('id_coa_op'), 
                                                                'id_cb_other_payment'     => $id,
                                                                'kredit_gl'     => $this->input->post('amount_op'),
                                                                'memo_gl' =>   $this->input->post('memo_op'),
                                                                'id_currency'     => 1,
                                                                'date_detail_gl'     => date('Y-m-d',strtotime($this->input->post('date_op')))  ? date('Y-m-d',strtotime($this->input->post('date_op'))) : NULL,
                                                                'cb_no_other'    => $this->input->post('no_other') ? $this->input->post('no_other') : NULL,
                                                            ]; 

                                        
                                        $this->db->where('cb_no_other', $this->input->post('no_other'));
                                        $this->db->where('id_cb_other_payment', $id);
                                        $this->db->update('gl_journal_voucher_detail', $datadetailgl);   
                                    
                            }


                            if ($this->input->post('coa_account')){

                                    foreach ($this->input->post('coa_account') as $key => $value) {

                                         $datadetailgl = [
                                                                'id_coa_gl'    => $this->input->post('coa_account')[$key], 
                                                                'id_cb_other_payment'     => $id,
                                                                'debit_gl'     => $this->input->post('ammount_detail')[$key],
                                                                'memo_gl' =>   $this->input->post('memo')[$key],
                                                                'id_currency'     => 1,
                                                               
                                                                'date_detail_gl'     => date('Y-m-d',strtotime($this->input->post('date_op')))  ? date('Y-m-d',strtotime($this->input->post('date_op'))) : NULL,
                                                                
                                                            ]; 


                                        if (!empty($this->input->post('id_detail_jurnal_voucher')[$key])) {
                                            $this->tbl_detail_gl_model->update($this->input->post('id_detail_jurnal_voucher')[$key], $datadetailgl);
                                        }else{
                                            $this->tbl_detail_gl_model->create($datadetailgl);
                                        }
                                        
                                    }
                            }
                            $message = ['message' => 'Data Berhasil Disimpan', 'return' => '__afterSubmit()'];


                        }

                        
                    }else {

                            if ($this->other_payment_model->create($dataop)) {

                                $idgl =    $this->db->insert_id();  
                                if ($this->input->post('id_coa_op')){

                                        $datadetailgl = [
                                                                'id_coa_gl'    => $this->input->post('id_coa_op'), 
                                                                'id_cb_other_payment'     => $idgl,
                                                                'kredit_gl'     => $this->input->post('amount_op'),
                                                                'memo_gl' =>   $this->input->post('memo_op'),
                                                                'id_currency'     => 1,
                                                                'create_by_detail'   =>  $this->session->userdata('id_user'),
                                                                'date_detail_gl'     => date('Y-m-d',strtotime($this->input->post('date_op')))  ? date('Y-m-d',strtotime($this->input->post('date_op'))) : NULL,
                                                                'date_create'     => date('Y-m-d H:i:s'),
                                                                'cb_no_other'    => $this->input->post('no_other') ? $this->input->post('no_other') : NULL,
                                                            ]; 

                                        $this->tbl_detail_gl_model->create($datadetailgl);
                                    
                                }

                                if ($this->input->post('coa_account')){

                                    foreach ($this->input->post('coa_account') as $key => $value) {

                                        $datadetailgl = [
                                                                'id_coa_gl'    => $this->input->post('coa_account')[$key], 
                                                                'id_cb_other_payment'     => $idgl,
                                                                'debit_gl'     => $this->input->post('ammount_detail')[$key],
                                                                'memo_gl' =>   $this->input->post('memo')[$key],
                                                                'id_currency'     => 1,
                                                                'create_by_detail'   =>  $this->session->userdata('id_user'),
                                                                'date_detail_gl'     => date('Y-m-d',strtotime($this->input->post('date_op')))  ? date('Y-m-d',strtotime($this->input->post('date_op'))) : NULL,
                                                                'date_create'     => date('Y-m-d H:i:s'),
                                                            ]; 

                                        $this->tbl_detail_gl_model->create($datadetailgl);
                                    }
                                }

                                $message = ['message' => 'Data Berhasil Disimpan', 'return' => '__afterSubmit()'];
                            }
                       

                    }
                   
            } else {
                $message = ['error' => true, 'message' => 'Terjadi Kesalahan <br> Periksa kembali data input', 'callback' => $this->form_validation->get_errors_array()];
            }

                echo json_encode($message);

        }
        
    }

    public function get_kode_unik($tipe){
                $cond = array();
                $cond['a.type_coa_id'] =  $tipe;
                $cond['id_coa IN (SELECT max(id_coa) FROM master_coa WHERE  type_coa_id = '. $tipe.')'] = NULL;
              
                $kode_unik = $this->master_gl_model->data($cond)->get()->row();

                $data['kode_unik'] = $kode_unik->no_account_coa ;
               
 
                echo json_encode($data);
                exit;
        }


    public function delete($id = NULL)
        {
            if ($this->laccess->otoritas('delete')) {
               
                if ($this->master_gl_model->data($id)->count_all_results() > 0) {
                    if ($this->master_gl_model->delete($id)) {
                        $this->db->where('id_gl_jurnalvoucher',$id);
                        $this->db->delete('gl_journal_voucher_detail');
                        $message = ['type' => 'info', 'message' => 'Data Berhasil Dihapus','return' => '__reloadTable(false)'];
                        # LOG
                        $this->log_activity_model->save([
                                    'module'   => $this->_module,
                                    'sistem'   => TRUE,
                                    'event'    => 'Delete',
                                    'activity' => 'Delete COA '
                        ]);

                    } else {
                        $message = ['error' => TRUE, 'message' => 'Proses Gagal'];
                    }

                } else {
                    $message = ['error' => TRUE, 'message' => 'Data yang akan dihapus tidak ditemukan.'];
                }

                echo json_encode($message);

            } else {
                echo Modules::run('template/error_message/error_forbidden');
            }
        }

}
