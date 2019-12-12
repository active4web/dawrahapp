<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Credit extends CI_Controller {

	public function my_credit($id=null){
		$data['body_class'] = 'vendor-template balance page-template';
		$data['title'] = 'رصيدي';
		$data['merchant_data'] = $this->session->userdata('merchant_data');
		$data['credit'] = get_this('settings',['id'=>1],'min_balance');
		if (empty($data['merchant_data'])) {
			redirect('site_user/login');
		}else{
			$data['merchant_credit'] = get_this('merchants',['id'=>$data['merchant_data']['id']],'credit');
				$this->form_validation->set_rules('quantity','الرساله','trim|required|numeric');
				if ($this->input->server('REQUEST_METHOD') === 'POST') {
					if ($this->form_validation->run()) {
						if ($data['merchant_credit'] < $data['credit']) {
							$this->session->set_flashdata('message',notify('عفوا رصيدكم الحالي لا يسمح باجراء عملية السحب','danger'));
							redirect($_SERVER['HTTP_REFERER']);
						}else{
							if ($this->input->post('quantity') < $data['credit']) {
								$this->session->set_flashdata('message',notify('عفوا لا يمكن سحب الرصيد فيجب ان تكون القيمه المسحوبة اعلى من الحد الادني لسحب الرصيد','danger'));
							}elseif ($this->input->post('quantity') > $data['merchant_credit']) {
								$this->session->set_flashdata('message',notify('عفوا رصيدكم الحالي لا يسمح لاتمام عملية السحب','danger'));	
							}else{
								if (get_this('withdraw_balance_requsets',['merchant_id'=>$data['merchant_data']['id'],'status'=>0])) {
									$this->session->set_flashdata('message',notify('عفوا لايمكن اتمام العمليه فلديك طلبات سحب سابقة لم يتم الموافقة عليها','danger'));
									redirect($_SERVER['HTTP_REFERER']);
								}
								$store = [
	 										'merchant_id' => $data['merchant_data']['id'],
	                                        'quantity'    => $this->input->post('quantity'),
	                                        'status'      => 0,
	                                        'created_at'  => date('Y-m-d')
										 ];
								$this->Main_model->insert('withdraw_balance_requsets',$store);		 
								$this->session->set_flashdata('message',notify('تم ارسال طلب سحي الرصيد بنجاح','success'));	
							}
						}
		            }
				}

			
			$data['main_content'] = 'site_merchant/credit/credit';
			$this->load->view('site_user/blank',$data);
		}
	}

}

