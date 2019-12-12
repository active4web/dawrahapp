<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Withdraw_balance extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if (!$this->session->has_userdata('login_data'))
            redirect('admin_panel/login'); 
	}
	public function index()
	{
        $data['title'] = 'طلبات سحب الرصيد';
        $data['requests'] = get_table('withdraw_balance_requsets');
		$data['main_content'] = 'admin_panel/withdraw_balance/list';
		$this->load->view('admin_panel/blank',$data);
    }
    public function accept($id){
		$data['request'] = get_this('withdraw_balance_requsets',['id'=>$id, 'status'=>0]);
		if ($data['request']) {
			$data['merchant'] = get_this('merchants',['id'=>$data['request']['merchant_id']]);
			# merchant old credit
			$merchant_credit =  $data['merchant']['credit'];
			# balance merchant want to withdraw
			$quantity = $data['request']['quantity'];
			# merchant new credit
			$credit =  $merchant_credit - $quantity;
			$this->Main_model->update('merchants',['id'=>$data['merchant']['id']],['credit'=>$credit]);
			$this->Main_model->update('withdraw_balance_requsets',['id'=>$data['request']['id']],['status'=>1]);
			$this->session->set_flashdata('message',notify('تمت الموافقه على طلب سحب الرصيد وخصم الكمية من رصيد التاجر ورصيد التاجر الحالي هو '.$credit.' '.'ريال','success'));
			redirect('admin_panel/withdraw_balance');
		} 
	}
    public function delete($id){
		if ($id) {
			$this->db->where('id',$id)->delete('cities');
			$this->session->set_flashdata('message',notify('تم حذف المدينة بنجاح','success'));
			redirect('admin_panel/cities');
		}
	}
}
