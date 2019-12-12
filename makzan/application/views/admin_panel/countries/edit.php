<!-- Page-header start -->

<div class="page-header card">

   <div class="card-block">

      <h5 class="m-b-10">الدول</h5>

      <ul class="breadcrumb-title b-t-default p-t-10">

         <li class="breadcrumb-item">

            <a href="<?=base_url('admin_panel/dashboard')?>">الرئيسية</a>

         </li>

         <li class="breadcrumb-item"><a href="<?=base_url('admin_panel/countries')?>">الدول</a>

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

            <h5>تعديل الدولة</h5>

         </div>

         <div class="card-block">

            <form action="" method="POST" enctype="multipart/form-data">

               <div class="form-group row">

                  <label class="col-sm-2 col-form-label">اسم الدولة</label>

                  <div class="col-sm-10">

                     <input type="text" class="form-control" name="name" value="<?=$country['name']?>" placeholder="من فضلك ادخل اسم الدولة">

                     <?php if(form_error('name'))echo form_error('name')?>

                  </div>

               </div>
               <div class="form-group row">

                  <label class="col-sm-2 col-form-label">المفتاح الدولي</label>

                  <div class="col-sm-10">

                     <input type="text" class="form-control" name="international_key" value="<?=$country['international_key']?>" placeholder="من فضلك ادخل المفتاح الدولي">

                     <?php if(form_error('international_key'))echo form_error('international_key')?>

                  </div>

               </div>

               <div class="form-group row">

                  <label class="col-sm-2 col-form-label">الشعار</label>

                  <div class="col-sm-10">

                      <input type="file" name="flag" class="form-control">

                      <?php if(form_error('flag')) echo form_error('flag') ?>

                  </div>

              </div>

               <button type="submit" class="btn btn-md btn-success"><i class="icofont icofont-check"></i>  تعديل </button>    <a href="<?=base_url('admin_panel/countries')?>" class="btn btn-md btn-danger"><i class="icofont icofont-close"></i>  رجوع </a>

            </form>

         </div>

</div>

