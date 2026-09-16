<?php

class vendorlist extends MX_Controller {

    private $_class_name = '';
    private $_title = 'Vendor List';
    private $_module = 'home';

    public function __construct() {
        parent::__construct();

        # Protection
        hprotection::login();

        $this->laccess->check();
        $this->laccess->otoritas('view', TRUE);


        $this->_class_name = get_class($this);
        $this->_module .= '/' . $this->_class_name;
       
        $this->load->model('vendor_model');
        $this->load->model('project_model');

        $this->load->model('vendorlist_model');
      
    }

    public function index($id = NULL) {
        if (hprotection::must_ajax($this->_module)) {
            $data['page_title'] = 'Master ' . $this->_title;
            $data['_modul'] = $this->_module;
            $data['_title'] = $this->_title;
            $data['data_daftar_rekanan'] = $this->vendor_model->data_daftar_rekanan()->get()->row();
            $this->load->view($this->_module . '/index', $data);
        }
    }

    public function load() {

        if (hprotection::must_ajax($this->_module)) {

            # Data Table
            $limit = $this->input->post('length');
            $offset = $this->input->post('start');
            $draw = $this->input->post('draw');
            $extra_search = $this->input->post('extra_search');
            $data_cond = hgenerator::seriliaze_decode($extra_search);

            # Condition 
            $cond = array();
            
            if (!empty($data_cond['desccirption'])) {
                $searchname = strtolower($data_cond['desccirption']);

                $cond["LOWER(a.description) LIKE '%{$searchname}%'"] = NULL;
                
            }

            if (!empty($data_cond['size'])) {
                $size = strtolower($data_cond['size']);

                $cond["LOWER(a.size) LIKE '%{$size}%'"] = NULL;
                
            }

            if (!empty($data_cond['qty'])) {
                $qty = strtolower($data_cond['qty']);

                $cond["a.qty = '{$qty}'"] = NULL;
                
            }

            if (!empty($data_cond['unit'])) {
                $unit = strtolower($data_cond['unit']);

                $cond["LOWER(a.unit) LIKE '%{$unit}%'"] = NULL;
                
            }


            if (!empty($data_cond['specification'])) {
                $specification = strtolower($data_cond['specification']);

                $cond["LOWER(a.spesicification) LIKE '%{$specification}%'"] = NULL;
                
            }

            if (!empty($data_cond['vendor'])) {
                $vendor = strtolower($data_cond['vendor']);

                $cond["LOWER(a.vendor) LIKE '%{$vendor}%'"] = NULL;
                
            }

             if (!empty($data_cond['origin'])) {
                $origin = strtolower($data_cond['origin']);

                $cond["LOWER(a.origin) LIKE '%{$origin}%'"] = NULL;
                
            }

             if (!empty($data_cond['remarks'])) {
                $remarks = strtolower($data_cond['remarks']);

                $cond["LOWER(a.remarks) LIKE '%{$remarks}%'"] = NULL;
                
            }

            $data_count = $this->vendorlist_model->data($cond)->count_all_results();
            $data_result = $this->vendorlist_model->data($cond, 'id_vendor_material', 'asc', $limit, $offset)->get();

            $rows = array();
            $no = $offset;

            foreach ($data_result->result() as $value) {
                 $id = $value->id_vendor_material;
                  $action = NULL;

                  
                if ($this->laccess->otoritas('delete')) {
                    $action .= anchor(NULL, '<i class="fa fa-trash-o"></i></a>', array(
                        'class' => 'btn btn-danger btn-xs margin-right-2',
                        'id' => 'mybutton-delete-' . $id,
                        'onclick' => 'my_data_table.row_action.ajax(this.id)',
                        'data-url' => base_url() . $this->_module . '/delete/' . $id,
                        'rel' => 'tooltip',
                        'data-placement' => "top",
                        'title' => 'Delete',
                    ));
                }
                 $action .= anchor($this->_module . '/edit/' . $id, '<i class="fa fa-pencil"></i></a>', array(
                                    'class' => 'btn btn-warning btn-xs margin-right-2',
                                    'id' => 'mybutton-edit-' . $id,
                                    'data-module' => $this->_module,
                                    'data-toggle' => "modal",
                                    'data-target' => "#remoteModalBar",
                                    'data-keyboard' => "false",
                                    'data-backdrop' => "static",
                                    'rel' => 'tooltip',
                                    'data-placement' => "top",
                                    'title' => 'Edit List',
                                ));

                    $unit_price = ' '.$value->currency.'  '.number_format($value->unit_price, 2).' '; 
                    $total_price = ' '.$value->currency.'  '.number_format($value->total_price, 2).' '; 

                 $no++;
                 $rows[] = array(
                                hgenerator::columns_align($no,'center'),
                                $value->description,
                                strtoupper($value->size),
                                strtoupper($value->qty),
                                strtoupper($value->unit),
                                strtoupper($value->spesicification),
                                strtoupper($value->vendor),
                                strtoupper($value->origin),
                                strtoupper($unit_price),
                                strtoupper($total_price),
                                strtoupper($value->remarks),
                                hgenerator::button_action($action),
                            );
              
            }

            $data = array(
                "draw" => $draw,
                "recordsTotal" => $data_count,
                "recordsFiltered" => $data_count,
                "data" => $rows
            );

            echo json_encode($data);
        }
    }

     public function add($id = '') {
        if ($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {
            if (hprotection::must_ajax($this->_module . '/add')) {

                $data['page_title'] = 'Tambah ' . $this->_title;
                $data['_modul'] = $this->_module;
                $data['form_action'] = $this->_module . '/save/'.$id;
              
                $data['vendor_list'] = $this->vendor_model->options_vendor(array(), array('' => '--Pilih--'));

                $this->load->view($this->_module . '/form', $data);
            }
        } else {
            echo Modules::run('template/error_message/error_forbidden');
        }
    }


    public function edit($id){
         if ($this->laccess->otoritas('edit')) {
            if (hprotection::must_ajax($this->_module . '/edit')) {

                $data['page_title'] = 'Edit Material Vendor List ' . $this->_title;
                $data['_modul'] = $this->_module;
                $data['form_action'] = $this->_module . '/proses_edit/'.$id;

                $data_edit = $this->vendorlist_model->data($id)->get();
                    if ($data_edit->num_rows() > 0) {
                        $row = $data_edit->row();
                        $data['data_edit'] = $row;
                    }
               
                $this->load->view($this->_module . '/form_edit', $data);
            }
        } else {
            echo Modules::run('template/error_message/error_404');
        }

    }

    public function proses_edit($id){
        if ($this->laccess->otoritas('edit')) {
             
            if (hprotection::must_ajax($this->_module . '/404')) {

                 $data = [
                                    'description'    => $this->input->post('description'),
                                    'size'     => $this->input->post('size'),
                                    'qty'     => $this->input->post('qty'),
                                    'unit' => $this->input->post('unit'),
                                    'spesicification' => $this->input->post('specification'),
                                    'vendor' =>  $this->input->post('vendor'),
                                    'origin' =>  $this->input->post('origin'),
                                    'unit_price' =>  $this->input->post('unit_price'),
                                    'total_price' =>  $this->input->post('total_price'),
                                    'remarks' =>  $this->input->post('remarks'),
                                    'currency' =>  $this->input->post('simbolcurrency'),
                                ];
                if ($this->vendorlist_model->update($id, $data)) {

                    $message = ['message' => 'Data Berhasil Disimpan', 'return' => '__afterSubmit()'];
                    
                }
                  $this->log_activity_model->save([
                                    'module'   => $this->_module,
                                    'sistem'   => TRUE,
                                    'event'    => 'update',
                                    'activity' => 'Update Vendor Material List'
                        ]);

                     echo json_encode($message);
                
               
            }

        }else{
            echo Modules::run('template/error_message/error_forbidden');
        }

    }


    public function save($id = NULL){
        if ($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {
            if (hprotection::must_ajax($this->_module . '/404')) {

               // $this->form_validation->set_rules('description', '<i class="fa fa-warning"> Description</i>', 'trim|required');

                // if($this->form_validation->run($this)) {

                    
  
                    // var_dump($data);exit();

                    if ($id) {

                        if ($id = $this->vendorlist_model->update($id, $data)) {
                            $message = ['message' => 'Data Berhasil Disimpan', 'return' => '__afterSubmit()'];
                        }

                          # LOG
                        $this->log_activity_model->save([
                                    'module'   => $this->_module,
                                    'sistem'   => TRUE,
                                    'event'    => 'Insert',
                                    'activity' => 'Update Vendor Material List'
                        ]);

                    }else {

                        if ($this->input->post('description')) {

                            foreach ($this->input->post('description') as $key => $value) {

                                $data = [
                                    'description'    => $this->input->post('description')[$key],
                                    'size'     => $this->input->post('size')[$key],
                                    'qty'     => $this->input->post('qty')[$key],
                                    'unit' => $this->input->post('unit')[$key],
                                    'spesicification' => $this->input->post('specification')[$key],
                                    'vendor' =>  $this->input->post('vendor')[$key],
                                    'origin' =>  $this->input->post('origin')[$key],
                                    'unit_price' =>  $this->input->post('unit_price')[$key],
                                    'total_price' =>  $this->input->post('total_price')[$key],
                                    'remarks' =>  $this->input->post('remarks')[$key],
                                    'currency' =>  $this->input->post('simbolcurrency')[$key],
                                ];

                                $this->vendorlist_model->create($data);

                            }

                            $message = ['message' => 'Data Berhasil Disimpan', 'return' => '__afterSubmit()'];

                        }

                        # LOG
                        $this->log_activity_model->save([
                                    'module'   => $this->_module,
                                    'sistem'   => TRUE,
                                    'event'    => 'Insert',
                                    'activity' => 'Insert Vendor Material List'
                        ]);

                    }


                // }else{
                //     $message = ['error' => true, 'message' => 'Terjadi Kesalahan <br> Periksa kembali data input', 'callback' => $this->form_validation->get_errors_array()];
                // }

             echo json_encode($message);
            }
        }else{
            echo Modules::run('template/error_message/error_forbidden');
        }

    }

    
    
	public function import()
    {
        $config['upload_path']   = 'uploads/import_excel/';
        $config['allowed_types'] = 'xlsx|xls|csv';
        $config['max_size']      = 400000;

        if(!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'],0777,TRUE);
        } 

        $this->load->library('upload', $config);

        $files = $_FILES['file'];

        if($this->upload->do_upload('file')) {
            $uploadData = $this->upload->data();
        }

        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));

        $object = IOFactory::load($config['upload_path'] .'/' .$uploadData['file_name']);

        $data = array();
        foreach ($object->getWorksheetIterator() as $worksheet) {
            $worksheetTitle     = $worksheet->getTitle();
            $highestRow         = $worksheet->getHighestRow(); 
            $highestColumn      = $worksheet->getHighestColumn(); 
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $nrColumns = ord($highestColumn) - 64;

            for ($row = 5; $row <= $highestRow; ++ $row) {

                $description              = $worksheet->getCellByColumnAndRow(1, $row); 
                $size                     = $worksheet->getCellByColumnAndRow(2, $row); 
                $qty                      = $worksheet->getCellByColumnAndRow(3, $row);
                $unit                     = $worksheet->getCellByColumnAndRow(4, $row);
                $spec                     = $worksheet->getCellByColumnAndRow(5, $row);
                $vendor                   = $worksheet->getCellByColumnAndRow(6, $row); 
                $origin                   = $worksheet->getCellByColumnAndRow(7, $row);
                $price                    = $worksheet->getCellByColumnAndRow(8, $row); 
                $currency                 = $worksheet->getCellByColumnAndRow(9, $row); 
                $total                    = $qty->getValue() *  $price->getValue() ; 
                $remarks                  = $worksheet->getCellByColumnAndRow(10, $row); 
               
                $data = array(
                        'description'          => $description->getValue(),
                        'size'            => $size->getValue(),
                        'qty'                     => $qty->getValue(),
                        'unit'                   => $unit->getValue(),
                        'spesicification'                   => $spec->getValue(),
                        'vendor'                     => $vendor->getValue(),
                        'origin'            => $origin->getValue(),
                        'unit_price'                   => $price->getValue(),
                        'currency'                  => $currency->getValue(),
                        'total_price'                    => $total,
                        'remarks'                    => $remarks->getValue(),
                        
                       
                       
                    );
                $this->vendorlist_model->create($data);
            }
        }

        echo json_encode(array('message' => 'Proses Berhasil'));
    }

    public function delete($id = '') {
        if ($this->laccess->otoritas('delete')) {
            # Cek data edit
            if ($this->vendorlist_model->data($id)->count_all_results() > 0) {
                if ($this->vendorlist_model->delete($id)) {
                    $message = array(true, 'Proses Berhasil', 'Data berhasil dihapus.', 'my_data_table.reload("#dt_basic")');
                } else {
                    $message = array(false, 'Proses gagal', 'Data gagal dihapus.', '');
                }
            } else {
                $message = array(false, 'Error', 'Data yang akan dihapus tidak ditemukan.', '');
            }
            echo json_encode($message);
        } else {
            echo Modules::run('template/error_message/error_forbidden');
        }
    }


}
 