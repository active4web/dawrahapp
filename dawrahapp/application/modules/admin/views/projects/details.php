<?php
//session_start();
ob_start();
$url=base_url();
if(!isset($_SESSION['admin_name'])||$_SESSION['admin_name']==""){ 
 redirect(base_url().'admin/login/','refresh');
}
else{
$id_admin=$_SESSION['id_admin'];
$admin_name=$_SESSION['admin_name'];
$last_login=$_SESSION['last_login'];
$curt='allprojects';
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
<title>تفاصيل المشروع</title>
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
if($this->input->get("project_id")==4){
?>

<li>
<a href="<?= $url . 'admin/projects/future'; ?>">المشاريع المستقبلية</a>
<i class="fa fa-circle"></i>
</li>
<?php }?>
<?php 
if($this->input->get("project_id")==3){
?>

<li>
<a href="<?= $url . 'admin/projects/finished'; ?>">المشاريع المنتهية</a>
<i class="fa fa-circle"></i>
</li>
<?php }?>
						<li>
							<span class="active">تفاصيل المشروع</span>
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
															<i class="fa fa-gift"></i> تفاصيل المشروع </div>

													</div>

													<div class="portlet light bordered form-fit">
														<div class="portlet-title">
															<div class="caption"></div>
															<div class="actions"></div>
														</div>
														<?php


															foreach($data as $result){



									$sql_finished_date=get_table_data('tbl_tasks',array('project_id'=>$result->id,'finished_date!='=>""),1,'finished_date','desc');

									$sql_start_date=$this->db->limit(1)->order_by('start_date','asc')->get_where('tbl_tasks',array('project_id'=>$result->id,'select_date'=>'2'))->result();
									$count_start=0;
									$count_end=0;
									if(count($sql_finished_date)>0){
										 $count_end	=count($sql_finished_date);
									foreach($sql_finished_date as $sql_finished_date)
											$data_sql['finish_date']=$sql_finished_date->finished_date;
											$this->db->update("tbl_projects",$data_sql,array('id'=>$result->id));
											$finish_date_task=$sql_finished_date->finished_date;
										}
                                        if(count($sql_start_date)>0){
											$count_start	=count($sql_start_date);
											foreach($sql_start_date as $sql_start_date)
											$data_sql['task_start_date']=$sql_start_date->start_date;
											$this->db->update("tbl_projects",$data_sql,array('id'=>$result->id));
											$start_date_task=$sql_start_date->start_date;
											}
										                        $id = $result->id;
																$username = $result->name;
																$creation_date = $result->creation_date;
																$status = $result->status;
																$type_id = $result->type_id;
																$update_date = $result->update_date;
																$details = $result->details;
																$logo = $result->logo;
																$id_magager = $result->id_magager;
																$clients_name = $result->clients_name;
																$clients_phone = $result->clients_phone;
																$total_hrs = $result->total_hrs;
																$finish_date = $result->finish_date;
																$start_date = $result->start_date;
																$select_date = $result->select_date;
																	
																$task_start_date = $result->task_start_date;
																$code = $result->code;
																}
												switch($status){
													case 1:
													  $status="<span class='label label-sm label-danger' style='background-color:#e7505a !important'>قيد العمل</span>";
													  break;
													case 2:
													  $status="<span class='label label-sm label-success'>قيد الانتظار</span>";
													  break;
													  case 3:
													  $status="<span class='label label-sm label-success'>مستقبلى</span>";
													  break;
													  case 4:
													  $status="<span class='label label-sm label-success' style='background-color:#4099ff !important'>تم الانتهاء</span>";
													  break;
													default:
													  break; 
												}
$project_tasks=get_table_data('tbl_tasks',array('project_id'=>$id));
$project_manager_name=get_table_filed("tbl_users",array("id"=>$id_magager),"fname");
//$users_tasks=$this->db->GROUP_BY("user_id")->get_where('tbl_tasks',array('project_id'=>$id,'user_id!='=>""))->result();
$users_tasks = $this->db->select('user_id as ids')
						->group_by('ids')
						->get_where('tbl_tasks',array('project_id'=>$id,'user_id!='=>""))
						->result();
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
																					
																					<div class="mt-comment-body">
																						<div class="mt-comment-info">
																							<span class="mt-comment-author"><?=$username."&nbsp&nbsp".$code."";?></span>
																							<span class="mt-comment-date"><?=$status;?></span>
																						</div>
																					</div>
																				</div>
																			</div>
																			<br>
																			<div class="portlet box yellow">
																				
																				<div class="portlet-body">
																					<div class="row">
																						<div class="col-md-3 col-sm-3 col-xs-3">
																							<ul class="nav nav-tabs tabs-left">
																								<li class="active">
																									<a href="#tab_6_1" data-toggle="tab">تفاصيل المشروع</a>
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
																														<th>
																														
																														<?php if($logo !=""){?>
								   <img src="<?=DIR?>uploads/projects/<?=$logo?>" style="width:80px;height:80px;border-radius:50%;">
									<?php }else {?>
                                 
								<img src="<?=DIR?>uploads/projects/avatar.png" style="width:50px;height:50px;">
								 <?php }  ?>
																														 </th>
																													</tr>

																													<tr>
																														<th>تاربخ اضافة المشروع</th>
																														<td> <?=$creation_date;?> </td>
																													</tr>
																													<tr>
																														<th>تاريخ التعديل</th>
																														<td> <?=$update_date;?> </td>
																													</tr>
																													
																													<?php
																														if($id_magager!=""){
																														?>
																													<tr>
																														<th> مدير المشروع</th>
																														<td> <?=$project_manager_name;?> </td>
																														<?php } else {?>
																															<td> غير معلوم </td>
																														<?php }?>
																													</tr>
																												
																													<tr>
																														<th> ساعات العمل </th>
																														<?php
																														if($select_date!=1){
																														?>
																														<td> <?=$total_hrs;?> </td>
																														<?php } else {?>
																															<td> غير معلوم </td>
																														<?php }?>
																													</tr>
																													<tr>
																														<th>تاريخ البداء </th>
																														<?php
																														if($select_date!=1){
																														?>
																														<td> <?=$start_date;?> </td>
																														<?php } else {?>
																															<td> غير معلوم </td>
																														<?php }?>
																													</tr>
																													<tr>
																														<th>تاريخ بداية اول مهمة </th>
																														<?php

																														if($count_start>0){
																														?>
																														<td> <?=$start_date_task;?> </td>
																														<?php }else {?>
																												<td> غير معلوم</td>
																														<?php }?>
																													</tr>
																													
																										<tr>
																											<th>تاريخ الانهاء </th>
																											<?php
																											if($count_start>0){
																											?>
																											<td> <?=$finish_date;?> </td>
																											<?php }else {?>
																										<td> غير معلوم</td>
																											<?php }?>
																										</tr>
											                             
		<th><a href="<?= DIR?>admin/task/project_users?project_id=<?= $this->input->get("project_id");?>&id_project=<?=$result->id;?>">فريق العمل <?php if(count($users_tasks)>0){?>
																									(<?=count($users_tasks)?>)<?php } else {?>
																									لا يوجد حاليا
																									<?php }?>
																									</a></th>
																												
																											</tr>

<?php
if($status==1||$status==4){
?>
																											<tr>
																					<th><a href="<?= DIR?>admin/task/tasks?id_project=<?=$result->id;?>">
																									مهام المشروع <?php if(count($project_tasks)>0){?>
																									(<?=count($project_tasks)?>)<?php } else {?>
																									لا يوجد حاليا
																									<?php }?>
																									</a></th>
																												
																											</tr>
																											<?php }?>

																													<tr>
																														<td> <?=$details;?> </td>
																													</tr>
																													
<?php
//if($this->session->userdata('end_project')=="end_project"){?>
<!--	<tr>
	<td>
 <a href="<?=DIR?>admin/projects/chaneg_finished?project_id=<?=$result->id?>"><button id="sample_editable_1_2_new" class="btn sbold red"> انهاء المشروع</button></a>
 </td></tr>-->
<?php //}?>
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
