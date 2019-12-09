<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Trainers extends MX_Controller {
    function __construct() {

		parent::__construct();
        $this->load->library('session');
		$this->load->model('data','','true');
          $this->load->library('pagination');
          $this->load->library('lib_pagination'); 
		@date_default_timezone_set('Asia/Riyadh');
    }


    
    
    
    public function index(){
    $tables = "customers";
    $config = array();
    $config['base_url'] = base_url().'trainers/'; 
    $config['total_rows'] = $this->data->record_count($tables,array("view"=>'1','status'=>'2'),'','id','desc');
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
$data_conent['result_count'] =$this->db->get_where($tables, array("view"=>'1','status'=>'2'))->result(); 
else:
$data['site_info'] =$this->db->get_where('site_info')->result(); 
$data_conent['site_info'] =$this->db->get_where('site_info')->result(); 
$data_conent['result_count'] =$this->db->get_where($tables, array("view"=>'1','status'=>'2'))->result(); 
$data_conent["results"] = $this->data->view_all_data($tables, array("view"=>'1','status'=>'2'), $config["per_page"], $page,'id','desc');
$str_links = $this->pagination->create_links();
$data_conent["links"] = explode('&nbsp;',$str_links);
endif;
$this->load->view("index/include/head",$data );
$this->load->view("include/header",$data );
$this->load->view('trainers',$data_conent);
$this->load->view("index/include/footer",$data);
  }




	function trainer_details() {
        $tab_id=$this->uri->segment(4);
        $data_conent["results"] =$this->db->get_where('customers',array('view'=>'1','id'=>$tab_id))->result(); 
		$data['site_info'] =$this->db->get_where('site_info')->result(); 
		$data_conent['site_info']=$this->db->get_where('site_info')->result();
$this->load->view("index/include/head",$data );
$this->load->view("include/header",$data );
$this->load->view('trainer_details',$data_conent);
$this->load->view("index/include/footer",$data);
            
    }
 
    
    

}


