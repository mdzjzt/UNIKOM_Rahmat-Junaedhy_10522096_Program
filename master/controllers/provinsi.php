<?php

	class provinsi extends MX_Controller
	{

		private $_class_name = NULL;
		private $_title		 = 'Provinsi';
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
		}

		public function index()
		{
			if(hprotection::must_ajax($this->_module)):
				$data = array(
								'page_title' => 'MASTER '.$this->_title,
								'_modul'	 => $this->_module,
								'_title'	 => $this->_title,
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
				$cond = [];

				if(!empty($this->input->post('keyword'))) {
					$cond["(LOWER(a.provinsi_nama) ILIKE '%{$this->input->post('keyword')}%') "] = NULL;
				}

	            $dataCount  = $this->provinsi_model->data($cond)->count_all_results();
	            $dataResult = $this->provinsi_model->data($cond, $orderBy, $direction, $limit, $offset)->get();
				
	            $rows = [];
	            $no   = $offset;

	            foreach ($dataResult->result() as $dt):

	            	$id  	= $dt->provinsi_id;

	            	$action = NULL;

	            	if($this->laccess->otoritas('edit')):
	            		$action .= anchor($this->_module . '/edit/' . $id, '<i class="fa fa-edit"></i></a>',array(
								'class'          => "btn btn-warning btn-xs margin-right-2",
								'data-toggle'    => "modal",
								'data-target'    => "#remoteModal",
								'data-keyboard'  => "false",
								'data-backdrop'  => "static",
								'rel'            => 'tooltip',
								'data-placement' => "top",
								'title'          => 'Ubah',
	            			));
	            	endif;

	            	if($this->laccess->otoritas('delete')):
	            		$action .= anchor(NULL, '<i class="fa fa-trash-o"></i></a>', array(
								'class'          => 'btn btn-danger btn-xs',
								'rel'            => 'tooltip',
								'data-placement' => "top",
								'data-title'     => 'Hapus',
								'data-url'       => base_url() . $this->_module . '/delete/'. $id,
								'onclick'	     => '$(this).myForm().submit(\'delete\')'
	            			));
	            	endif;

	            	$no++;

	            	$rows[] = array(
	            				hgenerator::columns_align($no,'center'),
		            				$dt->provinsi_id,
		            				$dt->provinsi_nama,
	            				hgenerator::button_action($action),
	            			);

	            endforeach;

	            $data = array(
	            			'draw' 			  => $draw,
	            			'recordsTotal' 	  => $dataCount,
	            			'recordsFiltered' => $dataCount,
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

					if($id):

						$data['page_title']	= 'Ubah ' . $this->_title;
						$data_edit = $this->provinsi_model->data($id)->get();

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
	        if ($this->provinsi_model->data($id)->count_all_results() > 0) {
	            $this->add($id);
	        } else {
	            echo Modules::run('template/error_message/error_404');
	        }
	    }

		public function proses()
		{
			if($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')):

				if(hprotection::must_ajax($this->_module .'/404')):

					$id 	 = $this->input->post('edit_id');

					#check exist
					$exist_kode = NULL;
					$kode       = trim($this->input->post('provinsi_id'));

					if(!$id):
						if(!empty($kode)):
							$check_kode = $this->provinsi_model->is_exist($kode);
							if($check_kode):
								$exist_kode = '|is_exist';
							endif;
						endif;
					endif;


					$this->form_validation->set_rules('provinsi_id', '<i class="fa fa-warning"> Kode</i>', 'trim|required|max_length[200]' .$exist_kode);
					$this->form_validation->set_rules('provinsi_name', '<i class="fa fa-warning"> Nama Provinsi</i>', 'trim|required|max_length[200]');

					if($this->form_validation->run($this)):
						$message = ['error' => true, 'message' => 'Terjadi error pada saat penyimpanan, silahkan coba lagi.'];

						$data = [
									'provinsi_id' => $this->input->post('provinsi_id'),
									'provinsi_nama' => $this->input->post('provinsi_name')
								];

						if($id):
							if($this->provinsi_model->update($id,$data)):
								$message = ['type' => 'info', 'message' => 'Data Berhasil Diupdate','return' => '_afterSubmit(false)'];
							endif;
						else:
							if($this->provinsi_model->create($data)):
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
				$check = $this->provinsi_model->data($id)->count_all_results();

				if($check > 0):
					if($this->provinsi_model->delete($id)):
						$message = ['type' => 'info', 'message' => 'Data Berhasil Dihapus','return' => '_afterDelete(false)'];
					else:
						$message = ['error' => TRUE, 'message' => 'Proses Gagal'];
					endif;
				else:
					$message = array('error' => TRUE, 'message' => 'Data yang akan dihapus tidak ditemukan.');
				endif;

				echo json_encode($message);

			else:
				echo Modules::run('template/error_message/error_forbidden');
			endif;
		}
	}
