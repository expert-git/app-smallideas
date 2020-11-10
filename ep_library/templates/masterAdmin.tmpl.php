<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <link rel="icon" type="image/png" href="/favicon.png">
        <meta content="" name="description" />
        <meta content="" name="author" />
		
		<link rel="apple-touch-icon" sizes="152×152" href="/smallideas152.png">
		<link rel="apple-touch-icon" sizes="167×167" href="/smallideas167.png">
		
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="/theme/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="/theme/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="/theme/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="/theme/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="/theme/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
        <link href="/theme/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />            
        <link href="/theme/assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css" /> 
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="/theme/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="/theme/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="/theme/assets/layouts/layout2/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="/theme/assets/layouts/layout2/css/themes/blue.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="/theme/assets/layouts/layout2/css/custom.min.css" rel="stylesheet" type="text/css" />

        <!-- CUSTOM -->
        <?= $pagelevelCSS; ?>

        <link href="/css/style.css?v=30" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> 
        <script> var notice = ''; </script>
    </head>
    <!-- END HEAD -->

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">
        <!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner ">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                    <a href="/manager/">
                        <img src="/images/smallideas90w.png" alt="logo" class="logo-default" height="45" /> </a>
                    <div class="menu-toggler sidebar-toggler">
                        <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
                    </div>
                </div>
                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
                <!-- END RESPONSIVE MENU TOGGLER -->
                
                <!-- BEGIN PAGE TOP -->
                <div class="page-top">
                  
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">
                                                     
                            <!-- BEGIN USER LOGIN DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                            <li class="dropdown dropdown-user">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <img alt="" class="img-circle" src="/images/avatar.png" />
                                    <span class="username username-hide-on-mobile"> <?= $_SESSION['username'] ?> </span>
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">                                   
                                    <li>
                                        <a href="/?logout=1">
                                            <i class="icon-key"></i> Log Out </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- END USER LOGIN DROPDOWN -->
                            
                        </ul>
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
                <!-- END PAGE TOP -->
            </div>
            <!-- END HEADER INNER -->
        </div>
        <!-- END HEADER -->
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                <!-- END SIDEBAR -->
                <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                <div class="page-sidebar navbar-collapse collapse">
                    <!-- BEGIN SIDEBAR MENU -->
                    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                        

                        <li class="nav-item start <? if($activeTab=='users') echo 'active open'; ?>">
                            <a href="/manager/" class="nav-link nav-toggle">
                                <i class="icon-users"></i>
                                <span class="title">Edit Users</span>
                                <span class="arrow"></span>
                            </a>                          
                        </li>

                        <li class="nav-item start <? if($activeTab=='vouchers') echo 'active open'; ?>">
                            <a href="/manager/vouchers.php" class="nav-link nav-toggle">
                                <i class="icon-tag"></i>
                                <span class="title">Edit Vouchers</span>
                                <span class="arrow"></span>
                            </a>                          
                        </li>
						<li class="nav-item start <? if($activeTab=='vouchersPdf') echo 'active open'; ?>">
                            <a href="/manager/vouchers-pdf.php" class="nav-link nav-toggle">
                                <i class="icon-tag"></i>
                                <span class="title">Vouchers PDF</span>
                                <span class="arrow"></span>
                            </a>                          
                        </li>
						<li class="nav-item start <? if($activeTab=='vouchersOrder') echo 'active open'; ?>">
                            <a href="/manager/orders.php" class="nav-link nav-toggle">
                                <i class="icon-tag"></i>
                                <span class="title">Orders</span>
                                <span class="arrow"></span>
                            </a>                          
                        </li>
						
                        <li class="nav-item start <? if($activeTab=='stats') echo 'active open'; ?>">
                            <a href="/manager/stats.php?year=<?= date('Y') ?>&month=<?= date('m'); ?>" class="nav-link nav-toggle">
                                <i class="icon-bar-chart"></i>
                                <span class="title">Stats</span>
                                <span class="arrow"></span>
                            </a>                          
                        </li>
               
   
                       
                    </ul>
                    <!-- END SIDEBAR MENU -->
                </div>
                <!-- END SIDEBAR -->
            </div>
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">

                   
                        <?= $content ?>                

                    
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
           
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <div class="page-footer">
            <div class="page-footer-inner"> 2017 &copy; | For Help &amp; Support contact
                <a target="_blank" href="https://www.entice.com.au">Entice Website Design</a> 
                <div class="scroll-to-top">
                    <i class="icon-arrow-up"></i>
                </div>
            </div>
            <!-- END FOOTER -->
            <!--[if lt IE 9]>
<script src="/theme/assets/global/plugins/respond.min.js"></script>
<script src="/theme/assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
            <!-- BEGIN CORE PLUGINS -->
            <script src="/theme/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
            <script src="/theme/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
            <script src="/theme/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
            <script src="/theme/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
            <script src="/theme/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
            <script src="/theme/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
            <!-- END CORE PLUGINS -->
            <!-- BEGIN PAGE LEVEL PLUGINS -->
            
            
            <script src="/theme/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
            <script src="/theme/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>

            <script src="/theme/assets/global/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
			<script src="/theme/assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js" type="text/javascript"></script>
            <!-- END PAGE LEVEL PLUGINS -->
            <!-- BEGIN THEME GLOBAL SCRIPTS -->
            <script src="/theme/assets/global/scripts/app.min.js" type="text/javascript"></script>
            <!-- END THEME GLOBAL SCRIPTS -->
            <!-- BEGIN PAGE LEVEL SCRIPTS -->
            <?= $pagelevelScripts ?>            
            <!-- END PAGE LEVEL SCRIPTS -->
            <!-- BEGIN THEME LAYOUT SCRIPTS -->
            <script src="/theme/assets/layouts/layout2/scripts/layout.min.js" type="text/javascript"></script>
            <script src="/theme/assets/layouts/layout2/scripts/demo.min.js" type="text/javascript"></script>
			
            
            <script src="/js/service.js?v=2.2" type="text/javascript"></script>
            <!-- END THEME LAYOUT SCRIPTS -->
    </body>

</html>