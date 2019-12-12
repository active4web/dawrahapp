<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

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
	public function index(){
		if ($this->session->has_userdata('login_data')) {
			redirect('admin_panel/dashboard');
		}
		$this->form_validation->set_rules('user_name','UserName','required');
		$this->form_validation->set_rules('password','Password','required');
		$data['user_name_error'] = null;
		$data['password_error'] = null;
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			if ($this->form_validation->run()) {
				$where = [
							'user_name'  => $this->input->post('user_name'),
				            'password'  => md5(md5(sha1($this->input->post('password'))))
						 ];
				$user_data = get_this('admins',$where);
				if($user_data)
                {
                	unset($user_data->password);
					$this->session->set_userdata('login_data',$user_data);
					redirect('admin_panel/dashboard');
				}else{
					redirect('admin_panel/login');
				}

			}else{
				if (form_error('user_name')) {
					 $data['user_name_error'] = form_error('اسم المستخدم', '<div class="danger">', '</div>');
				}
				if (form_error('password')) {
					 $data['password_error'] = form_error('كلمة المرور', '<div class="danger">', '</div>');
				}
			}
		}
		$this->load->view('admin_panel/login',$data);
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect('admin_panel/login');
	}
}
