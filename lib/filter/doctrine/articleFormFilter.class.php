<?php

/**
 * article filter form.
 *
 * @category Lib
 * @package  Filter
 * @author   Clément Gautier
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class articleFormFilter extends BasearticleFormFilter
{
  /**
   * @see parent 
   */
  public function configure()
  {
    $this->widgetSchema['created_at'] = new up2gWidgetFormInlineJQueryDateRange();
    $this->widgetSchema['updated_at'] = new up2gWidgetFormInlineJQueryDateRange();

    $this->widgetSchema['category_list'] = new sfWidgetFormDoctrineChoice(array(
        'model'     => 'category',
        'add_empty' => '~ (object is at root level)',
        'order_by'  => array('root_id, lft', ''),
        'method' => 'getIndentedName'
      ));

    $this->validatorSchema['category_list'] = new sfValidatorDoctrineChoice(array(
        'required' => false,
        'model'    => 'category'
      ));
  }

}
