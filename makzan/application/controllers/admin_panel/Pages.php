<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if (!$this->session->has_userdata('login_data'))
            redirect('admin_panel/login'); 
	}
	public function index()
	{
        $data['title'] = 'الصفحات الفرعيه';
        $data['pages'] = get_table('pages');
		$data['main_content'] = 'admin_panel/pages/list';
		$this->load->view('admin_panel/blank',$data);
    }
	
	public function gen_random_string()
	{
	$chars ="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";//length:36
	$final_rand='';
	for($i=0;$i<4; $i++) {
	 $final_rand .= $chars[ rand(0,strlen($chars)-1)];
		}
	return $final_rand;
	}

    public function add(){
        $data['title'] = 'اضافة صفحة جديدة';
        $this->form_validation->set_rules('title','عنوان الصفحه','trim|required');
        $this->form_validation->set_rules('content','محتوى الصفحة','trim|required');
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			if ($this->form_validation->run()) {
				
				$img_name=$this->gen_random_string(); 
				$imagename = $img_name;
				$_FILES['image']['name'];
                $config['upload_path'] = 'assets/uploads/files';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['file_name'] = $imagename;
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                $this->upload->do_upload('image');
				$uploadData = $this->upload->data();
                $image = $uploadData['file_name'];
				
				$store = $this->input->post();
				$store['created_at'] = date('Y-m-d');
				$store['image'] = $image;
				$insert = $this->Main_model->insert('pages',$store);
				if ($insert) {
					$this->session->set_flashdata('message',notify('تمت اضافة الصفحه بنجاح','success'));	
					redirect('admin_panel/pages');
				}
            }
		}
		$data['main_content'] = 'admin_panel/pages/add';
		$this->load->view('admin_panel/blank',$data);
    }
    public function edit($id){
		$data['title'] = 'تعديل الصفحة الفرعية';
		$data['page'] = get_this('pages',['id'=>$id]);
        $this->form_validation->set_rules('title','عنوان الصفحه','trim|required');
        $this->form_validation->set_rules('content','محتوى الصفحة','trim|required');
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			if ($this->form_validation->run()) {
				
				if(!empty($_FILES['image']['name'])){
				//Get Old Image To Remove
				$mg = get_this('pages',['id'=>$id]);
				$old_image = $mg['image'];
		
				$img_name=$this->gen_random_string(); 
				$imagename = $img_name;
                $config['upload_path'] = 'assets/uploads/files';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['file_name'] = $imagename;
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
				unlink("assets/uploads/files/$old_image");
				}
				if ($this->Main_model->update('pages',['id'=>$id],$store)) {
					$this->session->set_flashdata('message',notify('تم تعديل بيانات الصفحة بنجاج','success'));
					redirect('admin_panel/pages');
				}
			}
		}
		$data['main_content'] = 'admin_panel/pages/edit';
		$this->load->view('admin_panel/blank',$data);
	}
    public function delete($id){
		if ($id) {
			$this->db->where('id',$id)->delete('pages');
			$this->session->set_flashdata('message',notify('تم حذف الصفحة بنجاح','success'));
			redirect('admin_panel/pages');
		}
	}
}
