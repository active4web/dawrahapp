<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Products extends CI_Controller {



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

/*	public function index()

	{

		

	}*/

	public function lists($id, $type=null){

		if (!$id) {

			show_404();

		}else{

			$data['body_class'] = 'products store-template page-template';

			$data['title'] = 'المنتجات';

			$data['user_data'] = $this->session->userdata('user_data');

			$data['id'] = $id;

			if ($type == 0)

				$data['products'] = get_table('products',['category_id'=>$id, 'status'=>1,'type'=>0]);

			// print_r($data['products']);exit;

			if ($type == 1)

				$data['products'] = get_table('products',['category_id'=>$id, 'status'=>1,'type'=>1]);

			$data['main_content'] = 'site_user/products/list';

		    $this->load->view('site_user/blank',$data);

		}

	}

	public function search(){

			$data['body_class'] = 'search page-template';

			$data['title'] = 'البحث';

			$data['user_data'] = $this->session->userdata('user_data');

			$data['categories'] = get_table('categories');

			$this->form_validation->set_rules('product_name','اسم المنتج','required');

			if ($this->input->server('REQUEST_METHOD') === 'POST') {

			if ($this->form_validation->run()) {

				$where['products.status'] = 1;

          		$like['products.name'] = $this->input->post('product_name');

          		if ($this->input->post('category_id'))

             	    $where['products.category_id'] = $this->input->post('category_id');

          		if ($this->input->post('store_name'))

                    $like['merchants.store_name'] = $this->input->post('store_name');

                $data['products'] = $this->db->join('merchants','merchants.id=products.created_by')

                               		 		 ->like($like,'both')

                                             ->get_where('products',$where)

                                             ->result();                     

          		$data['products_count'] = count($data['products']);     

			}else{
				$this->session->set_flashdata('message',notify(validation_errors(),'danger'));	
			}

		}

		$data['main_content'] = 'site_user/products/search';

		$this->load->view('site_user/blank',$data);

	}
	
	public function auto_search()
    {
        $query = $this->input->get('query');
        $this->db->like('store_name', $query);
        $has = $this->db->get("merchants")->result();
		$data = array();
        foreach ($has as $hsl)
            {
                $data[] = $hsl->store_name;
            }
        echo json_encode($data);
    }
	
	public function product($id){

		if (!$id) {

			show_404();

		}else{

			$data['body_class'] = 'product single page-template';

			$data['title'] = 'صفحة المنتج';

			$data['user_data'] = $this->session->userdata('user_data');

			$data['product'] = get_this('products',['id'=>$id]);

			$data['product_comments'] = get_table('product_comments',['product_id'=>$id]);

			$data['product_images'] = get_table('product_images',['product_id'=>$id]);

			$data['comments_count'] = count($data['product_comments']);

			$data['merchant'] = get_this('merchants',['id'=>$data['product']['created_by']],'full_name');

			$data['average_rate'] = get_avg($id);

			$data['main_content'] = 'site_user/products/product';

			$this->load->view('site_user/blank',$data);

		}

	}

	public function add_comment($id){

		$data['user_data'] = $this->session->userdata('user_data');

		if (empty($data['user_data'])) {

			redirect('site_user/login');

		}else{

			$this->form_validation->set_rules('comment','التعليق','trim|required');

			if ($this->input->server('REQUEST_METHOD') === 'POST') {

				if ($this->form_validation->run()) {

					$store = [

								'product_id' => $id,

								'user_id'    => $data['user_data']['id'],

								'comment'    => $this->input->post('comment'),

								'created_at' => date('Y-m-d'),

								'time'       => date('h:i:s')

							 ];

					$insert = $this->Main_model->insert('product_comments',$store);

					if ($insert) {

						$this->session->set_flashdata('message',notify('تمت اضافة التعليق بنجاح','success'));	

						redirect('site_user/products/product/'.$id);

					}

	            }else{

	            	$this->session->set_flashdata('message',notify(validation_errors(),'danger'));	

					// redirect('site_user/products/product/'.$id);

					redirect($_SERVER['HTTP_REFERER']);

	            }

			}

		}

	}

	public function add_rate($id){
		$data['user_data'] = $this->session->userdata('user_data');
				if (empty($data['user_data'])) {
					redirect('site_user/login');
				}else{
					$this->form_validation->set_rules('rate','التقيم','trim|required');
					if ($this->input->server('REQUEST_METHOD') === 'POST') {
						if ($this->form_validation->run()) {
							if (get_this('product_rates',['product_id'=>$id, 'user_id'=>$data['user_data']['id']])) {
								$this->session->set_flashdata('message',notify('لقد قمت بالتقييم من قبل','danger'));	
								redirect('site_user/products/product/'.$id);
							}else{
								$store = [
											'product_id' => $id,
											'user_id'    => $data['user_data']['id'],
											'rate'    => $this->input->post('rate'),
										 ];
								$insert = $this->Main_model->insert('product_rates',$store);
								if ($insert) {
									$this->session->set_flashdata('message',notify('تمت اضافة التقييم بنجاح','success'));	
									redirect('site_user/products/product/'.$id);
								}
							}
			            }else{
			            	$this->session->set_flashdata('message',notify(validation_errors(),'danger'));	
							// redirect('site_user/products/product/'.$id);
							redirect('site_user/products/product/'.$id);
			            }
					}
				}
			}

	public function add_to_favourite($id){

		$data['user_data'] = $this->session->userdata('user_data');

		if (empty($data['user_data'])) {

			redirect('site_user/login');

		}else{

			if (get_this('customer_favourites',['product_id'=>$id,'user_id'=>$data['user_data']['id']])) {

				$this->session->set_flashdata('message',notify('عفوا هذا المنتج موجود بالفعل في قائمة المفضله لديك','danger'));	

				// redirect('site_user/products/product/'.$id);

				redirect($_SERVER['HTTP_REFERER']);

			}else{

				$store = [

							'product_id' => $id,

							'user_id'    => $data['user_data']['id'],

							'created_at' => date('Y-m-d'),

						 ];

				$this->Main_model->insert('customer_favourites',$store);

				$this->session->set_flashdata('message',notify('تمت اضافة المنتج الى المفضلة بنجاح','success'));	

				// redirect('site_user/products/product/'.$id);	

				redirect($_SERVER['HTTP_REFERER']);	 

			}

		}

	}
	
	public function img_pro(){
        $post = $this->input->post();
        $file = array('name' => 'img','id' => 'img','type' => 'file');
        $submit = array('name' => 'submit','id' => 'submit','type' => 'submit');
        echo form_open_multipart('');
        echo form_input($file);
        echo form_input($submit);
        echo form_close();
        if($post){
            $file = $this->do_uploads('img');
            return "Success";
        }else{
            return "Error";
        }
    }
	
	function do_uploads($image) {
        $file_name = '';
        $this->load->library('upload');
        $config['upload_path'] = "assets/uploads/files/";
        $config['allowed_types'] = '*';
        $config['overwrite'] = false;
        $config['encrypt_name'] = false;
        $this->upload->set_max_filesize(20001);
        $this->upload->initialize($config);
        $url = $_FILES[$image]['name'];
        if (!empty($url)) { // select img //
            if (!$this->upload->do_upload($image)) {
                $error = $this->upload->display_errors();
                return false;
            } else {
                $upname = $this->upload->data();
                return $file = $upname['file_name'];
            }
        }
  }
  
	public function favourites($id = null){

		$data['user_data'] = $this->session->userdata('user_data');

		if (empty($data['user_data'])) {

			redirect('site_user/login');

		}else{

			$data['body_class'] = 'favorite store-template page-template';

			$data['title'] = 'المفضلة';

			$where['customer_favourites.user_id'] = $data['user_data']['id'];

            $where['products.status'] = 1;

            $data['favourites'] = $this->db->select('*')

                          		   ->order_by('customer_favourites.created_at','DESC')

                          		   ->join('customer_favourites','product_id=products.id')

                          		   ->get_where('products',$where)

                          		   ->result();

		$data['main_content'] = 'site_user/user/favourites';

		$this->load->view('site_user/blank',$data);

		}

	}

	public function remove_from_favourites($id){

		$data['user_data'] = $this->session->userdata('user_data');

		if (empty($data['user_data'])) {

			redirect('site_user/login');

		}else{

			$where = [

						'product_id' => $id,

						'user_id'    => $data['user_data']['id']

					 ];

			$this->db->where($where)->delete('customer_favourites');

			$this->session->set_flashdata('message',notify('تم حذف المنتج من قائمة المفضله بنجاح','success'));

			redirect('site_user/products/favourites/'.$data['user_data']['id']);

		}

	}



}

