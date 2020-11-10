<!DOCTYPE html>
<!------------------------------------------->
<!-- Created by Entice - www.entice.com.au -->
<!------------------------------------------->
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
        <meta content="" name="description" />
        <meta content="" name="author" />
		<meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-title" content="Small Ideas">

		<link rel="manifest" href="/manifest.json">

        <link rel="icon" type="image/png" href="/favicon.png">
		<link rel="apple-touch-icon" sizes="152×152" href="/smallideas152.png">
		<link rel="apple-touch-icon" sizes="167×167" href="/smallideas167.png">	

        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />                     
        <?= $pagelevelCSS; ?>
              
        <!-- page transitions 
        <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
        <link href="/css/page.transition.css" rel="stylesheet" type="text/css"/>-->
        
        <link href="/css/style-frontend.css?v=6.33" rel="stylesheet" type="text/css" />  
       <!-- <link href="/theme/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />     -->
       <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>     
	   
	<!-- Fix for handling of links in ios when added to homescreen -->
	<script>(function(a,b,c){if(c in b&&b[c]){var d,e=a.location,f=/^(a|html)$/i;a.addEventListener("click",function(a){d=a.target;while(!f.test(d.nodeName))d=d.parentNode;"href"in d&&(d.href.indexOf("http")||~d.href.indexOf(e.host))&&(a.preventDefault(),e.href=d.href)},!1)}})(document,window.navigator,"standalone")</script>
	     
    </head>
    <!-- END HEAD -->

    <body class="<?= $bodyClass ?> edition<?= date('Y') ?>">
      
        <div class="page-header">
            <div class="page-header-inner ">

                <div class="backlink">
                    <!--<a href="<?= ($bodyClass=='password') ? "javascript:location.href='/'" : "javascript:if(document.referrer==''){location.href='/';}else{history.back();}" ?>"><img src="/images/back.png" alt="Back" class="back" height="20" /></a>-->
					<?php if(!isset($_SESSION['allow-insecure'])): ?>
                    <a href="<?= ($backlink) ? $backlink : "/" ?>"><img src="/images/back.png" alt="Back" class="back" height="20" /></a>
					<?php endif; ?>
                </div>
                <div class="page-logo">
                    <a href="<?= (isset($_SESSION['allow-insecure'])) ? '#' : '/' ?>">
						<?php if($bodyClass && $bodyClass=='main-menu'): ?>
                        <img src="/images/logo.png" alt="logo" class="logo-main" height="65" /> 
						<?php else: ?>
						<img src="/images/smallideas90w.png" alt="logo" class="logo-default" height="45" /> 
						<?php endif;?>
                    </a>                   
                </div>
                <div class="title">
                    <h1><?= (isset($heading)) ? $heading : '' ?></h1>
                </div>
                
                <div class="clearfix"></div>

            </div>
            <!-- END HEADER INNER -->
        </div>

        <div class="page-container">           
            <?= $content ?>       
        </div>


        <div class="page-footer">            
            
        </div>        

        <!-- page transitions 
        <script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>  -->   
        
        <script src="/js/service-frontend.js?v=3.2" type="text/javascript"></script>     
        <?= $pagelevelScripts ?>  
		
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