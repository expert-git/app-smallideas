<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.6
Version: 4.6
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com

-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>Small Ideas</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,600&subset=all" rel="stylesheet" type="text/css" />        
        <link href="/theme/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

        <link href="/theme/assets/global/plugins/ladda/ladda-themeless.min.css" rel="stylesheet" type="text/css" />
        
        <!-- END GLOBAL MANDATORY STYLES -->
                
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="/theme/assets/pages/css/login.min.css" rel="stylesheet" type="text/css" />
        <style>
            h4 {color:#364150 !important;text-align:center;font-size:20px;margin-bottom:16px;}
            body.login {background-color:none;background:url(/images/bg1280.jpg) no-repeat top center!important;}
			 body.login.edition2018 {background-color:none;background:url(/images/background2018.jpg) no-repeat top center!important;}
            .login .content {margin-top:20px;}
            .login .content.homescreen {text-align:center;padding-bottom:15px;}
            .login .content .form-control {background-color:#eee;border-color:#eee;}
            .login .content .form-actions {padding-bottom:0;padding-top:0;border:0;}
            
            .login-content{padding-bottom:0;}
            a {color:#2da6c8;}
            .btn.blue:not(.btn-outline){
                color: #FFF;                
                background-color:#2da6c8;
                border-color: #2da6c8;
            }
            .btn.blue:not(.btn-outline):hover{
                background-color: #78d0e9;
                border-color: #78d0e9;
            }
            .form-control {outline: 0 !important;}
            a, button, code, div, img, input, label, li, p, pre, select, span, svg, table, td, textarea, th, ul {border-radius: 0 !important;}
            .btn, .form-control {
                box-shadow: none !important;
            }
            body, h1, h2, h3, h4, h5, h6 {
            font-family: "Open Sans",sans-serif;
            }

            .control-label{
                margin-top: 1px;
                font-weight: 400;
            }
            .visible-ie9{
                display: none;
            }
            label {
                font-weight: 400;
            }
            .account {color:#111;text-align:center;}
            /*.account a {color:#111;text-decoration:underline;}
            .account a:hover {color:#777;text-decoration:none;}*/
			
			.created, .created a {text-align:center;color:#111;}
			.created a {text-decoration:underline;}
			
			.account.create,.account.create a {color:#2da6c8;}
			.account.create span {font-weight:bold;}


        </style>
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="icon" type="image/png" href="/favicon.png">
		<link rel="apple-touch-icon" sizes="152×152" href="/smallideas152.png">
		<link rel="apple-touch-icon" sizes="167×167" href="/smallideas167.png">	
        </head>
    <!-- END HEAD -->

    <body class="login edition<?= date('Y') ?>">

    <!-- FORGOT PASSWORD MODAL -->
    <div class="modal fade" id="forgotpassword" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h3 class="modal-title">Forgot password</h3>                                        
                </div>
                <div class="modal-body">  
                    <div class="col-md-12">
                        <p>Enter your email address below and we'll send you a link to reset your password.</p>
                    </div>
                    <div class="clearfix"></div>

                    <form role="form" class="main resetpassform">                                     

                        <div class="form-group" style="margin:10px 0 20px 0;">
                            <label for="email" class="col-md-3">Email</label>
                            <div class="col-md-7">                                                        
                                <input class="form-control" name="resetemail" placeholder="" >                                                    
                            </div>   
                            <div class="clearfix"></div>                                          
                        </div>

                        <div class="col-md-12">
                        <div class="center">                                            
                            <div class="login-button"><button class="btn blue mt-ladda-btn ladda-button sendpasswordlink" data-style="expand-right" >Reset Password</button> </div>
                        </div>
                        </div>
                        <div class="clearfix"></div>

                    </form>   
                    
                </div>                                     
            </div>
        </div>                    
    </div>
    <!-- END MODAL -->  
    
    
    
    
    
    
    
        <!-- BEGIN LOGO -->
        <div class="logo">            
            <img src="/images/smallideas90w.png" width="45" alt="" />
        </div>
        <!-- END LOGO -->
        
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->            
            <form class="login-form" action="" method="post">
                <h3 class="form-title font-green" style="color:#364150!important">Small Ideas Login</h3>
                
                <?php if($loginSuccess == NO): ?>                
                <div class="alert alert-danger">
                    <button class="close" data-close="alert"></button>
                    <span> Your email or password is incorrect. </span>
                </div>
                <?php elseif($loginSuccess == EDITION || $loginSuccess == EXPIRED): ?>                
                <div class="alert alert-danger">
                    <button class="close" data-close="alert"></button>
                    <span> Your account has expired.<br>Please <a href="https://www.smallideas.com.au/buy/" target="_blank">purchase here</a> to continue to use. </span>
                </div>
                <?php elseif($loginSuccess == TRIALEXPIRED): ?>                
                <div class="alert alert-danger">
                    <button class="close" data-close="alert"></button>
                    <span> Your trial account has expired. <br>Please <a target="_blank" href="https://www.smallideas.com.au/buy/">renew here</a>. </span>
                </div>
                <?php endif; ?>

                <? if($mobileDetect->isMobile()): ?>  

                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->                    
                    <label class="control-label visible-ie8 visible-ie9">Email</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="username" /> 
                </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Password</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" /> 
                </div>
                <div class="form-actions">                                        
                    <button type="submit" class="btn blue uppercase ">Login</button>
                   <!-- <label class="rememberme check mt-checkbox mt-checkbox-outline">
                        <input type="checkbox" name="remember" value="1" />Remember
                        <span></span>
                    </label>-->
                    <a data-toggle="modal" id="forget-password" class="forget-password" href="#forgotpassword" href="javascript:;">I forgot my password</a>                     
                    <div class="clearfix"></div>
                </div>
				

				
				<?php if(isset($_GET['app'])): ?>

				<?php else: ?>
				<hr>
		        <div class="account create">
		            <p><a target="_blank" href="https://smallideas.com.au/buy/"><span>No membership?</span> Order here</a></p>
		        </div>
				<?php endif; ?>
				

			<?php else: ?>

                <div class="alert alert-danger">
                    <button class="close" data-close="alert"></button>
                    <span> Sorry, the Small Ideas app is only designed to run on <strong>smartphones</strong> &amp; <strong>tablets</strong>. </span>
                </div>
				
				<p>No membership? <a href="https://smallideas.com.au/buy/">Order here.</a>

			<?php endif; ?>

                
                                
            </form>
			
            
            <!-- END LOGIN FORM -->
            <!-- BEGIN FORGOT PASSWORD FORM -->
            <form class="forget-form" action="index.html" method="post">
                <h3 class="font-green">Forget Password ?</h3>
                <p> Enter your e-mail address below to reset your password. </p>
                <div class="form-group">
                    <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" /> </div>
                <div class="form-actions">
                    <button type="button" id="back-btn" class="btn green btn-outline">Back</button>
                    <button type="submit" class="btn btn-success uppercase pull-right">Submit</button>
                </div>
            </form>
           <!--  END FORGOT PASSWORD FORM -->
           
        </div>
		<!--<p class="created">Created by <a href="https://www.entice.com.au">Entice</a></p>-->
		
<!--
        <?php if($mobileDetect->isiOS()): ?> 
        <div class="content homescreen apple">
            <h4><img src="/images/homescreen.png" width="40" /> Create a Home Screen icon</h4>
            <p>Click <img style="margin-top:-5px;" src="/images/export.png" width="20" alt="Export"> below and select <strong><i>Add to Home Screen</i></strong>
        </div>
        <?php elseif($mobileDetect->isAndroidOS()): ?>
        <div class="content homescreen apple">
            <h4><img src="/images/homescreen.png" width="40" /> Create a Home Screen icon</h4>
            <p>Click the menu button above <img style="margin-top:-5px;" src="/images/android-menu.png" width="28" alt="Export"><br> and select <strong><i>Add to homescreen</i></strong>
        </div>
        <?php endif; ?>
    -->

        <div class="copyright"> &nbsp; </div>
        <!--[if lt IE 9]>
<script src="/theme/assets/global/plugins/respond.min.js"></script>
<script src="/theme/assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="/theme/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="/theme/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="/theme/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        
        <script src="/theme/assets/global/plugins/ladda/spin.min.js" type="text/javascript"></script>
        <script src="/theme/assets/global/plugins/ladda/ladda.min.js" type="text/javascript"></script>
        
        <script src="/js/service-frontend.js" type="text/javascript"></script>  
		
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-56670743-2', 'auto');
		  ga('send', 'pageview');

		</script>

    </body>

</html>