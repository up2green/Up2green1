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
		$this->view = $request->getParameter('view');
		
		$this->phraseCoupon = "";
		
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

		if ($request->isMethod('post')) {
			
			// l'utilisateur a entré son numéro de coupon
			if ($request->getParameter('numCouponToUse')) {
				if ($coupon = Doctrine_Core::getTable('coupon')->findOneBy('code', $request->getParameter('code'))) {
					if ($coupon->getIsActive()) {
						$this->coupon = $coupon;
						if(is_null($this->partenaire)) {
							$this->partenaire = $coupon->getPartenaire()->getPartenaire();
						}
						$this->spendAll = true;
						$this->nbArbresToPlant = $coupon->getCouponGen()->getCredit();
					}
					else {
						$this->coupon = null;
						$this->phraseCoupon = "Ce coupon a déjà été utilisé";
					}
				}
			}
			
			// submit pour planter les arbres
			if ($request->getParameter('submitArbresProgramme')){
				if ($coupon = Doctrine_Core::getTable('coupon')->findOneBy('code', $request->getParameter('plantCouponCode'))) {
					if ($coupon->getIsActive()){
						
						$email = "";
						if (($request->hasParameter('email_user_deco')) && ($request->getParameter('email_user_deco') != "")) {
							$email = $request->getParameter('email_user_deco');
						}
						
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

						$this->phraseCoupon = "Vos arbres ont été plantés.";
					}
					else {
						$this->phraseCoupon = "Ce coupon a déjà été utilisé";
						$this->coupon = null;
					}
				}
			}
		}

		$this->getGmap();
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
				->leftJoin('c.CouponsPartenaires cp')
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
			'mapTypeId' => 'google.maps.MapTypeId.SATELLITE'
		));
		//		$this->programmes = Doctrine::getTable('programme')->getActive();
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

				$gMapMarker->SetCustomProperties(array(
					'class' => 'gmap-marker'
				));

				$html = '<span class="title">'.$programme->getTitle().'</span>';
				$html .= '<p class="content">';

				if(
					$programme->getLogo() != '' && 
					file_exists(sfConfig::get('sf_upload_dir').'/programme/'.$programme->getLogo())
				) {
					$html .= '<img class="gmap-programme" src="/uploads/programme/'.$programme->getLogo().'" alt="Diapo Image" />';
				}

				$html .= $programme->getAccroche();
				$html .= '<a href="http://association.up2green.com/programme/'.$programme->getSlug().'" class="read_more" target="_blank">Lire la suite</a>';
				$html .= '</p>';

				if(isset($this->nbArbresToPlant) && !empty($this->nbArbresToPlant)) {
					$html .= '
						<span class="action">
							<button class="addTree button really-small green" programme="'.$programme->getId().'">+</button>
							<button class="removeTree button really-small gray" programme="'.$programme->getId().'">-</button>
						</span>
					';
				}

				$html .= '<br />';

				$gMapMarker->addEvent(new GMapEvent(
					'click',
					'$.fn.moveToMarker('.$geocoded_addr->getLat().', '.$geocoded_addr->getLng().');'
				));


				$gMapMarker->addHtmlInfoWindow(new GMapInfoWindow(
					'<div class="gmap-info-bulle">'.$html.'</div>',
					array(
						'maxWidth' => 300
					)
				));

				$this->gMap->addMarker($gMapMarker);

			}
				
		$this->gMap->centerAndZoomOnMarkers();
		$this->gMapModes = $this->getGmapModeSelector();
	}
	
	private function getGmapModeSelector() {
		$modes = array();
		$checked = false;
		
		// mode tous
		$allValues = array();
		foreach($this->programmes as $programme) {
			$allValues[$programme->getTitle()] = $programme->countTrees();
			$allValuesEmpty[$programme->getTitle()] = 0;
		}
		
		// mode partenaire
		if(!is_null($this->partenaire)) {
			
			$partenaireValues = $allValuesEmpty;
			foreach($this->partenaire->getCoupons() as $coupon) {
				foreach($coupon->getCoupon()->getTrees() as $tree) {
					$partenaireValues[$tree->getProgramme()->getTitle()] ++;
				}
			}
			$checked = true;
			$modes[] = array(
				'name' => 'partenaire-'.$this->partenaire->getId(),
				'label' => 'Tout les arbes plantés par '.$this->partenaire->getTitle(),
				'values' => $partenaireValues,
				'checked' => $checked
			);
		}
		
		// mode user
		if ($this->getUser()->isAuthenticated()) {
			$userValues = $allValuesEmpty;
			foreach($this->getUser()->getGuardUser()->getTrees() as $tree) {
				$userValues[$tree->getProgramme()->getTitle()] ++;
			}
			$checked = !$checked;
			$modes[] = array(
				'name' => 'user',
				'label' => "Les arbres que j'ai planté",
				'values' => $userValues,
				'checked' => $checked
			);
		}
		
		$modes[] = array(
			'name' => 'all',
			'label' => 'Tout les arbes plantés',
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
