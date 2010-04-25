<?php

/**
 * programme actions.
 *
 * @package    up2green
 * @subpackage programme
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class programmeActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->programmes = Doctrine::getTable('programme')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->programme = Doctrine::getTable('programme')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->programme);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new programmeForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new programmeForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($programme = Doctrine::getTable('programme')->find(array($request->getParameter('id'))), sprintf('Object programme does not exist (%s).', $request->getParameter('id')));
    $this->form = new programmeForm($programme);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($programme = Doctrine::getTable('programme')->find(array($request->getParameter('id'))), sprintf('Object programme does not exist (%s).', $request->getParameter('id')));
    $this->form = new programmeForm($programme);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($programme = Doctrine::getTable('programme')->find(array($request->getParameter('id'))), sprintf('Object programme does not exist (%s).', $request->getParameter('id')));
    $programme->delete();

    $this->redirect('programme/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $programme = $form->save();

      $this->redirect('programme/edit?id='.$programme->getId());
    }
  }
}
