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
   <!-- Container-fluid starts -->
   <div class="container">
      <!-- Main content starts -->
      <div>
         <!-- Invoice card start -->
         <div class="card">
            <div class="row invoice-contact">
               <div class="col-md-8">
                  <div class="row">
                     <div class="col-sm-12">
                        <table class="table invoice-table invoice-order table-borderless">
                           <tbody>
                              <tr>
                                 <td style="padding-right: 15px;"><img src="<?=base_url()?>assets/admin_panel/images/logo-blue.png" class="m-b-10" alt=""></td>
                              </tr>
                              <tr>
                                 <td style="padding-right: 15px;"><?=$settings['app_name']?></td>
                              </tr>
                              <tr>
                                 <td style="padding-right: 15px;"><?=$settings['address']?></td>
                              </tr>
                              <tr>
                                 <td style="padding-right: 15px;"><a><?=$settings['email']?></a>
                                 </td>
                              </tr>
                              <tr>
                                 <td style="padding-right: 15px;"><?=$settings['phone']?></td>
                              </tr>
                              <!-- <tr>
                                 <td><a href="#" target="_blank">www.demo.com</a>
                                 </td>
                                 </tr> -->
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
               <div class="col-md-4">
               </div>
            </div>
            <div class="card-block">
               <div class="row invoive-info">
                  <div class="col-md-4 col-xs-12 invoice-client-info">
                     <h6>معلومات صاحب الطلب :</h6>
                     <h6 class="m-0"><?=$customer['full_name']?></h6>
                     <p class="m-0 m-t-10"><?=$order['address']?></p>
                     <p class="m-0"><?=$customer['phone']?></p>
                     <!-- <p>البريد الالكتروني</p> -->
                  </div>
                  <div class="col-md-2 col-sm-6">
                     <h6>بيانات الطلب :</h6>
                     <table class="table table-responsive invoice-table invoice-order table-borderless">
                        <tbody>
                           <tr>
                              <th>التاريخ :</th>
                              <td><?=$order['created_at']?></td>
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
                                #<?=$order['id']?>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
				  
				  <?php if ($order['payment_method_id'] == 1) { 
						$result = get_table('transactions_orders',['main_order_id'=>$order['id']]);
				  ?>
				  <div class="col-md-6">
                     <h6>بيانات العملية البنكية :</h6>
                     <table class="table table-responsive invoice-table invoice-order table-borderless" dir="rtl">
                        <tbody>
                           <tr><th>النتيجة : </th><td> <?=$result[0]->result?></td></tr>
                           <tr><th>كود النتيجة : </th><td> <?=$result[0]->response_code?></td></tr>
                           <tr><th>رقم الفاتورة : </th><td> <?=$result[0]->pt_invoice_id?></td></tr>
                           <tr><th>المبلغ الذي تم دفعه : </th><td> <?=$result[0]->amount?></td></tr>
                           <tr><th>العملة : </th><td> <?=$result[0]->currency?></td></tr>
                           <tr><th>رقم مرجعي : </th><td> <?=$result[0]->reference_no?></td></tr>
                           <tr><th>رقم العملية : </th><td> <?=$result[0]->transaction_id?></td></tr>
                        </tbody>
                     </table>
                  </div>
				  <?php }?>
				  <?php if ($order['payment_method_id'] == 2) { 
						$order_type = $order['transfer_type'];
						switch ($order_type) {
							case "0":
							$ord_type = "نفس البنك";
							break;
							case "1":
							$ord_type = "بنك أخر";
							break;
						}
				  ?>
				  <div class="col-md-6">
                     <h6>بيانات التحويل البنكي :</h6>
                     <table class="table table-responsive invoice-table invoice-order table-borderless">
                        <tbody>
                           <tr><th>اسم المحول : </th><td> <?=$order['transfer_name']?></td></tr>
                           <tr><th>المبلغ المحول : </th><td> <?=$order['money_transfered']?></td></tr>
                           <tr><th>نوع التحويل : </th><td> <?=$ord_type;?></td></tr>
                        </tbody>
                     </table>
                  </div>
				  <?php }?>
				  
                  <div class="col-md-4 col-sm-6">
                     <!-- <h6 class="m-b-20">رقم الفاتورة <span>#12398521473</span></h6> -->
                     <h6 class="text-uppercase text-primary">الاجمالي :
                        <span><?=$order['total']?> ريال</span>
                     </h6>
                  </div>
               </div>
            </div>
         </div>
         <!-- Invoice card end -->
         <div class="row text-center">
             <div class="col-sm-12 invoice-btn-group text-center">
                 <a href="<?=base_url('admin_panel/orders/details/'.$order['id'])?>" style="color: white" class="btn btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light m-r-20">التفاصيل</a>
                 <a href="<?=base_url('admin_panel/orders')?>" style="color: white" class="btn btn-danger waves-effect m-b-10 btn-sm waves-light">رجوع </a>
             </div>
         </div>
      </div>
   </div>
   <!-- Container ends -->
</div>