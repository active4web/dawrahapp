<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/API_Controller.php';
require APPPATH . 'libraries/MobilySms.php';

class Api extends API_Controller
{
    public function __construct() {
        parent::__construct();
		$this->load->model('data','','true');
		date_default_timezone_set('Asia/Riyadh');
    }
	
	public function checkLang($language = "")
    {
        $language = $this->input->post('lang');
		if ($language == "arabic" || $language == "" || $language != "english") {
            $this->lang->load('api_lang', "arabic");
            $this->lang->load('form_validation_lang', "arabic");
        } else {
            $this->lang->load('api_lang', "english");
            $this->lang->load('form_validation_lang', "english");
        }
    }

    /**
     * Check API Key
     *
     * @return key|string
     */
    private function key()
    {
        // use database query for get valid key
        return 1234567890;
    }
	
	public function register()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);

		$this->load->library('form_validation');
        $this->form_validation->set_rules('username', lang('Username'), 'trim|required');
        $this->form_validation->set_rules('phone', lang('Phone Number'), 'trim|required|numeric|is_unique[customers.phone]|max_length[10]');
		$this->form_validation->set_rules('email', lang('Email'), 'trim|required|valid_email|is_unique[customers.email]');
        $this->form_validation->set_rules('password', lang('Password'), 'trim|required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', lang('Confirm Password'), 'trim|required|matches[password]');
		$this->form_validation->set_rules('device_reg_id', lang('Device Reg ID'), 'trim|required');
		
        if($this->form_validation->run() === FALSE){
			
			$email = get_this('customers',['email'=>$this->input->post('email')]);
			$phone = get_this('customers',['phone'=>$this->input->post('phone')]);
			
            if(form_error('username'))
				$data[] = array('message'=> strip_tags(form_error('username')),"errNum" => 0);
            if(form_error('email')){
				if($this->input->post('email')==="" || !$this->input->post('email')){
					$data[] = array('message'=> strip_tags(form_error('email')),"errNum" => 0);
				}elseif($email){
					$data[] = array('message'=> strip_tags(form_error('email')),"errNum" => 2);
				}else{
					$data[] = array('message'=> strip_tags(form_error('email')),"errNum" => 1);
				}
			}
			
			if(form_error('device_reg_id'))
				$data[] = array('message'=> strip_tags(form_error('device_reg_id')),"errNum" => 0);
			
            if(form_error('phone')){
				if($this->input->post('phone')==="" || !$this->input->post('phone')){
					$data[] = array('message'=> strip_tags(form_error('phone')),"errNum" => 0);
				}elseif($phone){
					$data[] = array('message'=> strip_tags(form_error('phone')),"errNum" => 2);
				}else{
					$data[] = array('message'=> strip_tags(form_error('phone')),"errNum" => 1);
				}
			}
                
            if(form_error('password')){
				if($this->input->post('password')==="" || !$this->input->post('password')){
					$data[] = array('message'=> strip_tags(form_error('password')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('password')),"errNum" => 1);
				}
			}

			if(form_error('confirm_password')){
				if($this->input->post('confirm_password')==="" || !$this->input->post('confirm_password')){
					$data[] = array('message'=> strip_tags(form_error('confirm_password')),"errNum" => 0);
				}elseif($this->input->post('confirm_password')!=$this->input->post('password')){
					$data[] = array('message'=> strip_tags(form_error('confirm_password')),"errNum" => 3);
				}else{
					$data[] = array('message'=> strip_tags(form_error('confirm_password')),"errNum" => 1);
				}
			}
            $this->api_return([
				'message' => $data[0]['message'],
				'errNum' => $data[0]['errNum'],
				'status' => false
			],200);
        }else{
				$activation_code = generate_verification_code();
				$invitation_code = generate_verification_code_pass();
				
				//Generate Code If Exist Before
				$activation = get_this('customers',['activation_code'=>$activation_code]);
				$invitation = get_this('customers',['invitation_code'=>$invitation_code]);
				if($activation){$activation_code = generate_verification_code();}
				if($invitation){$invitation_code = generate_verification_code_pass();}
				
				$invitation_count = get_this('site_info',['id'=>1],'invitation_count');
				date_default_timezone_set('Asia/Riyadh');
				$store = [
                          'username'          	=> $this->input->post('username'),
						  'password'            => md5($this->input->post('password')),
						  'email'          		=> $this->input->post('email'),
                          'phone'               => $this->input->post('phone'),
                          'points'             	=> '0',
                          'status'             	=> '0',
                          'activation_code'    	=> $activation_code,
                          'invitation_code'    	=> $invitation_code,
                          'invitation_count'    => $invitation_count,
                          'alarm_near'    		=> '0',
                          'alarm_finished'    	=> '0',
                          'social_name'    		=> '',
                          'social_id'    	=> '',
                          'device_reg_id'    	=> $this->input->post('device_reg_id'),
                          'creation_date'       => date('Y-m-d H:i:s')
                        ];
	             $insert = $this->Main_model->insert('customers',$store);
				 
				 //Invitation Code If Found
				 $code = $this->input->post('code');
				 $res_cus = get_this('customers',['invitation_code'=>$code]);
				 if($res_cus){
					 if($res_cus['invitation_count']>0){
						$updates['invitation_count'] = $res_cus['invitation_count'] - 1;
						$update = $this->Main_model->update('customers',['id'=>$res_cus['id']],$updates);
					 }
				 }
				 ////////////////////////////////////////////////////////////////////////////////////////
				 
				 //Send SMS Activation Code
	            if($insert){
	              	  $customer_info = get_this('customers',['id' => $insert]);
	              	  //unset($customer_info['email']);
	              	  unset($customer_info['password']);
					  $customer_info['activation_status'] = lang('Account Not Activated');
						
						unset($customer_info['img']);
						$img = get_this('customers',['id'=>$customer_info['id']],'img');
						//echo file_exists($_SERVER['DOCUMENT_ROOT'].'/uploads/customers/'.$img);die;
						if($img!=""){
							if(file_exists($_SERVER['DOCUMENT_ROOT'].'/uploads/customers/'.$img)){
								$customer_info['img'] = base_url('uploads/customers/'.$img);
							}else{
								$customer_info['img'] = base_url('uploads/customers/avatar.png');
							}
						}else{
							$customer_info['img'] = base_url('uploads/customers/avatar.png');
						}
				
	                  $data['customer_info'] = $customer_info;
					  
					  $payload = [
							'id' => $customer_info['id'],
							'phone' => $customer_info['phone'],
							'email' => $customer_info['email']
						];
						 // Load Authorization Library or Load in autoload config file
						$this->load->library('authorization_token');
						// generte a token
						$token = $this->authorization_token->generateToken($payload);
						
	                  $this->api_return([
						  'message' => lang('Please enter your activation code'),
							'errNum' => 405,
							'status' => true,
							"result" => $data,
							'token' => $token
						],200);
	             }else{
	                  $this->api_return([
						'message' => lang('An error in the register'),
						'errNum' => 4,
						'status' => false
					],200);
	             }
        }
	}
	
	public function send_sms()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
			'limit' => [1, 'ip',1]
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);

		$this->load->library('form_validation');
        $this->form_validation->set_rules('phone', lang('Phone Number'), 'required|numeric');
        $this->form_validation->set_rules('type', lang('Send ٍType'), 'required|numeric');
        if($this->form_validation->run() === FALSE){
			
            if(form_error('phone')){
				if($this->input->post('phone')==="" || !$this->input->post('phone')){
					$data[] = array('message'=> strip_tags(form_error('phone')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('phone')),"errNum" => 1);
				}
			}
			
		
			if(form_error('type')){
				if($this->input->post('type')==="" || !$this->input->post('type')){
					$data[] = array('message'=> strip_tags(form_error('type')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('type')),"errNum" => 1);
				}
			}
			
            $this->api_return([
				'message' => $data[0]['message'],
				'errNum' => $data[0]['errNum'],
				'status' => false
					],200);
        }else{
			$phone = get_this('customers',['phone'=>$this->input->post('phone')]);
		if($phone){
          $verification_info = get_this('customers',['phone'=>$this->input->post('phone'),'status'=>'0']);
			/*if ($verification_info) {
				$code = $verification_info['activation_code'];
				$data = array('digit'=> strlen($code));
			}else{}*/
			if($this->input->post('type')!=0){
				$code = generate_verification_code();
				$data = array('digit'=> strlen($code));
			}else{
				$code = generate_verification_code_pass();
				$data = array('digit'=> strlen($code));
			}
			
			$update = ['activation_code' => $code,'status'=>'0'];
			$this->Main_model->update('customers',['phone'=>$this->input->post('phone')],$update);
          
			$phone = $this->input->post('phone');
			$phone_n = ltrim($phone, '0');
			$international_key = '966';
			$reciever = $international_key.$phone_n;
			
			date_default_timezone_set('Asia/Riyadh');
	        $sms = new MobilySms('966558238604','ahm88558855','08ddc32788bafc89f383b98bd419049b');
			$msg = "عزيزي (1)، كود التفعيل الخاص بك هو (2)";
    		$msgKey = "(1),*,$reciever,@,(2),*,$code";
    		$numbers = $reciever;
    		$result = $sms->sendMsgWK($msg,$numbers,'0558238604',$msgKey,'12:00:00',date("Y-m-d H:i:s"),0,'deleteKey','curl');
			$message_info = json_decode($result);
			$islam = 'success';
    		//if($islam == 'success'){
			if($message_info->ResponseStatus == 'success'){
				$data['phone'] = $this->input->post('phone');
				$data['activation_code'] = $code;
				//$this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
				$this->api_return([
					'message' => lang('Success code sent successfully'),
					'errNum' => 405,
					'status' => true,
					"result" => $data
				],200);
    		}else{
				//$this->response($message_info, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
				$this->api_return([
					'message' => $message_info,
					"errNum" => 3,
					'status' => false,
					"result" => $message_info,
					
				],200);
          }
			}else{
				$this->api_return([
				'message' => lang('Sorry this phone does not exist'),
				'errNum' => 5,
				'status' => false
					],200);
			}
        }
	}
	
	public function confirm()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);

		$this->load->library('form_validation');
        $this->form_validation->set_rules('phone',lang('Phone Number'), 'trim|required|numeric');
        $this->form_validation->set_rules('activation_code', lang('Activation Code'), 'trim|required|min_length[4]|max_length[6]');
        if($this->form_validation->run() === FALSE){
            if(form_error('phone')){
				if($this->input->post('phone')==="" || !$this->input->post('phone')){
					$data[] = array('message'=> strip_tags(form_error('phone')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('phone')),"errNum" => 1);
				}
			}
			
            if(form_error('activation_code')){
				if($this->input->post('activation_code')==="" || !$this->input->post('activation_code')){
					$data[] = array('message'=> strip_tags(form_error('activation_code')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('activation_code')),"errNum" => 1);
				}
			}
			
            $this->api_return([
				'message' => $data[0]['message'],
				'errNum' => $data[0]['errNum'],
				'status' => false
				],200);
        }else{
        	$customer_info = get_this('customers',['phone'=>$this->input->post('phone'),'status'=>'0']);
        	if ($customer_info) {
        		$verification_info = get_this('customers',['phone'=>$customer_info['phone'],'activation_code'=>$this->input->post('activation_code'),'status'=>'0']);
        		if ($verification_info) {
        			$update = ['status' =>'1'];
        			$this->Main_model->update('customers',['phone'=>$customer_info['phone']],$update);
					$data['customer_info'] = get_this('customers',['phone'=>$this->input->post('phone')]);
					$this->api_return([
						'message' => lang('Account successfully activated'),
						'errNum' => 405,
						'status' => true,
						"result" => $data
					],200);
        		}else{
					$this->api_return([
						'message' => lang('Please check your activation code and try again'),
						'errNum' => 6,
						'status' => false
					],200);
        		}
        	}else{
				$this->api_return([
						'message' => lang('Sorry, there are no data for this user'),
						'errNum' => 402,
						'status' => false
					],200);
        	}
    	}
	}
	
	public function login()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);

		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);

		$this->load->library('form_validation');
        $this->form_validation->set_rules('phone',lang('Phone Number'), 'required|numeric');
        $this->form_validation->set_rules('password', lang('Password'), 'required');
		$this->form_validation->set_rules('device_reg_id', lang('Device Reg ID'), 'trim|required');
        if($this->form_validation->run() === FALSE){
            if(form_error('phone')){
				if($this->input->post('phone')==="" || !$this->input->post('phone')){
				$data[] = array('message'=> strip_tags(form_error('phone')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('phone')),"errNum" => 1);
				}
			}
			
			if(form_error('device_reg_id'))
				$data[] = array('message'=> strip_tags(form_error('device_reg_id')),"errNum" => 0);
                
            if(form_error('password'))
                $data[] = array('message'=> strip_tags(form_error('password')),"errNum" => 0);
            
			//print_r($data);die;
			$this->api_return([
			'message' => $data[0]['message'],
			'errNum' => $data[0]['errNum'],
			'status' => false
			],200);
        }else{
            $customer_info = get_this('customers',['phone'=>$this->input->post('phone'),'password'=>md5($this->input->post('password'))]);
            if ($customer_info) {
                if ($customer_info['status'] == 0) {
					 /*$activation_code = generate_verification_code();
					 $update = ['activation_code' => $activation_code];
					 $this->Main_model->update('customers',['id'=>$customer_info['id']],$update);*/
					 unset($customer_info['img']);
					 $img = get_this('customers',['id'=>$customer_info['id']],'img');
					 if($img!=""){
						 if(file_exists($_SERVER['DOCUMENT_ROOT'].'/uploads/customers/'.$img)){
							 $customer_info['img'] = base_url('uploads/customers/'.$img);
						 }else{
							 $customer_info['img'] = base_url('uploads/customers/avatar.png');
						 }
					 }else{
						 $customer_info['img'] = base_url('uploads/customers/avatar.png');
					 }
					 $data['customer_info'] = $customer_info;
					 $data['customer_info']['activation_status'] = lang('Account Not Activated');
					 
					//Update Account Device_reg_id
					$device_reg_id = $this->input->post('device_reg_id');
					$update = ['device_reg_id' => $device_reg_id];
					$this->Main_model->update('customers',['id'=>$customer_info['id']],$update);
					///////////////////////////////////////////////////////////////////////////////
					
					//Update Activation Code
					$activation_code = generate_verification_code();
					$updates = ['activation_code' => $activation_code];
					$this->Main_model->update('customers',['id'=>$customer_info['id']],$updates);
					///////////////////////////////////////////////////////////////////////////////
					 
					 $payload = [
							'id' => $customer_info['id'],
							'phone' => $customer_info['phone'],
							'email' => $customer_info['email']
						];
					// Load Authorization Library or Load in autoload config file
					$this->load->library('authorization_token');
					// generte a token
					$token = $this->authorization_token->generateToken($payload);
						
					 //Send SMS To Phone Number
					 $this->api_return([
					 'message' => lang('Account Not Activated'),
					'errNum' => 401,
					'status' => true,
					"result" => $data,
					'token' => $token
					],200);
                }else{
                     if ($customer_info['status'] == 1) {
                         unset($customer_info['password']);
                         unset($customer_info['img']);
                         $customer_info['activation_status'] = lang('Account activated');
						 //$img = get_this('customers',['id'=>$customer_info['id']]);
                         //$customer_info['img'] = base_url('uploads/customers/'.$img['img']);
						 $img = get_this('customers',['id'=>$customer_info['id']],'img');
						 if($img!=""){
							 if(file_exists($_SERVER['DOCUMENT_ROOT'].'/uploads/customers/'.$img)){
								 $customer_info['img'] = base_url('uploads/customers/'.$img);
							 }else{
								 $customer_info['img'] = base_url('uploads/customers/avatar.png');
							 }
						 }else{
							 $customer_info['img'] = base_url('uploads/customers/avatar.png');
						 }
                         $data['customer_info'] = $customer_info;
						 
						 //Update Account Device_reg_id
						$device_reg_id = $this->input->post('device_reg_id');
						$update = ['device_reg_id' => $device_reg_id];
						$this->Main_model->update('customers',['id'=>$customer_info['id']],$update);
						///////////////////////////////////////////////////////////////////////////////
						 
						$payload = [
							'id' => $customer_info['id'],
							'phone' => $customer_info['phone'],
							'email' => $customer_info['email']
						];
						 // Load Authorization Library or Load in autoload config file
						$this->load->library('authorization_token');
						// generte a token
						$token = $this->authorization_token->generateToken($payload);
						
						 $this->api_return([
						 'message' => lang('Account activated'),
						'errNum' => 405,
						'status' => true,
						"result" => $data,
						'token' => $token
						],200);
                     }
					 /*else{
                        $data['message'] = lang('Account Not Activated');
                        $data['errNum'] = 401;
						$this->api_return([
							'status' => false,
							"result" => $data
							],200);
                     }*/
                }
            }else{
				$this->api_return([
					'message' => lang('wrong credential or password wrong'),
					'errNum' => 402,
					'status' => false
					],200);
            } 
        }
	}
	
	public function change_password()
    {
        header("Access-Control-Allow-Origin: *");

        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
			'requireAuthorization' => true
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);
		
		$social_name = $this->input->post('social_name');
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('customer_id', lang('Customer ID'), 'trim|required|numeric');
		if(!$social_name){
			$this->form_validation->set_rules('old_password', lang('Current Password'), 'trim|required');
		}
        $this->form_validation->set_rules('password', lang('New Password'), 'trim|required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', lang('Confirm Password'), 'trim|required|matches[password]');
		$customer = get_this('customers',['id'=>$this->input->post('customer_id')]);
		
		//if ($customer['password'] == md5($this->input->post('old_password')) || $this->input->post('old_password')==="") {
        if($this->form_validation->run() === FALSE){
			
          if(form_error('customer_id')){
			  if($this->input->post('customer_id')==="" || !$this->input->post('customer_id')){
				$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 0);
			  }else{
				$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 1);
			  }	
		  }
		  
		 if(form_error('old_password')){
					$data[] = array('message'=> strip_tags(form_error('old_password')),"errNum" => 0);
			}
			  
          if(form_error('password')){
			  if($this->input->post('password')==="" || !$this->input->post('password')){
				$data[] = array('message'=> strip_tags(form_error('password')),"errNum" => 0);
			  }else{
				$data[] = array('message'=> strip_tags(form_error('password')),"errNum" => 1);
			  }
		  }
		  
          if(form_error('confirm_password')){
			if($this->input->post('confirm_password')==="" || !$this->input->post('confirm_password')){
				$data[] = array('message'=> strip_tags(form_error('confirm_password')),"errNum" => 0);
			}elseif($this->input->post('confirm_password')!=$this->input->post('password')){
				$data[] = array('message'=> strip_tags(form_error('confirm_password')),"errNum" => 3);
			}else{
				$data[] = array('message'=> strip_tags(form_error('confirm_password')),"errNum" => 1);
			}
		  }
		
          $this->api_return([
					'message' => $data[0]['message'],
					'errNum' => $data[0]['errNum'],
					'status' => false
				],200);
        }else{
			if(!$social_name){
				if ($customer['password'] == md5($this->input->post('old_password')) || $this->input->post('old_password')==="") {
				$customer_info = get_this('customers',['id'=>$this->input->post('customer_id'),'status'=>'1']);
				if ($customer_info) {
					$update = ['password' => md5($this->input->post('password'))];
					$this->Main_model->update('customers',['id'=>$this->input->post('customer_id')],$update);
				   $this->api_return([
					   'message' => lang('Password changed successfully'),
						'errNum' => 405,
						'status' => true
					],200);

				}else{
				  $this->api_return([
						'message' => lang('Sorry, there are no data for this user'),
						'errNum' => 402,
						'status' => false
						],200);
				}
				}else{
				$this->api_return([
						'message' => lang('Sorry, the current password is incorrect'),
						'errNum' => 7,
						'status' => false
						],200);
				}
			}else{
				$customer_info = get_this('customers',['id'=>$this->input->post('customer_id'),'status'=>'1']);
				if ($customer_info) {
					$update = ['password' => md5($this->input->post('password'))];
					$this->Main_model->update('customers',['id'=>$this->input->post('customer_id')],$update);
				   $this->api_return([
						'message' => lang('Password changed successfully'),
						'errNum' => 405,
						'status' => true
						],200);

				}else{
				  $this->api_return([
						'message' => lang('Sorry, there are no data for this user'),
						'errNum' => 402,
						'status' => false,
						"result" => $data
						],200);
				}
			}
        }		
	}
	
	public function forget_password()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);

		$this->load->library('form_validation');
		$this->form_validation->set_rules('phone', lang('Phone Number'), 'trim|required|numeric');
        $this->form_validation->set_rules('activation_code', lang('Activation Code'), 'trim|required|exact_length[6]');
        $this->form_validation->set_rules('password', lang('New Password'), 'trim|required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', lang('Confirm Password'), 'trim|required|matches[password]');
		$this->form_validation->set_rules('device_reg_id', lang('Device Reg ID'), 'trim|required');
        if($this->form_validation->run() === FALSE){
		  
		if(form_error('phone')){
			if($this->input->post('phone')==="" || !$this->input->post('phone')){
				$data[] = array('message'=> strip_tags(form_error('phone')),"errNum" => 0);
			}else{
				$data[] = array('message'=> strip_tags(form_error('phone')),"errNum" => 1);
			}
		  }
		  
		  if(form_error('device_reg_id'))
				$data[] = array('message'=> strip_tags(form_error('device_reg_id')),"errNum" => 0);

          if(form_error('activation_code')){
			if($this->input->post('activation_code')==="" || !$this->input->post('activation_code')){
				$data[] = array('message'=> strip_tags(form_error('activation_code')),"errNum" => 0);
			}else{
				$data[] = array('message'=> strip_tags(form_error('activation_code')),"errNum" => 1);
			}
		  }

        if(form_error('password')){
			if($this->input->post('password')==="" || !$this->input->post('password')){
				$data[] = array('message'=> strip_tags(form_error('password')),"errNum" => 0);
			}else{
				$data[] = array('message'=> strip_tags(form_error('password')),"errNum" => 1);
			}
		}

		if(form_error('confirm_password')){
			if($this->input->post('confirm_password')==="" || !$this->input->post('confirm_password')){
				$data[] = array('message'=> strip_tags(form_error('confirm_password')),"errNum" => 0);
			}elseif($this->input->post('confirm_password')!=$this->input->post('password')){
				$data[] = array('message'=> strip_tags(form_error('confirm_password')),"errNum" => 3);
			}else{
				$data[] = array('message'=> strip_tags(form_error('confirm_password')),"errNum" => 1);
			}
		}
          $this->api_return([
					'message' => $data[0]['message'],
					'errNum' => $data[0]['errNum'],
					'status' => false
					],200);
        }else{
          $customer_info = get_this('customers',['phone'=>$this->input->post('phone')]);
            if ($customer_info) {
				$verification_info = get_this('customers',['phone'=>$customer_info['phone'],'activation_code'=>$this->input->post('activation_code')]);
				if ($verification_info) {
					$update = ['password' => md5($this->input->post('password')),'status'=>'1'];
					$this->Main_model->update('customers',['phone'=>$customer_info['phone']],$update);
					$data['customer_info'] = $customer_info;
					
					//Update Account Device_reg_id
					$device_reg_id = $this->input->post('device_reg_id');
					$update = ['device_reg_id' => $device_reg_id];
					$this->Main_model->update('customers',['id'=>$customer_info['id']],$update);
					///////////////////////////////////////////////////////////////////////////////

					$payload = [
							'id' => $customer_info['id'],
							'phone' => $customer_info['phone'],
							'email' => $customer_info['email']
						];
					// Load Authorization Library or Load in autoload config file
					$this->load->library('authorization_token');
					// generte a token
					$token = $this->authorization_token->generateToken($payload);
					
					$this->api_return([
					'message' => lang('Password changed successfully'),
					'errNum' => 405,
					'status' => true,
					"result" => $data,
					'token' => $token
					],200);
				}else{
					$this->api_return([
					'message' => lang('Please check the input data and try again'),
					'errNum' => 6,
					'status' => false
					],200);
              }
              
            }else{
              $this->api_return([
					'message' => lang('Sorry, there are no data for this user'),
					'errNum' => 402,
					'status' => false
					],200);
            }
        }
	}
	
	public function edit_profile()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
			'requireAuthorization' => true
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);

		$this->load->library('form_validation');
		$this->form_validation->set_rules('customer_id', lang('Customer ID'), 'trim|required|numeric');
		$phone = get_this('customers',['id'=>$this->input->post('customer_id')],'phone');
		$email = get_this('customers',['id'=>$this->input->post('customer_id')],'email');

        if($this->input->post('username') === "" || $this->input->post('username') != null)
            $this->form_validation->set_rules('username', lang('Username'), 'trim|required');
        if($this->input->post('img') === "")
            $this->form_validation->set_rules('img', lang('Personal Picture'), 'trim|required');
		
        if($this->input->post('phone') === "" || $this->input->post('phone') != null){
          if ($phone != $this->input->post('phone')) {
              $this->form_validation->set_rules('phone', lang('Phone Number'), 'trim|required|is_unique[customers.phone]|max_length[10]');
          }
        }
		
		if($this->input->post('email') === "" || $this->input->post('email') != null){
          if ($email != $this->input->post('email')) {
              $this->form_validation->set_rules('email', lang('Email'), 'trim|required|valid_email|is_unique[customers.email]');
          }
        }
		
        if($this->form_validation->run() === FALSE){
            if(form_error('customer_id'))
				$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 0);
            if(form_error('username'))
				$data[] = array('message'=> strip_tags(form_error('username')),"errNum" => 0);
			
				if(form_error('email')){
					if($this->input->post('email')==="" || !$this->input->post('email')){
						$data[] = array('message'=> strip_tags(form_error('email')),"errNum" => 0);
					}elseif($email){
						$data[] = array('message'=> strip_tags(form_error('email')),"errNum" => 2);
					}else{
						$data[] = array('message'=> strip_tags(form_error('email')),"errNum" => 1);
					}
				}
				if(form_error('phone')){
					if($this->input->post('phone')==="" || !$this->input->post('phone')){
						$data[] = array('message'=> strip_tags(form_error('phone')),"errNum" => 0);
					}elseif($phone){
						$data[] = array('message'=> strip_tags(form_error('phone')),"errNum" => 2);
					}else{
						$data[] = array('message'=> strip_tags(form_error('phone')),"errNum" => 1);
					}
				}

				if(form_error('img'))
				$data[] = array('message'=> strip_tags(form_error('img')),"errNum" => 1);

            $this->api_return([
					'message' => $data[0]['message'],
					'errNum' => $data[0]['errNum'],
					'status' => false
					],200);
        }else{
            $customer = get_this('customers',['id'=>$this->input->post('customer_id')]);
                 if ($customer) {
                     if ($customer['status'] == '1') {
                              $id = $customer['id'];
                              if ($this->input->post('img')) {
								  if($customer['img'] != ''){
									  @unlink('uploads/customers/'.$customer['img']);
								  }
                                  $image = $this->m_image->base64_upload($this->input->post('img'));
                                  $store['img'] = $image;
                              }  
                              if ($this->input->post('phone')!=$customer['phone']) {
								  //New Phone Number
									  //echo $this->input->post('phone')." -- " .$customer['phone'];die;
									  $code = generate_verification_code();
                                      $update = ['phone'=>$this->input->post('phone'),'activation_code' => $code,'status' => '0'];
                                      $this->Main_model->update('customers',['id'=>$id],$update);
									  $data['change_mobile'] = true;
                              }
							  else
							  $data['change_mobile'] = false;
							  $store['username'] = $this->input->post('username');
							  $store['email'] = $this->input->post('email');
                              $this->Main_model->update('customers',['id'=>$id],$store);
                              $customer_info = get_this('customers',['id'=>$id]);
                              $customer_info['img'] = base_url('uploads/customers/'.$customer_info['img']);
                              $data['customer_info'] = $customer_info;
							  
							 $payload = [
								'id' => $customer_info['id'],
								'phone' => $customer_info['phone'],
								'email' => $customer_info['email']
							];
							 // Load Authorization Library or Load in autoload config file
							$this->load->library('authorization_token');
							// generte a token
							$token = $this->authorization_token->generateToken($payload);
							  
                              $this->api_return([
								'message' => lang('Operation completed successfully'),
								'errNum' => 405,
								'status' => true,
								"result" => $data,
								'token' => $token
								],200);
                     }else{
						 $this->api_return([
							'message' => lang('Account Not Activated'),
							'errNum' => 401,
							'status' => false
							],200);
                     }
                 }else{
                     $this->api_return([
							'message' => lang('Sorry, there are no data for this user'),
							'errNum' => 402,
							'status' => false
							],200);
                 }
        }
	}
	
	public function add_to_favourite()
    {
        header("Access-Control-Allow-Origin: *");

        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
			'requireAuthorization' => true
        ]);

		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);

		$this->load->library('form_validation');
        $this->form_validation->set_rules('customer_id', lang('Customer ID'), 'trim|required|numeric');
        $this->form_validation->set_rules('mazad_id', lang('Mazad ID'), 'trim|required|numeric');
        if($this->form_validation->run() === FALSE){
            if(form_error('customer_id')){
				if($this->input->post('customer_id')==="" || !$this->input->post('customer_id')){
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 1);
				}
			}
			
            if(form_error('mazad_id')){
				if($this->input->post('mazad_id')==="" || !$this->input->post('mazad_id')){
					$data[] = array('message'=> strip_tags(form_error('mazad_id')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('mazad_id')),"errNum" => 1);
				}
			}
			
			$this->api_return([
					'message' => $data[0]['message'],
					'errNum' => $data[0]['errNum'],
					'status' => false
				],200);
        }else{
              $customer = get_this('customers',['id'=>$this->input->post('customer_id')]);
			  date_default_timezone_set('Asia/Riyadh');
               if ($customer) {
                   if ($customer['status'] == 1) {
                        $mazad = get_this('mazad',['id'=>$this->input->post('mazad_id')]);
                        if ($mazad) {
                            $added_befor = get_this('favourites',['customer_id'=>$this->input->post('customer_id'),'mazad_id'=>$this->input->post('mazad_id')]);
                           if ($added_befor) {
							   $data['message'] = lang('Sorry You have added this Mazad to Your Favorites List Before');
							   $data['errNum'] = 8;
							   $this->api_return([
							   'message' => lang('Sorry You have added this Mazad to Your Favorites List Before'),
								'errNum' => 8,
								'status' => false
								],200);
                           }else{
                               $store = [
                                          'customer_id'  => $this->input->post('customer_id'),
                                          'mazad_id' => $this->input->post('mazad_id'),
                                          'creation_date'     => date('Y-m-d'),
                                        ];
                                $insert = $this->Main_model->insert('favourites',$store);
                                if($insert){
                                    $this->api_return([
									'message' => lang('Successfully added'),
									'errNum' => 405,
									'status' => true,
									"result" => ""
									],200);
                                }else{
                                    $this->api_return([
									'message' => lang('Error in added'),
									'errNum' => 9,
									'status' => false
									],200);
                                }
                           }
                        }else{
                            $this->api_return([
									'message' => lang('Sorry, There Are No Mazad With This ID'),
									'errNum' => 5,
									'status' => false
								],200);
                        }
                       
                   }else{
                      $this->api_return([
									'message' => lang('Account Not Activated'),
									'errNum' => 401,
									'status' => false
								],200);
                   }
               }else{
                   $this->api_return([
						'message' => lang('Sorry, there are no data for this user'),
						'errNum' => 402,
						'status' => false
						],200);
               }
        }
	}
	
	public function remove_from_favourite()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
			'requireAuthorization' => true
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);

		$this->load->library('form_validation');
        $this->form_validation->set_rules('customer_id', lang('Customer ID'), 'trim|required|numeric');
        $this->form_validation->set_rules('mazad_id', lang('Mazad ID'), 'trim|required|numeric');
        if($this->form_validation->run() === FALSE){
            if(form_error('customer_id')){
				if($this->input->post('customer_id')==="" || !$this->input->post('customer_id')){
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 1);
				}
			}
			
            if(form_error('mazad_id')){
				if($this->input->post('mazad_id')==="" || !$this->input->post('mazad_id')){
					$data[] = array('message'=> strip_tags(form_error('mazad_id')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('mazad_id')),"errNum" => 1);
				}
			}
			
            $this->api_return([
				'message' => $data[0]['message'],
				'errNum' => $data[0]['errNum'],
				'status' => false
				],200);
        }else{
              $customer = get_this('customers',['id'=>$this->input->post('customer_id')]);
               if ($customer) {
                   if ($customer['status'] == 1) {
                           $added_befor = get_this('favourites',['customer_id'=>$this->input->post('customer_id'),'mazad_id'=>$this->input->post('mazad_id')]);
                           if ($added_befor) {
                                $where['customer_id'] = $added_befor['customer_id'];
                                $where['mazad_id'] = $added_befor['mazad_id'];
                                $this->db->where($where)->delete('favourites');
                                $this->api_return([
									'message' => lang('Successfully Deleted'),
									'errNum' => 405,
									'status' => true,
									"result" => ""
									],200);
                           }else{
                               $this->api_return([
									'message' => lang('Sorry this Mazad is not on your favorite list'),
									'errNum' => 5,
									'status' => false
									],200);
                           }  
                   }else{
                       $this->api_return([
									'message' => lang('Account Not Activated'),
									'errNum' => 401,
									'status' => false
								],200);
                   }
               }else{
                  $this->api_return([
						'message' => lang('Sorry, there are no data for this user'),
						'errNum' => 402,
						'status' => false,
						"result" => $data
					],200);
               }
        }
		
	}
	
	public function my_favourite()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
			'requireAuthorization' => true
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);

		$this->load->library('form_validation');
		$this->form_validation->set_rules('customer_id', lang('Customer ID'), 'required|numeric');
		$this->form_validation->set_rules('limit', lang('Number of visible elements'), 'trim|required|numeric');
		$this->form_validation->set_rules('page_number', lang('Page Number'), 'trim|required|numeric');
        if($this->form_validation->run() === FALSE){
            if(form_error('customer_id')){
				if($this->input->post('customer_id')==="" || !$this->input->post('customer_id')){
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 1);
				}
			}
			
            if(form_error('limit')){
				if($this->input->post('limit')==="" || !$this->input->post('limit')){
					$data[] = array('message'=> strip_tags(form_error('limit')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('limit')),"errNum" => 1);
				}
			}
			
            if(form_error('page_number')){
				if($this->input->post('page_number')==="" || !$this->input->post('page_number')){
					$data[] = array('message'=> strip_tags(form_error('page_number')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('page_number')),"errNum" => 1);
				}
			}
			 
            $this->api_return([
				'message' => $data[0]['message'],
				'errNum' => $data[0]['errNum'],
				'status' => false
			],200);
        }else{
          $customer = get_this('customers',['id'=>$this->input->post('customer_id')]);
               if ($customer) {
                   if ($customer['status'] == 1) {
						   $total = $this->data->get_table_data('favourites',array('customer_id'=>$this->input->post('customer_id')));
						   $offset = $this->input->post('limit') * $this->input->post('page_number');
                           $where['favourites.customer_id'] = $this->input->post('customer_id');
                           $favourites = $this->db->select('*')
                                                  ->order_by('favourites.creation_date','DESC')
                                                  //->group_by('mazad_id')
                                                  ->join('favourites','mazad_id=mazad.id')
                                                  ->get_where('mazad',$where, $this->input->post('limit'), $offset)
                                                  ->result();
							//echo $this->db->last_query();die;
                           if ($favourites) {
                               foreach ($favourites as $item) {
								//$product = get_this('products',['id' =>$item->product_id]);
								if($lang=='arabic' || $lang=="" || $lang !="english"){
									$this->db->select('id, name_ar as name, desc_ar as desc, img, default_price, creation_date');
									$this->db->where('id', $item->product_id);
									$product_detailes = $this->db->get('products')->row_array();
									$product_detailes['img'] = base_url('uploads/customers/'.$product_detailes['img']);
									//print_r($product_detailes);die;
								}else{
									$this->db->select('id, name_en as name, desc_en as desc, img, default_price, creation_date');
									$this->db->where('id', $item->product_id);
									$product_detailes = $this->db->get('products')->row_array();
									$product_detailes['img'] = base_url('uploads/customers/'.$product_detailes['img']);
								}
								//Select Max Price For Mazad
								$this->db->select_max('price');
								$this->db->where('mazad_id', $item->mazad_id);
								$max_price = $this->db->get('mazad_subscribers')->row_array();
								if(!$max_price['price']){$max_price['price']='0';}
								//Strip Tags From Content
								$product_detailes['desc'] = strip_tags(trim(preg_replace('/\s\s+/', ' ', $product_detailes['desc'])));
                                 $result[] = [
                                                'mazad_id'         => $item->mazad_id,
                                                'customer_id'        => $item->customer_id,
                                                'product'        => $product_detailes,
                                                'mazad'        => get_this('mazad',['id'=>$item->mazad_id]),
                                                'max_price'        => $max_price['price']
                                             ];  
                               }
                               if($result){
								 $total = count($total);
                                 //$data['my_favourite'] = $result;
								 $data = $result;
                                 $this->api_return([
									'message' => lang('Operation completed successfully'),
									'errNum' => 405,
									'status' => true,
									'total' => $total,
									"result" => $data
								],200);
                               }
                           }else{
							 $data = array();
                             $this->api_return([
								'message' => lang('Sorry, you do not have any Mazad on your favorite list'),
								'errNum' => 5,
								'total' => 0,
								'status' => true,
								"result" => $data
							],200);
                           } 
                       
                   }else{
                       $this->api_return([
							'message' => lang('Account Not Activated'),
							'errNum' => 401,
							'status' => false
						],200);
                   }
               }else{
                   $this->api_return([
						'message' => lang('Sorry, there are no data for this user'),
						'errNum' => 402,
						'status' => false
					],200);
               }                 
        }
	}
	
	public function pages()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
			'requireAuthorization' => true
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);
		
		if($lang=='arabic' || $lang=="" || $lang!="english"){
			$this->db->select('id, title_ar as title');
			$this->db->where('active','1');
			$pages = $this->db->get('pages')->result_array();
		}else{
			$this->db->select('id, title_en as title');
			$this->db->where('active','1');
			$pages = $this->db->get('pages')->result_array();
		}
		
		//$pages = get_table('pages',['active'=>'1'],['id','title_ar']);
		if ($pages) {	
        foreach ($pages as $page) {
          $result[] = $page;
        }
		
		//print_r($result);die;
            if ($result) {
              $data['pages'] = $result;
              $this->api_return([
						'message' => lang('Operation completed successfully'),
						'errNum' => 405,
						'status' => true,
						"result" => $data
					],200);
            }
      }else{
        $data['pages'] = [];
        $this->api_return([
				'message' => lang('Sorry, you do not have any pages stored in the database'),
				'errNum' => 5,
				'status' => true,
				"result" => $data
				],200);
       }
	}
	
	public function page()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
			//'requireAuthorization' => true
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);

		$this->load->library('form_validation');
        $this->form_validation->set_rules('page_id', lang('Page ID'), 'required|numeric');
        if($this->form_validation->run() === FALSE){
            if(form_error('page_id')){
                if($this->input->post('page_id')==="" || !$this->input->post('page_id')){
					$data[] = array('message'=> strip_tags(form_error('page_id')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('page_id')),"errNum" => 1);
				}
			}
			$this->api_return([
				'message' => $data[0]['message'],
				'errNum' => $data[0]['errNum'],
				'status' => false
			],200);
        }else{
            $page = get_this('pages',['id'=>$this->input->post('page_id'),'active'=>'1']);
            if ($page) {
                  $result = [
                                  'page_id' => $page['id'],
								  'title_ar'   => $page['title_ar'],
								  'title_en'   => $page['title_en'],
                                  'content_ar' => strip_tags(trim(preg_replace('/\s\s+/', ' ', $page['content_ar']))),
                                  'content_en' => strip_tags(trim(preg_replace('/\s\s+/', ' ', $page['content_en'])))
                              ];
                 if ($result) {
					  if($lang=='arabic' || $lang=="" || $lang!="english"){
							unset($result['title_en']);
							unset($result['content_en']);
							//Rename Fields Of array To be Same Name With Out Lang Name
							$result['title'] = $result['title_ar'];
							$result['content'] = $result['content_ar'];
							unset($result['title_ar']);
							unset($result['content_ar']);
							///////////////////////////////////////////////////////////////
					  }else{
						  unset($result['title_ar']);
						  unset($result['content_ar']);
						  //Rename Fields Of array To be Same Name With Out Lang Name
							$result['title'] = $result['title_en'];
							$result['content'] = $result['content_en'];
							unset($result['title_en']);
							unset($result['content_en']);
							///////////////////////////////////////////////////////////////
					  }
                      $data['page'] = $result;
                      $this->api_return([
						'message' => lang('Operation completed successfully'),
						'errNum' => 405,
						'status' => true,
						"result" => $data
					],200);
                 }
            }else{
                $data['page'] = [];
                $this->api_return([
						'message' => lang('Sorry, there are no pages for this ID'),
						'errNum' => 5,
						'status' => false
						//"result" => $data
					],200);
            } 
        }
	}
	
	public function tickets_types()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
			'requireAuthorization' => true
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);
		
		if($lang=='arabic' || $lang=="" || $lang!="english"){
			$this->db->select('id, name_ar as name,color');
			$tickets_types = $this->db->get('tickets_types')->result_array();
		}else{
			$this->db->select('id, name_en as name,color');
			$tickets_types = $this->db->get('tickets_types')->result_array();
		}

		//$tickets_types = get_table('tickets_types');
		
		if ($tickets_types) {
        foreach ($tickets_types as $method) {
          $result[] = $method;
        }
            if ($result) {
              $data['tickets_types'] = $result;
              $this->api_return([
						'message' => lang('Operation completed successfully'),
						'errNum' => 405,
						'status' => true,
						"result" => $data
					],200);
            }
      }else{
        $data['tickets_types'] = [];
        $this->api_return([
						'message' => lang('Sorry, there are no types of tickets stored in the database'),
						'errNum' => 5,
						'status' => true,
						"result" => $data
					],200);
       }
	}
	
	public function new_ticket()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
			'requireAuthorization' => true
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);

		$this->load->library('form_validation');
        $this->form_validation->set_rules('customer_id', lang('Customer ID'), 'trim|required|numeric');
        $this->form_validation->set_rules('ticket_type_id', lang('Ticket Type'), 'trim|required|numeric');
        $this->form_validation->set_rules('title', lang('Title'), 'trim|required');
        $this->form_validation->set_rules('content', lang('Content'), 'trim|required');
        if($this->form_validation->run() === FALSE){
            if(form_error('customer_id')){
				if($this->input->post('customer_id')==="" || !$this->input->post('customer_id')){
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 1);
				}
			}
			
            if(form_error('ticket_type_id')){
				if($this->input->post('ticket_type_id')==="" || !$this->input->post('ticket_type_id')){
					$data[] = array('message'=> strip_tags(form_error('ticket_type_id')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('ticket_type_id')),"errNum" => 1);
				}
			}
			
			if(form_error('title'))
				$data[] = array('message'=> strip_tags(form_error('title')),"errNum" => 0);
			
            if(form_error('content'))
				$data[] = array('message'=> strip_tags(form_error('content')),"errNum" => 0);
            $this->api_return([
						'message' => $data[0]['message'],
						'errNum' => $data[0]['errNum'],
						'status' => false
					],200);
        }else{
               $customer = get_this('customers',['id'=>$this->input->post('customer_id')]);
               if ($customer) {
                   if ($customer['status'] == '1') {
						$ticket_type = get_this('tickets_types',['id'=>$this->input->post('ticket_type_id')]);
						if($ticket_type){
							date_default_timezone_set('Asia/Riyadh');
                            $store = [
                                        'created_by'     => $this->input->post('customer_id'),
                                        'ticket_type_id' => $this->input->post('ticket_type_id'),
                                        'title'        => $this->input->post('title'),
                                        'content'        => $this->input->post('content'),
                                        'created_at'     => date('Y-m-d'),
                                        'time'     => date('h:i:s'),
                                        'type'           => 1
                                      ];
                            $insert = $this->Main_model->insert('tickets',$store);
                            if($insert){
                                $this->api_return([
										'message' => lang('Ticket successfully created'),
										'errNum' => 405,
										'status' => true,
										"result" => ""
									],200);
                            }else{
                                $this->api_return([
										'message' => lang('Error in added'),
										'errNum' => 9,
										'status' => false
									],200);
                            }
						}else{
							$this->api_return([
							   'message' => lang('No Tickets Types With This Id'),
								'errNum' => 5,
								'status' => false
							],200);
						}
                       
                   }else{
							   $this->api_return([
							   'message' => lang('Account Not Activated'),
								'errNum' => 401,
								'status' => false
							],200);
                   }
               }else{
                   $this->api_return([
						'message' => lang('Sorry, there are no data for this user'),
						'errNum' => 402,
						'status' => false
					],200);
               }
        }
	}
	
	public function new_reply()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
			'requireAuthorization' => true
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);

		$this->load->library('form_validation');
        $this->form_validation->set_rules('ticket_id', lang('Ticket ID'), 'trim|required|numeric');
        $this->form_validation->set_rules('customer_id', lang('Customer ID'), 'trim|required|numeric');
        $this->form_validation->set_rules('content', lang('Content'), 'trim|required');
        if($this->form_validation->run() === FALSE){
            if(form_error('ticket_id')){
				if($this->input->post('ticket_id')==="" || !$this->input->post('ticket_id')){
					$data[] = array('message'=> strip_tags(form_error('ticket_id')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('ticket_id')),"errNum" => 1);
				}
			}
			
            if(form_error('customer_id')){
				if($this->input->post('customer_id')==="" || !$this->input->post('customer_id')){
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 1);
				}
			}
			
            if(form_error('content'))
				$data[] = array('message'=> strip_tags(form_error('content')),"errNum" => 0);
            $this->api_return([
						'message' => $data[0]['message'],
						'errNum' => $data[0]['errNum'],
						'status' => false
					],200);
        }else{
              $customer = get_this('customers',['id'=>$this->input->post('customer_id')]);
               if ($customer) {
                   if ($customer['status'] == '1') {
                            $ticket = get_this('tickets',['id'=>$this->input->post('ticket_id')]);
                            if ($ticket) {
								date_default_timezone_set('Asia/Riyadh');
                                $store = [
                                      'created_by' => $this->input->post('customer_id'),
                                      'ticket_id'  => $this->input->post('ticket_id'),
                                      'content'    => $this->input->post('content'),
                                      'created_at' => date('Y-m-d'),
                                      'reply_type' => 1,
                                      'created_at' => date('Y-m-d'),
                                      'time'       => date('H:i:s')
                                    ];
                                $insert = $this->Main_model->insert('tickets_replies',$store);
								
								//Update action to Unread ticket For Admin Panel
								$update['status_id'] = 0;
								$update['updated_at'] = date('Y-m-d');
								$this->Main_model->update('tickets',['id'=>$this->input->post('ticket_id')],$update);
                                //////////////////////////////////////////////////////////////
								
								if($insert){
									$tickets_replies = get_this('tickets_replies',['id' => $insert]);
									//print_r($tickets_replies);die;

										$replies = [
											'id'=> $tickets_replies['id'],
                                            'created_at' => $tickets_replies['created_at'],
                                            'time'       => $tickets_replies['time'],
                                            'content'    => $tickets_replies['content'],
											'sender'	=>get_this('customers',['id' =>$tickets_replies['created_by']],'username')
										];

									$data['replies'] = $replies;
                                    $this->api_return([
											'message' => lang('Your reply has been sent successfully'),
											'errNum' => 405,
											'status' => true,
											"result" => $data
										],200);
                                }else{
                                    $this->api_return([
											'message' => lang('Error In Sending'),
											'errNum' => 9,
											'status' => false
										],200);
                                }
                            }else{
                                $this->api_return([
										'message' => lang('Sorry there are no tickets for this number'),
										'errNum' => 5,
										'status' => false
									],200);
                            }
                       
                   }else{
                       $this->api_return([
									'message' => lang('Account Not Activated'),
									'errNum' => 401,
									'status' => false
								],200);
                   }
               }else{
                   $this->api_return([
						'message' => lang('Sorry, there are no data for this user'),
						'errNum' => 402,
						'status' => false
					],200);
               }
        }
	}
	
	public function tickets()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
			'requireAuthorization' => true
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);

		$this->load->library('form_validation');
		$this->form_validation->set_rules('customer_id', lang('Customer ID'), 'trim|required|numeric');
		$this->form_validation->set_rules('limit', lang('Number of visible elements'), 'trim|required|numeric');
		$this->form_validation->set_rules('page_number', lang('Page Number'), 'trim|required|numeric');
		if($this->form_validation->run() === FALSE){
            if(form_error('customer_id')){
				if($this->input->post('customer_id')==="" || !$this->input->post('customer_id')){
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 1);
				}
			}
			
            if(form_error('limit')){
				if($this->input->post('limit')==="" || !$this->input->post('limit')){
					$data[] = array('message'=> strip_tags(form_error('limit')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('limit')),"errNum" => 1);
				}
			}
			
            if(form_error('page_number')){
				if($this->input->post('page_number')==="" || !$this->input->post('page_number')){
					$data[] = array('message'=> strip_tags(form_error('page_number')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('page_number')),"errNum" => 1);
				}
			}
            $this->api_return([
						'message' => $data[0]['message'],
				'		errNum' => $data[0]['errNum'],
						'status' => false
					],200);
        }else{
          $user_info = get_this('customers',['id' => $this->input->post('customer_id')]);
          if ($user_info) {
			  $total = get_this_limit('tickets',['created_by'=>$user_info['id'],'type'=>'1']);
              if ($user_info['status'] == '1') {
                      $offset = $this->input->post('limit') * $this->input->post('page_number');
                      $where['created_by'] = $user_info['id'];
                      $where['type'] = 1;
                      $tickets = $this->db->order_by('created_at','DESC')
										  //->select('id, title_ar')
                                          ->get_where('tickets',$where,$this->input->post('limit'),$offset)
                                          ->result();
                      if ($tickets) {
						
                        foreach ($tickets as $ticket) {
						$color = get_this('tickets_types',['id' => $ticket->ticket_type_id],'color');
						if($lang=='arabic' || $lang=="" || $lang!="english"){
							$type = get_this('tickets_types',['id' => $ticket->ticket_type_id],'name_ar');
						}else{
							$type = get_this('tickets_types',['id' => $ticket->ticket_type_id],'name_en');
						}
                          $result[] = [
                                            'id'      => $ticket->id,
                                            'title'   => $ticket->title,
                                            'type'   => $type,
                                            'color'   => $color,
                                            'content' => strip_tags(trim(preg_replace('/\s\s+/', ' ', $ticket->content))),
                                            'created_at' => $ticket->created_at
                                      ];
                        }
                        
						
						if($lang=='arabic' || $lang=="" || $lang!="english"){
						}else{
						}
						$total = count($total);
						if ($result) {
                                  $data['my_tickets'] = $result;
                                  $this->api_return([
										'message' => lang('Operation completed successfully'),
										'errNum' => 405,
										'status' => true,
										'total' => $total,
										"result" => $data
									],200);
                              }
						}else{
							$data['my_tickets'] = [];
                            $this->api_return([
									'message' => lang('Sorry, there are no special tickets for you'),
									'errNum' => 5,
									'status' => true,
									"result" => $data
								],200);
                     } 

              }else{
                  $this->api_return([
						'message' => lang('Account Not Activated'),
						'errNum' => 401,
						'status' => false
					],200);
              }
          }else{
                   $this->api_return([
						'message' => lang('Sorry, there are no data for this user'),
						'errNum' => 402,
						'status' => false
					],200);
          }
        }
	}
	
	public function ticket()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
			'requireAuthorization' => true
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);

		$this->load->library('form_validation');
        $this->form_validation->set_rules('customer_id', lang('Customer ID'), 'required|numeric');
        $this->form_validation->set_rules('ticket_id', lang('Ticket ID'), 'required|numeric');
        if($this->form_validation->run() === FALSE){
            if(form_error('customer_id')){
				if($this->input->post('customer_id')==="" || !$this->input->post('customer_id')){
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 1);
				}
			}
			
            if(form_error('ticket_id')){
				if($this->input->post('ticket_id')==="" || !$this->input->post('ticket_id')){
					$data[] = array('message'=> strip_tags(form_error('ticket_id')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('ticket_id')),"errNum" => 1);
				}
			}
			 
            $this->api_return([
						'message' => $data[0]['message'],
						'errNum' => $data[0]['errNum'],
						'status' => false
					],200);
        }else{
          $user_info = get_this('customers',['id' =>$this->input->post('customer_id')]);
          if ($user_info) {
              if ($user_info['status'] == '1') {
                      $ticket = get_this('tickets',['id'=>$this->input->post('ticket_id'),'created_by'=>$this->input->post('customer_id'),'type'=>1]);
                      if ($ticket) {
							$color = get_this('tickets_types',['id' => $ticket['ticket_type_id']],'color');
							if($lang=='arabic' || $lang=="" || $lang!="english"){
								$type = get_this('tickets_types',['id' => $ticket['ticket_type_id']],'name_ar');
							}else{
								$type = get_this('tickets_types',['id' => $ticket['ticket_type_id']],'name_en');
							}
                            $result = [
                                            'ticket_id' => $ticket['id'],
                                            'title' => $ticket['title'],
                                            'type'     => $type,
                                            'color'     => $color,
                                            'content'   => strip_tags(trim(preg_replace('/\s\s+/', ' ', $ticket['content']))),
                                            'created_at'   => $ticket['created_at']
                                        ];
                           if ($result) {
                                $data['ticket_info']['ticket'] = $result;
                                $ticket_replies = get_table('tickets_replies',['ticket_id'=>$ticket['id']]);
                                $replies = [];
								$replies[0] = [
                                            'id' => $ticket['id'],
											'created_at'   => $ticket['created_at'],
											'time' => $ticket['time'],
											'content'   => strip_tags(trim(preg_replace('/\s\s+/', ' ', $ticket['content']))),
                                            'sender'     => get_this('customers',['id' =>$user_info['id']],'username')
                                        ];
								//$data['ticket_info']['ticket_replies'][0] = $first_replie;
								//strip_tags(preg_replace('/\s\s+/', ' ',$reply->content)),
                                if ($ticket_replies) {
                                  foreach ($ticket_replies as $reply) {
                                            $replies[] =[
                                                          'id'         => $reply->id,
                                                          'created_at' => $reply->created_at,
                                                          'time'       => $reply->time,
                                                          'content'    => strip_tags(trim(preg_replace('/\s\s+/', ' ', $reply->content))),
                                                          'sender'     => ($reply->reply_type == '0') ? 'خدمة العملاء' : get_this('customers',['id' => $reply->created_by],'username')
                                                        ]; 
                                 }
                                 $data['ticket_info']['replies_number'] = get_table('tickets_replies',['ticket_id'=>$ticket['id']],'count')+1;
                                 $data['ticket_info']['ticket_replies'] = $replies;
                                }else{
									$data['ticket_info']['replies_number']=1;
                                  $data['ticket_info']['ticket_replies'] = $replies;
                                }
                                $this->api_return([
										'message' => lang('Operation completed successfully'),
										'errNum' => 405,
										'status' => true,
										"result" => $data
									],200);
                           }
                      }else{
                          $data['ticket'] = [];
                          $this->api_return([
									'message' => lang('Sorry, there are no tickets with this ID'),
									'errNum' => 5,
									'status' => false
									//"result" => $data
								],200);
                      } 
              }else{
                  $this->api_return([
						'message' => lang('Account Not Activated'),
						'errNum' => 401,
						'status' => false
					],200);
              }
          }else{
                   $this->api_return([
						'message' => lang('Sorry, there are no data for this user'),
						'errNum' => 402,
						'status' => false
					],200);
          }
        }
	}
	
	public function exchange()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
			'requireAuthorization' => true
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);

		$this->load->library('form_validation');
        $this->form_validation->set_rules('price', lang('Product price'), 'required|numeric');
        $this->form_validation->set_rules('currency', lang('Currency Type'), 'trim|required');
		if($this->form_validation->run() === FALSE){
            if(form_error('price')){
				if($this->input->post('price')==="" || !$this->input->post('price')){
					$data[] = array('message'=> strip_tags(form_error('price')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('price')),"errNum" => 1);
				}
			}
			
			if(form_error('currency'))
				$data[] = array('message'=> strip_tags(form_error('currency')),"errNum" => 0);
            $this->api_return([
						'message' => $data[0]['message'],
						'errNum' => $data[0]['errNum'],
						'status' => false
					],200);
        }else{
			$exchange = get_this('site_info',['id'=>1],'exchange_to_sar');
			if ($exchange) {
			if($this->input->post('currency')=='SAR'){
				$exchange_price = $this->input->post('price') * $exchange;
				$data['USD_To_SAR'] = $exchange_price;
			}else{
				$exchange_price = $this->input->post('price') / $exchange;
				$data['SAR_To_USD'] = $exchange_price;
			}
			//$data['price'] = $exchange_price;
                  $this->api_return([
						'message' => lang('Operation completed successfully'),
						'errNum' => 405,
						'status' => true,
						"result" => $data
					],200);
			}else{
                  $this->api_return([
						'message' => lang('Sorry, there is no value for the riyal in dollars'),
						'errNum' => 5,
						'status' => false
					],200);
			}
		}
	}
	
	public function share()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
			'requireAuthorization' => true
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);

		$this->load->library('form_validation');
        $this->form_validation->set_rules('code', lang('Invitation Code'), 'required|numeric|min_length[6]|max_length[6]');
		$this->form_validation->set_rules('customer_id', lang('Customer ID'), 'required|numeric');
		if($this->form_validation->run() === FALSE){
            if(form_error('code')){
				if($this->input->post('code')==="" || !$this->input->post('code')){
					$data[] = array('message'=> strip_tags(form_error('code')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('code')),"errNum" => 1);
				}
			}
			
			if(form_error('customer_id')){
				if($this->input->post('customer_id')==="" || !$this->input->post('customer_id')){
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 1);
				}
			}
			
            $this->api_return([
						'message' => $data[0]['message'],
						'errNum' => $data[0]['errNum'],
						'status' => false
					],200);
        }else{
			$user_info = get_this('customers',['id' =>$this->input->post('customer_id')]);
			if ($user_info) {
				if ($user_info['status'] == '1') {
				$share = get_this('customers',['id' =>$this->input->post('customer_id'),'invitation_code'=>$this->input->post('code')],'invitation_count');
					if(isset($share)){
						if ($share!=0) {
						$invitation_points = get_this('site_info',['id'=>1],'invitation_points');
						$total = $share - 1;
						$points = $user_info['points'] + $invitation_points;
						$update = ['invitation_count' => $total,'points' => $points];
						$this->Main_model->update('customers',['id'=>$this->input->post('customer_id')],$update);
							  $this->api_return([
									'message' => lang('A post has been made and a point deducted from your calling points'),
									'errNum' => 405,
									'status' => true,
									"result" => $data
								],200);
						}else{
							  $this->api_return([
									'message' => lang('Sorry there are no points to participate'),
									'errNum' => 5,
									'status' => false
								],200);
						}
					}else{
						  $this->api_return([
								'message' => lang('Invitation code is incorrect'),
								'errNum' => 10,
								'status' => false
							],200);
					}
				}else{
                  $this->api_return([
						'message' => lang('Account Not Activated'),
						'errNum' => 401,
						'status' => false
					],200);
              }
          }else{
                   $this->api_return([
						'message' => lang('Sorry, there are no data for this user'),
						'errNum' => 402,
						'status' => false
					],200);
          }
		}
	}
	
	public function social_login()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);

		$this->load->library('form_validation');
        $this->form_validation->set_rules('social_name', lang('Type of registration'), 'trim|required');
        $this->form_validation->set_rules('username', lang('Username'), 'trim|required');
		$this->form_validation->set_rules('email', lang('Email'), 'trim|valid_email');
        $this->form_validation->set_rules('social_id', lang('Social ID'), 'trim|required');
        $this->form_validation->set_rules('device_reg_id', lang('Device Reg ID'), 'trim|required');
        if($this->form_validation->run() === FALSE){
            if(form_error('social_name'))
				$data[] = array('message'=> strip_tags(form_error('social_name')),"errNum" => 0);
			if(form_error('username'))
				$data[] = array('message'=> strip_tags(form_error('username')),"errNum" => 0);
            if(form_error('email')){
				if($this->input->post('email')==="" || !$this->input->post('email')){
					$data[] = array('message'=> strip_tags(form_error('email')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('email')),"errNum" => 1);
				}
			}
			
            if(form_error('social_id'))
				$data[] = array('message'=> strip_tags(form_error('social_id')),"errNum" => 0);
            if(form_error('device_reg_id'))
				$data[] = array('message'=> strip_tags(form_error('device_reg_id')),"errNum" => 0);
            $this->api_return([
				'message' => $data[0]['message'],
				'errNum' => $data[0]['errNum'],
				'status' => false
			],200);
        }else{
            $customer_info = get_this('customers',['social_id'=>$this->input->post('social_id'),'social_name'=>$this->input->post('social_name')]);
			//print_r($customer_info);die;
            if ($customer_info) {
				//update info token
				$social_id = $this->input->post('social_id');
				$device_reg_id = $this->input->post('device_reg_id');
                $update = ['device_reg_id' => $device_reg_id];
				$this->Main_model->update('customers',['id'=>$customer_info['id']],$update);
				
				unset($customer_info['img']);
				$img = get_this('customers',['id'=>$customer_info['id']],'img');
				//echo file_exists($_SERVER['DOCUMENT_ROOT'].'/uploads/customers/'.$img);die;
				if($img!=""){
					if(file_exists($_SERVER['DOCUMENT_ROOT'].'/uploads/customers/'.$img)){
						$customer_info['img'] = base_url('uploads/customers/'.$img);
					}else{
						$customer_info['img'] = base_url('uploads/customers/avatar.png');
					}
				}else{
					$customer_info['img'] = base_url('uploads/customers/avatar.png');
				}
				
				$data['customer_info'] = $customer_info;
				
				
				
				$payload = [
					'id' => $customer_info['id'],
					'phone' => $customer_info['phone'],
					'email' => $customer_info['email']
				];
				// Load Authorization Library or Load in autoload config file
				$this->load->library('authorization_token');
				// generte a token
				$token = $this->authorization_token->generateToken($payload);
							  
	                  $this->api_return([
							'message' => lang('Operation completed successfully'),
							'errNum' => 405,
							'status' => true,
							"result" => $data,
							'token' => $token
						],200);
            }else{
				//insert new account
				
                $activation_code = generate_verification_code();
				$invitation_code = generate_verification_code();
				
				//Generate Code If Exist Before
				$activation = get_this('customers',['activation_code'=>$activation_code]);
				$invitation = get_this('customers',['invitation_code'=>$invitation_code]);
				if($activation){$activation_code = generate_verification_code();}
				if($invitation){$invitation_code = generate_verification_code();}
				
				/*if($this->input->post('phone')!==null || $this->input->post('phone')!=""){
					$phone = $this->input->post('phone');
					$customer_phone = get_this('customers',['phone'=>$this->input->post('phone')]);
					if($customer_phone){
						$regiset_phone = 1;
					}
					else{
						$regiset_phone = 0;
					}
				}
				else{
					$phone = '';
				}*/
				
				//echo $regiset_phone;die;
				//if($regiset_phone == 0)
				//{
					if($this->input->post('phone')==="" || !$this->input->post('phone')){
						$phone = '';
					}else{
						$phone = $this->input->post('phone');
					}
					
					if($this->input->post('email')==="" || !$this->input->post('email')){
						$email = '';
					}else{
						$email = $this->input->post('email');
					}
					
					$invitation_count = get_this('site_info',['id'=>1],'invitation_count');
					date_default_timezone_set('Asia/Riyadh');
					$store = [
							  'username'          	=> $this->input->post('username'),
							  'email'          		=> $email,
							  'phone'               => $phone,
							  'points'             	=> '0',
							  'status'             	=> '1',
							  'activation_code'    	=> $activation_code,
							  'invitation_code'    	=> $invitation_code,
							  'invitation_count'    => $invitation_count,
							  'alarm_near'    		=> '0',
							  'alarm_finished'    	=> '0',
							  'social_name'    		=> $this->input->post('social_name'),
							  'social_id'    		=> $this->input->post('social_id'),
							  'device_reg_id'    	=> $this->input->post('device_reg_id'),
							  'creation_date'       => date('Y-m-d H:i:s')
							];
					 $insert = $this->Main_model->insert('customers',$store);
					
					//Invitation Code If Found
					 $code = $this->input->post('code');
					 $res_cus = get_this('customers',['invitation_code'=>$code]);
					 if($res_cus){
						 if($res_cus['invitation_count']>0){
							$updates['invitation_count'] = $res_cus['invitation_count'] - 1;
							$update = $this->Main_model->update('customers',['id'=>$res_cus['id']],$updates);
						 }
					 }
					 ////////////////////////////////////////////////////////////////////////////////////////					
					
					 if($insert){
						  $customer_info = get_this('customers',['id' => $insert]);
						
							unset($customer_info['img']);
							$img = get_this('customers',['id'=>$customer_info['id']],'img');
							//echo file_exists($_SERVER['DOCUMENT_ROOT'].'/uploads/customers/'.$img);die;
							if($img!=""){
								if(file_exists($_SERVER['DOCUMENT_ROOT'].'/uploads/customers/'.$img)){
									$customer_info['img'] = base_url('uploads/customers/'.$img);
								}else{
									$customer_info['img'] = base_url('uploads/customers/avatar.png');
								}
							}else{
								$customer_info['img'] = base_url('uploads/customers/avatar.png');
							}
						
						  $data['customer_info'] = $customer_info;
						  
						  $payload = [
							'id' => $customer_info['id'],
							'phone' => $customer_info['phone'],
							'email' => $customer_info['email']
							];
							// Load Authorization Library or Load in autoload config file
							$this->load->library('authorization_token');
							// generte a token
							$token = $this->authorization_token->generateToken($payload);

						  $this->api_return([
								'message' => lang('successfully registered'),
								'errNum' => 405,
								'status' => true,
								"result" => $data,
								'token' => $token
							],200);
					 }else{
						  $this->api_return([
							'message' => lang('An error in the register'),
							'errNum' => 4,
							'status' => false
						],200);
					 }
				/*}else{
					$data['message'] = lang('Sorry phone number registered');
					$data['errNum'] = 2;
					$this->api_return([
							'status' => false,
							"result" => $data
						],200);
				}*/
            } 
        }
	}
	
	public function alarm_near()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
			'requireAuthorization' => true
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);

		$this->load->library('form_validation');
        $this->form_validation->set_rules('alarm_near', lang('The value of the alarm'), 'required|numeric|max_length[1]');
		$this->form_validation->set_rules('customer_id', lang('Customer ID'), 'required|numeric');
		if($this->form_validation->run() === FALSE){
            if(form_error('alarm_near')){
				if($this->input->post('alarm_near')==="" || !$this->input->post('alarm_near')){
					$data[] = array('message'=> strip_tags(form_error('alarm_near')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('alarm_near')),"errNum" => 1);
				}
			}
			
			if(form_error('customer_id')){
				if($this->input->post('customer_id')==="" || !$this->input->post('customer_id')){
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 1);
				}
			}
			
            $this->api_return([
						'message' => $data[0]['message'],
						'errNum' => $data[0]['errNum'],
						'status' => false
					],200);
        }else{
			$user_info = get_this('customers',['id' =>$this->input->post('customer_id')]);
			if ($user_info) {
				if ($user_info['status'] == '1') {
						$alarm_near = $this->input->post('alarm_near');
						$update = ['alarm_near' => $alarm_near];
						$this->Main_model->update('customers',['id'=>$this->input->post('customer_id')],$update);
							  $this->api_return([
									'message' => lang('Successfully updated'),
									'errNum' => 405,
									'status' => true,
									"result" => ""
								],200);
						
				}else{
                  $this->api_return([
						'message' => lang('Account Not Activated'),
						'errNum' => 401,
						'status' => false
					],200);
              }
          }else{
                   $this->api_return([
						'message' => lang('Sorry, there are no data for this user'),
						'errNum' => 402,
						'status' => false
					],200);
          }
		}
	}
	
	public function alarm_finished()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
			'requireAuthorization' => true
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);

		$this->load->library('form_validation');
        $this->form_validation->set_rules('alarm_finished', 'قيمة التنبيه', 'required|numeric|max_length[1]');
		$this->form_validation->set_rules('customer_id', 'رقم المستخدم', 'required|numeric');
		if($this->form_validation->run() === FALSE){
            if(form_error('alarm_finished')){
				if($this->input->post('alarm_finished')==="" || !$this->input->post('alarm_finished')){
					$data[] = array('message'=> strip_tags(form_error('alarm_finished')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('alarm_finished')),"errNum" => 1);
				}
			}
			
			if(form_error('customer_id')){
				if($this->input->post('customer_id')==="" || !$this->input->post('customer_id')){
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 1);
				}
			}
			
            $this->api_return([
						'message' => $data[0]['message'],
						'errNum' => $data[0]['errNum'],
						'status' => false
					],200);
        }else{
			$user_info = get_this('customers',['id' =>$this->input->post('customer_id')]);
			if ($user_info) {
				if ($user_info['status'] == '1') {
						$alarm_finished = $this->input->post('alarm_finished');
						$update = ['alarm_finished' => $alarm_finished];
						$this->Main_model->update('customers',['id'=>$this->input->post('customer_id')],$update);
							  $this->api_return([
									'message' => lang('Successfully updated'),
									'errNum' => 405,
									'status' => true,
									"result" => ""
								],200);
						
				}else{
                  $this->api_return([
						'message' => lang('Account Not Activated'),
						'errNum' => 401,
						'status' => false
					],200);
              }
          }else{
                   $this->api_return([
						'message' => lang('Sorry, there are no data for this user'),
						'errNum' => 402,
						'status' => false
					],200);
          }
		}
	}
	
	public function notifications()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
			'requireAuthorization' => true
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);

		$this->load->library('form_validation');
		$this->form_validation->set_rules('customer_id', lang('Customer ID'), 'required|numeric');
		$this->form_validation->set_rules('limit', lang('Number of visible elements'), 'trim|required|numeric');
		$this->form_validation->set_rules('page_number', lang('Page Number'), 'trim|required|numeric');
		if($this->form_validation->run() === FALSE){
			
			if(form_error('customer_id')){
				if($this->input->post('customer_id')==="" || !$this->input->post('customer_id')){
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 1);
				}
			}
			
			if(form_error('limit')){
				if($this->input->post('limit')==="" || !$this->input->post('limit')){
					$data[] = array('message'=> strip_tags(form_error('limit')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('limit')),"errNum" => 1);
				}
			}
			
            if(form_error('page_number')){
				if($this->input->post('page_number')==="" || !$this->input->post('page_number')){
					$data[] = array('message'=> strip_tags(form_error('page_number')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('page_number')),"errNum" => 1);
				}
			}
			
            $this->api_return([
						'message' => $data[0]['message'],
						'errNum' => $data[0]['errNum'],
						'status' => false
					],200);
        }else{
			$user_info = get_this('customers',['id' =>$this->input->post('customer_id')]);
			$offset = $this->input->post('limit') * $this->input->post('page_number');
			
			//Reset Customer Notifications Number To 0
			$update = ['notifications_num' => 0];
			$this->Main_model->update('customers',['id'=>$user_info['id']],$update);
			///////////////////////////////////////////////////////////////////////////
			
			if ($user_info) {
				if ($user_info['status'] == '1') {
						$notifications = get_this_limit('notifications',['customer_id'=>$this->input->post('customer_id')],'',[$this->input->post('limit'),$offset],['id','DESC']);
						$not_total = get_this('notifications',['customer_id'=>$this->input->post('customer_id')]);
						if($notifications){
						//$result = array();
						foreach($notifications as $notification){
							
							$end_time = get_this('mazad',['id' =>$notification->mazad_id],'end_time');
							if($lang=='arabic' || $lang=="" || $lang!="english"){
								$this->db->select('id, title_ar as title, desc_ar as desc');
								$this->db->where('customer_id', $this->input->post('customer_id'));
								$title = $this->db->get('notifications')->row_array();
								//print_r($title);die;
							}else{
								$this->db->select('id, title_en as title, desc_en as desc');
								$this->db->where('customer_id', $this->input->post('customer_id'));
								$title = $this->db->get('notifications')->row_array();
							}
						
							$result[] = [
								'id'         => $notification->id,
								'customer_id'        => $notification->customer_id,
								'mazad_id'        => $notification->mazad_id,
								'end_time'        => $end_time,
								'title'        => $title['title'],
								'desc'        => $title['desc'],
								'view'        => $notification->view
							]; 
						}
						//print_r($result);die;
						$total = count($not_total);
						
						//Reset Customer Notifications Number To 0
						$update = ['notifications_num' => 0];
						$this->Main_model->update('customers',['id'=>$user_info['id']],$update);
						///////////////////////////////////////////////////////////////////////////
						$data['notifications'] = $result;
							  $this->api_return([
									'message' => lang('Operation completed successfully'),
									'errNum' => 405,
									'status' => true,
									'total' => $total,
									"result" => $data
								],200);
						}else{
							$data['notifications'] = [];
							$this->api_return([
									'message' => lang('Sorry there are no notifications'),
									'errNum' => 5,
									'status' => true,
									"result" => $data
								],200);
						}
						
				}else{
                  $this->api_return([
						'message' => lang('Account Not Activated'),
						'errNum' => 401,
						'status' => false
					],200);
              }
          }else{
                   $this->api_return([
						'message' => lang('Sorry, there are no data for this user'),
						'errNum' => 402,
						'status' => false
					],200);
          }
		}
	}
	
	public function update_notifications()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
			'requireAuthorization' => true
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);

		$this->load->library('form_validation');
        $this->form_validation->set_rules('notification_id', lang('Alert number'), 'required|numeric');
		$this->form_validation->set_rules('customer_id', lang('Customer ID'), 'required|numeric');
		if($this->form_validation->run() === FALSE){
            if(form_error('notification_id')){
				if($this->input->post('notification_id')==="" || !$this->input->post('notification_id')){
					$data[] = array('message'=> strip_tags(form_error('notification_id')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('notification_id')),"errNum" => 1);
				}
			}
			
			if(form_error('customer_id')){
				if($this->input->post('customer_id')==="" || !$this->input->post('customer_id')){
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 1);
				}
			}
			
            $this->api_return([
						'message' => $data[0]['message'],
						'errNum' => $data[0]['errNum'],
						'status' => false
					],200);
        }else{
			$user_info = get_this('customers',['id' =>$this->input->post('customer_id')]);
			$offset = $this->input->post('limit') * $this->input->post('page_number');
			if ($user_info) {
				if ($user_info['status'] == '1') {
						$notification_id = $this->input->post('notification_id');
						$update = ['view' => '1'];
						$this->Main_model->update('notifications',['id'=>$this->input->post('notification_id')],$update);
							  $this->api_return([
									'message' => lang('Successfully updated'),
									'errNum' => 405,
									'status' => true,
									"result" => $data
								],200);
						
				}else{
                  $this->api_return([
						'message' => lang('Account Not Activated'),
						'errNum' => 401,
						'status' => false
					],200);
              }
          }else{
                   $this->api_return([
						'message' => lang('Sorry, there are no data for this user'),
						'errNum' => 402,
						'status' => false
					],200);
          }
		}
	}
	
	public function mazad_info()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
			'requireAuthorization' => true
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);

		$this->load->library('form_validation');
		$this->form_validation->set_rules('customer_id', lang('Customer ID'), 'trim|required|numeric');
        $this->form_validation->set_rules('mazad_id', lang('Mazad ID'), 'required|numeric');
		if($this->form_validation->run() === FALSE){
			
			if(form_error('customer_id')){
				if($this->input->post('customer_id')==="" || !$this->input->post('customer_id')){
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 1);
				}	
			}
			
            if(form_error('mazad_id')){
				if($this->input->post('mazad_id')==="" || !$this->input->post('mazad_id')){
					$data[] = array('message'=> strip_tags(form_error('mazad_id')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('mazad_id')),"errNum" => 1);
				}
			}
			
            $this->api_return([
						'message' => $data[0]['message'],
						'errNum' => $data[0]['errNum'],
						'status' => false
					],200);
        }else{
			$mazad_info = get_this('mazad',['id' =>$this->input->post('mazad_id')]);
			if ($mazad_info) {
				//$mazad_info = array();
				$product = get_this('products',['id' =>$mazad_info['product_id']]);
				$products_images = get_table('products_images',['product_id' =>$mazad_info['product_id']]);
				$favourite = get_this('favourites',['customer_id'=>$this->input->post('customer_id'),'mazad_id'=>$mazad_info['id']]);
				
				if($favourite){
				$favourites = true;
				}else{
					$favourites = false;
				}
			
				$data['mazad'] = $mazad_info;
				$data['mazad']['favourites'] = $favourites;
				$data['mazad']['product_detailes'] = $product;
				if($lang=='arabic' || $lang=="" || $lang!="english"){
					unset($data['mazad']['product_detailes']['name_en']);
					unset($data['mazad']['product_detailes']['desc_en']);
					//Rename Fields Of array To be Same Name With Out Lang Name
					$data['mazad']['product_detailes']['name'] = $data['mazad']['product_detailes']['name_ar'];
					$data['mazad']['product_detailes']['desc'] = strip_tags(trim(preg_replace('/\s\s+/', ' ', $data['mazad']['product_detailes']['desc_ar'])));
					unset($data['mazad']['product_detailes']['name_ar']);
					unset($data['mazad']['product_detailes']['desc_ar']);
					///////////////////////////////////////////////////////////////
				}else{
					unset($data['mazad']['product_detailes']['name_ar']);
					unset($data['mazad']['product_detailes']['desc_ar']);
					//Rename Fields Of array To be Same Name With Out Lang Name
					$data['mazad']['product_detailes']['name'] = $data['mazad']['product_detailes']['name_en'];
					$data['mazad']['product_detailes']['desc'] = strip_tags(trim(preg_replace('/\s\s+/', ' ', $data['mazad']['product_detailes']['desc_en'])));
					unset($data['mazad']['product_detailes']['name_en']);
					unset($data['mazad']['product_detailes']['desc_en']);
					///////////////////////////////////////////////////////////////
				}
				$data['mazad']['product_detailes']['path'] = base_url('uploads/site_setting/products_gallery/');
				$data['mazad']['product_detailes']['images'] = $products_images;

				//$data['mazad']['product_detailes']['images']['img'] = base_url('uploads/customers/'.$products_images['img']);
				$data['mazad']['product_detailes']['img'] = base_url('uploads/site_setting/products/'.$product['img']);
				
				$this->db->select_max('price');
				$this->db->where('mazad_id', $mazad_info['id']);
				$max_price = $this->db->get('mazad_subscribers')->row_array();
				//echo $max_price['price'];die;
				if($max_price['price'] && $max_price['price']!=''){
					foreach($max_price as $key=>$value){
						$data['mazad']['max_price'] = $value;
					}
				}else{
					$data['mazad']['max_price'] = "0";
				}
				//print_r($max_price);die;
				
				//echo $this->db->last_query();die;
				$this->db->select_min('price');
				$this->db->where('mazad_id', $mazad_info['id']);
				$min_price = $this->db->get('mazad_subscribers')->row_array();
				//print_r($min_price);die;
				foreach($min_price as $key=>$value){
					//$data['mazad']['min_price'] = $value;
				}

							  
				$this->api_return([
						'message' => lang('Operation completed successfully'),
						'errNum' => 405,
						'status' => true,
						"result" => $data
					],200);
          }else{
             $this->api_return([
						'message' => lang('Sorry, there are no data for this Mazad'),
						'errNum' => 5,
						'status' => false
					],200);
          }
		}
	}

	public function mazad_pluse()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
			'requireAuthorization' => true
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);

		$this->load->library('form_validation');
        $this->form_validation->set_rules('mazad_id', lang('Mazad ID'), 'required|numeric');
		$this->form_validation->set_rules('customer_id', lang('Customer ID'), 'required|numeric');
		if($this->form_validation->run() === FALSE){
            if(form_error('mazad_id')){
				if($this->input->post('mazad_id')==="" || !$this->input->post('mazad_id')){
					$data[] = array('message'=> strip_tags(form_error('mazad_id')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('mazad_id')),"errNum" => 1);
				}
			}
			
			if(form_error('customer_id')){
				if($this->input->post('customer_id')==="" || !$this->input->post('customer_id')){
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 1);
				}
			}
			
            $this->api_return([
						'message' => $data[0]['message'],
						'errNum' => $data[0]['errNum'],
						'status' => false
					],200);
        }else{
			date_default_timezone_set('Asia/Riyadh');
			$customer_info = get_this('customers',['id'=>$this->input->post('customer_id'),'status'=>'1']);
            if ($customer_info) {
				$mazad_info = get_this('mazad',['id' =>$this->input->post('mazad_id'),'status'=>'1']);
				$end_time = $mazad_info['end_time'];
				$split = explode(" ",$end_time);
				$selectedTime = $split[1];
				$pluse_time = get_this('site_info',['id'=>1],'pluse_time');
				$endTime = strtotime("-$pluse_time seconds", strtotime($selectedTime));
				$compare = date('H:i:s', $endTime);
				$now = date('H:i:s');
				//echo $now." - ".$selectedTime." - ".$compare." - ";
				//if($now >= $compare and $compare <= $selectedTime){die;

				if ($mazad_info) {
					$customer_points = get_this('customers',['id'=>$customer_info['id']],'points');
					//echo $customer_points." - ";
					//echo $mazad_info['pluse_points'];die;
					
					if($customer_points < $mazad_info['pluse_points']){
						$data['message'] = lang('Sorry, you do not have enough credits to bid');
						$data['errNum'] = 11;
						$this->api_return([
						'message' => lang('Sorry, you do not have enough credits to bid'),
						'errNum' => 11,
						'status' => false,
						"result" => $data
						],200);
					}else{
						//Update Customer Points
						$points = $customer_points - $mazad_info['pluse_points'];
						$update = ['points' => $points];
						$this->Main_model->update('customers',['id'=>$this->input->post('customer_id')],$update);
						////////////////////////////////////////////////////////////////////////////////////////////
						$this->db->select_max('price');
						$this->db->where('mazad_id', $mazad_info['id']);
						$max_price = $this->db->get('mazad_subscribers')->row_array();
						//echo $max_price['price'];die;
						//Update Subscriber In Mazad
						$store = [
							'mazad_id' => $mazad_info['id'],
							'customer_id'  => $customer_info['id'],
							'price'  => $mazad_info['point_value']*$mazad_info['pluse_points']+$max_price['price'],
							'points'  => $mazad_info['pluse_points'],
							'status'     => '0',
                        ];
						//////////////////////////////////////////////////////////////////////////////////
						//Add 10 Seconds if time in the end of 10 Seconds
						if($now >= $compare and $now <= $selectedTime){
							//echo "yes";
							$e_time0 = $split[0];
							$e_time1 = $split[1];
							$e_time = strtotime("+$pluse_time seconds", strtotime($e_time1));
							$endtime = $e_time0 . $e_time;
							$updates = ['end_time' => $endtime];
							$this->Main_model->update('mazad',['id'=>$mazad_info['id']],$updates);
						}else{
							//echo "No";
						}
						//////////////////////////////////////////////////////////////////////////////////
                        $insert = $this->Main_model->insert('mazad_subscribers',$store);
						////////////////////////////////////////////////////////////////////////////////////////////
						$pluse_value = get_this('mazad_subscribers',['id' => $insert]);
						$data = $pluse_value ;
						$this->api_return([
						'message' => lang('Bid successfully completed'),
						'errNum' => 405,
						'status' => true,
						"result" => $data
						],200);
					}
				}else{
					$this->api_return([
					'message' => lang('Sorry this mazad is over'),
					'errNum' => 12,
					'status' => false
					],200);
				}
			}else{
              $this->api_return([
					'message' => lang('Sorry, there are no data for this user'),
					'errNum' => 402,
					'status' => false
					],200);
            }
			
		}
	}

	
	public function mazad_now()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
			'requireAuthorization' => true
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('customer_id', lang('Customer ID'), 'trim|required|numeric');
		$this->form_validation->set_rules('limit', lang('Number of visible elements'), 'trim|required|numeric');
		$this->form_validation->set_rules('page_number', lang('Page Number'), 'trim|required|numeric');
		if($this->form_validation->run() === FALSE){
					
			if(form_error('customer_id')){
				if($this->input->post('customer_id')==="" || !$this->input->post('customer_id')){
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 1);
				}	
			}
			
			if(form_error('limit')){
				if($this->input->post('limit')==="" || !$this->input->post('limit')){
					$data[] = array('message'=> strip_tags(form_error('limit')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('limit')),"errNum" => 1);
				}
			}
			
            if(form_error('page_number')){
				if($this->input->post('page_number')==="" || !$this->input->post('page_number')){
					$data[] = array('message'=> strip_tags(form_error('page_number')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('page_number')),"errNum" => 1);
				}
			}
			
			$this->api_return([
					'message' => $data[0]['message'],
					'errNum' => $data[0]['errNum'],
					'status' => false
					],200);
					
		}else{
		date_default_timezone_set('Asia/Riyadh');
		$now = date("Y-m-d H:i:s");
		$offset = $this->input->post('limit') * $this->input->post('page_number');
		$mazadat = get_this_limit('mazad',['start_time <'=>$now,'end_time >'=>$now,'status'=>'1'],'',[$this->input->post('limit'),$offset],['id','DESC']);
		$total = get_this_limit('mazad',['start_time <'=>$now,'end_time >'=>$now,'status'=>'1']);
		$total = count($total);
		//$mazadat = get_this_limit('mazad',['start_time <'=>$now,'end_time >'=>$now,'status'=>'1']);
		//print_r($mazadat);die;
		//echo $this->db->last_query();die;
		$result = array();
		if($mazadat){
			
		foreach ($mazadat as $item) {
			$favourite = get_this('favourites',['customer_id'=>$this->input->post('customer_id'),'mazad_id'=>$item->id]);
			if($favourite){
				$favourites = true;
			}else{
				$favourites = false;
			}
			
			if($lang=='arabic' || $lang=="" || $lang!="english"){
				$this->db->select('id, name_ar as name, desc_ar as desc, img, default_price, creation_date');
				$this->db->where('id', $item->product_id);
				$product_detailes = $this->db->get('products')->row_array();
				$product_detailes['img'] = base_url('uploads/site_setting/products/'.$product_detailes['img']);
				//print_r($product_detailes);die;
			}else{
				$this->db->select('id, name_en as name, desc_en as desc, img, default_price, creation_date');
				$this->db->where('id', $item->product_id);
				$product_detailes = $this->db->get('products')->row_array();
				$product_detailes['img'] = base_url('uploads/site_setting/products/'.$product_detailes['img']);
			}
			
			//Select Max Price For Mazad
			$this->db->select_max('price');
			$this->db->where('mazad_id', $item->id);
			$max_price = $this->db->get('mazad_subscribers')->row_array();
			if(!$max_price['price']){$max_price['price']='0';}
			////////////////////////////////////////////////////////////////
			//Strip Tags From Content
			$product_detailes['desc'] = strip_tags(trim(preg_replace('/\s\s+/', ' ', $product_detailes['desc'])));
			$result[] = [
				'mazad_id'         => $item->id,
				'product_id'        => $item->product_id,
				'product_detailes'        => $product_detailes,
				'start_time'        => $item->start_time,
				'end_time'        => $item->end_time,
				'pluse_points'        => $item->pluse_points,
				'open_price'        => $item->open_price,
				'status'        => $item->status,
				'creation_date'        => $item->creation_date,
				'favourites'        => $favourites,
				'max_price'        => $max_price['price']
				//'mazad'        => get_this('mazad',['id'=>$item->mazad_id])
			];  
		}
			foreach($result as $key => $value){
				$test[] = $value;
			}
			//$result['total'] = count($total);
			$data = $test;
			//$total = count($mazadat);

              $this->api_return([
					'message' => lang('Operation completed successfully'),
					'errNum' => 405,
					'status' => true,
					'total' => $total,
					"result" => $data
					],200);
			}else{
				$data = array();
				$this->api_return([
					'message' => lang('Sorry there is no data to display'),
					'errNum' => 5,
					'status' => true,
					'total' => 0,
					"result" => $data
					],200);
			}
		}
	}
	
	
	public function mazad_finish()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
			'requireAuthorization' => true
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('customer_id', lang('Customer ID'), 'trim|required|numeric');
		$this->form_validation->set_rules('limit', lang('Number of visible elements'), 'trim|required|numeric');
		$this->form_validation->set_rules('page_number', lang('Page Number'), 'trim|required|numeric');
		if($this->form_validation->run() === FALSE){
					
			if(form_error('customer_id')){
				if($this->input->post('customer_id')==="" || !$this->input->post('customer_id')){
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 1);
				}	
			}
			
			if(form_error('limit')){
				if($this->input->post('limit')==="" || !$this->input->post('limit')){
					$data[] = array('message'=> strip_tags(form_error('limit')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('limit')),"errNum" => 1);
				}
			}
			
            if(form_error('page_number')){
				if($this->input->post('page_number')==="" || !$this->input->post('page_number')){
					$data[] = array('message'=> strip_tags(form_error('page_number')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('page_number')),"errNum" => 1);
				}
			}
			//print_r($data);die;
			$this->api_return([
					'message' => $data[0]['message'],
					'errNum' => $data[0]['errNum'],
					'status' => false
					],200);
					
		}else{
		date_default_timezone_set('Asia/Riyadh');
		$now = date("Y-m-d H:i:s");
		$offset = $this->input->post('limit') * $this->input->post('page_number');
		$mazadat = get_this_limit('mazad',['end_time <'=>$now,'status'=>'2'],'',[$this->input->post('limit'),$offset],['id','DESC']);
		$total = get_this_limit('mazad',['end_time <'=>$now,'status'=>'2']);
		//print_r($mazadat);die;
		//echo $this->db->last_query();die;
		
		if($mazadat){
		foreach ($mazadat as $item) {
			$favourite = get_this('favourites',['customer_id'=>$this->input->post('customer_id'),'mazad_id'=>$item->id]);
			if($favourite){
				$favourites = true;
			}else{
				$favourites = false;
			}
			
			if($lang=='arabic' || $lang=="" || $lang!="english"){
				$this->db->select('id, name_ar as name, desc_ar as desc, img, default_price, creation_date');
				$this->db->where('id', $item->product_id);
				$product_detailes = $this->db->get('products')->row_array();
				$product_detailes['img'] = base_url('uploads/site_setting/products/'.$product_detailes['img']);
				$product_detailes['desc'] = strip_tags(trim(preg_replace('/\s\s+/', ' ', $product_detailes['desc'])));
				//print_r($product_detailes);die;
			}else{
				$this->db->select('id, name_en as name, desc_en as desc, img, default_price, creation_date');
				$this->db->where('id', $item->product_id);
				$product_detailes = $this->db->get('products')->row_array();
				$product_detailes['img'] = base_url('uploads/site_setting/products/'.$product_detailes['img']);
				$product_detailes['desc'] = strip_tags(trim(preg_replace('/\s\s+/', ' ', $product_detailes['desc'])));
			}
			
			//Select Max Price For Mazad
			$this->db->select_max('price');
			$this->db->where('mazad_id', $item->id);
			$max_price = $this->db->get('mazad_subscribers')->row_array();
			if(!$max_price['price']){$max_price['price']='0';}
			////////////////////////////////////////////////////////////////
			$result[] = [
				'mazad_id'         => $item->id,
				'product_id'        => $item->product_id,
				'product_detailes'        => $product_detailes,
				'start_time'        => $item->start_time,
				'end_time'        => $item->end_time,
				'pluse_points'        => $item->pluse_points,
				'open_price'        => $item->open_price,
				'status'        => $item->status,
				'creation_date'        => $item->creation_date,
				'favourites'        => $favourites,
				'max_price'        => $max_price['price'],
				//'mazad'        => get_this('mazad',['id'=>$item->mazad_id])
			];
		}
		
			foreach($result as $key => $value){
				$test[] = $value;
			}
			
			$total = count($total);
			$data = $test;
		//$data['time'] = $now;
		//echo $this->db->last_query();die;
		//$data['mazadat'] = $mazadat;
              $this->api_return([
					'message' => lang('Operation completed successfully'),
					'errNum' => 405,
					'status' => true,
					'total' => $total,
					"result" => $data
					],200);
		
		}else{
			$this->api_return([
				'message' => lang('Sorry there is no data to display'),
				'errNum' => 5,
				'status' => true,
				"result" => ""
				],200);
		}
	}
	}
	
	public function rate()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
			'requireAuthorization' => true
        ]);
		ob_start();
		$lang = $this->input->post('lang');
        $this->checkLang($lang);
			$data = get_this('site_info',['id'=>1],'exchange_to_sar');
                  $this->api_return([
						'message' => lang('Operation completed successfully'),
						'errNum' => 405,
						'status' => true,
						"result" => $data
					],200);
	}
	
	public function mazad_values()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
			'requireAuthorization' => true
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);

		$this->load->library('form_validation');
        $this->form_validation->set_rules('mazad_id', lang('Mazad ID'), 'required|numeric');
		if($this->form_validation->run() === FALSE){
            if(form_error('mazad_id')){
				if($this->input->post('mazad_id')==="" || !$this->input->post('mazad_id')){
					$data[] = array('message'=> strip_tags(form_error('mazad_id')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('mazad_id')),"errNum" => 1);
				}
			}
			
            $this->api_return([
						'message' => $data[0]['message'],
						'errNum' => $data[0]['errNum'],
						'status' => false
					],200);
        }else{
			$mazad_info = get_this('mazad',['id' =>$this->input->post('mazad_id')]);
			if ($mazad_info) {
				//$values = get_this('mazad_subscribers',['mazad_id' =>$mazad_info['id']]);
				$values = get_table('mazad_subscribers',['mazad_id' =>$mazad_info['id']]);
				if(count($values)!=0){
					//print_r($values);die;
					foreach($values as $value){
						$customer_info['username'] = get_this('customers',['id'=>$value->customer_id],'username');
						$img = get_this('customers',['id'=>$value->customer_id],'img');
						$customer_info['img'] =  base_url('uploads/customers/'.$img);
						//$result[] = $value;
						$result[] = [
							'id'         => $value->id,
							'mazad_id'         => $value->mazad_id,
							'customer_id'         => $value->customer_id,
							'customer_info'         => $customer_info,
							'price'         => $value->price,
							'points'         => $value->points,
							'status'         => $value->status,
							'creation_date'         => $value->creation_date,
						];
					}
					$data = $result;
					$total = count($values);
					$this->api_return([
						'message' => lang('Operation completed successfully'),
						'errNum' => 405,
						'status' => true,
						//'total' => $total,
						"result" => $data
					],200);
				}else{
					$data = [];
					$total = count($values);
					$this->api_return([
						'message' => lang('Sorry there is no data to display'),
						'errNum' => 5,
						'status' => true,
						//'total' => $total,
						"result" => $data
					],200);
				}
          }else{
             $this->api_return([
						'message' => lang('Sorry, there are no data for this Mazad'),
						'errNum' => 5,
						'status' => false
					],200);
          }
		}
	}
	
	/*public function mazad_winner()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
			'requireAuthorization' => true
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('customer_id', lang('Customer ID'), 'trim|required|numeric');

		if($this->form_validation->run() === FALSE){
			
			if(form_error('customer_id')){
				if($this->input->post('customer_id')==="" || !$this->input->post('customer_id')){
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 1);
				}	
			}
			
            $this->api_return([
						'message' => $data[0]['message'],
						'errNum' => $data[0]['errNum'],
						'status' => false
					],200);
        }else{
			$customer_info = get_this('customers',['id'=>$this->input->post('customer_id')]);
            if ($customer_info) {
				$mazad_winner = get_table('mazad_subscribers',['customer_id'=>$customer_info['id'],'status'=>'1']);
				//print_r($mazad_winner);die;
				if($mazad_winner){
					foreach($mazad_winner as $winner){
					$mazad_info = get_this('mazad',['id'=>$winner->mazad_id]);
					
					$favourite = get_this('favourites',['customer_id'=>$this->input->post('customer_id'),'mazad_id'=>$winner->mazad_id]);
					if($favourite){
						$favourites = true;
					}else{
						$favourites = false;
					}
					
					if($lang=='arabic' || $lang=="" || $lang!="english"){
					$this->db->select('id, name_ar as name, desc_ar as desc, img, default_price, creation_date');
					$this->db->where('id', $mazad_info['product_id']);
					$product_detailes = $this->db->get('products')->row_array();
					$product_detailes['img'] = base_url('uploads/customers/'.$product_detailes['img']);
					//print_r($product_detailes);die;
					}else{
						$this->db->select('id, name_en as name, desc_en as desc, img, default_price, creation_date');
						$this->db->where('id', $mazad_info['product_id']);
						$product_detailes = $this->db->get('products')->row_array();
						$product_detailes['img'] = base_url('uploads/customers/'.$product_detailes['img']);
					}
					
					$result[] = [
						'id'         => $winner->id,
						'mazad_id'   => $winner->mazad_id,
						'mazad_info'   => $mazad_info,
						'product_info'   => $product_detailes,
						'customer_id'         => $winner->customer_id,
						'price'         => $winner->price,
						'points'         => $winner->points,
						'status'         => $winner->status,
						'favourites'        => $favourites,
						'creation_date'         => $winner->creation_date,
					];
				}
				$data = $result;
				$this->api_return([
					'message' => lang('Operation completed successfully'),
					'errNum' => 405,
					'status' => true,
					"result" => $data
				],200);
					
				}else{
					$this->api_return([
						'message' => lang('Sorry there is no data to display'),
						'errNum' => 5,
						'status' => false
						],200);
				}
                
            }else{
				$this->api_return([
					'message' => lang('Sorry, there are no data for this user'),
					'errNum' => 402,
					'status' => false
					],200);
            }
		}
	}*/
	
	public function mazad_winner()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
			'requireAuthorization' => true
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('customer_id', lang('Customer ID'), 'trim|required|numeric');
		$this->form_validation->set_rules('limit', lang('Number of visible elements'), 'trim|required|numeric');
		$this->form_validation->set_rules('page_number', lang('Page Number'), 'trim|required|numeric');
		if($this->form_validation->run() === FALSE){
					
			if(form_error('customer_id')){
				if($this->input->post('customer_id')==="" || !$this->input->post('customer_id')){
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 1);
				}	
			}
			
			if(form_error('limit')){
				if($this->input->post('limit')==="" || !$this->input->post('limit')){
					$data[] = array('message'=> strip_tags(form_error('limit')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('limit')),"errNum" => 1);
				}
			}
			
            if(form_error('page_number')){
				if($this->input->post('page_number')==="" || !$this->input->post('page_number')){
					$data[] = array('message'=> strip_tags(form_error('page_number')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('page_number')),"errNum" => 1);
				}
			}
			//print_r($data);die;
			$this->api_return([
					'message' => $data[0]['message'],
					'errNum' => $data[0]['errNum'],
					'status' => false
					],200);
					
		}else{
		$offset = $this->input->post('limit') * $this->input->post('page_number');
		//$mazad_winner = get_table('mazad_subscribers',['customer_id'=>$customer_info['id'],'status'=>'1']);
		//$mazadat = get_this_limit('mazad',['end_time <'=>$now,'status'=>'2'],'',[$this->input->post('limit'),$offset],['id','DESC']);
		$where['mazad_subscribers.customer_id'] = $this->input->post('customer_id');
		$where['mazad_subscribers.status'] = '1';
		$mazadat = $this->db->select('*')
							->select('mazad.status as mazad_status')
							->order_by('mazad.id','DESC')
							//->group_by('mazad_id')
							->join('mazad_subscribers','mazad_subscribers.mazad_id=mazad.id')
							->get_where('mazad',$where, $this->input->post('limit'), $offset)
							->result();
		$total = get_this_limit('mazad_subscribers',['customer_id'=>$this->input->post('customer_id'),'status'=>'1']);
		$total = count($total);
		//print_r($mazadat);die;
		//echo $this->db->last_query();die;
		//$total = get_this_limit('mazad',['end_time <'=>$now,'status'=>'2']);
		//print_r($mazadat);die;
		//echo $this->db->last_query();die;
		
		if($mazadat){
		foreach ($mazadat as $item) {
			$favourite = get_this('favourites',['customer_id'=>$this->input->post('customer_id'),'mazad_id'=>$item->mazad_id]);
			if($favourite){
				$favourites = true;
			}else{
				$favourites = false;
			}
			
			if($lang=='arabic' || $lang=="" || $lang!="english"){
				$this->db->select('id, name_ar as name, desc_ar as desc, img, default_price, creation_date');
				$this->db->where('id', $item->product_id);
				$product_detailes = $this->db->get('products')->row_array();
				$product_detailes['img'] = base_url('uploads/site_setting/products/'.$product_detailes['img']);
				//print_r($product_detailes);die;
			}else{
				$this->db->select('id, name_en as name, desc_en as desc, img, default_price, creation_date');
				$this->db->where('id', $item->product_id);
				$product_detailes = $this->db->get('products')->row_array();
				$product_detailes['img'] = base_url('uploads/site_setting/products/'.$product_detailes['img']);
			}
			
			//Select Max Price For Mazad
			$this->db->select_max('price');
			$this->db->where('mazad_id', $item->mazad_id);
			$max_price = $this->db->get('mazad_subscribers')->row_array();
			if(!$max_price['price']){$max_price['price']='0';}
			////////////////////////////////////////////////////////////////
			//Strip Tags
			$product_detailes['desc'] = strip_tags(trim(preg_replace('/\s\s+/', ' ', $product_detailes['desc'])));
			$result[] = [
				'mazad_id'         => $item->mazad_id,
				'product_id'        => $item->product_id,
				'product_detailes'        => $product_detailes,
				'start_time'        => $item->start_time,
				'end_time'        => $item->end_time,
				'pluse_points'        => $item->pluse_points,
				'open_price'        => $item->open_price,
				'status'        => $item->mazad_status,
				'creation_date'        => $item->creation_date,
				'favourites'        => $favourites,
				'max_price'        => $max_price['price'],
				'customer_id'        => $item->customer_id,
				'username'        => get_this('customers',['id'=>$item->customer_id],'username'),
				'img'        => base_url('uploads/customers/'. get_this('customers',['id'=>$item->customer_id],'img'))
			];
		}
		
			foreach($result as $key => $value){
				$test[] = $value;
			}
			
			//$total = count($mazadat);
			$data = $test;
		//$data['time'] = $now;
		//echo $this->db->last_query();die;
		//$data['mazadat'] = $mazadat;
              $this->api_return([
					'message' => lang('Operation completed successfully'),
					'errNum' => 405,
					'status' => true,
					'total' => $total,
					"result" => $data
					],200);
		
		}else{
			$data = array();
			$this->api_return([
				'message' => lang('Sorry there is no data to display'),
				'errNum' => 5,
				'status' => true,
				'total' => 0,
				"result" => $data
				],200);
		}
	}
	}
	
	public function packages()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
			'requireAuthorization' => true
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);
		
		if($lang=='arabic' || $lang=="" || $lang!="english"){
			$this->db->select('id, title_ar as title, points, price, creation_date');
			$packages = $this->db->get('packages')->result_array();
		}else{
			$this->db->select('id, title_en as title, points, price, creation_date');
			$packages = $this->db->get('packages')->result_array();
		}
		
		//$pages = get_table('pages',['active'=>'1'],['id','title_ar']);
		if ($packages) {	
        foreach ($packages as $package) {
          $result[] = $package;
        }
		
		//print_r($result);die;
            if ($result) {
              $data['packages'] = $result;
              $this->api_return([
						'message' => lang('Operation completed successfully'),
						'errNum' => 405,
						'status' => true,
						"result" => $data
					],200);
            }
      }else{
        $data['packages'] = [];
        $this->api_return([
				'message' => lang('Sorry there is no data to display'),
				'errNum' => 5,
				'status' => true,
				"result" => $data
				],200);
       }
	}
	
	public function confirm_points()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
			'requireAuthorization' => true
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);
		
		$this->form_validation->set_rules('customer_id', lang('Customer ID'), 'trim|required|numeric');
		$this->form_validation->set_rules('package_id', lang('Package ID'), 'trim|required|numeric');
		$this->form_validation->set_rules('process_number', lang('Process Number'), 'trim|required');

		if($this->form_validation->run() === FALSE){
					
			if(form_error('customer_id')){
				if($this->input->post('customer_id')==="" || !$this->input->post('customer_id')){
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 1);
				}	
			}
			
			if(form_error('package_id')){
				if($this->input->post('package_id')==="" || !$this->input->post('package_id')){
					$data[] = array('message'=> strip_tags(form_error('package_id')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('package_id')),"errNum" => 1);
				}
			}
			
			if(form_error('process_number')){
				if($this->input->post('process_number')==="" || !$this->input->post('process_number')){
					$data[] = array('message'=> strip_tags(form_error('process_number')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('process_number')),"errNum" => 1);
				}
			}
			//print_r($data);die;
			$this->api_return([
					'message' => $data[0]['message'],
					'errNum' => $data[0]['errNum'],
					'status' => false
					],200);
					
		}else{
			$packages = get_this('packages',['id' =>$this->input->post('package_id')]);
			$user_info = get_this('customers',['id' =>$this->input->post('customer_id')]);
			if($packages){
				$old_points = $user_info['points'];
				$points = $old_points + $packages['points'];
				//Update Point User After Confirm
				$update = ['points' => $points];
                $update = $this->Main_model->update('customers',['id'=>$user_info['id']],$update);
				/////////////////////////////////////////////////////////////////////////////////////
				//Insert Transactions Info After Paid
				$store = [
					'customer_id'=>$user_info['id'],
					'process_number'=>$this->input->post('package_id'),
					'title_ar'=>$packages['title_ar'],
					'title_en'=>$packages['title_en'],
					'amount'=>$packages['price'],
					'points' => $packages['points']
					];
                $insert = $this->Main_model->insert('transactions_points',$store);
				////////////////////////////////////////////////////////////////////////////////////////////
				$new_points = get_this('customers',['id' => $user_info['id']],'points');
				$data['new_points'] = $new_points;
				if ($update) {
				  $this->api_return([
							'message' => lang('Operation completed successfully'),
							'errNum' => 405,
							'status' => true,
							"result" => $data
						],200);
				}
			}else{
				$this->api_return([
							'message' => lang('Sorry This Package ID Not Found'),
							'errNum' => 5,
							'status' => false
						],200);
			}
		}
		
	}
	
	public function share_info()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
			'requireAuthorization' => true
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('customer_id', lang('Customer ID'), 'trim|required|numeric');

		if($this->form_validation->run() === FALSE){
					
			if(form_error('customer_id')){
				if($this->input->post('customer_id')==="" || !$this->input->post('customer_id')){
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 1);
				}
			}
			
            $this->api_return([
						'message' => $data[0]['message'],
						'errNum' => $data[0]['errNum'],
						'status' => false
					],200);
					
		}else{
			$customer_info = get_this('customers',['id'=>$this->input->post('customer_id')]);
        	if ($customer_info) {
        			$data['invitation_code'] = $customer_info['invitation_code'];
        			$data['invitation_count'] = $customer_info['invitation_count'];
        			$data['app_android'] = get_this('site_info',['id'=>1],'app_android');
        			$data['app_ios'] = get_this('site_info',['id'=>1],'app_ios');
					$this->api_return([
						'message' => lang('Operation completed successfully'),
						'errNum' => 405,
						'status' => true,
						"result" => $data
					],200);
        		
        	}else{
				$this->api_return([
						'message' => lang('Sorry, there are no data for this user'),
						'errNum' => 402,
						'status' => false
					],200);
        	}
		}
		
	}
	
	public function notifications_num()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
			'requireAuthorization' => true
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('customer_id', lang('Customer ID'), 'trim|required|numeric');

		if($this->form_validation->run() === FALSE){
					
			if(form_error('customer_id')){
				if($this->input->post('customer_id')==="" || !$this->input->post('customer_id')){
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 1);
				}
			}
			
            $this->api_return([
						'message' => $data[0]['message'],
						'errNum' => $data[0]['errNum'],
						'status' => false
					],200);
					
		}else{
			$customer_info = get_this('customers',['id'=>$this->input->post('customer_id')]);
        	if ($customer_info) {
        			$data['notifications_num'] = $customer_info['notifications_num'];
					$this->api_return([
						'message' => lang('Operation completed successfully'),
						'errNum' => 405,
						'status' => true,
						"result" => $data
					],200);
        		
        	}else{
				$this->api_return([
						'message' => lang('Sorry, there are no data for this user'),
						'errNum' => 402,
						'status' => false
					],200);
        	}
		}
		
	}
	
	public function logout()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
			'requireAuthorization' => true
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('customer_id', lang('Customer ID'), 'trim|required|numeric');

		if($this->form_validation->run() === FALSE){
					
			if(form_error('customer_id')){
				if($this->input->post('customer_id')==="" || !$this->input->post('customer_id')){
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(form_error('customer_id')),"errNum" => 1);
				}
			}
			
            $this->api_return([
						'message' => $data[0]['message'],
						'errNum' => $data[0]['errNum'],
						'status' => false
					],200);
					
		}else{
			$customer_info = get_this('customers',['id'=>$this->input->post('customer_id')]);
        	if ($customer_info) {
					//Reset device_reg_id
					$updates = ['device_reg_id' => ''];
					$this->Main_model->update('customers',['id'=>$customer_info['id']],$updates);
					///////////////////////////////////////////////////////////////////////////////
					$this->api_return([
						'message' => lang('Operation completed successfully'),
						'errNum' => 405,
						'status' => true
					],200);
        		
        	}else{
				$this->api_return([
						'message' => lang('Sorry, there are no data for this user'),
						'errNum' => 402,
						'status' => false
					],200);
        	}
		}
		
	}
}