<?php
class generationCouponPartenaireForm extends BaseForm {
    public function configure() {
        $this->setWidgets(array(
                'type_coupon'    => new sfWidgetFormSelect(array('choices' => couponGenTable::getTabChoices())),
                'nombre'   => new sfWidgetFormInputText(),
                'prefix'   => new sfWidgetFormInputText()
        ));
        $this->setValidators(array(
                'type_coupon'    => new sfValidatorChoice(array('choices' => array_keys(couponGenTable::getTabChoices()), 'required'=>'true')),
                'nombre'   => new sfValidatorInteger(array('required'=>'true')),
                'prefix'   => new sfValidatorString(array(
					'max_length' => '5'
				)),
        ));

        $this->widgetSchema->setNameFormat('couponPartenaire[%s]');
    }
}