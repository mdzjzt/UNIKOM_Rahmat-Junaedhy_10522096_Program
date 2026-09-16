<?php

/**
 * Description of dashboard
 *
 * @author Warman Suganda
 */
class home extends MX_Controller {

    private $_title = 'e-Procurement';
    private $_module = 'home';

    public function __construct() {
        parent::__construct();

        # Protection
        hprotection::login();
        // $this->laccess->check();
        // $this->laccess->otoritas('view', TRUE);
        
        $this->_class_name = get_class($this);
        $this->_module .= '/' . $this->_class_name;

        $this->load->model('menu_model');
       
        $this->load->model('logo_tuv_model');
   
        $this->load->model('email_config_model');

        $this->load->model('purchase_order_model');

        $this->load->model('purchase_item_model');

        $this->load->model('purchase_approve_model');

        $this->load->model('type_approval_model');

        $this->load->model('user_model');
        
     
    }

    public function index() {
        $data['page_content'] = $this->_module . '/form';
        $data['form_action'] = base_url($this->_module . '/run');
        echo Modules::run("template/admin", $data);
    }

    public function dashboard($id=NULL) {
        if (hprotection::must_ajax($this->_module)) {
            $data['app_menu'] = $this->menu_model->data(array('a.id_role' => $this->session->userdata('id_role'), 'a.view_otoritas_modul' => '1', 'b.m_m_id_menu' => $id));
            $data = [
                'page_title' => $this->_title,
                '_modul'     => $this->_module,
                '_title'     => $this->_title,
            ];
            $this->load->view($this->_module . '/dashboard', $data);

        }
    }

    // public function home()
    // {
    //     if(hprotection::must_ajax($this->_module)) {
    //         $data = [
    //             'page_title' => $this->_title,
    //             '_modul'     => $this->_module,
    //             '_title'     => $this->_title,
    //             'role_id'     => $this->session->userdata('id_role'),
    //         ];
    //         //PERSETUJUAN MR
           

    //         $this->load->view($this->_module.'/index',$data);
    //     }
    // }

    public function beranda($id = NULL)
    {
        if(hprotection::must_ajax($this->_module)) {
            $data = [
                'page_title' => 'Template Purchase Order',
                '_modul'     => $this->_module,
                '_title'     => $this->_title,
                'role_id'     => $this->session->userdata('id_role'),
                'id' => $id
            ];

            $data['form_action'] = $this->_module .'/save/'. $id;
         
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
            $orderBy   = 'id_po';
            $direction = NULL;

            if($extraColumn[$extraOrder[0]['column']]['orderable'] == 'true') {
                $orderBy = isset($extraColumn[$extraOrder[0]['column']]['name']) ? $extraColumn[$extraOrder[0]['column']]['name'] : NULL;
                $direction   = $extraOrder[0]['dir'];
            }

            # Condition
          
            $cond = [];

            if (!empty($this->input->post('judul_po'))) {
                $cond["(LOWER(judul_po) ILIKE '%{$this->input->post('judul_po')}%')"] = NULL;
            }

            if (!empty($this->input->post('no_po'))) {
                $cond["(LOWER(no_po) ILIKE '%{$this->input->post('no_po')}%')"] = NULL;
            }

            if (!empty($this->input->post('vendor'))) {
                $cond["(LOWER(vendor) ILIKE '%{$this->input->post('vendor')}%')"] = NULL;
            }

            if (!empty($this->input->post('pembuat'))) {
                $cond["(LOWER(username_user) ILIKE '%{$this->input->post('pembuat')}%')"] = NULL;
            }

            $cond['status_delete'] =  0;

            $dataCount          = $this->purchase_order_model->data($cond)->count_all_results();
            $dataCountFiltered  = $this->purchase_order_model->data($cond)->count_all_results();
            $dataResult         = $this->purchase_order_model->data($cond, $orderBy, $direction, $limit, $offset)->get();

            $rows = [];
            $no   = $offset;
           
            // var_dump($dataResult->result());
            // exit();

            foreach ($dataResult->result() as $dt) {
                
                $id     = $dt->id_po;

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

                 $action .= anchor($this->_module.'/print_order/'.$id, ' <i class="fa fa-print"> </i> </a>',
                                        [
                                            'class'          => 'btn green btn-xs margin-right-2',
                                            'rel'            => 'tooltip',
                                            'data-placement' => 'top',
                                            'title'          => 'preview',
                                            'target'         => '_blank'
                                        ]);

                 $action .= anchor($this->_module.'/print_order_unprice/'.$id, ' <i class="fa fa-print"> </i> Unpirce</a>',
                                        [
                                            'class'          => 'btn btn-default  btn-xs margin-right-2',
                                            'rel'            => 'tooltip',
                                            'data-placement' => 'top',
                                            'title'          => 'preview',
                                            'target'         => '_blank'
                                        ]);
               

                $no++;

                $rows[] = [
                    hgenerator::columns_align($no,'center'),
                    $dt->judul_po,
                    $dt->no_po,
                    $dt->vendor,
                    date('m-d-Y', strtotime($dt->tgl_po)),
                    $dt->username_user,
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
            $data['type_approval']      = $this->type_approval_model->options([], ['' => 'Pilih Role']);
            if ($id) {
                $data['page_title'] = 'UBAH ' . $this->_title;
                $query = $this->purchase_order_model->data($id)->get()->row();
                // var_dump($query);
                // exit();
                $cond = [];
                $cond["id_po"] = $id ;
                $query_item = $this->purchase_item_model->data($cond,'id_item_po')->get();
                $query_approve= $this->purchase_approve_model->data($cond,'id_approve')->get();
                $data['data']       = $query;
                $data['data_item']  = $query_item ;
                $data['data_approve']  = $query_approve ;
            }else{
                $data['page_title']  = 'Tambah' . $this->_title;
               
            }

            $this->load->view($this->_module . '/form', $data);

         // }else{
         //     echo Modules::run('template/error_message/error_forbidden');
         // }
    }

    public function save($id = NULL) {
        
            if (hprotection::must_ajax($this->_module . '/404')) {

                // var_dump($_POST);
                // exit();

                $this->form_validation->set_rules('data_vendor', '<i class="fa fa-warning">Project</i>', 'trim|required');
                $this->form_validation->set_rules('no_po', '<i class="fa fa-warning">No PO</i>', 'trim|required');
                $this->form_validation->set_rules('no_mr', '<i class="fa fa-warning">NO MR</i>', 'trim|required');
                $this->form_validation->set_rules('nama_po', '<i class="fa fa-warning"> Nama PO</i>', 'trim|required');
                $this->form_validation->set_rules('no_proyek', '<i class="fa fa-warning">NO Project</i>', 'trim|required');
                $this->form_validation->set_rules('currency', '<i class="fa fa-warning"> currency </i>', 'trim|required');
                $this->form_validation->set_rules('project_name', '<i class="fa fa-warning">Nama Project</i>', 'trim|required');
                $this->form_validation->set_rules('term_conditions', '<i class="fa fa-warning"> term_conditions</i>', 'trim|required');

                if($this->form_validation->run($this)) {

                    $data = [
                        'vendor'    => $this->input->post('data_vendor'),
                        'no_po'     => $this->input->post('no_po'),
                        'tgl_po'     => date('Y-m-d',strtotime($this->input->post('tgl_po'))),
                        'no_mr'     => $this->input->post('no_mr') ,
                        'judul_po'     => $this->input->post('nama_po'),
                        'currency'    => $this->input->post('currency'),
                        'nama_project'     => $this->input->post('project_name'),
                        'term_conditions'     => $this->input->post('term_conditions'),
                        'diskon'     => $this->input->post('diskon') ? $this->input->post('diskon') : NULL,
                        'jumlah_diskon'     => $this->input->post('gros_total') ? $this->input->post('gros_total')  : NULL,
                        'vat'    => $this->input->post('vat') ? $this->input->post('vat') : NULL,
                        'jumlah_vat'     => $this->input->post('jumlah_vat') ? $this->input->post('jumlah_vat')  : NULL ,
                        'create_by'     =>  $this->session->userdata('id_user'),
                        'create_date'     => date('Y-m-d H:i:s'),
                        'notes'     => $this->input->post('notes'),
                        'area' => $this->input->post('no_proyek'),
                        'alamat' => $this->input->post('alamat'),
                        'fax' => $this->input->post('fax'),
                        'ph' => $this->input->post('ph'),
                        'attn' => $this->input->post('attn'),

                         ];

                    if ($id) {
                         if($this->input->post('remove_item')) {
                            foreach ($this->input->post('remove_item') as $key => $value) {
                                $this->purchase_item_model->delete($this->input->post('remove_item')[$key]);
                            }
                        }

                        if($this->input->post('remove_approve')) {
                            foreach ($this->input->post('remove_approve') as $key => $value) {
                                $this->purchase_approve_model->delete($this->input->post('remove_approve')[$key]);
                            }
                        }

                        if ($this->purchase_order_model->update($id, $data)) {

                             if ($this->input->post('quantity')) {
                                foreach ($this->input->post('quantity') as $key => $value) {
                                    $dataitem = [
                                                    'id_po' => $id,
                                                    'qty'     => $this->input->post('quantity')[$key] ?  $this->input->post('quantity')[$key] : NULL,
                                                    'unit'      => $this->input->post('unit')[$key] ?  $this->input->post('unit')[$key] : NULL,
                                                    'description'      => $this->input->post('barang_nama')[$key] ? $this->input->post('barang_nama')[$key] : NULL,
                                                    'account_code'      => $this->input->post('part_number')[$key] ?  $this->input->post('part_number')[$key] : NULL,
                                                    'unit_price' => $this->input->post('unit_cost')[$key] ?  $this->input->post('unit_cost')[$key] : NULL,
                                                    'total_price' => $this->input->post('total_cost')[$key] ?  $this->input->post('total_cost')[$key] : NULL,
                                                   
                                                ];

                                    if(!empty($this->input->post('id_item_po')[$key])) {
                                        $this->db->where('id_item_po', $this->input->post('id_item_po')[$key]);
                                        $this->db->update('purchase_order_item',$dataitem);
                                    } else {
                                        $this->purchase_item_model->create($dataitem);
                                    }
                                           
                                }
                            }

                            if ($this->input->post('user_id')) {
                                foreach ($this->input->post('user_id') as $key => $value) {
                                    $dataapprove = [
                                                    'id_po' => $id,
                                                    'id_user_approve'     => $this->input->post('user_id')[$key] ?  $this->input->post('user_id')[$key] : NULL,
                                                    'date_approve'      =>  date('Y-m-d ',strtotime($this->input->post('tgl_kebutuhan')[$key])),
                                                    'urutan' =>  $this->input->post('no_urut')[$key] ?  $this->input->post('no_urut')[$key] : NULL,
                                                    'type_approve' =>  $this->input->post('type')[$key] ?  $this->input->post('type')[$key] : NULL,
                                                    'jam' => $this->input->post('jam')[$key] ?  $this->input->post('jam')[$key] : NULL,
                                                ];

                                    if(!empty($this->input->post('id_approve')[$key])) {
                                        $this->db->where('id_approve', $this->input->post('id_approve')[$key]);
                                        $this->db->update('tbl_approve_purchase',$dataapprove);
                                    } else {
                                        $this->purchase_approve_model->create($dataapprove);
                                           
                                    }
                                }
                            }

                            $message = ['message' => 'Data Berhasil Disimpan', 'return' => '__afterSubmit()'];


                        }

                          # LOG
                        // $this->log_activity_model->save([
                        //             'module'   => $this->_module,
                        //             'sistem'   => TRUE,
                        //             'event'    => 'Insert',
                        //             'activity' => 'Update Master Account Code'
                        // ]);

                    }else {

                        if ($id = $this->purchase_order_model->create($data)) {
                            $id_po = $this->db->insert_id();
                            if ($this->input->post('quantity')) {
                                foreach ($this->input->post('quantity') as $key => $value) {
                                    $dataitem = [
                                                    'id_po' => $id_po,
                                                    'qty'     => $this->input->post('quantity')[$key] ?  $this->input->post('quantity')[$key] : NULL,
                                                    'unit'      => $this->input->post('unit')[$key] ?  $this->input->post('unit')[$key] : NULL,
                                                    'description'      => $this->input->post('barang_nama')[$key] ? $this->input->post('barang_nama')[$key] : NULL,
                                                    'account_code'      => $this->input->post('part_number')[$key] ?  $this->input->post('part_number')[$key] : NULL,
                                                    'unit_price' => $this->input->post('unit_cost')[$key] ?  $this->input->post('unit_cost')[$key] : NULL,
                                                    'total_price' => $this->input->post('total_cost')[$key] ?  $this->input->post('total_cost')[$key] : NULL,
                                                   
                                                ];

                                    $this->purchase_item_model->create($dataitem);
                                           
                                }
                            }

                            if ($this->input->post('user_id')) {
                                foreach ($this->input->post('user_id') as $key => $value) {
                                    $dataapprove = [
                                                    'id_po' => $id_po,
                                                    'id_user_approve'     => $this->input->post('user_id')[$key] ?  $this->input->post('user_id')[$key] : NULL,
                                                    'date_approve'      =>  date('Y-m-d H:i:s',strtotime($this->input->post('tgl_kebutuhan')[$key])),
                                                    'jam' => date('H:i:s'),
                                                    'urutan' =>  $this->input->post('no_urut')[$key] ?  $this->input->post('no_urut')[$key] : NULL,
                                                    'type_approve' =>  $this->input->post('type')[$key] ?  $this->input->post('type')[$key] : NULL,
                                                ];

                                    $this->purchase_approve_model->create($dataapprove);
                                           
                                }
                            }


                            $message = ['message' => 'Data Berhasil Disimpan', 'return' => '__afterSubmit()'];
                        }

                        # LOG
                        // $this->log_activity_model->save([
                        //             'module'   => $this->_module,
                        //             'sistem'   => TRUE,
                        //             'event'    => 'Insert',
                        //             'activity' => 'Insert PO'
                        // ]);

                    }
                   
                } else {
                    $message = ['error' => true, 'message' => 'Terjadi Kesalahan <br> Periksa kembali data input', 'callback' => $this->form_validation->get_errors_array()];
                }

                echo json_encode($message);

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

   
    public function print_order($id_po){
          
          
            $data['type'] = 'PURCHASE ORDER';
                $query = $this->purchase_order_model->data($id_po)->get()->row();
                $cond = [];
                $cond["id_po"] = $id_po ;
                $query_item = $this->purchase_item_model->data($cond,'id_item_po')->get();
                $query_approve= $this->purchase_approve_model->data($cond,'id_approve')->get();
                $data['data']       = $query;
                $data['data_item']  = $query_item ;
                $data['data_approve']  = $query_approve ;
           

            $cond=['status_aktip' => 1];
            $cond=['type_logo' => 2];
            $dataimgtuv = $this->logo_tuv_model->data($cond)->get()->row();
            $data['image'] = json_decode($dataimgtuv->image);

            $this->load->library('lpdf');
            $this->lpdf->html($this->load->view($this->_module . '/po_pdf', $data, true));
            $this->lpdf->margin(10,10,10,10,5,5);
            $this->lpdf->print_standard('A4','P');
           
        
    } 

     public function print_order_unprice($id_po){
          
          
            $data['type'] = 'PURCHASE ORDER';
                $query = $this->purchase_order_model->data($id_po)->get()->row();
                $cond = [];
                $cond["id_po"] = $id_po ;
                $query_item = $this->purchase_item_model->data($cond,'id_item_po')->get();
                $query_approve= $this->purchase_approve_model->data($cond,'id_approve')->get();
                $data['data']       = $query;
                $data['data_item']  = $query_item ;
                $data['data_approve']  = $query_approve ;
           

            $cond=['status_aktip' => 1];
            $cond=['type_logo' => 2];
            $dataimgtuv = $this->logo_tuv_model->data($cond)->get()->row();
            $data['image'] = json_decode($dataimgtuv->image);

            $this->load->library('lpdf');
            $this->lpdf->html($this->load->view($this->_module . '/po_unprice_pdf', $data, true));
            $this->lpdf->margin(10,10,10,10,5,5);
            $this->lpdf->print_standard('A4','P');
           
        
    } 

   public function delete($id) 
    {
            $data = [
                        'status_delete'    => 1,
            ];
        $this->purchase_order_model->update($id, $data);

        # LOG
        // $this->log_activity_model->save([
        //             'module'   => $this->_module,
        //             'sistem'   => TRUE,
        //             'event'    => 'Delete',
        //             'activity' => 'Hapus Inventaris'
        // ]);

        $message = ['type' => 'info', 'message' => 'Data Berhasil Dihapus','return' => '__reloadTable(false)'];
        echo json_encode($message);
    }

}
