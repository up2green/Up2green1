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
        $this->gMap = new GMap();
        $this->programmes = Doctrine::getTable('programme')->createQuery('a')->execute();
        foreach($this->programmes as $programme) {
            if(!is_null($programme->getGeoadress()) || (!is_null($programme->getLatitude()) && !is_null($programme->getLongitude()))) {
                if(!is_null($programme->getLatitude()) && !is_null($programme->getLongitude())) {
                    // latitude / longitude method
                    $geocoded_addr = new GMapGeocodedAddress(null);
                    $geocoded_addr->setLat($programme->getLatitude());
                    $geocoded_addr->setLng($programme->getLongitude());
                    $geocoded_addr->reverseGeocode($this->gMap->getGMapClient());
                }
                else {
                    // adress user friendly method
                    $geocoded_addr = new GMapGeocodedAddress($programme->getGeoadress());
                }

                $gMapMarker = new GMapMarker(
                        $programme->getLatitude(),
                        $programme->getLongitude(),
                        array(
                        /*
					'title ' => $programme->getTitle(),
					'zIndex ' => (100 + floor($programme->getMaxTree()/1000)),
					'clickable ' => null,
					'shadow ' => null,
					'flat ' => null
                        */
                                'icon'	=> $this->getProgrammeIcon($programme)
                        )
                );
                $nbTrees = $this->getNbTrees($programme);
                $descr = $geocoded_addr->getRawAddress();
                if ($nbTrees > 0) $descr .= "<br />Vous avez planté " . $nbTrees . " arbre(s) ici.";
                $gMapMarker->addHtmlInfoWindow(new GMapInfoWindow('<div>'.$descr.'</div>'));
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
