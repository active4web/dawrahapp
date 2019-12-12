<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Verify_register extends CI_Controller {

	public function index($id){
		$data['body_class'] = 'register-confirm page-template';
		$data['title'] = 'تأكيد تسجيل الحساب';
        $this->form_validation->set_rules('code', 'كود التفعيل', 'trim|required|min_length[6]');
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			if ($this->form_validation->run()) {
				$customer_info = get_this('customers',['id'=>$id,'status'=>0]);
				if ($customer_info) {
					$verification_info = get_this('mobile_numbers',['mobile_number'=>$customer_info['phone'],'verification_code'=>$this->input->post('code'),'verified'=>0]);
					if ($verification_info) {
						// $store = ['verified' => 1];
	        			$update = ['status' => 1];
	        			// $this->Main_model->update('mobile_numbers',['id'=>$verification_info['id']],$store);
	        			$this->Main_model->update('customers',['phone'=>$customer_info['phone']],$update);
	        			$this->db->where('mobile_number',$customer_info['phone'])->delete('mobile_numbers');
	        			// $this->session->set_flashdata('message',notify('تم تفعيل الحساب بنجاح','success'));
	        			redirect('register_success');
					}else{
						$this->session->set_flashdata('message',notify('برجى التأكد من كود التفعيل الخاص بك','danger'));
					}
				}else{
					$this->session->set_flashdata('message',notify('عفوا فلا توجد اي بيانات تخص هذا الحساب','danger'));
				}
			}
		}
		$data['main_content'] = 'site_user/user/verify_register';
		$this->load->view('site_user/blank',$data);
	}
}

