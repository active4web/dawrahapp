<!-- Page-header start -->

<div class="page-header card">

   <div class="card-block">

      <h5 class="m-b-10"> المنتجات</h5>

      <ul class="breadcrumb-title b-t-default p-t-10">

         <li class="breadcrumb-item">

            <a href="<?=base_url('admin_panel/dashboard')?>">الرئيسية</a>

         </li>

         <li class="breadcrumb-item"><a href="<?=base_url('admin_panel/products')?>"> المنتجات</a>

         </li>

         <li class="breadcrumb-item"><a>تعديل</a>

         </li>

      </ul>

   </div>

</div>

<!-- Page-header end -->

<div class="page-body">

      <!-- Basic Form Inputs card start -->

      <div class="card">

         <div class="card-header">

            <h5> تعديل المنتج </h5>

         </div>

         <div class="card-block">

            <form action="" method="POST" enctype="multipart/form-data">

               <div class="form-group row">

                  <label class="col-sm-2 col-form-label">اسم المنتج</label>

                  <div class="col-sm-10">

                     <input type="text" class="form-control" name="name" value="<?=$product['name']?>" placeholder="من فضلك ادخل اسم المنتج">

                     <?php if(form_error('name'))echo form_error('name')?>

                  </div>

               </div>
               <div class="form-group row">

                  <label class="col-sm-2 col-form-label">سعر المنتج</label>

                  <div class="col-sm-10">

                     <input type="text" class="form-control" name="price" value="<?=$product['price']?>" placeholder="من فضلك ادخل سعر المنتج">

                     <?php if(form_error('price'))echo form_error('price')?>

                  </div>

               </div>
               <div class="form-group row">

                  <label class="col-sm-2 col-form-label">الكميه المتاحه من المنتج</label>

                  <div class="col-sm-10">

                     <input type="text" class="form-control" name="available_quantity" value="<?=$product['available_quantity']?>" placeholder="من فضلك ادخل الكميه المتاحه من المنتج">

                     <?php if(form_error('available_quantity'))echo form_error('available_quantity')?>

                  </div>

               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">المتجر</label>
                  <div class="col-sm-10">
                      <select style="height: 40px;" name="created_by" class="form-control">
                        <?php foreach ($merchants as $merchant) { ?>
                          <option value="<?=$merchant->id?>"<?php if($product['created_by'] == $merchant->id) echo 'selected'; ?>><?=$merchant->store_name?></option>
                        <?php } ?>
                      </select>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">التصنيف</label>
                  <div class="col-sm-10">
                      <select style="height: 40px;" name="category_id" class="form-control">
                        <?php foreach ($categories as $category) { ?>
                          <option value="<?=$category->id?>" <?php if($product['category_id'] == $category->id) echo 'selected'; ?>><?=$category->name?></option>
                        <?php } ?>
                      </select>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">وصف المنتج</label>
                  <div class="col-sm-10">
                     <textarea name="description">
                        <?=$product['description']?>
                     </textarea>
                     <?php if(form_error('description'))echo form_error('description')?>
                  </div>
               </div>
               <div class="form-group row">

                  <label class="col-sm-2 col-form-label">صورة المنتج الرئيسية</label>

                  <div class="col-sm-10">

                      <input type="file" name="main_image" value="" class="form-control">

                      <?php if(form_error('main_image')) echo form_error('main_image') ?>

                  </div>

              </div>
              <?php if (!empty($product_images)) { ?>
              <label class="col-sm-2 col-form-label">صور المنتج </label>
              <div class="row" style="padding-right: 221px">
                <?php foreach ($product_images as $item) { ?>
                  <div class="col-md-3">
                      <div class="thumbnail">
                          <div class="thumb">
                              <a href="<?=base_url('assets/uploads/files/'.$item->image_name)?>" data-lightbox="1" data-title="My caption 1">
                                  <img style="height: 150px" src="<?=base_url('assets/uploads/files/'.$item->image_name)?>" alt="" class="img-fluid img-thumbnail">
                              </a>
                              </br>
                             <a href="<?=base_url('admin_panel/products/delete_img/'.$item->id)?>" class="btn btn-danger btn-sm">حذف الصورة</a>  
                          </div>
                          
                      </div>
                  </div>
                <?php } ?>
              </div>
              <?php } ?>
              <?php if ($images == 0) { ?>
                  <div class="form-group row">

                    <label class="col-sm-2 col-form-label">اضف صور اخرى</label>

                    <div class="col-sm-5">

                        <input type="file" name="image[]" class="form-control">

                        <?php if(form_error('image')) echo form_error('image') ?>

                    </div>
                    <div class="col-sm-5">

                        <input type="file" name="image[]" class="form-control">

                        <?php if(form_error('image')) echo form_error('image') ?>

                    </div>

                  </div>
                  <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-5">

                        <input type="file" name="image[]" class="form-control">

                        <?php if(form_error('image')) echo form_error('image') ?>

                    </div>
                    <div class="col-sm-5">

                        <input type="file" name="image[]" class="form-control">

                        <?php if(form_error('image')) echo form_error('image') ?>

                    </div>

                  </div>
              <?php }if ($images == 1) { ?>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>
                    <label class="col-sm-2 col-form-label">اضف صور اخرى</label>
                    <div class="col-sm-3">

                        <input type="file" name="image[]" class="form-control">

                        <?php if(form_error('image')) echo form_error('image') ?>

                    </div>
                    <div class="col-sm-3">

                        <input type="file" name="image[]" class="form-control">

                        <?php if(form_error('image')) echo form_error('image') ?>

                    </div>
                    <div class="col-sm-3">

                        <input type="file" name="image[]" class="form-control">

                        <?php if(form_error('image')) echo form_error('image') ?>

                    </div>

                  </div>
              <?php }if ($images == 2) { ?>
               <div class="form-group row">

                    <label class="col-sm-2 col-form-label">اضف صور اخرى</label>

                    <div class="col-sm-5">

                        <input type="file" name="image[]" class="form-control">

                        <?php if(form_error('image')) echo form_error('image') ?>

                    </div>
                    <div class="col-sm-5">

                        <input type="file" name="image[]" class="form-control">

                        <?php if(form_error('image')) echo form_error('image') ?>

                    </div>

                  </div>
              <?php }if ($images == 3) { ?>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label">اضف صور اخرى</label>

                    <div class="col-sm-10">

                        <input type="file" name="image[]" class="form-control">

                        <?php if(form_error('image')) echo form_error('image') ?>

                    </div>

                  </div>
              <?php } ?>
              <div class="form-group row">
                  <label class="col-sm-2 col-form-label">حالة المنتج</label>
                  <div class="col-sm-10">
                     <div class="form-radio">
                        <div class="radio radiofill radio-primary radio-inline">
                           <label>
                           <input type="radio" name="type" value="1" <?php if($product['type'] == 1) echo 'selected'; ?>>
                           <i class="helper"></i>مستعمل
                           </label>
                        </div>
                        <div class="radio radiofill radio-primary radio-inline">
                           <label>
                           <input type="radio" name="type" value="0" <?php if($product['type'] == 0) echo 'selected'; ?>>
                           <i class="helper"></i>جديد
                           </label>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">حالة الظهور</label>
                  <div class="col-sm-10">
                     <div class="form-radio">
                        <div class="radio radiofill radio-primary radio-inline">
                           <label>
                           <input type="radio" name="status" value="1">
                           <i class="helper"></i>ظاهر
                           </label>
                        </div>
                        <div class="radio radiofill radio-primary radio-inline">
                           <label>
                           <input type="radio" name="status" value="0">
                           <i class="helper"></i>محجوب
                           </label>
                        </div>
                     </div>
                     <small class="text-danger"></small>
                     <span class="messages"></span>
                  </div>
               </div>

               <button type="submit" class="btn btn-md btn-success"><i class="icofont icofont-check"></i>  تعديل </button>    <a href="<?=base_url('admin_panel/products')?>" class="btn btn-md btn-danger"><i class="icofont icofont-close"></i>  رجوع </a>

            </form>

         </div>

</div>

