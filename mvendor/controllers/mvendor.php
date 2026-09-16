<?php

class mvendor extends MX_Controller {

    private $_class_name = '';
    private $_title = 'Vendor';
    private $_module = 'mvendor';

    public function __construct() {
        parent::__construct();

        # Protection
        hprotection::login();

        $this->laccess->check();
        $this->laccess->otoritas('view', TRUE);


        $this->_class_name = get_class($this);
        $this->_module .= '/' . $this->_class_name;
       
        $this->load->model('vendor_model');
        $this->load->model('black_list_model');
        $this->load->model('project_model');

        $this->load->model('provinsi_model');
        $this->load->model('kotamadya_model');
        $this->load->model('bidang_jenis_model');

        $this->load->model('permintaan_sp_model');
        //$this->load->model('spk_model');
    }

    public function index($id = NULL) {
        if (hprotection::must_ajax($this->_module)) {
            $data['page_title'] = 'Master ' . $this->_title;
            $data['_modul'] = $this->_module;
            $data['_title'] = $this->_title;
            $this->load->view($this->_module . '/index', $data);
        }
    }

    public function load() {

        if (hprotection::must_ajax($this->_module)) {

            # Data Table
            $limit = $this->input->post('length');
            $offset = $this->input->post('start');
            $draw = $this->input->post('draw');
            $extra_search = $this->input->post('extra_search');
            $data_cond = hgenerator::seriliaze_decode($extra_search);

            # Condition 
            $cond = array();

            if (!empty($data_cond['keyword'])) {
                $cond["(a.nama_perusahaan LIKE '%{$data_cond['keyword']}%' OR a.nama_pimpinan LIKE '%{$data_cond['keyword']}%')"] = NULL;
            }

            $data_count = $this->vendor_model->data($cond)->count_all_results();
            $data_result = $this->vendor_model->data($cond, 'id', 'asc', $limit, $offset)->get();

            $rows = array();
            $no = $offset;

            foreach ($data_result->result() as $value) {

                $id = $value->id;

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
                
                if (!empty($value->dok_siup) && !empty($value->dok_idp) && !empty($value->dok_situ) AND $value->dok_idp !== '[]' AND $value->dok_situ !== '[]' AND $value->dok_siup !== '[]' ){
                        $action .= '<span class="btn btn-warning btn-xs margin-right-2"><a href="' . base_url() . 'home/vendor/topdf/' . $id . '" rel="tooltip" title="Download PDF" target="_blank"><i class="fa fa-file-pdf-o"></i></a></span>';
                }    

                
                //}
                $no++;
                $rows[] = array(
                    hgenerator::columns_align($no, 'center'),
                    anchor($this->_module . '/detail/' . $id, $value->nama_perusahaan, array(
                        'data-module' => $this->_module,
                        'data-toggle' => "modal",
                        'data-target' => "#modalDetail",
                        'data-keyboard' => "false",
                        'data-backdrop' => "static",
                        'rel' => 'tooltip',
                        'data-placement' => 'top',
                        'title' => 'Detail',
                    )),
                    $value->nama_pimpinan,
                    $value->kota_id,
                    $value->status,
                    hgenerator::button_action($action)
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
    public function topdf($id = NULL) {
        # Condition
        $cond = array();
        $data['edit_id'] = $id;
        $cond["(a.id = '{$id}') "] = NULL;

        if ($this->vendor_model->data($cond)->count_all_results() > 0) {

            $data['edit_id'] = $id;

            $data['page_title'] = 'Ubah ' . $this->_title;
            $data_edit = $this->vendor_model->data($cond)->get();
            $row = $data_edit->row();

            $this->load->library('fpdf17/fpdf');
            $this->fpdf->FPDF('P', 'cm', 'A4');
            $this->fpdf->AddPage();
            $this->fpdf->Ln();
            $this->fpdf->setFont('Arial', 'B', 10);
            $this->fpdf->Text(6, 1, 'TITLE VENDOR');
            $this->fpdf->Line(15.6, 2.1, 5, 2.1);
            $this->fpdf->ln(1.6);
            $this->fpdf->ln(0.5);
            $this->fpdf->ln(0.5);
            $this->fpdf->setFont('Arial', '', 10);
            $this->fpdf->write(0, 'No. : ..............');
            $this->fpdf->ln(0.5);
            
            $this->fpdf->ln(0.5);
            $this->fpdf->write(0, '    Perusahaan. ' . $row->nama_perusahaan);
            $this->fpdf->ln(0.5);

            $this->fpdf->Image(hconfig::base_assets() . '/img/logo/client/logo_kaltim.png', 1, 1, "4", "1");
            $this->fpdf->Output("File.pdf", "I");
        } else {
            echo Modules::run('template/error_message/error_404');
        }
    }
    public function load_project($id)
        {
	
            if(hprotection::must_ajax($this->_module)):
                
                # Data Table
                $limit  = $this->input->post('length');
                $offset = $this->input->post('start');
                $draw   = $this->input->post('draw');
                $extra_search = $this->input->post('extra_search');
                $extra_search = $this->input->post('extra_search');
                $data_cond    = hgenerator::seriliaze_decode($extra_search);

                $tanggal = NULL;
                $nota    = NULL;
                # Condition
                $cond = array();
                if (!empty($data_cond['keyword'])):
                    $cond["(permintaan_nama LIKE '%{$data_cond['keyword']}%') "] = NULL;
                endif;
                
                $cond["(a.vendor_id = '{$id}') "] = NULL;

                $data_count  = $this->project_model->data($cond)->count_all_results();
                $data_result = $this->project_model->data($cond, 'permintaan_nama', 'asc', $limit, $offset)->get();

                $rows = array();
                $no   = $offset;
		
		if ($data_result->result()){
			foreach ($data_result->result() as $dt):
			    $id     = $dt->project_id;
			    $tanggal = '';
			    $nota = '';
			    $no++;

			    if($dt->permintaan_jenis == 'barang'){
				if ($spb = $this->permintaan_sp_model->data(array('a.permintaan_id' => $dt->permintaan_id))->get()->row()){
					$tanggal = $spb->sp_tanggal;
					$nota = $spb->sp_nota;
				};
				
				$dataGet['a.permintaan_id = '.$dt->permintaan_id] = null;
				if ($project = $this->project_model->data($dataGet)->get()->row()){
					$vote = $project->nilai;
				}
			    }elseif($dt->permintaan_jenis == 'jasa'){
				if ($spk = $this->spk_model->data(array('a.permintaan_id' => $dt->permintaan_id))->get()->row()){
					$tanggal = $spk->spk_approve_tanggal;
					$nota = $spk->spk_nota;
				};
				
				$dataGet['a.permintaan_id = '.$dt->permintaan_id] = null;
				if ($project = $this->project_model->data($dataGet)->get()->row()){
					$vote = $project->nilai;
				}
			    }
			    if (empty($vote)){
				$vote = '-';
			    }
			    $rows[] = array(
					hgenerator::columns_align($no,'center'),
					    $tanggal,
					    $nota,
					    $dt->permintaan_nama,
					    $vote.'/5',
				    );
			endforeach;
		}

                $data = array(
                            'draw'            => $draw,
                            'recordsTotal'    => $data_count,
                            'recordsFiltered' => $data_count,
                            'data'            => $rows, 
                        );
                echo json_encode($data);

            endif;

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
                #options kotamadya
                $cond = array();
                $data['kotamadya'] = $this->kotamadya_model->options($cond, array('' => '--Pilih--'));


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

                        $data['decode_idp'] = $decode_idp;
                        $data['decode_situ'] = $decode_situ;
                        $data['decode_dokumen'] = $decode_dokumen;
                        $data['decode_direksi'] = $decode_direksi;
                        $data['decode_saham'] = $decode_saham;

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

                $this->form_validation->set_rules('nama_perusahaan', '<i class="fa fa-warning"> Nama Perusahaan</i>', 'trim|required');
                $this->form_validation->set_rules('npwp', '<i class="fa fa-warning"> NPWP</i>', 'trim|required');
                $this->form_validation->set_rules('alamat', '<i class="fa fa-warning"> Alamat</i>', 'trim|required');

                /* form validasi */
                $id = $this->input->post('edit_id');
                $filter_unix = trim($this->input->post('nama_perusahaan'));


                if (!empty($filter_unix)) {
                    $filter_unix = $this->vendor_model->is_exist($filter_unix);
                    if (!$id && $filter_unix > 0) {
                        $this->form_validation->set_rules('nama_perusahaan', '<i class="fa fa-warning"> Nama Perusahaan</i>', 'is_exist');
                    } else {
                        $this->form_validation->set_rules('nama_perusahaan', '<i class="fa fa-warning"> Nama Perusahaan</i>', 'trim|required');
                    }
                } elseif (empty($filter_unix) or $filter_unix == 0) {
                    $this->form_validation->set_rules('nama_perusahaan', '<i class="fa fa-warning"> Nama Perusahaan</i>', 'trim|required');
                }
                /* end */

                if ($this->form_validation->run($this)) {
                    $message = array('error', 'Error!', 'Terjadi error pada saat penyimpanan, silahkan coba lagi.', '');
                    


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
                    
                    if ($this->input->post('dokumen_deskripsi')) {

                        //$path = $this->app_config->info('demand_doc_barang') . date('Y') . '/' . date('m') . '/';
                        $path = './uploads/vendor/'; 
                        $number_of_files = 0;

                        if (!file_exists($path))
                            mkdir($path, 0, TRUE);
                        if (!empty($_FILES['dokumen_file'])):
                            $files = $_FILES['dokumen_file'];
                            $number_of_files = sizeof($files['name']);
                        endif;

                        $dokumen = array();
                        $this->load->library('upload');

                        $config = array(
                            'upload_path' => $path,
                            'allowed_types' => 'pdf|jpg|png|docx|doc|xlsx|xls',
                        );
                        $this->upload->initialize($config);

                        $i = 0;
                        foreach ($this->input->post('dokumen_deskripsi') as $key => $value):

                            if (!empty($this->input->post('dokumen_path')[$key])):
                                $dokumen[] = array(
                                    'deskripsi' => $this->input->post('dokumen_deskripsi')[$key],
                                    'file' => $this->input->post('dokumen_path')[$key],
                                    'filename' => $this->input->post('dokumen_name')[$key],
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
                                        $dokumen[] = array(
                                            'deskripsi' => $this->input->post('dokumen_deskripsi')[$key],
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

                    $idp = array();
                    $idp[] = array(
                        'nomor' => $this->input->post('idp_nomor'),
                        'pejabat' => $this->input->post('idp_nama_pejabat'),
                        'tgl_dikeluarkan' => $this->input->post('idp_dikeluarkan'),
                        'tgl_kadaluarsa' => $this->input->post('idp_kadaluarsa'),
                    );

                    $situ = array();
                    $situ[] = array(
                        'nomor' => $this->input->post('situ_nomor'),
                        'pejabat' => $this->input->post('situ_nama_pejabat'),
                        'tgl_dikeluarkan' => $this->input->post('situ_dikeluarkan'),
                        'tgl_kadaluarsa' => $this->input->post('situ_kadaluarsa'),
                    );


                    $direksi = array();
                    foreach ($this->input->post('nama_direksi') as $key => $value) {
                        $direksi[] = array(
                            'nama_direksi' => $this->input->post('nama_direksi')[$key],
                            'jabatan_direksi' => $this->input->post('jabatan_direksi')[$key],
                        );
                    }

                    $saham = array();
                    foreach ($this->input->post('nama_saham') as $key => $value) {
                        $saham[] = array(
                            'nama_saham' => $this->input->post('nama_saham')[$key],
                            'persen_saham' => $this->input->post('persen_saham')[$key],
                        );
                    }

                    $data = array(
                        'nama_perusahaan' => $this->input->post('nama_perusahaan'),
                        'nama_pimpinan' => $this->input->post('nama_pimpinan'),
                        'jenis' => $this->input->post('jenis'),
                        'dokumen' => json_encode($dokumen),
                        'akte' => $this->input->post('akte'),
                        'siup_nomor' => $this->input->post('siup_nomor'),
                        'siup_dikeluarkan' => $this->input->post('siup_dikeluarkan'),
                        'siup_kadaluarsa' => $this->input->post('siup_kadaluarsa'),
                        'idp' => json_encode($idp),
                        'situ' => json_encode($situ),
                        'direksi' => json_encode($direksi),
                        'saham' => json_encode($saham),
                        'alamat' => $this->input->post('alamat'),
                        'propinsi' => $this->input->post('provinsi_id'),
                        'kota_id' => $this->input->post('kotamadya_id'),
                        'npwp' => $this->input->post('npwp'),
                        'norek' => $this->input->post('norek'),
                        'bidang' => $this->input->post('golongan_id'),
                        'bidangsub' => $this->input->post('bidang_id'),
                        'siup_pejabat' => $this->input->post('siup_pejabat'),
                        'dok_siup' => json_encode($dokumen_siup),
                        'dok_idp' => json_encode($dokumen_idp),
                        'dok_situ' => json_encode($dokumen_situ),
                        
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
    
    public function edit($id = '') {
        # Cek data edit
        if ($this->vendor_model->data($id)->count_all_results() > 0) {
            $this->add($id);
        } else {
            echo Modules::run('template/error_message/error_404');
        }
    }

    public function blacklist($id = '') {
        if ($this->black_list_model->data($id)->count_all_results() > 0) {
            $data['page_title'] = 'Black list ' . $this->_title;
            $data['_modul'] = $this->_module;
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

    public function proses_blacklist() {
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
                        'alasan' => $this->input->post('alasan'),
                    );

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

    


    public function delete($id = '') {
        if ($this->laccess->otoritas('delete')) {
            # Cek data edit
            if ($this->vendor_model->data($id)->count_all_results() > 0) {
                if ($this->vendor_model->delete($id)) {
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
                $cond["(a.parent_id = '{$id}')"] = NULL;
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

                        $dokumen = $data_edit->row()->dokumen;
                        $decode_dokumen = json_decode($dokumen, true);

                        $direksi = $data_edit->row()->direksi;
                        $decode_direksi = json_decode($direksi);

                        $saham = $data_edit->row()->saham;
                        $decode_saham = json_decode($saham);

                        $data['id'] = $id;
                            
                        $data['decode_idp'] = $decode_idp;
                        $data['decode_situ'] = $decode_situ;
                        $data['decode_dokumen'] = $decode_dokumen;
                        $data['decode_direksi'] = $decode_direksi;
                        $data['decode_saham'] = $decode_saham;

                }
            }
            $this->load->view($this->_module . '/detail', $data);
        } else {
            echo Modules::run('template/error_message/error_404');
        }
        
    }

}
 
