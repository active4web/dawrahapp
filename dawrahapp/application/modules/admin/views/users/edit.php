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
$curt='customers';
}
foreach($data as $result){
$id = $result->id;
$username = $result->user_name;
$email = $result->email;
$phone = $result->phone;
$img = $result->img;
$points = $result->points;
$invitation_code = $result->invitation_code;
$invitation_count = $result->invitation_count;
$creation_date = $result->creation_date;
$about = $result->about;
$status = $result->status;
$age = $result->age;
$view = $result->view;
$city_id=$result->city_id;
$cat_id=$result->cat_id;
$city_name=get_table_filed('city',array('id'=>$city_id),"name");
$country_id=get_table_filed('city',array('id'=>$city_id),"country_id");
$country_name=	get_table_filed('country',array('id'=>$country_id),"title");
if($cat_id!=""){
$category_name=	get_table_filed('category',array('id'=>$cat_id),"name");
}
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
<title>تعديل بيانات عميل</title>
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
							<a href="<?=$url.'admin';?>">لوحة التحكم</a>
							<i class="fa fa-circle"></i>
						</li>
						<li>
						    <?php
						    if($status==1){ $ret_p="customers";}
						    else if($status==2){$ret_p="trainers";} 
						    else if($status==3){$ret_p="bags_provider";}
						    else if($status==4){$ret_p="companies";}
						    ?>
							<a href="<?=$url."admin/users/$ret_p/";?>">العملاء</a>
						
							<i class="fa fa-circle"></i>
						</li>
						<li>
							<span class="active">تعديل بيانات عميل</span>
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
                                                    <i class="fa fa-gift"></i><?=lang('add_admins');?></div>
                                            </div>
                                        <div class="portlet light bordered form-fit">
                                            <div class="portlet-title">
                                                <div class="caption"></div>
                                                <div class="actions"></div>
                                            </div>
                                            <div class="portlet-body form">
                                                <!-- BEGIN FORM-->
												<?php
                                       
													if($img!=""){
														if(file_exists($_SERVER['DOCUMENT_ROOT'].'/uploads/customers/'.$img)){
															$imge = base_url('uploads/customers/'.$img);
														}else{
															$imge = base_url('uploads/customers/avatar.png');
														}
													}else{
														$imge = base_url('uploads/customers/avatar.png');
													}
													
													switch($view){
													case '0':
													  $view="<span class='label label-sm label-danger'>غير مفعل</span>";
													  break;
													case '1':
													  $view="<span class='label label-sm label-success'>مفعل</span>";
													  break;
													default:
													  break; 
												}
												?>
                                                <form action="<?=$url;?>admin/users/edit_action" class="form-horizontal form-bordered"  method="post" enctype="multipart/form-data">
												<?php if ($this->session->flashdata('message')) { ?>
													 <?=$this->session->flashdata('message');?>
												<?php } ?>
												<input type="hidden" name="id" value="<?=$id;?>" id="id">
                                                    <div class="form-body">
														<div class="form-group">
														<div class="col-md-3" style="text-align:center"></div>
                                                            <div class="col-md-6" style="text-align:center">
                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
																			<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
																				<img src="<?=$imge;?>" alt="" /> </div>
																			<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
																			<div>
																				<span class="btn default btn-file">
																					<span class="fileinput-new">الصورة الشخصية</span>
																					<span class="fileinput-exists">تغيير</span>
																					<input type="file" name="img"> </span>
																				<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> حذف </a>
																			</div>
																		</div>
															</div>
															<div class="col-md-3" style="text-align:center"></div>
                                                        </div>
														
														<div class="form-group">
														<div class="col-md-2"><span class="help-block">إسم العميل</span></div>
                                                            <div class="col-md-8">
                                                                <input value="<?=$username;?>" type="text" placeholder="إسم العميل" class="form-control" name="username">
															</div>
															<div class="col-md-2"></div>
                                                        </div>
														
														<div class="form-group">
														<div class="col-md-2"><span class="help-block">كلمة المرور</span></div>
                                                            <div class="col-md-8">
                                                                <input value="" type="password" placeholder="كلمة المرور" class="form-control" name="password">
															</div>
															<div class="col-md-2"></div>
                                                        </div>
														
														<div class="form-group">
														<div class="col-md-2"><span class="help-block">البريد الإلكتروني</span></div>
                                                            <div class="col-md-8">
                                                                <input value="<?=$email;?>" type="text" placeholder="البريد الإلكتروني" class="form-control" name="email" id="email">
                                                                <div class="alert alert-danger" id="confirm2" style="display:none">
																	<strong>خطأ!</strong>عفوا البريد الإلكتروني موجود من قبل
																</div>
															</div>
															<div class="col-md-2"></div>
                                                        </div>
														
														<div class="form-group">
														<div class="col-md-2"><span class="help-block">التليفون</span></div>
                                                            <div class="col-md-8">
                                                                <input value="<?=$phone;?>" type="text" placeholder="التليفون" class="form-control" name="phone" id="phone">
                                                                <div class="alert alert-danger" id="confirm" style="display:none">
																	<strong> خطأ! </strong> عفوا رقم التليفون موجود من قبل
																</div>
															</div>
															<div class="col-md-2"></div>
                                                        </div>
															<div class="form-group">
														<div class="col-md-2"><span class="help-block">العمر</span></div>
                                                            <div class="col-md-8">
                                                                <input value="<?=$age;?>" type="text" placeholder="العمر" class="form-control" name="age" id="age">
                                                              
															</div>
															<div class="col-md-2"></div>
                                                        </div>
                                                        
													<div class="form-group">
														<div class="col-md-2"><span class="help-block"> الدولة</span></div>
                                                            <div class="col-md-8">
                                                                <label> الدولة الحالية (<?= $country_name?>) </label>
                                                             <select name="country_id"  class="form-control"  onChange="getState(this.value);">
                                                                 <option value="" >من فضلك حدد الدولة</option>
                                                             <?php 
                                                             foreach($country as $country){
                                                             ?>
                                                             <option value="<?=$country->id?>"> <?=$country->title?> </option>
                                                             <?php }?>
                                                             </select>
															</div>
															<div class="col-md-2"></div>
                                                        </div>
														
														
														
                                                        <div class="form-group">
														<div class="col-md-2"><span class="help-block"> المدينة</span></div>
                                                            <div class="col-md-8">
                                                                 <label> المدينة الحالية (<?= $city_name?>) </label>
                        <select class="form-control demoInputBox"  name="city_id"  id="state-list">
                        <option value="">المدينة</option>
                        </select>
															</div>
															<div class="col-md-2"></div>
                                                        </div>
														<?php if($status==2){?>
														
														<div class="form-group">
														<div class="col-md-2"><span class="help-block">  التخصص </span></div>
                                                            <div class="col-md-8">
                                                                <label> التخصص الحالى  (<?= $category_name?>) </label>
                                                             <select name="cat_id"  class="form-control"  >
                                                                 <option value="" >من فضلك حدد التخصص</option>
                                                             <?php 
                                                             foreach($category as $category){
                                                             ?>
                                                             <option value="<?=$category->id?>"> <?=$category->name?> </option>
                                                             <?php }?>
                                                             </select>
															</div>
															<div class="col-md-2"></div>
                                                        </div>
														
														<?php }?>
                                                    <div class="form-actions">
                                                        <div class="row">
                                                            <div class="col-md-offset-3 col-md-9">
                                                                <button  type="submit" class="btn green">
                                                                <i class="fa fa-check"></i>تعديل</button>
                                                                <button type="reset" class="btn default">إلغاء</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
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
$(".edit").click(function(e) {
var id = $(this).data("id");
//alert(id);
var data={id:id};
			$.ajax({
				url: '<?php echo base_url("admin/customers/check_status") ?>',
                type: 'POST',
                data: data,				
                success: function( data ) {
                	if (data == "1") {
					// alert(data);
                		$(".code_actvation-"+id).html("<span class='label label-sm label-success'>مفعل</span>");
                	}
                	if (data == "0") {
                		$(".code_actvation-"+id).html("<span class='label label-sm label-danger'>غير مفعل</span>");
                	}
				}
         });
	});
});
</script>
<script type="text/javascript">
	$('#phone').focusout(function(e){
	var phone = $('#phone').val();
	e.preventDefault();
	//alert(data);
	$.ajax({
		url: '<?php echo base_url()?>admin/customers/check_phone',
		type: 'POST',
		dataType: 'json',
		data: {phone: phone},
		success: function(data) {
			///alert(data);
			console.log(data.msg);
			if(data.msg==1){ 
				$("#confirm").show();
				//$('#phone').val('<?=$phone;?>');
				$('#cvcx').prop("type", "button");
			}else{
				$("#confirm").hide();
				$('#cvcx').prop("type", "submit");
			}
		}
	});
});
</script>
<script type="text/javascript">
	$('#email').focusout(function(e){
	var email = $('#email').val();
	e.preventDefault();
	//alert(data);
	$.ajax({
		url: '<?php echo base_url()?>admin/customers/check_email',
		type: 'POST',
		dataType: 'json',
		data: {email: email},
		success: function(data) {
			///alert(data);
			console.log(data.msg);
			if(data.msg==1){ 
				$("#confirm2").show();
				//$('#email').val('<?=$email;?>');
				$('#cvcx').prop("type", "button");
			}else{
				$("#confirm2").hide();
				$('#cvcx').prop("type", "submit");
			}
		}
	});
});
</script>
<?php 
if(isset($_SESSION['msg'])){
?>
<script>
$(document).ready(function(e) {
 toastr.success("<?php echo $_SESSION['msg']?>");
});
</script>
<?php }?>
</body></html>
