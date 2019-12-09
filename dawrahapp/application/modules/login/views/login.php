<style>.wrapper {background-color:#f7f7fc} iframe{height:330px}
.fixed-top {
    box-shadow: none;
    position: fixed;}
</style>
		<?php 
	foreach($site_info as $siteinfo)
						?>

<section class="page-title-bg pt-80 pb-30" >
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-title text-center">
                       
                    </div>
                </div>
            </div>
        </div>
    </section>
		<div class="wrapper">
			<div class="container">
            <div class="row" style="height:20px"></div>
<div class="row  pt-50 " style="margin-top:30px;background-color:#fff;">
<div class="col-md-5  col-xs-12" >
<div class="col-md-12 ">
<div class="page-title text-center" >
<h2 style="font-size:17px;font-weight:bold"> تسجيل الدخول</h2>
<form method="POST" action="#" class="contact-form form" id="form">
<div class="row">

<div class="col-md-3">
<div class="user type_user">
<p><i class="fa fa-user"></i></p>
<p>عضو</p>
</div>
</div>
<div class="col-md-3">
<div class="com type_user">
<p><i class="fa fa-building"></i></p>
<p>شركة</p>
</div>

</div>
<div class="col-md-3">

<div class="bag type_user">
<p><i class="fa fa-briefcase"></i></p>
<p>صاحب حقيبة</p>
</div>

</div>
<div class="col-md-3 ">

<div class="trainer type_user">
<p><i class="fa fa-male"></i></p>
<p>مدرب</p>
</div>

</div>
<input type="hidden" id="user_type" name="user_type" value="1">

<div class="col-md-12 pos">
<label class="label" for="password">رقم الجوال</label>
<input type="text" id="phone" name="phone" class="theme-input-style main_input"  placeholder="رقم الجوال">
</div>

<div class="col-md-12 pos">
<label class="label" for="password">كلمة المرور</label>
<input type="password" id="password" name="password" class="theme-input-style main_input"  placeholder="كلمة المرور">
</div>

<div class="col-md-12">
<a href="<?= base_url()?>forgetpassword" style="color:#367dfe">هل نسيت كلمة المرور ؟</a>
</div>

<div class="col-md-12">
<button type="button" class="btn searchbutton mainheader login" style="border-radius:0.4em;background-color:#367dfe !important;width:100%">
<span style="padding:0px"><span class="button_right">تسجيل الدخول</span><i class="fa fa-arrow-left" style="background: transparent;float:left"></i></span></button>
</div>
</div>
<div class="form-response"></div>
</form>
</div>
</div>
</div>
<div class="col-md-2 col-xs-12 "  style="text-align:center">
    <div class="v_line"></div>
</div>
					
					<div class="col-md-5 col-xs-12 " style="">
                    <div class="col-md-12 ">
<div class="page-title text-center" >
<h2 style="font-size:17px;font-weight:bold">  إنشاء حساب جديد</h2>
</div>
</div>

<input type="hidden" id="user_type1" name="user_type1" value="1">

<div class="row">

<div class="col-md-3">
<div class="user1 type_user1">
<p><i class="fa fa-user"></i></p>
<p>عضو</p>
</div>
</div>
<div class="col-md-3">
<div class="com1 type_user1">
<p><i class="fa fa-building"></i></p>
<p>شركة</p>
</div>

</div>
<div class="col-md-3">
<div class="bag1 type_user1">
<p><i class="fa fa-briefcase"></i></p>
<p>صاحب حقيبة</p>
</div>
</div>

<div class="col-md-3 ">
<div class="trainer1 type_user1">
<p><i class="fa fa-male"></i></p>
<p>مدرب</p>
</div>
</div>
<div class="col-md-12 txt_register user_reg">
عضوية عامة يمكن التسجيل بها لطلب الدورات والدبلومات والحقائب التدرييبة
</div>
<div class="col-md-12 txt_register trainer_reg" style="display:none">
عضوية عامة يمكن التسجيل بها لفتح حساب مدرب
</div>

<div class="col-md-12 txt_register bag_reg" style="display:none">
عضوية عامة يمكن التسجيل بها لإضافة حقائب
</div>

<div class="col-md-12 txt_register company_reg" style="display:none">
عضوية عامة يمكن التسجيل بها لفتح ملف شركة وإضافة الدورات الداخلية
</div>

<div class="col-md-12">
<a  class="register_type" style="cursor: pointer;">
<button type="button" class="btn searchbutton mainheader" style="border-radius:0.4em;background-color:#367dfe !important;width:100%">
<span style="padding:0px"><span class="button_right">التالى</span>  
<i class="fa fa-arrow-left" style="background: transparent;float:left"></i></span></button>
</a>
</div>
</div>
<div class="form-response"></div>

</div>
            <div class="col-md-12 bg_login" style="background-image:url(<?=base_url()?>uploads/site_setting/login_bg.jpg)"></div>
        </div>
        <div class="row  pt-50 " style="height:20px"></div>

		

		</div>

	
