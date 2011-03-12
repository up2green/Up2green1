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
	
	public function executePlantation(sfWebRequest $request)
	{		
		$partenaireOffset = $request->getParameter('partenaireOffset');
		$this->operation = $request->getParameter('operation');
		$this->partenaire = null;
		
		if(!empty($partenaireOffset)) {
			$user = Doctrine_Core::getTable('sfGuardUser')->findOneBy('username', $partenaireOffset);
			
			if(!empty($user)) {
				$this->partenaire = $user->getPartenaire();
				$this->nbArbres = 0;
				
				if(!empty($this->partenaire)) {
					// comptage des arbres planté par l'utilisateur partenaire directement
					$this->nbArbres = Doctrine_Core::getTable('tree')
						->createQuery('t')
						->select('COUNT(id)')
						->innerJoin('t.User tu')
						->where('tu.user_id = ?', $user->getId())
						->count();
					// comptage des arbres planté par les coupons du partenaire
					$this->nbArbres += Doctrine_Core::getTable('coupon')
						->createQuery('c')
						->select('COUNT(id)')
						->innerJoin('c.Partenaire cp')
						->where('cp.partenaire_id = ?', $this->partenaire->getId())
						->andWhere('c.is_active = ?', 0)
						->count();
				}
			}
		}
	}

	public function executeMap(sfWebRequest $request)
	{
		$partenaireOffset = $request->getParameter('partenaireOffset');
		$this->operation = $request->getParameter('operation');
		$this->partenaire = null;

		if(!empty($partenaireOffset)) {
			$user = Doctrine_Core::getTable('sfGuardUser')->findOneBy('username', $partenaireOffset);

			if(!empty($user)) {
				$this->partenaire = $user->getPartenaire();
				$this->nbArbres = 0;

				if(!empty($this->partenaire)) {
					// comptage des arbres planté par l'utilisateur partenaire directement
					$this->nbArbres = Doctrine_Core::getTable('tree')
						->createQuery('t')
						->select('COUNT(id)')
						->innerJoin('t.User tu')
						->where('tu.user_id = ?', $user->getId())
						->count();
					// comptage des arbres planté par les coupons du partenaire
					$this->nbArbres += Doctrine_Core::getTable('coupon')
						->createQuery('c')
						->select('COUNT(id)')
						->innerJoin('c.Partenaire cp')
						->where('cp.partenaire_id = ?', $this->partenaire->getId())
						->andWhere('c.is_active = ?', 0)
						->count();
				}
			}

			$partenaireProgrammes = $this->partenaire->getProgrammes();
			$programmes = array();
			foreach($partenaireProgrammes as $partenaireProgramme) {
				$programmes[] = $partenaireProgramme->getProgramme();
			}
			$this->programmes = $programmes;

		}
		else {
			$this->programmes = Doctrine_Core::getTable('programme')->getActive();
		}

		$this->gMap = new myGMap(
			$this->programmes,
			$this->partenaire
		);

		$this->gMapModes = $this->gMap->getGmapModeSelector(array(
			'displayAll' => is_null($this->partenaire)
		));
	}
	
}
