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

         <li class="breadcrumb-item"><a>اضافة</a>

         </li>

      </ul>

   </div>

</div>

<!-- Page-header end -->

<div class="page-body">

      <!-- Basic Form Inputs card start -->

      <div class="card">

         <div class="card-header">

            <h5>اضافة منتج جديد </h5>

         </div>

         <div class="card-block">

            <form action="" method="POST" enctype="multipart/form-data">

               <div class="form-group row">

                  <label class="col-sm-2 col-form-label">اسم المنتج</label>

                  <div class="col-sm-10">

                     <input type="text" class="form-control" name="name" value="<?=set_value('name')?>" placeholder="من فضلك ادخل اسم المنتج">

                     <?php if(form_error('name'))echo form_error('name')?>

                  </div>

               </div>
               <div class="form-group row">

                  <label class="col-sm-2 col-form-label">سعر المنتج</label>

                  <div class="col-sm-10">

                     <input type="text" class="form-control" name="price" value="<?=set_value('price')?>" placeholder="من فضلك ادخل سعر المنتج">

                     <?php if(form_error('price'))echo form_error('price')?>

                  </div>

               </div>
               <div class="form-group row">

                  <label class="col-sm-2 col-form-label">الكميه المتاحه من المنتج</label>

                  <div class="col-sm-10">

                     <input type="text" class="form-control" name="available_quantity" value="<?=set_value('available_quantity')?>" placeholder="من فضلك ادخل الكميه المتاحه من المنتج">

                     <?php if(form_error('available_quantity'))echo form_error('available_quantity')?>

                  </div>

               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">المتجر</label>
                  <div class="col-sm-10">
                      <select style="height: 40px;" name="created_by" class="form-control">
                        <?php foreach ($merchants as $merchant) { ?>
                          <option value="<?=$merchant->id?>"><?=$merchant->store_name?></option>
                        <?php } ?>
                      </select>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">التصنيف</label>
                  <div class="col-sm-10">
                      <select style="height: 40px;" name="category_id" class="form-control">
                        <?php foreach ($categories as $category) { ?>
                          <option value="<?=$category->id?>"><?=$category->name?></option>
                        <?php } ?>
                      </select>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">وصف المنتج</label>
                  <div class="col-sm-10">
                     <textarea name="description">
                        <?=set_value('description')?>
                     </textarea>
                     <?php if(form_error('description'))echo form_error('description')?>
                  </div>
               </div>
               <div class="form-group row">

                  <label class="col-sm-2 col-form-label">صورة المنتج الرئيسية</label>

                  <div class="col-sm-10">

                      <input type="file" name="main_image" value="<?=set_value('main_image')?>" class="form-control">

                      <?php if(form_error('main_image')) echo form_error('main_image') ?>

                  </div>

              </div>
              <div class="form-group row">

                  <label class="col-sm-2 col-form-label">صور المنتج </label>

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
              <div class="form-group row">
                  <label class="col-sm-2 col-form-label">حالة المنتج</label>
                  <div class="col-sm-10">
                     <div class="form-radio">
                        <div class="radio radiofill radio-primary radio-inline">
                           <label>
                           <input type="radio" name="type" value="1">
                           <i class="helper"></i>مستعمل
                           </label>
                        </div>
                        <div class="radio radiofill radio-primary radio-inline">
                           <label>
                           <input type="radio" name="type" value="0">
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

               <button type="submit" class="btn btn-md btn-success"><i class="icofont icofont-check"></i>  اضافة </button>    <a href="<?=base_url('admin_panel/products')?>" class="btn btn-md btn-danger"><i class="icofont icofont-close"></i>  رجوع </a>

            </form>

         </div>

</div>

