<?php
	
/*
 * COPYRIGHT 2017 Entice Website Design
 * entice.com.au
 * No unauthorised copying permitted
 *
 */

	/* core inclusions */
	include_once("../../ep_library/initialise.php");
	include_once(EPABSPATH."/include/classes/template.class.php");

	/* database classes required for page */
	include_once(EPABSPATH."/include/classes/voucher.class.php");
	include_once(EPABSPATH."/include/classes/DAL/category.class.php");
	include_once(EPABSPATH."/include/classes/DAL/region.class.php");	
	include_once(EPABSPATH."/include/classes/DAL/voucherLocation.class.php");	
	
	/* check authentication and process login if required */
	include_once(EPABSPATH."/include/classes/auth.class.php");	 
  	
	//show login if required, update session time
	X_Auth::Login(); 
	
	//is admin?
    $isAdmin = (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']);
	
	if(!$isAdmin){
		session_destroy();
		unset($_COOKIE['remember']);
		header("Location: /manager/");
		exit;
	}
	
	if(isset($_GET['id'])){
		$voucherObj = X_Voucher::GetById(Service::cleanNumeric($_GET['id']));			
		$voucherLocationObjArr = DAL_VoucherLocation::GetAllForVoucherId($voucherObj->id);
	}
	if(!isset($voucherObj)){
		$voucherObj = null;
		$voucherLocationObjArr = null;
	}
	
	$catObjArr = DAL_Category::GetAll();
	$regionObjArr = DAL_Region::GetAll();


	//setup page templates
	$template = new Template(EPABSPATH.'/templates/masterAdmin.tmpl.php');
	$pageTemplate = new Template(EPABSPATH.'/templates/editVoucher.tmpl.php');
	$pageTemplate->parent($template);  //so that pageTemplate can access the variables set in the parent template
	

	//set template variables
	$template->title = " Edit Voucher | Small Ideas";
	$template->isAdmin = $isAdmin;	
	$template->activeTab = 'vouchers';
	$template->bodyClass = '';
	$template->voucherObj = $voucherObj;
	$template->voucherLocationObjArr = $voucherLocationObjArr;
	$template->catObjArr = $catObjArr;
	$template->regionObjArr = $regionObjArr;
	$template->pagelevelCSS = '<link href="/theme/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
							<link href="/theme/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css" />
							<link href="/theme/assets/global/plugins/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
        					<link href="/theme/assets/global/plugins/dropzone/basic.min.css" rel="stylesheet" type="text/css" />
							<link href="/css/calendar.css" rel="stylesheet" type="text/css" />							
							<link href="/theme/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />					
							';
	$template->pagelevelScripts = '
								<script src="/theme/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>					
								  <script src="/js/components-bootstrap-select.js" type="text/javascript"></script>
								  <script src="/theme/assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script>
								  <script src="/theme/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js" type="text/javascript"></script>								  
								  <script src="/js/components-editors.js" type="text/javascript"></script>
								  <script src="/theme/assets/global/plugins/dropzone/dropzone.min.js" type="text/javascript"></script>
								  <script src="/js/form-dropzone.js" type="text/javascript"></script>								  								 
								  <script src="/theme/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>					
								  <script src="/theme/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
								  <script src="/js/form-validation.js" type="text/javascript"></script>
								  <script src="/theme/assets/global/plugins/jquery-repeater/jquery.repeater.js" type="text/javascript"></script>
								  <script src="/js/form-repeater.js" type="text/javascript"></script>
								  <script src="/js/googlemap-edit.js" type="text/javascript"></script>
								<script async defer src="https://maps.googleapis.com/maps/api/js?key='.GOOGLE_API.'"></script>

								  <script>
								  /* generic datepicker enable */
	if (jQuery().datepicker) {
		$(".date-picker").datepicker({
			rtl: App.isRTL(),
			orientation: "left",
			autoclose: true
		});		
    }
	</script>
								';

	
	
	//display page
	$template->content = $pageTemplate->run();	//generate inner page content
	echo $template;	//echo master

?>