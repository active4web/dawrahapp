<div class="page-content mb-5">

        <div class="container">

            <div class="page-header rounded p-3">

                <h1 class="page-title mb-auto">

                    تأكيد عملية التسجيل

                </h1>

            </div><!-- .page-header -->

            <div class="row">

                <div class="col-lg-8 col-md-10 col-12 mx-auto py-5 my-5">

                    <div class="register-success rounded text-center px-5 py-4">

                        <h5 class="confirm-title mb-3">

                            تأكيد عملية التسجيل

                        </h5>

                        <p class="progress-message px-5">

                            من فضلك ادخل كود التفعيل المرسل اليك

                        </p>

                        <form method="POST" class="confirm-form clearfix">

                            <?php if ($this->session->flashdata('message')) { ?>

                                   <?=$this->session->flashdata('message');?>

                            <?php } ?>
                            <div class="form-group">

                                <label for="confirmNumber" class="sr-only">كود

                                    التفعيل</label>

                                <input type="text" name="code" value="<?=set_value('code')?>" class="form-control form-control-lg" id="confirmNumber">

                                 <?php if(form_error('code'))echo form_error('code')?>

                            </div><!-- .form-group -->

                            <button class="btn btn-lg text-white submit px-5 float-left" type="submit">تأكيد</button>
                            <a href="<?=base_url('site_merchant/send_sms/send/'.$this->uri->segment(4))?>" class="btn btn-lg px-5 text-white submit px-5 float-left">اعادة الارسال </a>

                        </form><!-- .confirm-form -->

                    </div><!-- .register-success -->

                </div><!-- .col-* -->

            </div><!-- .row -->

        </div><!-- .container -->

    </div><!-- .page-content -->