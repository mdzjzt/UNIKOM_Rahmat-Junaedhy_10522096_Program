<?php

class prinsipal extends MX_Controller
{
	
	private $_class_name = NULL;
	private $_title		 = 'PRINSIPAL';
	private $_module	 = 'backend';


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
		$this->load->model('prinsipal_model'); 
		$this->load->model('cabang_model'); 
		$this->load->model('role_model'); 
	}

	public function index()
	{
		if(hprotection::must_ajax($this->_module)) {
			$data = [
					'page_title' => $this->_title,
					'_modul'	 => $this->_module,
					'_title'	 => $this->_title, 
					'cabang'     => $this->cabang_model->options([], ['' => '-']),
					'role'		 => $this->role_model->options([], ['' => '-'])

			];

			# LOG
            $this->log_activity_model->save([
                        'module'   => $this->_module,
                        'event'    => 'View',
                        'activity' => 'View List Izin Prinsipal'
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
            $orderBy   = 'prinsipal_id';
            $direction = NULL;

            if($extraColumn[$extraOrder[0]['column']]['orderable'] == 'true') {
                $orderBy = isset($extraColumn[$extraOrder[0]['column']]['name']) ? $extraColumn[$extraOrder[0]['column']]['name'] : NULL;
                $direction   = $extraOrder[0]['dir'];
            }

			# Condition
            $cond = [];

            if(!empty($this->input->post('role_id') ) ) {
            	$cond['a.role_id'] = $this->input->post('role_id');
            }

            // if(!empty($this->input->post('cabang_id') ) ) {
            // 	$cond['a.cabang_id'] = $this->input->post('cabang_id');
            // }

            $dataCount          = $this->prinsipal_model->data()->count_all_results();
            $dataCountFiltered  = $this->prinsipal_model->data($cond)->count_all_results();
            $dataResult         = $this->prinsipal_model->data($cond, $orderBy, $direction, $limit, $offset)->get();

            $rows = [];
            $no   = $offset;

            foreach ($dataResult->result() as $dt) {
            	
            	$id  	= $dt->prinsipal_id;

            	$action = NULL;

            	if($this->laccess->otoritas('edit')) {
            		$action .= anchor($this->_module . '/form/' . $id, '<i class="fa fa-edit"></i></a>', 
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
        				// $dt->cabang_nama,
		            	$dt->nama_role,
		            	number_format($dt->limit, 2),
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

	public function form($id = NULL)
	{
		if($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {
			if(hprotection::must_ajax($this->_module . '/add')) {
				$data['id'] = $id;
				$data['page_title']  = 'TAMBAH ' . $this->_title;
				$data['_modul']		 = $this->_module;
				$data['form_action'] = $this->_module .'/save/'. $id;

				$data['cabang']		 = $this->cabang_model->options([], ['' => '-']);
				$data['role']		 = $this->role_model->options([], ['' => '-']);

				if($id) {
					$data['page_title']	= 'Ubah ' . $this->_title;
					$data['data'] = $this->prinsipal_model->data($id)->get()->row();
				}

				$this->load->view($this->_module . '/form' ,$data);
			}

		} else {
			echo Modules::run('template/error_message/error_forbidden');
		}

	}

	public function save($id = NULL)
	{
		if($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {

			if(hprotection::must_ajax($this->_module .'/404')) {
				$unique_cabang = NULL;

				// if(!$id) {
    //                 $unique_cabang = '|is_unique[sys_prinsipal.cabang_id]';
    //             } else {
    //                 $query = $this->prinsipal_model->data($id)->get()->row();
    //                 if($this->input->post('cabang_id') !== $query->cabang_id) 
    //                 	$unique_cabang = '|is_unique[sys_prinsipal.cabang_id]';
    //             }

               // $this->form_validation->set_rules('cabang_id', '<i class="fa fa-warning"> Cabang</i>', 'trim|required|max_length[200]' .$unique_cabang);
                $this->form_validation->set_rules('role_id', '<i class="fa fa-warning"> Role</i>', 'trim|required|max_length[200]');
                $this->form_validation->set_rules('limit', '<i class="fa fa-warning"> Limit</i>', 'trim|required|max_length[200]');

				if ($this->form_validation->run($this)) {

					$data =[
						// 'cabang_id' => $this->input->post('cabang_id'),
						'role_id'	=> $this->input->post('role_id'), 
						'limit'	=> $this->input->post('limit'), 
					];

					if($id) {
						
						if($this->prinsipal_model->update($id, $data)) {
							$message = ['type' => 'info', 'message' => 'Data Berhasil Di update','return' => '__afterSubmit(false)'];
						}

						# LOG
			            $this->log_activity_model->save([
			            			'sistem'   => TRUE,
			                        'module'   => $this->_module,
			                        'event'    => 'Update',
			                        'activity' => 'Update Izin Prinsipal'
			            ]);


					} else {

						if($this->prinsipal_model->create($data)) {
							$message = ['message' => 'Data Berhasil Di simpan','return' => '__afterSubmit()'];
						}

						# LOG
			            $this->log_activity_model->save([
			            			'sistem'   => TRUE,
			                        'module'   => $this->_module,
			                        'event'    => 'Insert',
			                        'activity' => 'Insert Izin Prinsipal'
			            ]);

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
            if ($this->prinsipal_model->data($id)->count_all_results() > 0) {
                if ($this->prinsipal_model->delete($id)) {

                	# LOG
			            $this->log_activity_model->save([
			            			'sistem'   => TRUE,
			                        'module'   => $this->_module,
			                        'event'    => 'Delete',
			                        'activity' => 'Delete Izin Prinsipal'
			            ]);

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