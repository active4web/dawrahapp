<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Products extends CI_Controller {



	function __construct()

	{

		parent::__construct();

		if (!$this->session->has_userdata('login_data'))

            redirect('admin_panel/login'); 

	}

	public function index()

	{

        $data['title'] = 'المنتجات';

        $data['products'] = get_table('products');

		$data['main_content'] = 'admin_panel/products/list';

		$this->load->view('admin_panel/blank',$data);

    }
    public function add(){
    	$data['title'] = 'اضافة منتج جديد';
    	$data['merchants'] = get_table('merchants',['status'=>2]);
    	$data['categories'] = get_table('categories');
    	$this->load->library('form_validation');
        $this->form_validation->set_rules('created_by', 'رقم التاجر', 'trim|required|numeric');
        $this->form_validation->set_rules('name', 'اسم المنتج', 'trim|required');
        $this->form_validation->set_rules('description', 'تفاصيل المنتج', 'trim|required');
        $this->form_validation->set_rules('price', 'سعر المنتج', 'trim|required|numeric');
        $this->form_validation->set_rules('available_quantity', 'الكمية المتاحه', 'trim|required|numeric');
        $this->form_validation->set_rules('category_id', 'تصنيف المنتج', 'trim|required|numeric');
        $this->form_validation->set_rules('type', 'حالة المنتج', 'trim|required|numeric');
        $this->form_validation->set_rules('status', 'ظهور المنتج', 'trim|required|numeric');
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
				$store['main_image'] = $main_image;
				$store['created_at'] = date('Y-m-d');
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
					redirect('admin_panel/products');
				}
            }
		}
		$data['main_content'] = 'admin_panel/products/add';
		$this->load->view('admin_panel/blank',$data);
    }
        public function edit($id){
    	$data['product'] = get_this('products',['id'=>$id]);
    	$data['product_images'] = get_table('product_images',['product_id'=>$id]);
    	$data['images'] = get_table('product_images',['product_id'=>$id],'count');
        $data['title'] = 'تعديل المنتج';
    	$data['merchants'] = get_table('merchants',['status'=>2]);
    	$data['categories'] = get_table('categories');
    	$this->load->library('form_validation');
        $this->form_validation->set_rules('created_by', 'رقم التاجر', 'trim|required|numeric');
        $this->form_validation->set_rules('name', 'اسم المنتج', 'trim|required');
        $this->form_validation->set_rules('description', 'تفاصيل المنتج', 'trim|required');
        $this->form_validation->set_rules('price', 'سعر المنتج', 'trim|required|numeric');
        $this->form_validation->set_rules('available_quantity', 'الكمية المتاحه', 'trim|required|numeric');
        $this->form_validation->set_rules('category_id', 'تصنيف المنتج', 'trim|required|numeric');
        $this->form_validation->set_rules('type', 'حالة المنتج', 'trim|required|numeric');
        $this->form_validation->set_rules('status', 'ظهور المنتج', 'trim|required|numeric');
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
				if($this->input->post('main_image')){
				   $store['main_image'] = $main_image;
				}else{
				    unset($store['main_image']);
				}
				$store['created_at'] = date('Y-m-d');
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
					redirect('admin_panel/products');
            }
    }
    	$data['main_content'] = 'admin_panel/products/edit';
		$this->load->view('admin_panel/blank',$data);
}

    public function view($id){

		$data['title'] = 'عرض المنتج';

		$data['product'] = get_this('products',['id'=>$id]);

		$data['product_images'] = get_table('product_images',['product_id'=>$id]);

		$data['rate'] = round(get_avg($id));

		$data['merchant'] = get_this('merchants',['id'=>$data['product']['created_by']]);

		$data['country'] = get_this('countries',['id'=>$data['merchant']['country_id']],'name');

    	$data['city'] = get_this('cities',['id'=>$data['merchant']['city_id']],'name');

    	$data['comments'] = get_table('product_comments',['product_id'=>$id]);

    	$data['rates'] = get_table('product_rates',['product_id'=>$id]);

		$data['main_content'] = 'admin_panel/products/view';

		$this->load->view('admin_panel/blank',$data);

	}

   public function delete($id){

		if ($id) {
			if (get_this('order_items',['product_id'=>$id])) {
				$this->session->set_flashdata('message',notify('عفوا لا يمكنك حذف هذا المنتج لانه موجود في بعض الطلبات','danger'));
				redirect('admin_panel/products');
			}
			$this->db->where('id',$id)->delete('products');

			redirect('admin_panel/products');

		}

	}
  public function delete_img($id){
    $img = get_this('product_images',['id'=>$id]);
    $this->db->where('id',$id)->delete('product_images');
    $this->session->set_flashdata('message',notify('تم حذف الصورة بنجاح','success'));
      redirect('admin_panel/products/edit/'.$img['product_id']);
  }

}

