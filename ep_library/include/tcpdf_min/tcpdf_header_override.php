<?php


	// Extend the TCPDF class to create custom Header and Footer
	class MYPDF extends TCPDF {

		//Page header
		public function Header() {
			// Logo
			
			//$image_file = EPABSPATH.'include/tcpdf_min/header.png';

			//echo $image_file; exit;
			// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
			//$this->Image($image_file, 0, 0, 210, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			// Set font
			//$this->SetFont('helvetica', 'B', 20);
			// Title
			//$this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		}

		// Page footer
		public function Footer() {

		//	$image_file = K_PATH_IMAGES.'/footer.png';		
		//	$this->Image($image_file, 0, 270, 210, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

			// Position at 15 mm from bottom
			//$this->SetY(-15);
			// Set font
			//$this->SetFont('helvetica', 'I', 8);
			// Page number
			//$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		}
	}



	// Extend the TCPDF class to create empty Header and Footer for Vouchers
	class VOUCHERPDF extends TCPDF {

		//Page header
		public function Header() {
			// Logo
			
			//$image_file = EPABSPATH.'include/tcpdf_min/header.png';

			//echo $image_file; exit;
			// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
			//$this->Image($image_file, 0, 0, 210, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			// Set font
			//$this->SetFont('helvetica', 'B', 20);
			// Title
			//$this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		}

		// Page footer
		public function Footer() {

		//	$image_file = K_PATH_IMAGES.'/footer.png';		
		//	$this->Image($image_file, 0, 270, 210, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

			// Position at 15 mm from bottom
			//$this->SetY(-15);
			// Set font
			//$this->SetFont('helvetica', 'I', 8);
			// Page number
			//$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		}
	}


