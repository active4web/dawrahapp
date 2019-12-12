<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Countries extends CI_Controller {



	function __construct()

	{

		parent::__construct();

		if (!$this->session->has_userdata('login_data'))

            redirect('admin_panel/login'); 

	}

	public function index()

	{

        $data['title'] = 'الدول';

        $data['countries'] = get_table('countries');

		$data['main_content'] = 'admin_panel/countries/list';

		$this->load->view('admin_panel/blank',$data);

    }

    public function add(){

        $data['title'] = 'اضافة دولة جديدة';

        $this->form_validation->set_rules('name','اسم الدولة','trim|required');
        $this->form_validation->set_rules('international_key','المفتاح الدولي','trim|required|numeric');

		if ($this->input->server('REQUEST_METHOD') === 'POST') {

			if ($this->form_validation->run()) {

				$_FILES['flag']['name'];

                $config['upload_path'] = 'assets/uploads/files';

                $config['allowed_types'] = 'jpg|jpeg|png|gif';

                $config['file_name'] = $_FILES['flag']['name'];

                //Load upload library and initialize configuration

                $this->load->library('upload',$config);

                $this->upload->initialize($config);

                $this->upload->do_upload('flag');

                $uploadData = $this->upload->data();

                $flag = $uploadData['file_name'];

				$store = $this->input->post();

				$store['created_at'] = date('Y-m-d');

				$store['flag'] = $flag;

				$insert = $this->Main_model->insert('countries',$store);

				if ($insert) {

					$this->session->set_flashdata('message',notify('تمت اضافة الدوله بنجاح','success'));	

					redirect('admin_panel/countries');

				}

            }

		}

		$data['main_content'] = 'admin_panel/countries/add';

		$this->load->view('admin_panel/blank',$data);

    }

    public function edit($id){

		$data['country'] = get_this('countries',['id'=>$id]);

		$data['title'] = 'تعديل بيانات الدولة ';

        $this->form_validation->set_rules('name','اسم الدولة','trim|required');
        $this->form_validation->set_rules('international_key','المفتاح الدولي','trim|required|numeric');

		if ($this->input->server('REQUEST_METHOD') === 'POST') {

			if ($this->form_validation->run()) {

				if(!empty($_FILES['flag']['name'])){

                $config['upload_path'] = 'assets/uploads/files';

                $config['allowed_types'] = 'jpg|jpeg|png|gif';

                $config['file_name'] = $_FILES['flag']['name'];

                //Load upload library and initialize configuration

                $this->load->library('upload',$config);

                $this->upload->initialize($config);

                if($this->upload->do_upload('flag')){

                    $uploadData = $this->upload->data();

                    $flag = $uploadData['file_name'];

                }else{

                    $flag = '';

                }

                }else{

                    $flag = '';

                }

				$store = $this->input->post();

				$store['updated_at'] = date('Y-m-d');

				if (!empty($flag)) {

				$store['flag'] = $flag;

				}

				if ($this->Main_model->update('countries',['id'=>$id],$store)) {

					$this->session->set_flashdata('message',notify('تم تعديل بيانات الدولة بنجاج','success'));

					redirect('admin_panel/countries');

				}

			}

		}

		$data['main_content'] = 'admin_panel/countries/edit';

		$this->load->view('admin_panel/blank',$data);

	}

    public function delete($id){

		if ($id) {

			$this->db->where('id',$id)->delete('countries');

			$this->session->set_flashdata('message',notify('تم حذف الدولة بنجاح','success'));

			redirect('admin_panel/countries');

		}

	}

}

