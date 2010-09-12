<?php

require_once dirname(__FILE__).'/../lib/partenaireGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/partenaireGeneratorHelper.class.php';

/**
 * partenaire actions.
 *
 * @package    up2green
 * @subpackage partenaire
 * @author     Clément Gautier
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class partenaireActions extends autoPartenaireActions {
    public function executeGenerateCoupons(sfWebRequest $request) {
        $this->partenaire = Doctrine_Core::getTable('partenaire')->findOneBy('id', $request->getParameter("id"));
        $this->form = new generationCouponPartenaireForm();

        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('couponPartenaire'));
            if ($this->form->isValid()) {
                $this->tabCoupons = $this->partenaire->generateCoupons($this->form->getValue("nombre"), Doctrine_Core::getTable('couponGen')->findOneBy('id', $this->form->getValue("type_coupon")));
            }
        }
    }
}
