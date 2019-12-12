<div class="page-content mb-5">
        <div class="container">
            <div class="page-header rounded p-3">
                <h1 class="page-title mb-auto">
                    تعديل الملف الشخصي
                </h1>
            </div><!-- .page-header -->
            <div class="avatar-wrap my-5 position-relative">
                <img style="width: 179px; height: 180px" src="<?=base_url('assets/uploads/files/'.$user_data['image'])?>"
                     class="profile-avatar rounded-circle position-relative d-block mx-auto img-fluid"
                     alt="Vendor avatar">
            </div>						<div class="col-lg-6 col-md-10 col-12 mx-auto">				<div class="form-group">					<input type="file" name="image" class="btn btn-sm reset px-3 px-sm-5 text-white"/>				</div>            </div>
            <div class="row">
                <div class="col-lg-6 col-md-10 col-12 mx-auto">
                    <form class="edit-form" method="POST">
                        <?php if ($this->session->flashdata('message')) { ?>
                           <?=$this->session->flashdata('message');?>
                        <?php } ?>
                        <div class="form-group">
                            <label for="user-name" class="col-form-label pr-2">الاسم</label>
                            <input class="form-control form-control-lg pr-2 border-top-0 border-left-0 border-right-0 rounded-0"
                                   id="user-name"
                                   name="full_name" 
                                   type="text" value="<?=$user_data['full_name']?>">
                        </div><!-- .form-group -->
                        <div class="form-group">
                            <label for="user-country" class="col-form-label pr-2">الدولة</label>
                            <select id="user-country" name="country_id" 
                                    class="custom-select pr-2 border-top-0 border-left-0 border-right-0 rounded-0">
                               <?php foreach ($countries as $country) { ?>
                                <option value="<?=$country->id?>" <?php if($user_data['country_id'] == $country->id){echo 'selected';} ?>><?=$country->name?></option>
                               <?php } ?>     
                            </select>
                        </div><!-- .form-group -->
                        <div class="form-group">
                            <label for="user-town" class="col-form-label pr-2">المدينة</label>
                            <select id="user-town" name="city_id" 
                                    class="custom-select pr-2 border-top-0 border-left-0 border-right-0 rounded-0">
                                <?php foreach ($cities as $city) { ?>
                                <option value="<?=$city->id?>" <?php if($user_data['city_id'] == $city->id){echo 'selected';} ?>><?=$city->name?></option>
                               <?php } ?>   
                            </select>
                        </div><!-- .form-group -->
                        <div class="form-group">
                            <label for="user-password" class="col-form-label pr-2">كلمة المرور</label>
                            <input class="form-control form-control-lg pr-2 border-top-0 border-left-0 border-right-0 rounded-0"
                                   id="user-password"
                                   name="password"
                                   type="password">
                        </div><!-- .form-group -->
                        <div class="form-group">
                            <label for="user-phone" class="col-form-label pr-2">رقم الجوال</label>
                            <input style="color: grey;" class="form-control form-control-lg pr-2 border-top-0 border-left-0 border-right-0 rounded-0 font-tahoma"
                                   id="user-phone" disabled
                                   type="tel" value="<?=$user_data['phone']?>">
                        </div><!-- .form-group -->
                        <div class="text-right my-5">
                            <a href="<?=base_url('site_user/edit_profile/phone')?>" class="text-body no-decoration">تعديل رقم الجوال ؟</a>
                        </div>
                        <div class="text-center my-5">
                            <button type="submit"
                                    class="btn btn-lg reset px-3 px-sm-5 text-white">
                                تعديل
                            </button>
                        </div>
                        <!-- <div class="text-center my-5">
                            <a href="<?=base_url('edit_profile/phone')?>" class="text-body no-decoration">تعديل رقم الجوال ؟</a>
                        </div> -->
                    </form><!-- .edit-form -->
                </div>
            </div>
        </div><!-- .container -->
    </div><!-- .page-content -->