<?php
// print_r($this->uri->segment(3));
header("Cache-Control: no cache");
session_cache_limiter("private_no_expire");
?>
<style>
.typeahead.dropdown-menu{
	width: 350px;
    text-align: right;
    background-color: antiquewhite;
}
</style>
<div class="page-content mb-5">
        <div class="container">
            <div class="page-header rounded p-3">
                <h1 class="page-title mb-auto">
                    <span class="fa-layers fa-fw ml-3">
                        <i class="fas fa-circle" data-fa-transform="grow-12"></i>
                        <i class="fa-inverse fas fa-search" data-fa-transform="shrink-2"></i>
                    </span>
                    البحث
                </h1>
            </div><!-- .page-header -->
            <?php if ($this->session->flashdata('message')) { ?>

               <?=$this->session->flashdata('message');?>

            <?php } ?>
            <form method="POST" class="search-form mt-5 clearfix">
                <div class="row">
                    <div class="col-md-4 col-12">
                        <select class="custom-select custom-select-lg" name="category_id">
                            <?php foreach ($categories as $category) { ?>
                                <option value="<?=$category->id?>" <?php if($category->id == set_value('category_id')) echo 'selected' ?>><?=$category->name?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-4 col-12 mt-2 mt-md-auto">
                        <input name="store_name" placeholder="اسم المتجر" class="typeahead form-control form-control-lg" type="text" value="<?=set_value('store_name')?>">
                    </div>
                    <div class="col-md-4 col-12 mt-2 mt-md-auto">
                        <input name="product_name" placeholder="اسم المنتج" class="form-control form-control-lg" type="text" value="<?=set_value('product_name')?>">
                    </div>
                </div><!-- .form-row -->
                <button type="submit" class="btn btn-lg px-5 text-white mt-4 float-left submit position-relative">بحث</button>
            </form><!-- .search-form -->
        <?php if(!empty($products)){  ?>    
            <div class="search-result mt-3">
                <div class="result-count">
                    عدد النتائج
                    <span class="number">(&nbsp;&nbsp;<?=$products_count?>&nbsp;&nbsp;)</span>
                </div><!-- .result-count -->
                <div class="result-item mt-4">
                  <?php foreach ($products as $product) { ?>
                    <div class="col-md-6 col-12 shadow-sm rounded-0 border d-flex align-items-center px-3 py-5">
                        <div class="media w-100">
                            <a href="<?=base_url('site_user/products/product/'.$product->id)?>">
                                <img style="width: 85px; height: 85px" class="d-block mx-auto" src="<?=base_url('assets/uploads/files/'.$product->main_image)?>">
                            </a>
                            <div class="media-body align-self-center mr-3">
                                <h5 class="mt-0 h6 font-weight-bold">
                                    <a href="<?=base_url('site_user/products/product/'.$product->id)?>" class="text-body no-decoration">
                                        <span class="number text-uppercase"><?=$product->name?></span>
                                    </a>
                                </h5>
                                <p class="mb-0">
                                    سعر الوحدة :
                                    <span class="number"><?=$product->price?></span>
                                    ريال
                                </p>
                            </div><!-- .media-body -->
                            <div class="align-self-center">
                                <a href="<?=base_url('site_user/products/product/'.$product->id)?>" class="more-link">
                                    <span class="fa-3x">
                                        <span class="fa-layers">
                                            <i class="fas fa-circle"></i>
                                            <i class="fa-inverse fas fa-chevron-left" data-fa-transform="shrink-8"></i>
                                        </span>
                                    </span>
                                </a>
                            </div>
                        </div><!-- .media -->
                    </div>
                  <?php } ?>
                </div><!-- .result-item -->
            </div><!-- .search-result -->
        <?php } ?>
        </div><!-- .container -->
    </div><!-- .page-content -->
