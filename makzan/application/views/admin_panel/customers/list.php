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
                     <th>رقم الهاتف</th>
                     <th>صورة الحساب</th>
                     <th>العمليات</th>
                  </tr>
               </thead>
               <tbody>
                  <?php $count = 1;
                  foreach($customers as $customer){ ?>
                    <tr>
                        <td><?=$count++?></td>
                        <td><?=$customer->full_name?></td>
                        <td><?=$customer->phone?></td>
                        <td><?php if(!empty($customer->image)){ ?><img style="width: 100px; height: 66px" src="<?=base_url('assets/uploads/files/'.$customer->image)?>"><?php }else{?><img style="width: 100px; height: 66px" src="<?=base_url('assets/uploads/files/man.png')?>"><?php } ?></td>
                        <td><a href="<?=base_url('admin_panel/customers/view/'.$customer->id)?>" class="btn btn-warning ">عرض</a> <a href="<?=base_url('admin_panel/customers/activate/'.$customer->id)?>" class="btn btn-success ">تفعيل</a> <a href="<?=base_url('admin_panel/customers/deactivate/'.$customer->id)?>" class="btn btn-danger ">تعطيل</a></td>
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
        a.href = "<?=base_url('admin_panel/customers/delete/')?>"+val;

        }
</script>