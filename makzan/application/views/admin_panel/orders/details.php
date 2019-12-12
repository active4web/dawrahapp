<!-- Page-header start -->
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10"><?=$title?></h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item">
            <a href="<?=base_url('admin_panel/dashboard')?>">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="<?=base_url('admin_panel/orders')?>">الطلبات</a>
         </li>
         <li class="breadcrumb-item"><a><?=$title?></a>
         </li>
      </ul>
   </div>
</div>
<!-- Page-header end -->
<div class="page-body">
    <?=$map['js']?>
    <?=$map['html']?>
   <!-- Container-fluid starts -->
   <div class="container">
      <!-- Main content starts -->
      <?php 
	  foreach ($sub_orders as $sub) { 
	  $rate = $sub->rate/100;
	  $ntotal = $sub->total * $rate;
	  $final_total = $sub->total - $ntotal;
	  ?>
      <div>
         <!-- Invoice card start -->
         <div class="card">
            <div class="card-block" style="height: 60px">
               <div class="row invoive-info">
                  <div class="col-md-4 col-xs-12 invoice-client-info">
                     <!-- <h6>معلومات التاجر  :</h6> -->
                     <?php $merchant = get_this('merchants',['id'=>$sub->merchant_id]); ?>
                     <h6 class="text-uppercase text-primary"><?=$merchant['store_name']?></h6>
                     <!-- <p class="m-0 m-t-10"><?=get_this('delivering_methods',['id'=>$sub->delivering_method_id],'name')?></p>
                     <p class="m-0"><?=$merchant['phone']?></p> 
                     <p>البريد الالكتروني</p> -->
                  </div>
                  <!-- <div class="col-md-4 col-sm-6">
                     <h6>بيانات الطلب :</h6>
                     <table class="table table-responsive invoice-table invoice-order table-borderless">
                        <tbody>
                           <tr>
                              <th>التاريخ :</th>
                              <td><?=$sub->created_at?></td>
                           </tr>
                           <tr>
                              <th>حالة الدفع :</th>
                              <td>
                                 <?php if ($order['payment_status'] == 1) { ?>
                                 <span class="label label-success">تم الدفع</span>
                                 <?php }else{ ?>
                                 <span class="label label-danger">لم يتم الدفع</span>
                                 <?php } ?> 
                              </td>
                           </tr>
                           <tr>
                              <th>رقم الطلب :</th>
                              <td>
                                 #<?=$sub->id?>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </div> -->
                  <!-- <div class="col-md-4 col-sm-6">
                      <h6 class="m-b-20">رقم الفاتورة <span>#12398521473</span></h6> 
                     <h6 class="text-uppercase text-primary">الاجمالي :
                        <span><?=$sub->total?> ريال</span>
                     </h6>
                  </div> -->
               </div>
            </div>
         </div>
         <!-- Invoice card end -->
         <div class="row">
            <div class="col-sm-12">
               <div class="table-responsive">
                  <table class="table  invoice-detail-table">
                     <thead>
                        <tr class="thead-default">
                           <th style="text-align: right">اسم المنتج</th>
                           <th style="text-align: right">سعر المنتج</th>
                           <th style="text-align: right">عدد القطع</th>
                           <th style="text-align: right">الاجمالي</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php $items = get_table('order_items',['sub_order_id'=>$sub->id]);
                        foreach ($items as $item) { ?>
                        <tr>
                           <td style="text-align: right">
                              <h6><?=$item->product_name?></h6>
                           </td>
                           <td style="text-align: right"><?=$item->product_price?></td>
                           <td style="text-align: right"><?=$item->quantity?></td>
                           <td style="text-align: right"><?=$item->total?></td>
                        </tr>
                       <?php } ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-sm-12">
               <table class="table table-responsive invoice-table invoice-total">
                  <tbody>
                     <tr>
                        <th>الاجمالي قبل الضريبة وسعر التوصيل : </th>
                        <td> <?=$sub->sub_total?></td>
                     </tr>
                     <tr>
                        <th>الضريبة :</th>
                        <td> <?=$sub->tax?></td>
                     </tr>
                     <tr>
                        <th>سعر التوصيل :</th>
                        <td> <?=$sub->delivering_method_price?></td>
                     </tr>
                     <tr class="text-info">
                        <td>
                           <hr/>
                           <h5 class="text-success">الاجمالي :</h5>
                        </td>
                        <td>
                           <hr/>
                           <h5 class="text-success"><?=$sub->total?> ريال</h5>
                        </td>
                     </tr>
					 <tr>
						<td style="color:red;">الاجمالي المستحق للتاجر بعد خصم نسبة التطبيق</td>
						<td><h5><?=$final_total?> ريال</h5></td>
					 </tr>
					 <tr>
						<td style="color:blue;">قيمة المستحق للتطبيق</td>
						<td><h5><?=$ntotal?> ريال</h5></td>
					 </tr>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   <?php } ?>
   </div>
   <!-- Container ends -->
</div>