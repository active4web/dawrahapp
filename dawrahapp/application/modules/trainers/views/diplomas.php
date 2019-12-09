<style>.wrapper {background-color:#f7f7fc} iframe{height:330px}</style>
		<?php 
	foreach($site_info as $siteinfo)
						?>

<section class="page-title-bg pt-130 pb-30" >
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-title text-center">
                        <h2>الدورات</h2>
                        <ul class="list-inline">
                            <li><a href="<?=DIR ?>index">الرئيسية</a></li>
                            <li><i class="fa fa-chevron-left"></i></li>
                            <li>الدورات</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
		<div class="wrapper">
			<div class="container">
				<div class="row  pt-50 ">
<div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom:30px;background-color:#fcfcfe;padding:10px">
<?php 
include("sidebar.php");
?>
					</div>
					
					<div class="col-md-9 col-sm-6 col-xs-12 " style="">
						<div class="row">
						    <div class="col-md-12" style="margin-bottom: 15px;border-bottom: 2px solid #fcfcfe;padding-bottom: 10px;">
	 <a href="<?base_url()?>courses/bags">
       <div  class="display_courses">
			<svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="th" role="img" xmlns="http://www.w3.org/2000/svg" 
			viewBox="0 0 512 512" class="svg-inline--fa fa-th fa-w-16 fa-lg"><path fill="currentColor" 
			d="M464 32H48C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48 48h416c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48zM197.3 72h117.3v96H197.3zm0 136h117.3v96H197.3zm-40 232H52c-6.6 0-12-5.4-12-12v-84h117.3zm0-136H40v-96h117.3zm0-136H40V84c0-6.6 5.4-12 12-12h105.3zm157.4 272H197.3v-96h117.3v96zm157.3 0H354.7v-96H472zm0-136H354.7v-96H472zm0-136H354.7V72H472z" class=""  ></path></svg>
						</div>
						    </a>
						    
<a href="<?base_url()?>courses/one_bags">
<div  class=" display_courses_notactive">
<svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="th-list" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-th-list fa-w-16 fa-lg"><path fill="currentColor" d="M0 80v352c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V80c0-26.51-21.49-48-48-48H48C21.49 32 0 53.49 0 80zm472 224H197.333v-96H472v96zm0 40v84c0 6.627-5.373 12-12 12H197.333v-96H472zM40 208h117.333v96H40v-96zm157.333-40V72H460c6.627 0 12 5.373 12 12v84H197.333zm-40-96v96H40V84c0-6.627 5.373-12 12-12h105.333zM40 344h117.333v96H52c-6.627 0-12-5.373-12-12v-84z" class=""></path></svg>
</div></a>

						    
						    </div>
						    <?
						    if(count($result_count)==0){
						    ?>
						    <div class="col-md-12">
					<div class="page-title text-center" >
                        <h2 style="font-size:16px;padding-top:20px">لا يوجد اى محتوى حاليا</h2>
                        </div>
                        </div>
						    <?php } else {?>

<?php
foreach($results as $bag){

 $Institute_name=get_table_filed('Institute',array('id_course'=>$bag->id),"Institute_name");
 $Institute_about=get_table_filed('Institute',array('id_course'=>$bag->id),"Institute_about");  
  $Institute_img=get_table_filed('Institute',array('id_course'=>$bag->id),"Institute_img");  
  $city_id_bage=$bag->city_id;
$city =get_table_filed('city',array('id'=>$city_id_bage),"name");
$country_id =get_table_filed('city',array('id'=>$city_id_bage),"country_id");
$country=get_table_filed('country',array('id'=>$country_id),"title");
    
?>
<div class="col-md-4 col-ms-6 col-xs-12" style="margin-bottom:20px;">
    <a href="<?=base_url()?>courses/diplomas_details/<?= $bag->id;?>">

<div class="img_info">

<?php 
if($bag->img!=""){
?>
<img src="<?=DIR_DES_STYLE?>products/<?=$bag->img?>" style="width:100%;" class="img_bags">
<?php }else {?>
<img src="<?=DIR_DES_STYLE?>products/no_img.png" style="width:100%;" class="img_bags">
<?php }?>
</div>
<div class="col-md-12 info">
    
<div class="col-md-12">
<h3 style="font-size:14px;text-align:right;font-weight:400;padding:10px"><?= $bag->name;?></h3>
</div>


<div class="row"  style="color:#3f3f3f">

<div class="col-md-4" style="font-weight:600;font-size:12px;padding-left: 0px;">
<i class="fa fa-map-marker" style="margin-left:5px;"></i><?= mb_substr($city,0,20);?></div>
<div class="col-md-6" style="font-size:12px;padding-left: 0px;padding-right: 0px;text-align:center">
<i class="fa fa-hotel" style="margin-left:5px"></i><?= mb_substr($Institute_name,0,20);?></div>
<div class="col-md-2" style="font-size:12px;padding-right: 0px;text-align:left">
<i class="fa fa-chair" style="margin-left:5px"></i><?= $bag->num_seats;;?></div>

</div>
<div class="row"  style="color:#3f3f3f">
    
<div class="col-6" style="font-size:12px;text-align:right;">
                                     <?php
if($bag->price>$bag->discount&&$bag->discount!=""){
  $discount=$bag->price; 
  $price=$bag->discount;
}
else{
if($bag->discount==""){$discount="";}
else {$discount=$bag->discount; }
$price=$bag->price;   
}

?>
<div><?= $price.""."ريال";?>

<?php 
if($discount!=""){
?>
<strike><?= $discount.""."ريال";?></strike>
<?php }?>
</div>
</div>

<div class="col-md-6" style="font-size:12px;text-align:left">
<?php 
$total_rate=$bag->total_rate;
for($i=0; $i<5; $i++){
if($total_rate>$i){
$total_rate--;
?>
<i class="fa fa-star rate_view " style="color:#fec355"></i>
<?php } else {?>
<i class="fa fa-star rate_view"></i>
<?php } }?>
</div>
</div>

</div>


</a>
</div>

<?php  }?>
<div class="col-md-12 pagination justify-content-center" style="margin-bottom:20px;">						    
 <ul class="nav align-items-center" style="visibility: visible;margin:auto">
            <?php foreach($links as $link){?><?php echo $link;?><?php } ?>
</div>
                                            </ul>						    
						    <?php }?>
						    
						</div>
					</div>

			</div>
		</div>
		

		</div>

	