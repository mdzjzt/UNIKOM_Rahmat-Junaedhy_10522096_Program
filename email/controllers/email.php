<?php

class email extends MX_Controller {

    private $_class_name = NULL;
    private $_title = 'SETTINGS EMAIL ';
    private $_module = 'email';

    function __construct() {
        parent::__construct();

        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', TRUE);

        $this->_class_name = get_class($this);
        $this->_module .= '/' . $this->_class_name;


        $this->load->model('email_model');
        $this->load->model('email_config_model');
        $this->load->model('email_list_model');
       
       
    }

    public function index() {
        if (hprotection::must_ajax($this->_module)) {

            $query = $this->email_model->table(1)->get()->row();
            $data = [
                'pageTitle'  => $this->_title,
                '_modul'     => $this->_module,
                '_title'     => $this->_title,
                'form_action' =>  $this->_module .'/save/1',
                'data' => $query,
                
            ];
          
            # LOG
            $this->log_activity_model->save([
                        'module'   => $this->_module,
                        'event'    => 'View',
                        'activity' => 'View List Account Code'
            ]);

            $this->load->view($this->_module . '/index', $data);
        }
    }

   


    public function form($id = NULL){
         if ($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {

            $data['_modul']      = $this->_module;
            $data['form_action'] = $this->_module .'/save/'. $id;

            if ($id) {
                $query = $this->accountcode_model->table($id)->get()->row();
                $data['page_title'] = 'UBAH ' . $this->_title;
                $data['data']       = $query;


            }else{
                $data['page_title']  = 'Tambah' . $this->_title;
                
            }

            $this->load->view($this->_module . '/form', $data);

         }else{
             echo Modules::run('template/error_message/error_forbidden');
         }
    }

    public function save($id = NULL) {
        if ($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {
            if (hprotection::must_ajax($this->_module . '/404')) {

                    $data = [
                        'email'    => $this->input->post('email'),
                        'mailtype'     => $this->input->post('mailtype'),
                        'protocol'     => $this->input->post('protocol'),
                        'system_path'     => $this->input->post('sendmail_path'),
                        'smtp_user'     => $this->input->post('smtp_user'),
                        'smtp_password' => $this->input->post('smtp_password'),
                        'smtp_host'     => $this->input->post('smtp_host'),
                        'smtp_port'     => $this->input->post('smtp_port'),
                        'charset'     => $this->input->post('charset'),
                      
                         ];

                    if ($id) {

                        if ($id = $this->email_model->update($id, $data)) {
                            $message = ['message' => 'Data Berhasil Disimpan', 'return' => '__afterSubmit()'];
                        }

                          # LOG
                        $this->log_activity_model->save([
                                    'module'   => $this->_module,
                                    'sistem'   => TRUE,
                                    'event'    => 'Insert',
                                    'activity' => 'Update Master Account Code'
                        ]);

                    }
               
                echo json_encode($message);

            }
        }else {
            echo Modules::run('template/error_message/error_forbidden');
        }
    }

      public function delete($id) 
    {
        $this->accountcode_model->delete($id);

        # LOG
        $this->log_activity_model->save([
                    'module'   => $this->_module,
                    'sistem'   => TRUE,
                    'event'    => 'Delete',
                    'activity' => 'Hapus Inventaris'
        ]);

        $message = ['type' => 'info', 'message' => 'Data Berhasil Dihapus','return' => '__reloadTable(false)'];
        echo json_encode($message);
    }

     public function send_email(){

        $email_test = $this->input->post('email_test');

        $data = $this->email_model->table(1)->get()->row();
        $config = Array(
                        'protocol' => $data->protocol,
                        'smtp_host' =>  $data->smtp_host,
                        'smtp_port' =>  $data->smtp_port,
                        'smtp_user' => $data->smtp_user,
                        'smtp_pass' => $data->smtp_password,
                        'mailtype'  => $data->mailtype,
                        'charset'   => $data->charset,
                        );

        
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");


        $this->email->from($data->email);
        $this->email->to($email_test );
        $this->email->subject("TEST CONFIGURASI EMAIL");
        $this->email->message('OK configurasi berhasil ');
       
        if($this->email->send()) {

            $message = array('ok'=> 1);
        } else {
            $message = array('ok'=> 2);
              
        }

        echo json_encode($message);

    }

    public function send_email_mr(){
       
          $data_config = $this->email_config_model->table(1)->get()->row();
          $cond['status_terkirim'] = 0;
          $data = $this->email_list_model->data($cond,'id')->get();
          $config = Array(
                                'protocol'  => $data_config->protocol,
                                'smtp_host' => $data_config->smtp_host,
                                'smtp_port' => $data_config->smtp_port,
                                'smtp_user' => $data_config->smtp_user,
                                'smtp_pass' => $data_config->smtp_password,
                                'mailtype'  => $data_config->mailtype,
                                'charset'   => $data_config->charset,
                                );

                        $this->load->library('email', $config);
                        $this->email->set_newline("\r\n");

                    if (!empty($data->result())) {
                       
                        foreach ($data->result() as $value) {
                            // var_dump($value->message);
                            // exit();
                        
                            $this->email->from($value->email_from);
                            $this->email->to($value->email_to);
                            $this->email->subject($value->subject);
                            $this->email->message(''.$value->message.'');
                            // $this->email->cc($value->cc);
                            // $this->email->attach($value->attachment);

                           if($this->email->send()) {
                                $data_update['status_terkirim'] = 1 ;
                                $this->db->where('id', $value->id);
                                $this->db->update('tbl_list_email_mr',$data_update);
                            } else {
                                $data_update['status_terkirim'] = 0 ;
                                $this->db->where('id', $value->id);
                                $this->db->update('tbl_list_email_mr',$data_update);
                            }

                        }

                    }


    }



}
