<?php

/**
 * html actions.
 *
 * @package    up2green
 * @subpackage html
 * @author     Clément Gautier
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class htmlActions extends sfActions
{
 /**
  * Executes index action
  */
  public function executeIndex()
  {
    // TODO : delete this ?
    $this->forward('default', 'module');
  }
}
