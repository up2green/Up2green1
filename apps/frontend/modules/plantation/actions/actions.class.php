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
			$this->setProgrammesFromPartenaire($this->partenaire);
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
		
		if ($request->isMethod('post')) {
			
			// l'utilisateur a entré son numéro de coupon
			if ($request->getParameter('numCouponToUse')) {
				if ($coupon = Doctrine_Core::getTable('coupon')->findOneBy('code', $request->getParameter('code'))) {
					if ($coupon->getIsActive()) {
						$this->coupon = $coupon;
						if(is_null($this->partenaire)) {
							$this->partenaire = $coupon->getPartenaire()->getPartenaire();
						}
						$this->setProgrammesFromPartenaire($this->partenaire);
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
						$this->setProgrammesFromPartenaire($coupon->getPartenaire()->getPartenaire());
						
						$email = "";
						if (($request->hasParameter('email_user_deco')) && ($request->getParameter('email_user_deco') != "")) {
							$email = trim($request->getParameter('email_user_deco'));
						}
						
						if ($request->getParameter('nbArbresToPlantLeft') == 0){
							$trees = array();
							foreach ($this->programmes as $programme){
								if ($request->getParameter('nbArbresProgrammeHidden_'.$programme->getId()) > 0){
									$trees += array($programme->getTitle() => $request->getParameter('nbArbresProgrammeHidden_'.$programme->getId()));
									$coupon->plantArbre($request->getParameter('nbArbresProgrammeHidden_'.$programme->getId()), $programme, $this->getUser());
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
								// on construit l'attestation :
								$filename = $this->buildAttestation($email, $trees);
								
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
								
								if(file_exists($filename)) {
									$message->attach(
										Swift_Attachment::fromPath($filename)
									);
								}
								
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
	/*
	 * Construit l'attestation pdf dans le dossier temporaire
	 * @return: (string) nom du fichier physique
	 */
	public function buildAttestation($username, $trees) {
		$config = sfTCPDFPluginConfigHandler::loadConfig('my_config');

		// pdf object
		$pdf = new attestationPDF();

		// settings
		$pdf->SetMargins(10, 20);
		$pdf->SetHeaderMargin(0);
		$pdf->setPrintFooter(false);

		// init pdf doc
		$pdf->AliasNbPages();
		$pdf->AddPage();
		
		$nbTotal = array_sum($trees);
		
		//body
		$pdf->Cell(0,10,'certifie que',0,1,'C');
		
		$pdf->SetTextColor(73,115,16);
		$pdf->SetFontSize(16);
		$pdf->Cell(0,7,$username,0,1,'C');
		$pdf->SetFontSize(12);
		$pdf->SetTextColor(0);
		$pdf->Cell(0, 5, '', 0, 1); // saut de ligne
		$pdf->Cell(0,5,'a fincancé la plantation '.($nbTotal > 1 ? 'de '.$nbTotal.' arbres' : 'd\'un arbre'),0,1,'C');
		
		if(sizeof($trees) > 1) {
			$pdf->Cell(0,5,'dans les programmes de reforestation suivants :',0,1,'C');
		}
		else {
			$pdf->Cell(0,5,'dans le programme de reforestation suivant :',0,1,'C');
		}
		
		$current_y_position = $pdf->getY();
		$pdf->SetTextColor(73,115,16);
		$pdf->SetFontSize(13);
		$pdf->writeHTMLCell(130, 0, 15, $current_y_position, join(', ', array_keys($trees)),0,1,false, true, 'C');
		$pdf->SetFontSize(12);
		$pdf->SetTextColor(0);
			
		$pdf->writeHTMLCell(0, 0, 15, 85, '<b><font size="-4">A Paris, le '.date('d/m/Y').'</font></b>', 0, 1, false, true, 'L');
		
		// output
		$filename = '/tmp/attestation-'.uniqid().'.pdf';
		$pdf->Output($filename , 'F');
		return $filename;
	}
	
	public function setProgrammesFromPartenaire($partenaire) {
		if(!is_null($partenaire)) {
			$partenaireProgrammes = $partenaire->getProgrammes();
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
				->leftJoin('c.Partenaire cp')
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
