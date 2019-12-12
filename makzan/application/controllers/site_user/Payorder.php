<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payorder extends CI_Controller {
	
	private $merchant_email = 'Muath440@gmail.com';
    private $secret_key     = 'wCmoQoeFoKFEO7jOsRACKIclBLwcrjyYWUmNiAtHl8l9gEXIwxlhgxCSi94KsDIpx5cQGFx1NSb4x8M4G7lXFXPY6UIzxrY5xaVd';

	public function merchant_email($merchant_email) { 
        $this->merchant_email = $merchant_email;
		return $this->merchant_email;
    }
	
	public function secret_key($secret_key) { 
        $this->secret_key = $secret_key;
		return $this->secret_key;
    }
	
	public function index(){
	$params = ['merchant_email'=>$this->merchant_email,'secret_key'=>$this->secret_key];
    $this->load->library('pay_orders',$params);
	$values = array(
		"merchant_email" => $this->merchant_email,
		'secret_Key' => $this->secret_key,
		'title' => "Islam Mohamed",
		'cc_first_name' => "Islam",
		'cc_last_name' => "Mohamed",
		'email' => "islam.devphp@gmail.com",
		'cc_phone_number' => "966",
		'phone_number' => "33333333",
		'billing_address' => "Juffair, Manama, Bahrain",
		'city' => "Manama",
		'state' => "Capital",
		'postal_code' => "97300",
		'country' => "SAU",
		'address_shipping' => "Juffair, Manama, Bahrain",
		'city_shipping' => "Manama",
		'state_shipping' => "Capital",
		'postal_code_shipping' => "97300",
		'country_shipping' => "SAU",
		"products_per_title"=>"MobilePhone || Charger || Camera",
		"unit_price"=>"120.00 || 20.00 || 35.00",
		'quantity' => "1 || 2 || 1",
		'amount' => "195.00",
		'currency' => "SAR",
		'other_charges' => "0",
		'discount'=>"0",
		"msg_lang" => "Arabic",
		"reference_no" => "FC123123d1",
		"site_url" => "https://play.google.com/store/apps/details?id=com.makhzan.app",
		'return_url' => base_url()."site_user/payorder/verify_order",
		"cms_with_version" => "API USING PHP"
		);
		$response= $this->pay_orders->create_pay_page($values);
		if(isset($_SESSION['payment_reference'])){
			unset($_SESSION['payment_reference']);
		}
		$this->session->set_userdata(array('payment_reference' =>$response->p_id));
		redirect($response->payment_url);
		//print_r($this->session->userdata); 
		/*echo "<pre>";print_r($response);echo "</pre>";*/
	}
	
	public function checkout($data){
	$params = ['merchant_email'=>$this->merchant_email,'secret_key'=>$this->secret_key];
    $this->load->library('pay_orders',$params);
	$values = array(
		"merchant_email" => $this->merchant_email,
		'secret_Key' => $this->secret_key,
		'title' => $data['title'],
		'cc_first_name' => $data['cc_first_name'],
		'cc_last_name' => $data['cc_last_name'],
		'email' => $data['email'],
		'cc_phone_number' => "966",
		'phone_number' => "33333333",
		'billing_address' => $data['billing_address'],
		'city' => "Manama",
		'state' => "Capital",
		'postal_code' => "97300",
		'country' => "SAU",
		'address_shipping' => $data['address_shipping'],
		'city_shipping' => "Manama",
		'state_shipping' => "Capital",
		'postal_code_shipping' => "97300",
		'country_shipping' => "SAU",
		"products_per_title"=>"MobilePhone || Charger || Camera",
		"unit_price"=>"120.00 || 20.00 || 35.00",
		'quantity' => "1 || 2 || 1",
		'amount' => "195.00",
		'currency' => "SAR",
		'other_charges' => "0",
		'discount'=>"0",
		"msg_lang" => "Arabic",
		"reference_no" => "FC123123d1",
		"site_url" => "https://play.google.com/store/apps/details?id=com.makhzan.app",
		'return_url' => base_url()."site_user/payorder/verify_order",
		"cms_with_version" => "PHP"
		);
		$response= $this->pay_orders->create_pay_page($values);
		if(isset($_SESSION['payment_reference'])){
			unset($_SESSION['payment_reference']);
		}
		$this->session->set_userdata(array('payment_reference' =>$response->p_id));
		redirect($response->payment_url);
		//print_r($this->session->userdata); 
		/*echo "<pre>";print_r($response);echo "</pre>";*/
	}
	
	public function verify_order(){
		//echo $_SESSION['payment_reference'];die;
		$params = ['merchant_email'=>$this->merchant_email,'secret_key'=>$this->secret_key];
		$this->load->library('pay_orders',$params);
		$payment_reference = $_SESSION['payment_reference'];
		$values = ['payment_reference'=>$payment_reference];
		$response= $this->pay_orders->verify_payment($values); 
		
		/*echo "<pre>";
		print_r($response);
		echo "</pre>";*/
	}
	
	}
?>