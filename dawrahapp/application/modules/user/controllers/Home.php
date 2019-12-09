<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Home extends MX_Controller {
    function __construct() {

		parent::__construct();
        $this->load->library('session');
		$this->load->model('data','','true');
		@date_default_timezone_set('Asia/Riyadh');
		$this->load->library('pagination');
    }

function index() {
	
 if($this->session->userdata("customer_id")==""){
			redirect(base_url()."index");
		}		

	else {

		$user_type=$this->session->userdata("user_type");	
		$customer_id=$this->session->userdata("customer_id");

/************************Start BAGS****************** */		
		if($user_type==3){
			redirect(base_url()."user/bags/allbags");
		}	
/************************End Bags****************** */

/************************Start BAGS****************** */		
if($user_type==4){
	redirect(base_url()."user/company/dawrat");
}	
/************************End Bags****************** */


/************************Start Trainers****************** */	

if($user_type==2){
			$data['site_info'] =$this->db->get_where('site_info')->result(); 
$data_conent['trainer_certifactes']=$this->db->order_by("id","desc")->get_where('trainer_certifactes',array("user_id"=>$customer_id))->result();
$data_conent['trainer_experiences']=$this->db->order_by("id","desc")->get_where('trainer_experiences',array("user_id"=>$customer_id))->result();
			$data_conent['site_info'] =$this->db->get_where('site_info')->result(); 
			$data_conent['customers'] =$this->db->get_where('customers',array("id"=>$customer_id))->result(); 
			$this->load->view('index/include/head',$data );
			$this->load->view('include/header',$data );
				$this->load->view('trainer',$data_conent);
				$this->load->view('index/include/footer',$data);
		}
/************************End Trainers****************** */
/************************Start User****************** */		
		
		if($user_type==1){	


	$tables = "products";
	$config = array();
	$config['base_url'] = base_url().'user/bags/allbags'; 
	$config['total_rows'] = $this->data->record_count($tables,array("type"=>'1','view'=>'1','delete_key'=>'1'),'','id','desc');
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
$data_conent['result_count'] =$this->db->get_where($tables, array("view"=>'1','delete_key'=>'2'))->result(); 
$data_conent['category']=$this->db->get_where('category',array("view"=>'1'))->result();
$data_conent['city']=$this->db->get_where('city',array("view"=>'1'))->result();
else:
	$data_conent['customers'] =$this->db->get_where('customers',array("id"=>$customer_id))->result(); 
$data['site_info'] =$this->db->get_where('site_info')->result(); 
$data_conent['site_info'] =$this->db->get_where('site_info')->result(); 
$data_conent['category']=$this->db->get_where('category',array("view"=>'1'))->result();
$data_conent['city']=$this->db->get_where('city',array("view"=>'1'))->result();
$data_conent['result_count'] =$this->db->get_where($tables, array("type"=>'1','view'=>'1','delete_key'=>'1'))->result(); 
$data_conent["results"] = $this->data->view_all_data($tables, array("type"=>'1','view'=>'1','delete_key'=>'1'), $config["per_page"], $page,'id','desc');
$str_links = $this->pagination->create_links();
$data_conent["links"] = explode('&nbsp;',$str_links);
endif;
$this->load->view("index/include/head",$data );
$this->load->view("include/header",$data );
$this->load->view('home',$data_conent);
$this->load->view("index/include/footer",$data);



		}
	}
    }

function test() {	$this->load->view('test');}


function reward() {
	if($this->session->userdata("customer_id")==""){
		redirect(base_url()."index");
	}
	else {
		$user_type=$this->session->userdata("user_type");	
$data['site_info'] =$this->db->get_where('site_info')->result(); 
$data_conent['points_terms']=$this->db->order_by("id","desc")->get_where('points_terms',array("user_key"=>$user_type,'view'=>'1'))->result();
$data_conent['site_info'] =$this->db->get_where('site_info')->result(); 
$this->load->view('index/include/head',$data );
$this->load->view('include/header',$data );
$this->load->view('reward',$data_conent);
$this->load->view('index/include/js');
$this->load->view('index/include/footer',$data);
	}
	}
	

	
function supporting() {
	if($this->session->userdata("customer_id")==""){
		redirect(base_url()."index");
	}
	else {
		$tab_id=$this->uri->segment(4);
		$user_type=$this->session->userdata("user_type");	
		$customer_id=$this->session->userdata("customer_id");
$data['site_info'] =$this->db->get_where('site_info')->result(); 
if($tab_id==""){
$data_conent['details_tickets']=$this->db->order_by("id","desc")->limit(1)->get_where('tickets',array("created_by"=>$customer_id))->result();
}
else {
	$data_conent['details_tickets']=$this->db->order_by("id","desc")->limit(1)->get_where('tickets',array('id'=>$tab_id,"created_by"=>$customer_id))->result();

}
$data_conent['tickets']=$this->db->order_by("id","desc")->get_where('tickets',array("created_by"=>$customer_id))->result();
$data_conent['tickets_types']=$this->db->get_where('tickets_types',array("view"=>'1'))->result();

$data_conent['site_info'] =$this->db->get_where('site_info')->result(); 
$this->load->view('index/include/head',$data );
$this->load->view('include/header',$data );
$this->load->view('supporting',$data_conent);
$this->load->view('index/include/js');
$this->load->view('index/include/footer',$data);
	}
	}


	

}



