 <div class="page-content mb-5">
        <div class="container">
            <div class="page-header rounded p-3">
                <h1 class="page-title mb-auto">
                    الرصيد
                </h1>
            </div><!-- .page-header -->
            <?php if ($this->session->flashdata('message')) { ?>
                   <?=$this->session->flashdata('message');?>
            <?php } ?>
            <div class="balance-wrap">
                <div class="fa-10x text-center">
                    <span class="fa-layers fa-fw">
                        <i class="fas fa-circle" style="color:Tomato"></i>
                        <i class="fa-inverse fas fa-money-bill-alt"
                           data-fa-transform="shrink-10"></i>
                    </span>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-9 mx-auto">
                            <div class="balance-row mt-3 p-3 d-flex flex-column flex-wrap">
                                <div class="d-flex align-items-center justify-content-around">
                                    <p class="mb-0 withdraw-request">
                                        الرصيد
                                    </p>
                                    <i class="mx-2  d-sm-block"></i>
                                    <p class="mb-0 h3">
                                        <span class="colored number"><?=$merchant_credit?></span>
                                        <span class="text-gray">ريال</span>
                                    </p>
                                </div>
                                <p class="mt-3 text-center text-gray">
                                    يرجى العلم بأن الحد الأدني لسحب الرصيد 1000 ريال
                                </p>
                                <form method="POST" class="register-form mt-5">
                                    <input type="فثءف" name="quantity" value="<?=set_value('quantity')?>" class="form-control form-control-lg pr-4" id="user-name" placeholder="ادخل الكمية المراد سحبها">
                                    <!-- <button type="submit"
                                            class="btn btn-block submit position-relative text-white font-weight-bold py-3">
                                        إرسال طلب سحب رصيد
                                    </button> -->
                                    <button type="submit" class="btn btn-lg text-white px-4 mt-3 float-left submit">إرسال </button>
                                </form>
                            </div>
                    </div><!-- .col-* -->
                </div><!-- .row -->
            </div><!-- .balance-wrap -->
        </div><!-- .container -->
    </div><!-- .page-content -->