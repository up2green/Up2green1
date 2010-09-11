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
        $this->programmes = Doctrine_Core::getTable('programme')->findAll();

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
        }

        if ($request->isMethod('post')) {
            if ($request->getParameter('numCouponToUse')) {
                if ($coupon = Doctrine_Core::getTable('coupon')->findOneBy('code', $request->getParameter('code'))) {
                    if ($coupon->getIsActive()) {
                        $this->coupon = $coupon;
                        $this->spendAll = true;
                        $this->nbArbresToPlant = $coupon->getCouponGen()->getCredit();
//                            $coupon->setIsActive(false);
                        // utilisation du coupon
                    }
                    else $this->coupon = null;
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
                    else $this->phraseCoupon = "Ce coupon a déjà été utilisé";
                }
            }
        }
    }
    private function executePosts(sfWebRequest $request) {
        

    }

    public function executeListeCouponsPartenaires(sfWebRequest $request) {
        if (($user = $this->getUser()->getGuardUser()) && ($partenaire = $user->getPartenaire())) {
            $arrCoupons = array();
            $arrCouponsUsed = array();

            $totalCoupons = Doctrine_Query::create()->select('*')->from("coupon c")
                    ->leftJoin('c.CouponsPartenaires cp')->where('cp.partenaire_id = ?', $partenaire->getId())
                            ->leftJoin('c.couponGen cg')->orderBy('cg.credit')->execute();
            foreach ($totalCoupons as $coupon) {
                if ($coupon->getIsActive()) $arrCoupons[] = $coupon;
                else $arrCouponsUsed[] = $coupon;
            }
           $this->couponsUsed = $arrCouponsUsed;
           $this->coupons = $arrCoupons;
        }
    }
}
