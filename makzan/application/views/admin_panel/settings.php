<!-- Page-header start -->
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10">الاعدادات</h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item">
            <a href="<?=base_url('admin_panel/dashboard')?>">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="<?=base_url('admin_panel/settings')?>">الاعدادات</a>
         </li>
      </ul>
   </div>
</div>
<!-- Page-header end -->
<div class="page-body">
      <!-- Basic Form Inputs card start -->
      <div class="card">
         <div class="card-header">
            <h5>الاعدادات</h5>
         </div>
         <div class="card-block">
            <form action="" method="POST">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">اسم التطبيق</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="app_name" value="<?=$settings['app_name']?>" placeholder="من فضلك ادخل اسم التطبيق">
                     <?php if(form_error('app_name'))echo form_error('app_name')?>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">رقم الجوال</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="phone" value="<?=$settings['phone']?>" placeholder="من فضلك ادخل رقم الجوال">
                     <?php if(form_error('phone'))echo form_error('phone')?>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">البريد الالكتروني</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="email" value="<?=$settings['email']?>" placeholder="من فضلك ادخل البريد الالكتروني">
                     <?php if(form_error('email')) echo form_error('email') ?>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">الضريبة</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="tax" value="<?=$settings['tax']?>" placeholder="من فضلك ادخل الضريبة ">
                     <?php if(form_error('tax')) echo form_error('tax') ?>
                  </div>
                </div>
				<div class="form-group row">
                  <label class="col-sm-2 col-form-label">نسبة التطبيق</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="app_balance" value="<?=$settings['app_balance']?>" placeholder="من فضلك ادخل نسبة التطبيق ">
                     <?php if(form_error('app_balance')) echo form_error('app_balance') ?>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">العنوان</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="address" value="<?=$settings['address']?>" placeholder="من فضلك ادخل العنوان">
                     <?php if(form_error('address')) echo form_error('address') ?>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">الحد الادنى لسحب الرصيد</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="min_balance" value="<?=$settings['min_balance']?>" placeholder="من فضلك ادخل الحد الادنى لسحب الرصيد">
                     <?php if(form_error('min_balance')) echo form_error('min_balance') ?>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">فيس بوك</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="facebook" value="<?=$settings['facebook']?>" placeholder="من فضلك ادخل فيس بوك">
                     <?php if(form_error('facebook')) echo form_error('facebook') ?>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">تويتر</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="twitter" value="<?=$settings['twitter']?>" placeholder="من فضلك ادخل تويتر">
                     <?php if(form_error('twitter')) echo form_error('twitter') ?>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">جوجل بلس</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="google_plus" value="<?=$settings['google_plus']?>" placeholder="من فضلك ادخل جوجل بلس">
                     <?php if(form_error('google_plus')) echo form_error('google_plus') ?>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">يوتيوب</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="youtube" value="<?=$settings['youtube']?>" placeholder="من فضلك ادخل يوتيوب">
                     <?php if(form_error('youtube')) echo form_error('youtube') ?>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">انستجرام</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="instagram" value="<?=$settings['instagram']?>" placeholder="من فضلك ادخل انستجرام">
                     <?php if(form_error('instagram')) echo form_error('instagram') ?>
                  </div>
                </div>
				<div class="form-group row">
                  <label class="col-sm-2 col-form-label">رابط التطبيق الاندرويد</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="android_app" value="<?=$settings['android_app']?>" placeholder="من فضلك ادخل انستجرام">
                     <?php if(form_error('android_app')) echo form_error('android_app') ?>
                  </div>
                </div>
				<div class="form-group row">
                  <label class="col-sm-2 col-form-label">رابط تطبيق IOS</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="ios_app" value="<?=$settings['ios_app']?>" placeholder="من فضلك ادخل انستجرام">
                     <?php if(form_error('ios_app')) echo form_error('ios_app') ?>
                  </div>
                </div>
               <button type="submit" class="btn btn-md btn-success"><i class="icofont icofont-check"></i>  تعديل </button>      <a href="<?=base_url('admin_panel/dashboard')?>" class="btn btn-md btn-danger"><i class="icofont icofont-close"></i>  رجوع </a>
            </form>
         </div>
</div>
