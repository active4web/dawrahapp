<?php  if ($this->session->userdata('user_data')) {

           $user_data = $this->session->userdata('user_data');

       }

       if ($this->session->userdata('merchant_data')) {

           $merchant_data = $this->session->userdata('merchant_data');

       }

?>

<!doctype html>

<html lang="ar">



<head>

    <!-- Required meta tags -->

    <meta charset="utf-8">

    <meta name="description" content="">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <link rel="manifest" href="site.webmanifest">

    <link rel="shortcut icon" href="favicon.ico">

    <link rel="apple-touch-icon" href="icon.png">



    <title><?=$title?></title>



    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="<?=base_url()?>/assets/site_user/css/bootstrap/bootstrap.min.css">

    <link rel="stylesheet" href="<?=base_url()?>/assets/site_user/fonts/droid/stylesheet.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

    <link rel="stylesheet" href="<?=base_url()?>/assets/site_user/css/style.css">

    <link rel="stylesheet" href="<?=base_url()?>/assets/site_user/css/vendor.css">
	
	<link rel="stylesheet" href="<?=base_url()?>/assets/site_user/css/toastr.css">
	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

</head>

<style type="text/css">
    .contain {
    position: relative;
    width: 100%;
    max-width: 400px;
}

.contain img {
    width: 100%;
    height: auto;
}

.contain .btni {
    position: absolute;
    bottom: 49%;
    left: 81%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    background-color: #e46d57;
    color: white;
    /*font-size: 16px;*/
    padding: 12px 24px;
    border: none;
    cursor: pointer;
    /*border-radius: 5px;*/
    text-align: center;
}

.contain .btn:hover {
    background-color: white;
    color: #e46d57;
}

</style>


<body class="<?=$body_class?>">

    <!--[if lte IE 9]>

    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>

<![endif]-->



    <header class="site-header">

        <div class="top-nav">

            <div class="container">

                <div class="row">

                    <div class="col-lg-8 col-12 order-lg-1 order-2">

                        <nav class="navbar navbar-expand-lg top-navbar p-lg-0">

                            <button class="navbar-toggler mx-auto" type="button" data-toggle="collapse" data-target="#top-navbar"

                                aria-controls="top-navbar" aria-expanded="false" aria-label="Toggle navigation">

                                <i class="fa fa-bars text-white"></i>

                            </button>

                            <div class="collapse navbar-collapse" id="top-navbar">

                                <ul class="navbar-nav ml-auto pr-0">

                                    <li class="nav-item active p-2 ml-0 ml-lg-2">
                                        <?php if (!empty($merchant_data)) { ?>
                                            
                                        <a class="nav-link text-white" href="<?=base_url('site_merchant/orders')?>">

                                            <i class="fa fa-home fa-fw" aria-label="الرئيسية"></i>

                                            <span class="sr-only">(current)</span>

                                        </a>
                                       <?php }else{ ?>
                                        <a class="nav-link text-white" href="<?=base_url('home')?>">

                                            <i class="fa fa-home fa-fw" aria-label="الرئيسية"></i>

                                            <span class="sr-only">(current)</span>

                                        </a>
                                       <?php } ?>

                                    </li>

                                    <?php if (!empty($user_data)) { ?>

                                        <li class="nav-item py-2 ml-0 ml-lg-2">

                                            <a class="nav-link text-white" href="<?=base_url('site_user/edit_profile')?>">تعديل الملف الشخصي</a>

                                        </li>

                                        <li class="nav-item py-2 ml-0 ml-lg-2">

                                            <a class="nav-link text-white" href="<?=base_url('site_user/orders')?>">طلباتي</a>

                                        </li>

                                        <li class="nav-item py-2 ml-0 ml-lg-2">

                                            <a class="nav-link text-white" href="<?=base_url('site_user/products/favourites/'.$user_data['id'])?>">المفضلة</a>

                                        </li>

                                        <li class="nav-item py-2 ml-0 ml-lg-2">

                                            <a class="nav-link text-white" href="<?=base_url('site_user/shopping_cart/show_cart')?>">سلة الشراء</a>

                                        </li>

                                        <li class="nav-item py-2 mr-0 mr-lg-2">

                                            <a class="nav-link text-white" href="<?=base_url('site_user/tickets/my_tickets/'.$user_data['id'])?>">تذاكري</a>

                                        </li>

                                    <?php } ?> 

                                    <?php if (!empty($merchant_data)) { ?>

                                        <li class="nav-item py-2 ml-0 ml-lg-2">

                                            <a class="nav-link text-white" href="<?=base_url('site_merchant/edit_profile')?>">تعديل الملف الشخصي</a>

                                        </li>

                                        <!-- <li class="nav-item py-2 ml-0 ml-lg-2">

                                            <a class="nav-link text-white" href="<?=base_url('site_merchant/orders')?>">طلباتي</a>

                                        </li> -->

                                        <li class="nav-item py-2 ml-0 ml-lg-2">

                                            <a class="nav-link text-white" href="<?=base_url('site_merchant/products/my_products/'.$merchant_data['id'])?>">منتجاتي</a>

                                        </li>

                                        <li class="nav-item py-2 mr-0 mr-lg-2">

                                            <a class="nav-link text-white" href="<?=base_url('site_merchant/tickets/my_tickets/'.$merchant_data['id'])?>">تذاكري</a>

                                        </li>

                                        <li class="nav-item py-2 mr-0 mr-lg-2">

                                            <a class="nav-link text-white" href="<?=base_url('site_merchant/credit/my_credit/'.$merchant_data['id'])?>">الرصيد</a>

                                        </li>

                                    <?php } ?> 
									
									<li class="nav-item py-2 mr-0 mr-lg-2">
										<a class="nav-link text-white" href="<?=base_url('site_user/products/search')?>">البحث</a>
									</li>

                                    <li class="nav-item dropdown py-2 ml-0 ml-lg-2">

                                        <a class="nav-link dropdown-toggle text-white" href="#" id="topNavbarDropdown"

                                            role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                            صفحات فرعية

                                        </a>

                                        <div class="dropdown-menu text-right" aria-labelledby="topNavbarDropdown">

                                            <?php $pages = get_table('pages');

                                            foreach ($pages as $page) { ?>

                                                <a class="dropdown-item" href="<?=base_url('site_user/pages/page/'.$page->id)?>"><?=$page->title?></a>

                                             <?php } ?>

                                        </div>

                                    </li>

                                </ul>

                            </div>

                        </nav>

                    </div>

                    <div class="col-lg-4 col-12 order-lg-2 order-1">

                        <nav class="navbar user-navbar px-lg-0 justify-content-lg-end">

                            <ul class="nav pr-0 mx-lg-0 mx-auto">

                                <li class="nav-item mx-auto">

                                    <?php if (!empty($user_data) || !empty($merchant_data)) { ?>

                                        <a class="nav-link text-white" href="<?=base_url()?>site_user/login/logout">

                                            <i class="fa fa-unlock fa-fw text-orange" aria-hidden="true"></i>

                                            تسجيل الخروج

                                            <i class="fa fa-chevron-down text-white fa-fw" aria-hidden="true"></i>

                                        </a>

                                    <?php }else{ ?>

                                        <a class="nav-link text-white" href="<?=base_url()?>site_user/login">

                                            <i class="fa fa-unlock fa-fw text-orange" aria-hidden="true"></i>

                                            تسجيل الدخول

                                            <i class="fa fa-chevron-down text-white fa-fw" aria-hidden="true"></i>

                                        </a>

                                    <?php } ?>

                                </li>

                                <?php if (empty($user_data) && empty($merchant_data)) { ?>

                                    <li class="nav-item mx-auto">

                                        <a class="nav-link text-white pl-lg-0" href="<?=base_url()?>site_user/register">

                                            <i class="fa fa-user fa-fw text-orange" aria-hidden="true"></i>

                                            مستخدم جديد

                                            <i class="fa fa-chevron-down text-white fa-fw" aria-hidden="true"></i>

                                        </a>

                                    </li>

                                 <?php } ?>

                            </ul>

                        </nav>

                    </div>

                </div>

            </div>

        </div>

        <div class="container py-2 d-sm-flex d-block justify-content-between align-items-center">

            <div class="site-logo text-sm-right text-center">

                <a href="<?=base_url()?>">

                    <img src="<?=base_url()?>/assets/site_user/img/logo.png" class="img-fluid d-block mx-sm-0 mx-auto" width="230" height="106"

                        alt="Site Logo">

                </a>

            </div>

            <ul class="social-menu list-inline ltr mb-0 text-sm-left text-center mt-2 mt-lg-0">

                <?php $settings = get_this('settings',['id'=>1]) ?>

                <li class="list-inline-item">

                    <a target="_blank" href="<?=$settings['facebook']?>" class="social-link text-white d-block text-center">

                        <i class="fab fa-facebook-f" aria-hidden="true" aria-label="Facebook link"></i>

                    </a>

                </li>

                <li class="list-inline-item">

                    <a target="_blank" href="<?=$settings['twitter']?>" class="social-link text-white d-block text-center">

                        <i class="fab fa-twitter" aria-hidden="true" aria-label="Twitter link"></i>

                    </a>

                </li>

                <li class="list-inline-item">

                    <a target="_blank" href="<?=$settings['google_plus']?>" class="social-link text-white d-block text-center">

                        <i class="fab fa-google-plus-g" aria-hidden="true" aria-label="Google plus link"></i>

                    </a>

                </li>

                <li class="list-inline-item">

                    <a target="_blank" href="<?=$settings['youtube']?>" class="social-link text-white d-block text-center">

                        <i class="fab fa-youtube" aria-hidden="true" aria-label="Youtube link"></i>

                    </a>

                </li>

                <li class="list-inline-item">

                    <a target="_blank" href="<?=$settings['instagram']?>" class="social-link text-white d-block text-center">

                        <i class="fab fa-instagram" aria-hidden="true" aria-label="Instagram link"></i>

                    </a>

                </li>

            </ul>

        </div>

    </header><!-- .site-header -->

    <?php $this->load->view($main_content) ?>



    <div class="ads-area mb-5 pb-5">

        <div class="container">

            <div class="row">

                <?php $advertisements = get_table('ads',[],['created_at','DESC'],'2');

                 foreach ($advertisements as $adv) { ?>

                    <div class="col-md-6 col-12">

                        <a target="_blank" href="<?=$adv->url?>">

                            <img style="height: 120px; width: 570px" src="<?=base_url('assets/uploads/files/'.$adv->image)?>" class="img-fluid d-block mx-auto">

                        </a>

                    </div>

                <?php } ?>

            </div>

        </div>

    </div><!-- .ads-area -->



    <div class="subscribe-area pt-3 pb-5">

        <div class="container">

            <div class="row">

                <div class="col-md-6 col-12">

                    <div class="subscribe">

                        <h6 class="subscribe-title">إشترك معنا بالقائمة البريدية</h6>

                        <form class="subscribe-form">
                            <div id="response">
                            </div>
                            

                            <div class="input-group input-group-lg mt-3">

                                <input  id="email" type="text" name="email" class="form-control rounded-0 border-0" placeholder="أدخل بريدك الإلكتروني  هنا.." aria-label="أدخل بريدك الإلكتروني  هنا .." aria-describedby="subscribe-addon">

                                <div class="input-group-append">

                                    <span class="input-group-text bg-white rounded-0 border-0" id="subscribe-addon">

                                        <button id="send" type="submit" class="btn border-0 bg-white p-0">

                                            <i class="fa fa-envelope" aria-hidden="true"></i>

                                        </button>

                                    </span>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

                <div class="col-md-6 col-12 d-md-flex d-block justify-content-md-end">

                    <div class="play-store mt-5 mt-md-auto">

                        <h6 class="play-store-title">تواصل معنا عبر تطبيق متاجر</h6>

                        <ul class="play-store-menu list-inline pr-0 ltr mt-3">
                            <li class="list-inline-item mr-auto mr-sm-2">
                                <a href="<?=$settings['android_app']?>" target="_blank">
                                    <img src="<?=base_url()?>assets/site_user/img/google-play.png" class="img-fluid d-block mx-auto" width="133"
                                        height="38" alt="Google Play">
                                </a>
                            </li>
                            <li class="list-inline-item mt-2 mt-sm-auto">
                                <a href="<?=$settings['ios_app']?>" target="_blank">
                                    <img src="<?=base_url()?>assets/site_user/img/app-store.png" class="img-fluid d-block mx-auto" width="133"
                                        height="38" alt="Google Play">
                                </a>
                            </li>
                        </ul>

                    </div>

                </div>

            </div>

        </div>

    </div><!-- .subscribe-area -->



    <footer class="site-footer pt-5">

        <div class="container pb-4">

            <div class="row">

                <div class="col-lg-9 col-12">

                    <h5 class="site-cats-title text-white font-weight-bold">

                        أقسام الموقع

                    </h5>

                    <div class="row">

                        <div class="col-md-6 col-sm-6 col-12">

                            <ul class="site-cats-menu mt-3 pr-0">

                                <li class="list-item">

                                    <a href="<?=base_url()?>" class="list-link text-white">

                                        <i class="fa fa-angle-double-left fa-fw"></i>

                                        الرئيسية

                                    </a>

                                </li>
								
								<?php $pages = get_table('pages');

								foreach ($pages as $page) { ?>

                                <li class="list-item">

                                    <a href="<?=base_url('site_user/pages/page/'.$page->id)?>" class="list-link text-white">

                                        <i class="fa fa-angle-double-left fa-fw"></i>

                                        <?=$page->title?>

                                    </a>

                                </li>

                               <?php } ?>

                            </ul>

                        </div>

                        <div class="col-md-6 col-sm-6 col-12">

                            <ul class="footer-menu mt-3 pr-0">

							<?php if (!empty($user_data)) { ?>
							
                                <li class="list-item">
                                    <a href="<?=base_url('site_user/edit_profile')?>" class="list-link text-white">
                                        <i class="fa fa-angle-double-left fa-fw"></i>تعديل الملف الشخصي
                                    </a>
                                </li>
								
								<li class="list-item">
                                    <a href="<?=base_url('site_user/orders')?>" class="list-link text-white">
                                        <i class="fa fa-angle-double-left fa-fw"></i>طلباتي
                                    </a>
                                </li>

                                <li class="list-item">
                                    <a href="<?=base_url('site_user/products/favourites/')?>" class="list-link text-white">
                                        <i class="fa fa-angle-double-left fa-fw"></i>المفضلة
                                    </a>
                                </li>
								
								<li class="list-item">
                                    <a href="<?=base_url('site_user/shopping_cart/show_cart')?>" class="list-link text-white">
                                        <i class="fa fa-angle-double-left fa-fw"></i>سلة الشراء
                                    </a>
                                </li>
								
								<li class="list-item">
                                    <a href="<?=base_url('site_user/tickets/my_tickets/'.$user_data['id'])?>" class="list-link text-white">
                                        <i class="fa fa-angle-double-left fa-fw"></i>تذاكري
                                    </a>
                                </li>
								
								<li class="list-item">
                                    <a href="<?=base_url('site_user/orders')?>" class="list-link text-white">
                                        <i class="fa fa-angle-double-left fa-fw"></i>طلباتي
                                    </a>
                                </li>
							<?php } ?>
							
							<?php if (!empty($merchant_data)) { ?>
							
							<li class="list-item">
                                    <a href="<?=base_url('site_merchant/edit_profile')?>" class="list-link text-white">
                                        <i class="fa fa-angle-double-left fa-fw"></i>تعديل الملف الشخصي
                                    </a>
                            </li>
							
							<li class="list-item">
                                    <a href="<?=base_url('site_merchant/orders');?>" class="list-link text-white">
                                        <i class="fa fa-angle-double-left fa-fw"></i>طلباتي
                                    </a>
                            </li>
							
							<li class="list-item">
                                    <a href="<?=base_url('site_merchant/products/lists/'.$merchant_data['id'])?>" class="list-link text-white">
                                        <i class="fa fa-angle-double-left fa-fw"></i>منتجاتي
                                    </a>
                            </li>
								
							<li class="list-item">
                                    <a href="<?=base_url('site_merchant/tickets/my_tickets/'.$merchant_data['id'])?>" class="list-link text-white">
                                        <i class="fa fa-angle-double-left fa-fw"></i>تذاكري
                                    </a>
                            </li>
							
							<?php } ?>
							
							<li class="list-item">
                                    <a href="<?=base_url()?>site_user/products/search" class="list-link text-white">
                                        <i class="fa fa-angle-double-left fa-fw"></i>البحث
                                    </a>
                            </li>
							
							<?php if (!empty($user_data) || !empty($merchant_data)) { ?>
							
							<li class="list-item">
                                    <a href="<?=base_url()?>site_user/login/logout" class="list-link text-white">
                                        <i class="fa fa-angle-double-left fa-fw"></i>تسجيل الخروج
                                    </a>
                            </li>
							<?php }else{ ?>
							<li class="list-item">
                                    <a href="<?=base_url()?>site_user/login" class="list-link text-white">
                                        <i class="fa fa-angle-double-left fa-fw"></i>تسجيل الدخول
                                    </a>
                            </li>
							<?php } ?>
							
							<?php if (empty($user_data) && empty($merchant_data)) { ?>
							
							<li class="list-item">
                                    <a href="<?=base_url()?>site_user/register" class="list-link text-white">
                                        <i class="fa fa-angle-double-left fa-fw"></i>مستخدم جديد
                                    </a>
                            </li>
							
							<?php } ?>
							

                            </ul>

                        </div>

                    </div>

                </div>

                <div class="col-lg-3 col-12 text-center">

                    <a href="!#">

                        <img src="<?=base_url()?>/assets/site_user/img/footer-logo.png" width="142" height="163" alt="Site Logo">

                    </a>

                    <p class="copyright text-white mt-3">

                        جميع الحقوق محفوظة لـ مخزن <i class="far fa-copyright"></i> <span class="font-tahome">2018</span>

                    </p>

                </div>

            </div>

        </div>



        <div class="bottom-copyright copyright text-center text-white py-3">

            <p class="mb-0">Made with <i class="fa fa-heart fa-fw"></i> by <a href="https://wisyst.com/" class="text-white">Wisyst</a></p>

        </div>

    </footer><!-- .site-footer -->



    <!-- Optional JavaScript -->

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

    <script>

        window.jQuery || document.write('<script src="<?=base_url()?>/assets/site_user/js/vendor/jquery-3.2.1.min.js"><\/script>');

    </script>

    <script src="<?=base_url()?>/assets/site_user/js/vendor/popper.min.js"></script>
	<script src="<?=base_url()?>assets/site_user/js/toastr.min.js"></script>
    <script src="<?=base_url()?>/assets/site_user/js/vendor/bootstrap.min.js"></script>
	<script type="text/javascript">

    $(document).ready(function(){

        $('.add_cart').click(function(){
            var user_id = $(this).data("user");
            var product_id    = $(this).data("productid");

            var product_name  = $(this).data("productname");

            var product_price = $(this).data("productprice");

            var product_owner = $(this).data("productowner");

            var quantity      = $('#' + product_id).val();

            var qty = $(this).data("productqty");
            if (user_id == 0) {
               alert('يرجى تسجيل الدخول');exit();
            }
            if (qty <= 0) {
               alert('منتج غير متوفر');exit();
            }

            $.ajax({

                url : "<?php echo site_url('site_user/shopping_cart/add_to_cart');?>",

                method : "POST",

                data : {product_id: product_id, product_name: product_name, product_owner: product_owner, product_price: product_price, quantity: quantity},

                // success: function(data){

                //     $('#detail_cart').html(data);

                // }

                success: function(){

                    alert('تمت اضافة المنتج بنجاح');

                },

                error: function(){

                    alert('failure');

                }

            });

        });



        

        $('#detail_cart').load("<?php echo site_url('product/load_cart');?>");



        

        $(document).on('click','.romove_cart',function(){

            var row_id=$(this).attr("id"); 

            $.ajax({

                url : "<?php echo site_url('site_user/shopping_cart/delete_cart');?>",

                method : "POST",

                data : {row_id : row_id},

                // success :function(data){

                //     $('#detail_cart').html(data);

                // }

                success: function(){

                    alert('تم حذف المنتج من السلة لنجاح');

                    location.reload();

                },

                error: function(){

                    alert('failure');

                }

            });

        });

    });

</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script> 
<script type="text/javascript">
	toastr.options = {
	  "closeButton": true,
	  "debug": false,
	  "newestOnTop": false,
	  "progressBar": false,
	  "positionClass": "toast-top-right",
	  "preventDuplicates": true,
	  "onclick": null,
	  "showDuration": "300",
	  "hideDuration": "1000",
	  "timeOut": "2000",
	  "extendedTimeOut": "1000",
	  "showEasing": "swing",
	  "hideEasing": "linear",
	  "showMethod": "fadeIn",
	  "hideMethod": "fadeOut"
	}

	$('input.typeahead').typeahead({
        source:  function (query, process) {
        return $.get('<?=base_url();?>site_user/products/auto_search', { query: query }, function (data) {
                console.log(data);
                data = $.parseJSON(data);
                return process(data);
            });
        }
    });
	
	function final_total(id){
		$(':input[type="submit"]').prop('disabled', true);
		setTimeout(function(){
		var sub = $('#sub_'+id).text();
		var tax = $('#general_tax').val()*sub;
		//alert(tax);
		var delivery = $('#delivery_'+id).text();
		var sum = +sub + +tax + +delivery;
		//alert(sum);
		///Sum Tax
		$('#tax_'+id).html('');
		$('#tax_'+id).html(Math.round(tax));
		$('#taxs_'+id).val('');
		$('#taxs_'+id).val(Math.round(tax));
		///END Sum Tax
		$('#final_total_'+id).html('');
		var total = $('#final_total_'+id).html(sum);
		$('#total'+id).val('');
		$('#total'+id).val(sum);
		
		$(':input[type="submit"]').prop('disabled', false);
		}, 500);
		/*setTimeout(function(){
			finshed_total();
		}, 1000);*/
	}
	
	function final_sub_total(id){
		setTimeout(function(){
		var sub = $('#sub_'+id).text();
		var tax = $('#tax_'+id).text();
		var delivery = $('#delivery_'+id).text();
		var sum = +sub + +tax + +delivery;
		//alert(sum);
		$('#final_total_'+id).html('');
		var total = $('#final_total_'+id).html(sum);
		$('#total'+id).val('');
		$('#total'+id).val(sum);
		}, 500);
		/*setTimeout(function(){
			finshed_total();
		}, 1000);*/
	}
	
	function owner_total(id){
		$.ajax({
				url: '<?=base_url();?>site_user/Shopping_cart/get_sub_total', // returns "[1,2,3,4,5,6]"
				type: "POST",
				data:{id:id},
				dataType: 'json', // jQuery will parse the response as JSON
				success: function (data) {
					console.log(data);
					//alert('#sub_'+id);
					$('#sub_'+id).html('');
					$('#sub_'+id).html(data.msg);
					///SUM Tax
					var sub = $('#sub_'+id).text();
					var tax = $('#general_tax').val()*sub;
					$('#tax_'+id).html('');
					$('#tax_'+id).html(Math.round(tax));
					$('#taxs_'+id).val('');
					$('#taxs_'+id).val(Math.round(tax));
					///End SUM Tax
					$('#sub_total'+id).val('');
					$('#sub_total'+id).val(data.msg);
				}
				
			});
	}
	
	function change_order_status(order_id,id,msg){
		if (confirm('هل أنت متأكد من '+msg)) {
			$.ajax({
				url: '<?=base_url();?>site_merchant/orders/change_order_status', // returns "[1,2,3,4,5,6]"
				type: "POST",
				data:{order_id:order_id,id:id},
				dataType: 'json', // jQuery will parse the response as JSON
				success: function (data) {
					alert(data.msg); // alert the 0th value
					window.location = "<?=base_url();?>site_merchant/orders/";

				}
			});
		} else {
			// Do nothing!
			//alert('no');
		}
	}
	
	function change_qty(rowid,qty,owner){
		$(':input[type="submit"]').prop('disabled', true);
		$.ajax({
				url: '<?=base_url();?>site_user/Shopping_cart/update_item', // returns "[1,2,3,4,5,6]"
				type: "POST",
				data:{rowid:rowid,qty:qty},
				dataType: 'json', // jQuery will parse the response as JSON
				success: function (data) {
					//console.log(data);
					//alert(data.msg);
					toastr.info(data.msg);
					//toastr.clear();
					$(':input[type="submit"]').prop('disabled', false);
				}
			});
			final_total(owner);
		
	}
	
	function update_qty(rowid,qty,owner,max){
		//alert($('qty_'+rowid).max);
		if($('#qty_'+rowid).length === 0 || $('#qty_'+rowid).val() <= 0) {
				$('#qty_'+rowid).val(1);
				change_qty(rowid,1,owner);
		}else if($('#qty_'+rowid).val() > max){
			$('#qty_'+rowid).val(max);
			change_qty(rowid,max,owner);
			toastr.warning('أقصي كمية متاحة '+max);
		}
		else{
			change_qty(rowid,qty,owner);
		}
	}
	
	function get_subtotal(rowid,id,owner){
		//alert(rowid+" "+qty);
		setTimeout(function(){
		$.ajax({
				url: '<?=base_url();?>site_user/Shopping_cart/get_subtotal', // returns "[1,2,3,4,5,6]"
				type: "POST",
				data:{rowid:rowid},
				dataType: 'json', // jQuery will parse the response as JSON
				success: function (data) {
					//console.log(data);
					$('#pro_'+id).html('');
					$('#pro_'+id).html(data.msg);
				}
			});
			owner_total(owner);
			final_total(owner);
		}, 1000);
	}
	
	
	
	function change_delivery(owner){
		var radios = document.getElementsByName('delivering_'+owner);
		for (var i = 0, length = radios.length; i < length; i++)
		{
			if (radios[i].checked)
				{
					// do whatever you want with the checked radio
					$('#delivery_'+owner).html('');
					$('#delivery_'+owner).html(radios[i].value);
					$('#method_'+owner).val('');
					$('#method_'+owner).val(radios[i].id);
					//alert(radios[i].value);
					// only one radio can be logically checked, don't check the rest
					break;
				}
		}
		final_total(owner);
		//alert(radios);
	}
	
	function collapse(){
		$('#collapseTwo').removeClass("collapse show");
		$('#collapseTwo').addClass("collapse");
	}
	
</script>
<script type="text/javascript">
	function alert_toastr(type,msg){
		return "toastr."+type+"("+msg+")";
	}
    var baseurl = "<?=base_url(); ?>";
    $( document ).on( 'click', '#send', function ( e ) {
    e.preventDefault();
    //hide response if it's visible
    $( '#response' ).hide();
    //we grab all fields values to create our email
    var email = $( '#email' ).val();
    // console.log(email);
    if (email === '')
    {
        //all fields are rquired so if one of them is empty the function returns
        $( '#response' ).html('البريد الالكتروني حقل مطلوب').fadeIn( 'slow' ).delay( 3000 ).fadeOut( 'slow' );
        return;
    }
    //if it's all right we proceed
    $.ajax( {
        type: 'POST',
        //our baseurl variable in action will call a method in our default controller
        url: baseurl + 'home/news_letter',
        dataType: 'json',
        data: {email: email},
        success: function (data) {
                    // console.log(data.type);
                    //alert(data.msg);
					console.log(data.type);
                    var type = data.type;
					//var toastr = "toastr."+type+(data.msg)
					//alert(type);
					Command: toastr['info'](data.msg);
					
					//alert_toastr(type,data.msg);
					//return toastr;
					//return type;
					//Command: toastr[""+type+""](""+data.msg+"");
                    //toastr.+type+(data.msg);
                    //toastr.clear();
                }
    } );
} ); 
</script>
</body>



</html>