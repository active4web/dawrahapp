<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Users extends CI_Controller {



	function __construct()

	{

		parent::__construct();

		if (!$this->session->has_userdata('login_data'))

            redirect('admin_panel/login'); 

	}

	public function index()

	{

        $data['title'] = 'المستخدمين';

        $data['admins'] = get_table('admins');

		$data['main_content'] = 'admin_panel/admins/list';

		$this->load->view('admin_panel/blank',$data);

    }

    public function add(){

        $data['title'] = 'اضافة مستخدم جديد';

        $this->form_validation->set_rules('full_name','الاسم بالكامل','trim|required');

		$this->form_validation->set_rules('user_name','اسم المستخدم','trim|required');

        $this->form_validation->set_rules('email','البريد الالكتروني','trim|required|valid_email|is_unique[admins.email]');

        $this->form_validation->set_rules('password','كلمة المرور','trim|required|min_length[6]');

        $this->form_validation->set_rules('confirm_password','تأكيد كلمة المرور','trim|required|matches[password]');

        if (empty($_FILES['img']['name']))

            $this->form_validation->set_rules('img', 'صورة الاسلايد', 'required');

		if ($this->input->server('REQUEST_METHOD') === 'POST') {

			if ($this->form_validation->run()) {

				$_FILES['img']['name'];

                $config['upload_path'] = 'assets/uploads/';

                $config['allowed_types'] = 'jpg|jpeg|png|gif';

                $config['file_name'] = $_FILES['img']['name'];

                //Load upload library and initialize configuration

                $this->load->library('upload',$config);

                $this->upload->initialize($config);

                $this->upload->do_upload('img');

                $uploadData = $this->upload->data();

                $img = $uploadData['file_name'];

				$store = $this->input->post();

				unset($store['confirm_password']);

				$store['password'] =  md5(md5(sha1($this->input->post('password'))));

				$store['img'] = $img;

				$this->Main_model->insert('admins',$store);

				redirect('admin_panel/users');

            }

		}

		$data['main_content'] = 'admin_panel/admins/add';

		$this->load->view('admin_panel/blank',$data);

    }

    public function edit($id){

		$data['admin'] = get_this('admins',['user_id'=>$id]);

		$data['title'] = 'تعديل بيانات المستخدم';

		$this->form_validation->set_rules('full_name','الاسم بالكامل','trim|required');

		$this->form_validation->set_rules('user_name','اسم المستخدم','trim|required');

		if ($this->input->post('email') && $data['admin']['email'] != $this->input->post('email')) {

    		$this->form_validation->set_rules('email','البريد الالكتروني','trim|required|valid_email|is_unique[admins.email]');

		}

		if ($this->input->server('REQUEST_METHOD') === 'POST') {

			if ($this->form_validation->run()) {

				if(!empty($_FILES['img']['name'])){

                $config['upload_path'] = 'assets/uploads/files';

                $config['allowed_types'] = 'jpg|jpeg|png|gif';

                $config['file_name'] = $_FILES['img']['name'];

                //Load upload library and initialize configuration

                $this->load->library('upload',$config);

                $this->upload->initialize($config);

                if($this->upload->do_upload('img')){

                    $uploadData = $this->upload->data();

                    $img = $uploadData['file_name'];

                }else{

                    $img = '';

                }

                }else{

                    $img = '';

                }

				$store = $this->input->post();

				if ($this->input->post('password')) {

					$store['password'] =  md5(md5(sha1($this->input->post('password'))));

				}else{
					unset($store['password']);
				}

				if (!empty($img)) {

				$store['img'] = $img;

				}

				$this->Main_model->update('admins',['user_id'=>$id],$store);

				redirect('admin_panel/users');

			}

		}

		$data['main_content'] = 'admin_panel/admins/edit';

		$this->load->view('admin_panel/blank',$data);

	}

    public function delete($id){

		if ($id) {
			if ($id == 1) {
				$this->session->set_flashdata('message',notify('عفوا لا يمكنك حذف هذا المستخدم','danger'));
				redirect('admin_panel/users');
			}
			$this->db->where('user_id',$id)->delete('admins');

			redirect('admin_panel/users');

		}

	}

}

