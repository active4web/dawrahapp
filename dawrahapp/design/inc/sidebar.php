        <!-- BEGIN SIDEBAR -->
                <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                <div class="page-sidebar navbar-collapse collapse">
                    <!-- BEGIN SIDEBAR MENU -->
                    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                    <li class="nav-item start <?php if($curt=='home'){echo'active open';}?>">
                        <a href="<?=$url;?>admin" class="nav-link ">
                            <i class="icon-home"></i>
                                        <span class="title">لوحة التحكم</span>
                                        <span class="selected"></span>
                                    </a>
                    </li>
                    <?
                    	$reply_counts=$this->db->get_where("tickets",array("status_id"=>'0'))->result();
                        $users_accounts=$this->db->get_where("customers",array("nofiy_register"=>'0'))->result();
                        $users_accounts_customers=$this->db->get_where("customers",array("nofiy_register"=>'0','status'=>'1'))->result();
                        $users_accounts_trainer=$this->db->get_where("customers",array("nofiy_register"=>'0','status'=>'2'))->result();
                        $users_accounts_bages=$this->db->get_where("customers",array("nofiy_register"=>'0','status'=>'3'))->result();
                        $users_accounts_company=$this->db->get_where("customers",array("nofiy_register"=>'0','status'=>'4'))->result();
                        $payments_accounts=$this->db->get_where("request_courses",array("view"=>'0'))->result();
                           $payments_accounts_only=$this->db->get_where("request_courses",array("view"=>'0','type_payment'=>'1'))->result();
                    ?>
	<li class="nav-item start <?php if($curt=='setting'){echo'active open';}?>">
						<a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-settings"></i>
								<span class="title">الاعدادات <span style="color:red" class="ticket_nofiy"><? if(count($reply_counts)>0){echo "(".count($reply_counts).")"; };?></span></span>
                                <span class="arrow"></span>
                            </a>
							<ul class="sub-menu">
                                <li class="nav-item  ">
                              
                                    <a href="<?=base_url()?>admin/setting" class="nav-link ">
                                        <span class="title">الاعدادات</span>
                                    </a>
                                </li>
							 <li class="nav-item <?php if($curt=='pdf'){echo'active open';}?>">
                                    <a href="<?=base_url()?>admin/services/" class="nav-link ">
                                        <i class="fa fa-file"></i>
                                        <span class="title">التصنيفات</span>
                                    </a>
                                </li>
							
							 <li class="nav-item  <?php if($curt=='setting'){echo'active open';}?>">
                                    <a href="<?=base_url()?>admin/tickets_types/" class="nav-link ">
                                        <i class="icon-envelope"></i>
                                        <span class="title">انواع التذاكر</span>
                                    </a>
								</li>
								
                                <li class="nav-item  <?php if($curt=='setting'){echo'active open';}?>">
                                    <a href="<?=base_url()?>admin/tickets/" class="nav-link ">
                                        <i class="icon-envelope"></i>
                                        <span class="title">التذاكر <span style="color:red" class="ticket_nofiy"><? if(count($reply_counts)>0){echo "(".count($reply_counts).")"; };?></span></span>
                                    </a>
								</li>
								
								 <li class="nav-item  <?php if($curt=='setting'){echo'active open';}?>">
                                    <a href="<?=base_url()?>admin/notifications/" class="nav-link ">
                                        <i class="fa fa-bell"></i>
                                        <span class="title">التنيهات</span>
                                    </a>
								</li>
								

 <li class="nav-item  <?php if($curt=='discount'){echo'active open';}?>">
                                    <a href="<?=base_url()?>admin/codes/user_codes" class="nav-link ">
                                        <i class="icon-note"></i>
                                        <span class="title">اكواد الخصم</span>
                                    </a>
								</li>
							
                                  <li class="nav-item  <?php if($curt=='products'){echo'active open';}?>">
                                    <a href="<?=base_url()?>admin/products/" class="nav-link ">
                                        <i class="icon-envelope"></i>
                                        <span class="title">الايميلات البريدية</span>
                                    </a>
								</li>
								
                            </ul>
                    </li>
                    
                    

                      
<li class="nav-item start <?php if($curt=='team_work'){echo'active open';}?>">
<a href="<?=$url;?>admin/team_work" class="nav-link ">
<i class="icon-users"></i>
<span class="title">المشرفين</span>
<span class="selected"></span>
</a>
</li>
				
                    
					<li class="nav-item start <?php if($curt=='homepage'){echo'active open';}?>">
                        
						<a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-home"></i>
								<span class="title">الصفحة الرئيسية</span>
                                <span class="arrow"></span>
                            </a>
							<ul class="sub-menu">
                                <li class="nav-item  ">
                              
                                    <a href="<?=base_url()?>admin/pages/steps" class="nav-link ">
                                        <span class="title">خطوات الاستخدام</span>
                                    </a>
                                </li>
								<li class="nav-item  ">
                                    <a href="<?=base_url()?>admin/pages/home_background" class="nav-link ">
                                        <span class="title"> صورة الرئيسية</span>
                                    </a>
                                </li>
								
                                <li class="nav-item  ">
                                    <a href="<?=base_url()?>admin/pages/home_intro" class="nav-link ">
                                        <span class="title">المقدمة</span>
                                    </a>
                                </li>
						
                            </ul>
                    </li>
					<li class="nav-item start <?php if($curt=='about_us'){echo'active open';}?>">
						<a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-info"></i>
								<span class="title">عن المعاهد</span>
                                <span class="arrow"></span>
                            </a>
							<ul class="sub-menu">
							<li class="nav-item  ">
							
							<a href="<?=base_url()?>admin/about/show" class="nav-link ">
                            <i class="icon-note"></i>
								<span class="title">من نحن</span>
							</a>
						</li>

							<li class="nav-item  ">
							
								<a href="<?=base_url()?>admin/about/vision" class="nav-link">
                                <i class="icon-eye"></i>
									<span class="title">الرؤية</span>
								</a>
							</li>
							</ul>
                    </li>
                    
                    	<li class="nav-item start <?php if($curt=='places'){echo'active open';}?>">
						<a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-home"></i>
								<span class="title">الأماكن</span>
                                <span class="arrow"></span>
                            </a>
							<ul class="sub-menu">
							<li class="nav-item  ">
							
							<a href="<?=base_url()?>admin/places/countries" class="nav-link ">
                            <i class="icon-note"></i>
								<span class="title">الدول</span>
							</a>
						</li>

							<li class="nav-item  ">
							
								<a href="<?=base_url()?>admin/places/cities" class="nav-link">
                                <i class="icon-eye"></i>
									<span class="title">المدن</span>
								</a>
							</li>
							</ul>
                    </li>
                    
                                        
                      <li class="nav-item start <?php if($curt=='customers'){echo'active open';}?>">
						<a href="javascript:;" class="nav-link nav-toggle"><i class="fa fa-users"></i>
								<span class="title">العضويات 
								<span style="color:red" class="user_nofiy"><? if(count($users_accounts)>0){echo "(".count($users_accounts).")"; };?></span>
								</span>
                                <span class="arrow"></span>
                            </a>
							<ul class="sub-menu">
                            <li class="nav-item">
                                    <a href="<?=base_url()?>admin/users/customers" class="nav-link ">
                                        <i class="icon-users"></i>
                                        <span class="title">المستخدمين <span style="color:red" class="user_nofiy_customer"><? if(count($users_accounts_customers)>0){echo "(".count($users_accounts_customers).")"; };?></span></span>
                                    </a>
								</li>

                                <li class="nav-item">
                                    <a href="<?=base_url()?>admin/users/trainers" class="nav-link ">
                                    <i class="fa fa-graduation-cap"></i>
                                        <span class="title">المدربين <span style="color:red" class="user_nofiy_trainer"><? if(count($users_accounts_trainer)>0){echo "(".count($users_accounts_trainer).")"; };?></span></span>
                                    </a>
								</li>
								
								 <li class="nav-item">
                                    <a href="<?=base_url()?>admin/users/bags_provider" class="nav-link ">
                                    <i class="fa fa-users"></i>
                                        <span class="title">مقدمى الحقائب 
                        <span style="color:red" class="user_nofiy_bagers"><? if(count($users_accounts_bages)>0){echo "(".count($users_accounts_bages).")"; };?></span>
                        </span>
                                    </a>
								</li>


 <li class="nav-item">
                                    <a href="<?=base_url()?>admin/users/companies" class="nav-link ">
                                    <i class="fa-home"></i>
                                        <span class="title">الشركات <span style="color:red" class="user_nofiy_company"><? if(count($users_accounts_company)>0){echo "(".count($users_accounts_company).")"; };?></span></span>
                                    </a>
								</li>
                                </ul>
                    </li>
                    
                    
                    
                      <li class="nav-item start <?php if($curt=='courses'){echo'active open';}?>">
						<a href="javascript:;" class="nav-link nav-toggle"><i class="fa-sticky-note"></i>
								<span class="title">الدورات</span>
                                <span class="arrow"></span>
                            </a>
							<ul class="sub-menu">
                            <li class="nav-item">
                                    <a href="<?=base_url()?>admin/courses/inside" class="nav-link ">
                                        <i class="icon-note"></i>
                                        <span class="title">الدورات </span>
                                    </a>
								</li>

                            
								                            <li class="nav-item">
                                    <a href="<?=base_url()?>admin/courses/bags" class="nav-link ">
                                        <i class="icon-note"></i>
                                        <span class="title">الحقائب</span>
                                    </a>
								</li>

                                </ul>
                    </li>
                    
		
                               
						

<li class="nav-item start <?php if($curt=='payment_type'||$curt=='bank_accounts'||$curt=='bank_payments'){echo'active open';}?>">
						<a href="javascript:;" class="nav-link nav-toggle">
                                <i class="fa fa-credit-card"></i>
								<span class="title">الحسابات
		<span style="color:red" class="banks_nofiy"><? if(count($payments_accounts)>0){echo "(".count($payments_accounts).")"; };?></span>							
								</span>
                                <span class="arrow"></span>
                            </a>
							<ul class="sub-menu">
							    
							    	 <li class="nav-item  <?php if($curt=='payment_type'){echo'active open';}?>">
                                    <a href="<?=base_url()?>admin/banks/payment_type" class="nav-link ">
                                        <i class="fa fa-credit-card"></i>
                                        <span class="title">انواع التحويلات</span>
                                    </a>
								</li>
						 <li class="nav-item  <?php if($curt=='bank_accounts'){echo'active open';}?>">
                                    <a href="<?=base_url()?>admin/banks/bank_accounts" class="nav-link ">
                                        <i class="fa fa-credit-card"></i>
                                        <span class="title"> الحسابات البنكية</span>
                                    </a>
								</li>
								
									 <li class="nav-item  <?php if($curt=='bank_payments'){echo'active open';}?>">
                                    <a href="<?=base_url()?>admin/banks/bank_payments" class="nav-link ">
                                        <i class="fa fa-credit-card"></i>
                                        <span class="title"> الدفع البنكى 
  <span style="color:red" class="bank_payments"><? if(count($payments_accounts_only)>0){echo "(".count($payments_accounts_only).")"; };?></span>                                      
                                    </span>
                                    </a>
								</li>
								
								<li class="nav-item  <?php if($curt=='products'){echo'active open';}?>">
                                    <a href="<?=base_url()?>admin/banks/requested_courses" class="nav-link ">
                                        <i class="fa fa-cart-plus"></i>
                                        <span class="title">الطلبات
                 <span style="color:red" class="banks_nofiy"><? if(count($payments_accounts)>0){echo "(".count($payments_accounts).")"; };?></span>                       
                                        
                                        </span>
                                    </a>
								</li>

							</ul>
                    </li>



                      <li class="nav-item start <?php if($curt=='pages'){echo'active open';}?>">
						<a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-info"></i>
								<span class="title">صفحات فرعية</span>
                                <span class="arrow"></span>
                            </a>
							<ul class="sub-menu">
                            <li class="nav-item">
                                    <a href="<?=base_url()?>admin/pages/" class="nav-link ">
                                        <i class="icon-notebook"></i>
                                        <span class="title">الصفحات الفرعية</span>
                                    </a>
                                </li>

                                <li class="nav-item <?php if($curt=='faq'){echo'active open';}?>">
                                    <a href="<?=base_url()?>admin/pages/terms" class="nav-link ">
                                        <i class="icon-question"></i>
                                        <span class="title">صفحات الشروط والأحكام</span>
                                    </a>
                                </li>
							
                                <li class="nav-item <?php if($curt=='pages'){echo'active open';}?>">
                                    <a href="<?=base_url()?>admin/pages/point_info" class="nav-link ">
                                        <i class="icon-question"></i>
                                        <span class="title">صفحات استخدام النقاط</span>
                                    </a>
                                </li>
						
                            </ul>
                    </li>


          
           

							



								<li class="nav-item  <?php if($curt=='update_contact'){echo'active open';}?>">
                                    <a href="<?=base_url()?>admin/update_contact" class="nav-link ">
                                        <i class="icon-call-end"></i>
                                        <span class="title">تواصل معانا </span>
                                    </a>
                                </li>
                             	
                            </ul>
                        </li>
                        
                            </ul>
                        </li>
                    </ul>
                    <!-- END SIDEBAR MENU -->
                </div>
                <!-- END SIDEBAR -->
