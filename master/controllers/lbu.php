<?php

class lbu extends MX_Controller
{
	
	private $_class_name = NULL;
	private $_title		 = 'LBU';
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
		$this->load->model('lbu_model'); 
	}

	public function index()
	{
		if(hprotection::must_ajax($this->_module)) {
			$data = [
				'pageTitle' => 'MASTER '.$this->_title,
				'_modul'	 => $this->_module,
				'_title'	 => $this->_title, 
			];

			# LOG
            $this->log_activity_model->save([
                        'module'   => $this->_module,
                        'event'    => 'View',
                        'activity' => 'View master LBU'
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
            $orderBy   = 'lbu_nama';
            $direction = NULL;

            if($extraColumn[$extraOrder[0]['column']]['orderable'] == 'true') {
                $orderBy = isset($extraColumn[$extraOrder[0]['column']]['name']) ? $extraColumn[$extraOrder[0]['column']]['name'] : NULL;
                $direction   = $extraOrder[0]['dir'];
            }

			# Condition
            $cond = [];

            if (!empty($this->input->post('keyword'))) {
                $cond["(LOWER(a.lbu_kode) ILIKE '%{$this->input->post('keyword')}%' OR LOWER(a.lbu_nama) ILIKE '%{$this->input->post('keyword')}%' )"] = NULL;
            }

            $dataCount          = $this->lbu_model->data()->count_all_results();
            $dataCountFiltered  = $this->lbu_model->data($cond)->count_all_results();
            $dataResult         = $this->lbu_model->data($cond, $orderBy, $direction, $limit, $offset)->get();

            $rows = [];
            $no   = $offset;

            foreach ($dataResult->result() as $dt) {
            	
            	$id  	= $dt->lbu_id;

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
        				$dt->lbu_kode,
		            	$dt->lbu_nama,
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
		if($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')):
			if(hprotection::must_ajax($this->_module . '/add')):
				$data['page_title']  = 'TAMBAH ' . $this->_title;
				$data['_modul']		 = $this->_module;
				$data['form_action'] = $this->_module .'/save/'. $id;

				# CEK EDIT
				$data['edit_id'] 	 = $id;

				if($id):

					$data['page_title']	= 'Ubah ' . $this->_title;
					$data_edit = $this->lbu_model->data($id)->get();

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

	public function edit($id) {
    # Cek data edit
        if ($this->lbu_model->data($id)->count_all_results() > 0) {
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
                    $unique_kode = '|is_unique[m_kode_lbu.lbu_kode]';
                } else {
                    $query = $this->lbu_model->data($id)->get()->row();
                    if($this->input->post('lbu_kode') !== $query->lbu_kode) 
                    	$unique_kode = '|is_unique[m_kode_lbu.lbu_kode]';
                }

                $this->form_validation->set_rules('lbu_kode', '<i class="fa fa-warning"> Kode</i>', 'trim|required|max_length[200]' .$unique_kode);
                $this->form_validation->set_rules('lbu_nama', '<i class="fa fa-warning"> Nama LBU</i>', 'trim|required|max_length[200]');

				if ($this->form_validation->run($this)) {

					$data =[
						'lbu_kode' => $this->input->post('lbu_kode'),
						'lbu_nama'	  => $this->input->post('lbu_nama'), 
					];

					if($id) {
						
						if($this->lbu_model->update($id, $data)) {
							$message = ['type' => 'info', 'message' => 'Data Berhasil Di update','return' => '__afterSubmit(false)'];
							# LOG
                            $this->log_activity_model->save([
                                        'module'   => $this->_module,
                                        'sistem'   => TRUE,
                                        'event'    => 'Insert',
                                        'activity' => 'Insert Master LBU'
                            ]);
						}

					} else {

						if($this->lbu_model->create($data)) {
							$message = ['message' => 'Data Berhasil Di simpan','return' => '__afterSubmit()'];
							# LOG
                            $this->log_activity_model->save([
                                        'module'   => $this->_module,
                                        'sistem'   => TRUE,
                                        'event'    => 'Update',
                                        'activity' => 'Update Master LBU'
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
            # Cek data edit
            if ($this->lbu_model->data($id)->count_all_results() > 0) {
                if ($this->lbu_model->delete($id)) {
                    $message = ['type' => 'info', 'message' => 'Data Berhasil Dihapus','return' => '__reloadTable(false)'];
                	# LOG
                    $this->log_activity_model->save([
                                'module'   => $this->_module,
                                'sistem'   => TRUE,
                                'event'    => 'Delete',
                                'activity' => 'Delete Master LBU'
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