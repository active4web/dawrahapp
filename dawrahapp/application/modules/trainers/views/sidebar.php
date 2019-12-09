<div class="row">
<form action="<?=base_url()?>courses/search" method="post" class="contact-form">
							 <div class="col-md-12" style="position: relative;">
								 <input class="theme-input-style input" style="margin-bottom:0px" type="text" placeholder="اسم الكورس" name="name" required="">
								 <i class="fa fa-search " style="position: absolute;top: 1px;left: 16px;background-color: #367dff;color: #fff;padding: 9px;"></i>
								 </div>
								 	
</form>  							
<div class="page-title text-center">
<h2 calss="col-md-12" style="text-align:right;font-size:16px;padding:10px;margin-bottom:0px">الأقسام</h2>
</div>
<?php
$inside_course=get_table_data("products",array("type"=>'1','view'=>'1','delete_key'=>'1'));
$diploma_course=get_table_data("products",array("type"=>'3','view'=>'1','delete_key'=>'1'));
$outside_course=get_table_data("products",array("type"=>'4','view'=>'1','delete_key'=>'1'));
$bags_course=get_table_data("bag_info",array('view'=>'1','delete_key'=>'1','delete_key'=>'1'));
$category=get_table_data("category",array('view'=>'1'),'20','name','asc');
?>

<div class="col-md-12">
<ul class="courses_list">
<li class="sidebar_dep">
<a href="">
<input type="checkbox" name="courses" value="1">
<span class="couses_span">دورات داخل المملكة</span>
<span  class="dep_count"><?= count($inside_course);?></span>
</a></li>
<li class="sidebar_dep">
<a href="">
<input type="checkbox" name="courses" value="4">
<span class="couses_span">دورات خارج المملكة</span>
<span class="dep_count"><?= count($outside_course);?></span>
</a></li>
<li class="sidebar_dep">
<a href="">
<input type="checkbox" name="courses" value="3"><span class="couses_span"> دبلومات </span>
<span class="dep_count"><?= count($diploma_course);?></span>
</a></li>
<li class="sidebar_dep">
<a href="">
<input type="checkbox" name="courses" value="2"><span class="couses_span">حقائب تدريبة</span>
<span class="dep_count"><?= count($bags_course);?></span>
</a></li>
   </ul>
</div>
<div class="col-md-12">
<div class="page-title text-center">
    
<h2 calss="col-md-12" style="text-align:right;font-size:16px;padding:10px;margin-bottom:0px">التخصصات</h2>
</div>
<?php 
if(count($category)>0){
    
?>


<ul class="courses_list">
    <?php foreach($category as $cat){
    $id_cat=$cat->id;
  $dep_courses=get_table_data("products",array("cat_id"=>$id_cat,'view'=>'1','delete_key'=>'1'));
$dep_bags=get_table_data("bag_info",array('dep_id'=>$id_cat,'view'=>'1','delete_key'=>'1'));  
$total=count($dep_courses)+count($dep_bags);
    ?>
<li class="sidebar_dep">
<a href="">
<input type="checkbox" name="courses" value="1">
<span class="couses_span"><?= $cat->name?></span>
<span  class="dep_count"><?php if($total>0){?><?= $total;?><?php }?></span>
</a></li>
<?php }?>
   </ul>

<?php }?>
</div>

  
</div>