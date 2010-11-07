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

	public function executeInscription(sfWebRequest $request) {
		if (!$this->getUser()->isAuthenticated()){
			$this->redirect('@homepage');
			return;
		}
	
		$this->form = new userRegistrationForm();

		if($request->isMethod('post')) {
			$this->form->bind($request->getParameter($this->form->getName()));

			if($this->form->isValid()) {
				$utilisateur = $this->form->save();
				$utilisateur->save();
				
				// @TODO: envoyer un email ici

				$this->getUser()->signIn($utilisateur);
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

		$this->form = new sfForm();
		$this->form->embedForm('profil', $profilForm);
		$this->form->embedForm('user', $userForm);
		
		// dont allow username and email change
		unset($userForm['username'], $userForm['email_address']);

		$this->nbTrees = Doctrine_Core::getTable('tree')->countFromUser($this->getUser()->getGuardUser()->getId());
		
		if($request->isMethod('post')) {
		 
			$userForm->bind($request->getPostParameter('user'));
			$profilForm->bind($request->getPostParameter('profil'));

			if($userForm->isValid() && $profilForm->isValid()) {
				$profil = $profilForm->save();
				$user = $userForm->save();
				
				$profil->save();
				$user->save();

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
				$message = $this->getMailer()->compose(
								array('webmaster@up2green.com' => 'Up2Green'),
								$user->getEmailAddress(),
								'Votre nouveau mot de passe'
				);
				
				$html = "Bonjour " . $user->getUsername() . ", <br />".
								"Vous avez demandé à changer votre mot de passe. <br />".
								"Votre nouveau mot de passe est : " . $pwd . "<br /><br />".
								"Nous vous conseillons de changer votre mot de passe à votre prochaine connexion.<br /><br />".
								"A bientôt pour de nouvelles recherches sur http://up2green.com/ !";
				
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
