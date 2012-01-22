<?php

/**
 * newsletter actions.
 *
 * @package    up2green
 * @subpackage newsletter
 * @author     Clément Gautier
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class newsletterActions extends sfActions
{

  /**
   * @param sfRequest $request A request object
   */
  public function executeUnsuscribe(sfWebRequest $request)
  {
    sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));

    $email = base64_decode($request->getParameter('email'));

    Doctrine_Core::getTable('sfGuardUser')->unsuscribe($email);
    Doctrine_Core::getTable('filleul')->unsuscribe($email);
    Doctrine_Core::getTable('logCoupon')->unsuscribe($email);
    Doctrine_Core::getTable('preinscription')->unsuscribe($email);
    Doctrine_Core::getTable('mailingList')->unsuscribe($email);

    $this->getUser()->setFlash('notice', __('Vous avez été désinscrit avec succès'));
    $this->redirect('@homepage');

  }

}