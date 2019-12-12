<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets_types extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if (!$this->session->has_userdata('login_data'))
            redirect('admin_panel/login'); 
	}
	public function index()
	{
        $data['title'] = 'انواع التذاكر';
        $data['tickets_types'] = get_table('tickets_types');
		$data['main_content'] = 'admin_panel/tickets_types/list';
		$this->load->view('admin_panel/blank',$data);
    }
    public function add(){
        $data['title'] = 'اضافة نوع تذاكر جديد';
        $this->form_validation->set_rules('name','اسم النوع','trim|required');
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			if ($this->form_validation->run()) {
				$store = $this->input->post();
				$store['created_at'] = date('Y-m-d');
				$insert = $this->Main_model->insert('tickets_types',$store);
				if ($insert) {
					$this->session->set_flashdata('message',notify('تمت اضافة النوع بنجاح','success'));	
					redirect('admin_panel/tickets_types');
				}
            }
		}
		$data['main_content'] = 'admin_panel/tickets_types/add';
		$this->load->view('admin_panel/blank',$data);
    }
    public function edit($id){
		$data['title'] = 'تعديل النوع ';
		$data['type'] = get_this('tickets_types',['id'=>$id]);
        $this->form_validation->set_rules('name','اسم النوع','trim|required');
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			if ($this->form_validation->run()) {
				$store = $this->input->post();
				$store['updated_at'] = date('Y-m-d');
				if ($this->Main_model->update('tickets_types',['id'=>$id],$store)) {
					$this->session->set_flashdata('message',notify('تم تعديل بيانات النوع بنجاج','success'));
					redirect('admin_panel/tickets_types');
				}
			}
		}
		$data['main_content'] = 'admin_panel/tickets_types/edit';
		$this->load->view('admin_panel/blank',$data);
	}
    public function delete($id){
		if ($id) {
			$this->db->where('id',$id)->delete('tickets_types');
			$this->session->set_flashdata('message',notify('تم حذف النوع بنجاح','success'));
			redirect('admin_panel/tickets_types');
		}
	}
}
