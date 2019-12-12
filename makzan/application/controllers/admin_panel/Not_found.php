<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Not_found extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if (!$this->session->has_userdata('login_data'))
            redirect('admin_panel/login'); 
	}
	public function index(){
        $data['title'] = 'الاعلانات';
		$this->load->view('admin_panel/not_found',$data);
    }
}
