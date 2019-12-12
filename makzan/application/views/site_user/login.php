<div class="page-content mb-5">

        <div class="container">

            <div class="page-header rounded p-3">

                <h1 class="page-title mb-auto">

                    الدخول

                </h1>

            </div><!-- .page-header -->

            <div class="login-wrap">

                <div class="user-avatar mt-5">

                    <div class="fa-15x text-center">

                        <span class="fa-layers rounded-circle">

                            <i class="fas fa-circle"></i>

                            <i class="fa-inverse fas fa-user-alt" data-fa-transform="down-3"></i>

                        </span>

                    </div>

                </div><!-- .user-avatar -->
                <?php if ($this->session->flashdata('message')) { ?>
                       <?=$this->session->flashdata('message');?>
                <?php } ?>

                <div class="row">

                    <div class="col-lg-6 col-md-8 col-12 mx-auto">

                        <div class="login-tab mt-5">

                            <ul id="login-tab"

                                class="nav nav-tabs justify-content-around d-flex pr-0 border-0"

                                role="tablist">

                                <li class="nav-item">

                                    <a class="nav-link active btn btn-lg user px-3 px-sm-5"

                                       id="user-login"

                                       href="#user"

                                       data-toggle="tab"

                                       aria-selected="true"

                                       aria-controls="user">دخول مستخدم</a>

                                </li>

                                <li class="nav-item">

                                    <a class="nav-link btn btn-lg vendor px-3 px-sm-5"

                                       id="vendor-login"

                                       href="#vendor"

                                       data-toggle="tab"

                                       aria-selected="false"

                                       aria-controls="vendor">دخول تاجر</a>

                                </li>

                            </ul>

                        </div><!-- .login-tab -->

                        <div class="tab-content">

                            <div id="user"

                                 class="tab-pane fade show active"

                                 aria-labelledby="user-login"

                                 role="tabpanel">

                                <div class="user-login-form">

                                    <form class="login-form mt-4 clearfix" method="POST" class="login-form mt-4 clearfix" action="<?=base_url('site_user/login')?>">

                                        <div class="form-group required position-relative">

                                            <label for="user-mobile" class="sr-only">رقم الجوال</label>

                                            <input type="text"

                                                   class="form-control form-control-lg pr-4"

                                                   id="user-mobile"

                                                   name="phone"

                                                   value="<?=set_value('phone')?>"

                                                   placeholder="رقم الجوال">

                                                   <?php if(form_error('phone'))echo form_error('phone')?>

                                        </div><!-- .form-group -->

                                        <div class="form-group required position-relative">

                                            <label for="user-password" class="sr-only">كلمة المرور</label>

                                            <input type="password"

                                                   class="form-control form-control-lg pr-4"

                                                   id="user-password"

                                                   name="password"

                                                   value="<?=set_value('password')?>"

                                                   placeholder="كلمة المرور">

                                                   <?php if(form_error('password'))echo form_error('password')?>

                                        </div><!-- .form-group -->

                                        <a href="<?=base_url('site_user/forget_password')?>" class="text-body no-decoration">هل نسيت كلمة المرور؟</a>

                                        <button type="submit" class="btn btn-lg px-5 text-white submit mt-3 float-left">دخول</button>

                                    </form><!-- .login-form -->

                                </div>

                            </div>

                            <div id="vendor"

                                 class="tab-pane fade"

                                 aria-labelledby="vendor-login"

                                 role="tabpanel">

                                <div class="vendor-login-form">

                                    <form class="login-form mt-4 clearfix" method="POST" class="login-form mt-4 clearfix" action="<?=base_url('site_merchant/login')?>">

                                        <div class="form-group required position-relative">

                                            <label for="vendor-mobile" class="sr-only">رقم الجوال</label>

                                            <input type="text"

                                                   class="form-control form-control-lg pr-4"

                                                   id="vendor-mobile"

                                                   name="phone"

                                                   value="<?=set_value('phone')?>"

                                                   placeholder="رقم الجوال">

                                                   <?php if(form_error('phone'))echo form_error('phone')?>

                                        </div><!-- .form-group -->

                                        <div class="form-group required position-relative">

                                            <label for="vendor-password" class="sr-only">كلمة المرور</label>

                                            <input type="password"

                                                   class="form-control form-control-lg pr-4"

                                                   id="vendor-password"

                                                   name="password"

                                                   value="<?=set_value('password')?>"

                                                   placeholder="كلمة المرور">

                                                   <?php if(form_error('password'))echo form_error('password')?>

                                        </div><!-- .form-group -->

                                        <a href="<?=base_url('site_merchant/forget_password')?>" class="text-body no-decoration">هل نسيت كلمة المرور؟</a>

                                        <button type="submit" class="btn btn-lg px-5 text-white submit mt-3 float-left">دخول</button>

                                    </form><!-- .login-form -->

                                </div>

                            </div>

                        </div>

                    </div>

                </div><!-- .row -->

            </div><!-- .login-wrap -->

        </div><!-- .container -->

    </div><!-- .page-content -->