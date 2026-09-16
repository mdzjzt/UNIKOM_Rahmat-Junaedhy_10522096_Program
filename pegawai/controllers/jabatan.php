<?php

	class jabatan extends MX_Controller
	{

		private $_class_name = NULL;
		private $_title		 = 'JABATAN';
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
			$this->load->model('jabatan_model');
			$this->load->model('kelompok_jabatan_model');
			$this->load->model('jenis_jabatan_model');
		}

		public function index()
		{
			if(hprotection::must_ajax($this->_module)) {
				$data = [
					'pageTitle'  => $this->_title,
					'_modul'	 => $this->_module,
					'_title'	 => $this->_title,
					'kelompok'	 => $this->kelompok_jabatan_model->options([], ['' => '-']),
					'jenis'	 	 => $this->jenis_jabatan_model->options([], ['' => '-']),
				];

				# LOG
	            $this->log_activity_model->save([
	                        'module'   => $this->_module,
	                        'event'    => 'View',
	                        'activity' => 'View Master Jabatan'
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
	            $orderBy   = 'jabatan_nama';
	            $direction = NULL;

	            if($extraColumn[$extraOrder[0]['column']]['orderable'] == 'true') {
	                $orderBy = isset($extraColumn[$extraOrder[0]['column']]['name']) ? $extraColumn[$extraOrder[0]['column']]['name'] : NULL;
	                $direction   = $extraOrder[0]['dir'];
	            }

	            # Condition
	            $cond = [];

	            if(!empty($this->input->post('kelompok_jabatan_id'))) {
	            	$cond['a.kelompok_jabatan_id'] = $this->input->post('kelompok_jabatan_id');
	            }

	            if(!empty($this->input->post('jenis_jabatan_id'))) {
	            	$cond['a.jenis_jabatan_id'] = $this->input->post('jenis_jabatan_id');
	            }

	            if (!empty($this->input->post('keyword'))) {
	                $cond["(LOWER(a.jabatan_id) ILIKE '%{$this->input->post('keyword')}%' OR LOWER(a.jabatan_nama) ILIKE '%{$this->input->post('keyword')}%' )"] = NULL;
	            }

	            $dataCount          = $this->jabatan_model->data()->count_all_results();
	            $dataCountFiltered  = $this->jabatan_model->data($cond)->count_all_results();
	            $dataResult         = $this->jabatan_model->data($cond, $orderBy, $direction, $limit, $offset)->get();

	            $rows = [];
            	$no   = $offset;

	            foreach ($dataResult->result() as $dt) {

	            	$id  	= $dt->jabatan_id;

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
		            				$dt->jabatan_id,
		            				$dt->jabatan_nama,
		            				// $dt->jenis_jabatan_nama,
		            				// $dt->kelompok_jabatan_nama,
		            				// $dt->jabatan_tunjangan != 0 ? number_format($dt->jabatan_tunjangan) : '',
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

				$data['kelompok']    = $this->kelompok_jabatan_model->options([], ['' => '-']);
				$data['jenis']		 = $this->jenis_jabatan_model->options([], ['' => '-']);

				if($id) {
					$data['pageTitle']   = 'UBAH ' . $this->_title;
					$data['data']		 = $this->jabatan_model->data($id)->get()->row();
				}

				$this->load->view($this->_module . '/form' ,$data);

			} else {
				echo Modules::run('template/error_message/error_forbidden');
			}

		}

		public function edit($id = NULL) {
        # Cek data edit
	        if ($this->jabatan_model->data($id)->count_all_results() > 0) {
	            $this->add($id);
	        } else {
	            echo Modules::run('template/error_message/error_404');
	        }
	    }

		public function save($id = NULL)
		{
			if($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {

				if(hprotection::must_ajax($this->_module .'/404')) {
					// $unique_kode = NULL;

					// if(!$id) {
	    //                 $unique_kode = '|is_unique[hr_ref_jabatan.jabatan_id]';
	    //             } else {
	    //                 $query = $this->jabatan_model->data($id)->get()->row();
	    //                 if($this->input->post('jabatan_id') !== $query->jabatan_id)
	    //                 	$unique_kode = '|is_unique[hr_ref_jabatan.jabatan_id]';
	    //             }

	                // $this->form_validation->set_rules('jabatan_id', '<i class="fa fa-warning"> Kode</i>', 'trim|required|max_length[200]' .$unique_kode);
	                $this->form_validation->set_rules('jabatan_nama', '<i class="fa fa-warning"> Nama Cabang</i>', 'trim|required|max_length[200]');

					if ($this->form_validation->run($this)) {

						$data =[
							'jabatan_id'	  => $this->input->post('jabatan_id'),
							'jabatan_nama'	  => $this->input->post('jabatan_nama'),
							// 'kelompok_jabatan_id' => $this->input->post('kelompok_jabatan_id') ? $this->input->post('kelompok_jabatan_id') : NULL,
							// 'jenis_jabatan_id' => $this->input->post('jenis_jabatan_id') ? $this->input->post('jenis_jabatan_id') : NULL,
							'kelompok_jabatan_id' =>  NULL,
							'jenis_jabatan_id' => NULL,
						];

						if($id) {

							if($this->jabatan_model->update($id, $data)) {
								$message = ['type' => 'info', 'message' => 'Data Berhasil Di update','return' => '__afterSubmit(false)'];
								# LOG
	                            $this->log_activity_model->save([
	                                        'module'   => $this->_module,
	                                        'sistem'   => TRUE,
	                                        'event'    => 'Insert',
	                                        'activity' => 'Insert Master Jabatan'
	                            ]);
							}

						} else {

							if($this->jabatan_model->create($data)) {
								$message = ['message' => 'Data Berhasil Di simpan','return' => '__afterSubmit()'];
								# LOG
	                            $this->log_activity_model->save([
	                                        'module'   => $this->_module,
	                                        'sistem'   => TRUE,
	                                        'event'    => 'Update',
	                                        'activity' => 'Update Master Jabatan'
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

	            if ($this->jabatan_model->data($id)->count_all_results() > 0) {
	                if ($this->jabatan_model->delete($id)) {
	                    $message = ['type' => 'info', 'message' => 'Data Berhasil Dihapus','return' => '__reloadTable(false)'];
	                	# LOG
	                    $this->log_activity_model->save([
	                                'module'   => $this->_module,
	                                'sistem'   => TRUE,
	                                'event'    => 'Delete',
	                                'activity' => 'Delete Master Jabatan'
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
