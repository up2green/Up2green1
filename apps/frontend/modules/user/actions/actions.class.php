<?php

/**
 * user actions.
 *
 * @package    up2green
 * @subpackage user
 * @author     Clément Gautier
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class userActions extends sfActions {
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request) {
			$this->forward404();
	}
	
	public function executeListCoupon(sfWebRequest $request) {
		if (!$this->getUser()->isAuthenticated()) {
			$this->redirect('@sf_guard_signin');
			return;
		}

		$user = $this->getUser()->getGuardUser();
		$this->partenaire = ($user->getPartenaire()->getId() != null ? $user->getPartenaire() : null);
		
		if(!is_null($this->partenaire)) {
			$query = Doctrine::getTable('coupon')->getByPartenaireQuery($this->partenaire->getId());
		} else {
			$query = Doctrine::getTable('coupon')->getByUserQuery($user->getId());
		}
		
		$this->pager = new sfDoctrinePager('coupon', sfConfig::get('app_max_default_list_item'));
		$this->pager->setQuery($query);
		$this->pager->setPage($request->getParameter('page', 1));
		$this->pager->init();
		
		$this->coupons = $this->pager->getResults();
		
	}

	public function executeChangeLanguage(sfWebRequest $request) {
		$langs = sfConfig::get('app_cultures_enabled');

		$form = new sfFormLanguage(
			$this->getUser(),
			array('languages' => array_keys($langs))
		);

		$form->process($request);

		if ($this->getUser()->isAuthenticated()){
			$profil = $this->getUser()->getGuardUser()->getProfile();
			$profil->setCulture($form->getValue('language'));
			$profil->save();
		}

		return $this->redirect($request->getParameter('fromUrl'));
	}

	public function executeInscription(sfWebRequest $request) {
		if ($this->getUser()->isAuthenticated()){
			$this->redirect('@homepage');
			return;
		}
	
		$this->form = new userRegistrationForm();

		if($request->isMethod('post')) {
			$formPost = $request->getParameter($this->form->getName());
			$this->form->bind($formPost);

			if($this->form->isValid()) {

				$utilisateur = $this->form->save();
				$utilisateur->save();
				$this->getUser()->signIn($utilisateur);

				$newsletter = Doctrine_Core::getTable('newsletter')->getBySlug('inscription');

				$message = $this->getMailer()->compose(
					array($newsletter->getEmailFrom() => 'Up2Green'),
					$utilisateur->getEmailAddress(),
					$newsletter->getTitle()
				);

				$html = $newsletter->getContent();
				$html = str_replace('%username%', $utilisateur->getUsername(), $html);
				$html = str_replace('%password%', $formPost['password'], $html);

				$message->setBody($html, 'text/html');

				$this->getMailer()->send($message);
				$this->getUser()->setFlash('notice', 'creation-compte');
				$this->redirect('@homepage');
			}
		}
	}

	public function executeProfil(sfWebRequest $request){
		if (!$this->getUser()->isAuthenticated()){
			$this->redirect('@homepage');
			return;
		}

		// @TODO : find how protect embded form with CSRF
		sfForm::disableCSRFProtection();
		
		$userForm = new sfGuardUserForm($this->getUser()->getGuardUser());
		$profilForm = new profilForm($this->getUser()->getGuardUser()->getProfile());
		$passwordForm = new changeUserPasswordForm($this->getUser()->getGuardUser());

		$userForm->useFields(array('first_name', 'last_name', 'password'));
		$profilForm->useFields(array('is_newsletter'));

		$this->form = new sfForm();
		$this->form->embedForm('profil', $profilForm);
		$this->form->embedForm('user', $userForm);
		$this->form->embedForm('pass', $passwordForm);

		$this->nbTrees = Doctrine_Core::getTable('tree')->countFromUser($this->getUser()->getGuardUser()->getId());
		
		if($request->isMethod('post')) {
		 
			$userForm->bind($request->getPostParameter('user'));
			$profilForm->bind($request->getPostParameter('profil'));

			$passwordData = $request->getPostParameter('pass');
			$passwordForm->bind($request->getPostParameter('pass'));
			
			if($request->getPostParameter('submit_password')){
				if($passwordForm->isValid()){
					$passwordForm->save();
					$this->getUser()->setFlash('notice', 'modif-ok');
				}
				else {
					$this->getUser()->setFlash('error', 'form-error');
				}
			}
			else if($userForm->isValid() && $profilForm->isValid()) {

				$profil = $profilForm->save();
				$user = $userForm->save();

				$profil->save();
				$user->save();
				
				$this->getUser()->setFlash('notice', 'modif-ok');

				// @TODO: retirer cette redirection ?
				$this->redirect('user/profil');
				
			}
		}

		
	}

	public function executeForgotPassword(sfWebRequest $request) {
		if ($request->isMethod('post')) {
			if ($user = Doctrine_Core::getTable('sfGuardUser')->findOneBy("username", $request->getPostParameter("username"))) {

				$pwd = substr(md5(rand().rand()), 0, 8);
				$user->setPassword($pwd);
				$user->save();

				$newsletter = Doctrine_Core::getTable('newsletter')->getBySlug('nouveau-mot-de-passe');

				$message = $this->getMailer()->compose(
					array($newsletter->getEmailFrom() => 'Up2Green'),
					$user->getEmailAddress(),
					$newsletter->getTitle()
				);

				$html = $newsletter->getContent();
				$html = str_replace('%username%', $user->getUsername(), $html);
				$html = str_replace('%password%', $pwd, $html);

				$message->setBody($html, 'text/html');
				
				$this->getMailer()->send($message);
				$this->pwd = $pwd;
			}
			else{
				$this->error = "Nom d'utilisateur inconnu ou vide";
			}
		}
	}
}
