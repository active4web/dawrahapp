<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/MobilySms.php';
class Forget_password extends CI_Controller {

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
		$data['body_class'] = 'password-template page-template';
		$data['title'] = 'نسيت كلمة المرور';
		$this->form_validation->set_rules('phone', 'رقم الجوال', 'trim|required');
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			if ($this->form_validation->run()) {
				$customer_info = get_this('customers',['phone'=>$this->input->post('phone')]);
				if ($customer_info) {
					if ($customer_info['status'] == 0) {
						$this->session->set_flashdata('message',notify('عفوا هذا الحساب غير مفعل حتى الان','danger'));
						redirect($_SERVER['HTTP_REFERER']);
					}
					$code = generate_verification_code();
		            $phone = $this->input->post('phone');
		            $phone1 = ltrim($phone, '0');
		            $country_id = get_this('customers',['phone' => $phone],'country_id');
		            $international_key = get_this('countries',['id'=>$country_id],'international_key');
		            $reciever = $international_key.$phone1;
		            $store = [
		        				'mobile_number'     => $phone,
		        				'verification_code' => $code,
		        				'verified '         => 0
		        			 ];
		            $sms = new MobilySms('966507717440','159789','88f55e6be5eed49301496725879b72ac');
	    			$msg = "عزيزي (1)، كود التفعيل الخاص بك هو (2)";
	    			$msgKey = "(1),*,$reciever,@,(2),*,$code";
	    			$numbers = $reciever;
	    			$result = $sms->sendMsgWK($msg,$numbers,'0507717440',$msgKey,'12:00:00',now(),0,'deleteKey','curl');
	            	$message_info = json_decode($result);
	            	if($message_info->ResponseStatus == 'success'){
	    			   $id = $this->Main_model->insert('mobile_numbers',$store);
					   redirect('site_user/forget_password/verify/'.$customer_info['id']);
	    			}else{
	    			   $this->session->set_flashdata('message',notify('يرجى التأكد من رقم الجوال واعادة المحاولة','danger'));
	    			}

				}else{
					$this->session->set_flashdata('message',notify('عفوا لا توجد اي بيانات لهذا الرقم الخاص بك','danger'));
					redirect($_SERVER['HTTP_REFERER']);
				}
			}else{
	            	$this->session->set_flashdata('message',notify(validation_errors(),'danger'));	
					redirect($_SERVER['HTTP_REFERER']);
            }
		}
		$data['main_content'] = 'site_user/user/forget_password';
	    $this->load->view('site_user/blank',$data);
	}
	public function verify($id){
		$data['body_class'] = 'password-template page-template';
		$data['title'] = 'نسيت كلمة المرور';
        $this->form_validation->set_rules('code', 'كود التفعيل', 'trim|required|min_length[6]');
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			if ($this->form_validation->run()) {
				$customer_info = get_this('customers',['id'=>$id,'status'=>1]);
				if ($customer_info) {
					$verification_info = get_this('mobile_numbers',['mobile_number'=>$customer_info['phone'],'verification_code'=>$this->input->post('code'),'verified'=>0]);
					if ($verification_info) {
						$store = ['verified' => 1];
	        			$this->Main_model->update('mobile_numbers',['id'=>$verification_info['id']],$store);
	        			redirect('site_user/forget_password/new_password/'.$customer_info['id']);
					}else{
						$this->session->set_flashdata('message',notify('برجى التأكد من كود التفعيل الخاص بك','danger'));
					}
				}else{
					$this->session->set_flashdata('message',notify('عفوا فلا توجد اي بيانات تخص هذا الحساب','danger'));
				}

			}else{
	            	$this->session->set_flashdata('message',notify(validation_errors(),'danger'));	
					redirect($_SERVER['HTTP_REFERER']);
            }
		}
		$data['main_content'] = 'site_user/user/forget_password_verify_code';
		$this->load->view('site_user/blank',$data);
	}
	public function new_password($id){
		$data['body_class'] = 'password-template page-template';
		$data['title'] = 'نسيت كلمة المرور';
		$this->form_validation->set_rules('password', 'كلمة المرور', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('c_password', 'تأكيد كلمة المرور', 'trim|required|min_length[6]|matches[password]');
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
			if ($this->form_validation->run()) {
				$store['password'] = md5(md5(md5(sha1($this->input->post('password')))));
				$this->Main_model->update('customers',['id'=>$id],$store);
				$this->session->set_flashdata('message',notify('تم تغيير كلمة المرور بنجاح','success'));
				redirect('site_user/login');		 
			}else{
	            	$this->session->set_flashdata('message',notify(validation_errors(),'danger'));	
					redirect($_SERVER['HTTP_REFERER']);
            }
		}
		$data['main_content'] = 'site_user/user/new_password';
		$this->load->view('site_user/blank',$data);
	}
	
}
