<!DOCTYPE html>
<html>
<head>
   <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/login/login.css">
<link rel="stylesheet" media="screen" href="https://fontlibrary.org/face/droid-arabic-kufi" type="text/css"/>
<title>تسجيل الدخول</title>
</head>
<body style="font-family: DroidArabicKufiRegular">
<div class="container">
   <div class="row">
      
<!-- Mixins-->
<!-- Pen Title-->
<div class="pen-title">
  <!-- <h1>تسجيل الدخول</h1> -->
  <img style="height: 75px" src="<?=base_url()?>assets/admin_panel/images/logo.png">
</div>
<div class="container">
  <div class="card"></div>
  <div class="card">
    <h1 class="title">دخول</h1>
    <form method="POST" role="form">
      <div class="input-container">
        <input type="text" id="Username" name="user_name">
        <label for="Username">اسم المستخدم</label>
        <div class="bar"></div>
        <?php if($user_name_error)echo $user_name_error?>
      </div>
      <div class="input-container">
        <input type="password" id="Password" name="password" >
        <label for="Password">كلمة المرور</label>
        <div class="bar"></div>
        <?php if($password_error)echo $password_error?>
      </div>
      <div class="button-container">
        <button type="submit"><span>دخول</span></button>
      </div>
      <div class="footer"><a href="#" style="color: #4099ff">نسيت كلمة المرور؟</a></div>
    </form>
  </div>
   </div>
</div>
</body>
</html>