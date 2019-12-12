<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/MobilySms.php';

class Register extends CI_Controller {



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
		$data['body_class'] = 'register page-template';
		$data['title'] = 'تسجيل مستخدم جديد';
		$data['countries'] = get_table('countries');
		$data['cities'] = get_table('cities');
		$this->form_validation->set_rules('vendor_full_name', 'الاسم بالكامل', 'trim|required');
        $this->form_validation->set_rules('vendor_phone', 'رقم الجوال', 'trim|required|numeric|is_unique[merchants.phone]');
        $this->form_validation->set_rules('email', 'البريد الإلكتروني', 'trim|required|valid_email|is_unique[merchants.email]');
        $this->form_validation->set_rules('country_id', 'الدولة', 'trim|required|numeric');
        $this->form_validation->set_rules('city_id', 'المدينة', 'trim|required|numeric');
        $this->form_validation->set_rules('vendor_password', 'كلمة المرور', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('vendor_c_password', 'تأكيد كلمة المرور', 'trim|required|min_length[6]|matches[vendor_c_password]');
		$this->form_validation->set_rules('vendor_bank_name', 'الاسم البنك', 'trim|required');
		$this->form_validation->set_rules('vendor_iban_account', 'حساب ايبان', 'trim|required|is_unique[merchants.iban_account]');
		if($this->input->post('vendor_commercial_register') != null)
		   $this->form_validation->set_rules('vendor_commercial_register', 'السجل التجاري', 'trim|required|is_unique[merchants.commercial_register]');
		$this->form_validation->set_rules('vendor_store_name', 'الاسم المتجر', 'trim|required');
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			if ($this->form_validation->run()) {
				$store = [

                          'full_name'           => $this->input->post('vendor_full_name'),
                          'phone'               => $this->input->post('vendor_phone'),
                          'email'               => $this->input->post('email'),
                          'country_id'          => $this->input->post('country_id'),
                          'city_id'             => $this->input->post('city_id'),
                          'password'            => md5(md5(md5(sha1($this->input->post('vendor_password'))))),
                          'store_name'           => $this->input->post('vendor_store_name'),
                          'bank_name'           => $this->input->post('vendor_bank_name'),
                          'iban_account'        => $this->input->post('vendor_iban_account'),
                          'credit'              => 0,
                          'created_at'          => date('Y-m-d'),
                          'status'              => 0,
                        ];
                if ($this->input->post('vendor_commercial_register')) {
                	$store['commercial_register'] = $this->input->post('vendor_commercial_register');
                }       
             	$insert = $this->Main_model->insert('merchants',$store);
		        if ($insert) {
		         	$code = generate_verification_code();
		            $phone = $this->input->post('vendor_phone');
		            $phone1 = ltrim($phone, '0');
		            $country_id = get_this('merchants',['phone' => $phone],'country_id');
		            $international_key = get_this('countries',['id'=>$country_id],'international_key');
		            $reciever = $international_key.$phone1;
		            // echo $reciever;exit;
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
		            print_r($message_info);
		            if($message_info->ResponseStatus == 'success'){
				    	$id = $this->Main_model->insert('mobile_numbers',$veri_info);
						redirect('site_merchant/verify_register/index/'.$insert);
				    }else{
				    	$this->session->set_flashdata('message',notify('يرجى التأكد من رقم الجوال واعادة المحاولة','danger'));
				    }
		         }
			}
			/*else{
				    	$this->session->set_flashdata('message',notify(validation_errors(),'danger'));
		    }*/
		}
		$data['main_content'] = 'site_user/user/register';
		$this->load->view('site_user/blank',$data);
	}

}

