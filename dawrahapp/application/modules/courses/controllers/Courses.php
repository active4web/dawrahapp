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
    $tables = "bag_info";
    $config = array();
    $config['base_url'] = base_url().'courses/bags'; 
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
$this->load->view("index/include/header",$data );
$this->load->view('bags',$data_conent);
$this->load->view("index/include/footer",$data);
  }


public function bags_details(){
  $tab_id=$this->uri->segment(3);
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
$this->load->view("index/include/header",$data );
$this->load->view('bags_details',$data_conent);
$this->load->view("index/include/footer",$data);

}



 public function dawrat(){
    $tables = "products";
    $config = array();
    $config['base_url'] = base_url().'courses/dawrat'; 
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
    $tables = "products";
    $config = array();
    $config['base_url'] = base_url().'courses/dawrat_list'; 
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
$this->load->view('dawrat_list',$data_conent);
$this->load->view("index/include/footer",$data);
  }

  

  public function courses_details(){
    $tab_id=$this->uri->segment(3);
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
$this->load->view("index/include/header",$data );
$this->load->view('courses_details',$data_conent);
$this->load->view("index/include/footer",$data);

  }






 public function diplomas_list(){
    $tables = "products";
    $config = array();
    $config['base_url'] = base_url().'courses/diplomas_list'; 
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
$this->load->view("index/include/header",$data );
$this->load->view('diplomas_list',$data_conent);
$this->load->view("index/include/footer",$data);
  }


  public function diplomas_details(){
    $tab_id=$this->uri->segment(3);
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
$this->load->view("index/include/header",$data );
$this->load->view('diplomas_details',$data_conent);
$this->load->view("index/include/footer",$data);

  }


public function bags_list(){
    $tables = "bag_info";
    $config = array();
    $config['base_url'] = base_url().'courses/bags_list'; 
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
$this->load->view("index/include/header",$data );
$this->load->view('bags_list',$data_conent);
$this->load->view("index/include/footer",$data);
  }



 public function diplomas(){
    $tables = "products";
    $config = array();
    $config['base_url'] = base_url().'courses/diplomas'; 
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
$this->load->view("index/include/header",$data );
$this->load->view('diplomas',$data_conent);
$this->load->view("index/include/footer",$data);
  }


    
    

}


