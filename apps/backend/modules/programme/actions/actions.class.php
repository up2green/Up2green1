<?php

require_once dirname(__FILE__) . '/../lib/programmeGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/programmeGeneratorHelper.class.php';

/**
 * Programme actions
 *
 * @category Actions
 * @package  Frontend
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class programmeActions extends autoProgrammeActions
{

  /**
   * ShowTrees Action : Show the history of trees planted in the program
   * 
   * @param sfWebRequest $request
   * @throws Exception 
   */
  public function executeShowTrees(sfWebRequest $request)
  {
    $this->programme = $this->getRequestProgramme($request);

    $this->months = array_merge_recursive(
      $this->programme->getTreesVoucherPartnerGroupByMonth(), 
      $this->programme->getTreesVoucherUserGroupByMonth(), 
      $this->programme->getTreesUserGroupByMonth()
    );

    ksort($this->months);
  }

  /**
   * Return the programme by the id in the request.
   * 
   * @param sfWebRequest $request
   * @return programme
   * @throws Exception 
   */
  protected function getRequestProgramme(sfWebRequest $request)
  {
    $program = Doctrine_Core::getTable('programme')
      ->findOneById($request->getParameter("id"));

    if (!$program)
    {
      throw new Exception(sprintf('Programme %s not found in the database', $id));
    }

    return $program;
  }

}
