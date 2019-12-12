<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/MobilySms.php';
class Edit_profile extends CI_Controller {

	public function index(){
		$data['body_class'] = 'vendor-template page-template';
		$data['title'] = 'تعديل بيانات الحساب';
		$data['merchant_data'] = $this->session->userdata('merchant_data');
		$data['countries'] = get_table('countries');
		$data['delivering_methods'] = get_table('delivering_methods');
		$data['cities'] = get_table('cities');
		if (empty($data['merchant_data'])) {
			redirect('site_user/login');
		}else{
			$this->load->library('form_validation');
        	if($this->input->post('full_name') === "" || $this->input->post('full_name') != null)
               $this->form_validation->set_rules('full_name', 'الاسم بالكامل', 'trim|required');
        	if($this->input->post('country_id') === "" || $this->input->post('country_id') != null)
               $this->form_validation->set_rules('country_id', 'الدولة', 'trim|required|numeric');
        	if($this->input->post('city_id') === "" || $this->input->post('city_id') != null)
               $this->form_validation->set_rules('city_id', 'المدينة', 'trim|required|numeric');
		   
		   if($this->input->post('email') === "" || $this->input->post('email') != null){
			  $email = get_this('merchants',['id'=>$data['merchant_data']['id']],'email');
			  if ($email != $this->input->post('email')) {
				  $this->form_validation->set_rules('email', 'البريد الالكتروني', 'trim|required|valid_email|is_unique[merchants.email]');
			  }
			}
        	// if($this->input->post('image') === "")
         //       $this->form_validation->set_rules('image', 'الصورة الشخصيه', 'trim|required');
            if($this->input->server('REQUEST_METHOD') === 'POST') {
            	if ($this->form_validation->run()) {
            		$store = $this->input->post();
            		if(!empty($_FILES['image']['name'])){
		                $config['upload_path'] = 'assets/uploads/files';
		                $config['allowed_types'] = 'jpg|jpeg|png|gif';
		                $config['file_name'] = $_FILES['image']['name'];
		                //Load upload library and initialize configuration
		                $this->load->library('upload',$config);
		                $this->upload->initialize($config);
		                if($this->upload->do_upload('image')){
		                    $uploadData = $this->upload->data();
		                    $image = $uploadData['file_name'];
		                }else{
		                    $image = '';
		                }
		                }else{
		                    $image = '';
		                }
						if (!empty($image)) {
						$store['image'] = $image;
						}else{
							unset($store['image']);
						}
            		unset($store['method']);
            		if ($this->input->post('password')) {
            			$store['password'] = md5(md5(md5(sha1($this->input->post('password')))));
            		}else{
            			unset($store['password']);
            		}
            		// print_r($store);exit;
        		$this->Main_model->update('merchants',['id'=>$data['merchant_data']['id']],$store);
        		if ($this->input->post('method')) {
					$this->db->where('merchant_id',$data['merchant_data']['id'])->delete('merchants_delivering_methods');
	        		foreach ($this->input->post('method') as $me) {
	        			if ($me['id'] > 0) {
							 $this->db->insert('merchants_delivering_methods',array('merchant_id' => $data['merchant_data']['id'],'created_at'=>date('Y-m-d'),'method_id' => $me['id'], 'price' => $me['price']));	
	        			}
					}	
        		}
        		$merchant = get_this('merchants',['id'=>$data['merchant_data']['id']]);
        		$this->session->set_userdata('merchant_data',$merchant);
        		$this->session->set_flashdata('message',notify('تم تعديل الحساب بنجاح','success'));
				redirect('site_merchant/edit_profile');
            	}else{
	            	$this->session->set_flashdata('message',notify(validation_errors(),'danger'));	
					redirect($_SERVER['HTTP_REFERER']);
            	}
            }
			$data['main_content'] = 'site_merchant/merchant/edit_profile';
		    $this->load->view('site_user/blank',$data);
		}
	}

	public function phone(){
		$data['body_class'] = 'password-template page-template';
		$data['title'] = 'تغيير رقم الجوال';
		$data['merchant_data'] = $this->session->userdata('merchant_data');
		if (empty($data['merchant_data'])) {
			redirect('site_user/login');
		}else{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('phone', 'رقم الجوال', 'trim|required|numeric|is_unique[customers.phone]|min_length[10]|is_unique[merchants.phone]');
			if($this->input->server('REQUEST_METHOD') === 'POST') {
            	if ($this->form_validation->run()) {
            		$store = [
            					'phone'  =>$this->input->post('phone'),
            					'status' =>0
        					 ];
        			$this->Main_model->update('merchants',['id'=>$data['merchant_data']['id']],$store);		 
            		$verification_data = get_this('mobile_numbers',['mobile_number'=>$this->input->post('phone'),'verified'=>0]);
            		if ($verification_data) {
            			$code = $verification_data['verification_code'];
			            $phone = $verification_data['mobile_number'];
			            $phone1 = ltrim($phone, '0');
			            $country_id = get_this('merchants',['id' =>$data['merchant_data']['id']],'country_id');
			            $international_key = get_this('countries',['id'=>$country_id],'international_key');
			            $reciever = $international_key.$phone1;
			            $sms = new MobilySms('966507717440','159789','88f55e6be5eed49301496725879b72ac');
			    		$msg = "عزيزي (1)، كود التفعيل الخاص بك هو (2)";
			    		$msgKey = "(1),*,$reciever,@,(2),*,$code";
			    		$numbers = $reciever;
			    		$result = $sms->sendMsgWK($msg,$numbers,'0507717440',$msgKey,'12:00:00',now(),0,'deleteKey','curl');
			            $message_info = json_decode($result);
			            if($message_info->ResponseStatus == 'success'){
							redirect('site_merchant/edit_profile/verify/'.$data['merchant_data']['id']);
	    			    }else{
    			    		$this->session->set_flashdata('message',notify('يرجى التأكد من رقم الجوال واعادة المحاولة','danger'));
    			    	}
            		}else{
            			$code = generate_verification_code();
			            $phone = $this->input->post('phone');
			            $phone1 = ltrim($phone, '0');
			            $country_id = get_this('merchants',['id' =>$data['merchant_data']['id']],'country_id');
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
	    			    	$this->Main_model->insert('mobile_numbers',$veri_info);
							redirect('site_merchant/edit_profile/verify/'.$data['merchant_data']['id']);
	    			    }else{
    			    		$this->session->set_flashdata('message',notify('يرجى التأكد من رقم الجوال واعادة المحاولة','danger'));
    			    	}
            		}
            	}else{
	            	$this->session->set_flashdata('message',notify(validation_errors(),'danger'));	
					redirect($_SERVER['HTTP_REFERER']);
            	}
            }
        	$data['main_content'] = 'site_merchant/merchant/change_phone';
			$this->load->view('site_user/blank',$data);
		}
	}

	public function verify($id){
		$data['body_class'] = 'password-template page-template';
		$data['title'] = 'تفعيل رقم الجوال';
        $this->form_validation->set_rules('code', 'كود التفعيل', 'trim|required|min_length[6]');
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			if ($this->form_validation->run()) {
				$merchant_info = get_this('merchants',['id'=>$id,'status'=>0]);
				if ($merchant_info) {
					$verification_info = get_this('mobile_numbers',['mobile_number'=>$merchant_info['phone'],'verification_code'=>$this->input->post('code'),'verified'=>0]);
					if ($verification_info) {
						// $store = ['verified' => 1];
	        			$update = ['status' => 1];
	        			$this->db->where('mobile_number',$verification_info['mobile_number'])->delete('mobile_numbers');
	        			// $this->Main_model->update('mobile_numbers',['id'=>$verification_info['id']],$store);
	        			$this->Main_model->update('merchants',['phone'=>$merchant_info['phone']],$update);
	        			$merchant = get_this('merchants',['id'=>$id]);
	        			$this->session->set_userdata('merchant_data',$merchant);
	        			redirect('site_merchant/edit_profile');
					}else{
						$this->session->set_flashdata('message',notify('برجى التأكد من كود التفعيل الخاص بك','danger'));
					}
				}else{
					$this->session->set_flashdata('message',notify('عفوا فقد قمت بتفعيل الحساب من قبل','danger'));
				}
			}else{
	            	$this->session->set_flashdata('message',notify(validation_errors(),'danger'));	
					redirect($_SERVER['HTTP_REFERER']);
            }
		}
		$data['main_content'] = 'site_merchant/merchant/edit_phone_verify_code';
		$this->load->view('site_user/blank',$data);
	}
}

