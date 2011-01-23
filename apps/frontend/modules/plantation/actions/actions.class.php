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
		$this->fromUrl = '';
		
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
			$this->fromUrl = $request->getParameter('fromUrl');
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
						$this->errors[] = 'coupon-already-user';
					}
				}
			}
			
			// submit pour planter les arbres
			if ($request->getParameter('submitArbresProgramme')){
				$email = "";
				$sendMail = false;

				if (($request->hasParameter('email_user_deco'))
					&& ($request->getParameter('email_user_deco') != "")) {
					$email = trim($request->getParameter('email_user_deco'));
				}
				
				$codeCoupon = $request->getParameter('plantCouponCode');
				if (!empty($codeCoupon) && $coupon = Doctrine_Core::getTable('coupon')->findOneBy('code', $codeCoupon)) {
					if ($coupon->getIsActive()){
						$this->coupon = $coupon;
						$this->setProgrammesFromPartenaire($coupon->getPartenaire()->getPartenaire());
						
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
							
							$sendMail = true;
							$this->errors[] = 'plant-succes';
							$this->coupon = null;
							
						}
						else {
							$this->errors[] = 'error-plant-all';
						}
					}
					else {
						$this->errors[] = 'coupon-already-user';
						$this->coupon = null;
					}
				}
				else {
					if($this->getUser()->isAuthenticated()) {
						$trees = array();
						foreach ($this->programmes as $programme){
							if ($request->getParameter('nbArbresProgrammeHidden_'.$programme->getId()) > 0){
								$trees += array($programme->getTitle() => $request->getParameter('nbArbresProgrammeHidden_'.$programme->getId()));
								Doctrine_Core::getTable('treeUser')->plantArbre($request->getParameter('nbArbresProgrammeHidden_'.$programme->getId()), $programme, $this->getUser());
							}
						}

						$profil = $this->getUser()->getGuardUser()->getProfile();
						$profil->setCredit($profil->getCredit() - array_sum($trees));
						$profil->save();
						
						$this->nbArbresToPlant -= array_sum($trees);

						if($this->getUser()->getGuardUser()->getEmailAddress()){
							$email = $this->getUser()->getGuardUser()->getEmailAddress();
							$sendMail = true;
						}

						$this->errors[] = 'plant-succes';
					}
					else {
						$this->errors[] = 'error-deco';
					}
				}

				if($sendMail && !empty($email)) {
					// on construit l'attestation :
					$filename = $this->buildAttestation($email, $trees);

					$newsletter = Doctrine_Core::getTable('newsletter')->getBySlug('attestation-de-plantation');

					$message = $this->getMailer()->compose(
						array($newsletter->getEmailFrom() => 'Up2Green'),
						$email,
						$newsletter->getTitle()
					);

					$html = $newsletter->getContent();
					$html = str_replace('%treeNumber%', $request->getParameter('nbTreeMax'), $html);

					$message->setBody($html, 'text/html');

					if(file_exists($filename)) {
						$message->attach(
							Swift_Attachment::fromPath($filename)
						);
					}

					$this->getMailer()->send($message);
					$this->errors[] = 'email-confirmation';
				}
			}
		}
		
		if(is_null($this->coupon) && !empty($this->fromUrl)) {
			return $this->redirect($this->fromUrl);
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
		$pdf->Cell(0,5,'a financé la plantation '.($nbTotal > 1 ? 'de '.$nbTotal.' arbres' : 'd\'un arbre'),0,1,'C');
		
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
						'title ' => "'".$programme->getId()."'",
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
		$programmesIds = array();
		
		foreach($this->programmes as $programme) {
			$allValuesEmpty += array($programme->getId() => array(
				'title' => $programme->getTitle(),
				'number' => 0
			));
		}
		
		$results = Doctrine_Core::getTable('programme')->countTrees(array_keys($allValuesEmpty));
		$allValues = $allValuesEmpty;
		foreach($results as $result) {
			$allValues[$result['id']]['number'] = $result['nbTree'];
		}
		
		// mode partenaire
		if(!$this->getUser()->isAuthenticated() && !is_null($this->partenaire)) {
			
			$partenaireValues = $allValuesEmpty;
			$sum = 0;
			
			$resultsFromUser = Doctrine_Core::getTable('tree')->countFromUserByProgramme($this->partenaire->getUser()->getId(), array_keys($allValuesEmpty));
			$resultsFromCoupon = Doctrine_Core::getTable('tree')->countFromCouponPartenaireByProgramme($this->partenaire->getId(), array_keys($allValuesEmpty));
			
			foreach($resultsFromUser as $result) {
				$partenaireValues[$result['programme_id']]['number'] += $result['nbTree'];
				$sum += $result['nbTree'];
			}
			
			foreach($resultsFromCoupon as $result) {
				$partenaireValues[$result['programme_id']]['number'] += $result['nbTree'];
				$sum += $result['nbTree'];
			}
			
			$checked = !$checked;
			$modes[] = array(
				'name' => 'partenaire-'.$this->partenaire->getId(),
				'partenaireId' => $this->partenaire->getId(),
				'partenaireTitle' => $this->partenaire->getTitle(),
				'values' => $partenaireValues,
				'displayValue' => $sum,
				'checked' => $checked
			);
		}
		
		if ($this->getUser()->isAuthenticated()) {
			$userValues = $allValuesEmpty;
			$sum = 0;

			$resultsFromUser = Doctrine_Core::getTable('tree')->countFromUserByProgramme($this->getUser()->getGuardUser()->getId(), array_keys($allValuesEmpty));
			foreach($resultsFromUser as $result) {
				$userValues[$result['programme_id']]['number'] += $result['nbTree'];
				$sum += $result['nbTree'];
			}
			
			$modes[] = array(
				'name' => 'user',
				'values' => $userValues,
				'displayValue' => $sum,
				'checked' => false
			);
			
			if(!is_null($this->partenaire)) {
				$couponValues = $allValuesEmpty;
				$sum = 0;

				$resultsFromCoupon = Doctrine_Core::getTable('tree')->countFromCouponPartenaireByProgramme($this->partenaire->getId(), array_keys($allValuesEmpty));
				foreach($resultsFromCoupon as $result) {
					$couponValues[$result['programme_id']]['number'] += $result['nbTree'];
					$sum += $result['nbTree'];
				}

				$checked = !$checked;
				$modes[] = array(
					'name' => 'coupon',
					'values' => $couponValues,
					'displayValue' => $sum,
					'checked' => $checked
				);
				
			}
			
		}
		
		$modes[] = array(
			'name' => 'all',
			'values' => $allValues,
			'displayValue' => Doctrine_Core::getTable('tree')->count() + sfConfig::get('app_hardcode_tree_number'),
			'checked' => !$checked
		);
		
		return $modes;
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
