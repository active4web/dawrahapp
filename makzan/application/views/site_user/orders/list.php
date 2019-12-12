 <div class="page-content mb-5">
        <div class="container">
            <div class="page-header rounded p-3">
                <h1 class="page-title mb-auto">
                    <span class="fa-layers fa-fw ml-3">
                        <i class="fas fa-circle" data-fa-transform="grow-12"></i>
                        <i class="fa-inverse fas fa-shopping-bag" data-fa-transform="shrink-2"></i>
                    </span>
                    طلباتي
                </h1>
            </div><!-- .page-header -->
            <div class="row mt-4">
                <?php foreach ($my_main_orders as $main) { ?>
                <div class="col-lg-6 mb-4">
                    <div class="media order-item py-3 px-2 rounded position-relative">
                        <a href="<?=base_url('site_user/orders/order/'.$main->id)?>" class="ml-3">
                            <img src="<?=base_url()?>/assets/site_user/img/cart.jpg" width="159" height="159" alt="Order image">
                        </a>
                        <div class="media-body">
                            <h4 class="mb-2 text-gray">
                                طلب رقم :
                                <span class="number"><?=$main->id?></span>
                            </h4>
                            <!-- <p class="lead mb-2 text-gray">
                                <span class="fa-lg">
                                    <span class="fa-layers fa-fw">
                                        <i class="fas fa-circle" data-fa-transform="grow-4"></i>
                                        <i class="fa-inverse fas fa-exclamation" data-fa-transform="shrink-8"></i>
                                    </span>
                                </span>
                                حالة الطلب :
                                <span class="text-body"> قيد الانتظار</span>
                            </p> -->
                            <p class="lead">
                                <span class="colored">الإجمالي</span>
                                <span class="number text-body"><?=$main->total?></span>
                                <span class="text-gray">ريال</span>
                            </p>
                        </div>
                        <div class="align-self-center">
                            <a href="<?=base_url('site_user/orders/order/'.$main->id)?>" class="more-link">
                                <span class="fa-2x">
                                    <span class="fa-layers fa-fw ml-3">
                                        <i class="fas fa-circle" data-fa-transform="grow-8"></i>
                                        <i class="fa-inverse fas fa-chevron-left" data-fa-transform="shrink-6"></i>
                                    </span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div><!-- .container -->
    </div><!-- .page-content -->