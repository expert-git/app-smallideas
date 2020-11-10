<?php

	/*
	* COPYRIGHT 2017 Entice Website Design
	* entice.com.au
	* No unauthorised copying permitted
	*
	*/


//error_reporting(E_ALL);
//ini_set('display_errors', '1');

	/* core inclusions */
	include_once("../../ep_library/initialise.php");
	
	/* database classes required for page */
	include_once(EPABSPATH."/include/classes/service.class.php");

	if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']){
		$uploaddir = WEBPATH."/images/voucher/";
		//prepend userid to file, and datetime
		$newfilename = Service::cleanFilename("_tmp_".date('Ymdhis')."_".basename($_FILES['file']['name']));

		$uploadfile = $uploaddir . $newfilename;

		if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
	
		
			//resize
			$maxWidth = 1000;
			$maxHeight = 700;
			
			/*$ext		= $img[2];
			$img        = $img[1];
			$img        = urldecode($img);
			$img_path   = "../$img.$ext";*/

			if(file_exists($uploadfile)){

				$thumb_path = str_replace("_tmp_","",$uploadfile);  //remove tmp string

				$image = imagecreatefromjpeg($uploadfile);
				
				
				
				//Mimetype validation and all ... 
				$exif = exif_read_data($uploadfile); 
			//	print_r($exif);
				$rotate = null; 
				//print_r($exif);
				if(isset($exif['Orientation'])){
					switch($exif['Orientation']){ 
						case 3: $rotate = 180; 
							break; 
						case 6: $rotate = -90; 
							break; 
						case 8: $rotate = 90; 
							break;
					} 
				}
				if($rotate){ 
					$image = imagerotate($image,$rotate,0); 
				}
				
				
				

				//get image dimensions
				$height = imagesy($image);
				$width = imagesx($image);
				$origratio = $width / $height;
				// 0.25 = 500 / 2000

				//resize only if too large
				if($height > $maxHeight || $width > $maxWidth){
					if($width > $maxWidth){
						$newWidth = $maxWidth;
						$newHeight = $newWidth/$origratio;
						//check if still over (ie both were over)
						if($newHeight > $maxHeight || $newWidth > $maxWidth){
							//go the other way - ie set height to max height
							$newHeight = $maxHeight;
							$newWidth = $newHeight * $origratio;
						}
					} else {
						$newHeight = $maxHeight;
						$newWidth = $newHeight * $origratio;
						//check if still over (ie both were over)
						if($newHeight > $maxHeight || $newWidth > $maxWidth){
							//go the other way - ie set width to max width
							$newWidth = $maxWidth;
							$newHeight = $newWidth/$origratio;
						}
					}
				} else {
					//not too large so keep the same dimensions
					$newHeight = $height;
					$newWidth = $width;
				}

				$new_image  = imagecreatetruecolor($newWidth, $newHeight);
				imagecopyresampled($new_image, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
				imagedestroy($image);
			
				imagejpeg($new_image, $thumb_path,88);  //82 is quality

				//remove tmp image
				unlink($uploadfile);
		
			}	


			//all good!
			echo json_encode(array('success'=>1,'file'=>str_replace("_tmp_","",$newfilename)));
		} else {
			echo json_encode(array('success'=>0));
		}
	} else {
		echo json_encode(array('success'=>0));	
	}



	
?>