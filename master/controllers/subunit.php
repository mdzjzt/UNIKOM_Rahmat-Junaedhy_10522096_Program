<?php

	class subunit extends MX_Controller
	{
		
		private $_class_name = NULL;
		private $_title		 = 'Sub Unit';
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
			$this->load->model('subunit_model'); 
		}

		public function index()
		{
			if(hprotection::must_ajax($this->_module)):
				$data = array(
								'pageTitle'  => 'MASTER '.$this->_title,
								'_modul'	 => $this->_module,
								'_title'	 => $this->_title, 
							);
				$this->load->view($this->_module.'/index',$data);
			endif;
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
	            $orderBy   = 'subunit_kode';
	            $direction = NULL;

	            if($extraColumn[$extraOrder[0]['column']]['orderable'] == 'true') {
	                $orderBy = isset($extraColumn[$extraOrder[0]['column']]['name']) ? $extraColumn[$extraOrder[0]['column']]['name'] : NULL;
	                $direction   = $extraOrder[0]['dir'];
	            }

				# Condition
	            $cond = [];

	            if (!empty($this->input->post('keyword'))) {
	                $cond["(LOWER(a.subunit_kode) ILIKE '%{$this->input->post('keyword')}%' OR LOWER(a.subunit_name) ILIKE '%{$this->input->post('keyword')}%' )"] = NULL;
	            }

	            $dataCount          = $this->subunit_model->data()->count_all_results();
	            $dataCountFiltered  = $this->subunit_model->data($cond)->count_all_results();
	            $dataResult         = $this->subunit_model->data($cond, $orderBy, $direction, $limit, $offset)->get();

	            $rows = [];
	            $no   = $offset;

	            foreach ($dataResult->result() as $dt) {
	            	
	            	$id  	= $dt->subunit_id;

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
	        				$dt->subunit_kode,
		            		$dt->subunit_name,
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

				$data['pageTitle']  = 'Tambah ' . $this->_title;
				$data['_modul']		 = $this->_module;
				$data['formAction'] = $this->_module .'/save/' . $id;

				if($id) {
					$data['pageTitle']  = 'Ubah ' . $this->_title;
					$data['data'] = $this->subunit_model->data($id)->get()->row();
				}

				$this->load->view($this->_module . '/form' ,$data);

			} else {
				echo Modules::run('template/error_message/error_forbidden');
			}

		}

		public function edit($id = NULL) {
        # Cek data edit
	        if ($this->subunit_model->data($id)->count_all_results() > 0) {
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
	                    $unique_kode = '|is_unique[m_subunit.subunit_kode]';
	                } else {
	                    $query = $this->subunit_model->data($id)->get()->row();
	                    if($this->input->post('subunit_kode') !== $query->subunit_kode) 
	                    	$unique_kode = '|is_unique[m_subunit.subunit_kode]';
	                }

					$this->form_validation->set_rules('subunit_kode', '<i class="fa fa-warning"> Kode</i>', 'trim|required|max_length[200]' .$unique_kode);
					$this->form_validation->set_rules('subunit_name', '<i class="fa fa-warning"> Sub Unit</i>', 'trim|required|max_length[200]');

					if($this->form_validation->run($this)) {
						$data =[
							'subunit_kode' => $this->input->post('subunit_kode'),
							'subunit_name'	  => $this->input->post('subunit_name'), 
						];

						if($id) {
						
							if($this->subunit_model->update($id, $data)) {
								$message = ['type' => 'info', 'message' => 'Data Berhasil Di update','return' => '__afterSubmit(false)'];
							}

						} else {

							if($this->subunit_model->create($data)) {
								$message = ['message' => 'Data Berhasil Di simpan','return' => '__afterSubmit()'];
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
	            if ($this->subunit_model->data($id)->count_all_results() > 0) {
	                if ($this->subunit_model->delete($id)) {
	                    $message = ['type' => 'info', 'message' => 'Data Berhasil Dihapus','return' => '__reloadTable(false)'];
	                } else {
	                    $message = ['error' => TRUE, 'message' => 'Proses Gagal'];
	                }

	            } else {
	                $message = array('error' => TRUE, 'message' => 'Data yang akan dihapus tidak ditemukan.');
	            }

	            echo json_encode($message);

	        } else {
	            echo Modules::run('template/error_message/error_forbidden');
	        }
		}
	}