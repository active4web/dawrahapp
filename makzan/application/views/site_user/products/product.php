 <?php if ($this->session->flashdata('message')) { ?>
    <?=$this->session->flashdata('message');?>
 <?php } ?>
 <div class="page-content mb-5">
         <div class="container">
             <div class="page-header rounded p-3">
                 <h1 class="page-title mb-auto">
                     <?=get_this('categories',['id'=>$product['category_id']],'name')?> - <?=$product['name']?>
                     <!-- <span class="text-body">Huawei Y7 Prime 2018</span> -->
                 </h1>
             </div><!-- .page-header -->
             <div class="item-wrap mt-4">
                 <div class="row">
                     <div class="col-lg-6 col-12 order-lg-1 order-2">
                         <h3 class="item-title font-tahoma text-center border mb-auto py-2">
                             <?=$product['name']?>
                         </h3>
                         <p class="mb-auto text-gray py-2 px-4 h4 border mt-2">
                             سعر المنتج |
                             <span class="colored">
                                 <span class="font-tahoma"><?=$product['price']?></span>
                                 ريال
                             </span>
                         </p>
                         <div class="rate text-gray py-2 px-4 border mt-2">
                             <span class="h4 mb-auto">تقييم المنتج |</span>
                             <ul class="list-inline pr-1 d-inline-block mb-auto">
                                 <?php for ($i = 1; $i <= 5; $i++){
                                 if ($i <= $average_rate){ ?>
                                     <li class="list-inline-item mr-1">
                                         <i class="fa fa-star filled" aria-hidden="true"></i>
                                     </li>
                                 <?php }else{ ?>
                                     <li class="list-inline-item mr-1">
                                         <i class="fa fa-star" aria-hidden="true"></i>
                                     </li>
                                 <?php  } } ?>
                             </ul>
                         </div>
                         <div class="item-details mt-5">
                             <h5 class="details-title font-weight-bold text-gray">
                                 تفاصيل المنتج
                             </h5>
                             <p class="text-justify details-content mt-3">
                                 <?=$product['description']?>
                             </p>
                         </div>
                     </div><!-- .col-* -->
                     <div class="col-lg-6 col-12 order-lg-2 order-1">
                         <div id="item-slider" class="carousel slide" data-ride="carousel">
                             <div class="carousel-inner">
                                 <?php 
                                 $i = 0;
                                 foreach ($product_images as $img) { ?>
                                 <div class="carousel-item <?php if($i == 0) echo 'active'; ?>">
                                     <img style="height: 328px; width: 328px" src="<?=base_url('assets/uploads/files/'.$img->image_name)?>"
                                          class="img-fluid d-block mx-auto">
                                 </div>
                                 <?php 
                                 $i++;    
                                 } ?>
                             </div><!-- .carousel-inner -->
                             <div class="slider-indicators text-center my-3">
                                 <?php 
                                 $j = 0;
                                 foreach ($product_images as $pic) { ?>
                                 <a data-target="#item-slider" data-slide-to="<?=$j?>" class="d-inline-block <?php if($j == 0) echo 'active'; ?>">
                                     <img style="height: 50px; width: 50px" src="<?=base_url('assets/uploads/files/'.$pic->image_name)?>"
                                          class="img-fluid d-block mx-auto" alt="">
                                 </a>
                                 <?php 
                                 $j++;    
                                 } ?>
                             </div>
                         </div><!-- .carousel -->
                         <div class="action-wrap d-sm-flex justify-content-lg-end justify-content-around mb-4 mb-lg-auto">
                             <a href="<?=base_url('site_user/products/add_to_favourite/'.$product['id'])?>" class="add-to-favorite btn ml-3 py-3 position-relative text-white mb-sm-auto mb-2">
                                 <span class="fa-layers fa-fw position-absolute">
                                     <i class="fa-inverse fas fa-star text-white" data-fa-transform="grow-8"></i>
                                 </span>
                                 اضف للمفضلة
                             </a>
                             <?php $product_qty = $product['available_quantity']; $product_id = $product['id']; $product_name = $product['name']; $product_price = $product['price']; $product_owner = get_this('merchants',['id'=>$product['created_by']],'id'); ?>
                             <input hidden="hidden" type="number" name="quantity" id="<?php echo $product_id;?>" value="1" class="quantity form-control">
                             <button type="button" class="add_cart add-to-cart btn py-3 position-relative text-white mb-sm-auto mb-2" data-productid="<?php echo $product_id;?>" data-productowner="<?php echo $product_owner;?>" data-productname="<?php echo $product_name;?>" data-productprice="<?php echo $product_price;?>" data-productqty="<?php echo $product_qty;?>" <?php if($user_data['id']){echo 'data-user='.$user_data['id'];}else{echo 'data-user=0';}?>>
                                 <span class="fa-layers fa-fw position-absolute">
                                     <i class="fa-inverse fas fa-shopping-basket text-white" data-fa-transform="grow-8"></i>
                                 </span>
                                 اضف للسلة
                             </button>
                         </div><!-- .action-wrap -->
                     </div><!-- .col-* -->
                 </div><!-- .row -->
                 <div class="vendor-data mt-5 d-md-flex justify-content-between p-3">
                     <?php $merchant = get_this('merchants',['id'=>$product['created_by']]); ?>
                         <a style="text-decoration: none" href="<?=base_url('site_user/merchant/index/'.$merchant['id'])?>">
                             <h4 class="vendor-name text-gray mb-auto">
                                 اسم التاجر | <?=$merchant['full_name']?>
                             </h4>
                         </a>
                     <div class="product-rate mt-md-auto mt-2">
                        <span class="lead">تقييم المنتج</span>
                        <form class="d-inline-block mr-3" method="POST" action="<?=base_url('site_user/products/add_rate/'.$product['id'])?>">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-10">
                                    <input name="rate" type="number" id="rating-control" class="form-control text-center mt-4 " step="1" max="5" placeholder="Rate 1 - 5">
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 25px;">
                                <div class="col-md-2">
                                    <button style="float: left;" type="submit" class="btn btn-success">تقييم</button>
                                </div>
                            </div>
                        </div>
                        </form>
                        <div class="mb-auto d-block text-center text-lg-left">
                            <div class="stars-outer">
                                <div class="stars-inner"></div>
                            </div>       
                        </div>
                    </div>
                 </div>
             </div><!-- .item-wrap -->
             <div class="comments mt-5">
                 <div class="comments-header d-sm-flex justify-content-between align-items-center">
                     <a href="#" class="btn btn-lg comments-count border bg-white px-5 mt-sm-auto mt-2">
                         عدد التعليقات <span class="number font-weight-bold"><?=$comments_count?></span>
                     </a>
                     <div class="border-bottom w-100 mx-1 d-sm-block d-none"></div>
                     <a class="btn btn-lg add-new-comment text-white px-5 mt-sm-auto mt-2">إضافة تعليق</a>
                 </div><!-- .comments-header -->
                 <form class="comments-form mt-4" method="POST" action="<?=base_url('site_user/products/add_comment/'.$product['id'])?>">
                     <div class="row">
                         <div class="col-lg-9">
                             <div class="form-group">
                                 <label for="message" class="sr-only">إضافة تعليق</label>
                                 <textarea name="comment" class="form-control" id="message" rows="6" placeholder="التعليق"><?=set_value('comment')?></textarea>
                             </div>
                             <button class="btn btn-lg submit text-white px-5 float-left">إرسال</button>
                         </div>
                     </div>
                 </form><!-- .comments-form -->
                 <div class="old-comments mt-5">
                     <div class="row">
                     <?php if ($comments_count > 0) { 
                       foreach ($product_comments as $comment) { ?>
                         <div class="col-lg-9 mb-4">
                             <h5 class="comment-author font-weight-bold position-relative pb-3">
                                  <?=get_this('customers',['id'=>$comment->user_id],'full_name')?>
                             </h5>
                             <div class="old-comment-box position-relative rounded px-5 py-4 mt-3 d-sm-flex">
                                 <div class="fa-3x d-inline-block comment-icon">
                                     <span class="fa-layers p-3 bg-white rounded-circle">
                                         <i class="fas fa-circle rounded-circle" data-fa-transform="shrink-4 right-.5"></i>
                                         <i class="fa-inverse fas fa-comments" data-fa-transform="shrink-10 right-1"></i>
                                     </span>
                                 </div>
                                 <div class="comment-wrap pr-4 border-right">
                                     <p class="comment-date">
                                         <i class="far fa-clock colored" aria-hidden="true"></i>
                                         <span class="font-tahome text-gray">
                                             <?=$comment->time?>  <?=$comment->created_at?>
                                         </span>
                                     </p>
                                     <p class="comment-content">
                                         <?=$comment->comment?>
                                     </p>
                                 </div>
                             </div>
                         </div>
                     <?php } } ?>
                     </div>
                 </div>
             </div>
         </div><!-- .container -->
     </div><!-- .page-content -->