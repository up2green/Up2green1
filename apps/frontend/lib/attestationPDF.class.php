<?php

/**
 * Surcharge de TCPDF pour création de l'attestation de plantation.
 *
 * @author     Clément Gautier
 */

class attestationPDF extends TCPDF {
	
	private $imgName;
	
	public function __construct($imgName = 'attestation_empty', $orientation = 'L', $unit = 'mm', $format = 'C6', $unicode = true, $encoding = "UTF-8") {
		$this->imgName = $imgName;
		parent::__construct($orientation, $unit, $format, $unicode, $encoding);
  }
	
	public function init() {
		$this->SetMargins(10, 20);
		$this->SetHeaderMargin(0);
		$this->setPrintFooter(false);
		$this->AliasNbPages();
		$this->AddPage();
	}
	
	public function Header() {
		// full background image
		// store current auto-page-break status
		$bMargin = $this->getBreakMargin();
		$auto_page_break = $this->AutoPageBreak;
		$this->SetAutoPageBreak(false, 0);
		$img_file = K_PATH_IMAGES.'pdf/'.$this->imgName.'.png';
		$this->Image($img_file, 0, 0, 162.04, 113.95, '', '', '', false, 300, '', false, false, 0);
		// restore auto-page-break status
		$this->SetAutoPageBreak($auto_page_break, $bMargin);
	}	
}

?>
