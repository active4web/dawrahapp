<div class="page-content">
        <div class="container">
            <!-- <div class="page-header rounded p-3">
                <h1 class="page-title mb-auto">
                    قائمة المنتجات
                </h1>
                <a style="float: left" href="<?=base_url('site_merchant/products/add')?>" type="button" class="btn btn-success">Success</a>
            </div> -->
            <div class="page-header rounded px-3 py-2 d-flex justify-content-between align-items-center">
                <h1 class="page-title mb-auto">
                    منتجاتي
                </h1>
                <a href="<?=base_url('site_merchant/products/add')?>" class="btn px-3 text-white btn-success">
                    اضافة منتج جديد
                </a>

            </div>
            <?php if ($this->session->flashdata('message')) { ?>
                   <?=$this->session->flashdata('message');?>
            <?php } ?>
            <div class="row py-4">
                <?php foreach ($products as $product) { ?>
                    <div class="col-md-6 col-12 mt-4">
                        <div class="media border rounded p-4">
                            <a href="#" class="d-block p-2 border rounded ml-3">
                                <img style="width: 122px; height: 161px" class="d-block mx-auto img-fluid"
                                     src="<?=base_url('assets/uploads/files/'.$product->main_image)?>"
                                     alt="Generic placeholder image">
                            </a>
                            <div class="media-body d-flex flex-column flex-wrap">
                                <h5 class="mt-2 font-tahoma text-uppercase">
                                    <a href="" class="text-body no-decoration"><?=$product->name?></a>
                                </h5>
                                <p class="mb-auto">
                                    سعر المنتج :
                                    <span class="number"><?=$product->price?></span>
                                    <span class="currency">ريال</span>
                                </p>
                                <p>
                                    الكمية المتاحة :
                                    <span class="number"><?=$product->available_quantity?></span>
                                    <span class="label">جهاز</span>
                                </p>
                                <div class="fa-2x justify-content-end align-self-end mt-2 ltr">
                                    <?php if ($product->status == 1) { ?>
                                        <a href="<?=base_url('site_merchant/products/close/'.$product->id)?>" style="text-decoration: none;">
                                            <span class="fa-layers">
                                                <i class="fas fa-circle remove"></i>
                                                <i class="fa-inverse fas fa-times"
                                                   data-fa-transform="shrink-8"></i>
                                            </span>
                                        </a>
                                    <?php } ?>
                                        <a href="<?=base_url('site_merchant/products/edit/'.$product->id)?>" style="text-decoration: none;">
                                            <span class="fa-layers">
                                                <i class="fas fa-circle edit"></i>
                                                <i class="fa-inverse fas fa-pencil-alt"
                                                   data-fa-transform="shrink-8"></i>
                                            </span>
                                        </a>
                                    <?php if ($product->status == 0) { ?>
                                        <a href="<?=base_url('site_merchant/products/open/'.$product->id)?>" style="text-decoration: none;">
                                            <span class="fa-layers">
                                                <i class="fas fa-circle unlocked"></i>
                                                <i class="fa-inverse fas fa-unlock"
                                                   data-fa-transform="shrink-8"></i>
                                            </span>
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div><!-- .media -->
                    </div><!-- .col-* -->
                <?php } ?>
            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- .page-content -->