<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if (!$this->session->has_userdata('login_data'))
            redirect('admin_panel/login'); 
	}
	public function index()
	{
		$data['title'] = 'الاحصائيات';
		$data['customers'] = get_table('customers',[],'count');
		$data['stores'] = get_table('merchants',[],'count');
		$data['products'] = get_table('products',[],'count');
		$data['main_orders'] = get_table('main_orders',[],'count');
		$data['main_content'] = 'admin_panel/dashboard';
		$this->load->view('admin_panel/blank',$data);
	}
}
