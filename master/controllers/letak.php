<?php

	class letak extends MX_Controller
	{
		
		private $_class_name = NULL;
		private $_title		 = 'Letak';
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
			$this->load->model('letak_model'); 
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
				if (!empty($data_cond['keyword'])):
	                $cond["(LOWER(a.letak_kode) ILIKE '%{$data_cond['keyword']}%' OR LOWER(a.letak_name) ILIKE '%{$data_cond['keyword']}%') "] = NULL;
	            endif;

	            $data_count  = $this->letak_model->data($cond)->count_all_results();
	            $data_result = $this->letak_model->data($cond, 'letak_name', 'asc', $limit, $offset)->get();

	            $rows = array();
	            $no   = $offset;

	            foreach ($data_result->result() as $dt):
	            	
	            	$id  	= $dt->letak_id;

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
		            				$dt->letak_kode,
		            				$dt->letak_name,
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

					if($id):

						$data['page_title']	= 'Ubah ' . $this->_title;
						$data_edit = $this->letak_model->data($id)->get();

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
	        if ($this->letak_model->data($id)->count_all_results() > 0) {
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
					$kode       = trim($this->input->post('letak_kode'));

					if(!$id):
						$exist_kode = '|is_unique[m_letak.letak_kode]';
					endif;

					$this->form_validation->set_rules('letak_kode', '<i class="fa fa-warning"> Kode</i>', 'trim|required|max_length[200]' .$exist_kode);
					$this->form_validation->set_rules('letak_name', '<i class="fa fa-warning"> Letak</i>', 'trim|required');

					if($this->form_validation->run($this)):
						$message = array('error', 'Error!', 'Terjadi error pada saat penyimpanan, silahkan coba lagi.', '');

						$data = array(
										'letak_kode' => $this->input->post('letak_kode'),
										'letak_name' => $this->input->post('letak_name'), 
									);

						if($id):
							if($this->letak_model->update($id,$data)):
								$message = array(TRUE,'Proses Berhasil','Data Berhasil Disimpan','__after_process(0)');
							endif;
						else:
							if($this->letak_model->create($data)):
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
				$check = $this->letak_model->data($id)->count_all_results();

				if($check > 0):
					if($this->letak_model->delete($id)):
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