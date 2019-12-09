<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of site
 *
 * @author https://www.roytuts.com
 */
class Notification extends MX_Controller {

    function __construct() {
		parent::__construct();
        $this->db->order_by('id', 'DESC');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->model('data','','true');
    }



	function view_notification() {
		if($this->session->userdata("customer_id")==""){
			redirect(base_url()."index");
		}
		else {
	$user_type=$this->session->userdata("user_type");	
	$customer_id=$this->session->userdata("customer_id");
	$data['site_info'] =$this->db->get_where('site_info')->result(); 
	$data_conent['notifications']=$this->db->order_by("id","desc")->get_where("notifications", array("customer_id"=>$customer_id))->result();
	$data_conent['site_info'] =$this->db->get_where('site_info')->result(); 
	$this->load->view('index/include/head',$data );
	$this->load->view('include/header',$data );
	$this->load->view('view_notification',$data_conent);
	$this->load->view('index/include/footer',$data);
	$update = ['notifications_num' => 0];
	$this->db->update('customers',$update,array('id'=>$customer_id));
	$update_notfy = ['view' =>'1'];
	$this->db->update('notifications',$update_notfy,array('customer_id'=>$customer_id));

		}
		}
	


/* End of file Site.php */
/* Location: ./application/modules/site/controllers/site.php */
   function empty_all()  {
		if($this->session->userdata("customer_id")==""){
			redirect(base_url()."index");
		}
		else {
			$user_type=$this->session->userdata("user_type");	
			$customer_id=$this->session->userdata("customer_id");
			$update = ['notifications_num' => 0];
			$this->db->update('customers',$update,array('id'=>$customer_id));
		//	$update_notfy = ['view' =>'1'];
		//	$this->db->update('notifications',$update_notfy,array('customer_id'=>$customer_id));
		}
	
}

}
