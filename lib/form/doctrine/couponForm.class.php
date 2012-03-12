<?php

/**
 * coupon form.
 *
 * @category Lib
 * @package  Form
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
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
