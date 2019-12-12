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

		$this->form_validation->set_rules('full_name', 'الاسم بالكامل', 'trim|required');

        $this->form_validation->set_rules('phone', 'رقم الجوال', 'trim|required|numeric|is_unique[customers.phone]|min_length[10]|max_length[10]');

        $this->form_validation->set_rules('country_id', 'الدولة', 'trim|required|numeric');

        $this->form_validation->set_rules('city_id', 'المدينة', 'trim|required|numeric');

        $this->form_validation->set_rules('password', 'كلمة المرور', 'trim|required|min_length[6]');

        $this->form_validation->set_rules('c_password', 'تأكيد كلمة المرور', 'trim|required|min_length[6]|matches[password]');

		if ($this->input->server('REQUEST_METHOD') === 'POST') {

			if ($this->form_validation->run()) {

				$store = [

                          'full_name'           => $this->input->post('full_name'),

                          'phone'               => $this->input->post('phone'),

                          'country_id'          => $this->input->post('country_id'),

                          'city_id'             => $this->input->post('city_id'),

                          'password'            => md5(md5(md5(sha1($this->input->post('password'))))),

                          'created_at'          => date('Y-m-d'),

                          'status'              => 0,
                          'confirmed'           => 1

                        ];

	             $insert = $this->Main_model->insert('customers',$store);

	             if ($insert) {

	             	 $code = generate_verification_code();

		             $phone = $this->input->post('phone');

		             $phone1 = ltrim($phone, '0');

		             $country_id = get_this('customers',['phone' => $phone],'country_id');

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

    			    	$id = $this->Main_model->insert('mobile_numbers',$veri_info);

						redirect('site_user/verify_register/index/'.$insert);

    			    }else{

    			    	$this->session->set_flashdata('message',notify('يرجى التأكد من رقم الجوال واعادة المحاولة','danger'));

    			    }

	             }



			}

		}

		$data['main_content'] = 'site_user/user/register';

		$this->load->view('site_user/blank',$data);

	}

}

