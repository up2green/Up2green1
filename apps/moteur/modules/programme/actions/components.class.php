<?php

/**
 * programme actions.
 *
 * @package    up2green
 * @subpackage programme
 * @author     Clément Gautier
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class programmeComponents extends sfComponents
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executePlant(sfWebRequest $request)
  {
  	$this->programmes = Doctrine::getTable('programme')->createQuery('a')->execute();
    $this->show_programme_navigation = Doctrine::getTable('programme')->count() > sfConfig::get('app_max_programme_plantation_list');
  }
}
