<?php

require_once dirname(__FILE__) . '/../lib/programmeGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/programmeGeneratorHelper.class.php';

/**
 * programme actions.
 *
 * @package    up2green
 * @subpackage programme
 * @author     Clément Gautier
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class programmeActions extends autoProgrammeActions
{

  public function executeShow(sfWebRequest $request)
  {
    $this->programme = Doctrine_Core::getTable('programme')
      ->findOneById($request->getParameter("id"));

    if (!$this->programme) {
      throw new Exception(sprintf('Programme %s not found in the database', $id));
    }
    
    $this->months = array();
    
  }

}
