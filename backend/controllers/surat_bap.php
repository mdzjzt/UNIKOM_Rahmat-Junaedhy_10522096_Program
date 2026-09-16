<?php

class surat_bap extends MX_Controller
{
    private $_class_name = NULL;
    private $_title      = 'Setting Surat';
    private $_module     = 'backend';

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
        $this->load->model('syssetings_model'); 
    }

    public function index()
    {   
        if(hprotection::must_ajax($this->_module)):
            $data = $this->syssetings_model->data(['key_setting' => 'APP_CONFIG', 'name_setting' => 'default_bap'])->get()->row();

            $data = array(
                            'pageTitle'  => 'Surat BAP',
                            '_modul'     => $this->_module,
                            '_title'     => $this->_title, 
                            'formAction' => $this->_module .'/save/',
                            'data'       => $data,
                        );

            $this->load->view($this->_module.'/index',$data);
        endif;
    }


    public function save()
    {
        $this->syssetings_model
        ->update(['key_setting' => 'APP_CONFIG', 'name_setting' => 'default_bap'],['value_setting' => $this->input->post('value_setting')]);

        $message = ['message' => 'Data Berhasil Disimpan'];

        echo json_encode($message);
    }

}