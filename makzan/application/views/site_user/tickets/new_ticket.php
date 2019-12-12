<div class="page-content mb-5">
        <div class="container">
            <div class="page-header rounded p-3">
                <h1 class="page-title mb-0">
                    إنشاء تذكرة جديده
                </h1>
            </div><!-- .page-header -->

            <div class="form-content text-center">
                <h3 class="my-5">نوع المراسلة</h3>
                <form class="contact-form" method="POST">
                	<?php if ($this->session->flashdata('message')) { ?>
                           <?=$this->session->flashdata('message');?>
                    <?php } ?>
                	<?php 
                	$i=1;
                	foreach ($tickets_types as $type) { ?>
                    <div class="custom-control custom-radio custom-control-inline <?php if($i == 1) echo 'checked';?> px-5 py-2 mb-2">
                        <label class="form-label mb-auto pr-3 <?php if($i == 1) echo 'text-white';?>" for="customRadioInline<?=$i?>"><?=$type->name?>
                            <input type="radio" value="<?=$type->id?>" id="customRadioInline<?=$i?>" name="ticket_type_id" <?php if($i == 1) echo'checked="checked"'?>>
                            <span class="radio-btn mr-3 position-absolute rounded-circle"></span>
                        </label>
                    </div>
                	<?php 
                	$i++;
                    } ?>
                    <div class="mt-5 clearfix">
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1" class="sr-only">النص هنا</label>
                            <textarea name="content" class="form-control text-area p-3" id="exampleFormControlTextarea1" rows="7"
                                placeholder="النص هنا"><?=set_value('content')?></textarea>
                                <?php if(form_error('content'))echo form_error('content')?>
                        </div><!-- .form-group -->
                        <button type="submit" class="btn btn-lg submit text-white px-5 float-left">إرسال</button>
                    </div>
                </form>
            </div><!-- .contact-form -->
        </div><!-- .container -->
    </div>