<?php

/**
 * coupon form.
 *
 * @package    up2green
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class couponForm extends BasecouponForm
{
  public function configure()
  {
  	unset(
      $this['created_at'], $this['updated_at'],
      $this['used_at'], $this['used_by'], $this['is_active']
    );
  }
}
