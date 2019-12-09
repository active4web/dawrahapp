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
<title>المدفوعات البنكية</title>
<?php include ("design/inc/header.php");?>
<link rel="stylesheet" href="<?=$url;?>design/lightbox2-master/dist/css/lightbox.min.css" type="text/css" media="screen" />
<script src="<?=$url;?>design/lightbox2-master/dist/js/lightbox-plus-jquery.min.js"></script>
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
				<!-- BEGIN CONTENT BODY -->
				<div class="page-content">
					<!-- BEGIN PAGE BREADCRUMB -->
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<a href="<?=$url.'admin';?>">لوحة التحكم</a>
							<i class="fa fa-circle"></i>
						</li>
					
						<li>
							<span class="active">الطلبات</span>
						</li>
					</ul>
					<!-- END PAGE BREADCRUMB -->

					<!-- Start Table Data -->
					<div class="row">
						<div class="col-md-12">
							<!-- BEGIN EXAMPLE TABLE PORTLET-->
							<div class="portlet light bordered">
								<div class="portlet-title">
									<div class="caption font-dark">
										<i class="icon-settings font-dark"></i>
										<span class="caption-subject bold uppercase">الطلبات</span>
									</div>
								</div>
								<span class="portlet-body">
									<div class="table-toolbar">
										<div class="row">
											<div class="col-md-6">
											<!--	<div class="btn-group">
													<button id="sample_editable_1_2_new" class="btn sbold green addbutton"> إضافة
														<i class="fa fa-plus"></i>
													</button>
												</div>-->
												<?php if($result_amount>0){?>
													<!--<div class="btn-group">
														<button id="sample_editable_1_2_new" class="btn sbold red delbutton"> حذف مجموعة
															<i class="fa fa-remove"></i>
														</button>
													</div>-->
												<?php }?>
											</div>
										</div>
									</div>
									<?php if(!empty($results)){?>
									<form action="#" method="POST" id="form">
									<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1_2">
										<thead>
											<tr>
												<th>
													<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
														<input id="checkAll" type="checkbox" class="group-checkable" data-set="#sample_1_2 .checkboxes" />
														<span></span>
													</label>
												</th>
										     	<th>  الدورة  </th>
										     	<th>  النوع  </th>
												<th> المستخدم  </th>
												<th>تاريخ الطلب</th>
												<th>الأجمالى</th>
												<th> حالة الطلب  </th>
										        <th>  رقم الطلب  </th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th> </th>
												<th> </th>
												<th> </th>
												<th> </th>
												<th> </th>
												<th> </th>
												<th> </th>
												<th> </th>
											</tr>
										</tfoot>
										<tbody>
                                        <?php
                                            foreach($results as $data) {
												$active=$data->status;
												switch($active){
													case 0:
													  $active="<span class='label label-sm label-danger'>منتظر التاكيد</span>";
													  break;
													case 1:
													  $active="<span class='label label-sm label-success'>تم تاكيد الحجز</span>";
													  break;
													  case 2:
													  $active="<span class='label label-sm label-success'>تم رفض الحجز </span>";
													  break;
												
													  
													default:
													  break; 
												}
												
										$id_bank=$data->id_bank;
										$id_user=$data->id_user;
										$user_name = get_table_filed('customers',array('id'=>$id_user,'view'=>'1'),"user_name");
                                         
												$id_course=$data->id_course;
												if($data->type==2){$course_name = get_table_filed('bag_info',array('id'=>$id_course,'view'=>'1'),"bage_name");}
												else {
												$course_name = get_table_filed('products',array('id'=>$id_course,'view'=>'1'),"name");
												}
												$type=$data->type;
												switch($type){
													case 1:
													  $type="<span class='label label-sm label-danger'>دورات داخلية</span>";
													  break;
													case 2:
													  $type="<span class='label label-sm label-success'>حقائب تدريبة</span>";
													  break;
													  case 3:
													  $type="<span class='label label-sm label-danger'>دبلومات</span>";
													  break;
												      case 4:
													  $type="<span class='label label-sm label-success'>دورات خارجية</span>";
													  break;
													  
													default:
													  break; 
												}
                                        ?>
											<tr class="odd gradeX">
												<td>
													<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
														<input name="check[]" type="checkbox" class="checkboxes" value="<?=$data->id;?>" />
														<span></span>
													</label>
												</td>
<?php if($data->type==2){ ?> <td> <a href="<?= base_url()?>admin/courses/bages_details?id=<?= $id_course?>&course_type=<?=  $data->type?>"><?=mb_substr($course_name,0,50);?></a> </td>
<?php } else {?>				
<td> <a href="<?= base_url()?>admin/courses/courses_details?id=<?= $id_course?>&course_type=<?=  $data->type?>"><?=mb_substr($course_name,0,50);?></a> </td>
<?php }?>
<td> <?=$type?> </td>
<td> <?=mb_substr($user_name,0,50);?> </td>
	 <td> <?= date("Y-m-d",strtotime($data->creation_date));?> </td>
	 		<td> <?=mb_substr($data->final_price,0,50);?> </td>

												<td>
												<a href="<?= base_url()?>admin/banks/request_courses_status?id=<?=$data->id;?>" class="btn btn-xs purple edit" style="padding: 1px 0px;">
												    <i class="fa fa-edit"></i>
												<span class="code_actvation-<?php echo $data->id;?>"><?php echo $active;?></span>
												</a>
												</td>
												<td> <?=mb_substr($data->request_code,0,50);?> </td>
											
											</tr>
                                            <?php }?>
										</tbody>
									</table>
									</form>
									<?php }else{?>
									<center><span class="caption-subject font-red bold uppercase"><?=lang('no_data');?></span></center>
									<?php }?>
								<div class="row">
                                    <div class="col-md-5 col-sm-5">
									<br>
                                        <div class="dataTables_info" id="sample_1_2_info" role="status" aria-live="polite">
                                        <ul class="nav nav-pills">
                                            <li>
                                            <a href="javascript:;"> مجموع السجلات :
                                                <span class="badge badge-success pull-right"> <?php echo $result_amount; ?> </span>
                                            </a>
                                            </li>
                                        </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-7 col-sm-7">
                                        <div style="text-align: right;" class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_2_paginate">
                                            <ul class="pagination" style="visibility: visible;">
                                                <?php echo $pagination; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
								</div>
							</div>
							<!-- END EXAMPLE TABLE PORTLET-->
						</div>
					</div>
					<!-- END Table Data-->

				</div>
				<!-- END CONTENT -->
		</div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <?php include ("design/inc/footer.php");?>
        <!-- END FOOTER -->

        <?php include ("design/inc/footer_js.php");?>
<script>
$(document).ready(function(e) {
	
    $(".addbutton").click(function(e) {
        window.location.assign("add");
    });

	$(".delbutton").click(function(e) {
        window.location.assign("delete");
	});
});
</script>

<script>
$(document).ready(function(e) {
$(".edit").click(function(e) {
var id = $(this).data("id");
//alert(id);
var data={id:id};
	$.ajax({
		url: '<?php echo base_url("admin/banks/active") ?>',
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
<script>
$(document).ready(function(e) {
    $("#checkAll").change(function(){
		$("input[type=checkbox]").not("#checkAll").each(function() {
            this.checked=!this.checked;
        });
	});
	$(".delbutton").click(function(){
		if($('input[type=checkbox]:not("#checkAll"):checked').length>0){
			$('#form').unbind('submit').submit();//renable submit
		}
	    else{
			window.stop();
			//alert("<?=lang('row_one_alert');?>");
			toastr.warning("<?=lang('row_one_alert');?>");
	}
	});
});
</script>
<?php if(isset($_SESSION['msg']) && $_SESSION['msg']!=''){?>
<script>
$(document).ready(function(e) {
	toastr.success("<?php echo $_SESSION['msg']?>");
});
</script>
<?php }?>
</body>
</html>