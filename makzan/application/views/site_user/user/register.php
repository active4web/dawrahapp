<div class="page-content mb-5">
        <div class="container">
            <div class="page-header rounded p-3">
                <h1 class="page-title mb-auto">
                    التسجيل
                </h1>
            </div><!-- .page-header -->
            <div class="row">
                <div class="col-lg-6 col-md-8 col-12 mx-auto">
                    <div class="register-tab mt-5">
                        <ul id="register-tab"
                            class="nav nav-tabs justify-content-around d-flex pr-0 border-0"
                            role="tablist">
                            <li class="nav-item">
                                <a class="nav-link <?php if($this->uri->segment(1) == 'site_user') echo 'active' ?> btn btn-lg user px-3 px-sm-5"
                                   id="user-register"
                                   href="#user"
                                   data-toggle="tab"
                                   aria-selected="true"
                                   aria-controls="user">تسجيل مستخدم</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if($this->uri->segment(1) == 'site_merchant') echo 'active' ?> btn btn-lg vendor px-3 px-sm-5"
                                   id="vendor-register"
                                   href="#vendor"
                                   data-toggle="tab"
                                   aria-selected="false"
                                   aria-controls="vendor">تسجيل تاجر</a>
                            </li>
                        </ul>
                    </div><!-- .register-tab -->
                    <div class="tab-content">
                        <div id="user"
                             class="tab-pane fade show <?php if($this->uri->segment(1) == 'site_user') echo 'active' ?>"
                             aria-labelledby="user-register"
                             role="tabpanel">
                            <div class="user-register-form">
                                <form method="POST" class="register-form mt-5" id="user-register-form" action="<?=base_url('site_user/register')?>">
                                  <?php if ($this->session->flashdata('message')) { ?>
                                         <?=$this->session->flashdata('message');?>
                                  <?php } ?>
                                    <div class="form-group required position-relative">
                                        <label for="user-name" class="sr-only">الإسم</label>
                                        <input type="text"
                                               class="form-control form-control-lg pr-4"
                                               id="user-name"
                                               placeholder="الإسم"
                                               name="full_name"
                                               value="<?=set_value('full_name')?>">
                                               <?php if(form_error('full_name'))echo form_error('full_name')?>
                                    </div><!-- .form-group -->

                                    <div class="form-group required position-relative">
                                        <label for="user-mobile" class="sr-only">رقم الجوال</label>
                                        <input type="tel"
                                               class="form-control form-control-lg pr-4"
                                               id="user-mobile"
                                               placeholder="رقم الجوال"
                                               name="phone"
                                               value="<?=set_value('phone')?>">
                                               <?php if(form_error('phone'))echo form_error('phone')?>
                                    </div><!-- .form-group -->
                                    <div class="form-group required position-relative">
                                        <label for="user-mobile" class="sr-only">كلمة المرور</label>
                                        <input type="password"
                                               class="form-control form-control-lg pr-4"
                                               id="user-mobile"
                                               placeholder="كلمة المرور"
                                               name="password"
                                               value="<?=set_value('password')?>">
                                               <?php if(form_error('password'))echo form_error('password')?>
                                    </div><!-- .form-group -->
                                    <div class="form-group required position-relative">
                                        <label for="user-password-confirm" class="sr-only">إعادة كلمة المرور</label>
                                        <input type="password"
                                               class="form-control form-control-lg pr-4"
                                               id="user-password-confirm"
                                               placeholder="إعادة كلمة المرور"
                                               name="c_password"
                                               value="<?=set_value('c_password')?>">
                                               <?php if(form_error('c_password'))echo form_error('c_password')?>
                                    </div><!-- .form-group -->
                                    <div class="form-group required position-relative">
                                        <select name="country_id" class="custom-select custom-select-lg pr-4">
                                          <?php foreach ($countries as $country) { ?>
                                             <option value="<?=$country->id?>" ><?=$country->name?></option>
                                          <?php } ?>
                                        </select>
                                    </div><!-- .form-group -->

                                    <div class="form-group required position-relative">
                                        <select name="city_id" class="custom-select custom-select-lg pr-4">
                                          <?php foreach ($cities as $city) { ?>
                                             <option value="<?=$city->id?>" ><?=$city->name?></option>
                                          <?php } ?>
                                        </select>
                                    </div><!-- .form-group -->

                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" checked class="custom-control-input"
                                               id="user-agreement">
                                        <label class="custom-control-label mr-4"
                                               for="user-agreement">الموافقة على إتفاقية الإستخدام</label>
                                    </div>
                                    <button type="submit"
                                            class="btn btn-lg text-white px-4 mt-3 float-left submit">تسجيل</button>

                                </form><!-- .register-form -->
                            </div>
                        </div>
                        <div id="vendor"
                             class="tab-pane fade <?php if($this->uri->segment(1) == 'site_merchant') echo 'active show' ?>"
                             aria-labelledby="vendor-register"
                             role="tabpanel">
                            <div class="vendor-register-form">
                                <form class="register-form mt-5" id="vendor-register-form" method="POST" action="<?=base_url('site_merchant/register')?>">
                                  <?php if ($this->session->flashdata('message')) { ?>
                                         <?=$this->session->flashdata('message');?>
                                  <?php } ?>
                                    <div class="form-group required position-relative">
                                        <label for="user-name" class="sr-only">الإسم</label>
                                        <input type="text"
                                               class="form-control form-control-lg pr-4"
                                               id="vendor-name"
                                               placeholder="الإسم"
                                               name="vendor_full_name"
                                               value="<?=set_value('vendor_full_name')?>">
                                               <?php if(form_error('vendor_full_name'))echo form_error('vendor_full_name')?>
                                    </div><!-- .form-group -->
                                    <div class="form-group required position-relative">
                                        <label for="user-mobile" class="sr-only">رقم الجوال</label>
                                        <input type="tel"
                                               class="form-control form-control-lg pr-4"
                                               id="vendor-mobile"
                                               placeholder="رقم الجوال"
                                               name="vendor_phone"
                                               value="<?=set_value('vendor_phone')?>">
                                               <?php if(form_error('vendor_phone'))echo form_error('vendor_phone')?>
                                    </div><!-- .form-group -->																		<div class="form-group required position-relative">                                            <label for="vendor-email" class="sr-only">البريد الإلكتروني</label>                                            <input type="text"                                                   class="form-control form-control-lg pr-4"                                                   id="vendor-email"                                                   name="email"                                                   value="<?=set_value('email')?>"                                                   placeholder="البريد الإلكتروني">                                                   <?php if(form_error('email'))echo form_error('email')?>                                        </div><!-- .form-group -->
                                    <div class="form-group required position-relative">
                                        <label for="user-name" class="sr-only">المتجر</label>
                                        <input type="text"
                                               class="form-control form-control-lg pr-4"
                                               id="vendor-name"
                                               placeholder="المتجر"
                                               name="vendor_store_name"
                                               value="<?=set_value('vendor_store_name')?>">
                                               <?php if(form_error('vendor_store_name'))echo form_error('vendor_store_name')?>
                                    </div><!-- .form-group -->
                                    <div class="form-group required position-relative">
                                        <label for="user-name" class="sr-only">اسم البنك</label>
                                        <input type="text"
                                               class="form-control form-control-lg pr-4"
                                               id="vendor-name"
                                               placeholder="اسم البنك"
                                               name="vendor_bank_name"
                                               value="<?=set_value('vendor_bank_name')?>">
                                               <?php if(form_error('vendor_bank_name'))echo form_error('vendor_bank_name')?>
                                    </div><!-- .form-group -->
                                    <div class="form-group required position-relative">
                                        <label for="user-name" class="sr-only">حساب ايبان</label>
                                        <input type="text"
                                               class="form-control form-control-lg pr-4"
                                               id="vendor-name"
                                               placeholder="حساب ايبان"
                                               name="vendor_iban_account"
                                               value="<?=set_value('vendor_iban_account')?>">
                                               <?php if(form_error('vendor_iban_account'))echo form_error('vendor_iban_account')?>
                                    </div><!-- .form-group -->
                                    <div class="form-group position-relative">
                                        <label for="user-name" class="sr-only">السجل التجاري</label>
                                        <input type="text"
                                               class="form-control form-control-lg pr-4"
                                               id="vendor-name"
                                               placeholder="السجل التجاري"
                                               name="vendor_commercial_register"
                                               value="<?=set_value('vendor_commercial_register')?>">
                                               <?php if(form_error('vendor_commercial_register'))echo form_error('vendor_commercial_register')?>
                                    </div><!-- .form-group -->
                                    <div class="form-group required position-relative">
                                        <label for="user-password" class="sr-only">كلمة المرور</label>
                                        <input type="password"
                                               class="form-control form-control-lg pr-4"
                                               id="vendor-password"
                                               placeholder="كلمة المرور"
                                               name="vendor_password"
                                               value="<?=set_value('vendor_password')?>">
                                               <?php if(form_error('vendor_password'))echo form_error('vendor_password')?>
                                    </div><!-- .form-group -->

                                    <div class="form-group required position-relative">
                                        <label for="user-password-confirm" class="sr-only">إعادة كلمة المرور</label>
                                        <input type="password"
                                               class="form-control form-control-lg pr-4"
                                               id="vendor-password-confirm"
                                               placeholder="إعادة كلمة المرور"
                                               name="vendor_c_password"
                                               value="<?=set_value('vendor_c_password')?>">
                                               <?php if(form_error('vendor_c_password'))echo form_error('vendor_c_password')?>
                                    </div><!-- .form-group -->
                                    <div class="form-group required position-relative">
                                        <select name="country_id" class="custom-select custom-select-lg pr-4">
                                            <?php foreach ($countries as $country) { ?>
                                             <option value="<?=$country->id?>" ><?=$country->name?></option>
                                          <?php } ?>
                                        </select>
                                    </div><!-- .form-group -->

                                    <div class="form-group required position-relative">
                                        <select name="city_id" class="custom-select custom-select-lg pr-4">
                                            <?php foreach ($cities as $city) { ?>
                                             <option value="<?=$city->id?>" ><?=$city->name?></option>
                                          <?php } ?>
                                        </select>
                                    </div><!-- .form-group -->


                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" checked
                                               class="custom-control-input"
                                               id="vendor-agreement">
                                        <label class="custom-control-label mr-4"
                                               for="vendor-agreement">الموافقة على إتفاقية الإستخدام</label>
                                    </div>
                                    <button type="submit"
                                            class="btn btn-lg text-white px-4 mt-3 float-left submit">تسجيل</button>

                                </form><!-- .register-form -->
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .row -->


        </div><!-- .container -->
    </div><!-- .page-content -->