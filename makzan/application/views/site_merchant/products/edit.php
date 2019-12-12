<form class="product-form mt-5" method="POST" enctype="multipart/form-data">
<div class="page-content mb-5">
        <div class="container">
            <div class="page-header rounded p-3">
                <h1 class="page-title mb-auto">
                    تعديل المنتج
                </h1>
            </div><!-- .page-header -->
            <div class="product-view mt-4">
                <div class="row">
                    <div class="col-md-6 mx-auto">
                        <div class="box-image rounded thumbnail ">
                            <img src="<?=base_url('assets/uploads/files/'.$product['main_image'])?>" id="image_upload_preview" class="img-fluid" style="width:570px; height:300px"
                            alt="Product image">
                            <input name="main_image" onchange="document.getElementById('image_upload_preview').src = window.URL.createObjectURL(this.files[0])" type="file" class="custom-file-input"  id="inputFile" style=" width:570px; height:300px;">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php foreach ($product_images as $one) { ?>
                        <div class="col-3 contain">
                            <img style="width: 255px; height: 155px;" src="<?=base_url('assets/uploads/files/'.$one->image_name)?>" class="img-fluid d-block mx-auto rounded thumbnail mt-3 mt-sm-4">
                            <a data-id="<?=$one->id?>" href="<?=base_url('site_merchant/products/delete_img/'.$one->id)?>" class="btn btn-sm btni">حذف </a>  
                        </div>
                    <?php } ?>
                    <?php $num = 4 - count($product_images);
                    for ($i=0; $i <$num ; $i++) { ?>
                    <div class="col-3 ">
                        <div class="box-image rounded thumbnail mt-3 mt-sm-4">
                            <img src="<?=base_url()?>assets/uploads/files/add-product-sm.png" id="image_upload_preview-<?=$i?>" class="img-fluid d-block mx-auto img-resp"
                            alt="Product image"  width="255" height="151">
                            <input name="image[]" onchange="document.getElementById('image_upload_preview-<?=$i?>').src = window.URL.createObjectURL(this.files[0])" type="file" class="custom-file-input input-row-2"  id="inputFile" style="width:255px; height:151px">
                            <?php if(form_error('main_image')) echo form_error('main_image') ?>
                        </div>
                    </div>
                    <?php  } ?>
                </div>
            </div><!-- .product-view -->
                <div class="form-row">
                    <div class="col-12 col-md-3">
                        <label for="product-title" class="col-form-label">إسم المنتج</label>
                        <input name="name" value="<?=$product['name']?>" type="text" class="form-control form-control-lg" id="product-title">
                        <?php if(form_error('name'))echo form_error('name')?>
                    </div>
                    <div class="col-12 col-md-3">
                        <label for="product-carigoray" class="col-form-label">قسم المنتج</label>
                        <select name="category_id" class="custom-select form-control-lg" id="product-carigoray">
                            <?php $i=0;
                            foreach ($categories as $category) { ?>
                            <option value="<?=$category->id?>" <?php if($category->id == $product['category_id']) echo 'selected' ?>><?=$category->name?></option><?php $i++ ; } ?>
                        </select>
                    </div>
                    <div class="col-12 col-md-3">
                        <label for="product-price" class="col-form-label">سعر المنتج</label>
                        <input name="price" value="<?=$product['price']?>" type="text" class="form-control form-control-lg" id="product-price">
                        <?php if(form_error('price'))echo form_error('price')?>
                    </div>
                    <div class="col-12 col-md-3">
                        <label for="product-quantity" class="col-form-label">الكمية</label>
                        <input name="available_quantity" value="<?=$product['available_quantity']?>" type="number" class="form-control form-control-lg" id="product-quantity">
                        <?php if(form_error('available_quantity'))echo form_error('available_quantity')?>
                    </div>
                </div><!-- .form-row -->

                <div class="product-condition text-right text-sm-center mt-5">
                    <span>حالة المنتج :</span>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input class="custom-control-input" type="radio" id="inlineRadio1"
                           name="type" value="0" <?php if ($product['type'] == 0) { echo 'checked="checked"'; } ?>>
                        <label class="custom-control-label mr-3 pr-3" for="inlineRadio1">جديد</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input class="custom-control-input" type="radio" id="inlineRadio2"
                            name="type" value="1" <?php if ($product['type'] == 1) { echo 'checked="checked"'; } ?>>
                        <label class="custom-control-label mr-3 pr-3" for="inlineRadio2">مستعمل</label>
                    </div>
                </div><!-- .product-condition -->

                <div class="row mt-5">
                    <div class="form-group col-md-9 col-12">
                        <label for="exampleFormControlTextarea1">وصف المنتج</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" name="description"><?=$product['description']?></textarea>
                         <?php if(form_error('description'))echo form_error('description')?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-7 col-12 mx-auto mt-4">
                        <button class="btn btn-lg btn-block submit text-white py-3 position-relative" type="submit">تعديل</button>
                    </div>
                </div>

        </div><!-- .container -->
    </div><!-- .page-content -->
</form><!-- .product-form -->