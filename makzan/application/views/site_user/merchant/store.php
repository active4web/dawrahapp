<div class="page-content mb-5">
        <div class="container">
            <div class="page-header rounded p-3">
                <h1 class="page-title mb-auto">
                    التاجر | <?=$merchant['full_name']?>
                </h1>
            </div><!-- .page-header -->
            <div class="store-header media d-flex align-items-center py-1 px-3 border rounded my-4">
                <img style="width:112px; height: 113px" src="<?=base_url('assets/uploads/files/'.$merchant['image'])?>"
                     alt="Vendor image"
                     class="rounded-circle">
                <div class="media-body mr-3">
                    <h4 class="store-title"><?=$merchant['store_name']?></h4>
                </div>
            </div>
            <?php if ($this->session->flashdata('message')) { ?>
               <?=$this->session->flashdata('message');?>
            <?php } ?>
            <div class="row category-tabs">
                <?php if ($products) {
                    foreach ($products as $product) { ?>
                <div class="col-md-6 col-12 mb-4">
                    <div class="media border rounded pt-4 px-4 pb-2">
                        <a href="<?=base_url('site_user/products/product/'.$product->id)?>"
                           class="d-block border rounded item-image">
                            <div class="py-2 px-3">
                                <img style="width:122px; height: 161px"  class="d-block mx-auto img-fluid"
                                     src="<?=base_url('assets/uploads/files/'.$product->main_image)?>"
                                     alt="Generic placeholder image">
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
                                <a href="" class="btn add-to-cart mr-1 rounded-circle text-center p-0">
                                    <i class="fas fa-shopping-cart"></i>
                                </a>
                                <a href="<?=base_url('site_user/products/add_to_favourite/'.$product->id)?>" class="btn add-to-favorite rounded-circle text-center p-0">
                                    <i class="fas fa-star filled"></i>
                                </a>
                            </div>
                        </div>
                    </div><!-- .media -->
                </div><!-- .col-* -->
                <?php  }
                }else{ ?>
                    <h3> عفوا لا توجد لديك اي منتجات </h3>
               <?php } ?>
            </div>
        </div><!-- .container -->
    </div><!-- .page-content -->