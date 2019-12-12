<div id="hero-slider" class="carousel slide carousel-fade hero-slider" data-ride="carousel">

        <div class="carousel-inner">

          <?php foreach ($slider as $item) { ?>

            <div class="carousel-item <?php if($item->id == 1) echo 'active'; ?>">

                <img style="height: 405px" class="d-block w-100 slider-img" src="<?=base_url('assets/uploads/files/'.$item->image)?>" alt="<?=$item->title?>">

                <div class="carousel-caption d-none d-md-block pb-lg-0">

                    <h5 class="h1"><?=$item->title?></h5>

                    <p class="lead"><?=$item->note?></p>

                    <a href="<?=base_url()?>site_user/register" class="register-now btn btn-lg text-white border-light px-5 mt-1 mt-lg-3">

                        سجل الآن

                    </a>

                </div>

            </div>

          <?php } ?>

        </div>

        <a class="carousel-control-prev" href="#hero-slider" role="button" data-slide="prev">

            <span class="carousel-control-icon text-center rounded">

                <i class="fa fa-chevron-left" aria-hidden="true"></i>

            </span>

            <span class="sr-only">Previous</span>

        </a>

        <a class="carousel-control-next" href="#hero-slider" role="button" data-slide="next">

            <span class="carousel-control-icon text-center rounded">

                <i class="fa fa-chevron-right" aria-hidden="true"></i>

            </span>

            <span class="sr-only">التالي</span>

        </a>

</div><!-- .hero-slider -->

<div class="page-content mb-5 py-5">

    <div class="container">



        <div class="product-list">

            <div class="row">

              <?php foreach ($categories as $category) { ?>

                <div class="col-lg-3 col-md-4 col-sm-6 col-12">

                    <div class="product-item mt-4">

                        <a href="<?=base_url('site_user/products/lists/'.$category->id)?>" class="product-link no-decoration <?php if($category->id == 1) echo 'active' ?> d-block text-center pt-5 pb-4">

                            <img style="height: 40px" src="<?=base_url('assets/uploads/files/'.$category->image)?>" class="img-fluid d-block mx-auto">

                            <p class="product-title d-block <?php if($category->id == 1) echo 'text-white' ?> mt-4 mb-auto"><?=$category->name?></p>

                        </a>

                    </div>

                </div>

              <?php } ?>

            </div>

        </div><!-- .product-list -->



    </div><!-- .container -->

</div><!-- .page-content -->