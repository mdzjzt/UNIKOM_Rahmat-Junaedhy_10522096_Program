<?php

class bidang_lbu extends MX_Controller
{
	
	private $_class_name = NULL;
	private $_title		 = 'Bidang LBU';
	private $_module	 = 'master';


	function __construct()
	{
		parent::__construct();

		#Protection
		hprotection::login();
		$this->laccess->check();
		$this->laccess->otoritas('view',TRUE);

		$this->_class_name = get_class($this);
		$this->_module    .= '/' . $this->_class_name;

		#Load Model
		$this->load->model('lbu_model'); 
		$this->load->model('bidang_lbu_model'); 
	}

	public function index()
	{
		if(hprotection::must_ajax($this->_module)) {

			$data = [
				'pageTitle' => 'MASTER '.$this->_title,
				'_modul'	 => $this->_module,
				'_title'	 => $this->_title,
				'golongan'	 => $this->lbu_model->options([], ['' => '-']), 
			];

			# LOG
            $this->log_activity_model->save([
                        'module'   => $this->_module,
                        'event'    => 'View',
                        'activity' => 'View master Bidang LBU'
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
            $orderBy   = 'lbu_nama';
            $direction = NULL;

            if($extraColumn[$extraOrder[0]['column']]['orderable'] == 'true') {
                $orderBy = isset($extraColumn[$extraOrder[0]['column']]['name']) ? $extraColumn[$extraOrder[0]['column']]['name'] : NULL;
                $direction   = $extraOrder[0]['dir'];
            }

			# Condition
            $cond = [];

            if (!empty($this->input->post('lbu_id'))) {
            	$cond['a.lbu_id'] = $this->input->post('lbu_id');
            }

            if (!empty($this->input->post('keyword'))) {
                $cond["(LOWER(a.bidang_lbu_kode) ILIKE '%{$this->input->post('keyword')}%' OR LOWER(a.bidang_lbu_nama) ILIKE '%{$this->input->post('keyword')}%' )"] = NULL;
            }

            $dataCount          = $this->bidang_lbu_model->data()->count_all_results();
            $dataCountFiltered  = $this->bidang_lbu_model->data($cond)->count_all_results();
            $dataResult         = $this->bidang_lbu_model->data($cond, $orderBy, $direction, $limit, $offset)->get();

            $rows = [];
            $no   = $offset;

            foreach ($dataResult->result() as $dt) {
            	
            	$id  	= $dt->bidang_lbu_id;

            	$action = NULL;

            	if($this->laccess->otoritas('edit')) {
            		$action .= anchor($this->_module . '/edit/' . $id, '<i class="fa fa-edit"></i></a>', 
            			[
            				'class'          => 'btn btn-warning btn-xs',
            				'data-toggle'	 => 'modal',
            				'data-target'    => "#remoteModal",
	                        'rel'            => 'tooltip',
	                        'data-placement' => 'top',
	                        'title'          => 'Ubah',
            			]);
            	}

            	if($this->laccess->otoritas('delete')) {
            		$action .= anchor(NULL, '<i class="fa fa-trash-o"></i></a>', 
	            		[
	                        'class'          => 'btn btn-danger btn-xs',
	                        'rel'            => 'tooltip',
	                        'data-placement' => "top",
	                        'data-title'     => 'Hapus',
	                        'data-url'       => base_url() . $this->_module . '/delete/'. $id,  
	                        'onclick'        => '$(this).myForm().submit(\'delete\')'
	                    ]);
            	}
            	

            	$no++;

            	$rows[] = [
    				hgenerator::columns_align($no,'center'),
        				$dt->bidang_lbu_kode,
        				$dt->lbu_nama,
        				$dt->bidang_lbu_nama,
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

	public function add($id = NULL)
	{
		if($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {
			if(hprotection::must_ajax($this->_module . '/add')) {
				
				$data['id'] 	 = $id;
				$data['pageTitle']  = 'TAMBAH ' . $this->_title;
				$data['_modul']		 = $this->_module;
				$data['formAction'] = $this->_module .'/save/'. $id;
				$data['golongan'] = $this->lbu_model->options([], ['' => '-']); 

				if($id) {

					$data['pageTitle'] = 'UBAH ' . $this->_title;
					$data['data']      = $this->bidang_lbu_model->data($id)->get()->row();
				}

				$this->load->view($this->_module . '/form' ,$data);
			}

		} else {
			echo Modules::run('template/error_message/error_forbidden');
		}

	}

	public function edit($id) {
    # Cek data edit
        if ($this->bidang_lbu_model->data($id)->count_all_results() > 0) {
            $this->add($id);
        } else {
            echo Modules::run('template/error_message/error_404');
        }
    }

	public function save($id = NULL)
	{
		if($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {

			if(hprotection::must_ajax($this->_module .'/404')) {
				$unique_kode = NULL;

				if(!$id) {
                    $unique_kode = '|is_unique[m_bidang_lbu.bidang_lbu_kode]';
                } else {
                    $query = $this->bidang_lbu_model->data($id)->get()->row();
                    if($this->input->post('bidang_lbu_kode') !== $query->bidang_lbu_kode) 
                    	$unique_kode = '|is_unique[m_bidang_lbu.bidang_lbu_kode]';
                }

                $this->form_validation->set_rules('bidang_lbu_kode', '<i class="fa fa-warning"> Kode</i>', 'trim|required|max_length[200]' .$unique_kode);
                $this->form_validation->set_rules('lbu_id', '<i class="fa fa-warning"> Golongan</i>', 'trim|required');
				
				if ($this->form_validation->run($this)) {

					$data =[
						'lbu_id'          => $this->input->post('lbu_id'),
                        'bidang_lbu_kode' => $this->input->post('bidang_lbu_kode'),
                        'bidang_lbu_nama' => $this->input->post('bidang_lbu_nama'), 
                        'persen_penyusutan' => $this->input->post('persen_penyusutan'),
                        'masa_penyusutan' => $this->input->post('masa_penyusutan'),
                        'gl_aset' => $this->input->post('gl_aset'), 
                        'gl_debit' => $this->input->post('gl_debit'),
                        'gl_kredit' => $this->input->post('gl_kredit'), 
					];

					if($id) {
						
						if($this->bidang_lbu_model->update($id, $data)) {
							$message = ['type' => 'info', 'message' => 'Data Berhasil Di update','return' => '__afterSubmit(false)'];
							
							# LOG
                            $this->log_activity_model->save([
                                        'module'   => $this->_module,
                                        'sistem'   => TRUE,
                                        'event'    => 'Update',
                                        'activity' => 'Update Master Bidang LBU'
                            ]);
						}

					} else {

						if($this->bidang_lbu_model->create($data)) {
							$message = ['message' => 'Data Berhasil Di simpan','return' => '__afterSubmit()'];
							
							# LOG
                            $this->log_activity_model->save([
                                        'module'   => $this->_module,
                                        'sistem'   => TRUE,
                                        'event'    => 'Insert',
                                        'activity' => 'Insert Master Bidang LBU'
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

	public function delete($id = NULL)
	{
		if ($this->laccess->otoritas('delete')) {
            # Cek data edit
            if ($this->bidang_lbu_model->data($id)->count_all_results() > 0) {
                if ($this->bidang_lbu_model->delete($id)) {
                    $message = ['type' => 'info', 'message' => 'Data Berhasil Dihapus','return' => '__reloadTable(false)'];
                	
                	# LOG
                    $this->log_activity_model->save([
                                'module'   => $this->_module,
                                'sistem'   => TRUE,
                                'event'    => 'Delete',
                                'activity' => 'Delete Master Bidang LBU'
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