<?php

class tuv extends MX_Controller
{
	
	private $_class_name = NULL;
	private $_title		 = 'Logo TUV';
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
		$this->load->model('tuv_model'); 
		$this->load->module('template/app_config');
		
	}

	public function index()
	{
		if(hprotection::must_ajax($this->_module)) {
			$data = [
					'page_title' => $this->_title,
					'_modul'	 => $this->_module,
					'_title'	 => $this->_title, 
				
			];

			# LOG
            $this->log_activity_model->save([
                        'module'   => $this->_module,
                        'event'    => 'View',
                        'activity' => 'View Logo TUV'
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
            $orderBy   = 'logo_id';
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

            $dataCount          = $this->tuv_model->data()->count_all_results();
            $dataCountFiltered  = $this->tuv_model->data($cond)->count_all_results();
            $dataResult         = $this->tuv_model->data($cond, $orderBy, $direction, $limit, $offset)->get();

            $rows = [];
            $no   = $offset;

            foreach ($dataResult->result() as $dt) {
            	
            	$id  	= $dt->logo_id;
            	  if(!empty($dt->image)) {
            	  	 $image = json_decode($dt->image); 
                            if(!empty($image)){
                            	$img = '<img src="'.$image[0]->file.'" alt="..." width="100px;">' ;
                             }else{
                             	$img = '';
                             }
            	  };

            	  if($dt->status_aktip == 1){
            	  	$status = "AKTIF";
            	  }else{
            	  	$status = "TIDAK AKTIF";
            	  }
                               

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
		            	$dt->nama_logo,
		            	$img,
		            	$status,
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

				if($id) {
					$data['page_title']	= 'Ubah ' . $this->_title;
					$data['data'] = $this->tuv_model->data($id)->get()->row();
				}

				$data['logotype'] = array('1' => 'Logo CPM Group', '2' => 'Logo Tuv');

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

                $this->form_validation->set_rules('nama_logo', '<i class="fa fa-warning"> Role</i>', 'trim|required|max_length[200]');
              
				if ($this->form_validation->run($this)) {

						$path = $this->app_config->info('pegawai_image');

	                    if(!file_exists($path)) mkdir($path,0777,TRUE);
	                    if(!empty($_FILES['image'])) {
	                        $files = $_FILES['image'];
	                    }

	                    $this->load->library('upload');
	                        
	                    $config  = [
	                        'upload_path'   => $path,
	                        'allowed_types' => 'jpg|png|jpeg',            
	                    ];  

	                    $this->upload->initialize($config);

	                    $image = [];
	                    if(!empty($_FILES['image'])) {
	                        $_FILES['image']['name']     = $files['name'];
	                        $_FILES['image']['type']     = $files['type'];
	                        $_FILES['image']['tmp_name'] = $files['tmp_name'];
	                        $_FILES['image']['error']    = $files['error'];
	                        $_FILES['image']['size']     = $files['size'];
	                        
	                        if($this->upload->do_upload('image')) {
	                            $dataUpload = $this->upload->data();
	                            $image[] = [
	                                    'file'      => $config['upload_path'].$dataUpload['file_name'],
	                                    'filename'  => $dataUpload['file_name'],
	                            ];
	                        } 
	                    }

	                 if (empty($image)) {
	                 		$data =[
						// 'cabang_id' => $this->input->post('cabang_id'),
						'nama_logo'	=> $this->input->post('nama_logo'), 
						'type_logo' => $this->input->post('type_logo'), 
						'keterangan'	=> $this->input->post('keterangan'), 
						'status_aktip' => $this->input->post('st_aktips')
						];
	                 }else{
	                 	$data =[
						// 'cabang_id' => $this->input->post('cabang_id'),
						'nama_logo'	=> $this->input->post('nama_logo'), 
						'type_logo' => $this->input->post('type_logo'), 
						'image'	=> json_encode($image), 
						'keterangan'	=> $this->input->post('keterangan'), 
						'status_aktip' => $this->input->post('st_aktips')
						];
	                 }


					if($id) {
						
						if($this->tuv_model->update($id, $data)) {

							 if($this->input->post('st_aktips') == 1){
							 	$dataa = ['status_aktip' => 0];
							 	$this->db->where('logo_id !=', $id);
							 	$this->db->where('type_logo =',  $this->input->post('type_logo'));
                                $this->db->update('tbl_logo',$dataa);
 
							 }

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

						if($this->tuv_model->create($data)) {
							$id_tuv = $this->db->insert_id();

							 if($this->input->post('st_aktips') == 1){

							 	$dataa = ['status_aktip' => 0];

							 	$this->db->where('logo_id !=', $id_tuv);
							 	$this->db->where('type_logo =',  $this->input->post('type_logo'));
                                $this->db->update('tbl_logo',$dataa);
 
							 }

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
            if ($this->tuv_model->data($id)->count_all_results() > 0) {
                if ($this->tuv_model->delete($id)) {

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