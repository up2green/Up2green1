<?php

/**
 * Surcharge de TCPDF pour création de l'attestation de plantation.
 *
 * @author     Clément Gautier
 */

class attestationPDF extends TCPDF {
	
	private $imgName;
	
	public function __construct($imgName = '', $orientation = 'L', $unit = 'mm', $format = 'A4', $unicode = true, $encoding = "UTF-8") {
		if(empty($imgName)) {
			$imgName = sfConfig::get('sf_web_dir').'/images/pdf/attestation-02.png';
		}
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
		$img_file = $this->imgName;
		if(preg_match('#/images/pdf/attestation_empty_sdf\.png#', $img_file)) {
			$this->Image($img_file, 0, 0, 162.04, 113.95, '', '', '', false, 300, '', false, false, 0);
		}
		else {
			$this->Image($img_file, 0, 0, 297, 210, '', '', '', false, 300, '', false, false, 0);	
		}
		// restore auto-page-break status
		$this->SetAutoPageBreak($auto_page_break, $bMargin);
	}	
}

?>
