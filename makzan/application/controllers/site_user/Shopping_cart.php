<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Shopping_cart extends CI_Controller {

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
	 ///Real Account
	///private $merchant_email = 'muath440@gmail.com';
    ///private $secret_key     = 'wCmoQoeFoKFEO7jOsRACKIclBLwcrjyYWUmNiAtHl8l9gEXIwxlhgxCSi94KsDIpx5cQGFx1NSb4x8M4G7lXFXPY6UIzxrY5xaVd';
	
	///Test Acount
	private $merchant_email = 'muath440@gmail.com';
    private $secret_key     = 'wCmoQoeFoKFEO7jOsRACKIclBLwcrjyYWUmNiAtHl8l9gEXIwxlhgxCSi94KsDIpx5cQGFx1NSb4x8M4G7lXFXPY6UIzxrY5xaVd';

	public function merchant_email($merchant_email) { 
        $this->merchant_email = $merchant_email;
		return $this->merchant_email;
    }
	
	public function secret_key($secret_key) { 
        $this->secret_key = $secret_key;
		return $this->secret_key;
    }
	
	public function json($status,$msg=[]){
		$data['status'] = $status;
		$data['msg'] = $msg;
		echo json_encode($data);
	}
	
	public function add_to_cart(){
		$data['user_data'] = $this->session->userdata('user_data');
		if (empty($data['user_data'])) {
			redirect('site_user/login');
		}else{
			$store = [
						'id'    => $this->input->post('product_id'), 
						'name'  => $this->input->post('product_name'), 
						'price' => $this->input->post('product_price'), 
						'qty'   => $this->input->post('quantity'), 
						'product_owner'   => $this->input->post('product_owner'), 
					 ];
			$this->cart->insert($store);
		}
	}
	
	public function gen_random_string()
	{
	$chars ="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";//length:36
	$final_rand='';
	for($i=0;$i<4; $i++) {
	 $final_rand .= $chars[ rand(0,strlen($chars)-1)];
		}
	return $final_rand;
	}
	
	function show_cart(){ 
		$data['user_data'] = $this->session->userdata('user_data');
		$data['body_class'] = 'cart page-template';
		$data['title'] = 'سلة الشراء';
		if (empty($data['user_data'])) {
			redirect('site_user/login');
		}else{
			$data['user_data'] = $this->session->userdata('user_data');
			$all = $this->cart->contents();
			
			//echo"<pre>";
			//print_r($all);
			//$gg = $all['1f0e3dad99908345f7439f8ffabdffc4'];
			//print_r($gg);
			//echo $gg['subtotal'];
			//die;
			//echo"</pre>";
			
			$dic = [];
			foreach ($all as $val) {
				if (array_key_exists($val['product_owner'], $dic)) {
				    array_push($dic[$val['product_owner']], $val);
				}else{
					$dic[$val['product_owner']] = [$val];
				}
			}
			// print_r($dic);exit;
			// print_r(array_values($all));exit;
			$data['cart_contents'] = $dic;
			$data['bank_accounts'] = get_table('bank_accounts',[]);
			$data['sub_total'] = $this->cart->total();
			$data['tax'] = get_this('settings',['id'=>1],'tax')/100;
			$data['total'] = $data['tax'] + $data['sub_total'] ;
			$data['main_content'] = 'site_user/cart/contents';
			$this->load->view('site_user/blank',$data);
		}
	}
	
	function update_item(){
		$rowid = $this->input->post('rowid');
		$qty = $this->input->post('qty');
		$data = array(
        'rowid' => $rowid,
        'qty'   => $qty
		);
		if($qty==0 || $qty==''){
			return $this->json(false,'عفوا كمية المنتج يجب أن لاتقل عن 1');
		}else{
			$this->cart->update($data);
			return $this->json(true,'تم تحديث الكمية');
		}
	}
	
	function get_subtotal(){
		$rowid = $this->input->post('rowid');
		$cart = $this->cart->contents();
		$subtotal = $cart[$rowid];
		$total = $subtotal['subtotal'];
		if($total){
			return $this->json(true,$total);
		}else{
			return $this->json(false,0);
		}
	}
	
	function delete_cart(){ 
		$data['user_data'] = $this->session->userdata('user_data');
		if (empty($data['user_data'])) {
			redirect('site_user/login');
		}else{
			$data = [
						'rowid' => $this->input->post('row_id'), 
						'qty' => 0, 
					];
			$this->cart->update($data);
			// $this->session->set_flashdata('message',notify('تم حذف المنتج بنجاح','success'));
		}
	}
	
	function get_sub_total(){
		$id = $this->input->post('id');
		$all = $this->cart->contents();
		$total=0;
		foreach ($all as $key => $val) {
			//print_r($val);
		   if ($val['product_owner'] == $id) {
			  //echo "<pre>";
			  //print_r($val);
			  //echo "</pre>";
			  $total+= $val['subtotal'];
		   }
		   
	   }
	    $result = $total;
	    if($result){
			return $this->json(true,$result);
		}else{
			return $this->json(false,0);
		}
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
		'phone_number' => $data['phone_number'],
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
		"products_per_title"=>$data['products_per_title'],
		"unit_price"=>$data['unit_price'],
		'quantity' =>$data['quantity'],
		'amount' => $data['amount'],
		'currency' => "SAR",
		'other_charges' => $data['other_charges'],
		'discount'=>"0",
		"msg_lang" => "Arabic",
		"reference_no" => "RC-".$this->gen_random_string(),
		"site_url" => "https://makzan.com.sa",
		'return_url' => base_url()."site_user/Shopping_cart/verify_order",
		"cms_with_version" => "PHP"
		);
		//echo "<pre>";print_r($values);/*print_r($this->session->userdata);*/ echo "</pre>";
		$response= $this->pay_orders->create_pay_page($values);
		if(isset($_SESSION['payment_reference'])){
			unset($_SESSION['payment_reference']);
		}
		$this->session->set_userdata(array('payment_reference' =>$response->p_id));
		/*echo "<pre>";print_r($response);
		print_r($this->session->userdata);
		echo "</pre>";
		die;*/
		//Insert Transaction Order As First ::
		$transactions = ['main_order_id' => $_SESSION['payment_mainorder_id'],'pt_invoice_id' => $_SESSION['payment_reference']];
		$insert = $this->Main_model->insert('transactions_orders',$transactions);
		$this->cart->destroy();
		redirect($response->payment_url);
		//print_r($this->session->userdata); 
	}
	
	public function verify_order(){
		//echo $_SESSION['payment_reference'];die;
		$params = ['merchant_email'=>$this->merchant_email,'secret_key'=>$this->secret_key];
		$this->load->library('pay_orders',$params);
		$payment_reference = $_SESSION['payment_reference'];
		$values = ['payment_reference'=>$payment_reference];
		$response= $this->pay_orders->verify_payment($values);
		$transactions = [
			'result' => $response->result,
			'response_code' => $response->response_code,
			'amount' => $response->amount,
			'currency' => $response->currency,
			'reference_no' => $response->reference_no,
			'transaction_id' => $response->transaction_id,
		];
		$this->Main_model->update('transactions_orders',['main_order_id'=>$_SESSION['payment_mainorder_id']],$transactions);
		if($response->response_code==100){
			$payment_status = ['payment_status'=>1];
			$this->Main_model->update('main_orders',['id'=>$_SESSION['payment_mainorder_id']],$payment_status);
		}
		$this->finished();
	}
	
	function order_total(){
		$data = $this->input->post();
		$user['user_data'] = $this->session->userdata('user_data');
		$data['merchant_id'] = $this->input->post('merchant_id');
		$data['sub_total'] = $this->input->post('sub_total');
		$data['total'] = $this->input->post('total');
		$data['final_total'] = $this->input->post('final_total');
		$data['address'] = $this->input->post('address');
		$data['payment_method_id'] = $this->input->post('payment_method_id');
		$data['customer_id'] = $user['user_data']['id'];
		$data['tax'] = get_this('settings',['id'=>1],'tax');
		$data['rate'] = get_this('settings',['id'=>1],'app_balance');
		$data['products'] = $this->cart->contents();
		
		$data['transfer_name'] = $this->input->post('transfer_name');
		$data['money_transfered'] = $this->input->post('money_transfered');
		$data['transfer_type'] = $this->input->post('transfer_type');
		
		//echo $data['payment_method_id'];die;
		if($data['payment_method_id']==1){$data['payment_status'] = 0;}else{$data['payment_status'] = '';}
		
			
		if($data){
			if($this->input->post('payment_method_id')!=1){
				if(($this->input->post('transfer_name')=='') || ($this->input->post('money_transfered')=='') || ($this->input->post('transfer_type')==''))
				{
					$this->session->set_flashdata('message',notify('يرجي إستكمال باقي بيانات التحويل','danger'));
					redirect('site_user/shopping_cart/show_cart');
				}
			}
		///////////////////////////////////////////////////////////////////////////////////////////
		//Insert Main Order
		$main_order = [
				'customer_id'  => $data['customer_id'],
				'total' 	   => $data['final_total'],
				'address' 	   => $data['address'],
				'confirmation_status' => '',
				'payment_method_id' => $data['payment_method_id'],
				'payment_status' => $data['payment_status'],
				'transfer_name' => $data['transfer_name'],
				'money_transfered' => $data['money_transfered'],
				'transfer_type' => $data['transfer_type'],
				'transfer_date' => date('Y-m-d'),
				'created_at' => date('Y-m-d')
				];
			
		/*echo "<pre>";
		print_r($main_order);
		echo "</pre>";
		$main_order_id ="333333333";
		$sub_order_id  ="222222222";*/
		
		/**/$insert = $this->Main_model->insert('main_orders',$main_order);
		$main_order_id = $this->db->insert_id();
		if(isset($_SESSION['payment_mainorder_id'])){
			unset($_SESSION['payment_mainorder_id']);
		}
		$this->session->set_userdata(array('payment_mainorder_id' =>$main_order_id));
		///////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////
		//Insert sub Orders
		foreach($data['merchant_id'] as $key => $value){
			//echo $value;
			$sub_orders = [
				'main_order_id'  => $main_order_id,
				'merchant_id' 	 => $value,
				'customer_id' 	 => $data['customer_id'],
				'created_at' => date('Y-m-d'),
				'sub_total' => $data['sub_total'][$value],
				'total' => $data['total'][$value],
				'delivering_method_id' => $data['delivering_method'][$value],
				'delivering_method_price' => $this->input->post('delivering_'.$value),
				'tax' => $this->input->post('tax_'.$value),
				'rate' => $data['rate'],
				'status_id' => 1
				];
			/*echo "<pre style='color:green'>";
			print_r($sub_orders);
			echo "</pre>";*/
			/////////////////////////////////////////////////////////////////////////////////////////
			/////Add Balance To Merchant After Order
			$app_balance = get_this('settings',['id'=>1],'app_balance');
			$merchant_balance = get_this('merchants',['id'=>$value],'credit');
			$rate = $data['total'][$value] * $app_balance / 100;
			$new_balance = $data['total'][$value] - $rate;
			$result = $merchant_balance + $new_balance;
			$rows = ['credit' => $result];
			$this->Main_model->update('merchants',['id'=>$value],$rows);
			/////////////////////////////////////////////////////////////////////////////////////////
			$insert = $this->Main_model->insert('sub_orders',$sub_orders);
			$sub_order_id = $this->db->insert_id();
		///////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////
		//Insert Products
		foreach ($data['products'] as $key => $val) {
			if ($val['product_owner'] == $value) {
				$order_items = [
					'product_id'  => $val['id'],
					'product_name' 	 => $val['name'] ,
					'product_color' 	 => '',
					'product_price' => $val['price'],
					'main_order_id' => $main_order_id,
					'sub_order_id' => $sub_order_id,
					'quantity' => $val['qty'],
					'total' => $val['subtotal']
					];
			/*echo "<pre style='color:red'>";
			print_r($order_items);
			echo "</pre>";*/
			/////////////////////////////////////////////////////////////////////////////////////////
			///Update Quantity In Product After Order
			$available_quantity = get_this('products',['id'=>$val['id']],'available_quantity');
			$new_quantity = $available_quantity - $val['qty'];
			$rows = ['available_quantity' => $new_quantity];
			$this->Main_model->update('products',['id'=>$val['id']],$rows);
			/////////////////////////////////////////////////////////////////////////////////////////
			
			$insert = $this->Main_model->insert('order_items',$order_items);
			   }
			}
		///////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////
		}
		///////////////////////////////////////////////////////////////////////////////////////////
		//CheckOut AND Payment Action
		$i=0;
		foreach ($data['products'] as $key => $val) {
			$i++;
			$counter = count($data['products']);
			if($i<$counter){$seperator = " || ";}else{$seperator = "";};
			@$names.= $val['name'].$seperator;
			@$prices.= $val['price'].'.00'.$seperator;
			@$quantitys.= $val['qty'].$seperator;
		}

		$data['products_per_title'] = $names;
		$data['unit_price'] = $prices;
		$data['quantity'] = $quantitys;
		
		foreach($data['merchant_id'] as $key => $value){
			$delivering_method_price = $this->input->post('delivering_'.$value);
			$taxs = $this->input->post('tax_'.$value);
			@$sum+= $delivering_method_price;
			@$taxx+= $taxs;
		}
		
		$count_tax = $taxx;
		$data['other_charges'] = $sum+$count_tax;

		$values = [
			'title'=>$user['user_data']['full_name'],
			'cc_first_name'=>$user['user_data']['full_name'],
			'cc_last_name'=>$user['user_data']['full_name'],
			'email'=>$user['user_data']['email'],
			'phone_number'=>$user['user_data']['phone'],
			'billing_address'=>$data['address'],
			'address_shipping'=>$data['address'],
			'products_per_title'=>$data['products_per_title'],
			'unit_price'=>$data['unit_price'],
			'quantity'=>$data['quantity'],
			'amount'=>$data['final_total'].'.00',
			'other_charges'=>$data['other_charges'].'.00'
			//'payment_method_id'=>$data['payment_method_id']
		];
		if($data['payment_method_id']==1){
			$this->cart->destroy();
			$this->checkout($values);
		}
		else{
			$this->cart->destroy();
			$this->finished();
		}
		/*echo "<pre style='color:blue'>";
		print_r($values);
		echo "</pre>";*/
		///////////////////////////////////////////////////////////////////////////////////////////
		}
	}
	
	public function finished(){
		$data['title'] = 'تسليم الطلب';
		$data['body_class'] = 'cart page-template';
		$data['main_content'] = 'site_user/cart/finished';
		$data['user_data'] = $this->session->userdata('user_data');
		if (empty($data['user_data'])) {
			redirect('site_user/login');
		}else{
			$this->session->set_flashdata('message',notify('تم إرسال طلبك بنجاح','success'));
			$this->load->view('site_user/blank',$data);
		}
	}

}

