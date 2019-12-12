<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cities extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if (!$this->session->has_userdata('login_data'))
            redirect('admin_panel/login'); 
	}
	public function index()
	{
        $data['title'] = 'المدن';
        $data['cities'] = get_table('cities');
		$data['main_content'] = 'admin_panel/cities/list';
		$this->load->view('admin_panel/blank',$data);
    }
    public function add(){
        $data['title'] = 'اضافة مدينة جديدة';
        $data['countries'] = get_table('countries');
        $this->form_validation->set_rules('name','اسم المدينة','trim|required');
        $this->form_validation->set_rules('country_id','اسم المدينة','trim|required|numeric');
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			if ($this->form_validation->run()) {
				$store = $this->input->post();
				$store['created_at'] = date('Y-m-d');
				$insert = $this->Main_model->insert('cities',$store);
				if ($insert) {
					$this->session->set_flashdata('message',notify('تمت اضافة المدينة بنجاح','success'));	
					redirect('admin_panel/cities');
				}
            }
		}
		$data['main_content'] = 'admin_panel/cities/add';
		$this->load->view('admin_panel/blank',$data);
    }
    public function edit($id){
		$data['title'] = 'تعديل المدينة';
		$data['city'] = get_this('cities',['id'=>$id]);
		$data['countries'] = get_table('countries');
        $this->form_validation->set_rules('name','اسم المدينة','trim|required');
        $this->form_validation->set_rules('country_id','اسم المدينة','trim|required|numeric');
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			if ($this->form_validation->run()) {
				$store = $this->input->post();
				$store['updated_at'] = date('Y-m-d');
				if ($this->Main_model->update('cities',['id'=>$id],$store)) {
					$this->session->set_flashdata('message',notify('تم تعديل بيانات المدينة بنجاج','success'));
					redirect('admin_panel/cities');
				}
			}
		}
		$data['main_content'] = 'admin_panel/cities/edit';
		$this->load->view('admin_panel/blank',$data);
	}
    public function delete($id){
		if ($id) {
			$this->db->where('id',$id)->delete('cities');
			$this->session->set_flashdata('message',notify('تم حذف المدينة بنجاح','success'));
			redirect('admin_panel/cities');
		}
	}
}
