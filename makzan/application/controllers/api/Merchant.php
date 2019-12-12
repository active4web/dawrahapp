<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/MobilySms.php';
/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Merchant extends REST_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    }
    public function settings_post(){
      $settings = get_this('settings',['id'=>1]);
      if ($settings) {
              $data['status'] = true;
              $data['settings'] = $settings;
              $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
      }else{
        $data['status'] = false;
        $data['message'] = 'عفوا لا توجد اي  اعدادات بقاعدة البيانات';
        $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
       } 
    }
    public function countries_post(){
      $countries = get_table('countries');
      if ($countries) {
        foreach ($countries as $country) {
          $result[] = [
                          'id'   => $country->id,
                          'name' => $country->name,
                      ];
        }
            if ($result) {
              $data['status'] = true;
              $data['countries'] = $result;
              $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
      }else{
        $data['status'] = true;
        $data['countries'] = [];
        $data['message'] = 'عفوا لا توجد اي دول مخزنة بقاعدة البيانات';
        $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
       } 
    }
    public function cities_post(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('country_id', 'الدولة', 'required|numeric');
        if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('country_id')){
                $data['country_id_error'] = strip_tags(form_error('country_id'));
                $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
        }else{
          $country = get_this('countries',['id'=>$this->post('country_id')]);
          if ($country) {
            $cities = get_table('cities',['country_id'=>$this->post('country_id')]);
            if ($cities) {
                foreach ($cities as $city) {
                  $result[] = [
                                  'id'           => $city->id,
                                  'name'         => $city->name,
                                  'country_name' => get_this('countries',['id' => $city->country_id],'name')
                              ];
                }if ($result) {
                      $data['status'] = true;
                      $data['cities'] = $result;
                      $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            }else{
                $data['status'] = true;
                $data['cities'] = [];
                $data['message'] = 'عفوا لاتوجد اي مدن تخص هذه الدولة';
                $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
          }else{
            $data['status'] = false;
            $data['message'] = 'عفوا لا توجد اي بيانات لهذه الدولة';
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
          } 
        }
    }
    public function pages_post(){
      $pages = get_table('pages');
      if ($pages) {
        foreach ($pages as $page) {
          $result[] = [
                          'page_id' => $page->id,
                          'title'   => $page->title,
                          'content' => $page->content,
                      ];
        }
            if ($result) {
              $data['status'] = true;
              $data['pages'] = $result;
              $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
      }else{
        $data['status'] = true;
        $data['pages'] = [];
        $data['message'] = 'عفوا لا توجد اي صفحات مخزنة بقاعدة البيانات';
        $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
       } 
    }
    public function page_post(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('page_id', 'رقم الصفحه', 'required|numeric');
        if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('page_id')){
                $data['page_id_error'] = strip_tags(form_error('page_id'));
                $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
        }else{
            $page = get_this('pages',['id'=>$this->post('page_id')]);
            if ($page) {
                  $result = [
                                  'page_id' => $page['id'],
                                  'title'   => $page['title'],
                                  'content' => $page['content']
                            ];
                 if ($result) {
                      $data['status'] = true;
                      $data['page'] = $result;
                      $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                 }
            }else{
                $data['status'] = true;
                $data['page'] = [];
                $data['message'] = 'عفوا لاتوجد اي صفحات تخص هذا الرقم';
                $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } 
        }
    }
    public function delivering_methods_post(){
      $delivering_methods = get_table('delivering_methods');
      if ($delivering_methods) {
        foreach ($delivering_methods as $method) {
          $result[] = [
                          'method_id' => $method->id,
                          'name'      => $method->name
                      ];
        }
            if ($result) {
              $data['status'] = true;
              $data['delivering_methods'] = $result;
              $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
      }else{
        $data['status'] = true;
        $data['delivering_methods'] = [];
        $data['message'] = 'عفوا لا توجد اي طرق توصيل مخزنة بقاعدة البيانات';
        $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
       } 
    }
    public function categories_post(){
      $categories = get_table('categories');
      if ($categories) {
        foreach ($categories as $method) {
          $result[] = [
                          'category_id' => $method->id,
                          'name'      => $method->name,
                          'image'     => base_url('assets/uploads/files/'.$method->image)
                      ];
        }
            if ($result) {
              $data['status'] = true;
              $data['categories'] = $result;
              $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
      }else{
        $data['status'] = true;
        $data['categories'] = [];
        $data['message'] = 'عفوا لا توجدياي تصنيفات مخزنة بقاعدة البيانات';
        $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
       } 
    }
    public function tickets_types_post(){
      $tickets_types = get_table('tickets_types');
      if ($tickets_types) {
        foreach ($tickets_types as $method) {
          $result[] = [
                          'type_id' => $method->id,
                          'name'      => $method->name,
                      ];
        }
            if ($result) {
              $data['status'] = true;
              $data['tickets_types'] = $result;
              $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
      }else{
        $data['status'] = true;
        $data['tickets_types'] = [];
        $data['message'] = 'عفوا لا توجدياي انواع للتذاكر مخزنة بقاعدة البيانات';
        $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
       } 
    }
    public function register_post(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('full_name', 'الاسم بالكامل', 'trim|required');
        $this->form_validation->set_rules('store_name', 'اسم المتجر', 'trim|required');
        $this->form_validation->set_rules('email', 'البريد الالكتروني', 'trim|required|valid_email|is_unique[merchants.email]');
        $this->form_validation->set_rules('phone', 'رقم الجوال', 'trim|required|numeric|is_unique[merchants.phone]|is_unique[customers.phone]');
        $this->form_validation->set_rules('country_id', 'الدولة', 'trim|required|numeric');
        $this->form_validation->set_rules('city_id', 'المدينة', 'trim|required|numeric');
        $this->form_validation->set_rules('password', 'كلمة المرور', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('bank_name', 'البنك', 'trim|required');
        $this->form_validation->set_rules('iban_account', 'رقم حساب ايبان', 'trim|required|numeric');
        if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('full_name'))
                $data['full_name_error'] = strip_tags(form_error('full_name'));
            if(form_error('store_name'))
                $data['store_name_error'] = strip_tags(form_error('store_name'));
            if(form_error('email'))
                $data['email_error'] = strip_tags(form_error('email'));
            if(form_error('phone'))
                $data['phone_error'] = strip_tags(form_error('phone'));
            if(form_error('country_id'))
                $data['country_id_error'] = strip_tags(form_error('country_id'));
            if(form_error('city_id'))
                $data['city_id_error'] = strip_tags(form_error('city_id'));
            if(form_error('password'))
                $data['password_error'] = strip_tags(form_error('password'));
            if(form_error('bank_name'))
                $data['bank_name_error'] = strip_tags(form_error('bank_name'));
            if(form_error('iban_account'))
                $data['iban_account_error'] = strip_tags(form_error('iban_account'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
             $store = [
                        'full_name'           => $this->post('full_name'),
                        'store_name'          => $this->post('store_name'),
                        'email'               => $this->post('email'),
                        'phone'               => $this->post('phone'),
                        'country_id'          => $this->post('country_id'),
                        'city_id'             => $this->post('city_id'),
                        'password'            => md5(md5(md5(sha1($this->post('password'))))),
                        'bank_name'           => $this->post('bank_name'),
                        'iban_account'        => $this->post('iban_account'),
                        'commercial_register' => $this->post('commercial_register'),
                        'created_at'          => date('Y-m-d'),
                        'status'              => 0,
                        'confirmed'           => 0
                      ];
	             $insert = $this->Main_model->insert('merchants',$store);
	             if($insert){
	              	  $merchant_info = get_this('merchants',['id' => $insert]);
	              	  unset($merchant_info['password']);
	              	  unset($merchant_info['verified']);
	              	  $merchant_info['image'] = base_url('assets/uploads/files/'.$merchant_info['image']);
	                  $data['status'] = true;
	                  $data['message'] = 'من فضلك ادخل كود التفعيل';
	                  $data['merchant'] = $merchant_info;
	                  $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
	             }else{
	                  $data['status'] = false;
	                  $data['message'] = 'خطأ في التسجيل';
	                  $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
	             }
        }
    }
    public function send_sms_post(){
    	$this->load->library('form_validation');
        $this->form_validation->set_rules('phone', 'رقم الجوال', 'trim|required|numeric');
        if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('phone'))
                $data['phone_error'] = strip_tags(form_error('phone'));
            	$this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
        	$verification_info = get_this('mobile_numbers',['mobile_number'=>$this->post('phone')]);
          if ($verification_info) {
              $code = $verification_info['verification_code'];
          }else{
              $code = generate_verification_code();
          }
        	$phone = $this->post('phone');
          $phone1 = ltrim($phone, '0');
          $country_id = get_this('merchants',['phone' => $phone],'country_id');
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
    			$numbers = $this->post('phone');
    			$result = $sms->sendMsgWK($msg,$numbers,'Makzan',$msgKey,'12:00:00',now(),0,'deleteKey','curl');
          $message_info = json_decode($result);
    			if($message_info->ResponseStatus == 'success'){
    			   $id = $this->Main_model->insert('mobile_numbers',$store);
    				 $data['status'] = true;
             $data['message'] = 'تم ارسال كود التفعيل بنجاح';
             $data['phone'] = $this->post('phone');
             $data['verification_code'] = $code;
             $data['verification_code_id'] = $id;
             $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
    			}else{
          	 $this->response($message_info, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
          }
        }
    }
    public function confirm_registration_post(){
    	$this->load->library('form_validation');
        $this->form_validation->set_rules('phone', 'رقم الجوال', 'trim|required|numeric');
        $this->form_validation->set_rules('verification_code', 'كود التفعيل', 'trim|required|exact_length[6]');
        $this->form_validation->set_rules('id', 'رقم عملية الارسال', 'trim|required');
        if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('phone'))
                $data['phone_error'] = strip_tags(form_error('phone'));
            if(form_error('verification_code'))
                $data['verification_code_error'] = strip_tags(form_error('verification_code'));
            if(form_error('id'))
                $data['id_error'] = strip_tags(form_error('id'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
        	$merchant_info = get_this('merchants',['phone'=>$this->post('phone'),'status'=>0]);
        	if ($merchant_info) {
        		$verification_info = get_this('mobile_numbers',['mobile_number'=>$merchant_info['phone'],'verification_code'=>$this->post('verification_code'),'verified'=>0]);
        		if ($verification_info) {
        			// $store = ['verified' => 1];
        			$update = ['status' => 1];
        			// $this->Main_model->update('mobile_numbers',['id'=>$verification_info['id']],$store);
        			$this->Main_model->update('merchants',['phone'=>$merchant_info['phone']],$update);
              $this->db->where('mobile_number',$merchant_info['phone'])->delete('mobile_numbers');
        			$data['status'] = true;
              $data['message'] = 'تم تفعيل الحساب بنجاح سيتم تاكيد الحساب من قبل الادارة واشعاركم ';
              $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        		}else{
        			$data['status'] = false;
              $data['message'] = 'يرجى التأكد من كود التفعيل واعادة المحاولة';
              $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        		}
        	}else{
        		  $data['status'] = false;
              $data['message'] = 'عفوا لا توجد اي بيانات تخص هذا التاجر';
              $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        	}
    	}
    }
    public function login_post(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('phone', 'رقم الجوال', 'required|numeric');
        $this->form_validation->set_rules('password', 'كبمة المرور', 'required');
        if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('phone'))
                $data['phone_error'] = strip_tags(form_error('phone'));
            if(form_error('password'))
                $data['password_error'] = strip_tags(form_error('password'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
          $merchant = get_this('merchants',['phone'=>$this->post('phone'),'password'=>md5(md5(md5(sha1($this->post('password')))))]);
          if ($merchant) {
             if ($merchant['status'] == 1) {
                 if ($merchant['confirmed'] == 1) {
                     unset($merchant['password']);
                     $merchant['country'] = get_this('countries',['id'=>$merchant['country_id']],'name');
                     $merchant['city'] = get_this('cities',['id'=>$merchant['city_id']],'name');
                     // $merchant['activation_status'] = 'حساب مفعل';
                     $merchant['image'] = base_url('assets/uploads/files/'.$merchant['image']);
                     $data['status'] = true;
                     $data['merchant'] = $merchant;
                     $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code 
                 }else{
                     $data['status'] = false;
                     $data['message'] = 'حساب لم تتم الموافقه عليه من قبل الادارة';
                     $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                 }
             }else{
                 $data['status'] = false;
                 $data['message'] = 'حساب غير مفعل';
                 $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
             }
          }else{
             $data['status'] = false;
             $data['message'] = 'عفوا لا توجد اي بيانات لهذا التاجر';
             $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
          }
        }
    }
    public function forget_password_post(){
    	$this->load->library('form_validation');
	    $this->form_validation->set_rules('phone', 'رقم الجوال', 'trim|required|numeric');
	    $this->form_validation->set_rules('verified', 'رقم الجوال', 'trim|required|numeric');
	    if ($this->post('verified') == 1) {
		    $this->form_validation->set_rules('verification_code', 'كود التفعيل', 'trim|required|exact_length[6]');
		    $this->form_validation->set_rules('id', 'رقم عملية الارسال', 'trim|required');
		    $this->form_validation->set_rules('password', 'كلمة المرور الجديدة', 'trim|required|min_length[6]');
	        $this->form_validation->set_rules('confirm_password', 'تأكيد كلمة المرور', 'trim|required|matches[password]');
	        if($this->form_validation->run() === FALSE){
		        $data['status'] = false;
		        if(form_error('phone'))
		            $data['phone_error'] = strip_tags(form_error('phone'));
		        if(form_error('verification_code'))
		            $data['verification_code_error'] = strip_tags(form_error('verification_code'));
		        if(form_error('id'))
		            $data['id_error'] = strip_tags(form_error('id'));
		        if(form_error('password'))
	                $data['password_error'] = strip_tags(form_error('password'));
	            if(form_error('confirm_password'))
	                $data['confirm_password_error'] = strip_tags(form_error('confirm_password'));
		        $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
	        }else{
		    	$merchant_info = get_this('merchants',['phone'=>$this->post('phone'),'status'=>2]);
	        	if ($merchant_info) {
	        		$verification_info = get_this('mobile_numbers',['mobile_number'=>$merchant_info['phone'],'verification_code'=>$this->post('verification_code'),'verified'=>0]);
	        		if ($verification_info) {
	        			$store = ['verified' => 1];
	        			$update = ['password' => md5(md5(md5(sha1($this->post('password')))))];
	        			// $this->Main_model->update('mobile_numbers',['id'=>$verification_info['id']],$store);
	        			$this->Main_model->update('merchants',['phone'=>$merchant_info['phone']],$update);
                $this->db->where('mobile_number',$merchant_info['phone'])->delete('mobile_numbers');
	        			$data['status'] = true;
	                    $data['message'] = 'تم تغيير كلمة المرور بنجاح';
	                    $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
	        		}else{
	        			$data['status'] = false;
	                    $data['message'] = 'يرجى التاكد من البيانات المدخله واعادة المحاولة';
	                    $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
	        		}
	        	}else{
	        		$data['status'] = false;
	                $data['message'] = 'عفوا لا توجد اي بيانات تخص هذا التاجر';
	                $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
	        	}
	    	}
	    }else{
				$data['status'] = false;
	            $data['message'] = 'يرجى التأكد من كود التفعيل واعادة المحاولة';
	            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
	        		}
    }
    public function tickets_post(){
      $this->load->library('form_validation');
      $this->form_validation->set_rules('merchant_id', 'رقم التاجر', 'trim|required|numeric');
      $this->form_validation->set_rules('limit', 'عدد العناصر الظاهره', 'trim|required|numeric');
      $this->form_validation->set_rules('page_number', 'رقم الصفحه', 'trim|required|numeric');
      if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('merchant_id'))
                $data['merchant_id_error'] = strip_tags(form_error('merchant_id'));
            if(form_error('limit'))
                $data['limit_error'] = strip_tags(form_error('limit'));
            if(form_error('page_number'))
                $data['page_number_error'] = strip_tags(form_error('page_number'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
          $merchant = get_this('merchants',['id'=>$this->post('merchant_id')]);
          if ($merchant) {
             if ($merchant['status'] == 1) {
                 if ($merchant['confirmed'] == 1) {
                     $offset = $this->post('limit') * $this->post('page_number');
                      $where['created_by'] = $merchant['id'];
                      $where['type'] = 0;
                      $tickets = $this->db->order_by('created_at','DESC')
                                          ->get_where('tickets',$where,$this->post('limit'),$offset)
                                          ->result();
                      if ($tickets) {
                        foreach ($tickets as $ticket) {
                          $result[] = [
                                            'id'      => $ticket->id,
                                            'title'   => get_this('tickets_types',['id' => $ticket->ticket_type_id],'name'),
                                            'content' => $ticket->content
                                ];
                        }
                          if ($result) {
                                  $data['status'] = true;
                                  $data['my_tickets'] = $result;
                                  $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                              }
                      }else{
                            $data['status'] = false;
                            $data['message'] = 'عفوا لا توجد اي تذاكر خاصه بك';
                            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                     }
                 }else{
                     $data['status'] = false;
                     $data['message'] = 'حساب لم تتم الموافقه عليه من قبل الادارة';
                     $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                 }
             }else{
                 $data['status'] = false;
                 $data['message'] = 'حساب غير مفعل';
                 $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
             }
          }else{
             $data['status'] = false;
             $data['message'] = 'عفوا لا توجد اي بيانات لهذا التاجر';
             $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
          }
        }
    }
    public function ticket_post(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('merchant_id', 'رقم التاجر', 'required|numeric');
        $this->form_validation->set_rules('ticket_id', 'رقم التذكرة', 'required|numeric');
        if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('merchant_id'))
                $data['merchant_id_error'] = strip_tags(form_error('merchant_id'));
            if(form_error('ticket_id'))
                $data['ticket_id_error'] = strip_tags(form_error('ticket_id'));  
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
          $merchant = get_this('merchants',['id'=>$this->post('merchant_id')]);
          if ($merchant) {
             if ($merchant['status'] == 1) {
                 if ($merchant['confirmed'] == 1) {
                     $ticket = get_this('tickets',['id'=>$this->post('ticket_id'),'created_by'=>$this->post('merchant_id'),'type'=>0]);
                    if ($ticket) {
                          $result = [
                                          'ticket_id' => $ticket['id'],
                                          'title'     => get_this('tickets_types',['id' => $ticket['ticket_type_id']],'name'),
                                          'content'   => $ticket['content']
                                      ];
                         if ($result) {
                              $data['status'] = true;
                              $data['ticket_info']['ticket'] = $result;
                              $ticket_replies = get_table('tickets_replies',['ticket_id'=>$ticket['id']]);
                              $replies = [];
                              if ($ticket_replies) {
                                foreach ($ticket_replies as $reply) {
                                          $replies[] =[
                                                        'id'         => $reply->id,
                                                        'created_at' => $reply->created_at,
                                                        'time'       => $reply->time,
                                                        'content'    => $reply->content,
                                                        'sender'     => ($reply->reply_type == '2') ? 'خدمة العملاء' : get_this('merchants',['id' => $reply->created_by],'full_name')
                                                      ]; 
                               }
                               $data['ticket_info']['replies_number'] = get_table('tickets_replies',['ticket_id'=>$ticket['id']],'count');
                               $data['ticket_info']['ticket_replies'] = $replies;
                              }else{
                                $data['ticket_info']['ticket_replies'] = [];
                              }
                              $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                         }
                    }else{
                        $data['status'] = true;
                        $data['ticket'] = [];
                        $data['message'] = 'عفوا لا توجد اي تذاكر بهذه الارقام';
                        $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                    }  


                      
                 }else{
                     $data['status'] = false;
                     $data['message'] = 'حساب لم تتم الموافقه عليه من قبل الادارة';
                     $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                 }
             }else{
                 $data['status'] = false;
                 $data['message'] = 'حساب غير مفعل';
                 $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
             }
          }else{
             $data['status'] = false;
             $data['message'] = 'عفوا لا توجد اي بيانات لهذا التاجر';
             $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
          } 
        }
    }
    public function new_ticket_post(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('merchant_id', 'رقم التاجر', 'trim|required|numeric');
        $this->form_validation->set_rules('ticket_type_id', 'نوع المراسلة', 'trim|required|numeric');
        $this->form_validation->set_rules('content', 'المحتوى', 'trim|required');
        if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('merchant_id'))
                $data['merchant_id_error'] = strip_tags(form_error('merchant_id'));
            if(form_error('ticket_type_id'))
                $data['ticket_type_id_error'] = strip_tags(form_error('ticket_type_id'));
            if(form_error('content'))
                $data['content_error'] = strip_tags(form_error('content'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $merchant = get_this('merchants',['id'=>$this->post('merchant_id')]);
            if ($merchant) {
               if ($merchant['status'] == 1) {
                   if ($merchant['confirmed'] == 1) {
                       $store = [
                        'created_by'     => $this->post('merchant_id'),
                        'ticket_type_id' => $this->post('ticket_type_id'),
                        'content'        => $this->post('content'),
                        'created_at'     => date('Y-m-d'),
                        'type'           => 0
                      ];
                    $insert = $this->Main_model->insert('tickets',$store);
                    if($insert){
                        $data['status'] = true;
                        $data['message'] = 'تم انشاء التذكرة بنجاح';
                        $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                    }else{
                        $data['status'] = false;
                        $data['message'] = 'خطأ في الانشاء';
                        $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                    }  
                   }else{
                       $data['status'] = false;
                       $data['message'] = 'حساب لم تتم الموافقه عليه من قبل الادارة';
                       $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                   }
               }else{
                   $data['status'] = false;
                   $data['message'] = 'حساب غير مفعل';
                   $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
               }
            }else{
               $data['status'] = false;
               $data['message'] = 'عفوا لا توجد اي بيانات لهذا التاجر';
               $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
        }
    }
    public function new_reply_post(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('ticket_id', 'رقم التذكرة', 'trim|required|numeric');
        $this->form_validation->set_rules('merchant_id', 'رقم التاجر', 'trim|required|numeric');
        $this->form_validation->set_rules('content', 'المحتوى', 'trim|required');
        if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('ticket_id'))
                $data['ticket_id_error'] = strip_tags(form_error('ticket_id'));
            if(form_error('merchant_id'))
                $data['merchant_id_error'] = strip_tags(form_error('merchant_id'));
            if(form_error('content'))
                $data['content_error'] = strip_tags(form_error('content'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $merchant = get_this('merchants',['id'=>$this->post('merchant_id')]);
            if ($merchant) {
               if ($merchant['status'] == 1) {
                   if ($merchant['confirmed'] == 1) {
                       $ticket = get_this('tickets',['id'=>$this->post('ticket_id'),'created_by'=>$merchant['id'],'type'=>0]); 
                       if ($ticket) {
                           $store = [
                                      'created_by' => $merchant['id'],
                                      'ticket_id'  => $ticket['id'],
                                      'content'    => $this->post('content'),
                                      'created_at' => date('Y-m-d'),
                                      'reply_type' => 0,
                                      'created_at' => date('Y-m-d'),
                                      'time'       => date('h:i:s')
                                    ];
                            $insert = $this->Main_model->insert('tickets_replies',$store);
                            if($insert){
                                $data['status'] = true;
                                $data['message'] = 'تم ارسال الرد بنجاح';
                                $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                            }else{
                                $data['status'] = false;
                                $data['message'] = 'خطأ في الارسال';
                                $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                            }
                       }else{
                           $data['status'] = false;
                           $data['message'] = 'عفوا لا توجد تذاكر بهذا الرقم';
                           $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                       }
                   }else{
                       $data['status'] = false;
                       $data['message'] = 'حساب لم تتم الموافقه عليه من قبل الادارة';
                       $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                   }
               }else{
                   $data['status'] = false;
                   $data['message'] = 'حساب غير مفعل';
                   $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
               }
            }else{
               $data['status'] = false;
               $data['message'] = 'عفوا لا توجد اي بيانات لهذا التاجر';
               $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
        }
    }
    public function add_product_post(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('merchant_id', 'رقم التاجر', 'trim|required|numeric');
        $this->form_validation->set_rules('name', 'اسم المنتج', 'trim|required');
        $this->form_validation->set_rules('description', 'تفاصيل المنتج', 'trim|required');
        $this->form_validation->set_rules('price', 'سعر المنتج', 'trim|required|numeric');
        $this->form_validation->set_rules('available_quantity', 'الكمية المتاحه', 'trim|required|numeric');
        $this->form_validation->set_rules('category_id', 'تصنيف المنتج', 'trim|required|numeric');
        $this->form_validation->set_rules('type', 'حالة المنتج', 'trim|required|numeric');
        $this->form_validation->set_rules('main_image', 'صورة المنتج', 'required');
        if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('merchant_id'))
                $data['merchant_id_error'] = strip_tags(form_error('merchant_id'));
            if(form_error('name'))
                $data['name_error'] = strip_tags(form_error('name'));
            if(form_error('description'))
                $data['description_error'] = strip_tags(form_error('description'));
            if(form_error('price'))
                $data['price_error'] = strip_tags(form_error('price'));
            if(form_error('available_quantity'))
                $data['available_quantity_error'] = strip_tags(form_error('available_quantity'));
            if(form_error('category_id'))
                $data['category_id_error'] = strip_tags(form_error('category_id'));
            if(form_error('type'))
                $data['type_error'] = strip_tags(form_error('type'));
            if(form_error('main_image'))
                $data['main_image_error'] = strip_tags(form_error('main_image'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $merchant = get_this('merchants',['id'=>$this->post('merchant_id')]);
            if ($merchant) {
               if ($merchant['status'] == 1) {
                   if ($merchant['confirmed'] == 1) {
                       $store = [
                                    'created_by' => $this->post('merchant_id'),
                                    'name'  => $this->post('name'),
                                    'description'    => $this->post('description'),
                                    'price'    => $this->post('price'),
                                    'available_quantity'    => $this->post('available_quantity'),
                                    'category_id'    => $this->post('category_id'),
                                    'type'    => $this->post('type'),
                                    'created_at' => date('Y-m-d'),
                                    'status' => 1,
                                    // 'store_name' => $merchant_id['store_name']
                              ];
                      $image = $this->m_image->base64_upload($this->post('main_image'));
                      $store['main_image'] = $image;   
                      $insert = $this->Main_model->insert('products',$store);
                      $colors  = $this->post('colors');
                      if ($colors) {
                          foreach ($colors as $color) {
                            $store_color = ['product_id'=>$insert,'color'=>$color];
                            $this->db->insert('product_colors',$store_color);
                          }
                      }    
                      if($insert){
                          $product_details = get_this('products',['id'=>$insert]);
                          $product_colors = get_table('product_colors',['product_id'=>$insert]);
                          $product_details['main_image'] = base_url('assets/uploads/files/'.$product_details['main_image']);
                          $data['status'] = true;
                          $data['message'] = 'تمت الاضافة بنجاح';
                          $data['product_details'] = $product_details;
                          $data['product_details']['colors'] = $product_colors;
                          $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                      }else{
                          $data['status'] = false;
                          $data['message'] = 'خطأ في الاضافة';
                          $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                      } 


                        
                   }else{
                       $data['status'] = false;
                       $data['message'] = 'حساب لم تتم الموافقه عليه من قبل الادارة';
                       $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                   }
               }else{
                   $data['status'] = false;
                   $data['message'] = 'حساب غير مفعل';
                   $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
               }
            }else{
               $data['status'] = false;
               $data['message'] = 'عفوا لا توجد اي بيانات لهذا التاجر';
               $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
        }
    }
    public function add_product_image_post(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('image_name', 'صورة المنتج', 'trim|required');
        $this->form_validation->set_rules('product_id', 'رقم المنتج', 'trim|required|numeric');
        if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('image_name'))
                $data['image_name_error'] = strip_tags(form_error('image_name'));
            if(form_error('product_id'))
                $data['product_id_error'] = strip_tags(form_error('product_id'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $product_info = get_this('products',['id'=>$this->post('product_id')]);
            if ($product_info) {
              $store = [
                          'product_id' => $product_info['id'],
                          'created_at' => date('Y-m-d')
                       ];
              $image = $this->m_image->base64_upload($this->post('image_name'));
              $store['image_name'] = $image;   
              $insert = $this->Main_model->insert('product_images',$store);
              if($insert){
                      $data['status'] = true;
                      $data['message'] = 'تمت الاضافة بنجاح';
                      $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
              }else{
                      $data['status'] = false;
                      $data['message'] = 'خطأ في الاضافة';
                      $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
              }
            }else{
              $data['status'] = false;
              $data['message'] = 'عفوا لا يوجد اي منتج بهذا الرقم';
              $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
        } 
    }
    public function remove_product_image_post(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('image_id', 'رقم الصورة', 'trim|required|numeric');
        if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('image_id'))
                $data['image_id_error'] = strip_tags(form_error('image_id'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $image_id = get_this('product_images',['id'=>$this->post('image_id')],'id');
            if ($image_id) {
                 $this->Main_model->delete('product_images',['id'=>$image_id]);
                 $data['status'] = true;
                 $data['message'] = 'تم الحذف بنجاح';
                 $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }else{
                 $data['status'] = false;
                 $data['message'] = 'عفوا لاتوجد صور بهذا الرقم';
                 $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
        }
    }
    public function close_product_post(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('product_id', 'رقم المنتج', 'trim|required|numeric');
        if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('product_id'))
                $data['product_id_error'] = strip_tags(form_error('product_id'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $product_info = get_this('products',['id' => $this->post('product_id')]);
            if ($product_info) {
              if ($product_info['status'] == 0) {
                 $data['status'] = false;
                 $data['message'] = 'عفوا هذا المنتج مغلق بالفعل';
                 $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
              }else{
                 $store['status'] = 0;
                 unset($store['product_id']);
                 $this->Main_model->update('products',['id'=>$product_info['id']],$store);
                 $data['status'] = true;
                 $data['message'] = 'تم اغلاق المنتج بنجاح';
                 $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
              }
            }else{
                 $data['status'] = false;
                 $data['message'] = 'عفوا لاتوجد منتجات بهذا الرقم';
                 $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
        }
    }
    public function open_product_post(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('product_id', 'رقم المنتج', 'trim|required|numeric');
        if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('product_id'))
                $data['product_id_error'] = strip_tags(form_error('product_id'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $product_info = get_this('products',['id' => $this->post('product_id')]);
            if ($product_info) {
              if ($product_info['status'] == 1) {
                 $data['status'] = false;
                 $data['message'] = 'عفوا هذا المنتج مفعل بالفعل';
                 $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
              }else{
                 $store['status'] = 1;
                 unset($store['product_id']);
                 $this->Main_model->update('products',['id'=>$product_info['id']],$store);
                 $data['status'] = true;
                 $data['message'] = 'تم اعادة فتح المنتج بنجاح';
                 $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
              }
            }else{
                 $data['status'] = false;
                 $data['message'] = 'عفوا لاتوجد منتجات بهذا الرقم';
                 $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
        }
    }
    public function my_products_post(){
      $this->load->library('form_validation');
      $this->form_validation->set_rules('merchant_id', 'رقم التاجر', 'trim|required|numeric');
      $this->form_validation->set_rules('limit', 'عدد العناصر الظاهره', 'trim|required|numeric');
      $this->form_validation->set_rules('page_number', 'رقم الصفحه', 'trim|required|numeric');
      if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('merchant_id'))
                $data['merchant_id_error'] = strip_tags(form_error('merchant_id'));
            if(form_error('limit'))
                $data['limit_error'] = strip_tags(form_error('limit'));
            if(form_error('page_number'))
                $data['page_number_error'] = strip_tags(form_error('page_number'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $merchant = get_this('merchants',['id'=>$this->post('merchant_id')]);
            if ($merchant) {
               if ($merchant['status'] == 1) {
                   if ($merchant['confirmed'] == 1) {
                      $offset = $this->post('limit') * $this->post('page_number');
                      $where['created_by'] = $merchant['id'];
                      $products = $this->db->order_by('created_at','DESC')
                                           ->get_where('products',$where,$this->post('limit'),$offset)
                                           ->result();
                      if ($products) {
                        foreach ($products as $product) {
                          $result[] = [
                                          'id'                 => $product->id,
                                          'name'               => $product->name,
                                          'price'              => $product->price,
                                          'available_quantity' => $product->available_quantity,
                                          'product_status'     => ($product->status == 0)?'مغلق':'مفتوح',
                                          'main_image'         => base_url('assets/uploads/files/'.$product->main_image)
                                ];
                        }
                          if ($result) {
                                  $data['status'] = true;
                                  $data['my_products'] = $result;
                                  $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                              }
                      }else{
                            $data['status'] = false;
                            $data['my_products'] = [];
                            $data['message'] = 'عفوا لا توجد اي منتجات خاصه بك';
                            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                     }  


                        
                   }else{
                       $data['status'] = false;
                       $data['message'] = 'حساب لم تتم الموافقه عليه من قبل الادارة';
                       $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                   }
               }else{
                   $data['status'] = false;
                   $data['message'] = 'حساب غير مفعل';
                   $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
               }
            }else{
               $data['status'] = false;
               $data['message'] = 'عفوا لا توجد اي بيانات لهذا التاجر';
               $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
        }
    }
    public function edit_product_post(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('product_id', 'رقم المنتج', 'trim|required|numeric');
        if($this->post('name') === "" || $this->post('name') != null)
            $this->form_validation->set_rules('name', 'اسم المنتج', 'trim|required');
        if($this->post('description') === "" || $this->post('description') != null)
            $this->form_validation->set_rules('description', 'وصف المنتج', 'trim|required');
        if($this->post('price') === "" || $this->post('price') != null)
            $this->form_validation->set_rules('price', 'سعر المنتج', 'trim|required|numeric');
        if($this->post('available_quantity') === "" || $this->post('available_quantity') != null)
            $this->form_validation->set_rules('available_quantity', 'الكمية المتاحه', 'trim|required|numeric');
        if($this->post('category_id') === "" || $this->post('category_id') != null)
            $this->form_validation->set_rules('category_id', 'تصنيف المنتج', 'trim|required|numeric');
        if($this->post('type') === "" || $this->post('type') != null)
            $this->form_validation->set_rules('type', 'حالة المتاحه', 'trim|required|numeric');
        if($this->post('main_image') === "")
            $this->form_validation->set_rules('main_image', 'صورة المنتج', 'trim|required');
        if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('product_id'))
                $data['product_id_error'] = strip_tags(form_error('product_id'));
            if(form_error('name'))
                $data['name_error'] = strip_tags(form_error('name'));
            if(form_error('description'))
                $data['description_error'] = strip_tags(form_error('description'));
            if(form_error('price'))
                $data['price_error'] = strip_tags(form_error('price'));
            if(form_error('available_quantity'))
                $data['available_quantity_error'] = strip_tags(form_error('available_quantity'));
            if(form_error('category_id'))
                $data['category_id_error'] = strip_tags(form_error('category_id'));
            if(form_error('type'))
                $data['type_error'] = strip_tags(form_error('type'));
            if(form_error('main_image'))
                $data['main_image_error'] = strip_tags(form_error('main_image'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $product_info = get_this('products',['id' => $this->post('product_id')]);
            if ($product_info) {
                 $id = $product_info['id'];
                 $store = $this->post();
                 unset($store['product_id']);
                 unset($store['created_by']);
                 if ($this->post('main_image')) {
                     $image = $this->m_image->base64_upload($this->post('main_image'));
                     $store['main_image'] = $image;
                 }
                 if (empty($store)) {
                     $data['status'] = false;
                     $data['message'] = 'يرجى ادخال بيانات للتعديل';
                     $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                 }else{
                     unset($store['colors']);
                     $this->Main_model->update('products',['id'=>$product_info['id']],$store);
                     $colors  = $this->post('colors');
                     if ($colors) {
                         $this->db->where('product_id',$product_info['id'])->delete('product_colors');
                         foreach ($colors as $color) {
                            $store_color = ['product_id'=>$product_info['id'],'color'=>$color];
                            $this->db->insert('product_colors',$store_color);
                         }
                     }    
                     $product = get_this('products',['id' => $id]);
                     $product_colors = get_table('product_colors',['product_id'=>$product_info['id']]);
                     $product['status'] = ($product['status'] == 0)?'مغلق':'مفتوح';
                     $product['type'] = ($product['type'] == 0)?'جديد':'مشتعمل';
                     $product['main_image'] = base_url('assets/uploads/files/'.get_this('products',['id'=>$product['id']],'main_image'));
                     $data['status'] = true;
                     $data['message'] = 'تم التعديل بنجاح';
                     $data['product_info'] = $product;
                     $data['product_info']['colors'] = $product_colors;
                     $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                 }
            }else{
                 $data['status'] = false;
                 $data['message'] = 'عفوا لاتوجد منتجات بهذا الرقم';
                 $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
        }
    }
    public function orders_statuses_post(){
      $orders_statuses = get_table('orders_statuses');
      if ($orders_statuses) {
        foreach ($orders_statuses as $status) {
          $result[] = [
                          'status_id' => $status->id,
                          'name'      => $status->name,
                      ];
        }
            if ($result) {
              $data['status'] = true;
              $data['orders_statuses'] = $result;
              $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
      }else{
        $data['status'] = true;
        $data['orders_statuses'] = [];
        $data['message'] = 'عفوا لا توجد اي حالات للطلبات مخزة بقاعدة البيانات';
        $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
       } 
    }
    public function my_current_orders_post(){
      $this->load->library('form_validation');
      $this->form_validation->set_rules('merchant_id', 'رقم التاجر', 'trim|required|numeric');
      $this->form_validation->set_rules('limit', 'عدد العناصر الظاهره', 'trim|required|numeric');
      $this->form_validation->set_rules('page_number', 'رقم الصفحه', 'trim|required|numeric');
      if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('merchant_id'))
                $data['merchant_id_error'] = strip_tags(form_error('merchant_id'));
            if(form_error('limit'))
                $data['limit_error'] = strip_tags(form_error('limit'));
            if(form_error('page_number'))
                $data['page_number_error'] = strip_tags(form_error('page_number'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
              $merchant = get_this('merchants',['id'=>$this->post('merchant_id')]);
              if ($merchant) {
                 if ($merchant['status'] == 1) {
                     if ($merchant['confirmed'] == 1) {
                        $offset = $this->post('limit') * $this->post('page_number');
                        $where['merchant_id'] = $merchant['id'];
                        $orders = $this->db->order_by('created_at','DESC')
                                           ->where('status_id !=',4)
                                           ->get_where('sub_orders',$where,$this->post('limit'),$offset)
                                           ->result();
                        if ($orders) {
                          foreach ($orders as $order) {
                            $result[] = [
                                            'id'            => $order->id,
                                            'main_order_id' => $order->main_order_id,
                                            'total'         => $order->total,
                                            'status'        => get_this('orders_statuses',['id'=>$order->status_id],'name'),
                                        ];        
                        
                          }
                            if ($result) {
                                    $data['status'] = true;
                                    $data['my_orders'] = $result;
                                    $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                                }
                        }else{
                              $data['status'] = false;
                              $data['my_orders'] = [];
                              $data['message'] = 'عفوا لا توجد اي طلبات خاصه بك';
                              $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                       }


                          
                     }else{
                         $data['status'] = false;
                         $data['message'] = 'حساب لم تتم الموافقه عليه من قبل الادارة';
                         $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                     }
                 }else{
                     $data['status'] = false;
                     $data['message'] = 'حساب غير مفعل';
                     $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                 }
              }else{
                 $data['status'] = false;
                 $data['message'] = 'عفوا لا توجد اي بيانات لهذا التاجر';
                 $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
              }
        }
    }
    public function my_finised_orders_post(){
      $this->load->library('form_validation');
      $this->form_validation->set_rules('merchant_id', 'رقم التاجر', 'trim|required|numeric');
      $this->form_validation->set_rules('limit', 'عدد العناصر الظاهره', 'trim|required|numeric');
      $this->form_validation->set_rules('page_number', 'رقم الصفحه', 'trim|required|numeric');
      if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('merchant_id'))
                $data['merchant_id_error'] = strip_tags(form_error('merchant_id'));
            if(form_error('limit'))
                $data['limit_error'] = strip_tags(form_error('limit'));
            if(form_error('page_number'))
                $data['page_number_error'] = strip_tags(form_error('page_number'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
          $merchant = get_this('merchants',['id'=>$this->post('merchant_id')]);
          if ($merchant) {
             if ($merchant['status'] == 1) {
                 if ($merchant['confirmed'] == 1) {
                      $offset = $this->post('limit') * $this->post('page_number');
                      $where['merchant_id'] = $merchant['id'];
                      $where['status_id'] = 4;
                      $orders = $this->db->order_by('created_at','DESC')
                                         ->get_where('sub_orders',$where,$this->post('limit'),$offset)
                                         ->result();
                      if ($orders) {
                        foreach ($orders as $order) {
                          $result[] = [
                                          'id'            => $order->id,
                                          'main_order_id' => $order->main_order_id,
                                          'total'         => $order->total,
                                          'status'        => get_this('orders_statuses',['id'=>$order->status_id],'name')
                                      ];
                        }
                          if ($result) {
                                  $data['status'] = true;
                                  $data['my_orders'] = $result;
                                  $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                              }
                      }else{
                            $data['status'] = false;
                            $data['my_orders'] = [];
                            $data['message'] = 'عفوا لا توجد اي طلبات خاصه بك';
                            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                     }  


                      
                 }else{
                     $data['status'] = false;
                     $data['message'] = 'حساب لم تتم الموافقه عليه من قبل الادارة';
                     $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                 }
             }else{
                 $data['status'] = false;
                 $data['message'] = 'حساب غير مفعل';
                 $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
             }
          }else{
             $data['status'] = false;
             $data['message'] = 'عفوا لا توجد اي بيانات لهذا التاجر';
             $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
          }
        }
    }
    public function oredr_details_post(){
      $this->load->library('form_validation');
      $this->form_validation->set_rules('sub_order_id', 'رقم الطلب', 'trim|required|numeric');
      if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('sub_order_id'))
                $data['sub_order_id_error'] = strip_tags(form_error('sub_order_id'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $order_info = get_this('sub_orders',['id'=>$this->post('sub_order_id')]);
            if ($order_info) {
                 $main_order = get_this('main_orders',['id'=>$order_info['main_order_id']]);
                 $result = [
                              'main_order_id' => $order_info['main_order_id'],
                              'sub_order_id' => $order_info['id'],
                              'payment_method' => get_this('payment_methods',['id'=>$main_order['payment_method_id']],'name'),
                              'payment_status' => ($main_order == 0)?'لم يتم الدفع':'تم الدفع',
                              'delivering_method' => get_this('delivering_methods',['id'=>$order_info['delivering_method_id']],'name'),
                              'tax' => $order_info['tax'],
                              'delivering_method_price' => $order_info['delivering_method_price'],
                              'sub_total'=> $order_info['sub_total'],
        					  'total'=> $order_info['total'],
                              'order_status' => get_this('orders_statuses',['id'=>$order_info['status_id']],'name')
                           ];
                 $data['status'] = true;
                 $order_items = get_table('order_items',['sub_order_id'=>$order_info['id']]);
                 $items = [];
                 if ($order_items) {
                   foreach ($order_items as $item) {
                                  $items[] =[
                                                'id'                  => $item->id,
                                                'product_id'          => $item->product_id,
                                                'product_price'       => $item->product_price,
                                                'product_name'        => $item->product_name,
                                                'product_description' => get_this('products',['id'=>$item->product_id],'description'),
                                                'quantity'            => $item->quantity,
                                                'total'               => $item->total,
                                                'product_image'       => base_url('assets/uploads/files/'.get_this('products',['id'=>$item->product_id],'main_image'))
                                              ]; 
                       }
                   $customer = get_this('customers',['id'=>$order_info['customer_id']]);
                   $customer_data = [];
                   $customer_data = [
                                        'customer_id'    => $customer['id'],
                                        'customer_name'  => $customer['full_name'],
                                        'customer_phone' => $customer['phone'],
                                        'country_name'   => get_this('countries',['id' => $customer['country_id']],'name'),
                                        'address'        => $main_order['address'],
                                        /*'latitude'       => $main_order['latitude'],
                                        'langitude'      => $main_order['langitude'],*/
                                    ];
                   $data['order']['order_user'] = $customer_data; 
                   $data['order']['order_details'] = $result;
                   $data['order']['order_items'] = $items; 
                   $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code   
                 }

            }else{
                $data['status'] = false;
                $data['message'] = 'عفوا لا توجد اي طلبات بهذه الارقام';
                $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }

        }
    }
    public function change_order_status_post(){
      $this->load->library('form_validation');
      $this->form_validation->set_rules('sub_order_id', 'رقم الطلب', 'trim|required|numeric');
      if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('sub_order_id'))
                $data['sub_order_id_error'] = strip_tags(form_error('sub_order_id'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
      }else{
            $order_info = get_this('sub_orders',['id'=>$this->post('sub_order_id')]);
            if ($order_info) {
                if ($order_info['status_id'] == 1) {
                    $store['status_id'] = 2;
                    $this->Main_model->update('sub_orders',['id'=>$order_info['id']],$store);
                    $data['status'] = true;
                    $data['order_status'] = get_this('orders_statuses',['id'=>$store['status_id']],'name');
                    $data['message'] = 'تمت عملية تعديل حالة الطلب من الانتظار الى جاري تجهيز الطلب';
                    $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                }elseif ($order_info['status_id'] == 2) {
                    $store['status_id'] = 3;
                    $this->Main_model->update('sub_orders',['id'=>$order_info['id']],$store);
                    $data['status'] = true;
                    $data['order_status'] = get_this('orders_statuses',['id'=>$store['status_id']],'name');
                    $data['message'] = 'تمت عملية تعديل الطلب من جاري التجهيز الى تم شحن الطلب';
                    $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                }elseif ($order_info['status_id'] == 3) {
                    $store['status_id'] = 4;
                    $this->Main_model->update('sub_orders',['id'=>$order_info['id']],$store);
                    $data['status'] = true;
                    $data['order_status'] = get_this('orders_statuses',['id'=>$store['status_id']],'name');
                    $data['message'] = 'تمت عملية تعديل الطلب من تم الشحن الى تم استلام الطلب';
                    $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                }else{
                    $data['status'] = false;
                    $data['message'] = 'عفوا لا يمكنك تغيير حالة الطلب';
                    $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                }
            }else{
                $data['status'] = false;
                $data['message'] = 'عفوا لا توجد اي طلبات بهذه الارقام';
                $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
      }
    }
    public function my_credit_post(){
      $this->load->library('form_validation');
      $this->form_validation->set_rules('merchant_id','رقم التاجر','trim|required|numeric');
      if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('merchant_id'))
                $data['merchant_id_error'] = strip_tags(form_error('merchant_id'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
      }else{
        $merchant = get_this('merchants',['id'=>$this->post('merchant_id')]);
        if ($merchant) {
           if ($merchant['status'] == 1) {
               if ($merchant['confirmed'] == 1) {
                   $data['status'] = true;
                   $data['credit'] = $merchant['credit'];
                   $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
               }else{
                   $data['status'] = false;
                   $data['message'] = 'حساب لم تتم الموافقه عليه من قبل الادارة';
                   $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
               }
           }else{
               $data['status'] = false;
               $data['message'] = 'حساب غير مفعل';
               $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
           }
        }else{
           $data['status'] = false;
           $data['message'] = 'عفوا لا توجد اي بيانات لهذا التاجر';
           $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
      }
    }
    public function withdraw_balance_post(){
      $min_balance = get_this('settings',['id' => 1],'min_balance');	
      $this->load->library('form_validation');
      $this->form_validation->set_rules('merchant_id', 'رقم التاجر', 'trim|required|numeric');
      $this->form_validation->set_rules('quantity', 'الرصيد', 'trim|required|numeric');
      if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('merchant_id'))
                $data['merchant_id_error'] = strip_tags(form_error('merchant_id'));
              if(form_error('quantity'))
                $data['quantity_error'] = strip_tags(form_error('quantity'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
      }else{
        $merchant = get_this('merchants',['id'=>$this->post('merchant_id')]);
        if ($merchant) {
           if ($merchant['status'] == 1) {
               if ($merchant['confirmed'] == 1) {
                   if ($merchant['credit'] < $min_balance) {
                         $data['status'] = false;
                         $data['message'] = 'عفوا لا يمكنك سحب الرصيد حيث رصيدكم اقل من الحد الادني لسحب الرصيد';
                         $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                     }else{
                         $store = [
                                    'merchant_id' => $this->post('merchant_id'),
                                    'quantity'    => $this->post('quantity')
                                  ];
                         if ($store['quantity'] < $min_balance) {
                             $data['status'] = false;
                             $data['message'] = 'عفوا لا يمكن سحب الرصيد فيجب ان تكون القيمه المسحوبة اعلى من الحد الادني لسحب الرصيد';
                             $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                         }
                         elseif ($store['quantity'] > $merchant['credit']) {
                             $data['status'] = false;
                             $data['message'] = 'عفوا رصيدكم الحالي لا يسمح لاتمام عملية السحب';
                             $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                         }
                         else{
                             $this->Main_model->insert('withdraw_balance_requsets',$store);
                             $data['status'] = true;
                             $data['message'] = 'تم ارسال طلب سحب الرصيد بنجاح';
                             $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code  
                         }
                     }
               }else{
                   $data['status'] = false;
                   $data['message'] = 'حساب لم تتم الموافقه عليه من قبل الادارة';
                   $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
               }
           }else{
               $data['status'] = false;
               $data['message'] = 'حساب غير مفعل';
               $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
           }
        }else{
           $data['status'] = false;
           $data['message'] = 'عفوا لا توجد اي بيانات لهذا التاجر';
           $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
      }
    }
    public function add_delivering_method_post(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('merchant_id', 'رقم التاجر', 'trim|required|numeric');
        $this->form_validation->set_rules('method_id', 'رقم طريقه التوصيل', 'trim|required|numeric');
        $this->form_validation->set_rules('method_price', 'السعر', 'trim|required|numeric');
        if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('merchant_id'))
                $data['merchant_id_error'] = strip_tags(form_error('merchant_id'));
            if(form_error('method_id'))
                $data['method_id_error'] = strip_tags(form_error('method_id'));
            if(form_error('method_price'))
                $data['method_price_error'] = strip_tags(form_error('method_price'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $merchant = get_this('merchants',['id'=>$this->post('merchant_id')]);
            if ($merchant) {
               if ($merchant['status'] == 1) {
                   if ($merchant['confirmed'] == 1) {
                       $method = get_this('merchants_delivering_methods',['merchant_id'=>$this->post('merchant_id'),'method_id'=>$this->post('method_id')]);
                       if ($method) {
                            $data['status'] = false;
                            $data['message'] = 'تمت اضافة طريقة التوصيل من قبل';
                            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                       }else{
                           $store = [
                                      'merchant_id'  => $merchant['id'],
                                      'method_id'    => $this->post('method_id'),
                                      'price'        => $this->post('method_price'),
                                      'created_at'   => date('Y-m-d')
                                   ];
                            $insert = $this->Main_model->insert('merchants_delivering_methods',$store);
                            if($insert){
                                    $data['status'] = true;
                                    $data['message'] = 'تمت الاضافة بنجاح';
                                    $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                            }else{
                                    $data['status'] = false;
                                    $data['message'] = 'خطأ في الاضافة';
                                    $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                            } 
                        
                       }
                   }else{
                       $data['status'] = false;
                       $data['message'] = 'حساب لم تتم الموافقه عليه من قبل الادارة';
                       $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                   }
               }else{
                   $data['status'] = false;
                   $data['message'] = 'حساب غير مفعل';
                   $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
               }
            }else{
               $data['status'] = false;
               $data['message'] = 'عفوا لا توجد اي بيانات لهذا التاجر';
               $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
        } 
    }
    public function edit_delivering_method_price_post(){
    	$this->load->library('form_validation');
        $this->form_validation->set_rules('merchant_id', 'رقم التاجر', 'trim|required|numeric');
        $this->form_validation->set_rules('method_id', 'رقم طريقه التوصيل', 'trim|required|numeric');
        $this->form_validation->set_rules('method_price', 'السعر', 'trim|required|numeric');
        if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('merchant_id'))
                $data['merchant_id_error'] = strip_tags(form_error('merchant_id'));
            if(form_error('method_id'))
                $data['method_id_error'] = strip_tags(form_error('method_id'));
            if(form_error('method_price'))
                $data['method_price_error'] = strip_tags(form_error('method_price'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
          $merchant = get_this('merchants',['id'=>$this->post('merchant_id')]);
          if ($merchant) {
             if ($merchant['status'] == 1) {
                 if ($merchant['confirmed'] == 1) {
                     if (get_this('merchants_delivering_methods',['merchant_id'=>$this->post('merchant_id'),'method_id'=>$this->post('method_id')])){
                          $store = [
                                    'price' => $this->post('method_price')
                                   ];
                          $this->Main_model->update('merchants_delivering_methods',['merchant_id'=>$this->post('merchant_id'),'method_id'=>$this->post('method_id')],$store);
                          $data['status'] = true;
                                $data['message'] = 'تم تعديل سعر طريقة التوصيل بنجاح';
                                $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code     
                      }else{
                          $data['status'] = false;
                              $data['message'] = 'عفوا فلا توجد طرق توصيل خاصه بك بهذا الرقم';
                              $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                      }
                 }else{
                     $data['status'] = false;
                     $data['message'] = 'حساب لم تتم الموافقه عليه من قبل الادارة';
                     $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                 }
             }else{
                 $data['status'] = false;
                 $data['message'] = 'حساب غير مفعل';
                 $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
             }
          }else{
             $data['status'] = false;
             $data['message'] = 'عفوا لا توجد اي بيانات لهذا التاجر';
             $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
          }
        }
    }
    public function remove_delivering_method_post(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('method_id', 'رقم طريقة التوصيل', 'trim|required|numeric');
        if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('method_id'))
                $data['method_id_error'] = strip_tags(form_error('method_id'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $method_id = get_this('merchants_delivering_methods',['id'=>$this->post('method_id')],'id');
            if ($method_id) {
                 $this->Main_model->delete('merchants_delivering_methods',['id'=>$method_id]);
                 $data['status'] = true;
                 $data['message'] = 'تم الحذف بنجاح';
                 $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }else{
                 $data['status'] = false;
                 $data['message'] = 'عفوا لاتوجد طريقة توصيل لك بهذا الرقم';
                 $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
        }
    }
    public function my_delivering_methods_post(){
    	$this->load->library('form_validation');
        $this->form_validation->set_rules('merchant_id', 'رقم طريقة التوصيل', 'trim|required|numeric');
        if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('merchant_id'))
                $data['merchant_id_error'] = strip_tags(form_error('merchant_id'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $merchant = get_this('merchants',['id'=>$this->post('merchant_id')]);
            if ($merchant) {
               if ($merchant['status'] == 1) {
                   if ($merchant['confirmed'] == 1) {
                        $methods = get_table('merchants_delivering_methods',['merchant_id'=>$this->post('merchant_id')]);
                        if ($methods) {
                          foreach ($methods as $method) {
                            $delivering_method = get_this('delivering_methods',['id'=>$method->method_id]);
                            $result[] = [
                                    'method_id'    => $method->method_id,
                                    'method_name'  => $delivering_method['name'],
                                    'method_price' => $method->price,
                                  ];
                          }
                          if ($result) {
                            $data['status'] = true;
                                  $data['my_methods'] = $result;
                                  $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                          }
                        }else{
                          $data['status'] = true;
                          $data['my_methods'] = [];
                              $data['message'] = 'عفوا لا توجد لديك اي طرق توصيل';
                              $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                        }
                   }else{
                       $data['status'] = false;
                       $data['message'] = 'حساب لم تتم الموافقه عليه من قبل الادارة';
                       $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                   }
               }else{
                   $data['status'] = false;
                   $data['message'] = 'حساب غير مفعل';
                   $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
               }
            }else{
               $data['status'] = false;
               $data['message'] = 'عفوا لا توجد اي بيانات لهذا التاجر';
               $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
        }
    }
    public function edit_profile_post(){
    	$this->load->library('form_validation');
    	$this->form_validation->set_rules('merchant_id', 'رقم التاجر', 'trim|required|numeric');
    	if($this->post('full_name') === "" || $this->post('full_name') != null)
            $this->form_validation->set_rules('full_name', 'الاسم بالكامل', 'trim|required');
        if($this->post('store_name') === "" || $this->post('store_name') != null)
            $this->form_validation->set_rules('store_name', 'اسم المتجر', 'trim|required');
        if($this->post('country_id') === "" || $this->post('country_id') != null)
            $this->form_validation->set_rules('country_id', 'رقم الدولة', 'trim|required|numeric');
        if($this->post('city_id') === "" || $this->post('city_id') != null)
            $this->form_validation->set_rules('city_id', 'رقم المدينة', 'trim|required|numeric');
        if($this->post('password') === "" || $this->post('password') != null)
            $this->form_validation->set_rules('password', 'كلمة المرور', 'trim|required|min_length[6]');
        if($this->post('image') === "")
            $this->form_validation->set_rules('image', 'الصورة الشخصيه', 'trim|required');
        if($this->post('phone') === "" || $this->post('phone') != null){
        	$phone = get_this('merchants',['id'=>$this->post('merchant_id')],'phone');
        	if ($phone != $this->post('phone')) {
        		$this->form_validation->set_rules('verified', 'حالة كود التفعيل', 'trim|required|numeric');
            	$this->form_validation->set_rules('phone', 'رقم الجوال', 'trim|required|is_unique[merchants.phone]');
        		if($this->post('verified') == 1){
	        		$this->form_validation->set_rules('verification_code', 'كود التفعيل', 'trim|required|exact_length[6]');
		    		$this->form_validation->set_rules('id', 'رقم عملية الارسال', 'trim|required');
        		}
        	}
        }
        if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('merchant_id'))
                $data['merchant_id_error'] = strip_tags(form_error('merchant_id'));
            if(form_error('full_name'))
                $data['full_name_error'] = strip_tags(form_error('full_name'));
            if(form_error('store_name'))
                $data['store_name_error'] = strip_tags(form_error('store_name'));
            if(form_error('country_id'))
                $data['country_id_error'] = strip_tags(form_error('country_id'));
            if(form_error('city_id'))
                $data['city_id_error'] = strip_tags(form_error('city_id'));
            if(form_error('password'))
                $data['password_error'] = strip_tags(form_error('password'));
            if(form_error('phone'))
                $data['phone_error'] = strip_tags(form_error('phone'));
            if(form_error('verified'))
                $data['verified_error'] = strip_tags(form_error('verified'));
            if(form_error('verification_code'))
                $data['verification_code_error'] = strip_tags(form_error('verification_code'));
            if(form_error('id'))
                $data['id_error'] = strip_tags(form_error('id'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $merchant = get_this('merchants',['id'=>$this->post('merchant_id')]);
            if ($merchant) {
               if ($merchant['status'] == 1) {
                   if ($merchant['confirmed'] == 1) {
                        $id = $this->post('merchant_id');
                        $store = $this->post();
                        $store['updated_at'] = date('Y-m-d');
                        unset($store['merchant_id']);
                        unset($store['verification_code']);
                        unset($store['verified']);
                        unset($store['id']);
                        if ($this->post('image')) {
                                $image = $this->m_image->base64_upload($this->post('image'));
                                $store['image'] = $image;
                            }
                        if ($this->post('password'))
                          $store['password'] = (md5(md5(md5(sha1($this->post('password'))))));
                        if ($this->post('verified') == 1) {
                          $verification_info = get_this('mobile_numbers',['id'=>$this->post('id'),'verification_code'=>$this->post('verification_code'),'verified'=>0]);
                          if ($verification_info) {
                            $update = ['verified' => 1];
                          $store['phone'] = $this->post('phone');
                            $this->Main_model->update('mobile_numbers',['id'=>$this->post('id')],$update);
                          }
                        }else
                          unset($store['phone']);
                        $this->Main_model->update('merchants',['id'=>$id],$store);
                        $merchant_info = get_this('merchants',['id'=>$id]);
                        unset($merchant_info['password']);
                        $merchant_info['image'] = base_url('assets/uploads/files/'.$merchant_info['image']);
                        $data['status'] = true;
                        $data['merchant_info'] = $merchant_info;
                        $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code 


                        
                   }else{
                       $data['status'] = false;
                       $data['message'] = 'حساب لم تتم الموافقه عليه من قبل الادارة';
                       $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                   }
               }else{
                   $data['status'] = false;
                   $data['message'] = 'حساب غير مفعل';
                   $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
               }
            }else{
               $data['status'] = false;
               $data['message'] = 'عفوا لا توجد اي بيانات لهذا التاجر';
               $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
        } 
    }
    public function product_post(){
      $this->load->library('form_validation');
      $this->form_validation->set_rules('product_id', 'رقم التصنيف', 'trim|required|numeric');
      if($this->form_validation->run() === FALSE){
          $data['status'] = false;
          if(form_error('product_id'))
              $data['product_id_error'] = strip_tags(form_error('product_id'));
          $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
      }else{
          $product = get_this('products',['id'=>$this->post('product_id')]);
          if ($product) {
            $result =  $product;
            if ($result) {
              $data['status'] = true;
              $result['main_image'] = base_url('assets/uploads/files/'.$product['main_image']);
              $data['product']['details'] = $result;
              $product_images = get_table('product_images',['product_id'=>$product['id']]);
              $images = [];
              if ($product_images) {
                foreach ($product_images as $image) {
                  $images[] = [
                                    'id'           => $image->id,
                                    'image_source' => base_url('assets/uploads/files/'.$image->image_name)
                              ];
                }
              }
              $product_colors = get_table('product_colors',['product_id'=>$product['id']]);
              $colors = [];
              if ($product_colors) {
                foreach ($product_colors as $color) {
                  $colors[] = [
                                    'id'    => $color->id,
                                    'color' => $color->color
                              ];
                }
              }
              $data['product']['images'] = $images;
              $data['product']['colors'] = $colors;
              $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
          }else{
            $data['status'] = false;
            $data['message'] = 'عفوا لا توجد اي منتجات بهذا الرقم';
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
          }
      }
    }
    
}
