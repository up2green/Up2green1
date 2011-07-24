<?php

/**
 * ajax actions.
 *
 * @package    up2green
 * @subpackage ajax
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ajaxActions extends sfActions
{
	public function executeGetKML(sfWebRequest $request) {
		$this->displayOrganismeActif = $request->getParameter('displayOrganismeActif', false);
		$this->displayOrganismeInactif = $request->getParameter('displayOrganismeInactif', false);
		$this->displayProgrammeActif = $request->getParameter('displayProgrammeActif', true);
		$this->displayProgrammeInactif = $request->getParameter('displayProgrammeInactif', true);

		$partenaireId = $request->getParameter('partenaire', 0);
		$this->partenaire = Doctrine_Core::getTable('partenaire')->findOneById($partenaireId);
		
		// Organismes
		$this->organismes = null;
		if($this->displayOrganismeActif && $this->displayOrganismeInactif) {
			$this->organismes = Doctrine_Core::getTable('organisme')->get();
		}
		else if($this->displayOrganismeActif) {
			$this->organismes = Doctrine_Core::getTable('organisme')->getActive();
		}
		else if($this->displayOrganismeInactif) {
			$this->organismes = Doctrine_Core::getTable('organisme')->getInactive();
		}

		// Programmes
		$this->programmes = null;
		$query = null;
		if($this->displayProgrammeActif && $this->displayProgrammeInactif) {
			$query = Doctrine_Core::getTable('programme')->addQuery();
		}
		else if ($this->displayProgrammeActif) {
			$query = Doctrine_Core::getTable('programme')->addActiveQuery();
		}
		else if ($this->displayProgrammeInactif) {
			$query = Doctrine_Core::getTable('programme')->addInactiveQuery();
		}
		
		// Programmes Partenaire
		$this->displayProgrammePartenaire = $request->getParameter('displayProgrammePartenaire', ($this->partenaire ? true : false));
		$this->programmePartenaireId = array();
		if($this->partenaire && $this->displayProgrammePartenaire) {
			foreach($this->partenaire->getProgrammes() as $partenaireProgramme) {
				$this->programmePartenaireId[] = $partenaireProgramme->getProgrammeId();
			}
			if(null === $query) {
				$query = Doctrine_Core::getTable('programme')->addQuery();
				$query->where('p.id IN ('.implode($this->programmePartenaireId, ', ').')');
			}
			else {
				$query->orWhereIn($this->programmePartenaireId);
			}
		}

		if(null !== $query) {
			$this->programmes = Doctrine_Core::getTable('programme')->get($query);
		}
	}
	
	public function executeGetInfoProgramme(sfWebRequest $request) {
		$programmeId = $request->getParameter('programme', 0);
		$partenaireId = $request->getParameter('partenaire', 0);
		
		$this->partenaire = Doctrine_Core::getTable('partenaire')->findOneById($partenaireId);
		$this->programme = Doctrine_Core::getTable('programme')->findOneById($programmeId);
		$this->canPlant = $request->getParameter('canPlant', 0);
		$this->userProgrammeTrees = 0;
		
		$this->forward404Unless($this->programme);
		
		// on inactives le programme s'il n'est pas soutenu par le partenaire
		if($this->partenaire) {
			$partenaireProgrammes = $this->partenaire->getProgrammes()->getPrimaryKeys();
			if(!in_array($this->programme->getId(), $partenaireProgrammes)) {
				$this->programme->setIsActive(false);
			}
		}
		
		if($this->getUser()->isAuthenticated()) {
			$this->userProgrammeTrees = Doctrine_Core::getTable('tree')->countByUserAndProgramme($this->getUser()->getGuardUser()->getId(), array($programmeId));
		}
		
		// comptage des arbres planté sur le programme :
		$this->max = 0;
		$this->programmeTrees = 0;
		$this->showPerPartenaire = false;
		if ($this->partenaire)
		{
			$partenaireProgramme = Doctrine_Core::getTable('partenaireProgramme')->findOneByPartenaireIdAndProgrammeId($this->partenaire->getId(), $this->programme->getId());
$this->max = (int)$partenaireProgramme->getNumber();
			$this->programmeTrees = (int)$partenaireProgramme->getHardcode();
			$this->programmeTrees += (int)Doctrine_Core::getTable('tree')->countFromCouponPartenaireByProgramme($this->partenaire->getId(), $this->programme->getId());
			$this->showPerPartenaire = true;
		}

		if ( empty ($this->max))
		{
			$this->showPerPartenaire = false;
			$this->programmeTrees = Doctrine_Core::getTable('tree')->countByProgramme($programmeId);
			$this->max = $this->programme->getMaxTree();
		}

		if (empty ($this->max))
			$this->max = 1;

		$this->displayPourcent = floor($this->programmeTrees * 100 / $this->max);

		if(empty ($this->displayPourcent))
			$this->displayPourcent = 1;
		
	}
	
	public function executeGetInfoOrganisme(sfWebRequest $request) {
		$organismeId = $request->getParameter('organisme', 0);
		$this->organisme = Doctrine_Core::getTable('organisme')
						->addLangQuery($this->getUser()->getCulture())
						->addWhere('id = ?', $organismeId)
						->fetchOne();
		
		if(!$this->organisme) {
			return $this->forward404();
		}
	}
		
	public function executeClicPub(sfWebRequest $request) {
		$params = $request->getParameterHolder();
		$url = $params->get('url');
		$this->messageImage = '/images/icons/48x48/tick.png';
		
		if($this->getUser()->isAuthenticated()) {

			$log = Doctrine_Core::getTable('logPub')
				->getForUrlAndUser($url, $this->getUser()->getGuardUser()->getId());

			if(empty($log)) {
				$log = new logPub();
				$log->setIp($_SERVER['REMOTE_ADDR']);
				$log->setUserId($this->getUser()->getGuardUser()->getId());
				$log->setUrl($url);
				$log->save();
				
				$profil = $this->getUser()->getGuardUser()->getProfile();
				$profil->addCredit(sfConfig::get('app_gain_cpc'));
				$profil->save();
				
				$this->message = 'success';
				$this->messageType = 'flash_notice';
			}
			else {
				$this->message = 'error-log';
				$this->messageType = 'error';
				$this->messageImage = '/images/icons/48x48/warning.png';
			}
			
		}
		else {
			$this->message = 'not-connected';
			$this->messageType = 'flash_notice';
			$this->messageImage = '/images/icons/48x48/warning.png';
		}
  }

  public function executeMoreresults(sfWebRequest $request)
  {
      $params = $request->getParameterHolder();

      $min = $params->get('nb_items_affiche');
      $minPub = $params->get('nb_pub');
      $minAffiliate = $params->get('nb_affiliate');
      $text = $params->get('text_search');
      $moteur = $params->get('moteur_search');
      $engine = new SearchEngine($text, $moteur);

	  $this->pubResults = array();
	  $this->results = array();

	  switch($moteur) {
		  case SearchEngine::SHOP :
			  $this->affiliateResults = $engine->getResults($min);
			  break;
		  case SearchEngine::WEB :
		  case SearchEngine::NEWS :
			  $this->pubResults = $engine->getPubResults(2, $minPub);
		  default :
			  $this->affiliateResults = array();
			  $this->results = $engine->getResults($min);
			  break;
	  }

		if(empty($this->affiliateResults)) {
			$this->affiliateResults = array();
		}
      
  }
}
