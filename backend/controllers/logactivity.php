<?php

/**
 * Description of Master Mata Uang (Currency)
 *
 * @author Candra Daniswara
 */
class logactivity extends MX_Controller {

    private $_class_name = '';
    private $_title      = 'Log Activity';
    private $_module     = 'backend';

    public function __construct() {
        parent::__construct();

        # Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', TRUE);

        $this->_class_name  = get_class($this);
        $this->_module     .= '/' . $this->_class_name;

        $this->load->model('logactivity_model');
        $this->load->model('user_model');
    }

    public function index() {
        if (hprotection::must_ajax($this->_module)) {     
            $data['page_title'] = $this->_title;
            $data['_modul']     = $this->_module;
            $data['_title']     = $this->_title;

            $this->load->view($this->_module . '/index', $data);
        }
    }

    public function load() {
        if (hprotection::must_ajax($this->_module)) {

            # Data Table
            $limit        = $this->input->post('length');
            $offset       = $this->input->post('start');
            $draw         = $this->input->post('draw');
            $extra_search = $this->input->post('extra_search');
            $data_cond    = hgenerator::seriliaze_decode($extra_search);

            # Condition 
            $cond = array();

            if (!empty($data_cond['keyword'])) {
                $cond["(a.id_activity_log LIKE '%{$data_cond['keyword']}%' OR a.activity LIKE '%{$data_cond['keyword']}%')"] = NULL;
            }

            $data_count  = $this->logactivity_model->data($cond)->count_all_results();
            $data_result = $this->logactivity_model->data($cond, 'a.id_activity_log', 'asc', $limit, $offset)->get();
            
            $rows        = array();
            $no          = $offset;

            foreach ($data_result->result() as $value) {
                $id     = $value->id_activity_log;
                $action = '';

                if ($this->laccess->otoritas('edit')) {
                    $action .= anchor(NULL, '<i class="fa fa-edit"></i></a>', array(
                        'class'               => 'btn btn-warning btn-xs margin-right-2',
                        'id'                  => 'mybutton-edit-' . $id,
                        'data-breadcrumb'     => 'Edit',
                        'onclick'             => 'my_form.open(this.id)',
                        'data-module'         => $this->_module,
                        'data-url'            => $this->_module . '/edit/' . $id,
                        'data-original-title' => 'Edit',
                        'rel'                 => 'tooltip'
                    ));
                }

                if ($this->laccess->otoritas('delete')) {
                    $action .= anchor(NULL, '<i class="fa fa-trash-o"></i></a>', array(
                        'class'               => 'btn btn-danger btn-xs',
                        'id'                  => 'mybutton-delete-' . $id,
                        'onclick'             => 'my_data_table.row_action.ajax(this.id)',
                        'data-url'            => base_url() . $this->_module . '/delete/' . $id,
                        'data-original-title' => 'Delete',
                        'rel'                 => 'tooltip'
                    ));
                }

                $no++;
                $rows[] = array(
                    hgenerator::columns_align($no, 'center'),
                    $value->activity,
                    $value->waktu,
                    $value->nama_user,
                    hgenerator::button_action($action)
                );
            }

            $data = array(
                "draw"            => $draw,
                "recordsTotal"    => $data_count,
                "recordsFiltered" => $data_count,
                "data"            => $rows
            );

            echo json_encode($data);
        }
    }

    public function add($id = '') {
        if ($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {
            if (hprotection::must_ajax($this->_module . '/add')) {
                $data['page_title']  = 'Add ' . $this->_title;
                $data['_modul']      = $this->_module;
                $data['form_action'] = $this->_module . '/proses';
                #Option
                $data['opt_id_user'] = $this->user_model->options();
                # Cek data edit
                $data['edit_id'] = $id;
                if ($id != '') {
                    $data['page_title'] = 'Edit ' . $this->_title;
                    $data_edit = $this->logactivity_model->data($id)->get();
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
        if ($this->logactivity_model->data($id)->count_all_results() > 0) {
            $this->add($id);
        } else {
            echo Modules::run('template/error_message/error_404');
        }
    }

    public function proses() {
        if ($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {
            if (hprotection::must_ajax($this->_module . '/404')) {

                $this->form_validation->set_rules('activity', '<i class="fa fa-warning"></i>', 'trim|required|callback_cek_duplikat');
                $this->form_validation->set_rules('id_user', '<i class="fa fa-warning"></i>', 'trim|required');

                if ($this->form_validation->run($this)) {
                    $message = array('error', 'Error!', 'Terjadi error pada saat penyimpanan, silahkan coba lagi.', '');

                    $id = $this->input->post('edit_id');
                    $id_user= $this->input->post('id_user');
                    $data = array(
                        'activity'   => $this->input->post('activity'),
                        'id_user' => $this->input->post('id_user'),
                        'waktu' => date("Y-m-d")." ".gmdate('H:i:s',time()+7*3600),
                        'status'=> 't',
                        'id_pegawai'=> $this->user_model->data($id_user)->get()->row()->id_pegawai
                    );

                    if ($id == '') {
                        if ($this->logactivity_model->create($data)) {
                            $message = array(true, 'Proses berhasil', 'Data berhasil disimpan.', 'my_form.reset(\'#finput\')');
                        }
                    } else {
                        if ($this->logactivity_model->update($data, $id)) {
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
            if ($this->logactivity_model->data($id)->count_all_results() > 0) {
                if ($this->logactivity_model->delete($id)) {
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
