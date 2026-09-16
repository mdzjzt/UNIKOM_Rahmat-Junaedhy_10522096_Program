<?php

	class cabang extends MX_Controller
	{
		
		private $_class_name = NULL;
		private $_title		 = 'Cabang';
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
			$this->load->model('master_cabang_model'); 
		}

		public function index()
		{	
			if(hprotection::must_ajax($this->_module)) {
				$data = [
					'pageTitle' => 'MASTER '.$this->_title,
					'_modul'	 => $this->_module,
					'_title'	 => $this->_title, 
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
	            $orderBy   = 'cabang_nama';
	            $direction = NULL;

	            if($extraColumn[$extraOrder[0]['column']]['orderable'] == 'true') {
	                $orderBy = isset($extraColumn[$extraOrder[0]['column']]['name']) ? $extraColumn[$extraOrder[0]['column']]['name'] : NULL;
	                $direction   = $extraOrder[0]['dir'];
	            }

				# Condition
	            $cond = [];

	            if (!empty($this->input->post('keyword'))) {
	                $cond["(LOWER(a.cabang_id) ILIKE '%{$this->input->post('keyword')}%' OR LOWER(a.cabang_nama) ILIKE '%{$this->input->post('keyword')}%' )"] = NULL;
	            }

	            $dataCount          = $this->master_cabang_model->data()->count_all_results();
	            $dataCountFiltered  = $this->master_cabang_model->data($cond)->count_all_results();
	            $dataResult         = $this->master_cabang_model->data($cond, $orderBy, $direction, $limit, $offset)->get();

	            $rows = [];
	            $no   = $offset;

	            foreach ($dataResult->result() as $dt) {
	            	
	            	$id  	= $dt->cabang_id;

	            	$action = NULL;

	            	if($this->laccess->otoritas('edit')) {
	            		$action .= anchor($this->_module . '/edit/' . $id, '<i class="fa fa-edit"></i></a>', 
	            			[
	            				'class'          => 'btn btn-info btn-xs',
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
            				$dt->cabang_id,
            				$dt->cabang_nama,
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
					$data['id']         = $id;
					$data['pageTitle']  = 'TAMBAH ' . $this->_title;
					$data['_modul']     = $this->_module;
					$data['formAction'] = $this->_module .'/save/'. $id;

					if($id) {

						$data['pageTitle']	= 'UBAH ' . $this->_title;
						$data['data'] = $this->master_cabang_model->data($id)->get()->row();
					}

					$this->load->view($this->_module . '/form' ,$data);
				}

			} else {
				echo Modules::run('template/error_message/error_forbidden');
			}

		}

		public function edit($id) {
        # Cek data edit
	        if ($this->master_cabang_model->data($id)->count_all_results() > 0) {
	            $this->add($id);
	        } else {
	            echo Modules::run('template/error_message/error_404');
	        }
	    }

		public function save($id = NULL)
		{
			if($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {

				if(hprotection::must_ajax($this->_module .'/404')) {
					
					#check exist
					$unique_kode = NULL;
					$unique_nama = NULL;

					if(!$id) {
	                    $unique_kode = '|is_unique[m_cabang.cabang_id]';
	                    $unique_nama = '|is_unique[m_cabang.cabang_nama]';
	                } else {
	                    $query = $this->master_cabang_model->data($id)->get()->row();

	                    if($this->input->post('cabang_id') !== $query->cabang_id) 
	                    	$unique_kode = '|is_unique[m_cabang.cabang_id]';

	                    if($this->input->post('cabang_nama') !== $query->cabang_nama) 
	                    	$unique_nama = '|is_unique[m_cabang.cabang_nama]';
	                }

					$this->form_validation->set_rules('cabang_id', '<i class="fa fa-warning"> Kode</i>', 'trim|required|max_length[200]' .$unique_kode);
					$this->form_validation->set_rules('cabang_nama', '<i class="fa fa-warning"> Nama Cabang</i>', 'trim|required|max_length[200]' .$unique_nama);

					if($this->form_validation->run($this)) {

						$data = [
							'cabang_id'   => $this->input->post('cabang_id'),
							'cabang_nama' => $this->input->post('cabang_nama'), 
						];

						if($id) {
							if($this->master_cabang_model->update($id,$data)) {
								$message = ['type' => 'info', 'message' => 'Data Berhasil Di update','return' => '__afterSubmit(false)'];
								# LOG
	                            $this->log_activity_model->save([
	                                        'module'   => $this->_module,
	                                        'sistem'   => TRUE,
	                                        'event'    => 'Update',
	                                        'activity' => 'Update Master Cabang'
	                            ]);
							}

						} else {

							if($this->master_cabang_model->create($data)) {
								$message = ['message' => 'Data Berhasil Di simpan','return' => '__afterSubmit()'];
								# LOG
	                            $this->log_activity_model->save([
	                                        'module'   => $this->_module,
	                                        'sistem'   => TRUE,
	                                        'event'    => 'Insert',
	                                        'activity' => 'Insert Master Cabang'
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
	            if ($this->master_cabang_model->data($id)->count_all_results() > 0) {
	                if ($this->master_cabang_model->delete($id)) {
	                    $message = ['type' => 'info', 'message' => 'Data Berhasil Dihapus','return' => '__reloadTable(false)'];
	                	
	                	# LOG
	                    $this->log_activity_model->save([
	                                'module'   => $this->_module,
	                                'sistem'   => TRUE,
	                                'event'    => 'Delete',
	                                'activity' => 'Delete Master Cabang'
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