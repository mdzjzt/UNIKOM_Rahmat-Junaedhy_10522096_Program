<?php

/**
 * Description of dashboard
 *
 * @author Warman Suganda, Modif Deni R
 */
class menu extends MX_Controller {

    private $_title = 'Tabs';
    private $_module = 'home';

    public function __construct() {
        parent::__construct();

        # Protection
        hprotection::login();
		
        $this->_class_name = get_class($this);
        $this->_module .= '/' . $this->_class_name;
		
		$this->load->model('menu_model2_tabs');
    }
	
	public function htabs($id = NULL) {
	
		$app_menu_title = $this->menu_model2_tabs->data_title($id);
		foreach ($app_menu_title->get()->result() as $row1)
			{ 
			$nama_menu = $row1->nama_menu; 
			}
		$data['title_menu'] = $nama_menu;	
	
        $data['app_menu'] = $this->menu_model2_tabs->data(array('a.id_role' => $this->session->userdata('id_role'), 'a.view_otoritas_modul' => '1', 'b.m_m_id_menu' => $id));
		//print_debug($data['app_menu']->get()->result());

		$this->load->view('tabs_horizontal', $data);
    }	   
	public function htabsid($id = NULL) {
		$app_menu_title = $this->menu_model2_tabs->data_title($id);
		foreach ($app_menu_title->get()->result() as $row1)
			{ 
			$nama_menu = $row1->nama_menu; 
			}
		$data['title_menu'] = $nama_menu;	
	
        $data['app_menu'] = $this->menu_model2_tabs->data(array('a.id_role' => $this->session->userdata('id_role'), 'a.view_otoritas_modul' => '1', 'b.m_m_id_menu' => $id));
		//print_debug($data['app_menu']->get()->result());

		$this->load->view('tabs_horizontal_id', $data);
    }		
	public function vtabs($id = NULL) {
	
		$app_menu_title = $this->menu_model2_tabs->data_title($id);
		foreach ($app_menu_title->get()->result() as $row1)
			{ 
			$nama_menu = $row1->nama_menu; 
			}
		$data['title_menu'] = $nama_menu;	
	
        $data['app_menu'] = $this->menu_model2_tabs->data(array('a.id_role' => $this->session->userdata('id_role'), 'a.view_otoritas_modul' => '1', 'b.m_m_id_menu' => $id));
		//print_debug($data['app_menu']->get()->result());

		$this->load->view('tabs_vertical', $data);
    }	

}
