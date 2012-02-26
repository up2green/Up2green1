<?php

/**
 * up2gWidgetFormInlineJQueryDateRange override the base date range widget by 
 * providing an inline version with datepicker
 *
 * @package    up2green
 * @subpackage widget
 * @author     Your name here
 */
class up2gWidgetFormInlineJQueryDateRange extends sfWidgetFormDateRange
{
  public function __construct($options = array(), $attributes = array())
  {
    parent::__construct(array_merge($options, array(
      'from_date' =>  new sfWidgetFormJQueryDate(array(
							'image'=>'/images/calendar.png',
			)),
			'to_date'   =>  new sfWidgetFormJQueryDate(array(
							'image'=>'/images/calendar.png',
			)),
			'template'  => 'From %from_date%<br />To %to_date%',
    )), $attributes);
  }

}
