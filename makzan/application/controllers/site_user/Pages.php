<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function page($id)
	{
		$data['body_class'] = 'page singular page-template';
		$data['user_data'] = $this->session->userdata('user_data');
		$data['page'] = get_this('pages',['id'=>$id]);
		$data['title'] = 'الصفحات الفرعية';
		$data['main_content'] = 'site_user/pages/page';
		$this->load->view('site_user/blank',$data);
	}
}
