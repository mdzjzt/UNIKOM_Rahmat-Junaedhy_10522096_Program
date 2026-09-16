<?php

class vendor extends MX_Controller {

    private $_class_name = '';
    private $_title = 'Vendor';
    private $_module = 'home';

    public function __construct() {
        parent::__construct();

        # Protection
        hprotection::login();

        $this->laccess->check();
        $this->laccess->otoritas('view', TRUE);


        $this->_class_name = get_class($this);
        $this->_module .= '/' . $this->_class_name;
       
        $this->load->model('vendor_model');
        // $this->load->model('project_model');

         $this->load->model('provinsi_model');
         $this->load->model('kotamadya_model');
         $this->load->model('bidang_jenis_model');
        // $this->load->model('pegawai_model');
        // $this->load->model('user_model');
         $this->load->model('bank_model');
        // $this->load->model('permintaan_sp_model');
        //  $this->load->model('project_all_model');

        //$this->load->model('spk_model');
    }

    public function index($id = NULL) {
        if (hprotection::must_ajax($this->_module)) {
            $data['page_title'] = 'Master ' . $this->_title;
            $data['_modul'] = $this->_module;
            $data['_title'] = $this->_title;
            $data['data_daftar_rekanan'] = $this->vendor_model->data_daftar_rekanan()->get()->row();
            $this->load->view($this->_module . '/index', $data);
        }
    }

    public function load() {

        if (hprotection::must_ajax($this->_module)) {

            # Data Table
            // $limit = $this->input->post('length');
            // $offset = $this->input->post('start');
            // $draw = $this->input->post('draw');
            // $extra_search = $this->input->post('extra_search');
            // $data_cond = hgenerator::seriliaze_decode($extra_search);

            # Init
            // var_dump($this->input->post('keyword'));
            // exit();
            $limit  = $this->input->post('length');
            $offset = $this->input->post('start');
            $draw   = $this->input->post('draw');
            $extraColumn = $this->input->post('columns');
            $extraOrder  = $this->input->post('order');

            # Ordering
            $orderBy   = 'a.nama_perusahaan';
            $direction = "asc";

            if($extraColumn[$extraOrder[0]['column']]['orderable'] == 'true') {
                $orderBy = isset($extraColumn[$extraOrder[0]['column']]['name']) ? $extraColumn[$extraOrder[0]['column']]['name'] : NULL;
                $direction   = $extraOrder[0]['dir'];
            }

            # Condition 
            $cond = array();
            
            if (!empty($this->input->post('keyword'))) {
                $cond["(a.nama_perusahaan ILIKE '%{$this->input->post('keyword')}%' OR a.nama_pimpinan ILIKE '%{$this->input->post('keyword')}%')"] = NULL;
            }
            if (!empty($this->input->post('contact_person'))) {
                $cond["(a.contact_person ILIKE '%{$this->input->post('contact_person')}%')"] = NULL;
            }
             if (!empty($this->input->post('sub_category'))) {
                $cond["(a.sub_category ILIKE '%{$this->input->post('sub_category')}%')"] = NULL;
            }

            // $data_count = $this->vendor_model->data($cond)->count_all_results();
            // $data_result = $this->vendor_model->data($cond, 'id', 'asc', $limit, $offset)->get();

            // var_dump($cond);
            // exit();


            $dataCount          = $this->vendor_model->data_search($cond)->count_all_results();
            $dataCountFiltered  = $this->vendor_model->data_search($cond)->count_all_results();
            $dataResult         = $this->vendor_model->data_search($cond, $orderBy, $direction, $limit, $offset)->get();

            $rows = array();
            $no = $offset;

            foreach ($dataResult->result() as $value) {

                $id = $value->id;
		
        		// $rekanan = 0;
        		// $datetime1 = new DateTime($value->akte_notaris_kadaluarsa.' 07:08:00');
        		// $datetime2 = new DateTime();
        		// $interval = $datetime1->diff($datetime2);
        		// if ((int)$interval->format('%R%a') > 0){
        		// 	$date_akte_notaris_kadaluarsa = '<span class="alert-danger" >Expire</span>';
        		// 	$rekanan  = 0;
        		// }else{
        		// 	$rekanan  = 1;
        		// 	$date_akte_notaris_kadaluarsa = '<span class="alert-info" >Active</span>';
        		// };
		
        		// $datetime_siup_kadaluarsa = new DateTime($value->siup_kadaluarsa.' 07:08:00');
        		// $interval = $datetime_siup_kadaluarsa->diff($datetime2);
        		// if ((int)$interval->format('%R%a') > 0){
        		// 	$datesiup_kadaluarsa = '<span class="alert-danger" >Expire</span>';
        		// 	$rekanan  = 0;
        		// }else{
        		// 	$datesiup_kadaluarsa = '<span class="alert-info" >Active</span>';
        		// 	if ($rekanan  == 1){
        		// 		$rekanan  = 1;
        		// 	}
        		// };
		
        		// $json_situ = json_decode($value->situ, true);
        		// $input_time_situ = new DateTime($json_situ[0]['tgl_kadaluarsa']);
        		// $interval2 = $input_time_situ->diff($datetime2);
        		// if ((int)$interval2->format('%R%a') > 0){
        		// 	$date_situ = '<span class="alert-danger" >Expire</span>';
        		// 	$rekanan  = 0;
        		// }else{
        		// 	$date_situ = '<span class="alert-info" >Active</span>';
        		// 	if ($rekanan  == 1){
        		// 		$rekanan  = 1;
        		// 	}
        		// };
		
        		// $json_idp = json_decode($value->idp, true);
        		// $input_time_idp = new DateTime($json_idp[0]['tgl_kadaluarsa']);
        		// $interval3 = $input_time_idp->diff($datetime2);
        		// if ((int)$interval3->format('%R%a') > 0){
        		// 	$date_idp = '<span class="alert-danger" >Expire</span>';
        		// 	$rekanan  = 0;
        		// }else{
        		// 	$date_idp = '<span class="alert-info" >Active</span>';
        		// 	if ($rekanan  == 1){
        		// 		$rekanan  = 1;
        		// 	}
        		// };
		
                $action = '';

                if ($this->laccess->otoritas('edit')) {
                    $action .= anchor(NULL, '<i class="fa fa-edit"></i>', array(
                        'id' => 'mybutton-edit-' . $id,
                        'class' => 'btn btn-warning btn-xs margin-right-2',
                        'onclick' => 'my_form.open(this.id)',
                        'data-module' => $this->_module,
                        'data-url' => $this->_module . '/edit/' . $id,
                        'rel' => 'tooltip',
                        'data-placement' => "top",
                        'title' => 'Edit',
                    ));
                }


                if ($this->laccess->otoritas('delete')) {
                    $action .= anchor(NULL, '<i class="fa fa-trash-o"></i></a>', array(
                        'class' => 'btn btn-danger btn-xs margin-right-2',
                        'id' => 'mybutton-delete-' . $id,
                        'onclick' => 'my_data_table.row_action.ajax(this.id)',
                        'data-url' => base_url() . $this->_module . '/delete/' . $id,
                        'rel' => 'tooltip',
                        'data-placement' => "top",
                        'title' => 'Delete',
                    ));
                }
                //Barcode
                //if ($this->laccess->otoritas('edit')) {
                $action .= anchor($this->_module . '/blacklist/' . $id, '<i class="fa fa-list-alt"></i></a>', array(
                    'class' => 'btn btn-warning btn-xs margin-right-2',
                    'id' => 'mybutton-edit-' . $id,
                    'data-module' => $this->_module,
                    'data-toggle' => "modal",
                    'data-target' => "#remoteModalBar",
                    'data-keyboard' => "false",
                    'data-backdrop' => "static",
                    'rel' => 'tooltip',
                    'data-placement' => "top",
                    'title' => 'Black List',
                ));

                   $action .= anchor($this->_module . '/detail_evaluation/' . $id, '<i class="fa fa-book"></i></a>', array(
                        'data-module' =>  $this->_module,
                         'class' => 'btn btn-info btn-xs margin-right-2',
                        'data-toggle' => "modal",
                        'data-target' => "#modalDetailevaluated",
                        'data-keyboard' => "false",
                        'data-backdrop' => "static",
                        'rel' => 'tooltip',
                        'data-placement' => 'top',
                        'title' => 'Vendor Evaluation',
                    ));
                
                //if (!empty($value->dok_siup) && !empty($value->dok_idp) && !empty($value->dok_situ) AND $value->dok_idp !== '[]' AND $value->dok_situ !== '[]' AND $value->dok_siup !== '[]' ){
                //        $action .= '<span class="btn btn-warning btn-xs margin-right-2"><a href="' . base_url() . 'home/vendor/topdf/' . $id . '" rel="tooltip" title="Download PDF" target="_blank"><i class="fa fa-file-pdf-o"></i></a></span>';
                //}
			
        		// if ($value->status == 'tidak' && $rekanan  == 1){
        		// 	$cond2 = [];
        		// 	$cond2["(a.id_vendor = '{$id}') "] = NULL;
        		// 	if ($this->vendor_model->data_daftar_rekanan($cond2)->get()->num_rows() > 0){
        		// 		$action .= '<span class="btn btn-warning btn-xs margin-right-2"><a href="' . base_url() . 'home/vendor/topdf_daftar_rekanan/' . $id . '" rel="tooltip" title="Download PDF REKANAN" target="_blank"><i class="fa fa-file-pdf-o"></i></a></span>';
        		// 	}
        		// }
		
                //}
                $no++;
                $rows[] = array(
                    hgenerator::columns_align($no, 'center'),
                    anchor($this->_module . '/detail/' . $id, strtoupper(''.$value->nama_perusahaan.' .'.$value->jenis.''), array(
                        'data-module' => $this->_module,
                        'data-toggle' => "modal",
                        'data-target' => "#modalDetail",
                        'data-keyboard' => "false",
                        'data-backdrop' => "static",
                        'rel' => 'tooltip',
                        'data-placement' => 'top',
                        'title' => 'Detail',
                    )),
                   strtoupper($value->ranking) ,
                    $value->alamat,
                    $value->contact_person,
                    'Tlp : '.$value->no_telpon.' <br> HP : '.$value->hp.' ' ,
                    $value->email,
                    $value->sub_category,
                    $value->username_user,
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
    
    public function create_daftar_rekanan($id = '') {
        if ($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {
            if (hprotection::must_ajax($this->_module . '/add')) {

                //Bidang 
                $data['qvendor'] = $this->project_model->vendor();

                $data['page_title'] = 'Create Daftar Rekanan' . $this->_title;
                $data['_modul'] = $this->_module;
                $data['form_action'] = $this->_module . '/gerate_daftar_rekanan';
                $data['pegawai_options'] = $this->pegawai_model->options();
		
                # Cek data edit
                $data['edit_id'] = $id;
                if ($id != '') {
                    $data['page_title'] = 'Edit ' . $this->_title;
                    $data_edit = $this->project_model->data($id)->get();
                    if ($data_edit->num_rows() > 0) {
                        $row = $data_edit->row();
                        $data['data_edit'] = $row;
                    }
                }

                $this->load->view($this->_module . '/form_daftar_rekanan', $data);
            }
        } else {
            echo Modules::run('template/error_message/error_forbidden');
        }
    }
    
    public function gerate_daftar_rekanan($id = NULL) {

        # Condition
        $data['tgl_laporan'] = hgenerator::switch_tanggal($this->input->post('tgl_laporan'));
        $data['sampai_tgl_laporan'] = $this->input->post('sampai_tgl_laporan');
        $data['pegawai_id'] = $this->input->post('listkaryawan');

        $datavendor = $this->vendor_model->data()->get()->result();
        $this->vendor_model->delete_daftar_rekanan();
        $no = 1;

	    $message = array('error', 'Error!', 'Terjadi error pada saat penyimpanan, silahkan coba lagi.', '');
	   
       foreach($datavendor as $dt){

		$rekanan = 0;
		$datetime1 = new DateTime($dt->akte_notaris_kadaluarsa.' 07:08:00');
		$datetime2 = new DateTime();
		$interval = $datetime1->diff($datetime2);
		if ((int)$interval->format('%R%a') > 0){
			$rekanan  = 0;
		}else{
			$rekanan  = 1;
		};
		
		$datetime_siup_kadaluarsa = new DateTime($dt->siup_kadaluarsa.' 07:08:00');
		$interval = $datetime_siup_kadaluarsa->diff($datetime2);
		if ((int)$interval->format('%R%a') > 0){
			$rekanan  = 0;
		}else{
			if ($rekanan  == 1){
				$rekanan  = 1;
			}
		};
		
		$json_situ = json_decode($dt->situ, true);
		$input_time_situ = new DateTime($json_situ[0]['tgl_kadaluarsa']);
		$interval2 = $input_time_situ->diff($datetime2);
		if ((int)$interval2->format('%R%a') > 0){
			$rekanan  = 0;
		}else{
			if ($rekanan  == 1){
				$rekanan  = 1;
			}
		};
		
		$json_idp = json_decode($dt->idp, true);
		$input_time_idp = new DateTime($json_idp[0]['tgl_kadaluarsa']);
		$interval3 = $input_time_idp->diff($datetime2);
		if ((int)$interval3->format('%R%a') > 0){
			$rekanan  = 0;
		}else{
			if ($rekanan  == 1){
				$rekanan  = 1;
			}
		};
		
            if ($dt->status == 'tidak' && $rekanan  == 1){
			$data['id_vendor'] = $dt->id;
			$data['nomor'] = $no++.'/TDR/DIVISIUMUM/'.date('Y');
			if ($this->vendor_model->create_daftar_rekanan($data)) {
				$message = array(true, 'Proses berhasil', 'Data berhasil disimpan.', '__after_process(1)');
			} else {
				$message = array('error', 'Error!', 'Terjadi error pada saat penyimpanan, silahkan coba lagi.', '');
			}
                }	
	}
	   echo json_encode($message);
    }
    
    public function topdf_daftar_rekanan($id = NULL) {
    
        # Condition
        $cond = array();
        $data['edit_id'] = $id;
        $cond["(a.id = '{$id}') "] = NULL;
        $cond2["(a.id_vendor = '{$id}') "] = NULL;

        if ($this->vendor_model->data($cond)->count_all_results() > 0) {


            $data['page_title'] = 'Ubah ' . $this->_title;
            $data_edit = $this->vendor_model->data($cond)->get();
            $get_data_daftar_rekanan = $this->vendor_model->data_daftar_rekanan($cond2)->get();
            $row = $data_edit->row();
            $get_row_data_daftar_rekanan = $get_data_daftar_rekanan->row();
	    
		if ($get_row_data_daftar_rekanan->nomor){
			$data['page_title']  = 'TANDA DAFTAR REKANAN <br /> BANK PEMBANGUNAN DAERAH KALIMANTAN TIMUR <br />NOMOR : '.$get_row_data_daftar_rekanan->nomor;
		}
		
		$data['id'] = $id;
		$data['edit_id'] = $id;
		$data['nomor'] = $get_row_data_daftar_rekanan->nomor;
		$data['data'] = $row;
		$data['get_data_daftar_rekanan']        = $get_row_data_daftar_rekanan;
		$data['_modul'] = $this->_module;
		$data['form_action'] = $this->_module .'/proses_persetujuan/'.$id;
		
                $data['option_bidang'] = $this->vendor_model->options_jenis_usaha(array(), array());
                $data['option_sub_bidang'] = $this->bidang_jenis_model->options(array(), array());
		
		$id_pegawai = $get_row_data_daftar_rekanan->pegawai_id;
		$conPeg["(a.pegawai_id = '{$id_pegawai}') "] = NULL;
		$data['listpegawai'] = $this->pegawai_model->data($conPeg)->get()->row();
		

		$html = $this->load->view($this->_module . '/surat' , $data, true);

        $this->load->library('zend');
        $this->zend->load('Zend/Barcode');

        $path = 'uploads/barcode/vendor/';
        if(!file_exists($path)) mkdir($path,0777,TRUE);

        $barcode = $get_row_data_daftar_rekanan->nomor;
        $test    = Zend_Barcode::draw('code128', 'image', array('text' => $barcode), array());
        imagejpeg($test, $path.'NO-'.$get_row_data_daftar_rekanan->id_vendor.'.jpg', 100);
        


        $this->load->library('mpdf');

        $mpdf= new mPDF('','', 0, '', 20, 25, 28, 23, 9, 9, 'L');
        $mpdf->WriteHTML($html);
        $mpdf->Output();
	
	
        } else {
            echo Modules::run('template/error_message/error_404');
        }
    }
    
    public function load_project($id){

        if (hprotection::must_ajax($this->_module)) {

            # Data Table
            $limit = $this->input->post('length');
            $offset = $this->input->post('start');
            $draw = $this->input->post('draw');
            $extra_search = $this->input->post('extra_search');
            $data_cond = hgenerator::seriliaze_decode($extra_search);

            # Condition 
            $cond = array();
            $cond["(a.vendor_id = '{$id}') "] = NULL;
            
            $data_count = $this->project_model->data_project($cond)->count_all_results();
            $data_result = $this->project_model->data_project($cond, 'vendor_id', 'asc', $limit, $offset)->get();

            $rows = array();
            $no = $offset;

            foreach ($data_result->result() as $value) {
				$data['vote'] = $value->nilai;
				$no++;
                $rows[] = array(
                    hgenerator::columns_align($no, 'center'),
                    $value->nama_perusahaan,
                    date('Y-m-d',strtotime($value->sp_tanggal)),
                    $value->sp_nota,
                    $value->sp_name,
                    $value->nilai,
                );
            }

            $data = array(
                "draw" => $draw,
                "recordsTotal" => $data_count,
                "recordsFiltered" => $data_count,
                "data" => $rows
            );

            echo json_encode($data);
        }

    }
		
	public function blacklist($id = '') {
        if ($this->vendor_model->data($id)->count_all_results() > 0) {
            $data['page_title'] = 'Black list ' . $this->_title;
            $data['_modul'] = $this->_module;
            $data['blacklistdata'] =  $this->vendor_model->datablacklist()->get()->result();
            $data['id_blacklist'] =  $this->vendor_model->get_blacklist_id();
            $data['form_action'] = $this->_module . '/proses_blacklist';

            $data['edit_id'] = $id;
            if ($id != '') {
                $data['page_title'] = 'Black list ' . $this->_title;
                $data_edit = $this->vendor_model->data($id)->get();
                if ($data_edit->num_rows() > 0) {
                    $row = $data_edit->row();
                    $data['data_edit'] = $row;
                }
            }
            $this->load->view($this->_module . '/form_blacklist', $data);
        } else {
            echo Modules::run('template/error_message/error_404');
        }
    }
	
	public function row_blacklist($id = '',$id_blacklist = '') 
    {
    	if ($this->vendor_model->detail_blacklist(['a.id_blacklist' => $id_blacklist])->count_all_results() > 0) {
            $data['id'] =  $id;
            $data['id_blacklist'] =  $id_blacklist;
            $data['blacklistdata'] =  $this->vendor_model->detail_blacklist(['a.id_blacklist' => $id_blacklist])->get();
            $this->load->view($this->_module . '/row-specification', $data);
        } else {
            echo Modules::run('template/error_message/error_404');
        }
    }
	
	// public function load_blacklist($id) {

        // if (hprotection::must_ajax($this->_module)) {

            // # Data Table
            // $limit = $this->input->post('length');
            // $offset = $this->input->post('start');
            // $draw = $this->input->post('draw');
            // $extra_search = $this->input->post('extra_search');
            // $data_cond = hgenerator::seriliaze_decode($extra_search);

            // # Condition 
            // $cond = array();
            // $cond["(a.id = '{$id}') "] = NULL;
            
            // $data_count = $this->vendor_model->data_blacklist($cond)->count_all_results();
            // $data_result = $this->vendor_model->data_blacklist($cond, 'id', 'asc', $limit, $offset)->get();

            // $rows = array();
            // $no = $offset;

            // foreach ($data_result->result() as $value) {

                // $id = $value->id;
		
        		// $rekanan = 0;
        		
		
                // $action = '';
				// $no++;
                // $rows[] = array(
                    // hgenerator::columns_align($no, 'center'),
                    // anchor($this->_module . '/detailblacklist/' . $id, $value->nama_perusahaan, array(
                        // 'data-module' => $this->_module,
                        // 'data-toggle' => "modal",
                        // 'data-target' => "#modalDetailBlacklist",
                        // 'data-keyboard' => "false",
                        // 'data-backdrop' => "static",
                        // 'rel' => 'tooltip',
                        // 'data-placement' => 'top',
                        // 'title' => 'Detail',
                    // )),
                    // $value->tgl_blacklist,
                    // $value->tgl_akhir_blacklist,
                // );
            // }

            // $data = array(
                // "draw" => $draw,
                // "recordsTotal" => $data_count,
                // "recordsFiltered" => $data_count,
                // "data" => $rows
            // );

            // echo json_encode($data);
        // }
    // }

    public function proses_blacklist() {
        $id_blacklist = $this->input->post('id_blacklist');
        $alasan       = $this->input->post('alasan');
        $date         = new DateTime();
        $tanggal      = $date->format('Y-m-d');

        if (hprotection::must_ajax($this->_module . '/404')) {
            $this->form_validation->set_rules('status', '<i class="fa fa-warning"> Status</i>', 'trim|required');

            /* form validasi */
            $id = $this->input->post('edit_id');

            /* end */

            if ($this->form_validation->run($this)) {
                $message = array('error', 'Error!', 'Terjadi error pada saat penyimpanan, silahkan coba lagi.', '');

                $data = array(
                    'status' => $this->input->post('status'),
                    'tgl_blacklist' => $this->input->post('tgl_blacklist'),
                    'alasan' => "",
                );
				
				$blacklist = array(
                    'tgl_blacklist' => $tanggal,
					'tgl_akhir_blacklist' => date('Y-m-d', strtotime($this->input->post('tgl_blacklist'))),                    
                );
				
				if (!empty($id)) {
					$this->vendor_model->create_blacklist($blacklist);
						$jsonDecode = explode("&", $alasan);

                        if (!empty($alasan)) {
    						foreach($jsonDecode as $index => $dt):
    							$detail_blacklist = array(
    								'id_blacklist' => $id_blacklist,
    								'id_vendor' => $id,
    								'id_alasan' => $dt,
    							);
    						$this->vendor_model->create_detail_blacklist($detail_blacklist);
    						endforeach;
                        }
					if ($this->vendor_model->update($id, $data)) {
                        $message = array(true, 'Proses berhasil', 'Data berhasil diupdate.', '__after_process(2)');
                    }
                }
            } else {
                $message = array(false, 'Proses gagal', $this->form_validation->get_errors_array(), '');
            }

            echo json_encode($message);
        }
    }

    public function proses_evaluated($id) {
        
        // var_dump($_POST);
        // exit();

        if (hprotection::must_ajax($this->_module . '/404')) {
            $this->form_validation->set_rules('specification', '<i class="fa fa-warning"> specification</i>', 'trim|required');
            $this->form_validation->set_rules('on_time', '<i class="fa fa-warning"> specification</i>', 'trim|required');
            $this->form_validation->set_rules('competitive_price', '<i class="fa fa-warning"> specification</i>', 'trim|required');
            $this->form_validation->set_rules('term_pay', '<i class="fa fa-warning"> specification</i>', 'trim|required');
            $this->form_validation->set_rules('communication', '<i class="fa fa-warning"> specification</i>', 'trim|required');
            $this->form_validation->set_rules('smkl', '<i class="fa fa-warning"> specification</i>', 'trim|required');
            $this->form_validation->set_rules('no_proyek', '<i class="fa fa-warning"> Kode Project</i>', 'trim|required');
            


            /* form validasi */
           

            /* end */

            if ($this->form_validation->run($this)) {
                $message = array('error', 'Error!', 'Terjadi error pada saat penyimpanan, silahkan coba lagi.', '');

                $data = array(
                    'specification' => $this->input->post('specification'),
                    'on_time' => $this->input->post('on_time'),
                    'competitive_price' => $this->input->post('competitive_price'),
                    'term_pay' => $this->input->post('term_pay'),
                    'communication' => $this->input->post('communication'),
                    'documentation' => $this->input->post('documentation'),
                    'smkl' => $this->input->post('smkl'),
                    'hasil' => $this->input->post('total'),
                    'ranking' => $this->input->post('ranking'),
                    'evaluate_by' => $this->session->userdata('id_user'),
                    'notes' => $this->input->post('notes'),
                    
                );
                
                $evalua = array(
                    'id_vendor' => $id,
                    'date_create' => date('Y-m-d H:i:s'),
                    'create_by' =>  $this->session->userdata('id_user'),
                    'notes' => $this->input->post('notes'),
                    'specification' => $this->input->post('specification'),
                    'on_time' => $this->input->post('on_time'),
                    'competitive_price' => $this->input->post('competitive_price'),
                    'term_pay' => $this->input->post('term_pay'),
                    'communication' => $this->input->post('communication'),
                    'documentation' => $this->input->post('documentation'),
                    'smkl' => $this->input->post('smkl'),
                    'hasil' => $this->input->post('total'),
                    'ranking' => $this->input->post('ranking'),
                    'kode_project'=> $this->input->post('no_proyek'),
                                   
                );
                 $this->vendor_model->create_evaluated($evalua);
                if (!empty($id)) {
                    if ($this->vendor_model->update($id, $data)) {
                        $message = array(true, 'Proses berhasil', 'Data berhasil diupdate.', '__after_process(2)');
                    }
                }
            } else {
                $message = array(false, 'Proses gagal', $this->form_validation->get_errors_array(), '');
            }

            echo json_encode($message);
        }
    }

    public function add($id = '') {
        if ($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {
            if (hprotection::must_ajax($this->_module . '/add')) {

                $data['page_title'] = 'Tambah ' . $this->_title;
                $data['_modul'] = $this->_module;
                $data['form_action'] = $this->_module . '/proses';
                //$data['form_action'] = base_url().'vendor/post_test';
                # Cek data edit
                $data['edit_id'] = $id;

                $data['option_bidang'] = $this->vendor_model->options_jenis_usaha(array(), array('' => '--Pilih--'));
                $data['option_sub_bidang'] = $this->bidang_jenis_model->options(array(), array('' => '--Pilih--'));

                # options provinsi
                $data['provinsi'] = $this->provinsi_model->optionsall(array(), array('' => '--Pilih--'));

                $data['bank'] = $this->bank_model->options(array(), array('' => '--Pilih--'));
                #options kotamadya
                $cond = array();
                $data['kotamadya'] = $this->kotamadya_model->optionsall($cond, array('' => '--Pilih--'));


                if ($id != '') {
                    $data['page_title'] = 'Edit ' . $this->_title;
                    $data_edit = $this->vendor_model->data($id)->get();
                    if ($data_edit->num_rows() > 0) {
                        $row = $data_edit->row();

                        $jenis = $data_edit->row()->jenis;

                        #Decode Data
                        $idp = $data_edit->row()->idp;
                        $decode_idp = json_decode($idp, true);

                        $situ = $data_edit->row()->situ;
                        $decode_situ = json_decode($situ, true);

                        $dokumen = $data_edit->row()->dokumen;
                        $decode_dokumen = json_decode($dokumen, true);

                        $direksi = $data_edit->row()->direksi;
                        $decode_direksi = json_decode($direksi);

                        $saham = $data_edit->row()->saham;
                        $decode_saham = json_decode($saham);
			
                        $kantor_cabang = $data_edit->row()->kantor_cabang;
                        $decode_kantor_cabang = json_decode($kantor_cabang);
			
                        $bidang = $data_edit->row()->bidang;
                        $decode_bidang = json_decode($bidang);
			
                        $bidangsub = $data_edit->row()->bidangsub;
                        $decode_bidangsub = json_decode($bidangsub);

                        $data['decode_idp'] = $decode_idp;
                        $data['decode_situ'] = $decode_situ;
                        $data['decode_dokumen'] = $decode_dokumen;
                        $data['decode_direksi'] = $decode_direksi;
                        $data['decode_saham'] = $decode_saham;
                        $data['decode_kantor_cabang'] = $decode_kantor_cabang;
                        $data['decode_bidang'] = $decode_bidang;
                        $data['decode_bidangsub'] = $decode_bidangsub;

                        $data['jenis'] = $jenis;
                        $data['data_edit'] = $row;
                    }
                }

                $this->load->view($this->_module . '/form', $data);
            }
        } else {
            echo Modules::run('template/error_message/error_forbidden');
        }
    }

    public function proses() {
    
        if ($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {
            if (hprotection::must_ajax($this->_module . '/404')) {

                // var_dump($this->session->userdata('id_user'));
                // exit();


                // $this->form_validation->set_rules('nama_perusahaan', '<i class="fa fa-warning"> Nama Perusahaan</i>', 'trim|required|callback_no_duplication');
                
                //  $this->form_validation->set_rules('sub_category', '<i class="fa fa-warning"> Sub Category</i>', 'trim|required|callback_no_duplication');


                $this->form_validation->set_rules('nama_perusahaan', '<i class="fa fa-warning"> Nama Perusahaan</i>', 'trim|required');
                
                 $this->form_validation->set_rules('sub_category', '<i class="fa fa-warning"> Sub Category</i>', 'trim|required');
                
                
                // $this->form_validation->set_rules('npwp', '<i class="fa fa-warning"> NPWP</i>', 'trim|required');
                // $this->form_validation->set_rules('alamat', '<i class="fa fa-warning"> Alamat</i>', 'trim|required');
                $this->form_validation->set_rules('contact_person', '<i class="fa fa-warning"> Contac Person</i>', 'trim|required');
                 if ($this->input->post('jenis_perusahaan') == 1) {
                     $this->form_validation->set_rules('npwp', '<i class="fa fa-warning">NPWP</i>', 'trim|required');
                 }else{
                    $this->form_validation->set_rules('npwp', '<i class="fa fa-warning">NPWP</i>', 'trim|required');
                    $this->form_validation->set_rules('nik_vendor', '<i class="fa fa-warning">NIK Vendor</i>', 'trim|required');
                 }
                // $this->form_validation->set_rules('email', '<i class="fa fa-warning"> Email</i>', 'trim|required|valid_email');

                /*$this->form_validation->set_rules('provinsi_id', '<i class="fa fa-warning"> Provinsi</i>', 'trim|required');
                $this->form_validation->set_rules('kotamadya_id', '<i class="fa fa-warning"> Kota</i>', 'trim|required');
*/
                /* form validasi */
                $id = $this->input->post('edit_id');
                // $filter_unix = trim($this->input->post('nama_perusahaan'));


             /*   if (!empty($filter_unix)) {
                    $filter_unix = $this->vendor_model->is_exist($filter_unix);
                    if (!$id && $filter_unix > 0) {
                        $this->form_validation->set_rules('nama_perusahaan', '<i class="fa fa-warning"> Nama Perusahaan</i>', 'is_exist');
                    } else {
                        $this->form_validation->set_rules('nama_perusahaan', '<i class="fa fa-warning"> Nama Perusahaan</i>', 'trim|required');
                    }
                } elseif (empty($filter_unix) or $filter_unix == 0) {
                    $this->form_validation->set_rules('nama_perusahaan', '<i class="fa fa-warning"> Nama Perusahaan</i>', 'trim|required');
                }*/
                /* end */

                if ($this->form_validation->run($this)) {
                    // var_dump($_POST);
                    // exit();
                    $message = array('error', 'Error!', 'Terjadi error pada saat penyimpanan, silahkan coba lagi.', '');
		    
                    #AKTE NOTARIS
                    if ($this->input->post('dokumen_deskripsi_akte_notaris')) {

                        $path = './uploads/vendor/';
                        $number_of_files = 0;

                        if (!file_exists($path))
                            mkdir($path, 0, TRUE);
                        if (!empty($_FILES['dokumen_file_akte_notaris'])):
                            $files = $_FILES['dokumen_file_akte_notaris'];
                            $number_of_files = sizeof($files['name']);
                        endif;

                        $dokumen_akte_notaris = array();
                        $this->load->library('upload');

                        $config = array(
                            'upload_path' => $path,
                            'allowed_types' => 'pdf|jpg|png|docx|doc|xlsx|xls',
                        );
                        $this->upload->initialize($config);

                        $i = 0;
                        foreach ($this->input->post('dokumen_deskripsi_akte_notaris') as $key => $value):

                            if (!empty($this->input->post('dokumen_path_akte_notaris')[$key])):
                                $dokumen_akte_notaris[] = array(
                                    'deskripsi' => $this->input->post('dokumen_deskripsi_akte_notaris')[$key],
                                    'file' => $this->input->post('dokumen_path_akte_notaris')[$key],
                                    'filename' => $this->input->post('dokumen_name_akte_notaris')[$key],
                                );
                            else:

                                if ($number_of_files > $i):

                                    $_FILES['dokumen']['name'] = $files['name'][$i];
                                    $_FILES['dokumen']['type'] = $files['type'][$i];
                                    $_FILES['dokumen']['tmp_name'] = $files['tmp_name'][$i];
                                    $_FILES['dokumen']['error'] = $files['error'][$i];
                                    $_FILES['dokumen']['size'] = $files['size'][$i];

                                    if ($this->upload->do_upload('dokumen')):
                                        $data_upload = $this->upload->data();
                                        $dokumen_akte_notaris[] = array(
                                            'deskripsi' => $this->input->post('dokumen_deskripsi_akte_notaris')[$key],
                                            'file' => $config['upload_path'] . $data_upload['file_name'],
                                            'filename' => $data_upload['file_name'],
                                        );
                                    else:
                                        echo $this->upload->display_errors();
                                    endif;
                                endif;
                                $i++;
                            endif;

                        endforeach;
                    }
		    
                    #SIUP
                    if ($this->input->post('dokumen_deskripsi_siup')) {

                        $path = './uploads/vendor/';
                        $number_of_files = 0;

                        if (!file_exists($path))
                            mkdir($path, 0, TRUE);
                        if (!empty($_FILES['dokumen_file_siup'])):
                            $files = $_FILES['dokumen_file_siup'];
                            $number_of_files = sizeof($files['name']);
                        endif;

                        $dokumen_siup = array();
                        $this->load->library('upload');

                        $config = array(
                            'upload_path' => $path,
                            'allowed_types' => 'pdf|jpg|png|docx|doc|xlsx|xls',
                        );
                        $this->upload->initialize($config);

                        $i = 0;
                        foreach ($this->input->post('dokumen_deskripsi_siup') as $key => $value):

                            if (!empty($this->input->post('dokumen_path_siup')[$key])):
                                $dokumen_siup[] = array(
                                    'deskripsi' => $this->input->post('dokumen_deskripsi_siup')[$key],
                                    'file' => $this->input->post('dokumen_path_siup')[$key],
                                    'filename' => $this->input->post('dokumen_name_siup')[$key],
                                );
                            else:

                                if ($number_of_files > $i):

                                    $_FILES['dokumen']['name'] = $files['name'][$i];
                                    $_FILES['dokumen']['type'] = $files['type'][$i];
                                    $_FILES['dokumen']['tmp_name'] = $files['tmp_name'][$i];
                                    $_FILES['dokumen']['error'] = $files['error'][$i];
                                    $_FILES['dokumen']['size'] = $files['size'][$i];

                                    if ($this->upload->do_upload('dokumen')):
                                        $data_upload = $this->upload->data();
                                        $dokumen_siup[] = array(
                                            'deskripsi' => $this->input->post('dokumen_deskripsi_siup')[$key],
                                            'file' => $config['upload_path'] . $data_upload['file_name'],
                                            'filename' => $data_upload['file_name'],
                                        );
                                    else:
                                        echo $this->upload->display_errors();
                                    endif;
                                endif;
                                $i++;
                            endif;

                        endforeach;
                    }

                   #IDP
                    if ($this->input->post('dokumen_deskripsi_idp')) {

                        $path = './uploads/vendor/';
                        $number_of_files = 0;

                        if (!file_exists($path))
                            mkdir($path, 0, TRUE);
                        if (!empty($_FILES['dokumen_file_idp'])):
                            $files = $_FILES['dokumen_file_idp'];
                            $number_of_files = sizeof($files['name']);
                        endif;

                        $dokumen_idp = array();
                        $this->load->library('upload');

                        $config = array(
                            'upload_path' => $path,
                            'allowed_types' => 'pdf|jpg|png|docx|doc|xlsx|xls',
                        );
                        $this->upload->initialize($config);

                        $i = 0;
                        foreach ($this->input->post('dokumen_deskripsi_idp') as $key => $value):

                            if (!empty($this->input->post('dokumen_path_idp')[$key])):
                                $dokumen_idp[] = array(
                                    'deskripsi' => $this->input->post('dokumen_deskripsi_idp')[$key],
                                    'file' => $this->input->post('dokumen_path_idp')[$key],
                                    'filename' => $this->input->post('dokumen_name_idp')[$key],
                                );
                            else:

                                if ($number_of_files > $i):

                                    $_FILES['dokumen']['name'] = $files['name'][$i];
                                    $_FILES['dokumen']['type'] = $files['type'][$i];
                                    $_FILES['dokumen']['tmp_name'] = $files['tmp_name'][$i];
                                    $_FILES['dokumen']['error'] = $files['error'][$i];
                                    $_FILES['dokumen']['size'] = $files['size'][$i];

                                    if ($this->upload->do_upload('dokumen')):
                                        $data_upload = $this->upload->data();
                                        $dokumen_idp[] = array(
                                            'deskripsi' => $this->input->post('dokumen_deskripsi_idp')[$key],
                                            'file' => $config['upload_path'] . $data_upload['file_name'],
                                            'filename' => $data_upload['file_name'],
                                        );
                                    else:
                                        echo $this->upload->display_errors();
                                    endif;
                                endif;
                                $i++;
                            endif;

                        endforeach;
                    }

                    #SITU
                    if ($this->input->post('dokumen_deskripsi_situ')) {

                        $path = './uploads/vendor/';
                        $number_of_files = 0;

                        if (!file_exists($path))
                            mkdir($path, 0, TRUE);
                        if (!empty($_FILES['dokumen_file_situ'])):
                            $files = $_FILES['dokumen_file_situ'];
                            $number_of_files = sizeof($files['name']);
                        endif;

                        $dokumen_situ = array();
                        $this->load->library('upload');

                        $config = array(
                            'upload_path' => $path,
                            'allowed_types' => 'pdf|jpg|png|docx|doc|xlsx|xls',
                        );
                        $this->upload->initialize($config);

                        $i = 0;
                        foreach ($this->input->post('dokumen_deskripsi_situ') as $key => $value):

                            if (!empty($this->input->post('dokumen_path_situ')[$key])):
                                $dokumen_situ[] = array(
                                    'deskripsi' => $this->input->post('dokumen_deskripsi_situ')[$key],
                                    'file' => $this->input->post('dokumen_path_situ')[$key],
                                    'filename' => $this->input->post('dokumen_name_situ')[$key],
                                );
                            else:

                                if ($number_of_files > $i):

                                    $_FILES['dokumen']['name'] = $files['name'][$i];
                                    $_FILES['dokumen']['type'] = $files['type'][$i];
                                    $_FILES['dokumen']['tmp_name'] = $files['tmp_name'][$i];
                                    $_FILES['dokumen']['error'] = $files['error'][$i];
                                    $_FILES['dokumen']['size'] = $files['size'][$i];

                                    if ($this->upload->do_upload('dokumen')):
                                        $data_upload = $this->upload->data();
                                        $dokumen_situ[] = array(
                                            'deskripsi' => $this->input->post('dokumen_deskripsi_situ')[$key],
                                            'file' => $config['upload_path'] . $data_upload['file_name'],
                                            'filename' => $data_upload['file_name'],
                                        );
                                    else:
                                        echo $this->upload->display_errors();
                                    endif;
                                endif;
                                $i++;
                            endif;

                        endforeach;
                    }
                    
                    if ($this->input->post('dokumen_deskripsi_qhse')) {

                        //$path = $this->app_config->info('demand_doc_barang') . date('Y') . '/' . date('m') . '/';
                        $path = './uploads/vendor/'; 
                        $number_of_files = 0;

                        if (!file_exists($path))
                            mkdir($path, 0, TRUE);
                        if (!empty($_FILES['dokumen_file_qhse'])):
                            $files = $_FILES['dokumen_file_qhse'];
                            $number_of_files = sizeof($files['name']);
                        endif;

                        $dokumenqhse = array();
                        $this->load->library('upload');

                        $config = array(
                            'upload_path'   => $path,
                            'allowed_types' => 'pdf|jpg|png|docx|doc|xlsx|xls',
                        );
                        $this->upload->initialize($config);

                        $i = 0;
                        foreach ($this->input->post('dokumen_deskripsi_qhse') as $key => $value):

                            if (!empty($this->input->post('dokumen_path_qhse')[$key])):
                                $dokumenqhse[] = array(
                                    'deskripsi' => $this->input->post('dokumen_deskripsi_qhse')[$key],
                                    'file'      => $this->input->post('dokumen_path_qhse')[$key],
                                    'filename'  => $this->input->post('dokumen_name_qhse')[$key],
                                );
                            else:

                                if ($number_of_files > $i):

                                    $_FILES['dokumen']['name'] = $files['name'][$i];
                                    $_FILES['dokumen']['type'] = $files['type'][$i];
                                    $_FILES['dokumen']['tmp_name'] = $files['tmp_name'][$i];
                                    $_FILES['dokumen']['error'] = $files['error'][$i];
                                    $_FILES['dokumen']['size'] = $files['size'][$i];

                                    if ($this->upload->do_upload('dokumen')):
                                        $data_upload = $this->upload->data();
                                        $dokumenqhse[] = array(
                                            'deskripsi' => $this->input->post('dokumen_deskripsi_qhse')[$key],
                                            'file'      => $config['upload_path'] . $data_upload['file_name'],
                                            'filename'  => $data_upload['file_name'],
                                        );
                                    else:
                                        echo $this->upload->display_errors();
                                    endif;
                                endif;
                                $i++;
                            endif;

                        endforeach;
                    }

                    if ($this->input->post('dokumen_deskripsi_finance')) {

                        //$path = $this->app_config->info('demand_doc_barang') . date('Y') . '/' . date('m') . '/';
                        $path = './uploads/vendor/'; 
                        $number_of_files = 0;

                        if (!file_exists($path))
                            mkdir($path, 0, TRUE);
                        if (!empty($_FILES['dokumen_file_finance'])):
                            $files = $_FILES['dokumen_file_finance'];
                            $number_of_files = sizeof($files['name']);
                        endif;

                        $dokumen_finance = array();
                        $this->load->library('upload');

                        $config = array(
                            'upload_path'   => $path,
                            'allowed_types' => 'pdf|jpg|png|docx|doc|xlsx|xls',
                        );
                        $this->upload->initialize($config);

                        $i = 0;
                        foreach ($this->input->post('dokumen_deskripsi_finance') as $key => $value):

                            if (!empty($this->input->post('dokumen_path_finance')[$key])):
                                $dokumen_finance[] = array(
                                    'deskripsi' => $this->input->post('dokumen_deskripsi_finance')[$key],
                                    'file'      => $this->input->post('dokumen_path_finance')[$key],
                                    'filename'  => $this->input->post('dokumen_name_finance')[$key],
                                );
                            else:

                                if ($number_of_files > $i):

                                    $_FILES['dokumen']['name'] = $files['name'][$i];
                                    $_FILES['dokumen']['type'] = $files['type'][$i];
                                    $_FILES['dokumen']['tmp_name'] = $files['tmp_name'][$i];
                                    $_FILES['dokumen']['error'] = $files['error'][$i];
                                    $_FILES['dokumen']['size'] = $files['size'][$i];

                                    if ($this->upload->do_upload('dokumen')):
                                        $data_upload = $this->upload->data();
                                        $dokumen_finance[] = array(
                                            'deskripsi' => $this->input->post('dokumen_deskripsi_finance')[$key],
                                            'file'      => $config['upload_path'] . $data_upload['file_name'],
                                            'filename'  => $data_upload['file_name'],
                                        );
                                    else:
                                        echo $this->upload->display_errors();
                                    endif;
                                endif;
                                $i++;
                            endif;

                        endforeach;
                    }

                    if ($this->input->post('dokumen_deskripsi_legal')) {

                        //$path = $this->app_config->info('demand_doc_barang') . date('Y') . '/' . date('m') . '/';
                        $path = './uploads/vendor/'; 
                        $number_of_files = 0;

                        if (!file_exists($path))
                            mkdir($path, 0, TRUE);
                        if (!empty($_FILES['dokumen_file_legal'])):
                            $files = $_FILES['dokumen_file_legal'];
                            $number_of_files = sizeof($files['name']);
                        endif;

                        $dokumen_legal = array();
                        $this->load->library('upload');

                        $config = array(
                            'upload_path'   => $path,
                            'allowed_types' => 'pdf|jpg|png|docx|doc|xlsx|xls',
                        );
                        $this->upload->initialize($config);

                        $i = 0;
                        foreach ($this->input->post('dokumen_deskripsi_legal') as $key => $value):

                            if (!empty($this->input->post('dokumen_path_legal')[$key])):
                                $dokumen_legal[] = array(
                                    'deskripsi' => $this->input->post('dokumen_deskripsi_legal')[$key],
                                    'file'      => $this->input->post('dokumen_path_legal')[$key],
                                    'filename'  => $this->input->post('dokumen_name_legal')[$key],
                                );
                            else:

                                if ($number_of_files > $i):

                                    $_FILES['dokumen']['name'] = $files['name'][$i];
                                    $_FILES['dokumen']['type'] = $files['type'][$i];
                                    $_FILES['dokumen']['tmp_name'] = $files['tmp_name'][$i];
                                    $_FILES['dokumen']['error'] = $files['error'][$i];
                                    $_FILES['dokumen']['size'] = $files['size'][$i];

                                    if ($this->upload->do_upload('dokumen')):
                                        $data_upload = $this->upload->data();
                                        $dokumen_legal[] = array(
                                            'deskripsi' => $this->input->post('dokumen_deskripsi_legal')[$key],
                                            'file'      => $config['upload_path'] . $data_upload['file_name'],
                                            'filename'  => $data_upload['file_name'],
                                        );
                                    else:
                                        echo $this->upload->display_errors();
                                    endif;
                                endif;
                                $i++;
                            endif;

                        endforeach;
                    }

                     if ($this->input->post('dokumen_deskripsi_others')) {

                        //$path = $this->app_config->info('demand_doc_barang') . date('Y') . '/' . date('m') . '/';
                        $path = './uploads/vendor/'; 
                        $number_of_files = 0;

                        if (!file_exists($path))
                            mkdir($path, 0, TRUE);
                        if (!empty($_FILES['dokumen_file_others'])):
                            $files = $_FILES['dokumen_file_others'];
                            $number_of_files = sizeof($files['name']);
                        endif;

                        $dokumen_others = array();
                        $this->load->library('upload');

                        $config = array(
                            'upload_path'   => $path,
                            'allowed_types' => 'pdf|jpg|png|docx|doc|xlsx|xls',
                        );
                        $this->upload->initialize($config);

                        $i = 0;
                        foreach ($this->input->post('dokumen_deskripsi_others') as $key => $value):

                            if (!empty($this->input->post('dokumen_path_others')[$key])):
                                $dokumen_others[] = array(
                                    'deskripsi' => $this->input->post('dokumen_deskripsi_others')[$key],
                                    'file'      => $this->input->post('dokumen_path_others')[$key],
                                    'filename'  => $this->input->post('dokumen_name_others')[$key],
                                );
                            else:

                                if ($number_of_files > $i):

                                    $_FILES['dokumen']['name'] = $files['name'][$i];
                                    $_FILES['dokumen']['type'] = $files['type'][$i];
                                    $_FILES['dokumen']['tmp_name'] = $files['tmp_name'][$i];
                                    $_FILES['dokumen']['error'] = $files['error'][$i];
                                    $_FILES['dokumen']['size'] = $files['size'][$i];

                                    if ($this->upload->do_upload('dokumen')):
                                        $data_upload = $this->upload->data();
                                        $dokumen_others[] = array(
                                            'deskripsi' => $this->input->post('dokumen_deskripsi_others')[$key],
                                            'file'      => $config['upload_path'] . $data_upload['file_name'],
                                            'filename'  => $data_upload['file_name'],
                                        );
                                    else:
                                        echo $this->upload->display_errors();
                                    endif;
                                endif;
                                $i++;
                            endif;

                        endforeach;
                    }

                   
                    $akte_notaris = array();
                    $akte_notaris[] = array(
                        'nomor'           => $this->input->post('akte_notaris_nomor'),
                        'pejabat'         => $this->input->post('akte_notaris_nama_pejabat'),
                        'tgl_dikeluarkan' => date('Y-m-d', strtotime($this->input->post('akte_notaris_dikeluarkan'))),
                        'tgl_kadaluarsa'  => date('Y-m-d', strtotime($this->input->post('akte_notaris_kadaluarsa'))),
                    );
		    
		            $idp = array();
                    $idp[] = array(
                        'nomor' => $this->input->post('idp_nomor'),
                        'pejabat' => $this->input->post('idp_nama_pejabat'),
                        'tgl_dikeluarkan' => date('Y-m-d', strtotime($this->input->post('idp_dikeluarkan'))),
                        'tgl_kadaluarsa' => date('Y-m-d', strtotime($this->input->post('idp_kadaluarsa'))),
                    );

                    $situ = array();
                    $situ[] = array(
                        'nomor' => $this->input->post('situ_nomor'),
                        'pejabat' => $this->input->post('situ_nama_pejabat'),
                        'tgl_dikeluarkan' => date('Y-m-d', strtotime($this->input->post('situ_dikeluarkan'))),
                        'tgl_kadaluarsa' => date('Y-m-d', strtotime($this->input->post('situ_kadaluarsa'))),
                    );
		    
                    $direksi = array();
                    foreach ($this->input->post('nama_direksi') as $key => $value) {
                        $direksi[] = array(
                            'nama_direksi'    => $this->input->post('nama_direksi')[$key],
                            'jabatan_direksi' => $this->input->post('jabatan_direksi')[$key],
                        );
                    }

                    $saham = array();
                    foreach ($this->input->post('nama_saham') as $key => $value) {
                        $saham[] = array(
                            'nama_saham'   => $this->input->post('nama_saham')[$key],
                            'persen_saham' => $this->input->post('persen_saham')[$key],
                        );
                    }
		    
                    // $kantor_cabang = array();
                    // foreach ($this->input->post('alamat_cabang') as $key => $value) {
                    //     $kantor_cabang[] = array(
                    //         'alamat_cabang'    => $this->input->post('alamat_cabang')[$key],
                    //         'provinsi_cabang'  => $this->input->post('provinsi_cabang')[$key],
                    //         'kotamadya_cabang' => $this->input->post('kotamadya_cabang')[$key],
                    //     );
                    // }

                    $golongan_id = array();
        		    if($this->input->post('golongan_id')){
        			    foreach ($this->input->post('golongan_id') as $key => $value) {
        				$golongan_id[] = array(
        				    'golongan_id' => $this->input->post('golongan_id')[$key],
        				);
        			    }
        		    }

                    $bidang_id = array();
        		    if($this->input->post('bidang_id')){
        			    foreach ($this->input->post('bidang_id') as $key => $value) {
        				$bidang_id[] = array(
        				    'bidang_id' => $this->input->post('bidang_id')[$key],
        				);
        			    }
        		    }
		    
                    $data = array(
                        'email'          => $this->input->post('email'),
                        'second_email'          => $this->input->post('email_second'),
                        'nama_perusahaan'          => $this->input->post('nama_perusahaan'),
                        'nama_pimpinan'            => $this->input->post('nama_pimpinan'),
                        'jenis'                    => $this->input->post('jenis'),
                        'dokumen'                  => json_encode($dokumenqhse),
                        'dokumen_finance'                  => json_encode($dokumen_finance),
                        'dokumen_legal'                  => json_encode($dokumen_legal),
                        'dokumen_others'                  => json_encode($dokumen_others),
                        'no_telpon'                    => $this->input->post('telp'),
                        'hp'                    => $this->input->post('hp'),
                        'contact_person'                    => $this->input->post('contact_person'),
                        'sub_category'                    => $this->input->post('sub_category'),
                        'email'                     => $this->input->post('email'),
                        'akte'                     => $this->input->post('akte'),
                        'siup_nomor'               => $this->input->post('siup_nomor'),
                        'siup_dikeluarkan'         => date('Y-m-d', strtotime($this->input->post('siup_dikeluarkan'))),
                        'siup_kadaluarsa'          => date('Y-m-d', strtotime($this->input->post('siup_kadaluarsa'))),
                        'idp'                      => json_encode($idp),
                        'situ'                     => json_encode($situ),
                        'direksi'                  => json_encode($direksi),
                        'saham'                    => json_encode($saham),
                        'alamat'                   => $this->input->post('alamat'),
                        'propinsi'                 => $this->input->post('provinsi_id') ? $this->input->post('provinsi_id') :0,
                        'kota_id'                  => $this->input->post('kotamadya_id') ? $this->input->post('kotamadya_id') : 0,
                        'npwp'                     => $this->input->post('npwp'),
                        'nik_vendor'                     => $this->input->post('nik_vendor'),
                        'norek'                    => $this->input->post('norek'),
                        'nama_rek'                 => $this->input->post('nama_rek'),
                        'bank_id'                  => $this->input->post('bank_id') ?: 0,
                        'bidang'                   => json_encode($golongan_id),
                        'bidangsub'                => json_encode($bidang_id),
                        'siup_pejabat'             => $this->input->post('siup_pejabat'),
                        'dok_siup'                 => json_encode($dokumen_siup),
                        'dok_idp'                  => json_encode($dokumen_idp),
                        'dok_situ'                 => json_encode($dokumen_situ),
                        'dok_akte_notaris'         => json_encode($dokumen_akte_notaris),
                        'komisaris'                => $this->input->post('komisaris'),
                        'jenis_vendor_cpm'         => $this->input->post('jenis_perusahaan'),
                        // 'kantor_cabang'            => json_encode($kantor_cabang),
                        'akte_notaris_nomor'       => $this->input->post('akte_notaris_nomor'),
                        'akte_notaris_dikeluarkan' => date('Y-m-d', strtotime($this->input->post('akte_notaris_dikeluarkan'))),
                        'akte_notaris_kadaluarsa'  => date('Y-m-d', strtotime($this->input->post('akte_notaris_kadaluarsa'))),
                        'akte_notaris_pejabat'     => $this->input->post('akte_notaris_pejabat'),
                        'status'                   => 'tidak',
                        'specification'            => $this->input->post('specification') ?: NULL,
                        'on_time'                  => $this->input->post('on_time') ?: NULL,
                        'competitive_price'        => $this->input->post('competitive_price') ?: NULL,
                        'term_pay'                 => $this->input->post('term_pay') ?: NULL,
                        'communication'            => $this->input->post('communication') ?: NULL,
                        'documentation'            => $this->input->post('documentation') ?: NULL,
                        'smkl'                     => $this->input->post('smkl') ?: NULL,
                        'hasil'                    => $this->input->post('total') ?: NULL,
                        'ranking'                  => $this->input->post('ranking') ?: NULL,
                        'create_at'                => $this->session->userdata('id_user'),
                        'create_date'              => date("Y-m-d H:i:s"),
                       

                    );


                    if ($id == '') {
                        if ($this->vendor_model->create($data)) {
                            $message = array(true, 'Proses berhasil', 'Data berhasil disimpan.', '__after_process(1)');
                        }
                    } else {
                        if ($this->vendor_model->update($id, $data)) {
                            $message = array(true, 'Proses berhasil', 'Data berhasil diupdate.', '__after_process(2)');
                        }
                    }
                } else {
                    $message = array(false, 'Proses gagal', $this->form_validation->get_errors_array(), '');
                }

                echo json_encode($message);
            }
        } else {
            echo Modules::run('template/error_message/error_forbidden');
        }
    }

    public function no_duplication()
    {
        $nama_perusahaan = $this->input->post('nama_perusahaan'); 
        $id              = $this->input->post('edit_id');  

        if($id != '')
            $status = $this->vendor_model->is_exist_2(array("nama_perusahaan" => $nama_perusahaan, "id <> '" . $id . "'" => NULL));
        else 
            $status = $this->vendor_model->is_exist_2(array("nama_perusahaan" => $nama_perusahaan));

        if ($status) {
            $this->form_validation->set_message('no_duplication', '<i class="fa fa-warning"> Nama Perusahaan sudah ada</i>');
            return false;            
        } else {
            return true;
        }
        
    }
    
    public function edit($id = '') {
        # Cek data edit
        if ($this->vendor_model->data($id)->count_all_results() > 0) {
            $this->add($id);
        } else {
            echo Modules::run('template/error_message/error_404');
        }
    }

    

    public function delete($id = '') {
        if ($this->laccess->otoritas('delete')) {
            # Cek data edit
            if ($this->vendor_model->data($id)->count_all_results() > 0) {
                 $data = array(
                    'status_delete' => 2,
                   
                );

                if ($this->vendor_model->update($id, $data)) {
                    $message = array(true, 'Proses Berhasil', 'Data berhasil dihapus.', 'my_data_table.reload("#dt_basic")');
                } else {
                    $message = array(false, 'Proses gagal', 'Data gagal dihapus.', '');
                }
            } else {
                $message = array(false, 'Error', 'Data yang akan dihapus tidak ditemukan.', '');
            }
            echo json_encode($message);
        } else {
            echo Modules::run('template/error_message/error_forbidden');
        }
    }

    //Update Controller
    //--------------------------------
    function get_bidang($id) {
        $tmp = '';
        $data = $this->vendor_model->get_bidang_by_kode($id);
        if (!empty($data)) {
            $tmp .= "<option value=''>Pilih</option>";
            foreach ($data as $row) {
                $tmp .= "<option value='" . $row->id . "'>" . $row->keterangan . "</option>";
            }
        } else {
            $tmp .= "<option value=''>Pilih</option>";
        }
        die($tmp);
    }

    public function load_sub_bidang() {
        $id = $this->input->post('id');

        $cond = array();
        $cond["(a.parent_id = '{$id}')"] = NULL;
        $data = $this->bidang_jenis_model->data($cond)->get()->result();

        header('Content-Type: application/json');
        echo "{\"data\":" . json_encode($data) . "}";
    }

    public function load_regency() {
        if (hprotection::must_ajax($this->_module . '/add')) {

                $id = $this->input->post('key');

                $cond = array();
        		if (@$id){
        			$cond["(a.parent_id = '{$id}')"] = NULL;
        		}
                $data = array();
                $data = $this->bidang_jenis_model->options($cond);
                echo json_encode($data);
        }
    }

    #Detail
    public function detail($id = NULL) {
        
        if ($this->vendor_model->data($id)->count_all_results() > 0) {
            $data['page_title'] = '';
            $data['_modul'] = $this->_module;
            $data['edit_id'] = $id;

            
            if ($id != '') {
                $data['page_title'] = 'Detail ' . $this->_title;
                $data_edit = $this->vendor_model->data($id)->get();
                if ($data_edit->num_rows() > 0) {
                    $row = $data_edit->row();
                    $data['data_edit'] = $row;
                    
                        #Decode Data
                        $idp = $data_edit->row()->idp;
                        $decode_idp = json_decode($idp, true);

                        $situ = $data_edit->row()->situ;
                        $decode_situ = json_decode($situ, true);

                        $dokumenqhse = $data_edit->row()->dokumen;
                        $decode_dokumen = json_decode($dokumenqhse, true);

                        $dokumenfinance = $data_edit->row()->dokumen_finance;
                        $decode_dokumen_finance = json_decode($dokumenfinance, true);

                        $dokumenlegal = $data_edit->row()->dokumen_legal;
                        $decode_dokumen_legal = json_decode($dokumenlegal, true);

                        $dokumenothers = $data_edit->row()->dokumen_others;
                        $decode_dokumen_others = json_decode($dokumenothers, true);

                        $direksi = $data_edit->row()->direksi;
                        $decode_direksi = json_decode($direksi);

                        $saham = $data_edit->row()->saham;
                        $decode_saham = json_decode($saham);

                        $data['id'] = $id;
                            
                        $data['decode_idp'] = $decode_idp;
                        $data['decode_situ'] = $decode_situ;
                        $data['decode_dokumen'] = $decode_dokumen;
                        $data['decode_dokumen_finance'] = $decode_dokumen_finance;
                        $data['decode_dokumen_legal'] = $decode_dokumen_legal;
                        $data['decode_dokumen_others'] = $decode_dokumen_others;
                        $data['decode_direksi'] = $decode_direksi;
                        $data['decode_saham'] = $decode_saham;
						$queryblacklist = $this->vendor_model->data_blacklist(['c.id' => $id],['c.id','a.id_blacklist'],'a.id_blacklist')->get();
						if($queryblacklist->num_rows() > 0) {
							$data['datablacklist'] = $queryblacklist;
						}
                

                }
            }
            $this->load->view($this->_module . '/detail', $data);
        } else {
            echo Modules::run('template/error_message/error_404');
        }
        
    }


    public function detail_evaluation($id = NULL) {
        
        if ($this->vendor_model->data($id)->count_all_results() > 0) {
            $data['page_title'] = '';
            $data['_modul'] = $this->_module;
            $data['edit_id'] = $id;
            $data['form_action'] = $this->_module . '/proses_evaluated/'.$id.'';
            $data['project']  = $this->project_all_model->options_by_kd_area_no(array(), array('' => '--Pilih Kode Project --'));
            
            if ($id != '') {
                $data['page_title'] = 'Detail ' . $this->_title;
                $data_edit = $this->vendor_model->data($id)->get();
                $data_transaski = $this->db->select(" * FROM v_db_purchase_all where id_vendor =".$id." ")->get();

                if ($data_edit->num_rows() > 0) {
                    $row = $data_edit->row();
                    if (!empty($row->evaluate_by)) {
                        $data_user = $this->user_model->data($row->evaluate_by)->get()->row();
                    }else{
                        $data_user = NULL;
                    }

                    $data_create = $this->user_model->data($row->create_at)->get()->row();
                   
                    $data['data_edit'] = $row;
                    $data['data_user'] = $data_user;
                    $data['data_create'] = $data_create;
                    $data['data_transaski'] = $data_transaski;
                    
                }
            }
            $this->load->view($this->_module . '/detail_evaluation', $data);
        } else {
            echo Modules::run('template/error_message/error_404');
        }
        
    }

    public function get_exfire_date_dmy($dateline, $batasverifikasi)
    {

		//date batas verifikasi
		$newdata = date("d-m-Y", strtotime($dateline));
		$getdate = new DateTime($newdata);
		$addnewdate = $getdate->modify('+'.$batasverifikasi.' day');
		$formataddnewdate1 = date_format($addnewdate,"d/m/Y");

		//date current
		$knowdate = date("d/m/Y");
		$knowdateTime = new DateTime($knowdate);
		$formataddnewdate2 = date_format($knowdateTime,"d/m/Y");
		
		//diffrent date
		$diff = $getdate->diff($knowdateTime);
		$diff2 = date_diff($getdate,$knowdateTime);
		$viewdate = '';
		foreach ($diff2 as $key => $value) {
			if ($value != 0){
				if ($key == 'y') {
					$viewdate .=  $value.' tahun';
				}elseif ($key == 'm') {
					$viewdate .=  $value.' bulan';
				}elseif ($key == 'd') {
					$viewdate .=  $value.' hari';
				}
			}
		 };

		$dataBanding1 = explode('-', date("Y-m-d", strtotime($formataddnewdate1)));
		$dataBanding2 = explode('-', date("Y-m-d", strtotime($formataddnewdate2)));
		$minus = '';
		foreach ($dataBanding1 as $key1 => $value1) {
			$bandingdatalast = intval($value1) - intval($dataBanding2[$key1]);

			if ($bandingdatalast < 0) {
				$minus = '-';
				break;
			}
		};
		return $minus.$viewdate;
    }

    public function import()
    {
        $config['upload_path']   = 'uploads/import_excel/';
        $config['allowed_types'] = 'xlsx|xls|csv';
        $config['max_size']      = 400000;

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

        $data = array();
        foreach ($object->getWorksheetIterator() as $worksheet) {
            $worksheetTitle     = $worksheet->getTitle();
            $highestRow         = $worksheet->getHighestRow(); 
            $highestColumn      = $worksheet->getHighestColumn(); 
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $nrColumns = ord($highestColumn) - 64;

            for ($row = 8; $row <= $highestRow; ++ $row) {

                $nama_perusahaan          = $worksheet->getCellByColumnAndRow(1, $row); 
                $cek          			  = strtoupper($worksheet->getCellByColumnAndRow(1, $row)); 
                $jenis 			          = $worksheet->getCellByColumnAndRow(2, $row); 
                $alamat                   = $worksheet->getCellByColumnAndRow(3, $row); 
                $propinsi                 = $worksheet->getCellByColumnAndRow(12, $row);
                $kota_id                  = $worksheet->getCellByColumnAndRow(13, $row);
                $email                    = $worksheet->getCellByColumnAndRow(7, $row); 
                $npwp                     = $worksheet->getCellByColumnAndRow(8, $row);
                $akta_nomor               = $worksheet->getCellByColumnAndRow(9, $row); 
                $akta_tanggal             = $worksheet->getCellByColumnAndRow(10, $row);
                $akta_notaris             = $worksheet->getCellByColumnAndRow(11, $row); 

                $data = array(
                        'nama_perusahaan'          => $nama_perusahaan->getValue(),
                        'jenis'                    => $jenis->getValue(),
                        'alamat'                   => $alamat->getValue(),
                        'propinsi'            	   => $propinsi->getValue(),
                        'kota_id'                  => $kota_id->getValue(),
                        'email'                    => $email->getValue(),
                        'npwp'                     => $npwp->getValue(),
                        'akte_notaris_nomor'       => $akta_nomor->getValue(),
                        'akte_notaris_dikeluarkan' => $akta_tanggal->getValue(),
                        'akte_notaris_pejabat'     => $akta_notaris->getValue()
                );
				$data_vendor = $this->vendor_model->custom_query("select upper(nama_perusahaan) from m_vendor where upper(nama_perusahaan)='$cek'");
				if($data_vendor->num_rows() == 0){
					// echo $cek."<br/>";
					$this->vendor_model->create($data);
				}
            }
        }

        echo json_encode(array('message' => 'Proses Berhasil'));
    }
	
	public function import_excel()
    {
        $config['upload_path']   = 'uploads/import_excel/';
        $config['allowed_types'] = 'xlsx|xls|csv';
        $config['max_size']      = 400000;

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

        $data = array();
        foreach ($object->getWorksheetIterator() as $worksheet) {
            $worksheetTitle     = $worksheet->getTitle();
            $highestRow         = $worksheet->getHighestRow(); 
            $highestColumn      = $worksheet->getHighestColumn(); 
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $nrColumns = ord($highestColumn) - 64;

            for ($row = 8; $row <= $highestRow; ++ $row) {

                $nama_perusahaan          = $worksheet->getCellByColumnAndRow(1, $row); 
                $nama_pimpinan            = $worksheet->getCellByColumnAndRow(2, $row); 
                $npwp                     = $worksheet->getCellByColumnAndRow(3, $row); 
                $status                   = $worksheet->getCellByColumnAndRow(4, $row);
                $alamat                   = $worksheet->getCellByColumnAndRow(5, $row);
                $rate                     = $worksheet->getCellByColumnAndRow(6, $row);
                $tgl_blacklist            = $worksheet->getCellByColumnAndRow(7, $row); 
                $alasan                   = $worksheet->getCellByColumnAndRow(8, $row);
                $email                    = $worksheet->getCellByColumnAndRow(9, $row); 
                $jenis                    = $worksheet->getCellByColumnAndRow(10, $row); 
                $dokumen                  = $worksheet->getCellByColumnAndRow(11, $row); 
                $akta_notaris_nomor       = $worksheet->getCellByColumnAndRow(12, $row);
                $akta_notaris_pejabat     = $worksheet->getCellByColumnAndRow(13, $row);
                $akta_notaris_dikeluarkan = $worksheet->getCellByColumnAndRow(14, $row); 
                $saham                    = $worksheet->getCellByColumnAndRow(15, $row); 
                $provinsi                 = $worksheet->getCellByColumnAndRow(16, $row); 
                $kota                     = $worksheet->getCellByColumnAndRow(17, $row); 

                $data = array(
                        'nama_perusahaan'          => $nama_perusahaan->getValue(),
                        'nama_pimpinan'            => $nama_pimpinan->getValue(),
                        'npwp'                     => $npwp->getValue(),
                        'status'                   => $status->getValue(),
                        'alamat'                   => $alamat->getValue(),
                        'rate'                     => $rate->getValue(),
                        'tgl_blacklist'            => $tgl_blacklist->getValue(),
                        'alasan'                   => $alasan->getValue(),
                        'email'                    => $email->getValue(),
                        'jenis'                    => $jenis->getValue(),
                        'dokumen'                  => $dokumen->getValue(),
                        'akte_notaris_nomor'       => $akta_notaris_nomor->getValue(),
                        'akte_notaris_pejabat'     => $akta_notaris_pejabat->getValue(),
                        'akte_notaris_dikeluarkan' => $akta_notaris_dikeluarkan->getValue(),
                        'saham'                    => $saham->getValue(),
                       
                    );
                $this->vendor_model->create($data);
            }
        }

        echo json_encode(array('message' => 'Proses Berhasil'));
    }

    public function fix_database()
    {
        $this->db->query('ALTER TABLE m_vendor ALTER COLUMN nama_perusahaan TYPE VARCHAR(255);
                ALTER TABLE m_vendor ALTER COLUMN nama_pimpinan TYPE VARCHAR(255);
                ALTER TABLE m_vendor ALTER COLUMN status TYPE VARCHAR(255);
                ALTER TABLE m_vendor ALTER COLUMN rate TYPE VARCHAR(255);
                ALTER TABLE m_vendor ALTER COLUMN tgl_blacklist TYPE VARCHAR(255);

                ALTER TABLE m_vendor ALTER COLUMN email TYPE VARCHAR(255);
                ALTER TABLE m_vendor ALTER COLUMN jenis TYPE VARCHAR(255);
                ALTER TABLE m_vendor ALTER COLUMN akte TYPE VARCHAR(255);
                ALTER TABLE m_vendor ALTER COLUMN siup_nomor TYPE VARCHAR(255);
                ALTER TABLE m_vendor ALTER COLUMN npwp TYPE VARCHAR(255);
                ALTER TABLE m_vendor ALTER COLUMN norek TYPE VARCHAR(255);
                ALTER TABLE m_vendor ALTER COLUMN siup_pejabat TYPE VARCHAR(255);
                ALTER TABLE m_vendor ALTER COLUMN komisaris TYPE VARCHAR(255);

                ALTER TABLE m_vendor ALTER COLUMN akte_notaris_nomor TYPE VARCHAR(255);
                ALTER TABLE m_vendor ALTER COLUMN akte_notaris_pejabat TYPE VARCHAR(255);
                ');
    }

    public function excel()
    {
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));

        $excel = new PHPExcel();
        
        $excel->getProperties()
                        ->setCreator('PT. Citra Panji Manunggal') 
                        ->setTitle('  Vendor List');  

        $excel->getActiveSheet()->setTitle(' Vendor List ');
        $excel->setActiveSheetIndex(0)->setCellValue('A1', ' VENDOR List ')->mergeCells('A1:H1');
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(15); 



       
        $excel->getActiveSheet()->getStyle('G8:G'.$excel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 
        
        //COLUMN
        $excel->getActiveSheet()->setCellValue('A8', 'No');
        $excel->getActiveSheet()->setCellValue('B8', 'NAMA PERUSAHAAN');
        $excel->getActiveSheet()->setCellValue('C8', 'ALAMAT');
        $excel->getActiveSheet()->setCellValue('D8', 'CONTACT PERSON');
        $excel->getActiveSheet()->setCellValue('E8', 'HP / NO TELPON');
        $excel->getActiveSheet()->setCellValue('F8', 'FAX');
        $excel->getActiveSheet()->setCellValue('G8', 'SUB CATEGORY ');
        $excel->getActiveSheet()->setCellValue('H8', 'QUALITY');
        $excel->getActiveSheet()->setCellValue('I8', 'DELIVERY');
        $excel->getActiveSheet()->setCellValue('J8', 'PRICE ');
        $excel->getActiveSheet()->setCellValue('K8', 'TERM OF PAYMENT');
        $excel->getActiveSheet()->setCellValue('L8', 'COMUNICATION');
        $excel->getActiveSheet()->setCellValue('M8', 'DOCUMENTATION');
        $excel->getActiveSheet()->setCellValue('N8', 'SMK3L');
        $excel->getActiveSheet()->setCellValue('O8', 'HASIL');
        $excel->getActiveSheet()->setCellValue('P8', 'RANKING');
        $excel->getActiveSheet()->setCellValue('Q8', 'TGL CREATE');
        $excel->getActiveSheet()->setCellValue('R8', 'CREATE By');


        $excel->getActiveSheet()->setCellValue('B2', 'SCORE');
        $excel->getActiveSheet()->setCellValue('C2', 'EVALUATION RANKING');
        $excel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true)->setSize(12); 
        $excel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true)->setSize(12); 
        $excel->getActiveSheet()->getStyle('B2:C2')->getFill()
                                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                ->getStartColor()->setARGB('FFE8E5E5');
        $excel->getActiveSheet()->setCellValue('B3', '25 - 28');
        $excel->getActiveSheet()->setCellValue('C3', 'A = Excellent');
        $excel->getActiveSheet()->setCellValue('B4', '18 - 24');
        $excel->getActiveSheet()->setCellValue('C4', 'B = Good');
        $excel->getActiveSheet()->setCellValue('B5', '11 - 17');
        $excel->getActiveSheet()->setCellValue('C5', 'C = Fair');
        $excel->getActiveSheet()->setCellValue('B6', '1 - 10 ');
        $excel->getActiveSheet()->setCellValue('C6', 'D = Poor');
        $excel->getActiveSheet()->getStyle('B2:C2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $excel->getActiveSheet()->getStyle('B3:C3')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $excel->getActiveSheet()->getStyle('B4:C4')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $excel->getActiveSheet()->getStyle('B5:C5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $excel->getActiveSheet()->getStyle('B6:C6')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


        $excel->getActiveSheet()->setCellValue('E2', '1. Quality');
        $excel->getActiveSheet()->getStyle('E2')->getFont()->setBold(true)->setSize(12); 
        $excel->getActiveSheet()->setCellValue('E3', '4: comply with all requirements');
        $excel->getActiveSheet()->setCellValue('E4', '3: quite match with requirements');
        $excel->getActiveSheet()->setCellValue('E5', '2: Not comply to several requirements');
        $excel->getActiveSheet()->setCellValue('E6', '1: Not comply to all requirements ');

        $excel->getActiveSheet()->setCellValue('F2', '2. Delivery Time');
        $excel->getActiveSheet()->getStyle('F2')->getFont()->setBold(true)->setSize(12); 
        $excel->getActiveSheet()->setCellValue('F3', '4: On time, early on workhours');
        $excel->getActiveSheet()->setCellValue('F4', '3: On time, in the end of workhours');
        $excel->getActiveSheet()->setCellValue('F5', '2: 5-day late');
        $excel->getActiveSheet()->setCellValue('F6', '1: Late more than 6 days');

        $excel->getActiveSheet()->setCellValue('G2', '3. Price');
        $excel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true)->setSize(12); 
        $excel->getActiveSheet()->setCellValue('G3', '4: Best price and lower than market price');
        $excel->getActiveSheet()->setCellValue('G4', '3: Equal with market price');
        $excel->getActiveSheet()->setCellValue('G5', '2: More expensive as maximum 10% higher than market price');
        $excel->getActiveSheet()->setCellValue('G6', '1: More than 10% higher than market price');
       
        $excel->getActiveSheet()->setCellValue('H2', '4. Terms of payment');
        $excel->getActiveSheet()->getStyle('H2')->getFont()->setBold(true)->setSize(12); 
        $excel->getActiveSheet()->setCellValue('H3', '4: Back to back with client');
        $excel->getActiveSheet()->setCellValue('H4', '3: Progress payment & 30 days after receive invoice');
        $excel->getActiveSheet()->setCellValue('H5', '2: With down payment');
        $excel->getActiveSheet()->setCellValue('H6', '1: Cash');
       
        $excel->getActiveSheet()->setCellValue('I2', '5. Communication');
        $excel->getActiveSheet()->getStyle('I2')->getFont()->setBold(true)->setSize(12); 
        $excel->getActiveSheet()->setCellValue('I3', '4: Responded and actioned very fastly');
        $excel->getActiveSheet()->setCellValue('I4', '3: Responded and actioned fastly');
        $excel->getActiveSheet()->setCellValue('I5', '2: Responded and actioned poorly');
        $excel->getActiveSheet()->setCellValue('I6', '1: No response and action');

        $excel->getActiveSheet()->setCellValue('J2', '6. Documentation');
        $excel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true)->setSize(12); 
        $excel->getActiveSheet()->setCellValue('J3', '4: Complete and detail');
        $excel->getActiveSheet()->setCellValue('J4', '3: Complete but not detail');
        $excel->getActiveSheet()->setCellValue('J5', '2: Not detail');
        $excel->getActiveSheet()->setCellValue('J6', '1: No documentation');


        $excel->getActiveSheet()->setCellValue('K2', '7. HSE');
        $excel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true)->setSize(12); 
        $excel->getActiveSheet()->setCellValue('K3', '4: Provide OHSAS Certification');
        $excel->getActiveSheet()->setCellValue('K4', '3: Provide commitment and completed safety document');
        $excel->getActiveSheet()->setCellValue('K5', '2: Provide safety document only');
        $excel->getActiveSheet()->setCellValue('K6', '1: No HSE document');


        $startRow = 9;

        //CONDITION
        $cond = [];
        $orderBy   = 'nama_perusahaan';
        $direction = 'ASC';

        if($status = $this->input->get('keyword')) {
            $cond["(LOWER(nama_perusahaan) ILIKE '%{$status}%')"] = NULL;

            $excel->getActiveSheet()->setCellValue('A7', 'VENDOR')->mergeCells('A3:B3');
            $excel->getActiveSheet()->setCellValue('C7', ': '.$status.'' )->mergeCells('C3:D3');
        }

        if($sub = $this->input->get('sub_category')) {
            $cond["(LOWER(sub_category) ILIKE '%{$sub}%')"] = NULL;

            $excel->getActiveSheet()->setCellValue('A7', 'Sub category')->mergeCells('A3:B3');
            $excel->getActiveSheet()->setCellValue('C7', ': '.$sub.'' )->mergeCells('C3:D3');
        }

        if($conta = $this->input->get('contact_person')) {
            $cond["(LOWER(contact_person) ILIKE '%{$conta}%')"] = NULL;

            $excel->getActiveSheet()->setCellValue('A7', 'Contact Person')->mergeCells('A3:B3');
            $excel->getActiveSheet()->setCellValue('C7', ': '.$status.'' )->mergeCells('C3:D3');
        }

        // if($provinsi = $this->input->get('provinsi_id')) {
        //     $cond['a.propinsi'] = $provinsi;

        //     $provinsiData = $this->provinsi_model->data_all($provinsi)->get()->row();

        //     $excel->getActiveSheet()->setCellValue('A3', 'Provinsi')->mergeCells('A3:B3');
        //     $excel->getActiveSheet()->setCellValue('C3', ': '. $provinsiData->provinsi_nama)->mergeCells('C3:D3');
        // }

        $dataCount = $this->vendor_model->data_search($cond)->get()->num_rows();
        $query     = $this->vendor_model->data_search($cond, $orderBy ,$direction)->get();

        
        $no = 1;

        $countBorder = $dataCount + $startRow - 1;

        $excel->getActiveSheet()->getStyle('A8:P'.$countBorder)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $excel->getActiveSheet()->getStyle('A8:R8')->getFill()
                                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                ->getStartColor()->setARGB('FFE8E5E5');

        foreach ($query->result() as $dt){

            $excel->getActiveSheet()->setCellValue('A' . $startRow, $no++);
            $excel->getActiveSheet()->setCellValue('B' . $startRow, ''.$dt->nama_perusahaan.' '.$dt->jenis.'');
            $excel->getActiveSheet()->setCellValue('C' . $startRow, $dt->alamat);
            $excel->getActiveSheet()->setCellValue('D' . $startRow, $dt->contact_person);
            $excel->getActiveSheet()->setCellValue('E' . $startRow, $dt->no_telpon );
            $excel->getActiveSheet()->setCellValue('F' . $startRow, $dt->fax);
            $excel->getActiveSheet()->setCellValue('G' . $startRow, $dt->sub_category);
            $excel->getActiveSheet()->setCellValue('H' . $startRow, $dt->specification);
            $excel->getActiveSheet()->setCellValue('I' . $startRow, $dt->on_time);
            $excel->getActiveSheet()->setCellValue('J' . $startRow, $dt->competitive_price );
            $excel->getActiveSheet()->setCellValue('K' . $startRow, $dt->term_pay);
            $excel->getActiveSheet()->setCellValue('L' . $startRow, $dt->communication);
            $excel->getActiveSheet()->setCellValue('M' . $startRow, $dt->documentation);
            $excel->getActiveSheet()->setCellValue('N' . $startRow, $dt->smkl);
            $excel->getActiveSheet()->setCellValue('O' . $startRow, $dt->hasil );
            $excel->getActiveSheet()->setCellValue('P' . $startRow, $dt->ranking );
            $excel->getActiveSheet()->setCellValue('Q' . $startRow, $dt->create_date );
            $excel->getActiveSheet()->setCellValue('R' . $startRow, $dt->username_user );
    
            $startRow++;
        }



        $excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(25.86);
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(30.86);
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(18.14);
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(18.57);
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(5.57);
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(15.29);
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(7.57);
        $excel->getActiveSheet()->getColumnDimension('I')->setWidth(8.14);
        $excel->getActiveSheet()->getColumnDimension('J')->setWidth(4.86);
        $excel->getActiveSheet()->getColumnDimension('K')->setWidth(9.14);
        $excel->getActiveSheet()->getColumnDimension('L')->setWidth(8.00);
        $excel->getActiveSheet()->getColumnDimension('M')->setWidth(8.71);
        $excel->getActiveSheet()->getColumnDimension('N')->setWidth(4.71);
        $excel->getActiveSheet()->getColumnDimension('O')->setWidth(5.00);
        $excel->getActiveSheet()->getColumnDimension('P')->setWidth(8.86);

        $writer = IOFactory::createWriter($excel, 'Excel5');
       
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Database Vendor.xls"');

        $writer->save("php://output");    
    }

}
 