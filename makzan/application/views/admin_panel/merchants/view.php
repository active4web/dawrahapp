<!-- Page-header start -->
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10">اصحاب المتاجر</h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item">
            <a href="<?=base_url('admin_panel/dashboard')?>">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="<?=base_url('admin_panel/merchants')?>">اصحاب المتاجر</a>
         </li>
         <li class="breadcrumb-item"><a>عرض</a>
         </li>
      </ul>
   </div>
</div>
<!-- Page-header end -->
<div class="page-body">
   <!--profile cover start-->
   <div class="row">
      <div class="col-lg-12">
         <div class="cover-profile">
            <div class="profile-bg-img">
               <img class="profile-bg-img img-fluid" src="<?=base_url()?>assets/admin_panel/images/user-profile/bg-img1.jpg" alt="bg-img">
               <div class="card-block user-info">
                  <div class="col-md-12">
                     <div class="media-left">
                        <a href="#" class="profile-image">
                        <img style="height: 108px; width: 108px" class="user-img img-radius" src="<?=base_url('assets/uploads/files/'.$merchant['image'])?>" alt="user-img">
                        </a>
                     </div>
                     <div class="media-body row">
                        <div class="col-lg-12">
                           <div class="user-title">
                              <h2><?=$merchant['full_name']?></h2>
                              <span class="text-white"><?=$merchant['store_name']?></span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!--profile cover end-->
   <div class="row">
      <div class="col-lg-12">
         <!-- tab header start -->
         <div class="tab-header card">
            <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
               <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#personal" role="tab">المعلومات الشخصية</a>
                  <div class="slide"></div>
               </li>
               <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#binfo" role="tab">منتجات التاجر</a>
                  <div class="slide"></div>
               </li>
               <!-- <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#contacts" role="tab">User's Contacts</a>
                  <div class="slide"></div>
               </li> -->
               <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#review" role="tab">التذاكر</a>
                  <div class="slide"></div>
               </li>
            </ul>
         </div>
         <!-- tab header end -->
         <!-- tab content start -->
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
                                                      <?php if ($merchant['confirmed'] == 1) { ?>
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
            <!-- tab pane personal end -->
            <!-- tab pane info start -->
            <div class="tab-pane" id="binfo">
                <div class="row">
                  <?php foreach ($products as $product) { ?>
                    <div class="col-lg-12 col-xl-6">
                        <div class="card">
                            <div class="card-block post-timelines">
                                <span style="float: left;" class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip"></span>
                                <div class="dropdown-menu dropdown-menu-left b-none services-list">
                                    <a class="dropdown-item" href="<?=base_url('admin_panel/products/view/'.$product->id)?>">عرض المنتج</a>
                                </div>
                                <div class="media bg-white d-flex">
                                    <div class="media-left media-middle">
                                        <a href="<?=base_url('admin_panel/products/view/'.$product->id)?>">
                                    <img style="width: 128px; height: 128px;" class="media-object" src="<?=base_url('assets/uploads/files/'.$product->main_image)?>" alt="">
                                </a>
                                    </div>
                                    <div class="media-body friend-elipsis" style="padding-right: 20px;">
                                        <div class="f-15 f-bold m-b-5"><?=$product->name?></div>
                                        <div class="text-muted social-designation"><?=word_limiter($product->description,20)?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 <?php } ?>
                </div>
            </div>
            <!-- tab pane info end -->
            <div class="tab-pane" id="review" role="tabpanel">
               <div class="card">
                  <div class="card-block">
                     <ul class="media-list">
                        <?php foreach ($tickets as $ticket) { ?>
                           <li class="media">
                              <div class="media-left">
                                 <a href="#">
                                 <img class="media-object img-radius comment-img" src="<?=base_url()?>assets/uploads/files/ticket-office.png">
                                 </a>
                              </div>
                              <div class="media-body" style="padding-right: 20px;">
                                 <h6 class="media-heading"><?=get_this('merchants',['id'=>$ticket->created_by],'full_name')?><span class="f-12 text-muted m-l-5" style="padding-right: 5px;"><?=$ticket->created_at?></span></h6>
                                 <p class="m-b-0"><?=$ticket->content?></p>
                                 <hr>
                                 <!-- Nested media object -->
                                 <?php $replies = get_table('tickets_replies',['ticket_id'=>$ticket->id, 'reply_type !='=>1]);
                                 foreach ($replies as $reply) { ?>
                                    <div class="media mt-2">
                                       <a class="media-left" href="#">
                                       <img class="media-object img-radius comment-img" src="<?=base_url()?>assets/uploads/files/reply.png">
                                       </a>
                                       <div class="media-body" style="padding-right: 20px;">
                                          <h6 class="media-heading"><?php if($reply->reply_type == 0) echo get_this('merchants',['id'=>$reply->created_by],'full_name'); else echo'ادارة التطبيق';?><span style="padding-right: 5px;" class="f-12 text-muted m-l-5"><?=$reply->created_at?></span></h6>
                                          <p class="m-b-0"><?=$reply->content?></p>
                                          <hr>
                                       </div>
                                    </div>
                                 <?php } ?>
                              </div>
                           </li>
                        <?php } ?>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
         <!-- tab content end -->
      </div>
   </div>
</div>