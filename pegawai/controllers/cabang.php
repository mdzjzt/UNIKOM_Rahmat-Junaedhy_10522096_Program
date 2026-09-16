<?php

	class cabang extends MX_Controller
	{
		
		private $_class_name = NULL;
		private $_title		 = 'CABANG';
		private $_module	 = 'pegawai';


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
			$this->load->model('cabang_model'); 
		}

		public function index()
		{	
			if(hprotection::must_ajax($this->_module)) {
				$data = [
					'pageTitle'  => $this->_title,
					'_modul'	 => $this->_module,
					'_title'	 => $this->_title, 
				];

				# LOG
	            $this->log_activity_model->save([
	                        'module'   => $this->_module,
	                        'event'    => 'View',
	                        'activity' => 'View Master Cabang'
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

	            $dataCount          = $this->cabang_model->data()->count_all_results();
	            $dataCountFiltered  = $this->cabang_model->data($cond)->count_all_results();
	            $dataResult         = $this->cabang_model->data($cond, $orderBy, $direction, $limit, $offset)->get();

	            $rows = [];
            	$no   = $offset;

	            foreach ($dataResult->result() as $dt) {
	            	
	            	$id  	= $dt->cabang_id;

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

	            	$rows[] = array(
	            				hgenerator::columns_align($no,'center'),
		            				$dt->cabang_id,
		            				$dt->cabang_nama,
		            				
		            				$dt->cabang_alamat.' '.$dt->kota_nama,
		            				$dt->cabang_telepon,
		            				$dt->cabang_rekening,
		            				$dt->kode_lokasi,
	            				hgenerator::button_action($action),
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

		public function add($id = NULL)
		{
			if($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {
				$data['pageTitle']   = 'TAMBAH ' . $this->_title;
				$data['_modul']		 = $this->_module;
				$data['formAction']  = $this->_module .'/save/'. $id;
				$this->load->model('kotamadya_model');
				$data['kotamadya'] = $this->kotamadya_model->options(array(), array('' => '--Pilih Kota--'));
				if($id) {
					$data['pageTitle']   = 'UBAH ' . $this->_title;
					$data['data']		 = $this->cabang_model->data($id)->get()->row();
				}

				$this->load->view($this->_module . '/form' ,$data);

			} else {
				echo Modules::run('template/error_message/error_forbidden');
			}

		}

		public function edit($id = NULL) 
		{
	        if ($this->cabang_model->data($id)->count_all_results() > 0) {
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
	                    $unique_kode = '|is_unique[hr_ref_cabang.cabang_id]';
	                } else {
	                    $query = $this->cabang_model->data($id)->get()->row();
	                    if($this->input->post('cabang_id') !== $query->cabang_id) 
	                    	$unique_kode = '|is_unique[hr_ref_cabang.cabang_id]';
	                }

	                $this->form_validation->set_rules('cabang_id', '<i class="fa fa-warning"> Kode</i>', 'trim|required|max_length[200]' .$unique_kode);
	                $this->form_validation->set_rules('cabang_nama', '<i class="fa fa-warning"> Nama Cabang</i>', 'trim|required|max_length[200]');

					if ($this->form_validation->run($this)) {

						$data =[
							'cabang_id' 	  => $this->input->post('cabang_id'),
							'cabang_nama'	  => $this->input->post('cabang_nama'), 
							'cabang_alamat'   => $this->input->post('cabang_alamat'), 
							'cabang_telepon'  => $this->input->post('cabang_telepon'), 
							'cabang_rekening' => $this->input->post('cabang_rekening'), 
							'kode_lokasi' 	  => $this->input->post('kode_lokasi'),
							'kota_id' 	  => $this->input->post('kota_id'),
						];

						if($id) {
							
							if($this->cabang_model->update($id, $data)) {
								$message = ['type' => 'info', 'message' => 'Data Berhasil Di update','return' => '__afterSubmit(false)'];
								# LOG
	                            $this->log_activity_model->save([
	                                        'module'   => $this->_module,
	                                        'sistem'   => TRUE,
	                                        'event'    => 'Insert',
	                                        'activity' => 'Insert Master Cabang'
	                            ]);
							}

						} else {

							if($this->cabang_model->create($data)) {
								$message = ['message' => 'Data Berhasil Di simpan','return' => '__afterSubmit()'];
								# LOG
	                            $this->log_activity_model->save([
	                                        'module'   => $this->_module,
	                                        'sistem'   => TRUE,
	                                        'event'    => 'Update',
	                                        'activity' => 'Update Master Cabang'
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
	           
	            if ($this->cabang_model->data($id)->count_all_results() > 0) {
	                if ($this->cabang_model->delete($id)) {
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