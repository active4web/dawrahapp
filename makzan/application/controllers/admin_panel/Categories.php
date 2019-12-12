<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if (!$this->session->has_userdata('login_data'))
            redirect('admin_panel/login'); 
	}
	public function index()
	{
        $data['title'] = 'تصنيفات المنتجات';
        $data['categories'] = get_table('categories');
		$data['main_content'] = 'admin_panel/categories/list';
		$this->load->view('admin_panel/blank',$data);
    }
    public function add(){
        $data['title'] = 'اضافة تصنيف جديد';
        $this->form_validation->set_rules('name','اسم الدولة','trim|required');
        if (empty($_FILES['image']['name']))
            $this->form_validation->set_rules('image', 'صورة الاسلايد', 'required');
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			if ($this->form_validation->run()) {
				$_FILES['image']['name'];
                $config['upload_path'] = 'assets/uploads/files';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['file_name'] = $_FILES['image']['name'];
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                $this->upload->do_upload('image');
                $uploadData = $this->upload->data();
                $image = $uploadData['file_name'];
				$store = $this->input->post();
				$store['created_at'] = date('Y-m-d');
				$store['image'] = $image;
				$insert = $this->Main_model->insert('categories',$store);
				if ($insert) {
					$this->session->set_flashdata('message',notify('تمت اضافة التصنيف بنجاح','success'));	
					redirect('admin_panel/categories');
				}
            }
		}
		$data['main_content'] = 'admin_panel/categories/add';
		$this->load->view('admin_panel/blank',$data);
    }
    public function edit($id){
		$data['category'] = get_this('categories',['id'=>$id]);
		$data['title'] = 'تعديل التصنيف ';
		$this->form_validation->set_rules('name','اسم الدولة','trim|required');
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			if ($this->form_validation->run()) {
				if(!empty($_FILES['image']['name'])){
                $config['upload_path'] = 'assets/uploads/files';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['file_name'] = $_FILES['image']['name'];
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('image')){
                    $uploadData = $this->upload->data();
                    $image = $uploadData['file_name'];
                }else{
                    $image = '';
                }
                }else{
                    $image = '';
                }
				$store = $this->input->post();
				$store['updated_at'] = date('Y-m-d');
				if (!empty($image)) {
				$store['image'] = $image;
				}
				if ($this->Main_model->update('categories',['id'=>$id],$store)) {
					$this->session->set_flashdata('message',notify('تم تعديل بيانات التصنيف بنجاج','success'));
					redirect('admin_panel/categories');
				}
			}
		}
		$data['main_content'] = 'admin_panel/categories/edit';
		$this->load->view('admin_panel/blank',$data);
	}
    public function delete($id){
		if ($id) {
			$this->db->where('id',$id)->delete('categories');
			$this->session->set_flashdata('message',notify('تم حذف التصنيف بنجاح','success'));
			redirect('admin_panel/categories');
		}
	}
}
