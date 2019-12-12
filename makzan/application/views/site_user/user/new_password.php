<div class="page-content mb-5">
        <div class="container">
            <div class="page-header rounded p-3">
                <h1 class="page-title mb-auto">
                    نسيت كلمة المرور
                </h1>
            </div><!-- .page-header -->
            <div class="form-content my-5 py-5">
                <div class="row">
                    <div class="col-lg-8 col-md-10 col-12 mx-auto py-4 px-5 rounded form-wrap">
                        <h3 class="text-center">إنشاء كلمة مرور جديدة</h3>
                        <form class="password-form clearfix" method="POST">
                            <?php if ($this->session->flashdata('message')) { ?>
                               <?=$this->session->flashdata('message');?>
                            <?php } ?>
                            <div class="form-group">
                                <label for="password1" class="col-form-label">أدخل كلمة المرور الجديدة</label>
                                <input type="password" name="password" class="form-control form-control-lg border-0" id="password1">
                            </div>
                            <div class="form-group">
                                <label for="password2" class="col-form-label">إعادة كلمة المرور الجديدة</label>
                                <input type="password" name="c_password" class="form-control form-control-lg border-0" id="password2">
                            </div>
                            <button type="submit" class="btn btn-lg px-5 text-white float-left submit mt-4">
                                إرسال
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- .container -->
    </div><!-- .page-content -->