<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>Login - Small Ideas</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="/theme/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="/theme/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="/theme/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="/theme/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="/theme/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="/theme/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="/theme/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="/theme/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="/theme/assets/pages/css/login.min.css" rel="stylesheet" type="text/css" />
        <style>
            body.login {background-color:#444!important;}
            .login .content .form-control {background-color:#eee;border-color:#eee;}
        </style>
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->

    <body class=" login">
        <!-- BEGIN LOGO -->
        <div class="logo">            
            <img src="/images/smallideas90w.png" alt="" />
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            <form class="login-form" action="" method="post">
                <h3 class="form-title font-green" style="color:#364150!important">Sign In</h3>
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span> Enter any username and password. </span>
                </div>

                <?php if($loginSuccess == NO): ?>                
                <div class="alert alert-danger">
                    <button class="close" data-close="alert"></button>
                    <span> Your username or password is incorrect. </span>
                </div>
                <?php endif; ?>

                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    
                    <label class="control-label visible-ie8 visible-ie9">Username</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username" /> </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Password</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" /> </div>
                <div class="form-actions">
                
                    <button type="submit" class="btn green uppercase">Login</button>
                   <!-- <label class="rememberme check mt-checkbox mt-checkbox-outline">
                        <input type="checkbox" name="remember" value="1" />Remember
                        <span></span>
                    </label>
                    <a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a>-->
                </div>
                                
            </form>
            <!-- END LOGIN FORM -->
            <!-- BEGIN FORGOT PASSWORD FORM 
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
             END FORGOT PASSWORD FORM -->
           
        </div>
        <div class="copyright"> &nbsp; </div>
        <!--[if lt IE 9]>
<script src="/theme/assets/global/plugins/respond.min.js"></script>
<script src="/theme/assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="/theme/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="/theme/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="/theme/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        

    </body>

</html>