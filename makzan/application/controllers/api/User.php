<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/MobilySms.php';
/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class User extends REST_Controller {
    function __construct(){
        // Construct the parent class
        parent::__construct();
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    }
    public function bank_accounts_post(){
      $bank_accounts = get_table('bank_accounts');
      if ($bank_accounts) {
      	foreach ($bank_accounts as $account) {
      		$result[] = [
      						'id'             => $account->id,
      						'owner'          => $account->owner,
      						'account_number' => $account->account_number,
      						'bank_name'      => $account->bank_name
      					];
      	}
              $data['status'] = true;
              $data['bank_accounts'] = $result;
              $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
      }else{
        $data['status'] = false;
        $data['message'] = 'عفوا لا توجد اي  ارقام حسابات بنكية بقاعدة البيانات';
        $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
       } 
    }
    public function settings_post(){
      $settings = get_this('settings',['id'=>1]);
      if ($settings) {
              $data['status'] = true;
              $data['settings'] = $settings;
              $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
      }else{
        $data['status'] = false;
        $data['message'] = 'عفوا لا توجد اي  اعدادات بقاعدة البيانات';
        $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
       } 
    }
    public function countries_post(){
      $countries = get_table('countries');
      if ($countries) {
        foreach ($countries as $country) {
          $result[] = [
                          'id'   => $country->id,
                          'name' => $country->name,
                      ];
        }
            if ($result) {
              $data['status'] = true;
              $data['countries'] = $result;
              $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
      }else{
        $data['status'] = true;
        $data['countries'] = [];
        $data['message'] = 'عفوا لا توجدي اي دول مخزنة بقاعدة البيانات';
        $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
       } 
    }
    public function cities_post(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('country_id', 'الدولة', 'required|numeric');
        if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('country_id')){
                $data['country_id_error'] = strip_tags(form_error('country_id'));
                $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
        }else{
          $country = get_this('countries',['id'=>$this->post('country_id')]);
          if ($country) {
            $cities = get_table('cities',['country_id'=>$this->post('country_id')]);
            if ($cities) {
                foreach ($cities as $city) {
                  $result[] = [
                                  'id'           => $city->id,
                                  'name'         => $city->name,
                                  'country_name' => get_this('countries',['id' => $city->country_id],'name')
                              ];
                }if ($result) {
                      $data['status'] = true;
                      $data['cities'] = $result;
                      $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            }else{
                $data['status'] = true;
                $data['cities'] = [];
                $data['message'] = 'عفوا لاتوجد اي مدن تخص هذه الدولة';
                $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
          }else{
            $data['status'] = false;
            $data['message'] = 'عفوا لا توجد اي بيانات لهذه الدولة';
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
          } 
        }
    }
    public function pages_post(){
      $pages = get_table('pages');
      if ($pages) {
        foreach ($pages as $page) {
          $result[] = [
                          'page_id' => $page->id,
                          'title'   => $page->title,
                          'content' => $page->content,
                      ];
        }
            if ($result) {
              $data['status'] = true;
              $data['pages'] = $result;
              $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
      }else{
        $data['status'] = true;
        $data['pages'] = [];
        $data['message'] = 'عفوا لا توجدي اي صفحات مخزنة بقاعدة البيانات';
        $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
       } 
    }
    public function page_post(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('page_id', 'رقم الصفحه', 'required|numeric');
        if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('page_id')){
                $data['page_id_error'] = strip_tags(form_error('page_id'));
                $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
        }else{
            $page = get_this('pages',['id'=>$this->post('page_id')]);
            if ($page) {
                  $result = [
                                  'page_id' => $page['id'],
                                  'title'   => $page['title'],
                                  'content' => $page['content']
                              ];
                 if ($result) {
                      $data['status'] = true;
                      $data['page'] = $result;
                      $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                 }
            }else{
                $data['status'] = true;
                $data['page'] = [];
                $data['message'] = 'عفوا لاتوجد اي صفحات تخص هذا الرقم';
                $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } 
        }
    }
    public function categories_post(){
      $categories = get_table('categories');
      if ($categories) {
        foreach ($categories as $method) {
          $result[] = [
                          'category_id' => $method->id,
                          'name'      => $method->name,
                          'image'     => base_url('assets/uploads/files/'.$method->image)
                      ];
        }
            if ($result) {
              $data['status'] = true;
              $data['categories'] = $result;
              $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
      }else{
        $data['status'] = true;
        $data['categories'] = [];
        $data['message'] = 'عفوا لا توجدياي تصنيفات مخزنة بقاعدة البيانات';
        $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
       } 
    }
    public function products_post(){
      $this->load->library('form_validation');
      $this->form_validation->set_rules('category_id', 'رقم التصنيف', 'trim|required|numeric');
      $this->form_validation->set_rules('type', 'رقم حالة المنتج', 'trim|required|numeric');
      $this->form_validation->set_rules('limit', 'عدد العناصر الظاهره', 'trim|required|numeric');
      $this->form_validation->set_rules('page_number', 'رقم الصفحه', 'trim|required|numeric');
      if($this->form_validation->run() === FALSE){
          $data['status'] = false;
          if(form_error('category_id'))
              $data['category_id_error'] = strip_tags(form_error('category_id'));
          if(form_error('type'))
              $data['type_error'] = strip_tags(form_error('type'));
          if(form_error('limit'))
                $data['limit_error'] = strip_tags(form_error('limit'));
          if(form_error('page_number'))
                $data['page_number_error'] = strip_tags(form_error('page_number'));  
          $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
      }else{
          $offset = $this->post('limit') * $this->post('page_number');
          $where['category_id'] = $this->post('category_id');
          $where['type'] = $this->post('type');
          $where['products.status'] = 1;
          $where['merchants.status'] = 1;
          $where['merchants.confirmed'] = 1;
          if ($this->post('city_id')) {
              $where['merchants.city_id'] = $this->post('city_id');
          }
          
          $products = $this->db->select('products.id as number, name, price, main_image')
                               ->order_by('products.created_at','DESC')
                               ->join('merchants','merchants.id=products.created_by')
                               ->get_where('products',$where,$this->post('limit'),$offset)
                               ->result();
          if ($products) {
              foreach ($products as $product) {
                $result[] = [
                                'product_id'      => $product->number,
                                'product_name'    => $product->name,
                                'product_price'   => $product->price,
                                'product_image'   => base_url('assets/uploads/files/'.$product->main_image),
                                // 'product_city_id' => get_this('merchants',['id'=>$product->created_by],'city_id'),
                                'product_rate'    => get_avg($product->number)
                            ];
              }
              if ($result) {
                $data['status'] = true;
                $data['products'] = $result;
                $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

              }
          }else{
              $data['status'] = true;
              $data['products'] = [];
              $data['message'] = 'عفوا لا توجد اي منتجات بهذه البيانات';
              $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
          }
      }
    }
    public function product_post(){
      $this->load->library('form_validation');
      $this->form_validation->set_rules('product_id', 'رقم التصنيف', 'trim|required|numeric');
      if($this->form_validation->run() === FALSE){
          $data['status'] = false;
          if(form_error('product_id'))
              $data['product_id_error'] = strip_tags(form_error('product_id'));
          $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
      }else{
          $product = get_this('products',['id'=>$this->post('product_id'),'status'=>1]);
          if ($product) {
            $result = [
                          'product_id' => $product['id'],
                          'product_name' => $product['name'],
                          'product_store_name' => get_this('merchants',['id'=>$product['created_by']],'store_name'),
                          'product_owner' => get_this('merchants',['id'=>$product['created_by']],'id'),
                          'product_price' => $product['price'],
                          'product_description' => $product['description'],
                          'product_main_image' => base_url('assets/uploads/files/'.$product['main_image']),
                          'product_rate'  => get_avg($product['id'])
                      ];
            if ($result) {
              $data['status'] = true;
              $data['product']['details'] = $result;
              $product_images = get_table('product_images',['product_id'=>$product['id']]);
              $images = [];
              if ($product_images) {
                foreach ($product_images as $image) {
                  $images[] = [
                                    'image_source' => base_url('assets/uploads/files/'.$image->image_name)
                              ];
                }
              }
              $product_colors = get_table('product_colors',['product_id'=>$product['id']]);
              $colors = [];
              if ($product_colors) {
                foreach ($product_colors as $color) {
                  $colors[] = [
                                    'id'    => $color->id,
                                    'color' => $color->color
                              ];
                }
              }
              $data['product']['images'] = $images;
              $data['product']['colors'] = $colors;
              $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
          }else{
            $data['status'] = false;
            $data['message'] = 'عفوا لا توجد اي منتجات بهذا الرقم';
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
          }
      }
    }
    public function product_comments_post(){
      $this->load->library('form_validation');
      $this->form_validation->set_rules('product_id', 'رقم التصنيف', 'trim|required|numeric');
      $this->form_validation->set_rules('limit', 'عدد العناصر الظاهرة', 'trim|required|numeric');
      $this->form_validation->set_rules('page_number', 'رقم الصفحة', 'trim|required|numeric');
      if($this->form_validation->run() === FALSE){
          $data['status'] = false;
          if(form_error('product_id'))
              $data['product_id_error'] = strip_tags(form_error('product_id'));
          if(form_error('limit'))
              $data['limit_error'] = strip_tags(form_error('limit'));
          if(form_error('page_number'))
              $data['page_number_error'] = strip_tags(form_error('page_number'));      
          $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
      }else{
          $comments_num = get_table('product_comments',['product_id'=>$this->post('product_id')],'count');
          $offset = $this->post('limit') * $this->post('page_number');
          $where['product_id'] = $this->post('product_id');
          $product_comments = $this->db->order_by('created_at','DESC')
                                       ->order_by('time','DESC')
                                       ->get_where('product_comments',$where,$this->post('limit'),$offset)
                                       ->result();
          if ($product_comments) {
              foreach ($product_comments as $comment) {
                $comments[] = [
                                    'comment_id'     => $comment->id,
                                    'comment_owner'  => get_this('customers',['id'=>$comment->user_id],'full_name'),
                                    'comment_date'   => $comment->created_at,
                                    'comment_time'   => $comment->time,
                                    'comment'        => $comment->comment
                              ];
              }
              if ($comments) {
                  $data['comments_number'] = $comments_num;
                  $data['comments'] = $comments;
                  $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
              }
          }else{
            $data['status'] = false;
            $data['message'] = 'عفوا لا توجد اي تعليقات تخص هذا المنتج';
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
          }
      }
    }
    public function add_comment_post(){
      $this->load->library('form_validation');
      $this->form_validation->set_rules('user_id', 'رقم المستخدم', 'trim|required|numeric');
      $this->form_validation->set_rules('product_id', 'رقم المنتج', 'trim|required|numeric');
      $this->form_validation->set_rules('comment', 'التعليق', 'trim|required');
      if($this->form_validation->run() === FALSE){
          $data['status'] = false;
          if(form_error('user_id'))
              $data['user_id_error'] = strip_tags(form_error('user_id'));
          if(form_error('product_id'))
              $data['product_id_error'] = strip_tags(form_error('product_id'));
          if(form_error('comment'))
              $data['comment_error'] = strip_tags(form_error('comment'));
          $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
      }else{
           $customer = get_this('customers',['id'=>$this->post('user_id')]);
           if ($customer) {
               if ($customer['status'] == 1) {
                   if ($customer['confirmed'] == 1) {
                       $store = [
                                  'user_id'     => $this->post('user_id'),
                                  'product_id'  => $this->post('product_id'),
                                  'comment'     => $this->post('comment'),
                                  'created_at'  => date('Y-m-d'),
                                  'time'        => date('h:i:s')
                                ];
                       $insert = $this->Main_model->insert('product_comments',$store);
                       if($insert){
                          $data['status'] = true;
                          $data['message'] = 'تم اضافة التعليق بنجاح';
                          $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                       }else{
                          $data['status'] = false;
                          $data['message'] = 'خطأ في الانشاء';
                          $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                       }
                   }else{
                       $data['status'] = false;
                       $data['message'] = 'حساب لم تتم الموافقه عليه من قبل الادارة';
                       $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                   }
               }else{
                   $data['status'] = false;
                   $data['message'] = 'حساب غير مفعل';
                   $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
               }
           }else{
               $data['status'] = false;
               $data['message'] = 'عفوا لا توجد اي بيانات لهذا المستخدم';
               $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
           }
      }
    }
    public function rate_product_post(){
      $this->load->library('form_validation');
      $this->form_validation->set_rules('user_id', 'رقم المستخدم', 'trim|required|numeric');
      $this->form_validation->set_rules('product_id', 'رقم المنتج', 'trim|required|numeric');
      $this->form_validation->set_rules('rate', 'التقييم', 'trim|required|numeric|greater_than[0]|less_than[6]');
      if($this->form_validation->run() === FALSE){
          $data['status'] = false;
          if(form_error('user_id'))
              $data['user_id_error'] = strip_tags(form_error('user_id'));
          if(form_error('product_id'))
              $data['product_id_error'] = strip_tags(form_error('product_id'));
          if(form_error('rate'))
              $data['rate_error'] = strip_tags(form_error('rate'));
          $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
      }else{
            $customer = get_this('customers',['id'=>$this->post('user_id')]);
            if ($customer) {
                if ($customer['status'] == 1) {
                    if ($customer['confirmed'] == 1) {
                        $rated_before = get_this('product_rates',['user_id'=>$this->post('user_id'),'product_id'=>$this->post('product_id')]);
                        if ($rated_before) {
                            $data['status'] = false;
                            $data['message'] = 'عفوا لقد قمت من قبل بتقييم هذا المنتج';
                            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                        }else{
                            $store =  [
                                          'user_id'     => $this->post('user_id'),
                                          'product_id' => $this->post('product_id'),
                                          'rate'        => $this->post('rate'),
                                          'created_at'     => date('Y-m-d'),
                                      ];
                            $insert = $this->Main_model->insert('product_rates',$store);
                            if($insert){
                                $data['status'] = true;
                                $data['message'] = 'تم تقييم المنتج بنجاح';
                                $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                            }else{
                                $data['status'] = false;
                                $data['message'] = 'خطأ في الانشاء';
                                $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                            }
                        }
                    }else{
                       $data['status'] = false;
                       $data['message'] = 'حساب لم تتم الموافقه عليه من قبل الادارة';
                       $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                   }
                }else{
                   $data['status'] = false;
                   $data['message'] = 'حساب غير مفعل';
                   $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
               }
            }else{
               $data['status'] = false;
               $data['message'] = 'عفوا لا توجد اي بيانات لهذا المستخدم';
               $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
           }
      }
    }
    public function search_product_post(){
      $this->load->library('form_validation');
      $this->form_validation->set_rules('product_name', 'اسم المنتج', 'trim|required');
      $this->form_validation->set_rules('limit', 'عدد العناصر الظاهره', 'trim|required|numeric');
      $this->form_validation->set_rules('page_number', 'رقم الصفحه', 'trim|required|numeric');
      if($this->post('store_name') === "" || $this->post('store_name') != null)
            $this->form_validation->set_rules('store_name', 'اسم المتجر', 'trim|required');
      if($this->post('category_id') === "" || $this->post('category_id') != null)
            $this->form_validation->set_rules('category_id', 'رقم التصنيف', 'trim|required');
      if($this->form_validation->run() === FALSE){
          $data['status'] = false;
          if(form_error('product_name'))
              $data['product_name_error'] = strip_tags(form_error('product_name'));
          if(form_error('store_name'))
              $data['store_name_error'] = strip_tags(form_error('store_name'));
          if(form_error('category_id'))
              $data['category_id_error'] = strip_tags(form_error('category_id'));
          if(form_error('limit'))
                $data['limit_error'] = strip_tags(form_error('limit'));
          if(form_error('page_number'))
                $data['page_number_error'] = strip_tags(form_error('page_number'));    
          $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
      }else{
          $offset = $this->post('limit') * $this->post('page_number');
          $where['products.status'] = 1;
          $like['name'] = $this->post('product_name');
          if ($this->post('category_id'))
              $where['category_id'] = $this->post('category_id');
          if ($this->post('store_name'))
              $like['merchants.store_name'] = $this->post('store_name');  
          $where['merchants.status'] = 1;
          $where['merchants.confirmed'] = 1;  
          $products = $this->db->join('merchants','merchants.id=products.created_by')
                               ->like($like,'both')
                               ->get_where('products',$where,$this->post('limit'),$offset)
                               ->result();
          $products_count = count($products);
          if ($products) {
              foreach ($products as $product) {
                $result[] = [
                                'product_id'         => $product->id,
                                'product_name'       => $product->name,
                                'product_price'      => $product->price,
                                'product_main_image' => base_url('assets/uploads/files/'.$product->main_image),
                            ];  
              }
              if ($result) {
                  $data['search_results_number'] = $products_count;
                  $data['search_results'] = $result;
                  $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
              }
          }else{
              $data['status'] = false;
              $data['message'] = 'عفوا لا توجد اي نتائج للبحث';
              $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
          }  

      }    
    }
    public function tickets_types_post(){
      $tickets_types = get_table('tickets_types');
      if ($tickets_types) {
        foreach ($tickets_types as $method) {
          $result[] = [
                          'type_id' => $method->id,
                          'name'      => $method->name,
                      ];
        }
            if ($result) {
              $data['status'] = true;
              $data['tickets_types'] = $result;
              $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
      }else{
        $data['status'] = true;
        $data['tickets_types'] = [];
        $data['message'] = 'عفوا لا توجدياي انواع للتذاكر مخزنة بقاعدة البيانات';
        $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
       } 
    }
    public function new_ticket_post(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_id', 'رقم المستخدم', 'trim|required|numeric');
        $this->form_validation->set_rules('ticket_type_id', 'نوع المراسلة', 'trim|required|numeric');
        $this->form_validation->set_rules('content', 'المحتوى', 'trim|required');
        if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('user_id'))
                $data['user_id_error'] = strip_tags(form_error('user_id'));
            if(form_error('ticket_type_id'))
                $data['ticket_type_id_error'] = strip_tags(form_error('ticket_type_id'));
            if(form_error('content'))
                $data['content_error'] = strip_tags(form_error('content'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
               $customer = get_this('customers',['id'=>$this->post('user_id')]);
               if ($customer) {
                   if ($customer['status'] == 1) {
                       if ($customer['confirmed'] == 1) {
                            $store = [
                                        'created_by'     => $this->post('user_id'),
                                        'ticket_type_id' => $this->post('ticket_type_id'),
                                        'content'        => $this->post('content'),
                                        'created_at'     => date('Y-m-d'),
                                        'type'           => 1
                                      ];
                            $insert = $this->Main_model->insert('tickets',$store);
                            if($insert){
                                $data['status'] = true;
                                $data['message'] = 'تم انشاء التذكرة بنجاح';
                                $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                            }else{
                                $data['status'] = false;
                                $data['message'] = 'خطأ في الانشاء';
                                $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                            }
                       }else{
                           $data['status'] = false;
                           $data['message'] = 'حساب لم تتم الموافقه عليه من قبل الادارة';
                           $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                       }
                   }else{
                       $data['status'] = false;
                       $data['message'] = 'حساب غير مفعل';
                       $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                   }
               }else{
                   $data['status'] = false;
                   $data['message'] = 'عفوا لا توجد اي بيانات لهذا المستخدم';
                   $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
               }
        }
    }
    public function new_reply_post(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('ticket_id', 'رقم التذكرة', 'trim|required|numeric');
        $this->form_validation->set_rules('user_id', 'رقم المستخدم', 'trim|required|numeric');
        $this->form_validation->set_rules('content', 'المحتوى', 'trim|required');
        if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('ticket_id'))
                $data['ticket_id_error'] = strip_tags(form_error('ticket_id'));
            if(form_error('user_id'))
                $data['user_id_error'] = strip_tags(form_error('user_id'));
            if(form_error('content'))
                $data['content_error'] = strip_tags(form_error('content'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
              $customer = get_this('customers',['id'=>$this->post('user_id')]);
               if ($customer) {
                   if ($customer['status'] == 1) {
                       if ($customer['confirmed'] == 1) {
                            $ticket = get_this('tickets',['id'=>$this->post('ticket_id')]);
                            if ($ticket) {
                                $store = [
                                      'created_by' => $this->post('user_id'),
                                      'ticket_id'  => $this->post('ticket_id'),
                                      'content'    => $this->post('content'),
                                      'created_at' => date('Y-m-d'),
                                      'reply_type' => 1,
                                      'created_at' => date('Y-m-d'),
                                      'time'       => date('h:i:s')
                                    ];
                                $insert = $this->Main_model->insert('tickets_replies',$store);
                                if($insert){
                                    $data['status'] = true;
                                    $data['message'] = 'تم ارسال الرد بنجاح';
                                    $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                                }else{
                                    $data['status'] = false;
                                    $data['message'] = 'خطأ في الارسال';
                                    $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                                }
                            }else{
                                $data['status'] = false;
                                $data['message'] = 'عفوا لا توجد تذاكر بهذا الرقم';
                                $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                            }
                       }else{
                           $data['status'] = false;
                           $data['message'] = 'حساب لم تتم الموافقه عليه من قبل الادارة';
                           $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                       }
                   }else{
                       $data['status'] = false;
                       $data['message'] = 'حساب غير مفعل';
                       $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                   }
               }else{
                   $data['status'] = false;
                   $data['message'] = 'عفوا لا توجد اي بيانات لهذا المستخدم';
                   $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
               }
        }
    }
    public function tickets_post(){
      $this->load->library('form_validation');
      $this->form_validation->set_rules('user_id', 'رقم المستخدم', 'trim|required|numeric');
      $this->form_validation->set_rules('limit', 'عدد العناصر الظاهره', 'trim|required|numeric');
      $this->form_validation->set_rules('page_number', 'رقم الصفحه', 'trim|required|numeric');
      if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('user_id'))
                $data['user_id_error'] = strip_tags(form_error('user_id'));
            if(form_error('limit'))
                $data['limit_error'] = strip_tags(form_error('limit'));
            if(form_error('page_number'))
                $data['page_number_error'] = strip_tags(form_error('page_number'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
          $user_info = get_this('customers',['id' => $this->post('user_id')]);
          if ($user_info) {
              if ($user_info['status'] == 1) {
                  if ($user_info['confirmed'] == 1) {
                      $offset = $this->post('limit') * $this->post('page_number');
                      $where['created_by'] = $user_info['id'];
                      $where['type'] = 1;
                      $tickets = $this->db->order_by('created_at','DESC')
                                          ->get_where('tickets',$where,$this->post('limit'),$offset)
                                          ->result();
                      if ($tickets) {
                        foreach ($tickets as $ticket) {
                          $result[] = [
                                            'id'      => $ticket->id,
                                            'title'   => get_this('tickets_types',['id' => $ticket->ticket_type_id],'name'),
                                            'content' => $ticket->content
                                      ];
                        }
                          if ($result) {
                                  $data['status'] = true;
                                  $data['my_tickets'] = $result;
                                  $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                              }
                      }else{
                            $data['status'] = false;
                            $data['message'] = 'عفوا لا توجد اي تذاكر خاصه بك';
                            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                     } 
                  }else{
                      $data['status'] = false;
                      $data['message'] = 'حساب لم تتم الموافقه عليه من قبل الادارة';
                      $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                  }
              }else{
                  $data['status'] = false;
                  $data['message'] = 'حساب غير مفعل';
                  $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
              }
          }else{
             $data['status'] = false;
             $data['message'] = 'عفوا لا توجد اي بيانات لهذا المستخدم';
             $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
          }
        }
    }
    public function ticket_post(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_id', 'رقم المستخدم', 'required|numeric');
        $this->form_validation->set_rules('ticket_id', 'رقم التذكرة', 'required|numeric');
        if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('user_id'))
                $data['user_id_error'] = strip_tags(form_error('user_id'));
            if(form_error('ticket_id'))
                $data['ticket_id_error'] = strip_tags(form_error('ticket_id'));  
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
          $user_info = get_this('customers',['id' => $this->post('user_id')]);
          if ($user_info) {
              if ($user_info['status'] == 1) {
                  if ($user_info['confirmed'] == 1) {
                      $ticket = get_this('tickets',['id'=>$this->post('ticket_id'),'created_by'=>$this->post('user_id'),'type'=>1]);
                      if ($ticket) {
                            $result = [
                                            'ticket_id' => $ticket['id'],
                                            'title'     => get_this('tickets_types',['id' => $ticket['ticket_type_id']],'name'),
                                            'content'   => $ticket['content']
                                        ];
                           if ($result) {
                                $data['status'] = true;
                                $data['ticket_info']['ticket'] = $result;
                                $ticket_replies = get_table('tickets_replies',['ticket_id'=>$ticket['id']]);
                                $replies = [];
                                if ($ticket_replies) {
                                  foreach ($ticket_replies as $reply) {
                                            $replies[] =[
                                                          'id'         => $reply->id,
                                                          'created_at' => $reply->created_at,
                                                          'time'       => $reply->time,
                                                          'content'    => $reply->content,
                                                          'sender'     => ($reply->reply_type == '2') ? 'خدمة العملاء' : get_this('customers',['id' => $reply->created_by],'full_name')
                                                        ]; 
                                 }
                                 $data['ticket_info']['replies_number'] = get_table('tickets_replies',['ticket_id'=>$ticket['id']],'count');
                                 $data['ticket_info']['ticket_replies'] = $replies;
                                }else{
                                  $data['ticket_info']['ticket_replies'] = [];
                                }
                                $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                           }
                      }else{
                          $data['status'] = true;
                          $data['ticket'] = [];
                          $data['message'] = 'عفوا لا توجد اي تذاكر بهذه الارقام';
                          $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                      } 
                  }else{
                      $data['status'] = false;
                      $data['message'] = 'حساب لم تتم الموافقه عليه من قبل الادارة';
                      $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                  }
              }else{
                  $data['status'] = false;
                  $data['message'] = 'حساب غير مفعل';
                  $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
              }
          }else{
             $data['status'] = false;
             $data['message'] = 'عفوا لا توجد اي بيانات لهذا المستخدم';
             $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
          }
        }
    }
    public function my_favourite_post(){
      $this->load->library('form_validation');
      $this->form_validation->set_rules('user_id', 'رقم المستخدم', 'required|numeric');
      $this->form_validation->set_rules('limit', 'عدد العناصر الظاهره', 'trim|required|numeric');
      $this->form_validation->set_rules('page_number', 'رقم الصفحه', 'trim|required|numeric');
        if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('user_id'))
                $data['user_id_error'] = strip_tags(form_error('user_id'));
            if(form_error('limit'))
                $data['limit_error'] = strip_tags(form_error('limit'));
            if(form_error('page_number'))
                $data['page_number_error'] = strip_tags(form_error('page_number'));  
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
          $customer = get_this('customers',['id'=>$this->post('user_id')]);
               if ($customer) {
                   if ($customer['status'] == 1) {
                       if ($customer['confirmed'] == 1) {
                           $offset = $this->get('limit') * $this->get('page_number');
                           $where['customer_favourites.user_id'] = $this->post('user_id');
                           $where['products.status'] = 1;
                           $favourites = $this->db->select('*')
                                                  ->order_by('customer_favourites.created_at','DESC')
                                                  ->group_by('product_id')
                                                  ->join('customer_favourites','product_id=products.id')
                                                  ->get_where('products',$where, $this->get('limit'), $offset)
                                                  ->result();
                           if ($favourites) {
                               foreach ($favourites as $item) {
                                 $result[] = [
                                                // 'id'                 => $item->id,
                                                'product_id'         => $item->product_id,
                                                'user_id'            => $item->user_id,
                                                'product_name'       => $item->name,
                                                'product_price'      => $item->price,
                                                'product_main_image' =>  base_url('assets/uploads/files/'.$item->main_image)
                                             ];  
                               }
                               if($result){
                                 $data['status'] = true;
                                 $data['my_favourite'] = $result;
                                 $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                               }
                           }else{
                             $data['status'] = false;
                             $data['message'] = 'عفوا لا توجد لديك اي منتجات بقائمة المفضله';
                             $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code    
                           } 
                       }else{
                           $data['status'] = false;
                           $data['message'] = 'حساب لم تتم الموافقه عليه من قبل الادارة';
                           $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                       }
                   }else{
                       $data['status'] = false;
                       $data['message'] = 'حساب غير مفعل';
                       $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                   }
               }else{
                   $data['status'] = false;
                   $data['message'] = 'عفوا لا توجد اي بيانات لهذا المستخدم';
                   $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
               }                 
        }
    }
    public function add_to_favourite_post(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_id', 'رقم المستخدم', 'trim|required|numeric');
        $this->form_validation->set_rules('product_id', 'رقم المنتج', 'trim|required|numeric');
        if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('user_id'))
                $data['user_id_error'] = strip_tags(form_error('user_id'));
            if(form_error('product_id'))
                $data['product_id_error'] = strip_tags(form_error('product_id'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
              $customer = get_this('customers',['id'=>$this->post('user_id')]);
               if ($customer) {
                   if ($customer['status'] == 1) {
                       if ($customer['confirmed'] == 1) {
                        $product = get_this('products',['id'=>$this->post('product_id')]);
                        if ($product) {
                            $added_befor = get_this('customer_favourites',['user_id'=>$this->post('user_id'),'product_id'=>$this->post('product_id')]);
                           if ($added_befor) {
                               $data['status'] = false;
                               $data['message'] = 'عفوا لقد قمت باضافة هذا المنتج من قبل الى قائمة المفضله';
                               $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                           }else{
                               $store = [
                                          'user_id'     => $this->post('user_id'),
                                          'product_id' => $this->post('product_id'),
                                          'created_at'     => date('Y-m-d'),
                                        ];
                                $insert = $this->Main_model->insert('customer_favourites',$store);
                                if($insert){
                                    $data['status'] = true;
                                    $data['message'] = 'تمت الاضافة بنجاح';
                                    $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                                }else{
                                    $data['status'] = false;
                                    $data['message'] = 'خطأ في الانشاء';
                                    $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                                }
                           }
                        }else{
                            $data['status'] = false;
                            $data['message'] = 'عفوا لا توجد اي منتجات بهذا الرقم';
                            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                        }
                           /*$added_befor = get_this('customer_favourites',['user_id'=>$this->post('user_id'),'product_id'=>$this->post('product_id')]);
                           if ($added_befor) {
                               $data['status'] = false;
                               $data['message'] = 'عفوا لقد قمت باضافة هذا المنتج من قبل الى قائمة المفضله';
                               $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                           }else{
                               $store = [
                                          'user_id'     => $this->post('user_id'),
                                          'product_id' => $this->post('product_id'),
                                          'created_at'     => date('Y-m-d'),
                                        ];
                                $insert = $this->Main_model->insert('customer_favourites',$store);
                                if($insert){
                                    $data['status'] = true;
                                    $data['message'] = 'تمت الاضافة بنجاح';
                                    $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                                }else{
                                    $data['status'] = false;
                                    $data['message'] = 'خطأ في الانشاء';
                                    $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                                }
                           }*/
                       }else{
                           $data['status'] = false;
                           $data['message'] = 'حساب لم تتم الموافقه عليه من قبل الادارة';
                           $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                       }
                   }else{
                       $data['status'] = false;
                       $data['message'] = 'حساب غير مفعل';
                       $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                   }
               }else{
                   $data['status'] = false;
                   $data['message'] = 'عفوا لا توجد اي بيانات لهذا المستخدم';
                   $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
               }
             /*$added_befor = get_this('customer_favourites',['user_id'=>$this->post('user_id'),'product_id'=>$this->post('product_id')]);
             if ($added_befor) {
                 $data['status'] = false;
                 $data['message'] = 'عفوا لقد قمت باضافة هذا المنتج من قبل الى قائمة المفضله';
                 $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
             }else{
                 $store = [
                            'user_id'     => $this->post('user_id'),
                            'product_id' => $this->post('product_id'),
                            'created_at'     => date('Y-m-d'),
                          ];
                  $insert = $this->Main_model->insert('customer_favourites',$store);
                  if($insert){
                      $data['status'] = true;
                      $data['message'] = 'تمت الاضافة بنجاح';
                      $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                  }else{
                      $data['status'] = false;
                      $data['message'] = 'خطأ في الانشاء';
                      $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                  }
             }*/
        }
    }
    public function remove_from_favourite_post(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_id', 'رقم المستخدم', 'trim|required|numeric');
        $this->form_validation->set_rules('product_id', 'رقم المنتج', 'trim|required|numeric');
        if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('user_id'))
                $data['user_id_error'] = strip_tags(form_error('user_id'));
            if(form_error('product_id'))
                $data['product_id_error'] = strip_tags(form_error('product_id'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
              $customer = get_this('customers',['id'=>$this->post('user_id')]);
               if ($customer) {
                   if ($customer['status'] == 1) {
                       if ($customer['confirmed'] == 1) {
                           $added_befor = get_this('customer_favourites',['user_id'=>$this->post('user_id'),'product_id'=>$this->post('product_id')]);
                           if ($added_befor) {
                                $where['user_id'] = $added_befor['user_id'];
                                $where['product_id'] = $added_befor['product_id'];
                                $this->db->where($where)->delete('customer_favourites');
                                $data['status'] = true;
                                $data['message'] = 'تم الحذف بنجاح';
                                $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                           }else{
                               $data['status'] = false;
                               $data['message'] = 'عفوا هذا المنتج غير موجود بقائمة المفضله لديك';
                               $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                           }  
                       }else{
                           $data['status'] = false;
                           $data['message'] = 'حساب لم تتم الموافقه عليه من قبل الادارة';
                           $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                       }
                   }else{
                       $data['status'] = false;
                       $data['message'] = 'حساب غير مفعل';
                       $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                   }
               }else{
                   $data['status'] = false;
                   $data['message'] = 'عفوا لا توجد اي بيانات لهذا المستخدم';
                   $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
               }
             /*$added_befor = get_this('customer_favourites',['user_id'=>$this->post('user_id'),'product_id'=>$this->post('product_id')]);
             if ($added_befor) {
                  $where['user_id'] = $added_befor['user_id'];
                  $where['product_id'] = $added_befor['product_id'];
                  $this->db->where($where)->delete('customer_favourites');
                  $data['status'] = true;
                  $data['message'] = 'تم الحذف بنجاح';
                  $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
             }else{
                 $data['status'] = false;
                 $data['message'] = 'عفوا هذا المنتج غير موجود بقائمة المفضله لديك';
                 $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
             }*/
        }
    }
    public function register_post(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('full_name', 'الاسم بالكامل', 'trim|required');
        $this->form_validation->set_rules('phone', 'رقم الجوال', 'trim|required|numeric|is_unique[customers.phone]');
        $this->form_validation->set_rules('country_id', 'الدولة', 'trim|required|numeric');
        $this->form_validation->set_rules('city_id', 'المدينة', 'trim|required|numeric');
        $this->form_validation->set_rules('password', 'كلمة المرور', 'trim|required|min_length[6]');
        if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('full_name'))
                $data['full_name_error'] = strip_tags(form_error('full_name'));
            if(form_error('phone'))
                $data['phone_error'] = strip_tags(form_error('phone'));
            if(form_error('country_id'))
                $data['country_id_error'] = strip_tags(form_error('country_id'));
            if(form_error('city_id'))
                $data['city_id_error'] = strip_tags(form_error('city_id'));
            if(form_error('password'))
                $data['password_error'] = strip_tags(form_error('password'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
               $store = [
                          'full_name'           => $this->post('full_name'),
                          'phone'               => $this->post('phone'),
                          'country_id'          => $this->post('country_id'),
                          'city_id'             => $this->post('city_id'),
                          'password'            => md5(md5(md5(sha1($this->post('password'))))),
                          'created_at'          => date('Y-m-d'),
                          'status'              => 0,
                          'confirmed'           => 1
                        ];
	             $insert = $this->Main_model->insert('customers',$store);
	             if($insert){
	              	  $customer_info = get_this('customers',['id' => $insert]);
	              	  unset($customer_info['email']);
	              	  unset($customer_info['password']);
                    $customer_info['activation_status'] = 'حساب غير مفعل';
	                  $data['status'] = true;
	                  $data['message'] = 'من فضلك ادخل كود التفعيل المرسل اليك';
	                  $data['customer'] = $customer_info;
	                  $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
	             }else{
	                  $data['status'] = false;
	                  $data['message'] = 'خطأ في التسجيل';
	                  $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
	             }
        }
    }
    public function send_sms_post(){
    	$this->load->library('form_validation');
        $this->form_validation->set_rules('phone', 'رقم الجوال', 'required');
        if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('phone'))
                $data['phone_error'] = strip_tags(form_error('phone'));
            	$this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
          $verification_info = get_this('mobile_numbers',['mobile_number'=>$this->post('phone')]);
          if ($verification_info) {
              $code = $verification_info['verification_code'];
          }else{
              $code = generate_verification_code();
          }
          $phone = $this->post('phone');
          $phone1 = ltrim($phone, '0');
          $country_id = get_this('customers',['phone' => $phone],'country_id');
          $international_key = get_this('countries',['id'=>$country_id],'international_key');
          $reciever = $international_key.$phone1;
        	$store = [
              				'mobile_number'     => $phone,
              				'verification_code' => $code,
              				'verified '         => 0
        			     ];
	        $sms = new MobilySms('966507717440','159789','88f55e6be5eed49301496725879b72ac');
    			$msg = "عزيزي (1)، كود التفعيل الخاص بك هو (2)";
    			$msgKey = "(1),*,$reciever,@,(2),*,$code";
    			$numbers = $reciever;
    			$result = $sms->sendMsgWK($msg,$numbers,'Makzan',$msgKey,'12:00:00',now(),0,'deleteKey','curl');
            $message_info = json_decode($result);
    			if($message_info->ResponseStatus == 'success'){
    			    $id = $this->Main_model->insert('mobile_numbers',$store);
    				  $data['status'] = true;
	            $data['message'] = 'تم ارسال كود التفعيل بنجاح';
	            $data['phone'] = $this->post('phone');
	            $data['verification_code'] = $code;
	            $data['verification_code_id'] = $id;
	            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
    			}else{
              $this->response($message_info, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
          }
        }
    }
    public function confirm_registration_post(){
    	$this->load->library('form_validation');
        $this->form_validation->set_rules('phone', 'رقم الجوال', 'trim|required|numeric');
        $this->form_validation->set_rules('verification_code', 'كود التفعيل', 'trim|required|exact_length[6]');
        $this->form_validation->set_rules('id', 'رقم عملية الارسال', 'trim|required');
        if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('phone'))
                $data['phone_error'] = strip_tags(form_error('phone'));
            if(form_error('verification_code'))
                $data['verification_code_error'] = strip_tags(form_error('verification_code'));
            if(form_error('id'))
                $data['id_error'] = strip_tags(form_error('id'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
        	$customer_info = get_this('customers',['phone'=>$this->post('phone'),'status'=>0]);
        	if ($customer_info) {
        		$verification_info = get_this('mobile_numbers',['mobile_number'=>$customer_info['phone'],'verification_code'=>$this->post('verification_code'),'verified'=>0]);
        		if ($verification_info) {
        			// $store = ['verified' => 1];
        			$update = ['status' => 1];
        			// $this->Main_model->update('mobile_numbers',['id'=>$verification_info['id']],$store);
        			$this->Main_model->update('customers',['phone'=>$customer_info['phone']],$update);
              $this->db->where('mobile_number',$customer_info['phone'])->delete('mobile_numbers');
        			$data['status'] = true;
              $data['message'] = 'تم تفعيل الحساب بنجاح  يرجي انتظار موافقة الادارة';
              $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        		}else{
        			$data['status'] = false;
              $data['message'] = 'يرجى التأكد من كود التفعيل واعادة المحاولة';
              $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        		}
        	}else{
        		$data['status'] = false;
            $data['message'] = 'عفوا لا توجد اي بيانات تخص هذا التاجر';
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        	}
    	}
    }
    public function login_post(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('phone', 'رقم الجوال', 'required|numeric');
        $this->form_validation->set_rules('password', 'كلمة المرور', 'required');
        if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('phone'))
                $data['phone_error'] = strip_tags(form_error('phone'));
            if(form_error('password'))
                $data['password_error'] = strip_tags(form_error('password'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $customer_info = get_this('customers',['phone'=>$this->post('phone'),'password'=>md5(md5(md5(sha1($this->post('password')))))]);
            if ($customer_info) {
                if ($customer_info['status'] == 0) {
                     $data['status'] = false;
                     $data['message'] = 'عفوا فلم يتم تفعيل الحساب';
                     $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                }else{
                     if ($customer_info['confirmed'] == 1) {
                         unset($customer_info['password']);
                         $customer_info['country'] = get_this('countries',['id'=>$customer_info['country_id']],'name');
                         $customer_info['city'] = get_this('cities',['id'=>$customer_info['city_id']],'name');
                         $customer_info['activation_status'] = 'حساب مفعل';
                         $customer_info['confirmed_by_admin'] = 'حساب موافق عليه';
                         $customer_info['image'] = base_url('assets/uploads/files/'.$customer_info['image']);
                         $data['status'] = true;
                         $data['customer_info'] = $customer_info;
                         $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                     }else{
                         $data['status'] = false;
                         $data['message'] = 'حساب لم تتم الموافقه عليه من قبل الادارة';
                         $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                     }
                }
            }else{
                $data['status'] = false;
                $data['message'] = 'يرجى التاكد من رقم الجوال وكلمة المرور';
                $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } 
        }
    }
    public function forget_password_post(){
      $this->load->library('form_validation');
      $this->form_validation->set_rules('phone', 'رقم الجوال', 'trim|required|numeric');
      $this->form_validation->set_rules('verified', 'حالة كود التفعيل', 'trim|required|numeric');
      if ($this->input->post('verified') == 1) {
        $this->form_validation->set_rules('verification_code', 'كود التفعيل', 'trim|required|exact_length[6]');
        $this->form_validation->set_rules('id', 'رقم عملية الارسال', 'trim|required');
        $this->form_validation->set_rules('password', 'كلمة المرور الجديدة', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'تأكيد كلمة المرور', 'trim|required|matches[password]');
        if($this->form_validation->run() === FALSE){
          $data['status'] = false;
          if(form_error('phone'))
              $data['phone_error'] = strip_tags(form_error('phone'));
          if(form_error('verification_code'))
              $data['verification_code_error'] = strip_tags(form_error('verification_code'));
          if(form_error('id'))
              $data['id_error'] = strip_tags(form_error('id'));
          if(form_error('password'))
                $data['password_error'] = strip_tags(form_error('password'));
          if(form_error('confirm_password'))
                $data['confirm_password_error'] = strip_tags(form_error('confirm_password'));
          $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
          $customer_info = get_this('customers',['phone'=>$this->post('phone'),'status'=>1]);
            if ($customer_info) {
              $verification_info = get_this('mobile_numbers',['mobile_number'=>$customer_info['phone'],'verification_code'=>$this->post('verification_code'),'verified'=>0]);
              if ($verification_info) {
                // $store = ['verified' => 1];
                $update = ['password' => md5(md5(md5(sha1($this->post('password')))))];
                $this->Main_model->update('customers',['phone'=>$customer_info['phone']],$update);
                // $this->Main_model->update('mobile_numbers',['id'=>$verification_info['id']],$store);
                $this->db->where('mobile_number',$customer_info['phone'])->delete('mobile_numbers');
                $data['status'] = true;
                $data['message'] = 'تم تغيير كلمة المرور بنجاح';
                $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
              }else{
                $data['status'] = false;
                $data['message'] = 'يرجى التاكد من البيانات المدخله واعادة المحاولة';
                $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
              }
            }else{
              $data['status'] = false;
              $data['message'] = 'عفوا لا توجد اي بيانات تخص هذا المستخدم';
              $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
        }
      }else{
          
          $data['verified'] = $this->input->post('verified');
        $data['status'] = false;
        $data['message'] = 'يرجى التأكد من كود التفعيل واعادة المحاولة';
        $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
              }
    }
    public function store_post(){
      $this->load->library('form_validation');
      $this->form_validation->set_rules('merchant_id', 'رقم التاجر', 'trim|required|numeric');
      $this->form_validation->set_rules('limit', 'عدد العناصر الظاهره', 'trim|required|numeric');
      $this->form_validation->set_rules('page_number', 'رقم الصفحه', 'trim|required|numeric');
      if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('merchant_id'))
                $data['merchant_id_error'] = strip_tags(form_error('merchant_id'));
            if(form_error('limit'))
                $data['limit_error'] = strip_tags(form_error('limit'));
            if(form_error('page_number'))
                $data['page_number_error'] = strip_tags(form_error('page_number'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
          $merchant_info = get_this('merchants',['id' => $this->post('merchant_id')]);
          if ($merchant_info) {
              if ($merchant_info['status'] == 1) {
                 if ($merchant_info['confirmed'] == 1) {
                     $store_info = [
                      'store_name'  => $merchant_info['store_name'],
                      'store_image' => base_url('assets/uploads/files/'.$merchant_info['image'])
                    ];
                      $offset = $this->post('limit') * $this->post('page_number');
                      $where['created_by'] = $merchant_info['id'];
                      $products = $this->db->order_by('created_at','DESC')
                                           ->get_where('products',$where,$this->post('limit'),$offset)
                                           ->result();
                      if ($products) {
                        foreach ($products as $product) {
                          $result[] = [
                                          'id'                 => $product->id,
                                          'name'               => $product->name,
                                          'price'              => $product->price,
                                          'product_rate'       => get_avg($product->id),
                                          'main_image'         => base_url('assets/uploads/files/'.$product->main_image)
                                ];
                        }
                          if ($result) {
                                  $data['status'] = true;
                                  $data['store'] = $store_info;
                                  $data['store_products'] = $result;
                                  $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                              }
                      }else{
                            $data['status'] = false;
                            $data['my_products'] = [];
                            $data['message'] = 'عفوا لا توجد اي منتجات خاصه بهذا التاجر';
                            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                     }   
                 }else{
                     $data['status'] = false;
                     $data['message'] = 'حساب لم تتم الموافقه عليه من قبل الادارة';
                     $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                 }
                   }else{
                       $data['status'] = false;
                       $data['message'] = 'حساب غير مفعل';
                       $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                   }
            /*$store_info = [
                            'store_name'  => $merchant_info['store_name'],
                            'store_image' => base_url('assets/uploads/files/'.$merchant_info['image'])
                          ];
            $offset = $this->post('limit') * $this->post('page_number');
            $where['created_by'] = $merchant_info['id'];
            $products = $this->db->order_by('created_at','DESC')
                                 ->get_where('products',$where,$this->post('limit'),$offset)
                                 ->result();
            if ($products) {
              foreach ($products as $product) {
                $result[] = [
                                'id'                 => $product->id,
                                'name'               => $product->name,
                                'price'              => $product->price,
                                'product_rate'       => get_avg($product->id),
                                'main_image'         => base_url('assets/uploads/files/'.$product->main_image)
                      ];
              }
                if ($result) {
                        $data['status'] = true;
                        $data['store'] = $store_info;
                        $data['store_products'] = $result;
                        $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                    }
            }else{
                  $data['status'] = false;
                  $data['my_products'] = [];
                  $data['message'] = 'عفوا لا توجد اي منتجات خاصه بك';
                  $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
           }*/  
          }else{
             $data['status'] = false;
             $data['message'] = 'عفوا لا توجد اي بيانات لهذا التاجر';
             $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
          }
        }
    }
    public function edit_profile_post(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('customer_id', 'رقم المستخدم', 'trim|required|numeric');
        if($this->post('full_name') === "" || $this->post('full_name') != null)
            $this->form_validation->set_rules('full_name', 'الاسم بالكامل', 'trim|required');
        if($this->post('country_id') === "" || $this->post('country_id') != null)
            $this->form_validation->set_rules('country_id', 'الدولة', 'trim|required|numeric');
        if($this->post('city_id') === "" || $this->post('city_id') != null)
            $this->form_validation->set_rules('city_id', 'المدينة', 'trim|required|numeric');
        if($this->post('password') === "" || $this->post('password') != null)
            $this->form_validation->set_rules('password', 'الكمية المتاحه', 'trim|required|min_length[6]');
        if($this->post('image') === "")
            $this->form_validation->set_rules('image', 'الصورة الشخصيه', 'trim|required');
        if($this->post('phone') === "" || $this->post('phone') != null){
          $phone = get_this('customers',['id'=>$this->post('customer_id')],'phone');
          if ($phone != $this->post('phone')) {
            $this->form_validation->set_rules('verified', 'حالة كود التفعيل', 'trim|required|numeric');
              $this->form_validation->set_rules('phone', 'رقم الجوال', 'trim|required|is_unique[customers.phone]');
            if($this->post('verified') == 1){
              $this->form_validation->set_rules('verification_code', 'كود التفعيل', 'trim|required|exact_length[6]');
            $this->form_validation->set_rules('id', 'رقم عملية الارسال', 'trim|required');
            }
          }
        }
        if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('customer_id'))
                $data['customer_id_error'] = strip_tags(form_error('customer_id'));
            if(form_error('full_name'))
                $data['full_name_error'] = strip_tags(form_error('full_name'));
            if(form_error('country_id'))
                $data['country_id_error'] = strip_tags(form_error('country_id'));
            if(form_error('city_id'))
                $data['city_id_error'] = strip_tags(form_error('city_id'));
            if(form_error('password'))
                $data['password_error'] = strip_tags(form_error('password'));
            if(form_error('phone'))
                $data['phone_error'] = strip_tags(form_error('phone'));
            if(form_error('verified'))
                $data['verified_error'] = strip_tags(form_error('verified'));
            if(form_error('verification_code'))
                $data['verification_code_error'] = strip_tags(form_error('verification_code'));
            if(form_error('id'))
                $data['id_error'] = strip_tags(form_error('id'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $customer = get_this('customers',['id'=>$this->post('customer_id')]);
                 if ($customer) {
                     if ($customer['status'] == 1) {
                         if ($customer['confirmed'] == 1) {
                             // $customer = get_this('customers',['id'=>$this->post('id'),'status'=>1]);
                              $id = $customer['id'];
                              $store = $this->post();
                              $store['updated_at'] = date('Y-m-d');
                              unset($store['customer_id']);
                              unset($store['verification_code']);
                              unset($store['verified']);
                              unset($store['id']);
                              if ($this->post('password'))
                                  $store['password'] = (md5(md5(md5(sha1($this->post('password'))))));
                              if ($this->post('image')) {
                                  $image = $this->m_image->base64_upload($this->post('image'));
                                  $store['image'] = $image;
                              }  
                              if ($this->post('verified') == 1) {
                                  $verification_info = get_this('mobile_numbers',['id'=>$this->post('id'),'verification_code'=>$this->post('verification_code'),'verified'=>0]);
                                  if ($verification_info) {
                                      $update = ['verified' => 1];
                                      $store['phone'] = $this->post('phone');
                                      $this->Main_model->update('mobile_numbers',['id'=>$this->post('id')],$update);
                                  }
                              }else
                                  unset($store['phone']);
                              $this->Main_model->update('customers',['id'=>$id],$store);
                              $customer_info = get_this('customers',['id'=>$id]);
                              unset($customer_info['password']);
                              $customer_info['image'] = base_url('assets/uploads/files/'.$customer_info['image']);
                              $data['status'] = true;
                              $data['customer_info'] = $customer_info;
                              $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code


                              
                         }else{
                             $data['status'] = false;
                             $data['message'] = 'حساب لم تتم الموافقه عليه من قبل الادارة';
                             $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                         }
                     }else{
                         $data['status'] = false;
                         $data['message'] = 'حساب غير مفعل';
                         $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                     }
                 }else{
                     $data['status'] = false;
                     $data['message'] = 'عفوا لا توجد اي بيانات لهذا المستخدم';
                     $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                 }
        }
    }
    public function my_orders_post(){
      $this->load->library('form_validation');
      $this->form_validation->set_rules('customer_id', 'رقم المستخدم', 'trim|required|numeric');
      $this->form_validation->set_rules('limit', 'عدد العناصر الظاهره', 'trim|required|numeric');
      $this->form_validation->set_rules('page_number', 'رقم الصفحه', 'trim|required|numeric');
      if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('customer_id'))
                $data['customer_id_error'] = strip_tags(form_error('customer_id'));
            if(form_error('limit'))
                $data['limit_error'] = strip_tags(form_error('limit'));
            if(form_error('page_number'))
                $data['page_number_error'] = strip_tags(form_error('page_number'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
              $customer_info = get_this('customers',['id'=>$this->post('customer_id')]);
                if ($customer_info) {
                   if ($customer_info['status'] == 1) {
                       if ($customer_info['confirmed'] == 1) {
                                if ($customer_info) {
                                    $offset = $this->post('limit') * $this->post('page_number');
                                    $where['customer_id'] = $customer_info['id'];
                                    $orders = $this->db->order_by('created_at','DESC')
                                                       ->get_where('main_orders',$where,$this->post('limit'),$offset)
                                                       ->result();
                                    if ($orders) {
                                      foreach ($orders as $order) {
                                        $result[] = [
                                                        'id'            => $order->id,
                                                        'total'         => $order->total,
                                                    ];
                                      }
                                        if ($result) {
                                                $data['status'] = true;
                                                $data['my_orders'] = $result;
                                                $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                                            }
                                    }else{
                                          $data['status'] = false;
                                          $data['my_orders'] = [];
                                          $data['message'] = 'عفوا لا توجد اي طلبات خاصه بك';
                                          $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                                   }  
                              }else{
                                 $data['status'] = false;
                                 $data['message'] = 'عفوا لا توجد اي بيانات لهذا المستخدم';
                                 $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                              }
                       }else{
                           $data['status'] = false;
                           $data['message'] = 'حساب لم تتم الموافقه عليه من قبل الادارة';
                           $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                       }
                   }else{
                       $data['status'] = false;
                       $data['message'] = 'حساب غير مفعل';
                       $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                   }
                }else{
                   $data['status'] = false;
                   $data['message'] = 'عفوا لا توجد اي بيانات لهذا المستخدم';
                   $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                }
           /* $customer_info = get_this('customers',['id' => $this->post('customer_id')]);
            if ($customer_info) {
            $offset = $this->post('limit') * $this->post('page_number');
            $where['customer_id'] = $customer_info['id'];
            $orders = $this->db->order_by('created_at','DESC')
                               ->get_where('main_orders',$where,$this->post('limit'),$offset)
                               ->result();
            if ($orders) {
              foreach ($orders as $order) {
                $result[] = [
                                'id'            => $order->id,
                                'total'         => $order->total,
                            ];
              }
                if ($result) {
                        $data['status'] = true;
                        $data['my_orders'] = $result;
                        $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                    }
            }else{
                  $data['status'] = false;
                  $data['my_orders'] = [];
                  $data['message'] = 'عفوا لا توجد اي طلبات خاصه بك';
                  $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
           }  

          }else{
             $data['status'] = false;
             $data['message'] = 'عفوا لا توجد اي بيانات لهذا المستخدم';
             $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
          }*/
        }
    }
    public function order_details_post(){
      $this->load->library('form_validation');
      $this->form_validation->set_rules('main_order_id', 'رقم الطلب', 'trim|required|numeric');
      if($this->form_validation->run() === FALSE){
            $data['status'] = false;
            if(form_error('main_order_id'))
                $data['main_order_id_error'] = strip_tags(form_error('main_order_id'));
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
        	$sub_orders = get_table('sub_orders',['main_order_id'=>$this->post('main_order_id')]);
        	foreach ($sub_orders as $sub) {
        		$merchant_info = get_this('merchants',['id'=>$sub->merchant_id]);
        		$result[]= [
              						'store_name' => $merchant_info['store_name'],
              						'merchant_id' => $merchant_info['id'],
              						'id' => $sub->id,
              						'delivering_method_name' => get_this('delivering_methods',['id'=>$sub->delivering_method_id],'name'),
              						'sub_total' => $sub->sub_total,
              						'delivering_method_price' => $sub->delivering_method_price,
              						'tax' => $sub->tax,
              						'total'=> $sub->total,
              						'order_status'=> get_this('orders_statuses',['id'=>$sub->status_id],'name'),
              						'products' => get_table('order_items',['sub_order_id'=>$sub->id]),
        				        ];
          }
          foreach ($result as $r) {
              foreach ($r['products'] as $product) {
               $product_image = get_this('products',['id'=>$product->product_id],'main_image');
               $product->main_image = base_url('assets/uploads/files/'.$product_image);
              }
              
          }
        	  $data['status'] = true;
            $data['order_details'] = $result;
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        	}  
    }
    public function create_pay_page_post(){
     $merchant_email = 'muath440@gmail.com';  //Orignal Value
      $secret_key     = 'wCmoQoeFoKFEO7jOsRACKIclBLwcrjyYWUmNiAtHl8l9gEXIwxlhgxCSi94KsDIpx5cQGFx1NSb4x8M4G7lXFXPY6UIzxrY5xaVd'; //Orignal Value
     //  $merchant_email = 'Muathali440@gmail.com';  //dumy Value
   // $secret_key     = 'Yk8EE4jv3fL5aEZHp5jnif42of2wXxbVRjAvoU0s9Mxkrx1RCleUAiXYx0vuyGqp01VoVWQ5InpaUr1xMfsmyql5rQAZx0px1kVX';  //dumy Value
      $merchant_id    = 'MERCHANT_ID';
      $params         = [
                           'merchant_email'=>$merchant_email,
                           'merchant_id'=>$merchant_id,
                           'secret_key'=>$secret_key
                        ];
      $this->load->library('paytabs',$params);
      $this->load->library('form_validation');
      $this->form_validation->set_rules('products_names', 'اسماء المنتجات', 'required');
      $this->form_validation->set_rules('products_prices', 'اسعار المنتجات', 'required');
      $this->form_validation->set_rules('products_quantities', 'الكمية من كل منتج', 'required');
      $this->form_validation->set_rules('taxes', 'اجمالي الضريبة', 'required|numeric');
      $this->form_validation->set_rules('total', 'الاجمالي', 'required|numeric');
      $this->form_validation->set_rules('customer_name', 'اسم العميل', 'required');
      $this->form_validation->set_rules('cc_first_name', 'الاسم الاول', 'required');
      $this->form_validation->set_rules('cc_last_name', 'الاسم الاخير', 'required');
      $this->form_validation->set_rules('email', 'البريد الالكتروني', 'required|valid_email');
      $this->form_validation->set_rules('phone_number', 'رقم الهاتف', 'required|numeric');
      $this->form_validation->set_rules('billing_address', 'عنوان الفاتورة', 'required');
      $this->form_validation->set_rules('city', 'المدينة', 'required');
      $this->form_validation->set_rules('state', 'النطقة', 'required');
      $this->form_validation->set_rules('postal_code', 'الرمز البريدي', 'required');
      $this->form_validation->set_rules('address_shipping', 'عنوان الشحن', 'required');
      if($this->form_validation->run() === FALSE){
         $data['status'] = false;
         if(form_error('products_names'))
            $data['products_names_error'] = strip_tags(form_error('products_names'));
         if(form_error('products_prices'))
            $data['products_prices_error'] = strip_tags(form_error('products_prices'));
         if(form_error('products_quantities'))
            $data['products_quantities_error'] = strip_tags(form_error('products_quantities'));
         if(form_error('taxes'))
            $data['taxes_error'] = strip_tags(form_error('taxes'));
         if(form_error('total'))
            $data['total_error'] = strip_tags(form_error('total'));
         if(form_error('customer_name'))
            $data['customer_name_error'] = strip_tags(form_error('customer_name'));
         if(form_error('cc_first_name'))
            $data['cc_first_name_error'] = strip_tags(form_error('cc_first_name'));
         if(form_error('cc_last_name'))
            $data['cc_last_name_error'] = strip_tags(form_error('cc_last_name'));
         if(form_error('email'))
            $data['email_error'] = strip_tags(form_error('email'));
         if(form_error('phone_number'))
            $data['phone_number_error'] = strip_tags(form_error('phone_number'));
         if(form_error('billing_address'))
            $data['billing_address_error'] = strip_tags(form_error('billing_address'));
         if(form_error('city'))
            $data['city_error'] = strip_tags(form_error('city'));
         if(form_error('state'))
            $data['state_error'] = strip_tags(form_error('state'));
         if(form_error('postal_code'))
            $data['postal_code_error'] = strip_tags(form_error('postal_code'));
         if(form_error('address_shipping'))
            $data['address_shipping_error'] = strip_tags(form_error('address_shipping'));
         $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
      }else{
         $values =  [
                        # PayTabs Merchant Account Details
                        'merchant_email'       => $merchant_email,
                        'secret_key'           => $secret_key, 
                        # Customer's Personal Information
                        'title'                => $this->post('customer_name'),
                        'cc_first_name'        => $this->post('cc_first_name'),
                        'cc_last_name'         => $this->post('cc_last_name'),     
                        'email'                => $this->post('email'),
                        'cc_phone_number'      => 'phone number',
                        'phone_number'         => $this->post('phone_number'),
                        # Customer's Billing Address (All fields are mandatory)
                        'billing_address'      => $this->post('billing_address'),
                        'city'                 => $this->post('city'),
                        'state'                => $this->post('state'),
                        'postal_code'          => $this->post('postal_code'),
                        'country'              => 'SAU',
                        # Customer's Shipping Address (All fields are mandatory)
                        'address_shipping'     => 'city',
                        'city_shipping'        => 'city shipping',
                        'state_shipping'       => 'state_shipping',
                        'postal_code_shipping' => 'postal_code_shipping',
                        'country_shipping'     => 'SAU',
                        # Product Information
                        'products_per_title'   => $this->post('products_names'),
                        'currency'             => 'SAR', 
                        'unit_price'           => $this->post('products_prices'), 
                        'quantity'             => $this->post('products_quantities'), 
                        'other_charges'        => $this->post('taxes'),
                        'amount'               => $this->post('total'),  
                        'discount'             => '0', 
                        'msg_lang'             => 'Arabic', 
                        'reference_no'         => '1231231',
                        'site_url'             => 'http://makzan.com.sa', 
                        'return_url'           => 'http://makzan.com.sa',
                        'cms_with_version'     => 'API USING PHP'
                    ]; 
         $response= $this->paytabs->create_pay_page($values);  
         $this->response($response, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
      }
    }
    public function verify_payment_post(){
      $merchant_email = 'Muathali440@gmail.com';
      $secret_key     = 'Yk8EE4jv3fL5aEZHp5jnif42of2wXxbVRjAvoU0s9Mxkrx1RCleUAiXYx0vuyGqp01VoVWQ5InpaUr1xMfsmyql5rQAZx0px1kVX';
      $merchant_id    = 'MERCHANT_ID';
      $params         = [
                           'merchant_email'=>$merchant_email,
                           'merchant_id'=>$merchant_id,
                           'secret_key'=>$secret_key
                        ];
      $this->load->library('paytabs',$params);
      $this->load->library('form_validation');
      $this->form_validation->set_rules('payment_reference', 'رقم عملية الدفع', 'required|numeric');
      if($this->form_validation->run() === FALSE){
         $data['status'] = false;
         if(form_error('payment_reference'))
            $data['payment_reference_error'] = strip_tags(form_error('payment_reference'));
         $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
      }else{
         $values =  [
                        # PayTabs Merchant Account Details
                        'merchant_email'       => $merchant_email,
                        'secret_key'           => $secret_key, 
                        # Customer's Proccess ID
                        'payment_reference'    => $this->post('payment_reference')
                    ];
         $response= $this->paytabs->verify_payment($values);  
         $this->response($response, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
      }      
    }
    public function create_order_post(){
        $order_json = $this->post('json');
        $order= json_decode($order_json);
        $main_order_data = [
                                  'customer_id'       => $order->main_order->user_id,
                                  'total'             => $order->main_order->total,
                                  'address'           => $order->main_order->address,
                                  /*'latitude'          => $order->main_order->latitude,
                                  'langitude'         => $order->main_order->langitude,*/
                                  'payment_method_id' => $order->main_order->payment_method_id,
                                  'payment_status'    => $order->main_order->payment_status,
                                  'transfer_name'     => $order->main_order->transfer_name,
                                  'money_transfered'  => $order->main_order->money_transfered,
                                  'transfer_type'     => $order->main_order->transfer_type,
                                  'transfer_date'     => $order->main_order->transfer_date,
                                  'created_at'        => date('Y-m-d')
                           ];
        $main_order_id = $this->Main_model->insert('main_orders',$main_order_data);
        
        //$insert_id = $this->db->insert_id();
    	/*$transactions = [
			'result' => $order->result,
			'response_code' => $order->response_code,
			'amount' => $order->amount,
			'currency' => $order->currency,
			'reference_no' => $order->reference_no,
			'transaction_id' => $order->transaction_id,
		];
		$this->Main_model->update('transactions_orders',['main_order_id'=>$main_order_id],$transactions);
		if($order->response_code==100){
			$payment_status = ['payment_status'=>1];
			$this->Main_model->update('main_orders',['id'=>$main_order_id],$payment_status);
		}                     */  
                           
        
        foreach ($order->sub_order as $sub) {
          $sub_order_data = [
                                  'main_order_id'           => $main_order_id,
                                  'merchant_id'             => $sub->merchant_id,
                                  'customer_id'             => $sub->customer_id,
                                  'delivering_method_id'    => $sub->delivering_method_id,
                                  'delivering_method_price' => get_this('merchants_delivering_methods',['method_id'=>$sub->delivering_method_id, 'merchant_id'=>$sub->merchant_id],'price'),
                                  'sub_total'               => $sub->sub_total,
                                  'status_id'               => $sub->status_id,
                                  'tax'                     => $sub->tax,
                                  'total'                   => $sub->total,
                            ];
          $sub_order_id = $this->Main_model->insert('sub_orders',$sub_order_data);
          $merchant_credit = get_this('merchants',['id'=>$sub->merchant_id],'credit');
          $credit = [
                        'credit' => $merchant_credit + $sub->total
                    ];
          $this->db->where('id',$sub->merchant_id)->update('merchants',$credit);
          foreach ($sub->order_products as $product) {
            $product_info = [
                                  'main_order_id' => $main_order_id,
                                  'sub_order_id'  => $sub_order_id,
                                  'product_id'    => $product->product_id,
                                  'product_color' => $product->product_color,
                                  'product_name'  => $product->product_name,
                                  'product_price' => $product->product_price,
                                  'quantity'      => $product->quantity,
                                  'total'         => $product->total,
                            ];
            $this->Main_model->insert('order_items',$product_info);
          }
        }
        $data['status'] = true;
        $data['message'] = 'تم انشاء الطلب بنجاح';
        $data['main_order_id'] = $main_order_id;
        $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
    }
}
