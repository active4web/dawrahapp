<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tickets extends CI_Controller {

	public function index(){
		$data['body_class'] = 'new-ticket ticket-template page-template';
		$data['title'] = 'انشاء تذكرة جديدة';
		$data['merchant_data'] = $this->session->userdata('merchant_data');
		$data['tickets_types'] = get_table('tickets_types');
		if (empty($data['merchant_data'])) {
			redirect('site_user/login');
		}else{
			$this->form_validation->set_rules('content','الرساله','trim|required');
			$this->form_validation->set_rules('ticket_type_id','نوع التذكرة','trim|required');
			if ($this->input->server('REQUEST_METHOD') === 'POST') {
				if ($this->form_validation->run()) {
					$store = [
								'ticket_type_id' => $this->input->post('ticket_type_id'),
								'content'        => $this->input->post('content'),
								'created_by'     => $data['merchant_data']['id'],
								'type'           => 0,
								'status_id'      => 0,
								'created_at'     => date('Y-m-d')
							 ];
					$insert = $this->Main_model->insert('tickets',$store);
					if ($insert) {
						$this->session->set_flashdata('message',notify('تم الارسال بنجاح','success'));
						redirect('site_merchant/tickets');
					}
	            }
			}
			$data['main_content'] = 'site_merchant/tickets/new_ticket';
			$this->load->view('site_user/blank',$data);
		}
	}
	public function my_tickets($id = null){
		$data['merchant_data'] = $this->session->userdata('merchant_data');
		if (empty($data['merchant_data'])) {
			redirect('site_user/login');
		}else{
			$data['body_class'] = 'ticket ticket-template page-template';
			$data['title'] = 'تذاكري';
			$where['created_by'] = $data['merchant_data']['id'];
            $where['type'] = 0;
            $data['my_tickets'] = $this->db->order_by('created_at','DESC')
                                  		   ->get_where('tickets',$where)
                                  		   ->result();
			$data['main_content'] = 'site_merchant/tickets/my_tickets';
			$this->load->view('site_user/blank',$data);
		}
	}

	public function ticket($id){
		$data['merchant_data'] = $this->session->userdata('merchant_data');
		if (empty($data['merchant_data'])) {
			redirect('site_user/login');
		}else{
			$data['body_class'] = 'new-ticket ticket-template page-template';
			$data['title'] = 'التذاكر';
			$data['ticket'] = get_this('tickets',['id'=>$id,'created_by'=>$data['merchant_data']['id'],'type'=>0]);
			$data['ticket_type'] = get_this('tickets_types',['id'=>$data['ticket']['ticket_type_id']],'name');
			$data['ticket_replys'] = get_table('tickets_replies',['ticket_id'=>$id]);
			$data['ticket_replys_count'] = count($data['ticket_replys']);
			$data['main_content'] = 'site_merchant/tickets/ticket';
			$this->load->view('site_user/blank',$data);
		}
	}

	public function reply($id){
		$data['merchant_data'] = $this->session->userdata('merchant_data');
		if (empty($data['merchant_data'])) {
			redirect('site_user/login');
		}else{
			$this->form_validation->set_rules('reply','الرد','trim|required');
			if ($this->input->server('REQUEST_METHOD') === 'POST') {
				if ($this->form_validation->run()) {
					$store = [
								'ticket_id'  => $id,
								'created_by' => $data['merchant_data']['id'],
								'reply_type' => 0,
								'created_at' => date('Y-m-d'),
								'time'       => date('h:i:s'),
								'content'      =>$this->input->post('reply')
							 ];
					$insert = $this->Main_model->insert('tickets_replies',$store);
					$this->session->set_flashdata('message',notify('تم ارسال الرد بنجاح','success'));
					redirect('site_merchant/tickets/ticket/'.$id);		 
				}else{
					$this->session->set_flashdata('message',notify(validation_errors(),'danger'));
					redirect('site_user/tickets/ticket/'.$id);	

				}

			}

		}

	}



}

