<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Merchant extends CI_Controller {

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
	public function index($id){
		if (!$id) {
			show_404();
		}else{
			$data['body_class'] = 'vendor-template vendor-store page-template';
			$data['title'] = 'التاجر';
			$data['user_data'] = $this->session->userdata('user_data');
			$data['merchant'] = get_this('merchants',['id'=>$id]);
			$data['products'] = get_table('products',['created_by'=>$id]);
			$data['main_content'] = 'site_user/merchant/store';
		    $this->load->view('site_user/blank',$data);
		}
}

	
}
