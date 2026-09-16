<?php

	class pegawai extends MX_Controller
	{
		
		private $_class_name = NULL;
		private $_title		 = ' PEGAWAI';
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
			$this->load->model('pegawai_model'); 
			$this->load->model('cabang_model'); 
			$this->load->model('jabatan_model'); 
			$this->load->model('unit_kerja_model'); 
			$this->load->model('department_model'); 
			

			$this->load->module('template/app_config');
		}

		public function index()
		{	
			if(hprotection::must_ajax($this->_module)) {

				$data = [
					'pageTitle'  => $this->_title,
					'_modul'	 => $this->_module,
					'_title'	 => $this->_title, 
					'cabang'	 => $this->cabang_model->options([], ['' => '-']),
					'jabatan'	 => $this->jabatan_model->options([], ['' => '-']),
					'unit'	 	 => $this->unit_kerja_model->options([], ['' => '-']),
				];

				# LOG
	            $this->log_activity_model->save([
	                        'module'   => $this->_module,
	                        'event'    => 'View',
	                        'activity' => 'View Master Pegawai'
	            ]);

				$this->load->view($this->_module.'/index',$data);
			}
		}

		public function load()
		{
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

            if(!empty($this->input->post('cabang_id'))) {
            	$cond['a.cabang_id'] = $this->input->post('cabang_id');
            }

            if(!empty($this->input->post('unit_kerja_id'))) {
            	$cond['a.unit_kerja_id'] = $this->input->post('unit_kerja_id');
            }

            if(!empty($this->input->post('jabatan_id'))) {
            	$cond['a.jabatan_id'] = $this->input->post('jabatan_id');
            }

            if (!empty($this->input->post('keyword'))) {
                $cond["(LOWER(a.pegawai_nik) ILIKE '%{$this->input->post('keyword')}%' OR LOWER(a.pegawai_nama) ILIKE '%{$this->input->post('keyword')}%' )"] = NULL;
            }

            $dataCount          = $this->pegawai_model->data()->count_all_results();
            $dataCountFiltered  = $this->pegawai_model->data($cond)->count_all_results();
            $dataResult         = $this->pegawai_model->data($cond, $orderBy, $direction, $limit, $offset)->get();

            $rows = [];
            $no   = $offset;

            foreach ($dataResult->result() as $dt) {
            	
            	$id  	= $dt->pegawai_id;

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
    					$dt->pegawai_nik,
        				$dt->pegawai_nama,
        				//date('d/m/Y',strtotime($dt->tgl_masuk)),
        				// $dt->cabang_nama,
        				$dt->jabatan_nama,
        				$dt->pegawai_email,
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

		public function add($id = NULL)
		{
			if($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {
				if(hprotection::must_ajax($this->_module . '/add')) {

					$data['pageTitle']  = 'TAMBAH ' . $this->_title;
					$data['_modul']		 = $this->_module;
					$data['formAction']  = $this->_module .'/save/'. $id;

					# CEK EDIT
					$data['edit_id'] 	 = $id;
					# OPTIONS
					$data['cabang']    = $this->cabang_model->options([], ['' => '-']);
					$data['jabatan']   = $this->jabatan_model->options([], ['' => '-']);
					$data['unit']      = $this->unit_kerja_model->options([], ['' => '-']);
					$data['department_project']  = $this->department_model->options(array(), array('' => '-- Pilih Department --'));

					if($id) {

						$data['pageTitle']	= 'UBAH ' . $this->_title;
						$data['data']		 = $this->pegawai_model->data($id)->get()->row();
					}

					$this->load->view($this->_module . '/form' ,$data);
				}

			} else {
				echo Modules::run('template/error_message/error_forbidden');
			}

		}

		public function edit($id = NULL) {
        # Cek data edit
	        if ($this->pegawai_model->data($id)->count_all_results() > 0) {
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
	                    $unique_kode = '|is_unique[hr_pegawai.pegawai_nik]';
	                } else {
	                    $query = $this->pegawai_model->data($id)->get()->row();
	                    if($this->input->post('pegawai_nik') !== $query->pegawai_nik) 
	                    	$unique_kode = '|is_unique[hr_pegawai.pegawai_nik]';
	                }

	                $this->form_validation->set_rules('pegawai_nik', '<i class="fa fa-warning"> NIK</i>', 'trim|required|max_length[200]' .$unique_kode);
	                $this->form_validation->set_rules('pegawai_nama', '<i class="fa fa-warning"> Nama</i>', 'trim|required');
	                $this->form_validation->set_rules('pegawai_email', '<i class="fa fa-warning"> Email</i>', 'trim|valid_email');
					// $this->form_validation->set_rules('cabang_id', '<i class="fa fa-warning"> Cabang</i>', 'trim|required');
					$this->form_validation->set_rules('jabatan_id', '<i class="fa fa-warning"> Jabatan</i>', 'trim|required');
					// $this->form_validation->set_rules('unit_kerja_id', '<i class="fa fa-warning"> Unit Kerja</i>', 'trim|required');

					if ($this->form_validation->run($this)) {

						$path = $this->app_config->info('pegawai_image');

	                    if(!file_exists($path)) mkdir($path,0777,TRUE);
	                    if(!empty($_FILES['image'])) {
	                        $files = $_FILES['image'];
	                    }

	                    if(!empty($_FILES['imagettd'])) {
	                        $filesttd = $_FILES['imagettd'];
	                    }

	                    $this->load->library('upload');
	                        
	                    $config  = [
	                        'upload_path'   => $path,
	                        'allowed_types' => 'jpg|png|jpeg',            
	                    ];  

	                    $this->upload->initialize($config);

	                    $image = [];
	                    if(!empty($_FILES['image'])) {
	                        $_FILES['image']['name']     = $files['name'];
	                        $_FILES['image']['type']     = $files['type'];
	                        $_FILES['image']['tmp_name'] = $files['tmp_name'];
	                        $_FILES['image']['error']    = $files['error'];
	                        $_FILES['image']['size']     = $files['size'];
	                        
	                        if($this->upload->do_upload('image')) {
	                            $dataUpload = $this->upload->data();
	                            $image[] = [
	                                    'file'      => $config['upload_path'].$dataUpload['file_name'],
	                                    'filename'  => $dataUpload['file_name'],
	                            ];
	                        } 
	                    }

	                    $imagettd = [];
	                    if(!empty($_FILES['imagettd'])) {
	                        $_FILES['imagettd']['name']     = $filesttd['name'];
	                        $_FILES['imagettd']['type']     = $filesttd['type'];
	                        $_FILES['imagettd']['tmp_name'] = $filesttd['tmp_name'];
	                        $_FILES['imagettd']['error']    = $filesttd['error'];
	                        $_FILES['imagettd']['size']     = $filesttd['size'];
	                        
	                        if($this->upload->do_upload('imagettd')) {
	                            $dataUploadd = $this->upload->data();
	                            $imagettd[] = [
	                                    'file'      => $config['upload_path'].$dataUploadd['file_name'],
	                                    'filename'  => $dataUploadd['file_name'],
	                            ];
	                        } 
	                    }

						$data =[
							'pegawai_nik'     => $this->input->post('pegawai_nik'),
							'pegawai_nama'    => $this->input->post('pegawai_nama'), 
							'pegawai_alamat'  => $this->input->post('pegawai_alamat'), 
							'pegawai_contact' => $this->input->post('pegawai_contact'), 
							'pegawai_email'   => $this->input->post('pegawai_email'), 
							'pegawai_email_new'   => $this->input->post('pegawai_email_2'), 
							//'tgl_masuk'     => $this->input->post('tgl_masuk'),
							// 'cabang_id'       => $this->input->post('cabang_id') ? , 
							// 'jabatan_id'      => $this->input->post('jabatan_id'), 
							'department_pegawai'   => $this->input->post('deparment') ? $this->input->post('deparment') : 0,
							'cabang_id'       => 0, 
							'jabatan_id'      => $this->input->post('jabatan_id'), 
							'unit_kerja_id'   => 0,
							'foto'            => json_encode($image),
							'ttd_pegawai'            => json_encode($imagettd)
						];

						if($id) {
							
							if($this->pegawai_model->update($id, $data)) {
								$message = ['type' => 'info', 'message' => 'Data Berhasil Di update','return' => '__afterSubmit(false)'];
								# LOG
	                            $this->log_activity_model->save([
	                                        'module'   => $this->_module,
	                                        'sistem'   => TRUE,
	                                        'event'    => 'Insert',
	                                        'activity' => 'Insert Master Pegawai'
	                            ]);
							}

						} else {

							if($this->pegawai_model->create($data)) {
								$message = ['message' => 'Data Berhasil Di simpan','return' => '__afterSubmit()'];
								# LOG
	                            $this->log_activity_model->save([
	                                        'module'   => $this->_module,
	                                        'sistem'   => TRUE,
	                                        'event'    => 'Update',
	                                        'activity' => 'Update Master Pegawai'
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
	           
	            if ($this->pegawai_model->data($id)->count_all_results() > 0) {
	                if ($this->pegawai_model->delete($id)) {
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