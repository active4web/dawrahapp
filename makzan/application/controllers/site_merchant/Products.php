<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Products extends CI_Controller {

/*	public function index()

	{

		

	}*/

	public function my_products($id = null){
		$data['merchant_data'] = $this->session->userdata('merchant_data');
		if (empty($data['merchant_data'])) {
			redirect('site_user/login');
		}else{
			$data['body_class'] = 'products vendor-template store-template page-template';
			$data['title'] = 'منتجاتي';
			$data['products'] = get_table('products',['created_by'=>$data['merchant_data']['id']]);
			$data['main_content'] = 'site_merchant/products/my_products';
			$this->load->view('site_user/blank',$data);
		}
	}
	public function close($id){
		$data['merchant_data'] = $this->session->userdata('merchant_data');
		if (empty($data['merchant_data'])) {
			redirect('site_user/login');
		}else{
			$product = get_this('products',['id'=>$id]);
			if ($product) {
				if ($product['created_by'] == $data['merchant_data']['id']) {
					if ($product['status'] == 1) {
						$store = ['status' => 0];
						$this->Main_model->update('products',['id'=>$product['id']],$store);
						$this->session->set_flashdata('message',notify('تم اغلاق المنتج بنجاح','success'));
						redirect('site_merchant/products/my_products/'.$data['merchant_data']['id']);
					}else{
						$this->session->set_flashdata('message',notify('عفوا هذا المنتج مغلق بالفعل','danger'));
						redirect('site_merchant/products/my_products/'.$data['merchant_data']['id']);
					}
				}else{
					$this->session->set_flashdata('message',notify('عفوا هذا المنتج غير خاص بك','danger'));
					redirect('site_merchant/products/my_products/'.$data['merchant_data']['id']);	
				}
			}else{
				$this->session->set_flashdata('message',notify('عفوا لا توجحد منتجات بهذا الرقم','danger'));
				redirect('site_merchant/products/my_products/'.$data['merchant_data']['id']);	
			}
			
		}
	}
	public function open($id){
		$data['merchant_data'] = $this->session->userdata('merchant_data');
		if (empty($data['merchant_data'])) {
			redirect('site_user/login');
		}else{
			$product = get_this('products',['id'=>$id]);
			if ($product) {
				if ($product['created_by'] == $data['merchant_data']['id']) {
					if ($product['status'] == 0) {
						$store = ['status' => 1];
						$this->Main_model->update('products',['id'=>$product['id']],$store);
						$this->session->set_flashdata('message',notify('تم اظهار المنتج بنجاح','success'));
						redirect('site_merchant/products/my_products/'.$data['merchant_data']['id']);
					}else{
						$this->session->set_flashdata('message',notify('عفوا هذا المنتج مفتوح بالفعل','danger'));
						redirect('site_merchant/products/my_products/'.$data['merchant_data']['id']);
					}
				}else{
					$this->session->set_flashdata('message',notify('عفوا هذا المنتج غير خاص بك','danger'));
					redirect('site_merchant/products/my_products/'.$data['merchant_data']['id']);	
				}
			}else{
				$this->session->set_flashdata('message',notify('عفوا لا توجحد منتجات بهذا الرقم','danger'));
				redirect('site_merchant/products/my_products/'.$data['merchant_data']['id']);	
			}
			
		}
	}
	public function add(){
    	$data['title'] = 'اضافة منتج جديد';
    	$data['categories'] = get_table('categories');
    	$data['body_class'] = 'add-product page-template';
    	$data['merchant_data'] = $this->session->userdata('merchant_data');
		if (empty($data['merchant_data'])) {
			redirect('site_user/login');
		}else{
			$this->load->library('form_validation');
	        $this->form_validation->set_rules('name', 'اسم المنتج', 'trim|required');
	        $this->form_validation->set_rules('description', 'تفاصيل المنتج', 'trim|required');
	        $this->form_validation->set_rules('price', 'سعر المنتج', 'trim|required|numeric');
	        $this->form_validation->set_rules('available_quantity', 'الكمية المتاحه', 'trim|required|numeric');
	        $this->form_validation->set_rules('category_id', 'تصنيف المنتج', 'trim|required|numeric');
	        $this->form_validation->set_rules('type', 'حالة المنتج', 'trim|required|numeric');
	        // $this->form_validation->set_rules('status', 'ظهور المنتج', 'trim|required|numeric');
	        if (empty($_FILES['main_image']['name']))
	            $this->form_validation->set_rules('main_image', 'صورة المنتج', 'required');
	        if ($this->input->server('REQUEST_METHOD') === 'POST') {
				if ($this->form_validation->run()) {
					$_FILES['main_image']['name'];
	                $config['upload_path'] = 'assets/uploads/files';
	                $config['allowed_types'] = 'jpg|jpeg|png|gif';
	                $config['file_name'] = $_FILES['main_image']['name'];
	                //Load upload library and initialize configuration
	                $this->load->library('upload',$config);
	                $this->upload->initialize($config);
	                $this->upload->do_upload('main_image');
	                $uploadData = $this->upload->data();
	                $main_image = $uploadData['file_name'];
					$store = $this->input->post();
					$store['created_by'] = $data['merchant_data']['id'];
					$store['main_image'] = $main_image;
					$store['created_at'] = date('Y-m-d');
					$store['status'] = 1;
					$insert = $this->Main_model->insert('products',$store);
					if ($insert) {
						$id = $insert;
			            $j = 0;
			            for ($i = 0; $i < count($_FILES['image']['name']); $i++) {//loop to get individual element from the array
			              $target_path = dirname(BASEPATH) . "/assets/uploads/files/";
			              $validextensions = array("jpeg", "jpg","JPG", "png");  //Extensions which are allowed
			              $ext = explode('.', basename($_FILES['image']['name'][$i]));//explode file name from dot(.) 
			              $file_extension = pathinfo($_FILES['image']['name'][$i], PATHINFO_EXTENSION);
			              $image_name = md5(uniqid()) . "." . $ext[count($ext) - 1];
			              $target_path = $target_path . $image_name;//set the target path with a new name of image
			              $j = $j + 1;//increment the number of uploaded images according to the files in array       
			              if (in_array($file_extension, $validextensions) == 1) {
			               if (move_uploaded_file($_FILES['image']['tmp_name'][$i], $target_path)) {//if file moved to uploads folder
			                $this->m_image->create_thumbnail(dirname(BASEPATH) . '/assets/uploads/files/' . $image_name, 500, 450);
			                $this->Main_model->insert('product_images',array('product_id' => $id,'created_at'=>date('Y-m-d'),'image_name' => $image_name));
			               }
			              }
			            }
						$this->session->set_flashdata('message',notify('تمت اضافة المنتج بنجاح','success'));	
						redirect('site_merchant/products/my_products/'.$data['merchant_data']['id']);
					}
	            }
		}
		}
		$data['main_content'] = 'site_merchant/products/add';
		$this->load->view('site_user/blank',$data);
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
  
    public function edit($id){
    	$data['title'] = 'تعديل المنتج';
    	$data['categories'] = get_table('categories');
    	$data['body_class'] = 'add-product page-template';
    	$data['merchant_data'] = $this->session->userdata('merchant_data');
		if (empty($data['merchant_data'])) {
			redirect('site_user/login');
		}else{
			$data['product'] = get_this('products',['id'=>$id]);
			$data['product_images'] = get_table('product_images',['product_id'=>$data['product']['id']]);
			if ($data['product']['created_by'] == $data['merchant_data']['id']) {
				$this->load->library('form_validation');
		        $this->form_validation->set_rules('name', 'اسم المنتج', 'trim|required');
		        $this->form_validation->set_rules('description', 'تفاصيل المنتج', 'trim|required');
		        $this->form_validation->set_rules('price', 'سعر المنتج', 'trim|required|numeric');
		        $this->form_validation->set_rules('available_quantity', 'الكمية المتاحه', 'trim|required|numeric');
		        $this->form_validation->set_rules('category_id', 'تصنيف المنتج', 'trim|required|numeric');
		        $this->form_validation->set_rules('type', 'حالة المنتج', 'trim|required|numeric');
		        // $this->form_validation->set_rules('status', 'ظهور المنتج', 'trim|required|numeric');
		        // if (!empty($_FILES['main_image']['name']))
		        //     $this->form_validation->set_rules('main_image', 'صورة المنتج', 'required');
		        if ($this->input->server('REQUEST_METHOD') === 'POST') {
					if ($this->form_validation->run()) {
						$store = $this->input->post();
						if(!empty($_FILES['main_image']['name'])){
		                $config['upload_path'] = 'assets/uploads/files';
		                $config['allowed_types'] = 'jpg|jpeg|png|gif';
		                $config['file_name'] = $_FILES['main_image']['name'];
		                //Load upload library and initialize configuration
		                $this->load->library('upload',$config);
		                $this->upload->initialize($config);
		                if($this->upload->do_upload('main_image')){
		                    $uploadData = $this->upload->data();
		                    $image = $uploadData['file_name'];
		                }else{
		                    $image = '';
		                }
		                }else{
		                    $image = '';
		                }
						if (!empty($image)) {
						$store['main_image'] = $image;
						}else{
							unset($store['main_image']);
						}
						$store['created_at'] = date('Y-m-d');
						// print_r($store);exit;
						$update = $this->Main_model->update('products',['id'=>$id],$store);
						if($data['images'] < 4) {
				            $j = 0;
				            for ($i = 0; $i < count($_FILES['image']['name']); $i++) {//loop to get individual element from the array
				              $target_path = dirname(BASEPATH) . "/assets/uploads/files/";
				              $validextensions = array("jpeg", "jpg","JPG", "png");  //Extensions which are allowed
				              $ext = explode('.', basename($_FILES['image']['name'][$i]));//explode file name from dot(.) 
				              $file_extension = pathinfo($_FILES['image']['name'][$i], PATHINFO_EXTENSION);
				              $image_name = md5(uniqid()) . "." . $ext[count($ext) - 1];
				              $target_path = $target_path . $image_name;//set the target path with a new name of image
				              $j = $j + 1;//increment the number of uploaded images according to the files in array       
				              if (in_array($file_extension, $validextensions) == 1) {
				               if (move_uploaded_file($_FILES['image']['tmp_name'][$i], $target_path)) {//if file moved to uploads folder
				                $this->m_image->create_thumbnail(dirname(BASEPATH) . '/assets/uploads/files/' . $image_name, 500, 450);
				                $this->Main_model->insert('product_images',array('product_id' => $id,'created_at'=>date('Y-m-d'),'image_name' => $image_name));
				               }
				              }
				            }
						}  
							$this->session->set_flashdata('message',notify('تم تعديل المنتج بنجاح','success'));	
							redirect('site_merchant/products/edit/'.$data['product']['id']);
		            }
   				}
			}else{
				$this->session->set_flashdata('message',notify('عفوا هذا المنتج غير خاص بك','danger'));
				redirect('site_merchant/products/my_products/'.$data['product']['id']);	
			}
		}
		$data['main_content'] = 'site_merchant/products/edit';
		$this->load->view('site_user/blank',$data);
    }

	/*public function product($id){

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

	}*/

	public function delete_img($id){
	    $img = get_this('product_images',['id'=>$id]);
	    $this->db->where('id',$id)->delete('product_images');
	    $this->session->set_flashdata('message',notify('تم حذف الصورة بنجاح','success'));
	      redirect('site_merchant/products/edit/'.$img['product_id']);
  	}

}

