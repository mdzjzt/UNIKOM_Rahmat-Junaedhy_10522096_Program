<?php

/**
 * Description of role
 *
 * @author Warman Suganda
 */
class role extends MX_Controller {

    private $_class_name = '';
    private $_title = 'Role';
    private $_module = 'backend';
    private $_temp_menu = array();
    private $_html_menu = '';
    private $_authorities = array(
        'view_otoritas_modul' => array(),
        'insert_otoritas_modul' => array(),
        'update_otoritas_modul' => array(),
        'delete_otoritas_modul' => array(),
        'export_otoritas_modul' => array(),
        'import_otoritas_modul' => array(),
        'approve_otoritas_modul' => array()
    );

    public function __construct() {
        parent::__construct();

        # Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', TRUE);

        $this->_class_name = get_class($this);
        $this->_module .= '/' . $this->_class_name;

        $this->load->model('role_model');
        $this->load->model('role_authorities_model');
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
                        'activity' => 'View Role'
            ]);

            $this->load->view($this->_module . '/index', $data);
        }
    }

    public function load() {
        if (hprotection::must_ajax($this->_module)) {

            # Init
            $limit       = $this->input->post('length');
            $offset      = $this->input->post('start');
            $draw        = $this->input->post('draw');
            $extraColumn = $this->input->post('columns');
            $extraOrder  = $this->input->post('order');

             # Ordering
            $orderBy   = 'nama_role';
            $direction = NULL;

            if($extraColumn[$extraOrder[0]['column']]['orderable'] == 'true') {
                $orderBy = isset($extraColumn[$extraOrder[0]['column']]['name']) ? $extraColumn[$extraOrder[0]['column']]['name'] : NULL;
                $direction   = $extraOrder[0]['dir'];
            }

            # Condition
            $cond = [];

            if (!empty($this->input->post('keyword'))) {
                $cond["(LOWER(a.nama_role) ILIKE '%{$this->input->post('keyword')}%' OR LOWER(a.descript_role) ILIKE '%{$this->input->post('keyword')}%')"] = NULL;
            }

            $dataCount         = $this->role_model->data()->count_all_results();
            $dataCountFiltered = $this->role_model->data($cond)->count_all_results();
            $dataResult        = $this->role_model->data($cond, $orderBy, $direction, $limit, $offset)->get();

            $rows = [];
            $no   = $offset;

            foreach ($dataResult->result() as $dt) {

                $id = $dt->id_role;

                $action = NULL;
                if ($this->laccess->otoritas('edit')) {
                    $action .= anchor(NULL, '<i class="fa fa-edit"></i></a>', [
                        'class'     => 'btn btn-warning btn-xs',
                        'data-href' => $this->_module . '/edit/' . $id
                    ]);
                }

                if ($this->laccess->otoritas('delete')) {
                    $action .= anchor(NULL, '<i class="fa fa-trash-o"></i></a>', array(
                        'class'          => 'btn btn-danger btn-xs',
                        'rel'            => 'tooltip',
                        'data-placement' => "top",
                        'data-title'     => 'Hapus',
                        'data-url'       => base_url() . $this->_module . '/delete/'. $id,
                        'onclick'        => '$(this).myForm().submit(\'delete\')'
                    ));
                }

                $no++;
                $rows[] = array(
                    hgenerator::columns_align($no, 'center'),
                    $dt->nama_role,
                    $dt->descript_role,
                    hgenerator::button_action($action)
                );
            }

            $data = [
                "draw"            => $draw,
                "recordsTotal"    => $dataCount,
                "recordsFiltered" => $dataCountFiltered,
                "data"            => $rows
            ];

            echo json_encode($data);
        }
    }

    private $_opt_otoritas_data = array();

    public function add($id = NULL) {
        if ($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {
            if (hprotection::must_ajax($this->_module . '/add')) {

                #extend model
                $this->load->model('app_config_model');


                $data['page_title'] = 'Add ' . $this->_title;
                $data['_modul'] = $this->_module;
                $data['form_action'] = $this->_module . '/proses';

                # Cek data edit
                $data['edit_id'] = $id;
                if ($id != '') {
                    $data['page_title'] = 'Edit ' . $this->_title;
                    $data_edit = $this->role_model->data($id)->get();
                    if ($data_edit->num_rows() > 0) {
                        $row = $data_edit->row();
                        # Load _authorities
                        $this->_authorities($id);
                        $data['data_edit'] = $row;
                    }
                }

                $this->_opt_otoritas_data = $this->app_config_model->options(array('a.key_setting' => 'OTOR_DATA'), NULL);
                $data['opt_otoritas_data'] = $this->_opt_otoritas_data;
                $data['data_menu'] = $this->_admin();
                $this->load->view($this->_module . '/form', $data);
            }
        } else {
            echo Modules::run('template/error_message/error_forbidden');
        }
    }

    public function edit($id) {
        # Cek data edit
        if ($this->role_model->data($id)->count_all_results() > 0) {
            $this->add($id);
        } else {
            echo Modules::run('template/error_message/error_404');
        }
    }

    public function proses() {
        if ($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {
            if (hprotection::must_ajax($this->_module . '/404')) {

                $this->form_validation->set_rules('nama_role', '<i class="fa fa-warning"></i>', 'trim|required|max_length[100]');
                $this->form_validation->set_rules('descript_role', '<i class="fa fa-warning"></i>', 'trim|max_length[150]');

                if ($this->form_validation->run($this)) {
                    $message = array('error', 'Error!', 'An error occurred during storage, please try again.', '');

                    $id = $this->input->post('edit_id');

                    $data = array(
                        'nama_role' => $this->input->post('nama_role'),
                        'descript_role' => $this->input->post('descript_role'),
                        'is_modify_account_code' => $this->input->post('is_modify_account_code')
                    );

                    $authorities = $this->_parsing_authorities();

                    if ($id == '') {
                        if ($this->role_model->create($data, $authorities)) {
                            $message = array(true, 'Process Successfully', 'The data has been saved.', 'my_form.reset(\'#finput\')');

                            # LOG
                            $this->log_activity_model->save([
                                        'module'   => $this->_module,
                                        'sistem'   => TRUE,
                                        'event'    => 'Insert',
                                        'activity' => 'Insert Role'
                            ]);

                        }
                    } else {
                        if ($this->role_model->update($data, $authorities, $id)) {
                            $message = array(true, 'Process Successfully', 'The data has been updated.', '');

                            # LOG
                            $this->log_activity_model->save([
                                        'module'   => $this->_module,
                                        'sistem'   => TRUE,
                                        'event'    => 'Update',
                                        'activity' => 'Update Role'
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

    public function delete($id) {

        if ($this->laccess->otoritas('delete')) {
            # Cek data edit
            if ($this->role_model->data($id)->count_all_results() > 0) {
                if ($this->role_model->delete($id)) {
                    $message = ['type' => 'info', 'message' => 'Data Berhasil Dihapus','return' => '__reloadTable(false)'];
                    # LOG
                    $this->log_activity_model->save([
                                'module'   => $this->_module,
                                'sistem'   => TRUE,
                                'event'    => 'Delete',
                                'activity' => 'Delete Role'
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

    private function _parsing_authorities() {
        // Parsing roles
        $authorities = array();
        $data = array(
            'otoritas_menu_view' => $this->input->post('otoritas_menu_view'),
            'otoritas_menu_add' => $this->input->post('otoritas_menu_add'),
            'otoritas_menu_edit' => $this->input->post('otoritas_menu_edit'),
            'otoritas_menu_delete' => $this->input->post('otoritas_menu_delete'),
            'otoritas_menu_approve' => $this->input->post('otoritas_menu_approve'),
            'otoritas_menu_export' => $this->input->post('otoritas_menu_export'),
            'otoritas_menu_import' => $this->input->post('otoritas_menu_import'),
            'otoritas_menu_otordata' => $this->input->post('otoritas_menu_otordata')
        );

        if (isset($data['otoritas_menu_view']) && is_array($data['otoritas_menu_view'])) {
            foreach ($data['otoritas_menu_view'] as $value) {
                $authorities["{$value}"]['view_otoritas_modul'] = '1';
            }
        }

        if (isset($data['otoritas_menu_add']) && is_array($data['otoritas_menu_add'])) {
            foreach ($data['otoritas_menu_add'] as $value) {
                $authorities["{$value}"]['insert_otoritas_modul'] = '1';
            }
        }

        if (isset($data['otoritas_menu_edit']) && is_array($data['otoritas_menu_edit'])) {
            foreach ($data['otoritas_menu_edit'] as $value) {
                $authorities["{$value}"]['update_otoritas_modul'] = '1';
            }
        }

        if (isset($data['otoritas_menu_delete']) && is_array($data['otoritas_menu_delete'])) {
            foreach ($data['otoritas_menu_delete'] as $value) {
                $authorities["{$value}"]['delete_otoritas_modul'] = '1';
            }
        }


        if (isset($data['otoritas_menu_export']) && is_array($data['otoritas_menu_export'])) {
            foreach ($data['otoritas_menu_export'] as $value) {
                $authorities["{$value}"]['export_otoritas_modul'] = '1';
            }
        }

        if (isset($data['otoritas_menu_import']) && is_array($data['otoritas_menu_import'])) {
            foreach ($data['otoritas_menu_import'] as $value) {
                $authorities["{$value}"]['import_otoritas_modul'] = '1';
            }
        }

        if (isset($data['otoritas_menu_otordata']) && is_array($data['otoritas_menu_otordata'])) {
            foreach ($data['otoritas_menu_otordata'] as $key => $value) {
                $authorities["{$key}"]['data_otoritas_modul'] = $value;
            }
        }

        if (isset($data['otoritas_menu_approve']) && is_array($data['otoritas_menu_approve'])) {
            foreach ($data['otoritas_menu_approve'] as $value) {
                $authorities["{$value}"]['approve_otoritas_modul'] = '1';
            }
        }
        return $authorities;
    }

    private function _authorities($key = array()) {
        $data = $this->role_authorities_model->data($key)->get();
        foreach ($data->result() as $value) {
            if ($value->view_otoritas_modul == '1')
                $this->_authorities['view_otoritas_modul'][] = $value->id_menu;
            if ($value->insert_otoritas_modul == '1')
                $this->_authorities['insert_otoritas_modul'][] = $value->id_menu;
            if ($value->update_otoritas_modul == '1')
                $this->_authorities['update_otoritas_modul'][] = $value->id_menu;
            if ($value->delete_otoritas_modul == '1')
                $this->_authorities['delete_otoritas_modul'][] = $value->id_menu;
            if ($value->export_otoritas_modul == '1')
                $this->_authorities['export_otoritas_modul'][] = $value->id_menu;
            if ($value->import_otoritas_modul == '1')
                $this->_authorities['import_otoritas_modul'][] = $value->id_menu;
            if ($value->approve_otoritas_modul == '1')
                $this->_authorities['approve_otoritas_modul'][] = $value->id_menu;

            $this->_authorities['data_otoritas_modul'][(string)$value->id_menu] = $value->data_otoritas_modul;
        }

    }

    private function _list($key = array()) {
        $this->load->model('menu_model');
        $data = $this->menu_model->data($key, 'a.urut_menu')->get();

        $temp_menu = array();
        foreach ($data->result() as $value) {
            $parent_id = $value->m_m_id_menu;
            $parent = !empty($parent_id) ? $parent_id : 0;
            $url_menu = '#';

            if (!empty($value->url_menu)) {
                $url_menu = $value->url_menu;
            }

            $temp_menu[$parent][] = (object) array(
                        'id_menu' => $value->id_menu,
                        'nama_menu' => $value->nama_menu,
                        'icon_menu' => $value->icon_menu,
                        'url_menu' => $url_menu
            );
        }
        return $temp_menu;
    }

    private function _parsing($parent_id = 0, $submenu = true) {
        if (isset($this->_temp_menu[$parent_id])) {
            foreach ($this->_temp_menu[$parent_id] as $menu) {
                $id_menu = $menu->id_menu;
                $url = $menu->url_menu != '#' ? '#' . $menu->url_menu : $menu->url_menu;
                $icon_menu = $menu->icon_menu;

                $nama_menu = '<div class="dd-handle dd3-handle dd-nodrag">&nbsp;</div>';
                $nama_menu .= '<div class="dd3-content">';
                $nama_menu .= '     <i class="fa fa-lg fa-fw ' . $icon_menu . '"></i>  ' . $menu->nama_menu . ' <span class="text-info"> - ' . $url . '</span>';
                $nama_menu .= '     <div class="pull-right">';

                $nama_menu .= '         <div class="checkbox no-margin no-padding">';
                $nama_menu .= '         <label>' . form_checkbox("otoritas_menu_view[{$id_menu}]", $id_menu, in_array($id_menu, $this->_authorities['view_otoritas_modul']) ? TRUE : FALSE, 'class="checkbox style-0 cb_select cb_sb_view_otoritas_modul' . $parent_id . '" target-selected="cb_sb_view_otoritas_modul' . $id_menu . '" id="cb_view_otoritas_modul' . $id_menu . '" onchange="my_global.select_all(this.id)"') . '<span class="font-xs"><i class="fa fa-eye"></i></span></label>';
                $nama_menu .= '         <label>' . form_checkbox("otoritas_menu_add[{$id_menu}]", $id_menu, in_array($id_menu, $this->_authorities['insert_otoritas_modul']) ? TRUE : FALSE, 'class="checkbox style-0 cb_select cb_sb_view_otoritas_modul' . $id_menu . ' cb_sb_view_otoritas_modul' . $parent_id . ' cb_sb_insert_otoritas_modul' . $parent_id . '" target-selected="cb_sb_insert_otoritas_modul' . $id_menu . '" id="cb_insert_otoritas_modul' . $id_menu . '" onchange="my_global.select_all(this.id)"') . '<span class="font-xs"><i class="fa fa-plus"></i></span></label>';
                $nama_menu .= '         <label>' . form_checkbox("otoritas_menu_edit[{$id_menu}]", $id_menu, in_array($id_menu, $this->_authorities['update_otoritas_modul']) ? TRUE : FALSE, 'class="checkbox style-0 cb_select cb_sb_view_otoritas_modul' . $id_menu . ' cb_sb_view_otoritas_modul' . $parent_id . ' cb_sb_update_otoritas_modul' . $parent_id . '" target-selected="cb_sb_update_otoritas_modul' . $id_menu . '" id="cb_update_otoritas_modul' . $id_menu . '" onchange="my_global.select_all(this.id)"') . '<span class="font-xs"><i class="fa fa-edit"></i></span></label>';
                $nama_menu .= '         <label>' . form_checkbox("otoritas_menu_delete[{$id_menu}]", $id_menu, in_array($id_menu, $this->_authorities['delete_otoritas_modul']) ? TRUE : FALSE, 'class="checkbox style-0 cb_select cb_sb_view_otoritas_modul' . $id_menu . ' cb_sb_view_otoritas_modul' . $parent_id . ' cb_sb_delete_otoritas_modul' . $parent_id . '" target-selected="cb_sb_delete_otoritas_modul' . $id_menu . '" id="cb_delete_otoritas_modul' . $id_menu . '" onchange="my_global.select_all(this.id)"') . '<span class="font-xs"><i class="fa fa-trash-o"></i></span></label>';
                $nama_menu .= '         <label>' . form_checkbox("otoritas_menu_export[{$id_menu}]", $id_menu, in_array($id_menu, $this->_authorities['export_otoritas_modul']) ? TRUE : FALSE, 'class="checkbox style-0 cb_select cb_sb_view_otoritas_modul' . $id_menu . ' cb_sb_view_otoritas_modul' . $parent_id . ' cb_sb_export_otoritas_modul' . $parent_id . '" target-selected="cb_sb_export_otoritas_modul' . $id_menu . '" id="cb_export_otoritas_modul' . $id_menu . '" onchange="my_global.select_all(this.id)"') . '<span class="font-xs"><i class="fa fa-download"></i></span></label>';
                $nama_menu .= '         <label>' . form_checkbox("otoritas_menu_import[{$id_menu}]", $id_menu, in_array($id_menu, $this->_authorities['import_otoritas_modul']) ? TRUE : FALSE, 'class="checkbox style-0 cb_select cb_sb_view_otoritas_modul' . $id_menu . ' cb_sb_view_otoritas_modul' . $parent_id . ' cb_sb_import_otoritas_modul' . $parent_id . '" target-selected="cb_sb_import_otoritas_modul' . $id_menu . '" id="cb_import_otoritas_modul' . $id_menu . '" onchange="my_global.select_all(this.id)"') . '<span class="font-xs"><i class="fa fa-upload"></i></span></label>';
                $nama_menu .= '         <label>' . form_checkbox("otoritas_menu_approve[{$id_menu}]", $id_menu, in_array($id_menu, $this->_authorities['approve_otoritas_modul']) ? TRUE : FALSE, 'class="checkbox style-0 cb_select cb_sb_view_otoritas_modul' . $id_menu . ' cb_sb_view_otoritas_modul' . $parent_id . ' cb_sb_approve_otoritas_modul' . $parent_id . '" target-selected="cb_sb_approve_otoritas_modul' . $id_menu . '" id="cb_approve_otoritas_modul' . $id_menu . '" onchange="my_global.select_all(this.id)"') . '<span class="font-xs"><i class="fa fa-legal"></i></span></label>';

                $nama_menu .= '         <label class="no-padding">' . form_dropdown("otoritas_menu_otordata[{$id_menu}]", $this->_opt_otoritas_data, isset($this->_authorities['data_otoritas_modul'][$id_menu]) ? $this->_authorities['data_otoritas_modul'][$id_menu] : '', 'class="dd_roles dd_roles' . $parent_id . '" id="opt_otoritas_data' . $id_menu . '" target-selected="dd_roles' . $id_menu . '" onchange="my_global.set_value_selected(this.id)"') . '</label>';
                $nama_menu .= '         </div>';

                $nama_menu .= '     </div>';
                $nama_menu .= '</div>';

                if ($submenu) {
                    if (isset($this->_temp_menu[$id_menu])) {
                        $this->_html_menu .= '<li class="dd-item dd3-item" data-id="' . $id_menu . '">' . $nama_menu . '';
                        $this->_html_menu .= '  <ol class="dd-list">';
                        $this->_parsing($id_menu);
                        $this->_html_menu .= '  </ol>';
                        $this->_html_menu .= '</li>';
                    } else {
                        $this->_html_menu .= '<li class="dd-item dd3-item" data-id="' . $id_menu . '">' . $nama_menu . '</li>';
                    }
                } else {
                    $this->_html_menu .= '<li class="dd-item dd3-item" data-id="' . $id_menu . '">' . $nama_menu . '</li>';
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
