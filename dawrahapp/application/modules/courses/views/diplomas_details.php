<style>.wrapper {background-color:#f7f7fc} iframe{height:330px}

.fixed-top {
    box-shadow: none;
    position: fixed;}
</style>
		<?php 
	foreach($site_info as $siteinfo)
		foreach($results as $data)
		$cat_id=$data->cat_id;
		$cat_name =get_table_filed('category',array('id'=>$cat_id),"name");
						?>

<section class="page-title-bg pt-90 pb-30" style="border-bottom: 1px solid #e2e2e2;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-title text-center">
                        <h2>الدبلومات</h2>
                        <ul class="list-inline">
                            <li><a href="<?=DIR ?>index">الرئيسية</a></li>
                            <li><i class="fa fa-chevron-left"></i></li>
							<li><?= $cat_name;?></li>
							<li><i class="fa fa-chevron-left"></i></li>
							<li><?= $data->name;?></li>

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
 <div class="col-md-12" style="margin-bottom:20px;">

<div class="img_info" style="text-align:center;padding:0px">
<a href="<?=base_url()?>login">
<i class="icon-heart-empty  no_myfav" ></i>
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



<div class="col-md-12" style=";text-align:right;">
<?php
if($data->price>$data->discount&&$data->discount!=""&&$data->discount!=0){
  $discount=$data->price; 
  $price=$data->discount;
}
else{
if($data->discount==""||$data->discount==0){$discount="";}
else {$discount=$data->discount; }
$price=$data->price;   
}

?>
<div style="font-size:15px;margin-left:10px">
<span  style="color: #367dff;font-size:18px; font-weight:bold;"><?= $price.""."ريال";?></span>

<?php 
if($discount!=""){
?>
<strike style="color: #797979"><?= $discount.""."ريال";?></strike>
<?php }?>
</div>
</div>
 <a href="<?=base_url()?>login">
<div class="col-md-12 discount_code">هل لديل كود خصم ؟</div>
</a>
<div class="col-md-12 pt-10 pb-10" style="text-align:center">
 <a href="<?=base_url()?>login">
	 <div style="width:100%" class="mainheader stepsbutton">اطلب الأن  </div></a>
</div>
<div class="col-md-12 share_social" style="text-align:center;margin-bottom:20px;cursor: pointer;"><i class="fa fa-share"></i> شارك مع الأصدقاء</div>
<div style="display:none;text-align:center;margin-bottom:40px;" id="share_social" class="col-md-12">
<div class="sharethis-inline-share-buttons"></div>
</div>
	<script type='text/javascript' src='//platform-api.sharethis.com/js/sharethis.js#property=5cfe6b7d4351e90012650022&product=inline-share-buttons' async='async'></script>

</div>
</div>

<div class="col-md-8 col-lg-9">
<div class="row" style="background-color:#fff;border-radius: 0.4em;margin:0px !important;border:1px solid #8181812b">
<div class="col-md-12 main_previw" style="font-size:16px;font-weight:bold;padding:22px;color:#000"><?= $data->name;?></div>
<?php
  $city_id_bage=$data->city_id;
  $cat_id=$data->cat_id;
  $city =get_table_filed('city',array('id'=>$city_id_bage),"name");
  $category_name =get_table_filed('category',array('id'=>$cat_id),"name");

  
?>


<div class="col-md-12 main_previw">
    
<div class="row" style="margin:0px">
<?php if($city!=""){?>
<div class="col-lg-2 col-sm-12" style="font-size:13px; text-align:right;line-height: 32px;">
<i class="icon-map-marker" style="margin-left:5px;font-size:16px;"></i><?= $city;?></div>
<?php  }?>
<?php if($category_name!=""){?>
<div class="col-lg-3 col-sm-12 attr" style="font-size: 13px;border: 1px solid #2d77ff; line-height: 32px;background: #def0ff;border-radius: 0.4em;color: #2d77ff;height: 35px;"><?= $category_name;?></div>
<?php  }?>
<?php if($data->accreditation_number!=""&&$data->accreditation_number!=0){?>
<div class="col-lg-3 col-sm-12 attr" style="font-size:13px;line-height: 32px;">	رقم الأعتماد :<?= $data->accreditation_number;?></div>
<?php  }?>
<?php if($data->date_course!=""){?>
<div class="col-lg-4 col-sm-12 attr" style="font-size:13px;line-height: 32px;">	تاريخ الدورة:<?= date("Y-d-m h:i",strtotime($data->date_course));?></div>
<?php  }?>
<div style="height:50px" class="col-md-12"></div>
</div>    
<?php 
$customers_id=$this->session->userdata("customers_id");
$id_fav =get_table_filed('favourites',array('user_id'=>$customers_id,'type'=>$data->type,'course_id'=>$data->id),"id");

$count_fav =$this->db->get_where('reviews',array('id_course'=>$data->id,'course_key'=>$data->type))->result();
$rate_count=(int)count($count_fav);

$total_rate=$data->total_rate;
for($i=0; $i<5; $i++){
if($total_rate>$i){
//$total_rate--;
?>
<i class="fa fa-star rate_view " style="color:#fec355;font-size:12px;"></i>
<?php } else {?>
<i class="icon-star-empty"></i> 
<?php } 
}?>
<span style="color:#fec355"><?php  if($rate_count>0){echo "(".$rate_count.") تقييما";}?></span>

</div>
<div style="height:40px"></div>
<div class="col-md-12 main_previw">

					<?= $data->details;?>
</div>
					<hr class="inside_page">
				<!-----------*****--------------->
				<!-----------*****--------------->
				<!-----------*****--------------->
				<!-----------*****--------------->
				<!-----------*****--------------->


				<div class="col-md-12 ">
					    	    <div class="page-title text-right" >
                        <h2 style="font-size:17px;font-weight:500"> مقدم الدورة</h2>
                       
                    </div>
			</div>


			<?php
			if(count($institute)>0){
				foreach($institute as $institute)
				?>
			<div class="col-md-2 main_previw img_info_circle">
<?php
if($institute->Institute_img!=""){
?>
<img src="<?=DIR_DES_STYLE?>products/<?=$institute->Institute_img?>" style="width:100px;height:100px !important;" class="course_img">
<?php }else {?>
<img src="<?=DIR_DES_STYLE?>products/no_img.png" style="width:100px;height:100px !important;" class="course_img">
<?php }?>

			</div>
				<div class="col-md-10 main_previw" >
				    
				<p><?= $institute->Institute_name; ?></p>
				<p><?= $institute->Institute_about; ?></p>
			</div>
			<?php }?>
			<hr class="inside_page">

				<!-----------*****--------------->
				<!-----------*****--------------->
				<!-----------*****--------------->
				<!-----------*****--------------->
				<!-----------*****--------------->

				<div class="col-md-12 ">
					    	    <div class="page-title text-right" >
                        <h2 style="font-size:17px;font-weight:500">مدة الدورة</h2>
                       
					</div>
			</div>
			<div class="col-md-12 main_previw" ><?= $data->duration_course;?></div>


				   <?php
             if(count($course_info)>0){
                ?>
				<div class="col-md-12 mt-15">
				<div class="page-title text-right">
                <h2 style="font-size:17px;font-weight:500"></h2>
                </div>
                </div>
             
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
				
				
				<div class="col-md-12 pt-10 pb-10" style="text-align:center">
 <a href="<?=base_url()?>login">
	 <div style="width:100%" class="mainheader stepsbutton">طلب الدورة مقابل
	 <span  style="color:#fff;font-size:16px; font-weight:bold;">(<?= $price.""."ريال";?>)</span>

<?php 
if($discount!=""){
?>
<strike style="color:#1d1515"><?= $discount.""."ريال";?></strike>
<?php }?>
	</div>
	</a>
	</div>
				
           </div>
		</div>

			</div>
		</div>
		

		</div>

	
