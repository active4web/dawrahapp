</head>
<body>	

<?php


		$day_d=date('d');
		$month_d=date('m'); 
		$year_d=date('Y'); 
		$ip=$this->input->ip_address();
		$customer_id = $this->data->get_table_row('visiting',array('ip'=>$ip,'day_t'=>$day_d,'month_d'=>$month_d,'year_d'=>$year_d),'id');
		if($customer_id!=""){
		$visit_num = $this->data->get_table_row('visiting',array('ip'=>$ip,'day_t'=>$day_d,'month_d'=>$month_d,'year_d'=>$year_d),'visit_num');
		$data['visit_num']=$visit_num+1;
		
		$this->db->update('visiting',$data,array('ip'=>$ip,'day_t'=>$day_d,'month_d'=>$month_d,'year_d'=>$year_d));
		}
		else {
		$data['ip']=$ip;
		$data['day_t']=$day_d;
		$data['month_d']=$month_d;
		$data['year_d']=$year_d;
		$data['visit_num']=1;
		$data['date']=$year_d."-".$month_d."-".$day_d;;
		$this->db->insert('visiting',$data);
		}

$curt = $this->uri->segment(3);
$main_curt=$this->uri->segment(1);
$controller_curt=$this->uri->segment(2);
$curt_id = $this->uri->segment(4);
$this->session->set_userdata(array('curt' => $curt));
$this->session->set_userdata(array('curt_id' => $curt_id));
//echo "dfgfdg".$controller_curt;
  foreach($site_info as $site_info)
?>

<div class='preloader w-100 h-100 position-fixed'>
        <div class="loader">
            <img class="icon"  src="<?=base_url()?>assets/img/preloader.png" alt="">
        </div>
    </div>

    <header class="header fixed-top">
        <!-- Header Style One Begin -->
        <div class="fixed-top header-main style--one">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-2 col-sm-4 col-4" style="text-align:right;">
                        <!-- Logo Begin -->
                        <div class="logo">
                            <a href="<?= DIR ?>">
                                <img class="default-logo" src="<?=DIR_DES_STYLE?>site_setting/<?= $site_info->logo;?>" data-rjs="2" alt="الكورسات ودورات">
                                <img class="sticky-logo" src="<?=DIR_DES_STYLE?>site_setting/<?= $site_info->logo;?>" data-rjs="2" alt="دورات">
                            </a>
                        </div>
                        <!-- Logo End -->
                    </div>

                    <div class="col-lg-10 col-sm-8 col-8" style="padding-left:0px;padding-right:0px">
                        <!-- Main Menu Begin -->
                        <div class="main-menu d-flex align-items-center justify-content-end">
                            <ul class="nav align-items-center">
                                <li class="menu-item-has-children <?php if($main_curt=="index"&&$controller_curt==""||$controller_curt==""){?>current-menu-parent<?php }?>">
                                    <a href="<?= base_url()?>">الرئيسية</a>
                                   
                                </li>
                                <li class="<?php if($controller_curt=="dawrat"||$curt=="dawrat_list"||$controller_curt=="courses_details"){ ?>current-menu-parent<?php }?>">
                                    <a href="<?= base_url()?>courses/dawrat">الدورات
                                </a>
                                    
                                </li>
                                <li class="<?php if($controller_curt=="bags"||$controller_curt=="bags_details"){ ?>current-menu-parent<?php }?>">
                                    <a href="<?= base_url()?>courses/bags">الحقائب التدريبية</a>
                                   
                                </li>
                                <li class="<?php if($controller_curt=="diplomas"||$curt=="diplomas_list"||$controller_curt=="diplomas_details"){ ?>current-menu-parent<?php }?>">
                                    <a href="<?= base_url()?>courses/diplomas">الدبلومات</a>
                                  
                                </li>
                                <li class="<?php if($main_curt=="trainers"){ ?>current-menu-parent<?php }?>">
                                    <a href="<?= base_url()?>trainers/">المدربين</a>
                                  
                                </li>
                                <li class="<?php if($controller_curt=="contact"){ ?>current-menu-parent<?php }?>"><a href="<?= base_url()?>index/contact/">تواصل معانا</a></li>
                                
                            </ul>
                            
                            <!-- Offcanvas Holder Trigger -->
                          
                            <!-- Offcanvas Trigger End -->
                             <a href="<?= DIR?>search/advanced_search" class="mainheader searchbutton"><span style="padding:0px 10px 0px 10px;color:#367cff"><i class="fa fa-search"></i> بحث متقدم</span></a>
                             <?php
                             if($this->session->userdata("customer_id")==""&&!$this->session->userdata("customer_id")){
                             ?>
                            <a href="<?=base_url()?>login" class="mainheader loginbuuton"  style=""><span style="padding:0px 10px 0px 10px">
                                 <i class="fa fa-user"></i> تسجيل الدخول</span></a>
                                 <?php } else{?>
     <a href="<?=base_url()?>user/profile/myaccount" class="mainheader loginbuuton"  style=""><span style="padding:0px 10px 0px 10px">
                                 <i class="fa fa-user"></i> حسابى</span></a>
                                 <?php }?>
                        </div>
                       
                        <!-- Main Menu ENd -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Header Style One End -->
    </header>
    <!-- Header End -->
	  