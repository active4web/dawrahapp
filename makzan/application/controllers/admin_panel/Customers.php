<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		if (!$this->session->has_userdata('login_data'))
            redirect('admin_panel/login'); 
	}
	public function index($active=null){
        if ($active == 'activated'){
            $data['title'] = 'العملاء المفعلين';
            $data['customers'] = get_table('customers',['confirmed'=>1]);
        }
        elseif ($active == 'deactivated'){
            $data['title'] = 'العملاء الغير مفعلين';
            $data['customers'] = get_table('customers',['confirmed'=>0]);
        }
        else{
            $data['title'] = 'العملاء';
            $data['customers'] = get_table('customers');
        }
		$data['main_content'] = 'admin_panel/customers/list';
		$this->load->view('admin_panel/blank',$data);
    }
    public function view($id){
    	$data['title'] = 'العميل';
    	$data['customer'] = get_this('customers',['id'=>$id]);
    	if($data['customer']){
    	   $data['country'] = get_this('countries',['id'=>$data['customer']['country_id']],'name');
           $data['city'] = get_this('cities',['id'=>$data['customer']['city_id']],'name');
           $data['main_orders'] = get_table('main_orders',['customer_id'=>$id]);
           $data['tickets'] = get_table('tickets',['created_by'=>$id, 'type'=>1]);
           $data['main_content'] = 'admin_panel/customers/view';
           $this->load->view('admin_panel/blank',$data); 
    	}else{
    	   redirect('admin_panel/not_found');
    	}
    	

    }
    public function activate($id){
		$customer = get_this('customers',['id'=>$id]);
        if ($customer['confirmed'] == 1) {
            $this->session->set_flashdata('message',notify('عفوا فقد تم تفعيل الحساب من قبل','danger'));
            redirect('admin_panel/customers');
        }
        $store['confirmed'] = 1;
		$this->Main_model->update('customers',['id'=>$customer['id']],$store);
        $this->session->set_flashdata('message',notify('تم تفعيل الحساب بنجاح','success'));
		redirect('admin_panel/customers');
	}
    public function deactivate($id){
        $customer = get_this('customers',['id'=>$id]);
        if ($customer['confirmed'] == 0) {
            $this->session->set_flashdata('message',notify('عفوا فقد تم تعطيل الحساب من قبل','danger'));
            redirect('admin_panel/customers');
        }
        $store['confirmed'] = 0;
        $this->Main_model->update('customers',['id'=>$customer['id']],$store);
        $this->session->set_flashdata('message',notify('تم تعطيل الحساب بنجاح','success'));
        redirect('admin_panel/customers');
    }
}
