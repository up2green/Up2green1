<?php

/**
 * plantation components.
 *
 * @package    up2green
 * @subpackage plantation
 * @author     Clément Gautier
*/
class plantationComponents extends sfComponents {
	public function executeMapLegend(sfWebRequest $request) {
		$this->displayProgrammeActif = $request->getParameter("displayProgrammeActif", 1);
		$this->displayProgrammeInactif = $request->getParameter("displayProgrammeInactif", 1);
		$this->displayOrganismeActif = $request->getParameter("displayOrganismeActif", 0);
		$this->displayOrganismeInactif = $request->getParameter("displayOrganismeInactif", 0);
		$this->displayProgrammePartenaire = $request->getParameter("displayProgrammePartenaire", 0);
	}
}
