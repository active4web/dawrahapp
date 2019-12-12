<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News_letter extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if (!$this->session->has_userdata('login_data'))
            redirect('admin_panel/login'); 
	}
	public function index()
	{
        $data['title'] = 'مشتركي القائمة البريدية';
        $data['news_letter'] = get_table('news_letter');
		$data['main_content'] = 'admin_panel/news_letter/list';
		$this->load->view('admin_panel/blank',$data);
    }
    public function send($id){
		$data['title'] = 'ارسال رساله';
		$data['email'] = get_this('news_letter',['id'=>$id],'email');
        $this->form_validation->set_rules('title','العنوان','trim|required');
        $this->form_validation->set_rules('content','الرسالة','trim|required');
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			if ($this->form_validation->run()) {
				$this->load->library('email');
				$subject = $this->input->post('title');
				$message = $this->input->post('content');
				$result = $this->email->from(get_this('settings',['id'=>1],'email'), 'مخزن')
    						   ->to($data['email'])
    						   ->subject($subject)
    						   ->message($message)
    						   ->send();
                /*$this->email->from(get_this('settings',['id'=>1],'email'), 'مخزن');
                $this->email->to($data['email']);
                $this->email->subject($this->input->post('title'));
                $this->email->message($this->input->post('content'));  
                $this->email->send();*/
                redirect('admin_panel/news_letter');
			}
		}
		$data['main_content'] = 'admin_panel/news_letter/send';
		$this->load->view('admin_panel/blank',$data);
	}
    public function delete($id){
		if ($id) {
			$this->db->where('id',$id)->delete('news_letter');
			$this->session->set_flashdata('message',notify('تم حذف الصفحة بنجاح','success'));
			redirect('admin_panel/news_letter');
		}
	}
}
