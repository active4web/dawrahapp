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
$curt='bank_payments';
}
foreach($data as $data)
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
<title>تعديل حالة الدفع</title>
<?php include("design/inc/header.php"); ?>
</head>
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-md">
<?php include("design/inc/topbar.php"); ?>
<script type="text/javascript" src="<?= $url ?>design/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?= $url ?>design/ckfinder/ckfinder.js"></script>
<div class="clearfix"> </div>
<div class="page-container">
<div class="page-sidebar-wrapper">
<?php include("design/inc/sidebar.php"); ?>
</div>
<div class="page-content-wrapper">
<div class="page-content" style="min-height: 1261px;">
<ul class="page-breadcrumb breadcrumb">
<li>
<a href="<?= $url . 'admin'; ?>"><?= lang('admin_panel'); ?></a>
<i class="fa fa-circle"></i>
</li>
<li>
<a href="<?= $url . 'admin/banks/bank_payments'; ?>">الدفع البنكى</a>
<i class="fa fa-circle"></i>
</li>
<li><span>تعديل حالة الدفع</span></li>
</ul>
<div class="row">
<div class="col-md-12">
<div class="profile-sidebar">
</div>
<div class="profile-content">
<div class="row">
	<div class="col-md-12">
		<!--Start from-->
		<div class="tab-content">
			<div class="tab-pane active" id="tab_5">
				<div class="portlet box blue ">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-gift"></i>تعديل حالة الدفع البنكى</div>
					</div>

					<div class="portlet light bordered form-fit">
						<div class="portlet-title">
							<div class="caption"></div>
							<div class="actions"></div>
						</div>
						<div class="portlet-body form">
                       <input type="hidden" id="idresult" value="0">	
							<form action="<?php echo $url ?>admin/banks/status_action" id="myForm" class="form-horizontal form-bordered" method="post" enctype="multipart/form-data">
							<input type="hidden" name="id" value="<?=$data->id;?>">
								<div class="form-body">

									<div class="form-group">
										<div class="col-md-1"></div>
										<div class="col-md-10">
										<span class="help-block">حالة الدفع</span>
		    <?php $status=$data->status;?>
		<input type="radio"  <?php 	if($status==1||$status==2){?>disabled<?php }?> <?php if($status==0){?>checked<?php }?>  class="form-control" style="height:22px;" name="status" value="0"  > منتظر تاكيد الدفع   
		<input type="radio"  <?php 	if($status==2){?>disabled<?php }?> <?php if($status==1){?>checked<?php }?>  class="form-control" style="height:22px;" name="status" value="1" >تم الدفع بنجاح      
		<input type="radio" <?php 	if($status==1){?>disabled<?php }?> <?php if($status==2){?>checked<?php }?>   class="form-control main_title" style="height:22px;" name="status" value="2" >  فشل الدفع
										</div>
										<div class="col-md-1"></div>
									</div>
<input name="id_status" type="hidden"  value="<?=$data->status;?>" class="form-control" >

									<div class="form-actions">
										<div class="row">
											<div class="col-md-offset-3 col-md-9">
		<button type="button" class="btn green mainubtton paymentfinishbutton"><i class="fa fa-check"></i> حفظ</button>
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
//CKEDITOR.replace('description');
var editor = CKEDITOR.replace( 'contents' );
CKFinder.setupCKEditor( editor );
</script>

</body>
</html>
