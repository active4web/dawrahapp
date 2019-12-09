<div style="    background-color: #f7f7fc;height: 50px;"></div>
<footer>
<?php foreach($site_info as $siteinfo)?>
    <footer class="footer section-pattern footer-bg" data-bg-img="">
        <!-- Footer Top Begin -->
        <div class="footer-top pt-60">
            <div class="container border-bottom">
                <div class="row">
                    <div class="col-lg-4 ">
                        <!-- Contact Widget Begin -->
                        <div class="widget widget_recent_entries">
                            <!-- Widget Logo Begin -->
                            <div class="widget-title">
                                 <hr class="footer_hr">
<h4>عن دورة</h4>
                            </div>
                       <P class="p"><?= $siteinfo->footer_about?></P>
                        </div>
                        <!-- About Widget End -->
                    </div>
                    <div class="col-lg-4">
                        <!-- Widget Recent Post Begin -->
                        <div class="widget widget_recent_entries">
                            <!-- Widget Title Begin  -->
                            <div class="widget-title">
                                 <hr class="footer_hr">
                                <h4>روابط مختصرة </h4>
                            </div>
                            <?php 
                             if($this->session->userdata("customer_id")==""&&!$this->session->userdata("customer_id")){
                             ?>
                         <ul class="menu" style="float:right;text-align:right">
                             
                                <li><a href="<?= DIR?>index/" class="p"><i class="fa fa-external-link-alt menufooter"></i> الرئيسية</a></li>
<li><a href="#" class="p"><i class="fa fa-external-link-alt menufooter"></i> عن دورة</a></li>
                                <li><a href="<?= DIR?>courses/dawrat" class="p"> <i class="fa fa-external-link-alt menufooter"></i> الدورات </a></li>
                                <li><a href="<?= DIR?>courses/bags/" class="p" ><i class="fa fa-external-link-alt menufooter"></i> الحقائب التدريبية</a></li>
                            </ul>
                               <ul class="menu foot_menu" style="text-align:right">
                                <li><a href="<?= DIR?>courses/diplomas" class="p"><i class="fa fa-external-link-alt menufooter"></i> الدبلومات </a></li>
                                <li><a href="<?= DIR?>trainers/" class="p"><i class="fa fa-external-link-alt menufooter"></i> المدربين</a></li>
                                <li><a href="#" class="p"><i class="fa fa-external-link-alt menufooter"></i> الشروط والأحكام</a></li>
                                <li><a href="<?= DIR?>index/contact/" class="p"><i class="fa fa-external-link-alt menufooter"></i> اتصل بنا</a></li>
 
                            </ul>
                            <?php } else {?>
                             <ul class="menu" style="float:right;text-align:right">
                             
                                <li><a href="<?= DIR?>index/" class="p"><i class="fa fa-external-link-alt menufooter"></i> الرئيسية</a></li>
                                <li><a href="#" class="p"><i class="fa fa-external-link-alt menufooter"></i> عن اكاديمك</a></li>
                                <li><a href="#" class="p"><i class="fa fa-external-link-alt menufooter"></i> الشروط والأحكام</a></li>
                                <li><a href="<?= DIR?>index/contact/" class="p"><i class="fa fa-external-link-alt menufooter"></i> اتصل بنا</a></li>
                            </ul>
                            <?php }?>
                            <div style="clear:both;width:100%;"></div>
                        </div>
                        <!-- Widget Recent Post End -->
                    </div>
                    <div class="col-lg-4">
                        <!-- Widget Quick Nav -->
                        <div class="widget widget_recent_entries">
                            <!-- Widget Title Begin  -->
                            <div class="widget-title">
                                <hr class="footer_hr">
                                <h4>تواصل معانا</h4>
                            </div>
                            <!-- Widget Title End  -->

                            <!-- Menu Begin -->
                                <div class="info-content">
                                <div class="single-info" style="margin-bottom:15px">
                                    <p class="p"><a href="tel:<?=$siteinfo->phone?>"><i class="fa fa-phone iconstyle"></i><?=$siteinfo->phone?></a></p>
                                </div>
                                <div class="single-info" style="margin-bottom:15px">
                                    <p class="p">
                                        <a href="mailto:<?=$siteinfo->email?>"><i class="fa fa-envelope iconstyle"></i><?=$siteinfo->email?></a> 
                                    </p>
                                </div>
                                 <div class="single-info" style="text-align:center">
                                    <p class="p" >
                                        <a href="<?=$siteinfo->app_android?>" target="_blank"><img src="<?= DIR_DES_STYLE?>site_setting/androide.png" style="width:80px;"></a> 
                                         <a href="<?=$siteinfo->app_ios?>" target="_blank"><img src="<?= DIR_DES_STYLE?>site_setting/ios.png" style="width:80px;"></a>
                                    </p>
                                </div>
                            </div>
                         
                            <!-- Menu End -->
                        </div>
                        <!-- Widget Quick Nav -->
                           <div class="widget widget_social_icon soicalfooter" style="margin-bottom:0px;">
                            <ul class="social_icon_list list-inline" style="    display: contents;">
                                <li class="soicalli">
                                    <a href="<?=$siteinfo->facebook?>" target="_blank"><i class="fab fa-facebook-f" aria-hidden="true" style="color: #367dfe;"></i></a>
                                </li>
                                <li class="soicalli">
                                    <a href="<?=$siteinfo->twitter?>" target="_blank"><i class="fab fa-twitter" aria-hidden="true" style="color: #367dfe;"></i></a>
                                </li>
                                <li class="soicalli">
                                    <a href="<?=$siteinfo->linkedin?>" target="_blank"><i class="fab fa-linkedin-in" aria-hidden="true" style="color: #367dfe;"></i></a>
                                </li>
                                <li class="soicalli">
                                    <a href="<?=$siteinfo->instagram?>" target="_blank"><i class="fab fa-instagram" aria-hidden="true" style="color: #367dfe;"></i></a>
                                </li>
                                <li></li>
                            </ul>
                        </div>
                    </div>
        
                </div>
            </div>
        </div>
        <!-- Footer Top End -->

        <!-- Footer Bottom Begin -->
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="copyright-text text-center" style="font-size:14px">
<span><a href="#"></a>&copy; جميع الحقوق محفوظة لدورة 2019</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer Bottom End -->
        
    </footer>
    <!-- Footer End -->

    <!-- Back to Top Begin -->
    <a href="#" class="back-to-top position-fixed">
        <div class="top-arrow"></div>
        <div class="top-line"></div>
    </a>
    

    <!-- Back to Top End -->

    <!-- ======= jQuery Library ======= -->
    <script src="<?= DIR_DES?>js/jquery.min.js"></script>
    
    <!-- ======= Bootstrap Bundle JS ======= -->
    <script src="<?= DIR_DES?>js/bootstrap.bundle.min.js"></script>

    <!-- =======  Mobile Menu JS ======= -->
    <script src="<?= DIR_DES?>js/menu.min.js"></script>
    
    <!-- ======= Waypoints JS ======= -->
    <script src="<?= DIR_DES?>plugins/waypoints/jquery.waypoints.min.js"></script>
    
    <!-- ======= Counter Up JS ======= -->
    <script src="<?= DIR_DES?>plugins/waypoints/jquery.counterup.min.js"></script>

    <!-- ======= Owl Carousel JS ======= -->
    <script src="<?= DIR_DES?>plugins/owlcarousel/owl.carousel.min.js"></script>

    <!-- ======= Isotope JS ====== -->
    <script src="<?= DIR_DES?>plugins/isotope/isotope.pkgd.min.js"></script>

    <!-- ======= Magnific Popup JS ======= -->
    <script src="<?= DIR_DES?>plugins/magnific-popup/jquery.magnific-popup.min.js"></script>

    <!-- ======= Countdown JS ======= -->
    <script src="<?= DIR_DES?>/plugins/countdown/countdown.min.js"></script>

    <!-- ======= Retina JS ======= -->
    <script src="<?= DIR_DES?>plugins/retinajs/retina.min.js"></script>

    <!-- ======= Google API ======= -->

    <!-- ======= Main JS ======= -->
    <script src="<?= DIR_DES?>js/main.js"></script>
    
    <!-- ======= Custom JS ======= -->
    <script src="<?= DIR_DES?>js/custom.js"></script>
        <script type="text/javascript" src="<?=DIR;?>design/frontpage/toastr/toastr.min.js"></script>
    <link href="<?=DIR;?>design/frontpage/toastr/toastr.min.css" rel="stylesheet">

<script src="<?=base_url()?>design/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

	<?php 

	if(isset($_SESSION['msg']) && $_SESSION['msg']!=''&& $this->uri->segment(2)=="contact"){?>
<script>
$(document).ready(function(e) {
	toastr.info("<?=$_SESSION['msg'];?>",  {timeOut: 5000})
});
</script>
<?php } ?>

<?php
include("custom.php")
?>

