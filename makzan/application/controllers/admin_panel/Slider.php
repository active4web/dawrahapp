<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slider extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if (!$this->session->has_userdata('login_data'))
            redirect('admin_panel/login'); 
	}
	public function index(){
        $data['title'] = 'سلايدر الصور';
        $data['images'] = get_table('slider');
		$data['main_content'] = 'admin_panel/slider/list';
		$this->load->view('admin_panel/blank',$data);
    }
    public function add(){
        $data['title'] = 'اضافة صورة جديدة';
        $this->form_validation->set_rules('title','العنوان','trim|required');
		$this->form_validation->set_rules('note','الوصف المختصر','trim|required');
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
				$store['image'] = $image;
				$store['created_at'] = date('Y-m-d');
				$this->Main_model->insert('slider',$store);
				redirect('admin_panel/slider');
            }
		}
		$data['main_content'] = 'admin_panel/slider/add';
		$this->load->view('admin_panel/blank',$data);
    }
    public function edit($id){
		$data['slider'] = get_this('slider',['id'=>$id]);
		$data['title'] = 'تعديل صورة الاسلايدر';
		$this->form_validation->set_rules('title','العنوان','trim|required');
		$this->form_validation->set_rules('note','الوصف المختصر','trim|required');
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
				}else{
					unset($store['image']);
				}
				$this->Main_model->update('slider',['id'=>$id],$store);
				redirect('admin_panel/slider');
			}
		}
		$data['main_content'] = 'admin_panel/slider/edit';
		$this->load->view('admin_panel/blank',$data);
	}
    public function delete($id){
		if ($id) {
			$this->db->where('id',$id)->delete('slider');
			redirect('admin_panel/slider');
		}
	}
}
