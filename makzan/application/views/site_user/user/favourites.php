 <div class="page-content">
        <div class="container">
            <div class="page-header rounded p-3">
                <h1 class="page-title mb-auto">
                    <?=$title?>
                </h1>
            </div><!-- .page-header -->
            <div class="row py-4">
                <?php foreach ($favourites as $item) { ?>
                    <div class="col-md-6 col-12 mt-4">
                        <div class="media border rounded pt-4 px-4 pb-2">
                            <a href="<?=base_url('site_user/products/product/'.$item->product_id)?>" class="d-block p-2 border rounded ml-3">
                                <img style="height: 161px; width: 122px" class="d-block mx-auto img-fluid"
                                     src="<?=base_url('assets/uploads/files/'.$item->main_image)?>">
                            </a>
                            <div class="media-body d-flex flex-column flex-wrap">
                                <h5 class="mt-2 font-tahoma text-uppercase">
                                    <a href="<?=base_url('site_user/products/product/'.$item->product_id)?>" class="text-body no-decoration"><?=$item->name?></a>
                                </h5>
                                <p>
                                    سعر المنتج :
                                    <span class="number"><?=$item->price?></span>
                                    <span class="currency">ريال</span>
                                </p>
                                <div class="fa-2x justify-content-end align-self-end mt-5">
                                    <a href="<?=base_url('site_user/products/remove_from_favourites/'.$item->product_id)?>">
                                        <span class="fa-layers fa-fw">
                                            <i class="fas fa-circle remove"></i>
                                            <i class="fa-inverse fas fa-times"
                                               data-fa-transform="shrink-8"></i>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div><!-- .media -->
                    </div><!-- .col-* -->
                <?php } ?>
            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- .page-content -->