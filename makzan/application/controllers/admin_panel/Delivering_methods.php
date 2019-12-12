<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Delivering_methods extends CI_Controller {



	function __construct()

	{

		parent::__construct();

		if (!$this->session->has_userdata('login_data'))

            redirect('admin_panel/login'); 

	}

	public function index()

	{

        $data['title'] = 'طرق التوصيل';

        $data['delivering_methods'] = get_table('delivering_methods');

		$data['main_content'] = 'admin_panel/delivering_methods/list';

		$this->load->view('admin_panel/blank',$data);

    }

    public function add(){

        $data['title'] = 'اضافة طريقة توصيل جديد';

        $this->form_validation->set_rules('name','اسم طريقة التوصيل','trim|required');

		if ($this->input->server('REQUEST_METHOD') === 'POST') {

			if ($this->form_validation->run()) {

				$store = $this->input->post();

				$store['created_at'] = date('Y-m-d');

				$insert = $this->Main_model->insert('delivering_methods',$store);

				if ($insert) {

					$this->session->set_flashdata('message',notify('تمت اضافة طريقة التوصيل بنجاح','success'));	

					redirect('admin_panel/delivering_methods');

				}

            }

		}

		$data['main_content'] = 'admin_panel/delivering_methods/add';

		$this->load->view('admin_panel/blank',$data);

    }

    public function edit($id){

		$data['title'] = 'تعديل طريقة التوصيل ';

		$data['method'] = get_this('delivering_methods',['id'=>$id]);

        $this->form_validation->set_rules('name','اسم طريقة التوصيل','trim|required');

		if ($this->input->server('REQUEST_METHOD') === 'POST') {

			if ($this->form_validation->run()) {

				$store = $this->input->post();

				$store['updated_at'] = date('Y-m-d');

				if ($this->Main_model->update('delivering_methods',['id'=>$id],$store)) {

					$this->session->set_flashdata('message',notify('تم تعديل بيانات طريقة التوصيل بنجاح','success'));

					redirect('admin_panel/delivering_methods');

				}

			}

		}

		$data['main_content'] = 'admin_panel/delivering_methods/edit';

		$this->load->view('admin_panel/blank',$data);

	}

    public function delete($id){

		if ($id) {

			$this->db->where('id',$id)->delete('delivering_methods');

			$this->session->set_flashdata('message',notify('تم حذف طريقة التوصيل بنجاح','success'));

			redirect('admin_panel/delivering_methods');

		}

	}

}

