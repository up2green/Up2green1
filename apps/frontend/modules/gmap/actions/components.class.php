<?php

/**
 * gmap actions.
 *
 * @package    up2green
 * @subpackage gmap
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class gmapComponents extends sfComponents {
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */

	public function executeIndex(sfWebRequest $request) {
		$this->gMap = new GMap(array(
			'scrollwheel' => 'false',
			'mapTypeId' => 'google.maps.MapTypeId.SATELLITE'
		));
		$this->programmes = Doctrine::getTable('programme')->getActive();
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
							<button class="button really-small green">+</button>
							<button class="button really-small gray">-</button>
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
