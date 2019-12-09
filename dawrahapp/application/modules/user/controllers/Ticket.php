<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of site
 *
 * @author https://www.roytuts.com
 */
class Ticket extends MX_Controller {

    function __construct() {
   	parent::__construct();
		$this->load->library('session');
		$this->load->library('pagination');
			$this->load->model('data','','true');

    }
    
    


    
public function replay_action(){
	$user_type=$this->session->userdata("user_type");	
	$customer_id=$this->session->userdata("customer_id");
	$message=$this->input->post('message');
	$ticketid=$this->input->post('ticket');

	$ticket = get_this('tickets',['id'=>$ticketid]);
	if ($ticket) {
date_default_timezone_set('Asia/Riyadh');
			$store = [
						'created_by' => $customer_id,
						'ticket_id'  => $ticketid,
						'content'    => $message,
						'created_at' => date('Y-m-d'),
						'reply_type' => 1,
						'time'       => date('H:i:s')
					];
			$insert = $this->Main_model->insert('tickets_replies',$store);

$update['status_id'] = 0;
$update['updated_at'] = date('Y-m-d');
$this->Main_model->update('tickets',['id'=>$this->input->post('ticket_id')],$update);
				}
				echo 1;
}


public function new_action(){
	$user_type=$this->session->userdata("user_type");	
	$customer_id=$this->session->userdata("customer_id");
	$message=$this->input->post('message');
	$name=$this->input->post('name');
	$tickets_types=$this->input->post('tickets_types');

	$store = [
		'created_by'     =>$customer_id,
		'ticket_type_id' => $tickets_types,
		'title'        => $name,
		'content'        => $message,
		'created_at'     => date('Y-m-d'),
		'time'     => date('h:i:s'),
		'type'           => 1,
		'user_type' =>$user_type,
		'status_id'=> 0
	  ];
$insert = $this->Main_model->insert('tickets',$store);
	echo 1;
}

function new_ticket() {
	if($this->session->userdata("customer_id")==""){
		redirect(base_url()."index");
	}
	else {

$data['site_info'] =$this->db->get_where('site_info')->result(); 
$data_conent['tickets_types']=$this->db->order_by("id","desc")->get_where('tickets_types',array("view"=>'1'))->result();
$data_conent['site_info'] =$this->db->get_where('site_info')->result(); 
$this->load->view('index/include/head',$data );
$this->load->view('include/header',$data );
$this->load->view('new_ticket',$data_conent);
$this->load->view('index/include/footer',$data);
	}
	}
	
}



/* End of file Site.php */
/* Location: ./application/modules/site/controllers/site.php */
