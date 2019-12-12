<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class orders extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$data['user_data'] = $this->session->userdata('user_data');
		$data['body_class'] = 'orders cart-template page-template';
		$data['title'] = 'طلباتي';
		if (empty($data['user_data'])) {
			redirect('site_user/login');
		}else{
			$data['my_main_orders'] = get_table('main_orders',['customer_id'=>$data['user_data']['id']]);
			$data['main_content'] = 'site_user/orders/list';
			$this->load->view('site_user/blank',$data);
		}
	}
	public function order($id){
		$data['user_data'] = $this->session->userdata('user_data');
		$data['body_class'] = 'order-page page-template';
		$data['title'] = 'طلباتي';
		if (empty($data['user_data'])) {
			redirect('site_user/login');
		}else{
			$data['main_order'] = get_this('main_orders',['customer_id'=>$data['user_data']['id'],'id'=>$id]);
			$data['sub_orders'] = get_table('sub_orders',['customer_id'=>$data['user_data']['id'],'main_order_id'=>$id]);
			$data['main_content'] = 'site_user/orders/order';
			$this->load->view('site_user/blank',$data);
		}
	}
	
}
