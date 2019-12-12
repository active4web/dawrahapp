<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Ads extends CI_Controller {



	function __construct()

	{

		parent::__construct();

		if (!$this->session->has_userdata('login_data'))

            redirect('admin_panel/login'); 

	}

	public function index(){

        $data['title'] = 'الاعلانات';

        $data['ads'] = get_table('ads');

		$data['main_content'] = 'admin_panel/ads/list';

		$this->load->view('admin_panel/blank',$data);

    }

    public function add(){

        $data['title'] = 'اضافة اعلان جديد';

        $this->form_validation->set_rules('url','الرابط','trim|required|valid_url');

        if (empty($_FILES['image']['name']))

            $this->form_validation->set_rules('image', 'الصورة', 'required');

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

				$this->Main_model->insert('ads',$store);
				$this->session->set_flashdata('message','تمت اضافة الاعلان بنجاح');
				redirect('admin_panel/ads');

            }

		}

		$data['main_content'] = 'admin_panel/ads/add';

		$this->load->view('admin_panel/blank',$data);

    }

    public function edit($id){
    	if (!$id) {
    		redirect('admin_panel/not_found');
    	}
		$data['ad'] = get_this('ads',['id'=>$id]);
		if (!$data['ad']) {
    		redirect('admin_panel/not_found');
    	}
		$data['title'] = 'تعديل الاعلان';

		$this->form_validation->set_rules('url','الرابط','trim|required|valid_url');

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

				$this->Main_model->update('ads',['id'=>$id],$store);

				redirect('admin_panel/ads');

			}

		}

		$data['main_content'] = 'admin_panel/ads/edit';

		$this->load->view('admin_panel/blank',$data);

	}

    public function delete($id){
    	if (!$id) {
    		redirect('admin_panel/not_found');
    	}
		$data['ad'] = get_this('ads',['id'=>$id]);
		if (!$data['ad']) {
    		redirect('admin_panel/not_found');
    	}
		$this->db->where('id',$data['ad']['id'])->delete('ads');
		redirect('admin_panel/ads');


	}

}

