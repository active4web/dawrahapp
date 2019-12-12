<!-- Page-header start -->
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10">الحسابات البنكية</h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item">
            <a href="<?=base_url('admin_panel/dashboard')?>">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="<?=base_url('admin_panel/bank_accounts')?>">الحسابات البنكية</a>
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
            <h5>تعديل الحساب</h5>
         </div>
         <div class="card-block">
            <form action="" method="POST" enctype="multipart/form-data">
              <div class="form-group row">
                 <label class="col-sm-2 col-form-label">اسم البنك</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="bank_name" value="<?=$account['bank_name']?>" placeholder="من فضلك ادخل اسم البنك">
                     <?php if(form_error('bank_name'))echo form_error('bank_name')?>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">صاحب الحساب</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="owner" value="<?=$account['owner']?>" placeholder="من فضلك ادخل اسم صاحب الحساب">
                     <?php if(form_error('owner'))echo form_error('owner')?>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">رقم الحساب</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="account_number" value="<?=$account['account_number']?>" placeholder="من فضلك ادخل رقم الحساب">
                     <?php if(form_error('account_number'))echo form_error('account_number')?>
                  </div>
               </div>
               <button type="submit" class="btn btn-md btn-success"><i class="icofont icofont-check"></i>  تعديل </button>    <a href="<?=base_url('admin_panel/bank_accounts')?>" class="btn btn-md btn-danger"><i class="icofont icofont-close"></i>  رجوع </a>
            </form>
         </div>
</div>
