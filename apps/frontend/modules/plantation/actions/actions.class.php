<?php

/**
 * plantation actions.
 *
 * @package    up2green
 * @subpackage plantation
 * @author     Clément Gautier
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class plantationActions extends sfActions {
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request) {
		// chargement des variables pour le form programmes
		$this->programmes = Doctrine_Core::getTable('programme')->getActive();
		$this->errors = array();
		$this->view = $request->getParameter('view');
		
		// pour le form partenaire et pour savoir si on affiche la liste des programmes quand le user est connecté
		$this->partenaire = null;
		$this->nbArbresToPlant = 0;
		$this->spendAll = false;
		
		if ($this->getUser()->isAuthenticated()) {
			$user = $this->getUser()->getGuardUser();
			$this->partenaire = ($user->getPartenaire()->getId() != null ? $user->getPartenaire() : null);
			$this->nbArbresToPlant = $user->getProfile()->getCredit();
			$this->spendAll = false;
			
			if($this->view === 'listeCouponsPartenaires' &&
				!is_null($this->partenaire)
			) {
				$arrCoupons = array();
				$arrCouponsUsed = array();

				$totalCoupons = Doctrine_Query::create()
					->select('*')
					->from("coupon c")
					->leftJoin('c.Partenaire cp')
					->where('cp.partenaire_id = ?', $this->partenaire->getId())
					->leftJoin('c.couponGen cg')
					->orderBy('cg.credit')->execute();
					
				foreach ($totalCoupons as $coupon) {
					if ($coupon->getIsActive()) $arrCoupons[] = $coupon;
					else $arrCouponsUsed[] = $coupon;
				}
			 $this->couponsUsed = $arrCouponsUsed;
			 $this->coupons = $arrCoupons;
			}
		}
		
		$this->setProgrammesFromPartenaire();
		
		if ($request->isMethod('post')) {
			
			// l'utilisateur a entré son numéro de coupon
			if ($request->getParameter('numCouponToUse')) {
				if ($coupon = Doctrine_Core::getTable('coupon')->findOneBy('code', $request->getParameter('code'))) {
					if ($coupon->getIsActive()) {
						$this->coupon = $coupon;
						if(is_null($this->partenaire)) {
							$this->partenaire = $coupon->getPartenaire()->getPartenaire();
							$this->setProgrammesFromPartenaire();
						}
						$this->spendAll = true;
						$this->nbArbresToPlant = $coupon->getCouponGen()->getCredit();
					}
					else {
						$this->coupon = null;
						$this->errors[] = "Ce coupon a déjà été utilisé";
					}
				}
			}
			
			// submit pour planter les arbres
			if ($request->getParameter('submitArbresProgramme')){
				if ($coupon = Doctrine_Core::getTable('coupon')->findOneBy('code', $request->getParameter('plantCouponCode'))) {
					if ($coupon->getIsActive()){
						$this->coupon = $coupon;
						$email = "";
						if (($request->hasParameter('email_user_deco')) && ($request->getParameter('email_user_deco') != "")) {
							$email = trim($request->getParameter('email_user_deco'));
						}
						
						if ($request->getParameter('nbArbresToPlantLeft') == 0){
							foreach ($this->programmes as $programme){
								if (1*$request->getParameter('nbArbresProgrammeHidden_'.$programme->getId())){
									if ($request->getParameter('nbArbresProgrammeHidden_'.$programme->getId()) > 0){
										$coupon->plantArbre(1*$request->getParameter('nbArbresProgrammeHidden_'.$programme->getId()), $programme, $this->getUser());
									}
								}
							}
							
							$coupon->setUsedAt(date('c'));
							$coupon->setIsActive(false);
							$coupon->save();
							
							if (! ($this->getUser()->getGuardUser())) {
								$coupon->logUser($email);
							}
							
							$this->errors[] = "Vos arbres ont bien été plantés !";
							
							if(!empty($email)) {
								// on envoi le mail avec attestation :
/*
								$this->buildAttestation();
*/
								
								$html = "Bonjour, <br />".
                        "Vous venez de planter ".$request->getParameter('nbTreeMax')." arbre(s) sur la planète !<br />".
                        "Attention l'attestation est momentanément indisponible.<br />Elle sera disponible dans les plus brefs délais.<br />Merci de votre compréhension.<br />".
                        "A très bientôt pour faire avancer la reforestation sur http://reforestation.up2green.com/ !";
                
								$message = $this->getMailer()
									->compose(
										array('webmaster@up2green.com' => 'Up2Green'),
										$email,
										'Attestation de plantation sur Up2Green !')
									->setBody($html, 'text/html');
								
/*
								if(file_exists('/tmp/attestation.pdf')) {
									$message->attach(
										Swift_Attachment::fromPath('/tmp/attestation.pdf')
									);
								}
*/
								
                $this->getMailer()->send($message);
                $this->errors[] = "Vous aller recevoir un email attestant de votre plantation.";
							}
							
							$this->coupon = null;
							
						}
						else {
							$this->errors[] = "Veuillez planter tous vos arbres avant de valider !";
						}
					}
					else {
						$this->errors[] = "Ce coupon a déjà été utilisé";
						$this->coupon = null;
					}
				}
			}
		}

		$this->getGmap();
	}
	
	public function buildAttestation() {
		$config = sfTCPDFPluginConfigHandler::loadConfig();
 
		// pdf object
		$pdf = new sfTCPDF();
	 
		// settings
		$pdf->SetFont("FreeSerif", "", 12);
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
		$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	 
		// init pdf doc
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->Cell(80, 10, "Hello World !!! €àèéìòù");
	 
		// output
		file_put_contents('/tmp/attestation.pdf', $pdf->Output('/tmp/attestation.pdf', 's'));

	}
	
	public function setProgrammesFromPartenaire() {
		if(!is_null($this->partenaire)) {
			$partenaireProgrammes = $this->partenaire->getProgrammes();
			$programmes = array();
			foreach($partenaireProgrammes as $partenaireProgramme) {
				$programmes[] = $partenaireProgramme->getProgramme();
			}
			$this->programmes = $programmes;
		}
	}
	
	public function executeCouponsCSV(sfWebRequest $request){
		if (($user = $this->getUser()->getGuardUser()) && ($partenaire = $user->getPartenaire())) {
			$this->coupons = Doctrine_Query::create()
				->from('coupon c')
				->leftJoin('c.CouponsPartenaires cp')
				->where('cp.partenaire_id = ?', $partenaire->getId())
				->andWhere('c.is_active = ?', true)->execute();
		}
		else {
			$this->forward404();
		}
		
		$this->setLayout(false);
	}

	public function executeCouponsUsedCSV(sfWebRequest $request){
		if (($user = $this->getUser()->getGuardUser()) && ($partenaire = $user->getPartenaire())) {
			$this->coupons = Doctrine_Query::create()
				->from('coupon c')
				->leftJoin('c.Partenaire cp')
				->where('cp.partenaire_id = ?', $partenaire->getId())
				->andWhere('c.is_active = ?', false)->execute();
		}
		else {
			$this->forward404();
		}
		
		$this->setLayout(false);
	}


	private function getGmap() {
		$this->gMap = new GMap(array(
			'scrollwheel' => 'false',
			'mapTypeId' => 'google.maps.MapTypeId.SATELLITE',
			'mapTypeControl' => 'false',
			'navigationControl' => 'false'
		));
		
		foreach($this->programmes as $programme)
			if(
			!is_null($programme->getGeoadress()) ||
			(!is_null($programme->getLatitude()) && !is_null($programme->getLongitude()))
			) {

				if(!is_null($programme->getLatitude()) && !is_null($programme->getLongitude())) {
					// latitude / longitude method
					$geocoded_addr = new GMapGeocodedAddress(null);
					$geocoded_addr->setLat($programme->getLatitude());
					$geocoded_addr->setLng($programme->getLongitude());
				}
				else {
					// adress user friendly method
					$geocoded_addr = new GMapGeocodedAddress($programme->getGeoadress());
					$geocoded_addr->geocode($this->gMap->getGMapClient());
				}

				$gMapMarker = new GMapMarker(
					$geocoded_addr->getLat(),
					$geocoded_addr->getLng(),
					array(
						'title ' => "'".$programme->getTitle()."'",
						'zIndex ' => (100 + floor($programme->getMaxTree()/1000)),
						'icon'	=> $this->getProgrammeIcon($programme),
					)
				);
				
				$html = '<span class="title">'.$programme->getTitle().'</span>';
				$html .= '<span style="display:block;padding-top:10px;" class="content">';

				if(
					$programme->getLogo() != '' && 
					file_exists(sfConfig::get('sf_upload_dir').'/programme/'.$programme->getLogo())
				) {
					$html .= '<img class="gmap-programme" src="/uploads/programme/'.$programme->getLogo().'" alt="Diapo Image" />';
				}

				$html .= $programme->getAccroche();
				$html .= '<a href="http://association.up2green.com/programme/'.$programme->getSlug().'" class="read_more" target="_blank">Lire la suite</a>';
				$html .= '<br /></span>';

				if(isset($this->nbArbresToPlant) && !empty($this->nbArbresToPlant)) {
					$html .= '
						<span class="action">
							<span>Plantez vos arbres <span class="nbTree" programme="'.$programme->getId().'"></span> : </span>
							<button class="addTree button really-small green" programme="'.$programme->getId().'">+</button>
							<button class="removeTree button really-small gray" programme="'.$programme->getId().'">-</button>
						</span>
					';
				}

				if($geocoded_addr->getLat() != '' && $geocoded_addr->getLng() != '') {
					$gMapMarker->addEvent(new GMapEvent(
						'click',
						'$.fn.moveToMarker('.$geocoded_addr->getLat().', '.$geocoded_addr->getLng().');'
					));
				}

				$gMapMarker->addHtmlInfoWindow(new GMapInfoWindow(
					'<div class="gmap-info-bulle">'.$html.'</div>',
					array(
						'maxWidth' => 300
					)
				));

				$this->gMap->addMarker($gMapMarker);

			}
		
		$this->gMap->setZoom(2);
		$this->gMap->setCenter(25, 0);
		$this->gMapModes = $this->getGmapModeSelector();
	}
	
	private function getGmapModeSelector() {
		$modes = array();
		$checked = false;
		
		// mode tous
		$allValues = array();
		$allValuesEmpty = array();
		foreach($this->programmes as $programme) {
			$allValues += array($programme->getTitle() => $programme->countTrees());
			$allValuesEmpty += array($programme->getTitle() => 0);
		}
		
		// mode partenaire
		if(!$this->getUser()->isAuthenticated() && !is_null($this->partenaire)) {
			
			$partenaireValues = $allValuesEmpty;
			//Les arbres plantés par ses coupons
			foreach($this->partenaire->getCoupons() as $coupon) {
				foreach($coupon->getCoupon()->getTrees() as $treeCoupon) {
					$tree = $treeCoupon->getTree();
					if(isset($partenaireValues[$tree->getProgramme()->getTitle()])) {
						$partenaireValues[$tree->getProgramme()->getTitle()] ++;
					}
				}
			}
			//Les arbres plantés directement
			foreach($this->partenaire->getUser()->getTrees() as $treeUser) {
				$tree = $treeUser->getTree();
				if(isset($partenaireValues[$tree->getProgramme()->getTitle()])) {
					$partenaireValues[$tree->getProgramme()->getTitle()] ++;
				}
			}
			
			$checked = !$checked;
			$modes[] = array(
				'name' => 'partenaire-'.$this->partenaire->getId(),
				'label' => "Tous les arbes plantés par ".$this->partenaire->getTitle(),
				'values' => $partenaireValues,
				'checked' => $checked
			);
		}
		
		if ($this->getUser()->isAuthenticated()) {
			$userValues = $allValuesEmpty;
			foreach($this->getUser()->getGuardUser()->getTrees() as $treeUser) {
				$tree = $treeUser->getTree();
				if(isset($userValues[$tree->getProgramme()->getTitle()])) {
					$userValues[$tree->getProgramme()->getTitle()] ++;
				}
			}
			$checked = !$checked;
			$modes[] = array(
				'name' => 'user',
				'label' => "Les arbres plantés avec mon compte",
				'values' => $userValues,
				'checked' => $checked
			);
			
			if(!is_null($this->partenaire)) {
				
				$couponValues = $allValuesEmpty;
				//Les arbres plantés par ses coupons
				foreach($this->partenaire->getCoupons() as $coupon) {
					foreach($coupon->getCoupon()->getTrees() as $treeCoupon) {
						$tree = $treeCoupon->getTree();
						if(isset($couponValues[$tree->getProgramme()->getTitle()])) {
							$couponValues[$tree->getProgramme()->getTitle()] ++;
						}
					}
				}
				
				$modes[] = array(
					'name' => 'coupon',
					'label' => "Les arbres plantés avec mes coupons",
					'values' => $couponValues,
					'checked' => $checked
				);
				
			}
			
		}
		
		$modes[] = array(
			'name' => 'all',
			'label' => "Tous les arbres plantés",
			'values' => $allValues,
			'checked' => !$checked
		);
		
		return $modes;
	}

	private function getNbTrees(programme $programme) {
		// si l'utilisateur est connecté
		if ($user = $this->getUser()->getGuardUser()) {
			// si c'est un partenaire
			if ($partenaire = $user->getPartenaire()) {
				// récupération des coupons du partenaire
				$coupons = $partenaire->getCoupons();
				// comptage des arbres faisant parti du programme
				$cpt = 0;
				foreach ($coupons as $couponPartenaire) {
					$coupon = $couponPartenaire->getCoupon();
					foreach ($coupon->getTreeCoupon() as $treeCoupon) {
						$tree = $treeCoupon->getTree();
						if ($tree->getProgramme() == $programme) $cpt ++;
					}
				}
				return $cpt;
			}
			return 0;
		}
		return 0;
	}

	private function getProgrammeIcon(programme $programme) {
		return new GMapMarkerImage(
			'/images/gmap/pointeur/60x60/empty/vert.png',
			array(
				'width' => 60,
				'height' => 60,
			)
		);
	}

}
