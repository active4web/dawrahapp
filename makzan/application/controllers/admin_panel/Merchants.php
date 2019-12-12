<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Merchants extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		if (!$this->session->has_userdata('login_data'))
            redirect('admin_panel/login'); 
	}
	public function index($active=null){
        $data['title'] = 'اصحاب المتاجر';
        if ($active == 'activated'){
        	$data['merchants'] = get_table('merchants',['confirmed'=>1]);
            $data['title'] = 'اصحاب المتاجر - المفعلين';
        }
        elseif ($active == 'deactivated'){
            $data['merchants'] = get_table('merchants',['confirmed'=>0]);
        	$data['title'] = 'اصحاب المتاجر - الغير مفعلين';
        }
        else
        	$data['merchants'] = get_table('merchants',null,['id','DESC']);
		$data['main_content'] = 'admin_panel/merchants/list';
		$this->load->view('admin_panel/blank',$data);
    }
    public function view($id){
    	$data['title'] = 'التاجر';
    	$data['merchant'] = get_this('merchants',['id'=>$id]);
    	$data['country'] = get_this('countries',['id'=>$data['merchant']['country_id']],'name');
    	$data['city'] = get_this('cities',['id'=>$data['merchant']['city_id']],'name');
    	$data['products'] = get_table('products',['created_by'=>$id]);
    	$data['tickets'] = get_table('tickets',['created_by'=>$id, 'type'=>0]);
    	$data['main_content'] = 'admin_panel/merchants/view';
		$this->load->view('admin_panel/blank',$data);

    }
    public function activate($id){
        $merchant = get_this('merchants',['id'=>$id]);
        if ($merchant['confirmed'] == 1) {
            $this->session->set_flashdata('message',notify('عفوا فقد تم تفعيل الحساب من قبل','danger'));
            redirect('admin_panel/merchants');
        }
        $store['confirmed'] = 1;
        $this->Main_model->update('merchants',['id'=>$merchant['id']],$store);
        $this->session->set_flashdata('message',notify('تم تفعيل الحساب بنجاح','success'));
        redirect('admin_panel/merchants');
    }
    public function deactivate($id){
        $merchant = get_this('merchants',['id'=>$id]);
        if ($merchant['confirmed'] == 0) {
            $this->session->set_flashdata('message',notify('عفوا فقد تم تعطيل الحساب من قبل','danger'));
            redirect('admin_panel/merchants');
        }
        $store['confirmed'] = 0;
        $this->Main_model->update('merchants',['id'=>$merchant['id']],$store);
        $this->session->set_flashdata('message',notify('تم تعطيل الحساب بنجاح','success'));
        redirect('admin_panel/merchants');
    }
}
