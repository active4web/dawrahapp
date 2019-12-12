<div class="page-content mb-5">
        <div class="container">
            <div class="page-header rounded p-3">
                <h1 class="page-title mb-auto">
                    <span class="fa-layers fa-fw ml-3">
                        <i class="fas fa-circle" data-fa-transform="grow-12"></i>
                        <i class="fa-inverse fas fa-shopping-bag" data-fa-transform="shrink-2"></i>
                    </span>
                    صفحة الطلب | رقم . <?=$main_order['id']?>
                </h1>
            </div><!-- .page-header -->
        <?php foreach ($sub_orders as $sub) { 
              $items = get_table('order_items',['sub_order_id'=>$sub->id]);
              $merchant = get_this('merchants',['id'=>$sub->merchant_id]);
                  foreach ($items as $item) { ?>
                    <div class="media product-item border rounded-top py-4 px-3 mt-4">
                        <a href="<?=base_url('site_user/products/product/'.$item->product_id)?>" class="border rounded">
                            <img style="height: 258px; width: 258px" src="<?=base_url('assets/uploads/files/'.get_this('products',['id'=>$item->product_id],'main_image'))?>">
                        </a>
                        <div class="media-body mr-3">
                            <h4 class="lead mb-4">
                                <a style="text-decoration: none" href="<?=base_url('site_user/merchant/index/'.$sub->merchant_id)?>">
                                    <span class="colored font-weight-bold">
                                        متجر <?=$merchant['store_name']?>
                                    </span>
                                </a>
                                    | <?=$item->product_name?><!-- جهاز سوني <span class="font-tahoma">ps4</span> -->
                            </h4>
                            <p class="product-title">
                                <span class="text-gray">
                                    الإسم :
                                </span>
                                <?=$item->product_name?>
                            </p>
                            <p class="lead text-gray">
                                الكمية <span class="number colored"><?=$item->quantity?></span>
                            </p>
                            <p class="lead text-gray">
                                سعر الوحدة : <span class="number"><?=$item->product_price?></span> ريال
                            </p>
                            <p class="lead text-gray">
                                الإجمـــــــالي : <apan class="number"><?=$item->total?></apan> ريال
                            </p>
                        </div>
                    </div>
                   <?php } ?>
            <div class="item-details py-5 px-3 border-right border-left">

                <p class="text-gray">
                    الإجمالى قبل الضريبة :
                    <span class="colored font-tahoma">
                        <?=$sub->sub_total?>
                    </span>
                    ريال
                </p>
                <p class="text-gray">
                    قيمة الضريبة :
                    <span class="colored font-tahoma">
                        <?=$sub->tax?>
                    </span>
                    ريال
                </p>
                <p class="text-gray">
                    قيمة التوصيل :
                    <span class="colored font-tahoma">
                        <?=$sub->delivering_method_price?>
                    </span>
                    ريال
                </p>
                <p class="text-gray">
                    الإجمـــــــــــــالي
                    <span class="colored font-tahoma">
                        <?=$sub->total?>
                    </span>
                    ريال
                </p>
            </div><!-- .item-details -->
            <div class="delivery-services p-4 border">
                <p class="text-gray h4 mb-auto">طرق التوصيل المتاحة
                    <a class="home-delivery no-decoration px-5 py-1 text-white h4">
                         <?=get_this('delivering_methods',['id'=>$sub->delivering_method_id],'name')?>
                    </a>
                </p>

            </div><!-- .delivery-services -->
        <?php } ?>
        </div><!-- .container -->
    </div><!-- .page-content -->