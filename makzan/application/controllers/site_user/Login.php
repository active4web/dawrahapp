<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Login extends CI_Controller {



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

	public function index(){
		$data['body_class'] = 'login page-template';
		$data['title'] = 'تسجيل الدخول';
		if ($this->session->has_userdata('user_data')) {
			redirect('home');
		}
		$this->form_validation->set_rules('phone','رقم الجوال','required');
		$this->form_validation->set_rules('password','كلمة المرور','required');
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			if ($this->form_validation->run()) {
				$where = [
							'phone'  => $this->input->post('phone'),
				            'password'  => md5(md5(md5(sha1($this->input->post('password')))))
						 ];
				$user = get_this('customers',$where);
				if($user)
                {
                	if ($user['status'] == 0) {
                		redirect('site_user/verify_register/index/'.$user['id']);	
                	}else{
                		if ($user['confirmed'] == 0) {
                			$this->session->set_flashdata('message',notify('حساب غير موافق عليه من الأدارة','danger'));	
                		}else{
		                	unset($user->password);
							$this->session->set_userdata('user_data',$user);
							redirect('home');
					    }
                	}
				}else{
					$this->session->set_flashdata('message',notify('يرجى التأكد من بيانات الدخول واعادة المحاولة','danger'));
					redirect('site_user/login');
				}
			}
		}
		$data['main_content'] = 'site_user/login';
		$this->load->view('site_user/blank',$data);
	}
	public function logout(){

		$this->session->sess_destroy();

		redirect('site_user/login');

	}
}

