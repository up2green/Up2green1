<?php

require_once dirname(__FILE__) . '/../lib/newsletterGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/newsletterGeneratorHelper.class.php';

/**
 * newsletter actions.
 *
 * @package    up2green
 * @subpackage newsletter
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class newsletterActions extends autoNewsletterActions
{
  public function executeSendToOne(sfWebRequest $request)
  {
    $this->newsletter = $this->getNewsletter($request->getParameter("id"));
    $this->form = new sendNewsletterToForm();

    if ($request->isMethod('post')) {
      $this->form->bind($request->getParameter('sendNewsletterTo'));
      if ($this->form->isValid()) {
        $message = $this->getMessage($this->form->getValue('email'), $this->form->getValue('newsletterVars'));

        try
        {
          $this->getMailer()->send($message);
          $this->getUser()->setFlash('notice', 'Mail successfuly sent!');
        }
        catch(Exception $e)
        {
          $this->getUser()->setFlash('error', sprintf("An error occured while sending the mail : %s.", $e->getMessage()));
        }

        $this->redirect('@newsletter');
      }
    }
  }

  public function executeSendToAllForced(sfWebRequest $request)
  {
    $request->setParameter("forced", true);
    $this->forward('newsletter', 'sendToAll');
  }

  public function executeSendToAll(sfWebRequest $request)
  {
    $this->newsletter = $this->getNewsletter($request->getParameter("id"));
    $this->forced = $request->getParameter("forced", false);
    $this->form = new NewsletterVarCollectionForm();

    if ($request->isMethod('post')) {
      $this->form->bind($request->getParameter('newsletterVarCollection'));
      if ($this->form->isValid()) {
        
        $emails = $this->getEmails();
        $oks = 0;
        $noks = 0;

        ini_set('max_execution_time', 0);
        ini_set('memory_limit',-1);

        foreach ($emails as $email) {
          try
          {
            $message = $this->getMessage($email, $this->form->getValues());
            $this->getMailer()->getRealtimeTransport()->stop();
            $this->getMailer()->getRealtimeTransport()->start();
            $this->getMailer()->sendNextImmediately()->send($message); 
            //$this->getMailer()->send($message);
            $oks++;
          }
          catch(Exception $e)
          {
            $noks++;
          }
        }

        if ($oks) {
          $this->getUser()->setFlash('notice', sprintf('Mail successfuly sent to %s user(s)!', $oks));
        }

        if ($noks) {
          $this->getUser()->setFlash('error', sprintf("Error occured while sending %s mail(s).", $noks));
        }

        $this->redirect('@newsletter');
      }
    }
  }

  /**
   * @param integer $id
   * @return Newsletter
   */
  protected function getNewsletter($id)
  {
    $newsletter = Doctrine_Core::getTable('newsletter')->findOneById($id);

    if (!$newsletter) {
      throw new Exception(sprintf('Newsletter %s not found in the database', $id));
    }

    return $newsletter;
  }

  /**
   * @param string $email
   * @param array $vars 
   * @return Swift_Message A Swift_Message instances
   */
  protected function getMessage($email, array $vars)
  {
    $message = $this->getMailer()->compose(
      array($this->newsletter->getEmailFrom() => 'Up2Green'),
      $email,
      $this->newsletter->getTitle()
    );

    $html = $this->newsletter->getContent();

    foreach ($vars as $var) {
      if (!empty ($var['key'])) {
        $html = str_replace($var['key'], $var['value'], $html);
      }
    }

    sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));

    // unsuscribe part
    $url = sfConfig::get('app_link_to_search').'newsletter/unsuscribe/'.base64_encode($email);

    $html .= '<br /><br /><p style="text-align:center;">'
      .__('Si vous ne voulez plus recevoir de notifications de la part de Up2green, cliquez sur le lien ci-dessous.')
      .'<br />'
      .'<a href="'.$url.'">'.$url.'</a>'
      .'</p>';

    $message->setBody($html, 'text/html');

    return $message;
  }

  /**
   * @return array
   */
  protected function getEmails($forced = false)
  {
    // emails from log_coupons table
    $emails = Doctrine_Core::getTable('sfGuardUser')->getDistinctEmails($forced);
    $emails = array_merge($emails, Doctrine_Core::getTable('filleul')->getDistinctEmails($forced, $emails));
    $emails = array_merge($emails, Doctrine_Core::getTable('logCoupon')->getDistinctEmails($forced, $emails));
    $emails = array_merge($emails, Doctrine_Core::getTable('preinscription')->getDistinctEmails($forced, $emails));
    $emails = array_merge($emails, Doctrine_Core::getTable('mailingList')->getDistinctEmails($forced, $emails));

    // hotfix du 31/01/2012
    // $emails = array_splice($emails, 77);

    return $emails;
  }
}
