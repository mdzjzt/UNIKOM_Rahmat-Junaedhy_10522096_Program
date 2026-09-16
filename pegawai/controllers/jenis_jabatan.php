<?php

	class jenis_jabatan extends MX_Controller
	{
		
		private $_class_name = NULL;
		private $_title		 = 'JENIS JABATAN';
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
			$this->load->model('jenis_jabatan_model'); 
		}

		public function index()
		{	
			if(hprotection::must_ajax($this->_module)):
				$data = array(
								'page_title' => $this->_title,
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
				$extra_search = $this->input->post('extra_search');
				$data_cond    = hgenerator::seriliaze_decode($extra_search);

				# Condition
				$cond = array();
				if (!empty($data_cond['keyword'])):
	                $cond["(LOWER(a.jenis_jabatan_nama) ILIKE '%{$data_cond['keyword']}%') "] = NULL;
	            endif;

	            $data_count  = $this->jenis_jabatan_model->data($cond)->count_all_results();
	            $data_result = $this->jenis_jabatan_model->data($cond, 'jenis_jabatan_nama', 'asc', $limit, $offset)->get();

	            $rows = array();
	            $no   = $offset;

	            foreach ($data_result->result() as $dt):
	            	
	            	$id  	= $dt->jenis_jabatan_id;

	            	$action = NULL;

	            	if($this->laccess->otoritas('edit')):
	            		$action .= anchor($this->_module . '/edit/' . $id, '<i class="fa fa-edit"></i></a>',array(
								'class'          => "btn btn-warning btn-xs margin-right-2",
								'id'             => "mybutton-edit-" . $id,
								'data-module'    => $this->_module,
								'data-toggle'    => "modal",
								'data-target'    => "#remoteModal",
								'data-keyboard'  => "false",
								'data-backdrop'  => "static",
								'rel'            => 'tooltip',
								'data-placement' => 'top',
								'title'          => 'Ubah',
	            			));
	            	endif;

	            	if($this->laccess->otoritas('delete')):
	            		$action .= anchor(NULL, '<i class="fa fa-trash-o"></i></a>', array(
								'class'          => 'btn btn-danger btn-xs',
								'id'             => 'mybutton-delete-' . $id,
								'onclick'        => 'my_data_table.row_action.ajax(this.id)',
								'rel'            => 'tooltip',
								'data-placement' => 'top',
								'title'          => 'Hapus',
								'data-url'       => base_url() . $this->_module . '/delete/' . $id
	            			));
	            	endif;

	            	$no++;

	            	$rows[] = array(
	            				hgenerator::columns_align($no,'center'),
		            				$dt->jenis_jabatan_nama,
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
					$data['page_title']  = 'Tambah' . $this->_title;
					$data['_modul']		 = $this->_module;
					$data['form_action'] = $this->_module .'/proses';

					# CEK EDIT
					$data['edit_id'] 	 = $id;

					if($id):

						$data['page_title']	= 'Ubah ' . $this->_title;
						$data_edit = $this->jenis_jabatan_model->data($id)->get();

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
	        if ($this->jenis_jabatan_model->data($id)->count_all_results() > 0) {
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
					$exist_nama = NULL;

					$nama       = trim($this->input->post('jenis_jabatan_nama'));

					if(!$id):
						if(!empty($nama)):
							$check_nama = $this->jenis_jabatan_model->is_exist($nama);
							if($check_nama):
								$exist_nama = '|is_exist';
							endif;
						endif;
					endif;

					$this->form_validation->set_rules('jenis_jabatan_nama', '<i class="fa fa-warning"> Jenis Jabatan</i>', 'trim|required|max_length[200]'.$exist_nama);

					if($this->form_validation->run($this)):
						$message = array('error', 'Error!', 'Terjadi error pada saat penyimpanan, silahkan coba lagi.', '');

						$data = array(
										'jenis_jabatan_nama'	  => $this->input->post('jenis_jabatan_nama'), 
									);

						if($id):
							if($this->jenis_jabatan_model->update($id,$data)):
								$message = array(TRUE,'Proses Berhasil','Data Berhasil Disimpan','__after_process(0)');
							endif;
						else:
							if($this->jenis_jabatan_model->create($data)):
								$message = array(TRUE,'Proses Berhasil','Data Berhasil Disimpan','__after_process(1)');
							endif;
						endif;
					else:
						$message = array(false, 'Proses gagal', $this->form_validation->get_errors_array(), '');
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
				$check = $this->jenis_jabatan_model->data($id)->count_all_results();

				if($check > 0):
					if($this->jenis_jabatan_model->delete($id)):
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