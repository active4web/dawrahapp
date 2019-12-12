<form class="edit-form" action="" method="POST" enctype="multipart/form-data">
<?php if ($this->session->flashdata('message')) { ?>
<?=$this->session->flashdata('message');?>
<?php } ?>
<div class="page-content mb-5">
        <div class="container">
            <div class="page-header rounded p-3">
                <h1 class="page-title mb-auto">
                    تعديل الملف الشخصي
                </h1>
            </div><!-- .page-header -->
            <!-- <div class="avatar-wrap my-5 position-relative">
                <img src="<?=base_url('assets/uploads/files/'.$merchant_data['image'])?>"
                     class="profile-avatar rounded-circle position-relative d-block mx-auto img-fluid"
                     width="179"
                     height="180"
                     alt="Vendor avatar">
            </div> -->
           <div class="row">
              <div class="col-md-6 mx-auto">
                  <div class="box-image rounded thumbnail ">
                      <img src="<?=base_url('assets/uploads/files/'.$merchant_data['image'])?>" id="image_upload_preview" class="img-fluid rounded-circle" style="width:170px; height:170px"
                      alt="Product image">
                      <input name="image" onchange="document.getElementById('image_upload_preview').src = window.URL.createObjectURL(this.files[0])" type="file" class="custom-file-input"  id="inputFile" style=" width:170px; height:170px;">
                  </div>
              </div>
          </div>
            <div class="row">
                <div class="col-lg-6 col-md-10 col-12 mx-auto">

                        <div class="form-group">
                            <label for="user-name" class="col-form-label pr-2">الاسم</label>
                            <input class="form-control form-control-lg pr-2 border-top-0 border-left-0 border-right-0 rounded-0"
                                   id="user-name"
                                   name="full_name"
                                   type="text" value="<?=$merchant_data['full_name']?>">
                        </div><!-- .form-group -->
						
						<div class="form-group">
                            <label for="user-email" class="col-form-label pr-2">البريد الإلكتروني</label>
                            <input class="form-control form-control-lg pr-2 border-top-0 border-left-0 border-right-0 rounded-0"
                                   id="user-email"
                                   name="email"
                                   type="text" value="<?=$merchant_data['email']?>">
								   <?php if(form_error('email'))echo form_error('email')?>
                        </div><!-- .form-group -->

                        <div class="form-group">
                            <label for="user-store" class="col-form-label pr-2">اسم المتجر</label>
                            <input class="form-control form-control-lg pr-2 border-top-0 border-left-0 border-right-0 rounded-0"
                                   id="user-store"
                                   name="store_name"
                                   type="text" value="<?=$merchant_data['store_name']?>">
                        </div><!-- .form-group -->
                        <div class="form-group">
                            <label for="user-country" class="col-form-label pr-2">الدولة</label>
                            <select id="user-country" name="country_id"
                                    class="custom-select pr-2 border-top-0 border-left-0 border-right-0 rounded-0">
                              <?php foreach ($countries as $country) { ?>   
                                <option <?php if($merchant_data['country_id'] == $country->id) echo 'selected' ?> value="<?=$country->id?>"><?=$country->name?></option>
                              <?php } ?>
                            </select>
                        </div><!-- .form-group -->

                        <div class="form-group">
                            <label for="user-town" class="col-form-label pr-2">المدينة</label>
                            <select id="user-town" name="city_id" 
                                    class="custom-select pr-2 border-top-0 border-left-0 border-right-0 rounded-0">
                              <?php foreach ($cities as $city) { ?>   
                                <option <?php if($merchant_data['city_id'] == $city->id) echo 'selected' ?> value="<?=$city->id?>"><?=$city->name?></option>
                              <?php } ?>
                            </select>
                        </div><!-- .form-group -->

                        <div class="form-group">
                            <label for="user-password" class="col-form-label pr-2">كلمة المرور</label>
                            <input class="form-control form-control-lg pr-2 border-top-0 border-left-0 border-right-0 rounded-0"
                                   id="user-password"
                                   name="password" 
                                   type="password" value="">
                        </div><!-- .form-group -->
                        <div class="form-group">
                            <label for="user-phone" class="col-form-label pr-2">رقم الجوال</label>
                            <input class="form-control form-control-lg pr-2 border-top-0 border-left-0 border-right-0 rounded-0 font-tahoma"
                                   id="user-phone"
                                   name="phone"
                                   type="tel" value="<?=$merchant_data['phone']?>">
                        </div><!-- .form-group -->

                        <!-- <div class="text-center my-5">
                            <button type="reset" class="btn btn-lg reset px-3 px-sm-5 text-white"> إعادة تفعيل الجوال</button>
                        </div> -->
                        <div class="text-right my-5">

                            <a href="<?=base_url('site_merchant/edit_profile/phone')?>" class="text-body no-decoration">تعديل رقم الجوال ؟</a>

                        </div>
                        <p class="lead text-center font-weight-bold">طرق التوصيل</p>
                        <?php $i = 0 ;
                         foreach ($delivering_methods as $method) { 
                          $merchant_method = get_this('merchants_delivering_methods',['merchant_id'=>$merchant_data['id'],'method_id'=>$method->id]) ?>
                          <div class="custom-control custom-checkbox bg-gradient border rounded px-2 py-4">
                              <div class="d-flex justify-content-between align-items-center">
                                  <div class="w-50">
                                      <input type="checkbox"
                                             name="<?='method'.'['.$i.']'.'[id]'?>"
                                             value="<?=$method->id?>"
                                             class="custom-control-input"
                                             id="customCheck<?=$i?>"
                                             <?php if($merchant_method['id']) echo 'checked' ?>>
                                      <label class="custom-control-label pr-5"
                                             for="customCheck<?=$i?>"><?=$method->name?></label>
                                  </div>
                                  <div class="form-inline justify-content-end">
                                      <input type="text"
                                             name="<?='method'.'['.$i.']'.'[price]'?>"
                                             class="form-control w-25 d-inline border"
                                             id="cost<?=$i?>"
                                             value="<?=($merchant_method['id']) ? $merchant_method['price'] : '00.00';?>">
                                      <label for="cost<?=$i?>" class="mr-3 col-form-label">ريال</label>
                                  </div>
                              </div>  
                          </div>
                        <?php 
                          $i++;
                        } ?>
                        <div class="text-center my-5">
                            <button type="submit"

                                    class="btn btn-lg reset px-3 px-sm-5 text-white">

                                تعديل

                            </button>
                        </div>

                </div>
            </div>
        </div><!-- .container -->
    </div><!-- .page-content -->
</form><!-- .edit-form -->