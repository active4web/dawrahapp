<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/MobilySms.php';
class Forget_password extends CI_Controller {

	public function index(){
		if ($this->session->userdata('merchant_data')) {
			redirect('site_user/login/logout');
		}
		$data['body_class'] = 'password-template page-template';
		$data['title'] = 'نسيت كلمة المرور';
		$this->form_validation->set_rules('phone', 'رقم الجوال', 'trim|required');
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			if ($this->form_validation->run()) {
				$merchant_info = get_this('merchants',['phone'=>$this->input->post('phone')]);
				if ($merchant_info) {
					if ($merchant_info['status'] == 0) {
						$this->session->set_flashdata('message',notify('عفوا هذا الحساب غير مفعل حتى الان','danger'));
						redirect($_SERVER['HTTP_REFERER']);
					}else{
						if ($merchant_info['confirmed'] == 0) {
							$this->session->set_flashdata('message',notify('عفوا هذا الحساب غير موافق عليه من قبل الادارة'));
						}else{
							$verification_info = get_this('mobile_numbers',['mobile_number'=>$merchant_info['phone']]);
							if ($verification_info) {
								$code = $verification_info['verification_code'];
								$phone = $merchant_info['phone'];
					            $phone1 = ltrim($phone, '0');
					            $country_id = $merchant_info['country_id'];
					            $international_key = get_this('countries',['id'=>$country_id],'international_key');
					            $reciever = $international_key.$phone1;
					            /*$store = [
					        				'mobile_number'     => $phone,
					        				'verification_code' => $code,
					        				'verified '         => 0
					        			 ];*/
					            $sms = new MobilySms('966507717440','159789','88f55e6be5eed49301496725879b72ac');
				    			$msg = "عزيزي (1)، كود التفعيل الخاص بك هو (2)";
				    			$msgKey = "(1),*,$reciever,@,(2),*,$code";
				    			$numbers = $reciever;
				    			$result = $sms->sendMsgWK($msg,$numbers,'0507717440',$msgKey,'12:00:00',now(),0,'deleteKey','curl');
				            	$message_info = json_decode($result);
				            	if($message_info->ResponseStatus == 'success'){
				    			   // $id = $this->Main_model->insert('mobile_numbers',$store);
								   redirect('site_merchant/forget_password/verify/'.$merchant_info['id']);
				    			}else{
				    			   $this->session->set_flashdata('message',notify('يرجى التأكد من رقم الجوال واعادة المحاولة','danger'));
				    			}
							}else{
								$code = generate_verification_code();
					            $phone = $merchant_info['phone'];
					            $phone1 = ltrim($phone, '0');
					            $country_id = $merchant_info['country_id'];
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
								   redirect('site_merchant/forget_password/verify/'.$merchant_info['id']);
				    			}else{
				    			   $this->session->set_flashdata('message',notify('يرجى التأكد من رقم الجوال واعادة المحاولة','danger'));
				    			}
							}
						}
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
		$data['main_content'] = 'site_merchant/merchant/forget_password';
	    $this->load->view('site_user/blank',$data);
	}

	public function verify($id){
		$data['body_class'] = 'password-template page-template';
		$data['title'] = 'نسيت كلمة المرور';
        $this->form_validation->set_rules('code', 'كود التفعيل', 'trim|required|min_length[6]');
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			if ($this->form_validation->run()) {
				$merchant_info = get_this('merchants',['id'=>$id,'status'=>1]);
				if ($merchant_info) {
					$verification_info = get_this('mobile_numbers',['mobile_number'=>$merchant_info['phone'],'verification_code'=>$this->input->post('code'),'verified'=>0]);
					if ($verification_info) {
						// $store = ['verified' => 1];
	        			// $this->Main_model->update('mobile_numbers',['id'=>$verification_info['id']],$store);
	        			$this->db->where('mobile_number',$merchant_info['phone'])->delete('mobile_numbers');
	        			redirect('site_merchant/forget_password/new_password/'.$merchant_info['id']);
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
		$data['main_content'] = 'site_merchant/merchant/forget_password_verify_code';
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
				$this->Main_model->update('merchants',['id'=>$id],$store);
				$this->session->set_flashdata('message',notify('تم تغيير كلمة المرور بنجاح','success'));
				redirect('site_user/login');		 
			}else{
	            	$this->session->set_flashdata('message',notify(validation_errors(),'danger'));	
					redirect($_SERVER['HTTP_REFERER']);
            }
		}
		$data['main_content'] = 'site_merchant/merchant/new_password';
		$this->load->view('site_user/blank',$data);
	}

}

