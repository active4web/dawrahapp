<?php 
/*foreach ($cart_contents as $content) {
   for ($i=0; $i < count($content); $i++) { 
       echo $content[$i]['name'];
   }
} 
exit;*/ 
// print_r($cart_contents);exit; 
/*echo "<pre style='text-align: left;direction: ltr;'>";
print_r($cart_contents);
echo "</pre>";
//echo key($cart_contents);
die;*/
$cart = count($cart_contents);
?>

<div class="page-content mb-5">
        <div class="container">
		<form action="<?=base_url().'site_user/shopping_cart/order_total'?>" method="post" class="payment-confirm pt-3 pb-5 mt-2 mb-5 clearfix">
            <div class="page-header rounded p-3">
                <h1 class="page-title mb-auto">
                    <span class="fa-layers fa-fw ml-3">
                        <i class="fas fa-circle" data-fa-transform="grow-12"></i>
                        <i class="fa-inverse fas fa-shopping-bag" data-fa-transform="shrink-2"></i>
                    </span>
                    سلة الشراء
                </h1>
            </div><!-- .page-header -->
			<?php if ($this->session->flashdata('message')) { ?><?=$this->session->flashdata('message');?><?php } ?>
            <?php
			  if($cart!=0){
			  //print_r($cart_contents);
              foreach ($cart_contents as $content) { ?>
			  <script type="text/javascript">
					jQuery(document).ready(function($){
					owner_total(<?=$content[0]['product_owner'];?>);
				});
			  </script>
				<input type="hidden" value="<?=$content[0]['product_owner'];?>" name="merchant_id[]">
                <div class="item-wrap border mt-4">
                    <?php for ($i=0; $i < count($content); $i++) { 
                        $product = get_this('products',['id'=>$content[$i]['id']]); 
						$quantity = get_this('products',['id'=>$content[$i]['id']],'available_quantity');
						?>
                    <div class="item-content py-4 mx-3 border-bottom">
                        <div class="media">
                            <a href="<?=base_url('site_user/products/product/'.$content[$i]['id'])?>" class="border rounded">
                                <img style="width:258px; height:258px;" src="<?=base_url('assets/uploads/files/'.$product['main_image'])?>">
                            </a>
                            <div class="media-body align-self-stretch mr-3">
                                <?php if ($i == 0) { ?>
                                <h4 class="store-title">
                                    <span class="colored font-weight-bold">
                                        متجر  
                                    </span>
                                    |  <?=get_this('merchants',['id'=>$product['created_by']],'store_name');?>
                                </h4>
                                <?php } ?>
                                <p class="lead product-title">
                                    <span class="text-gray">
                                        الإسم :
                                    </span>
                                     <?=$content[$i]['name']?>
                                </p>
                                    <div class="form-group row">
                                        <label for="quantity-3" class="col-lg-1 col-md-2 col-form-label">الكمية</label>
                                        <div class="col-lg-4 col-md-8">
                                            <input type="number" min="1" max="<?=$quantity;?>" id="qty_<?=$content[$i]['rowid']?>" class="form-control form-control-lg colored font-tahoma"
                                                 value="<?=$content[$i]['qty']?>" onChange="update_qty('<?=$content[$i]['rowid']?>',this.value,<?=$content[0]['product_owner'];?>,<?=$quantity;?>),get_subtotal('<?=$content[$i]['rowid']?>',<?=$content[$i]['id']?>,<?=$content[0]['product_owner'];?>)"
												 onkeyup="update_qty('<?=$content[$i]['rowid']?>',this.value,<?=$content[0]['product_owner'];?>,<?=$quantity;?>),get_subtotal('<?=$content[$i]['rowid']?>',<?=$content[$i]['id']?>,<?=$content[0]['product_owner'];?>)"
												 >
                                        </div>
                                    </div>
                                <p class="lead text-gray mb-2">
                                    سعر الوحدة : <span class="number"> <?=$content[$i]['price']?></span> ريال
                                </p>
                                <p class="lead text-gray mb-2">
                                    الإجمـــــــالي : <span class="number" id="pro_<?=$content[$i]['id']?>"> <?=$content[$i]['subtotal']?></span> ريال
                                </p>
                               <!--  <p class="lead text-gray mb-2">
                                    كود المتابعة | <span class="number">985647</span>
                                </p> -->
                                <div class="fa-2x d-flex justify-content-end align-self-end">
                                    <a id="<?=$content[$i]['rowid']?>" class="fa-layers romove_cart">
                                        <i class="fas fa-circle remove"></i>
                                        <i class="fas fa-times fa-inverse" data-fa-transform="shrink-6"></i>
                                    </a>
                                </div>
                            </div><!-- .media-body -->
                        </div><!-- .media -->
                    </div><!-- .item-content -->
                    <?php } 
					$taxs = $content[0]['subtotal']*$tax;
					?>
                    <div class="item-details mt-3 pb-2 px-4">
                        <p class="text-gray">الإجمالى قبل الضريبة : <span class="colored font-tahoma" id="sub_<?=$content[0]['product_owner'];?>"> </span> ريال </p>
						<input type="hidden" value="" name="sub_total[<?=$content[0]['product_owner'];?>]" id="sub_total<?=$content[0]['product_owner'];?>">
						<input type="hidden" value="<?=$tax;?>" name="general_tax" id="general_tax">
						<input type="hidden" value="" name="tax_<?=$content[0]['product_owner'];?>" id="taxs_<?=$content[0]['product_owner'];?>">
                        <p class="text-gray">قيمة الضريبة : <span class="colored font-tahoma" id="tax_<?=$content[0]['product_owner'];?>"> </span> ريال </p>
                        <p class="text-gray">قيمة التوصيل : <span class="colored font-tahoma" id="delivery_<?=$content[0]['product_owner'];?>"> </span> ريال </p>
                        <p class="text-gray">الإجمـــــالي : <span class="colored font-tahoma" id="final_total_<?=$content[0]['product_owner'];?>"> </span> ريال </p>
						<input type="hidden" value="" name="total[<?=$content[0]['product_owner'];?>]" id="total<?=$content[0]['product_owner'];?>">
                    </div><!-- .item-details -->
                    <div class="delivery-services pb-5 pt-3 px-4 border-top">
                            <p class="text-gray">طرق التوصيل المتاحة</p>
							<!--[<?=$content[0]['product_owner'];?>]-->
                    <?php 
                        $methods = get_table('merchants_delivering_methods',['merchant_id'=>$content[0]['product_owner']]); 
                        foreach ($methods as $method) { 
                            $method_name = get_this('delivering_methods',['id'=>$method->method_id],'name');
                            ?>
                                <!-- <div class="custom-control custom-radio custom-control-inline">
                                      <label class="custom-control-label"><input class="custom-control-input" type="radio" name="optradio" checked>سلام</label>
                                </div> -->
                                <div class="custom-control custom-radio custom-control-inline">
                                  <label><input type="radio" id="<?=$method->method_id;?>" onChange="change_delivery(<?=$content[0]['product_owner'];?>)" value="<?=$method->price?>" name="delivering_<?=$content[0]['product_owner'];?>" checked>[ <?=$method->price?> ريال ] <?=$method_name?> </label>
                                </div>
                           
                    <?php
                        } 
                    ?>
					<input type="hidden" value="" name="delivering_method[<?=$content[0]['product_owner'];?>]" id="method_<?=$content[0]['product_owner'];?>">
					<script type="text/javascript">
					$( document ).ready(function() {
						var radios = document.getElementsByName('delivering_<?=$content[0]['product_owner'];?>');
						for (var i = 0, length = radios.length; i < length; i++)
						{
						 if (radios[i].checked)
						 {
						  // do whatever you want with the checked radio
						  $('#delivery_<?=$content[0]['product_owner'];?>').html('');
						  $('#delivery_<?=$content[0]['product_owner'];?>').html(radios[i].value);
						  $('#method_<?=$content[0]['product_owner'];?>').val('');
						  $('#method_<?=$content[0]['product_owner'];?>').val(radios[i].id);
						  //alert(radios[i].value);
						  // only one radio can be logically checked, don't check the rest
						  break;
						 }
						}
							
							
							function sub_total_sum(){
							setTimeout(function(){
								final_sub_total(<?=$content[0]['product_owner'];?>);
							}, 1000);
								setTimeout(sub_total_sum, 500);
							}
							sub_total_sum();
						});
					//final_total(<?=$content[0]['product_owner'];?>);
					</script>
                    </div>
                          
                </div><!-- .item-wrap -->
            <?php } ?>
            <div class="address-box border pt-3 pb-5 mt-4 px-3">
                <div class="row">
                    <div class="col-lg-6">
                        <h6 class="font-weight-bold">إجمالي المشتريات شاملة الضريبة والتوصيل</h6>
                        <p class="h3 px-lg-5 px-0 mr-lg-5 mt-auto mt-lg-5 mr-auto text-gray"> <span class="colored number" id="finished_total"></span> ريال </p>
						<input type="hidden" value="" name="final_total" id="final_total">
						<script type="text/javascript">
						$( document ).ready(function() {
							function finshed_total(){
							setTimeout(function(){
								<?php foreach ($cart_contents as $content) { ?>
								var finshed_<?=$content[0]['product_owner'];?> = $("#final_total_<?=$content[0]['product_owner'];?>").text();
								<?php }?>
								var sum_total = <?php foreach ($cart_contents as $content) { ?>+finshed_<?=$content[0]['product_owner'];?> + <?php }?>0;
								$('#finished_total').html('');
								var total = $('#finished_total').html(sum_total);
								$('#final_total').val('');
								$('#final_total').val(sum_total);
							}, 1000);
							setTimeout(finshed_total, 500);
							}
							finshed_total();
						});
					</script>
						
                    </div>
                    <div class="col-lg-6">
                            <div class="form-group">
                                <label for="location" class="font-weight-bold mb-lg-auto">
                                    العنوان
                                </label>
                                <div class="input-group border mt-lg-5 mt-auto">
                                    <input name="address" type="text" class="border-0 form-control form-control-lg" id="location" aria-label="Location" aria-describedby="location-icon" placeholder="العنوان" required>
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text border-0 bg-white" id="location-icon">
                                            <i class="fa fa-map-marker-alt colored"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div><!-- .address-box -->
            <div class="payment-method border px-4 pt-3 pb-5 mt-4">
                <h6 class="payment-title text-center font-weight-bold">طرق الدفع</h6>
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                            <div id="accordion">
                                <div class="card p-0 border-0 rounded-0 shadow-none">
                                    <div class="card-header p-0 border-0 shadow-none rounded-0" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
										<div class="custom-control custom-checkbox mt-2">
                                            <input checked type="radio" id="bank-account" name="payment_method_id" class="custom-control-input" value="1" onClick="collapse()">
                                            <label class="custom-control-label py-4 rounded pr-5 pl-3 d-block d-sm-flex justify-content-between align-items-center text-gray" for="bank-account">
                                                <img src="<?=base_url()?>assets/site_user/img/payment/tabs.png" class="ml-5 d-block mr-sm-0 ml-sm-5 mx-auto d-sm-inline-flex" width="60" height="80" alt="Visa card">
                                                <span class="">
                                                    <span class="card-name text-uppercase" style="font-size: x-large;text-align: right;">بطاقة ائتمانية</span>
                                                </span>
                                            </label>
                                        </div><!-- .custom-control -->
                                    </div><!-- .card-header -->
                                </div><!--card -->

                                <div class="card p-0 border-0 rounded-0 shadow-none">
                                    <div class="card-header p-0 border-0 shadow-none rounded-0" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        <div class="custom-control custom-checkbox mt-2">
                                            <input type="radio" id="visa-card" name="payment_method_id" class="custom-control-input" value="2">
                                            <label class="custom-control-label py-4 rounded pr-5 pl-3 d-block d-sm-flex justify-content-between align-items-center text-gray" for="visa-card">
                                                <img src="<?=base_url()?>assets/site_user/img/payment/transfer.png" class="d-block mx-sm-0 mx-auto d-sm-inline-flex" width="94" height="29" alt="Bank Transfer">
                                                <span class="">
                                                    <span class="card-name text-uppercase" style="font-size: x-large;text-align: right;"> تحويل بنكي </span>
                                                </span>
                                            </label>
                                        </div><!-- .custom-control -->
                                    </div><!-- .card-header -->
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                         <div class="px-4 pt-3">
										 <?php 
										 //print_r($bank_accounts);
										 foreach ($bank_accounts as $accounts) { ?>
                                            <p class="py-1"><?=$accounts->bank_name;?> :  <span><?=$accounts->account_number;?></span></p>
										<?php }?>
                                         </div>
                                        <div class="card-body pl-5">
                                                <div class="form-group">
                                                    <label for="confirm-name">اسم المحول</label>
                                                    <input name="transfer_name" class="form-control border-0" id="confirm-name">
                                                </div>
                                                <div class="form-group">
                                                    <label for="visa-number">المبلغ المحول</label>
                                                    <input name="money_transfered" class="form-control border-0" id="confirm-amount">
                                                </div>
                                                <div class="form-group">
                                                    <label>نوع التحويل</label>
                                                    <select name="transfer_type" class="custom-select border-0 h-auto">
                                                        <option selected disabled>نوع التحويل</option>
                                                        <option value="0">نفس البنك</option>
                                                        <option value="1">بنك أخر</option>
                                                    </select>
                                                </div>
                                        </div>
                                    </div>
                                </div><!--card -->
                            </div>
                    </div>
                </div>
            </div><!-- .payment-method -->
                <input type="submit" value="تأكيد الطلب" class="submit btn btn-lg px-5 text-white float-left font-weight-bold mb-4">
            </form><!-- .payment-confirm -->
			<?php }else{?>
			<br>
			<h1 class="page-title mb-auto"><center>عفوا لاتوجد بيانات بالسلة</center></h1>
			<script type="text/javascript">
			$( document ).ready(function() {
				setTimeout(function(){
					window.location = "<?=base_url();?>";
				}, 5000);
			});
			</script>
			<?php }?>
        </div><!-- .container -->
    </div><!-- .page-content -->