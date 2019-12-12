<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/MobilySms.php';
class Send_sms extends CI_Controller {
	public function send($id){
		$data['body_class'] = 'register-confirm page-template';
		$data['title'] = 'تأكيد تسجيل الحساب';
		if ($this->session->has_userdata('user_data')) {
			redirect('home');
		}else{
			$customer = get_this('customers',['id'=>$id]);
			if ($customer) {
				if ($customer['status'] == 0) {
					$verification_data = get_this('mobile_numbers',['mobile_number'=>$customer['phone']]);
					if ($verification_data) {
						$code = $verification_data['verification_code'];
					}else{
						$code = generate_verification_code();
					}
					$phone = $customer['phone'];
		            $phone1 = ltrim($phone, '0');
		            $country_id = $customer['country_id'];
		            $international_key = get_this('countries',['id'=>$country_id],'international_key');
		            $reciever = $international_key.$phone1;
		        	$veri_info = [
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
    			       $insert = $this->Main_model->insert('mobile_numbers',$veri_info);
					   redirect('site_user/verify_register/index/'.$id);
    			    }else{
    			    	$this->session->set_flashdata('message',notify('يرجى التأكد من رقم الجوال واعادة المحاولة','danger'));
    			    }
				}
				if ($customer['status'] == 1) {
					$this->session->set_flashdata('message',notify('تم تاكيد تفعيل الحساب يرجى تسجيل الدخول','danger'));
					redirect('site_user/login');
				}
			}else{
				$this->session->set_flashdata('message',notify('عفوا لا توجد اي بيانات لهذا الحساب','danger'));
				redirect('site_user/login');
			}
		}

	}
}

