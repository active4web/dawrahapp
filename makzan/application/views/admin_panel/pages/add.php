<!-- Page-header start -->
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10">الصفحات الفرعيه</h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item">
            <a href="<?=base_url('admin_panel/dashboard')?>">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="<?=base_url('admin_panel/pages')?>">الصفحات الفرعيه</a>
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
            <h5>اضافة صفحة فرعية جديدة </h5>
         </div>
         <div class="card-block">
            <form action="" method="POST" enctype="multipart/form-data">
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">عنوان الصفحة</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="title" value="<?=set_value('title')?>" placeholder="من فضلك ادخل عنوان الصفحه الفرعيه">
                     <?php if(form_error('title'))echo form_error('title')?>
                  </div>
               </div>
			   <div class="form-group row">
                  <label class="col-sm-2 col-form-label">صورة الصفحة</label>
                  <div class="col-sm-10">
                      <input type="file" name="image" value="<?=set_value('image')?>" class="form-control">
                      <?php if(form_error('image')) echo form_error('image') ?>
                  </div>
              </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">محتوى الصفحة</label>
                  <div class="col-sm-10">
                     <textarea name="content">
                        <?=set_value('content')?>
                     </textarea>
                     <?php if(form_error('content'))echo form_error('content')?>
                  </div>
               </div>
               <button type="submit" class="btn btn-md btn-success"><i class="icofont icofont-check"></i>  اضافة </button>    <a href="<?=base_url('admin_panel/pages')?>" class="btn btn-md btn-danger"><i class="icofont icofont-close"></i>  رجوع </a>
            </form>
         </div>
</div>
