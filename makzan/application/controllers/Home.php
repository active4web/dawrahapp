<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

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
	public function index()
	{
		$data['body_class'] = 'page singular page-template';
		$data['user_data'] = $this->session->userdata('user_data');
		$data['title'] = 'الرئيسية';
		$data['slider'] = get_table('slider');
		$data['categories'] = get_table('categories');
		$data['main_content'] = 'site_user/home';
		$this->load->view('site_user/blank',$data);
	}
	public function json($status,$type,$msg=[]){
		$data['status'] = $status;
		$data['msg'] = $msg;
		$data['type'] = $type;
		echo json_encode($data);
	}

	public function news_letter(){
        $this->form_validation->set_rules('email','البريد الالكتروني','trim|required|is_unique[news_letter.email]|valid_email');
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			if ($this->form_validation->run()) {
				$store = $this->input->post();
				$store['created_at'] = date('Y-m-d');
				$insert = $this->Main_model->insert('news_letter',$store);
				if ($insert) {
					// $result = $this->session->set_flashdata('news_letter',notify(,'success'));
					return $this->json(true,'success','تم الاشتراك في القائمة البريدية بنجاح');
				}
            }else{
            	// $result = $this->session->set_flashdata('news_letter',notify(validation_errors(),'danger'));
            	return $this->json(false,'danger',validation_errors());
            }
		}
	}
}
