<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of site
 *
 * @author https://www.roytuts.com
 */
class Teamwork extends MX_Controller {

    function __construct() {
		parent::__construct();
        $this->lang->load('main_lang', get_lang() );
        $this->db->order_by('id', 'DESC');
		$this->load->library('session');
		$this->load->library('pagination');
        if( isset($this->session->get_userdata('lang')['lang']) ){
        $lang = $this->session->get_userdata('lang')['lang'];
        }else{
        $lang = 'arabic';
        }
        $dir = ( $lang == 'arabic' )? 'left' : 'right' ;
		define( "LANGU" , $lang );
		$this->load->model('data','','true');
    }


public function lang_site( $lang = null ){
    $curt = $this->uri->segment(3);
$main_curt=$this->uri->segment(1);
$controller_curt=$this->uri->segment(2);
$curt_sub =$_SESSION['curt'];
$curt_id =$_SESSION['curt_id'];
 
        if( $lang == 'ar' ){
            $newdata = array(
            'lang'  => 'arabic'
            );
            $this->session->set_userdata($newdata);
        }else{
            $newdata = array(
            'lang'  => 'english'
            );
            $this->session->set_userdata($newdata);
		}
		echo  $this->session->get_userdata($newdata);
if($curt_id!=""){
redirect(DIR."site/".$controller_curt."/".$curt_sub."/".$curt_id);
}
else {
redirect(DIR."site/".$controller_curt."/".$curt_sub);    
}
    }
    function index() {
        redirect(DIR."site/teamwork/our_team");   
	}
	function our_team() {
		global $lang;
		if( isset($this->session->get_userdata('lang')['lang']) ){
			$lang = $this->session->get_userdata('lang')['lang'];
			}else{
			$lang = 'arabic';
			}
        $tables = "team_work";
        $config['base_url'] = base_url().'site/teamwork/our_team'; 
        $config['total_rows'] = $this->data->record_count($tables,array('view'=>'1','type'=>'2'),'','id','asc');
        $config['per_page'] =12;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';   
        $config['last_link'] = '»»';
        $config['last_tag_open'] = '<li style="border:0px  ">';
        $config['last_tag_close'] = '</li>';
        $config['first_link'] = '««';
        $config['first_tag_open'] = '<li style="border:0px  ">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '«';
        $config['prev_tag_open'] = '<li style="border:0px  ">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '»';
        $config['next_tag_open'] = '<li style="border:0px  ">';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active" style="border:0px  "><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li style="border:0px  ">';
        $config['num_tag_close'] = '</li>';
       // $config['suffix'] = '?' . http_build_query($_GET, '', "&");
       // $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
        $this->pagination->initialize($config);
        if($this->uri->segment(4)){
        $page = ($this->uri->segment(4)) ;
        }
        else{
        $page =0;
        }
        $rs = $this->db->get($tables);
        if($rs->num_rows() == 0):
        $data["results"] = array();
        $data["links"] = array();
		$datahead['site_info'] =$this->db->get_where('site_info')->result(); 
		$data['siteinfo']=$this->db->get_where('site_info')->result();
		$datahead['lang'] =$lang; 
		$data['lang'] =$lang;
		$data['result_amount'] =$this->db->get_where('team_work',array('view'=>'1'))->result(); 
        else:
        $data["results"] = $this->data->view_all_data($tables, array('view'=>'1','type'=>'2'), $config["per_page"], $page,'id','asc');
        $str_links = $this->pagination->create_links();
        $data["links"] = explode('&nbsp;',$str_links);
		$datahead['site_info'] =$this->db->get_where('site_info')->result(); 
		$data['siteinfo']=$this->db->get_where('site_info')->result();
		$datahead['lang'] =$lang; 
		$data['lang'] =$lang;
        $data['result_amount'] =$this->db->get_where('team_work',array('view'=>'1','type'=>'2'))->result(); 
        $data['main_team'] =$this->db->get_where('team_work',array('view'=>'1','type'=>'1'))->result(); 
		endif;
		

		$this->load->view('include/head',$datahead);
		$this->load->view('include/insideheader',$datahead);
		$this->load->view('our_team',$data);
		$this->load->view('include/footer',$datahead);
    }
	
	

	
}

/* End of file Site.php */
/* Location: ./application/modules/site/controllers/site.php */
