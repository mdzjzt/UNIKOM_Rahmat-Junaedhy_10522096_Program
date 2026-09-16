<?php

class display extends MX_Controller {

    private $_title  = 'SIMBADA - MONITORING';
    private $_module;
    private $_class_name;
    private $_workflow_persetujuan = 'PERM-01';
    private $_workflow_pemeriksaan = 'PERM-02';
    private $_workflow_penugasan   = 'PERM-03';

    public function __construct()
    {
        parent::__construct();      

        $this->_class_name  = get_class($this);
        $this->_module     .= '/' . $this->_class_name;

        $this->load->helper('currency_format');
        $this->load->model('cabang_model');
        $this->load->model('log_user_model');
        $this->load->model('inventaris_model');
        $this->load->model('permintaan_model');
        $this->load->model('pegawai_model');
        $this->load->model('sp_permintaan_barang_model');
        $this->load->model('permintaan_sp_model');
        $this->load->model('permintaan_barang_model');
        $this->load->model('sp_permintaan_barang_model');  
        $this->load->model('cabang_model');    
        $this->load->model('permintaan_persetujuan_model');
    }


    #   -----------
    #   DISPLAY SLA
    #   -----------
    
    public function display_sla()
    {
        $data['title'] = $this->_title;

        $this->load->view($this->_module . '/index.php', $data);       
    }

    public function data_sla($limit = 100, $offset = 0)
    {
        # Ordering
        $orderBy          = 'a.waktu_penugasan';
        $direction        = 'desc';
        $cond             = [];

        # Set otoritas data
        $temp = [];
        $cond = $temp;       

        $cond['a.post_status']                          = 'publish';      
        $cond['d.cabang_parent']                        = '000';    # kantor pusat
        // $cond['a.permintaan_tugas']                     = NULL;     # belum ditugaskan       

        $cabangId = '000';

        $filterId = [
                'a.cabang_id' => $cabangId, 
                'workflow_id' => $this->_workflow_pemeriksaan,
        ];

        $filterId['status_flow'] = TRUE;

        //FILTER FLOW
        $qFlow = $this->permintaan_persetujuan_model->data($filterId)->get();
        $flow  = "0";
        
        if($qFlow->num_rows() > 0) {
            foreach ($qFlow->result() as $value) {
                $flow .= ",'{$value->permintaan_id}'";
            }
        }

        $cond["(a.permintaan_id IN ({$flow}) )"] = NULL;
        
        $dataCountFiltered = $this->permintaan_model->data($cond)->count_all_results();
        $dataResult        = $this->permintaan_model->data($cond, $orderBy, $direction, $limit, $offset)->get();
        
        $row_data          = '';
        $page              = '';
        $no                = 0;

        $row_data .= '<table class="table_data marquee" cellspacing="0" cellpadding="3px" border="0">';

        if (COUNT($dataResult->result()) > 0) {
            foreach ($dataResult->result() as $dt) {            

                $petugas = $this->pegawai_model->data($dt->permintaan_tugas)->get()->row();

                if ($no == 0) {
                    $no++;
                    $row_data .= '<tr class="tr_color">';
                } else {
                    $no--;
                }
                
                $row_data .= '<td class="td_center" width="300px">' . $dt->permintaan_nota . '</td>';
                $row_data .= '<td width="700px">' . $dt->permintaan_nama . '</td>'; 
                $row_data .= '<td class="td_center" width="250px">' . date_format(date_create($dt->waktu_permintaan), 'd/m/Y, H:i') . '</td>';

                if ($dt->waktu_pemeriksaan == NULL) {
                    $row_data .= '<td bgcolor="red"></td>';
                } else {
                    $row_data .= '<td class="td_center" width="250px">' . ($dt->waktu_pemeriksaan != NULL ? (date_format(date_create($dt->waktu_pemeriksaan), 'd/m/Y, H:i')) : '-') . '</td>';
                }

                if ($dt->permintaan_tugas == NULL) {
                    $row_data .= '<td class="td_center">-</td>';
                } else {
                    $row_data .= '<td class="td_center"> ' . strtoupper($petugas->pegawai_nik) . '<br />' . strtoupper($petugas->pegawai_nama) . ' </td>';
                }

                $row_data .= '</tr>';                
            }
        } else {
            $row_data .= '<tr class="tr_color">';
            $row_data .= '<td class="td_center" colspan="5">Tidak ada data yang ditampilkan';
            $row_data .= '</td>';
            $row_data .= '</tr>';
        }       

        $row_data .= '</table>';  
        
        echo $row_data;
    }


    #   ------------------
    #   DISPLAY PERMINTAAN
    #   ------------------

    public function display_permintaan()
    {
        $data['title'] = '';

        $this->load->view($this->_module . '/index_permintaan.php', $data);   
    }

    public function data_permintaan($limit= 30, $offset = 0)
    {
        # Ordering
        $orderBy          = 'a.waktu_permintaan';
        $direction        = 'desc';
        $cond             = []; 

        # Set otoritas data
        $temp = [];        

        $cond = $temp;
        $cond['a.post_status']                          = 'publish';
        // $cond['a.status_pemeriksaan_approve']        = TRUE;
        // $cond['a.waktu_pemeriksaan IS NULL']         = NULL;
        $cond['d.cabang_parent']                        = '000';    # kantor pusat
        $cond['a.permintaan_tugas']                     = NULL;     # belum ditugaskan
        // $cond['a.waktu_permintaan_approve IS NOT NULL'] = NULL;     # approval adhi
        // $cond['a.waktu_pemeriksaan IS NULL']            = NULL;     # pemeriksaaan dhani

        // $qCabang  = $this->cabang_model->data($this->session->userdata('cabang_id'))->get()->row();
        $cabangId = '000';

        $filterId = [
                'a.cabang_id' => $cabangId, 
                'workflow_id' => $this->_workflow_pemeriksaan,
        ];

        // if ($this->input->post('status') != 0) {
        //     $filterId['status_flow'] = FALSE;
        // } else {
            $filterId['status_flow'] = TRUE; // Sudah diperiksa
        //}

        //FILTER FLOW
        $qFlow = $this->permintaan_persetujuan_model->data($filterId)->get();
        $flow  = "0";
        
        if($qFlow->num_rows() > 0) {
            foreach ($qFlow->result() as $value) {
                $flow .= ",'{$value->permintaan_id}'";
            }
        }

        $cond["(a.permintaan_id IN ({$flow}) )"] = NULL;
        
        $dataCountFiltered = $this->permintaan_model->data($cond)->count_all_results();
        $dataResult        = $this->permintaan_model->data($cond, $orderBy, $direction, $limit, $offset)->get();
        
        $row_data          = '';
        $page              = '';
        $no                = 0;

        $row_data .= '<table class="table_data marquee" cellspacing="0" cellpadding="3px" border="0">';

        if (COUNT($dataResult->result()) > 0) {   
            foreach ($dataResult->result() as $dt) {

                $filterExt = [
                    'a.permintaan_id' => $dt->permintaan_id, 
                    'workflow_id'     => $this->_workflow_persetujuan,
                ];

                $ExtFlow = $this->permintaan_persetujuan_model->data($filterExt)->get()->row();
                // print_debug($ExtFlow);
                if ($no == 0) {
                    $no++;
                    $row_data .= '<tr class="tr_color">';
                } else {
                    $row_data .= '<tr>';
                    $no--;
                }
                
                $row_data .= '<td class="td_center" width="300px">' . $dt->permintaan_nota . '</td>';
                $row_data .= '<td width="500px">' . $dt->permintaan_nama . '</td>'; 
                $row_data .= '<td class="td_center" width="300px">' . date_format(date_create($dt->waktu_permintaan), 'd/m/Y, H:i') . '</td>';
                $row_data .= '<td class="td_center" width="300px">' . date_format(date_create($ExtFlow->tanggal), 'd/m/Y, H:i') . '</td>';
                $row_data .= '<td class="td_center" width="300px">' . ($dt->waktu_pemeriksaan != NULL ? (date_format(date_create($dt->waktu_pemeriksaan), 'd/m/Y, H:i')) : '-') . '</td>';
                $row_data .= '</tr>';                
            }
        } else {
            $row_data .= '<tr class="tr_color">';
            $row_data .= '<td class="td_center" colspan="4">Tidak ada data yang ditampilkan';
            $row_data .= '</td>';
            $row_data .= '</tr>';
        } 

        $row_data .= '</table>';      
        
        echo $row_data;
    }


    #   ---------------
    #   DISPLAY BY NAME
    #   ---------------

    public function display_by_name()
    {
        $data['title'] = $this->_title;

        $this->load->view($this->_module . '/index_by_name', $data);       
    }

    public function data_by_name($limit = 100, $offset = 0)
    {
        # Ordering
        $orderBy          = 'a.permintaan_tugas';
        $direction        = 'asc';
        $cond             = [];

        # Set otoritas data
        $temp = [];
        $cond = $temp;

        $cond['a.post_status']                  = 'publish';
        $cond['d.cabang_parent']                = '000';    # kantor pusat
        $cond['a.permintaan_tugas IS NOT NULL'] = NULL;     # belum ditugaskan   
        $cond['f.sp_nota IS NULL']              = NULL;    

        $cabangId = '000';

        $filterId = [
                'a.cabang_id' => $cabangId, 
                'workflow_id' => $this->_workflow_pemeriksaan,
        ];
      
        $filterId['status_flow'] = TRUE;

        //FILTER FLOW
        $qFlow = $this->permintaan_persetujuan_model->data($filterId)->get();
        $flow  = "0";
        
        if($qFlow->num_rows() > 0) {
            foreach ($qFlow->result() as $value) {
                $flow .= ",'{$value->permintaan_id}'";
            }
        }

        $cond["(a.permintaan_id IN ({$flow}) )"] = NULL;
        
        $dataCountFiltered = $this->permintaan_model->data_permintaan_by_name($cond)->count_all_results();
        $dataResult        = $this->permintaan_model->data_permintaan_by_name($cond, $orderBy, $direction, $limit, $offset)->get();
        // print_debug($this->db->last_query());
        $row_data          = '';
        $page              = '';
        $no                = 0;

        $row_data .= '<table class="table_data marquee" cellspacing="0" cellpadding="3px" border="0">';

        if (COUNT($dataResult->result()) > 0) {
            foreach ($dataResult->result() as $dt) {   
                if ($dt->permintaan_jenis == 'barang') {
                    $queryBarangSP = $this->sp_permintaan_barang_model->data(['b.permintaan_id' => $dt->permintaan_id])->count_all_results(); 
                    if ($queryBarangSP == 0) {
                        $ahay = 0;//'-BELUM-'.$dt->permintaan_id;
                    }else{
                        $ahay = 1;//'-SUDAH-'.$dt->permintaan_id;
                    }
                }else{
                    $spk = $this->permintaan_sp_model->data(['a.permintaan_id' => $dt->permintaan_id])->count_all_results();

                    if ($spk == 0) {
                        $ahay = 0;//'-BELUM-'.$dt->permintaan_id;
                    }else{
                        $ahay = 1;//'-SUDAH-'.$dt->permintaan_id;
                    }
                }
                    if($ahay==0){ 
                        #   Data petugas yang di tugaskan
                        $petugas = $this->pegawai_model->data($dt->permintaan_tugas)->get()->row();

                        #   Data batas waktu standar pekerjaan 10 hari dihitung dari waktu penugasan
                        $lama_batas_pekerjaan = floor((strtotime(date('Y-m-d H:i:s')) - strtotime($dt->waktu_penugasan)) / (60 * 60 * 24));

                        $alert = "";                

                        if ($no == 0) {
                            $no++;

                            if ($lama_batas_pekerjaan > 10)
                                $row_data .= '<tr class="tr_color tr_alert">';
                            else
                                $row_data .= '<tr class="tr_color">';
                        } else {
                            if ($lama_batas_pekerjaan > 10)
                                $row_data .= '<tr class="tr_alert">';
                            else
                                $row_data .= '<tr>';

                            $no--;
                        }
                        
                        $row_data .= '<td width="700px">' . $dt->unit_kerja_nama . '</td>';
                        $row_data .= '<td width="1020px">' . $dt->permintaan_nama . '</td>'; 
                        // $row_data .= '<td width="1020px">' . date('Y-m-d H:i:s') . ' - ' . $dt->waktu_penugasan . ' - ' . $lama_batas_pekerjaan . '</td>'; 
                        $row_data .= '<td class="td_center" width="250px">' . date_format(date_create($dt->waktu_permintaan), 'd/m/Y, H:i') . '</td>';
                       
                        if ($dt->permintaan_tugas == NULL) {
                            $row_data .= '<td class="td_center">-</td>';
                        } else {
                            $row_data .= '<td class="td_center"> ' . strtoupper($petugas->pegawai_nama) . ' </td>';
                        }

                        $row_data .= '</tr>';
                    }                
            }
        } else {
            $row_data .= '<tr class="tr_color">';
            $row_data .= '<td class="td_center" colspan="5">Tidak ada data yang ditampilkan';
            $row_data .= '</td>';
            $row_data .= '</tr>';
        }       

        $row_data .= '</table>';  
        
        echo $row_data;
    }
}