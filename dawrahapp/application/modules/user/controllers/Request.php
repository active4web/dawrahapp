<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Request extends MX_Controller {
    function __construct() {

		parent::__construct();
        $this->load->library('session');
		$this->load->model('data','','true');
		$this->load->library('pagination');
		@date_default_timezone_set('Asia/Riyadh');
    }

function index() {
		redirect(base_url()."index");
}	

function myrequested() {
	if($this->session->userdata("customer_id")==""){
		redirect(base_url()."index");
	}
	else {


	$user_type=$this->session->userdata("user_type");	
		$customer_id=$this->session->userdata("customer_id");
		$tables = "request_courses";
		$config = array();
		$config['base_url'] = base_url().'user/request/myrequested'; 
		$config['total_rows'] = $this->data->record_count($tables,array("id_user"=>$customer_id),'','id','desc');
		$config['per_page'] =30;
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';   
		$config['last_link'] = '»»';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['first_link'] = '««';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = 'السابق';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = 'التالى';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active" style="padding:0px"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		//$config['suffix'] = '?' . http_build_query($_GET, '', "&");
	  //$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
		$this->pagination->initialize($config);
	if($this->uri->segment(3)){
	$page = ($this->uri->segment(3)) ;
	}
	else{
	$page =0;
	}
	
	$rs = $this->db->get($tables);
	if($rs->num_rows() == 0):
	$data_conent["results"] = array();
	$data_conent["links"] = array();
	$data_conent['site_info'] =$this->db->get_where('site_info')->result(); 
	$data['site_info'] =$this->db->get_where('site_info')->result(); 
	$data_conent['customers'] =$this->db->get_where('customers',array("id"=>$customer_id))->result(); 
	$data_conent['result_count'] =$this->db->get_where($tables, array("id_user"=>$customer_id))->result(); 
	else:
		$data_conent['customers'] =$this->db->get_where('customers',array("id"=>$customer_id))->result(); 
	$data['site_info'] =$this->db->get_where('site_info')->result(); 
	$data_conent['site_info'] =$this->db->get_where('site_info')->result(); 
	$data_conent['result_count'] =$this->db->get_where($tables, array("id_user"=>$customer_id))->result(); 
	$data_conent["results"] = $this->data->view_all_data($tables, array("id_user"=>$customer_id), $config["per_page"], $page,'id','desc');
	$str_links = $this->pagination->create_links();
	$data_conent["links"] = explode('&nbsp;',$str_links);
	endif;
	$this->load->view("index/include/head",$data );
	$this->load->view("include/header",$data );
	$this->load->view('myrequested',$data_conent);
	$this->load->view("index/include/footer",$data);



	}
	}
	

	

	

}



