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

								$totalCoupons = Doctrine_Query::create()->select('*')->from("coupon c")
												->leftJoin('c.CouponsPartenaires cp')->where('cp.partenaire_id = ?', $this->partenaire->getId())
																->leftJoin('c.couponGen cg')->orderBy('cg.credit')->execute();
								foreach ($totalCoupons as $coupon) {
										if ($coupon->getIsActive()) $arrCoupons[] = $coupon;
										else $arrCouponsUsed[] = $coupon;
								}
							 $this->couponsUsed = $arrCouponsUsed;
							 $this->coupons = $arrCoupons;
						}
        }

        if ($request->isMethod('post')) {
            if ($request->getParameter('numCouponToUse')) {
                if ($coupon = Doctrine_Core::getTable('coupon')->findOneBy('code', $request->getParameter('code'))) {
                    if ($coupon->getIsActive()) {
                        $this->coupon = $coupon;
                        $this->spendAll = true;
                        $this->nbArbresToPlant = $coupon->getCouponGen()->getCredit();
                    }
                    else {
                        $this->coupon = null;
                        $this->phraseCoupon = "Ce coupon a déjà été utilisé";
                    }
                }
            }
            if ($request->getParameter('submitArbresProgramme')){
                if ($coupon = Doctrine_Core::getTable('coupon')->findOneBy('code', $request->getParameter('plantCouponCode'))) {
                    if ($coupon->getIsActive()){
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
	    $this->coupons = Doctrine_Query::create()->from('coupon c')->leftJoin('c.CouponsPartenaires cp')->where('cp.partenaire_id = ?', $partenaire->getId())
		    ->andWhere('c.is_active = ?', true)->execute();
	}
	else $this->forward404();
	$this->setLayout(false);
    }

        public function executeCouponsUsedCSV(sfWebRequest $request){
	if (($user = $this->getUser()->getGuardUser()) && ($partenaire = $user->getPartenaire())) {
	    $this->coupons = Doctrine_Query::create()->from('coupon c')->leftJoin('c.CouponsPartenaires cp')->where('cp.partenaire_id = ?', $partenaire->getId())
		    ->andWhere('c.is_active = ?', false)->execute();
	}
	else $this->forward404();
	$this->setLayout(false);
    }


    private function getGmap() {
		$this->gMap = new GMap(array(
			'scrollwheel' => 'false',
			'mapTypeId' => 'google.maps.MapTypeId.SATELLITE'
		));
//		$this->programmes = Doctrine::getTable('programme')->getActive();
		foreach($this->programmes as $programme) {

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
						'icon'	=> $this->getProgrammeIcon($programme)
					)
				);

				$html = '
					<span class="title">'.$programme->getTitle().'</span>
					<p class="content">'.$programme->getAccroche().'</p>
				';

				if(isset($this->nbArbresToPlant) && !empty($this->nbArbresToPlant)) {
					$html .= '
						<span class="action">
							<button id="addArbreProgrammeMap_'.$programme->getId().'" class="button really-small green">+</button>
							<button id="removeArbreProgrammeMap_'.$programme->getId().'" class="button really-small gray">-</button>
						</span>
					';
				}

				$gMapMarker->addEvent(new GMapEvent(
					'click',
					'moveToMarker('.$geocoded_addr->getLat().', '.$geocoded_addr->getLng().');'
				));


				$gMapMarker->addHtmlInfoWindow(new GMapInfoWindow(
					'<div class="gmap-info-bulle">'.$html.'</div>',
					array(
						'maxWidth' => 300
					)
				));

				$this->gMap->addMarker($gMapMarker);

			}
		}
		$this->gMap->centerAndZoomOnMarkers();
	}

    private function getNbTrees(programme $programme) {
        // si l'utilisateur est connecté
        if ($user = $this->getUser()->getGuardUser()) {
            // si c'est un partenaire
            if ($partenaire = $user->getPartenaire()) {
                // récupération des coupons du partenaire
                $coupons = $partenaire->getCouponsPartenaires();
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
                '/images/gmap/tree.png',
                array(
                        'width' => 32,
                        'height' => 32,
                )
        );
    }

}
