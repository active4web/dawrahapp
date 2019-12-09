<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Login extends MX_Controller {
    function __construct() {

		parent::__construct();
        $this->load->library('session');
		$this->load->model('data','','true');
          $this->load->library('pagination');
          $this->load->library('lib_pagination'); 
		@date_default_timezone_set('Asia/Riyadh');
    }


    
    
    
    public function index(){
 if($this->session->userdata("customer_id")!=""){
redirect(base_url()."user");
      }
else {
  $data['site_info'] =$this->db->get_where('site_info')->result(); 
  $this->load->view("index/include/head",$data );
  $this->load->view("index/include/header",$data );
  $this->load->view('login',$data);
  $this->load->view("index/include/footer",$data);
}

}

public function terms(){
$user_type=$this->uri->segment(3);
	if($this->session->userdata("customer_id")!=""){
 redirect(base_url()."user");
			 }
 else {
	 $data['site_info'] =$this->db->get_where('site_info')->result(); 
	 $data['pages'] =$this->db->get_where('pages',array("flag"=>$user_type,'key_txt'=>"terms"))->result(); 
	 $this->load->view("index/include/head",$data );
	 $this->load->view("index/include/header",$data );
	 $this->load->view('terms',$data);
	 $this->load->view("index/include/footer",$data);
 }
 
 }


    public function login_action() {

          $user_type = $this->security->sanitize_filename($this->input->post('user_type'),true);
          $phone = $this->security->sanitize_filename($this->input->post('phone'),true);
          $password = $this->security->sanitize_filename($this->input->post('password'),true);
          $passwordp=md5($password);
          $customer_id="";
      $customer_id = $this->data->get_table_row('customers',array('phone'=>$phone,'password'=>$passwordp,'status'=>$user_type),'id');
          if($customer_id != ""){
            $view =$this->data->get_table_row('customers',array('id'=>$customer_id),'view');
if($view==1){
          $username =$this->data->get_table_row('customers',array('id'=>$customer_id),'user_name');
          $type =$this->data->get_table_row('customers',array('id'=>$customer_id),'status');
          $email =$this->data->get_table_row('customers',array('id'=>$customer_id),'email');
					$myimg =$this->data->get_table_row('customers',array('id'=>$customer_id),'img');
          $this->session->set_userdata(array('customer_id' => $customer_id));
          $this->session->set_userdata(array('admin_email' => $email));
          $this->session->set_userdata(array('admin_name' => $username));
          $this->session->set_userdata(array('admin_phone' => $phone));
          $this->session->set_userdata(array('user_type' => $type));
          $this->session->set_userdata(array('myimg' => $myimg));
          echo 1;
}
else {echo 2;}
          
          }
          else {
            echo 3;
          }    
      

    }
 
    
    

}


