<?php

	class gl_akun extends MX_Controller
	{
		
		private $_class_name = NULL;
		private $_title		 = 'GOLONGAN LBU';
		private $_module 	 = 'master';

		function __construct()
		{
			parent::__construct();

			# PROTECTION
			hprotection::login();
			$this->laccess->check();
			$this->laccess->otoritas('view',TRUE);

			$this->_class_name = get_class($this);
			$this->_module    .= '/' . $this->_class_name;

			# LOAD MODEL
			$this->load->model('gl_akun_model'); 
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
				$extra_search = $this->input->post('extra_search');
				$data_cond    = hgenerator::seriliaze_decode($extra_search);

				# Condition
				$cond = array();
				if (!empty($data_cond['keyword'])) {
					if (!empty($data_cond['column'])) {
						 $cond["(
	                		a.{$data_cond['column']} ILIKE '%{$data_cond['keyword']}%')"] = NULL;
					} else {
		                $cond["(
		                		LOWER(a.gl_kode) ILIKE '%{$data_cond['keyword']}%'  
		                		OR LOWER(a.gl_nama) ILIKE '%{$data_cond['keyword']}%'
		                		OR LOWER(a.gl_dk) ILIKE '%{$data_cond['keyword']}%' 
		                		OR LOWER(a.gl_rekening) ILIKE '%{$data_cond['keyword']}%'
		                	  )"] = NULL;
					}
	            }

	            $data_count  = $this->gl_akun_model->data($cond)->count_all_results();
	            $data_result = $this->gl_akun_model->data($cond, 'gl_nama', 'asc', $limit, $offset)->get();

	            $rows = array();
	            $no   = $offset;

	            foreach ($data_result->result() as $dt):
	            	
	            	$id  	= $dt->gl_id;

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
		            				$dt->gl_kode,
		            				$dt->gl_kode_syariah,
		            				$dt->gl_nama,
		            				$dt->gl_rekening,
		            				$dt->gl_dk,
		            				ucwords($dt->gl_kategori) ,
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
						$data_edit = $this->gl_akun_model->data($id)->get();

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
	        if ($this->gl_akun_model->data($id)->count_all_results() > 0) {
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
					$kode       = trim($this->input->post('gl_kode'));

					if(!$id):
						if(!empty($kode)):
							$check_kode = $this->gl_akun_model->is_exist($kode);
							if($check_kode):
								$exist_kode = '|is_exist';
							endif;
						endif;
					endif;

					$this->form_validation->set_rules('gl_kode', '<i class="fa fa-warning"> Kode</i>', 'trim|required|max_length[200]' .$exist_kode);
					$this->form_validation->set_rules('gl_nama', '<i class="fa fa-warning"> Golongan</i>', 'trim|required|max_length[200]');
					$this->form_validation->set_rules('gl_rekening', '<i class="fa fa-warning"> Nama Rekening</i>', 'trim|required|max_length[200]');

					if($this->form_validation->run($this)):
						$message = array('error', 'Error!', 'Terjadi error pada saat penyimpanan, silahkan coba lagi.', '');

						$data = array(
										'gl_kode'         => $this->input->post('gl_kode'),
										'gl_kode_syariah' => $this->input->post('gl_kode_syariah'),
										'gl_nama'         => $this->input->post('gl_nama'),
										'gl_rekening'     => $this->input->post('gl_rekening'), 
										'gl_dk'           => $this->input->post('gl_dk'),
										'gl_kategori'     => $this->input->post('gl_kategori'),
										'masa_penyusutan' => $this->input->post('masa_penyusutan'),
										'persen_penyusutan' => $this->input->post('persen_penyusutan'),
									);

						if($id):
							if($this->gl_akun_model->update($id,$data)):
								$message = array(TRUE,'Proses Berhasil','Data Berhasil Disimpan','__after_process(0)');
							endif;
						else:
							if($this->gl_akun_model->create($data)):
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
				$check = $this->gl_akun_model->data($id)->count_all_results();

				if($check > 0):
					if($this->gl_akun_model->delete($id)):
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