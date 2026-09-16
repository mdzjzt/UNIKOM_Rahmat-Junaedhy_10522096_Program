<?php

/**
 * Description of Backend System Setting
 *
 * @author Warman Suganda
 */
class syssetings extends MX_Controller {

    private $_class_name = '';
    private $_title = 'Sys Setting';
    private $_module = 'backend';

    public function __construct() {
        parent::__construct();

        # Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', TRUE);

        $this->_class_name = get_class($this);
        $this->_module .= '/' . $this->_class_name;

        $this->load->model('syssetings_model');
    }

    public function index() {
        if (hprotection::must_ajax($this->_module)) {
            $data['page_title'] = $this->_title;
            $data['_modul'] = $this->_module;
            $data['_title'] = $this->_title;

            

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

            if (!empty($data_cond['keyword'])) {
                $cond["(a.key_setting LIKE '%{$data_cond['keyword']}%' OR a.name_setting LIKE '%{$data_cond['keyword']}%' OR a.value_setting LIKE '%{$data_cond['keyword']}%' OR a.description_setting LIKE '%{$data_cond['keyword']}%')"] = NULL;
            }

            $cond['a.sys_id_setting IS NULL'] = NULL;

            $data_count = $this->syssetings_model->data($cond)->count_all_results();
            $data_result = $this->syssetings_model->data($cond, 'a.id_setting', 'asc', $limit, $offset)->get();

            $rows = array();
            $no = $offset;

            foreach ($data_result->result() as $value) {
                $id = $value->id_setting;

                $action = anchor(NULL, '<i class="fa fa-plus-square-o"></i></a>', array(
                    'class' => 'btn btn-success btn-xs margin-right-2 view-detail',
                    'id' => 'mybutton-detail-' . $id,
                    'data-id' => $id,
                    'data-source' => $this->_module . '/child/' . $id,
                    'data-type' => 'html',
                    'onclick' => 'my_data_table.row_detail(this.id)',
                    'data-original-title' => 'View Detail',
                    'rel' => 'tooltip'
                ));


                if ($this->laccess->otoritas('edit')) {
                    $action .= anchor($this->_module . '/edit/' . $id, '<i class="fa fa-edit"></i></a>', array(
                        'class' => 'btn btn-warning btn-xs margin-right-2',
                        'id' => 'mybutton-edit-' . $id,
                        'data-toggle' => "modal",
                        'data-target' => "#remoteModal",
                        'data-keyboard' => "false",
                        'data-backdrop' => "static",
                        'data-original-title' => 'Edit',
                        'rel' => 'tooltip'
                    ));
                }

                if ($this->laccess->otoritas('delete')) {
//                    $action .= anchor(NULL, '<i class="fa fa-trash-o"></i></a>', array(
//                        'class'    => 'btn btn-danger btn-xs',
//                        'id'       => 'mybutton-delete-' . $id,
//                        'onclick'  => 'my_data_table.row_action.ajax(this.id)',
//                        'data-url' => base_url() . $this->_module . '/delete/' . $id
//                    ));
                }

                $no++;
                $rows[] = array(
                    hgenerator::columns_align($no, 'center'),
                    hgenerator::columns_align($value->key_setting, 'center'),
                    $value->name_setting ,
                    $value->value_setting,
                    $value->description_setting,
                    hgenerator::button_action($action)
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
                $data['page_title'] = 'Add ' . $this->_title;
                $data['_modul'] = $this->_module;
                $data['form_action'] = $this->_module . '/proses';

                # Cek data edit
                $data['edit_id'] = $id;
                if ($id != '') {
                    $data['page_title'] = 'Edit ' . $this->_title;
                    $data_edit = $this->syssetings_model->data($id)->get();
                    if ($data_edit->num_rows() > 0) {
                        $row = $data_edit->row();
                        $data['data_edit'] = $row;
                    }
                }

                $this->load->view($this->_module . '/form', $data);
            }
        } else {
            echo Modules::run('template/error_message/error_forbidden');
        }
    }

    public function edit($id = '') {
        # Cek data edit
        if ($this->syssetings_model->data($id)->count_all_results() > 0) {
            $this->add($id);
        } else {
            echo Modules::run('template/error_message/error_404');
        }
    }

    public function child($id = '') {
        if (hprotection::must_ajax($this->_module)) {
            $data['page_title'] = $this->_title;
            $data['_modul'] = $this->_module;
            $data['_title'] = $this->_title;

            $this->load->view($this->_module . '/child', $data);
        }
    }

    public function proses() {
        if ($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {
            if (hprotection::must_ajax($this->_module . '/404')) {

                $this->form_validation->set_rules('key_setting', '<i class="fa fa-warning"></i>', 'trim|required');
                $this->form_validation->set_rules('name_setting', '<i class="fa fa-warning"></i>', 'trim|required');
				$this->form_validation->set_rules('value_setting', '<i class="fa fa-warning"></i>', 'trim|required');

                if ($this->form_validation->run($this)) {
                    $message = array('error', 'Error!', 'Terjadi error pada saat penyimpanan, silahkan coba lagi.', '');

                    $id = $this->input->post('edit_id');

                    $data = array(
                        'key_setting' => $this->input->post('key_setting'),
                        'name_setting' => $this->input->post('name_setting'),
						'value_setting' => $this->input->post('value_setting'),
						'description_setting' => $this->input->post('description_setting')
                    );

                    if ($id == '') {
                        if ($this->syssetings_model->create($data)) {
                            $message = array(true, 'Proses berhasil', 'Data berhasil disimpan.', 'my_form.reset(\'#finput\')');
                        }
                    } else {
                        if ($this->syssetings_model->update($data, $id)) {
                            $message = array(true, 'Proses berhasil', 'Data berhasil diupdate.', '');
                        }
                    }
                } else {
                    $message = array(false, 'Proses gagal', $this->form_validation->get_errors_array(), '');
                }

                echo json_encode($message);
            }
        } else {
            echo Modules::run('template/error_message/error_forbidden');
        }
    }

    public function delete($id = '') {
        if ($this->laccess->otoritas('delete')) {
            # Cek data edit
            if ($this->syssetings_model->data($id)->count_all_results() > 0) {
                if ($this->syssetings_model->delete($id)) {
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
