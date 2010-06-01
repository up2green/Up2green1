<?php

/**
 * user actions.
 *
 * @package    up2green
 * @subpackage user
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class userActions extends sfActions {
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        //$this->forward('default', 'module');
    }

    public function executeInscription(sfWebRequest $request) {
        $this->form = new userRegistrationForm();

        if($request->isMethod('post')) {
            $this->form->bind($request->getParameter($this->form->getName()));

            if($this->form->isValid()) {
                $utilisateur = $this->form->save();
                $utilisateur->save();

                $this->getUser()->signIn($utilisateur);
                $this->redirect('@homepage');
            }
        }
    }

    public function executeProfil(sfWebRequest $request){
        if ($this->getUser()->isAuthenticated()){

        }
    }

    public function executeForgotPassword(sfWebRequest $request) {
        if ($request->isMethod('post')) {
            if ($user = Doctrine_Core::getTable('sfGuardUser')->findOneBy("username", $request->getPostParameter("username"))) {
//                die('ok');
                $pwd = substr(md5(rand().rand()), 0, 8);
                $user->setPassword($pwd);
                $user->save();
                $message = $this->getMailer()->compose(
                        array('noreply@up2green.com' => 'Up2Green Bot'),
                        $user->userProfile->getMail(),
                        '[Up2Green] Nouveau mot de passe',
                        "Bonjour " . $user->getUsername() . ", <br />".
                        "Vous avez demandé à changer votre mot de passe. <br />".
                        "Votre nouveau mot de passe est : " . $pwd . "<br /><br />".
                        "Nous vous conseillons de changer votre mot de passe à votre prochaine connexion.<br /><br />".
                        "A bientôt pour de nouvelles recherches sur http://up2green.com/ !"
                );
//                $message->getHeaders()->remove('Content-Type');
//                $message->getHeaders()->addParameterizedHeader('Content-Type', 'text/html');
//                $message->getHeaders()->addParameterizedHeader('charset', 'utf-8');
//                $type->setValue('text/html');
//                $this->getMail()->c
                
                $this->getMailer()->send($message);
                $this->pwd = $pwd;
            }
            else{
                $this->error = "Nom d'utilisateur inconnu ou vide";
            }
        }
    }
}
