<?php
//session_start();
ob_start();
if(!isset($_SESSION['admin_name'])||$_SESSION['admin_name']==""){ 
header("Location:".$url."admin/login"); 
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
<title>تفاصيل الدورة</title>
<?php include ("design/inc/header.php");?>
<style>
.mt-comments .mt-comment {
    background-color:#f9f9f9;
    height: 75px;
}
</style>
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
							<a href="<?=$url.'admin';?>">لوحة التحكم</a>
							<i class="fa fa-circle"></i>
						</li>
						<li>
							<a href="<?=$url.'admin/courses/inside/';?>">الدورات</a>
							<i class="fa fa-circle"></i>
						</li>
						<li>
							<span class="active">تفاصيل الدورة</span>
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
															<i class="fa fa-gift"></i> تفاصيل الدورة </div>

													</div>

													<div class="portlet light bordered form-fit">
														<div class="portlet-title">
															<div class="caption"></div>
															<div class="actions"></div>
														</div>
														<?php
															foreach($data as $result){
																$id = $result->id;
																$username = $result->name;
																$details = $result->details;
																$duration_course = $result->duration_course;
																$img = $result->img;
																$accreditation_number = $result->accreditation_number;
																$price = $result->price;
																$discount = $result->discount;
																$date_course = $result->date_course;
																$country_id = $result->country_id;
																$home_type = $result->home_type;
																$duration_study = $result->duration_study;
																$notes = $result->notes;
																$type = $result->type;
																$user_id = $result->user_id;
																$num_seats = $result->num_seats;
																$creation_date = $result->creation_date;
															}
															
										$city_id=$result->city_id;
											$cat_id=$result->cat_id;
										$city_name=get_table_filed('city',array('id'=>$city_id),"name");
										$country_id=get_table_filed('city',array('id'=>$city_id),"country_id");
									$country_name=	get_table_filed('country',array('id'=>$country_id),"title");
									$category_name=	get_table_filed('category',array('id'=>$cat_id),"name");

										$Institute_name=get_table_filed('Institute',array('id_course'=>$id),"Institute_name");
										$Institute_about=get_table_filed('Institute',array('id_course'=>$id),"Institute_about");
										$Institute_img=get_table_filed('Institute',array('id_course'=>$id),"Institute_img");
								if($Institute_img!=""){$instute_img=base_url()."uploads/institute/".$Institute_img;}
                              else {$instute_img=base_url()."uploads/products/no_img.png";  }
								    	$country_name=	get_table_filed('country',array('id'=>$country_id),"title");
															if($img!=""){
															if(file_exists($_SERVER['DOCUMENT_ROOT'].'/uploads/products/'.$img)){
																$imge = base_url('uploads/customers/'.$img);
															}else{
																$imge = base_url('uploads/products/no_img.png');
															}
															}else{
																$imge = base_url('uploads/products/no_img.png');
															}
																$view=$result->view;
																switch($view){
													case 0:
													  $view="<span class='label label-sm label-danger'>غير مفعل</span>";
													  break;
													case 1:
													  $view="<span class='label label-sm label-success'>مفعل</span>";
													  break;
													default:
													  break; 
												}
												$intersted_courses=$this->db->get_where("reviews",array("id_course"=>$result->id,'course_key'=>$result->type))->result();
													$request_courses=$this->db->get_where("request_courses",array("id_course"=>$result->id,'type'=>$result->type))->result();
														?>
														<div class="portlet-body form">
															<!-- BEGIN FORM-->
															<div class="form-horizontal form-bordered">
																<input type="hidden" name="id" value="<?=$id;?>">
																<div class="form-body">
																	<div class="form-group">
																		<div class="col-md-1"></div>
																		<div class="col-md-10">
																			<div class="mt-comments">
																				<div class="mt-comment">
																					<div class="mt-comment-img">
																						<img src="<?=$imge?>" width="50px" height="50px" /> </div>
																					<div class="mt-comment-body">
																						<div class="mt-comment-info">
																							<span class="mt-comment-author"><?=$username;?></span>
																							<span class="mt-comment-date" style="color:#000"><?=$creation_date;?></span>
																						</div>
																					</div>
																				</div>
																			</div>
																			<br>
																			<div class="portlet box yellow">
																				<div class="portlet-title">
																					<div class="caption">
																					    
																					    <?php
													$course_type=$this->input->get("course_type");
													switch($course_type){
													case 1:
													  $course_type="<span class='label label-sm label-danger'>الدورات الداخلية</span>";
													  break;
													case 4:
													  $course_type="<span class='label label-sm label-success'>الدورات الخارجية</span>";
													  break;
													  case 3:
													  $course_type="<span class='label label-sm label-success'>الدبلومات</span>";
													  break;
													default:
													  break; 
												}
																					    
																					    ?>
																						<i class="fa fa-gift"></i>  تفاصيل الدورة من نوع  <?= $course_type?> </div>
																					<div class="tools">
																						<a href="javascript:;" class="collapse"> </a>
																					</div>
																				</div>
																				<div class="portlet-body">
																					<div class="row">
																					
																						<div class="col-md-12">
																							<div class="tab-content">
																								<div class="tab-pane active" id="tab_6_1">
																									<div class="portlet-body">
																										<div class="table-responsive">
																											<table class="table table-bordered">
																												<tbody>
																													<tr>
																														<th> الإسم </th>
																														<td> <?=$username;?> </td>
																													</tr>
																													<tr>
																														<th>مدة الدورة </th>
																														<td> <?=$duration_course;?> </td>
																													</tr>
																													<tr>
																														<th> تصنيف الدورة  </th>
																														<td> <?=$category_name;?> </td>
																													</tr>
																													<tr>
																														<th>  الدولة  </th>
																														<td> <?=$country_name;?> </td>
																													</tr>
																													<tr>
																														<th>  المدينة  </th>
																														<td> <?=$city_name;?> </td>
																													</tr>
																												
																													<tr>
																														<th>عدد الطلبات</th>
																														<td> <?=count($request_courses);?> </td>
																													</tr>
																													
																													<tr>
																														<th>السعر</th>
																														<td> <?=$price;?> </td>
																													</tr>
																													<tr>
																														<th>الخصم</th>
																														<td> <?=$discount;?> </td>
																													</tr>
																													<?php
																													
																													if($result->type!=4){
																													?>
																													<tr>
																														<th> رقم الأعتماد   </th>
																														<td> <?=$accreditation_number;?> </td>
																													</tr>
																													
																														<tr>
																														<th> تاريخ الدورة     </th>
																														<td> <?=$result->date_course;?> </td>
																													</tr>
																													<?php
																													
																													if($result->type==1){
																													?>
																													
																													    <tr>
																														<th> مقدم الدورة </th>
																														<td> <?=$Institute_name;?> </td>
																													</tr>
																													    <tr>
																														<th>  تفاصيل مقدم الدورة   </th>
																														<td> <?=$Institute_about;?> </td>
																													</tr>
																													 <tr>
																														<th>صورة مقدم الدورة</th>
																														<td><img src="<?=$instute_img?>" width="50px" height="50px" /> </td>
																													</tr>
																													 <?php } else {?>
																													    <tr>
																														<th>  المعهد المقدم للدورة  </th>
																														<td> <?=$Institute_name;?> </td>
																													</tr>
																													    <tr>
																														<th>  تفاصيل المعهد المقدم للدورة
																														<td> <?=$Institute_about;?> </td>
																													</tr>
																													 <tr>
																														<th>صورة المعهد المقدم للدورة</th>
																														<td> 	<img src="<?=$instute_img?>" width="50px" height="50px" />  </td>
																												
																													</tr>
																													 <?php }?>
                                                                                                                  <tr>
																													<?php } else {?>
																													
																															<tr>
																														<th>  نوع السكن    </th>
																														<td> <?=$result->home_type;?> </td>
																													</tr>
																													
																														<tr>
																														<th> مدة الدراسة </th>
																														<td> <?=$result->duration_study;?> </td>
																													</tr>
																													
																													    <tr>
																														<th>  المعهد المقدم للدورة  </th>
																														<td> <?=$Institute_name;?> </td>
																													</tr>
																													    <tr>
																														<th>  تفاصيل المعهد المقدم للدورة
																														<td> <?=$Institute_about;?> </td>
																													</tr>
																													 <tr>
																														<th>صورة المعهد المقدم للدورة</th>
																														<td><img src="<?=$instute_img?>" width="50px" height="50px" /> </td>
																												
																													</tr>
																																																										 <tr>
																														<td colspan="2"> <?=$result->notes;;?> </td>
																												
																													</tr>
																													<?php }?>
																														
  <tr>
																														<th> تقييم الدورة</th>
																														<td> <?=$result->total_rate;?> </td>
																													</tr>
																													
																													<tr>
																														<th> عدد التقييمات </th>
																					<td> <a href="<?=$url?>admin/courses/rate_details?id=<?=$result->id;?>&course_type=<?= $result->type?>"><?= count($intersted_courses);?></a></td>
																													</tr>
																													
																													<tr>
																														<th> تاريخ أشاء الدورة </th>
																														<td> <?=$creation_date;?> </td>
																													</tr>
																														
																											<?php 
																													if(count($course_info)>0){?>
																												<tr><td colspan="2" style="text-align:center"> محتوى الدورة</td></tr>	
																										  <?php 
																										  foreach($course_info as $intersted_courses){
																										   $course_content= $intersted_courses->content;
																													?>
																														<tr>
																												<td colspan="2"><?=$course_content;?> </td>
																													</tr>
																													<?php }?>
																													<?php }?>
																													
																													
																												</tbody>
																											</table>
																										</div>
																									</div>
																								</div>
																						
																					
																							</div>
																						</div>
																					</div>
																				</div>
																			</div>
																		
																		</div>
																		<div class="col-md-1"></div>
																	</div>
															</div>
															<!-- END FORM-->
															</div>
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
        window.location.assign("show");
    });
});
</script>
</body>
</html>