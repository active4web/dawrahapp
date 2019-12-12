<div class="page-content mb-5">

        <div class="container">

            <div class="page-header rounded px-3 py-2 d-flex justify-content-between align-items-center">

                <h1 class="page-title mb-auto">

                    التذاكر

                </h1>

                <a href="<?=base_url('site_merchant/tickets')?>" class="btn px-3 text-white">

                    إنشاء تذكرة جديده

                </a>

            </div><!-- .page-header -->

            <div class="row mt-5">

                <?php foreach ($my_tickets as $ticket) { ?>

                <div class="col-lg-6 col-12">

                    <div class="ticket-content light rounded mb-4 p-3 p-md-5">

                        <div class="d-sm-flex justify-content-sm-between">

                            <h5 class="client-title colored font-weight-bold">

                                <?=$merchant_data['full_name']?>

                            </h5>

                            <div class="ticket-date">

                                <i class="far fa-clock date-icon ml-1" aria-hidden="true"></i>

                                <span class="number"><?=$ticket->created_at?></span>

                            </div>

                        </div>

                        <a href="<?=base_url('site_merchant/tickets/ticket/'.$ticket->id)?>" style="text-decoration: none; color: black">

                        <p class="lead mt-3 mb-auto">

                            <?=$ticket->content?>

                        </p>

                        </a>

                    </div><!-- .ticket-content light -->

                </div>

                <?php } ?>

            </div>

        </div><!-- .container -->

    </div><!-- .page-content -->