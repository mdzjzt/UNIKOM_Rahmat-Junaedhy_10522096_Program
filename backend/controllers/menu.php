<?php


class menu extends MX_Controller {

    private $_class_name = '';
    private $_title = 'Menu';
    private $_module = 'backend';
    private $_temp_menu = array();
    private $_temp_ordering = array();
    private $_html_menu = '';

    public function __construct() {
        parent::__construct();

        # Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', TRUE);

        $this->_class_name = get_class($this);
        $this->_module .= '/' . $this->_class_name;

        $this->load->model('modul_model');
    }

    public function index() {
        if (hprotection::must_ajax($this->_module)) {
            
            $data['page_title'] = $this->_title . ' Management';
            $data['_modul'] = $this->_module;
            $data['_title'] = $this->_title;
            
            # LOG
            $this->log_activity_model->save([
                        'module'   => $this->_module,
                        'event'    => 'View',
                        'activity' => 'View Management Menu'
            ]);

            $this->load->view($this->_module . '/index', $data);
        }
    }

    public function load() {
        if (hprotection::must_ajax($this->_module)) {
            $data['list_data_menu'] = $this->_admin();
            $data['form_action'] = $this->_module . '/proses_ordering';
            $this->load->view($this->_module . '/nestable', $data);
        }
    }

    public function add($id = '', $parent = '') {
        if ($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {
            if (hprotection::must_ajax($this->_module . '/add')) {
                $data['page_title'] = 'Add ' . $this->_title;
                $data['_modul'] = $this->_module;
                $data['form_action'] = $this->_module . '/proses';

                # Cek data edit
                $data['edit_id'] = $id;
                if ($id != '') {
                    $data['page_title'] = 'Edit ' . $this->_title;
                    $data_edit = $this->modul_model->data($id)->get();
                    if ($data_edit->num_rows() > 0) {
                        $row = $data_edit->row();
                        $data['data_edit'] = $row;
                    }
                } else {
                    $data['m_m_id_menu'] = $parent;
                }

                $this->load->view($this->_module . '/form', $data);
            }
        } else {
            echo Modules::run('template/error_message/error_forbidden');
        }
    }

    public function edit($id = '') {
        # Cek data edit
        if ($this->modul_model->data($id)->count_all_results() > 0) {
            $this->add($id);
        } else {
            echo Modules::run('template/error_message/error_404', 'Data yang anda cari tidak ditemukan.');
        }
    }

    public function add_child($id = '') {
        # Cek data edit
        if ($this->modul_model->data($id)->count_all_results() > 0) {
            $this->add('', $id);
        } else {
            echo Modules::run('template/error_message/error_404', 'Data yang anda cari tidak ditemukan.');
        }
    }

    public function proses() {
        if ($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {
            if (hprotection::must_ajax($this->_module . '/404')) {

                $this->form_validation->set_rules('menu_name', '<i class="fa fa-warning"></i>', 'trim|required|max_length[50]');
                $this->form_validation->set_rules('menu_url', '<i class="fa fa-warning"></i>', 'trim|required|max_length[50]');

                if ($this->form_validation->run($this)) {
                    $message = array('error', 'Error!', 'An error occurred during storage, please try again.', '');

                    $id = $this->input->post('edit_id');
                    $m_m_id_menu = $this->input->post('m_m_id_menu');

                    $data = array(
                        'nama_menu' => $this->input->post('menu_name'),
                        'url_menu'  => $this->input->post('menu_url'),
                        'icon_menu' => $this->input->post('menu_icon')
                    );

                    if ($id == '') {

                        $data['urut_menu'] = 0;
                        $data['m_m_id_menu'] = !empty($m_m_id_menu) ? $m_m_id_menu : NULL;

                        if ($this->modul_model->create($data)) {
                            $message = array(true, 'Process Successfully', 'The data has been saved.', 'load_and_reset_form()');
                            # LOG
                            $this->log_activity_model->save([
                                        'module'   => $this->_module,
                                        'sistem'   => TRUE,
                                        'event'    => 'Insert',
                                        'activity' => 'Insert Menu'
                            ]);
                        }
                    } else {
                        if ($this->modul_model->update($data, $id)) {
                            $message = array(true, 'Process Successfully', 'The data has been updated.', 'pagefunction()');
                            # LOG
                            $this->log_activity_model->save([
                                        'module'   => $this->_module,
                                        'sistem'   => TRUE,
                                        'event'    => 'Update',
                                        'activity' => 'Update Menu'
                            ]);
                        }
                    }
                } else {
                    $message = array(false, 'Process Fails', $this->form_validation->get_errors_array(), '');
                }

                echo json_encode($message);
            }
        } else {
            echo Modules::run('template/error_message/error_forbidden');
        }
    }

    public function proses_ordering() {
        if ($this->laccess->otoritas('edit')) {
            if (hprotection::must_ajax($this->_module . '/404')) {

                $nestable = $this->input->post('nestable_output');
                if (!empty($nestable)) {
                    $this->_ordering(json_decode($nestable));
                    # print_debug($this->_temp_ordering);
                    if ($this->modul_model->update_ordering($this->_temp_ordering)) {
                        $message = array(true, 'Process Successfully', 'The data has been saved.', 'pagefunction()');

                        # LOG
                        $this->log_activity_model->save([
                                    'module'   => $this->_module,
                                    'sistem'   => TRUE,
                                    'event'    => 'Update',
                                    'activity' => 'Update Ordering Menu'
                        ]);

                    } else {
                        $message = array('error', 'Error!', 'An error occurred during storage, please try again.', '');
                    }
                } else {
                    $message = array(true, 'Process Successfully', 'The data has been saved.', 'pagefunction()');
                }

                echo json_encode($message);
            }
        } else {
            echo Modules::run('template/error_message/error_forbidden');
        }
    }

    private function _ordering($nestable, $m_m_id_menu = NULL) {
        if (is_array($nestable)) {
            $menu_order = 1;
            foreach ($nestable as $value) {
                $this->_temp_ordering[$value->id] = array(
                    'urut_menu' => $menu_order,
                    'm_m_id_menu' => $m_m_id_menu
                );

                if (isset($value->children)) {
                    $this->_ordering($value->children, $value->id);
                }
                $menu_order++;
            }
        }
    }

    public function delete($id = '') {
        if ($this->laccess->otoritas('delete')) {

            # Cek data edit
            if ($this->modul_model->data($id)->count_all_results() > 0) {
                if ($this->modul_model->data(array('a.m_m_id_menu' => $id))->count_all_results() == 0) {
                    #extend model
                    $this->load->model('role_authorities_model');

                    if ($this->modul_model->data(array('a.m_m_id_menu' => $id))->count_all_results() > 0) {
                        $message = array(false, 'Process Fails', 'The data failed to delete, karena memiliki turunan.', '');
                    } else {
                        if ($this->modul_model->delete($id)) {
                            $message = array(true, 'Process Successfully', 'The Data has been deleted.', 'pagefunction()');
                        } else {
                            $message = array(false, 'Process Fails', 'The data failed to delete.', '');
                        }
                    }
                } else {
                    $message = array(false, 'Process Fails', 'Data tidak bisa dihapus, karena memiliki Submenu.', '');
                }
            } else {
                $message = array(false, 'Error', 'The data will be deleted not found.', '');
            }

            # LOG
            $this->log_activity_model->save([
                        'module'   => $this->_module,
                        'sistem'   => TRUE,
                        'event'    => 'Delete',
                        'activity' => 'Delete Menu'
            ]);

            echo json_encode($message);

        } else {
            echo Modules::run('template/error_message/error_forbidden');
        }
    }

    private function _list($key = array()) {
        $data = $this->modul_model->data($key, 'a.urut_menu')->get();

        $temp_menu = array();
        foreach ($data->result() as $value) {
            $parent_id = $value->m_m_id_menu;
            $parent = !empty($parent_id) ? $parent_id : 0;
            $menu_url = '#';

            if (!empty($value->url_menu)) {
                $menu_url = $value->url_menu;
            }

            $temp_menu[$parent][] = (object) array(
                        'menu_id' => $value->id_menu,
                        'menu_name' => $value->nama_menu,
                        'menu_icon' => $value->icon_menu,
                        'menu_url' => $menu_url
            );
        }
        return $temp_menu;
    }

    private function _parsing($parent_id = 0, $submenu = true) {
        if (isset($this->_temp_menu[$parent_id])) {
            foreach ($this->_temp_menu[$parent_id] as $menu) {
                $menu_id = $menu->menu_id;
                $url = $menu->menu_url != '#' ? '#' . $menu->menu_url : $menu->menu_url;
                $menu_icon = $menu->menu_icon;

                $nama_menu = '<div class="dd-handle dd3-handle">&nbsp;</div>';
                $nama_menu .= '<div class="dd3-content">';
                $nama_menu .= '     <i class="fa fa-lg fa-fw ' . $menu_icon . '"></i>  ' . $menu->menu_name . ' <span class="text-info"> - ' . $url . '</span>';
                $nama_menu .= '     <div class="pull-right">';

                if ($this->laccess->otoritas('add')) {
                    $nama_menu .= anchor($this->_module . '/add_child/' . $menu_id, '<i class="fa fa-plus"></i>', array(
                        'id' => 'mybutton-add-child-' . $menu_id,
                        'class' => 'btn btn-primary btn-xs margin-right-2',
                        'data-toggle' => "modal",
                        'data-target' => "#remoteModal"
                    ));
                }

                if ($this->laccess->otoritas('edit')) {
                    $nama_menu .= anchor($this->_module . '/edit/' . $menu_id, '<i class="glyphicon glyphicon-edit"></i>', array(
                        'id' => 'mybutton-edit-' . $menu_id,
                        'class' => 'btn btn-warning btn-xs margin-right-2',
                        'data-toggle' => "modal",
                        'data-target' => "#remoteModal"
                    ));
                }

                if ($this->laccess->otoritas('delete')) {
                    $nama_menu .= anchor(NULL, '<i class="fa fa-trash-o"></i></a>', array(
                        'class' => 'btn btn-danger btn-xs',
                        'id' => 'mybutton-delete-' . trim($menu_id),
                        'onclick' => 'my_data_table.row_action.ajax(this.id)',
                        'data-url' => base_url() . $this->_module . '/delete/' . trim($menu_id)
                    ));
                }

                $nama_menu .= '     </div>';
                $nama_menu .= '</div>';

                if ($submenu) {
                    if (isset($this->_temp_menu[$menu_id])) {
                        $this->_html_menu .= '<li class="dd-item dd3-item" data-id="' . $menu_id . '">' . $nama_menu . '';
                        $this->_html_menu .= '  <ol class="dd-list">';
                        $this->_parsing($menu_id);
                        $this->_html_menu .= '  </ol>';
                        $this->_html_menu .= '</li>';
                    } else {
                        $this->_html_menu .= '<li class="dd-item dd3-item" data-id="' . $menu_id . '">' . $nama_menu . '</li>';
                    }
                } else {
                    $this->_html_menu .= '<li class="dd-item dd3-item" data-id="' . $menu_id . '">' . $nama_menu . '</li>';
                }
            }
        }
    }

    private function _admin($key = array()) {
        $this->_temp_menu = $this->_list($key);

        $this->_html_menu = '<ol class="dd-list">';
        $this->_parsing(0);
        $this->_html_menu .= '</ol>';
        return $this->_html_menu;
    }

}
