<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of site
 *
 * @author https://www.roytuts.com
 */
class Bags extends MX_Controller {

    function __construct() {
		parent::__construct();
        $this->db->order_by('id', 'DESC');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->model('data','','true');
    }



	function add_new() {
		if($this->session->userdata("customer_id")==""){
			redirect(base_url()."index");
		}		
	else {
		$customer_id=$this->session->userdata("customer_id");
		$data_contant['customers'] =$this->db->get_where('customers',array("id"=>$customer_id))->result(); 
		$data['site_info'] =$this->db->get_where('site_info')->result(); 
			$data_contant['category']=$this->db->get_where('category',array("view"=>'1'))->result();
		$data_contant['siteinfo']=$this->db->get_where('site_info')->result();
     	$this->load->view('index/include/head',$data );
	    $this->load->view('include/header',$data );
	    $this->load->view('add_new',$data_contant);
	    $this->load->view('index/include/footer',$data);  
	}
	}


	


	public function bag_action(){
		if($this->session->userdata("customer_id")==""){
			redirect(base_url()."index");
		}		
		
		$customer_id=$this->session->userdata("customer_id");
		$user_type=$this->session->userdata("user_type");
		$name=$this->input->post('name');
		$about=$this->input->post('about');
		$bage_total_daies=$this->input->post('bage_total_daies');
		$week_bage_daies=$this->input->post('week_bage_daies');
		$bage_hrs=$this->input->post('bage_hrs');

	$store['user_id'] = $customer_id;
	$store['bage_name'] = $name;
	$store['bage_details'] = $about;
	$store['bage_hrs'] = $bage_hrs;
	$store['week_bage_daies'] = $week_bage_daies;
	$store['bage_total_daies'] = $bage_total_daies;
	$store['creation_date'] = date("Y-d-m");
	$store['dep_id'] = 2;
	$store['view'] = '1';

	$insert = $this->db->insert('bag_info',$store);
	$id_course= $this->db->insert_id();

	
	$field_values_array =$this->input->post('field_name');

	for($i=0; $i<count($field_values_array); $i++){
	$data['content'] = $field_values_array[$i];
	$data['id_user'] = $customer_id;
	$data['id_course'] =$id_course;
	$data['type'] =2;
	$data['view'] ='1';
	$this->db->insert('course_info',$data);
	}

	if($_FILES['img']['name']!=""){
		$file=$_FILES['img']['name'];
		$file_name="img";
		$config=get_img_config('customers','uploads/products/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id_course),"400","400");
		$storeb['img'] = $config;
		$this->Main_model->update('bag_info',array("id"=>$id_course),$storeb);

		if($id_course!=0){
			get_img_resize_courses("uploads/products/".$config,"uploads/products/thumbnail_100/","150","100");
		 }
		 if($id_course!=0){
			get_img_resize_courses("uploads/products/".$config,"uploads/products/thumbnail_150/","250","150");
		 }

		}


	echo 1;
	}





	public function allbags(){

		if($this->session->userdata("customer_id")==""){
			redirect(base_url()."index");
		}		

		$user_type=$this->session->userdata("user_type");	
		$customer_id=$this->session->userdata("customer_id");
		
		$tables = "bag_info";
		$config = array();
		$config['base_url'] = base_url().'user/bags/allbags'; 
		$config['total_rows'] = $this->data->record_count($tables,array("user_id"=>$customer_id,'delete_key'=>'1'),'','id','desc');
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
	else:
		$data_conent['customers'] =$this->db->get_where('customers',array("id"=>$customer_id))->result(); 
	$data['site_info'] =$this->db->get_where('site_info')->result(); 
	$data_conent['site_info'] =$this->db->get_where('site_info')->result(); 
	$data_conent['result_count'] =$this->db->get_where($tables, array("user_id"=>$customer_id,'delete_key'=>'1'))->result(); 
	$data_conent["results"] = $this->data->view_all_data($tables, array("user_id"=>$customer_id,'delete_key'=>'1'), $config["per_page"], $page,'id','desc');
	$str_links = $this->pagination->create_links();
	$data_conent["links"] = explode('&nbsp;',$str_links);
	endif;
	$this->load->view("index/include/head",$data );
	$this->load->view("include/header",$data );
	$this->load->view('bags',$data_conent);
	$this->load->view("index/include/footer",$data);
	  }
	
	  


	  public function edit_bag(){

			if($this->session->userdata("customer_id")==""){
				redirect(base_url()."index");
			}		

		$tab_id=$this->uri->segment(4);
		$data_conent["results"] =$this->db->get_where('bag_info',array('view'=>'1','id'=>$tab_id))->result(); 
		$data_conent["course_info"] =$this->db->get_where('course_info',array('id_course'=>$tab_id))->result(); 
		$data_conent["bag_info"] =$this->db->get_where('bag_info',array('id'=>$tab_id))->result(); 
		$count_fav =$this->db->get_where('reviews',array('id_course'=>$tab_id,'course_key'=>'2'))->result();
		$rate_count=(int)count($count_fav);
		$this->db->select_sum('rate');
		$this->db->from('reviews');
		$this->db->where("id_course=$tab_id");
		$query = $this->db->get();
		 $final_rate=$query->row()->rate;
		 if($rate_count>0){
		  $main_rata_data['total_rate']= round($final_rate/$rate_count);
		 }
		 else {
		  $main_rata_data['total_rate']=0;
		 }
		$this->db->update("bag_info",$main_rata_data,array("id"=>$tab_id));
		 
	  
	  
	  $data['site_info'] =$this->db->get_where('site_info')->result(); 
	  $data_conent['site_info']=$this->db->get_where('site_info')->result();
	  $this->load->view("index/include/head",$data );
	  $this->load->view("include/header",$data );
	  $this->load->view('edit_bag',$data_conent);
	  $this->load->view("index/include/footer",$data);
	  
	  }



	  public function editbag_action(){
			if($this->session->userdata("customer_id")==""){
				redirect(base_url()."index");
			}		

		$customer_id=$this->session->userdata("customer_id");
		$bag_id=$this->input->post("bag_id");
		$user_type=$this->session->userdata("user_type");
		$name=$this->input->post('name');
		$about=$this->input->post('about');
		$bage_total_daies=$this->input->post('bage_total_daies');
		$week_bage_daies=$this->input->post('week_bage_daies');
		$bage_hrs=$this->input->post('bage_hrs');

	$store['bage_name'] = $name;
	$store['bage_details'] = $about;
	$store['bage_hrs'] = $bage_hrs;
	$store['week_bage_daies'] = $week_bage_daies;
	$store['bage_total_daies'] = $bage_total_daies;
	$store['creation_date'] = date("Y-d-m");

	$insert = $this->db->update('bag_info',$store,array("id"=>$bag_id));
	$field_values_array =$this->input->post('field_name');
	if(count($field_values_array)>0){
	$this->db->delete("course_info",array("id_course"=>$bag_id));
	}

	for($i=0; $i<count($field_values_array); $i++){
	$data['content'] = $field_values_array[$i];
	$data['id_user'] = $customer_id;
	$data['id_course'] =$bag_id;
	$data['type'] =2;
	$data['view'] ='1';
	$this->db->insert('course_info',$data);
	}

	if($_FILES['img']['name']!=""){
		$file=$_FILES['img']['name'];
		$file_name="img";
		$config=get_img_config('customers','uploads/products/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$bag_id),"400","400");
		$storeb['img'] = $config;
		$this->Main_model->update('bag_info',array("id"=>$bag_id),$storeb);

		if($bag_id!=0){
			get_img_resize_courses("uploads/products/".$config,"uploads/products/thumbnail_100/","150","100");
		 }
		 if($bag_id!=0){
			get_img_resize_courses("uploads/products/".$config,"uploads/products/thumbnail_150/","250","150");
		 }

		}


	echo 1;
	}

	

	public function delete(){    
		if($this->session->userdata("customer_id")==""){
			redirect(base_url()."index");
		}		

    $tab_id=$this->uri->segment(4);
			$this->db->update("bag_info",array("delete_key" => "0"),array("id"=>$tab_id));
			redirect(base_url()."user/bags/allbags");	
	}   
	
}

/* End of file Site.php */
/* Location: ./application/modules/site/controllers/site.php */
