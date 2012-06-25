<?php
/**
 * Gallery actions.
 *
 * @category Actions
 * @package  Up2green
 * @author   Clément Gautier <clement.gautier.76@gmail.com>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 * @link     https://github.com/SmartIT-Fr
 */
class galleryActions extends sfActions
{
  /**
   * @param sfWebRequest $request
   * @return string
   */
  public function executeShow(sfWebRequest $request)
  {
    $slug = $request->getParameter('slug');
    $this->forward404Unless($slug);

    $this->gallery = Doctrine_Core::getTable('gallery')->findOneBySlug($slug);
    $this->forward404Unless($this->gallery);
  }
}
