<style>.wrapper {background-color:#f7f7fc} iframe{height:330px}

    </style>
		<?php 
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
$this->output->set_header('Pragma: no-cache');
$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  

	foreach($site_info as $siteinfo)
						?>

<section class="page-title-bg pt-90 pb-30"  >
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-title text-center">
                       
                    </div>
                </div>
            </div>
        </div>
    </section>
		<div class="wrapper">
			<div class="container">
				<div class="row  pt-50 ">
<div class="col-lg-3 col-md-4 col-sm-12" style="margin-bottom:30px;background-color:#fcfcfe;padding:10px;min-height:400px">
<?php 
include("sidebar.php");

?>
					</div>
					
					<div class="col-lg-9 col-md-8 col-sm-12" style="">
						<div class="row" style="margin:0px">
						  
						    <?php
						    if(count($sql_product)==0&&count($sql_product_bag)==0){
						    ?>
						    <div class="col-md-12">
					<div class="page-title text-center" >
                        <h2 style="font-size:16px;padding-top:20px">لا يوجد اى محتوى حاليا</h2>
                        </div>
                        </div>
						    <?php } else {?>

<?php
foreach($sql_product as $bag){

 $Institute_name=get_table_filed('Institute',array('id_course'=>$bag->id),"Institute_name");
 $Institute_about=get_table_filed('Institute',array('id_course'=>$bag->id),"Institute_about");  
  $Institute_img=get_table_filed('Institute',array('id_course'=>$bag->id),"Institute_img");  
  $city_id_bage=$bag->city_id;
$city =get_table_filed('city',array('id'=>$city_id_bage),"name");
$country_id =get_table_filed('city',array('id'=>$city_id_bage),"country_id");
$country=get_table_filed('country',array('id'=>$country_id),"title");
    
?>
<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 main_dwart">
    
    <a href="<?=base_url()?>user/courses/courses_details/<?= $bag->id;?>">

<div class="img_info" style="background:#fff">

<?php 
if($bag->img!=""){
?>
<img src="<?=DIR_DES_STYLE?>products/thumbnail_150/<?=$bag->img?>" style="width:100%;" class="img_bags">
<?php }else {?>
<img src="<?=DIR_DES_STYLE?>products/no_img.png" style="width:100%;" class="img_bags">
<?php }?>
</div>
<div class="col-12 info no_p" >
<div class="row"  style="color:#3f3f3f;margin:0px">
<div class="col-12">
<h3 class="title_course"><?= $bag->name;?></h3>
</div>

<div class="col-lg-4  col-md-12  col-sm-12 attr main_attr no_p no_p_c">
<i class="icon-map-marker" style="margin-left:5px;padding-left:5px;"></i><?= mb_substr($city,0,10);?></div>
<div class="col-lg-5  col-md-12  col-sm-12 attr main_attr no_p no_p_c">
    <img src="<?=DIR_DES_STYLE?>site_setting/buliding.png" class="icon_img"><?= mb_substr($Institute_name,0,10);?>
    </div>
<div class="col-lg-3  col-md-12 col-sm-12 attr no_p no_p_c" style="color:#367dfe">
<img src="<?=DIR_DES_STYLE?>site_setting/chair.png" class="icon_img"><?= $bag->num_seats;;?></div>

</div>
<div class="row"  style="color:#3f3f3f;margin:0px;">
    
<div class="col-lg-6 col-md-12 col-sm-12" style="font-size:12px;text-align:right;">
                                     <?php
if($bag->price>$bag->discount&&$bag->discount!=""&&$bag->discount!=0){
  $discount=$bag->price; 
  $price=$bag->discount;
}
else{
if($bag->discount==""||$bag->discount==0){$discount="";}
else {$discount=$bag->discount; }
$price=$bag->price;   
}

?>
<div><span style="color:#367dfe;font-weight:bold"><?= $price."&nbsp"."ريال";?></span>

<?php 
if($discount!=""){
?>
<strike><?= $discount.""."ريال";?></strike>
<?php }?>
</div>
</div>

<div class="col-lg-6 col-md-12 col-sm-12 align_r" style="font-size:13px;text-align:left;font-weight:400">
<?php 
$total_rate=$bag->total_rate;
for($i=0; $i<5; $i++){
if($total_rate>$i){
//$total_rate--;
?>
<i class="fa fa-star rate_view " style="color:#fec355;    font-size: 12px;"></i>
<?php } else {?>
<i class="icon-star-empty"></i>
<?php } }?>
</div>
</div>

</div>


</a>
</div>

<?php  }?>

<?php
foreach($sql_product_bag as $bag){
?>
<div class="col-md-6 col-lg-4 col-sm-12" style="margin-bottom:20px;">
    <a href="<?=base_url()?>user/courses/bags_details/<?= $bag->id;?>">

<div class="img_info">

<?php 
if($bag->img!=""){
?>
<img src="<?=DIR_DES_STYLE?>products/thumbnail_150/<?=$bag->img?>" style="width:100%;    border-top-left-radius: 0.4em;border-top-right-radius: 0.4em;" class="img_bags">
<?php }else {?>
<img src="<?=DIR_DES_STYLE?>products/no_img.png" style="width:100%;    border-top-left-radius: 0.4em;border-top-right-radius: 0.4em;" class="img_bags">
<?php }?>
</div>
<div class="col-md-12 info">
    
<div class="row" style="margin:0px; background:#fff;padding-top:10px;padding-bottom:6px">
<div class="col-md-12">
<h3 style="font-size:16px;text-align:right;font-weight:600;padding-bottom:12px;padding-top:15px;"><?= $bag->bage_name;?></h3>

</div>

<div class="col-12" style="font-size:13px;text-align:right;padding-bottom:6px;padding-top:15px;background:#fff;">
<?php 
$total_rate=$bag->total_rate;
for($i=0; $i<5; $i++){
if($total_rate>$i){
//$total_rate--;
?>
<i class="fa fa-star" style="color:#fec355;font-size:12px"></i>
<?php } else {?>
<i class="icon-star-empty" style="color:#3f3f3f"></i>
<?php } }?>
</div>
</div>
</div>

</a>
</div>

<?php  }?>

						    
						    <?php }?>
						    
						</div>
					</div>

			</div>
		</div>
		

		</div>

	
