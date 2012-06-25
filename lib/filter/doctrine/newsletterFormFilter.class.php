<?php

/**
 * newsletter filter form.
 *
 * @category Lib
 * @package  Filter
 * @author   Clément Gautier
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class newsletterFormFilter extends BasenewsletterFormFilter
{
  /**
   * @see parent 
   */
  public function configure()
  {
    $this->widgetSchema['created_at'] = new up2gWidgetFormInlineJQueryDateRange();
    $this->widgetSchema['updated_at'] = new up2gWidgetFormInlineJQueryDateRange();
    $this->widgetSchema['sent_at'] = new up2gWidgetFormInlineJQueryDateRange();

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
