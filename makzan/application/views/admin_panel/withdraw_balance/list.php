<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10"><?=$title?></h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item" style="line-height: 2.5">
            <a href="<?=base_url('admin_panel/dashboard')?>">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="<?=base_url('admin_panel/withdraw_balance')?>" style="line-height: 2.5"><?=$title?></a>
         </li>
         <!-- <a style="float: left; color: white" href="<?=base_url('admin_panel/withdraw_balance/add')?>" class="btn btn-grd-primary">اضافة مدينة جديده</a> -->
      </ul>
   </div>
</div>
<div class="page-body">
   <?php if ($this->session->flashdata('message')) { ?>
     <?=$this->session->flashdata('message');?>
  <?php } ?>
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
                     <th>اسم التاجر</th>
                     <th>رصيد التاجر</th>
                     <th>الكمية المراد سحبها</th>
                     <th>تاريخ الانشاء</th>
                     <th>الحالة</th>
                     <th>العمليات</th>
                  </tr>
               </thead>
               <tbody>
                  <?php $count = 1;
                  foreach($requests as $request){ ?>
                    <?php $merchant = get_this('merchants',['id'=>$request->merchant_id]) ?>
                    <tr>
                        <td><?=$count++?></td>
                        <td><?=$merchant['full_name']?></td>
                        <td><?=$merchant['credit']?></td>
                        <td><?=$request->quantity?> ريال</td>
                        <td><?=$request->created_at?></td>
                        <td <?php if($request->status == 1){ echo 'class="text-success"';}else{ echo 'class="text-danger"';} ?>><?=($request->status == 0)?'بانتظار الموافقة':'تمت الموافقة عليه' ;?></td>
                        <td><?php if ($request->status == 0) { ?>
                          <a href="<?=base_url('admin_panel/withdraw_balance/accept/'.$request->id)?>" class="btn btn-success ">موافقة</a>
                        <?php } ?></td>
                    </tr>
                  <?php } ?>
            </table>
         </div>
      </div>
   </div>
</div>