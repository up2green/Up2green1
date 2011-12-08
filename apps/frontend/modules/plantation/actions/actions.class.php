<?php

/**
 * plantation actions.
 *
 * @package    up2green
 * @subpackage plantation
 * @author     Clément Gautier
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class plantationActions extends sfActions {
	
	private static $defaultFromUrl = 'plantation/index';
	private static $defaultRedirectUrl = 'plantation/index';
	
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request) {
		// chargement des variables pour le form programmes
		$this->programmes = Doctrine_Core::getTable('programme')->getActive();
		
		$session = $this->getUser()->getPlantSession(array(
				'fromUrl'	=> self::$defaultFromUrl,
				'redirectUrl'	=> self::$defaultRedirectUrl,
		));

		if ($request->hasParameter('code'))
		{
			$session['code'] = $request->getParameter('code');
		}
		if ($request->hasParameter('fromUrl'))
		{
			$session['fromUrl'] = $request->getParameter('fromUrl');
		}
		if ($request->hasParameter('redirectUrl'))
		{
			$session['redirectUrl'] = $request->getParameter('redirectUrl');
		}
	
		$this->fromUrl = $session['fromUrl'];
		$this->redirectUrl = $session['redirectUrl'];
		
		// pour le form partenaire et pour savoir si on affiche la liste des programmes quand le user est connecté
		$this->partenaire = null;
		$this->nbArbresToPlant = 0;
		$this->spendAll = false;
		
		if($this->getUser()->isAuthenticated()) {
			$this->nbArbresToPlant = $this->getUser()->getGuardUser()->getProfile()->getCredit();
		}
	
		if($request->getParameter("cancelPlant"))
		{
			$this->getUser()->removePlantSession();
			$this->redirect($this->fromUrl);
		}

		// l'utilisateur a entré son numéro de coupon
		if ($code = (isset($session['code']) ? $session['code'] : null)) {
			$coupon = Doctrine_Core::getTable('coupon')->findOneByCode($code);
			if(!$coupon) {
				$this->getUser()->setFlash('error', 'invalid-coupon');
				$this->getUser()->removePlantSession();
				$this->redirect($this->fromUrl);
			}
			else if($coupon->isPerime()) {
				$this->getUser()->setFlash('error', 'coupon-perime');
				$this->getUser()->removePlantSession();
				$this->redirect($this->fromUrl);
			}
			else {
				if ($coupon->getIsActive()) {
					$this->coupon = $coupon;
					$this->getUser()->setPlantSession($session);
					if(!$coupon->getPartenaire()->isNew()) {
						$this->partenaire = $coupon->getPartenaire()->getPartenaire();
						$this->setProgrammesFromPartenaire($this->partenaire);
					}
					$this->spendAll = true;
					$this->nbArbresToPlant = $coupon->getCouponGen()->getCredit();
				}
				else {
					$this->getUser()->setFlash('error', 'coupon-already-user');
					$this->getUser()->removePlantSession();
					$this->redirect($this->fromUrl);
				}
			}
		}
		
		if($this->getUser()->isAuthenticated() && is_null($this->partenaire)) {
			$user = $this->getUser()->getGuardUser();
			$this->partenaire = ($user->getPartenaire()->getId() != null ? $user->getPartenaire() : null);
		}

		if ($this->partenaire) {
			$request->setParameter('partenaire', $this->partenaire->getUser()->getUsername());
		}

	}

	public function executePlant(sfWebRequest $request) {
		
		$this->forward404Unless($request->isMethod('post'));
		$this->forward404Unless($request->hasParameter('confirmPlant'));

		sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
	
		$session = $this->getUser()->getPlantSession(array(
			'fromUrl'	=> self::$defaultFromUrl,
			'redirectUrl'	=> self::$defaultRedirectUrl,
			'code'		=> $request->getParameter('code'),
			'trees'		=> $request->getParameter('trees'),
		));

		if ($request->hasParameter('trees'))
		{
			$session['trees'] = $request['trees'];
		}

		if ($request->hasParameter('code'))
		{
			$session['code'] = $request['code'];
		}
	
		$this->fromUrl = $session['fromUrl'];
		$this->redirectUrl = $session['redirectUrl'];
		$this->partenaire = null;
		$email = "";
		$sendMail = true;
		$code = $session['code'];
		$trees = $session['trees'];
		$sdf = false;

		if (!empty($code)) {
			// plantation à partir d'un code coupon
			$coupon = Doctrine_Core::getTable('coupon')->findOneBy('code', $code);

			if(!$coupon) {
				$this->getUser()->setFlash('error', 'invalid-coupon');
				$this->getUser()->removePlantSession();
				$this->redirect($this->fromUrl);
			}
			else if($coupon->isPerime()) {
				$this->getUser()->setFlash('error', 'coupon-perime');
				$this->getUser()->removePlantSession();
				$this->redirect($this->fromUrl);
			}
			elseif(!$coupon->getIsActive()) {
				$this->getUser()->setFlash('error', 'coupon-already-user');
				$this->getUser()->removePlantSession();
				$this->redirect($this->fromUrl);
			}
			elseif(array_sum($trees) !== (int)$coupon->getCouponGen()->getCredit()){
				$this->getUser()->setFlash('error', 'error-plant-all');
				return $this->forward('plantation', 'index');
			}
			
			foreach ($trees as $programme => $nombre){
				$coupon->plantArbre((int)$nombre, $programme, $this->getUser());
			}
			
			if(!$coupon->getPartenaire()->isNew()) {
				$this->partenaire = $coupon->getPartenaire()->getPartenaire();
			}

			$coupon->setUsedAt(date('c'));
			$coupon->setIsActive(false);
			$coupon->setPartenaire(null);
			$coupon->save();
			$this->getUser()->removePlantSession();
			
			if(!$this->getUser()->isAuthenticated()) {
				$email = $request->getParameter('email_user');
				$coupon->logUser($email);
			}
			else {
				$email = $this->getUser()->getGuardUser()->getEmailAddress();
			}
			
		}
		else if(!$this->getUser()->isAuthenticated()) {
			$this->getUser()->setFlash('error', 'error-deco');
			$this->redirect($this->fromUrl);
		}
		elseif(array_sum($trees) > floor((int)$this->getUser()->getGuardUser()->getProfile()->getCredit())){
			$this->getUser()->setFlash('error', 'not-enough-credit');
			$this->redirect($this->fromUrl);
		}
		else {
			foreach ($trees as $programme => $nombre){
				Doctrine_Core::getTable('treeUser')->plantArbre($nombre, $programme, $this->getUser());
			}

			$profil = $this->getUser()->getGuardUser()->getProfile();
			$profil->setCredit($profil->getCredit() - array_sum($trees));
			$profil->save();
			$this->getUser()->removePlantSession();
			$email = $this->getUser()->getGuardUser()->getEmailAddress();
			$sendMail = (bool)$request->getParameter('send_email');
		}

		$this->getUser()->setFlash('notice', 'plant-succes');
		
		$username = $request->getParameter('prenom_user');
		$name = $request->getParameter('nom_user');
		$username .= empty ($name) ? '' : ' '.$name;

		if (empty ($username))
		{
			$username = $this->getUser()->getGuardUser() ? $this->getUser()->getGuardUser()->getDisplayName() : $email;
		}

		if($sendMail && !empty($email)) {
			// on construit l'attestation :
			sfProjectConfiguration::getActive()->loadHelpers(array('I18N', 'Date'));
			sfTCPDFPluginConfigHandler::loadConfig('my_config');
			if(!is_null($this->partenaire) && $this->partenaire->getId() == sfConfig::get('app_sdf_id')) {
				$filename = $this->buildAttestationSdF($username, $trees);
				$newsletter = Doctrine_Core::getTable('newsletter')->getBySlug('attestation-de-plantation-sdf');
			}
			else {
				$filename = $this->buildAttestation($username, $trees, $this->partenaire);
				$newsletter = Doctrine_Core::getTable('newsletter')->getBySlug('attestation-de-plantation');
			}
			
			$message = $this->getMailer()->compose(
				array($newsletter->getEmailFrom() => 'Up2Green'),
				$email,
				$newsletter->getTitle()
			);

			$html = $newsletter->getContent();
			$html = str_replace('treeNumber', array_sum($trees), $html);
			
			$message->setBody($html, 'text/html');

			if(file_exists($filename)) {
				$message->attach(Swift_Attachment::fromPath($filename));
			}

			try
			{
				$this->getMailer()->send($message);
				$this->getUser()->setFlash('notice', 'email-confirmation');
			}
			catch(Exception $e)
			{
				$this->getUser()->setFlash('error', __("Une erreur est survenue lors de l'envoi du mail d'attestation."));
			}
		}
		
		$this->redirect($this->fromUrl);
	}
	
	/**
	 * Executes confirm action
	 * @param sfRequest $request A request object
	 */
	public function executeConfirm(sfWebRequest $request) {

		$this->forwardUnless($request->isMethod('post'), 'plantation', 'index');
		$this->forwardUnless($request->hasParameter('submitArbresProgramme'), 'plantation', 'index');
	
		$session = $this->getUser()->getPlantSession(array(
			'fromUrl'	=> self::$defaultFromUrl,
			'redirectUrl'	=> self::$defaultRedirectUrl,
		));

		$this->fromUrl = $session['fromUrl'];
		$this->redirectUrl = $session['redirectUrl'];
        
		$code = isset($session['code']) ? $session['code'] : null;

		$this->programmes = Doctrine_Core::getTable('programme')->getActive();
		$this->coupon = null;
		$this->partenaire = null;
		$this->isThePartenaire = null;
		$this->trees = array();

		if (!empty($code)) {
			// plantation à partir d'un code coupon
			$this->coupon = Doctrine_Core::getTable('coupon')->findOneByCode($code);
			if(!$this->coupon) {
				$this->getUser()->setFlash('error', 'invalid-coupon');
				$this->redirect($this->fromUrl);
			}
			else if($this->coupon->isPerime()) {
				$this->getUser()->setFlash('error', 'coupon-perime');
				$this->redirect($this->redirectUrl);
			}
			elseif(!$this->coupon->getIsActive()) {
				$this->getUser()->setFlash('error', 'coupon-already-user');
				$this->redirect($this->fromUrl);
			}

			if(!$this->coupon->getPartenaire()->getPartenaire()->isNew()){
				$this->partenaire = $this->coupon->getPartenaire()->getPartenaire();
				if($this->getUser()->isAuthenticated() && $this->getUser()->getGuardUser()->getPartenaire()->getId() === $this->partenaire->getId()) {
					$this->isThePartenaire = true;
				}
				$this->setProgrammesFromPartenaire($this->partenaire);
			}
			
			$total = 0;
			foreach ($this->programmes as $programme){
				if ($request->getParameter('nbArbresProgrammeHidden_'.$programme->getId()) > 0){
					$nombre = $request->getParameter('nbArbresProgrammeHidden_'.$programme->getId());
					$this->trees[] = array(
						'programmeTitle' => $programme->getTitle(),
						'programmeId' => $programme->getId(),
						'nombre' => $nombre
					);
					$total += $nombre;
				}
			}
			
			if((int)$total !== (int)$this->coupon->getCouponGen()->getCredit()) {
				$this->getUser()->setFlash('error', 'error-plant-all');
				$this->forward('plantation', 'index');
			}
		}
		else {
			if(!$this->getUser()->isAuthenticated()) {
				$this->getUser()->setFlash('error', 'error-deco');
				$this->redirect($this->fromUrl);
			}

			if($this->getUser()->getGuardUser()->getPartenaire()->getId()) {
				$this->partenaire = $this->getUser()->getGuardUser()->getPartenaire();
				$this->isThePartenaire = true;
			}
			
			$this->programmes = Doctrine_Core::getTable('programme')->getActive();
			$this->email = $this->getUser()->getGuardUser()->getEmailAddress();

			$total = 0;
			$credit = floor((int)$this->getUser()->getGuardUser()->getProfile()->getCredit());
			
			foreach ($this->programmes as $programme){
				if ($request->getParameter('nbArbresProgrammeHidden_'.$programme->getId()) > 0){
					$nombre = $request->getParameter('nbArbresProgrammeHidden_'.$programme->getId());
					$this->trees[] = array(
						'programmeTitle' => $programme->getTitle(),
						'programmeId' => $programme->getId(),
						'nombre' => $nombre
					);
					$total += $nombre;
				}
			}
			
			if($total > $credit) {
				$this->getUser()->setFlash('error', 'not-enough-credit');
				$this->redirect($this->fromUrl);
			}
		}

	}
	/*
	 * Construit l'attestation pdf dans le dossier temporaire
	 * @return: (string) nom du fichier physique
	 */
	public function buildAttestation($username, $trees, $partenaire = null) {
		
		if(!is_null($partenaire) && $partenaire->getAttestation()) {
			$pdf = new attestationPDF(sfConfig::get('sf_upload_dir').'/partenaire/'.$partenaire->getAttestation());
		}
		else {
			$pdf = new attestationPDF();
		}
		
		$pdf->init();
		
		$nbTotal = array_sum($trees);
		
		//body
		$pdf->SetTextColor(73,115,16);
		$pdf->SetFontSize(21);
		$pdf->writeHTMLCell(130,10, 15, 115, $username,0,1, false, true, 'C');
		
		$pdf->SetFontSize(20);
		$pdf->writeHTMLCell(40, 10, 105, 135, $nbTotal, 0, 1, false, true, 'C'); // saut de ligne
		
		foreach($trees as $key => $value) {
			$programme = Doctrine_Core::getTable('programme')->findOneBy('id', $key);
			$programmes[] = $programme->getTitle();
		}
		
		$pdf->SetFontSize(18);
		$pdf->writeHTMLCell(130, 30, 15, 158, join(', ', $programmes),0,1,false, true, 'C');
		
		$pdf->SetFontSize(16);
		$pdf->SetTextColor(255, 255, 255);
		$str = __("À {city}, le {date}", array(
			"{city}" => "Paris",
			"{date}" => format_date(time()),
		));
		$pdf->writeHTMLCell(60, 0, 165, 155, '<b><font size="-4">'.$str.'</font></b>', 0, 1, false, true, 'R');
		
		// output
		$filename = '/tmp/attestation-'.uniqid().'.pdf';
		$pdf->Output($filename , 'F');
		
		return $filename;
	}
	
	/*
	 * Construit l'attestation pdf dans le dossier temporaire pour le partenaire SdF
	 * @return: (string) nom du fichier physique
	 */
	public function buildAttestationSdF($username, $trees) {
		$pdf = new attestationPDF(sfConfig::get('sf_web_dir').'/images/pdf/attestation_empty_sdf.png', 'L', 'mm', 'C6');
		$pdf->init();

		//body
		$police = strlen($username) > 30 ? 12 : 14;
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('Times','BI', $police);
		$pdf->writeHTMLCell(0, 0, 20, 66, $username,0,0,false, true, 'L');
		
		$programme = Doctrine_Core::getTable('programme')->findOneBy('id', key($trees));
		
		$pdf->SetTextColor(255,255,255);
		$pdf->SetFont('Times','B', 9);
		$pdf->writeHTMLCell(0, 0, 53, 77, $programme->getTitle(),0,0,false, true, 'L');

		$pdf->SetFont('Times','B', 9);
		$pdf->SetTextColor(255,255,255);
		
		$str = __("À {city}, le {date}", array(
				"{city}" => "Paris",
				"{date}" => format_date(time()),
		));
		
		$pdf->writeHTMLCell(0, 0, 95, 89, '<b><font size="-4">'.$str.'</font></b>', 0, 0, false, true, 'L');
		$pdf->SetTextColor(0);

		// output
		$filename = '/tmp/attestation-'.uniqid().'.pdf';
		$pdf->Output($filename , 'F');
		
		return $filename;
	}

	public function setProgrammesFromPartenaire($partenaire) {
		if(!is_null($partenaire)) {
			$partenaireProgrammes = $partenaire->getProgrammes();
			$programmes = array();
			foreach($partenaireProgrammes as $partenaireProgramme) {
				$programmes[] = $partenaireProgramme->getProgramme();
			}
			$this->programmes = $programmes;
		}
	}
	
	public function executeCouponsCSV(sfWebRequest $request){
		if (!$this->getUser()->isAuthenticated()) {
			$this->forward404();
			return;
		}
		
		$this->format = $request->getParameter('format', 'csv');
		
		$user = $this->getUser()->getGuardUser();
		$partenaire = ($user->getPartenaire()->getId() != null ? $user->getPartenaire() : null);
		
		if(!is_null($partenaire)) {
			$query = Doctrine::getTable('coupon')->getByPartenaireQuery($partenaire->getId());
		} else {
			$query = Doctrine::getTable('coupon')->getByUserQuery($user->getId());
		}
		
		$this->couponGens = Doctrine::getTable('couponGen')->getArrayById();
		
		$queryProgrammes = Doctrine::getTable('programme')
						->addLangQuery($this->getUser()->getCulture())
						->select('p.id, pt.title');
		
		$this->programmes = Doctrine::getTable('programme')->getArrayById($queryProgrammes);
		
		$this->coupons = $query->select('c.gen_id, c.code, c.is_active, c.used_at')->fetchArray();
		
		$couponIds = array();
		foreach($this->coupons as $coupon) {
			$couponIds[] = $coupon['id'];
		}
		
		$trees = Doctrine::getTable('tree')->addQuery()
						->select('id, programme_id, tc.coupon_id')
						->innerJoin('t.Coupon tc')
						->whereIn('tc.coupon_id', $couponIds)
						->fetchArray();
		
		$this->couponProgrammes = array();
		foreach($trees as $tree) {
			if(isset($this->couponProgrammes[$tree['Coupon']['coupon_id']][$tree['programme_id']])) {
				$this->couponProgrammes[$tree['Coupon']['coupon_id']][$tree['programme_id']]++;
			}
			else {
				$this->couponProgrammes[$tree['Coupon']['coupon_id']][$tree['programme_id']] = 1;
			}
		}
		
		$this->setLayout(false);
	}

}
