<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Courses extends MX_Controller {
    function __construct() {

		parent::__construct();
        $this->load->library('session');
		$this->load->model('data','','true');
          $this->load->library('pagination');
          $this->load->library('lib_pagination'); 
		@date_default_timezone_set('Asia/Riyadh');
    }


    
    
    
    public function bags(){
			if($this->session->userdata("customer_id")==""){
				redirect(base_url()."index");
			}		

    $tables = "bag_info";
    $config = array();
    $config['base_url'] = base_url().'user/courses/bags'; 
    $config['total_rows'] = $this->data->record_count($tables,array("view"=>'1','delete_key'=>'1'),'','id','desc');
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
$data_conent['result_count'] =$this->db->get_where($tables, array("view"=>'1','delete_key'=>'2'))->result(); 
else:
$data['site_info'] =$this->db->get_where('site_info')->result(); 
$data_conent['site_info'] =$this->db->get_where('site_info')->result(); 
$data_conent['result_count'] =$this->db->get_where($tables, array("view"=>'1','delete_key'=>'1'))->result(); 
$data_conent["results"] = $this->data->view_all_data($tables, array("view"=>'1','delete_key'=>'1'), $config["per_page"], $page,'id','desc');
$str_links = $this->pagination->create_links();
$data_conent["links"] = explode('&nbsp;',$str_links);
endif;
$this->load->view("index/include/head",$data );
$this->load->view("include/header",$data );
$this->load->view('all_bags',$data_conent);
$this->load->view("index/include/footer",$data);
  }


public function bags_details(){
	if($this->session->userdata("customer_id")==""){
		redirect(base_url()."index");
	}		

  $tab_id=$this->uri->segment(4);
  $data_conent["results"] =$this->db->get_where('bag_info',array('view'=>'1','id'=>$tab_id))->result(); 
  $data_conent["course_info"] =$this->db->get_where('course_info',array('id_course'=>$tab_id))->result(); 
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
$this->load->view('bags_details',$data_conent);
$this->load->view("index/include/footer",$data);

}



 public function dawrat(){
	if($this->session->userdata("customer_id")==""){
		redirect(base_url()."index");
	}		

    $tables = "products";
    $config = array();
    $config['base_url'] = base_url().'user/courses/dawrat'; 
    $config['total_rows'] = $this->data->record_count($tables,array("view"=>'1','delete_key'=>'1','type!='=>'3'),'','id','desc');
    $config['per_page'] =20;
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
$data_conent['result_count'] =$this->db->get_where($tables, array("view"=>'1','delete_key'=>'1','type!='=>'3'))->result(); 
else:
$data['site_info'] =$this->db->get_where('site_info')->result(); 
$data_conent['site_info'] =$this->db->get_where('site_info')->result(); 
$data_conent['result_count'] =$this->db->get_where($tables, array("view"=>'1','delete_key'=>'1','type!='=>'3'))->result(); 
$data_conent["results"] = $this->data->view_all_data($tables, array("view"=>'1','delete_key'=>'1','type!='=>'3'), $config["per_page"], $page,'id','desc');
$str_links = $this->pagination->create_links();
$data_conent["links"] = explode('&nbsp;',$str_links);
endif;
$this->load->view("index/include/head",$data );
$this->load->view("index/include/header",$data );
$this->load->view('courses',$data_conent);
$this->load->view("index/include/footer",$data);
  }





 public function dawrat_list(){
	if($this->session->userdata("customer_id")==""){
		redirect(base_url()."index");
	}		
    $tables = "products";
    $config = array();
    $config['base_url'] = base_url().'user/courses/dawrat_list'; 
    $config['total_rows'] = $this->data->record_count($tables,array("view"=>'1','delete_key'=>'1','type!='=>'3'),'','id','desc');
    $config['per_page'] =20;
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
$data_conent['result_count'] =$this->db->get_where($tables, array("view"=>'1','delete_key'=>'1','type!='=>'3'))->result(); 
else:
$data['site_info'] =$this->db->get_where('site_info')->result(); 
$data_conent['site_info'] =$this->db->get_where('site_info')->result(); 
$data_conent['result_count'] =$this->db->get_where($tables, array("view"=>'1','delete_key'=>'1','type!='=>'3'))->result(); 
$data_conent["results"] = $this->data->view_all_data($tables, array("view"=>'1','delete_key'=>'1','type!='=>'3'), $config["per_page"], $page,'id','desc');
$str_links = $this->pagination->create_links();
$data_conent["links"] = explode('&nbsp;',$str_links);
endif;
$this->load->view("index/include/head",$data );
$this->load->view("include/header",$data );
$this->load->view('dawrat_list',$data_conent);
$this->load->view("index/include/footer",$data);
  }

  

  public function courses_details(){
		if($this->session->userdata("customer_id")==""){
			redirect(base_url()."index");
		}		
    $tab_id=$this->uri->segment(4);
    $data_conent["results"] =$this->db->get_where('products',array('view'=>'1','id'=>$tab_id))->result(); 
    $data_conent["institute"] =$this->db->get_where('Institute',array('id_course'=>$tab_id))->result(); 
    $data_conent["course_info"] =$this->db->get_where('course_info',array('id_course'=>$tab_id))->result(); 
    $count_fav =$this->db->get_where('reviews',array('id_course'=>$tab_id,'course_key!='=>'2'))->result();
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
    $this->db->update("products",$main_rata_data,array("id"=>$tab_id));
     


$data['site_info'] =$this->db->get_where('site_info')->result(); 
$data_conent['site_info']=$this->db->get_where('site_info')->result();
$this->load->view("index/include/head",$data );
$this->load->view("include/header",$data );
$this->load->view('courses_details',$data_conent);
$this->load->view("index/include/footer",$data);

  }






 public function diplomas_list(){
	if($this->session->userdata("customer_id")==""){
		redirect(base_url()."index");
	}		
    $tables = "products";
    $config = array();
    $config['base_url'] = base_url().'user/courses/diplomas_list'; 
    $config['total_rows'] = $this->data->record_count($tables,array("view"=>'1','delete_key'=>'1','type'=>'3'),'','id','desc');
    $config['per_page'] =20;
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
$data_conent['result_count'] =$this->db->get_where($tables, array("view"=>'1','delete_key'=>'1','type'=>'3'))->result(); 
else:
$data['site_info'] =$this->db->get_where('site_info')->result(); 
$data_conent['site_info'] =$this->db->get_where('site_info')->result(); 
$data_conent['result_count'] =$this->db->get_where($tables, array("view"=>'1','delete_key'=>'1','type'=>'3'))->result(); 
$data_conent["results"] = $this->data->view_all_data($tables, array("view"=>'1','delete_key'=>'1','type'=>'3'), $config["per_page"], $page,'id','desc');
$str_links = $this->pagination->create_links();
$data_conent["links"] = explode('&nbsp;',$str_links);
endif;
$this->load->view("index/include/head",$data );
$this->load->view("include/header",$data );
$this->load->view('diplomas_list',$data_conent);
$this->load->view("index/include/footer",$data);
  }


  public function diplomas_details(){
		if($this->session->userdata("customer_id")==""){
			redirect(base_url()."index");
		}		

    $tab_id=$this->uri->segment(4);
    $data_conent["results"] =$this->db->get_where('products',array('view'=>'1','id'=>$tab_id))->result(); 
    $data_conent["institute"] =$this->db->get_where('Institute',array('id_course'=>$tab_id))->result(); 
    $data_conent["course_info"] =$this->db->get_where('course_info',array('id_course'=>$tab_id))->result(); 
    $count_fav =$this->db->get_where('reviews',array('id_course'=>$tab_id,'course_key!='=>'2'))->result();
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
         $this->db->update("products",$main_rata_data,array("id"=>$tab_id));
     


$data['site_info'] =$this->db->get_where('site_info')->result(); 
$data_conent['site_info']=$this->db->get_where('site_info')->result();
$this->load->view("index/include/head",$data );
$this->load->view("include/header",$data );
$this->load->view('diplomas_details',$data_conent);
$this->load->view("index/include/footer",$data);

  }


public function bags_list(){
	if($this->session->userdata("customer_id")==""){
		redirect(base_url()."index");
	}		
    $tables = "bag_info";
    $config = array();
    $config['base_url'] = base_url().'user/courses/bags_list'; 
    $config['total_rows'] = $this->data->record_count($tables,array("view"=>'1','delete_key'=>'1'),'','id','desc');
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
$data_conent['result_count'] =$this->db->get_where($tables, array("view"=>'1','delete_key'=>'2'))->result(); 
else:
$data['site_info'] =$this->db->get_where('site_info')->result(); 
$data_conent['site_info'] =$this->db->get_where('site_info')->result(); 
$data_conent['result_count'] =$this->db->get_where($tables, array("view"=>'1','delete_key'=>'1'))->result(); 
$data_conent["results"] = $this->data->view_all_data($tables, array("view"=>'1','delete_key'=>'1'), $config["per_page"], $page,'id','desc');
$str_links = $this->pagination->create_links();
$data_conent["links"] = explode('&nbsp;',$str_links);
endif;
$this->load->view("index/include/head",$data );
$this->load->view("include/header",$data );
$this->load->view('bags_list',$data_conent);
$this->load->view("index/include/footer",$data);
  }



 public function diplomas(){
	if($this->session->userdata("customer_id")==""){
		redirect(base_url()."index");
	}		
    $tables = "products";
    $config = array();
    $config['base_url'] = base_url().'user/courses/diplomas'; 
    $config['total_rows'] = $this->data->record_count($tables,array("view"=>'1','delete_key'=>'1','type'=>'3'),'','id','desc');
    $config['per_page'] =20;
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
$data_conent['result_count'] =$this->db->get_where($tables, array("view"=>'1','delete_key'=>'1','type'=>'3'))->result(); 
else:
$data['site_info'] =$this->db->get_where('site_info')->result(); 
$data_conent['site_info'] =$this->db->get_where('site_info')->result(); 
$data_conent['result_count'] =$this->db->get_where($tables, array("view"=>'1','delete_key'=>'1','type'=>'3'))->result(); 
$data_conent["results"] = $this->data->view_all_data($tables, array("view"=>'1','delete_key'=>'1','type'=>'3'), $config["per_page"], $page,'id','desc');
$str_links = $this->pagination->create_links();
$data_conent["links"] = explode('&nbsp;',$str_links);
endif;
$this->load->view("index/include/head",$data );
$this->load->view("include/header",$data );
$this->load->view('diplomas',$data_conent);
$this->load->view("index/include/footer",$data);
  }


	public function add_fav(){
		$customer_id=$this->session->userdata("customer_id");
	$data_fav['user_id']=$customer_id;
	$data_fav['course_id']=$this->input->post('id');
	$data_fav['type']=$this->input->post('course_key');

	if($this->input->post('type')==1){
		$data_fav['creation_date']=date("Y-m-d");
	$this->db->insert("favourites",$data_fav);
	}
	else 	if($this->input->post('type')==2){
		$this->db->delete("favourites",$data_fav);
		}

		echo count($this->db->get_where("favourites", array("user_id"=>$customer_id))->result()); 


	}
	
	
	public function request(){
	if($this->session->userdata("customer_id")==""){
		redirect(base_url()."index");
	}

$finalprice=$this->input->post("finalprice");
$tab_id=$this->input->post("course_id");
$data_conent["results"] =$this->db->get_where('products',array('view'=>'1','id'=>$tab_id))->result(); 
$data_conent["institute"] =$this->db->get_where('Institute',array('id_course'=>$tab_id))->result(); 
$data_conent["course_info"] =$this->db->get_where('course_info',array('id_course'=>$tab_id))->result(); 
$data_conent["bank_accounts"] =$this->db->get_where('bank_accounts',array('view'=>'1'))->result(); 

$data['site_info'] =$this->db->get_where('site_info')->result(); 
$data_conent['site_info']=$this->db->get_where('site_info')->result();
$this->load->view("index/include/head",$data );
$this->load->view("include/header",$data );
$this->load->view('request',$data_conent);
$this->load->view("index/include/footer",$data);
	
	
	}
	
public function transfer_info(){
if($this->session->userdata("customer_id")==""){
redirect(base_url()."index");
}




$finalprice=$this->input->post("finalprice");
$tab_id=$this->input->post("course_id");

if($tab_id==""){
redirect(base_url()."user");
}

$data_conent["results"] =$this->db->get_where('products',array('view'=>'1','id'=>$tab_id))->result(); 
$data_conent["institute"] =$this->db->get_where('Institute',array('id_course'=>$tab_id))->result(); 
$data_conent["course_info"] =$this->db->get_where('course_info',array('id_course'=>$tab_id))->result(); 
$data_conent["bank_accounts"] =$this->db->get_where('bank_accounts',array('view'=>'1'))->result(); 
$data_conent["bank_payment_type"] =$this->db->get_where('bank_payment_type',array('view'=>'1'))->result(); 

$data['site_info'] =$this->db->get_where('site_info')->result(); 
$data_conent['site_info']=$this->db->get_where('site_info')->result();
$this->load->view("index/include/head",$data );
$this->load->view("include/header",$data );
$this->load->view('transfer_info',$data_conent);
$this->load->view("index/include/footer",$data);
	
	
	}
	
	
	
	
	
public function transfer_action(){
if($this->session->userdata("customer_id")==""){
redirect(base_url()."index");
}
else {
    $customers_id=$this->session->userdata("customer_id");
    
        $id_course=$this->input->post('id_course');
    $course_key=$this->input->post('course_key');
    $select_data=$this->db->get_where('bank_accounts_forms',array('id_course'=>$id_course,'key_type'=>$course_key,'id_user'=>$customers_id,'status'=>'0'))->result();
    if(count($select_data)==0){
     $store = [
                      'id_bank'      => $this->input->post('bank_name'),
                      'id_user'      => $customers_id,
                      'id_course'    => $this->input->post('id_course'),
                      'name_payment' => $this->input->post('convter_name'),
                      'convert_type' => $this->input->post('bank_payment'),
                      'key_type'     => $this->input->post('course_key'),
                      'creation_date'     => date("Y-m-d")
                    ];
                    $insert = $this->db->insert('bank_accounts_forms',$store);
                   $id= $this->db->insert_id();
                   
if($_FILES['Institute_img']['name']!=""){
$file=$_FILES['Institute_img']['name'];
$file_name="Institute_img";
$config=get_img_config('bank_accounts_forms','uploads/Banks_accounts/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id),"400","400");
}
 if($insert){
   $store_request = [
                      'id_bank'      => $id,
                      'id_user'      => $customers_id,
                      'id_course'    => $this->input->post('course_id'),
                      'final_price' => $this->input->post('final_price'),
                      'type'     => $this->input->post('course_key'),
                      'creation_date'     => date("Y-m-d"),
                       'request_code'     => gen_random_string_code(),
                       'type_payment'=>'1'
                    ];
                    $insert = $this->db->insert('request_courses',$store_request);
}
}
echo 1;
}


}
	
	
	public function success_message(){
if($this->session->userdata("customer_id")==""){
redirect(base_url()."index");
}
else {
 $data['site_info'] =$this->db->get_where('site_info')->result(); 
$data_conent['site_info']=$this->db->get_where('site_info')->result();
$this->load->view("index/include/head",$data );
$this->load->view("include/header",$data );
$this->load->view('success_message',$data_conent);
$this->load->view("index/include/footer",$data);
	
}
}
	
public function request_bag(){
if($this->session->userdata("customer_id")==""){
redirect(base_url()."index");
}
$customer_id=$this->session->userdata("customer_id");

    $tab_id=$this->uri->segment(4);
    $count_request=$this->db->get_where('request_courses',array('id_user'=>$customer_id,'id_course'=>$tab_id,'type'=>'2','view'=>'0'))->result();
     $store_request = [
                      'id_user'       =>  $customer_id,
                      'id_course'     =>  $tab_id,
                      'type'          => '2',
                      'creation_date' => date("Y-m-d"),
                       'request_code' => gen_random_string_code(),
                       'type_payment' =>'2',
                       'view'         =>'0',
                       'status'       =>'0'
                    ];
                    if(count($count_request)==0){
                    $insert = $this->db->insert('request_courses',$store_request);
                    }
$data['site_info'] =$this->db->get_where('site_info')->result(); 
$data_conent['site_info']=$this->db->get_where('site_info')->result();
$this->load->view("index/include/head",$data );
$this->load->view("include/header",$data );
$this->load->view('request_bag',$data_conent);
$this->load->view("index/include/footer",$data);
	
	
	}
	
	
public function check_code(){
    $course_id=$this->input->post('course_id');
   $final_price=$this->input->post('price');
   $sql_discount=$this->input->post('discount');
   $discount_code_txt=$this->input->post('discount_code_txt');
   $customer_id=$this->session->userdata("customer_id");
   
if($discount_code_txt!=""){
    $user_code_discount= get_table_filed('customers',array('id'=>$customer_id),"code_discount");
     $code_discount_id= get_table_filed('customers',array('id'=>$customer_id),"code_discount_id");
      $code_id= get_table_filed('codes',array('code_name'=>$discount_code_txt,'view'=>'1','total_used>'=>0,'end_date>'=>date("Y-m-d")),"id"); 
  $code_discount= get_table_filed('codes',array('code_name'=>$discount_code_txt,'view'=>'1','total_used>'=>0,'end_date>'=>date("Y-m-d")),"discount"); 
  $user_using= get_table_filed('codes',array('code_name'=>$discount_code_txt,'view'=>'1','total_used>'=>0,'end_date>'=>date("Y-m-d")),"user_using"); 
  if($code_id!=""){
      $coustomer_code_id= get_table_filed('coustomer_code',array('id_customer'=>$customer_id,'id_code'=>$code_id),"id");   
      if($coustomer_code_id!=""){
        $coustomer_count= get_table_filed('coustomer_code',array('id'=>$coustomer_code_id),"count");
        if($coustomer_count<$user_using){
        $customer_infop['code_discount_key'] =1; 
         $customer_infop['discount_code'] =$code_discount;;
    $customer_infop['txt'] ="تم استخدام كود الخصم بنجاح ";
    if($final_price>$sql_discount&&$sql_discount!=""){
 $customer_infop['final_price'] =$sql_discount-round(($sql_discount*$code_discount)/100);}
else { $customer_infop['final_price']  =$final_price-round(($final_price*$code_discount)/100);}
$main_data['count']=$coustomer_count+1;
$this->db->update('coustomer_code',$main_data,array('id'=>$coustomer_code_id));
}
else {
 $customer_infop['code_discount_key'] =2; 
  $customer_infop['discount_code'] =0;;
    $customer_infop['txt'] ="لقد تم تخطى الحد المسموح بيه فى استخدام الكود";
    if($final_price>$sql_discount&&$sql_discount!=""){
 $customer_infop['final_price'] =$sql_discount-round(($sql_discount*$code_discount)/100);}
else { $customer_infop['final_price']  =$final_price-round(($final_price*$code_discount)/100);}    
}



}
else {
 $customer_infop['code_discount_key'] =1; 
 $customer_infop['txt'] ="تم استخدام كود الخصم بنجاح ";
 $customer_infop['discount_code'] =$code_discount;
 if($final_price>$sql_discount&&$sql_discount!=""){
 $customer_infop['final_price'] =$sql_discount-round(($sql_discount*$code_discount)/100);}
else { $customer_infop['final_price']  =$final_price-round(($final_price*$code_discount)/100);}
$main_data['count']=1;
$main_data['id_customer']=$customer_id;
$main_data['id_code']=$code_id;
$this->db->insert('coustomer_code',$main_data);   
}



 }
   /************First Codition*****************************/     
      
      
      
  
  
  /************if error in code*****************************/
  else {
 $customer_infop['code_discount_key'] =3;     
      $customer_infop['discount_code'] =0;;
 $customer_infop['txt'] ="كود الخصم غير صالح للاستخدام";
  if($final_price>$sql_discount&&$sql_discount!=""){ $customer_infop['final_price'] =(int)$final_price;}
else {$customer_infop['final_price']  =(int)$final_price;}
  }
   /************end if error in code*****************************/
}

echo json_encode($customer_infop);

	}
	
}


