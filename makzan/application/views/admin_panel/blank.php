<?php $login_data = $this->session->userdata('login_data');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?=$title?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <!-- Favicon icon -->
    <link rel="icon" href="<?=base_url()?>assets/admin_panel/images/favicon.ico" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/bower_components/bootstrap/css/bootstrap.min.css">
     <!-- sweet alert framework -->
     <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/bower_components/sweetalert/css/sweetalert.css">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/icon/themify-icons/themify-icons.css">
    <!-- simple line icon -->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/icon/simple-line-icons/css/simple-line-icons.css">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/icon/icofont/css/icofont.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/icon/font-awesome/css/font-awesome.min.css">
    <!-- animation nifty modal window effects css -->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/css/component.css">
    <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/pages/data-table/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">
    <!-- Syntax highlighter Prism css -->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/pages/prism/prism.css">
    <!-- notify js Fremwork -->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/bower_components/pnotify/css/pnotify.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/bower_components/pnotify/css/pnotify.brighttheme.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/bower_components/pnotify/css/pnotify.buttons.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/bower_components/pnotify/css/pnotify.history.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/bower_components/pnotify/css/pnotify.mobile.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/assets/pages/pnotify/notify.css">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/css/jquery.mCustomScrollbar.css">
    <link rel="stylesheet" media="screen" href="https://fontlibrary.org/face/droid-arabic-kufi" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/icon/typicons-icons/css/typicons.min.css">
    <!-- ion icon css -->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/icon/ion-icon/css/ionicons.min.css">
    <!-- Material Icon -->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/icon/material-design/css/material-design-iconic-font.min.css">
    <!-- jquery file upload Frame work -->
    <link href="<?=base_url()?>assets/admin_panel/pages/jquery.filer/css/jquery.filer.css" type="text/css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/admin_panel/pages/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css" type="text/css" rel="stylesheet" />
    <!-- star theme css -->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/bower_components/jquery-bar-rating/css/bars-1to10.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/bower_components/jquery-bar-rating/css/bars-horizontal.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/bower_components/jquery-bar-rating/css/bars-movie.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/bower_components/jquery-bar-rating/css/bars-pill.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/bower_components/jquery-bar-rating/css/bars-reversed.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/bower_components/jquery-bar-rating/css/bars-square.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/bower_components/jquery-bar-rating/css/css-stars.css">
    <!-- slick css -->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/bower_components/slick-carousel/css/slick.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/bower_components/slick-carousel/css/slick-theme.css">



</head>
<!-- Menu rtl layout -->

<body style="font-family: DroidArabicKufiRegular">
    <!-- Pre-loader start -->
    <div class="theme-loader">
        <div class="loader-track">
            <div class="loader-bar"></div>
        </div>
    </div>
    <!-- Pre-loader end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
            <nav class="navbar header-navbar pcoded-header">
                <div class="navbar-wrapper">
                    <div class="navbar-logo">
                        <a class="mobile-menu" id="mobile-collapse" href="#!">
                            <i class="ti-menu"></i>
                        </a>
                        <div class="mobile-search">
                            <div class="header-search">
                                <div class="main-search morphsearch-search">
                                    <div class="input-group">
                                        <span class="input-group-addon search-close"><i class="ti-close"></i></span>
                                        <input type="text" class="form-control" placeholder="Enter Keyword">
                                        <span class="input-group-addon search-btn"><i class="ti-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="index.html">
                            <!-- <img class="img-fluid" src="<?=base_url()?>assets/admin_panel/images/logo.png" alt="Theme-Logo" /> -->
                        </a>
                        <a class="mobile-options">
                            <i class="ti-more"></i>
                        </a>
                    </div>

                    <div class="navbar-container container-fluid">
                        <ul class="nav-left">
                            <li>
                                <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
                            </li>
                        </ul>
                        <ul class="nav-right">
                            <li class="user-profile header-notification">
                                <a>
                                    <?php if ($login_data['img'] == null ) { ?>
                                    <img src="<?=base_url()?>assets/uploads/files/arab.png" class="img-radius" alt="User-Profile-Image"> 
                                    <?php }else{ ?>
                                    <img src="<?=base_url('assets/uploads/files/'.$login_data['img'])?>" class="img-radius" alt="User-Profile-Image"> 
                                    <?php } ?>
                                    <span><?=$login_data['full_name']?></span>
                                    <i class="ti-angle-down"></i>
                                </a>
                                <ul class="show-notification profile-notification">
                                    <li>
                                        <a href="<?=base_url('admin_panel/settings')?>">
                                            <i class="ti-settings"></i>اعدادات عامة
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?=base_url('admin_panel/users/edit/'.$login_data['user_id'])?>">
                                            <i class="ti-user"></i> حسابي
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?=base_url('admin_panel/login/logout')?>">
                                        <i class="ti-layout-sidebar-left"></i> تسجيل الخروج
                                    </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <nav class="pcoded-navbar">
                        <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
                        <div class="pcoded-inner-navbar main-menu">
                            <div class="pcoded-navigation-label"></div>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="<?php if($this->uri->segment(2) == 'dashboard') echo'active'; ?>">
                                    <a href="<?=base_url('admin_panel/dashboard')?>">
                                        <span class="pcoded-micon"><i class="fa fa-area-chart"></i><b></b></span>
                                        <span class="pcoded-mtext">الاحصائيات</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li class="<?php if($this->uri->segment(2) == 'countries') echo'active'; ?>">
                                    <a href="<?=base_url('admin_panel/countries')?>">
                                        <span class="pcoded-micon"><i class="fa fa-globe"></i><b></b></span>
                                        <span class="pcoded-mtext">الدول</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li class="<?php if($this->uri->segment(2) == 'cities') echo'active'; ?>">
                                    <a href="<?=base_url('admin_panel/cities')?>">
                                        <span class="pcoded-micon"><i class="fa fa-map-signs"></i><b></b></span>
                                        <span class="pcoded-mtext">المدن</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li class="<?php if($this->uri->segment(2) == 'pages') echo'active'; ?>">
                                    <a href="<?=base_url('admin_panel/pages')?>">
                                        <span class="pcoded-micon"><i class="icofont icofont-page"></i><b></b></span>
                                        <span class="pcoded-mtext">الصفحات الفرعية</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li class="<?php if($this->uri->segment(2) == 'categories') echo'active'; ?>">
                                    <a href="<?=base_url('admin_panel/categories')?>">
                                        <span class="pcoded-micon"><i class="fa fa-google-wallet"></i><b></b></span>
                                        <span class="pcoded-mtext">تصنيفات المنتجات</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li class="<?php if($this->uri->segment(2) == 'tickets_types') echo'active'; ?>">
                                    <a href="<?=base_url('admin_panel/tickets_types')?>">
                                        <span class="pcoded-micon"><i class="fa fa-paper-plane"></i><b></b></span>
                                        <span class="pcoded-mtext">انواع التذاكر</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li class="<?php if($this->uri->segment(2) == 'delivering_methods') echo'active'; ?>">
                                    <a href="<?=base_url('admin_panel/delivering_methods')?>">
                                        <span class="pcoded-micon"><i class="fa fa-truck"></i><b></b></span>
                                        <span class="pcoded-mtext">طرق التوصيل</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li class="<?php if($this->uri->segment(2) == 'products') echo'active'; ?>">
                                    <a href="<?=base_url('admin_panel/products')?>">
                                        <span class="pcoded-micon"><i class="fa fa-cubes"></i><b></b></span>
                                        <span class="pcoded-mtext">المنتجات</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <!-- <li class="<?php if($this->uri->segment(2) == 'orders') echo'active'; ?>">
                                    <a href="<?=base_url('admin_panel/orders')?>">
                                        <span class="pcoded-micon"><i class="fa fa-shopping-cart"></i><b></b></span>
                                        <span class="pcoded-mtext">طلبات العملاء</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li> -->
                                <li class="pcoded-hasmenu <?php if($this->uri->segment(2) == 'orders') echo'active'; ?>">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="ti-shopping-cart"></i><b></b></span>
                                        <span class="pcoded-mtext">طلبات العملاء</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="<?php if($this->uri->segment(2) == 'orders' && $this->uri->segment(3) == 'index'  && $this->uri->segment(4) == 'new') echo'active'; ?>">
                                            <a href="<?=base_url('admin_panel/orders/index/new')?>">
                                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                <span class="pcoded-mtext">الطلبات الجديدة</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        <li class="<?php if($this->uri->segment(2) == 'orders' && $this->uri->segment(3) == 'index'  && $this->uri->segment(4) == 'confirmed') echo'active'; ?>">
                                            <a href="<?=base_url('admin_panel/orders/index/confirmed')?>">
                                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                <span class="pcoded-mtext">الطلبات الموافق عليها</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>

                                        <li class="<?php if($this->uri->segment(2) == 'orders' && $this->uri->segment(3) == 'index'  && $this->uri->segment(4) == 'rejected') echo'active'; ?>">
                                            <a href="<?=base_url('admin_panel/orders/index/rejected')?>">
                                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                <span class="pcoded-mtext">الطلبات المرفوضة</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>

                                    </ul>
                                </li>
                                <li class="pcoded-hasmenu <?php if($this->uri->segment(2) == 'tickets') echo'active'; ?>">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="fa fa-users"></i><b></b></span>
                                        <span class="pcoded-mtext">التذاكر</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="pcoded-hasmenu <?php if($this->uri->segment(2) == 'tickets' && $this->uri->segment(5) == '0') echo'active'; ?>">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                <span class="pcoded-mtext">التجار</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <li class="<?php if($this->uri->segment(2) == 'tickets' && $this->uri->segment(3) == 'index'  && $this->uri->segment(4) == '1' && $this->uri->segment(5) == '0') echo'active'; ?>">
                                                    <a href="<?=base_url('admin_panel/tickets/index/1/0')?>">
                                                        <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                        <span class="pcoded-mtext">المقروءة</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                                <li class="<?php if($this->uri->segment(2) == 'tickets' && $this->uri->segment(3) == 'index'  && $this->uri->segment(4) == '0' && $this->uri->segment(5) == '0') echo'active'; ?>">
                                                    <a href="<?=base_url('admin_panel/tickets/index/0/0')?>">
                                                        <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                        <span class="pcoded-mtext">الغير مقروءة</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="pcoded-hasmenu <?php if($this->uri->segment(2) == 'tickets' && $this->uri->segment(5) == '1') echo'active'; ?>">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                <span class="pcoded-mtext">العملاء</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                               <li class="<?php if($this->uri->segment(2) == 'tickets' && $this->uri->segment(3) == 'index'  && $this->uri->segment(4) == '1' && $this->uri->segment(5) == '1') echo'active'; ?>">
                                                    <a href="<?=base_url('admin_panel/tickets/index/1/1')?>">
                                                        <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                        <span class="pcoded-mtext">المقروءة</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                                <li class="<?php if($this->uri->segment(2) == 'tickets' && $this->uri->segment(3) == 'index'  && $this->uri->segment(4) == '0' && $this->uri->segment(5) == '1') echo'active'; ?>">
                                                    <a href="<?=base_url('admin_panel/tickets/index/0/1')?>">
                                                        <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                        <span class="pcoded-mtext">الغير مقروءة</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>

                                    </ul>
                                </li>
                                <li class="pcoded-hasmenu <?php if($this->uri->segment(2) == 'customers' || $this->uri->segment(2) == 'customers') echo'active'; ?>">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="fa fa-users"></i><b></b></span>
                                        <span class="pcoded-mtext">أعضاء التطبيق</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                       <li class="pcoded-hasmenu <?php if($this->uri->segment(2) == 'customers') echo'active'; ?>">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                <span class="pcoded-mtext">العملاء</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <li class="<?php if($this->uri->segment(2) == 'customers' && $this->uri->segment(3) == 'index'  && $this->uri->segment(4) == '') echo'active'; ?>">
                                                    <a href="<?=base_url('admin_panel/customers')?>">
                                                        <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                        <span class="pcoded-mtext">الكل</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                                <li class="<?php if($this->uri->segment(2) == 'customers' && $this->uri->segment(3) == 'index'  && $this->uri->segment(4) == 'activated') echo'active'; ?>">
                                                    <a href="<?=base_url('admin_panel/customers/index/activated')?>">
                                                        <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                        <span class="pcoded-mtext">المفعلين</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                                <li class="<?php if($this->uri->segment(2) == 'customers' && $this->uri->segment(3) == 'index'  && $this->uri->segment(4) == 'deactivated') echo'active'; ?>">
                                                    <a href="<?=base_url('admin_panel/customers/index/deactivated')?>">
                                                        <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                        <span class="pcoded-mtext">الغير مفعلين</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="pcoded-hasmenu <?php if($this->uri->segment(2) == 'merchants') echo'active'; ?>">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                <span class="pcoded-mtext">اصحاب المتاجر</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <li class="<?php if($this->uri->segment(2) == 'merchants' && $this->uri->segment(3) == 'index'  && $this->uri->segment(4) == '') echo'active'; ?>">
                                                    <a href="<?=base_url('admin_panel/merchants')?>">
                                                        <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                        <span class="pcoded-mtext">الكل</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                                <li class="<?php if($this->uri->segment(2) == 'merchants' && $this->uri->segment(3) == 'index'  && $this->uri->segment(4) == 'activated') echo'active'; ?>">
                                                    <a href="<?=base_url('admin_panel/merchants/index/activated')?>">
                                                        <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                        <span class="pcoded-mtext">المفعلين</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                                <li class="<?php if($this->uri->segment(2) == 'merchants' && $this->uri->segment(3) == 'index'  && $this->uri->segment(4) == 'deactivated') echo'active'; ?>">
                                                    <a href="<?=base_url('admin_panel/merchants/index/deactivated')?>">
                                                        <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                        <span class="pcoded-mtext">الغير مفعلين</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>

                                    </ul>
                                </li>
                                <li class="<?php if($this->uri->segment(2) == 'withdraw_balance') echo'active'; ?>">
                                    <a href="<?=base_url('admin_panel/withdraw_balance')?>">
                                        <span class="pcoded-micon"><i class="fa fa-money"></i><b></b></span>
                                        <span class="pcoded-mtext">طلبات سحب الرصيد</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li class="<?php if($this->uri->segment(2) == 'news_letter') echo'active'; ?>">
                                    <a href="<?=base_url('admin_panel/news_letter')?>">
                                        <span class="pcoded-micon"><i class="fa fa-envelope"></i><b></b></span>
                                        <span class="pcoded-mtext">مشتركي القائمة البريدية</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                            </ul>
                            <div class="pcoded-navigation-label">الاعدادات</div>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="<?php if($this->uri->segment(2) == 'settings') echo'active'; ?>">
                                    <a href="<?=base_url('admin_panel/settings')?>">
                                        <span class="pcoded-micon"><i class="fa fa-cogs"></i><b></b></span>
                                        <span class="pcoded-mtext">اعدادات عامة</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li class="<?php if($this->uri->segment(2) == 'users') echo'active'; ?>">
                                    <a href="<?=base_url('admin_panel/users')?>">
                                        <span class="pcoded-micon"><i class="fa fa-user-secret"></i><b></b></span>
                                        <span class="pcoded-mtext">المستخدمين</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li class="<?php if($this->uri->segment(2) == 'bank_accounts') echo'active'; ?>">
                                    <a href="<?=base_url('admin_panel/bank_accounts')?>">
                                        <span class="pcoded-micon"><i class="fa fa-dollar"></i><b></b></span>
                                        <span class="pcoded-mtext">الحسابات البنكية</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li class="<?php if($this->uri->segment(2) == 'slider') echo'active'; ?>">
                                    <a href="<?=base_url('admin_panel/slider')?>">
                                        <span class="pcoded-micon"><i class="fa fa-image"></i><b></b></span>
                                        <span class="pcoded-mtext">سلايدر الصور</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li class="<?php if($this->uri->segment(2) == 'ads') echo'active'; ?>">
                                    <a href="<?=base_url('admin_panel/ads')?>">
                                        <span class="pcoded-micon"><i class="fa fa-buysellads"></i><b></b></span>
                                        <span class="pcoded-mtext">الاعلانات</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                    <div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <!-- Main-body start -->
                            <div class="main-body">
                                <div class="page-wrapper">
                                    <!-- Page body start -->
                                            <?php $this->load->view($main_content); ?>
                                    <!-- Page body end -->
                                </div>
                            </div>
                            <!-- Main-body end -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Warning Section Ends -->
    <!-- Required Jquery -->
    <script  src="<?=base_url()?>assets/admin_panel/bower_components/jquery/js/jquery.min.js"></script>
    <script  src="<?=base_url()?>assets/admin_panel/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
    <script  src="<?=base_url()?>assets/admin_panel/bower_components/popper.js/js/popper.min.js"></script>
    <script  src="<?=base_url()?>assets/admin_panel/bower_components/bootstrap/js/bootstrap.min.js"></script>
    <!-- jquery slimscroll js -->
    <script  src="<?=base_url()?>assets/admin_panel/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
    <!-- modernizr js -->
    <script  src="<?=base_url()?>assets/admin_panel/bower_components/modernizr/js/modernizr.js"></script>
    <script  src="<?=base_url()?>assets/admin_panel/bower_components/modernizr/js/css-scrollbars.js"></script>
    <!-- Syntax highlighter prism js -->
    <script  src="<?=base_url()?>assets/admin_panel/pages/prism/custom-prism.js"></script>
    <!-- Custom js -->
    <script src="<?=base_url()?>assets/admin_panel/js/pcoded.min.js"></script>
    <script src="<?=base_url()?>assets/admin_panel/js/vertical/menu/menu-rtl.js"></script>
    <script src="<?=base_url()?>assets/admin_panel/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script  src="<?=base_url()?>assets/admin_panel/js/script.js"></script>
    <script  src="<?=base_url()?>assets/admin_panel/js/particles.js"></script>
     <!-- data-table js -->
    <script src="<?=base_url()?>assets/admin_panel/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?=base_url()?>assets/admin_panel/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?=base_url()?>assets/admin_panel/pages/data-table/js/jszip.min.js"></script>
    <script src="<?=base_url()?>assets/admin_panel/pages/data-table/js/pdfmake.min.js"></script>
    <script src="<?=base_url()?>assets/admin_panel/pages/data-table/js/vfs_fonts.js"></script>
    <script src="<?=base_url()?>assets/admin_panel/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?=base_url()?>assets/admin_panel/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?=base_url()?>assets/admin_panel/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?=base_url()?>assets/admin_panel/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?=base_url()?>assets/admin_panel/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <!-- Custom js -->
    <script src="<?=base_url()?>assets/admin_panel/pages/data-table/js/data-table-custom.js"></script>
    <!-- sweet alert js -->
    <script  src="<?=base_url()?>assets/admin_panel/bower_components/sweetalert/js/sweetalert.min.js"></script>
    <script  src="<?=base_url()?>assets/admin_panel/js/modal.js"></script>
    <!-- sweet alert modal.js intialize js -->
    <!-- modalEffects js nifty modal window effects -->
    <script src="<?=base_url()?>assets/admin_panel/js/classie.js"></script>
    <script  src="<?=base_url()?>assets/admin_panel/js/modalEffects.js"></script>
    <!-- Bootstrap date-time-picker js -->
    <script  src="<?=base_url()?>assets/admin_panel/pages/advance-elements/moment-with-locales.min.js"></script>
    <script  src="<?=base_url()?>assets/admin_panel/bower_components/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script  src="<?=base_url()?>assets/admin_panel/pages/advance-elements/bootstrap-datetimepicker.min.js"></script>
    <!-- Date-range picker js -->
    <script  src="<?=base_url()?>assets/admin_panel/bower_components/bootstrap-daterangepicker/js/daterangepicker.js"></script>
    <!-- Date-dropper js -->
    <script  src="<?=base_url()?>assets/admin_panel/bower_components/datedropper/js/datedropper.min.js"></script>
    <!-- ck editor -->
    <script src="<?=base_url()?>assets/admin_panel/pages/ckeditor/ckeditor.js"></script>
    <!-- echart js -->
    <script src="<?=base_url()?>assets/admin_panel/pages/user-profile.js"></script>
    <!-- pnotify js -->
    <script  src="<?=base_url()?>assets/admin_panel/bower_components/pnotify/js/pnotify.js"></script>
    <script  src="<?=base_url()?>assets/admin_panel/bower_components/pnotify/js/pnotify.desktop.js"></script>
    <script  src="<?=base_url()?>assets/admin_panel/bower_components/pnotify/js/pnotify.buttons.js"></script>
    <script  src="<?=base_url()?>assets/admin_panel/bower_components/pnotify/js/pnotify.confirm.js"></script>
    <script  src="<?=base_url()?>assets/admin_panel/bower_components/pnotify/js/pnotify.callbacks.js"></script>
    <script  src="<?=base_url()?>assets/admin_panel/bower_components/pnotify/js/pnotify.animate.js"></script>
    <script  src="<?=base_url()?>assets/admin_panel/bower_components/pnotify/js/pnotify.history.js"></script>
    <script  src="<?=base_url()?>assets/admin_panel/bower_components/pnotify/js/pnotify.mobile.js"></script>
    <script  src="<?=base_url()?>assets/admin_panel/bower_components/pnotify/js/pnotify.nonblock.js"></script>
    <script  src="<?=base_url()?>assets/admin_panel/pages/pnotify/notify.js"></script>
    <script src="<?=base_url()?>assets/admin_panel/pages/wysiwyg-editor/js/tinymce.min.js"></script>
    <script src="<?=base_url()?>assets/admin_panel/pages/wysiwyg-editor/wysiwyg-editor.js"></script>
    <!-- jquery file upload js -->
    <script src="<?=base_url()?>assets/admin_panel/pages/jquery.filer/js/jquery.filer.min.js"></script>
    <script src="<?=base_url()?>assets/admin_panel/pages/filer/custom-filer.js" ></script>
    <script src="<?=base_url()?>assets/admin_panel/pages/filer/jquery.fileuploads.init.js" ></script>
    <!-- Model animation js -->
    <script src="<?=base_url()?>assets/admin_panel/js/classie.js"></script>
    <script src="<?=base_url()?>assets/admin_panel/js/modalEffects.js"></script>
    <!-- product list js -->
    <script  src="<?=base_url()?>assets/admin_panel/pages/product-list/product-list.js"></script>
     <!-- barrating js -->
    <script  src="<?=base_url()?>assets/admin_panel/bower_components/jquery-bar-rating/js/jquery.barrating.min.js"></script>
    <script  src="<?=base_url()?>assets/admin_panel/pages/rating/rating.js"></script>
    <!-- slick js -->
    <script  src="<?=base_url()?>assets/admin_panel/bower_components/slick-carousel/js/slick.min.js"></script>
    <!-- product detail js -->
    <script  src="<?=base_url()?>assets/admin_panel/pages/product-detail/product-detail.js"></script>
    <!-- task board js -->
    <script  src="<?=base_url()?>assets/admin_panel/pages/task-board/task-board.js"></script>
</body>

</html>
