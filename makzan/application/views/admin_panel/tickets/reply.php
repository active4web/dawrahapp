<!-- Page-header start -->
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10"><?=$title?></h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item">
            <a href="<?=base_url('admin_panel/dashboard')?>">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="<?=base_url('admin_panel/tickets')?>"><?=$title?></a>
         </li>
         <li class="breadcrumb-item"><a>عرض التذكرة</a>
         </li>
      </ul>
   </div>
</div>
<!-- Page-header end -->
<div class="page-body">
   <?php if ($this->session->flashdata('message')) { ?>
     <?=$this->session->flashdata('message');?>
  <?php } ?>
   <div class="row">
      <div class="col-md-12">
         <div class="">
            <div class="row timeline-right p-t-35">
               <div class="col-2 col-sm-2 col-xl-1">
                  <!-- <div class="">
                     <img class="img-radius timeline-icon" src="<?=base_url()?>assets/admin_panel/images/avatar-2.jpg" alt="">
                  </div> -->
               </div>
               <div class="col-10 col-sm-10 col-xl-11 p-l-5 p-b-35">
                  <div class="card">
                     <div class="card-block post-timelines">
                        <!-- <span class="dropdown-toggle addon-btn text-muted f-left service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip"></span>
                        <div class="dropdown-menu dropdown-menu-left b-none services-list">
                           <a class="dropdown-item" href="#">حذف التذكرة</a>
                           <a class="dropdown-item" href="#">رجوع</a>
                        </div> -->
                        <div class="chat-header f-w-600"><?php if($ticket['type'] == 0){ echo get_this('merchants',['id'=>$ticket['created_by']],'full_name');}else{ echo get_this('customers',['id'=>$ticket['created_by']],'full_name');} ?></div>
                        <div class="social-time text-muted"><?=$ticket['created_at']?></div>
                     </div>
                     <div class="card-block">
                        <div class="timeline-details">
                           <div class="chat-header"><?=$ticket_type?></div>
                           <p class="text-muted"><?=$ticket['content']?></p>
                        </div>
                     </div>
                     <div class="card-block b-b-theme b-t-theme social-msg">
                        <a> <i class="icofont icofont-comment text-muted"></i> <span class="b-r-muted">الردود <?=$replys_conut?></span></a>
                     </div>
                     <div class="card-block user-box">
                        <div class="p-b-30"><span class="f-right">عرض جميع الردود</span></div>
                     <?php foreach ($ticket_replys as $reply) { ?>   
                        <div class="media m-b-20">
                           <a class="media-left" href="#">
                           <img class="media-object img-radius m-r-20" src="<?=base_url()?>assets/admin_panel/images/avatar-1.jpg" alt="Generic placeholder image">
                           </a>
                           <div class="media-body b-b-muted social-client-description" style="padding-right: 20px;">
                              <div class="chat-header"><?php if($reply->reply_type == 0){echo get_this('merchants',['id'=>$reply->created_by],'full_name');}elseif($reply->reply_type == 1){echo get_this('customers',['id'=>$reply->created_by],'full_name');}else{echo 'ادارة التطبيق';}?><span class="text-muted" style="padding-right: 5px;"><?=$reply->created_at?></span></div>
                              <p class="text-muted"><?=$reply->content?></p>
                           </div>
                        </div>
                     <?php } ?>
                        <div class="media">
                           <a class="media-left" href="#">
                           <img class="media-object img-radius m-r-20" src="<?=base_url()?>assets/admin_panel/images/user.png" alt="Generic placeholder image">
                           </a>
                           <div class="media-body" style="padding-right: 20px;">
                              <form action="" method="POST" >
                                 <div class="">
                                    <textarea rows="5" name="content" cols="5" class="form-control"></textarea>
                                    <div class="text-right m-t-20"> <button style="width: 63px" type="submit" class="btn btn-md btn-success">رد</button>  <a href="<?=base_url('admin_panel/users')?>" class="btn btn-md btn-danger">رجوع</a></div>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

