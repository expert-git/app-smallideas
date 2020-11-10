<?php
	
	/*
	* COPYRIGHT 2017 Entice Website Design
	* entice.com.au
	* No unauthorised copying permitted
	*
	*/

	require_once(EPABSPATH."/include/sendgrid-php/sendgrid-php.php");

	class Service {				
		
		/* returns password hash that can be stored in the db */
		static public function getPasswordHash($salt,$password){			
			return md5($salt.$password);
		}
		
		/* cleans post input for username */
		static public function cleanEmail($post){			
			return substr(preg_replace("/[^a-zA-Z0-9\-_@\.]+/i","", $post),0,80);  //remove unwanted chars and size and length
		}		
		
		/* cleans post input for password */
		static public function cleanPassword($post){			
			return preg_replace("/[^a-zA-Z0-9\+\(\)\*\^\$\?=_&%#!@]+/i","", $post);  //remove unwanted chars and size and length  (allow alphanumeric and anything shift+num keys and _=+)
		}

		/* cleans post input for page titles */
		static public function cleanTitle($post){
			$post = str_replace("$","&#36;",$post);  //replace $ sign with html code			
			$post = str_replace("'","&#39;",$post);  //replace ' with html code
			return preg_replace("/[^a-zA-Z0-9,\.\(\)\-&\s]+/i","", $post);  //remove unwanted chars and size and length
		}

		/* cleans username */
		static public function cleanUsername($post){
			return preg_replace("/[^a-zA-Z0-9]+/i","", $post);  //remove unwanted chars and size and length
		}

		/* cleans post input for filename creation */
		static public function cleanFilename($post){			
			return trim(preg_replace("/[^a-zA-Z0-9\-_\.,]+/i","", $post));  //remove unwanted chars and size and length
		}

		/* cleans post input strings */
		static public function cleanHTML($post){
			$post = str_replace("'","&#39;",$post);  //replace ' with html code
			return preg_replace("/[^a-zA-Z0-9',\.\?:\"_=\$%!\(\)\-&#;<>\/\s]+/i","", $post);  //remove unwanted chars and size and length
		}
		
		/* cleans post input strings */
		static public function cleanString($post){
			$post = str_replace("$","&#36;",$post);  //replace $ sign with html code
			$post = str_replace("'","&#39;",$post);  //replace ' with html code
			return preg_replace("/[^a-zA-Z\/0-9:,\.@%\(\)\-_&#;\s]+/i","", $post);  //remove unwanted chars and size and length
		}

		/* cleans invoice strings */
		static public function cleanInvoice($post){
			$post = str_replace("$","&#36;",$post);  //replace $ sign with html code
			$post = str_replace("'","&#39;",$post);  //replace ' with html code
			return preg_replace("/[^a-z0-9,\.@%\(\)\-&#;\/\s]+/i","", $post);  //remove unwanted chars and size and length
		}
		
		/* cleans post input for facebook access tokens */
		static public function cleanToken($post){			
			$post = preg_replace("/[^a-zA-Z0-9\|\._\-]+/i","", $post);  //remove unwanted chars and size and length			
			return $post;
		}
		
		/* cleans post input for urls */
		static public function cleanURL($post){			
			return trim(preg_replace("/[^a-zA-Z0-9\(\)\-_;&:%\/\s\.]+/i","", $post));  //remove unwanted chars and size and length
		}
		
		/* cleans post input for numeric values */
		static public function cleanNumeric($post){			
			return trim(substr(preg_replace("/[^0-9\-\.]+/","", $post),0,100));  //remove unwanted chars and size and length
		}

		/* cleans date */
		static public function cleanDate($post){
			//also replaces / with - to be strtotime compatible
			return trim(substr(preg_replace("/[^0-9\-]+/","", str_replace("/","-",$post)),0,12));  //remove unwanted chars and size and length
		}
		
		//given a search string, return SQL search string for boolean search
		static public function createSqlSearchString($search){
			$parts = explode(" ",$search);
			$searchString = '';
			if($parts){
				foreach($parts as $part){
					$word = trim($part);
					if($word){
						$searchString .= "{$word}* ";
					}
				}
				$searchString = substr($searchString, 0,-1);
			}			
			return $searchString;
		}
		
		//returns today if Sunday, or date of last sunday
		static public function getSundayDate(){
			if(date('N')==7){ //Sunday
				$currentWeekStart = date('Y-m-d');
			} else {
				$currentWeekStart = date('Y-m-d',strtotime('last sunday'));
			}
			return $currentWeekStart;
		}
		
		public static function checkPasswordRequirements($password){
			//check password meets requirements
			$hasNumbers = preg_match('/\\d/', $password);
			$hasCharacters = preg_match('/[A-Z]+/i', $password);		 		 
			//echo "$hasNumbers || $hasCharacters";
			if(strlen($password)<6 || !$hasNumbers || !$hasCharacters){			 
				return false;
			}
			return true;
		}

		/* generates a random string */
		public static function generateRandomString($length = 10)
		{
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			return $randomString;
		}

		/* generates a password */
		public static function generatePassword()
		{
			$characters = 'abcdefghijklmnopqrstuvwxyz';
			$numbers = '0123456789';
			$charactersLength = strlen($characters);
			$numbersLength = strlen($numbers);
			$randomString = '';
			for ($i = 0; $i < 5; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			for ($i = 0; $i < 2; $i++) {
				$randomString .= $numbers[rand(0, $numbersLength - 1)];
			}
			return $randomString;
		}



		/**
		* Email login details to customer
		* Called after Woocommerce purchase 
		*/
		static public function wpSendLogin($emailAddress,$accountEmail,$password,$isExistingCustomer,$isGift = false)
		{
			
			// ini_set('display_errors', 1);
// 			ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
			
			if($isGift){
				
				//generate pdf voucher and add to as attachment to email
				require_once(EPABSPATH.'/include/tcpdf_min/tcpdf_include.php');

				//load template
				if($isExistingCustomer){
					$html = new Template(EPABSPATH.'/templates/emailWpExistingCustGiftPDF.tmpl.php');
				} else {
					$html = new Template(EPABSPATH.'/templates/emailWpNewCustGiftPDF.tmpl.php');
				}				
				$html->emailAddress = $emailAddress;
				$html->accountEmail = $accountEmail;
				$html->password = $password;

				// create new PDF document
				$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

				// create new PDF document
				//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

				// set default header data
				$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 061', PDF_HEADER_STRING);

				// set header and footer fonts
				$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

				// set default monospaced font
				$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

				// set margins
				$pdf->SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);
				$pdf->SetHeaderMargin(10);
				$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

				// set auto page breaks
				$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

				// set image scale factor
				$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

				// set some language-dependent strings (optional)
				if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
					require_once(dirname(__FILE__).'/lang/eng.php');
					$pdf->setLanguageArray($l);
				}

				// ---------------------------------------------------------

				// set font
				$pdf->SetFont('helvetica', '', 11);

				// add a page
				$pdf->AddPage();

				// output the HTML content
				$pdf->writeHTML($html->run(), true, false, true, false, '');

				// reset pointer to the last page
				$pdf->lastPage();

				// ---------------------------------------------------------

				//create filename	
				$identifier = str_replace(array("@","."),"",$accountEmail);
				$nameStr = "SmallIdeas-".date('YmdHi')."-".$identifier;

				//Close and output PDF document	
				//$pdf->Output('example_061.pdf', 'I');  //to screen
				$filename = $nameStr.".pdf";
				$filenamePath = EPABSPATH."/gift-vouchers/".$filename;
				$pdf->Output($filenamePath, 'F');

				//check if file exists.
				// if(!@file_exists($filenamePath)){
	// 				return false;
	// 			}
	

				//email
				$emailContent = new Template(EPABSPATH.'/templates/emailWpGift.tmpl.php');
				$subject = 'Small Ideas Login';
				//$emailContent->guideObj = $guideObj;
				//$sendToArr = array($emailAddress,EMAIL_ADMIN);	
				$result = Service::sendMessage(array($emailAddress),EMAIL_FROMNAME,EMAIL_FROM,EMAIL_FROM,$subject,$emailContent->run(),$filenamePath,$filename);		
//				$success = Service::sendMessage($sendToArr,EMAIL_FROMNAME,EMAIL_FROM,EMAIL_FROM,'MyGui Remittance Advice',$emailContent->run(),$filenamePath,$filename);

				// if($result != 202){
				// 	return false;
				// }

				return $result;
	
					
				
			} else {
				$subject = 'Small Ideas Login';
				if($isExistingCustomer){
					$emailContent = new Template(EPABSPATH.'/templates/emailWpExistingCust.tmpl.php');
				} else {
					$emailContent = new Template(EPABSPATH.'/templates/emailWpNewCust.tmpl.php');
				}
				
				//send email					
				$emailContent->emailAddress = $emailAddress;
				$emailContent->accountEmail = $accountEmail;
				$emailContent->password = $password;
				//$emailContent->edition = $edition;
				$result = Service::sendMessage(array($emailAddress),EMAIL_FROMNAME,EMAIL_FROM,EMAIL_FROM,$subject,$emailContent->run());		
				
			}

			

			return $result;

		}
		
		
		
		/**
		* Email login details to customer
		* Called after Woocommerce purchase 
		*/
		static public function wpSendRenewalThankyou($emailAddress,$accountExpiry)
		{

			$subject = 'Small Ideas Digital Subscription';
			$emailContent = new Template(EPABSPATH.'/templates/emailWpSubscriptionRenewal.tmpl.php');

			//send email					
			$emailContent->accountExpiry = $accountExpiry;
			//$emailContent->edition = $edition;
			$result = Service::sendMessage(array($emailAddress),EMAIL_FROMNAME,EMAIL_FROM,EMAIL_FROM,$subject,$emailContent->run());		

			return $result;

		}
		
		

		/**
		* Email login details to trial customer
		* Called from trial form on website
		*/
		static public function wpSendTrialLogin($emailAddress,$password)
		{

			$subject = 'Small Ideas Trial Login';
			$emailContent = new Template(EPABSPATH.'/templates/emailWpTrialCust.tmpl.php');

			//send email					
			$emailContent->emailAddress = $emailAddress;
			$emailContent->password = $password;
			$result = Service::sendMessage(array($emailAddress),EMAIL_FROMNAME,EMAIL_FROM,EMAIL_FROM,$subject,$emailContent->run());		

			return $result;

		}
		
		
		
		/**
		* Email login details to trial customer
		* Called from trial form on website
		*/
		static public function wpSendGroupWelcomeEmail($email,$groupName)
		{

			$subject = 'Welcome to Small Ideas - Playgroup NSW';
			$emailContent = new Template(EPABSPATH.'/templates/emailWpGroupMember.tmpl.php');

			//send email					
			$emailContent->groupName = $groupName;
			$emailContent->email = $email;
			$result = Service::sendMessage(array($email),EMAIL_FROMNAME,EMAIL_FROM,EMAIL_FROM,$subject,$emailContent->run());		

			return $result;

		}



		/**
		* Email 'account automatic creation' error notification
		* Called after Woocommerce purchase if purchase successfull , but app login creation not successful
		*/
		static public function wpSendAccountError($emailAddress)
		{

			$subject = 'Small Ideas account creation error';			

			//send email to user					
			$emailContent = new Template(EPABSPATH.'/templates/emailWpAccountError.tmpl.php');
			$emailContent->emailAddress = $emailAddress;		
			//$emailContent->edition = $edition;
			$result = Service::sendMessage(array($emailAddress),EMAIL_FROMNAME,EMAIL_FROM,EMAIL_FROM,$subject,$emailContent->run());		

			//send email to ADMIN					
			$emailContent2 = new Template(EPABSPATH.'/templates/emailWpAccountErrorAdmin.tmpl.php');
			$emailContent2->emailAddress = $emailAddress;		
			//$emailContent2->edition = $edition;
			$result = Service::sendMessage(array(ADMIN_EMAIL),EMAIL_FROMNAME,EMAIL_FROM,EMAIL_FROM,$subject,$emailContent2->run());		

			return true;

		}






		/* handle send messages via Sendgrid */
		static public function sendMessage($sendToArr,$fromName,$fromEmail,$replytoEmail,$subject,$content,$attachmentPath = '',$attachmentName = '',$attachment2Path = '',$attachment2Name = ''){
			
			//check if email in domain list that sendgrid doesn't work well with.  Send via SMTP if so.
			$useSMTP = false;
			$em_parts = explode('@',$sendToArr[0]);
			if(isset($em_parts[1]))
				$emailDomain = $em_parts[1];
//			echo $emailDomain."-";
//echo USE_SMTP_SERVER;
			$domains_parts = explode(',',USE_SMTP_SERVER);
			foreach($domains_parts as $aDomain){
				if($aDomain == $emailDomain){
					$useSMTP = true;
				}
			}
			
			if($useSMTP){
				//send SMTP email			
//				echo 'HERE'; exit;
				$result = Service::sendSMTPMessage($sendToArr[0],$fromName,SMTP_USERNAME,"Small Ideas login",$content,$attachmentPath);
				return $result;
			} 						
			
		//	echo 'no';
			
			//setup email
			$mail = new SendGrid\Mail();
			$email = new SendGrid\Email($fromName, $fromEmail); 
			$mail->setFrom($email);
			$mail->setSubject($subject);

			//reply to
			$reply_to = new SendGrid\ReplyTo($replytoEmail);
    		$mail->setReplyTo($reply_to);

			//message details
			foreach($sendToArr as $to){	
				$personalization = new SendGrid\Personalization();
				$email = new SendGrid\Email($to,$to);
				$personalization->addTo($email);
				
				//$email = new Email("Example User", "test3@example.com");
				//$personalization2->addCc($email);
				//$personalization->setSubject("Hello World from the SendGrid PHP Library");
				$mail->addPersonalization($personalization);
			}

			//body content
			$content = new SendGrid\Content("text/html", $content);
			$mail->addContent($content);

			//attachment 	
			if($attachmentPath){		
				$type = pathinfo($attachmentPath, PATHINFO_EXTENSION);
				$data = file_get_contents($attachmentPath);			
				$base64 = base64_encode($data);
				$attachment = new SendGrid\Attachment();
				$attachment->setContent($base64);
				$attachment->setType("application/pdf");
				$attachment->setFilename($attachmentName);
				$attachment->setDisposition("attachment");
				$attachment->setContentId("Report");
				$mail->addAttachment($attachment);
			}

			//2nd attachment 	
			if($attachment2Path){		
				$type = pathinfo($attachment2Path, PATHINFO_EXTENSION);
				$data = file_get_contents($attachment2Path);			
				$base64 = base64_encode($data);
				$attachment2 = new SendGrid\Attachment();
				$attachment2->setContent($base64);
				$attachment2->setType("application/pdf");
				$attachment2->setFilename($attachment2Name);
				$attachment2->setDisposition("attachment");
				$attachment2->setContentId("Report");
				$mail->addAttachment($attachment2);
			}

			//send
			$apiKey = SENDGRID_API_KEY;
			$sg = new \SendGrid($apiKey);
			$response = $sg->client->mail()->send()->post($mail);
			//print_r($response);
		
			// echo $response->headers();
			// echo $response->body();
			// echo 'a';

			return $response->statusCode();
		}

		/* handle send messages via Sendgrid */
		static public function sendSMTPMessage($sendTo,$fromName,$fromEmail,$subject,$content,$attachmentPath = '',$attachmentName = ''){
			
		//	error_reporting(E_ALL);
		//	ini_set('display_errors', 1);
			
			require_once "Mail.php";
			require_once "Mail/mime.php";
 	
			$headers = array (
				'From' => "{$fromName} <{$fromEmail}>",
			   	'To' => $sendTo,
			   	'Subject' => $subject);
				
//				print_r($headers); exit;
			   
		   $crlf = "\n";
		   $mime = new Mail_mime(['eol' => $crlf]);		   
		   
		   if($attachmentPath){
			if(is_array($attachmentPath)){
			 foreach($attachmentPath as $ap){
				$mime->addAttachment($ap, 'application/pdf');
			 }	
			} else {				
		   		$mime->addAttachment($attachmentPath, 'application/pdf');
			}
		   }	   
		   
		   $mime->setHTMLBody($content);
		   $body = $mime->get();
		   $headers = $mime->headers($headers);
		   
			$smtp = Mail::factory('smtp',
			   array ('host' => SMTP_HOST,
			     'auth' => true,
				 'port' => SMTP_PORT,
			     'username' => SMTP_USERNAME,
			     'password' => SMTP_PASSWORD));

			$mail = $smtp->send($sendTo, $headers, $body);
 
			if (PEAR::isError($mail)) {
			    // echo("<p>" . $mail->getMessage() . "</p>");
				// exit;
	  			return false;
			} else {
//			  echo("<p>Message successfully sent!</p>");
			  //exit;
			  return true;
			}		
		}


		
	/*
	 *  Send an email message via amazon ses	 	
	 
	 
	static public function sendemail($dataArr){
		
		include_once(Config::$baseroot."/private_html/include/class.phpmailer.php");		
		
		$mail = new phpmailer;
		
		// Set mailer to use AmazonSES.
		$mail->IsAmazonSES();

		// Set AWSAccessKeyId and AWSSecretKey provided by amazon.
		$mail->AddAmazonSESKey(Config::$AmazonKey, Config::$AmazonPass);

		// "From" must be a verified address.
		$mail->From = $dataArr['fromemail'];
		$mail->FromName = $dataArr['fromname'];

		$mail->AddAddress($dataArr['toemail']); 
		$mail->Subject = $dataArr['subject'];
		//$mail->Body = "Looks like it works!";
		//$mail->AltBody = $text; // optional - MsgHTML will create an alternate automatically
		$mail->MsgHTML($dataArr['htmlbody']);
	
		$result =  $mail->Send(); // send message
	
		return $result;

	}
			*/
		
		/* 
		 * calculate setup/hosting/domain costs 
		 * return array of costs 
		 
			 $data = array(		
				'setupType' => Premium/Standard,
				'needDomainRegistered' => bool,
				'expressTransfer' => bool,
				'isAnnualPayments' => bool,
				'needExtraEmailAccounts' => bool,
				'referrerCode' = string (optional)
			);				 
		 
		 
		 
		static public function calculateCost($data){
			
			include_once(Config::$baseroot."/private_html/include/lib/X/product.class.php");
			include_once(Config::$baseroot."/private_html/include/lib/X/referrercode.class.php");		

			$setupcost = 0;		
			$reoccuringcost = 0;
			$frequency = 'yr';
			
			//get referrer code details
			if(isset($data['referrerCode']) && $data['referrerCode']!=''){			
				$referrerCodeObj = X_ReferrerCode::get($data['referrerCode']);			
			}			
			//setup costs
			switch($data['setupType']){
				case 'Premium':
					$setupProductObj = X_Product::getByType('setup','premium');			
					$productIdArr[] = array('id'=>$setupProductObj->id,'qty'=>1,'amount'=>$setupProductObj->amount);
					
					///////////////////////////////////////////////////////////////////////////
					// temporary measure to allow for a different NEW ZEALAND AUD price ///////					
					if(isset($data['isNewZealand']) && $data['isNewZealand']=='1'){          //
						 $setupProductObj->amount -= 200;         //take off $200            //
					}	                                                                     //
					// END temporary measure //////////////////////////////////////////////////
					
					if($referrerCodeObj && !self::codeExpired($referrerCodeObj->codeExpiry) && $referrerCodeObj->type=='percentDiscountPremiumSetup'){							
						//referrer code used					
						$setupcost = $setupProductObj->amount * (100 - $referrerCodeObj->value)/100;
					} else {					
						$setupcost = $setupProductObj->amount;
					}					
					
					break;
				default:
					$setupProductObj = X_Product::getByType('setup','standard');													
					$productIdArr[] = array('id'=>$setupProductObj->id,'qty'=>1,'amount'=>$setupProductObj->amount);

					///////////////////////////////////////////////////////////////////////////
					// temporary measure to allow for a different NEW ZEALAND AUD price ///////					
					if(isset($data['isNewZealand']) && $data['isNewZealand']=='1'){          //
						$setupProductObj->amount -= 100;            //take off $100          //
					}	                                                                     //
					// END temporary measure //////////////////////////////////////////////////

					if($referrerCodeObj && !self::codeExpired($referrerCodeObj->codeExpiry) && $referrerCodeObj->type=='percentDiscountStandardSetup'){	
						//referrer code used					
						$setupcost = $setupProductObj->amount * (100 - $referrerCodeObj->value)/100;															
					} else {					
						$setupcost = $setupProductObj->amount;
					}						
					
					break;	
			}
			
			//domain + domain transfer
			$isFreeDomain = false;
			if($referrerCodeObj && !self::codeExpired($referrerCodeObj->codeExpiry) && $referrerCodeObj->type=='freeDomainOrTransfer'){
				//override the price to be free
				$isFreeDomain = true;
			}				
			if($data['needDomainRegistered']){				
				$domainProductObj = X_Product::getByType('domain','new');									
				$productIdArr[] = array('id'=>$domainProductObj->id,'qty'=>1,'amount'=>$domainProductObj->amount);
				if(!$isFreeDomain) $domaincost = $domainProductObj->amount;						
			} elseif($data['expressTransfer']=='yes'){
				$domainProductObj = X_Product::getByType('domain','transfer');					
				$productIdArr[] = array('id'=>$domainProductObj->id,'qty'=>1,'amount'=>$domainProductObj->amount);
				if(!$isFreeDomain) $domaintransfercost += $domainProductObj->amount;
			}			
			
			
			//ongoing costs		
			if($data['isAnnualPayments']){			
				//annual
				if($referrerCodeObj && !self::codeExpired($referrerCodeObj->codeExpiry)){								
					//referrer code used with 'free x months when paying annually'				
					$hostingProductObj = X_Product::getByType('hosting','month');					
					$productIdArr[] = array('id'=>$hostingProductObj->id,'qty'=>12,'amount'=>$hostingProductObj->amount);
					$hostingcost = 12 * $hostingProductObj->amount;
					
					///////////////////////////////////////////////////////////////////////////
					// temporary measure to allow for a different NEW ZEALAND AUD price ///////					
					if(isset($data['isNewZealand']) && $data['isNewZealand']=='1'){          //
						$hostingcost -= 12 * 10;                                           //
					}	                                                                     //
					// END temporary measure //////////////////////////////////////////////////
					
					$reoccuringcost += $hostingcost;
				} else {
				
					//no 'free hosting' referrer code used
					$hostingProductObj = X_Product::getByType('hosting','year');					
					$productIdArr[] = array('id'=>$hostingProductObj->id,'qty'=>1,'amount'=>$hostingProductObj->amount);
					$hostingcost = $hostingProductObj->amount;
					
					///////////////////////////////////////////////////////////////////////////
					// temporary measure to allow for a different NEW ZEALAND AUD price ///////					
					if(isset($data['isNewZealand']) && $data['isNewZealand']=='1'){          //
						$hostingcost -= 100;                                               //
					}	                                                                     //
					// END temporary measure //////////////////////////////////////////////////          
					
					$reoccuringcost += $hostingcost;				// annual discount only given if no referrer code is used
				}
				$frequency = 'yr';
				if($data['needExtraEmailAccounts']){
					$emailProductObj = X_Product::getByType('emailaccount','10');					
					$productIdArr[] = array('id'=>$emailProductObj->id,'qty'=>12,'amount'=>$emailProductObj->amount);
					$emailcost = 12 * $emailProductObj->amount;
					$reoccuringcost += $emailcost;
				}
			} else { 
				//monthly
				$hostingProductObj = X_Product::getByType('hosting','month');				
				$productIdArr[] = array('id'=>$hostingProductObj->id,'qty'=>1,'amount'=>$hostingProductObj->amount);
				$hostingcost = $hostingProductObj->amount;
				
				///////////////////////////////////////////////////////////////////////////
				// temporary measure to allow for a different NEW ZEALAND AUD price  //////					
				if(isset($data['isNewZealand']) && $data['isNewZealand']=='1'){          //
					$hostingcost -= 10;                                                  //
				}	                                                                     //
				// END temporary measure //////////////////////////////////////////////////  
					
				$reoccuringcost += $hostingcost;
				$frequency = 'month';
				if($data['needExtraEmailAccounts']){ 
					$emailProductObj = X_Product::getByType('emailaccount','10');					
					$productIdArr[] = array('id'=>$emailProductObj->id,'qty'=>1,'amount'=>$emailProductObj->amount);
					$emailcost = $emailProductObj->amount;
					$reoccuringcost += $emailcost;				
				}
			}
			
			//return				
			$totalsArr = array(
				'setupcost' => $setupcost,
				'reoccuringcost' => $reoccuringcost,
				'reoccuringperiod' => $frequency,
				'hostingcost' => $hostingcost,  //need to separate out of reoccuringcost cost so can record in site obj during signup				
				'productIdArr' => $productIdArr
			);
			if(isset($domaincost)) $totalsArr['domaincost'] = $domaincost;
			if(isset($domaintransfercost)) $totalsArr['domaintransfercost'] = $domaintransfercost;
			if(isset($emailcost)) $totalsArr['emailcost'] = $emailcost;			
			
			return $totalsArr;
			
		}
		
		
		//date checker
		static private function codeExpired($dtExpiry){
			if($dtExpiry && (strtotime($dtExpiry) < strtotime(date('Y-m-d H:i:s')))) 
				return true;
			return false;
		}
	*/
					
		
	}



?>