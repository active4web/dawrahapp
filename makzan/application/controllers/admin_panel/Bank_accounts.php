<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Bank_accounts extends CI_Controller {



	function __construct()

	{

		parent::__construct();

		if (!$this->session->has_userdata('login_data'))

            redirect('admin_panel/login'); 

	}

	public function index()

	{

        $data['title'] = 'الحسابات البنكية';

        $data['bank_accounts'] = get_table('bank_accounts');

		$data['main_content'] = 'admin_panel/bank_accounts/list';

		$this->load->view('admin_panel/blank',$data);

    }

    public function add(){
        $data['title'] = 'اضافة حساب جديد';
        $this->form_validation->set_rules('owner','صاحب الحساب','trim|required');
        $this->form_validation->set_rules('account_number','رقم الحساب','trim|required');
        $this->form_validation->set_rules('bank_name','اسم البنك','trim|required');
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			if ($this->form_validation->run()) {
				$store = $this->input->post();
				$store['created_at'] = date('Y-m-d');
				$insert = $this->Main_model->insert('bank_accounts',$store);
				if ($insert) {
					$this->session->set_flashdata('message',notify('تمت اضافة الحساب بنجاح','success'));	
					redirect('admin_panel/bank_accounts');
				}
            }
		}
		$data['main_content'] = 'admin_panel/bank_accounts/add';
		$this->load->view('admin_panel/blank',$data);
    }

    public function edit($id){
		$data['account'] = get_this('bank_accounts',['id'=>$id]);
		$data['title'] = 'تعديل بيانات الحساب ';
		$this->form_validation->set_rules('owner','صاحب الحساب','trim|required');
        $this->form_validation->set_rules('account_number','رقم الحساب','trim|required');
        $this->form_validation->set_rules('bank_name','اسم البنك','trim|required');

		if ($this->input->server('REQUEST_METHOD') === 'POST') {

			if ($this->form_validation->run()) {
				$store = $this->input->post();

				$store['updated_at'] = date('Y-m-d');
				if ($this->Main_model->update('bank_accounts',['id'=>$id],$store)) {

					$this->session->set_flashdata('message',notify('تم تعديل بيانات الحساب بنجاح','success'));

					redirect('admin_panel/bank_accounts');

				}

			}

		}

		$data['main_content'] = 'admin_panel/bank_accounts/edit';

		$this->load->view('admin_panel/blank',$data);

	}

    public function delete($id){

		if ($id) {

			$this->db->where('id',$id)->delete('bank_accounts');

			$this->session->set_flashdata('message',notify('تم حذف الحساب بنجاح','success'));

			redirect('admin_panel/bank_accounts');

		}

	}

}

