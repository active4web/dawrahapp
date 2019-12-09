<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/API_Controller.php';

class Api extends API_Controller
{
    public function __construct() {
        parent::__construct();
		$this->load->model('data','','true');
		date_default_timezone_set('Asia/Riyadh');
		$this->load->library('Authorization_Token');
    }
	
	public function checkLang()
    {
       // $language = $this->input->post('lang');
       $language= "ar";
		if ($language == "ar") {
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
       
       
       
     public function get_test_city(){
 $this->_apiConfig(['methods' => ['POST']
 //,'key' => ['POST', $this->key()]
 ]);
	$home_city=$this->db->order_by('id','desc')->get_where('city',array('view'=>'1','country_id'=>1))->result();
		if (count($home_city)>0) {
            	
        foreach ($home_city as $page) {
            $result['city_name']=$page->name;
             $result['city_id']=(int)$page->id;
        $data['cities'][]= $result;
        }
		            if ($data) {
              $this->api_return([
						'errNum' => 405, //active4web copyright 2019
						'status' => true,
						"result" => $data
					],200);
            }
      }
      else{
        $data['pages'] = [];
        $this->api_return([
		'message' => lang('no_data'),
				'errNum' =>401,
				'status' => false,
				"result" => $data
				],200);
       }
    }
 
 
    public function get_all_city(){
        header("Access-Control-Allow-Origin: *");
        // API Configuration #endregion
        //this configration for any api
        $this->_apiConfig([
            'methods' => ['POST'], //This Function by default request method GET
            'key' => ['POST', $this->key()]
          // ,'requireAuthorization' => true //this used if reqired token valye
        ]);
       $lang = "ar";
    $this->checkLang($lang); 
	$home_city=$this->db->order_by('id','desc')->get_where('city',array('view'=>'1','country_id'=>1))->result();
		if (count($home_city)>0) {
            	
        foreach ($home_city as $page) {
            $result['city_name']=$page->name;
             $result['city_id']=(int)$page->id;
        $data['cities'][]= $result;
        }
		            if ($data) {
              $this->api_return([
						'errNum' => 405, //active4web copyright 2019
						'status' => true,
						"result" => $data
					],200);
            }
      }
      else{
        $data['pages'] = [];
        $this->api_return([
		'message' => lang('no_data'),
				'errNum' =>401,
				'status' => false,
				"result" => $data
				],200);
       }
    }
    
    
      public function get_all_outsidecity(){
        header("Access-Control-Allow-Origin: *");
        // API Configuration #endregion
        //this configration for any api
        $this->_apiConfig([
            'methods' => ['POST'], //This Function by default request method GET
            'key' => ['POST', $this->key()]
          // ,'requireAuthorization' => true //this used if reqired token valye
        ]);
       $lang = "ar";
    $this->checkLang($lang); 
	$home_city=$this->db->order_by('id','desc')->get_where('city',array('view'=>'1','country_id!='=>1))->result();
		if (count($home_city)>0) {
            	
        foreach ($home_city as $page) {
            $result['city_name']=$page->name;
             $result['city_id']=(int)$page->id;
        $data['cities'][]= $result;
        }
		            if ($data) {
              $this->api_return([
						'errNum' => 405, //active4web copyright 2019
						'status' => true,
						"result" => $data
					],200);
            }
      }
      else{
        $data['pages'] = [];
        $this->api_return([
		'message' => lang('no_data'),
				'errNum' =>401,
				'status' => false,
				"result" => $data
				],200);
       }
    }

    
        public function get_all_category(){
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'], //This Function by default request method GET
            'key' => ['POST', $this->key()]
          // ,'requireAuthorization' => true //this used if reqired token valye
        ]);
       $lang = "ar";
        //this for lang check it
    $this->checkLang($lang); 
	$home_city=$this->db->order_by('id','desc')->get_where('category',array('view'=>'1'))->result();
		if (count($home_city)>0) {
        foreach ($home_city as $page) {
            $result['category_name']=$page->name;
             $result['category_id']=(int)$page->id;
        $data['categories'][]= $result;
        }
		            if ($data) {
              $this->api_return([
						'errNum' => 405, //active4web copyright 2019
						'status' => true,
						"result" => $data
					],200);
            }
      }
      else{
        $data['pages'] = [];
        $this->api_return([
		'message' => lang('no_data'),
				'errNum' =>401,
				'status' => false,
				"result" => $data
				],200);
       }
    }
    
    
public function preparation_register(){
    
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'], //This Function by default request method GET
            'key' => ['POST', $this->key()]
          // ,'requireAuthorization' => true //this used if reqired token valye
        ]);
       $lang = "ar";
    $this->checkLang($lang);
$this->load->library('form_validation');
        $this->form_validation->set_rules('key_user',lang('key_user'), 'trim|required|numeric|min_length[1]|max_length[1]');
  if($this->form_validation->run() === FALSE){

    if(form_error('key_user')){
	if($this->input->post('key_user')==="" || !$this->input->post('key_user')){
	$data[] = array('message'=> strip_tags(lang('user_type')),"errNum" => 0);
				}
else{
$data[] = array('message'=> strip_tags(lang('user_type')),"errNum" => 1);
				}
            }
            
    $this->api_return([
        'message' => $data[0]['message'],
        'errNum' => $data[0]['errNum'],
        'status' => false
    ],200);
    
  }
else {	
    $home_city=$this->db->order_by('id','desc')->get_where('city',array('view'=>'1','country_id'=>'1'))->result();
		if (count($home_city)>0) {
            	
        foreach ($home_city as $page) {
            $result['city_name']=$page->name;
             $result['city_id']=(int)$page->id;
        $data['cities'][]= $result;
        }
        
        
		}
	    else{
	         $result['city_name']="";
             $result['city_id']="";
        $data['cities'][]= $result;
        	$data['cities'][]=$data;
       }
    
    
	$home_category=$this->db->order_by('id','desc')->get_where('category',array('view'=>'1'))->result();
		if (count($home_category)>0) {
            	
        foreach ($home_category as $page_home) {
            $result_cat['category_name']=$page_home->name;
             $result_cat['category_id']=(int)$page_home->id;
        $data['categories'][]= $result_cat;
        }
             
            }
      
      else{
           $result_cat['category_name']="";
             $result_cat['category_id']="";
        $data['categories'][]= $result_cat;
       }
       
       
        $terms=$this->db->get_where('pages',array('key_txt'=>'terms','active'=>'1','flag'=>$this->input->post('key_user')))->result();
		if (count($terms)>0) {
            	
        foreach ($terms as $page_terms) {
            $result_terms['title']=$page_terms->title;
            $result_terms['Terms']=strip_tags(trim(preg_replace('/\s\s+/', ' ',$page_terms->content )));;
        $data['Terms'][]= $result_terms;
        }
		    
		}
      
      else{
          $result_terms['title']="";
            $result_terms['Terms']="";
$data['Terms'][]=$result_terms;
       }
       
if($data){
$this->api_return([
'keynum' => 405, //active4web copyright 2019
'status' => true,
"result" => $data
],200); 
}

else {
         $data['pages'] = [];
        $this->api_return([
		'message' => lang('no_data'),
				'keynum' =>401,
				'status' => false,
				"result" => $data
				],200);   
}
       
}

       
    }
    
	
	public function set_register(){
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
       $lang ="ar";
      $this->checkLang($lang);
        $this->load->library('Authorization_Token');
		$this->load->library('form_validation');
        $this->form_validation->set_rules('name',lang('Username'), 'trim|required');
        $this->form_validation->set_rules('user_type', lang('user_type'), 'trim|required');
        $this->form_validation->set_rules('phone', lang('Phone Number'), 'trim|required|numeric');
		$this->form_validation->set_rules('email', lang('Email'), 'trim|required|valid_email');
        $this->form_validation->set_rules('password', lang('Password'), 'trim|required|min_length[8]');
        //$this->form_validation->set_rules('confirm_password', lang('Confirm Password'), 'trim|required|matches[password]');
      $this->form_validation->set_rules('device_token_id', lang('Device Reg ID'), 'trim|required');
        $this->form_validation->set_rules('age', lang('age'), 'trim|required|numeric|min_length[2]');
        $this->form_validation->set_rules('policy_id', lang('policy_id'), 'trim|required');
        $this->form_validation->set_rules('city', lang('city'), 'trim|required|numeric');

        if($this->form_validation->run() === FALSE){
			$email_find = get_table_filed('customers',array('email'=>$this->input->post('email'),'status'=>$this->input->post('user_type')),"email");
            $phone_find= get_table_filed('customers',array('phone'=>$this->input->post('phone'),'status'=>$this->input->post('user_type')),"phone");
            
              if(form_error('name')){
                if($this->input->post('name')==="" || !$this->input->post('name')){
                $data[] = array('message'=> strip_tags(lang('Username')),"errNum" => 0);
                }
            }
  //**************** */
    if(form_error('email')){
	if($this->input->post('email')==="" || !$this->input->post('email')){
	$data[] = array('message'=> strip_tags(lang('Email')),"errNum" => 1);
				}elseif($email_find!=""){
					$data[] = array('message'=> strip_tags(lang('Email')),"errNum" =>3);
				}else{
					$data[] = array('message'=> strip_tags(lang('error_email')),"errNum" => 4);
				}
            }
              //**************** */
            if(form_error('phone')){
				if($this->input->post('phone')==="" || !$this->input->post('phone')){
					$data[] = array('message'=> strip_tags(lang('Phone Number')),"errNum" => 5);
				}elseif($phone_find!=""){
					$data[] = array('message'=> strip_tags(lang('Phone Number')),"errNum" => 6);
				}else{
					$data[] = array('message'=> strip_tags(lang('error_phone')),"errNum" => 7);
				}
            }
              //**************** */
              if(form_error('device_token_id')){
                if($this->input->post('device_token_id')==="" || !$this->input->post('device_token_id')){
                $data[] = array('message'=> strip_tags(lang('device_token_id')),"errNum" =>8);
                }
            }

            if(form_error('password')){
				if($this->input->post('password')==="" || !$this->input->post('password')){
					$data[] = array('message'=> strip_tags(lang('Password')),"errNum" =>9);
				}else{
					$data[] = array('message'=> strip_tags(lang('Password Leng')),"errNum" =>10);
				}
            }

            if(form_error('user_type')){
                if($this->input->post('user_type')==="" || !$this->input->post('user_type')){
                    $data[] = array('message'=> strip_tags(lang('user_type')),"errNum" =>11);
          }  
        }

        
if(form_error('age')){
    if($this->input->post('age')==="" || !$this->input->post('age')){
    $data[] = array('message'=> strip_tags(lang('age')),"errNum" => 12);
    } 
    else {
      $data[] = array('message'=> strip_tags(lang('age_error')),"errNum" => 15);   
    }
    }
    if(form_error('policy_id')){
    if($this->input->post('policy_id')!=1 ||$this->input->post('policy_id')==="" || !$this->input->post('policy_id')){
    $data[] = array('message'=> strip_tags(lang('policy_id')),"errNum" =>13);
    } 
    }
    if(form_error('city')){
    if($this->input->post('city')==="" || !$this->input->post('city')){
    $data[] = array('message'=> strip_tags(lang('city')),"errNum" =>14);
    } 
    }

    
    $this->api_return([
        'message' => $data[0]['message'],
        'errNum' => $data[0]['errNum'],
        'status' => false
    ],200);



        }

        else{
			
$email_find = get_table_filed('customers',array('email'=>$this->input->post('email'),'status'=>$this->input->post('user_type')),"email");
$phone_find= get_table_filed('customers',array('phone'=>$this->input->post('phone'),'status'=>$this->input->post('user_type')),"phone");
            
if($phone_find!=""){
$data[] = array('message'=> strip_tags(lang("phone_anthor")),"errNum" => 2);
}
if($email_find!=""){
$data[] = array('message'=> strip_tags(lang("email_anthor")),"errNum" => 2);
}
if($phone_find!=""||$email_find!=""){
$this->api_return([
    'message' => $data[0]['message'],
    'errNum' => $data[0]['errNum'],
    'status' => false
],200);

}
else if($phone_find==""&&$email_find==""){
    

    
    
date_default_timezone_set('Asia/Riyadh');
            $store = [
                      'user_name'          	=> $this->input->post('name'),
                      'password'            => md5($this->input->post('password')),
                      'email'          		=> $this->input->post('email'),
                      'phone'               => $this->input->post('phone'),
                      'age'             	=> $this->input->post('age'),
                      'status'             	=> $this->input->post('user_type'),
                      'view'=>'1',
                      'city_id'    	=> $this->input->post('city'),
                      'social_id'    	=> $this->input->post('device_token_id'),
                      'creation_date'       => date('Y-m-d H:i:s'),
                      'invitation_code'       => gen_random_string(),
                      'using_invitation_code'  =>$this->input->post('invitation_code')
                    ];
                    
if($this->input->post('share_code')!=""){
$share_code_id=get_table_filed('customers',array('invitation_code'=>$this->input->post('share_code')),"id");
if($share_code_id!=""){
$insert = $this->db->insert('customers',$store);
$id= $this->db->insert_id(); 

$share_code['share_code_register'] = $this->input->post('share_code');
$this->Main_model->update('customers',['id'=>$id],$share_code);	
$customer_infop['using_share'] ="تم استخدام الكود بنجاح";

}
else {
 $customer_infop['using_share'] ="الكود المستخدم غير صحيح";
}
}
 else {
  $customer_infop['using_share']="";    
$insert = $this->db->insert('customers',$store);
$id= $this->db->insert_id();    
 }                 
                   
if($this->input->post('interest_list')!=0){
   $arry_interest= explode(',', $this->input->post('interest_list'));
   for($i=0; $i<count($arry_interest); $i++){
       $data_interst['id_user']=$id;
       $data_interst['department_id']=$arry_interest[$i];
       $this->db->insert('intersted_courses',$data_interst);
   }
}
                    
            //////////////////////////////////////////////Send SMS Code
             //Check Insert User Data
            if($insert){


$customer = get_this('customers',['id'=>$id]);
  if ($customer) {
$id = $customer['id'];
if ($this->input->post('img')) {
  $image_name = gen_random_string();
  $filename = $image_name . '.' . 'png';
  $image = base64_decode($this->input->post("img"));
  $path = "uploads/customers/".$filename;
  file_put_contents($path, $image);
$store['img'] = $filename;
}
if ($this->input->post('city')) {
$store['city_id'] = $this->input->post('city');
}
$store['user_name'] = $this->input->post('name');
$store['email'] = $this->input->post('email');
$store['phone'] = $this->input->post('phone');
$store['age'] = $this->input->post('age');

$this->Main_model->update('customers',['id'=>$id],$store);
$customer_info =get_this('customers',['id'=>$id]);

 $payload = ['id' => $customer_info['id'],
								'phone' => $customer_info['phone'],
								'email' => $customer_info['email']
							];
$token = $this->authorization_token->generateToken($payload);
$token_data['token'] = $token;
$token_data['id_customer'] = $id;
$this->db->insert("customers_token",$token_data);

$customer_infop['id'] =(int)$customer_info['id'];
$customer_infop['name'] = $customer_info['user_name'];
$customer_infop['phone'] =$customer_info['phone'];
$customer_infop['email'] =$customer_info['email'];
$customer_infop['age'] = $customer_info['age'];
$customer_infop['user_key'] = (int)$customer_info['status'];
//$customer_infop['invitation_code'] = $customer_info['invitation_code'];
if($customer_info['img']!=""){
$customer_infop['img'] =  base_url()."uploads/customers/".$customer_info['img'];
}
else {
$customer_infop['img'] = base_url()."uploads/customers/no_img.png";   
}
$customer_infop['city'] =get_table_filed('city',array('id'=>$customer_info['city_id']),"name");
$customer_infop['token_id'] =$token;
 $data['customer_info'] = $customer_infop;
 $this->api_return([
								'message' => lang('register message'),
								'errNum' => 405,
								'status' => true,
								"result" => $data
								],200);
							 
                     }
else {
$data['customer_info'] = [];
$this->api_return([
'message' => lang('no_data'),
'keynum' =>401,
'status' => false,
"result" => $data
],200);   
}
             }else{
                 $data['customer_info'] =$customer_infop['using_share'];
                  $this->api_return([
                    'message' => lang('An error in the register'),
                    'errNum' => 4,
                    'status' => false,
                    'data'=>$data,
                ],200);
             }
				}
				
                ///////////////////////////////////////////////////////////////////////////////////////////////////////////
            }


        }





public function preparation_profile() {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
        ]);
        
 $lang = "ar";
 $this->checkLang($lang); 
	$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
 if($this->form_validation->run() === FALSE){
            if(form_error('token_id')) {
                if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
                $data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
                }
            }

$this->api_return([
        'message' => $data[0]['message'],
        'errNum' => $data[0]['errNum'],
        'status' => false
    ],200);


        }
        else{
   $customer_id= get_customer_id($this->input->post('token_id')); //get_this('customers',['device_reg_id'=>$this->input->post('token_id')]);
  // $customer_info =get_this('customers',['id'=>$id]);
   
if ($customer_id!="") {
  $city_id= get_table_filed('customers',array('id'=>$customer_id),"city_id"); ;      
$home_city=$this->db->order_by('id','desc')->get_where('city',array('view'=>'1','country_id'=>'1'))->result();
if (count($home_city)>0) {

foreach ($home_city as $page) {
$result['city_name']=$page->name;
$result['city_id']=(int)$page->id;
if($city_id==$page->id){
$result['user_city_key']=1;
}
else {
$result['user_city_key']=0;    
}
$data['cities'][]= $result;
}


}
else{
$result['city_name']="";
$result['city_id']="";
$data['cities'][]= $result;
}
  
$id = $customer_id;
   $customer_info =get_this('customers',['id'=>$id]);
$customer_infop['id'] =(int)$customer_info['id'];
$customer_infop['name'] = $customer_info['user_name'];
$customer_infop['phone'] =$customer_info['phone'];
$customer_infop['email'] =$customer_info['email'];
$customer_infop['age'] = $customer_info['age'];
$customer_infop['user_key'] = (int)$customer_info['status'];
$customer_infop['token'] =$this->input->post('token_id');
$customer_infop['invitation_code'] = $customer_info['invitation_code'];
if($customer_info['img']!=""){
$customer_infop['img'] =  base_url()."uploads/customers/".$customer_info['img'];
}
else {
$customer_infop['img'] = base_url()."uploads/customers/no_img.png";   
}
$customer_infop['city'] =get_table_filed('city',array('id'=>$customer_info['city_id']),"name");
 $data['customer_info'] = $customer_infop;
 
                              $this->api_return([
								'message' => lang('Operation completed successfully'),
								'errNum' => 405,
								'status' => true,
								"result" => $data
								],200);
							 
                     }
                     else {
                         $this->api_return([
'message' => lang('device_token_id_error'),
'errNum' => 4,
'status' => false
],200);
                     }
               
            
        }
	}



public function edit_profile() {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
			//'requireAuthorization' => true
        ]);
        
 $lang = "ar";
 $this->checkLang($lang); 
$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
$this->form_validation->set_rules('age', lang('age'), 'trim|required|numeric|min_length[2]');
$this->form_validation->set_rules('name',lang('Username'), 'trim|required');
$this->form_validation->set_rules('phone', lang('Phone Number'), 'trim|required|numeric');
$this->form_validation->set_rules('email', lang('Email'), 'trim|required|valid_email');
$customer_id= get_customer_id($this->input->post('token_id'));
$phone = get_this('customers',['id'=>$customer_id],'phone');
$email = get_this('customers',['id'=>$customer_id],'email');

if($this->input->post('phone') === "" || $this->input->post('phone') != null){
if ($phone != $this->input->post('phone')) {
$this->form_validation->set_rules('phone', lang('phone_anthor'), 'trim|required|is_unique[customers.phone]');
}
}

if($this->input->post('email') === "" || $this->input->post('email') != null){
if ($email != $this->input->post('email')) {
$this->form_validation->set_rules('email', lang('email_anthor'), 'trim|required|valid_email|is_unique[customers.email]');
}
}
		

		
        if($this->form_validation->run() === FALSE){
            
            if(form_error('token_id')) {
                if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
                $data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
                }
                else{
		$data[] = array('message'=> strip_tags(lang('Customer ID_notfind')),"errNum" => 1);
				}
            }
           
				
            if(form_error('name')){
                if($this->input->post('name')==="" || !$this->input->post('name')){
                $data[] = array('message'=> strip_tags(lang('Username')),"errNum" => 0);
                }
            }
  //**************** */
    if(form_error('email')){
	if($this->input->post('email')==="" || !$this->input->post('email')){
	$data[] = array('message'=> strip_tags(lang('Email')),"errNum" => 0);
				}else{
		$data[] = array('message'=> strip_tags(lang('email_anthor')),"errNum" => 1);
				}
            }
              //**************** */
            if(form_error('phone')){
				if($this->input->post('phone')==="" || !$this->input->post('phone')){
					$data[] = array('message'=> strip_tags(lang('Phone Number')),"errNum" => 0);
				}else{
					$data[] = array('message'=> strip_tags(lang('phone_anthor')),"errNum" => 1);
				}
            }
     
if(form_error('age')){
    if($this->input->post('age')==="" || !$this->input->post('age')){
    $data[] = array('message'=> strip_tags(lang('age')),"errNum" => 0);
    } 
    }
    
$this->api_return([
        'message' => $data[0]['message'],
        'errNum' => $data[0]['errNum'],
        'status' => false
    ],200);


        }
        else{
$customerid =    $customer_id= get_customer_id($this->input->post('token_id'));
$customer = get_this('customers',['id'=>$customerid]);
if ($customer) {
$id = $customer['id'];
if ($this->input->post('img')) {
  $image_name = gen_random_string();
  $filename = $image_name . '.' . 'png';
  $image = base64_decode($this->input->post("img"));
  $path = "uploads/customers/".$filename;
  file_put_contents($path, $image);
$store['img'] = $filename;
}
if ($this->input->post('city')) {
$store['city_id'] = $this->input->post('city');
}
$store['user_name'] = $this->input->post('name');
$store['email'] = $this->input->post('email');
$store['phone'] = $this->input->post('phone');
$store['age'] = $this->input->post('age');

$this->Main_model->update('customers',['id'=>$id],$store);
$customer_info =get_this('customers',['id'=>$id]);
$customer_infop['id'] =(int)$customer_info['id'];
$customer_infop['name'] = $customer_info['user_name'];
$customer_infop['phone'] =$customer_info['phone'];
$customer_infop['email'] =$customer_info['email'];
$customer_infop['age'] = $customer_info['age'];
$customer_infop['user_key'] =(int) $customer_info['status'];
$customer_infop['invitation_code'] = $customer_info['invitation_code'];
$customer_infop['activation_status'] = lang('Account activated');
if($customer_info['img']!=""){
$customer_infop['img'] =  base_url()."uploads/customers/".$customer_info['img'];
}
else {
$customer_infop['img'] = base_url()."uploads/customers/no_img.png";   
}
$customer_infop['city'] =get_table_filed('city',array('id'=>$customer_info['city_id']),"name");
$customer_infop['token_id'] =$this->input->post('token_id');
 $data['customer_info'] = $customer_infop;

							  
                              $this->api_return([
								'message' => lang('Successfully updated'),
								'errNum' => 405,
								'status' => true,
								"result" => $data
								],200);
							 
                     }
                     else {
                          $this->api_return([
						'message' => lang('Customer ID notcorrect'),
						'errNum' => 402,
						'status' => false
						],200);
                     }
               
            
        }
	}





public function change_password() {
        header("Access-Control-Allow-Origin: *");

        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
        $lang = "ar";
$this->checkLang($lang);
$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
$this->form_validation->set_rules('old_password', lang('Current Password'), 'trim|required');
 $this->form_validation->set_rules('password', lang('New Password'), 'trim|required|min_length[8]');
 $customer = get_this('customers',['device_reg_id'=>$this->input->post('token_id')]);
		
		 if($this->form_validation->run() === FALSE){
          if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
			  }else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
			  }	
		  }
		  
		 if(form_error('old_password')){
					$data[] = array('message'=> strip_tags(lang('Current Password')),"errNum" => 0);
			}
			  
          if(form_error('password')){
			  if($this->input->post('password')==="" || !$this->input->post('password')){
				$data[] = array('message'=> strip_tags(lang('New Password')),"errNum" => 0);
			  }else{
				$data[] = array('message'=> strip_tags(lang('New Password')),"errNum" => 1);
			  }
		  }
		  

		
          $this->api_return([
					'message' => $data[0]['message'],
					'errNum' => $data[0]['errNum'],
					'status' => false
				],200);
        }else{
			$customerid =    $customer_id= get_customer_id($this->input->post('token_id'));
			
             $customeremail = get_table_filed('customers',array('id'=>$customerid),"email");
			if($customeremail!=""){
			    $password = get_table_filed('customers',array('id'=>$customerid),"password");
				if ($password == md5($this->input->post('old_password')) ) {
					$update = ['password' => md5($this->input->post('password'))];
					$this->Main_model->update('customers',['id'=>$customerid],$update);
				   $this->api_return([
					   'message' => lang('Password changed successfully'),
						'errNum' => 405,
						'status' => true
					],200);

				}else{
				$this->api_return([
						'message' => lang('Sorry, the current password is incorrect'),
						'errNum' => 3,
						'status' => false
						],200);
				}
			}else{
				   $this->api_return([
						'message' => lang('Customer ID notcorrect'),
						'errNum' => 402,
						'status' => false
						],200);
			}
        }		
	}

	
	
	
	
	public function get_interset_categories(){
        header("Access-Control-Allow-Origin: *");
        // API Configuration #endregion
        //this configration for any api
        $this->_apiConfig([
            'methods' => ['POST'], //This Function by default request method GET
            'key' => ['POST', $this->key()]
         // ,'requireAuthorization' => true //this used if reqired token valye
        ]);
        $lang ="ar";
    $this->checkLang($lang); 
    
    
 $lang = "ar";
$this->checkLang($lang);
$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
if($this->form_validation->run() === FALSE){
if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
			  }	
		  }

$this->api_return([
'message' => $data[0]['message'],
'errNum' => $data[0]['errNum'],
'status' => false
],200);
        }
        else{
            $customer_id= get_customer_id($this->input->post('token_id'));
 $customeremail = get_table_filed('customers',array('id'=>$customer_id),"email");
    if($customeremail!="") {

$intersted_courses=$this->db->order_by('id','desc')->get_where('category',array('view'=>'1'))->result();
		if (count($intersted_courses)>0) {
        foreach ($intersted_courses as $page) {
 $department_id=$page->id;
 
 $depart_inter_id=get_table_filed('intersted_courses',array('department_id'=>$department_id,'id_user'=>$customer_id),"id");
 if($depart_inter_id!=""){
   $result['interst_key']=1;  
 }
 else {
     $result['interst_key']=0;  
 }
       $result['name']=$page->name;
         $result['depart_id']=$page->id;
         $data['categories'][]= $result;
 
        }
		            if ($data) {
              $this->api_return([
				 'message' => lang('Operation completed successfully'),
						'keynum' => 405, //active4web copyright 2019
						'status' => true,
						"result" => $data
					],200);
            }
      }
      else{
           $result['name']="";
         $result['depart_id']="";
         $data['categories'][]= $result;
        $this->api_return([
		'message' => lang('no_data'),
				'keynum' =>401,
				'status' => false,
				"result" => $data
				],200);
       }
        }
         else {
             
$this->api_return([
'message' => lang('Customer ID notcorrect'),
'errNum' => 402,
'status' => false
],200);  
        }
        
        
        }
       
       
    }
	
	
	
	
	
public function change_userinterset(){
header("Access-Control-Allow-Origin: *");
$this->_apiConfig([
'methods' => ['POST'],
'key' => ['POST', $this->key()],
//'requireAuthorization' => true
]);
$lang ="ar";
$this->checkLang($lang);
$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
if($this->form_validation->run() === FALSE){
if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}

$this->api_return([
'message' => $data[0]['message'],
'errNum' => $data[0]['errNum'],
'status' => false
],200);

    
}

        else{
        $customeid = get_customer_id($this->input->post('token_id'));
     $customeremail = get_table_filed('customers',array('id'=>$customeid),"email");
    if($customeremail!=""&&$customeid!="") {
        
        if($this->input->post('interest_list')!=0){
    $this->db->delete('intersted_courses',array('id_user'=>$customeid));
   $arry_interest= explode(',', $this->input->post('interest_list'));
   for($i=0; $i<count($arry_interest); $i++){
       $data_interst['id_user']=$customeid;
       $data_interst['department_id']=$arry_interest[$i];
       $this->db->insert('intersted_courses',$data_interst);
   }
}

$intersted_courses=$this->db->order_by('id','desc')->get_where('intersted_courses',array('id_user'=>'1'))->result();
		if (count($intersted_courses)>0) {
        foreach ($intersted_courses as $page) {
            
 $department_id=$page->department_id;
 $depart_name=get_table_filed('category',array('id'=>$department_id),"name");
 $id=get_table_filed('category',array('id'=>$department_id),"id");
 if($depart_name!="" && $id!=""){
       $result['name']=$depart_name;
         $result['depart_id']=$id;
         $data['intersted_courses'][]= $result;
 }
        }
		            if ($data) {
              $this->api_return([
				 'message' => 'تم تغير قائمة اهتمامك بنجاح',
						'keynum' => 405, //active4web copyright 2019
						'status' => true,
						"result" => $data
					],200);
            }
      }
      else{
        $data['pages'] = [];
        $this->api_return([
		'message' => lang('no_data'),
				'keynum' =>401,
				'status' => false,
				"result" => $data
				],200);
       }
        }
         else {
             
$this->api_return([
'message' => lang('Customer ID notcorrect'),
'errNum' => 402,
'status' => false
],200);  
        }
        
        
        }
 }
	



     public function get_all_department(){
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'], //This Function by default request method GET
            'key' => ['POST', $this->key()]
          // ,'requireAuthorization' => true //this used if reqired token valye
        ]);
       $lang = "ar";
        //this for lang check it
    $this->checkLang($lang); 
	$home_city=$this->db->order_by('id','desc')->get_where('department',array('view'=>'1'))->result();
		if (count($home_city)>0) {
            	
        foreach ($home_city as $page) {
            $result['department_name']=$page->name;
             $result['department_id']=$page->id;
        $data['departments'][]= $result;
        }
		            if ($data) {
              $this->api_return([
						'keynum' => 405, //active4web copyright 2019
						'status' => true,
						"result" => $data
					],200);
            }
      }
      else{
        $data['departments'] = [];
        $this->api_return([
		'message' => lang('no_data'),
				'keynum' =>401,
				'status' => false,
				"result" => $data
				],200);
       }
    }





public function get_all_bage(){
  header("Access-Control-Allow-Origin: *");
  $this->_apiConfig([
      'methods' => ['POST'],
      'key' => ['POST', $this->key()]
]);
  $lang ="ar";
  $this->checkLang($lang);
$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
$this->form_validation->set_rules('limit', lang('Number of visible elements'), 'trim|required|numeric');
$this->form_validation->set_rules('page_number', lang('Page Number'), 'trim|required|numeric'); 
$this->form_validation->set_rules('key_depart', lang('Key Depart'), 'trim|required|in_list[2]'); 
  if($this->form_validation->run() === FALSE){
      
if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}
      
if(form_error('key_depart')){
if($this->input->post('key_depart')==="" || !$this->input->post('key_depart')){
$data[] = array('message'=>strip_tags(lang('Key Depart')),"errNum" => 0);
}else{$data[] = array('message'=>strip_tags(lang('Key Depart')),"errNum" => 1);}
}

if(form_error('limit')){
if($this->input->post('limit')==="" || !$this->input->post('limit')){
$data[] = array('message'=>strip_tags(lang('limit')),"errNum" => 0);
}else{$data[] = array('message'=>strip_tags(lang('limit')),"errNum" => 1);}
}

      if(form_error('page_number')){
  if($this->input->post('page_number')==="" || !$this->input->post('page_number')){
    $data[] = array('message'=> strip_tags(lang('page_number')),"errNum" => 0);
  }else{
    $data[] = array('message'=> strip_tags(lang('page_number')),"errNum" => 1);
  }
}
            $this->api_return([
  'message' => $data[0]['message'],
  'errNum' => $data[0]['errNum'],
  'status' => false
],200);
  }
else{

$user_mode_key=$this->input->post('user_mode_key');
if($user_mode_key!=""&&$user_mode_key==0){
 $customers_id=-1;   
}
else {
$customers_id=get_customer_id($this->input->post('token_id'));    
}
if($customers_id!=""){
    $limit=$this->input->post('limit');
    $page_number=$this->input->post('page_number');
         $total = $this->data->get_table_data('bag_info',array('view'=>'1','delete_key'=>'1'));
         $offset =$limit * $page_number;
         $sql_product=$this->db->order_by('id','DESC')->get_where('bag_info',array('view'=>'1','delete_key'=>'1'),$limit, $offset)->result();
if (count($sql_product)>0) {
foreach ($sql_product as $page) {

$id_fav =get_table_filed('favourites',array('user_id'=>$customers_id,'type'=>$this->input->post('key_depart'),'course_id'=>$page->id),"id");
if($id_fav!=""){
	$result['favourite_key']=1;
}
else{
	$result['favourite_key']=0;	
}
    
$result['name']=$page->bage_name;
$result['id']=(int)$page->id;
if($page->total_rate!=""){
$result['total_rate']=(int)$page->total_rate;
}
else {
$result['total_rate']=(int)0;
}
if($page->img!=""){
$result['image']=base_url()."uploads/products/".$page->img;
}
else {
$result['image']=base_url()."uploads/products/no_img.png";
}

$data['all_bage'][]= $result;
                }
                     $total = count($total);
             //$data['my_favourite'] = $result;
             $this->api_return([
              'message' => lang('Operation completed successfully'),
              'errNum' => 405,
              'status' => true,
              'total' => $total,
              "result" => $data
            ],200);
                
                
                }
                else {
             $data['all_bage'] = [];
             $total = count($total);
             $this->api_return([
              'message' => lang('no_data'),
              'errNum' => 401,
              'status' => false,
              "result" => $data
              ],200);
                }
                
}
else {$this->api_return([ 'message' => lang('Customer ID notcorrect'), 'errNum' => 402, 'status' => false, ],200);}
}
}






public function get_all_courses_inside(){
  header("Access-Control-Allow-Origin: *");
  $this->_apiConfig([
      'methods' => ['POST'],
      'key' => ['POST', $this->key()]
]);
  $lang ="ar";
  $this->checkLang($lang);
$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
$this->form_validation->set_rules('limit', lang('Number of visible elements'), 'trim|required|numeric');
$this->form_validation->set_rules('page_number', lang('Page Number'), 'trim|required|numeric'); 
$this->form_validation->set_rules('key_depart', lang('Key Depart'), 'trim|required|in_list[1,3]'); 
  if($this->form_validation->run() === FALSE){
      
if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}
      
if(form_error('key_depart')){
if($this->input->post('key_depart')==="" || !$this->input->post('key_depart')){
$data[] = array('message'=>strip_tags(lang('Key Depart')),"errNum" => 3);
}else{$data[] = array('message'=>strip_tags(lang('Key Depart')),"errNum" => 4);}
}

if(form_error('limit')){
if($this->input->post('limit')==="" || !$this->input->post('limit')){
$data[] = array('message'=>strip_tags(lang('limit')),"errNum" => 5);
}else{$data[] = array('message'=>strip_tags(lang('limit')),"errNum" => 6);}
}

      if(form_error('page_number')){
  if($this->input->post('page_number')==="" || !$this->input->post('page_number')){
    $data[] = array('message'=> strip_tags(lang('page_number')),"errNum" => 7);
  }else{
    $data[] = array('message'=> strip_tags(lang('page_number')),"errNum" => 8);
  }
}
            $this->api_return([
  'message' => $data[0]['message'],
  'errNum' => $data[0]['errNum'],
  'status' => false
],200);
  }
else{
$user_mode_key=$this->input->post('user_mode_key');
if($user_mode_key!=""&&$user_mode_key==0){
 $customers_id=-1;   
}
else {
$customers_id=get_customer_id($this->input->post('token_id'));    
}

 if($customers_id){
     
    $limit=$this->input->post('limit');
    $page_number=$this->input->post('page_number');
         $total = $this->data->get_table_data('products',array('delete_key'=>'1','view'=>'1','type'=>$this->input->post('key_depart')));
         $offset =$limit * $page_number;
         $sql_product=$this->db->order_by('id','DESC')->get_where('products',array('delete_key'=>'1','view'=>'1','type'=>$this->input->post('key_depart')),$limit, $offset)->result();
if (count($sql_product)>0) {
foreach ($sql_product as $page) {

     
$id_fav =get_table_filed('favourites',array('user_id'=>$customers_id,'type'=>$this->input->post('key_depart'),'course_id'=>$page->id),"id");
if($id_fav!=""){
	$result['favourite_key']=1;
}
else{
	$result['favourite_key']=0;	
}

$Institute_name=get_table_filed('Institute',array('id_course'=>$page->id),"Institute_name");
$city_id=$page->city_id;
$result['city'] =get_table_filed('city',array('id'=>$city_id),"name");
$country_id =get_table_filed('city',array('id'=>$city_id),"country_id");
$result['country']=get_table_filed('country',array('id'=>$country_id),"title");

$result['name']=$page->name;
if($Institute_name!=""){
$result['Institute_name']=$Institute_name;
}
else {
$result['Institute_name']="";    
}

if($page->num_seats!=""){
$result['num_seats']=$page->num_seats;
}
else {
$result['num_seats']="";    
}

if($page->price>$page->discount&&$page->discount!=""&&$page->discount!=0){
  $result['discount']=$page->price; 
  $result['price']=$page->discount;
}
else{
if($page->discount==""||$page->discount==0){$result['discount']="";}
else {$result['discount']=$page->discount; }

$result['price']=$page->price;   
}

$result['id']=(int)$page->id;
if($page->total_rate!=""){
$result['total_rate']=(int)$page->total_rate;
}
else {
$result['total_rate']=0;
}
if($page->img!=""){
$result['image']=base_url()."uploads/products/".$page->img;
}
else {
$result['image']=base_url()."uploads/products/no_img.png";
}
$result['share_link']=base_url()."courses/inside/".(int)$page->id;
$data['all_inside_courses'][]= $result;
                }
                     $total = count($total);
             //$data['my_favourite'] = $result;
             $this->api_return([
              'message' => lang('Operation completed successfully'),
              'errNum' => 405,
              'status' => true,
              'total' => $total,
              "result" => $data
            ],200);
                
                
                }
                else {
             $data['all_inside_courses'] = [];
             $total = count($total);
             $this->api_return([
              'message' => lang('no_data'),
              'errNum' => 401,
              'status' => false,
              "result" => $data
              ],200);
                }
}
else {
$this->api_return([ 'message' => lang('Customer ID notcorrect'), 'errNum' => 402, 'status' => false, ],200);
}

}
}




public function filter_courses(){
  header("Access-Control-Allow-Origin: *");
  $this->_apiConfig([
      'methods' => ['POST'],
      'key' => ['POST', $this->key()]
]);
  $lang ="ar";
  $this->checkLang($lang);
$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
$this->form_validation->set_rules('limit', lang('Number of visible elements'), 'trim|required|numeric');
$this->form_validation->set_rules('page_number', lang('Page Number'), 'trim|required|numeric'); 
$this->form_validation->set_rules('key_depart', lang('Key Depart'), 'trim|required|in_list[1,3,4]'); 
$this->form_validation->set_rules('arrange_type', lang('Arrange Type'), 'trim|required|in_list[1,2]'); 
  if($this->form_validation->run() === FALSE){
      
if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}
      
if(form_error('key_depart')){
if($this->input->post('key_depart')==="" || !$this->input->post('key_depart')){
$data[] = array('message'=>strip_tags(lang('Key Depart')),"errNum" => 3);
}else{$data[] = array('message'=>strip_tags(lang('Key Depart')),"errNum" => 4);}
}

if(form_error('limit')){
if($this->input->post('limit')==="" || !$this->input->post('limit')){
$data[] = array('message'=>strip_tags(lang('limit')),"errNum" => 5);
}else{$data[] = array('message'=>strip_tags(lang('limit')),"errNum" => 6);}
}

      if(form_error('page_number')){
  if($this->input->post('page_number')==="" || !$this->input->post('page_number')){
    $data[] = array('message'=> strip_tags(lang('page_number')),"errNum" => 7);
  }else{
    $data[] = array('message'=> strip_tags(lang('page_number')),"errNum" => 8);
  }
}
      if(form_error('arrange_type')){
  if($this->input->post('arrange_type')==="" || !$this->input->post('arrange_type')){
    $data[] = array('message'=> strip_tags(lang('Arrange Type')),"errNum" => 9);
  }else{
    $data[] = array('message'=> strip_tags(lang('Arrange Type_error')),"errNum" => 10);
  }
}

            $this->api_return([
  'message' => $data[0]['message'],
  'errNum' => $data[0]['errNum'],
  'status' => false
],200);
  }
else{


    $limit=$this->input->post('limit');
    $page_number=$this->input->post('page_number');
     $offset =$limit * $page_number;
     $user_mode_key=$this->input->post('user_mode_key');
if($user_mode_key!=""&&$user_mode_key==0){
 $customers_id=-1;   
}
else {
$customers_id=get_customer_id($this->input->post('token_id'));    
}

 if($customers_id!=""){
$this->db->select('*');
$this->db->from('products');

if($this->input->post('city_id')!=""){
$this->db->where('city_id',$this->input->post('city_id'));  
}
if($this->input->post('cat_id')!=""){
     $arry_interest= explode(',', $this->input->post('cat_id'));
   for($i=0; $i<count($arry_interest); $i++){
$this->db->where('cat_id',$arry_interest[$i]);  
$this->db->or_where('cat_id',$arry_interest[$i]); 
}
}

if($this->input->post('course_name')!=""){
$this->db->like('name', $this->input->post('course_name'));
}$this->db->where('view', '1');
$this->db->where('type',$this->input->post('key_depart'));
if($this->input->post('arrange_type')==1){$arran="asc";}else{$arran="desc";}
$this->db->order_by('price',$arran);
$this->db->limit($limit, $offset);
$query = $this->db->get();
$sql_product=$query->result();

$total =count($sql_product);
        
if (count($sql_product)>0) {
foreach ($sql_product as $page) {

 
$id_fav =get_table_filed('favourites',array('user_id'=>$customers_id,'type'=>$this->input->post('key_depart'),'course_id'=>$page->id),"id");
if($id_fav!=""){
$result['favourite_key']=1;
}
else{
$result['favourite_key']=0;	
}

$Institute_name=get_table_filed('Institute',array('id_course'=>$page->id),"Institute_name");
$city_id=$page->city_id;
$result['city'] =get_table_filed('city',array('id'=>$city_id),"name");
$country_id =get_table_filed('city',array('id'=>$city_id),"country_id");
$result['country']=get_table_filed('country',array('id'=>$country_id),"title");
$result['name']=$page->name;
if($Institute_name!=""){
$result['Institute_name']=$Institute_name;
}
else {
$result['Institute_name']="";    
}

if($page->num_seats!=""){
$result['num_seats']=$page->num_seats;
}
else {
$result['num_seats']="";    
}

if($page->price>$page->discount&&$page->discount!=""&&$page->discount!=0){
  $result['discount']=$page->price; 
  $result['price']=$page->discount;
}
else{
if($page->discount==""||$page->discount==0){$result['discount']="";}
else {$result['discount']=$page->discount; }
$result['price']=$page->price;   
}

$result['id']=(int)$page->id;
if($page->total_rate!=""){
$result['total_rate']=(int)$page->total_rate;
}
else {
$result['total_rate']=0;
}
if($page->img!=""){
$result['image']=base_url()."uploads/products/".$page->img;
}
else {
$result['image']=base_url()."uploads/products/no_img.png";
}
$result['share_link']=base_url()."courses/inside/".(int)$page->id;
$data['all_courses'][]= $result;
                }
             $this->api_return([
              'message' => lang('Operation completed successfully'),
              'errNum' => 405,
              'status' => true,
              'total' => $total,
              "result" => $data
            ],200);
                
                
                }
                else {
             $data['all_courses'] = [];
             $this->api_return([
              'message' => lang('no_data'),
              'errNum' => 401,
              'status' => false,
              "result" => $data
              ],200);
                }
                
    }
    else {$this->api_return([
              'message' => lang('Customer ID notcorrect'),
              'errNum' => 402,
              'status' => false,
              ],200);
        
    }
}
}




public function get_all_courses_outside(){
    
  header("Access-Control-Allow-Origin: *");
  $this->_apiConfig([
      'methods' => ['POST'],
      'key' => ['POST', $this->key()]
]);
  $lang ="ar";
  $this->checkLang($lang);
$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
$this->form_validation->set_rules('limit', lang('Number of visible elements'), 'trim|required|numeric');
$this->form_validation->set_rules('page_number', lang('Page Number'), 'trim|required|numeric'); 
$this->form_validation->set_rules('key_depart', lang('Key Depart'), 'trim|required|in_list[3,4]'); 
  if($this->form_validation->run() === FALSE){
      
if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}
      
if(form_error('key_depart')){
if($this->input->post('key_depart')==="" || !$this->input->post('key_depart')){
$data[] = array('message'=>strip_tags(lang('Key Depart')),"errNum" => 3);
}else{$data[] = array('message'=>strip_tags(lang('Key Depart')),"errNum" => 4);}
}

if(form_error('limit')){
if($this->input->post('limit')==="" || !$this->input->post('limit')){
$data[] = array('message'=>strip_tags(lang('limit')),"errNum" => 5);
}else{$data[] = array('message'=>strip_tags(lang('limit')),"errNum" => 6);}
}

      if(form_error('page_number')){
  if($this->input->post('page_number')==="" || !$this->input->post('page_number')){
    $data[] = array('message'=> strip_tags(lang('page_number')),"errNum" => 7);
  }else{
    $data[] = array('message'=> strip_tags(lang('page_number')),"errNum" => 8);
  }
}
            $this->api_return([
  'message' => $data[0]['message'],
  'errNum' => $data[0]['errNum'],
  'status' => false
],200);
  }
else{

$limit=$this->input->post('limit');
    $page_number=$this->input->post('page_number');
         $total = $this->data->get_table_data('products',array('delete_key'=>'1','view'=>'1','type'=>$this->input->post('key_depart')));
         $offset =$limit * $page_number;
         $sql_product=$this->db->order_by('id','DESC')->get_where('products',array('delete_key'=>'1','view'=>'1','type'=>$this->input->post('key_depart')),$limit, $offset)->result();
         
$user_mode_key=$this->input->post('user_mode_key');
if($user_mode_key!=""&&$user_mode_key==0){
 $customers_id=-1;   
}
else {
$customers_id=get_customer_id($this->input->post('token_id'));    
}

if($customers_id){
if (count($sql_product)>0) {
foreach ($sql_product as $page) {
$id_fav =get_table_filed('favourites',array('user_id'=>$customers_id,'type'=>$this->input->post('key_depart'),'course_id'=>$page->id),"id");
if($id_fav!=""){
	$result['favourite_key']=1;
}
else{
	$result['favourite_key']=0;	
}

$Institute_name=get_table_filed('Institute',array('id_course'=>$page->id),"Institute_name");
    
$result['name']=$page->name;

$city_id=$page->city_id;
$result['city'] =get_table_filed('city',array('id'=>$city_id),"name");
$country_id =get_table_filed('city',array('id'=>$city_id),"country_id");
$result['country']=get_table_filed('country',array('id'=>$country_id),"title");

if($Institute_name!=""){
$result['Institute_name']=$Institute_name;
}
else {
$result['Institute_name']="";    
}

if($page->num_seats!=""){
$result['num_seats']=$page->num_seats;
}
else {
$result['num_seats']="";    
}

if($page->price>$page->discount&&$page->discount!=""&&$page->discount!=0){
  $result['discount']=$page->price; 
  $result['price']=$page->discount;
}
else{
    if($page->discount==""||$page->discount==0){
$result['discount']=""; 
}
else {$result['discount']=$page->discount; 
}
$result['price']=$page->price;   
}

$result['id']=(int)$page->id;
if($page->total_rate!=""){
$result['total_rate']=(int)$page->total_rate;
}
else {
$result['total_rate']=0;
}
if($page->img!=""){
$result['image']=base_url()."uploads/products/".$page->img;
}
else {
$result['image']=base_url()."uploads/products/no_img.png";
}
$result['share_link']=base_url()."courses/inside/".(int)$page->id;
$data['all_outside_courses'][]= $result;
                }
                     $total = count($total);
             //$data['my_favourite'] = $result;
             $this->api_return([
              'message' => lang('Operation completed successfully'),
              'errNum' => 405,
              'status' => true,
              'total' => $total,
              "result" => $data
            ],200);
                
                
                }
                else {
             $data['all_outside_courses'] = [];
             $total = count($total);
             $this->api_return([
              'message' => lang('no_data'),
              'errNum' => 401,
              'status' => false,
              'total' => $total,
              "result" => $data
              ],200);
                }
}
else {
$this->api_return([
'message' => lang('Customer ID notcorrect'),
'errNum' => 402,
'status' => false,
],200);
}

}
}





public function get_all_myrequest(){
  header("Access-Control-Allow-Origin: *");
  // API Configuration #endregion
  //this configration for any api
  $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
    // ,'requireAuthorization' => true //this used if reqired token valye
]);
  $lang ="ar";
  $this->checkLang($lang);
  $this->input->post('customer_id');
$this->load->library('form_validation');


$this->form_validation->set_rules('limit', lang('Number of visible elements'), 'trim|required|numeric');
$this->form_validation->set_rules('page_number', lang('Page Number'), 'trim|required|numeric'); 
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');


  if($this->form_validation->run() === FALSE){
      
      
      if(form_error('customer_id')){
if($this->input->post('customer_id')==="" || !$this->input->post('customer_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}
      
if(form_error('limit')){
if($this->input->post('limit')==="" || !$this->input->post('limit')){
$data[] = array('message'=>strip_tags(lang('limit')),"errNum" => 0);
}else{$data[] = array('message'=>strip_tags(lang('limit')),"errNum" => 1);}
}

      if(form_error('page_number')){
  if($this->input->post('page_number')==="" || !$this->input->post('page_number')){
    $data[] = array('message'=> strip_tags(lang('page_number')),"errNum" => 0);
  }else{
    $data[] = array('message'=> strip_tags(lang('page_number')),"errNum" => 1);
  }
}
   $this->api_return([
  'message' => $data[0]['message'],
  'errNum' => $data[0]['errNum'],
  'status' => false
],200);
  }
else{

 $customers_id=get_customer_id($this->input->post('token_id'));
 if($customers_id!=""){

    $limit=$this->input->post('limit');
    $page_number=$this->input->post('page_number');
         $total = $this->data->get_table_data('request_courses',array("id_user"=>$customers_id));
         $offset =$limit * $page_number;
         $sql_product=$this->db->order_by('id','DESC')->get_where('request_courses',array("id_user"=>$customers_id),$limit, $offset)->result();
         
         if (count($sql_product)>0) {
            foreach ($sql_product as $page) {
                $type=$page->type;
                 $id_course=$page->id_course;
                $request_code=$page->request_code;
                $type_payment=$page->type_payment;
                $status=$page->status;
                $view=$page->view;
                if($type==2){
  $course_name=get_table_filed('bag_info',array('id'=>$id_course,'view'=>'1'),"bage_name");                   
                }
                else {
 $course_name=get_table_filed('products',array('id'=>$id_course,'view'=>'1'),"name");                     
                }
$result['course_name']=$course_name;
$result['request_number']=$request_code;
$result['course_key']=$page->type;
$result['id']=(int)$page->id;
$result['payment_confirm']=(int)$view;
$result['request_confirm']=(int)$status;
$data['all_myrequest'][]= $result;
                }
                     $total = count($total);
             $this->api_return([
              'message' => lang('Operation completed successfully'),
              'errNum' => 405,
              'status' => true,
              'total' => $total,
              "result" => $data
            ],200);
                
                
                }
                else {
             $data['all_myrequest'] = [];
             $total = count($total);
             $this->api_return([
              'message' => lang('no_data'),
              'errNum' => 401,
              'status' => false,
              "result" => $data
              ],200);
                }
 }
 else {
     
 $this->api_return([
'message' => lang('Customer ID notcorrect'),
'errNum' =>402,
'status' => false
],200); 

 }
 
}

}




public function get_all_myfavorite(){
  header("Access-Control-Allow-Origin: *");
  $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
   // ,'requireAuthorization' => true //this used if reqired token valye
]);
  $lang ="ar";
  $this->checkLang($lang);
$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
$customer_id=get_customer_id($this->input->post('token_id'));

$total = $this->db->get_where('favourites',array('user_id'=>$customer_id))->result();
if(count($total)>20){
$this->form_validation->set_rules('limit', lang('Number of visible elements'), 'trim|required|numeric');
$this->form_validation->set_rules('page_number', lang('Page Number'), 'trim|required|numeric'); 
}
  if($this->form_validation->run() === FALSE){
		if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}

$total = $this->db->get_where('favourites',array('user_id'=>$customer_id))->result();

if(form_error('limit')&&count($total)>20){
if($this->input->post('limit')==="" || !$this->input->post('limit')){
$data[] = array('message'=>strip_tags(lang('limit')),"errNum" => 0);
}else{$data[] = array('message'=>strip_tags(lang('limit')),"errNum" => 1);}
}

 if(form_error('page_number')&&count($total)>20){
  if($this->input->post('page_number')==="" || !$this->input->post('page_number')){
    $data[] = array('message'=> strip_tags(lang('page_number')),"errNum" =>0);
  }else{
    $data[] = array('message'=> strip_tags(lang('page_number')),"errNum" => 1);
  }
}if($data[0]['errNum']){
$this->api_return([
  'message' => $data[0]['message'],
  'errNum' => $data[0]['errNum'],
  'status' => false
],200);
}
else {
$data['all favorites'] = [];
$total = count($total);
$this->api_return([
'message' => lang('no_data'),
'errNum' => 401,
'status' => false,
"result" => $data
],200); 
}
  }
else{
$limit=$this->input->post('limit');
$customer_id=get_customer_id($this->input->post('token_id'));
    $page_number=$this->input->post('page_number');
         $total = $this->data->get_table_data('favourites',array('user_id'=>$customer_id));
         $offset =$limit * $page_number;
         $sql_product=$this->db->order_by('id','DESC')->get_where('favourites',array('user_id'=>$customer_id),$limit, $offset)->result();
         if (count($sql_product)>0) {
            foreach ($sql_product as $page) {
                $course_id=(int)$page->course_id;
                 $type=(int)$page->type;
                 if($type==2){
$sql_bag=$this->db->order_by('id','DESC')->get_where('bag_info',array('id'=>$course_id,'view'=>'1'))->result();
  foreach ($sql_bag as $bage)
 $dep_id=$bage->dep_id;
 $result['id']=(int)$bage->id;
  $result['course_key']=(int)2;
  
$result['name']=$bage->bage_name;

$result['department_name']=get_table_filed('department',array('id'=>$dep_id),"name");

 $result['price']="";
 $result['discount']="";  

 $result['city']="";
 $result['country']="";

if($dep_id!=0){
$result['category'] =get_table_filed('category',array('id'=>$dep_id),"name");
}
else {
$result['category']="";
}
 
  

if($bage->total_rate!=""){
$result['total_rate']=(int)$bage->total_rate;
}
else {
$result['total_rate']=0;
}
if($bage->img!=""){
$result['image']=base_url()."uploads/products/".$bage->img;
}
else {
$result['image']=base_url()."uploads/products/no_img.png";
}  

$Institute_name=get_table_filed('Institute',array('id_course'=>$customer_id),"Institute_name");
if($Institute_name!=""){
$result['Institute_name'] = $Institute_name;
}
else{
  $result['Institute_name'] = "";  
}

     }
     
else {
 
 $sql_bag=$this->db->order_by('id','DESC')->get_where('products',array('id'=>$course_id,'view'=>'1'))->result();
  foreach ($sql_bag as $bage)
  $city_id=$bage->city_id;
 $dep_id=$bage->cat_id;
 $result['id']=(int)$bage->id;
 $result['course_key']=(int)$bage->type;
 
$result['name']=$bage->name;
$result['department_name']=get_table_filed('department',array('id'=>$dep_id),"name");
if($bage->discount<$bage->price&&$bage->discount!=""){
 $result['price']=$bage->discount;
 $result['discount']=$bage->price;  
}
else {
  $result['price']=$bage->price;
  if($bage->discount==""){ $result['discount']="";  }
  else {$result['discount']=$bage->discount; }
}
  if($city_id!=0){
  $result['city'] =get_table_filed('city',array('id'=>$city_id),"name");
$country_id =get_table_filed('city',array('id'=>$city_id),"country_id");
$result['country']=get_table_filed('country',array('id'=>$country_id),"title");
}
else {
 $result['city']="";
 $result['country']="";
}

if($dep_id!=0){
$result['category'] =get_table_filed('category',array('id'=>$dep_id),"name");
}
else {
$result['category']="";
}
 
  

if($bage->total_rate!=""){
$result['total_rate']=(int)$bage->total_rate;
}
else {
$result['total_rate']=0;
}
if($bage->img!=""){
$result['image']=base_url()."uploads/products/".$bage->img;
}
else {
$result['image']=base_url()."uploads/products/no_img.png";
}    

$Institute_name=get_table_filed('Institute',array('id_course'=>$customer_id),"Institute_name");
if($Institute_name!=""){
$result['Institute_name'] = $Institute_name;
}
else{
  $result['Institute_name'] = "";  
}

    
}

$data['all favorites'][]= $result;
                }
                     $total = count($total);
             //$data['my_favourite'] = $result;
             $this->api_return([
              'message' => lang('Operation completed successfully'),
              'errNum' => 405,
              'status' => true,
              'total' => $total,
              "result" => $data
            ],200);
                
                
                }
                else {
			$data['all favorites'] = [];
             $total = count($total);
             $this->api_return([
              'message' => lang('no_data'),
              'errNum' => 401,
              'status' => false,
              "result" => $data
              ],200);
                }
}

}






public function update_myfavorite(){
  header("Access-Control-Allow-Origin: *");
  $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
]);
  $lang ="ar";
  $this->checkLang($lang);
$this->load->library('form_validation');

$this->form_validation->set_rules('id_course', lang('Course ID'), 'trim|required|numeric');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
$this->form_validation->set_rules('course_key', lang('course_key'), 'trim|required|numeric');
$this->form_validation->set_rules('action_type', lang('action_type'), 'trim|required|numeric|in_list[1,2]');

  if($this->form_validation->run() === FALSE){
      
if(form_error('id_course')){
if($this->input->post('id_course')==="" || !$this->input->post('id_course')){
$data[] = array('message'=> strip_tags(lang('Course ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Course ID')),"errNum" => 1);
}	
}

if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}
else {
$id=get_customer_id($this->input->post('token_id'));
if($id==""){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}
}	
}


if(form_error('course_key')){
if($this->input->post('course_key')==="" || !$this->input->post('course_key')){
$data[] = array('message'=> strip_tags(lang('course_key')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('course_key')),"errNum" => 1);
}	
}


if(form_error('action_type')){
if($this->input->post('action_type')==="" || !$this->input->post('action_type')){
$data[] = array('message'=> strip_tags(lang('action_type')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('action_type')),"errNum" => 1);
}	
}

$this->api_return([
  'message' => $data[0]['message'],
  'errNum' => $data[0]['errNum'],
  'status' => false
],200);

  }
else{
    $idcustomers=get_customer_id($this->input->post('token_id'));
    if($idcustomers!=""){
    if($this->input->post('action_type')==2){
    $this->db->delete("favourites",array("user_id"=>$idcustomers,'course_id'=>$this->input->post('id_course'),'type'=>$this->input->post('course_key')));
$this->api_return([
'message' => lang('delete_fav'),
'errNum' => 405,
'status' => true
],200);
    }
 else  if($this->input->post('action_type')==1){
$total_find= $this->db->get_where("favourites",array("user_id"=>$idcustomers,'course_id'=>$this->input->post('id_course'),'type'=>$this->input->post('course_key')))->result();
if(count($total_find)>0){
 $this->api_return([
'message' => lang('exite_fav'),
'errNum' => 405,
'status' => true
],200);   
}
else {
    $data_fav['user_id']=$idcustomers;
    $data_fav['course_id']=$this->input->post('id_course');
    $data_fav['type']=$this->input->post('course_key');
    $data_fav['creation_date']=date("Y-m-d");
    $this->db->insert("favourites",$data_fav);
     $this->api_return([
'message' => lang('add_fav'),
'errNum' => 405,
'status' => true
],200);  
}
    }
    else  {
$this->api_return([
'message' => lang('Customer ID_notfind'),
'errNum' => 4,
'status' => false
],200);
    }

}



}
}


public function get_course_details_bage(){
  header("Access-Control-Allow-Origin: *");
  $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
    //,'requireAuthorization' => true //this used if reqired token valye
]);
  $lang ="ar";
  $this->checkLang($lang);

$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
$this->form_validation->set_rules('course_id', lang('key_depart'), 'trim|required|numeric');
$this->form_validation->set_rules('key_depart', lang('Course Key'), 'trim|required|numeric');
 if($this->form_validation->run() === FALSE){
     
 if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}    
    
if(form_error('course_id')){
if($this->input->post('course_id')==="" || !$this->input->post('course_id')){
$data[] = array('message'=> strip_tags(lang('Course ID')),"errNum" => 2);
}else {
$data[] = array('message'=> strip_tags(lang('Course ID')),"errNum" => 3);
}	
}


if(form_error('key_depart')){
if($this->input->post('key_depart')==="" || !$this->input->post('key_depart')){
$data[] = array('message'=> strip_tags(lang('Course Key')),"errNum" => 4);
}else {
$data[] = array('message'=> strip_tags(lang('Course Key')),"errNum" => 5);
}	
}


$this->api_return([
  'message' => $data[0]['message'],
  'errNum' => $data[0]['errNum'],
  'status' => false
],200);
}
else{
$user_mode_key=$this->input->post('user_mode_key');
if($user_mode_key!=""&&$user_mode_key==0){
 $customers_id=-1;   
}
else {
$customers_id=get_customer_id($this->input->post('token_id'));    
}
if($customers_id!=""){

if($this->input->post('key_depart')==2){
    
    
$sql_bag=$this->db->order_by('id','DESC')->get_where('bag_info',array('id'=>$this->input->post('course_id'),'view'=>'1'))->result();
  foreach ($sql_bag as $bage)
 $dep_id=$bage->dep_id;
 $result['id']=(int)$bage->id;
 
 $count_fav =$this->db->get_where('reviews',array('id_course'=>$bage->id,'course_key'=>$this->input->post('key_depart')))->result();
$result['rate_count']=(int)count($count_fav);
 
 $id_fav =get_table_filed('favourites',array('user_id'=>$customers_id,'type'=>$this->input->post('key_depart'),'course_id'=>$bage->id),"id");
if($id_fav!=""){
	$result['favourite_key']=1;
}
else{
	$result['favourite_key']=0;	
}

$id_request =get_table_filed('request_courses',array('id_user'=>$customers_id,'type'=>'2','id_course'=>$bage->id),"id");
if($id_request!=""){
	$result['requested_key']=1;
}
else{
	$result['requested_key']=0;	
}
 
  $result['course_key']=(int)$bage->dep_id;
$result['name']=$bage->bage_name;
if($bage->bage_details!=""){
$result['details']=$bage->bage_details;
}else {$result['details']="";}
if($bage->bage_hrs!=""){
$result['bage_hrs']=(int)$bage->bage_hrs;
}else {$result['bage_hrs']="";}

if($bage->week_bage_daies!=""){
$result['week_bage_daies']=(int)$bage->week_bage_daies;
}else {$result['week_bage_daies']="";}


if($bage->bage_total_daies!=""){
$result['bage_total_daies']=(int)$bage->bage_total_daies;
}else {$result['bage_total_daies']="";}


$sql_bag_content=$this->db->order_by('id','DESC')->get_where('course_info',array('id_course'=>$bage->id,'view'=>'1','type'=>$this->input->post('key_depart')))->result();
if(count($sql_bag_content)>0){
  foreach ($sql_bag_content as $bag_content){
	$result['content_bag'][]=$bag_content->content;	
      
  }
}
else {
$result['content_bag']=[];
}

$result['department_name']=get_table_filed('department',array('id'=>$dep_id),"name");

 
if($bage->total_rate!=""){
$result['total_rate']=(int)$bage->total_rate;
}
else {
$result['total_rate']=0;
}
if($bage->img!=""){
$result['image']=base_url()."uploads/products/".$bage->img;
}
else {
$result['image']=base_url()."uploads/products/no_img.png";
} 
$result['share_link']=base_url()."courses/bags_details/".(int)$bage->id;

$data['Course details'][]= $result;
}

if($data){
$this->api_return([
              'message' => lang('Operation completed successfully'),
              'errNum' => 405,
              'status' => true,
              "result" => $data
            ],200);
}
else {
    
$data['Course details'] = [];
$this->api_return([
'message' => lang('no_data'),
'errNum' => 401,
'status' => false,
"result" => $data
],200); 
    
}


}
else {
$this->api_return([
'message' => lang('Customer ID notcorrect'),
'errNum' => 402,
'status' => false
],200);
              
}

}
}





public function get_course_details_inside_course(){
  header("Access-Control-Allow-Origin: *");
  $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
    //,'requireAuthorization' => true //this used if reqired token valye
]);
  $lang ="ar";
  $this->checkLang($lang);
  $course_key=$this->input->post('course_key');
	$course_id=$this->input->post('course_id');
$this->load->library('form_validation');
$this->form_validation->set_rules('course_id', lang('Course ID'), 'trim|required|numeric');
$this->form_validation->set_rules('course_key', lang('Course Key'), 'trim|required|numeric');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
 if($this->form_validation->run() === FALSE){
     
if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}

if(form_error('course_id')){
if($this->input->post('course_id')==="" || !$this->input->post('course_id')){
$data[] = array('message'=> strip_tags(lang('Course ID')),"errNum" => 2);
}else {
$data[] = array('message'=> strip_tags(lang('Course ID')),"errNum" => 3);
}	
}


if(form_error('course_key')){
if($this->input->post('course_key')==="" || !$this->input->post('course_key')){
$data[] = array('message'=> strip_tags(lang('Course Key')),"errNum" => 4);
}else {
$data[] = array('message'=> strip_tags(lang('Course Key')),"errNum" => 5);
}	
}


$this->api_return([
  'message' => $data[0]['message'],
  'errNum' => $data[0]['errNum'],
  'status' => false
],200);
}
else{
    
    
$user_mode_key=$this->input->post('user_mode_key');
if($user_mode_key!=""&&$user_mode_key==0){
 $customers_id=-1;   
}
else {
$customers_id=get_customer_id($this->input->post('token_id'));    
}
if($customers_id!=""){

$sql_bag=$this->db->order_by('id','DESC')->get_where('products',array('delete_key'=>'1','id'=>$this->input->post('course_id'),'type'=>$this->input->post('course_key'),'view'=>'1'))->result();
if(count($sql_bag)>0){
  foreach ($sql_bag as $bage)
  $city_id_bage=$bage->city_id;
 $dep_id=$bage->cat_id;
 $result['id']=(int)$bage->id;
 
$result['course_key']=(int)$bage->type;
$result['name']=$bage->name;


$id_fav =get_table_filed('favourites',array('user_id'=>$customers_id,'type'=>$this->input->post('course_key'),'course_id'=>$bage->id),"id");
if($id_fav!=""){
	$result['favourite_key']=1;
}
else{
	$result['favourite_key']=0;	
}

$id_request =get_table_filed('request_courses',array('id_user'=>$customers_id,'type'=>$this->input->post('course_key'),'id_course'=>$bage->id),"id");
if($id_request!=""){
	$result['requested_key']=1;
}
else{
	$result['requested_key']=0;	
}



$count_fav =$this->db->get_where('reviews',array('id_course'=>$bage->id,'course_key'=>$this->input->post('course_key')))->result();
$result['rate_count']=(int)count($count_fav);
$Institute_name=get_table_filed('Institute',array('id_course'=>$bage->id),"Institute_name");
 $Institute_about=get_table_filed('Institute',array('id_course'=>$bage->id),"Institute_about");  
  $Institute_img=get_table_filed('Institute',array('id_course'=>$bage->id),"Institute_img");  

if($Institute_name!=""){$result['Institute_name']=$Institute_name;}
else {$result['Institute_name']="";  }

if($Institute_about!=""){$result['Institute_about']=$Institute_about;}
else {$result['Institute_about']="";  }

if($Institute_img!=""){$result['Institute_img']=base_url()."uploads/products/".$Institute_img;}
else {$result['Institute_img']=base_url()."uploads/products/no_img.png";  }

$city_id_bage=$bage->city_id;
if($city_id_bage!=0){
$result['city'] =get_table_filed('city',array('id'=>$city_id_bage),"name");
$country_id =get_table_filed('city',array('id'=>$city_id_bage),"country_id");
$result['country']=get_table_filed('country',array('id'=>$country_id),"title");
}
else {
 $result['city']="";
 $result['country']="";
}

if($bage->details!=""){
$result['details']=$bage->details;
}else {$result['details']="";}


if($bage->duration_course!=""){
$result['duration_course']=$bage->duration_course;
}else {$result['duration_course']="";}

if($dep_id!=0){
$result['category'] =get_table_filed('category',array('id'=>$dep_id),"name");
}
else {
$result['category']="";
}

if($bage->accreditation_number!=""){
$result['accreditation_number']=$bage->accreditation_number;
}
else {$result['accreditation_number']="";}

if($bage->date_course!=""){
$result['date_course']=$bage->date_course;
}else {$result['date_course']="";}



$sql_bag_content=$this->db->order_by('id','DESC')->get_where('course_info',array('id_course'=>$bage->id,'view'=>'1','type'=>$this->input->post('course_key')))->result();
if(count($sql_bag_content)>0){
  foreach ($sql_bag_content as $bag_content){
	$result['content_courses'][]=$bag_content->content;	
      
  }
}
else {
$result['content_courses']=[];
}

if($bage->price>$bage->discount&&$bage->discount!=""&&$bage->discount!=0){
  $result['discount']=$bage->price; 
  $result['price']=$bage->discount;
}
else{
if($bage->discount==""||$bage->discount==0){$result['discount']="";}
else {$result['discount']=$bage->discount; }
$result['price']=$bage->price;   
}

if($bage->total_rate!=""){
$result['total_rate']=(int)$bage->total_rate;
}
else {
$result['total_rate']=0;
}
if($bage->img!=""){
$result['image']=base_url()."uploads/products/".$bage->img;
}
else {
$result['image']=base_url()."uploads/products/no_img.png";
} 
$result['share_link']=base_url()."courses/courses_details/".(int)$bage->id;



$data['Course details'][]= $result;


$this->api_return([
              'message' => lang('Operation completed successfully'),
              'errNum' => 405,
              'status' => true,
              "result" => $data
            ],200);
}
else {
    
$data['Course details'] = [];
$this->api_return([
'message' => lang('no_data'),
'errNum' => 401,
'status' => false,
"result" => $data
],200); 
    
}



 
              
}
else {
$this->api_return([
'message' => lang('Customer ID notcorrect'),
'errNum' => 402,
'status' => false
],200); }
}


}






public function get_course_details_outside_course(){
  header("Access-Control-Allow-Origin: *");
  $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
    //,'requireAuthorization' => true //this used if reqired token valye
]);
  $lang ="ar";
  $this->checkLang($lang);
  $course_key=$this->input->post('course_key');
	$course_id=$this->input->post('course_id');
$this->load->library('form_validation');
$this->form_validation->set_rules('course_id', lang('Course ID'), 'trim|required|numeric');
$this->form_validation->set_rules('course_key', lang('Course Key'), 'trim|required|numeric');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');

 if($this->form_validation->run() === FALSE){


if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}

if(form_error('course_id')){
if($this->input->post('course_id')==="" || !$this->input->post('course_id')){
$data[] = array('message'=> strip_tags(lang('Course ID')),"errNum" => 2);
}else {
$data[] = array('message'=> strip_tags(lang('Course ID')),"errNum" => 3);
}	
}


if(form_error('course_key')){
if($this->input->post('course_key')==="" || !$this->input->post('course_key')){
$data[] = array('message'=> strip_tags(lang('Course Key')),"errNum" => 4);
}else {
$data[] = array('message'=> strip_tags(lang('Course Key')),"errNum" => 5);
}	
}


$this->api_return([
  'message' => $data[0]['message'],
  'errNum' => $data[0]['errNum'],
  'status' => false
],200);
}
else{
$user_mode_key=$this->input->post('user_mode_key');
if($user_mode_key!=""&&$user_mode_key==0){
 $customers_id=-1;   
}
else {
$customers_id=get_customer_id($this->input->post('token_id'));    
}

if($customers_id!=""){

$sql_bag=$this->db->order_by('id','DESC')->get_where('products',array('delete_key'=>'1','id'=>$this->input->post('course_id'),'view'=>'1','type'=>$this->input->post('course_key')))->result();
if(count($sql_bag)>0){
  foreach ($sql_bag as $bage)
  $city_id_bage=$bage->city_id;
 $dep_id=$bage->cat_id;
 $result['id']=$bage->id;


  $city_id_bage=$bage->city_id;
 $dep_id=$bage->cat_id;
 $result['id']=(int)$bage->id;
 
$result['course_key']=$bage->type;
$result['name']=$bage->name;


$id_fav =get_table_filed('favourites',array('user_id'=>$customers_id,'type'=>$this->input->post('course_key'),'course_id'=>$bage->id),"id");
if($id_fav!=""){
	$result['favourite_key']=1;
}
else{
	$result['favourite_key']=0;	
}

$id_request =get_table_filed('request_courses',array('id_user'=>$customers_id,'type'=>$this->input->post('course_key'),'id_course'=>$bage->id),"id");
if($id_request!=""){
	$result['requested_key']=1;
}
else{
	$result['requested_key']=0;	
}


$count_fav =$this->db->get_where('reviews',array('id_course'=>$bage->id,'course_key'=>$this->input->post('course_key')))->result();
$result['rate_count']=(int)count($count_fav);

$Institute_name=get_table_filed('Institute',array('id_course'=>$bage->id),"Institute_name");
 $Institute_about=get_table_filed('Institute',array('id_course'=>$bage->id),"Institute_about");  
  $Institute_img=get_table_filed('Institute',array('id_course'=>$bage->id),"Institute_img");  

if($Institute_name!=""){$result['Institute_name']=$Institute_name;}
else {$result['Institute_name']="";  }

if($Institute_about!=""){$result['Institute_about']=$Institute_about;}
else {$result['Institute_about']="";  }

if($Institute_img!=""){$result['Institute_img']=base_url()."uploads/products/".$Institute_img;}
else {$result['Institute_img']=base_url()."uploads/products/no_img.png";  }
 

$city_id_bage=$bage->city_id;
if($city_id_bage!=0){
$result['city'] =get_table_filed('city',array('id'=>$city_id_bage),"name");
$country_id =get_table_filed('city',array('id'=>$city_id_bage),"country_id");
$result['country']=get_table_filed('country',array('id'=>$country_id),"title");
}
else {
 $result['city']="";
 $result['country']="";
}

if($bage->details!=""){
$result['details']=$bage->details ." ".$bage->home_type;;
}else {$result['details']="";}


if($bage->duration_course!=""){
$result['duration_course']=$bage->duration_course;
}else {$result['duration_course']="";}

if($dep_id!=0){
$result['category'] =get_table_filed('category',array('id'=>$dep_id),"name");
}
else {
$result['category']="";
}



$sql_bag_content=$this->db->order_by('id','DESC')->get_where('course_info',array('id_course'=>$bage->id,'view'=>'1','type'=>$this->input->post('course_key')))->result();
if(count($sql_bag_content)>0){
  foreach ($sql_bag_content as $bag_content){
	$result['content_course'][]=$bag_content->content;	
  }
}
else {
$result['content_course']=[];
}

if($bage->price>$bage->discount&&$bage->discount!=""&&$bage->discount!=0){
  $result['discount']=$bage->price; 
  $result['price']=$bage->discount;
}
else{
if($bage->discount==""||$bage->discount==0){$result['discount']="";}
else {$result['discount']=$bage->discount; }
$result['price']=$bage->price;   
}


if($bage->total_rate!=""){
$result['total_rate']=(int)$bage->total_rate;
}
else {
$result['total_rate']=0;
}



if($bage->duration_study!=""){
$result['duration_study']=$bage->duration_study;
}else {$result['duration_study']="";}


if($bage->img!=""){
$result['image']=base_url()."uploads/products/".$bage->img;
}
else {
$result['image']=base_url()."uploads/products/no_img.png";
} 
$result['share_link']=base_url()."courses/courses_details/".(int)$bage->id;

$data['Course details'][]= $result;


if($data){
$this->api_return([
              'message' => lang('Operation completed successfully'),
              'errNum' => 405,
              'status' => true,
              "result" => $data
            ],200);
}
}

else {
$data['Course details'] = [];
$this->api_return([
'message' => lang('no_data'),
'errNum' => 401,
'status' => false,
"result" => $data
],200); 
    
}
}
else {$this->api_return([
'message' => lang('Customer ID notcorrect'),
'errNum' => 402,
'status' => false
],200);}
}

}




public function get_bank_accounts(){
    
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'], //This Function by default request method GET
            'key' => ['POST', $this->key()]
        ]);
       $lang = "ar";
    $this->checkLang($lang);
$this->load->library('form_validation');

$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');

  if($this->form_validation->run() === FALSE){
	if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}

$this->api_return([
        'message' => $data[0]['message'],
        'errNum' => $data[0]['errNum'],
        'status' => false
    ],200);
    
  }
else {	
    $home_city=$this->db->order_by('id','desc')->get_where('bank_accounts',array('view'=>'1'))->result();
		if (count($home_city)>0) {

        foreach ($home_city as $page) {
            $result['name_bank']=$page->name_bank;
             $result['user account name']=$page->user_name;
             $result['account_number']=$page->account_number;
             $result['iban_number']=$page->iban_number;
        $data['Bank Accounts'][]= $result;
        }
        
        
		}
	    else{
        	$data['Bank Accounts'][]= lang('no_data');
       }
    
    
	
if($data){
$this->api_return([
'keynum' => 405, //active4web copyright 2019
'status' => true,
"result" => $data
],200); 
}

else {
         $data['pages'] = [];
        $this->api_return([
		'message' => lang('no_data'),
				'keynum' =>401,
				'status' => false,
				"result" => $data
				],200);   
}
       
}

 }






public function preparation_from_bank(){
    
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'], //This Function by default request method GET
            'key' => ['POST', $this->key()]
          // ,'requireAuthorization' => true //this used if reqired token valye
        ]);
       $lang = "ar";
    $this->checkLang($lang);
$this->load->library('form_validation');
 
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');

  if($this->form_validation->run() === FALSE){
		if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}

$this->api_return([
        'message' => $data[0]['message'],
        'errNum' => $data[0]['errNum'],
        'status' => false
    ],200);
    
    
  }
else {	
    $bank_accounts=$this->db->order_by('id','desc')->get_where('bank_accounts',array('view'=>'1'))->result();
		if (count($bank_accounts)>0) {
        foreach ($bank_accounts as $page) {
      $result['bank_name']=$page->name_bank;
      $result['bank_id']=$page->id;
        $data['bank_accounts'][]= $result;
        }
        
        
		}
	    else{
        $data['bank_accounts'][]= lang('no_data');
       }
    
    
	$payment_type=$this->db->order_by('id','desc')->get_where('bank_payment_type',array('view'=>'1'))->result();
		if (count($payment_type)>0) {
            	
        foreach ($payment_type as $payments) {
            $result_cat['category_name']=$payments->name;
             $result_cat['category_id']=$payments->id;
        $data['payment_type'][]= $result_cat;
        }
             
            }
      
      else{
	$data['payment_type'][]= lang('no_data');
       }
       
       
       
       
if($data){
$this->api_return([
'keynum' => 405, //active4web copyright 2019
'status' => true,
"result" => $data
],200); 
}

else {
         $data['pages'] = [];
        $this->api_return([
		'message' => lang('no_data'),
				'keynum' =>401,
				'status' => false,
				"result" => $data
				],200);   
}
       
}

}




public function payment_from_bank(){
    
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'], //This Function by default request method GET
            'key' => ['POST', $this->key()]
          // ,'requireAuthorization' => true //this used if reqired token valye
        ]);
       $lang = "ar";
    $this->checkLang($lang);
$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');

$this->form_validation->set_rules('user_name', lang('Name converter'), 'trim|required');
  $this->form_validation->set_rules('bank_img', lang('bank_img'), 'trim|required');
  
    $this->form_validation->set_rules('payment_type', lang('Payment type'), 'trim|required');
$this->form_validation->set_rules('course_id', lang('Course ID'), 'trim|required');
$this->form_validation->set_rules('course_key', lang('Course Key'), 'trim|required|numeric');
     
if($this->form_validation->run() === FALSE){
			
if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}

if(form_error('user_name')){
if($this->input->post('user_name')==="" || !$this->input->post('user_name')){
$data[] = array('message'=> strip_tags(lang('Name converter')),"errNum" => 2);
}else {
$data[] = array('message'=> strip_tags(lang('Name converter')),"errNum" => 3);
}	
}




if(form_error('payment_type')){
if($this->input->post('payment_type')==="" || !$this->input->post('payment_type')){
$data[] = array('message'=> strip_tags(lang('Payment type')),"errNum" => 4);
}else {
$data[] = array('message'=> strip_tags(lang('Payment type')),"errNum" => 5);
}	
}


if(form_error('bank_img')){
if($this->input->post('bank_img')==="" || !$this->input->post('bank_img')){
$data[] = array('message'=> strip_tags(lang('Bank img')),"errNum" => 6);
}else {
$data[] = array('message'=> strip_tags(lang('Bank img')),"errNum" => 7);
}	
}


if(form_error('course_id')){
if($this->input->post('course_id')==="" || !$this->input->post('course_id')){
$data[] = array('message'=> strip_tags(lang('Course ID')),"errNum" => 8);
}else {
$data[] = array('message'=> strip_tags(lang('Course ID')),"errNum" => 9);
}	
}

if(form_error('namebank')){
if($this->input->post('bank_id')==="" || !$this->input->post('bank_id')){
$data[] = array('message'=> strip_tags(lang('Bank name')),"errNum" => 10);
}else {
$data[] = array('message'=> strip_tags(lang('Bank name')),"errNum" => 11);
}	
}

if(form_error('course_key')){
if($this->input->post('course_key')==="" || !$this->input->post('course_key')){
$data[] = array('message'=> strip_tags(lang('Course Key')),"errNum" =>12);
}else {
$data[] = array('message'=> strip_tags(lang('Course Key')),"errNum" =>13);
}	
}


$this->api_return([
        'message' => $data[0]['message'],
        'errNum' => $data[0]['errNum'],
        'status' => false
    ],200);
    
    
  }
else {	
    
     $customers_id=get_customer_id($this->input->post('token_id'));
 if($customers_id!=""){
    
 date_default_timezone_set('Asia/Riyadh');
            $store = [
                      'id_bank'      => $this->input->post('bank_id'),
                      'id_user'      => $customers_id,
                      'id_course'    => $this->input->post('course_id'),
                      'name_payment' => $this->input->post('user_name'),
                      'convert_type' => $this->input->post('payment_type'),
                      'key_type'     => $this->input->post('course_key'),
                      'creation_date'     => date("Y-m-d")
                    ];
                    $insert = $this->db->insert('bank_accounts_forms',$store);
                   $id= $this->db->insert_id();
                   
if ($this->input->post('bank_img')) {
  $image_name = gen_random_string();
  $filename = $image_name . '.' . 'png';
  $image = base64_decode($this->input->post("bank_img"));
  $path = "uploads/Banks_accounts/".$filename;
  file_put_contents($path, $image);
$store['img'] = $filename;

$this->Main_model->update('bank_accounts_forms',['id'=>$id],$store);
}
                    
            //////////////////////////////////////////////Send SMS Code
             //Check Insert User Data
            if($insert){


   $store_request = [
                      'id_bank'      => $id,
                      'id_user'      => $customers_id,
                      'id_course'    => $this->input->post('course_id'),
                      'final_price' => $this->input->post('final_price'),
                      'type'     => $this->input->post('course_key'),
                      'creation_date'     => date("Y-m-d"),
                       'request_code'     => gen_random_string_code(),
                       'type_payment'=>'1'
                    ];
                    $insert = $this->db->insert('request_courses',$store_request);
                   //$id= $this->db->insert_id();

$customer = get_this('bank_accounts_forms',['id'=>$id]);

  if ($customer) {
$customer_infop['id'] =$id;
$customer_infop['name converter'] = $this->input->post('user_name')
;
$customer_infop['payment_type'] =get_table_filed('bank_payment_type',array('id'=>$this->input->post('payment_type')),"name");

$customer_infop['bank name'] =get_table_filed('bank_accounts',array('id'=> $this->input->post('bank_id')),"name_bank");

if($this->input->post('course_key')==2){
$customer_infop['course name'] =get_table_filed('bag_info',array('id'=>$this->input->post('course_id')),"bage_name");
}
else {
   $customer_infop['course name'] =get_table_filed('products',array('id'=>$this->input->post('course_id')),"name");
}
if(get_table_filed('bank_accounts_forms',array('id'=>$id),"img")!=""){
$customer_infop['img'] = base_url()."uploads/Banks_accounts/".get_table_filed('bank_accounts_forms',array('id'=>$id),"img");
}
else {
$customer_infop['img'] = base_url()."uploads/Banks_accounts/no_img.png";   
}
 $data['payment_info'] = $customer_infop;

  }
       
       
       
       
if($data){
    
$this->api_return([
'message' => lang('تم اضافة بيانات الدفع بنجاح وسوف يتم مراجعتها من الادارة'),
'keynum' => 405, //active4web copyright 2019
'status' => true,
"result" => $data
],200); 
}

else {
         $data['pages'] = [];
        $this->api_return([
		'message' => lang('no_data'),
				'keynum' =>401,
				'status' => false,
				"result" => $data
				],200);   
}
       

}
}


else {
$this->api_return([
'message' => lang('Customer ID notcorrect'),
'errNum' => 402,
'status' => false
],200);    
}

}
}




public function requested_bags(){
    
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'], //This Function by default request method GET
            'key' => ['POST', $this->key()]
          // ,'requireAuthorization' => true //this used if reqired token valye
        ]);
       $lang = "ar";
    $this->checkLang($lang);
$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
$this->form_validation->set_rules('course_id', lang('Course ID'), 'trim|required');
     
if($this->form_validation->run() === FALSE){
if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}

if(form_error('course_id')){
if($this->input->post('course_id')==="" || !$this->input->post('course_id')){
$data[] = array('message'=> strip_tags(lang('Course ID')),"errNum" =>2);
}else {
$data[] = array('message'=> strip_tags(lang('Course ID')),"errNum" =>3);
}	
}




$this->api_return([
        'message' => $data[0]['message'],
        'errNum' => $data[0]['errNum'],
        'status' => false
    ],200);
    
    
  }
else {	
    
     $customers_id=get_customer_id($this->input->post('token_id'));
 if($customers_id!=""){
    
 date_default_timezone_set('Asia/Riyadh');


   $store_request = [
                      'id_user'      => $customers_id,
                      'id_course'    => $this->input->post('course_id'),
                      'type'     => $this->input->post('course_key'),
                      'creation_date'     => date("Y-m-d"),
                       'request_code'     => gen_random_string_code(),
                       'type_payment'=>'2',
                       'view'=>'0'
                    ];
                    $insert = $this->db->insert('request_courses',$store_request);
                    $id= $this->db->insert_id();
 
if($id){
$this->api_return([
'message' =>"تم اضافة طلبكم بنجاح",
'keynum' => 405, //active4web copyright 2019
'status' => true
],200); 
}

else {
         $data['pages'] = [];
        $this->api_return([
		'message' => lang('no_data'),
				'keynum' =>401,
				'status' => false,
				"result" => $data
				],200);   
}
       


}


else {
$this->api_return([
'message' => lang('Customer ID notcorrect'),
'errNum' =>402,
'status' => false
],200);    
}

}
}









/******* Start 22-4-2019*******************/

/*************API_1**********/
public function get_all_review(){
  header("Access-Control-Allow-Origin: *");
  $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
  //  ,'requireAuthorization' => true //this used if reqired token valye
]);
  $lang ="ar";
  $this->checkLang($lang);
$this->load->library('form_validation');
$this->form_validation->set_rules('id_course', lang('Course ID'), 'trim|required|numeric');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');

$total = $this->db->get_where('reviews',array('id_course'=>$this->input->post('id_course')))->result();
if(count($total)>20){
$this->form_validation->set_rules('limit', lang('Number of visible elements'), 'trim|required|numeric');
$this->form_validation->set_rules('page_number', lang('Page Number'), 'trim|required|numeric'); 
}
  if($this->form_validation->run() === FALSE){
		if(form_error('id_course')){
if($this->input->post('id_course')==="" || !$this->input->post('id_course')){
$data[] = array('message'=> strip_tags(lang('Course ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Course ID')),"errNum" => 1);
}	
}

if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}

$total = $this->db->get_where('reviews',array('id_course'=>$this->input->post('id_course'),'course_key'=>$this->input->post('course_key')))->result();

if(form_error('limit')&&count($total)>20){
if($this->input->post('limit')==="" || !$this->input->post('limit')){
$data[] = array('message'=>strip_tags(lang('limit')),"errNum" => 0);
}else{$data[] = array('message'=>strip_tags(lang('limit')),"errNum" => 1);}
}

 if(form_error('page_number')&&count($total)>20){
  if($this->input->post('page_number')==="" || !$this->input->post('page_number')){
    $data[] = array('message'=> strip_tags(lang('page_number')),"errNum" =>0);
  }else{
    $data[] = array('message'=> strip_tags(lang('page_number')),"errNum" => 1);
  }
}
$this->api_return([
  'message' => $data[0]['message'],
  'errNum' => $data[0]['errNum'],
  'status' => false
],200);


  }
else{
$limit=$this->input->post('limit');
    $page_number=$this->input->post('page_number');
       $total = $this->db->get_where('reviews',array('id_course'=>$this->input->post('id_course'),'course_key'=>$this->input->post('course_key')))->result();
         $offset =$limit * $page_number;
         $sql_product=$this->db->order_by('id','DESC')->get_where('reviews',array('id_course'=>$this->input->post('id_course'),'course_key'=>$this->input->post('course_key')),$limit, $offset)->result();
         if (count($sql_product)>0) {
            foreach ($sql_product as $page) {
                $user_id=$page->user_id;
				$comment=$page->comment;
				$rate=$page->rate;
				
$result['user_name']=get_table_filed('customers',array('id'=>$user_id),"user_name");
$result['comment']=$page->comment;
$result['rate_value']=(int)$page->rate;
$result['rate_id']=(int)$page->id;
$data['all reviews'][]= $result;
			}

 $this->api_return([
              'message' => lang('Operation completed successfully'),
              'errNum' => 405,
              'status' => true,
              'total' => count($total),
              "result" => $data
            ],200);

                }

                else {
			$data['all reviews'] = [];
             $this->api_return([
              'message' => lang('no_data'),
              'errNum' => 401,
              'status' => false,
              "result" => $data
              ],200);
                }
}

}




/***************ADD REVIEW****************************/

public function add_new_review(){
  header("Access-Control-Allow-Origin: *");
  $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
  //  ,'requireAuthorization' => true //this used if reqired token valye
]);
  $lang ="ar";
  $this->checkLang($lang);
$this->load->library('form_validation');
$this->form_validation->set_rules('id_course', lang('Course ID'), 'trim|required|numeric');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
$this->form_validation->set_rules('comment', lang('Review comment'), 'trim|required');
$this->form_validation->set_rules('course_key', lang('course_key'), 'trim|required|numeric');
$this->form_validation->set_rules('rate_value', lang('rate_value'), 'trim|required|numeric|in_list[1,2,3,4,5]');

  if($this->form_validation->run() === FALSE){
      
if(form_error('id_course')){
if($this->input->post('id_course')==="" || !$this->input->post('id_course')){
$data[] = array('message'=> strip_tags(lang('Course ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Course ID')),"errNum" => 1);
}	
}

if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}
else {
$id=get_customer_id($this->input->post('token_id'));
if($id==""){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}
}	
}


if(form_error('course_key')){
if($this->input->post('course_key')==="" || !$this->input->post('course_key')){
$data[] = array('message'=> strip_tags(lang('course_key')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('course_key')),"errNum" => 1);
}	
}


if(form_error('rate_value')){
if($this->input->post('rate_value')==="" || !$this->input->post('rate_value')){
$data[] = array('message'=> strip_tags(lang('rate_value')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('rate_value')),"errNum" => 1);
}	
}


if(form_error('comment')){
if($this->input->post('comment')==="" || !$this->input->post('comment')){
$data[] = array('message'=> strip_tags(lang('Review comment')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Review comment')),"errNum" => 1);
}	
}


$this->api_return([
  'message' => $data[0]['message'],
  'errNum' => $data[0]['errNum'],
  'status' => false
],200);


  }
else{
$customers_id=get_customer_id($this->input->post('token_id'));
if($customers_id==""){
$data[] = array('message'=> strip_tags(lang('Customer ID_notfind')),"errNum" =>8);
$this->api_return([
  'message' => $data[0]['message'],
  'errNum' => $data[0]['errNum'],
  'status' => false
],200);
}
  

else {
$sql_product=$this->db->get_where('reviews',array('id_course'=>$this->input->post('id_course'),
'course_key'=>$this->input->post('course_key'),'user_id'=>$customers_id))->result();    


if(count($sql_product)>0){
$result['Review_Key'] =0;
$data['Evaluation']=$result;
$this->api_return([
'message' => lang('review add prev'),
'errNum' => 405,
'status' => false,
"result" => $data
],200);

} 
   
   else {
       
$datap['id_course']=$this->input->post('id_course');
$datap['course_key']=$this->input->post('course_key');
$datap['user_id']=$customers_id;
$datap['comment']=$this->input->post('comment');
$datap['rate']=$this->input->post('rate_value');
$this->db->insert("reviews",$datap);
 $id= $this->db->insert_id();
 if($id){
    $id_course= $this->input->post('id_course');
   $count_rate= $this->db->get_where("reviews",array("id_course"=>$id_course))->result();
  
$this->db->select_sum('rate');
    $this->db->from('reviews');
    $this->db->where("id_course=$id_course");
    $query = $this->db->get();
     $final_rate=$query->row()->rate;
         $main_rata_data['total_rate']= round($final_rate/count($count_rate));

     if($this->input->post('course_key')==2){
    $this->db->update("bag_info",$main_rata_data,array("id"=>$this->input->post('id_course')));
     }
     else {
    $this->db->update("products",$main_rata_data,array("id"=>$this->input->post('id_course')));
     }
$result['Review_Key'] =1;
$data['add_review'][]=$result;
$this->api_return([
'message' => lang('review add success'),
'errNum' => 405,
'status' => true,
"result" => $data
],200);
    
}

else {
$this->api_return([
'message' => lang('An error in the review'),
'errNum' => 4,
'status' => false
],200);
}


       
   }
    
}
}

}


/*****************END 23-4-2019*****************************/
/******* Start 22-4-2019*******************/

/*************API_1**********/

public function filter_trainers(){
  header("Access-Control-Allow-Origin: *");
  // API Configuration #endregion
  //this configration for any api
  $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
    // ,'requireAuthorization' => true //this used if reqired token valye
]);
  $lang ="ar";
  $this->checkLang($lang);
  $key_depart=$this->input->post('key_depart');
$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
$this->form_validation->set_rules('limit', lang('Number of visible elements'), 'trim|required|numeric');
$this->form_validation->set_rules('page_number', lang('Page Number'), 'trim|required|numeric'); 
$this->form_validation->set_rules('key_depart', lang('Key Depart'), 'trim|required|in_list[2]'); 
  if($this->form_validation->run() === FALSE){
      
if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}
      
if(form_error('key_depart')){
if($this->input->post('key_depart')==="" || !$this->input->post('key_depart')){
$data[] = array('message'=>strip_tags(lang('Key Depart')),"errNum" => 3);
}else{$data[] = array('message'=>strip_tags(lang('Key Depart')),"errNum" => 4);}
}

if(form_error('limit')){
if($this->input->post('limit')==="" || !$this->input->post('limit')){
$data[] = array('message'=>strip_tags(lang('limit')),"errNum" => 5);
}else{$data[] = array('message'=>strip_tags(lang('limit')),"errNum" => 6);}
}

      if(form_error('page_number')){
  if($this->input->post('page_number')==="" || !$this->input->post('page_number')){
    $data[] = array('message'=> strip_tags(lang('page_number')),"errNum" => 7);
  }else{
    $data[] = array('message'=> strip_tags(lang('page_number')),"errNum" => 8);
  }
}


            $this->api_return([
  'message' => $data[0]['message'],
  'errNum' => $data[0]['errNum'],
  'status' => false
],200);
  }
else{

$user_mode_key=$this->input->post('user_mode_key');
if($user_mode_key!=""&&$user_mode_key==0){
 $customers_id=-1;   
}
else {
$customers_id=get_customer_id($this->input->post('token_id'));    
}
if($customers_id!=""){
    $limit=$this->input->post('limit');
    $page_number=$this->input->post('page_number');
    $key_depart=$this->input->post('key_depart');
    $offset =$limit * $page_number;
$last_add=$this->db->select('*');
$this->db->from('customers');
$this->db->where('view', '1');
$this->db->where('status',$key_depart);
if($this->input->post('cat_id')!=""){
  $this->db->where('cat_id',$this->input->post('cat_id'));  
}
if($this->input->post('tariner_name')!=""){
$this->db->like('user_name', $this->input->post('tariner_name'));
}
$this->db->order_by('id','DESC');
$this->db->limit($limit, $offset);
$query = $this->db->get();
$sql_product=$query->result();
 $total = count($sql_product);
if (count($sql_product)>0) {
foreach ($sql_product as $page) {
$result['name']=$page->user_name;
$cat_id=$page->cat_id;
$name_category=get_table_filed('category',array('id'=>$cat_id),"name");
$result['id']=(int)$page->id;
if($page->about!=""){
$result['about']=$page->about;
}
else {
 $result['about']="";   
}
if($name_category!=""){
$result['category']=$name_category;
}
else {
$result['category']=""; 
}
if($page->img!=""){
$result['image']=base_url()."uploads/customers/".$page->img;
}
else {
$result['image']=base_url()."uploads/customers/no_img.png";
}

$data['all_trainers'][]= $result;
                }
             $this->api_return([
              'message' => lang('Operation completed successfully'),
              'errNum' => 405,
              'status' => true,
              'total' => $total,
              "result" => $data
            ],200);
                
                
                }
                else {



             $data['all_trainers'] =[];
             $this->api_return([
              'message' => lang('no_data'),
              'errNum' => 401,
              'status' => false,
              "result" => $data
              ],200);
                }
                
}
else {$this->api_return([ 'message' => lang('Customer ID notcorrect'), 'errNum' => 402, 'status' => false, ],200);}
}

}
















public function get_all_trainers(){
  header("Access-Control-Allow-Origin: *");

  $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
]);
  $lang ="ar";
  $this->checkLang($lang);
  $key_depart=$this->input->post('key_depart');
$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
$this->form_validation->set_rules('limit', lang('Number of visible elements'), 'trim|required|numeric');
$this->form_validation->set_rules('page_number', lang('Page Number'), 'trim|required|numeric'); 
$this->form_validation->set_rules('key_depart', lang('Key Depart'), 'trim|required|in_list[2]'); 
  if($this->form_validation->run() === FALSE){
      
if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}
      
if(form_error('key_depart')){
if($this->input->post('key_depart')==="" || !$this->input->post('key_depart')){
$data[] = array('message'=>strip_tags(lang('Key Depart')),"errNum" => 3);
}else{$data[] = array('message'=>strip_tags(lang('Key Depart')),"errNum" => 4);}
}

if(form_error('limit')){
if($this->input->post('limit')==="" || !$this->input->post('limit')){
$data[] = array('message'=>strip_tags(lang('limit')),"errNum" => 5);
}else{$data[] = array('message'=>strip_tags(lang('limit')),"errNum" => 6);}
}

      if(form_error('page_number')){
  if($this->input->post('page_number')==="" || !$this->input->post('page_number')){
    $data[] = array('message'=> strip_tags(lang('page_number')),"errNum" => 7);
  }else{
    $data[] = array('message'=> strip_tags(lang('page_number')),"errNum" => 8);
  }
}


            $this->api_return([
  'message' => $data[0]['message'],
  'errNum' => $data[0]['errNum'],
  'status' => false
],200);
  }
else{


    $limit=$this->input->post('limit');
    $page_number=$this->input->post('page_number');
    $key_depart=$this->input->post('key_depart');
         $total = $this->data->get_table_data('customers',array('view'=>'1','status'=>$key_depart));
         $offset =$limit * $page_number;
         $sql_product=$this->db->order_by('id','DESC')->get_where('customers',array('view'=>'1','status'=>$key_depart),$limit, $offset)->result();
$user_mode_key=$this->input->post('user_mode_key');
if($user_mode_key!=""&&$user_mode_key==0){
 $customers_id=-1;   
}
else {
$customers_id=get_customer_id($this->input->post('token_id'));    
}
if($customers_id!=""){
         if (count($sql_product)>0) {
            foreach ($sql_product as $page) {
$result['name']=$page->user_name;
$cat_id=$page->cat_id;
$name_category=get_table_filed('category',array('id'=>$cat_id),"name");
$result['id']=(int)$page->id;
if($page->about!=""){
$result['about']=$page->about;
}
else {
 $result['about']="";   
}
if($name_category!=""){
$result['category']=$name_category;
}
else {
$result['category']=""; 
}
if($page->img!=""){
$result['image']=base_url()."uploads/customers/".$page->img;
}
else {
$result['image']=base_url()."uploads/customers/no_img.png";
}

$data['all_trainers'][]= $result;
                }
                     $total = count($total);
             //$data['my_favourite'] = $result;
             $this->api_return([
              'message' => lang('Operation completed successfully'),
              'errNum' => 405,
              'status' => true,
              'total' => $total,
              "result" => $data
            ],200);
                
                
                }
                else {
$result['name']="";
$result['id']="";
$result['about']="";
$result['category']=""; 
$result['image']="";


             $data['all_trainers'] =[];
             $total = count($total);
             $this->api_return([
              'message' => lang('no_data'),
              'errNum' => 401,
              'status' => false,
              'total' => $total,
              "result" => $data
              ],200);
                }
}
else {
$this->api_return([ 'message' => lang('Customer ID notcorrect'), 'errNum' => 402, 'status' => false, ],200);    
}

}
}




public function get_trainer_details(){
  header("Access-Control-Allow-Origin: *");
  // API Configuration #endregion
  //this configration for any api
  $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
    // ,'requireAuthorization' => true //this used if reqired token valye
]);
  $lang ="ar";
  $this->checkLang($lang);
$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
$this->form_validation->set_rules('id_trainer', lang('Trainer ID'), 'trim|required|numeric'); 
$this->form_validation->set_rules('key_depart', lang('Key Depart'), 'trim|required|in_list[2]'); 

  if($this->form_validation->run() === FALSE){
      
      
if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}

      if(form_error('id_trainer')){
if($this->input->post('id_trainer')==="" || !$this->input->post('id_trainer')){
$data[] = array('message'=>strip_tags(lang('Trainer ID')),"errNum" => 2);
}else{$data[] = array('message'=>strip_tags(lang('Trainer ID')),"errNum" =>3);}
}

if(form_error('key_depart')){
if($this->input->post('key_depart')==="" || !$this->input->post('key_depart')){
$data[] = array('message'=>strip_tags(lang('Key Depart')),"errNum" => 4);
}else{$data[] = array('message'=>strip_tags(lang('Key Depart')),"errNum" => 5);}
}


$this->api_return([
  'message' => $data[0]['message'],
  'errNum' => $data[0]['errNum'],
  'status' => false
],200);
  }
else{
    
$user_mode_key=$this->input->post('user_mode_key');
if($user_mode_key!=""&&$user_mode_key==0){
 $customers_id=-1;   
}
else {
$customers_id=get_customer_id($this->input->post('token_id'));    
}
if($customers_id!=""){

$key_depart=$this->input->post('key_depart');
$id_trainer=$this->input->post('id_trainer');
 $sql_product=$this->db->order_by('id','DESC')->get_where('customers',array('view'=>'1','id'=>$id_trainer,'status'=>$key_depart))->result();
         if (count($sql_product)>0) {
            foreach ($sql_product as $page) {
$result['name']=$page->user_name;
$cat_id=$page->cat_id;
$name_category=get_table_filed('category',array('id'=>$cat_id),"name");
$result['id']=(int)$page->id;
$result['about']=$page->about;
if($page->about!=""){
$result['about']=$page->about;    
}
else {
   $result['about']=""; 
}
if($name_category!=""){
$result['category']=$name_category;
}
else {
$result['category']=""; 
}
if($page->img!=""){
$result['image']=base_url()."uploads/customers/".$page->img;
}
else {
$result['image']=base_url()."uploads/customers/no_img.png";
}
$data['Trainer Details'][]=$result;
 }
 
 
$certification_content=$this->db->order_by('id','DESC')->get_where('trainer_certifactes',array('user_id'=>$id_trainer))->result();
if(count($certification_content)>0){
foreach ($certification_content as $certification_content){
    if($certification_content->certification!=""){
$data['Trainer certification'][]=$certification_content->certification;	
}
else {$data['Trainer certification']=[];}
}
}
else {
$data['Trainer certification']=[];
}

 
 $experiences_content=$this->db->order_by('id','DESC')->get_where('trainer_experiences',array('user_id'=>$id_trainer))->result();
if(count($experiences_content)>0){
  foreach ($experiences_content as $bag_content){
       if($bag_content->experiences!=""){
	$result_experiences['trainer_experiences']=$bag_content->experiences;
       }
       else {
       $result_experiences['trainer_experiences']="";    
       }
	 if($bag_content->start_date!=""){
     $result_experiences['start_year']=$bag_content->start_date;
	 }
	 else {  $result_experiences['start_year']="";}
	 
      if($bag_content->start_moth!=""){
     $result_experiences['start_month']=$bag_content->start_moth;
      }
      else {$result_experiences['start_month']="";}
     if($bag_content->company_name!=""){
     $result_experiences['company_name']=$bag_content->company_name;
     }
     else {
      $result_experiences['company_name']="";    
     }
     
     
      if($bag_content->end_date!=""){
      $result_experiences['end_key']=1;
       $result_experiences['end_year']=$bag_content->end_date;
       if($bag_content->end_month!=""){
       $result_experiences['end_month']=$bag_content->end_month;
       }
       else {$result_experiences['end_month']="";}
      }
      else {
     $result_experiences['end_key']=0;
     $result_experiences['end_month']="";
      $result_experiences['end_year']="";
      
      }
      $data['Trainer experiences'][]=$result_experiences;
  }
}
else {
$data['Trainer experiences']=[];
}

 
 $this->api_return([
  'message' => lang('Operation completed successfully'),
  'errNum' => 405,
  'status' => true,
  "result" => $data
],200);

         }
                else {


$data['Trainer certification']="";	
$data['Trainer experiences']=[];

$data['Trainer Details'] =[];
             $this->api_return([
              'message' => lang('no_data'),
              'errNum' => 401,
              'status' => false,
              "result" => $data
              ],200);
                }
    
}

else {$this->api_return([ 'message' => lang('Customer ID notcorrect'), 'errNum' => 402, 'status' => false, ],200);}

}
}




public function set_register_trainer(){
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
       $lang ="ar";
      $this->checkLang($lang);
        $this->load->library('Authorization_Token');
		$this->load->library('form_validation');
        $this->form_validation->set_rules('name',lang('Username'), 'trim|required');
        $this->form_validation->set_rules('user_type', lang('user_type'), 'trim|required');
        $this->form_validation->set_rules('phone', lang('Phone Number'), 'trim|required|numeric');
		$this->form_validation->set_rules('email', lang('Email'), 'trim|required|valid_email');
        $this->form_validation->set_rules('password', lang('Password'), 'trim|required|min_length[8]');
        //$this->form_validation->set_rules('confirm_password', lang('Confirm Password'), 'trim|required|matches[password]');
      $this->form_validation->set_rules('device_token_id', lang('Device Reg ID'), 'trim|required');
        $this->form_validation->set_rules('age', lang('age'), 'trim|required|numeric|min_length[2]');
        $this->form_validation->set_rules('policy_id', lang('policy_id'), 'trim|required');
        $this->form_validation->set_rules('city', lang('city'), 'trim|required|numeric');
        $this->form_validation->set_rules('id_cat', lang('id_cat'), 'trim|required|numeric');
        if($this->form_validation->run() === FALSE){


			$email_find = get_table_filed('customers',array('email'=>$this->input->post('email'),'status'=>$this->input->post('user_type')),"email");
            $phone_find= get_table_filed('customers',array('phone'=>$this->input->post('phone'),'status'=>$this->input->post('user_type')),"phone");
            
             if(form_error('name')){
                if($this->input->post('name')==="" || !$this->input->post('name')){
                $data[] = array('message'=> strip_tags(lang('Username')),"errNum" => 0);
                }
            }
  //**************** */
    if(form_error('email')){
	if($this->input->post('email')==="" || !$this->input->post('email')){
	$data[] = array('message'=> strip_tags(lang('Email')),"errNum" => 1);
				}elseif($email_find!=""){
					$data[] = array('message'=> strip_tags(lang('Email')),"errNum" =>3);
				}else{
					$data[] = array('message'=> strip_tags(lang('error_email')),"errNum" => 4);
				}
            }
              //**************** */
            if(form_error('phone')){
				if($this->input->post('phone')==="" || !$this->input->post('phone')){
					$data[] = array('message'=> strip_tags(lang('Phone Number')),"errNum" => 5);
				}elseif($phone_find!=""){
					$data[] = array('message'=> strip_tags(lang('Phone Number')),"errNum" => 6);
				}else{
					$data[] = array('message'=> strip_tags(lang('error_phone')),"errNum" => 7);
				}
            }
              //**************** */
              if(form_error('device_token_id')){
                if($this->input->post('device_token_id')==="" || !$this->input->post('device_token_id')){
                $data[] = array('message'=> strip_tags(lang('device_token_id')),"errNum" =>8);
                }
            }

            if(form_error('password')){
				if($this->input->post('password')==="" || !$this->input->post('password')){
					$data[] = array('message'=> strip_tags(lang('Password')),"errNum" =>9);
				}else{
					$data[] = array('message'=> strip_tags(lang('Password Leng')),"errNum" =>10);
				}
            }

            if(form_error('user_type')){
                if($this->input->post('user_type')==="" || !$this->input->post('user_type')){
                    $data[] = array('message'=> strip_tags(lang('user_type')),"errNum" =>11);
          }  
        }

        
if(form_error('age')){
    if($this->input->post('age')==="" || !$this->input->post('age')){
    $data[] = array('message'=> strip_tags(lang('age')),"errNum" => 12);
    } 
    else {
      $data[] = array('message'=> strip_tags(lang('age_error')),"errNum" => 16);   
    }
    }
    if(form_error('policy_id')){
    if($this->input->post('policy_id')!=1 ||$this->input->post('policy_id')==="" || !$this->input->post('policy_id')){
    $data[] = array('message'=> strip_tags(lang('policy_id')),"errNum" =>13);
    } 
    }
    if(form_error('city')){
    if($this->input->post('city')==="" || !$this->input->post('city')){
    $data[] = array('message'=> strip_tags(lang('city')),"errNum" =>14);
    } 
    }

       if(form_error('id_cat')){
                if($this->input->post('id_cat')==="" || !$this->input->post('id_cat')){
                $data[] = array('message'=> strip_tags(lang('Cat ID')),"errNum" => 15);
                }
        else{
					$data[] = array('message'=> strip_tags(lang('Cat ID_error')),"errNum" => 16);
				}
            }
    
    $this->api_return([
        'message' => $data[0]['message'],
        'errNum' => $data[0]['errNum'],
        'status' => false
    ],200);



        }

        else{
			
$email_find = get_table_filed('customers',array('email'=>$this->input->post('email'),'status'=>$this->input->post('user_type')),"email");
$phone_find= get_table_filed('customers',array('phone'=>$this->input->post('phone'),'status'=>$this->input->post('user_type')),"phone");
            
if($phone_find!=""){
$data[] = array('message'=> strip_tags(lang("phone_anthor")),"errNum" => 2);
}
if($email_find!=""){
$data[] = array('message'=> strip_tags(lang("email_anthor")),"errNum" => 2);
}
if($phone_find!=""||$email_find!=""){
$this->api_return([
    'message' => $data[0]['message'],
    'errNum' => $data[0]['errNum'],
    'status' => false
],200);

}
else if($phone_find==""&&$email_find==""){
date_default_timezone_set('Asia/Riyadh');
            $store = [
                      'user_name'          	=> $this->input->post('name'),
                      'password'            => md5($this->input->post('password')),
                      'email'          		=> $this->input->post('email'),
                      'phone'               => $this->input->post('phone'),
                      'age'             	=> $this->input->post('age'),
                      'status'             	=> $this->input->post('user_type'),
                      'view'                =>'0',
                      'city_id'    	=> $this->input->post('city'),
                      'social_id'    	=> $this->input->post('device_token_id'),
                      'creation_date'       => date('Y-m-d H:i:s'),
                      'invitation_code'       => gen_random_string(),
                      'cat_id'       => $this->input->post('id_cat')
                    ];
                    $insert = $this->db->insert('customers',$store);
                   $id= $this->db->insert_id();
                   

                    
            //////////////////////////////////////////////Send SMS Code
             //Check Insert User Data
            if($insert){


$customer = get_this('customers',['id'=>$id]);
  if ($customer) {
$id = $customer['id'];
if ($this->input->post('img')) {
  $image_name = gen_random_string();
  $filename = $image_name . '.' . 'png';
  $image = base64_decode($this->input->post("img"));
  $path = "uploads/customers/".$filename;
  file_put_contents($path, $image);
$store['img'] = $filename;
}
if ($this->input->post('city')) {
$store['city_id'] = $this->input->post('city');
}
$store['user_name'] = $this->input->post('name');
$store['email'] = $this->input->post('email');
$store['phone'] = $this->input->post('phone');
$store['age'] = $this->input->post('age');

$this->Main_model->update('customers',['id'=>$id],$store);
$customer_info =get_this('customers',['id'=>$id]);
$payload = ['id' => $customer_info['id'],
'phone' => $customer_info['phone'],
'email' => $customer_info['email']
];
$token = $this->authorization_token->generateToken($payload);
$token_data['token'] = $token;
$token_data['id_customer'] = $id;
//$this->Main_model->update('customers',['id'=>$id],$token_data);	
$this->db->insert("customers_token",$token_data);
$customer_infop['id'] =(int)$customer_info['id'];
$customer_infop['name'] = $customer_info['user_name'];
$customer_infop['phone'] =$customer_info['phone'];
$customer_infop['email'] =$customer_info['email'];
$customer_infop['age'] = $customer_info['age'];
$customer_infop['user_key'] = (int)$customer_info['status'];
//$customer_infop['invitation_code'] = $customer_info['invitation_code'];
if($customer_info['img']!=""){
$customer_infop['img'] =  base_url()."uploads/customers/".$customer_info['img'];
}
else {
$customer_infop['img'] = base_url()."uploads/customers/no_img.png";   
}
$customer_infop['city'] =get_table_filed('city',array('id'=>$customer_info['city_id']),"name");
$customer_infop['token_id'] =$token;

 $data['customer_info'] = $customer_infop;
						  
                              $this->api_return([
								'message' => lang('register message'),
								'errNum' => 405,
								'status' => true,
								"result" => $data
								],200);
							 
                     }
else {
$data['pages'] = [];
$this->api_return([
'message' => lang('no_data'),
'keynum' =>401,
'status' => false,
"result" => $data
],200);   
}
             }else{
                  $this->api_return([
                    'message' => lang('An error in the register'),
                    'errNum' => 4,
                    'status' => false
                ],200);
             }
				}
				
                ///////////////////////////////////////////////////////////////////////////////////////////////////////////
            }


        }





	public function get_categories_trainer(){
        header("Access-Control-Allow-Origin: *");
        // API Configuration #endregion
        //this configration for any api
        $this->_apiConfig([
            'methods' => ['POST'], //This Function by default request method GET
            'key' => ['POST', $this->key()]
         // ,'requireAuthorization' => true //this used if reqired token valye
        ]);
        $lang ="ar";
    $this->checkLang($lang); 
    
    
 $lang = "ar";
$this->checkLang($lang);
$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
if($this->form_validation->run() === FALSE){
if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
			  }	
		  }

$this->api_return([
'message' => $data[0]['message'],
'errNum' => $data[0]['errNum'],
'status' => false
],200);
        }
        else{
          $customerid = get_customer_id($this->input->post('token_id'));
 $customeremail = get_table_filed('customers',array('id'=>$customerid),"email");
    if($customeremail!="") {

$intersted_courses=$this->db->order_by('id','desc')->get_where('category',array('view'=>'1'))->result();
		if (count($intersted_courses)>0) {
        foreach ($intersted_courses as $page) {
 $department_id=$page->id;
  $cat_id = get_table_filed('customers',array('id'=>$customerid),"cat_id");
 if($department_id==$cat_id){
   $result['interst_key']=1;  
 }
 else {
     $result['interst_key']=0;  
 }
       $result['name']=$page->name;
         $result['depart_id']=$page->id;
         $data['categories'][]= $result;
        }
		            if ($data) {
              $this->api_return([
				 'message' => lang('Operation completed successfully'),
						'keynum' => 405, //active4web copyright 2019
						'status' => true,
						"result" => $data
					],200);
            }
      }
      else{
           $result['name']="";
         $result['depart_id']="";
         $data['categories'][]= $result;
        $this->api_return([
		'message' => lang('no_data'),
				'keynum' =>401,
				'status' => false,
				"result" => $data
				],200);
       }
        }
         else {
             
$this->api_return([
'message' => lang('Customer ID notcorrect'),
'errNum' => 402,
'status' => false
],200);  
        }
        
        
        }
       
       
    }
	
	
	
	
	
public function change_trainer_dep(){
header("Access-Control-Allow-Origin: *");
$this->_apiConfig([
'methods' => ['POST'],
'key' => ['POST', $this->key()],
//'requireAuthorization' => true
]);
$lang ="ar";
$this->checkLang($lang);
$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
$this->form_validation->set_rules('cat_id', lang('cat_id'), 'trim|required|numeric');
if($this->form_validation->run() === FALSE){
if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}

if(form_error('cat_id')){
            if($this->input->post('cat_id')==="" || !$this->input->post('cat_id')){
            $data[] = array('message'=> strip_tags(lang('Cat ID')),"errNum" => 0);
            }
    else{
				$data[] = array('message'=> strip_tags(lang('Cat ID_error')),"errNum" => 1);
			}
        }

$this->api_return([
'message' => $data[0]['message'],
'errNum' => $data[0]['errNum'],
'status' => false
],200);

    
}

        else{
			 
			 $customeid =get_customer_id($this->input->post('token_id'));
			 $customeremail = get_table_filed('customers',array('id'=>$customeid),"email");
    if($customeremail!=""&&$customeid!="") {
        
       $data_interst['cat_id']=$this->input->post('cat_id');
       $this->db->update('customers',$data_interst,array("id"=>$customeid));
   

$intersted_courses=$this->db->order_by('id','desc')->get_where('category',array('view'=>'1'))->result();
		if (count($intersted_courses)>0) {
        foreach ($intersted_courses as $page) {
 $department_id=$page->id;
  $cat_id = get_table_filed('customers',array('device_reg_id'=>$this->input->post('token_id')),"cat_id");
 if($department_id==$cat_id){
   $result['interst_key']=1;  
 }
 else {
     $result['interst_key']=0;  
 }
       $result['name']=$page->name;
         $result['depart_id']=$page->id;
         $data['categories'][]= $result;
        }
		            if ($data) {
              $this->api_return([
				 'message' => lang('Successfully updated'),
						'keynum' => 405, //active4web copyright 2019
						'status' => true,
						"result" => $data
					],200);
            }
      }
      else{
        $data['pages'] = [];
        $this->api_return([
		'message' => lang('no_data'),
				'keynum' =>401,
				'status' => false,
				"result" => $data
				],200);
       }
        }
         else {
             
$this->api_return([
'message' => lang('Customer ID notcorrect'),
'errNum' => 402,
'status' => false
],200);  
        }
        
        
        }
 }
 
 
 
 public function preperation_trainer_details(){
  header("Access-Control-Allow-Origin: *");
  // API Configuration #endregion
  //this configration for any api
  $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
    // ,'requireAuthorization' => true //this used if reqired token valye
]);
  $lang ="ar";
  $this->checkLang($lang);
$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
 if($this->form_validation->run() === FALSE){
            if(form_error('token_id')) {
                if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
                $data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
                }
            }

$this->api_return([
        'message' => $data[0]['message'],
        'errNum' => $data[0]['errNum'],
        'status' => false
    ],200);

  }
else{
$id_trainer=get_customer_id($this->input->post('token_id'));
 $sql_product=$this->db->order_by('id','DESC')->get_where('customers',array('view'=>'1','id'=>$id_trainer))->result();
         if (count($sql_product)>0) {
            foreach ($sql_product as $page) {
$result['name']=$page->user_name;
$result['email']=$page->email;
$result['about']=$page->about;
if($page->about!=""){
$result['about']=$page->about;
}
else {
$result['about']="";
}
if($page->img!=""){
$result['image']=base_url()."uploads/customers/".$page->img;
}
else {
$result['image']=base_url()."uploads/customers/no_img.png";
}
$data['Trainer Details'][]=$result;
 }
 
 
$certification_content=$this->db->order_by('id','DESC')->get_where('trainer_certifactes',array('user_id'=>$id_trainer))->result();
if(count($certification_content)>0){
foreach ($certification_content as $certification_content){
$data['Trainer certification'][]=$certification_content->certification;	
}
}
else {
 $data['Trainer certification']=[];
}

 
 $experiences_content=$this->db->order_by('id','DESC')->get_where('trainer_experiences',array('user_id'=>$id_trainer))->result();
if(count($experiences_content)>0){
  foreach ($experiences_content as $bag_content){
	$result_experiences['trainer_experiences']=$bag_content->experiences;	
	$result_experiences['company_name']=$bag_content->company_name;	
      $result_experiences['start_year']=$bag_content->start_date;
     $result_experiences['start_month']=$bag_content->start_moth;
      if($bag_content->end_date!=""&&$bag_content->end_date!=0){
      $result_experiences['end_key']=1;
       $result_experiences['end_year']=$bag_content->end_date;
        $result_experiences['end_month']=$bag_content->end_month;
      }
      else {
     $result_experiences['end_key']=0;
      $result_experiences['end_year']="";
       $result_experiences['end_month']="";
      }
      $data['Trainer experiences'][]=$result_experiences;
  }
}
else {
$data['Trainer experiences']=[];
}

 
 $this->api_return([
  'message' => lang('Operation completed successfully'),
  'errNum' => 405,
  'status' => true,
  "result" => $data
],200);

         }
                else {

$data['Trainer certification']=[];
$data['Trainer experiences']=[];
$data['Trainer Details']=[];
             $this->api_return([
              'message' => lang('no_data'),
              'errNum' => 401,
              'status' => false,
              "result" => $data
              ],200);
                }
}
}



public function update_trainer_details(){
  header("Access-Control-Allow-Origin: *");
  $this->_apiConfig([
      'methods' => ['POST'],
     'key' => ['POST', $this->key()]
]);
  $lang ="ar";
  $this->checkLang($lang);
$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
if($this->form_validation->run() === FALSE){
            if(form_error('token_id')) {
                if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
                $data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
                }
            }
$this->api_return([
        'message' => $data[0]['message'],
        'errNum' => $data[0]['errNum'],
        'status' => false
    ],200);

  }
else{
$id_trainer=get_customer_id($this->input->post('token_id'));
if($this->input->post('trainer_about')){
    $data_about['about']=$this->input->post('trainer_about');
    $this->db->update("customers",$data_about,array("id"=>$id_trainer));
}


if ($this->input->post('img')) {
  $image_name = gen_random_string();
  $filename = $image_name . '.' . 'png';
  $image = base64_decode($this->input->post("img"));
  $path = "uploads/customers/".$filename;
  file_put_contents($path, $image);
$store['img'] = $filename;
 $this->db->update("customers",$store,array("id"=>$id_trainer));
}

if($this->input->post('certificates_list')){
$this->db->delete('trainer_certifactes',array('user_id'=>$id_trainer));
  // $arry_interest= explode(',', $this->input->post('certificates_list'));
   for($i=0; $i<count($this->input->post('certificates_list')); $i++){
       if($this->input->post('certificates_list')[$i]!=""){
       $data_interst['user_id']=$id_trainer;
       $data_interst['creation_date']=date("Y-m-d");
       $data_interst['certification']=$this->input->post('certificates_list')[$i];
       $this->db->insert('trainer_certifactes',$data_interst);
       }
   }
}

if($this->input->post('experiences_list')){
$this->db->delete('trainer_experiences',array('user_id'=>$id_trainer));
   for($i=0; $i<count($this->input->post('experiences_list')); $i++){
       if($this->input->post('experiences_list')[$i]!=""){
       $data_interst_exp['user_id']=$id_trainer;
       $data_interst_exp['creation_date']=date("Y-m-d");
       $data_interst_exp['experiences']=$this->input->post('experiences_list')[$i]['name'];
       $data_interst_exp['company_name']=$this->input->post('experiences_list')[$i]['company_name'];
       $data_interst_exp['start_moth']=$this->input->post('experiences_list')[$i]['start_month'];
       $data_interst_exp['end_month']=$this->input->post('experiences_list')[$i]['end_month'];
       $data_interst_exp['start_date']=$this->input->post('experiences_list')[$i]['start_year'];
       $data_interst_exp['end_date']=$this->input->post('experiences_list')[$i]['end_year'];
       $data_interst_exp['end_key']=1;
       $this->db->insert('trainer_experiences',$data_interst_exp);
       
       }
   }
}

 $sql_product=$this->db->order_by('id','DESC')->get_where('customers',array('view'=>'1','id'=>$id_trainer))->result();
         if (count($sql_product)>0) {
            foreach ($sql_product as $page) {
$result['id']=(int)$page->id;               
$result['name']=$page->user_name;
$result['about']=$page->about;
if($page->about!=""){
$result['about']=$page->about;
}
else {
$result['about']="";
}
if($page->img!=""){
$result['image']=base_url()."uploads/customers/".$page->img;
}
else {
$result['image']=base_url()."uploads/customers/no_img.png";
}
$data['Trainer Details'][]=$result;
 }
 
 
$certification_content=$this->db->order_by('id','DESC')->get_where('trainer_certifactes',array('user_id'=>$id_trainer))->result();
if(count($certification_content)>0){
foreach ($certification_content as $certification_content){
$result_certification['trainer_certification']=$certification_content->certification;	
$data['Trainer certification'][]=$certification_content->certification;;
}
}
else {
    $data['Trainer certification']=[];
}

 
 $experiences_content=$this->db->order_by('id','DESC')->get_where('trainer_experiences',array('user_id'=>$id_trainer))->result();
if(count($experiences_content)>0){
    foreach ($experiences_content as $bag_content){
       if($bag_content->experiences!=""){
	$result_experiences['trainer_experiences']=$bag_content->experiences;
       }
       else {
       $result_experiences['trainer_experiences']="";    
       }
	 if($bag_content->start_date!=""){
     $result_experiences['start_year']=$bag_content->start_date;
	 }
	 else {  $result_experiences['start_year']="";}
	 
      if($bag_content->start_moth!=""){
     $result_experiences['start_month']=$bag_content->start_moth;
      }
      else {$result_experiences['start_month']="";}
     if($bag_content->company_name!=""){
     $result_experiences['company_name']=$bag_content->company_name;
     }
     else {
      $result_experiences['company_name']="";    
     }
     
     
      if($bag_content->end_date!=""&&$bag_content->end_date!="0"){
      $result_experiences['end_key']=1;
       $result_experiences['end_year']=$bag_content->end_date;
       if($bag_content->end_month!=""){
       $result_experiences['end_month']=$bag_content->end_month;
       }
       else {$result_experiences['end_month']="";}
      }
      else {
     $result_experiences['end_key']=0;
     $result_experiences['end_month']="";
      $result_experiences['end_year']="";
      
      }
     $data['Trainer experiences'][]=$result_experiences; 
  }
  
  
}
else {
$data['Trainer experiences']=[];
}

 
 $this->api_return([
  'message' => lang('Operation completed successfully'),
  'errNum' => 405,
  'status' => true,
  "result" => $data
],200);

         }
                else {



$data['Trainer Details'] =[];
$data['Trainer experiences']=[];
$data['Trainer certification']=[];
             $this->api_return([
              'message' => lang('no_data'),
              'errNum' => 401,
              'status' => false,
              "result" => $data
              ],200);
                }
}
}







public function code_discount(){
  header("Access-Control-Allow-Origin: *");
  // API Configuration #endregion
  //this configration for any api
  $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
    // ,'requireAuthorization' => true //this used if reqired token valye
]);
  $lang ="ar";
  $this->checkLang($lang);
$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
$this->form_validation->set_rules('code_discount', lang('code_discount'), 'trim|required');

  if($this->form_validation->run() === FALSE){
if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}

if(form_error('code_discount')){
if($this->input->post('code_discount')==="" || !$this->input->post('code_discount')){
$data[] = array('message'=> strip_tags(lang('code_discount')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('code_discount')),"errNum" => 1);
}	
}



$this->api_return([
  'message' => $data[0]['message'],
  'errNum' => $data[0]['errNum'],
  'status' => false
],200);
  }
else{

$id_trainer=get_table_filed('customers',array('device_reg_id'=>$this->input->post('token_id')),"code_discount");
 $sql_product=$this->db->order_by('id','DESC')->get_where('customers',array('view'=>'1','id'=>$id_trainer))->result();
         if (count($sql_product)>0) {
            foreach ($sql_product as $page) {
$result['name']=$page->user_name;
$cat_id=$page->cat_id;
$name_category=get_table_filed('category',array('id'=>$cat_id),"name");
$result['id']=(int)$page->id;
$result['about']=$page->about;
if($name_category!=""){
$result['category']=$name_category;
}
else {
$result['category']=""; 
}
if($page->img!=""){
$result['image']=base_url()."uploads/customers/".$page->img;
}
else {
$result['image']=base_url()."uploads/customers/no_img.png";
}
$data['Trainer Details'][]=$result;
 }
 
 
$certification_content=$this->db->order_by('id','DESC')->get_where('trainer_certifactes',array('user_id'=>$id_trainer))->result();
if(count($certification_content)>0){
foreach ($certification_content as $certification_content){
$result_certification['trainer_certification']=$certification_content->certification;	

$data_certification['Trainer certification'][]=$result_certification;
}
}
else {
    $result_certification['trainer_certification']="";
    $data_certification['Trainer certification'][]=$result_certification;
}

 
 $experiences_content=$this->db->order_by('id','DESC')->get_where('trainer_experiences',array('user_id'=>$id_trainer))->result();
if(count($experiences_content)>0){
  foreach ($experiences_content as $bag_content){
	$result_experiences['trainer_experiences']=$bag_content->experiences;
	      $result_experiences['company_name']=$bag_content->company_name;
     $result_experiences['end_month']=$bag_content->start_moth;
           $result_experiences['start_year']=$bag_content->start_date;

    $result_experiences['id']=$bag_content->id;
      if($bag_content->end_date!=""){
      $result_experiences['end_key']=1;
      $result_experiences['end_month']=$bag_content->end_month;
       $result_experiences['end_year']=$bag_content->end_date;
        $result_experiences['id']=$bag_content->id;
      }
      else {
     $result_experiences['end_key']=0;
     $result_experiences['end_month']="";
      $result_experiences['end_year']="";
      }
      $data_experiences['Trainer experiences'][]=$result_experiences;
  }
}
else {
$data_experiences['Trainer experiences']=[];
}

 
 $this->api_return([
  'message' => lang('Operation completed successfully'),
  'errNum' => 405,
  'status' => true,
  "result" => $data,
 "data_experiences" =>$data_experiences,
 "data_certification" =>$data_certification
],200);

         }
                else {
$result_experiences['trainer_experiences']="";	
$result_experiences['trainer_experiences']="";	
$result_experiences['trainer_experiences']="";	
$result_certification['trainer_certification']="";
$result_experiences['end_key']=0;
$data_certification['Trainer certification'][]=$result_certification;
$data_experiences['Trainer experiences'][]=$result_experiences;
$result['name']="";
$result['id']="";
$result['about']="";
$result['category']=""; 
$result['image']="";
$data['Trainer Details'] =$result;
             $this->api_return([
              'message' => lang('no_data'),
              'errNum' => 401,
              'status' => false,
              "result" => $data,
              "data_experiences" =>$data_experiences,
              "data_certification" =>$data_certification
              ],200);
                }
}
}


public function trainer_home(){
  header("Access-Control-Allow-Origin: *");
  // API Configuration #endregion
  //this configration for any api
  $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
    // ,'requireAuthorization' => true //this used if reqired token valye
]);
  $lang ="ar";
  $this->checkLang($lang);
$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');


  if($this->form_validation->run() === FALSE){
if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}

$this->api_return([
  'message' => $data[0]['message'],
  'errNum' => $data[0]['errNum'],
  'status' => false
],200);
  }
else{

$id_trainer=get_customer_id($this->input->post('token_id'));
 $sql_product=$this->db->order_by('id','DESC')->get_where('customers',array('view'=>'1','id'=>$id_trainer))->result();
         if (count($sql_product)>0) {
            foreach ($sql_product as $page) {
$result['name']=$page->user_name;
$result['email']=$page->email;
$cat_id=$page->cat_id;
$name_category=get_table_filed('category',array('id'=>$cat_id),"name");
$result['id']=(int)$page->id;
$result['about']=$page->about;
if($page->about!=""){
  $result['about']=$page->about;  
}
else {
$result['about']=""; 
}

if($name_category!=""){
$result['category']=$name_category;
}
else {
$result['category']=""; 
}
if($page->img!=""){
$result['image']=base_url()."uploads/customers/".$page->img;
}
else {
$result['image']=base_url()."uploads/customers/no_img.png";
}
$data['Trainer Details'][]=$result;
 }
 
 
$certification_content=$this->db->order_by('id','DESC')->get_where('trainer_certifactes',array('user_id'=>$id_trainer))->result();
if(count($certification_content)>0){
foreach ($certification_content as $certification_content){
    if($certification_content->certification!=""){
$data['Trainer certification'][]=$certification_content->certification;;
}
else {$data['Trainer certification']=[];}
}
}
else {
    $data['Trainer certification']=[];
}

 
 $experiences_content=$this->db->order_by('id','DESC')->get_where('trainer_experiences',array('user_id'=>$id_trainer))->result();
if(count($experiences_content)>0){
    foreach ($experiences_content as $bag_content){
       if($bag_content->experiences!=""){
	$result_experiences['trainer_experiences']=$bag_content->experiences;
       }
       else {
       $result_experiences['trainer_experiences']="";    
       }
	 if($bag_content->start_date!=""){
     $result_experiences['start_year']=$bag_content->start_date;
	 }
	 else {  $result_experiences['start_year']="";}
	 
      if($bag_content->start_moth!=""){
     $result_experiences['start_month']=$bag_content->start_moth;
      }
      else {$result_experiences['start_month']="";}
     if($bag_content->company_name!=""){
     $result_experiences['company_name']=$bag_content->company_name;
     }
     else {
      $result_experiences['company_name']="";    
     }
     
     
      if($bag_content->end_date!=""){
      $result_experiences['end_key']=1;
       $result_experiences['end_year']=$bag_content->end_date;
       if($bag_content->end_month!=""){
       $result_experiences['end_month']=$bag_content->end_month;
       }
       else {$result_experiences['end_month']="";}
      }
      else {
     $result_experiences['end_key']=0;
     $result_experiences['end_month']="";
      $result_experiences['end_year']="";
      
      }
     $data['Trainer experiences'][]=$result_experiences; 
  }
}
else {
$data['Trainer experiences']=[];
}

 
 $this->api_return([
  'message' => lang('Operation completed successfully'),
  'errNum' => 405,
  'status' => true,
  "result" => $data
],200);

         }
else {


$data['Trainer certification']=[];
$data['Trainer experiences']=[];
$data['Trainer Details']=[];
             $this->api_return([
              'message' => lang('no_data'),
              'errNum' => 401,
              'status' => false,
              "result" => $data
              ],200);
                }
}
}



/*****************END 23-4-2019*****************************/
/*****************Start 24-4-2019*****************************/



public function preparation_register_bager(){
    
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'], //This Function by default request method GET
            'key' => ['POST', $this->key()],
            //'password'=>['POST', $this->password()]
        ]);
       $lang = "ar";
    $this->checkLang($lang);
$this->load->library('form_validation');
        $this->form_validation->set_rules('key_user',lang('key_user'), 'trim|required|numeric|min_length[1]|max_length[1]');
  if($this->form_validation->run() === FALSE){

    if(form_error('key_user')){
	if($this->input->post('key_user')==="" || !$this->input->post('key_user')){
	$data[] = array('message'=> strip_tags(lang('user_type')),"errNum" => 0);
				}
else{
$data[] = array('message'=> strip_tags(lang('user_type')),"errNum" => 1);
				}
            }
            
    $this->api_return([
        'message' => $data[0]['message'],
        'errNum' => $data[0]['errNum'],
        'status' => false
    ],200);
    
  }
else {	
    $home_city=$this->db->order_by('id','desc')->get_where('city',array('view'=>'1','country_id'=>'1'))->result();
		if (count($home_city)>0) {
            	
        foreach ($home_city as $page) {
            $result['city_name']=$page->name;
             $result['city_id']=(int)$page->id;
        $data['cities'][]= $result;
        }
        
        
		}
	    else{
	         $result['city_name']="";
             $result['city_id']="";
        $data['cities'][]= $result;
        	$data['cities'][]=$data;
       }
    

       
        $terms=$this->db->get_where('pages',array('key_txt'=>'terms','active'=>'1','flag'=>$this->input->post('key_user')))->result();
		if (count($terms)>0) {
            	
        foreach ($terms as $page_terms) {
            $result_terms['title']=$page_terms->title;
            $result_terms['Terms']=strip_tags(trim(preg_replace('/\s\s+/', ' ',$page_terms->content )));;
        $data['Terms'][]= $result_terms;
        }
		    
		}
      
      else{
          $result_terms['title']="";
            $result_terms['Terms']="";
$data['Terms'][]=$result_terms;
       }
       
if($data){
$this->api_return([
'keynum' => 405, //active4web copyright 2019
'status' => true,
"result" => $data
],200); 
}

else {
         $data['pages'] = [];
        $this->api_return([
		'message' => lang('no_data'),
				'keynum' =>401,
				'status' => false,
				"result" => $data
				],200);   
}
       
}

       
    }
    
    
    
    
    
    public function bager_register(){
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
       $lang ="ar";
      $this->checkLang($lang);
        $this->load->library('Authorization_Token');
		$this->load->library('form_validation');
        $this->form_validation->set_rules('name',lang('Username'), 'trim|required');
        $this->form_validation->set_rules('user_type', lang('user_type'), 'trim|required');
        $this->form_validation->set_rules('phone', lang('Phone Number'), 'trim|required|numeric');
		$this->form_validation->set_rules('email', lang('Email'), 'trim|required|valid_email');
        $this->form_validation->set_rules('password', lang('Password'), 'trim|required|min_length[8]');
      $this->form_validation->set_rules('device_token_id', lang('Device Reg ID'), 'trim|required');
        $this->form_validation->set_rules('age', lang('age'), 'trim|required|numeric|min_length[2]');
        $this->form_validation->set_rules('policy_id', lang('policy_id'), 'trim|required');
        $this->form_validation->set_rules('city', lang('city'), 'trim|required|numeric');

        if($this->form_validation->run() === FALSE){
			$email_find = get_table_filed('customers',array('email'=>$this->input->post('email'),'status'=>$this->input->post('user_type')),"email");
            $phone_find= get_table_filed('customers',array('phone'=>$this->input->post('phone'),'status'=>$this->input->post('user_type')),"phone");
            
            //**************** */
            if(form_error('name')){
                if($this->input->post('name')==="" || !$this->input->post('name')){
                $data[] = array('message'=> strip_tags(lang('Username')),"errNum" => 0);
                }
            }
  //**************** */
    if(form_error('email')){
	if($this->input->post('email')==="" || !$this->input->post('email')){
	$data[] = array('message'=> strip_tags(lang('Email')),"errNum" => 1);
				}elseif($email_find!=""){
					$data[] = array('message'=> strip_tags(lang('Email')),"errNum" =>3);
				}else{
					$data[] = array('message'=> strip_tags(lang('error_email')),"errNum" => 4);
				}
            }
              //**************** */
            if(form_error('phone')){
				if($this->input->post('phone')==="" || !$this->input->post('phone')){
					$data[] = array('message'=> strip_tags(lang('Phone Number')),"errNum" => 5);
				}elseif($phone_find!=""){
					$data[] = array('message'=> strip_tags(lang('Phone Number')),"errNum" => 6);
				}else{
					$data[] = array('message'=> strip_tags(lang('error_phone')),"errNum" => 7);
				}
            }
              //**************** */
              if(form_error('device_token_id')){
                if($this->input->post('device_token_id')==="" || !$this->input->post('device_token_id')){
                $data[] = array('message'=> strip_tags(lang('device_token_id')),"errNum" =>8);
                }
            }

            if(form_error('password')){
				if($this->input->post('password')==="" || !$this->input->post('password')){
					$data[] = array('message'=> strip_tags(lang('Password')),"errNum" =>9);
				}else{
					$data[] = array('message'=> strip_tags(lang('Password Leng')),"errNum" =>10);
				}
            }

            if(form_error('user_type')){
                if($this->input->post('user_type')==="" || !$this->input->post('user_type')){
                    $data[] = array('message'=> strip_tags(lang('user_type')),"errNum" =>11);
          }  
        }

        
if(form_error('age')){
    if($this->input->post('age')==="" || !$this->input->post('age')){
    $data[] = array('message'=> strip_tags(lang('age')),"errNum" => 12);
    } 
    }
    if(form_error('policy_id')){
    if($this->input->post('policy_id')!=1 ||$this->input->post('policy_id')==="" || !$this->input->post('policy_id')){
    $data[] = array('message'=> strip_tags(lang('policy_id')),"errNum" =>13);
    } 
    }
    if(form_error('city')){
    if($this->input->post('city')==="" || !$this->input->post('city')){
    $data[] = array('message'=> strip_tags(lang('city')),"errNum" =>14);
    } 
    }
    
    $this->api_return([
        'message' => $data[0]['message'],
        'errNum' => $data[0]['errNum'],
        'status' => false
    ],200);



        }

        else{
			
$email_find = get_table_filed('customers',array('email'=>$this->input->post('email'),'status'=>$this->input->post('user_type')),"email");
$phone_find= get_table_filed('customers',array('phone'=>$this->input->post('phone'),'status'=>$this->input->post('user_type')),"phone");
            
if($phone_find!=""){
$data[] = array('message'=> strip_tags(lang("phone_anthor")),"errNum" =>6);
}
if($email_find!=""){
$data[] = array('message'=> strip_tags(lang("email_anthor")),"errNum" =>3);
}
if($phone_find!=""||$email_find!=""){
$this->api_return([
    'message' => $data[0]['message'],
    'errNum' => $data[0]['errNum'],
    'status' => false
],200);

}
else if($phone_find==""&&$email_find==""){
date_default_timezone_set('Asia/Riyadh');
            $store = [
                      'user_name'          	=> $this->input->post('name'),
                      'password'            => md5($this->input->post('password')),
                      'email'          		=> $this->input->post('email'),
                      'phone'               => $this->input->post('phone'),
                      'age'             	=> $this->input->post('age'),
                      'status'             	=> $this->input->post('user_type'),
                      'view'=>'0',
                      'city_id'    	=> $this->input->post('city'),
                      'social_id'    	=> $this->input->post('device_token_id'),
                      'creation_date'       => date('Y-m-d H:i:s'),
                      'invitation_code'       => gen_random_string()
                    ];
                    $insert = $this->db->insert('customers',$store);
                   $id= $this->db->insert_id();
                   

             //Check Insert User Data
            if($insert){


$customer = get_this('customers',['id'=>$id]);
  if ($customer) {
$id = $customer['id'];
if ($this->input->post('img')) {
  $image_name = gen_random_string();
  $filename = $image_name . '.' . 'png';
  $image = base64_decode($this->input->post("img"));
  $path = "uploads/customers/".$filename;
  file_put_contents($path, $image);
$store['img'] = $filename;
}
if ($this->input->post('city')) {
$store['city_id'] = $this->input->post('city');
}
$store['user_name'] = $this->input->post('name');
$store['email'] = $this->input->post('email');
$store['phone'] = $this->input->post('phone');
$store['age'] = $this->input->post('age');

$this->Main_model->update('customers',['id'=>$id],$store);
$customer_info =get_this('customers',['id'=>$id]);
$payload = ['id' => $customer_info['id'],
'phone' => $customer_info['phone'],
'email' => $customer_info['email']
];
$token = $this->authorization_token->generateToken($payload);
$token_data['token'] = $token;
$token_data['id_customer'] = $id;
$this->db->insert("customers_token",$token_data);

$customer_infop['id'] =(int)$customer_info['id'];
$customer_infop['name'] = $customer_info['user_name'];
$customer_infop['phone'] =$customer_info['phone'];
$customer_infop['email'] =$customer_info['email'];
$customer_infop['age'] = $customer_info['age'];
$customer_infop['user_key'] = (int)$customer_info['status'];
//$customer_infop['invitation_code'] = $customer_info['invitation_code'];
if($customer_info['img']!=""){
$customer_infop['img'] =  base_url()."uploads/customers/".$customer_info['img'];
}
else {
$customer_infop['img'] = base_url()."uploads/customers/no_img.png";   
}
$customer_infop['city'] =get_table_filed('city',array('id'=>$customer_info['city_id']),"name");
$customer_infop['token_id'] =$token;

 $data['customer_info'] = $customer_infop;
						  
                              $this->api_return([
								'message' => lang('register message'),
								'errNum' => 405,
								'status' => true,
								"result" => $data
								],200);
							 
                     }
else {
$data['pages'] = [];
$this->api_return([
'message' => lang('no_data'),
'keynum' =>401,
'status' => false,
"result" => $data
],200);   
}
             }else{
                  $this->api_return([
                    'message' => lang('An error in the register'),
                    'errNum' => 4,
                    'status' => false
                ],200);
             }
				}
				
                ///////////////////////////////////////////////////////////////////////////////////////////////////////////
            }


        }





public function bages_home(){
  header("Access-Control-Allow-Origin: *");
  $this->_apiConfig([
      'methods' => ['POST'],
      'key' => ['POST', $this->key()]
]);
  $lang ="ar";
  $this->checkLang($lang);
$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
$this->form_validation->set_rules('limit', lang('Number of visible elements'), 'trim|required|numeric');
$this->form_validation->set_rules('page_number', lang('Page Number'), 'trim|required|numeric'); 
$this->form_validation->set_rules('key_depart', lang('Key Depart'), 'trim|required|in_list[2]'); 
  if($this->form_validation->run() === FALSE){
      
if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}
      
if(form_error('key_depart')){
if($this->input->post('key_depart')==="" || !$this->input->post('key_depart')){
$data[] = array('message'=>strip_tags(lang('Key Depart')),"errNum" => 2);
}else{$data[] = array('message'=>strip_tags(lang('Key Depart')),"errNum" => 3);}
}

if(form_error('limit')){
if($this->input->post('limit')==="" || !$this->input->post('limit')){
$data[] = array('message'=>strip_tags(lang('limit')),"errNum" => 4);
}else{$data[] = array('message'=>strip_tags(lang('pager_error')),"errNum" => 5);}
}

      if(form_error('page_number')){
  if($this->input->post('page_number')==="" || !$this->input->post('page_number')){
    $data[] = array('message'=> strip_tags(lang('page_number')),"errNum" =>6);
  }else{
    $data[] = array('message'=> strip_tags(lang('limit_error')),"errNum" =>7);
  }
}
            $this->api_return([
  'message' => $data[0]['message'],
  'errNum' => $data[0]['errNum'],
  'status' => false
],200);
  }
else{

$customers_id=get_customer_id($this->input->post('token_id'));
    $limit=$this->input->post('limit');
    $page_number=$this->input->post('page_number');
         $total = $this->data->get_table_data('bag_info',array('view'=>'1','user_id'=>$customers_id,'delete_key'=>'1'));
         $offset =$limit * $page_number;
         $sql_product=$this->db->order_by('id','DESC')->get_where('bag_info',array('view'=>'1','user_id'=>$customers_id,'delete_key'=>'1'),$limit, $offset)->result();
if (count($sql_product)>0) {
foreach ($sql_product as $page) {

$result['name']=$page->bage_name;
$result['id']=(int)$page->id;
if($page->total_rate!=""){
$result['total_rate']=(int)$page->total_rate;
}
else {
$result['total_rate']=(int)0;
}
if($page->img!=""){
$result['image']=base_url()."uploads/products/".$page->img;
}
else {
$result['image']=base_url()."uploads/products/no_img.png";
}

$data['all_bage'][]= $result;
                }
                     $total = count($total);
             $this->api_return([
              'message' => lang('Operation completed successfully'),
              'errNum' => 405,
              'status' => true,
              'total' => $total,
              "result" => $data
            ],200);
                
                
                }
                else {
             $final_d=round((int)$total / (int)$limit);
             if($final_d < $page_number&&(int)$total>0){$lang=lang('no_data');}
             else {
              $lang=lang('bages_no_find')  ; 
             }
             $data['all_bage'] = [];
             $total = count($total);
             $this->api_return([
              'message' =>$lang,
              'errNum' => 405,
              'status' => true,
              'total' => $total,
              "result" => $data
              ],200);
                    
                
                }
}
}



public function add_bage(){
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
       $lang ="ar";
      $this->checkLang($lang);
        $this->load->library('Authorization_Token');
		$this->load->library('form_validation');
        $this->form_validation->set_rules('bage_name',lang('bage_name'), 'trim|required');
        $this->form_validation->set_rules('about_bage', lang('about_bage'), 'trim|required');
        $this->form_validation->set_rules('total_daies', lang('Total daies'), 'trim|required|numeric');
		$this->form_validation->set_rules('daies_week', lang('Daies week'), 'trim|required|numeric');
        $this->form_validation->set_rules('total_hrs', lang('Total hrs'), 'trim|required|numeric');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
$this->form_validation->set_rules('key_depart', lang('Key Depart'), 'trim|required|in_list[2]'); 
$this->form_validation->set_rules('img_bag', lang('img_bag'), 'trim|required'); 
//$this->form_validation->set_rules('content_bage', lang('content_bage'), 'trim|required'); 
        if($this->form_validation->run() === FALSE){
		
		if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}
      
if(form_error('key_depart')){
if($this->input->post('key_depart')==="" || !$this->input->post('key_depart')){
$data[] = array('message'=>strip_tags(lang('Key Depart')),"errNum" => 2);
}else{$data[] = array('message'=>strip_tags(lang('Key Depart')),"errNum" => 3);}
}
              //**************** */
if(form_error('bage_name')){
if($this->input->post('bage_name')==="" || !$this->input->post('bage_name')){
$data[] = array('message'=> strip_tags(lang('bage_name')),"errNum" =>13);
}
}              
              
if(form_error('about_bage')){
if($this->input->post('about_bage')==="" || !$this->input->post('about_bage')){
$data[] = array('message'=> strip_tags(lang('about_bage')),"errNum" =>4);
}
}
if(form_error('total_daies')){
if($this->input->post('total_daies')==="" || !$this->input->post('total_daies')){
$data[] = array('message'=> strip_tags(lang('Total daies')),"errNum" => 5);
}else{
$data[] = array('message'=> strip_tags(lang('Total daies_error')),"errNum" => 6);
}
}
            
          
if(form_error('daies_week')){
if($this->input->post('daies_week')==="" || !$this->input->post('daies_week')){
$data[] = array('message'=> strip_tags(lang('Daies week')),"errNum" =>7);
}else{
$data[] = array('message'=> strip_tags(lang('Daies week_error')),"errNum" =>8);
}
}
            
 if(form_error('total_hrs')){
if($this->input->post('total_hrs')==="" || !$this->input->post('total_hrs')){
$data[] = array('message'=> strip_tags(lang('Total hrs')),"errNum" =>9);
}else{
$data[] = array('message'=> strip_tags(lang('Total hrs_error')),"errNum" =>10);
}
}

 if(form_error('img_bag')){
if($this->input->post('img_bag')==="" || !$this->input->post('img_bag')){     
$data[] = array('message'=> strip_tags(lang('img_bag')),"errNum" =>11);
}
}   

  
    
    $this->api_return([
        'message' => $data[0]['message'],
        'errNum' => $data[0]['errNum'],
        'status' => false
    ],200);



        }

        else{
			
$customers_id=get_customer_id($this->input->post('token_id'));
date_default_timezone_set('Asia/Riyadh');
            $store = [
                      'user_id'          	=> $customers_id,
                      'bage_name'           =>$this->input->post('bage_name'),
                      'bage_details'        => $this->input->post('about_bage'),
                      'bage_hrs'            => $this->input->post('total_hrs'),
                      'week_bage_daies'     => $this->input->post('daies_week'),
                      'bage_total_daies'    => $this->input->post('total_daies'),
                      'view'=>'1',
                      'creation_date'       => date('Y-m-d H:i:s'),
                      'share'=>'1',
                      'dep_id'=>$this->input->post('key_depart')
                    ];
                    $insert = $this->db->insert('bag_info',$store);
                   $id= $this->db->insert_id();

if ($this->input->post('img_bag')) {
  $image_name = gen_random_string();
  $filename = $image_name . '.' . 'png';
  $image = base64_decode($this->input->post("img_bag"));
  $path = "uploads/products/".$filename;
  file_put_contents($path, $image);

  

$store['img'] = $filename;
$this->Main_model->update('bag_info',['id'=>$id],$store);

  if($id!=0){
     get_img_resize_courses("uploads/products/".$filename,"uploads/products/thumbnail_100/","150","100");
  }
  if($id!=0){
     get_img_resize_courses("uploads/products/".$filename,"uploads/products/thumbnail_150/","250","150");
  }
  
}
 

if($this->input->post('content_bage')){
   for($i=0; $i<count($this->input->post('content_bage')); $i++){
       if($this->input->post('content_bage')[$i]!=""){
       $data_interst['id_user']=$customers_id;
       $data_interst['type']=$this->input->post('key_depart');
       $data_interst['id_course']=$id;
       $data_interst['content']=$this->input->post('content_bage')[$i];
       $this->db->insert('course_info',$data_interst);
       }
   }
}
                    
            //////////////////////////////////////////////Send SMS Code
             //Check Insert User Data
if($insert){

$sql_bag=$this->db->order_by('id','DESC')->get_where('bag_info',array('id'=>$id,'view'=>'1'))->result();
  foreach ($sql_bag as $bage)
 $dep_id=$bage->dep_id;
 $result['id']=(int)$bage->id;
  $result['course_key']=(int)$bage->dep_id;
$result['name']=$bage->bage_name;
if($bage->bage_details!=""){
$result['details']=$bage->bage_details;
}else {$result['details']="";}
if($bage->bage_hrs!=""){
$result['bage_hrs']=(int)$bage->bage_hrs;
}else {$result['bage_hrs']="";}

if($bage->week_bage_daies!=""){
$result['week_bage_daies']=(int)$bage->week_bage_daies;
}else {$result['week_bage_daies']="";}

if($bage->week_bage_daies!=""){
$result['week_bage_daies']=(int)$bage->week_bage_daies;
}else {$result['week_bage_daies']="";}

if($bage->bage_total_daies!=""){
$result['bage_total_daies']=(int)$bage->bage_total_daies;
}else {$result['bage_total_daies']="";}


$sql_bag_content=$this->db->order_by('id','DESC')->get_where('course_info',array('id_course'=>(int)$bage->id,'view'=>'1','type'=>$this->input->post('key_depart')))->result();
if(count($sql_bag_content)>0){
  foreach ($sql_bag_content as $bag_content){
	$result['content_bag'][]=$bag_content->content;	
      
  }
}
else {
$result['content_bag']=[];
}
$result['department_name']=get_table_filed('department',array('id'=>$dep_id),"name");
if($bage->total_rate!=""){
$result['total_rate']=(int)$bage->total_rate;
}
else {
$result['total_rate']=0;
}
if($bage->img!=""){
$result['image']=base_url()."uploads/products/".$bage->img;
}
else {
$result['image']=base_url()."uploads/products/no_img.png";
} 
$result['share']=$bage->share;

$data['Course details'][]= $result;

if($data){
$this->api_return([
              'message' => lang('add_bages_result'),
              'errNum' => 405,
              'status' => true,
              "result" => $data
            ],200);
}
else {
    
$data['Course details'] = [];
$this->api_return([
'message' => lang('no_data'),
'errNum' => 401,
'status' => false,
"result" => $data
],200); 
    
}


}
else {
$data['Course details'] = [];
$this->api_return([
'message' => lang('add_bages_error'),
'errNum' => 401,
'status' => false,
"result" => $data
],200); 
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
}


        }




public function preparation_update_bage(){
  header("Access-Control-Allow-Origin: *");
  $this->_apiConfig([
      'methods' => ['POST'], //This Function by default request method GET
      'key' => ['POST', $this->key()]
    //,'requireAuthorization' => true //this used if reqired token valye
]);
  $lang ="ar";
  $this->checkLang($lang);

$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
$this->form_validation->set_rules('course_id', lang('Course ID'), 'trim|required|numeric');
$this->form_validation->set_rules('course_key', lang('Course Key'), 'trim|required|numeric');
 if($this->form_validation->run() === FALSE){
     
 if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}    
    
if(form_error('course_id')){
if($this->input->post('course_id')==="" || !$this->input->post('course_id')){
$data[] = array('message'=> strip_tags(lang('Course ID')),"errNum" =>2);
}else {
$data[] = array('message'=> strip_tags(lang('Course ID_error')),"errNum" => 3);
}	
}


if(form_error('course_key')){
if($this->input->post('course_key')==="" || !$this->input->post('course_key')){
$data[] = array('message'=> strip_tags(lang('Course Key')),"errNum" => 4);
}else {
$data[] = array('message'=> strip_tags(lang('Course Key')),"errNum" => 5);
}	
}


$this->api_return([
  'message' => $data[0]['message'],
  'errNum' => $data[0]['errNum'],
  'status' => false
],200);
}
else{

if($this->input->post('course_key')==2){
$sql_bag=$this->db->order_by('id','DESC')->get_where('bag_info',array('id'=>$this->input->post('course_id'),'view'=>'1','delete_key'=>'1'))->result();
  foreach ($sql_bag as $bage)
 $dep_id=$bage->dep_id;
 $result['id']=(int)$bage->id;
  $result['course_key']=(int)$bage->dep_id;
$result['name']=$bage->bage_name;
if($bage->bage_details!=""){
$result['details']=$bage->bage_details;
}else {$result['details']="";}
if($bage->bage_hrs!=""){
$result['bage_hrs']=(int)$bage->bage_hrs;
}else {$result['bage_hrs']="";}

if($bage->week_bage_daies!=""){
$result['week_bage_daies']=(int)$bage->week_bage_daies;
}else {$result['week_bage_daies']="";}

if($bage->week_bage_daies!=""){
$result['week_bage_daies']=(int)$bage->week_bage_daies;
}else {$result['week_bage_daies']="";}

if($bage->bage_total_daies!=""){
$result['bage_total_daies']=(int)$bage->bage_total_daies;
}else {$result['bage_total_daies']="";}


$sql_bag_content=$this->db->order_by('id','DESC')->get_where('course_info',array('id_course'=>$bage->id,'view'=>'1','type'=>$this->input->post('course_key')))->result();
if(count($sql_bag_content)>0){
  foreach ($sql_bag_content as $bag_content){
	$result['content_bag'][]=$bag_content->content;	
      
  }
}
else {
$result['content_bag']=[];
}

$result['department_name']=get_table_filed('department',array('id'=>$dep_id),"name");

if($bage->total_rate!=""){
$result['total_rate']=(int)$bage->total_rate;
}
else {
$result['total_rate']=0;
}
if($bage->img!=""){
$result['image']=base_url()."uploads/products/".$bage->img;
}
else {
$result['image']=base_url()."uploads/products/no_img.png";
} 
$data['Course details'][]= $result;
}

if($data){
$this->api_return([
              'message' => lang('Operation completed successfully'),
              'errNum' => 405,
              'status' => true,
              "result" => $data
            ],200);
}
else {
    
$data['Course details'] = [];
$this->api_return([
'message' => lang('no_data'),
'errNum' => 401,
'status' => false,
"result" => $data
],200); 
    
}



 
              
}

}



public function update_bage(){
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
       $lang ="ar";
      $this->checkLang($lang);
        $this->load->library('Authorization_Token');
		$this->load->library('form_validation');
        $this->form_validation->set_rules('bage_name',lang('bage_name'), 'trim|required');
        $this->form_validation->set_rules('about_bage', lang('about_bage'), 'trim|required');
        $this->form_validation->set_rules('total_daies', lang('Total daies'), 'trim|required|numeric');
		$this->form_validation->set_rules('daies_week', lang('Daies week'), 'trim|required|numeric');
        $this->form_validation->set_rules('total_hrs', lang('Total hrs'), 'trim|required|numeric');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
$this->form_validation->set_rules('course_id', lang('Course ID'), 'trim|required|numeric');
$this->form_validation->set_rules('key_depart', lang('Key Depart'), 'trim|required|in_list[2]'); 
//$this->form_validation->set_rules('content_bage', lang('content_bage'), 'trim|required'); 
        if($this->form_validation->run() === FALSE){
		
		if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}
      
if(form_error('key_depart')){
if($this->input->post('key_depart')==="" || !$this->input->post('key_depart')){
$data[] = array('message'=>strip_tags(lang('Key Depart')),"errNum" => 2);
}else{$data[] = array('message'=>strip_tags(lang('Key Depart')),"errNum" => 3);}
}

if(form_error('course_id')){
if($this->input->post('course_id')==="" || !$this->input->post('course_id')){
$data[] = array('message'=> strip_tags(lang('Course ID')),"errNum" =>14);
}else {
$data[] = array('message'=> strip_tags(lang('Course ID_error')),"errNum" =>15);
}	
}
              //**************** */
if(form_error('bage_name')){
if($this->input->post('bage_name')==="" || !$this->input->post('bage_name')){
$data[] = array('message'=> strip_tags(lang('bage_name')),"errNum" =>13);
}
}              
              
if(form_error('about_bage')){
if($this->input->post('about_bage')==="" || !$this->input->post('about_bage')){
$data[] = array('message'=> strip_tags(lang('about_bage')),"errNum" =>4);
}
}
if(form_error('total_daies')){
if($this->input->post('total_daies')==="" || !$this->input->post('total_daies')){
$data[] = array('message'=> strip_tags(lang('Total daies')),"errNum" => 5);
}else{
$data[] = array('message'=> strip_tags(lang('Total daies_error')),"errNum" => 6);
}
}
            
          
if(form_error('daies_week')){
if($this->input->post('daies_week')==="" || !$this->input->post('daies_week')){
$data[] = array('message'=> strip_tags(lang('Daies week')),"errNum" =>7);
}else{
$data[] = array('message'=> strip_tags(lang('Daies week_error')),"errNum" =>8);
}
}
            
 if(form_error('total_hrs')){
if($this->input->post('total_hrs')==="" || !$this->input->post('total_hrs')){
$data[] = array('message'=> strip_tags(lang('Total hrs')),"errNum" =>9);
}else{
$data[] = array('message'=> strip_tags(lang('Total hrs_error')),"errNum" =>10);
}
}


 /*if(form_error('content_bage')){
if($this->input->post('content_bage')==="" || !$this->input->post('content_bage')){          
$data[] = array('message'=> strip_tags(lang('content_bage')),"errNum" =>12);
}
}*/   
    
    $this->api_return([
        'message' => $data[0]['message'],
        'errNum' => $data[0]['errNum'],
        'status' => false
    ],200);



        }

        else{
			
$customers_id=get_customer_id($this->input->post('token_id'));
date_default_timezone_set('Asia/Riyadh');
            $store = [
                      'bage_name'           =>$this->input->post('bage_name'),
                      'bage_details'        => $this->input->post('about_bage'),
                      'bage_hrs'            => $this->input->post('total_hrs'),
                      'week_bage_daies'     => $this->input->post('daies_week'),
                      'bage_total_daies'    => $this->input->post('total_daies'),
                      'view'=>'1',
                      'creation_date'       => date('Y-m-d H:i:s'),
                      'dep_id'       => gen_random_string(),
                      'share'=>'1',
                      'dep_id'=>$this->input->post('key_depart')
                    ];
$insert = $this->db->update('bag_info',$store,array("id"=>$this->input->post('course_id')));
$img_course=get_table_filed('bag_info',array('id'=>$this->input->post('course_id')),"img");
$id=$this->input->post('course_id');
if ($this->input->post('img_bag')!="") {
    if($img_course!=""){
 unlink("uploads/products/".$img_course);
    }
  $image_name = gen_random_string();
  $filename = $image_name . '.' . 'png';
  $image = base64_decode($this->input->post("img_bag"));
  $path = "uploads/products/".$filename;
  file_put_contents($path, $image);
$store['img'] = $filename;
$this->Main_model->update('bag_info',['id'=>$id],$store);

  if($id!=0){
     get_img_resize_courses("uploads/products/".$filename,"uploads/products/thumbnail_100/","150","100");
  }
  if($id!=0){
     get_img_resize_courses("uploads/products/".$filename,"uploads/products/thumbnail_150/","250","150");
  }
  
}
 

if($this->input->post('content_bage')){
   $arry_interest= $this->input->post('content_bage');
   $this->db->delete('course_info',array('id_course'=>$id));
   for($i=0; $i<count($arry_interest); $i++){
       if($arry_interest[$i]!=""){
       $data_interst['id_user']=$customers_id;
       $data_interst['type']=$this->input->post('key_depart');
       $data_interst['id_course']=$id;
       $data_interst['view']='1';
       $data_interst['content']=$arry_interest[$i];
       $this->db->insert('course_info',$data_interst);
       }
   }
}
                    
            //////////////////////////////////////////////Send SMS Code
             //Check Insert User Data
if($insert){
$sql_bag=$this->db->order_by('id','DESC')->get_where('bag_info',array('id'=>$id,'view'=>'1'))->result();
  foreach ($sql_bag as $bage)
 $dep_id=$bage->dep_id;
 $result['id']=(int)$bage->id;
  $result['course_key']=(int)$bage->dep_id;
$result['name']=$bage->bage_name;
if($bage->bage_details!=""){
$result['details']=$bage->bage_details;
}else {$result['details']="";}
if($bage->bage_hrs!=""){
$result['bage_hrs']=(int)$bage->bage_hrs;
}else {$result['bage_hrs']="";}

if($bage->week_bage_daies!=""){
$result['week_bage_daies']=(int)$bage->week_bage_daies;
}else {$result['week_bage_daies']="";}

if($bage->week_bage_daies!=""){
$result['week_bage_daies']=(int)$bage->week_bage_daies;
}else {$result['week_bage_daies']="";}

if($bage->bage_total_daies!=""){
$result['bage_total_daies']=(int)$bage->bage_total_daies;
}else {$result['bage_total_daies']="";}


$sql_bag_content=$this->db->order_by('id','DESC')->get_where('course_info',array('id_course'=>13,'view'=>'1','type'=>$this->input->post('key_depart')))->result();
if(count($sql_bag_content)>0){
  foreach ($sql_bag_content as $bag_content){
	$result['content_bag'][]=$bag_content->content;	
  }
}

else {
$result['content_bag'][]=[];
}
$result['department_name']=get_table_filed('department',array('id'=>$dep_id),"name");
if($bage->total_rate!=""){
$result['total_rate']=(int)$bage->total_rate;
}
else {
$result['total_rate']=0;
}
if($bage->img!=""){
$result['image']=base_url()."uploads/products/".$bage->img;
}
else {
$result['image']=base_url()."uploads/products/no_img.png";
} 
$result['share']=$bage->share;

$data['Course details'][]= $result;

if($data){
$this->api_return([
              'message' => lang('update_bages_result'),
              'errNum' => 405,
              'status' => true,
              "result" => $data
            ],200);
}
else {
    
$data['Course details'] = [];
$this->api_return([
'message' => lang('no_data'),
'errNum' => 401,
'status' => false,
"result" => $data
],200); 
    
}


}
else {
$data['Course details'] = [];
$this->api_return([
'message' => lang('update_bages_error'),
'errNum' => 401,
'status' => false,
"result" => $data
],200); 
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
}


        }



public function delete_bage()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
		ob_start();
        $lang = "ar";
        $this->checkLang($lang);
		$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
$this->form_validation->set_rules('course_id', lang('Course ID'), 'trim|required|numeric');
$this->form_validation->set_rules('key_depart', lang('Key Depart'), 'trim|required|in_list[2]'); 
if($this->form_validation->run() === FALSE){

if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}
      
if(form_error('key_depart')){
if($this->input->post('key_depart')==="" || !$this->input->post('key_depart')){
$data[] = array('message'=>strip_tags(lang('Key Depart')),"errNum" => 2);
}else{$data[] = array('message'=>strip_tags(lang('Key Depart')),"errNum" => 3);}
}

if(form_error('course_id')){
if($this->input->post('course_id')==="" || !$this->input->post('course_id')){
$data[] = array('message'=> strip_tags(lang('Course ID')),"errNum" =>4);
}else {
$data[] = array('message'=> strip_tags(lang('Course ID_error')),"errNum" =>5);
}	
}


$this->api_return([
'message' => $data[0]['message'],
'errNum' => $data[0]['errNum'],
'status' => false
],200);
}
else{
$customers_id=get_customer_id($this->input->post('token_id'));
$id=$this->input->post('course_id');
$bag_id=get_table_filed('bag_info',array('id'=>$id),"id");
if ($customers_id!=""&&$bag_id!="") {
  $img_course=get_table_filed('bag_info',array('id'=>$bag_id),"img");   
$res_delete= $this->db->update('bag_info',array("delete_key"=>'0'),array('id'=>$id,'user_id'=>$customers_id));
 if($res_delete){
$this->api_return([
'message' => lang('delete_bages_success'),
'errNum' => 405,
'status' => true
],200);
}
else {
  $this->api_return([
						'message' => lang('delete_bages_error'),
						'errNum' => 402,
						'status' => false
					],200);
					
					
}
               }
               else{
                  $this->api_return([
						'message' => lang('premmission_delete'),
						'errNum' => 401,
						'status' => false
					],200);
               }
        }
		
	}
	







public function forget_password(){
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
        ]);
		ob_start();
        $lang = "ar";
        $this->checkLang($lang);

		$this->load->library('form_validation');
			$this->form_validation->set_rules('email', lang('Email'), 'trim|required|valid_email');
            $this->form_validation->set_rules('key_user',lang('key_user'), 'trim|required|numeric|min_length[1]|max_length[1]|in_list[1,2,3]');

        if($this->form_validation->run() === FALSE){
			$email_find = get_table_filed('customers',array('email'=>$this->input->post('email'),'status'=>$this->input->post('key_user')),"email");
            if(form_error('key_user')){
	if($this->input->post('key_user')==="" || !$this->input->post('key_user')){
	$data[] = array('message'=> strip_tags(lang('user_type')),"errNum" => 0);
				}
else{
$data[] = array('message'=> strip_tags(lang('user_type_error')),"errNum" => 1);
				}
            }
  //**************** */
    if(form_error('email')){
	if($this->input->post('email')==="" || !$this->input->post('email')){
	$data[] = array('message'=> strip_tags(lang('Email')),"errNum" => 2);
				}elseif($email_find==""){
					$data[] = array('message'=> strip_tags(lang('email_error')),"errNum" => 3);
				}else{
					$data[] = array('message'=> strip_tags(lang('email_error')),"errNum" => 4);
				}
            }
		  
		  

		
          $this->api_return([
					'message' => $data[0]['message'],
					'errNum' => $data[0]['errNum'],
					'status' => false
					],200);
        }else{
        $email_find = get_table_filed('customers',array('email'=>$this->input->post('email'),'status'=>$this->input->post('key_user')),"email");
        $email_id= get_table_filed('customers',array('email'=>$this->input->post('email'),'status'=>$this->input->post('key_user')),"id");

        if($email_find!=""){
           	send_email($email_id,"forgetpassword","password");
            $this->api_return([
					'message' => lang('Please check email'),
					'errNum' =>405,
					'status' => true
					],200);
	
        }

         else{
					$this->api_return([
					'message' => lang('error_send_email'),
					'errNum' =>401,
					'status' => false
					],200);
              }
              
            }
            
        
	}



/*****************END 24-4-2019*****************************/



	
	public function login()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);

		ob_start();
        $lang = "ar";
        $this->checkLang($lang);

		$this->load->library('form_validation');
        $this->form_validation->set_rules('password', lang('Password'), 'required');
		$this->form_validation->set_rules('device_reg_id', lang('Device Reg ID'), 'trim|required');
		$this->form_validation->set_rules('user_key',lang('user_key'), 'trim|required|numeric|in_list[1,2,3,4]');
			$this->form_validation->set_rules('phone', lang('phone'), 'trim|required|numeric');

        if($this->form_validation->run() === FALSE){

if(form_error('user_key')){
	if($this->input->post('user_key')==="" || !$this->input->post('user_key')){
	$data[] = array('message'=> strip_tags(lang('user_type')),"errNum" => 0);
				}
else{
$data[] = array('message'=> strip_tags(lang('user_type_error')),"errNum" => 1);
				}
            }
            
if(form_error('email')){
	if($this->input->post('email')==="" || !$this->input->post('email')){
	$data[] = array('message'=> strip_tags(lang('Phone Number')),"errNum" => 2);
				}elseif($email_find==""){
					$data[] = array('message'=> strip_tags(lang('Sorry this phone does not exist')),"errNum" => 3);
				}else{
					$data[] = array('message'=> strip_tags(lang('error_phone')),"errNum" => 4);
				}
            }
            
            
			if(form_error('device_reg_id'))
				$data[] = array('message'=> strip_tags(lang('Social ID')),"errNum" =>5);
                
            if(form_error('password'))
                $data[] = array('message'=> strip_tags(lang('Password')),"errNum" => 6);
            
			//print_r($data);die;
			$this->api_return([
			'message' => $data[0]['message'],
			'errNum' => $data[0]['errNum'],
			'status' => false
			],200);
        }else{
            $customer_info = get_this('customers',['phone'=>$this->input->post('phone'),'password'=>md5($this->input->post('password')),'status'=>$this->input->post('user_key')]);
            if ($customer_info) {
                if ((int)$customer_info['view']== 0) {
				
					 unset($customer_info['img']);
					$id = get_this('customers',['id'=>$customer_info['id']],'id');
					 $customer_info =get_this('customers',['id'=>$id]);
					 $img = get_this('customers',['id'=>$id],'img');
					 if($img!=""){
						 if(file_exists($_SERVER['DOCUMENT_ROOT'].'/uploads/customers/'.$img)){
							 $customer_infop['img'] = base_url('uploads/customers/'.$img);
						 }else{
							 $customer_infop['img'] = base_url('uploads/customers/avatar.png');
						 }
					 }else{
						 $customer_infop['img'] = base_url('uploads/customers/avatar.png');
					 }
	
					 $payload = [
							'id' => $customer_info['id'],
							'phone' => $customer_info['phone'],
							'email' => $customer_info['email']
						];
				
				$this->load->library('authorization_token');
				$token = $this->authorization_token->generateToken($payload);
						
					$data_token['token'] =$token;
					$data_token['id_customer'] =$id;
					$this->db->insert('customers_token',$data_token);
					
					$updates ['social_id']= $this->input->post('device_reg_id');
					$test=$this->db->update('customers',$updates,array('id'=>$id));
					///////////////////////////////////////////////////////////////////////////////
$customer_info =get_this('customers',['id'=>$id]);
$customer_infop['id'] =(int)$customer_info['id'];
$customer_infop['name'] = $customer_info['user_name'];
$customer_infop['phone'] =$customer_info['phone'];
$customer_infop['email'] =$customer_info['email'];
$customer_infop['age'] = $customer_info['age'];
$customer_infop['user_key'] =(int)$customer_info['status'];
$customer_infop['invitation_code'] = $customer_info['invitation_code'];
$customer_infop['city'] =get_table_filed('city',array('id'=>$customer_info['city_id']),"name");
$customer_infop['token_id'] =$token;
$data['customer_info'] = $customer_infop;
$data['customer_info']['activation_status'] = lang('Account Not Activated');

					 $this->api_return([
					 'message' => lang('Account Not Activated'),
					'errNum' => 401,
					'status' => true,
					"result" => $data
					],200);
                }else{
                     if ($customer_info['view'] == 1) {
                         
						$id = get_this('customers',['id'=>$customer_info['id']],'id');
					 $customer_info =get_this('customers',['id'=>$id]);
					 $img = get_this('customers',['id'=>$id],'img');
					 if($img!=""){
						 if(file_exists($_SERVER['DOCUMENT_ROOT'].'/uploads/customers/'.$img)){
							 $customer_infop['img'] = base_url('uploads/customers/'.$img);
						 }else{
							 $customer_infop['img'] = base_url('uploads/customers/avatar.png');
						 }
					 }else{
						 $customer_infop['img'] = base_url('uploads/customers/avatar.png');
					 }
	
					 $payload = [
							'id' => $customer_info['id'],
							'phone' => $customer_info['phone'],
							'email' => $customer_info['email']
						];
						$this->load->library('authorization_token');
						$token = $this->authorization_token->generateToken($payload);
					$updates ['social_id']= $this->input->post('device_reg_id');
					$test=$this->db->update('customers',$updates,array('id'=>$id));
					$data_token['token'] =$token;
					$data_token['id_customer'] =$id;
					$this->db->insert('customers_token',$data_token);
					///////////////////////////////////////////////////////////////////////////////
$customer_info =get_this('customers',['id'=>$id]);
$customer_infop['id'] =(int)$customer_info['id'];
$customer_infop['name'] = $customer_info['user_name'];
$customer_infop['phone'] =$customer_info['phone'];
$customer_infop['email'] =$customer_info['email'];
$customer_infop['age'] = $customer_info['age'];
$customer_infop['user_key'] =(int)$customer_info['status'];
$customer_infop['city'] =get_table_filed('city',array('id'=>$customer_info['city_id']),"name");
$customer_infop['token_id'] =$token;
$data['customer_info'] = $customer_infop;
$data['customer_info']['activation_status'] = lang('Account activated');

						 $this->api_return([
						 'message' => lang('Account activated'),
						'errNum' => 405,
						'status' => true,
						"result" => $data
						],200);
                     }
				
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
	



	public function pages(){
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
        ]);
        
 $lang = "ar";
 $this->checkLang($lang); 
$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
        $this->form_validation->set_rules('key_user',lang('key_user'), 'trim|required|numeric|min_length[1]|max_length[1]');

 if($this->form_validation->run() === FALSE){
            if(form_error('token_id')) {
                if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
                $data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
                }
    }
if(form_error('key_user')){
if($this->input->post('key_user')==="" || !$this->input->post('key_user')){
$data[] = array('message'=> strip_tags(lang('user_type')),"errNum" =>1);
}
else{
$data[] = array('message'=> strip_tags(lang('user_type_error')),"errNum" =>2);
}
}

$this->api_return([
        'message' => $data[0]['message'],
        'errNum' => $data[0]['errNum'],
        'status' => false
    ],200);

 }
 else {
		$pages_value=$this->db->get_where("pages",array('key_txt!='=>'Points','key_txt!='=>'terms',"flag"=>$this->input->post('key_user')))->result();
		if(count($pages_value)>0){
		foreach($pages_value as $pages_value)
		$result['page_id']=(int)$pages_value->id;
		$result['title']=$pages_value->title;
		$result['content']= strip_tags(trim(preg_replace('/\s\s+/', ' ', $pages_value->content)));
            if ($result) {
              $data['pages'] = $result;
              $this->api_return([
						'message' => lang('Operation completed successfully'),
						'errNum' => 405,
						'status' => true,
						"result" => $data
					],200);
            }
      }
      
      else{
        $data['pages'] = [];
        $this->api_return([
				'message' => lang('Sorry, you do not have any pages stored in the database'),
				'errNum' => 5,
				'status' => true,
				"result" => $data
				],200);
       }
 }
     
 }
	
	public function page()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
        ]);
		ob_start();
        $lang ="ar";
        $this->checkLang($lang);

		$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
$this->form_validation->set_rules('key_user',lang('key_user'), 'trim|required|numeric|min_length[1]|max_length[1]');

        $this->form_validation->set_rules('page_id', lang('Page ID'), 'required|numeric');
        if($this->form_validation->run() === FALSE){
            
             if(form_error('token_id')) {
                if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
                $data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
                }
    }
if(form_error('key_user')){
if($this->input->post('key_user')==="" || !$this->input->post('key_user')){
$data[] = array('message'=> strip_tags(lang('user_type')),"errNum" =>1);
}
else{
$data[] = array('message'=> strip_tags(lang('user_type_error')),"errNum" =>2);
}
}
            
            if(form_error('page_id')){
                if($this->input->post('page_id')==="" || !$this->input->post('page_id')){
					$data[] = array('message'=> strip_tags(lang('page_id')),"errNum" =>3);
				}else{
					$data[] = array('message'=> strip_tags(lang('page_id')),"errNum" => 3);
				}
			}
			$this->api_return([
				'message' => $data[0]['message'],
				'errNum' => $data[0]['errNum'],
				'status' => false
			],200);
        }else{
            $page = get_this('pages',["flag"=>$this->input->post('key_user'),'id'=>$this->input->post('page_id'),'active'=>'1']);
            if ($page) {
                  $result = [
                                  'page_id' => (int)$page['id'],
								  'title'   => $page['title'],
                                  'content' => strip_tags(trim(preg_replace('/\s\s+/', ' ', $page['content'])))
                              ];
                 if ($result) {
							///////////////////////////////////////////////////////////////
					  
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
        ]);

        $lang = "ar";
        $this->checkLang($lang);
	
			$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');

if($this->form_validation->run() === FALSE){
if(form_error('token_id')) {
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}
}
$this->api_return([
'message' => $data[0]['message'],
'errNum' => $data[0]['errNum'],
'status' => false
],200);
        }else{
			$this->db->select('id,name,color');
				$this->db->where('view','1');
			$tickets = $this->db->get('tickets_types');
	$tickets_types=$tickets->result();
		
		if ($tickets_types) {
        foreach ($tickets_types as $method) {
          $result['id'] =(int)$method->id;
          $result['name'] =$method->name;
          $result['color'] =$method->color;
          $data['tickets_types'][]= $result;
        }
            if ($result) {
              
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
	}
	
	public function new_ticket()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
        $lang ="ar";
        $this->checkLang($lang);

		$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
$this->form_validation->set_rules('key_user',lang('key_user'), 'trim|required|numeric|min_length[1]|max_length[1]');
$this->form_validation->set_rules('ticket_type_id', lang('Ticket Type'), 'trim|required|numeric');
$this->form_validation->set_rules('title', lang('Title'), 'trim|required');
$this->form_validation->set_rules('content', lang('Content'), 'trim|required');
        if($this->form_validation->run() === FALSE){


if(form_error('token_id')) {
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}
}
if(form_error('key_user')){
if($this->input->post('key_user')==="" || !$this->input->post('key_user')){
$data[] = array('message'=> strip_tags(lang('user_type')),"errNum" =>1);
}
else{
$data[] = array('message'=> strip_tags(lang('user_type_error')),"errNum" =>2);
}
}
			
            if(form_error('ticket_type_id')){
				if($this->input->post('ticket_type_id')==="" || !$this->input->post('ticket_type_id')){
					$data[] = array('message'=> strip_tags(lang('Ticket Type')),"errNum" => 3);
				}else{
					$data[] = array('message'=> strip_tags(lang('Ticket Type_error')),"errNum" =>4);
				}
			}
			
			if(form_error('title'))
				$data[] = array('message'=> strip_tags(lang('Title')),"errNum" => 5);
			
            if(form_error('content'))
				$data[] = array('message'=> strip_tags(lang('Content')),"errNum" =>6);
            $this->api_return([
						'message' => $data[0]['message'],
						'errNum' => $data[0]['errNum'],
						'status' => false
					],200);
        }else{
            $customers_id=get_customer_id($this->input->post('token_id'));
              $customer = get_this('customers',['id'=>$customers_id]);
               if ($customers_id) {
						$ticket_type = get_this('tickets_types',['id'=>$this->input->post('ticket_type_id')]);
						if($ticket_type){
							date_default_timezone_set('Asia/Riyadh');
                            $store = [
                                        'created_by'     =>$customers_id,
                                        'ticket_type_id' => $this->input->post('ticket_type_id'),
                                        'title'        => $this->input->post('title'),
                                        'content'        => $this->input->post('content'),
                                        'created_at'     => date('Y-m-d'),
                                        'time'     => date('h:i:s'),
                                        'type'           => 1,
                                        'user_type' =>$this->input->post('key_user')
                                      ];
                            $insert = $this->Main_model->insert('tickets',$store);
                            if($insert){
                                
                                $this->api_return([
										'message' => lang('Ticket successfully created'),
										'errNum' => 405,
										'status' => true
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
			'key' => ['POST', $this->key()]
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);

		$this->load->library('form_validation');
        $this->form_validation->set_rules('ticket_id', lang('Ticket ID'), 'trim|required|numeric');
        $this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
        $this->form_validation->set_rules('content', lang('Content'), 'trim|required');
        if($this->form_validation->run() === FALSE){
            if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}
            
            
            if(form_error('ticket_id')){
				if($this->input->post('ticket_id')==="" || !$this->input->post('ticket_id')){
					$data[] = array('message'=> strip_tags(lang('Ticket ID')),"errNum" =>2);
				}else{
					$data[] = array('message'=> strip_tags(lang('Ticket ID_error')),"errNum" =>3);
				}
			}
			

			
            if(form_error('content'))
				$data[] = array('message'=> strip_tags(lang('Content')),"errNum" =>4);
            $this->api_return([
						'message' => $data[0]['message'],
						'errNum' => $data[0]['errNum'],
						'status' => false
					],200);
        }else{
            $customers_id=get_customer_id($this->input->post('token_id'));
              $customer = get_this('customers',['id'=>$customers_id]);
               if ($customer) {
                            $ticket = get_this('tickets',['id'=>$this->input->post('ticket_id')]);
                            if ($ticket) {
								date_default_timezone_set('Asia/Riyadh');
                                $store = [
                                      'created_by' => $customers_id,
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
											'sender'	=>get_this('customers',['id' =>$tickets_replies['created_by']],'user_name')
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
                       
                   
               }
               else{
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
			'key' => ['POST', $this->key()]
        ]);
        $lang ="ar";
        $this->checkLang($lang);

		$this->load->library('form_validation');
		$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
		$this->form_validation->set_rules('limit', lang('Number of visible elements'), 'trim|required|numeric');
		$this->form_validation->set_rules('page_number', lang('Page Number'), 'trim|required|numeric');
		if($this->form_validation->run() === FALSE){

if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}
			
            if(form_error('limit')){
				if($this->input->post('limit')==="" || !$this->input->post('limit')){
					$data[] = array('message'=> strip_tags(lang('limit')),"errNum" => 2);
				}else{
					$data[] = array('message'=> strip_tags(lang('limit_error')),"errNum" => 3);
				}
			}
			
            if(form_error('page_number')){
				if($this->input->post('page_number')==="" || !$this->input->post('page_number')){
					$data[] = array('message'=> strip_tags(lang('page_number')),"errNum" => 4);
				}else{
					$data[] = array('message'=> strip_tags(lang('page_number_error')),"errNum" => 5);
				}
			}
            $this->api_return([
						'message' => $data[0]['message'],
				'errNum' => $data[0]['errNum'],
						'status' => false
					],200);
        }else{
            $customers_id=get_customer_id($this->input->post('token_id'));
          $user_info = get_this('customers',['id' =>$customers_id]);
          if ($user_info) {
			  $total = get_this_limit('tickets',['created_by'=>$user_info['id']]);
                      $offset = $this->input->post('limit') * $this->input->post('page_number');
                      $where['created_by'] = (int)$user_info['id'];
                     
                      $tickets = $this->db->order_by('id','DESC')
										  //->select('id, title_ar')
                                          ->get_where('tickets',$where,$this->input->post('limit'),$offset)
                                          ->result();
                      if ($tickets) {
						
                        foreach ($tickets as $ticket) {
						$color = get_this('tickets_types',['id' => $ticket->ticket_type_id],'color');
						$type = get_this('tickets_types',['id' => $ticket->ticket_type_id],'name');
					
                          $result[] = [
                                            'id'      => (int)$ticket->id,
                                            'title'   => $ticket->title,
                                            'type'   => $type,
                                            'sender_type'   => $ticket->type,
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
			'key' => ['POST', $this->key()]
        ]);
		ob_start();
        $lang = $this->input->post('lang');
        $this->checkLang($lang);

		$this->load->library('form_validation');
        $this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
        $this->form_validation->set_rules('ticket_id', lang('Ticket ID'), 'required|numeric');
        if($this->form_validation->run() === FALSE){
            
if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}
			
            if(form_error('ticket_id')){
				if($this->input->post('ticket_id')==="" || !$this->input->post('ticket_id')){
					$data[] = array('message'=> strip_tags(lang('Ticket ID')),"errNum" => 2);
				}else{
					$data[] = array('message'=> strip_tags(lang('Ticket ID_error')),"errNum" => 3);
				}
			}
			 
            $this->api_return([
						'message' => $data[0]['message'],
						'errNum' => $data[0]['errNum'],
						'status' => false
					],200);
        }else{
            $customers_id=get_customer_id($this->input->post('token_id'));

          $user_info = get_this('customers',['id' =>$customers_id]);
          if ($user_info) {
                      $ticket = get_this('tickets',['id'=>$this->input->post('ticket_id'),'created_by'=>$customers_id]);
                      if ($ticket) {
							$color = get_this('tickets_types',['id' => $ticket['ticket_type_id']],'color');
							$type = get_this('tickets_types',['id' => $ticket['ticket_type_id']],'name');
							
                            $result = [
                                            'ticket_id' => (int)$ticket['id'],
                                            'title' => $ticket['title'],
                                            'type'     => $type,
                                            'color'     => $color,
                                            'content'   => strip_tags(trim(preg_replace('/\s\s+/', ' ', $ticket['content']))),
                                            'created_at'   => $ticket['created_at']
                                        ];
                           if ($result) {
                                $data['ticket_info']['ticket'] = $result;
                                $ticket_replies = get_table('tickets_replies',['ticket_id'=>(int)$ticket['id']]);
                                $replies = [];
						

                                if ($ticket_replies) {
                                  foreach ($ticket_replies as $reply) {
                                            $replies[] =[
                                                          'id'         => (int)$reply->id,
                                                          'created_at' => $reply->created_at,
                                                          'time'       => $reply->time,
                                                          'content'    => strip_tags(trim(preg_replace('/\s\s+/', ' ', $reply->content))),
                                                          'sender'     => ($reply->reply_type == '0') ? 'خدمة العملاء' : get_this('customers',['id' => $reply->created_by],'user_name'),
                                     'sender_type'=>(int)$reply->reply_type
                                                        ]; 
                                 }
                                 $data['ticket_info']['replies_number'] = get_table('tickets_replies',['ticket_id'=>(int)$ticket['id']],'count');
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
						'message' => lang('Sorry, there are no data for this user'),
						'errNum' => 402,
						'status' => false
					],200);
          }
        }
	}
	

	
	public function share(){
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
		ob_start();
        $lang = "ar";
        $this->checkLang($lang);

		$this->load->library('form_validation');
		$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
		if($this->form_validation->run() === FALSE){
		    
if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}
}
		    
$this->api_return([
						'message' => $data[0]['message'],
						'errNum' => $data[0]['errNum'],
						'status' => false
					],200);
        }
        
        else{
          $user_mode_key=$this->input->post('user_mode_key');
if($user_mode_key!=""&&$user_mode_key==0){
 $customers_id=-1;   
}
else {
$customers_id=get_customer_id($this->input->post('token_id'));    
}
          
if($customers_id!="")       {   
             $invitation_code=get_table_filed('customers',array('id'=>$customers_id),"invitation_code");
			$user_info = get_this('customers',['id' =>$customers_id]);
						$app_android = get_this('site_info',['id'=>1],'app_android');
		                     $app_ios = get_this('site_info',['id'=>1],'app_ios');
		                     $result['app_ios']=$app_ios;
		                     $result['app_android']=$app_android;
		                     if($invitation_code!=""){
		                      $result['share code']=$invitation_code;
		                     }
		                     else {
		                      $result['share code']="";   
		                     }
		                       $data['Share'][] = $result;
							  $this->api_return([
									'message' => lang('A post has been made and a point deducted from your calling points'),
									'errNum' => 405,
									'status' => true,
									"result" => $data
								],200);
        }
        else {
            
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
	


	
	public function notifications()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
		ob_start();
        $lang ="ar";
        $this->checkLang($lang);

		$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
		$this->form_validation->set_rules('limit', lang('Number of visible elements'), 'trim|required|numeric');
		$this->form_validation->set_rules('page_number', lang('Page Number'), 'trim|required|numeric');
		if($this->form_validation->run() === FALSE){
			
			
if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}

if(form_error('limit')){
if($this->input->post('limit')==="" || !$this->input->post('limit')){
$data[] = array('message'=> strip_tags(lang('limit')),"errNum" => 2);
}else{
$data[] = array('message'=> strip_tags(lang('limit_error')),"errNum" => 3);
}
}
			
if(form_error('page_number')){
if($this->input->post('page_number')==="" || !$this->input->post('page_number')){
$data[] = array('message'=> strip_tags(lang('page_number')),"errNum" => 4);
}else{
$data[] = array('message'=> strip_tags(lang('page_number_error')),"errNum" => 5);
}
}
			
            $this->api_return([
						'message' => $data[0]['message'],
						'errNum' => $data[0]['errNum'],
						'status' => false
					],200);
        }else{
$customers_id=get_customer_id($this->input->post('token_id'));         
            
			$user_info = get_this('customers',['id' =>$customers_id]);
			$offset = $this->input->post('limit') * $this->input->post('page_number');
			
		
			///////////////////////////////////////////////////////////////////////////
			
			if ($user_info) {
						$notifications = get_this_limit('notifications',['customer_id'=>$customers_id],'',[$this->input->post('limit'),$offset],['id','DESC']);
						$not_total = get_this('notifications',['customer_id'=>$customers_id]);
						$total = $this->db->get_where('notifications',array('customer_id'=>$customers_id))->result();
						if($notifications){
						foreach($notifications as $notification){
								$this->db->select('id,title,description');
								$this->db->where('customer_id',$customers_id);
								$title = $this->db->get('notifications')->row_array();

								$result['date']=$notification->creation_date; 
								$result['title'] = $notification->title;
								$result['desc'] =$notification->description;
if($notification->course_key==2&&$notification->course_id!=""&&$notification->course_key!=""){
$result['course name'] =get_table_filed('bag_info',array('id'=>(int)$notification->course_id),"bage_name");
$img =get_table_filed('bag_info',array('id'=>(int)$notification->course_id),"img");
if($img!=""){
$result['image']=base_url()."uploads/products/".$img;
}
else {
$result['image']=base_url()."uploads/products/no_img.png";
}  
}
else if($notification->course_key!=2&&$notification->course_id!=""&&$notification->course_key!=""){
$result['course name'] =get_table_filed('products',array('id'=>(int)$notification->course_id),"name"); 
$img =get_table_filed('products',array('id'=>(int)$notification->course_id),"img");
if($img!=""){
$result['image']=base_url()."uploads/products/".$img;
}
else {
$result['image']=base_url()."uploads/products/no_img.png";
}  	
}
else {
$result['course name']="";
 $result['image']="";   
}
$result['type'] =(int)$notification->type;
$data['Notifications'][]=$result;
}
						
						$update = ['notifications_num' => 0];
						$this->db->update('customers',$update,array('id'=>$customers_id));
						
						
						//$update_notfy = ['view' =>'1'];
						//$this->db->update('notifications',$update_notfy,array('customer_id'=>$customers_id));
						
						
						///////////////////////////////////////////////////////////////////////////
							  $this->api_return([
									'message' => lang('Operation completed successfully'),
									'errNum' => 405,
									'status' => true,
									'total' => count($total),
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
						'message' => lang('Sorry, there are no data for this user'),
						'errNum' => 402,
						'status' => false
					],200);
          }
		}
	}
	
	public function details_notification(){
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
		ob_start();
        $lang = "ar";
        $this->checkLang($lang);

		$this->load->library('form_validation');
        $this->form_validation->set_rules('notification_id', lang('Alert number'), 'required|numeric');
		$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
		if($this->form_validation->run() === FALSE){
     
if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}

if(form_error('notification_id')){
				if($this->input->post('notification_id')==="" || !$this->input->post('notification_id')){
					$data[] = array('message'=> strip_tags(lang('notification_id')),"errNum" =>2);
				}else{
					$data[] = array('message'=> strip_tags(lang('notification_id')),"errNum" =>3);
				}
			}
			
            $this->api_return([
						'message' => $data[0]['message'],
						'errNum' => $data[0]['errNum'],
						'status' => false
					],200);
        }else{
            $customers_id=get_customer_id($this->input->post('token_id'));
			$user_info = get_this('customers',['id' =>$customers_id]);
			if ($user_info) {

						$update = ['view' => '1'];
						$this->db->update('notifications',$update,array('id'=>$this->input->post('notification_id')));
						$notifications = $this->db->get_where('notifications',array('id'=>$this->input->post('notification_id')))->result();
						if(count($notifications)>0){
						foreach($notifications as $notification){
								$this->db->select('id,title,description');
								$this->db->where('customer_id',$customers_id);
								$title = $this->db->get('notifications')->row_array();

								$result['notification_id']=(int)$notification->id; 
								$result['customer_id'] = (int)$notification->customer_id;
								if($notification->course_key==""){$result['course_key']="";}
								else {	$result['course_key'] = $notification->course_key;}
								if($notification->course_id==""){$result['course_id']="";}
								else {	$result['course_id'] =$notification->course_id;}
								$result['title'] = $notification->title;
								$result['desc'] =$notification->description;
if($notification->course_key==2&&$notification->course_id!=""&&$notification->course_key!=""){
$result['course name'] =get_table_filed('bag_info',array('id'=>(int)$notification->course_id),"bage_name");
$img =get_table_filed('bag_info',array('id'=>(int)$notification->course_id),"img");
if($img!=""){
$result['image']=base_url()."uploads/products/".$img;
}
else {
$result['image']=base_url()."uploads/products/no_img.png";
}  
}
else if($notification->course_key!=2&&$notification->course_id!=""&&$notification->course_key!=""){
$result['course name'] =get_table_filed('products',array('id'=>(int)$notification->course_id),"name"); 
$img =get_table_filed('products',array('id'=>(int)$notification->course_id),"img");
if($img!=""){
$result['image']=base_url()."uploads/products/".$img;
}
else {
$result['image']=base_url()."uploads/products/no_img.png";
}  	
}
else {
$result['course name']="";
 $result['image']="";   
}
$result['view'] =$notification->view;
$result['type'] =(int)$notification->type;
$data['Notifications'][]=$result;
$this->api_return([
'message' => lang('Successfully updated'),
'errNum' => 405,
'status' => true,
"result" => $data
],200);
						
				}
						}
			
          }
          else{
                   $this->api_return([
						'message' => lang('Sorry, there are no data for this user'),
						'errNum' => 402,
						'status' => false
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
	
	public function custom_menu()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
		ob_start();
        $lang ="ar";
        $this->checkLang($lang);
		
		$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
$this->form_validation->set_rules('key_user',lang('key_user'), 'trim|required|numeric|min_length[1]|max_length[1]');

		if($this->form_validation->run() === FALSE){
					
	if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}
if(form_error('key_user')){
if($this->input->post('key_user')==="" || !$this->input->post('key_user')){
$data[] = array('message'=> strip_tags(lang('user_type')),"errNum" =>1);
}
else{
$data[] = array('message'=> strip_tags(lang('user_type_error')),"errNum" =>2);
}
}
			
            $this->api_return([
						'message' => $data[0]['message'],
						'errNum' => $data[0]['errNum'],
						'status' => false
					],200);
					
		}
		else{
$user_mode_key=$this->input->post('user_mode_key');
if($user_mode_key!=""&&$user_mode_key==0){
 $customer_id=-1;   
}
else {
$customer_id=get_customer_id($this->input->post('token_id'));    
}

if($customer_id!=""&&$customer_id!=-1){

$customers_id=get_table_filed('customers',array('id'=>$customer_id,'status'=>$this->input->post('key_user')),"id");
$customer_info = get_this('customers',['id'=>$customers_id]);    
$img = get_this('customers',['id'=>$customers_id],'img');
if($img!=""){
if(file_exists($_SERVER['DOCUMENT_ROOT'].'/uploads/customers/'.$img)){
$customer_infop['img'] = base_url('uploads/customers/'.$img);
}else{
$customer_infop['img'] = base_url('uploads/customers/no_img.png');
}
}else{
$customer_infop['img'] = base_url('uploads/customers/no_img.png');
}
	
					
$customer_info =get_this('customers',['id'=>$customers_id]);
$customer_infop['id'] =(int)$customer_info['id'];
$customer_infop['name'] = $customer_info['user_name'];
$customer_infop['phone'] =$customer_info['phone'];
$customer_infop['email'] =$customer_info['email'];
$customer_infop['age'] = $customer_info['age'];
$customer_infop['user_key'] =(int)$customer_info['status'];
$customer_infop['invitation_code'] = $customer_info['invitation_code'];
$customer_infop['social_id'] = $customer_info['social_id'];
$customer_infop['points'] = $customer_info['points'];
$customer_infop['notifications_num'] = $customer_info['notifications_num'];
$customer_infop['fav_num'] = count($this->db->get_where('favourites',['user_id'=>$customers_id])->result());
$customer_infop['city'] =get_table_filed('city',array('id'=>$customer_info['city_id']),"name");
$customer_infop['token_id'] =$customer_info['device_reg_id'];
$data['customer_info']= $customer_infop;

$pages_value=$this->db->get_where("pages",array('key_txt!='=>'Points','key_txt!='=>'terms',"flag"=>$this->input->post('key_user')))->result();
		if(count($pages_value)>0){
		foreach($pages_value as $pages_value){
		$result['page_id']=(int)$pages_value->id;
		$result['title']=$pages_value->title;
		$result['content']= strip_tags(trim(preg_replace('/\s\s+/', ' ', $pages_value->content)));
		  $data['pages'] []= $result;
      }
		}
      
else { $data['pages']=[];}
		
	
$this->api_return([
'message' => lang('Operation completed successfully'),
'errNum' => 405,
'status' => true,
"result" => $data
],200);	
	
	
		}
		
else if($customer_id!=""&&$customer_id==-1){
$customer_infop['id'] =0;		    
$customer_infop['img'] = base_url('uploads/customers/no_img.png');
$customer_infop['name'] = "زائر";
$customer_infop['phone'] ="";
$customer_infop['email'] ="";
$customer_infop['age'] = "";
$customer_infop['user_key'] =0;
$customer_infop['invitation_code'] = "";
$customer_infop['social_id'] ="";
$customer_infop['points'] = "";
$customer_infop['notifications_num'] = "0";
$customer_infop['fav_num'] =0;
$customer_infop['city'] ="";
$customer_infop['token_id'] ="";
$data['customer_info']= $customer_infop;

$pages_value=$this->db->get_where("pages",array('key_txt!='=>'Points','key_txt!='=>'terms',"flag"=>1))->result();
		if(count($pages_value)>0){
		foreach($pages_value as $pages_value){
		$result['page_id']=(int)$pages_value->id;
		$result['title']=$pages_value->title;
		$result['content']= strip_tags(trim(preg_replace('/\s\s+/', ' ', $pages_value->content)));
		  $data['pages'] []= $result;
      }
		}
      
else {
 $data['pages']=[];
		}

$this->api_return([
'message' => lang('Operation completed successfully'),
'errNum' => 405,
'status' => true,
"result" => $data
],200);

	}
	else {
$this->api_return([
'message' => lang('Sorry, there are no data for this user'),
'errNum' => 402,
'status' => false
],200);	    
	    
	}
     

		 
       
		}
		
	}
	
	
	
	
		public function get_points()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
		ob_start();
        $lang ="ar";
        $this->checkLang($lang);
		
		$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
$this->form_validation->set_rules('key_user',lang('key_user'), 'trim|required|numeric|min_length[1]|max_length[1]');

		if($this->form_validation->run() === FALSE){
					
	if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}
if(form_error('key_user')){
if($this->input->post('key_user')==="" || !$this->input->post('key_user')){
$data[] = array('message'=> strip_tags(lang('user_type')),"errNum" =>1);
}
else{
$data[] = array('message'=> strip_tags(lang('user_type_error')),"errNum" =>2);
}
}
			
            $this->api_return([
						'message' => $data[0]['message'],
						'errNum' => $data[0]['errNum'],
						'status' => false
					],200);
					
		}else{
$customers_id=get_customer_id($this->input->post('token_id'));
	$customer_info = get_this('customers',['id'=>$customers_id,'status'=>$this->input->post('key_user')]);
	
	
if($customers_id!=""){
					
$customer_info =get_this('customers',['id'=>$customers_id]);
$customer_infop['id'] =(int)$customer_info['id'];
if($customer_info['points']==0){$customer_infop['points']="";}
else {$customer_infop['points'] = $customer_info['points'];}
$data['customer_info']= $customer_infop;
$pages_value=$this->db->get_where("points_terms",array("user_key"=>$this->input->post('key_user')))->result();
		if(count($pages_value)>0){
		foreach($pages_value as $pages_value){
		//$result['page_id']=(int)$pages_value->id;
		$result['content']= strip_tags(trim(preg_replace('/\s\s+/', ' ', $pages_value->content)));
		$data['Points terms'][] = $result;
          
      }
      
		}
		else {
		 //$result['page_id']="";
		$result['content']="";
		    $data['Points terms'][] =$result;}
        if ($data) {
              $this->api_return([
						'message' => lang('Operation completed successfully'),
						'errNum' => 405,
						'status' => true,
						"result" => $data
					],200);
            }
      else{
        $data['Points page'] = [];
        $this->api_return([
				'message' => lang('Sorry, you do not have any pages stored in the database'),
				'errNum' => 5,
				'status' => true,
				"result" => $data
				],200);
       }
       
}
else {
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
			'key' => ['POST', $this->key()]
        ]);
		ob_start();
        $lang = "ar";
        $this->checkLang($lang);
		
		$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');

		if($this->form_validation->run() === FALSE){
if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}

	
            $this->api_return([
						'message' => $data[0]['message'],
						'errNum' => $data[0]['errNum'],
						'status' => false
					],200);
					
		}else{
		    
		 $customers_id= get_customer_id($this->input->post('token_id'));
		 $token_id=get_table_filed('customers_token',array('id'=>$this->input->post('token_id')),"id");
	$customer_info = get_this('customers',['id'=>$customers_id]);		    
        	if ($customer_info) {
					//Reset device_reg_id
					$updates['device_reg_id']= "";
					$updates ['social_id']= "";
					$this->db->update('customers',$updates,['id'=>$customer_info['id']]);
					$this->db->delete('customers_token', array('id' => $token_id)); 
					///////////////////////////////////////////////////////////////////////////////
					$this->api_return([
						'message' =>"تم تسجيل الخروج بنجاح",
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



public function menu_notfiy()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()]
        ]);
		ob_start();
        $lang ="ar";
        $this->checkLang($lang);
		
		$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
$this->form_validation->set_rules('key_user',lang('key_user'), 'trim|required|numeric|min_length[1]|max_length[1]');

		if($this->form_validation->run() === FALSE){
					
	if(form_error('token_id')){
if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
}else {
$data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 1);
}	
}
if(form_error('key_user')){
if($this->input->post('key_user')==="" || !$this->input->post('key_user')){
$data[] = array('message'=> strip_tags(lang('user_type')),"errNum" =>1);
}
else{
$data[] = array('message'=> strip_tags(lang('user_type_error')),"errNum" =>2);
}
}
			
            $this->api_return([
						'message' => $data[0]['message'],
						'errNum' => $data[0]['errNum'],
						'status' => false
					],200);
					
		}else{
		 $customers_id= get_customer_id($this->input->post('token_id'));
$customers_id=get_table_filed('customers',array('id'=>$customers_id,'status'=>$this->input->post('key_user')),"id");
	$customer_info = get_this('customers',['id'=>$customers_id]);
	if($customers_id!=""){
	

	
					
$customer_info =get_this('customers',['id'=>$customers_id]);
$data['notifications_num'] = (int)$customer_info['notifications_num'];

        if ($data) {
              $this->api_return([
						'message' => lang('Operation completed successfully'),
						'errNum' => 405,
						'status' => true,
						"result" => $data
					],200);
            }
            
                 else{
     $data['notifications_num'] = "";
        $this->api_return([
				'message' =>"لا يوجد اى تنبهات حاليا",
				'errNum' => 5,
				'status' => true,
				"result" => $data
				],200);
       }
	}
      else{
$data['notifications_num'] = "";
        $this->api_return([
				'message' => lang('Customer ID notcorrect'),
				'errNum' =>402,
				'status' => false
				],200);
       }
       
		}
		
	}

	
public function get_course_final_price() {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
			'key' => ['POST', $this->key()],
        ]);
        
 $lang = "ar";
 $this->checkLang($lang); 
	$this->load->library('form_validation');
$this->form_validation->set_rules('token_id', lang('Customer ID'), 'trim|required');
$this->form_validation->set_rules('course_id', lang('Course ID'), 'trim|required|numeric');
$this->form_validation->set_rules('course_key', lang('Course Key'), 'trim|required|numeric');

 if($this->form_validation->run() === FALSE){
            if(form_error('token_id')) {
                if($this->input->post('token_id')==="" || !$this->input->post('token_id')){
                $data[] = array('message'=> strip_tags(lang('Customer ID')),"errNum" => 0);
                }
            }
            
if(form_error('course_id')){
if($this->input->post('course_id')==="" || !$this->input->post('course_id')){
$data[] = array('message'=> strip_tags(lang('Course ID')),"errNum" => 2);
}else {
$data[] = array('message'=> strip_tags(lang('Course ID')),"errNum" => 3);
}	
}


if(form_error('course_key')){
if($this->input->post('course_key')==="" || !$this->input->post('course_key')){
$data[] = array('message'=> strip_tags(lang('Course Key')),"errNum" => 4);
}else {
$data[] = array('message'=> strip_tags(lang('Course Key')),"errNum" => 5);
}	
}


$this->api_return([
        'message' => $data[0]['message'],
        'errNum' => $data[0]['errNum'],
        'status' => false
    ],200);


        }
        else{
 $customers_id=get_customer_id($this->input->post('token_id'));
 if($customers_id!=""){




if($discount_code_txt!=""){
    $user_code_discount= get_table_filed('customers',array('id'=>$customer_id),"code_discount");
     $code_discount_id= get_table_filed('customers',array('id'=>$customer_id),"code_discount_id");
      $code_id= get_table_filed('codes',array('code_name'=>$discount_code_txt,'view'=>'1','total_used>'=>0,'end_date>'=>date("Y-m-d")),"id"); 
  $code_discount= get_table_filed('codes',array('code_name'=>$discount_code_txt,'view'=>'1','total_used>'=>0,'end_date>'=>date("Y-m-d")),"discount"); 
  $user_using= get_table_filed('codes',array('code_name'=>$discount_code_txt,'view'=>'1','total_used>'=>0,'end_date>'=>date("Y-m-d")),"user_using"); 
  if($code_id!=""){
      $coustomer_code_id= get_table_filed('coustomer_code',array('id_customer'=>$customer_id,'id_code'=>$code_id),"id");   
      if($coustomer_code_id!=""){
        $coustomer_count= get_table_filed('coustomer_code',array('id'=>$coustomer_code_id),"count");
        if($coustomer_count<$user_using){
         $customer_infop['code_discount_key'] =1; 
         $customer_infop['discount_code'] =$code_discount;;
         $customer_infop['txt'] ="تم استخدام كود الخصم بنجاح ";
    if($final_price>$sql_discount&&$sql_discount!=""){
 $customer_infop['final_price'] =$sql_discount-round(($sql_discount*$code_discount)/100);}
else { $customer_infop['final_price']  =$final_price-round(($final_price*$code_discount)/100);}
$main_data['count']=$coustomer_count+1;
$this->db->update('coustomer_code',$main_data,array('id'=>$coustomer_code_id));
}
else {
 $customer_infop['code_discount_key'] =2; 
  $customer_infop['discount_code'] =0;;
    $customer_infop['txt'] ="لقد تم تخطى الحد المسموح بيه فى استخدام الكود";
    if($final_price>$sql_discount&&$sql_discount!=""){
 $customer_infop['final_price'] =$sql_discount-round(($sql_discount*$code_discount)/100);}
else { $customer_infop['final_price']  =$final_price-round(($final_price*$code_discount)/100);}    
}



}
else {
 $customer_infop['code_discount_key'] =1; 
 $customer_infop['txt'] ="تم استخدام كود الخصم بنجاح ";
 $customer_infop['discount_code'] =$code_discount;
 if($final_price>$sql_discount&&$sql_discount!=""){
 $customer_infop['final_price'] =$sql_discount-round(($sql_discount*$code_discount)/100);}
else { $customer_infop['final_price']  =$final_price-round(($final_price*$code_discount)/100);}
$main_data['count']=1;
$main_data['id_customer']=$customer_id;
$main_data['id_code']=$code_id;
$this->db->insert('coustomer_code',$main_data);   
}



 }
   /************First Codition*****************************/     
      
      
      
  
  
  /************if error in code*****************************/
  else {
 $customer_infop['code_discount_key'] =3;     
      $customer_infop['discount_code'] =0;;
 $customer_infop['txt'] ="كود الخصم غير صالح للاستخدام";
  if($final_price>$sql_discount&&$sql_discount!=""){ $customer_infop['final_price'] =(int)$final_price;}
else {$customer_infop['final_price']  =(int)$final_price;}
  }
   /************end if error in code*****************************/
}

else {
 $customer_infop['code_discount_key'] =0;     
 $customer_infop['txt'] ="";
  if($sql_price>$sql_discount&&$sql_discount!=""&&$sql_discount!=0){ $customer_infop['final_price'] =(int)$sql_discount;}
else {$customer_infop['final_price']  =(int)$sql_price;}    
}
$data['customer_info']= $customer_infop;
$this->api_return([
'message' => lang('Operation completed successfully'),
'errNum' => 405,
'status' => true,
"result" => $data
],200);








}

else {
$data['notifications_num'] = "";
$this->api_return([
'message' => lang('Customer ID notcorrect'),
'errNum' =>402,
'status' => false
],200);
}
               
}
	
}


}

