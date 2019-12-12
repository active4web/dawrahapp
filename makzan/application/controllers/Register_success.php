<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register_success extends CI_Controller {

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
		$data['body_class'] = 'register-confirm page-template';
		$data['user_data'] = $this->session->userdata('user_data');
		$data['title'] = 'تأكيد التسجيل';
		$data['main_content'] = 'site_user/register_success';
		$this->load->view('site_user/blank',$data);
	}
}
