<?php
//session_start();
ob_start();
if (!isset($_SESSION['admin_name']) || $_SESSION['admin_name'] == "") {
redirect(base_url().'admin/login/','refresh');
} else {
	$id_admin = $_SESSION['id_admin'];
	$admin_name = $_SESSION['admin_name'];
	$last_login = $_SESSION['last_login'];
	$curt = 'allprojects';
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" dir="rtl">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8">
<title>إضافة مشروع</title>
<?php include("design/inc/header.php"); ?>
</head>
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-md">
		<!-- BEGIN HEADER -->
		<?php include("design/inc/topbar.php"); ?>
		<script type="text/javascript" src="<?= $url ?>design/ckeditor/ckeditor.js"></script>
		<script type="text/javascript" src="<?= $url ?>design/ckfinder/ckfinder.js"></script>
        <!-- END HEADER -->
		<!-- BEGIN HEADER & CONTENT DIVIDER -->
		<div class="clearfix"> </div>
		<!-- END HEADER & CONTENT DIVIDER -->
		<!-- BEGIN CONTAINER -->
		<div class="page-container">
			<!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                <!-- BEGIN SIDEBAR -->
                <?php include("design/inc/sidebar.php"); ?>
                <!-- END SIDEBAR -->
            </div>
            <!-- END SIDEBAR -->
			<!-- BEGIN CONTENT -->
			<div class="page-content-wrapper">
				<div class="page-content" style="min-height: 1261px;">
					<!-- BEGIN PAGE HEAD-->

					<!-- END PAGE HEAD-->
					<!-- BEGIN PAGE BREADCRUMB -->
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<a href="<?= $url . 'admin'; ?>"><?= lang('admin_panel'); ?></a>
							<i class="fa fa-circle"></i>
						</li>
						<?php 
						if($this->input->get("project_id")==2){
						?>
						
							<li>
							<a href="<?= $url . 'admin/projects/current_projects'; ?>">المشاريع الحالية</a>
							<i class="fa fa-circle"></i>
						</li>
						<?php }?>
					
						<?php 
						if($this->input->get("project_id")==1){
						?>
						
							<li>
							<a href="<?= $url . 'admin/projects/wait'; ?>">المشاريع المنتظرة</a>
							<i class="fa fa-circle"></i>
						</li>
						<?php }?>
						
							<?php 
						if($this->input->get("project_id")==3){
						?>
						
							<li>
							<a href="<?= $url . 'admin/projects/future'; ?>">المشاريع المستقبلية</a>
							<i class="fa fa-circle"></i>
						</li>
						<?php }?>
						<?php 
						if($this->input->get("project_id")==4){
						?>
						
							<li>
							<a href="<?= $url . 'admin/projects/finished'; ?>">المشاريع المنتهية</a>
							<i class="fa fa-circle"></i>
						</li>
						<?php }?>
					
						<li>
							<span>إضافة مشروع</span>
						</li>
					</ul>
					<!-- END PAGE BREADCRUMB -->
					<!-- BEGIN PAGE BASE CONTENT -->
					<div class="row">
						<div class="col-md-12">
							<!-- BEGIN PROFILE SIDEBAR -->
							<div class="profile-sidebar">
								<!-- PORTLET MAIN -->
								<!-- END PORTLET MAIN -->
								<!-- PORTLET MAIN -->

								<!-- END PORTLET MAIN -->
							</div>
							<!-- END BEGIN PROFILE SIDEBAR -->
							<!-- BEGIN PROFILE CONTENT -->
							<div class="profile-content">
								<div class="row">
									<div class="col-md-12">
										<!--Start from-->
										<div class="tab-content">
											<div class="tab-pane active" id="tab_5">
												<div class="portlet box blue ">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-gift"></i>إضافة مشروع</div>
													</div>

													<div class="portlet light bordered form-fit">
														<div class="portlet-title">
															<div class="caption"></div>
															<div class="actions"></div>
														</div>
														<div class="portlet-body form">
															<!-- BEGIN FORM-->
															<input type="hidden" value="1" id="service_type">
															<form  id="myForm" class="form-horizontal form-bordered" method="post" enctype="multipart/form-data">
															    <input type="hidden" name="project_id" value="<?= $this->input->get("project_id");?>">
																<div class="form-body">
										
																	<div class="form-group">
																		<div class="col-md-1"></div>
																		<div class="col-md-10">
																		<span class="help-block"> اسم المشروع</span>

																			<input name="name_project" id="mainid" type="text" placeholder="اسم المشروع" class="form-control" required>
																		</div>
																		<div class="col-md-1"></div>
																	</div>
																	
																

																	<div class="form-group">
																		<div class="col-md-1"></div>
																		<div class="col-md-10">
																		<span class="help-block">وصف المشروع</span>
<textarea name="desc_ar" id="contents" style="width:100%;height:150px"></textarea>
																			<?php //echo $this->ckeditor->editor("desc_ar", "contents"); ?>
																		</div>
																		<div class="col-md-1"></div>
																	</div>
																
																	
																
																	

																	<div class="form-group">
																		<div class="col-md-1"></div>
																		<div class="col-md-10">
																		<span class="help-block">تاريخ  البداية</span>
									 <input type="radio"  class="form-control" style="height:22px;" name="select_date" value="1" checked> غير معلوم الان
									 <input type="radio"  class="form-control" style="height:22px;" name="select_date" value="2" >تحديد وقت البداية
                            <input name="start_time" style="direction: ltr;width: 100%; display:none" size="18" id="start_date" type="text"  class="form_datetime form-control" >
																		</div>
																		<div class="col-md-1"></div>
																	</div>


																<div class="form-group">
																			<div class="col-md-1"></div>
																			<div class="col-md-10">
																			<span class="help-block"> حالة المشروع </span>
																			<select class="form-control" name="status_executed" style="height: auto;">
																			    <?php
																			if($this->input->get("project_id")==2){
																			?>
																		<option value="1">مشروع حالى</option> 
																		<?php }?>
																			<option value="2">مشروع منتظر</option>
																			<option value="3">مشروع مستقبلى</option>
																			</select>																					
																			</div>
																			<div class="col-md-1"></div>
																		</div>

																		<div class="form-group">
																			<div class="col-md-1"></div>
																			<div class="col-md-10">
																			<span class="help-block">نوع المشروع</span>
																			<div class="row">
																			<?php
																			$services_type=get_table_data('services_type',array('view'=>'1','type'=>'1'),'','id','desc');
																			if(count($services_type)>0){
																				 foreach($services_type as $services_type){
																			?><div class="col-md-3 col-xs-12" style="margin-bottom:10px;text-align:justify">
																			<input type="checkbox" class="typeproject" name="services_type[]" value="<?=$services_type->id;?>">
																			<span style="padding-right:2px;"><?=$services_type->name;?></span>
																			</div>
																				 <?php }?>
																			<?php }?>	
																			</div>																			
																			</div>
																			<div class="col-md-1"></div>
																		</div>


																			<div class="form-group">
																				<div class="col-md-1"></div>
																				<div class="col-md-10">
																				<span class="help-block">مدير المشروع</span>
																	<select class="form-control" id="select_manager_id" name="manager_id" style="height: auto;">
																			<option value="0">بدون</option>
																			<?php
														$manager_user = $this->db->get_where('tbl_users', array('view' => '1','status'=>'1'))->result();
														
																		if (count($manager_user) > 0) {
																			foreach ($manager_user as $manager_user) {
																				$group_id=$manager_user->group_id;
													$job_description=get_table_filed("tbl_user_groups",array("id"=>$group_id),"name");
																				?>
														<option value="<?= $manager_user->id; ?>"><?= $manager_user->fname."".$manager_user->lname."&nbsp&nbsp(".$job_description.")"; ?></option>
															<?php

													}
												} ?>
																		</select>		
																				</div>
																				<div class="col-md-1"></div>
																			</div>
																			
																	<!--<div class="form-group">
																		<div class="col-md-1"></div>
																		<div class="col-md-10">
																		<span class="help-block">اسم العميل</span>

																			<input name="client_name" type="text" placeholder=" اسم العميل" class="form-control" >
																		</div>
																		<div class="col-md-1"></div>
																	</div>

																	<div class="form-group">
																		<div class="col-md-1"></div>
																		<div class="col-md-10">
																		<span class="help-block"> رقم جوال العميل</span>

																			<input name="client_phone" type="text" placeholder=" رقم جوال العميل" class="form-control" >
																		</div>
																		<div class="col-md-1"></div>
																	</div>--->


																	<div class="form-group">
																	<div class="col-md-1"></div>
																	<div class="col-md-10">
																		<div class="fileinput fileinput-new" data-provides="fileinput">
																						<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;"></div>
																						<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
																						<div>
																							<span class="btn default btn-file">
																								<span class="fileinput-new">لوجو المشروع</span>
																								<span class="fileinput-exists">تغيير</span>
																								<input type="file" name="img"> </span>
																								<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> حذف </a>
																						</div>
																					</div>
																					<p style="color:red;direction:rtl"></p>
																		<p style="color:red;direction:rtl">عرض الصورة 400 بيكسل</p>
																		<p style="direction:rtl">طول الصورة 400بيكسل</p>
																	</div>
																	<div class="col-md-1"></div>
																	</div>


																	<div class="form-actions">
																		<div class="row">
																			<div class="col-md-offset-3 col-md-9">
																			<button type="button" class="mainbutton btn green projectkbutton">
																					<i class="fa fa-check"></i> حفظ</button>
																				<button type="button" class="btn default cancelbutton">إلغاء</button>
																			</div>
																		</div>
																	</div>
																</div>
														</form>
														<!-- END FORM-->
														</div>

													</div>
													<!---END FROM-->



												</div>
											</div>
											<!-- END PROFILE CONTENT -->
										</div>
									</div>
									<!-- END PAGE BASE CONTENT -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <?php include("design/inc/footer.php"); ?>
        <!-- END FOOTER -->

        <?php include("design/inc/footer_js.php"); ?>
<script>
$(document).ready(function(e) {
    $(".cancelbutton").click(function(e) {
     window.history.back();
    });
});
</script>
<script>
	//this script for select if time of start project selected or no as :
	 //if value==2 mean select start date or value =1 mean not selected date
	
$(document).ready(function(e) {
	$("input[type='radio']").click(function(){
		var radioValue = $("input[name='select_date']:checked").val();
            if(radioValue==2){
               $("#start_date").show();
            }
			else {
				$("#start_date").hide();	
			}
        });
});
</script>
<script type="text/javascript">
    $(".form_datetime").datetimepicker({format: 'yyyy-mm-dd hh:ii'});
</script>  
</body>
</html>
