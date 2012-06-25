<?php

/**
 * gallery filter form.
 *
 * @package    up2green
 * @subpackage filter
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class galleryFormFilter extends BasegalleryFormFilter
{

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
