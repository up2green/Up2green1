<?php

/**
 * landing actions.
 *
 * @package    up2green
 * @subpackage landing
 * @author     Clément Gautier
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class landingActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$this->forward404();
	}

	public function execute404(sfWebRequest $request)
	{
		$this->forward404();
	}

	public function executePartenaire(sfWebRequest $request)
	{
		$this->operation = $request->getParameter('operation');
    $this->forward404Unless($this->operation);
    
		$partenaireSlug = $request->getParameter('partenaire');
    $this->forward404Unless($partenaireSlug);
    $user = Doctrine_Core::getTable('sfGuardUser')->findOneBy('username', $partenaireSlug);
		$this->forward404Unless($user);
    $this->partenaire = $user->getPartenaire();
    $this->forward404Unless($this->partenaire);
    
    $this->nbArbres = Doctrine_Core::getTable('treeUser')->countByUser($user->getId());
    $this->nbArbres += Doctrine_Core::getTable('tree')->countFromCouponPartenaire($this->partenaire->getId());
    
    return ucfirst($partenaireSlug).ucfirst($this->operation).'Success';
	}
	
	public function executePagePartenaire(sfWebRequest $request)
	{
		$this->operation = $request->getParameter('operation');
		$this->partenaire = null;
		
		$user = Doctrine_Core::getTable('sfGuardUser')->findOneBy('username', $request->getParameter('partenaire'));
		$this->forward404Unless($user);
		$this->partenaire = $user->getPartenaire();
		$this->forward404If($this->partenaire->isNew());
		$this->forward404Unless($this->partenaire->getPage());
	}
	
	public function executePlantation(sfWebRequest $request)
	{
		$partenaireSlug = $request->getParameter('partenaire');
		$this->operation = $request->getParameter('operation');
		$this->partenaire = null;
		
		if(!empty($partenaireSlug)) {
			$user = Doctrine_Core::getTable('sfGuardUser')->findOneBy('username', $partenaireSlug);
			
			if(!empty($user)) {
				$this->partenaire = $user->getPartenaire();
                $this->nbArbres = Doctrine_Core::getTable('treeUser')->countByUser($user->getId());
				
				if(!empty($this->partenaire)) {
                    $this->nbArbres += Doctrine_Core::getTable('tree')->countFromCouponPartenaire($this->partenaire->getId());
				}
			}
		}
	}

	public function executeMap(sfWebRequest $request)
	{
		$partenaireSlug = $request->getParameter('partenaire');
		$this->operation = $request->getParameter('operation');
		$this->partenaire = null;

		if(!empty($partenaireSlug)) {
			$user = Doctrine_Core::getTable('sfGuardUser')->findOneBy('username', $partenaireSlug);

			if(!empty($user)) {
				$this->partenaire = $user->getPartenaire();
                $this->nbArbres = Doctrine_Core::getTable('treeUser')->countByUser($user->getId());
				
				if(!empty($this->partenaire)) {
                    $this->nbArbres += Doctrine_Core::getTable('tree')->countFromCouponPartenaire($this->partenaire->getId());
				}

                $partenaireProgrammes = $this->partenaire->getProgrammes();
                
                $programmes = array();
                foreach($partenaireProgrammes as $partenaireProgramme) {
                    $programmes[] = $partenaireProgramme->getProgramme();
                }
                $this->programmes = $programmes;
            }
		}
		else {
			$this->programmes = Doctrine_Core::getTable('programme')->getActive();
		}
    
	}
	
}
