<?php

/**
 * Surcharge de TCPDF pour création de l'attestation.
 *
 * @author     Clément Gautier
 */

class attestationPDF extends TCPDF {
	//Page header
	public function __construct($orientation = 'L', $unit = 'mm', $format = 'C6', $unicode = true, $encoding = "UTF-8")
  {
    parent::__construct($orientation, $unit, $format, $unicode, $encoding);
  }
	
	public function Header() {
		// full background image
		// store current auto-page-break status
		$bMargin = $this->getBreakMargin();
		$auto_page_break = $this->AutoPageBreak;
		$this->SetAutoPageBreak(false, 0);
		$img_file = K_PATH_IMAGES.'pdf/attestation_empty.png';
		$this->Image($img_file, 0, 0, 162.04, 113.95, '', '', '', false, 300, '', false, false, 0);
		// restore auto-page-break status
		$this->SetAutoPageBreak($auto_page_break, $bMargin);
	}	
}

class attestationPDFSdF extends TCPDF {

	//Page header
	public function __construct($orientation = 'L', $unit = 'mm', $format = 'C6', $unicode = true, $encoding = "UTF-8") {
		parent::__construct($orientation, $unit, $format, $unicode, $encoding);
	}

	public function Header() {
		// full background image
		// store current auto-page-break status
		$bMargin = $this->getBreakMargin();
		$auto_page_break = $this->AutoPageBreak;
		$this->SetAutoPageBreak(false, 0);
		$img_file = K_PATH_IMAGES.'pdf/attestation_empty_sdf.png';
		$this->Image($img_file, 0, 0, 162.04, 113.95, '', '', '', false, 300, '', false, false, 0);
		// restore auto-page-break status
		$this->SetAutoPageBreak($auto_page_break, $bMargin);
	}
}

?>
