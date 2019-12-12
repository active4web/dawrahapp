<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		if (!$this->session->has_userdata('login_data'))
            redirect('admin_panel/login'); 
	}
	public function index($status_id=null, $type=null){
        if($type == 0){
           $data['title'] = 'تذاكر التجار';
        }else{
           $data['title'] = 'تذاكر العملاء';
        }
        $data['tickets'] = get_table('tickets',['type'=>$type, 'status_id'=>$status_id],['id','DESC']);
		$data['main_content'] = 'admin_panel/tickets/list';
		$this->load->view('admin_panel/blank',$data);
    }
    public function reply($id){
    	$data['title'] = 'التاجر';
    	$data['ticket'] = get_this('tickets',['id'=>$id]);
        $data['ticket_type'] = get_this('tickets_types',['id'=>$data['ticket']['ticket_type_id']],'name');
    	$data['ticket_replys'] = get_table('tickets_replies',['ticket_id'=>$id]);
        $data['replys_conut'] = get_table('tickets_replies',['ticket_id'=>$id],'count');
        $this->form_validation->set_rules('content','الرد','trim|required');
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            if ($this->form_validation->run()) {
                $store = $this->input->post();
                $store['created_at'] = date('Y-m-d');
                $store['time'] = date('h:i:s');
                $store['ticket_id'] = $id;
                $store['reply_type'] = 2;
                $insert = $this->Main_model->insert('tickets_replies',$store);
                if ($insert) {
                    $this->session->set_flashdata('message',notify('تم ارسال الرد بنجاح','success'));    
                    redirect('admin_panel/tickets/reply/'.$id);
                }
            }
        }
    	$data['main_content'] = 'admin_panel/tickets/reply';
		$this->load->view('admin_panel/blank',$data);

    }
}
