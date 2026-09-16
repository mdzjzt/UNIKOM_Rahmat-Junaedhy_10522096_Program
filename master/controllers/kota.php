<?php

	class kota extends MX_Controller
	{

		private $_class_name = NULL;
		private $_title		 = 'Kota';
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
			$this->load->model('provinsi_model');
			$this->load->model('kotamadya_model');
		}

		public function index()
		{
			if(hprotection::must_ajax($this->_module)):
				$data = array(
								'page_title' => 'MASTER '.$this->_title,
								'_modul'	 => $this->_module,
								'_title'	 => $this->_title,
								'provinsi'	 => $this->provinsi_model->options(array(), array('' => '--Choose Province--')),
							);

				$this->load->view($this->_module.'/index',$data);
			endif;
		}

		public function load()
		{
			if(hprotection::must_ajax($this->_module)):

				# Data Table
				$limit  = $this->input->post('length');
				$offset = $this->input->post('start');
				$draw   = $this->input->post('draw');
				$extraColumn = $this->input->post('columns');
				$extraOrder  = $this->input->post('order');

				# Ordering
				$orderBy   = 'provinsi_nama';
				$direction = NULL;

				if($extraColumn[$extraOrder[0]['column']]['orderable'] == 'true') {
					$orderBy = isset($extraColumn[$extraOrder[0]['column']]['name']) ? $extraColumn[$extraOrder[0]['column']]['name'] : NULL;
					$direction   = $extraOrder[0]['dir'];
				}

				# Condition
				$cond = array();

				if(!empty($this->input->post('provinsi_id'))) {
	                $cond["(a.provinsi_id = '{$this->input->post('provinsi_id')}')"] = NULL;
	            }

				if(!empty($this->input->post('keyword'))) {
	                $cond["(LOWER(a.kota_nama) ILIKE '%{$this->input->post('keyword')}%' ) "] = NULL;
	            }

	            $data_count  = $this->kotamadya_model->data($cond)->count_all_results();
	            $data_result = $this->kotamadya_model->data($cond, $orderBy, $direction, $limit, $offset)->get();

	            $rows = array();
	            $no   = $offset;

	            foreach ($data_result->result() as $dt):

	            	$id  	= $dt->kota_id;

	            	$action = NULL;

	            	if($this->laccess->otoritas('edit')):
	            		$action .= anchor($this->_module . '/edit/' . $id, '<i class="fa fa-edit"></i></a>',array(
	            				'class' 		=> "btn btn-warning btn-xs margin-right-2",
	            				'id'			=> "mybutton-edit-" . $id,
	            				'data-module' 	=> $this->_module,
	            				'data-toggle'	=> "modal",
	            				'data-target' 	=> "#remoteModal",
	            				'data-keyboard' => "false",
	            				'data-backdrop' => "static",
	            				'rel' => 'tooltip',
                                'data-placement' => "top",
                                'title'	=> 'Ubah',
	            			));
	            	endif;

	            	if($this->laccess->otoritas('delete')):
	            		$action .= anchor(NULL, '<i class="fa fa-trash-o"></i></a>', array(
	            				'class' 	=> 'btn btn-danger btn-xs',
	            				'id'		=> 'mybutton-delete-' . $id,
	            				'onclick'	=> 'my_data_table.row_action.ajax(this.id)',
	            				'rel' => 'tooltip',
                                'data-placement' => "top",
                                'title'	=> 'Hapus',
	            				'data-url'	=> base_url() . $this->_module . '/delete/' . $id
	            			));
	            	endif;

	            	$no++;

	            	$rows[] = array(
	            				hgenerator::columns_align($no,'center'),
		            				// $dt->kotamadya_kode,
		            				$dt->provinsi_nama,
		            				$dt->kota_nama,
	            				hgenerator::button_action($action),
	            			);

	            endforeach;

	            $data = array(
	            			'draw' 			  => $draw,
	            			'recordsTotal' 	  => $data_count,
	            			'recordsFiltered' => $data_count,
	            			'data'			  => $rows,
	            		);
	            echo json_encode($data);

	        endif;

		}

		public function add($id = NULL)
		{
			if($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')):
				if(hprotection::must_ajax($this->_module . '/add')):
					$data['page_title']  = 'Tambah ' . $this->_title;
					$data['_modul']		 = $this->_module;
					$data['form_action'] = $this->_module .'/proses';

					# CEK EDIT
					$data['edit_id'] 	 = $id;
					#options
                	$data['provinsi'] = $this->provinsi_model->options(array(), array('' => 'Choose Province'));
					if($id):

						$data['page_title']	= 'Ubah ' . $this->_title;
						$data_edit = $this->kotamadya_model->data($id)->get();

						if($data_edit->num_rows() > 0):
							$row = $data_edit->row();
							$data['data_edit'] = $row;
						endif;
					endif;

					$this->load->view($this->_module . '/form' ,$data);
				endif;

			else:
				echo Modules::run('template/error_message/error_forbidden');
			endif;

		}

		public function edit($id = NULL) {
        # Cek data edit
	        if ($this->kotamadya_model->data($id)->count_all_results() > 0) {
	            $this->add($id);
	        } else {
	            echo Modules::run('template/error_message/error_404');
	        }
	    }

		public function proses()
		{
			if($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')):

				if(hprotection::must_ajax($this->_module .'/404')):

					$id = $this->input->post('edit_id');

					#check exist
					$exist_kode = NULL;
					$kode       = trim($this->input->post('kotamadya_kode'));

					if(!$id):
						if(!empty($kode)):
							$check_kode = $this->kotamadya_model->is_exist($kode);
							if($check_kode):
								$exist_kode = '|is_exist';
							endif;
						endif;
					endif;

					$this->form_validation->set_rules('provinsi_id', '<i class="fa fa-warning"> Provinsi</i>', 'trim|required');
					$this->form_validation->set_rules('kotamadya_name', '<i class="fa fa-warning"> Nama Kota</i>', 'trim|required');

					if($this->form_validation->run($this)):
						$message = ['error' => true, 'message' => 'Terjadi error pada saat penyimpanan, silahkan coba lagi.'];

						$data = array(
										'provinsi_id' => $this->input->post('provinsi_id'),
										'kota_nama' => $this->input->post('kotamadya_name'),
									);

						if($id):
							if($this->kotamadya_model->update($id,$data)):
								$message = ['type' => 'info', 'message' => 'Data Berhasil Diupdate','return' => '_afterSubmit(false)'];
							endif;
						else:
							if($this->kotamadya_model->create($data)):
								$message = ['message' => 'Data Berhasil Disimpan','return' => '_afterSubmit()'];
							endif;
						endif;
					else:
						$message = ['error' => true, 'message' => 'Periksa kembali data input', 'callback' => $this->form_validation->get_errors_array()];
					endif;

					echo json_encode($message);

				endif;

			else:
				echo Modules::run('template/error_message/error_forbidden');
			endif;
		}

		public function delete($id = NULL)
		{
			if($this->laccess->otoritas('delete')):
				# CHECK
				$check = $this->kotamadya_model->data($id)->count_all_results();

				if($check > 0):
					if($this->kotamadya_model->delete($id)):
						$message = array(true, 'Proses Berhasil', 'Data berhasil dihapus.', 'my_data_table.reload("#dt_basic")');
					else:
						$message = array(false, 'Proses gagal', 'Data gagal dihapus.', '');
					endif;
				else:
					$message = array(false, 'Error', 'Data yang akan dihapus tidak ditemukan.', '');
				endif;

				echo json_encode($message);

			else:
				echo Modules::run('template/error_message/error_forbidden');
			endif;
		}
	}
