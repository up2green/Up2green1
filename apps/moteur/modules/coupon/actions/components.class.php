<?php

/**
 * coupon actions.
 *
 * @package    up2green
 * @subpackage coupon
 * @author     Clément Gautier
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class couponComponents extends sfComponents
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
	public function executeForm(sfWebRequest $request)
	{
		$this->form = new sfForm();
	}
}
