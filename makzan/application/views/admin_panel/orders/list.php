

<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10"><?=$title?></h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item" style="line-height: 2.5">
            <a href="<?=base_url('admin_panel/dashboard')?>">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="<?=base_url('admin_panel/orders')?>" style="line-height: 2.5"><?=$title?></a>
         </li>
      </ul>
   </div>
</div>
<div class="page-body">
   <div class="row">
      <div class="col-sm-12">
         <!-- Product list card start -->
         <div class="card">
            <div class="card-header">
               <h5><?=$title?></h5>
            </div>
            <div class="card-block">
               <div class="table-responsive">
                  <div class="table-content">
                     <div class="project-table">
                        <table id="order-table" class="table table-striped table-bordered nowrap">
                           <thead>
                              <tr>
                                 <th>رقم الطلب</th>
                                 <th>صاحب الطلب</th>
                                 <th>الاجمالي</th>
                                 <th>تاريخ الطلب</th>
                                 <th>نوع الدفع</th>
                                 <th>العمليات</th>
                              </tr>
                           </thead>
                           <tbody>
                            <?php foreach ($orders as $order) { ?>
                              <tr>
                                 <td>
                                   <?=$order->id?>
                                 </td>
                                 <td>
                                    <h6><?=get_this('customers',['id'=>$order->customer_id],'full_name')?></h6>
                                 </td>
                                 <td><?=$order->total?> ريال</td>
                                 <td><?=$order->created_at?></td>
                                 <td><?=get_this('payment_methods',['id'=>$order->payment_method_id],'name')?></td>
                                 <td class="action-icon">
                                    <a href="<?=base_url('admin_panel/orders/view/'.$order->id)?>" class="btn btn-success ">عرض الفاتورة</a> <a href="<?=base_url('admin_panel/orders/details/'.$order->id)?>" class="btn btn-warning ">تفاصيل الطلب</a> <?php if($order->confirmation_status == 0){ ?> <a href="<?=base_url('admin_panel/orders/confirm/'.$order->id)?>" class="btn btn-success ">موافقة</a> <a href="<?=base_url('admin_panel/orders/reject/'.$order->id)?>" class="btn btn-danger ">رفض</a> <?php }?>  
                                 </td>
                              </tr>
                            <?php } ?>  
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- Product list card end -->
      </div>
   </div>
</div>

