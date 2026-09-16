<?php

class jenis_barang extends MX_Controller
{
	
	private $_class_name = NULL;
	private $_title		 = 'Jenis Barang';
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
		$this->load->model('jenis_barang_model'); 
		$this->load->model('kode_jenis_barang_model'); 
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
		if(hprotection::must_ajax($this->_module)) {

			# Init
            $limit  = $this->input->post('length');
            $offset = $this->input->post('start');
            $draw   = $this->input->post('draw');
            $extraColumn = $this->input->post('columns');
            $extraOrder  = $this->input->post('order');

            # Ordering
            $orderBy   = 'nama_jenis_barang';
            $direction = NULL;

            if($extraColumn[$extraOrder[0]['column']]['orderable'] == 'true') {
                $orderBy = isset($extraColumn[$extraOrder[0]['column']]['name']) ? $extraColumn[$extraOrder[0]['column']]['name'] : NULL;
                $direction   = $extraOrder[0]['dir'];
            }

			# Condition
            $cond = [];

            if (!empty($this->input->post('keyword'))) {
                $cond["LOWER(a.nama_jenis_barang) ILIKE '%{$this->input->post('keyword')}%'"] = NULL;
            }

            $dataCount          = $this->jenis_barang_model->data()->count_all_results();
            $dataCountFiltered  = $this->jenis_barang_model->data($cond)->count_all_results();
            $dataResult         = $this->jenis_barang_model->data($cond, $orderBy, $direction, $limit, $offset)->get();

            $rows = [];
            $no   = $offset;

            foreach ($dataResult->result() as $dt) {
            	
            	$id  	= $dt->kode_jenis_barang;

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
        				$dt->nama_jenis_barang,
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
				$data['page_title']  = 'Tambah ' . $this->_title;
				$data['_modul']		 = $this->_module;
				$data['form_action'] = $this->_module .'/save/'. $id;

				# CEK EDIT
				$data['edit_id'] 	 = $id;

				if($id):

					$data['page_title']	= 'Ubah ' . $this->_title;
					$data_edit = $this->jenis_barang_model->data($id)->get();

					if($data_edit->num_rows() > 0):
						$row = $data_edit->row();
						$data['data_edit'] = $row;

						$cond = array('a.kode_jenis_barang' => $id);
						$data['data_detail'] = $this->kode_jenis_barang_model->data($cond,'urutan')->get();

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
        if ($this->jenis_barang_model->data($id)->count_all_results() > 0) {
            $this->add($id);
        } else {
            echo Modules::run('template/error_message/error_404');
        }
    }

	public function save($id = NULL)
	{
		if($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {

			if(hprotection::must_ajax($this->_module .'/404')) {

				$unique_nama = NULL;

				if(!$id) {
                    $unique_nama = '|is_unique[m_jenis_barang.nama_jenis_barang]';
                } else {
                    $query = $this->jenis_barang_model->data($id)->get()->row();
                    if($this->input->post('nama_jenis_barang') !== $query->nama_jenis_barang) 
                    	$unique_nama = '|is_unique[m_jenis_barang.nama_jenis_barang]';
                }

                $this->form_validation->set_rules('nama_jenis_barang', '<i class="fa fa-warning"> Jenis Barang</i>', 'trim|required' .$unique_nama);
				//$this->form_validation->set_rules('label[]', '<i class="fa fa-warning"> Label</i>', 'trim|required');

				if ($this->form_validation->run($this)) {

					$data = ['nama_jenis_barang' => $this->input->post('nama_jenis_barang')];

					if($id) {

						$kode = $id;
						
						if($this->jenis_barang_model->update($id, $data)) {
							$message = ['type' => 'info', 'message' => 'Data Berhasil Diupdate','return' => '__afterSubmit(false)'];
						}

					} else {
						if($kode = $this->jenis_barang_model->create($data)) {
							$message = ['message' => 'Data Berhasil Disimpan', 'return' => '__afterSubmit()'];
						}
					}

					if($this->input->post('remove_detail')) {
						foreach ($this->input->post('remove_detail') as $key => $value) {
							$key = $this->input->post('remove_detail')[$key];
							$this->kode_jenis_barang_model->delete($key);
						}
					}

					if( $this->input->post('id_detail')) {
						foreach ($this->input->post('id_detail') as $key => $value) {
							
							if($this->input->post('label')[$key]) {
								$id_detail = $this->input->post('id_detail')[$key]; 
								$data_detail = [
									'kode_jenis_barang' => $kode,
									'label'             => $this->input->post('label')[$key],
									'atribut'           => $this->input->post('atribut')[$key],
									'nilai'             => $this->input->post('nilai')[$key],
									'urutan'            => $this->input->post('urutan')[$key], 
								];

								if($id_detail) {
									$this->kode_jenis_barang_model->update($id_detail,$data_detail);
								} else {
									$this->kode_jenis_barang_model->create($data_detail);
								}
							}

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

	public function delete($id = NULL) {
        if ($this->laccess->otoritas('delete')) {
            # Cek data edit
            if ($this->jenis_barang_model->data($id)->count_all_results() > 0) {
                if ($this->jenis_barang_model->delete($id)) {
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