<div class="page-content mb-5">
        <div class="container">
            <div class="page-header rounded p-3">
                <h1 class="page-title mb-auto">
                    <?=$title?>
                </h1>
            </div><!-- .page-header -->
            <div class="form-content my-5 py-5">
                <div class="row">
                    <div class="col-lg-8 col-md-10 col-12 mx-auto py-4 px-5 rounded form-wrap">
                        <h3 class="text-center"><?=$title?></h3>
                        <form class="password-form clearfix" method="POST">
                            <?php if ($this->session->flashdata('message')) { ?>
                               <?=$this->session->flashdata('message');?>
                            <?php } ?>
                            <div class="form-group">
                                <label for="confirm-code" class="col-form-label text-center d-block mt-2">
                                    أدخل رقم جوالك هنا حتى يتم إرسال الرمز المكون من ستة أرقام
                                </label>
                                <input type="text" value="<?=set_value('phone')?>" name="phone" class="form-control form-control-lg border-0 mt-4" id="confirm-code">
                            </div>
                            <button type="submit" class="btn btn-lg px-5 text-white float-left submit">
                                إرسال
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- .container -->
    </div><!-- .page-content -->