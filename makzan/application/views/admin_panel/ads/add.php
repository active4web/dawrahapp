<!-- Page-header start -->
<!-- <div class="alert alert-success background-success">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <i class="icofont icofont-close-line-circled text-white"></i>
  </button>
  <strong>Success!</strong> Add Class <code> background-success</code>
</div> -->
<div class="page-header card">

   <div class="card-block">

      <h5 class="m-b-10">الاعلانات</h5>

      <ul class="breadcrumb-title b-t-default p-t-10">

         <li class="breadcrumb-item">

            <a href="<?=base_url('admin_panel/dashboard')?>">الرئيسية</a>

         </li>

         <li class="breadcrumb-item"><a href="<?=base_url('admin_panel/ads')?>">الاعلانات</a>

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

            <h5>اضافة اعلان جديد </h5>

         </div>

         <div class="card-block">

            <form action="" method="POST" enctype="multipart/form-data">

               <div class="form-group row">

                  <label class="col-sm-2 col-form-label">الرابط</label>

                  <div class="col-sm-10">

                     <input type="url" class="form-control" name="url" value="<?=set_value('url')?>" placeholder="من فضلك ادخل الرابط">

                     <?php if(form_error('url'))echo form_error('url')?>

                  </div>

               </div>

               <div class="form-group row">

                  <label class="col-sm-2 col-form-label">الصورة</label>

                  <div class="col-sm-10">

                      <input type="file" name="image" value="<?=set_value('image')?>" class="form-control">

                      <?php if(form_error('image')) echo form_error('image') ?>

                  </div>

              </div>

               <button type="submit" class="btn btn-md btn-success"><i class="icofont icofont-check"></i>  اضافة </button>    <a href="<?=base_url('admin_panel/ads')?>" class="btn btn-md btn-danger"><i class="icofont icofont-close"></i>  رجوع </a>

            </form>

         </div>

</div>

