<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Courses extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->model('data','','true');
        $this->load->model('paging','','true');
        $this->load->library('upload');
        $this->load->helper(array('form', 'url','text'));
        $this->load->library('lib_pagination'); 
    }

    public function index(){
		redirect(base_url().'admin/Courses/inside','refresh');
    }
	
	public function gen_random_string()
    {
        $chars ="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";//length:36
        $final_rand='';
        for($i=0;$i<4; $i++) {
            $final_rand .= $chars[ rand(0,strlen($chars)-1)];
        }
        return $final_rand;
    }
	
	
    public  function search_username(){
        $phone=$this->input->post('phone');
        $len=strlen($phone);
        $a=array();
        $sql=$this->db->get_where('customers',array('view'=>'1','phone!='=>""))->result();
        if(count($sql)>0){
        foreach($sql as $sql){
        $user_phone=$sql->phone;
        if(substr($user_phone,0,$len)==$phone){
        array_push($a,$user_phone);
        }
        }
    }
echo json_encode($a);    
    }


    public function customer_search(){
        $phone=$this->input->get('phone');
		$where = "phone=$phone";
        $pg_config['sql'] = $this->data->get_sql('customers',$where,'id','DESC');
        $pg_config['per_page'] = 40;
        $data = $this->lib_pagination->create_pagination($pg_config);
        $this->load->view("admin/users/customer_search", $data); 
    }	
    public function inside(){
		
        $pg_config['sql'] = $this->data->get_sql('products','','id','DESC');
        $pg_config['per_page'] = 40;
        $data = $this->lib_pagination->create_pagination($pg_config);
        $this->load->view("admin/courses/inside", $data); 
    }
    
  
      public function insidecourses_content(){
		$id_course=$this->input->get("course_id");
        $pg_config['sql'] = $this->data->get_sql('course_info',array("id_course"=>$id_course,'type!='=>2),'id','DESC');
        $pg_config['per_page'] = 40;
        $data = $this->lib_pagination->create_pagination($pg_config);
        $this->load->view("admin/courses/insidecourses_content", $data); 
    }  
    
     public function bags_content(){
		$id_course=$this->input->get("course_id");
        $pg_config['sql'] = $this->data->get_sql('course_info',array("id_course"=>$id_course,'type'=>2),'id','DESC');
        $pg_config['per_page'] = 40;
        $data = $this->lib_pagination->create_pagination($pg_config);
        $this->load->view("admin/courses/bags_content", $data); 
    }  
         public function add_course_content(){
        $this->load->view("admin/courses/add_course_content"); 
    }  
    
    
    
	public function add_content_action(){
	    $type=$this->input->post('type');
	    $course_id=$this->input->post('course_id');
	    if($type!=2){
	   $user_id = get_table_filed('products',array('id'=>$course_id),"user_id");
	   $status= get_table_filed('products',array('id'=>$course_id),"type");
	    }
	    else if($type==2){
	    $user_id = get_table_filed('bag_info',array('id'=>$course_id),"user_id");
	     $status=2;
	    }
       $field_values_array = $_POST['field_name'];
       for($i=0; $i<count($field_values_array); $i++){
$data['content'] = $field_values_array[$i];
$data['id_course'] = $course_id;
$data['id_user'] =$user_id;
$data['type'] =$status;
$this->db->insert('course_info',$data);
}
$this->session->set_flashdata('msg', 'تم الأضافة بنجاح');
if($type==1){
redirect(base_url()."admin/courses/insidecourses_content?course_id=$course_id",'refresh');
}
else {
  redirect(base_url()."admin/courses/bags_content?course_id=$course_id",'refresh');  
}
}
    
    
    
        public function rate_details(){
	   $id=$this->input->get('id');
	   $course_type=$this->input->get('course_type');
	   	$where =array("id_course"=>$id,"course_key"=>$course_type) ;
        $pg_config['sql'] = $this->data->get_sql('reviews',$where,'id','DESC');
        $pg_config['per_page'] = 40;
        $data = $this->lib_pagination->create_pagination($pg_config);
        $this->load->view("admin/courses/rate_details", $data); 
    }
   
           public function bags(){
		$where = "status='3'";
        $pg_config['sql'] = $this->data->get_sql('bag_info','','id','DESC');
        $pg_config['per_page'] = 40;
        $data = $this->lib_pagination->create_pagination($pg_config);
        $this->load->view("admin/courses/bags", $data); 
    }
    
 public function bags_rate(){
	   $id=$this->input->get('id');
	   $course_type=$this->input->get('course_type');
	   	$where =array("id_course"=>$id,"course_key"=>$course_type) ;
        $pg_config['sql'] = $this->data->get_sql('reviews',$where,'id','DESC');
        $pg_config['per_page'] = 40;
        $data = $this->lib_pagination->create_pagination($pg_config);
        $this->load->view("admin/courses/bags_rate", $data); 
    }
	
	public function show_none(){
		$where = "status='0'";
        $pg_config['sql'] = $this->data->get_sql('customers',$where,'id','DESC');
        $pg_config['per_page'] = 10;
        $data = $this->lib_pagination->create_pagination($pg_config);
        $this->load->view("admin/customers/show_none", $data); 
    }
	
	public function edit(){
		$id=$this->input->get('id');
        $data['data'] = $this->data->get_table_data('products',array('id'=>$id));
         $data['country'] = $this->data->get_table_data('country',array('view'=>'1'));
         $data['category'] = $this->data->get_table_data('category',array('view'=>'1'));
         $data['Institute'] = $this->data->get_table_data('Institute',array('id_course'=>$id));
        $this->load->view("admin/courses/edit",$data); 
	}
	
	public function edit_bag(){
		$id=$this->input->get('id');
        $data['data'] = $this->data->get_table_data('bag_info',array('id'=>$id));
        $this->load->view("admin/courses/edit_bag",$data); 
	}	
	
		public function edit_content(){
		$id=$this->input->get('id');
        $data['data'] = $this->data->get_table_data('course_info',array('id'=>$id));
        $this->load->view("admin/courses/edit_content",$data); 
	}	
	
	
	


	public function edit_content_action(){
	    $id_courses=$this->input->post('id');
	    $type=$this->input->post('type');
	    $course_id=$this->input->post('course_id');
        $content=$this->input->post('content');
$data['content'] = $content;
$this->db->update('course_info',$data,array("id"=>$id_courses));

$this->session->set_flashdata('msg', 'تم الأضافة بنجاح');
if($type==1){
redirect(base_url()."admin/courses/insidecourses_content?course_id=$course_id",'refresh');
}
else {
  redirect(base_url()."admin/courses/bags_content?course_id=$course_id",'refresh');  
}
}

	
	public function editbag_action(){
	    $id_courses=$this->input->post('id');
        $title=$this->input->post('title');
        $bage_hrs=$this->input->post('bage_hrs');
        $week_bage_daies=$this->input->post('week_bage_daies');
 $bage_total_daies=$this->input->post('bage_total_daies');
        $cat_id=$this->input->post('cat_id');
      $bage_details=$this->input->post('bage_details');

         $data['bage_name'] = $title;
         $data['bage_details'] = $bage_details;
         $data['bage_hrs'] = $bage_hrs;
         $data['bage_total_daies'] = $bage_total_daies;
         $data['creation_date'] = date("Y-m-d");
         $data['dep_id'] = $cat_id;
         $data['week_bage_daies'] = $week_bage_daies;
        $this->db->update('bag_info',$data,array("id"=>$id_courses));
if($_FILES['img_course']['name']!=""){
$file=$_FILES['img_course']['name'];
$file_name="img_course";
$config=get_img_config_course('bag_info','uploads/products/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id_courses),"400","400",$id_courses);
}

if($id_courses!=""){
echo 1;
}
else {
echo 0;
}
}
	
	public function get_state(){
    header ('Content-Type: text/html; charset=UTF-8'); 
$country_id=$this->input->post('country_id');
$data_p=$this->db->get_where('city',array('view'=>'1','country_id'=>$country_id))->result();
if(count($data_p)>0){
    echo "<option value=''>حدد المدينة</option>";
    foreach($data_p as $data_p){
 echo "<option value='$data_p->id'>$data_p->name</option>";
    }
}
else {
  echo "<option value=''>لا يوجد حاليا اى بيانات</option>";   
}
}    

	
public function edit_action(){
$id_courses=$this->input->post('id');
$id_Institute=$this->input->post('id_Institute');
$title=$this->input->post('title');
$price=$this->input->post('price');
$duration_course=$this->input->post('duration_course');
$discount=$this->input->post('discount');
        $country_id=$this->input->post('country_id');
        $city_id=$this->input->post('city_id');
        $cat_id=$this->input->post('cat_id');
        $type=$this->input->post('type');
        $num_seats=$this->input->post('num_seats');
        $course_date=$this->input->post('course_date');
         //echo $course_date."<br>";
        $accreditation_number=$this->input->post('accreditation_number');
        $institute_name=$this->input->post('institute_name');
        $institute_about=$this->input->post('institute_about');
        $home_type=$this->input->post('home_type');
        $duration_study=$this->input->post('duration_study');
        $details=$this->input->post('details');
$duration_course=$this->input->post('duration_course');
        $notes=$this->input->post('notes');
         $data['name'] = $title;
         $data['city_id'] = $city_id;
         $data['details'] = $details;
         $data['duration_course'] = $duration_course;
         $data['cat_id'] = $cat_id;
         $data['accreditation_number'] = $accreditation_number;
         $data['price'] = $price;
         $data['discount'] = $discount;
         $data['date_course'] = $course_date;
         $data['country_id'] = $title;
         $data['home_type'] = $home_type;
         $data['duration_study'] = $duration_study;
         $data['notes'] = $notes;
         $data['type'] = $type;
         $data['num_seats'] = $num_seats;
         $data['creation_date'] = date("Y-m-d");
        $this->db->update('products',$data,array("id"=>$id_courses));
        
if($_FILES['img_course']['name']!=""){
$file=$_FILES['img_course']['name'];
$file_name="img_course";
$config=get_img_config_course('products','uploads/products/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id_courses),"400","400",$id_courses);
}

         $data_instit['Institute_name'] = $institute_name;
         $data_instit['Institute_about'] = $institute_about;
  $this->db->update('Institute',$data_instit,array("id"=>$id_Institute));
 
if($_FILES['img_institute']['name']!=""){
$file=$_FILES['img_institute']['name'];
$file_name="img_institute";
$config=get_img_config('Institute','uploads/products/',$file,$file_name,'Institute_img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id_Institute),"400","400");
}


if($id_courses!=""){
echo 1;
}
else {
echo 0;
}

	}
	

 public function add_bag(){
  $data['country'] = $this->data->get_table_data('country',array('view'=>'1'));
  $data['category'] = $this->data->get_table_data('category',array('view'=>'1'));
 $this->load->view("admin/courses/add_bag",$data); 
    }
    
    public function bags_action(){
        $title=$this->input->post('title');
        $bage_hrs=$this->input->post('bage_hrs');
        $week_bage_daies=$this->input->post('week_bage_daies');
 $bage_total_daies=$this->input->post('bage_total_daies');
        $cat_id=$this->input->post('cat_id');
      $bage_details=$this->input->post('bage_details');

         $data['bage_name'] = $title;
         $data['bage_details'] = $bage_details;
         $data['bage_hrs'] = $bage_hrs;
         $data['bage_total_daies'] = $bage_total_daies;
         $data['creation_date'] = date("Y-m-d");
         $data['dep_id'] = $cat_id;
         $data['week_bage_daies'] = $week_bage_daies;
        $this->db->insert('bag_info',$data);
        
$id_courses = $this->db->insert_id();
if($_FILES['img_course']['name']!=""){
$file=$_FILES['img_course']['name'];
$file_name="img_course";
$config=get_img_config_course('bag_info','uploads/products/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id_courses),"400","400",$id_courses);
}

     

if($id_courses!=""){
echo 1;
}
else {
echo 0;
}
    }

    
 public function add_course(){
  $data['country'] = $this->data->get_table_data('country',array('view'=>'1'));
  $data['category'] = $this->data->get_table_data('category',array('view'=>'1'));
 $this->load->view("admin/courses/add_course",$data); 
    }

    public function add_action(){
        $title=$this->input->post('title');
        $price=$this->input->post('price');
        $title=$this->input->post('title');
 $duration_course
=$this->input->post('duration_course
');
        $discount=$this->input->post('discount');
        $country_id=$this->input->post('country_id');
        $city_id=$this->input->post('city_id');
        $cat_id=$this->input->post('cat_id');
        $type=$this->input->post('type');
        $num_seats=$this->input->post('num_seats');
        $course_date=$this->input->post('course_date');
        $accreditation_number=$this->input->post('accreditation_number');
        $institute_name=$this->input->post('institute_name');
        $institute_about=$this->input->post('institute_about');
        $home_type=$this->input->post('home_type');
        $duration_study=$this->input->post('duration_study');
        $details=$this->input->post('details');
$duration_course=$this->input->post('duration_course');
        $notes=$this->input->post('notes');
         $data['name'] = $title;
         $data['city_id'] = $city_id;
         $data['details'] = $details;
         $data['duration_course'] = $duration_course;
         $data['cat_id'] = $cat_id;
         $data['accreditation_number'] = $accreditation_number;
         $data['price'] = $price;
         $data['discount'] = $discount;
         $data['date_course'] = $course_date;
         $data['country_id'] = $title;
         $data['home_type'] = $home_type;
         $data['duration_study'] = $duration_study;
         $data['notes'] = $notes;
         $data['type'] = $type;
         $data['num_seats'] = $num_seats;
         $data['creation_date'] = date("Y-m-d");
        $this->db->insert('products',$data);
        
$id_courses = $this->db->insert_id();

if($_FILES['img_course']['name']!=""){
$file=$_FILES['img_course']['name'];
$file_name="img_course";
$config=get_img_config_course('products','uploads/products/',$file,$file_name,'img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id_courses),"400","400",$id_courses);
}


        $data_instit['id_course'] = $id_courses;
         $data_instit['Institute_name'] = $institute_name;
         $data_instit['Institute_about'] = $institute_about;
 $this->db->insert('Institute',$data_instit);
 $id_Institute= $this->db->insert_id();
 
 
if($_FILES['img_institute']['name']!=""){
$file=$_FILES['img_institute']['name'];
$file_name="img_institute";
$config=get_img_config('Institute','uploads/products/',$file,$file_name,'Institute_img','gif|jpg|png|jpeg',600000,600000,600000,array('id'=>$id_Institute),"400","400");
}


if($id_courses!=""){
echo 1;
}
else {
echo 0;
}
    }

public function test(){
do_resize(42);  

}

public function courses_details(){
$id=$this->input->get('id');
$course_type=$this->input->get('course_type');
$data['data'] = $this->data->get_table_data('products',array('id'=>$id));
$data['course_info'] = $this->data->get_table_data('course_info',array('id_course'=>$id,'type'=>$course_type,'view'=>'1'));
$this->load->view("admin/courses/courses_details",$data); 
}


public function bages_details(){
$id=$this->input->get('id');
$course_type=$this->input->get('course_type');
$data['data'] = $this->data->get_table_data('bag_info',array('id'=>$id));
$data['course_info'] = $this->data->get_table_data('course_info',array('id_course'=>$id,'type'=>$course_type,'view'=>'1'));
$this->load->view("admin/courses/bages_details",$data); 
}




    function active(){
        $id = $this->input->post("id");
        $ser = $this->db->get_where("products",array("id"=>$id,"view" => "1"))->num_rows();
        if ($ser == 1) {
            $this->db->update("products",array("view" => "0"),array("id"=>$id));
            echo "0";
        }
        if ($ser == 0) {
            $this->db->update("products",array("view" => "1"),array("id"=>$id));
            echo "1";
        } 
    }

    function active_content(){
        $id = $this->input->post("id");
        $ser = $this->db->get_where("course_info",array("id"=>$id,"view" => "1"))->num_rows();
        if ($ser == 1) {
            $this->db->update("course_info",array("view" => "0"),array("id"=>$id));
            echo "0";
        }
        if ($ser == 0) {
            $this->db->update("course_info",array("view" => "1"),array("id"=>$id));
            echo "1";
        } 
    }

function active_bag(){
        $id = $this->input->post("id");
        $ser = $this->db->get_where("bag_info",array("id"=>$id,"view" => "1"))->num_rows();
        if ($ser == 1) {
            $this->db->update("bag_info",array("view" => "0"),array("id"=>$id));
            echo "0";
        }
        if ($ser == 0) {
            $this->db->update("bag_info",array("view" => "1"),array("id"=>$id));
            echo "1";
        } 
    }



    public function delete_content(){
        $id_customers = $this->input->get('id');

        $check=$this->input->post('check');

        if($id_customers!=""){
                     $type = $this->input->get('type');
          $course_id = $this->input->get('course_id');
        $ret_value=$this->data->delete_table_row('course_info',array('id'=>$id_customers)); 
        }
     
        if(isset($check) && $check!=""){
                     $type = $this->input->post('type');
          $course_id = $this->input->post('course_id');
        $check=$this->input->post('check');
        $length=count($check);
        for($i=0;$i<$length;$i++){
        $ret_value=$this->data->delete_table_row('course_info',array('id'=>$check[$i]));    
        }
        }
        $this->session->set_flashdata('msg', 'تم الحذف بنجاح');
        if($type==1){
redirect(base_url()."admin/courses/insidecourses_content?course_id=$course_id",'refresh');
}
else {
  redirect(base_url()."admin/courses/bags_content?course_id=$course_id",'refresh');  
}

    }
    

    public function delete(){
        $id_customers = $this->input->get('id_customers');
        $check=$this->input->post('check');

        if($id_customers!=""){
        $ret_value=$this->db->update('products',array('delete_key'=>'0'),array('id'=>$id_customers)); 
        }
     
        if(isset($check) && $check!=""){  
        $check=$this->input->post('check');
        $length=count($check);
        for($i=0;$i<$length;$i++){
        $ret_value=$$this->db->update('products',array('delete_key'=>'0'),array('id_customers'=>$check[$i]));    
        }
        }
        $this->session->set_flashdata('msg', 'تم الحذف بنجاح');
redirect(base_url().'admin/courses/inside/','refresh');


    }
    
        public function delete_bags(){
        $id_customers = $this->input->get('id_customers');
        $check=$this->input->post('check');

        if($id_customers!=""){
        $ret_value=$this->db->update('bag_info',array('delete_key'=>'0'),array('id'=>$id_customers)); 
        }
     
        if(isset($check) && $check!=""){  
        $check=$this->input->post('check');
        $length=count($check);
        for($i=0;$i<$length;$i++){
        $ret_value=$this->db->update('bag_info',array('delete_key'=>'0'),array('id_customers'=>$check[$i]));    
        }
        }
        $this->session->set_flashdata('msg', 'تم الحذف بنجاح');
redirect(base_url().'admin/courses/bags/','refresh');


    }
    
    

}