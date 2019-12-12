<!-- Page-header start -->

<div class="page-header card">

   <div class="card-block">

      <h5 class="m-b-10">طرق التوصيل</h5>

      <ul class="breadcrumb-title b-t-default p-t-10">

         <li class="breadcrumb-item">

            <a href="<?=base_url('admin_panel/dashboard')?>">الرئيسية</a>

         </li>

         <li class="breadcrumb-item"><a href="<?=base_url('admin_panel/delivering_methods')?>">طرق التوصيل</a>

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

            <h5>تعديل طريقة التوصيل  </h5>

         </div>

         <div class="card-block">

            <form action="" method="POST" enctype="multipart/form-data">

               <div class="form-group row">

                  <label class="col-sm-2 col-form-label">اسم طريقة التوصيل </label>

                  <div class="col-sm-10">

                     <input type="text" class="form-control" name="name" value="<?=$method['name']?>" placeholder="من فضلك ادخل اسم طريقة التوصيل ">

                     <?php if(form_error('name'))echo form_error('name')?>

                  </div>

               </div>

               <button type="submit" class="btn btn-md btn-success"><i class="icofont icofont-check"></i>  تعديل </button>    <a href="<?=base_url('admin_panel/delivering_methods')?>" class="btn btn-md btn-danger"><i class="icofont icofont-close"></i>  رجوع </a>

            </form>

         </div>

</div>

