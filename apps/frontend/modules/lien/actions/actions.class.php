<?php

/**
 * lien actions.
 *
 * @package    up2green
 * @subpackage lien
 * @author     Clément Gautier
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class lienActions extends sfActions
{
 /**
  * Executes index action
  * FIXME delete this ?
  */
  public function executeIndex()
  {
    $this->forward('default', 'module');
  }
}
