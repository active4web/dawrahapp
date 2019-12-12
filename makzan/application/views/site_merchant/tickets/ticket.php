 <div class="page-content mb-5">

        <div class="container">

            <div class="page-header rounded px-3 py-2 d-flex justify-content-between align-items-center">

                <h1 class="page-title mb-0">

                    <?=$title?>

                </h1>

                <a href="<?=base_url('site_merchant/tickets')?>" class="btn px-3 text-white">

                    إنشاء تذكرة جديده

                </a>

            </div><!-- .page-header -->



            <div class="ticket-content rounded mt-5 p-3 p-lg-5">

                <div class="row">

                    <div class="col-lg-6 col-md-8 col-12">

                        <h5 class="client-title font-weight-bold">

                            <?=$merchant_data['full_name']?>

                        </h5>

                        <p class="mt-4">

                            <?=$ticket_type?>

                        </p>

                        <p class="mt-3 pl-5">

                            <?=$ticket['content']?>

                        </p>

                    </div>

                    <div class="col-lg-6 col-md-4 col-12 justify-content-end d-flex">

                        <div class="ticket-date">

                            <i class="far fa-clock date-icon ml-1" aria-hidden="true"></i>

                            <span class="number"><?=$ticket['created_at']?></span>

                        </div>

                    </div>

                </div>

            </div><!-- .ticket-content -->

            <div class="comments mt-5">

                <div class="comments-header">

                    <a href="#" class="btn btn-lg comments-count px-3 px-sm-5">

                        عدد الردود <span class="number font-weight-bold"><?=$ticket_replys_count?></span>

                    </a>

                </div><!-- .comments-header -->

                <?php foreach ($ticket_replys as $reply) { ?>

                    <div class="comment-box d-flex rounded px-4 py-5 mt-5">

                        <div class="separator ml-4">

                            <img src="<?=base_url()?>/assets/site_user/img/comments-separator.png" width="28" height="181" alt="Separator">

                        </div><!-- .separator -->

                        <div class="comment">

                            <h5 class="comment-title font-weight-bold">

                                <?php if($reply->reply_type == 2){ echo 'خدمة العملاء'; }else{ echo $merchant_data['full_name']; } ?>

                            </h5>

                            <div class="comment-date mt-2">

                                <i class="far fa-clock date-icon ml-1" aria-hidden="true"></i>

                                <span class="number"><?=$reply->created_at?></span>

                            </div>

                            <div class="comment-content mt-2">

                                <div class="row">

                                    <div class="col-lg-6 col-12">

                                        <p class="mb-auto">

                                           <?=$reply->content?>

                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div><!-- .comment -->

                    </div><!-- .comment-box -->

                <?php } ?>

                <a class="btn btn-lg px-4 mt-5 text-white new-reply">إضافة رد جديد</a>

                <form method="POST" action="<?=base_url('site_merchant/tickets/reply/'.$ticket['id'])?>" class="reply-form mt-5 clearfix">

                    <?php if ($this->session->flashdata('message')) { ?>

                           <?=$this->session->flashdata('message');?>

                    <?php } ?>

                    <div class="form-group">

                        <label for="exampleFormControlTextarea1" class="sr-only">النص هنا</label>

                        <textarea name="reply" class="form-control border-0" id="exampleFormControlTextarea1" rows="4"><?=set_value('reply')?></textarea>

                    </div>

                    <button type="submit" class="btn px-4 mt-3 bg-white font-weight-bold submit float-left">إرسال</button>

                </form><!-- .reply-form -->

            </div><!-- .comments -->

        </div><!-- .container -->

    </div><!-- .page-content -->