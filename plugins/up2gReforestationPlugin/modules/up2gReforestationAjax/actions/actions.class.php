<?php

/**
 * Reforestation ajax actions.
 *
 * @package    up2gReforestationPlugin
 * @subpackage Ajax
 * @author     Clément Gautier
 */
class up2gReforestationAjaxActions extends sfActions
{

  /**
   * @param sfWebRequest $request
   */
  public function executeKml(sfWebRequest $request)
  {
    $this->displayOrganismeActif = $request->getParameter('displayOrganismeActif', false);
    $this->displayOrganismeInactif = $request->getParameter('displayOrganismeInactif', false);
    $this->displayProgrammeActif = $request->getParameter('displayProgrammeActif', true);
    $this->displayProgrammeInactif = $request->getParameter('displayProgrammeInactif', true);

    $partenaireId = $request->getParameter('partenaire', 0);
    $this->partenaire = Doctrine_Core::getTable('partenaire')->findOneById($partenaireId);

    // Organismes
    $this->organismes = null;
    if ($this->displayOrganismeActif && $this->displayOrganismeInactif)
    {
      $this->organismes = Doctrine_Core::getTable('organisme')->get();
    } else if ($this->displayOrganismeActif)
    {
      $this->organismes = Doctrine_Core::getTable('organisme')->getActive();
    } else if ($this->displayOrganismeInactif)
    {
      $this->organismes = Doctrine_Core::getTable('organisme')->getInactive();
    }

    // Programmes
    $this->programmes = null;
    $query = null;
    if ($this->displayProgrammeActif && $this->displayProgrammeInactif)
    {
      $query = Doctrine_Core::getTable('programme')->addQuery();
    } else if ($this->displayProgrammeActif)
    {
      $query = Doctrine_Core::getTable('programme')->addActiveQuery();
    } else if ($this->displayProgrammeInactif)
    {
      $query = Doctrine_Core::getTable('programme')->addInactiveQuery();
    }

    // Programmes Partenaire
    $this->displayProgrammePartenaire = $request->getParameter('displayProgrammePartenaire', ($this->partenaire ? true : false));
    $this->programmePartenaireId = array();
    if ($this->partenaire && $this->displayProgrammePartenaire)
    {
      foreach ($this->partenaire->getProgrammes() as $partenaireProgramme) {
        $this->programmePartenaireId[] = $partenaireProgramme->getProgrammeId();
      }
      if (null === $query)
      {
        $query = Doctrine_Core::getTable('programme')->addQuery();
        $query->where('p.id IN (' . implode($this->programmePartenaireId, ', ') . ')');
      } else
      {
        $query->orWhereIn($this->programmePartenaireId);
      }
    }

    if (null !== $query)
    {
      $this->programmes = Doctrine_Core::getTable('programme')->get($query);
    }
  }

  /**
   * @param sfWebRequest $request
   */
  public function executeProgramme(sfWebRequest $request)
  {
    $programmeId  = $request->getParameter('programme', 0);
    $partenaireId = $request->getParameter('partenaire', 0);

    $this->partenaire = Doctrine_Core::getTable('partenaire')->findOneById($partenaireId);
    $this->programme = Doctrine_Core::getTable('programme')->findOneById($programmeId);
    $this->canPlant = $request->getParameter('canPlant', 0);
    $this->userProgrammeTrees = 0;

    $this->forward404Unless($this->programme);

    // on inactives le programme s'il n'est pas soutenu par le partenaire
    if ($this->partenaire)
    {
      $partenaireProgrammes = $this->partenaire->getProgrammes()->getPrimaryKeys();
      if (!in_array($this->programme->getId(), $partenaireProgrammes))
      {
        $this->programme->setIsActive(false);
      }
    }

    if ($this->getUser()->isAuthenticated())
    {
      $this->userProgrammeTrees = Doctrine_Core::getTable('tree')->countByUserAndProgramme($this->getUser()->getGuardUser()->getId(), array($programmeId));
    }

    // comptage des arbres planté sur le programme :
    $this->max = 0;
    $this->programmeTrees = 0;
    $this->showPerPartenaire = false;
    if ($this->partenaire)
    {
      $partenaireProgramme = Doctrine_Core::getTable('partenaireProgramme')->findOneByPartenaireIdAndProgrammeId($this->partenaire->getId(), $this->programme->getId());
      $this->max = (int) $partenaireProgramme->getNumber();
      $this->programmeTrees = (int) $partenaireProgramme->getHardcode();
      $this->programmeTrees += (int) Doctrine_Core::getTable('tree')->countFromCouponPartenaireByProgramme($this->partenaire->getId(), $this->programme->getId());
      $this->showPerPartenaire = true;
    }

    if (empty($this->max))
    {
      $this->showPerPartenaire = false;
      $this->programmeTrees = Doctrine_Core::getTable('tree')->countByProgramme($programmeId);
      $this->max = $this->programme->getMaxTree();
    }

    if (empty($this->max))
      $this->max = 1;

    $this->displayPourcent = floor($this->programmeTrees * 100 / $this->max);

    if (empty($this->displayPourcent))
      $this->displayPourcent = 1;
  }

  /**
   * @param sfWebRequest $request
   */
  public function executeOrganisme(sfWebRequest $request)
  {
    $organismeId = $request->getParameter('organisme', 0);
    $this->organisme = Doctrine_Core::getTable('organisme')
      ->addLangQuery($this->getUser()->getCulture())
      ->addWhere('id = ?', $organismeId)
      ->fetchOne();

    if (!$this->organisme)
    {
      return $this->forward404();
    }
  }
}
