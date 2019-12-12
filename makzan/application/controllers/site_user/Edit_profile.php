<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/MobilySms.php';
class Edit_profile extends CI_Controller {

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
	
	public function gen_random_string(){
		$chars ="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		$final_rand='';		
		for($i=0;$i<4; $i++) {		 
		$final_rand .= $chars[ rand(0,strlen($chars)-1)];
		}		
		return $final_rand;	
	}	
	
	
	public function index(){
		$data['body_class'] = 'vendor-template page-template';
		$data['title'] = 'تعديل بيانات الحساب';
		$data['user_data'] = $this->session->userdata('user_data');
		$data['countries'] = get_table('countries');
		$data['cities'] = get_table('cities');
		if (empty($data['user_data'])) {
			redirect('site_user/login');
		}else{
			$this->load->library('form_validation');
        	if($this->input->post('full_name') === "" || $this->input->post('full_name') != null)
               $this->form_validation->set_rules('full_name', 'الاسم بالكامل', 'trim|required');
        	if($this->input->post('country_id') === "" || $this->input->post('country_id') != null)
               $this->form_validation->set_rules('country_id', 'الدولة', 'trim|required|numeric');
        	if($this->input->post('city_id') === "" || $this->input->post('city_id') != null)
               $this->form_validation->set_rules('city_id', 'المدينة', 'trim|required|numeric');
        	if($this->input->post('image') === "")
               $this->form_validation->set_rules('image', 'الصورة الشخصيه', 'trim|required');
            if($this->input->server('REQUEST_METHOD') === 'POST') {
            	if ($this->form_validation->run()) {
					
					if(!empty($_FILES['image']['name'])){
					//Get Old Image To Remove
					$mg = get_this('customers',['id'=>$data['user_data']['id']]);
					$old_image = $mg['image'];
			
					$img_name=$this->gen_random_string(); 
					$imagename = $img_name;
					$config['upload_path'] = 'assets/uploads/files';
					$config['allowed_types'] = 'jpg|jpeg|png|gif';
					$config['file_name'] = $imagename;
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
					
					
            		$store = $this->input->post();
            		if ($this->input->post('password')) {
            			$store['password'] = md5(md5(md5(sha1($this->input->post('password')))));
            		}else{
            			unset($store['password']);
            		}
					
					if (!empty($image)) {
					$store['image'] = $image;
					unlink("assets/uploads/files/$old_image");
					}
					
        		$this->Main_model->update('customers',['id'=>$data['user_data']['id']],$store);
        		$customer = get_this('customers',['id'=>$data['user_data']['id']]);
        		$this->session->set_userdata('user_data',$customer);
        		$this->session->set_flashdata('message',notify('تم تعديل الحساب بنجاح','success'));
				redirect('site_user/edit_profile');
            	}else{
	            	$this->session->set_flashdata('message',notify(validation_errors(),'danger'));	
					redirect($_SERVER['HTTP_REFERER']);
            	}
            }
			$data['main_content'] = 'site_user/user/edit_profile';
		    $this->load->view('site_user/blank',$data);
		}
	}
	public function phone(){
		$data['body_class'] = 'password-template page-template';
		$data['title'] = 'تغيير رقم الجوال';
		$data['user_data'] = $this->session->userdata('user_data');
		if (empty($data['user_data'])) {
			redirect('site_user/login');
		}else{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('phone', 'رقم الجوال', 'trim|required|numeric|is_unique[customers.phone]|min_length[10]');
			if($this->input->server('REQUEST_METHOD') === 'POST') {
            	if ($this->form_validation->run()) {
            		$store = [
            					'phone'  =>$this->input->post('phone'),
            					'status' =>0
        					 ];
        			$this->Main_model->update('customers',['id'=>$data['user_data']['id']],$store);		 
            		$verification_data = get_this('mobile_numbers',['mobile_number'=>$this->input->post('phone'),'verified'=>0]);
            		if ($verification_data) {
            			$code = $verification_data['verification_code'];
			            $phone = $verification_data['mobile_number'];
			            $phone1 = ltrim($phone, '0');
			            $country_id = get_this('customers',['id' =>$data['user_data']['id']],'country_id');
			            $international_key = get_this('countries',['id'=>$country_id],'international_key');
			            $reciever = $international_key.$phone1;
			            $sms = new MobilySms('966507717440','159789','88f55e6be5eed49301496725879b72ac');
			    		$msg = "عزيزي (1)، كود التفعيل الخاص بك هو (2)";
			    		$msgKey = "(1),*,$reciever,@,(2),*,$code";
			    		$numbers = $reciever;
			    		$result = $sms->sendMsgWK($msg,$numbers,'0507717440',$msgKey,'12:00:00',now(),0,'deleteKey','curl');
			            $message_info = json_decode($result);
			            if($message_info->ResponseStatus == 'success'){
							redirect('site_user/edit_profile/verify/'.$data['user_data']['id']);
	    			    }else{
    			    		$this->session->set_flashdata('message',notify('يرجى التأكد من رقم الجوال واعادة المحاولة','danger'));
    			    	}
            		}else{
            			$code = generate_verification_code();
			            $phone = $this->input->post('phone');
			            $phone1 = ltrim($phone, '0');
			            $country_id = get_this('customers',['id' =>$data['user_data']['id']],'country_id');
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
							redirect('site_user/edit_profile/verify/'.$data['user_data']['id']);
	    			    }else{
    			    		$this->session->set_flashdata('message',notify('يرجى التأكد من رقم الجوال واعادة المحاولة','danger'));
    			    	}
            		}
            	}else{
	            	$this->session->set_flashdata('message',notify(validation_errors(),'danger'));	
					redirect($_SERVER['HTTP_REFERER']);
            	}
            }
        	$data['main_content'] = 'site_user/user/change_phone';
			$this->load->view('site_user/blank',$data);
		}
	}
	public function verify($id){
		$data['body_class'] = 'password-template page-template';
		$data['title'] = 'تفعيل رقم الجوال';
        $this->form_validation->set_rules('code', 'كود التفعيل', 'trim|required|min_length[6]');
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			if ($this->form_validation->run()) {
				$customer_info = get_this('customers',['id'=>$id,'status'=>0]);
				if ($customer_info) {
					$verification_info = get_this('mobile_numbers',['mobile_number'=>$customer_info['phone'],'verification_code'=>$this->input->post('code'),'verified'=>0]);
					if ($verification_info) {
						$store = ['verified' => 1];
	        			$update = ['status' => 1];
	        			$this->Main_model->update('mobile_numbers',['id'=>$verification_info['id']],$store);
	        			$this->Main_model->update('customers',['phone'=>$customer_info['phone']],$update);
	        			$customer = get_this('customers',['id'=>$id]);
	        			$this->session->set_userdata('user_data',$customer);
	        			redirect('site_user/edit_profile');
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
		$data['main_content'] = 'site_user/user/edit_phone_verify_code';
		$this->load->view('site_user/blank',$data);
	}
	
}
