<style>.wrapper {background-color:#f7f7fc} iframe{height:330px}
.fixed-top {
    box-shadow: none;
    position: fixed;}
</style>
		<?php 
	foreach($site_info as $siteinfo)
		foreach($results as $data)
		//$cat_id=$data->dep_id;
		//$cat_name =get_table_filed('category',array('id'=>$cat_id),"name");
						?>

<section class="page-title-bg pt-90 pb-30" style="border-bottom: 1px solid #e2e2e2;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-title text-center">
                        <h2>الحقائب</h2>
                        <ul class="list-inline">
                            <li><a href="<?=DIR ?>index">الرئيسية</a></li>
                             <li><i class="fa fa-chevron-left"></i></li>
							<li><a href="<?=DIR ?>/courses/bags">الحقائب</a></li>
							<li><i class="fa fa-chevron-left"></i></li>
							<li><?= $data->bage_name;?></li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
		<div class="wrapper">
			<div class="container">
				<div class="row  pt-50 ">
<div class="col-md-4 col-lg-3">

<div class="row" style="margin-bottom:30px;background-color:#fff;border:1px solid #8181812b;border-radius:0.4em">
 <div class="col-md-12" style="margin-bottom:20px;padding:0px;">

<div class="img_info" style="text-align:center;">
<a href="<?=base_url()?>login">
<i class="icon-heart-empty no_myfav" ></i>
</a>


<?php 
if($data->img!=""){
?>
<img src="<?=DIR_DES_STYLE?>products/<?=$data->img?>" style="width:100%" >
<?php }else {?>
<img src="<?=DIR_DES_STYLE?>products/no_img.png" style="width:100%">
<?php }?>

</div>

</div>   


<input type="text" style="width:100%;height:35px;display:none" id="discount_code" placeholder="كود الخصم">
<input type="hidden" value="<?=$data->id?>" name="course_id">
<div class="col-md-12 pt-10 pb-10" style="text-align:center">
 <a href="<?=base_url()?>login">
	 <div style="width:100%" class="mainheader stepsbutton">
  اطلب الأن  </div></a>
</div>
<div class="col-md-12 share_social" style="text-align:center;margin-bottom:20px;cursor: pointer;"><i class="fa fa-share"></i> شارك مع الأصدقاء</div>
<div style="display:none;text-align:center;margin-bottom:40px;" id="share_social" class="col-md-12">
<div class="sharethis-inline-share-buttons"></div>
</div>
	<script type='text/javascript' src='//platform-api.sharethis.com/js/sharethis.js#property=5cfe6b7d4351e90012650022&product=inline-share-buttons' async='async'></script>

</div>
</div>

<div class="col-md-8 col-lg-9">
<div class="row" style="background-color:#fff;border-radius: 0.4em;margin:0px !important;border:1px solid #8181812b;border-radius:0.4em">
<div class="col-md-12 main_previw" style="font-size:16px;font-weight:bold;padding:22px;color:#000">
<?= $data->bage_name;?></div>
<?php
  $cat_id=$data->dep_id;
  $category_name =get_table_filed('category',array('id'=>$cat_id),"name");

  
?>
<?php if($data->bage_hrs!=""){?>
<div class="col-md-4" style="font-size:13px; text-align:right;    line-height: 32px;">عدد الساعات:
<?= $data->bage_hrs;?></div>
<?php  }?>

<?php if($data->week_bage_daies!=""){?>
<div class="col-md-4 attr" style="font-size:13px;line-height: 32px;">	الايام فى الاسبوع:<?= $data->week_bage_daies;?></div>
<?php  }?>
<?php if($data->bage_total_daies!=""){?>
<div class="col-md-4 attr" style="font-size:13px; line-height: 32px;">	عدد الأيام :<?= $data->bage_total_daies;?></div>
<?php  }?>

<div style="height:50px"></div>

<div class="col-md-12 main_previw">
<?php 
$customers_id=$this->session->userdata("customers_id");
$id_fav =get_table_filed('favourites',array('user_id'=>$customers_id,'type'=>2,'course_id'=>$data->id),"id");

$count_fav =$this->db->get_where('reviews',array('id_course'=>$data->id,'course_key'=>2))->result();
$rate_count=(int)count($count_fav);

$total_rate=$data->total_rate;
for($i=0; $i<5; $i++){
if($total_rate>$i){
//$total_rate--;
?>
<i class="fa fa-star rate_view " style="color:#fec355"></i>
<?php } else {?>
<i class="icon-star-empty  rate_view"></i> 
<?php } 
}?>
<span style="color:#fec355"><?php  if($rate_count>0){echo "(".$rate_count.") تقييما";}?></span>

</div>
<div style="height:40px"></div>
<div class="col-md-12 main_previw">

					<?= $data->bage_details;?>
</div>
					<hr class="inside_page">
				<!-----------*****--------------->
				<!-----------*****--------------->
				<!-----------*****--------------->
				<!-----------*****--------------->
				<!-----------*****--------------->


				

			
				<!-----------*****--------------->
				<!-----------*****--------------->
				<!-----------*****--------------->
				<!-----------*****--------------->
				<!-----------*****--------------->

				<div class="col-md-12 ">
					    	    <div class="page-title text-right" >
                        <h2 style="font-size:17px;font-weight:500">محتوى الحقيبة</h2>
                       
					</div>
			</div>


				   <?php
             if(count($course_info)>0){
                ?>
				<div class="col-md-12 mt-15">
				
             
			<div class="row" style="margin-right:0px; margin-left:0px">
				<?php 
				foreach($course_info as $course_info){
				?>
				<div class="col-md-6">
					<div class="row" style="margin-right:0px; margin-left:0px">
				<div class="col-md-12 main_previw"><span><i class=" fa fa-check iconstyle"></i></span><span><?= $course_info->content;?></span></div>
				</div>

				</div>
				<?php }?>
				</div>
				<div style="padding:20px;"></div>
				<?php }?>
				
				 <a href="<?=base_url()?>login" style="width:100%">
	 <div style="width:100%;text-align:center" class="mainheader stepsbutton">طلب  الحقيبة الأن
	</div>
	</a>
	
	
                </div>
           </div>
		</div>

			</div>
		</div>
		

		</div>

	
