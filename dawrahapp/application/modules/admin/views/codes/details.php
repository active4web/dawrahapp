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
$curt='tasks';
}
foreach($data as $result)
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
<title>تفاصيل المهمة</title>
<?php include ("design/inc/header.php");?>
<style>
.mt-comments .mt-comment {
    background-color: #e9e9e9;
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
							<a href="<?=$url.'admin';?>">الرئيسية</a>
							<i class="fa fa-circle"></i>
						</li>
												<?php
$id_projects=$this->input->get("id_project");
$status=get_table_filed("tbl_projects",array("id"=>$id_projects),"status");
if($status==1){
?>
<li>
<a href="<?= $url . 'admin/projects/current_projects'; ?>">المشاريع الحالية</a>
<i class="fa fa-circle"></i>
</li>
<?php }?>
<?php 
if($status==4){
?>
<li>
<a href="<?= $url . 'admin/projects/finished'; ?>">المشاريع المنتهية</a>
<i class="fa fa-circle"></i>
</li>
<?php }?>
						<li>
							<a href="<?= $url . 'admin/task/tasks?id_project='. $result->project_id;?>">المهام</a>
							<i class="fa fa-circle"></i>
						</li>
						<li>
							<span class="active">تفاصيل المهمة</span>
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
															<i class="fa fa-gift"></i> تفاصيل المهمة</div>

													</div>

													<div class="portlet light bordered form-fit">
														<div class="portlet-title">
															<div class="caption"></div>
															<div class="actions"></div>
														</div>
														<?php
															
																$id = $result->id;
																$name = $result->name;
																$project_id = $result->project_id;
																$user_id = $result->user_id;
																$main_task = $result->main_task;
																$start_date = $result->start_date;
																$review_date = $result->review_date;
																$review1_date = $result->review1_date;
																$finished_date = $result->finished_date;
																$status = $result->status;
																$status_review = $result->status_review;
																$status_review1 = $result->status_review1;
																$total_hrs = $result->total_hrs;
																$select_date = $result->select_date;
																$code = $result->code;
																$userid_review = $result->userid_review;
																$userid_review1 = $result->userid_review1;
																$project_name=get_table_filed("tbl_projects",array("id"=>$project_id),"name");
																$teamleader=get_table_filed("tbl_users",array("id"=>$userid_review),"fname");
																$manager_name=get_table_filed("tbl_users",array("id"=>$userid_review1),"fname");
																$manager_lname=get_table_filed("tbl_users",array("id"=>$userid_review1),"lname");
																$leader_lname=get_table_filed("tbl_users",array("id"=>$userid_review),"lname");
														?>
														<div class="portlet-body form">
															<!-- BEGIN FORM-->
													
																			<div class="portlet box yellow">
																			
																				<div class="portlet-title">
																					<div class="caption">
																						<i class="fa fa-gift"></i>  <?=$name?> (<?=$code?>)</div>
																					<div class="tools">
																						<a href="javascript:;" class="collapse"> </a>
																					</div>
																				</div>
																				<div class="portlet-body">
																					<div class="row">
																						<div class="col-md-3 col-sm-3 col-xs-3">
																							<ul class="nav nav-tabs tabs-left">
																							
																								<li class="active">
																									<a href="#tab_6_1" data-toggle="tab">مختصر التفاصيل </a>
																								</li>
																								<li>
																									<a href="#tab_6_2" data-toggle="tab">اسم المشروع</a>
																								</li>
																								<li>
																									<a href="#tab_6_3" data-toggle="tab">اسم المهمة</a>
																								</li>
																								<li>
																									<a href="#tab_6_4" data-toggle="tab">تاريخ البداية</a>
																								</li>
																								<li>
																									<a href="#tab_6_5" data-toggle="tab">تاريخ النهاية</a>
																								</li>
																								<li>
																									<a href="#tab_6_6" data-toggle="tab">عدد الساعات</a>
																								</li>
																								<li>
																									<a href="#tab_6_7" data-toggle="tab">التيم ليدر</a>
																								</li>
																								<li>
																									<a href="#tab_6_8" data-toggle="tab">مدير المشروع</a>
																								</li>
																								<li>
																									<a href="#tab_6_9" data-toggle="tab">تاريخ المراجعة الاولى</a>
																								</li>
																								<li>
																									<a href="#tab_6_10" data-toggle="tab">تاريخ المراجعة الثانية</a>
																								</li>
																								<li>
																									<a href="#tab_6_11" data-toggle="tab">ملاحظات</a>
																								</li>
																								<li>
																									<a href="#tab_6_12" data-toggle="tab"> التفاصيل</a>
																								</li>
																							</ul>
																						</div>
																						<div class="col-md-9 col-sm-9 col-xs-9">
																							<div class="tab-content">
																								<div class="tab-pane active" id="tab_6_1">
																									<div class="portlet-body">
																										<div class="table-responsive">
																											<table class="table table-bordered">
																												<tbody>
																												<tr>
																														<th> المهمة </th>
																														<td> <?=$name;?> </td>
																													</tr>
																													<tr>
																														<th> المشروع </th>
																														<td> <?=$project_name;?> </td>
																													</tr>
																													<tr>
																														<th> مدير  المشروع </th>
																														<td> <?=$manager_name."&nbsp;".$manager_lname?> </td>
																													</tr>
																												
																													<tr>
																														<th> وقت البداية </th>
																														<td> <?php
																														if($select_date==1){
																															echo $start_date="غير محدد";
																														}
																														else {
																															echo $start_date=$start_date	;
																														}
																														?></td>
																													</tr>
																													<tr>
																														<th> وقت النهاية </th>
																														<td> <?php
																														if($select_date==1){
																															echo "غير محدد";
																														}
																														else {
																															echo $finished_date	;
																														}
																														?> </td>
																													</tr>
																													<tr>
																														<th> وقت المراجعة الاولى </th>
																														<td> <?=$review_date?> </td>
																													</tr>
																													<tr>
																														<th> وقت المراجعة الثانية </th>
																														<td> <?=$review1_date?> </td>
																													</tr>
																													<tr>
																														<th>عدد الساعات </th>
																														<td> <?=$total_hrs ?> </td>
																													</tr>
															<?php if($this->session->userdata('user_statistics')=="user_statistics"){	?>
																									<tr>
																									<th>احصائيات العمل</th>
																									<td> <a href="<?= DIR?>admin/task/user_statistics?id_project=<?=$project_id?>&id=<?=$id?>">الاحصائيات</a> </td>
																									</tr>
															<?php }	if($this->session->userdata('review_statistics')=="review_statistics"){
																									?>
																									<tr>
																									<th>احصائيات المراجعة</th>
																									<td>  <a href="<?= DIR?>admin/task/review_statistics?id_project=<?=$project_id?>&id=<?=$id?>">الاحصائيات</a></td>
																									</tr>
																									<?php }?>
																												</tbody>
																											</table>
																										</div>
																									</div>
																								</div>
																								<div class="tab-pane fade" id="tab_6_2">
																									<?php //print_r($values);?>
																									<div class="portlet-body">
																										<div class="table-responsive">
																											<table class="table table-bordered">
																												<thead>
																													<th> المشروع </th>
																												</thead>
																												<tbody>
																												
																													<tr>
																														<td><?=$project_name?></td>
																													</tr>
																												</tbody>
																											</table>
																										
																										</div>
																									</div>
																								</div>
																								<div class="tab-pane fade" id="tab_6_3">
																									<div class="portlet-body">
																										<div class="table-responsive">
																											<table class="table table-bordered">
																												<thead>
																													<th> المهمة </th>
																												</thead>
																												<tbody>
																													<tr>
																														<td> <?=$name?> </td>
																													</tr>
																												</tbody>
																											</table>
																											
																										</div>
																									</div>
																								</div>
																								<div class="tab-pane fade" id="tab_6_4">
																									<div class="portlet-body">
																										<div class="table-responsive">
																											<table class="table table-bordered">
																												<thead>
																													<th>تاريخ البداية</th>
																												</thead>
																												<tbody>
																													<tr><td> 
																														<?php
																														if($select_date==1){
																															echo $start_date="غير محدد";
																														}
																														else {
																															echo $start_date=$start_date	;
																														}
																														?>
																														</td>
																													</tr>
																												</tbody>
																											</table>
																										</div>
																									</div>
																								</div>

																								<div class="tab-pane fade" id="tab_6_5">
																									<div class="portlet-body">
																										<div class="table-responsive">
																											<table class="table table-bordered">
																												<thead>
																													<th> تاريخ النهاية </th>
																												</thead>
																												<tbody>
																													<tr>
																														<td><?php
																														if($select_date==1){
																															echo "غير محدد";
																														}
																														else {
																															echo $finished_date	;
																														}
																														?> </td>
																													</tr>
																												</tbody>
																											</table>
																											
																										</div>
																									</div>
																								</div>

																								<div class="tab-pane fade" id="tab_6_6">
																									<div class="portlet-body">
																										<div class="table-responsive">
																											<table class="table table-bordered">
																												<thead>
																													<th> عدد الساعات </th>
																												</thead>
																												<tbody>
																													<tr>
																														<td> <?=$total_hrs ?> </td>
																													</tr>
																												</tbody>
																											</table>
																											
																										</div>
																									</div>
																								</div>


																								<div class="tab-pane fade" id="tab_6_7">
																									<div class="portlet-body">
																										<div class="table-responsive">
																											<table class="table table-bordered">
																												<thead>
																													<th> التيم ليدر </th>
																												</thead>
																												<tbody>
																													<tr>
																														<td> <?=$teamleader."&nbsp;".$leader_lname?> </td>
																													</tr>
																												</tbody>
																											</table>
																											
																										</div>
																									</div>
																								</div>

																								<div class="tab-pane fade" id="tab_6_8">
																									<div class="portlet-body">
																										<div class="table-responsive">
																											<table class="table table-bordered">
																												<thead>
																													<th> مدير المشروع </th>
																												</thead>
																												<tbody>
																													<tr>
																														<td><?=$manager_name."&nbsp;".$manager_lname?> </td>
																													</tr>
																												</tbody>
																											</table>
																											
																										</div>
																									</div>
																								</div>

																								<div class="tab-pane fade" id="tab_6_9">
																									<div class="portlet-body">
																										<div class="table-responsive">
																											<table class="table table-bordered">
																												<thead>
																													<th>تاريخ المراجعة الاولى</th>
																												</thead>
																												<tbody>
																													<tr>
																														<td> <?=$review_date?> </td>
																													</tr>
																												</tbody>
																											</table>
																											
																										</div>
																									</div>
																								</div>

																								<div class="tab-pane fade" id="tab_6_10">
																									<div class="portlet-body">
																										<div class="table-responsive">
																											<table class="table table-bordered">
																												<thead>
																													<th> تاريخ المراجعة الثانية </th>
																												</thead>
																												<tbody>
																													<tr>
																														<td> <?=$review1_date?> </td>
																													</tr>
																												</tbody>
																											</table>
																											
																										</div>
																									</div>
																								</div>


																								<div class="tab-pane fade" id="tab_6_11">
																									<div class="portlet-body">
																										<div class="table-responsive">
																											<table class="table table-bordered">
																												
																												<tbody>
																												<thead>
																												
																													<th> التفاصيل  </th>
																													<th> المرسل  </th>
																													<th> التاريخ  </th>
																													<?php if($status!=2){?>
																													<th> الرد  </th>
																													<?php }?>
																												</thead>
																												<?php foreach($notes as $notes){?>
																								<tr>
																									<td> <?=$notes->notes;?></td>
																									<td> <?php echo get_this('tbl_users',['id'=>$notes->id_sender],'fname');?></td>

																									<td> <?=$notes->create_date;?></td>
																									<?php if($status!=2){?>
																									<td> <a href="<?=DIR?>admin/task/notes_reply?id_project=<?php echo $project_id;?>&id_status=<?php echo $id;?>&id_messg=<?php echo $notes->id?>"><i class="fa fa-mail-reply"></i></a></td>
																									<?php }?>
<?php 
$reply_sql=$this->db->order_by("id","desc")->get_where('projects_notes',array('id_replay'=>$notes->id))->result();
if(count($reply_sql)>0){
	foreach($reply_sql as $reply_sql){
?>

<thead>
<th>من : <?php echo get_this('tbl_users',['id'=>$reply_sql->id_sender],'fname');?></th>
<th colspan="3"> <?=$reply_sql->notes;?>  </th>
</thead>																											
<?php } }?>


																								</tr>
																							<?php }?>
																												</tbody>
																											</table>
																											
																										</div>
																									</div>
																								</div>

																								<div class="tab-pane fade" id="tab_6_12">
																									<div class="portlet-body">
																										<div class="table-responsive">
																											<table class="table table-bordered">
																												<thead>
																													<th> تفاصيل المهمة </th>
																												</thead>
																												<tbody>
																													<tr>
																														<td> <?=$main_task?> </td>
																													</tr>
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
