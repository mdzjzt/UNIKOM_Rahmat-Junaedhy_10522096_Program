<?php

/**
 * Description of activity_log
 *
 * @author Warman Suganda
 */
class activity_log extends MX_Controller {

    private $_class_name = '';
    private $_module = 'backend';

    public function __construct() {
        parent::__construct();

        # Protection
        hprotection::login();

        $this->_class_name = get_class($this);
        $this->_module .= '/' . $this->_class_name;

        $this->load->model('activity_log_model');
    }

    public function add($activity = '') {
        $data = array();
        $data['activity'] = $activity;
        $data['status'] = 't';
        $data['waktu'] = date('Y-m-d H:i:s');
        $data['id_pegawai'] = $this->session->userdata('id_pegawai');
        $data['id_user'] = $this->session->userdata('id_user');
        return $this->activity_log_model->create($data);
    }

    public function last() {
        $data = array();
        $log = $this->activity_log_model->data(array('a.status' => 't'), 'waktu', 'desc', 10)->get();
        foreach ($log->result() as $value) {
            $data[] = array(
                'time' => $value->waktu,
                'activity' => $value->activity
            );
        }
        echo json_encode($data);
    }

}
