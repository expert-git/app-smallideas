<?php

	/* core inclusions */
	include_once("../ep_library/initialise.php");
	include_once(EPABSPATH."/include/classes/template.class.php");

	/* check authentication and process logins */
	include_once(EPABSPATH."/include/classes/auth.class.php");  
  	X_Auth::Login();

	//is admin?
    $isAdmin = (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']);

	//setup page templates
	$template = new Template(EPABSPATH.'/templates/master.tmpl.php');
	$pageTemplate = new Template(EPABSPATH.'/templates/viewFAQ.tmpl.php');
	$pageTemplate->parent($template);  //so that pageTemplate can access the variables set in the parent template



	//set template vars
	$template->heading = "FAQ";
	$template->title = "Small Ideas";
	$template->isAdmin = $isAdmin;	
	$template->bodyClass = 'faq';
	$template->pagelevelCSS = '<link rel="stylesheet" type="text/css" href="/css/addtohomescreen.css">';	
	$template->pagelevelScripts = '
		<script src="/js/addtohomescreen.js"></script>
		<script>
			var addtohome = addToHomescreen({
			   autostart: false
			}); 
			$(".addtohome-faq").click(function(){
				addtohome.show(true);
			});	
			
			/* ios hack to check if starting starting web app to FAQ page - redirect to home page */
			if(("standalone" in window.navigator) && window.navigator.standalone){				
				var prevURL = document.referrer;
				if(prevURL == ""){
					window.location = "/";
				}
				
				/* also hide button as already have an icon */
				$(".addtohome-faq").css("display","none");
			}
			
			
				
		</script>
		';
	
	//display page
	$template->content = $pageTemplate->run();	//generate inner page content
	echo $template;	//echo master

?>