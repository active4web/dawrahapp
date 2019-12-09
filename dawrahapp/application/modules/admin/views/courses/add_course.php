<?php
//session_start();
ob_start();
if(!isset($_SESSION['admin_name'])||$_SESSION['admin_name']==""){ 
header("Location:".base_url()."admin/login"); 
}
else{
$id_admin=$_SESSION['id_admin'];
$admin_name=$_SESSION['admin_name'];
$last_login=$_SESSION['last_login'];
$curt='courses';
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
<title>اضافة دورة </title>
<?php include ("design/inc/header.php");?>
</head>
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-md">
		<!-- BEGIN HEADER -->
		<?php include ("design/inc/topbar.php");?>
        <!-- END HEADER -->
		<!-- BEGIN HEADER & CONTENT DIVIDER -->
		<div class="clearfix"> </div>
		<!-- END HEADER & CONTENT DIVIDER -->
		<!-- BEGIN CONTAINER -->
		<div class="page-container">
			<!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                <!-- BEGIN SIDEBAR -->
                <?php include ("design/inc/sidebar.php");?>
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
							<a href="<?=$url.'admin';?>"><?=lang('admin_panel');?></a>
							<i class="fa fa-circle"></i>
						</li>
						<li>
							<a href="<?=$url.'admin/courses/inside';?>">الدورات</a>
							<i class="fa fa-circle"></i>
						</li>
						<li>
							<span>اضافة دورة</span>
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
															<i class="fa fa-gift"></i>اضافة دورة </div>
													</div>
													<?php //print_r($now);?>
													<div class="portlet light bordered form-fit">
														<div class="portlet-body form">
															<!-- BEGIN FORM-->
															<input type="hidden" id="service_type" value="1">
						<form action="#" class="form-horizontal form-bordered"  method="post" id="myForm">
															    
															    	<div class="form-group">
																	<div class="col-md-2"></div>
																	<div class="col-md-10">
																		<div class="fileinput fileinput-new" data-provides="fileinput">
																						<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;"></div>
																						<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
																						<div>
																							<span class="btn default btn-file">
																								<span class="fileinput-new">صورة  الدورة </span>
																								<span class="fileinput-exists">تغيير</span>
																								<input type="file" name="img_course"> </span>
																								<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> حذف </a>
																						</div>
																					</div>
																					<p style="color:red;direction:rtl"></p>
																		<p style="color:red;direction:rtl">عرض الصورة 400 بيكسل</p>
																		<p style="direction:rtl">طول الصورة 400بيكسل</p>
																	</div>
																	</div>
															    
															    
																<div class="form-body">
																	
																	<div class="form-group">
																		<div class="col-md-2"></div>
																		<div class="col-md-10">
																		<span class="help-block"> اسم الدورة </span>
																			<input name="title" id="title"  type="text" placeholder="اسم الدورة " class="form-control" required>
																			
																		</div>
																	</div>																	
																	
																	<div class="form-group">
																		<div class="col-md-2"></div>
																		<div class="col-md-10">
																		<span class="help-block">السعر</span>
																			<input name="price" id="price"  type="text" placeholder="السعر" class="form-control" required>
																		</div>
																	</div>	
																	
																	<div class="form-group">
																		<div class="col-md-2"></div>
																		<div class="col-md-10">
																		<span class="help-block">مدة الدراسة</span>
																			<input name="duration_course" id="duration_course"  type="text" placeholder="مدة الدراسة" class="form-control" required>
																		</div>
																	</div>	
																	
																	<div class="form-group">
																		<div class="col-md-2"></div>
																		<div class="col-md-10">
																		<span class="help-block">الخصم</span>
																			<input name="discount"   type="text" placeholder="الخصم" class="form-control" required>
																		</div>
																	</div>	
																	
																		<div class="form-group">
														<div class="col-md-2"></div>
                                                            <div class="col-md-10">
                                                                <label> الدول </label>
                                                             <select name="country_id"  class="form-control"  onChange="getState(this.value);">
                                                                  <option value="">من فضلك حدد الدولة</option>
                                                             <?php 
                                                             foreach($country as $country){
                                                             ?>
                                                             <option value="<?=$country->id?>"> <?=$country->title?> </option>
                                                             <?php }?>
                                                             </select>
															</div>
                                                        </div>
														
														
														
                                                        <div class="form-group">
														<div class="col-md-2"></div>
                                                            <div class="col-md-10">
                                                                 <label>المدن</label>
                        <select class="form-control demoInputBox city_id"  name="city_id"  id="state-list">
                        <option value="">المدينة</option>
                        </select>
															</div>
                                                        </div>
                                                        
                                                        
                                                        <div class="form-group">
														<div class="col-md-2"></div>
                                                            <div class="col-md-10">
                                                                <label> التخصص   </label>
                                                             <select name="cat_id"  class="form-control"  id="cat_id">
                                                             <?php 
                                                             foreach($category as $category){
                                                             ?>
                                                             <option value="<?=$category->id?>"> <?=$category->name?> </option>
                                                             <?php }?>
                                                             </select>
															</div>
                                                        </div>
                                                        
                                                        
                                                        <div class="form-group">
														<div class="col-md-2"></div>
                                                            <div class="col-md-10">
                                                                <label> نوع الدورة   </label>
                                                             <select name="type"  class="form-control"  id="type">
                                                              <option value="1">الدورات الداخلية</option>
                                                             <option value="3">الدبلومات</option>
                                                               <option value="4">الدورات الخارجية</option>
                                                             </select>
															</div>
                                                        </div>
                                                        
                                                        
                                                        <div class="form-group inside_courses">
																		<div class="col-md-2"></div>
																		<div class="col-md-10">
																		<span class="help-block">عدد المقاعد</span>
																			<input name="num_seats"  id="num_seats"  type="text" placeholder="عدد المقاعد" class="form-control" required>
																		</div>
																	</div
																	
    											 <div class="form-group inside_courses">
    												<div class="col-md-2"></div>
    												<div class="col-md-10">
    												<span class="help-block">تاريخ الدورة</span>
    			  <input name="course_date" style="direction:rtl;width: 100%;" size="18" id="course_date" type="text"  class="form_datetime form-control"  placeholder="تاريخ الدورة">

    												</div>
    											</div>
																	
																	
                                                        <div class="form-group inside_courses">
																		<div class="col-md-2"></div>
																		<div class="col-md-10">
																		<span class="help-block">رقم الأعتماد</span>
																			<input name="accreditation_number"   type="text" placeholder="رقم الأعتماد" class="form-control" required>
																		</div>
																	</div>
																	  <div class="form-group">
																		<div class="col-md-2"></div>
																		<div class="col-md-10">
																		<span class="help-block">مقدم الدورة</span>
																			<input name="institute_name" id="institute_name"   type="text" placeholder="مقدم الدورة" class="form-control" required>
																		</div>
																	</div>
																	
																	  <div class="form-group">
																		<div class="col-md-2"></div>
																		<div class="col-md-10">
																		<span class="help-block">وصف مقدم الدورة</span>
																	<textarea name="institute_about" id="institute_about" class="form-control" style="height:100px;"></textarea>

																		</div>
																	</div>
																	
																		<div class="form-group">
																	<div class="col-md-2"></div>
																	<div class="col-md-10">
																		<div class="fileinput fileinput-new" data-provides="fileinput">
																						<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;"></div>
																						<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
																						<div>
																							<span class="btn default btn-file">
																								<span class="fileinput-new">صورة مقدم الدورة</span>
																								<span class="fileinput-exists">تغيير</span>
																								<input type="file" name="img_institute"> </span>
																								<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> حذف </a>
																						</div>
																					</div>
																					<p style="color:red;direction:rtl"></p>
																		<p style="color:red;direction:rtl">عرض الصورة 400 بيكسل</p>
																		<p style="direction:rtl">طول الصورة 400بيكسل</p>
																	</div>
																	</div>
																	
																	<div class="form-group outside_courses" style="display:none">
																		<div class="col-md-2"></div>
																		<div class="col-md-10">
																		<span class="help-block"> نوع السكن</span>
																			<input name="home_type" id="home_type"   type="text" placeholder="نوع السكن" class="form-control" required>
																		</div>
																	</div>
																	
																	
																	
																	
																	
																	<div class="form-group">
																		<div class="col-md-2"></div>
																		<div class="col-md-10">
																		<span class="help-block">الوصف العام للدورة</span>
																			<textarea name="details" id="details" class="form-control" style="height:80px"></textarea>
																		</div>
																	</div>
																	
																	<div class="form-actions">
																		<div class="row">
																			<div class="col-md-offset-3 col-md-9">
																				<button type="button" class="mainbutton btn green coursesbutton">
																					<i class="fa fa-check"></i>حفقظ</button>
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
        <?php include ("design/inc/footer.php");?>
        <!-- END FOOTER -->

        <?php include ("design/inc/footer_js.php");?>
<script>
$(document).ready(function(e) {
    $(".cancelbutton").click(function(e) {
        window.location.assign("<?=DIR?>admin/places/");
    });
    $("#type").change(function(){
     var val=  $(this).val(); 
      if(val==1){
          $(".outside_courses").hide();
          $(".inside_courses").show();
      }
      else {
          $(".inside_courses").hide();
          $(".outside_courses").show();     
      }
    });
});
</script>

<script type="text/javascript">
    $(".form_datetime").datetimepicker({format: 'yyyy-mm-dd hh:ii'});
</script>  


</body>
</html>
