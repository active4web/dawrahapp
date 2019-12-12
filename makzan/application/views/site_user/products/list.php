<div class="page-content mb-5">
        <div class="container">
            <div class="page-header rounded p-3">
                <h1 class="page-title mb-auto">
                    صفحة القسم
                </h1>
            </div><!-- .page-header -->
            <div class="category-tabs pt-4">
                <ul class="nav nav-tabs nav-fill border-bottom-0 pr-0">
                    <li class="nav-item">
                        <a class="nav-link <?php if($this->uri->segment(5) == 0) echo 'active';?> border-0 py-3 rounded-right" href="<?=base_url('site_user/products/lists/'.$id.'/'.'0')?>" aria-selected="true">جديد</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($this->uri->segment(5) == 1) echo 'active';?> border-0 py-3 rounded-left"  href="<?=base_url('site_user/products/lists/'.$id.'/'.'1')?>" aria-selected="false">مستعمل</a>
                    </li>
                </ul>
                <div class="tab-content mt-4">
                    <?php if ($this->session->flashdata('message')) { ?>
                       <?=$this->session->flashdata('message');?>
                    <?php } ?>
                    <div class="tab-pane fade show active">
                        <div class="row">
                            <?php foreach ($products as $product) { ?>
                            <div class="col-md-6 col-12 mb-4">
                                <div class="media rounded pt-4 px-4 pb-2">
                                    <a href="<?=base_url('site_user/products/product/'.$product->id)?>" class="d-block border rounded position-relative item-image">
                                        <div class="position-absolute overlay rounded h-100 w-100 d-flex align-items-center justify-content-center">
                                            <i class="fa fa-eye fa-3x text-white"></i>
                                        </div>
                                        <div class="py-2 px-3">
                                            <img style="height: 161px; width: 122px" class="d-block mx-auto img-fluid" src="<?=base_url('assets/uploads/files/'.$product->main_image)?>">
                                        </div>
                                    </a>
                                    <div class="media-body d-flex flex-column flex-wrap mr-3">
                                        <h3 class="mt-2 font-tahoma">
                                            <a href="<?=base_url('site_user/products/product/'.$product->id)?>" class="text-body no-decoration font-tahoma">
                                               <?=$product->name?>
                                            </a>
                                        </h3>
                                        <p class="h4 colored">
                                            <span class="font-tahoma"><?=$product->price?></span>
                                            <span>ريال</span>
                                        </p>
                                        <ul class="rate list-inline pr-0 mt-2">
                                            <?php for ($i = 1; $i <= 5; $i++){
                                            if ($i <= get_avg($product->id)){ ?>
                                            <li class="list-inline-item mr-auto">
                                                <i class="fa fa-star filled" aria-hidden="true"></i>
                                            </li>
                                            <?php }else{ ?>
                                            <li class="list-inline-item mr-1">
                                                <i class="fa fa-star" aria-hidden="true" data-fa-transform="flip-h"></i>
                                            </li>
                                            <?php  } } ?>
                                        </ul>
                                        <div class="action-wrap justify-content-end align-self-end ltr">
                                            <?php $product_qty = $product->available_quantity; $product_id = $product->id; $product_name = $product->name; $product_price = $product->price; $product_owner = get_this('merchants',['id'=>$product->created_by],'id'); ?>
                                            <input hidden="hidden" type="number" name="quantity" id="<?php echo $product_id;?>" value="1" class="quantity form-control">
                                            <a href="javascript:void(0)"  class="add_cart btn add-to-cart mr-1" data-productid="<?php echo $product_id;?>" data-productowner="<?php echo $product_owner;?>" data-productname="<?php echo $product_name;?>" data-productprice="<?php echo $product_price;?>" data-productqty="<?php echo $product_qty;?>" <?php if($user_data['id']){echo 'data-user='.$user_data['id'];}else{echo 'data-user=0';}?>>
                                                <i class="fas fa-shopping-cart"></i>
                                            </a>
                                            <a href="<?=base_url('site_user/products/add_to_favourite/'.$product->id)?>" class="btn add-to-favorite">
                                                <i class="fas fa-star filled"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div><!-- .media -->
                            </div><!-- .col-* -->
                            <?php  } ?> 
                        </div>
                    </div>
                </div>
            </div><!-- .category-tabs -->
        </div><!-- .container -->
    </div><!-- .page-content -->