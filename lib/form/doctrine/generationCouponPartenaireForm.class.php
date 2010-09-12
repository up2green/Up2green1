<?php
class generationCouponPartenaireForm extends BaseForm {
    public function configure() {
        $this->setWidgets(array(
                'type_coupon'    => new sfWidgetFormSelect(array('choices' => couponGenTable::getTabChoices())),
                'nombre'   => new sfWidgetFormInputText(),
        ));
        $this->setValidators(array(
                'type_coupon'    => new sfValidatorChoice(array('choices' => array_keys(couponGenTable::getTabChoices()), 'required'=>'true')),
                'nombre'   => new sfValidatorInteger(array('required'=>'true')),
        ));

        $this->widgetSchema->setNameFormat('couponPartenaire[%s]');
    }
}