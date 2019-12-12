



<!-- Page-header start -->

<div class="page-header card">

   <div class="card-block">

      <h5 class="m-b-10">عرض المنتج</h5>

      <ul class="breadcrumb-title b-t-default p-t-10">

         <li class="breadcrumb-item">

            <a href="<?=base_url('admin_panel/dashboard')?>">الرئيسية</a>

         </li>

         <li class="breadcrumb-item"><a href="<?=base_url('admin_panel/product')?>">المنتجات</a>

         </li>

         <li class="breadcrumb-item"><a>عرض المنتج</a>

         </li>

      </ul>

   </div>

</div>

<!-- Page-header end -->

<div class="page-body">

   <div class="row">

      <div class="col-md-12">

         <!-- Product detail page start -->

         <div class="card product-detail-page">

            <div class="card-block">

               <div class="row">

                  <div class="col-lg-5 col-xs-12" style="direction: ltr !important">

                     <div class="port_details_all_img row">

                        <div class="col-lg-12 m-b-15" style="direction: ltr !important">

                           <div id="big_banner">

                              <?php foreach ($product_images as $img) { ?>

                              <div class="port_big_img">

                                 <img class="img img-fluid single-item-rtl" src="<?=base_url('assets/uploads/files/'.$img->image_name)?>" alt="Big_ Details">

                              </div>

                              <?php } ?>

                           </div>

                        </div>

                        <div class="col-lg-12 product-right" style="direction: ltr !important">

                           <div id="small_banner"  style="direction: ltr !important">

                              <?php foreach ($product_images as $img) { ?>

                              <div style="direction: ltr !important">

                                 <img class="img img-fluid" src="<?=base_url('assets/uploads/files/'.$img->image_name)?>" alt="small-details">

                              </div>

                              <?php } ?>

                           </div>

                        </div>

                     </div>

                  </div>

                  <div class="col-lg-7 col-xs-12 product-detail" id="product-detail">

                     <div class="row">

                        <div>

                           <div class="col-lg-12">

                              <span class="txt-muted d-inline-block">اسم المنتج: <a><?=$product['name']?></a></span>

                              <span class="f-left" style="margin-right: 30px">الكمية المتاحة من المنتج: <a> <?=$product['available_quantity']?> قطعة</a> </span>

                           </div>

                           <div class="col-lg-12">

                              <h4 class="pro-desc">اسم المتجر: <?=get_this('merchants',['id'=>$product['created_by']],'store_name')?></h4>

                           </div>

                           <div class="col-lg-12">

                              <span class="txt-muted">تصنيف المنتج: <?=get_this('categories',['id'=>$product['category_id']],'name')?> </span>

                           </div>

                           <div class="stars stars-example-css m-t-15 detail-stars col-lg-12">تقييم المنتج: 

                              <?php for ($i=5; $i >=1 ; $i--) { 

                                 if ($i <= $rate) { ?>

                              <i class="icofont icofont-star" style="color: #FFB64D"></i>

                              <?php }else{ ?>

                              <i class="icofont icofont-star"></i>

                              <?php } 

                                 } ?>

                           </div>

                           <div class="col-lg-12">

                              سعر المنتج: <span style="margin-right: 0px !important" class="text-primary product-price"><i class="icofont icofont-cur-riyal "></i> <?=$product['price']?></span>

                              <hr>

                              وصف المنتج: 

                              <p><?=$product['description']?></p>

                              <hr>

                           </div>

                        </div>

                     </div>

                  </div>

               </div>

            </div>

         </div>

         <!-- Product detail page end -->

      </div>

   </div>

   <!-- Nav tabs start-->

   <div class="tab-header card">

      <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">

         <li class="nav-item">

            <a class="nav-link active" data-toggle="tab" href="#personal" role="tab">عرض معلومات التاجر</a>

            <div class="slide"></div>

         </li>

         <li class="nav-item">

            <a class="nav-link" data-toggle="tab" href="#review" role="tab">عرض  التعليقات</a>

            <div class="slide"></div>

         </li>

         <li class="nav-item">

            <a class="nav-link" data-toggle="tab" href="#rate" role="tab">عرض  التقييمات</a>

            <div class="slide"></div>

         </li>

      </ul>

   </div>

   <!-- Nav tabs start-->

   <!-- Nav tabs card start-->

   <div class="tab-content">

      <!-- tab panel personal start -->

      <div class="tab-pane active" id="personal" role="tabpanel">

         <!-- personal card start -->

         <div class="card">

            <div class="card-block">

               <div class="view-info">

                  <div class="row">

                     <div class="col-lg-12">

                        <div class="general-info">

                           <div class="row">

                              <div class="col-lg-12 col-xl-6">

                                 <div class="table-responsive">

                                    <table class="table m-0">

                                       <tbody>

                                          <tr>

                                             <th scope="row">الاسم بالكامل</th>

                                             <td><?=$merchant['full_name']?></td>

                                          </tr>

                                          <tr>

                                             <th scope="row">اسم المتجر</th>

                                             <td><?=$merchant['store_name']?></td>

                                          </tr>

                                          <tr>

                                             <th scope="row">الدولة</th>

                                             <td><?=$country?></td>

                                          </tr>

                                          <tr>

                                             <th scope="row">المدينة</th>

                                             <td><?=$city?></td>

                                          </tr>

                                          <tr>

                                             <th scope="row">البريد الالكتروني</th>

                                             <td><a><?=$merchant['email']?></a></td>

                                          </tr>

                                          <tr>

                                             <th scope="row">حالة الحساب</th>

                                             <td>

                                                <?php if ($merchant['status'] == 2) { ?>

                                                <label class="label label-success">حساب مفعل</label>

                                                <?php }else{ ?>

                                                <label class="label label-danger">حساب غير مفعل</label>

                                                <?php } ?>

                                             </td>

                                          </tr>

                                       </tbody>

                                    </table>

                                 </div>

                              </div>

                              <!-- end of table col-lg-6 -->

                              <div class="col-lg-12 col-xl-6">

                                 <div class="table-responsive">

                                    <table class="table">

                                       <tbody>

                                          <tr>

                                             <th scope="row">رقم الجوال</th>

                                             <td><?=$merchant['phone']?></td>

                                          </tr>

                                          <tr>

                                             <th scope="row">اسم البنك</th>

                                             <td><?=$merchant['bank_name']?></a></td>

                                          </tr>

                                          <tr>

                                             <th scope="row">حساب ايبان</th>

                                             <td><?=$merchant['iban_account']?></td>

                                          </tr>

                                          <tr>

                                             <th scope="row">السجل التجاري</th>

                                             <td><?php if(!empty($merchant['commercial_register'])){ echo $merchant['commercial_register'];}else{ echo 'لا يوجد';}?></td>

                                          </tr>

                                          <tr>

                                             <th scope="row">الرصيد</th>

                                             <td><?=$merchant['credit']?> ريال</td>

                                          </tr>

                                          <tr>

                                             <th scope="row">تاريخ التسجيل</th>

                                             <td><?=$merchant['created_at']?></td>

                                          </tr>

                                       </tbody>

                                    </table>

                                 </div>

                              </div>

                              <!-- end of table col-lg-6 -->

                           </div>

                           <!-- end of row -->

                        </div>

                        <!-- end of general info -->

                     </div>

                     <!-- end of col-lg-12 -->

                  </div>

                  <!-- end of row -->

               </div>

            </div>

            <!-- end of card-block -->

         </div>

         <!-- personal card end-->

      </div>

      <div class="tab-pane" id="review" role="tabpanel">

         <div class="card">

            <div class="card-block">

               <ul class="media-list">

                  <?php foreach ($comments as $comment) { 

                     $user = get_this('customers',['id'=>$comment->user_id])?>

                     <li class="media">

                        <div class="media-left">

                           <?php if(!empty($user['image'])){ ?>

                           <a>

                           <img class="media-object img-radius comment-img" src="<?=base_url('assets/uploads/files/'.$user['image'])?>" alt="Generic placeholder image">

                           </a>

                           <?php }else{?>

                           <a>

                           <img class="media-object img-radius comment-img" src="<?=base_url('assets/uploads/files/man.png')?>" alt="Generic placeholder image">

                           </a>

                           <?php } ?>

                        </div>

                        <div class="media-body" style="padding-right: 20px;">

                           <h6 class="media-heading"><?=$user['full_name']?><span class="f-12 text-muted m-l-5" style="padding-right: 5px;"><?=$comment->created_at?></span></h6>

                           <!-- <div class="stars-example-css review-star">

                              <i class="icofont icofont-star"></i>

                              <i class="icofont icofont-star"></i>

                              <i class="icofont icofont-star"></i>

                              <i class="icofont icofont-star"></i>

                              <i class="icofont icofont-star"></i>

                           </div> -->

                           <p class="m-b-0"><?=$comment->comment?></p>

                           <hr>

                        </div>

                     </li>

                  <?php } ?>

               </ul>

            </div>

         </div>

      </div>

      <!-- tab pane personal end -->

      <!-- tab pane info start -->

      <!-- tab pane info end -->

       <div class="tab-pane" id="rate" role="tabpanel">

         <div class="card">

            <div class="card-block">

               <ul class="media-list">

                  <?php foreach ($rates as $rate) { 

                     $user = get_this('customers',['id'=>$rate->user_id])?>

                     <li class="media">

                        <div class="media-left">

                           <?php if(!empty($user['image'])){ ?>

                           <a>

                           <img class="media-object img-radius comment-img" src="<?=base_url('assets/uploads/files/'.$user['image'])?>" alt="Generic placeholder image">

                           </a>

                           <?php }else{?>

                           <a>

                           <img class="media-object img-radius comment-img" src="<?=base_url('assets/uploads/files/man.png')?>" alt="Generic placeholder image">

                           </a>

                           <?php } ?>

                        </div>

                        <div class="media-body" style="padding-right: 20px;">

                           <h6 class="media-heading"><?=$user['full_name']?><span class="f-12 text-muted m-l-5" style="padding-right: 5px;"><?=$rate->created_at?></span></h6>

                           <div class="stars-example-css review-star">

                               <?php for ($i=5; $i >=1 ; $i--) { 

                                 if ($i <= $rate->rate) { ?>

                                     <i class="icofont icofont-star" style="color: #FFB64D"></i>

                                  <?php }else{ ?>

                                     <i class="icofont icofont-star" style="color: black"></i>

                                  <?php } 

                                } ?>   

                           </div>

                           <hr>

                        </div>

                     </li>

                  <?php } ?>

               </ul>

            </div>

         </div>

      </div>

   </div>

   <!-- Nav tabs card end-->

</div>



