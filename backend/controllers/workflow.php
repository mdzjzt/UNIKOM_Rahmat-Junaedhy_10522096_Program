<?php


class workflow extends MX_Controller
{	
	private $_class_name    = NULL;
	private $_title         = 'Workflow';
	private $_module        = 'backend';
	private $_temp_menu     = array();
	private $_temp_ordering = array();
	private $_html_menu     = '';
	
	function __construct()
	{
		parent::__construct();
		hprotection::login();

		$this->laccess->check();
		$this->laccess->otoritas('view',TRUE);

		$this->_class_name = get_class($this);
		$this->_module    .= '/' . $this->_class_name;

		$this->load->model('workflow_model'); 
		$this->load->model('workflow_detail_model');
		$this->load->model('role_model');
		$this->load->model('range_model');

		$this->load->model('cabang_model');

		$this->load->model('project_all_model');
		$this->load->model('user_project_model');
		 $this->load->model('department_model');

	}

	public function index()
	{
		if(hprotection::must_ajax($this->_module)):
			$data = array(
							'page_title' => 'SETTING WORKFLOW',
							'_module'	 => $this->_module,
							'_title'	 => $this->_title, 
						);

			# LOG
            $this->log_activity_model->save([
                        'module'   => $this->_module,
                        'event'    => 'View',
                        'activity' => 'View List Workflow'
            ]);

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
            $orderBy   = "'order'";
            $direction = 'ASC';

            if($extraColumn[$extraOrder[0]['column']]['orderable'] == 'true') {
                $orderBy = isset($extraColumn[$extraOrder[0]['column']]['name']) ? $extraColumn[$extraOrder[0]['column']]['name'] : NULL;
                $direction   = $extraOrder[0]['dir'];
            }


			# Condition
            $cond = [];
			$dataCount          = $this->workflow_model->data()->count_all_results();
            $dataCountFiltered  = $this->workflow_model->data($cond)->count_all_results();
            $dataResult         = $this->workflow_model->data($cond, $orderBy, $direction, $limit, $offset)->get();

            $rows = [];
            $no   = $offset;

            foreach ($dataResult->result() as $dt) {
				
				$action = NULL;
				$id     = $dt->workflow_id;

				if($this->laccess->otoritas('edit')) {
            		$action .= anchor(NULL, '<i class="fa fa-edit"></i></a>',array(
							'class'     => 'btn btn-info btn-xs',
                        	'data-href' => $this->_module . '/edit/' . $id
            			));
				}

            	$no++;

            	$rows[] = array(
            				hgenerator::columns_align($no,'center'),
	            			$dt->workflow_name,
            				hgenerator::button_action($action),
            			);

            }

            $data = array(
				'draw'            => $draw,
				'recordsTotal'    => $dataCount,
				'recordsFiltered' => $dataCountFiltered,
				'data'            => $rows
            );

            echo json_encode($data);

		}
	}

	public function load_flow($id = NULL, $flag = NULL)
	{
		if(hprotection::must_ajax($this->_module)):
			$cond = [];
			$cond['workflow_id'] = $id;
			$cond['or_order'] = 0;
			
			// if($this->input->post('cabang_id')) $cond['cabang_id'] = $this->input->post('cabang_id');
			if($this->input->post('cabang_id')) $cond['cabang_id'] = $this->input->post('cabang_id');
			if($this->input->post('project_id')) $cond['project_id'] = $this->input->post('project_id');
			if($flag) $cond['flow_flag'] = $flag;


			$data['list_flow']   = $this->_flow($cond);

			$data['form_action'] = $this->_module . '/ordering';
			$this->load->view($this->_module . '/nestable', $data);
		endif;
	}

	public function load_flow_or($id = NULL, $flag = NULL)
	{
		if(hprotection::must_ajax($this->_module)):
			$cond = [];
			$cond['workflow_id'] = $id;
			$cond['or_order'] = 1;
			
			// if($this->input->post('cabang_id')) $cond['cabang_id'] = $this->input->post('cabang_id');
			if($this->input->post('cabang_id')) $cond['cabang_id'] = $this->input->post('cabang_id');
			if($this->input->post('project_id')) $cond['project_id'] = $this->input->post('project_id');
			 if($flag) $cond['flow_flag'] = $flag;


			$data['list_flow']   = $this->_flow($cond);

			$data['form_action'] = $this->_module . '/ordering';
			$this->load->view($this->_module . '/nestable', $data);
		endif;
	}

	public function edit($id)
	{
		if($this->laccess->otoritas('edit')):
			if(hprotection::must_ajax($this->_module . '/edit')):

				$query              = $this->workflow_model->data($id)->get()->row();				
				$data['_title']     = 'ROLE';
				$data['data']       = $query;
				$data['id']         = $id;
				$data['page_title'] = $query->workflow_name;
				$data['type_duplicate'] = $query->order;
				$data['_module']    = $this->_module;

				if($id == 'PERM-01') {
					$cond["(status = 1 OR cabang_parent = '000')"] = NULL;
				} else {
					$cond["(cabang_parent IS NULL)"] = NULL; 
				}

				$condd["status_delete"] = 0; 

				$data['cabang']		 = $this->cabang_model->options($cond,NULL);

				$data['project']		 = $this->project_all_model->options($condd,NULL);


				if($query->is_subworkflow == TRUE):
					$this->load->view($this->_module . '/form_alternatif' ,$data);
				else:
					$this->load->view($this->_module . '/form' ,$data);
				endif;
			endif;
		else:
			echo Modules::run('template/error_message/error_forbidden');
		endif;
	}

	public function edit_alternatif($id,$flag)
	{
		if(hprotection::must_ajax($this->_module . '/edit')):

			$query = $this->workflow_model->data($id)->get()->row();
			
			$data['_title']  	 = 'ROLE';
			$data['id']  	 	 = $id;
			$data['page_title']  = $this->input->get('name');
			$data['flag']  		 = $flag;
			$data['_module']     = $this->_module;
			$data['cabang']		 = $this->cabang_model->options(array('status' => true),NULL);

			$this->load->view($this->_module . '/form_alternatif_detail' ,$data);
		endif;
	}

	public function add_role($id = NULL, $flag = NULL)
	{
		if($this->laccess->otoritas('edit')):
			if(hprotection::must_ajax($this->_module . '/add_role')):

				$data['page_title']  = 'TAMBAH ROLE';
				$data['_title']  	 = 'ROLE';
				$data['workflow_id'] = $id;
				$data['_module']	 = $this->_module;
				$data['form_action'] = $this->_module.'/save';

				$data['role']		 = $this->role_model->options(array(),array('' => '--Pilih Role--'));
				$data['flag'] 	     = $flag;
				$cond["(status = 1 OR cabang_parent = '000')"] = NULL;
				$data['cabang']		 = $this->cabang_model->options($cond,NULL);
				$condd["status_delete"] = 0;
				$data['project']		 = $this->project_all_model->options($condd,NULL);
				$data['range']		 = $this->range_model->options([], ['' => 'Pilih Limit Range']);
				$data['department_project']  = $this->department_model->options(array(), array('' => '--Pilih Department Project--'));

				$this->load->view($this->_module . '/form_role' ,$data);
			endif;
		endif;
	}

	public function save($id = NULL)
	{
		if($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {
			if(hprotection::must_ajax($this->_module .'/404')) {
				$this->form_validation->set_rules('role_id', '<i class="fa fa-warning"></i>', 'trim|required');
				// var_dump($_POST);
				// exit();
				
				// if ($this->form_validation->run($this)) {

					// $data = [
					// 	'role_id'     => $this->input->post('role_id'),
					// 	'workflow_id' => $this->input->post('workflow_id'),
					// 	'project_id'   => $this->input->post('project_id'),
					// 	'flow_flag'   => $this->input->post('flag')
					// ];

					if($id) {
						if ($this->workflow_detail_model->update($id, $data)) {
							$message = ['type' => 'info', 'message' => 'Data Berhasil Diupdate','return' => '__pageFunction()'];
						}

					} else {

						// $data['flow_order'] = $this->workflow_detail_model->last_order($data['workflow_id'],$data['project_id']);
						if (!empty($this->input->post('deparment'))) {
							$dataorder = $this->workflow_detail_model->last_order_new($this->input->post('workflow_id'),$this->input->post('project_id'));
						}else{
							$dataorder = $this->workflow_detail_model->last_order($this->input->post('workflow_id'),$this->input->post('project_id'));
						}
					

					$idusr1 = $this->db->select(" * from m_user where id_role = '".$this->input->post('role_id')[0]."' ")->get();

					

					// $cond['id_master_project'] = $this->input->post('project_id');
					// $iduser= $this->user_project_model->data($cond)->get();

					$idu1 = NULL;
					foreach ($idusr1->result() as $key => $valuee) {


							$cond['a.id_master_project'] = $this->input->post('project_id');
							$cond['a.id_user'] = $valuee->id_user;
							$iduser1= $this->user_project_model->data($cond)->get()->row();

							if (!empty($iduser1)) {
								$idu1 = $iduser1->id_user;
							}
					}
					// var_dump($idu1);
					// exit();


					$idu2 = 'no';
					 if(!empty($this->input->post('role_id')[1])) {
						$idusr2 = $this->db->select(" * from m_user where id_role = '".$this->input->post('role_id')[1]."' ")->get();

						$idu2 = NULL;
						foreach ($idusr2->result() as $key => $valueee) {


								$cond['a.id_master_project'] = $this->input->post('project_id');
								$cond['a.id_user'] = $valueee->id_user;
								$iduser2= $this->user_project_model->data($cond)->get()->row();

								if (!empty($iduser2)) {
									$idu2 = $iduser2->id_user;
								}
						}
					}


					$idu3 = 'no';
					 if(!empty($this->input->post('role_id')[2])) {
						$idusr3 = $this->db->select(" * from m_user where id_role = '".$this->input->post('role_id')[2]."' ")->get();

						$idu3 = NULL;
						foreach ($idusr3->result() as $key => $valueee) {


								$cond['a.id_master_project'] = $this->input->post('project_id');
								$cond['a.id_user'] = $valueee->id_user;
								$iduser3= $this->user_project_model->data($cond)->get()->row();

								if (!empty($iduser3)) {
									$idu3 = $iduser3->id_user;
								}
						}
					}

					// var_dump($idu2);
					// exit();

					if (!empty($idu1) ) {

						if ($this->input->post('role_id')){
                                             #   Menyimpan data vendor peserta  ke tabel rfq
                                    // foreach ($this->input->post('role_id') as $key => $value) {

									if ($idu2 == 'no') {
										if(!empty($this->input->post('role_id')[0])) {

                                            $data = [
                                                  	'role_id'     => $this->input->post('role_id')[0],
													'workflow_id' => $this->input->post('workflow_id'),
													'project_id'   => $this->input->post('project_id'),
													'flow_flag'   => $this->input->post('flag'),
													'flow_order' => $dataorder,
													'id_user' => $idu1,
													'id_range' => $this->input->post('range') ? $this->input->post('range'): NULL,
													'department_flow'   => $this->input->post('deparment') ? $this->input->post('deparment'): 0,
													
													
                                            ];

                                            $this->workflow_detail_model->create($data);
	                                    	$message = ['message' => 'Data Berhasil Disimpan', 'return' => '__pageFunction()'];
                                        }
                                          
									}else if ($idu2 == NULL) {
										 $message = ['error' => true, 'message' => 'Terjadi Kesalahan <br> ROLE (OR 1) INI BELUM TERDAFTAR DI PROYEK/TRANSAKSI PADA MODUL MASTER PROJECT','callback' => $this->form_validation->get_errors_array()];
									}else if ($idu3 == NULL) {
										 $message = ['error' => true, 'message' => 'Terjadi Kesalahan <br> ROLE (OR 2) INI BELUM TERDAFTAR DI PROYEK/TRANSAKSI PADA MODUL MASTER PROJECT','callback' => $this->form_validation->get_errors_array()];
									}else{

                                    	if(!empty($this->input->post('role_id')[0])) {

                                            $data = [
                                                  	'role_id'     => $this->input->post('role_id')[0],
													'workflow_id' => $this->input->post('workflow_id'),
													'project_id'   => $this->input->post('project_id'),
													'flow_flag'   => $this->input->post('flag'),
													'flow_order' => $dataorder,
													'id_user' => $idu1,
													'id_range' => $this->input->post('range') ? $this->input->post('range'): NULL
													
                                            ];

                                            $this->workflow_detail_model->create($data);
	                                    	$message = ['message' => 'Data Berhasil Disimpan', 'return' => '__pageFunction()'];
                                        }
                                          

                                        if(!empty($this->input->post('role_id')[1])) {

		                                            	$data = [
		                                            		'role_id'     => $this->input->post('role_id')[1],
															'workflow_id' => $this->input->post('workflow_id'),
															'project_id'   => $this->input->post('project_id'),
															'flow_flag'   => $this->input->post('flag'),
															'flow_order' => $dataorder,
															'id_user' => $idu2,
															'or_order' => 1,
															'id_range' => $this->input->post('range') ? $this->input->post('range'): NULL
		                                            	];

		                                    $this->workflow_detail_model->create($data);
	                                    	$message = ['message' => 'Data Berhasil Disimpan', 'return' => '__pageFunction()'];
	                                          
                                    	} 

                                    	if(!empty($this->input->post('role_id')[2])) {

		                                            	$data = [
		                                            		'role_id'     => $this->input->post('role_id')[2],
															'workflow_id' => $this->input->post('workflow_id'),
															'project_id'   => $this->input->post('project_id'),
															'flow_flag'   => $this->input->post('flag'),
															'flow_order' => $dataorder,
															'id_user' => $idu3,
															'or_order' => 1,
															'id_range' => $this->input->post('range') ? $this->input->post('range'): NULL
		                                            	];

		                                    $this->workflow_detail_model->create($data);
	                                    	$message = ['message' => 'Data Berhasil Disimpan', 'return' => '__pageFunction()'];
	                                          
                                    	} 

                        			
									}

                    }
                      

					}else{
						 $message = ['error' => true, 'message' => 'Terjadi Kesalahan <br> ROLE INI BELUM TERDAFTAR DI PROYEK/TRANSAKSI PADA MODUL MASTER PROJECT','callback' => $this->form_validation->get_errors_array()];
					}
					
			}

				// } else {
				// 	$message = ['error' => true, 'message' => 'Terjadi Kesalahan <br> Periksa kembali data input', 'callback' => $this->form_validation->get_errors_array()];
				// }

				# LOG
	            $this->log_activity_model->save([
	                        'module'   => $this->_module,
	                        'sistem'   => TRUE,
	                        'event'    => 'Insert',
	                        'activity' => 'Insert Workflow'
	            ]);

				echo json_encode($message);
			}

		} else {
			echo Modules::run('template/error_message/error_forbidden');
		}

	}

	public function delete($id, $id_or = NULL)
	{
		if($this->laccess->otoritas('delete')):
			if($this->workflow_detail_model->data($id)->count_all_results() > 0):
				if($this->workflow_detail_model->delete($id)):
					
					if (!empty($id_or)) {
						$this->workflow_detail_model->delete($id_or);
					}
					
					$message = ['type' => 'info', 'message' => 'Data Berhasil Dihapus','return' => '__pageFunction()'];
				else:
					$message = ['error' => TRUE, 'message' => 'Terjadi Kesalahan <br> Data Gagal Dihapus'];
				endif;
			else:
				$message = array('error' => TRUE, 'message' => 'Terjadi Kesalahan <br> Data yang akan dihapus tidak ditemukan.');
			endif;
			echo json_encode($message);

			# LOG
            $this->log_activity_model->save([
                        'module'   => $this->_module,
                        'sistem'   => TRUE,
                        'event'    => 'Delete',
                        'activity' => 'Delete Workflow'
            ]);
		else:
			echo Modules::run('template/error_message/error_forbidden');
		endif;
	}

	public function skip($id,$workflow_id,$project_id, $param)
	{
		if($this->laccess->otoritas('edit')):
			if($this->workflow_detail_model->data($id)->count_all_results() > 0):

			if ($param == 1) {
				$data = array('skip_order' => 1);
				if($this->workflow_detail_model->skip($id, $data)):

					// $cond['project_id']  = $project_id ;
					// $cond['skip_order']  = 0;
					// $cond['or_order']  = 0;
					// $cond['or_order']  = 0;
					// $cond['workflow_id']  = $workflow_id;
					// $data_flow  = $this->workflow_detail_model->data_skip($cond,'flow_order')->get();

					// $this->_ordering($data_flow->result());


					// if($this->workflow_detail_model->skip($id, $data)){
					// 	$message = ['type' => 'info', 'message' => 'Data Berhasil Di SKIP','return' => '__pageFunction()'];
					// };

					// if($this->workflow_detail_model->update_ordering($this->_temp_ordering)){
					 	$message = ['type' => 'info', 'message' => 'Data Berhasil Di SKIP','return' => '__pageFunction()'];
					// };

				else:

					$message = ['error' => TRUE, 'message' => 'Terjadi Kesalahan <br> Data Gagal DiSkip'];
				endif;
			}else{
				$data = array('skip_order' => 0);
				if($this->workflow_detail_model->skip($id, $data)):
					// $message = ['type' => 'info', 'message' => 'Data Berhasil Di SKIP','return' => '__pageFunction()'];

					// $cond['project_id']  = $project_id ;
					// $cond['skip_order']  = 0;
					// $cond['or_order']  = 0;
					// $cond['or_order']  = 0;
					// $cond['workflow_id']  = $workflow_id;
					// $data_flow  = $this->workflow_detail_model->data_skip($cond,'flow_id')->get();

					// $this->_ordering($data_flow->result());

					// if($this->workflow_detail_model->update_ordering($this->_temp_ordering)){
						$message = ['type' => 'info', 'message' => 'Data Berhasil Di SKIP','return' => '__pageFunction()'];
					// };

				else:
					$message = ['error' => TRUE, 'message' => 'Terjadi Kesalahan <br> Data Gagal DiSkip'];
				endif;
			}
				
			else:
				$message = array('error' => TRUE, 'message' => 'Terjadi Kesalahan <br> Data yang akan diskip tidak ditemukan.');
			endif;
			echo json_encode($message);

			# LOG
            $this->log_activity_model->save([
                        'module'   => $this->_module,
                        'sistem'   => TRUE,
                        'event'    => 'Skip',
                        'activity' => 'Skip Workflow'
            ]);
		else:
			echo Modules::run('template/error_message/error_forbidden');
		endif;
	}

	public function ordering()
	{
		if ($this->laccess->otoritas('edit')):
			if (hprotection::must_ajax($this->_module . '/404')):

				

				$nestable = $this->input->post('nestable_output');
			

				if(!empty($nestable)):
					$this->_ordering(json_decode($nestable));

				// var_dump(json_decode($nestable));
				// exit();

					if($this->workflow_detail_model->update_ordering($this->_temp_ordering)):

						$message = ['type' => 'info', 'message' => 'Urutan berhasil disimpan','return' => '__pageFunction()'];
					else:
						$message = ['error' => TRUE, 'message' => 'Terjadi Kesalahan <br> Silahkan coba lagi'];

					endif;
				else:
					$message = ['type' => 'info', 'message' => 'Urutan berhasil disimpan','return' => '__pageFunction()'];
				endif;

				$this->log_activity_model->save([
                        'module'   => $this->_module,
                        'sistem'   => TRUE,
                        'event'    => 'Update',
                        'activity' => 'Update Ordering Workflow'
           	 	]);

				echo json_encode($message);

			endif;
		else:
			 echo Modules::run('template/error_message/error_forbidden');
		endif;
	}

	private function _list($key = array())
	{
		$data      = $this->workflow_detail_model->data($key,'a.flow_order')->get();
		$temp_menu = array();

		$parent = 0;
		foreach ($data->result() as $value):
			$temp_menu[$parent][] = (object) array(
					'flow_id'     => $value->flow_id,
					'role_id'     => $value->role_id,
					'role_name'   => $value->nama_role,
					'project_id'   => $value->project_id,
					'workflow_id' => $value->workflow_id,
					'flow_order'  => $value->flow_order,
					'skip_order'  => $value->skip_order,
					'or_order'    => $value->or_order,
					'range' => ''.$value->min.'-'.$value->max.'',
					);
		endforeach;
		return $temp_menu;
	}

	private function _parsing($parent_id = 0, $submenu = true) {
        if (isset($this->_temp_menu[$parent_id])):
        	//rint_debug($this->_temp_menu[$parent_id]);
        	foreach ($this->_temp_menu[$parent_id] as $data):
				$id     = $data->flow_id;

			$orname =$this->workflow_detail_model->get_or($data->workflow_id,$data->flow_order,$data->project_id)->get()->result();
			// print_debug($orname);
			// exit();			
			if (!empty($orname)) {
				$nama_or ='';
				$id_orr = '';
				$id_or = '';

				foreach ($orname as $key => $value) {
				
					$deleteor = anchor(NULL, '<i class="fa fa-trash-o"></i></a>', array(
                        'class'          => 'btn btn-danger btn-xs pull-right',
                        'rel'            => 'tooltip',
                        'data-placement' => "top",
                        'title'     => 'HAPUS OR '.$value->nama_role.' ',
                        'data-url'       => base_url() . $this->_module . '/delete/'. $value->flow_id,  
                        'onclick'        => '$(this).myForm().submit(\'delete\')'
                    ));
					$id_or .= $value->flow_id;

					$id_orr .= '<ol class="dd-list" style="display:none">
				                <li class="dd-item " data-id="'.$value->flow_id.'">
				                   <div class="dd-handlee">'.$value->nama_role.' '.$deleteor.'</div>
				                   
				                </li>
				               </ol>';
				   

					if ($data->or_order == 1) {
						$nama_or .= '';
					}else{
						$nama_or .= '<span style="color:red;"> OR </span>'.$value->nama_role.'' ;
					}

				}
				
			}else{
				$nama_or = '';
				$id_or = '';
				$id_orr = '';
			}

			if ($data->skip_order == 1) {
				$style = 'style="background: red none repeat scroll 0% 0%; border-color: red;" ';
			}else{
				$style = ' ';
			}
				

				$flow = '<div class="dd-handle dd3-handle">&nbsp;</div>';
				$flow .= '<div class="dd3-content" '.$style.'>';

				$flow .= ''.$data->role_name.' '.$data->range.' '.$nama_or.' ';
				$flow .= '<div class="pull-right">';

				

                if ($data->skip_order == 1) {
                	if ($this->laccess->otoritas('edit')) {
                		if ($data->or_order == 1) {

                		}else{
                			  $flow .= anchor(NULL, '<i class="fa fa-scissors"></i> Unskip</a>', array(
	                        'class'          => 'btn btn-info btn-xs',
	                        'rel'            => 'tooltip',
	                        'data-placement' => "top",
	                        'data-title'     => 'Unskip',
	                        'data-url'       => base_url() . $this->_module . '/skip/'.$id.'/'.$data->workflow_id.'/'.$data->project_id.'/2',  
	                        'onclick'        => '$(this).myForm().submit(\'skip\')'
	                    	));
                		}
	                  
                	}
				}else{
					
					if ($this->laccess->otoritas('edit')) {
						if ($data->or_order == 1) {

                		}else{
                			 $flow .= anchor(NULL, '<i class="fa fa-scissors"></i> Skip</a>', array(
	                        'class'          => 'btn btn-warning btn-xs',
	                        'rel'            => 'tooltip',
	                        'data-placement' => "top",
	                        'data-title'     => 'Skip',
	                        'data-url'       => base_url() . $this->_module . '/skip/'.$id.'/'.$data->workflow_id.'/'.$data->project_id.'/1',  
	                        'onclick'        => '$(this).myForm().submit(\'skip\')'
	                    	));
						}
	                   
                	}
				}


                if ($this->laccess->otoritas('delete')) {
                    $flow .= anchor(NULL, '<i class="fa fa-trash-o"></i></a>', array(
                        'class'          => 'btn btn-danger btn-xs',
                        'rel'            => 'tooltip',
                        'data-placement' => "top",
                        'data-title'     => 'Hapus',
                        'data-url'       => base_url() . $this->_module . '/delete/'.$id.'/'.$id_or.'',  
                        'onclick'        => '$(this).myForm().submit(\'delete\')'
                    ));
                }

                

                $flow .= '</div>';
                $flow .= '</div>';

                $this->_html_menu .= '<li class="dd-item dd3-item " data-id="'.$id.'">' . $flow . ' '.$id_orr.' </li>';

        	endforeach;
        endif;
    }

	private function _ordering($nestable)
	{
		if(is_array($nestable)):
			$order = 1;

			foreach ($nestable as $value):
				$this->_temp_ordering[$value->id] = array('flow_order' => $order);
			if (!empty($value->children)) {
				foreach ($value->children as $key => $valuechild) {
				$this->_temp_ordering[$valuechild->id] = array('flow_order' => $order);
				}
				
			}
				
				$order++;
			endforeach;
		endif;
	}

	private function _flow($key = array()) {
        $this->_temp_menu = $this->_list($key);
        $this->_html_menu = '<ol class="dd-list">';
        $this->_parsing(0);
        $this->_html_menu .= '</ol>';
        return $this->_html_menu;
    }

    public function save_duplicate(){

    	if ($this->laccess->otoritas('edit')):

    		$type_workflow = $this->input->post('order');
	    	$from = $this->input->post('project_id_from');
	    	$to = $this->input->post('project_id_to');

	    	$workflow_id = $this->db->select('* from sys_workflow where "order" = '.$type_workflow.' ')->get()->row()->workflow_id;

	    	$dt_form = $this->db->select("* from sys_workflow_detail where workflow_id = '".$workflow_id ."' and project_id = '".$from."' ")->get();

	    	$data_to = $this->db->select(" * from sys_workflow_detail where workflow_id = '".$workflow_id."' and project_id = '".$to."' ")->get();

	    
	    	if ($data_to->num_rows() > 0 ) {

	    		 $this->db->where('workflow_id',$workflow_id);
	    		 $this->db->where('project_id',$to);
       			 $this->db->delete('sys_workflow_detail');
	    	}


	    	foreach ($dt_form->result() as $key => $value) {

	    		$data = [
                            
							'role_id' =>  $value->role_id,
							'workflow_id'   =>  $value->workflow_id,
							'flow_order'   =>  $value->flow_order,
							'flow_flag' =>  $value->flow_flag,
							'cabang_id' =>  $value->cabang_id,
							'project_id' =>  $to,
							'skip_order' =>  $value->skip_order,
							'or_order' =>  $value->or_order,

                        ];
                                            

 			$this->workflow_detail_model->create($data);
					  
	    	}

	    	echo json_encode($workflow_id);


		else:

		echo Modules::run('template/error_message/error_forbidden');

		endif;
	    	
  
	    
    }

}