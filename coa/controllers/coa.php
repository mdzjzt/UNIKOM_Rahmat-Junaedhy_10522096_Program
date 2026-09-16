<?php

class coa extends MX_Controller {

    private $_class_name = NULL;
    private $_title = 'e-accouting';
    private $_module = 'coa';

    function __construct() {
        parent::__construct();

        # Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', TRUE);
        
        $this->_class_name = get_class($this);
        $this->_module .= '/' . $this->_class_name;

       
        $this->load->model('logo_tuv_model');
        $this->load->model('master_coa_model');
        $this->load->model('master_gl_model');
        $this->load->model('tbl_detail_gl_model');
        $this->load->model('currency_model');
        $this->load->model('tbl_account_type_coa_model');
        $this->load->model('tbl_head_coa_model');
        $this->load->model('kode_unik_model');
        
        $this->load->model('user_model');
        
     
    }

    public function index() {
        if(hprotection::must_ajax($this->_module)) {
            $data = [
                'page_title' => 'Template Service Order',
                '_modul'     => $this->_module,
                '_title'     => $this->_title,
                'account_type'      => $this->tbl_account_type_coa_model->options([], ['' => '-- Pilih Type --']),
                'currency'      => $this->currency_model->options([], ['' => 'Pilih Currency ']),
                'sub_coa' => $this->master_coa_model->options(array('status_delete_coa' => 0), array('' => '-- Pilih Account No --')),
                'role_id'     => $this->session->userdata('id_role')
            ];

    
            $this->log_activity_model->save([
                        'module'   => $this->_module,
                        'event' => 'View',
                        'activity' => 'View COA'
            ]);
         
            $this->load->view($this->_module.'/index',$data);
        }
    }

    


    public function load()
    {
        if(hprotection::must_ajax($this->_module)) {

            # Init
            $limit  = 200;
            $offset = $this->input->post('start');
            $draw   = $this->input->post('draw');
            $extraColumn = $this->input->post('columns');
            $extraOrder  = $this->input->post('order');

            # Ordering
            $orderBy   = 'no_account_coa';
            $direction = NULL;

            if($extraColumn[$extraOrder[0]['column']]['orderable'] == 'true') {
                $orderBy = isset($extraColumn[$extraOrder[0]['column']]['name']) ? $extraColumn[$extraOrder[0]['column']]['name'] : NULL;
                $direction   = $extraOrder[0]['dir'];
            }

            # Condition
          
            $cond = [];






            if (!empty($this->input->post('account_no'))) {
                $cond["id_coa"] = $this->input->post('account_no');
            }

            if (!empty($this->input->post('account_nama'))) {
                $cond["(LOWER(account_nama) ILIKE '%{$this->input->post('account_nama')}%')"] = NULL;
            }

            if (!empty($this->input->post('account_type'))) {
                $cond["account_type_id"] = $this->input->post('account_type');
            }

            // if (!empty($this->input->post('balance'))) {
            //     $cond["(LOWER(nama_type) ILIKE '%{$this->input->post('balance')}%')"] = NULL;
            // }

         


            $cond['status_delete_coa'] =  0;

            $dataCount          = $this->master_coa_model->data($cond)->count_all_results();
            $dataCountFiltered  = $this->master_coa_model->data($cond)->count_all_results();
            $dataResult         = $this->master_coa_model->data($cond, $orderBy, $direction, $limit, $offset)->get()->result();

            $rows = [];
            $no   = $offset;
            // var_dump($dataResult);
            // exit();

            
            foreach ($dataResult as $dt) {
                
                $id     = $dt->id_coa;

                $action = NULL;

                // if($this->laccess->otoritas('edit')) {

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
                //   $action = NULL;
                 // $opening_balance = NULL;
              
                    // if (empty($dt->opening_balance)) {
                    //     $opening_balance .= $this->db->select("sum(opening_balance) as total from master_coa where sub_account_off = ".$dt->id_coa." ")->get()->row()->total;
                    // }

                    // if (empty($dt->sub_account_off)) {
                    //     $opening_balance .= $this->db->select("sum(opening_balance) as total from master_coa where id_head_sub_coa = ".$dt->id_coa." ")->get()->row()->total;
                    // }else{
                    //     $opening_balance .= $dt->opening_balance;
                    // }

                  $opening_balance = 0;

                  // $balance=0;
                   $debit = 0;

                   if ($dt->id_head_coa == 1 || $dt->id_head_coa == 5 ) {

                        $debit .= $this->db->select("sum(debit_gl) as total_debit from gl_journal_voucher_detail where id_coa_gl = ".$dt->id_coa." and status_delete_gl_detail = 0")->get()->row()->total_debit;

                        $kredit  = $this->db->select("sum(kredit_gl) as total_kredit from gl_journal_voucher_detail where id_coa_gl = ".$dt->id_coa." and status_delete_gl_detail = 0 ")->get()->row()->total_kredit;
                        
                        // if (!empty($kredit)) {
                        //     $balance='('.number_format($kredit).')';
                        // }else{
                        //     $balance=number_format($opening_balance);
                        // }

                        $opening_balance .= $debit - $kredit;

                        $balance =number_format(abs($opening_balance));

                       

                    }

                    if ($dt->id_head_coa == 2 || $dt->id_head_coa == 3 || $dt->id_head_coa == 4) {

                        $debitminus = $this->db->select("sum(debit_gl) as total_debit from gl_journal_voucher_detail where id_coa_gl = ".$dt->id_coa." and status_delete_gl_detail = 0 ")->get()->row()->total_debit;
                       

                        $kredit  = $this->db->select("sum(kredit_gl) as total_kredit from gl_journal_voucher_detail where id_coa_gl = ".$dt->id_coa."  and status_delete_gl_detail = 0 ")->get()->row()->total_kredit;

                       $opening_balance .= $kredit - $debitminus;

                       $balance ='('.number_format(abs($opening_balance)).')';
                    }



                    // $opening_balance =  $this->db->select("sum(debit_gl) as total_opening_debit from gl_journal_voucher_detail ")->get()->row()->total_opening_debit;
                   

                $rows[] = [
                   
                    $dt->no_account_coa,
                    $dt->account_nama,
                    $dt->nama_type,
                    $balance,
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
         // if ($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {
            $data['_modul']      = $this->_module;
            $data['form_action'] = $this->_module .'/save/'. $id;
            $iduser = $this->session->userdata('id_user');
            $data["id"] = $id;
            $data['account_type']      = $this->tbl_account_type_coa_model->options([], ['' => ' ']);
            $data['head_coa'] = $this->tbl_head_coa_model->options(
    [],
    ['' => '-- Pilih Head COA --']
);
            $data['currency']      = $this->currency_model->options([], ['' => 'Pilih Currency ']);
            $data['sub_coa'] = $this->master_coa_model->options(array('status_delete_coa' => 0), array('' => ' '));
            
            if ($id) {
                $data['page_title'] = 'UBAH ' . $this->_title;
                $query = $this->master_coa_model->data($id)->get()->row();
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
                $data = $this->master_coa_model->options($cond);
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

                $this->form_validation->set_rules('account_type', '<i class="fa fa-warning">Account Type</i>', 'trim|required');
                $this->form_validation->set_rules('no_account_coa', '<i class="fa fa-warning"> No Account</i>', 'trim|required');
                $this->form_validation->set_rules('account_nama', '<i class="fa fa-warning">Name</i>', 'trim|required');
               
              
                
                if($this->form_validation->run($this)) {



                    $data = [
                        'type_coa_id'    => $this->input->post('account_type'),
                        'no_account_coa'     => $this->input->post('no_account_coa'),
                        'account_nama'     => $this->input->post('account_nama') ,
                        'currency_coa'     =>  $this->input->post('currency') ? $this->input->post('currency') : NULL,
                        'check_sub' =>  $this->input->post('check_sub') ? $this->input->post('check_sub') : NULL,
                        'sub_account_off'     => $this->input->post('sub_account_off') ? $this->input->post('sub_account_off') : NULL,
                        'opening_balance'     => $this->input->post('opening_balance') ? $this->input->post('opening_balance') : NULL,
                        'tgl_opening_balance'     => $this->input->post('tgl_opening_balance') ? date('Y-m-d',strtotime($this->input->post('tgl_opening_balance'))) : NULL,
                        'create_by'     =>  $this->session->userdata('id_user'),
                        'date_create'     => date('Y-m-d H:i:s'),
                        ];

                    if ($id) {


                        if ($this->master_coa_model->update($id, $data)) {


                            $message = ['message' => 'Data Berhasil Disimpan', 'return' => '__afterSubmit()'];


                        }

                        
                    }else {

                        $esix = $this->master_coa_model->is_exist($this->input->post('no_account_coa'));

                       
                        
                        if($esix == 1){
                           $message = ['error' => true, 'message' => 'No Account COA sudah ADA', 'callback' => $this->form_validation->get_errors_array()];
                        }else{


                            if ($this->master_coa_model->create($data)) {

                                $id_coa = $this->db->insert_id();
                                if (empty($this->input->post('sub_account_off'))) {
                                    $dataup = [
                                                  
                                                    'id_head_sub_coa'     =>$id_coa ? $id_coa : NULL,
                                                ];

                                                $this->master_coa_model->update($id_coa, $dataup);

                                    }
                              

                                if (!empty($this->input->post('sub_account_off'))) {

                                    $sub_account_off = $this->master_coa_model->is_exist_parents($this->input->post('sub_account_off'));
                                  
                                
                                    if($sub_account_off == 1){

                                            if ($this->input->post('sub_account_off') == $id_coa) {
                                                $dataup = [
                                                    'sub_account_off'     =>$id_coa ? $id_coa : NULL,
                                                    'id_head_sub_coa'     =>$id_coa ? $id_coa : NULL,
                                                ];

                                                $this->master_coa_model->update($id_coa, $dataup);
                                            }

                                            $cond=[];
                                            $cond['id_coa'] = $this->input->post('sub_account_off');
                                            $id_head_sub_coa = $this->master_coa_model->data($cond)->get()->row()->id_head_sub_coa;
                                            // var_dump($id_head_sub_coa);
                                            // exit();
                                            if (!empty($id_head_sub_coa)) {
                                                    $dataupp = [
                                                      
                                                        'id_head_sub_coa'     =>$id_head_sub_coa ? $id_head_sub_coa : NULL,
                                                    ];

                                                    $this->master_coa_model->update($id_coa, $dataupp);
                                             }
                                           
                                    }



                                       

                                }


                                 if (!empty($this->input->post('opening_balance'))) {

                                        $tableho = "gl_journal_voucher";
                                        $kode_unik = $this->kode_unik_model->getkodeunikgl($tableho);
                                       

                                        $no_voucher_gl =$kode_unik;

                                        $descriptionn = "Account Opening Balance ".$no_voucher_gl  ;

                                        $datagl = [
                                            'no_voucher_gl'    => $no_voucher_gl,
                                            'date_gl'     => $this->input->post('tgl_opening_balance') ? date('Y-m-d',strtotime($this->input->post('tgl_opening_balance'))) : NULL,
                                            'id_currency'     => $this->input->post('currency') ? $this->input->post('currency') : NULL,
                                            'description'     =>  $descriptionn,
                                            'id_coa' =>   $id_coa,
                                            'amount_gl' => $this->input->post('opening_balance'),
                                            'create_by'     =>  $this->session->userdata('id_user'),
                                            'date_create'     => date('Y-m-d H:i:s'),
                                            ];
                                            
                                        if ($this->master_gl_model->create($datagl)) {
                                        
                                                $idgl =    $this->db->insert_id();  

                                            $idheadcoa = $this->db->select("id_head_coa from tbl_account_type_coa where account_type_id = ".$this->input->post('account_type')." ")->get()->row()->id_head_coa;

                                            if ($idheadcoa == 1 || $idheadcoa == 5 ) {
                                                 if ($this->input->post('opening_balance') < 0) {

                                                    if ($this->input->post('account_type') == 6) {
                                                        $open = abs($this->input->post('opening_balance'));
                                                        $datadetailgl1 = [
                                                            'id_coa_gl'    => $id_coa,
                                                            'id_gl_jurnalvoucher'     => $idgl,
                                                            'debit_gl'     => $open,
                                                            'memo_gl' =>   $id_coa,
                                                            'id_currency'     => $this->input->post('currency') ? $this->input->post('currency') : NULL,
                                                            'create_by_detail'   =>  $this->session->userdata('id_user'),
                                                            'date_detail_gl'     => $this->input->post('tgl_opening_balance') ? date('Y-m-d',strtotime($this->input->post('tgl_opening_balance'))) : NULL,
                                                            'date_create'     => date('Y-m-d H:i:s'),
                                                        ]; 

                                                        $this->tbl_detail_gl_model->create($datadetailgl1);

                                                        $datadetailgl2 = [
                                                            'id_coa_gl'    => 71,
                                                            'id_gl_jurnalvoucher'     => $idgl,
                                                            'kredit_gl'     =>  $open,
                                                            'memo_gl' =>   $id_coa,
                                                            'id_currency'     => $this->input->post('currency') ? $this->input->post('currency') : NULL,
                                                            'create_by_detail'   =>  $this->session->userdata('id_user'),
                                                            'date_detail_gl'     => $this->input->post('tgl_opening_balance') ? date('Y-m-d',strtotime($this->input->post('tgl_opening_balance'))) : NULL,
                                                            'date_create'     => date('Y-m-d H:i:s'),
                                                        ]; 

                                                        $this->tbl_detail_gl_model->create($datadetailgl2);
                                                    }else{
                                                        $open = abs($this->input->post('opening_balance'));
                                                        $datadetailgl2 = [
                                                            'id_coa_gl'    => 71,
                                                            'id_gl_jurnalvoucher'     => $idgl,
                                                            'debit_gl'     => $open ,
                                                            'memo_gl' =>   $id_coa,
                                                            'id_currency'     => $this->input->post('currency') ? $this->input->post('currency') : NULL,
                                                            'create_by_detail'   =>  $this->session->userdata('id_user'),
                                                            'date_detail_gl'     => $this->input->post('tgl_opening_balance') ? date('Y-m-d',strtotime($this->input->post('tgl_opening_balance'))) : NULL,
                                                            'date_create'     => date('Y-m-d H:i:s'),
                                                        ]; 

                                                        $this->tbl_detail_gl_model->create($datadetailgl2);

                                                        $datadetailgl1 = [
                                                            'id_coa_gl'    => $id_coa,
                                                            'id_gl_jurnalvoucher'     => $idgl,
                                                            'kredit_gl'     =>  $open ,
                                                            'memo_gl' =>   $id_coa,
                                                            'id_currency'     => $this->input->post('currency') ? $this->input->post('currency') : NULL,
                                                            'create_by_detail'   =>  $this->session->userdata('id_user'),
                                                            'date_detail_gl'     => $this->input->post('tgl_opening_balance') ? date('Y-m-d',strtotime($this->input->post('tgl_opening_balance'))) : NULL,
                                                            'date_create'     => date('Y-m-d H:i:s'),
                                                        ]; 
                                                        $this->tbl_detail_gl_model->create($datadetailgl1);
                                                    } 

                                                }else{

                                                    $datadetailgl1 = [
                                                        'id_coa_gl'    => $id_coa,
                                                        'id_gl_jurnalvoucher'     => $idgl,
                                                         'debit_gl'     => $this->input->post('opening_balance'),
                                                        'memo_gl' =>   $id_coa,
                                                        'id_currency'     => $this->input->post('currency') ? $this->input->post('currency') : NULL,
                                                        'create_by_detail'   =>  $this->session->userdata('id_user'),
                                                        'date_detail_gl'     => $this->input->post('tgl_opening_balance') ? date('Y-m-d',strtotime($this->input->post('tgl_opening_balance'))) : NULL,
                                                        'date_create'     => date('Y-m-d H:i:s'),
                                                    ]; 

                                                    $this->tbl_detail_gl_model->create($datadetailgl1);

                                                    $datadetailgl2 = [
                                                        'id_coa_gl'    => 71,
                                                        'id_gl_jurnalvoucher'     => $idgl,
                                                        'kredit_gl'     =>  $this->input->post('opening_balance'),
                                                        'memo_gl' =>   $id_coa,
                                                        'id_currency'     => $this->input->post('currency') ? $this->input->post('currency') : NULL,
                                                        'create_by_detail'   =>  $this->session->userdata('id_user'),
                                                        'date_detail_gl'     => $this->input->post('tgl_opening_balance') ? date('Y-m-d',strtotime($this->input->post('tgl_opening_balance'))) : NULL,
                                                        'date_create'     => date('Y-m-d H:i:s'),
                                                    ]; 

                                                    $this->tbl_detail_gl_model->create($datadetailgl2);
                                                   
                                                }

                                            }else if ($idheadcoa == 2 || $idheadcoa == 3 || $idheadcoa == 4) {

                                                if ($this->input->post('opening_balance') < 0) {
                                                    $openingbalance = abs($this->input->post('opening_balance'));
                                                    $datadetailgl2 = [
                                                        'id_coa_gl'    => 71,
                                                        'id_gl_jurnalvoucher'     => $idgl,
                                                        'kredit_gl'     =>  $openingbalance,
                                                        'memo_gl' =>   $id_coa,
                                                        'id_currency'     => $this->input->post('currency') ? $this->input->post('currency') : NULL,
                                                        'create_by_detail'   =>  $this->session->userdata('id_user'),
                                                        'date_detail_gl'     => $this->input->post('tgl_opening_balance') ? date('Y-m-d',strtotime($this->input->post('tgl_opening_balance'))) : NULL,
                                                        'date_create'     => date('Y-m-d H:i:s'),
                                                    ]; 

                                                     $this->tbl_detail_gl_model->create($datadetailgl2);

                                                    $datadetailgl1 = [
                                                        'id_coa_gl'    => $id_coa,
                                                        'id_gl_jurnalvoucher'     => $idgl,
                                                        'debit_gl'     => $openingbalance,
                                                        'memo_gl' =>   $id_coa,
                                                        'id_currency'     => $this->input->post('currency') ? $this->input->post('currency') : NULL,
                                                        'create_by_detail'   =>  $this->session->userdata('id_user'),
                                                        'date_detail_gl'     => $this->input->post('tgl_opening_balance') ? date('Y-m-d',strtotime($this->input->post('tgl_opening_balance'))) : NULL,
                                                        'date_create'     => date('Y-m-d H:i:s'),
                                                    ]; 

                                                    $this->tbl_detail_gl_model->create($datadetailgl1);
                                                }else{
                                                    $datadetailgl2 = [
                                                        'id_coa_gl'    => 71,
                                                        'id_gl_jurnalvoucher'     => $idgl,
                                                        'debit_gl'     =>  $this->input->post('opening_balance'),
                                                        'memo_gl' =>   $id_coa,
                                                        'id_currency'     => $this->input->post('currency') ? $this->input->post('currency') : NULL,
                                                        'create_by_detail'   =>  $this->session->userdata('id_user'),
                                                        'date_detail_gl'     => $this->input->post('tgl_opening_balance') ? date('Y-m-d',strtotime($this->input->post('tgl_opening_balance'))) : NULL,
                                                        'date_create'     => date('Y-m-d H:i:s'),
                                                    ]; 

                                                     $this->tbl_detail_gl_model->create($datadetailgl2);

                                                    $datadetailgl1 = [
                                                        'id_coa_gl'    => $id_coa,
                                                        'id_gl_jurnalvoucher'     => $idgl,
                                                        'kredit_gl'     => $this->input->post('opening_balance'),
                                                        'memo_gl' =>   $id_coa,
                                                        'id_currency'     => $this->input->post('currency') ? $this->input->post('currency') : NULL,
                                                        'create_by_detail'   =>  $this->session->userdata('id_user'),
                                                        'date_detail_gl'     => $this->input->post('tgl_opening_balance') ? date('Y-m-d',strtotime($this->input->post('tgl_opening_balance'))) : NULL,
                                                        'date_create'     => date('Y-m-d H:i:s'),
                                                    ]; 

                                                    $this->tbl_detail_gl_model->create($datadetailgl1);
                                                }

                                                    
                                            }
                                               
                                               
                                        }
                                    }
                                

                                $message = ['message' => 'Data Berhasil Disimpan', 'return' => '__afterSubmit()'];
                            }
                        }

                    }
                   
                } else {
                    $message = ['error' => true, 'message' => 'Terjadi Kesalahan <br> Periksa kembali data input', 'callback' => $this->form_validation->get_errors_array()];
                }

                echo json_encode($message);

            }
        
    }

    public function add_account_type()
{
    if (hprotection::must_ajax($this->_module . '/404')) {

        $this->form_validation->set_rules(
            'nama_type',
            'Account Type',
            'trim|required'
        );

        $this->form_validation->set_rules(
            'id_head_coa',
            'Head COA',
            'trim|required'
        );

        if ($this->form_validation->run($this)) {

            $nama_type = trim($this->input->post('nama_type'));
            $id_head_coa = $this->input->post('id_head_coa');

            // Cek Account Type sudah ada atau belum
            $exist = $this->tbl_account_type_coa_model
                ->is_exist_name($nama_type);

            if ($exist == 1) {

                $message = [
                    'error' => TRUE,
                    'message' => 'Account Type "' . $nama_type . '" sudah ada.'
                ];

            } else {

                $data = [
                    'nama_type'   => $nama_type,
                    'id_head_coa' => $id_head_coa
                ];

                $id = $this->tbl_account_type_coa_model
                    ->create($data);

                if ($id) {

                    $message = [
                        'success' => TRUE,
                        'message' => 'Account Type berhasil ditambahkan.',
                        'account_type_id' => $id,
                        'nama_type' => $nama_type
                    ];

                } else {

                    $message = [
                        'error' => TRUE,
                        'message' => 'Account Type gagal ditambahkan.'
                    ];
                }
            }

        } else {

            $message = [
                'error' => TRUE,
                'message' => 'Nama Account Type dan Head COA wajib diisi.'
            ];
        }

        echo json_encode($message);
    }
}

    public function get_kode_unik($tipe){
                $cond = array();
                $cond['a.type_coa_id'] =  $tipe;
                $cond['id_coa IN (SELECT max(id_coa) FROM master_coa WHERE  type_coa_id = '. $tipe.')'] = NULL;
              
                $kode_unik = $this->master_coa_model->data($cond)->get()->row();

                $data['kode_unik'] = $kode_unik->no_account_coa ;
               
 
                echo json_encode($data);
                exit;
        }


    // public function delete($id = NULL)
    //     {
    //         if ($this->laccess->otoritas('delete')) {
               
    //             if ($this->master_coa_model->data($id)->count_all_results() > 0) {
    //                  $datadelcoa = [ 'status_delete_coa'     => 1, ];
    //                 if ($this->master_coa_model->update($id, $datadelcoa)) {
    //                     $datgl = $this->db->select("* from gl_journal_voucher_detail where id_coa_gl = ".$id." ")->get();
    //                     if (!empty($datgl)) {
    //                         foreach($datgl->result() as $value) {
    //                             $datadel = [ 'status_delete_gl'     => 1, ];
    //                             $this->db->where('id_gl_jurnalvoucher',$value->id_gl_jurnalvoucher);
    //                             $this->db->update('gl_journal_voucher',$datadel);
    //                         }
    //                     }
                       
    //                     $datadeldetail = [ 'status_delete_gl_detail'     => 1, ];                       
    //                     $this->db->where('id_coa_gl',$id);
    //                     $this->db->update('gl_journal_voucher_detail',$datadeldetail);

    //                     $message = ['type' => 'info', 'message' => 'Data Berhasil Dihapus','return' => '__reloadTable(false)'];
    //                     # LOG
    //                     $this->log_activity_model->save([
    //                                 'module'   => $this->_module,
    //                                 'sistem'   => TRUE,
    //                                 'event'    => 'Delete',
    //                                 'activity' => 'Delete COA '
    //                     ]);

    //                 } else {
    //                     $message = ['error' => TRUE, 'message' => 'Proses Gagal'];
    //                 }

    //             } else {
    //                 $message = ['error' => TRUE, 'message' => 'Data yang akan dihapus tidak ditemukan.'];
    //             }

    //             echo json_encode($message);

    //         } else {
    //             echo Modules::run('template/error_message/error_forbidden');
    //         }
    //     }

     public function delete($id = NULL)
        {
            if ($this->laccess->otoritas('delete')) {
               
                if ($this->master_coa_model->data($id)->count_all_results() > 0) {
                     $datadelcoa = [ 'status_delete_coa'     => 1, ];
                    if ($this->master_coa_model->delete($id)) {
                        $datgl = $this->db->select("* from gl_journal_voucher_detail where id_coa_gl = ".$id." ")->get();
                        if (!empty($datgl)) {
                            foreach($datgl->result() as $value) {
                                $datadel = [ 'status_delete_gl'     => 1, ];
                                $this->db->where('id_gl_jurnalvoucher',$value->id_gl_jurnalvoucher);
                                $this->db->delete('gl_journal_voucher');
                            }
                        }
                       
                        $datadeldetail = [ 'status_delete_gl_detail'     => 1, ];                       
                        $this->db->where('id_coa_gl',$id);
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
