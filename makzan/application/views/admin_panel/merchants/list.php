<?php if ($this->session->flashdata('message')) { ?>
   <?=$this->session->flashdata('message');?>
<?php } ?>
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10"><?=$title?></h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item" style="line-height: 2.5">
            <a href="<?=base_url('admin_panel/dashboard')?>">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a style="line-height: 2.5"><?=$title?></a>
         </li>
      </ul>
   </div>
</div>
<div class="page-body">
  <!-- <?php if ($this->session->flashdata('message')) { ?>
    <div class="alert alert-success background-success">
        <button style="float: left;" type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="icofont icofont-close-line-circled text-white"></i>
        </button>
        <strong>نجاح!</strong> <?=$this->session->flashdata('message');?></code>
    </div>
  <?php } ?> -->
   <div class="card">
      <div class="card-header">
         <h5><?=$title?></h5>
      </div>
      <div class="card-block">
         <div class="dt-responsive table-responsive">
            <table id="order-table" class="table table-striped table-bordered nowrap">
               <thead>
                  <tr>
                     <th>مسلسل</th>
                     <th>الاسم بالكامل</th>  
                     <th>اسم المتجر</th>
                     <th>رقم الهاتف</th>
                     <th>صورة المتجر</th>
                     <th>العمليات</th>
                  </tr>
               </thead>
               <tbody>
                  <?php $count = 1;
                  foreach($merchants as $merchant){ ?>
                    <tr>
                        <td><?=$count++?></td>
                        <td><?=$merchant->full_name?></td>
                        <td><?=$merchant->store_name?></td>
                        <td><?=$merchant->phone?></td>
                        <td><?php if(!empty($merchant->image)){ ?><img style="width: 100px; height: 66px" src="<?=base_url('assets/uploads/files/'.$merchant->image)?>"><?php }else{?><img style="width: 100px; height: 66px" src="<?=base_url('assets/uploads/files/man.png')?>"><?php } ?></td>
                        <td><a href="<?=base_url('admin_panel/merchants/view/'.$merchant->id)?>" class="btn btn-warning ">عرض</a>  <!-- <?php if($merchant->status == 1){ ?><a href="<?=base_url('admin_panel/merchants/activate/'.$merchant->id)?>" class="btn btn-success">تفعيل</a><?php } ?> --><a href="<?=base_url('admin_panel/merchants/activate/'.$merchant->id)?>" class="btn btn-success ">تفعيل</a> <a href="<?=base_url('admin_panel/merchants/deactivate/'.$merchant->id)?>" class="btn btn-danger ">تعطيل</a></td>
                    </tr>
                  <?php } ?>
            </table>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="default-Modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">تأكيد الحذف</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>هل انت متاكد من انك تريد حذف هذا التاجر ؟</p>
            </div>
            <div class="modal-footer">
                <a id="yes" style="margin-left: 5px; color: white" class="btn btn-danger waves-effect ">حذف</a>
                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary waves-effect waves-light ">رجوع</a>
            </div>
        </div>
    </div>
</div>
<script>
        function deletefn(val){
        var a = document.getElementById('yes');
        a.href = "<?=base_url('admin_panel/merchants/delete/')?>"+val;

        }
</script>