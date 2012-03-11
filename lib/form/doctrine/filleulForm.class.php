<?php

/**
 * filleul form.
 *
 * @category Lib
 * @package  Form
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class filleulForm extends BasefilleulForm
{
  public function configure()
  {
		unset(
			$this['created_at'],
			$this['updated_at']
		);
  }
}
