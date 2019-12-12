<pre>
<?php 
//print_r($processing_orders);
//print_r($comletet_orders);
//print_r($rejected_orders);
?>
</pre>

 
 <div class="page-content mb-5 pt-4">
        <div class="container">
            <div class="category-tabs pt-4">
                <ul class="nav nav-tabs nav-fill border-bottom-0 pr-0"
                    id="category-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active border-0 py-3 rounded-right" id="new-tab"
                           data-toggle="tab" href="#new"
                           role="tab" aria-controls="new"
                           aria-selected="true">طلبات قائمة</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link border-0 py-3 rounded-left" id="used-tab"
                           data-toggle="tab" href="#used"
                           role="tab" aria-controls="used"
                           aria-selected="false">طلبات منتهية</a>
                    </li>
					<li class="nav-item">
                        <a class="nav-link border-0 py-3 rounded-left" id="refused-tab"
                           data-toggle="tab" href="#refused"
                           role="tab" aria-controls="refused"
                           aria-selected="false">طلبات مرفوضة</a>
                    </li>
                </ul>
                <div class="tab-content mt-4" id="category-tab-content">
				
				<div class="tab-pane fade" id="refused" role="tabpanel" aria-labelledby="refused-tab">
                        <div class="row">
							<?php foreach ($rejected_orders as $rejected) { ?>
                            <div class="col-md-6 col-12 mb-4">
                                <div class="media rounded p-4">
                                    <a href="<?=base_url('site_merchant/orders/order_details/'.$rejected->id)?>" class="d-block">
                                        <div class="py-2 px-3">
                                            <img class="d-block mx-auto img-fluid rounded-circle product-image" src="<?=base_url()?>assets/site_user/img/vendor/product-home.jpg" width="73" height="73">
                                        </div>
                                    </a>
                                    <div class="media-body d-flex flex-column flex-wrap mr-3">
                                        <p class="text-gray mb-auto">
                                            <span class="lead">رقم الطلب :</span>
                                            <span class="colored number h3"><?=$rejected->id?></span>
                                        </p>
                                        <p class="text-gray mb-auto">
                                            <span class="lead">قيمة الطلب االجمالي :</span>
                                            <span class="colored number h3"><?=$rejected->total?></span>
                                            <span class="lead">ريال</span>
                                        </p>
                                        <p class="text-gray mb-auto">
                                            <span class="lead">حالة الطلب :</span>
                                            <span class="lead shipped">مرفوض</span>
                                        </p>
                                    </div><!-- .media-body -->
                                </div><!-- .media -->
                            </div><!-- .col-* -->
							<?php } ?>
                        </div><!-- .row -->
                    </div><!-- .tab-pane -->
					
					
                    <div class="tab-pane fade show active" id="new" role="tabpanel" aria-labelledby="new-tab">
                        <div class="row">
						<?php foreach ($processing_orders as $processing) { ?>
						<?php $orders_statuses = get_table('orders_statuses',['id'=>$processing->status_id]);?>
                            <div class="col-md-6 col-12 mb-4">
                                <div class="media rounded p-4">
                                    <a href="<?=base_url('site_merchant/orders/order_details/'.$processing->order_item)?>" class="d-block">
                                        <div class="py-2 px-3">
                                            <img class="d-block mx-auto img-fluid rounded-circle product-image" src="<?=base_url()?>assets/site_user/img/vendor/product-home.jpg" width="73" height="73">
                                        </div>
                                    </a>
                                    <div class="media-body d-flex flex-column flex-wrap mr-3">
                                        <p class="text-gray mb-auto">
                                            <span class="lead">رقم الطلب :</span>
                                            <span class="colored number h3"><?=$processing->order_item?></span>
                                        </p>
                                        <p class="text-gray mb-auto">
                                            <span class="lead">قيمة الطلب االجمالي :</span>
                                            <span class="colored number h3"><?=$processing->total?></span>
                                            <span class="lead">ريال</span>
                                        </p>
                                        <p class="text-gray mb-auto">
                                            <span class="lead">حالة الطلب :</span>
											<span class="lead shipped"><?=$orders_statuses[0]->name?></span>
                                        </p>
                                    </div><!-- .media-body -->
                                </div><!-- .media -->
                            </div><!-- .col-* -->
							<?php } ?>
                        </div><!-- .row -->
                    </div><!-- .tab-pane -->

                    <div class="tab-pane fade" id="used" role="tabpanel" aria-labelledby="used-tab">
                        <div class="row">
						<?php foreach ($comletet_orders as $comletet) { ?>
                            <div class="col-md-6 col-12 mb-4">
                                <div class="media rounded p-4">
                                    <a href="<?=base_url('site_merchant/orders/order_details/'.$comletet->id)?>" class="d-block">
                                        <div class="py-2 px-3">
                                            <img class="d-block mx-auto img-fluid rounded-circle product-image" src="<?=base_url()?>assets/site_user/img/vendor/product-home.jpg" width="73" height="73">
                                        </div>
                                    </a>
                                    <div class="media-body d-flex flex-column flex-wrap mr-3">
                                        <p class="text-gray mb-auto">
                                            <span class="lead">رقم الطلب :</span>
                                            <span class="colored number h3"><?=$comletet->id?></span>
                                        </p>
                                        <p class="text-gray mb-auto">
                                            <span class="lead">قيمة الطلب االجمالي :</span>
                                            <span class="colored number h3"><?=$comletet->total?></span>
                                            <span class="lead">ريال</span>
                                        </p>
                                        <p class="text-gray mb-auto">
                                            <span class="lead">حالة الطلب :</span>
                                            <span class="lead open">منتهي</span>
                                        </p>
                                    </div><!-- .media-body -->
                                </div><!-- .media -->
                            </div><!-- .col-* -->
                            <?php } ?>
                        </div><!-- .row -->
                    </div><!-- .tab-pane -->
                </div><!-- .tab-content -->
            </div><!-- .category-tabs -->
        </div><!-- .container -->
    </div><!-- .page-content -->
