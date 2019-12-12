<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if (!$this->session->has_userdata('login_data'))
            redirect('admin_panel/login'); 
	}
	public function index(){
		$data['settings'] = get_this('settings',['id'=>1]);
		$data['title'] = 'الاعدادات';
		$this->form_validation->set_rules('app_name','اسم التطبيق','trim|required');
		$this->form_validation->set_rules('email','البريد الالكتروني','trim|required|valid_email');
	    $this->form_validation->set_rules('phone','رقم الجوال','trim|required');
	    $this->form_validation->set_rules('address','العنوان','trim|required');
	    $this->form_validation->set_rules('tax','الضريبه ','trim|required|numeric');
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			if ($this->form_validation->run()) {
				$store = $this->input->post();
				$this->Main_model->update('settings',['id'=>1],$store);
				redirect('admin_panel/settings');
			}
		}
		$data['main_content'] = 'admin_panel/settings';
		$this->load->view('admin_panel/blank',$data);
	}
}
