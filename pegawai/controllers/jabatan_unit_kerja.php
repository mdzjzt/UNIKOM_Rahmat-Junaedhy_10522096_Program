<?php

/* 	author : Syaifullah 
  last edited : 14.12.03 - 23.45
 */

class jabatan_unit_kerja extends MX_Controller {

	private $class_name;
	private $limit = 10;
	private $_title = 'Pemetaan Jabatan Unit Kerja';
	private $_module	 = 'pegawai';

    public function __construct() {
	parent::__construct();
	#Protection
	hprotection::login();
	$this->laccess->check();
	$this->laccess->otoritas('view',TRUE);

	$this->_class_name = get_class($this);
	$this->_module    .= '/' . $this->_class_name;

	#Load Model
	$this->load->model('jabatan_model'); 
	$this->load->model('kelompok_jabatan_model'); 
	$this->load->model('jenis_jabatan_model'); 
	$this->load->model('jabatan_unit_kerja_model'); 
	
	$this->load->model('unit_kerja_model');
	$this->load->model('lokasi_kerja_model');
	$this->load->model('referensi_jabatan_model');
    }

    public function index() {
	$data = array(
					'page_title' => $this->_title,
					'_modul'	 => $this->_module,
					'_title'	 => $this->_title, 
					'posisi_options'	 => $this->jabatan_unit_kerja_model->options_posisi(array(), array('' => '--Pilih Kelompok--')),
					'unit_options'	 	 => $this->jabatan_unit_kerja_model->options_unit(array(), array('' => '--Pilih Jenis--')),
					'lokasi_options'	 	 => $this->jabatan_unit_kerja_model->options_lokasi(array(), array('' => '--Pilih Jenis--')),
				);
				
        $data['button_group'] = array();
        if ($this->laccess->otoritas('add')) {
            $data['button_group'] = array(
                anchor(null, '<i class="icon-plus"></i> Tambah Data', array('id' => 'button-add', 'class' => 'btn yellow', 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url('jabatan_unit_kerja/add')))
            );
        }
        $this->load->view($this->_module.'/index',$data);
    }

	public function load($page = 0) {
		if(hprotection::must_ajax($this->_module)):

			# Data Table
			$limit  = $this->input->post('length');
			$offset = $this->input->post('start');
			$draw   = $this->input->post('draw');
			$extra_search = $this->input->post('extra_search');
			$data_cond    = hgenerator::seriliaze_decode($extra_search);

			# Condition
			$cond = array();
			$posisi = $this->input->post('posisi_index');
			$cabang = $this->input->post('cabang_index');
			$unit = $this->input->post('unit_index');
			$status = $this->input->post('status');
			
			if (!empty($posisi)){
				//$searchposisi = "(a.kd_jabatan = '".$searchposisi."')"
				$cond["(a.kd_jabatan = '{$posisi}') "] = NULL;
			}
			if (!empty($cabang)){
				$cond["(a.kd_cabang = '{$cabang}') "] = NULL;
			}
			if (!empty($unit)){
				$cond["(a.kd_unit_kerja = '{$unit}') "] = NULL;
			}
			if (!empty($status)){
				$searchstatus = "(a.status = '".$status."')"
				$cond[$searchstatus] = NULL;
			}
				
			$data_count  = $this->jabatan_unit_kerja_model->data($cond)->count_all_results();
			$this->db->order_by('a.id_mapping_jabatan');
			$this->db->limit($limit, $offset);
			$data_result = $this->jabatan_unit_kerja_model->data($cond,$limit, $offset, 'a.id_mapping_jabatan')->get();

			//$data_result = $this->jabatan_unit_kerja_model->data($cond, $limit, $offset,'a.id_mapping_jabatan')->get();
			
			$rows = array();
			$no   = $offset;

			foreach ($data_result->result() as $value) {
			
				$id = $value->id_mapping_jabatan;

				$action = '';
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
				$cabang_nama = $value->kd_cabang . ' - ' . $value->cabang_nama;
				$unit_kerja_nama = '[' . $value->kd_unit_kerja . '] ' . $value->unit_kerja_nama;
				$jabatan_nama = $value->jabatan_nama;
				$masa_berlaku = hgenerator::switch_tanggal($value->tanggal_berlaku) . ' s/d ' . (!empty($value->tanggal_berakhir) ? hgenerator::switch_tanggal($value->tanggal_berakhir) : 'Tidak ditentukan' );
				
				$rows[] = array(
					hgenerator::columns_align($no,'center'),
					$cabang_nama,
					$unit_kerja_nama,
					$jabatan_nama,
					$masa_berlaku,
					hgenerator::button_action($action),
				);
				
			}
			
			$data = array(
				'draw' => $draw,
				'recordsTotal' => $data_count,
				'recordsFiltered' => $data_count,
				'data' => $rows, 
			);
			
			echo json_encode($data);

		endif;
	}

    public function add($id = '') {
        if ($this->laccess->otoritas('add')) {
    
            $data['lokasikerja_options'] = $this->lokasi_kerja_model->options();
            $data['unitkerja_options'] = $this->unit_kerja_model->options();
            $data['jabatan_options'] = $this->referensi_jabatan_model->options();
            $data['parent_options'] = $this->jabatan_unit_kerja_model->options();
	    
            $data['unitkerja_source'] = base_url('pegawai/jabatan_unit_kerja/get_unitkerja');
    
            $title = 'Tambah Data Jabatan Unit Kerja';
            $data['form_action'] = 'pegawai/jabatan_unit_kerja/proses';
    
            $data['edit_id'] = $id;
            if ($id != '') {
                $title = 'Edit Data Jabatan Unit Kerja';
    
                $db = $this->jabatan_unit_kerja_model->get_by_id($id);
                if ($db->num_rows() > 0) {
                    $row = $db->row();
                    $data['default'] = $row;
                }
            }
    
            $data['title'] = '<i class="icon-edit"></i> ' . $title;
	    
		$this->load->view($this->_module.'/form',$data);
        } else {
            $this->laccess->redirect();
        }
    }

    public function edit($id) {
        if ($this->laccess->otoritas('edit')) {
            $this->add($id);
        } else {
            $this->laccess->redirect();
        }
    }

    public function proses() {
    
        if ($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {
            $akhir_berlaku = $this->input->post('tanggal_berakhir');
            
            $this->form_validation->set_rules('kd_cabang', 'Nama Cabang', 'required');
            $this->form_validation->set_rules('kd_unit_kerja', 'Nama Unit Kerja', 'required');
            $this->form_validation->set_rules('kd_jabatan', 'Nama Jabatan', 'required');
            $this->form_validation->set_rules('status', 'Status', 'required');
    
            if ($this->form_validation->run()) {
                $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
    
                $id = $this->input->post('edit_id');
	
                $data = array(
                    'kd_cabang' => $this->input->post('kd_cabang'),
                    'kd_unit_kerja' => $this->input->post('kd_unit_kerja'),
                    'kd_jabatan' => $this->input->post('kd_jabatan'),
                    'status' => $this->input->post('status'),
                    'tanggal_berlaku' => hgenerator::switch_tanggal(date("Y-m-d")),
                );
                if ($akhir_berlaku != ''){
                    $data['tanggal_berakhir'] = hgenerator::switch_tanggal($akhir_berlaku);
                }
                else{
                    $data['tanggal_berakhir'] = null;
                }
                
                $parent_id = $this->input->post('parent');
                if (!empty($parent_id)) {
                    $data['parent'] = $parent_id;
                }
		
                if ($id == '') {
                    if ($this->jabatan_unit_kerja_model->create($data)) {
			$message = array(TRUE,'Proses Berhasil','Data Berhasil Disimpan','__after_process(1)');
                    }
                } else {
                    if ($this->jabatan_unit_kerja_model->update($data, $id)) {
			$message = array(TRUE,'Proses Berhasil','Data Berhasil Disimpan','__after_process(0)');
                    }
                }
            } else {
                $message = array(false, 'Terjadi Kesalahan', validation_errors(), '');
            }
            echo json_encode($message);
        } else {
            $this->laccess->redirect();
        }
    }

    public function delete($id) {
        if ($this->laccess->otoritas('delete', true)) {
            $message = array(false, 'Proses gagal', 'Proses hapus data gagal.', '');
            if ($this->jabatan_unit_kerja_model->delete($id)) {
			$message = array(TRUE,'Proses Berhasil', 'Proses hapus data berhasil','__after_process(1)');
            }
            echo json_encode($message);
        } else {
            $this->laccess->redirect();
        }
    }

    public function get_unitkerja() {
        $this->load->model('lokasi_unit_kerja_model');
        $kode = $this->input->post('kode');
        $selected = $this->input->post('selected');

        $options = array(null => '--Pilih Unit--');

        if (!empty($kode)) {
            $data = $this->lokasi_unit_kerja_model->get_data(array('a.kd_cabang' => $kode));
            foreach ($data->result() as $value) {
                $options[$value->kd_unit_kerja] = ' [' . $value->kd_unit_kerja . '] ' . $value->nama_unit_kerja;
            }
        }

        echo json_encode(hgenerator::array_to_option($options, $selected));
    }

    
    
}
