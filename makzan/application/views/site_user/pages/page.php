 <div class="page-content mb-5">
        <div class="container">
            <div class="page-header rounded p-3">
                <h1 class="page-title mb-auto">
                    الصفحات الفرعية
                </h1>
            </div><!-- .page-header -->
            <article class="entry py-5">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <img src="<?=base_url()?>/assets/uploads/files/<?=$page['image']?>" class="img-fluid d-block mx-auto" width="570" height="333" alt="Post thumbnail">
                        <h2 class="entry-title mt-4 mb-auto"><?=$page['title']?></h2>
                    </div>
                    <div class="col-lg-8 mx-auto">
                        <div class="entry-content mt-5">
                            <p class="text-justify">
                               <?=$page['content']?>
                            </p>
                        </div>
                    </div>
                </div>
            </article>
        </div><!-- .container -->
    </div><!-- .page-content -->