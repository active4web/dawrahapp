<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {
		
	public function index(){
		$data['body_class'] = 'login page-template';
		$data['title'] = 'سجل الطلبات';
		$data['merchant_data'] = $this->session->userdata('merchant_data');
		if (!$this->session->userdata('merchant_data')) {
			redirect('home');
		}
		else{
			//https://www.codeigniter.com/userguide3/database/query_builder.html#limiting-or-counting-results
			//$query = $this->db->query("SELECT * FROM sub_orders WHERE (status_id != 4 AND status_id != 5 ) AND merchant_id = ".$data['merchant_data']['id']."");
			//$data['comletet_orders'] = $query->result();
			//echo $this->db->last_query();die;
			$query = $this->db->select('*, sub_orders.id as order_item')->from('sub_orders')
												->join('main_orders', 'main_orders.id = sub_orders.main_order_id')
												->group_start()
												->where('status_id !=',4)
												->where('status_id !=',5)
												->group_end()
												->where('merchant_id',$data['merchant_data']['id'])
												->where('main_orders.confirmation_status',2)
												->get();
			//echo $this->db->last_query();die;
			$data['processing_orders'] = $query->result();
			$data['comletet_orders'] = get_table('sub_orders',['merchant_id'=>$data['merchant_data']['id'],'status_id'=>4]);
			$data['rejected_orders'] = get_table('sub_orders',['merchant_id'=>$data['merchant_data']['id'],'status_id'=>5]);
			$data['main_content'] = 'site_merchant/orders/list';
			//print_r($data);die;
			$this->load->view('site_user/blank',$data);
		}
		
	}
	
	public function json($status,$msg=[]){
	$data['status'] = $status;
	$data['msg'] = $msg;
	echo json_encode($data);
	}
		
	public function order_details($id){
			$data['body_class'] = 'vendor-template page-template';
			$data['title'] = 'تفاصيل الطلب';
			$data['merchant_data'] = $this->session->userdata('merchant_data');
			if (!$this->session->userdata('merchant_data')) {
				redirect('home');
			}
			else{
				$data['items'] = get_table('order_items',['sub_order_id'=>$id]);
				$data['order_details'] = get_table('sub_orders',['merchant_id'=>$data['merchant_data']['id'],'id'=>$id]);
				/*echo "<pre>";
				print_r($data);
				echo "</pre>";
				die;
				*/
				$data['main_content'] = 'site_merchant/orders/details';
				$this->load->view('site_user/blank',$data);
			}
	}
	public function change_order_status(){
		$id = $this->input->post('id');
		$order_id = $this->input->post('order_id');
		$data = ['status_id' =>$id];
		$result = $this->Main_model->update('sub_orders',['id'=>$order_id],$data);
		if($result){
			return $this->json(true, 'تم التحويل بنجاح');
		}else{
			return $this->json(false, 'لم يتم التحويل');
		}
	}
	
}

