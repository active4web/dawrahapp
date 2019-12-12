<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {


	public function index(){
		$data['body_class'] = 'login page-template';
		$data['title'] = 'تسجيل الدخول';
		if ($this->session->has_userdata('merchant_data')) {
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
				$merchant = get_this('merchants',$where);
				if($merchant)
                {
                   if ($merchant['status'] == 0) {
                   	   $this->session->set_flashdata('message',notify('حساب غير مفعل','danger'));
				       // redirect('site_user/login');
                   }else{
                   	   if ($merchant['confirmed'] == 0) {
                   	   	   $this->session->set_flashdata('message',notify('حساب غير موافق عليه من الادارة','danger'));
				           // redirect('site_user/login');
                   	   }else{
                   	   	   $this->session->set_userdata('merchant_data',$merchant);
                   	   	   redirect('site_merchant/orders');
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

