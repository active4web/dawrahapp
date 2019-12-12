<?php 
//print_r($order_details);die;
//echo $order_details[0]->customer_id;
?>
<style>
a.edit-link:hover{
	text-decoration: none;
}
</style>
<div class="page-content mb-5">
        <div class="container">
            <div class="page-header rounded p-3">
                <h1 class="page-title mb-auto">
                    صفحة الطلب
                </h1>
            </div><!-- .page-header -->
            <div class="order-wrap row">
			<?php foreach ($items as $item) { ?>
                <div class="col-md-6 mt-4">
                    <div class="media product-item border pt-4 px-4 pb-5">
                        <a href="<?=base_url('site_user/products/product/'.$item->product_id)?>">
                            <img src="<?=base_url('assets/uploads/files/'.get_this('products',['id'=>$item->product_id],'main_image'))?>" class="d-block mx-auto img-fluid product-thumbnail border" width="120" height="119" alt="Product image">
                        </a>
                        <div class="media-body mr-3">
                            <h4 class="product-title"><span class="text-gray">الإسم : </span><?=$item->product_name?></h4>
                            <p class="lead text-gray mb-auto">الكمية <span class="number colored"><?=$item->quantity?></span></p>
                            <p class="lead text-gray mb-auto">سعر الوحدة : <span class="number"><?=$item->product_price?></span> ريال</p>
                            <p class="lead text-gray mb-auto">الإجمـــــــالي : <span class="number"><?=$item->total?></span> ريال</p>
                        </div>
                    </div>
                </div>
			<?php }?>
				<?php $customer = get_table('customers',['id'=>$order_details[0]->customer_id]); //print_r($customer);?>
				<?php $delivering = get_table('delivering_methods',['id'=>$order_details[0]->delivering_method_id]);?>
				<?php $main = get_table('main_orders',['id'=>$order_details[0]->main_order_id]);
				//print_r($main);
				//print_r($order_details);die;
				?>
				<?php $status = $main[0]->payment_status;
					switch ($status) {
						case 0:
						$payment_status = "غير مكتمل";
						break;
						case 1:
						$payment_status = "مكتمل";
						break;
					}
					$order_status = $order_details[0]->status_id;
					$gg = get_table('orders_statuses',['id'=>$order_status]);
					switch ($order_status) {
						case 1:
						$order_status_msg = $gg[0]->name;
						$order_msg = "بالانتظار";
						break;
						case 2:
						$order_status_msg = $gg[0]->name;
						$order_msg = "تجهيز الطلب";
						break;
						case 3:
						$order_status_msg = $gg[0]->name;
						$order_msg = "شحن الطلب";
						break;
						case 4:
						$order_status_msg = $gg[0]->name;
						$order_msg = "تسليم الطلب";
						break;
						default:
						$order_status_msg = $gg[0]->name;
					}
					$app_balance = get_this('settings',['id'=>1],'app_balance')/100;
				?>
                <div class="col-12 mt-4">
                    <div class="details-wrap">
                        <div class="row px-3 px-sm-5">
                            <div class="col-md-6 py-5">
                                <div class="item-details ">
                                    <p class="text-gray h4 mb-3"> الإجمالى قبل الضريبة : <span class="colored font-tahoma"> <?=$order_details[0]->sub_total;?> </span>ريال</p>
                                    <p class="text-gray h4 mb-3"> قيمة الضريبة : <span class="colored font-tahoma"> <?=$order_details[0]->tax;?> </span>ريال</p>
                                    <p class="text-gray h4 mb-3"> قيمة التوصيل : <span class="colored font-tahoma"> <?=$order_details[0]->delivering_method_price;?> </span>ريال</p>
                                    <p class="text-gray h4 mb-3"> الإجمـــــــــــــالي : <span class="colored font-tahoma"> <?=$order_details[0]->total;?> </span>ريال</p>
                                    <p class="text-gray h4 mb-3"> طرق التوصيل المتاحة : <span class="colored green"> <?=$delivering[0]->name;?> </span></p>
									
									<p class="text-gray h4 mb-3"> الإجمالي المستحق لك : <span class="colored font-tahoma"> <?=$order_details[0]->total-($order_details[0]->total*$app_balance);?> </span>ريال</p>
									<p class="text-gray h4 mb-3"> الإجمالي المستحق للتطبيق : <span class="colored font-tahoma"> <?=$order_details[0]->total*$app_balance;?> </span>ريال</p>
                                </div><!-- .item-details -->
                            </div>
                            <div class="col-md-6 py-5">
                                <p class="order-status rounded h4 py-3 position-relative text-white mb-3">
                                    <span class="status d-block text-center">حالة الطلب : <?=$order_status_msg?></span>
									<?php 
									if(($order_status==1) || ($order_status==2) || ($order_status==3)){
										if($order_status==1){
											$enter = 2;
											$mssg = "تحويل حالة الطلب الي تجهيز الطلب";
											$result = "تجهيز الطلب";
										}elseif($order_status==2){
											$enter = 3;
											$mssg = "تحويل حالة الطلب الي شحن الطلب";
											$result = "شحن الطلب";
										}
										elseif($order_status==3){
											$enter = 4;
											$mssg = "تحويل حالة الطلب الي تسليم الطلب";
											$result = "تسليم الطلب";
										}
									?>
                                    <a onClick="change_order_status('<?=$order_details[0]->id?>','<?=$enter?>','<?=$mssg?>')" href="#" class="edit-link position-absolute h-100 d-block text-center" style="font-size: 18px;color: #fff;line-height: 60px; width: 150px;"> <?=$result;?>
                                    <span class="fa-layers fa-fw" style="height: 35px;">
                                        <i class="fa-inverse fas fa-pencil-alt text-white" data-fa-transform="shrink-4"></i>
                                    </span>
                                    </a>
									<?php }?>
                                </p>
                                <p class="payment-status rounded h4 py-3 position-relative text-white">
                                    <span class="status d-block text-center">حالة الدفع : <?=$payment_status;?></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
				<?php $country = get_table('countries',['id'=>$customer[0]->country_id]);?>
				<pre><?php //print_r($main);?></pre>
                <div class="col-12 mt-4">
                    <div class="member-box p-4">
                        <div class="member-details">
                            <h4 class="user-title text-gray pb-4 mb-4">
                                صاحب الطلب : <?=$customer[0]->full_name?>
                            </h4>
                            <div class="d-md-flex justify-content-between">
                                <p class="phone-number lead mb-2 mb-md-auto">
                                    <span class="colored">رقم الجوال : </span>
                                    <span class="text-body number"><?=$customer[0]->phone?></span>
                                </p>
                                <p class="country lead mb-2 mb-md-auto">
                                    <span class="colored">الدولة : </span>
                                    <span class="text-body"><?=$country[0]->name?></span>
                                </p>
                                <p class="city lead mb-2 mb-md-auto">
                                    <span class="colored">المدينة : </span>
                                    <span class="text-body"><?=$main[0]->address?></span>
                                </p>
                            </div>
                        </div><!-- .member-details -->
                    </div>
                </div>
                <!--<div class="col-12">
                    <p class="text-center text-gray lead my-4">الموقع على خريطة جوجل</p>
                    <div class="embed-responsive embed-responsive-16by9">
					<iframe src="https://maps.google.com/maps?q=<?=$main[0]->latitude?>,<?=$main[0]->langitude?>&hl=es;z=14&amp;output=embed" width="800" height="600" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>
                </div>-->
            </div>
        </div><!-- .container -->
    </div><!-- .page-content -->