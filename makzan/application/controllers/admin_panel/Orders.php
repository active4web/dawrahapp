<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if (!$this->session->has_userdata('login_data'))
            redirect('admin_panel/login'); 
	}
	public function index($type=null)
	{
		if ($type == 'new'){
            $data['title'] = 'الطلبات الجديدة';
            $data['orders'] = get_table('main_orders',['confirmation_status'=>0]);
        }
        elseif ($type == 'rejected'){
            $data['title'] = 'الطلبات المرفوضة';
            $data['orders'] = get_table('main_orders',['confirmation_status'=>1]);
        }
        else{
            $data['title'] = 'الطلبات الموافق عليها';
            $data['orders'] = get_table('main_orders',['confirmation_status'=>2]);
        }
		$data['main_content'] = 'admin_panel/orders/list';
		$this->load->view('admin_panel/blank',$data);
    }
    public function view($id){
		$data['title'] = 'عرض الفاتورة';
		$data['order'] = get_this('main_orders',['id'=>$id]);
		$data['settings'] = get_this('settings',['id'=>1]);
		$data['customer'] = get_this('customers',['id'=>$data['order']['customer_id']]);
		$data['main_content'] = 'admin_panel/orders/view';
		$this->load->view('admin_panel/blank',$data);
	}
	public function details($id){
		$data['title'] = 'تفاصيل الطلب';
		$data['order'] = get_this('main_orders',['id'=>$id]);
		$data['sub_orders'] = get_table('sub_orders',['main_order_id'=>$id]);
		$data['settings'] = get_this('settings',['id'=>1]);
		$this->load->library('googlemaps');
	    $config['center'] = $data['order']['latitude'].', '.$data['order']['langitude'];
	    $config['zoom'] = '8';
	    $config['map_height'] = "250px";
	    $this->googlemaps->initialize($config);
	    $marker = array();
	    $marker['position'] = $data['order']['latitude'].', '.$data['order']['langitude'];
	    $marker['draggable'] = false;
	    $this->googlemaps->add_marker($marker);
	    $data['map'] = $this->googlemaps->create_map();
		$data['main_content'] = 'admin_panel/orders/details';
		$this->load->view('admin_panel/blank',$data);
	}
    public function delete($id){
		if ($id) {
			$this->db->where('id',$id)->delete('categories');
			$this->session->set_flashdata('message',notify('تم حذف التصنيف بنجاح','success'));
			redirect('admin_panel/categories');
		}
	}
	public function send_message($id){
	    $mail = get_this('merchants',['id'=>$id],'email');
	    $this->load->library('email');
	    $email = $mail;
	    $findemail = get_this('merchants',['id'=>$id],'email');
	    $name = get_this('merchants',['id'=>$id],'full_name');
	    //echo $findemail;die;
	    if (count((array)$findemail)>0)
	    {
	        $subject = 'طلب جديد';        
	        $mail_message='مرحبا '.$name.','. "<br>\r\n";
	        $mail_message.='<b>تم إضافة طلب جديد لديك</b>'."\r\n";    
	        $mail_message.='<br>برجاء مراجعة حسابك ورؤية الطلبات الجديد';   
	        $mail_message.='<br>مع الشكر';        
	        $mail_message.='<br>Makzan.com.sa';         
	        $message = $mail_message;         
	        $body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	        <html xmlns="http://www.w3.org/1999/xhtml">
	        <head>
	        <meta http-equiv="Content-Type" content="text/html; charset=' . strtolower(config_item('charset')) . '" />
	        <title>' . html_escape($subject) . '</title>
	        <style type="text/css">
	        body {
	            font-family: Arial, Verdana, Helvetica, sans-serif;
	            font-size: 16px;
	        }
	        </style>
	        </head>
	        <body>' . $message . '</body></html>';
	        $result = $this->email        
	        ->from(get_this('settings',['id'=>1],'email'), 'مخزن')        
	        ->to($email)        
	        ->subject($subject)        
	        ->message($body)        
	        ->send();        
	        
	    }
	    //print_r($findemail);
	    //var_dump($result); 
	}
	
	public function confirm($id){
		$main_order = get_this('main_orders',['id'=>$id]);
        if ($main_order['confirmation_status'] == 1 && $main_order['confirmation_status'] == 2) {
            $this->session->set_flashdata('message',notify('عفوا لا يمكنك الموافقة على هذا الطلب','danger'));
            redirect('admin_panel/orders');
        }
        $store['confirmation_status'] = 2;
		$this->Main_model->update('main_orders',['id'=>$main_order['id']],$store);		//////////////////////////		//Send Mail To merchant		$result = array();		foreach($main_order as $main){			$result[]= $main->merchant_id;		}		//print_r($result);		$res = array_unique($result);		foreach($res as $se){			$this->send_message($se);		}		///////////////////////
        $this->session->set_flashdata('message',notify('تمت الموافقة على الطلب','success'));
		redirect('admin_panel/orders');
	}
	public function reject($id){
		$main_order = get_this('main_orders',['id'=>$id]);
        if ($main_order['confirmation_status'] == 1 && $main_order['confirmation_status'] == 2) {
            $this->session->set_flashdata('message',notify('عفوا لا يمكنك رفض  هذا الطلب','danger'));
            redirect('admin_panel/orders');
        }
        $store['confirmation_status'] = 1;
		$this->Main_model->update('main_orders',['id'=>$main_order['id']],$store);
        $this->session->set_flashdata('message',notify('تم رفض الطلب','success'));
		redirect('admin_panel/orders');
	}
}
