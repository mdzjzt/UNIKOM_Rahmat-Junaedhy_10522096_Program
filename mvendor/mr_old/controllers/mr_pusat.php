<?php

class mr_pusat extends MX_Controller {

    private $_class_name = NULL;
    private $_title = ' List Head Office';
    private $_module = 'mr';
    private $_workflow_persetujuan='PRO-MR-01';


    function __construct() {
        parent::__construct();
        #Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', TRUE);

        $this->_class_name = get_class($this);
        $this->_module .= '/' . $this->_class_name;

        #Load Model
        $this->load->model('mr_pusat_model');
        $this->load->model('jenis_barang_model');
        $this->load->model('kode_jenis_barang_model');
        $this->load->model('barang_spec_model');
        $this->load->model('satuan_model');
        $this->load->model('barang_model');
        $this->load->model('persediaan_model');
        $this->load->model('kode_unik_model');
        $this->load->model('workflow_model');
        $this->load->model('workflow_detail_model');
        $this->load->model('account_code_model');
        $this->load->model('mr_persetujuan_model');
        $this->load->model('logo_tuv_model');
        $this->load->model('email_config_model');
        $this->load->model('total_model');
        $this->load->model('email_list_model');
        $this->load->model('currency_model');
    }

    public function index() {

        if(hprotection::must_ajax($this->_module)) {
            
            $data = [
                'page_title' => $this->_title,
                '_modul'     => $this->_module,
                '_title'     => $this->_title,
                'pegawai_nama' => $this->session->userdata('pegawai_nama'),
                // 'id_user' => $this->session->userdata('id_user'),
               
            ];

            # LOG
            $this->log_activity_model->save([
                        'module'   => $this->_module,
                        'event' => 'View',
                        'activity' => 'View MR'
            ]);

            $this->load->view($this->_module.'/index',$data);
        }
    }

    public function load(){
        if(hprotection::must_ajax($this->_module)) {

            $id_user = $this->session->userdata('id_user');

            # Init
            $limit  = $this->input->post('length');
            $offset = $this->input->post('start');
            $draw   = $this->input->post('draw');
            $extraColumn = $this->input->post('columns');
            $extraOrder  = $this->input->post('order');

            # Ordering
            $orderBy   = 'id_master_project';
            $direction = NULL;

            if($extraColumn[$extraOrder[0]['column']]['orderable'] == 'true') {
                $orderBy = isset($extraColumn[$extraOrder[0]['column']]['name']) ? $extraColumn[$extraOrder[0]['column']]['name'] : NULL;
                $direction   = $extraOrder[0]['dir'];
            }

            # Condition
            $cond = [];
            $cond['id_user'] = $id_user;
            $cond['status_buat_projek <= 2'] = NULL;

            
              if (!empty($this->input->post('keyword'))) {
               $searc = strtolower($this->input->post('keyword'));
                $cond["LOWER(b.nama_project) LIKE '%{$searc}%'"] = NULL;
            }

            if (!empty($this->input->post('kode_projek'))) {

                $cond["b.kode_project LIKE '%{$this->input->post('kode_projek')}%'"] = NULL;
            }

            if (!empty($this->input->post('client'))) {

                $searclient = strtolower($this->input->post('client'));
                $cond["LOWER(b.client_project) LIKE '%{$searclient}%'"] = NULL;
            }



            if (!empty($this->input->post('tanggal'))) {
                $cond['b.create_at'] = date('Y-m-d',strtotime($this->input->post('tanggal')));
            }

            $dataCount          = $this->mr_pusat_model->data_project($cond)->count_all_results();
            $dataCountFiltered  = $this->mr_pusat_model->data_project($cond)->count_all_results();
            $dataResult         = $this->mr_pusat_model->data_project($cond, $orderBy, $direction, $limit, $offset)->get();

            $rows = [];
            $no   = $offset;

            foreach ($dataResult->result() as $dt) {
                $no++;
                 $action = NULL;
                   // $status="";
                   //  $dataMR         = $this->mr_pusat_model->data_mr(array('id_master_project'=>$dt->id_m_project))->get();
                   //  if($dataMR->num_rows() >0 ){
                   //       $no_mrr = 1;
                   //      foreach ($dataMR->result() as $dtMR) {
                   //        if ($dtMR->status_approve == 0) {
                   //             $status_app = '<span style="color:#F0AD4E">DI PROSES</span>';
                   //         }else if($dtMR->status_approve == 1){
                   //             $status_app = '<span style="color:#68B4F1">DI TERIMA </span>';
                   //         }else if($dtMR->status_approve == 2){
                   //             $status_app = '<span style="color:yellow">DI REVISI</span>';
                   //         }else if($dtMR->status_approve == 3){
                   //             $status_app = '<span style="color:red">DI TOLAK </span>';
                   //         }

                   //              $status .=''.$no_mrr++.'. '.$dtMR->kode_mr.'  '.$status_app.'<br>';
                   //      }
                   //  }
                    $dataMR         = $this->mr_pusat_model->data_mr(array('id_master_project'=>$dt->id_m_project))->get();
                    $dataMRproses   = $this->mr_pusat_model->data_mr(array('id_master_project'=>$dt->id_m_project,'status_approve'=>0,'status_save'=>1))->get();
                    $dataMRterima   = $this->mr_pusat_model->data_mr(array('id_master_project'=>$dt->id_m_project,'status_approve'=>1,'status_save'=>1))->get();
                    $dataMRrevisi   = $this->mr_pusat_model->data_mr(array('id_master_project'=>$dt->id_m_project,'status_approve'=>2,'status_save'=>1))->get();
                    $dataMRtolak    = $this->mr_pusat_model->data_mr(array('id_master_project'=>$dt->id_m_project,'status_approve'=>3,'status_save'=>1))->get();
                    $dataMRdraft   = $this->mr_pusat_model->data_mr(array('id_master_project'=>$dt->id_m_project,'status_save'=>2))->get();
                    $total_mr=$dataMR->num_rows();
                    $total_mr_proses=$dataMRproses->num_rows();
                    $total_mr_terima=$dataMRterima->num_rows();
                    $total_mr_revisi=$dataMRrevisi->num_rows();
                    $total_mr_tolak=$dataMRtolak->num_rows();
                    $total_draft=$dataMRdraft->num_rows();
                    $status = "";
                    if($total_draft != 0){
                        $status .='<span style="color:red;"> MR DI DRAFT '.$total_draft.'</span><br>';
                    }
                    if ($total_mr_proses != 0) {
                       $status .='<span style="color:#68B4F1;"> MR Di AJUKAN '.$total_mr_proses.'</span><br>';
                    }

                    if ($total_mr_terima != 0) {
                         $status .='<span style="color:orange;"> MR DI TERIMA '.$total_mr_terima.'</span><br>';
                    }

                    if ($total_mr_revisi != 0) {
                        $status .='<span style="color:#DAAE2B;"> MR DI REVISI '.$total_mr_revisi.'</span><br>';
                    }
                    if ($total_mr_tolak != 0) {
                      $status .='<span style="color:#F1353D;"> MR DI TOLAK '.$total_mr_tolak.'</span><br>';
                    }
                  
                    $status .='<span style="color:Gray;">TOTAL MR '.$total_mr.'<br>';
                
                    $action .= anchor('#mr/mr_pusat/page_list_mr/'.$dt->id_m_project, '<i class="fa fa-eye"></i> Lihat / Buat MR</a>', 
                            [
                                'class'          => 'btn btn-info btn-xs margin-right-2',   
                                'rel'            => 'tooltip',
                                'data-placement' => 'top',
                                'title'          => 'Pilih',
                            ]);
                            


                $rows[] = [
                    hgenerator::columns_align($no,'center'),
                     $dt->nama_project,
                    $dt->kode_project,
                    $dt->client_project,
                    // date('d-m-Y', strtotime($dt->create_at)),
                    $status,
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

     public function detail($id){

                $start = $_GET["iDisplayStart"];
 
                $end = $_GET["iDisplayLength"];

                $cond = [];
                $cond['a.mr_id'] = $id;
                // $cond['d.status_approve_po'] = '1';
                $order_by = 'mr_equipment_id';
                $list = $this->mr_pusat_model->data_mr_detail($cond,$order_by,'ASC', $end,$start)->get();
                $list2 = $this->mr_pusat_model->data_mr_detail($cond)->get();

                $data = array();
                $no = $start+1;
                // var_dump($list->result());
                // exit();
                // $no = 1;
                foreach ($list->result() as $detail) {

                    if (empty($detail->no_po) ) {
                        $nama_so = $this->mr_pusat_model->data_so($detail->mr_equipment_id)->get();
                           if ($nama_so->num_rows() > 0) {
                                $purhase = $nama_so->row()->no_so ;
                           }else{
                                $purhase = '' ;
                           }
                           
                    }else{
                        $purhase = $detail->no_po ;
                    }

                   if ($detail->type_equipment == 1) {
                        $type = "Asset";
                        if ($detail->tgl_butuh == '1970-01-01' || $detail->tgl_butuh == NULL) {
                          $tglbutuh  = '';
                        }else{
                            $tglbutuh  = date('d-m-Y',strtotime($detail->tgl_butuh));
                        }
                       
                   }else if ($detail->type_equipment == 2) {
                        $type ="Material Supply";
                       if ($detail->tgl_butuh == '1970-01-01' || $detail->tgl_butuh == NULL) {
                          $tglbutuh  = '';
                        }else{
                            $tglbutuh  = date('d-m-Y',strtotime($detail->tgl_butuh));
                        }
                   }else if ($detail->type_equipment == 3) {
                        $type ="Persediaan";
                       if ($detail->tgl_butuh == '1970-01-01' || $detail->tgl_butuh == NULL) {
                          $tglbutuh  = '';
                        }else{
                            $tglbutuh  = date('d-m-Y',strtotime($detail->tgl_butuh));
                        }
                   }else if($detail->type_equipment == 4){
                        $type = "Jasa / Sewa" ;
                       
                         if ($detail->tgl_butuh == '1970-01-01' || $detail->tgl_butuh == NULL) {
                             $tglbutuh  = '';
                        }else if ($detail->date_lama_sewa == '1970-01-01' || $detail->tgl_butuh == NULL) {
                            $tglbutuh  = '';
                        }
                        else{
                                 $tglbutuh  = ''.date('d-m-Y',strtotime($detail->tgl_butuh)).' <br> Masa Sewa Sampai <br>'.date('d-m-Y',strtotime($detail->date_lama_sewa)).'';
                        }
                   }else if($detail->type_equipment == 5){
                        $type = "Jasa / Non Sewa" ;
                       if ($detail->tgl_butuh == '1970-01-01' || $detail->tgl_butuh == NULL) {
                          $tglbutuh  = '';
                        }else{
                            $tglbutuh  = date('d-m-Y',strtotime($detail->tgl_butuh));
                        }
                   }

                    if (!empty($detail->lampiran)) {
                            if($detail->lampiran == '[]'){
                            $img = NULL;
                            }else{
                                $image = json_decode($detail->lampiran); 
                                // $img = NULL;
                                // for ($i=0; $i < count($image); $i++) { 
                                      $img =  anchor($image->file,$image->filename, ['target' =>'_blank']) ;
                                // }
                              
                            }
                               
                        }else{
                            $img = '';
                        }

                    $row = array();
                    $row[] = $no++;
                    $row[] = $type;
                    $row[] = ''.$detail->description.'<br> Specification : <br>'.$detail->desc_detail.' ';
                    // $row[] = $detail->desc_detail;
                    $row[] = $detail->size;
                    $row[] = $detail->quantity;
                    $row[] = $detail->unit;
                    $row[] = $detail->part_number ? $detail->part_number : '' ;
                    $row[] = ''.$detail->currency.' '.number_format($detail->unit_cost, 2).'';
                    $row[] = ''.$detail->currency.' '.number_format($detail->total_cost, 2).'';
                    // $row[] = $detail->currency;
                    $row[] = $detail->lokasi_station ? $detail->lokasi_station :'';
                    $row[] = $tglbutuh;
                    $row[] = $detail->remarks ? $detail->remarks:'' ;
                    $row[] = $img ;
                    $row[] = $purhase ;

                    $data[] = $row;
                }

                $output = array(
                                 "draw" => $_GET['sEcho'],
                                "recordsTotal" => count($list2->result()),
                                "recordsFiltered" => count($list2->result()),
                                "data" => $data,
                        );
                //output to json format
                echo json_encode($output);
        }

         public function detail_info($id){
            // var_dump($_POST['draw']);
            // exit();
                $list = $this->mr_pusat_model->data_info_approve($id)->get();

                $data = array();

                $no = 1;
                foreach ($list->result() as $detail) {

                     if ($detail->status_approve == 0) {
                        $status_app = 'DI AJUKAN';
                    }else if($detail->status_approve == 1){
                        $status_app = 'DI TERIMA';
                    }else if($detail->status_approve == 2){
                        $status_app = 'DI REVISI';
                    }else if($detail->status_approve == 3){
                        $status_app = 'DI TOLAK';
                    }


                    $row = array();
                    $row[] =  $no++;
                    $row[] = $detail->tgl_approve;
                    $row[] = $detail->catatan_approve;
                    $row[] = $detail->username_user;
                    $row[] = $detail->nama_role;
                    $row[] = $status_app;

                    $data[] = $row;
                }

                $output = array(
                                "draw" => $_POST['draw'],
                                "recordsTotal" => count($list->result()),
                                "recordsFiltered" => count($list->result()),
                                "data" => $data,
                        );
                //output to json format
                echo json_encode($output);
        }

        public function load_mr($id_project){
            if(hprotection::must_ajax($this->_module)) {

                # Init
                $limit  = $this->input->post('length');
                $offset = $this->input->post('start');
                $draw   = $this->input->post('draw');
                $extraColumn = $this->input->post('columns');
                $extraOrder  = $this->input->post('order');

                # Ordering
                $orderBy   = 'mr_id';
                $direction = 'DESC';

                if($extraColumn[$extraOrder[0]['column']]['orderable'] == 'true') {
                    $orderBy = isset($extraColumn[$extraOrder[0]['column']]['name']) ? $extraColumn[$extraOrder[0]['column']]['name'] : NULL;
                    $direction   = $extraOrder[0]['dir'];
                }

                # Condition
                $cond = [];
                $cond['a.id_master_project'] = $id_project;
                if (!empty($this->input->post('kode_mr'))) {
                    $cond["a.kode_mr LIKE '%{$this->input->post('kode_mr')}%'"] = NULL;
                }

                if (!empty($this->input->post('nama_mr'))) {
                    $cond["a.nama_permintaan LIKE '%{$this->input->post('nama_mr')}%'"] = NULL;
                }

                if (!empty($this->input->post('status_search'))) {
                    if ($this->input->post('status_search') == 0) {
                        $cond["a.status_approve"] = 0;
                    }else{
                          $cond["a.status_approve = '{$this->input->post('status_search')}'"] = NULL;
                    }

                  
                }



                $dataCount          = $this->mr_pusat_model->data_mr($cond)->count_all_results();
                $dataCountFiltered  = $this->mr_pusat_model->data_mr($cond)->count_all_results();
                $dataResult         = $this->mr_pusat_model->data_mr($cond, $orderBy, $direction, $limit, $offset)->get();

                $rows = [];
                $no   = $offset;

                foreach ($dataResult->result() as $dt) {
                    $no++;
                    $action = NULL;
                    // $status_app = NULL;

                    $app = $this->db->select(" * from m_approve_mr where mr_id = '".$dt->mr_id."' and approve_new = '0' ")->get()->num_rows();
                    

                    if ($dt->status_approve == 0) {
                        $status_app =  anchor(NULL,' <i class="fa  fa-clock-o"></i> DI AJUKAN ',
                                [
                                    'onclick' => 'detail_info('.$dt->mr_id.')',
                                    'rel' => 'tooltip',
                                    'data-placement' => 'top',
                                    'title' => 'Info Proses',
                                    'class' => 'btn btn-primary btn-xs margin-right-2',
                            ]);

                        // if($this->laccess->otoritas('delete')) {
                        // $action .= anchor(NULL, ' <i class="fa fa-trash-o"> </i>  </a>', [
                        //     'class'          => 'btn btn-danger btn-xs',
                        //     'rel'            => 'tooltip',
                        //     'data-placement' => "top",
                        //     'data-title'     => 'Hapus',
                        //     'data-url'       => base_url() . $this->_module . '/delete/'. $dt->mr_id,
                        //     'onclick'        => '$(this).myForm().submit(\'delete\')'
                        // ]);
                    // }



                    }else if($dt->status_approve == 1){
                        $status_app =  anchor(NULL,' <i class="fa fa-check"></i> DI TERIMA ',
                                [
                                    'onclick' => 'detail_info('.$dt->mr_id.')',
                                    'rel' => 'tooltip',
                                    'data-placement' => 'top',
                                    'title' => 'Info Approve',
                                    'class'          => 'btn btn-info btn-xs margin-right-2',
                            ]);
                          // $action .= anchor($this->_module.'/print_mr/'.$id_project.'/'.$dt->mr_id, ' <i class="fa fa-print"> </i> </a>',
                          //       [
                          //           'class'          => 'btn green btn-xs margin-right-2',
                          //           'rel'            => 'tooltip',
                          //           'data-placement' => 'top',
                          //           'title'          => 'print',
                          //           'target'         => '_blank'
                          //       ]);
                         // $action .= anchor('#mr/mr/form_mr/'.$id_project.'/2/'.$dt->mr_id, ' <i class="fa fa-eye"> </i> </a>',
                         //        [
                         //            'class'          => 'btn btn-warning btn-xs margin-right-2',
                         //            'rel'            => 'tooltip',
                         //            'data-placement' => 'top',
                         //            'title'          => 'Lihat MR',
                         //        ]);
                    }else if($dt->status_approve == 2){
                        $status_app =  anchor(NULL,' <i class="fa fa-retweet"></i> DI REVISI ',
                                [
                                    'onclick' => 'detail_info('.$dt->mr_id.')',
                                    'rel' => 'tooltip',
                                    'data-placement' => 'top',
                                    'title' => 'Info Revisi',
                                    'class'          => 'btn btn-warning btn-xs margin-right-2',
                            ]);
                    }else if($dt->status_approve == 3){
                         $status_app =  anchor(NULL,' <i class="fa fa-times"></i> DI TOLAK ',
                                [
                                    'onclick' => 'detail_info('.$dt->mr_id.')',
                                    'rel' => 'tooltip',
                                    'data-placement' => 'top',
                                    'title' => 'Info Di Tolak',
                                    'class'          => 'btn btn-danger btn-xs margin-right-2',
                            ]);
                    };

                    if($dt->status_save == 2 and $dt->status_approve == 0){
                         $status_app = '<label style="color:red">MR DI DRAFT</label>';
                    }else if($dt->status_save == 2 and $dt->status_approve == 2){
                         $status_app =  anchor(NULL,' <i class="fa fa-retweet"></i> DI REVISI ',
                                [
                                    'onclick' => 'detail_info('.$dt->mr_id.')',
                                    'rel' => 'tooltip',
                                    'data-placement' => 'top',
                                    'title' => 'Info Revisi',
                                    'class'          => 'btn btn-warning btn-xs margin-right-2',
                            ]);
                    };

                    if($dt->status_approve == 0 || $dt->status_approve == 2 ){
                        if ($app == 0 ) {
                       
                   
                           $action .= anchor('#mr/mr_pusat/form_mr/'.$id_project.'/1/'.$dt->mr_id, ' <i class="fa fa-pencil"> </i> </a>',
                                [
                                    'class'          => 'btn btn-info btn-xs margin-right-2',
                                    'rel'            => 'tooltip',
                                    'data-placement' => 'top',
                                    'title'          => 'Ubah',
                                ]);
                         }
                    }

                     $infoapp = "<button class='btn blue  btn-xs' title='Info List Approved' onclick='list_approved(".$id_project.",".$dt->mr_id.")'><i class='fa fa-legal'></i></button>";


                    $action .=  anchor(NULL,' <i class="fa fa-file"> </i> ',
                                [
                                    'onclick' => 'detail_mr('.$dt->mr_id.')',
                                    'rel' => 'tooltip',
                                    'data-placement' => 'top',
                                    'title' => 'Detail',
                                    'class'          => 'btn btn-info btn-xs margin-right-2',
                            ]);

                    $action .= anchor($this->_module.'/print_mr/'.$id_project.'/'.$dt->mr_id, ' <i class="fa fa-print"> </i> </a>',
                                [
                                    'class'          => 'btn green btn-xs margin-right-2',
                                    'rel'            => 'tooltip',
                                    'data-placement' => 'top',
                                    'title'          => 'preview',
                                    'target'         => '_blank'
                                ]);
                     $datalampiran = $this->mr_pusat_model->data_file($dt->mr_id)->get();

                     $img = NULL;
                     foreach ($datalampiran->result() as $key => $valuee) {
                          if (!empty($valuee->lampiran_new)) {
                            if($valuee->lampiran_new == '[]'){
                            $img = NULL;
                            }else{
                                $image = json_decode($valuee->lampiran_new); 
                                // $img = NULL;
                                // for ($i=0; $i < count($image); $i++) { 
                                      $img .= anchor($image->file,$image->filename, ['target' =>'_blank']).'<br>' ;
                                // }
                              
                            }
                               
                        }else{
                            $img .= '';
                        }
                     }
                    
                   
                    $rows[] = [
                        hgenerator::columns_align($no,'center'),
                        $dt->kode_mr,
                        $dt->nama_permintaan,
                        date('d-m-Y',strtotime($dt->create_at)),
                        // $img,
                        $dt->pegawai_nama,
                        ''.$status_app.' '.$infoapp.'',
                        $img,
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


        public function load_list_approve($id_project){
            if(hprotection::must_ajax($this->_module)) {

                # Init
                $limit  = $this->input->post('length');
                $offset = $this->input->post('start');
                $draw   = $this->input->post('draw');
                $extraColumn = $this->input->post('columns');
                $extraOrder  = $this->input->post('order');

                # Ordering
                $orderBy   = 'mr_id';
                $direction = NULL;

                if($extraColumn[$extraOrder[0]['column']]['orderable'] == 'true') {
                    $orderBy = isset($extraColumn[$extraOrder[0]['column']]['name']) ? $extraColumn[$extraOrder[0]['column']]['name'] : NULL;
                    $direction   = $extraOrder[0]['dir'];
                }

                //$appro = $this->db->select(" * from m_approve_mr where mr_id = '".."' and id_user_approve = '".."' ");

                $id_user = $this->session->userdata('id_user');
                $roleId   = $this->session->userdata('id_role');

                $cond['project_id']   = $id_project;
                $data_approve   = $this->workflow_detail_model->data($cond,'flow_order')->get();

                $condd['project_id']   = $id_project;
                $condd['role_id']   = $roleId;
                $condd['workflow_id']   = 'PRO-MR-01';
                $condd['skip_order']   = 0;
                $data_approve_flow   = $this->workflow_detail_model->data($condd,'flow_order')->get();
                // var_dump($data_approve_flow->row());
                // exit();
                $status = "";

                if ($data_approve_flow->num_rows() == 0 ) {
                    $floworder = 0;
                }else{

                    $floworder = $data_approve_flow->row()->flow_order ;
                }
              
                foreach ($data_approve->result() as $value) {

                    if($value->role_id == $roleId){
                        $status .= 1;
                    }
                }

                if ($status == 1) {

                        $cond = [];
                        $cond['a.id_master_project'] = $id_project;
                        $cond['a.status_save'] = 1;
                        // $status = "a.status_approve !='1' AND a.status_approve != '3'  ";
                        $cond['b.role_id'] = $roleId ;
                        $cond['b.workflow_id'] = 'PRO-MR-01';
                        $cond["a.status_approve !='1' AND a.status_approve != '3'  "] = NULL;
                        if (!empty($this->input->post('kode_appr'))) {
                            $cond["a.kode_mr LIKE '%{$this->input->post('kode_appr')}%'"] = NULL;
                        }

                        if (!empty($this->input->post('nama_appr'))) {
                            $cond["a.nama_permintaan LIKE '%{$this->input->post('nama_appr')}%'"] = NULL;
                        }

                        $dataCount          = $this->mr_pusat_model->data_mr_approve($cond)->count_all_results();
                        $dataCountFiltered  = $this->mr_pusat_model->data_mr_approve($cond)->count_all_results();
                        $dataResult         = $this->mr_pusat_model->data_mr_approve($cond, $orderBy, $direction, $limit, $offset)->get();


                }else{

                    $cond = [];
                    $cond['a.id_master_project'] = $id_project;
                    $cond['b.workflow_id'] = 'PRO-MR-01';
                    $cond['b.role_id'] = $roleId ;
                    $cond["a.status_approve !='1' AND a.status_approve != '3' and a.status_save != '2'  "] = NULL;
                    if (!empty($this->input->post('kode_appr'))) {
                        $cond["a.kode_mr LIKE '%{$this->input->post('kode_appr')}%'"] = NULL;
                    }

                    if (!empty($this->input->post('nama_appr'))) {
                        $cond["a.nama_permintaan LIKE '%{$this->input->post('nama_appr')}%'"] = NULL;
                    }
                    $dataCount          = $this->mr_pusat_model->data_mr_approve($cond)->count_all_results();
                    $dataCountFiltered  = $this->mr_pusat_model->data_mr_approve($cond)->count_all_results();
                    $dataResult         = $this->mr_pusat_model->data_mr_approve($cond, $orderBy, $direction, $limit, $offset)->get();
                }

                $rows = [];
                $no   = $offset;

                foreach ($dataResult->result() as $dt) {
                    $no++;
                    $action = NULL;
                    $status_app = NULL;

                    if ($dt->status_approve == 0) {
                        $status_app .=  anchor(NULL,' <i class="fa  fa-clock-o"></i> DI AJUKAN ',
                                [
                                    'onclick' => 'detail_info('.$dt->mr_id.')',
                                    'rel' => 'tooltip',
                                    'data-placement' => 'top',
                                    'title' => 'Info Proses',
                                    'class' => 'btn btn-primary btn-xs margin-right-2',
                            ]);
                    }else if($dt->status_approve == 1){
                        $status_app .=  anchor(NULL,' <i class="fa fa-clock-o"></i> DI TERIMA',
                                [
                                    'onclick' => 'detail_info('.$dt->mr_id.')',
                                    'rel' => 'tooltip',
                                    'data-placement' => 'top',
                                    'title' => 'Info Di Terima',
                                    'class' => 'btn btn-info btn-xs margin-right-2',
                            ]);
                       
                    }else if($dt->status_approve == 2){
                          $status_app .=  anchor(NULL,' <i class="fa fa-retweet"></i> DI REVISI',
                                [
                                    'onclick' => 'detail_info('.$dt->mr_id.')',
                                    'rel' => 'tooltip',
                                    'data-placement' => 'top',
                                    'title' => 'Info Di Revisi',
                                    'class' => 'btn btn-warning btn-xs margin-right-2',
                            ]);
                        
                    }else if($dt->status_approve == 3){
                         $status_app .=  anchor(NULL,' <i class="fa fa-close"></i> DI TOLAK',
                                [
                                    'onclick' => 'detail_info('.$dt->mr_id.')',
                                    'rel' => 'tooltip',
                                    'data-placement' => 'top',
                                    'title' => 'Info Di Tolak',
                                    'class' => 'btn btn-danger btn-xs margin-right-2',
                            ]);
                       
                    }

                     $status_app .= "<button class='btn blue  btn-xs' title='Info List Approved' onclick='list_approved(".$id_project.",".$dt->mr_id.")'><i class='fa fa-legal'></i></button>";

                   
                    $check = $this->db->select(" * from m_approve_mr where id_user_approve = '".$id_user."' and mr_id = '".$dt->mr_id."' and status_approve >= '1' and approve_new = '0' and limit_app = '0' ")->get();

                    if($check->num_rows() > 0) {
                         $action .= anchor( NULL , '<i class="fa fa-check"></i> </a>',
                                    [
                                        'class'          => 'btn btn-info btn-xs margin-right-2',
                                        'rel'            => 'tooltip',
                                        'data-placement' => 'top',
                                        'title'          => 'Terimakasih Sudah Melakukan Approval, Menunggu Approval Selanjutnya',
                                    ]);
                         

                    }else{

                        $checkk = $this->db->select("  MAX(step_approve) as step_approve from m_approve_mr where mr_id = '".$dt->mr_id."' and status_approve >= '1' and approve_new = '0'  and limit_app = '0' ")->get();

                        if ($checkk->num_rows() == 0) {
                            $order = 1;
                        }else{
                            $conddd['project_id']   = $id_project;
                            $conddd['workflow_id']   = 'PRO-MR-01';
                            $conddd['skip_order']   = 0;
                            $conddd['or_order']   = 0;
                            if ($checkk->num_rows() == 0 ) {
                                $conddd['flow_order']   =  1;
                            }else{
                                 $conddd['flow_order']   =  $floworder - 1;
                            }
                           
                            $dt_sebelum   = $this->workflow_detail_model->data($conddd,'flow_order')->get()->row();


                            if (empty( $dt_sebelum )) {
                                $order = $checkk->row()->step_approve + 1;
                            }else{

                            $total = $this->total_model->total_hitung('mr_equipment','total_cost','mr_id',$dt->mr_id)->get()->row()->total;
                           

                                $inrange = hgenerator::in_range($total,$dt_sebelum->min,$dt_sebelum->max);

                                if ($inrange == TRUE) {
                                    $order = $checkk->row()->step_approve + 2 ; 
                                }else{
                                     $order = $checkk->row()->step_approve + 1 ; 
                                }
                            }            
                               
                            
                        }

                       
                         if ($floworder == $order) {
                             $checkrev = $this->db->select(" * from m_approve_mr where id_user_approve = '".$id_user."' and mr_id = '".$dt->mr_id."' and status_approve = '2' and approve_new = '1'  and limit_app = '0' ")->get();

                             if ($checkrev->num_rows() == 0 ) {
                                  $action .= anchor('#mr/mr_pusat/form_mr_approve/'.$id_project.'/'.$dt->mr_id, '<i class="fa fa-pencil"></i> FORM APPROVE</a>',
                                    [
                                        'class'          => 'btn btn-warning btn-xs margin-right-2',
                                        'rel'            => 'tooltip',
                                        'data-placement' => 'top',
                                        'title'          => 'Approve',
                                    ]);
                             }else{
                                  $action .= 'Menunggu MR Untuk Direvisi terlebih Dahulu  ';
                             }

                               

                         }else if($floworder < $order){

                            $action .= " Approval sudah Di Lakukan <span style='color:red;'>lihat Urutan Approved OR</span><br>";
                            $action .= "<button class='btn blue' onclick='list_approved(".$id_project.",".$dt->mr_id.")'>Urutan Approved</button>";
                         }else{
                            $action .= "Maaf Belum bisa melakukan Approval , Menunggu Approval KE ".$order.",  karena anda di Approval KE ".$floworder." <br> ";
                            $action .= "<button class='btn blue' onclick='list_approved(".$id_project.",".$dt->mr_id.")'>List Approved</button>";

                         }

                     
                    }

                     $action .= anchor($this->_module.'/print_mr/'.$id_project.'/'.$dt->mr_id, ' <i class="fa fa-print"> </i> </a>',
                                [
                                    'class'          => 'btn green btn-xs margin-right-2',
                                    'rel'            => 'tooltip',
                                    'data-placement' => 'top',
                                    'title'          => 'preview',
                                    'target'         => '_blank'
                                ]);

                    $rows[] = [
                        hgenerator::columns_align($no,'center'),
                        $dt->kode_mr,
                        $dt->nama_permintaan,
                        $dt->tanggal_buat_mr,

                        $status_app,
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



        public function page_list_mr($id_m_project){
            $nama = $this->db->get_where('master_project', array('id_m_project' => $id_m_project))->row()->nama_project;
            $data= [
                     'page_title' =>'List MR ',
                     '_modul'     => $this->_module,
                     'id_m_project' => $id_m_project,
                     'nama_project' => $nama
                   ];


             $this->load->view($this->_module.'/page_list_mr',$data);
        }

        public function form_mr($id_projcet ,$param, $id = NULL){
            if ($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {

                $yearsnow = date("Y");
                $yearsmr = $this->db->select(" max(create_at) as date from material_requisition ")->get()->row()->date;
                $ye = date("Y", strtotime($yearsmr));

                $data['roleId']   = $this->session->userdata('id_role');
                $data['currency'] = $this->currency_model->options_simbol([], ['' => 'Pilih Currency']);

               if ($ye != $yearsnow  ) {
                    $this->db->empty_table('kode_unik_ho');
               }
               
                $data['id']         = $id;

                $data_project = $this->mr_pusat_model->get_data_project($id_projcet)->get()->row();

                // var_dump($data_project);
                // exit();

                $data['param'] = $param;

                if ($id) {
                  $query = $this->mr_pusat_model->data_edit($id, 'mr_equipment_id')->get();
                  $data['queryrevisi'] = $this->mr_pusat_model->data_revisi($id)->get();
                  $query_row = $this->mr_pusat_model->table(array('mr_id' => $id, ))->get()->row();
                  $data['lampiran_file_mr'] = $this->mr_pusat_model->data_file($id)->get();
                  // var_dump($query_row);
                  // exit();

                  if ($param == 2) {
                     $data['page_title'] = 'LIHAT MR' ;
                  }else{
                    $data['page_title'] = 'UBAH MR' ;
                  }
                    

                    $data['_modul']      = $this->_module;
                    $data['form_action'] = $this->_module .'/save/'. $id;
                    $data['data_equipment']       = $query;
                    $data['no_proyek'] = $query_row->no_proyek;
                    $data['nama_proyek'] = $query_row->nama_proyek;
                    $data['kode_mr'] = $query_row->kode_mr;
                    $data['note'] = $query_row->note;
                    $data['nama_permintan'] = $query_row->nama_permintaan;
                    $data['tanggal_buat_mr'] = $query_row->tanggal_buat_mr;
                    $data['shipping'] =  $query_row->shipping_instruction;
                    $data['purchase'] = $query_row->purchase_instruction;
                    // $data['gran_total'] = $query_row->grand_total;
                    $data['status_save'] = $query_row->status_save;
                    $data['status_approve'] = $query_row->status_approve;
                    $data['id_project'] = $id_projcet ;
                    $data['singkatan']= $data_project->singkatan;
                    $data['idkota']= $data_project->id_kota;
                    $data['lampiran_file']= json_decode($query_row->lampiran_file);

                    $data['kode_mr_dropdown'] = ''.$data_project->kode_project.'-MR-';
                    // print_debug($data['lampiran_file']);


                }else{
                      // $mr_form_code = $this->mr_model->getkodeunik();
                    $yr = date('y');
                    $table = "material_requisition";
                    $tableho = "kode_unik_ho";
                    $kode_unik = $this->kode_unik_model->getkodeunik($table, $id_projcet,$data_project->site_project);
                    $kode_unik_ho = $this->kode_unik_model->getkodeunikho($tableho, $yr);

                    $data['page_title']  = 'Form Permintaan (MR-001)';
                    $data['_modul']      = $this->_module;
                    $data['form_action'] = $this->_module .'/save/'. $id;
                    $data['no_proyek'] = $data_project->kode_project;
                    $data['nama_proyek'] = $data_project->nama_project;
                    $data['singkatan']= $data_project->singkatan;
                    $data['kode_unik']= $kode_unik;
                    $data['kode_unik_ho']= $kode_unik_ho;
                    $data['idkota']= $data_project->id_kota;
                    $data['status_approve'] = NULL;
                    $data['site_project']=$data_project->site_project;
                  
                    if ($data_project->status_buat_projek == 1 || $data_project->status_buat_projek == 2) {
                        $data['kode_mr'] = ''.$data_project->kode_project.'-MR-HO-'.$kode_unik_ho.'-'.$yr.'';
                        $data['type_transaksi'] = 1;
                    }else{
                         if ($data_project->site_project == 1) {
                            $data['kode_mr'] = ''.$data_project->kode_project.'-MR-HO-'.$kode_unik.'-'.$yr.'';
                        }else if ($data_project->site_project == 2) {
                            $data['kode_mr'] = ''.$data_project->kode_project.'-MR-'.$data_project->singkatan.'-'.$kode_unik.'-'.$yr.'';
                        }else{
                            $data['kode_mr'] = ''.$data_project->kode_project.'-MR-'.$data_project->singkatan.'-'.$kode_unik.'-'.$yr.'';
                        }
                        $data['type_transaksi'] = 2;
                    }
                   

                    $data['kode_mr_dropdown'] = ''.$data_project->kode_project.'-MR-';
                    $data['id_project'] = $id_projcet ;

                }

                 $this->load->view($this->_module.'/form_mr',$data);
            } else {
                echo Modules::run('template/error_message/error_forbidden');
            }

        }


         public function form_mr_approve($id_projcet , $id = NULL){
            // if ($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {

                $data['id']         = $id;
                $id_user = $this->session->userdata('id_user');
                $roleId   = $this->session->userdata('id_role');

                $cond['project_id']   = $id_projcet;
                $data_approve   = $this->workflow_detail_model->data($cond,'flow_order')->get();

                 $data['lampiran_file_mr'] = $this->mr_pusat_model->data_file($id)->get();

                $condd['project_id']   = $id_projcet;
                $condd['role_id']   = $roleId;
                $condd['workflow_id']   = 'PRO-MR-01';
                $condd['skip_order']   = 0;
                $data_approve_flow   = $this->workflow_detail_model->data($condd,'flow_order')->get();
                // var_dump($data_approve_flow->row());
                // exit();
                $status = "";
                $action = NULL;
                $not_approve = NULL;

                if ($data_approve_flow->num_rows() == 0 ) {
                    $floworder = 0;
                }else{

                    // $cond['project_id']   = $id_project;
                    // $cond['workflow_id']   = 'PRO-MR-01';
                    // $cond['skip_order']   = '1';
                    // $data_flow  = $this->workflow_detail_model->data($cond,'flow_order')->get();

                    $floworder = $data_approve_flow->row()->flow_order ;
                }
              
                foreach ($data_approve->result() as $value) {

                    if($value->role_id == $roleId){
                        $status .= 1;
                    }
                }

                $check = $this->db->select(" * from m_approve_mr where id_user_approve = '".$id_user."' and mr_id = '".$id."' and status_approve >= '1' and approve_new = '0'  and limit_app = '0' ")->get();


                    if($check->num_rows() > 0) {
                         $action .= 'Terimakasih Sudah Melakukan Approval, Menunggu Approval Selanjutnya';
                         $not_approve .= 1;

                    }else{

                        $checkk = $this->db->select("  MAX(step_approve) as step_approve from m_approve_mr where mr_id = '".$id."' and status_approve >= '1' and approve_new = '0'  and limit_app = '0' ")->get();

                        if ($checkk->num_rows() == 0) {
                            $conddd['project_id']   = $id_projcet;
                            $conddd['workflow_id']   = 'PRO-MR-01';
                            $conddd['skip_order']   = 0;
                            $conddd['or_order']   = 0;
                            $conddd['flow_order']   =  $floworder ;
                            $dt_sebelum   = $this->workflow_detail_model->data($conddd,'flow_order')->get()->row();

                            $total = $this->total_model->total_hitung('mr_equipment','total_cost','mr_id',$id)->get()->row()->total;
                            // var_dump($dt_sebelum);
                            // exit();

                             $inrange = hgenerator::in_range($total,$dt_sebelum->min,$dt_sebelum->max);

                                if ($inrange == TRUE) {
                                    $order = 2 ; 
                                }else{
                                     $order = 1 ; 
                                }
                            // $order = 1;
                        }else{
                            $conddd['project_id']   = $id_projcet;
                            $conddd['workflow_id']   = 'PRO-MR-01';
                            $conddd['skip_order']   = 0;
                            $conddd['or_order']   = 0;
                            if ($checkk->num_rows() == 0 ) {
                                $conddd['flow_order']   =  1;
                            }else{
                                 $conddd['flow_order']   =  $floworder - 1;
                            }
                           
                            $dt_sebelum   = $this->workflow_detail_model->data($conddd,'flow_order')->get()->row();


                            if (empty( $dt_sebelum )) {
                                $order = $checkk->row()->step_approve + 1;
                            }else{

                            $total = $this->total_model->total_hitung('mr_equipment','total_cost','mr_id',$id)->get()->row()->total;
                           

                                $inrange = hgenerator::in_range($total,$dt_sebelum->min,$dt_sebelum->max);

                                if ($inrange == TRUE) {
                                    $order = $checkk->row()->step_approve + 2 ; 
                                }else{
                                     $order = $checkk->row()->step_approve + 1 ; 
                                }
                            }            
                               
                            
                        }

                       
                         if ($floworder == $order) {
                             $checkrev = $this->db->select(" * from m_approve_mr where id_user_approve = '".$id_user."' and mr_id = '".$id."' and status_approve = '2' and approve_new = '1'  and limit_app = '0' ")->get();

                             if ($checkrev->num_rows() == 0 ) {
                                  // $action .= anchor('#mr/mr/form_mr_approve/'.$id_projcet.'/'.$dt->mr_id, '<i class="fa fa-pencil"></i> FORM APPROVE</a>',
                                  //   [
                                  //       'class'          => 'btn btn-info btn-xs margin-right-2',
                                  //       'rel'            => 'tooltip',
                                  //       'data-placement' => 'top',
                                  //       'title'          => 'Approve',
                                  //   ]);
                                $not_approve .= 2;
                             }else{
                                  $action .= 'Menunggu MR Untuk Direvisi terlebih Dahulu  ';
                                $not_approve .= 1;
                             }

                               

                         }else if($floworder < $order){

                            $action .= " MAAF ANDA BELUM BISA MELAKUKAN APPROVAL / TIDAK DI SET SEBAGAI APPROVAL ";
                         
                         }else{
                            $action .= "Maaf Belum bisa melakukan Approval , Menunggu Approval KE ".$order.",  karena anda di Approval KE ".$floworder." <br> ";
                           

                         }

                     
                    }

                            $data['msg'] = $action;
                            $data['nothing_approve'] = $not_approve;

                            $conddd['project_id']   = $id_projcet;
                            $conddd['workflow_id']   = 'PRO-MR-01';
                            $conddd['skip_order']   = 0;
                            $conddd['or_order']   = 0;
                            $conddd['flow_order']   =  $floworder ;
                            $dt_sebelum   = $this->workflow_detail_model->data($conddd,'flow_order')->get()->row();

                            //$total = $this->total_model->total_hitung('mr_equipment','total_cost','mr_id',$id)->get()->row()->total;
                            // var_dump($dt_sebelum);
                            // exit();

                             // $inrange = hgenerator::in_range($total,$dt_sebelum->min,$dt_sebelum->max);

                             //    if ($inrange == TRUE) {
                             //        $data['limit_app'] = 1 ; 
                             //    }else{
                                     $data['limit_app'] = 0 ; 
                             //    }


                if ($id) {
                  $query = $this->mr_pusat_model->data_edit($id,'mr_equipment_id')->get();

                  $query_row = $this->mr_pusat_model->data_edit($id)->get()->row();


                    $data['page_title'] = 'Form Persetujuan (MR-001)' ;

                    $data['_modul']      = $this->_module;
                    $data['form_action'] = $this->_module .'/save_approve/'.$id.'/'.$id_projcet.' ';
                    $data['data_equipment']       = $query;
                    $data['no_proyek'] = $query_row->no_proyek;
                    $data['nama_proyek'] = $query_row->nama_proyek;
                    $data['kode_mr'] = $query_row->kode_mr;
                    $data['note'] = $query_row->note;
                    $data['nama_permintan'] = $query_row->nama_permintaan;
                    $data['tanggal_buat_mr'] = $query_row->tanggal_buat_mr;
                    $data['shipping'] =  $query_row->shipping_instruction;
                    $data['purchase'] = $query_row->purchase_instruction;
                   // $data['gran_total'] = $query_row->grand_total;
                    $data['id_project'] = $id_projcet ;
                    $data['lampiran_file']= $query_row->lampiran_file;
                    $data['account_code']  = $this->account_code_model->options(array(), array('' => '--Pilih Account Code--'));


                }else{
                      // $mr_form_code = $this->mr_model->getkodeunik();
                    $data_project = $this->mr_pusat_model->get_data_project($id_projcet)->get()->row();

                    $data['page_title']  = 'Form Persetujuan (MR-001)';
                    $data['_modul']      = $this->_module;
                    $data['form_action'] = $this->_module .'/save/'. $id;
                    $data['no_proyek'] = $data_project->kode_project;
                     $data['note'] = $query_row->note;
                    $data['nama_proyek'] = $data_project->nama_project;
                    $data['kode_mr'] = ''.$data_project->kode_project.'-MR-'.$data_project->kota_nama.'-'.$data_project->id_kota.'';
                    $data['id_project'] = $id_projcet ;
                    $data['account_code']  = $this->account_code_model->options(array(), array('' => '--Pilih Account Code--'));


                }

                $data['data_app'] = $this->db->query("select * from m_approve_mr a
                                                LEFT JOIN m_user b on b.id_user = a.id_user_approve
                                                left join hr_pegawai c on c.pegawai_id = b.id_pegawai
                                                left join hr_ref_jabatan d on d.jabatan_id = c.jabatan_id
                                                left join m_role e on e.id_role = b.id_role
                                                where a.mr_id = '".$id."' and a.status_approve = '1' ORDER BY a.id_approve_mr ")->result();
                $create_by =  $this->db->query("select create_by from material_requisition where mr_id = '".$id."' ")->row()->create_by;
                $data['name_request'] =  $this->db->query("select * from m_user a
                                            left join m_role b on b.id_role = a.id_role
                                            left join hr_pegawai c on c.pegawai_id  = a.id_pegawai
                                            where a.id_user = '".$create_by."' ")->row();


                 $this->load->view($this->_module.'/form_approve',$data);
            // } else {
            //     echo Modules::run('template/error_message/error_forbidden');
            // }

        }


        public function save_approve($id, $id_project){
         if ($this->laccess->otoritas('approve')) {
                if (hprotection::must_ajax($this->_module . '/404')) {

                     $roleId   = $this->session->userdata('id_role');

                    $exist_kode = NULL;
                    $kode       = $id;
                    $roleidd       = $roleId;
                    $status_approvee  = $this->input->post('status_approve');
                    $apnew  = 0;
                                    

                   
                
                    $check_kode = $this->mr_pusat_model->is_exist_approve($kode, $roleidd, $status_approvee, $apnew);

                    // var_dump($check_kode);
                    // exit();
                    if($check_kode):
                                $exist_kode = 1;
                    endif;
               
                   

            if ($exist_kode == 1) {
                    $message = ['type' => 'info', 'message' => 'Terjadi Kesalahan <br> MR INI SUDAH ANDA APPROVE', 'return' => '__afterSubmit_approve()'];
                    echo json_encode($message);
                    exit();
                     // $message = ['type' => 'info', 'message' => 'Terjadi Kesalahan <br> MR INI SUDAH ANDA APPROVE', 'return' => '__afterSubmit()'];
                    
                }else{


                    $cond['project_id']   = $id_project;
                    $cond['workflow_id'] = 'PRO-MR-01';
                    $cond['or_order'] = '0';
                    $cond['skip_order'] = '0';

                    $condd['project_id']   = $id_project;
                    $condd['workflow_id'] = 'PRO-MR-01';
                    $condd['or_order'] = '0';
                    $condd['role_id'] =  $roleId;
                    $floworderr  = $this->workflow_detail_model->data($condd,'flow_order')->get()->row()->flow_order;

                    // var_dump($floworderr);
                    // exit();

                    $data_approve   = $this->workflow_detail_model->data($cond,'flow_order')->get()->num_rows();

                            $conddd['project_id']   = $id_project;
                            $conddd['workflow_id']   = 'PRO-MR-01';
                            $conddd['skip_order']   = 0;
                            $conddd['or_order']   = 0;

                            if ($floworderr == 1) {
                                $conddd['flow_order']   =  1;
                            }else{
                                $conddd['flow_order']   =  $floworderr - 1;
                            }
                            

                            $dt_sebelum   = $this->workflow_detail_model->data($conddd,'flow_order')->get()->row();

                            $total = $this->total_model->total_hitung('mr_equipment','total_cost','mr_id',$id)->get()->row()->total;
                            // var_dump($dt_sebelum);
                            // exit();

                             $inrange = hgenerator::in_range($total,$dt_sebelum->min,$dt_sebelum->max);

                                if ($inrange == TRUE) {
                                    $order =  $data_approve - 1 ; 
                                }else{
                                     $order =  $data_approve ; 
                                }



                  

                    $data_step = $this->db->select(" * from m_approve_mr where mr_id = '".$id."' and approve_new = '0' ")->get();

                    $step = $data_step->num_rows() + 1;

                    // var_dump($step, $order);
                    // exit();

                    // if ($step >= $data_approve) {
                    if ($step >= $order) {
                       $status = $this->input->post('status_approve') ;
                    }else{

                        if($this->input->post('status_approve') == 2){
                             $status = 2 ;
                        }else if($this->input->post('status_approve') == 3){
                             $status = 3 ;
                        }else if($this->input->post('status_approve') == 1){

                            $status = 0 ;
                        }

                    }

                    if ($step == 0) {
                         $tahap_step = 1;

                    }else{
                            $dt_step = $this->db->select(" MAX(step_approve) as step_approve from m_approve_mr where mr_id = '".$id."' and approve_new = '0' ")->get()->row()->step_approve;

                            $tahap_step = $dt_step + 1;
                    }

                    $id_user = $this->session->userdata('id_user');
                    $data_app = [
                                    'tgl_approve' => date("Y-m-d H:i:s"),
                                    'step_approve'     => $tahap_step,
                                    'id_user_approve' => $id_user,
                                    'catatan_approve'     => $this->input->post('catatan'),
                                    'mr_id' => $id,
                                    'role_id' => $roleId,
                                    'status_approve' => $this->input->post('status_approve'),
                                    'flow_order' => $floworderr,
                                    'limit_app' => $this->input->post('limit_app') ? $this->input->post('limit_app') :0,


                                ];
                    if ($status == 2 || $status == 3 ) {

                         $data_app = [
                                    'tgl_approve' => date("Y-m-d H:i:s"),
                                    'step_approve'     => $tahap_step,
                                    'id_user_approve' => $id_user,
                                    'catatan_approve'     => $this->input->post('catatan'),
                                    'mr_id' => $id,
                                    'role_id' => $roleId,
                                    'status_approve' => $this->input->post('status_approve'),
                                    'flow_order' => $floworderr,
                                    'approve_new' => 1,
                                    'limit_app' =>$this->input->post('limit_app') ? $this->input->post('limit_app') :0,
                                ];
                         
                         // $dataaprnew = ['approve_new'     => 1 ];
                         // $this->db->where('mr_id', $id);
                         // $this->db->update('m_approve_mr', $dataaprnew);           
                    }


                    if ($id) {

                        if ($this->mr_pusat_model->create_approve($data_app)) {
                            // update mr_persetujuan untuk notification
                            // $cond_persetujuan=array('project_id'=>$id_project,
                            //                         'mr_id'=>$id,
                            //                         'role_id'=>$roleId,
                            //                         'workflow_id'=>$this->_workflow_persetujuan);

                            // $this->mr_persetujuan_model->update(array('status_flow'=>FALSE,
                            //                             'tanggal'         => date('Y-m-d H:i'),
                            //                             'approve'       => 1,
                            //                             'status_flow'     => 0),$cond_persetujuan);

                            if ($status == 1) {
                                  $data_persetujuan = array('status_flow'=>FALSE,
                                                        'tanggal'        => date('Y-m-d H:i'),
                                                        'approve'       => 1,
                                                        'status_flow'    => 0);

                            $this->db->where('project_id', $id_project);
                            $this->db->where('mr_id', $id);
                            // $this->db->where('role_id',$roleId);
                            $this->db->where('workflow_id', $this->_workflow_persetujuan);
                            $this->db->update('persetujuan',$data_persetujuan);
                            }else{
                                  $data_persetujuan = array('status_flow'=>FALSE,
                                                        'tanggal'        => date('Y-m-d H:i'),
                                                        'approve'       => 1,
                                                        'status_flow'    => 0);

                            $this->db->where('project_id', $id_project);
                            $this->db->where('mr_id', $id);
                            $this->db->where('role_id',$roleId);
                            $this->db->where('workflow_id', $this->_workflow_persetujuan);
                            $this->db->update('persetujuan',$data_persetujuan);
                            }

                          
                            # code...

                             $data = [
                                        'status_approve' => $status,
                                        'step_approve'     => $tahap_step,
                                        'tanggal_approve' => date("Y-m-d H:i:s"),
                                        'catatan_approve'     => $this->input->post('catatan'),
                                        ];

                            if ($this->mr_pusat_model->update($id, $data)) {

                                $k = $_POST['jumlah_equipment'];

                                $data = array();

                                for($i=1; $i < $k; $i++){
                                    if($_POST['acc_no_'.$i]){

                                        $data['acc_no'] = $_POST['acc_no_'.$i] ? $_POST['acc_no_'.$i] : 0;
                                        $data['status_approve'] = $status ;

                                        $this->db->where('mr_equipment_id', $_POST['id_equipment_'.$i]);
                                        $this->db->update('mr_equipment',$data);

                                    }
                                }

                                $param_id_workflow = 'PRO-MR-01';


                                if ($this->input->post('status_approve') == 1) {
                                   if ($tahap_step < $data_approve) {
                                    $this->send_email_approve($id_project, $id, $param_id_workflow, $tahap_step);
                                    }
                                }
                                

                                if ($status == 1) {
                                    $this->send_email_status($id_project, $id, $status);
                                }else if($status == 2){
                                     $this->send_email_status($id_project, $id, $status);
                                }else if($status == 3){
                                     $this->send_email_status($id_project, $id, $status);
                                }

                               
                                $message = ['type' => 'info', 'message' => 'Data Berhasil Diupdate','return' => '__afterSubmit_approve()'];


                            }

                        # LOG
                            $this->log_activity_model->save([
                                        'module'   => $this->_module,
                                        'sistem'   => TRUE,
                                        'event'    => 'Update',
                                        'activity' => 'Update Material Requirment'
                            ]);

                            echo json_encode($message);
                        }
                    }
                }
            }
            }else{

                $message = ['type' => 'error', 'message' => 'MAAF !!!, TIDAK BISA MELAKUKAN APPROVAL KARENA TIDAK MEMPUNYAI HAK AKSES PADA SETTIGAN ROLE USER',];
                echo json_encode($message);
            }
        }

        public function save($id = NULL) {
            if ($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {
                if (hprotection::must_ajax($this->_module . '/404')) {

                    // var_dump($_POST);
                    // exit();
                    $exist_kode = NULL;
                    $kode       = $this->input->post('kode_mr');

                    if(!$id):
                        if(!empty($kode)):
                        $check_kode = $this->mr_pusat_model->is_exist($kode);
                            if($check_kode):
                                $exist_kode = 1;
                            endif;
                        endif;
                    endif;

                if ($exist_kode == 1) {
                     $message = ['error' => true, 'message' => 'Terjadi Kesalahan <br> NO MR Sudah Ada', 'callback' => $this->form_validation->get_errors_array()];
                    
                }else{

                    $cont = $this->input->post('barang_nama');
                    $jm = count($cont);
                   
                    for ($i=0; $i < $jm ; $i++) { 
                           $this->form_validation->set_rules('barang_nama['.$i.']', '<i class="fa fa-warning"> Description MR Tidak Boleh kosong </i>', 'trim|required');

                            $this->form_validation->set_rules('barang_nama[]', '<i class="fa fa-warning"> Description MR Cost Tidak Boleh kosong </i>', 'trim|required');
                    }


                    $this->form_validation->set_rules('nama_permintaan', '<i class="fa fa-warning"> Nama permintaan </i>', 'trim|required');

                        if($this->form_validation->run($this)) {

                            $param_id_workflow = 'PRO-MR-01';
                            $flow_order = 1;

                            $dokumen = [];
                            $path    = './uploads/mr/doc/'.date('Y').'/'.date('m').'/';
                            if(!file_exists($path)) mkdir($path,0777,TRUE);
                            $this->load->library('upload');
                           
                             $config  = array(
                                                    'upload_path'   => $path,
                                                    'allowed_types' => 'pdf|jpg|png|docx|doc|xlsx|csv|xls|gif|jpeg|JPG|PNG'
                                                );

                             $this->upload->initialize($config);

                            $confignew  = array(
                                                    'upload_path'   => $path,
                                                    'allowed_types' => 'pdf|jpg|png|docx|doc|xlsx|csv|xls|gif|jpeg|JPG|PNG'
                                                );

                             $this->upload->initialize($confignew);

                                 
                           $data = NULL;

                            if ($this->input->post('type_transaksi') == 1) {
                                 $data = [
                                    'id_master_project' => $this->input->post('id_project'),
                                    'status_save'     => $this->input->post('status_save'),
                                    'no_proyek'  => $this->input->post('no_project'),
                                    'nama_proyek' =>  $this->input->post('nama_project'),
                                    'kode_mr' => $this->input->post('kode_mr'),
                                    'nama_permintaan'     => $this->input->post('nama_permintaan'),
                                    'tanggal_buat_mr'  => date('Y-m-d',strtotime($this->input->post('tanggal_pembuatan_mr'))),
                                    'purchase_instruction' =>  $this->input->post('purchase'),
                                    'shipping_instruction' =>  $this->input->post('shipping'),
                                    'id_kota' => $this->input->post('id_kota'),
                                    'lampiran_file' => json_encode($dokumen),
                                    'create_at' =>  date('Y-m-d H:i:s'),
                                    'create_by' => $this->session->userdata('id_user'),
                                    'kode_unik_ho' => $this->input->post('kode_unik_ho'),
                                    'note' => $this->input->post('note'),
                                    'tahun' => date('y'),
                                    'mr_site_project' =>  $this->input->post('site_project'),
                                 ];
                            }else{
                                $data = [
                                    'id_master_project' => $this->input->post('id_project'),
                                    'status_save'     => $this->input->post('status_save'),
                                    'no_proyek'  => $this->input->post('no_project'),
                                    'nama_proyek' =>  $this->input->post('nama_project'),
                                    'kode_mr' => $this->input->post('kode_mr'),
                                    'nama_permintaan'     => $this->input->post('nama_permintaan'),
                                    'tanggal_buat_mr'  => date('Y-m-d',strtotime($this->input->post('tanggal_pembuatan_mr'))),
                                    'purchase_instruction' =>  $this->input->post('purchase'),
                                    'shipping_instruction' =>  $this->input->post('shipping'),
                                    'id_kota' => $this->input->post('id_kota'),
                                    'lampiran_file' => json_encode($dokumen),
                                    'create_at' =>  date('Y-m-d H:i:s'),
                                    'create_by' => $this->session->userdata('id_user'),
                                    'kode_unik' => $this->input->post('kode_unik'),
                                    'note' => $this->input->post('note'),
                                    'tahun' => date('y'),
                                    'mr_site_project' =>  $this->input->post('site_project'),
                                 ];
                            }



                            if ($id) {
                                if(!empty($_FILES['lampiran_file'])){
                                    $data_edit = [
                                        'nama_permintaan'     => $this->input->post('nama_permintaan'),
                                        'tanggal_buat_mr'  => date('Y-m-d',strtotime($this->input->post('tanggal_pembuatan_mr'))),
                                        'purchase_instruction' =>  $this->input->post('purchase'),
                                        'shipping_instruction' =>  $this->input->post('shipping'),
                                        'status_save'          =>  $this->input->post('status_save'),
                                        'note' => $this->input->post('note'),
                                        ];
                                }else{
                                    $data_edit = [
                                        'nama_permintaan'     => $this->input->post('nama_permintaan'),
                                        'tanggal_buat_mr'  => date('Y-m-d',strtotime($this->input->post('tanggal_pembuatan_mr'))),
                                        'purchase_instruction' =>  $this->input->post('purchase'),
                                        'shipping_instruction' =>  $this->input->post('shipping'),
                                        'status_save'          =>  $this->input->post('status_save'),
                                        'note' => $this->input->post('note'),
                                        ];
                                }


                                if ($this->input->post('status_approve') == 1) {
                                    $data_edit = [
                                        'nama_permintaan'     => $this->input->post('nama_permintaan'),
                                        'tanggal_buat_mr'  => date('Y-m-d',strtotime($this->input->post('tanggal_pembuatan_mr'))),
                                        'purchase_instruction' =>  $this->input->post('purchase'),
                                        'shipping_instruction' =>  $this->input->post('shipping'),
                                        'status_save'          =>  $this->input->post('status_save'),
                                        'note' => $this->input->post('note'),
                                        'status_approve'     => 0,
                                    ];

                                     $dataaprnew = ['approve_new'     => 2 ];
                                     $this->db->where('mr_id', $id);
                                     $this->db->update('m_approve_mr', $dataaprnew);    
                                }

                                //  var_dump($data_edit );
                                // exit();
                                if($this->input->post('remove_lampiran')) {
                                    foreach ($this->input->post('remove_lampiran') as $key => $value) {
                                        $this->mr_pusat_model->deletefilelampiran($this->input->post('remove_lampiran')[$key]);
                                    }
                                }

                                if(!empty($_FILES['lampiran_file_new'])) {
                                                $filess = $_FILES['lampiran_file_new'];
                                                $number_of_filess = sizeof($filess['name']);
                                          
                                           
                                        $dataa = array();
                                        $ii = 0;

                                       
                                        for ($ii=0;  $ii < $number_of_filess ; $ii++) { 
                                         //     # code...
                                         // } ($_FILES['lampiran_file'] as $key => $value) {
                                           
                                            if(!empty($_FILES['lampiran_file_new']['name'][$ii])) {
                                                if($number_of_filess > $ii) {
                                                    $_FILES['dokumen']['name'] = $filess['name'][$ii];
                                                    $_FILES['dokumen']['type'] = $filess['type'][$ii];
                                                    $_FILES['dokumen']['tmp_name'] = $filess['tmp_name'][$ii];
                                                    $_FILES['dokumen']['error'] = $filess['error'][$ii];
                                                    $_FILES['dokumen']['size'] = $filess['size'][$ii];
                                                    
                                                    $this->upload->initialize($confignew);
                                                    if($this->upload->do_upload('dokumen')) {
                                                        $data_upload = $this->upload->data();
                                                        $dokumen = array(
                                                                    'file'      => $confignew['upload_path'].$data_upload['file_name'],
                                                                    'filename'  => $data_upload['file_name'],
                                                                    );
                                                        $dataa['lampiran_new'] = json_encode($dokumen);
                                                        $dataa['mr_id_lampiran'] = $id;
                                                        $dataa['id_project_lampiran'] = $this->input->post('id_project');
                                                        $dataa['create_at'] =  date('Y-m-d H:i:s');
                                                        $dataa['create_by'] = $this->session->userdata('id_user');
                                                       
                                                    } else {
                                                        echo $this->upload->display_errors();
                                                    }

                                                }

                                                  $this->db->insert('lampiran_mr', $dataa);

                                            }

                                           

                                        }
                                  }


                            if ($this->mr_pusat_model->update($id, $data_edit)) {



                                if ($this->input->post('type_equipment')){
                                          if(!empty($_FILES['lampiran_file'])) {
                                                $files = $_FILES['lampiran_file'];
                                                $number_of_files = sizeof($files['name']);
                                            }
                                           
                                         // $data = array();
                                        $i = 0;
                                    foreach ($this->input->post('type_equipment') as $key => $value) {

                            
                                             $data = [ 
                                                'id_m_project' => $this->input->post('id_project'), 
                                                'mr_id' => $id, 
                                                'description' => $this->input->post('barang_nama')[$key], 
                                                'id_barang' => $this->input->post('barang_id')[$key] ? $this->input->post('barang_id')[$key] : 0, 
                                                'quantity' => $this->input->post('quantity')[$key] ? $this->input->post('quantity')[$key] : NULL, 
                                                'unit' =>  $this->input->post('unit')[$key] ? $this->input->post('unit')[$key] : NULL, 
                                                'part_number' =>  $this->input->post('part_number')[$key] ? $this->input->post('part_number')[$key] : NULL, 
                                                'unit_cost' => $this->input->post('unit_cost')[$key] ? $this->input->post('unit_cost')[$key] : 0 , 
                                                'total_cost' => $this->input->post('total_cost')[$key] ? $this->input->post('total_cost')[$key] : 0, 
                                                // 'total_cost' => $this->input->post('unit_cost')[$key] ? $this->input->post('unit_cost')[$key] : 0, 
                                                'type_equipment' => $this->input->post('type_equipment')[$key], 
                                                'date_lama_sewa' => $this->input->post('month')[$key] ? date('Y-m-d', strtotime($this->input->post('month')[$key])) : NULL, 
                                                'desc_detail' =>  $this->input->post('detail_desc')[$key], 
                                                'tgl_butuh' => $this->input->post('tgl_kebutuhan')[$key] ?  date('Y-m-d', strtotime($this->input->post('tgl_kebutuhan')[$key])) : NULL, 
                                                'remarks' => $this->input->post('remarks')[$key],
                                                'lokasi_station' => $this->input->post('lokasi_station')[$key], 
                                                'size' => $this->input->post('size')[$key],
                                                'no_rak' => $this->input->post('no_rak')[$key] ? $this->input->post('no_rak')[$key] : NULL,
                                                'currency' => $this->input->post('currency')[$key] ? $this->input->post('currency')[$key] : NULL,

                                             ];

                                            if(!empty($_FILES['lampiran_file']['name'][$key])) {
                                                if($number_of_files > $i) {
                                                    $_FILES['dokumen']['name'] = $files['name'][$key];
                                                    $_FILES['dokumen']['type'] = $files['type'][$key];
                                                    $_FILES['dokumen']['tmp_name'] = $files['tmp_name'][$key];
                                                    $_FILES['dokumen']['error'] = $files['error'][$key];
                                                    $_FILES['dokumen']['size'] = $files['size'][$key];
                                                    
                                                    $this->upload->initialize($config);
                                                    if($this->upload->do_upload('dokumen')) {
                                                        $data_upload = $this->upload->data();
                                                        $dokumen = array(
                                                                    'file'      => $config['upload_path'].$data_upload['file_name'],
                                                                    'filename'  => $data_upload['file_name'],
                                                                    );
                                                        $data['lampiran'] = json_encode($dokumen);
                                                    } else {
                                                        echo $this->upload->display_errors();
                                                    }
                                                }

                                            }

                                            if(!empty( $this->input->post('id_equipment')[$key])) {
                                                $this->db->where('mr_equipment_id',  $this->input->post('id_equipment')[$key]);
                                                $this->db->update('mr_equipment',$data);
                                            } else {
                                                $this->db->insert('mr_equipment', $data);
                                            }
                                        }
                                    }


                                    if ($this->input->post('status_save') == 1) {
                                        $this->send_email_approve($this->input->post('id_project'), $id, $param_id_workflow, $flow_order);
                                        $this->mr_persetujuan_model->delete(['project_id' => $this->input->post('id_project'),'mr_id'=>$id]);
                                        //$this->set_workflow($this->input->post('id_project'),$id);
                                    }


                                    $message = ['type' => 'info', 'message' => 'Data Berhasil Diupdate','return' => '__afterSubmit()'];
                                }

                                # LOG
                                $this->log_activity_model->save([
                                            'module'   => $this->_module,
                                            'sistem'   => TRUE,
                                            'event'    => 'Update',
                                            'activity' => 'Update Material Requirment'
                                ]);

                            } else {
                                $cond_flow = [
                                            'workflow_id' => $this->_workflow_persetujuan,
                                            'project_id'   => $this->input->post('id_project')
                                        ];

                                $checkFlow = $this->workflow_detail_model->data($cond_flow,'flow_order')->get();

                                if($checkFlow->num_rows() > 0) {

                                 if ($id = $this->mr_pusat_model->create($data)) {

                                    $id_mr = $this->db->insert_id();

                                     if ($this->input->post('type_transaksi') == 1) {

                                        $datakodeho = [
                                                'kode_unik_ho' => $this->input->post('kode_unik_ho'),
                                                'id_mr' => $id_mr,
                                                'id_project' => $this->input->post('id_project'),
                                                'tahun' => date('y'),
                                        ];

                                        $this->db->insert('kode_unik_ho', $datakodeho);
                                    }


                                    if ($this->input->post('type_equipment')){
                                          if(!empty($_FILES['lampiran_file'])) {
                                                $files = $_FILES['lampiran_file'];
                                                $number_of_files = sizeof($files['name']);
                                            }
                                           
                                         // $data = array();
                                        $i = 0;
                                        foreach ($this->input->post('type_equipment') as $key => $value) {
                                             $data = [ 
                                                'id_m_project' => $this->input->post('id_project'), 
                                                'mr_id' => $id_mr, 
                                                'description' => $this->input->post('barang_nama')[$key], 
                                                'id_barang' => $this->input->post('barang_id')[$key] ? $this->input->post('barang_id')[$key] : 0, 
                                                'quantity' => $this->input->post('quantity')[$key] ? $this->input->post('quantity')[$key] : NULL, 
                                                'unit' =>  $this->input->post('unit')[$key] ? $this->input->post('unit')[$key] : NULL, 
                                                'part_number' =>  $this->input->post('part_number')[$key] ? $this->input->post('part_number')[$key] : NULL, 
                                                'unit_cost' => $this->input->post('unit_cost')[$key] ? $this->input->post('unit_cost')[$key] : 0 , 
                                                'total_cost' => $this->input->post('total_cost')[$key] ? $this->input->post('total_cost')[$key] : 0,
                                                // 'total_cost' => $this->input->post('unit_cost')[$key] ? $this->input->post('unit_cost')[$key] : 0,
                                                
                                                'type_equipment' => $this->input->post('type_equipment')[$key], 
                                                'date_lama_sewa' => $this->input->post('month')[$key] ?  date('Y-m-d', strtotime($this->input->post('month')[$key])) : NULL, 
                                                'desc_detail' =>  $this->input->post('detail_desc')[$key], 
                                                'tgl_butuh' => $this->input->post('tgl_kebutuhan')[$key] ? date('Y-m-d', strtotime($this->input->post('tgl_kebutuhan')[$key])):NULL, 
                                                'remarks' => $this->input->post('remarks')[$key],
                                                'lokasi_station' => $this->input->post('lokasi_station')[$key], 
                                                'size' => $this->input->post('size')[$key],
                                                'no_rak' => $this->input->post('no_rak')[$key] ? $this->input->post('no_rak')[$key] : NULL,
                                                'currency' => $this->input->post('currency')[$key] ? $this->input->post('currency')[$key] : NULL,

                                             ];

                                            if(!empty($_FILES['lampiran_file']['name'][$key])) {
                                                if($number_of_files > $i) {
                                                    $_FILES['dokumen']['name'] = $files['name'][$key];
                                                    $_FILES['dokumen']['type'] = $files['type'][$key];
                                                    $_FILES['dokumen']['tmp_name'] = $files['tmp_name'][$key];
                                                    $_FILES['dokumen']['error'] = $files['error'][$key];
                                                    $_FILES['dokumen']['size'] = $files['size'][$key];
                                                    
                                                    $this->upload->initialize($config);
                                                    if($this->upload->do_upload('dokumen')) {
                                                        $data_upload = $this->upload->data();
                                                        $dokumen = array(
                                                                    'file'      => $config['upload_path'].$data_upload['file_name'],
                                                                    'filename'  => $data_upload['file_name'],
                                                                    );
                                                        $data['lampiran'] = json_encode($dokumen);
                                                    } else {
                                                        echo $this->upload->display_errors();
                                                    }
                                                }

                                            }

                                           
                                            $this->db->insert('mr_equipment', $data);
                                        }
                                    }


                                    if(!empty($_FILES['lampiran_file_new'])) {
                                                $filess = $_FILES['lampiran_file_new'];
                                                $number_of_filess = sizeof($filess['name']);
                                           
                                           
                                        $dataa = array();
                                        $ii = 0;
                                       
                                        for ($ii=0;  $ii < $number_of_filess ; $ii++) { 
                                         //     # code...
                                         // } ($_FILES['lampiran_file'] as $key => $value) {
                                           
                                            if(!empty($_FILES['lampiran_file_new']['name'][$ii])) {
                                                if($number_of_filess > $ii) {
                                                    $_FILES['dokumen']['name'] = $filess['name'][$ii];
                                                    $_FILES['dokumen']['type'] = $filess['type'][$ii];
                                                    $_FILES['dokumen']['tmp_name'] = $filess['tmp_name'][$ii];
                                                    $_FILES['dokumen']['error'] = $filess['error'][$ii];
                                                    $_FILES['dokumen']['size'] = $filess['size'][$ii];
                                                    
                                                    $this->upload->initialize($confignew);
                                                    if($this->upload->do_upload('dokumen')) {
                                                        $data_upload = $this->upload->data();
                                                        $dokumen = array(
                                                                    'file'      => $confignew['upload_path'].$data_upload['file_name'],
                                                                    'filename'  => $data_upload['file_name'],
                                                                    );
                                                        $dataa['lampiran_new'] = json_encode($dokumen);
                                                        $dataa['mr_id_lampiran'] = $id_mr;
                                                        $dataa['id_project_lampiran'] = $this->input->post('id_project');
                                                        $dataa['create_at'] =  date('Y-m-d H:i:s');
                                                        $dataa['create_by'] = $this->session->userdata('id_user');
                                                       
                                                    } else {
                                                        echo $this->upload->display_errors();
                                                    }

                                                }

                                                  $this->db->insert('lampiran_mr', $dataa);

                                            }

                                           

                                        }
                                    }

                                    //SIMPAN DULU PENYETUJU SESUAI MASTER approval
                                    $this->set_workflow($this->input->post('id_project'),$id_mr);

                                    

                                    if ($this->input->post('status_save') != 2) {
                                         $this->send_email_approve($this->input->post('id_project'), $id_mr, $param_id_workflow, $flow_order);
                                    }
                                   


                                    $message = ['type' => 'info', 'message' => 'Data Berhasil Disimpan', 'return' => '__afterSubmit()'];
                                }


                             
                                # LOG
                                $this->log_activity_model->save([
                                            'module'   => $this->_module,
                                            'sistem'   => TRUE,
                                            'event'    => 'Insert',
                                            'activity' => 'Insert Material Requirment'
                                ]);

                                }else{//JIKA BELUM DI SET WORKFLOW UNTUK PROJECT INI
                                    $message = ['error' => true, 'message' => 'Terjadi Kesalahan <br> Flow Persetujuan Proyek belum diset. Silahkan hubungi petugas bersangkutan', 'callback' => $this->form_validation->get_errors_array()];
                                }
                            }


                        } else {
                            $message = ['error' => true, 'message' => 'Terjadi Kesalahan <br> Periksa kembali data input', 'callback' => $this->form_validation->get_errors_array()];
                        }
                 }

                         echo json_encode($message);

                }else{
                    echo Modules::run('template/error_message/error_forbidden');
                }
            }
        }

        private function set_workflow($project_id,$mr_id)
        {
            $cond = [
                        'workflow_id' => $this->_workflow_persetujuan,
                        'project_id'   => $project_id
                    ];

            $checkFlow = $this->workflow_detail_model->data($cond,'flow_order')->get();

            if($checkFlow->num_rows() > 0) {

                foreach($checkFlow->result() as $cekFlow) {
                $this->mr_persetujuan_model->create(array(
                                                    'project_id' => $project_id,
                                                    'workflow_id'   => $this->_workflow_persetujuan,
                                                    'role_id'       => $cekFlow->role_id,
                                                    'mr_id'     => $mr_id
                                                ));
                                            }
            } else {

                $data = [
                    'status_approve' => false
                ];

                $this->permintaan_model->update($permintaan, $data);
            }
        }
    public function delete($id){

        $this->db->where('mr_id',$id);
        $this->db->delete('material_requisition');

        $this->db->where('mr_id',$id);
        $this->db->delete('mr_equipment');

        $message = ['type' => 'info', 'message' => 'Data Berhasil Dihapus','return' => '__reloadTable(false)'];
        echo json_encode($message);
    }

    public function delete_mr_equipment($id_equipment){
        $this->db->where('mr_equipment_id',$id_equipment);
        $this->db->delete('mr_equipment');

        //$message = ['type' => 'info', 'message' => 'Data Berhasil Dihapus','return' => '__reloadTable(false)'];
        echo json_encode($id_equipment);
    }

     //BARANG
    public function load_data_barang($type = NULL)
    {
        # Data Table
        $limit  = $this->input->post('length');
        $offset = $this->input->post('start');
        $draw   = $this->input->post('draw');
        $extraColumn = $this->input->post('columns');
        $extraOrder  = $this->input->post('order');

        # Ordering
        $orderBy   = 'barang_nama';
        $direction = NULL;

        if($extraColumn[$extraOrder[0]['column']]['orderable'] == 'true') {
            $orderBy = isset($extraColumn[$extraOrder[0]['column']]['name']) ? $extraColumn[$extraOrder[0]['column']]['name'] : NULL;
            $direction   = $extraOrder[0]['dir'];
        }

        # Condition
        $cond = [];

        if($type) {
            switch ($type) {
                case 'inventaris':
                    $cond['jenis_asset'] = 'Inventaris';
                    break;

                case 'habis_pakai':
                    $cond['jenis_asset'] = 'Habis Pakai';
                    break;
                case 'Persediaan': case 'persediaan':
                    $cond['jenis_asset'] = 'Persediaan';
                    break;
            }
        }


        // if (!empty( $this->input->post('lbu_id') ) ) {
        //     $cond['a.lbu_id'] = $this->input->post('lbu_id');
        // }

        // if (!empty( $this->input->post('bidang_lbu_id') ) ) {
        //     $cond['a.bidang_lbu_id'] = $this->input->post('bidang_lbu_id');
        // }

        // if (!empty( $this->input->post('gl_akun_id') ) ) {
        //     $cond['a.gl_akun_id'] = $this->input->post('gl_akun_id');
        // }

        if (!empty( $this->input->post('keyword') ) ) {
             $cond["(LOWER(barang_nama) ILIKE '%{$this->input->post('keyword')}%') "] = NULL;
        }

        $dataCount          = $this->barang_model->data()->get()->num_rows();
        $dataCountFiltered  = $this->barang_model->data($cond)->get()->num_rows();
        $dataResult         = $this->barang_model->data($cond, $orderBy, $direction, $limit, $offset)->get();

        $rows = [];
        $no   = $offset;

        foreach ($dataResult->result() as $dt) {

            $id     = $dt->barang_id;

            $no++;

            $rows[] = array(
                        hgenerator::columns_align($no,'center'),
                        '<span class="id" data-id="'.$dt->barang_id.'"><a href="javascript:;" class="a-kode">'.$dt->barang_id.'</a></span>',
                        '<span class="nama" data-id="'.$dt->barang_nama .' '. $dt->barang_merk.' '.$dt->barang_type.'"><a href="javascript:;" class="a-nama">'.$dt->barang_nama .' '. $dt->barang_merk.' '.$dt->barang_type.'</a></span>',
                            $dt->nama_jenis_barang,
                        '<span class="satuan" data-id="'.$dt->satuan.'"><a href="javascript:;" class="a-stock">'.$dt->satuan.'</a></span>',
                         '<span class="harga" data-id="'.$dt->harga.'">'.$dt->harga.' </span>'
                    );

        }

            $data = [
                'draw'            => $draw,
                'recordsTotal'    => $dataCount,
                'recordsFiltered' => $dataCountFiltered,
                'data'            => $rows,
            ];

            echo json_encode($data);
    }

    public function print_mr($id_projcet, $id_mr){
       if ($this->laccess->otoritas('import') || $this->laccess->otoritas('export')) {

        $data_approve = $this->db->query("select * from m_approve_mr a
                                                LEFT JOIN m_user b on b.id_user = a.id_user_approve
                                                left join hr_pegawai c on c.pegawai_id = b.id_pegawai
                                                left join hr_ref_jabatan d on d.jabatan_id = c.jabatan_id
                                                left join m_role e on e.id_role = b.id_role
                                                where a.mr_id = '".$id_mr."' and a.status_approve = '1' ORDER BY a.id_approve_mr ")->result();

        $create_by =  $this->db->query("select create_by from material_requisition where mr_id = '".$id_mr."' ")->row()->create_by;
        $name_request =  $this->db->query("select * from m_user a
                                            left join m_role b on b.id_role = a.id_role
                                            left join hr_pegawai c on c.pegawai_id  = a.id_pegawai
                                            where a.id_user = '".$create_by."' ")->row();


        // var_dump($create_by);
        // exit();

        // print_debug($data_approve);

        $cond=['status_aktip' => 1];
        $cond=['type_logo' => 2];
        $dataimgtuv = $this->logo_tuv_model->data($cond)->get()->row();
        $data['image'] = json_decode($dataimgtuv->image);
        
        $data['pageTitle']  = 'FORM MR';
        $cond= [];
        $cond['id_m_project'] = $id_projcet;
        $cond['mr_id'] = $id_mr;
        $dataTable = $this->mr_pusat_model->table_equipment($cond)->get();
        $dataResult= $this->mr_pusat_model->data_result_print($cond)->get();
        $data['table'] = $dataTable->result();
        $data['data'] = $dataResult->row();
        $count_print = $this->mr_pusat_model->count_print_mr(array('mr_id' => $id_mr))->get();

        $data['data_app'] =  $data_approve ;
        $data['name_request'] =  $name_request ;

        $status_appro = $this->db->get_where('material_requisition', array('mr_id' => $id_mr))->row();

        $data['status_approve'] =  $status_appro->status_approve ;


        if($count_print->num_rows() > 0){
            $result_last_print = $count_print->row();
            $last_print = $result_last_print->print+1;
            $data_edit = array('print' => $last_print);
            $this->mr_pusat_model->update_count_print_mr($id_mr, $data_edit);
            $result = $this->mr_pusat_model->count_print_mr(array('mr_id' => $id_mr))->get()->row();
            $print = $result->print;

        }else{
            $data_ = array('mr_id' => $id_mr,'print' => 1);
            $this->db->insert('mr_print', $data_);
            $result = $this->mr_pusat_model->count_print_mr(array('mr_id' => $id_mr))->get()->row();
            $print = $result->print;
        }
        $this->load->library('lpdf');
        $this->lpdf->html($this->load->view($this->_module . '/print_mr', $data, true));
        $this->lpdf->margin(10,10,10,10,5,5);
        $this->lpdf->print_standard('A4','L',$print);
        // $this->load->view($this->_module.'/print_mr',$data);

       }else{
                 echo Modules::run('template/error_message/error_forbidden');
        }
        
     
    }

   public function in_range($number, $min, $max)
        {
           if($number > $min and $number < $max) {
              return TRUE;
            }else{
              return FALSE;
            }
        }

    public function detail_info_list_approved($id_project,$id_mr, $param = NULL){

            $list = $this->mr_pusat_model->data_info_list_approve($id_project, $param)->get();
            $total = $this->total_model->total_hitung('mr_equipment','total_cost','mr_id',$id_mr)->get()->row()->total;

            // $kd =   hgenerator::in_range($total,100000,90000000);
            // var_dump($kd);
            // exit();
             
                $data = array();

                $no = 1;
                foreach ($list->result() as $detail) {

                    $orname =$this->workflow_detail_model->get_or($detail->workflow_id,$detail->flow_order,$detail->project_id)->get()->row();

               
                    $datamrr = $this->db->select(" * FROM m_approve_mr a
                                                    LEFT JOIN material_requisition b on b.mr_id = a.mr_id
                                                    where a.role_id = '".$detail->role_id."' and a.step_approve = '".$detail->flow_order."'
                                                    and a.id_user_approve = '".$detail->id_user."' and a.status_approve = '1'
                                                    and a.mr_id = '".$id_mr."'  and b.id_master_project = '".$id_project."' ")->get()->num_rows();
                    if ($datamrr == 1) {
                       $ket = 'SUDAH <i class="fa fa-check" style="color:blue"></i>';
                    }else if ($datamrr == 0) {
                        $ket = 'BELUM <i class="fa fa-times" style="color:red"></i>';
                    }


                    if (!empty($orname)) {
                       $nameor = ' <span style="color:red">OR</span> '.$orname->nama_role;
                    }else{
                        $nameor = '';
                    }

                    if ($detail->skip_order == 1) {
                        $skip = '<span class="pull-right" style="color:red">Skip</span> ';
                    }else{
                         $skip = '';
                    }

                    $inrange = hgenerator::in_range($total,$detail->min,$detail->max);
                    if ($inrange == TRUE) {
                        $inran= 'range';
                    }else{
                         $inran= 'notrange';
                    }

                       $row = array();
                      
                        $row[] = ''.$detail->flow_order.'';
                        $row[] = $detail->pegawai_nama;
                        $row[] = ''.$detail->nama_role.' '.$nameor.' '.$skip.' ';
                        $row[] = $ket;

                   
                    
                   
                    $data[] = $row;
                }

                $output = array(
                                "draw" => $_POST['draw'],
                                "recordsTotal" => count($list->result()),
                                "recordsFiltered" => count($list->result()),
                                "data" => $data,
                        );
                //output to json format
                echo json_encode($output);
    }

     public function list_data_barang()
    {
        $cond  =[];

        // if($this->input->get('jenis')) {
        //     $cond['tb.jenis_asset'] = $this->input->get('jenis');
        // }

        if($this->input->get('keyword')) {
            $cond["(LOWER(tb.name) ILIKE '%{$this->input->get('keyword')}%')"] = NULL;
        }

        $query = $this->barang_model->lists($cond)->get();

        $data = [];

        if($query->num_rows()) {
            foreach ($query->result() as $dt) {
                $data[] = [
                    'id' => $dt->id,
                    'name' => $dt->name,
                    'satuan' => $dt->satuan,
                    'harga' => $dt->harga,
                    'id_project' => $dt->id_project,
                    'id_kota' => $dt->id_kota,
                    'id_acc_code' => $dt->id_account_code,
                    'client' => $dt->client,
                    'id_currency' => $dt->id_currency,
                ];
            }
        }

        echo json_encode($data);
    }

    function send_email_status($id_project,$id_mr, $status){

                $datamr = $this->db->get_where('material_requisition', array('mr_id' => $id_mr))->row();
                $dtemail =  $this->db->get_where('m_user a left join hr_pegawai b on b.pegawai_id = a.id_pegawai', array('a.id_user' => $datamr ->create_by ))->row();

                 $link = base_url().'home#mr/mr/page_list_mr/'.$id_project ;

                $data_config = $this->email_config_model->table(1)->get()->row();
                $config = Array(
                        'protocol'  => $data_config->protocol,
                        'smtp_host' => $data_config->smtp_host,
                        'smtp_port' => $data_config->smtp_port,
                        'smtp_user' => $data_config->smtp_user,
                        'smtp_pass' => $data_config->smtp_password,
                        'mailtype'  => $data_config->mailtype,
                        'charset'   => $data_config->charset,
                );

                $this->load->library('email', $config);
                $this->email->set_newline("\r\n");
                if ($status == 1) {
                     $message = '
                            Nama Proyek = '.$datamr->nama_proyek.' <br>
                            Nama MR = '.$datamr->nama_permintaan.' <br>
                            Kode MR = '.$datamr->kode_mr.' <br>
                            <h2> DI APPROVE / DI SETUJUI </h2> <br> 

                            Silahkan clik link di bawah ini untuk Informasi Lebih Lanjut.<br>

                          '.$link.' ';
                }

                if ($status == 2) {
                    $message = '
                            Nama Proyek = '.$datamr->nama_proyek.' <br>
                            Nama MR = '.$datamr->nama_permintaan.' <br>
                            Kode MR = '.$datamr->kode_mr.' <br>
                            <h2> APPROVAL MEMINTA MR DI REVISI</h2> <br> 

                            Silahkan clik link di bawah ini untuk Informasi Lebih Lanjut.<br>

                          '.$link.' ';
                }

                if ($status == 3) {
                     $message = '
                            Nama Proyek = '.$datamr->nama_proyek.' <br>
                            Nama MR = '.$datamr->nama_permintaan.' <br>
                            Kode MR = '.$datamr->kode_mr.' <br>
                            <h2> DI TOLAK </h2> <br> 

                            Silahkan clik link di bawah ini untuk Informasi Lebih Lanjut.<br>

                          '.$link.' ';
                }
              

                $this->email->from($data_config->email);
                $this->email->to($dtemail->pegawai_email);
                $this->email->subject("info status approval (MR) NO MR ".$datamr->kode_mr."  ");
                $this->email->message($message);
                $this->email->send();
                    // $data['email_from']=$data_config->email;
                    // $data['email_to']=$dtemail->pegawai_email;
                    // $data['cc']=$data_config->email;
                 //    $data['subject']="INFO STATUS MATERIAL REQUISITION (MR) PT. CITRA PANJI MANUNGGAL ";
                 // $this->email_list_model->create($data);


    }

    function send_email_approve_all($id_project,$id_mr, $id_workflow, $floworder){

        $cond['a.project_id']= $id_project;
        $cond['a.workflow_id']= $id_workflow;
        // $cond['a.flow_order']= $floworder;
        $query = $this->workflow_detail_model->get_email_approve($cond,'flow_order')->get();
        $datamr = $this->db->get_where('material_requisition', array('mr_id' => $id_mr))->row();
      
       // $link = 'http://localhost/cpm/home#mr/mr/form_mr_approve/65/130' ;
        $link = base_url().'home#mr/mr/form_mr_approve/'.$datamr->id_master_project.'/'.$datamr->mr_id ;

        $data_config = $this->email_config_model->table(1)->get()->row();
        $config = Array(
                        'protocol'  => $data_config->protocol,
                        'smtp_host' => $data_config->smtp_host,
                        'smtp_port' => $data_config->smtp_port,
                        'smtp_user' => $data_config->smtp_user,
                        'smtp_pass' => $data_config->smtp_password,
                        'mailtype'  => $data_config->mailtype,
                        'charset'   => $data_config->charset,
                        );

           
                $this->load->library('email', $config);
                $this->email->set_newline("\r\n");

                // $this->email->attach(''.$path.'equipment_'.$id.'.pdf', 'attachment', 'Equipment.pdf');
                // $query_mr = $this->db->query("select * FROM material_requisition where mr_id = '".$mr_id."' ")->row();
                // $attach_mr = json_decode($query_mr->lampiran_file);

                // foreach ($attach_mr as $value) {
                //     $this->email->attach($value->file, 'attachment', 'Attachment.pdf');
                // }
                $data['id_mr'] = $id_mr;
                $message = 'Ada Permintaan MR baru di buat Pada tanggal '.$datamr->tanggal_buat_mr.' <br>
                          Nama Proyek = '.$datamr->nama_proyek.' <br>
                          Nama MR = '.$datamr->nama_permintaan.' <br>
                          Kode MR = '.$datamr->kode_mr.' <br>
                          Silahkan clik link di bawah ini untuk melihat/melakukan approval MR <br>
                          '.$link.' ';

                foreach ($query->result() as $dt) {

                $this->email->from($data_config->email);
                $this->email->to($dt->pegawai_email);
                $this->email->subject("Approval Material Requisition (MR) No MR ".$datamr->kode_mr." ");

                $this->email->message($message);

                $this->email->send();
                    // $data['email_from']=$data_config->email;
                    // $data['email_to']=$dt->pegawai_email;
                    // $data['cc']=$data_config->email;
                    //$data['subject']="APPROVAL MATERIAL REQUISITION (MR) PT. CITRA PANJI MANUNGGAL ";
                    // $data['attachment']=$data_config->email;

                // $this->email_list_model->create($data);

            }
          
    }

    function send_email_approve($id_project,$id_mr, $id_workflow, $floworder){

        $cond['a.project_id']= $id_project;
        $cond['a.workflow_id']= $id_workflow;
        $cond['a.flow_order']= $floworder;
        $query = $this->workflow_detail_model->get_email_approve($cond,'flow_order')->get();
        $datamr = $this->db->get_where('material_requisition', array('mr_id' => $id_mr))->row();
      
       // $link = 'http://localhost/cpm/home#mr/mr/form_mr_approve/65/130' ;
        $link = base_url().'home#mr/mr/form_mr_approve/'.$datamr->id_master_project.'/'.$datamr->mr_id ;

        $data_config = $this->email_config_model->table(1)->get()->row();
        $config = Array(
                        'protocol'  => $data_config->protocol,
                        'smtp_host' => $data_config->smtp_host,
                        'smtp_port' => $data_config->smtp_port,
                        'smtp_user' => $data_config->smtp_user,
                        'smtp_pass' => $data_config->smtp_password,
                        'mailtype'  => $data_config->mailtype,
                        'charset'   => $data_config->charset,
                        );

            // $config = Array(
            //     'protocol' => 'smtp',
            //     'smtp_host' => 'ssl://smtp.gmail.com',
            //     'smtp_port' => 465,
            //     'smtp_user' => 'arjunawae17@gmail.com',
            //     'smtp_pass' => 'akujugatidaktau',
            //     'mailtype'  => 'html',
            //     'charset'   => 'iso-8859-1'
            // );
                $this->load->library('email', $config);
                $this->email->set_newline("\r\n");

                // $this->email->attach(''.$path.'equipment_'.$id.'.pdf', 'attachment', 'Equipment.pdf');
                // $query_mr = $this->db->query("select * FROM material_requisition where mr_id = '".$mr_id."' ")->row();
                // $attach_mr = json_decode($query_mr->lampiran_file);

                // foreach ($attach_mr as $value) {
                //     $this->email->attach($value->file, 'attachment', 'Attachment.pdf');
                // }
                $data['id_mr'] = $id_mr;
                $message = 'Ada Permintaan MR baru di buat Pada tanggal '.$datamr->tanggal_buat_mr.' <br>
                          Nama Proyek = '.$datamr->nama_proyek.' <br>
                          Nama MR = '.$datamr->nama_permintaan.' <br>
                          Kode MR = '.$datamr->kode_mr.' <br>
                          Silahkan clik link di bawah ini untuk melihat/melakukan approval MR <br>
                          '.$link.' ';

                foreach ($query->result() as $dt) {

                $this->email->from($data_config->email);
                $this->email->to($dt->pegawai_email);
                $this->email->subject("Approval Material Requisition (MR) No MR ".$datamr->kode_mr." ");

                $this->email->message($message);

                $this->email->send();
                    // $data['email_from']=$data_config->email;
                    // $data['email_to']=$dt->pegawai_email;
                    // $data['cc']=$data_config->email;
                    // $data['subject']="APPROVAL MATERIAL REQUISITION (MR) PT. CITRA PANJI MANUNGGAL ";
                    // $data['attachment']=$data_config->email;

                 // $this->email_list_model->create($data);

           }
          
    }


    public function import($id_project, $id = NULL){

                    $data_project = $this->mr_pusat_model->get_data_project($id_project)->get()->row();

                    $table = "material_requisition";
                    $tableho = "kode_unik_ho";
                     $yr = date('y');
                    $kode_unik = $this->kode_unik_model->getkodeunik($table, $id_project,$data_project->site_project);
                    $kode_unik_ho = $this->kode_unik_model->getkodeunikho($tableho, $yr);
                   
                    $yr = date('y');
                    if ($data_project->status_buat_projek == 1 || $data_project->status_buat_projek == 2) {
                        $data['kode_mr'] = ''.$data_project->kode_project.'-MR-HO-'.$kode_unik_ho.'-'.$yr.'';
                        $data['type_transaksi'] = 1;
                        $tptransaksi = 1;
                    }else{
                         if ($data_project->site_project == 1) {
                        $data['kode_mr'] = ''.$data_project->kode_project.'-MR-HO-'.$kode_unik.'-'.$yr.'';
                        }else if ($data_project->site_project == 2) {
                            $data['kode_mr'] = ''.$data_project->kode_project.'-MR-'.$data_project->singkatan.'-'.$kode_unik.'-'.$yr.'';
                        }else{
                            $data['kode_mr'] = ''.$data_project->kode_project.'-MR-'.$data_project->singkatan.'-'.$kode_unik.'-'.$yr.'';
                        }
                        $data['type_transaksi'] = 2;
                        $tptransaksi = 2;
                    }

                     if ($data['type_transaksi'] == 1) {
                                  $datam = [
                                        'id_master_project' => $id_project,
                                        'status_save'     => 2,
                                        'no_proyek'  => $data_project->kode_project,
                                        'nama_proyek' =>  $data_project->nama_project,
                                        'kode_mr' =>  $data['kode_mr'],
                                        'nama_permintaan'     => 'MR '.$data_project->nama_project.'',
                                        'tanggal_buat_mr'  => date('Y-m-d'),
                                        'id_kota' => $data_project->id_kota,
                                        'create_at' =>  date('Y-m-d H:i:s'),
                                        'create_by' => $this->session->userdata('id_user'),
                                        'kode_unik_ho' => $kode_unik_ho,
                                        'tahun' => date('y'),
                                        'mr_site_project' => $data_project->site_project,
                                    ];
                        }else{
                                 $datam = [
                                        'id_master_project' => $id_project,
                                        'status_save'     => 2,
                                        'no_proyek'  => $data_project->kode_project,
                                        'nama_proyek' =>  $data_project->nama_project,
                                        'kode_mr' =>  $data['kode_mr'],
                                        'nama_permintaan'     => 'MR '.$data_project->nama_project.'',
                                        'tanggal_buat_mr'  => date('Y-m-d'),
                                        'id_kota' => $data_project->id_kota,
                                        'create_at' =>  date('Y-m-d H:i:s'),
                                        'create_by' => $this->session->userdata('id_user'),
                                        'kode_unik' => $kode_unik,
                                        'mr_site_project' =>  $data_project->site_project,
                                        'tahun' => date('y'),

                                    ];
                            }
                   

                          

                        if ($this->mr_pusat_model->create($datam)) {
                            $id_mr = $this->db->insert_id();

                            $config['upload_path']   = 'uploads/import_excel/';
                            $config['allowed_types'] = 'xlsx|xls|csv';
                            // $config['max_size']      = 400000;

                            if(!file_exists($config['upload_path'])) {
                                mkdir($config['upload_path'],0777,TRUE);
                            } 

                            $this->load->library('upload', $config);

                            $files = $_FILES['file'];

                            if($this->upload->do_upload('file')) {
                                $uploadData = $this->upload->data();
                            }

                            $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));

                            $object = IOFactory::load($config['upload_path'] .'/' .$uploadData['file_name']);

                            $validasi_tgl = NULL;

                            foreach ($object->getWorksheetIterator() as $worksheet) {
                                  $worksheetTitle     = $worksheet->getTitle();
                                $highestRow         = $worksheet->getHighestRow(); 
                                $highestColumn      = $worksheet->getHighestColumn(); 
                                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
                                $nrColumns = ord($highestColumn) - 64;

                                for ($row = 6; $row <= $highestRow; ++ $row) {
                                $tgl_kebutuhan            = $worksheet->getCellByColumnAndRow(9, $row); 
                                $var = $tgl_kebutuhan->getValue();

                                    if (empty($var)) {
                                        $validasi_tgl .= 1;
                                    }
                                }
                            }

                            if ($validasi_tgl == NULL) {
                                     $data = array();
                                foreach ($object->getWorksheetIterator() as $worksheet) {
                                $worksheetTitle     = $worksheet->getTitle();
                                $highestRow         = $worksheet->getHighestRow(); 
                                $highestColumn      = $worksheet->getHighestColumn(); 
                                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
                                $nrColumns = ord($highestColumn) - 64;

                                for ($row = 6; $row <= $highestRow; ++ $row) {


                                    $no_rak              = $worksheet->getCellByColumnAndRow(0, $row); 
                                    $description              = $worksheet->getCellByColumnAndRow(1, $row); 
                                    $size                     = $worksheet->getCellByColumnAndRow(2, $row); 
                                    $qty                      = $worksheet->getCellByColumnAndRow(3, $row);
                                    $unit                     = $worksheet->getCellByColumnAndRow(4, $row);
                                    $spec                     = $worksheet->getCellByColumnAndRow(5, $row);
                                    $price                    = $worksheet->getCellByColumnAndRow(6, $row); 
                                    $currency                 = $worksheet->getCellByColumnAndRow(7, $row);
                                    $lokasi                   = $worksheet->getCellByColumnAndRow(8, $row); 
                                    $tgl_kebutuhan            = $worksheet->getCellByColumnAndRow(9, $row); 
                                    $total                    = $qty->getValue() *  $price->getValue() ; 
                                    $remarks                  = $worksheet->getCellByColumnAndRow(10, $row); 

                                    // $desc = $description->getValue();
                                    // $desc = $description->getValue();

                                    // if (!empty(var)) {
                                    //     # code...
                                    // }

                                    $var = $tgl_kebutuhan->getValue();

                                    if (!empty($var)) {
                                        $stringDate = \PHPExcel_Style_NumberFormat::toFormattedString($var , 'YYYY-MM-DD');
                                        $date = str_replace('/', '-', $stringDate);
                                        $dt = date('Y-m-d', strtotime($date));
                                    }else{
                                        $dt = NULL;
                                    }
                                   
                                   
                                    $data = array(
                                            'mr_id' => $id_mr,
                                            'id_m_project' => $id_project,
                                            'type_equipment' => 2,
                                            'description'          => $description->getValue(),
                                            'size'            => $size->getValue(),
                                            'quantity'                     => $qty->getValue(),
                                            'unit'                   => $unit->getValue(),
                                            'desc_detail'                   => $spec->getValue(),
                                            'lokasi_station'                     => $lokasi->getValue(),
                                            'tgl_butuh'            => $dt,
                                            'unit_cost'                   => $price->getValue(),
                                            'currency'                  => $currency->getValue(),
                                            'total_cost'                    => $total,
                                            'remarks'                    => $remarks->getValue(),
                                            'id_kota' => $data_project->id_kota,
                                            'no_rak' => $no_rak->getValue(),
                                            
                                        );

                                     $this->db->insert('mr_equipment', $data);
                                }
                            }

                                 $this->set_workflow($id_project,$id_mr);

                                 $param_id_workflow = 'PRO-MR-01';
                                 $flow_order = 1;

                                 if ($tptransaksi == 1) {

                                        $datakodeho = [
                                                'kode_unik_ho' => $kode_unik_ho,
                                                'id_mr' => $id_mr,
                                                'id_project' => $id_project,
                                                'tahun' => date('y'),
                                        ];

                                        $this->db->insert('kode_unik_ho', $datakodeho);
                                    }

                                // $this->send_email_approve($id_project, $id_mr, $param_id_workflow, $flow_order);

                                $message = ['type' => 'info', 'message' => 'Data Berhasil Di update'];

                                // echo json_encode(array('message' => 'Proses Berhasil'));
                            }else{
                                $message = ['error' => true, 'message' => 'Terjadi Kesalahan <br> TGL Kebutuhan Tidak Boleh Kosong', 'callback' => $this->form_validation->get_errors_array()];
                            }

                              echo json_encode($message);

                           
        }

    }



}



