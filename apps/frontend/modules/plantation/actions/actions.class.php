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
		
		$this->fromUrl = $request->getParameter('fromUrl', self::$defaultFromUrl);
		$this->redirectUrl = $request->getParameter('redirectUrl', self::$defaultRedirectUrl);
		
		// pour le form partenaire et pour savoir si on affiche la liste des programmes quand le user est connecté
		$this->partenaire = null;
		$this->nbArbresToPlant = 0;
		$this->spendAll = false;
		
		if($this->getUser()->isAuthenticated()) {
			$this->nbArbresToPlant = $this->getUser()->getGuardUser()->getProfile()->getCredit();
		}
								
		// l'utilisateur a entré son numéro de coupon
		if ($request->hasParameter('code')) {
			$code = $request->getParameter('code');
			$coupon = Doctrine_Core::getTable('coupon')->findOneByCode($code);
			if(!$coupon) {
				$this->getUser()->setFlash('error', 'invalid-coupon');
				$this->redirect($this->redirectUrl);
			}
			else {
				if ($coupon->getIsActive()) {
					$this->coupon = $coupon;
					if(!$coupon->getPartenaire()->isNew()) {
						$this->partenaire = $coupon->getPartenaire()->getPartenaire();
						$this->setProgrammesFromPartenaire($this->partenaire);
					}
					$this->spendAll = true;
					$this->nbArbresToPlant = $coupon->getCouponGen()->getCredit();
				}
				else {
					$this->getUser()->setFlash('error', 'coupon-already-user');
					$this->redirect($this->fromUrl);
				}
			}
		}
		
		if($this->getUser()->isAuthenticated() && is_null($this->partenaire)) {
			$user = $this->getUser()->getGuardUser();
			$this->partenaire = ($user->getPartenaire()->getId() != null ? $user->getPartenaire() : null);
		}

	}

	public function executePlant(sfWebRequest $request) {
		
		$this->forward404Unless($request->isMethod('post'));
		$this->forward404Unless($request->hasParameter('confirmPlant'));
		
		$this->fromUrl = $request->getParameter('fromUrl', self::$defaultFromUrl);
		$this->redirectUrl = $request->getParameter('redirectUrl', self::$defaultRedirectUrl);
		$this->partenaire = null;
		
		$email = "";
		$sendMail = true;
		$code = $request->getParameter('code');
		$trees = $request->getParameter('trees');
		$sdf = false;

		if (!empty($code)) {
			// plantation à partir d'un code coupon
			$coupon = Doctrine_Core::getTable('coupon')->findOneBy('code', $code);

			if(!$coupon) {
				$this->getUser()->setFlash('error', 'invalid-coupon');
				$this->redirect($this->redirectUrl);
			}
			elseif(!$coupon->getIsActive()) {
				$this->getUser()->setFlash('error', 'coupon-already-user');
				$this->redirect($this->redirectUrl);
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
			$profil->setCredit($this->getUser()->getGuardUser()->getProfile()->getCredit() - array_sum($trees));
			$profil->save();

			$email = $this->getUser()->getGuardUser()->getEmailAddress();
			$sendMail = (bool)$request->getParameter('send_email');
		}

		$this->getUser()->setFlash('notice', 'plant-succes');
		$username = $this->getUser()->getGuardUser() ? $this->getUser()->getGuardUser()->getDisplayName() : $email;

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
			$html = str_replace('%treeNumber%', array_sum($trees), $html);

			$message->setBody($html, 'text/html');

			if(file_exists($filename)) {
				$message->attach(Swift_Attachment::fromPath($filename));
			}

			$this->getMailer()->send($message);
			$this->getUser()->setFlash('notice', 'email-confirmation');
		}
		
		$this->redirect($this->getUser()->hasFlash('error') ? $this->fromUrl : $this->redirectUrl);
	}
	
	/**
	 * Executes confirm action
	 * @param sfRequest $request A request object
	 */
	public function executeConfirm(sfWebRequest $request) {

		$this->forwardUnless($request->isMethod('post'), 'plantation', 'index');
		$this->forwardUnless($request->hasParameter('submitArbresProgramme'), 'plantation', 'index');
		
		$this->fromUrl = $request->getParameter('fromUrl', self::$defaultFromUrl);
		$this->redirectUrl = $request->getParameter('redirectUrl', self::$defaultRedirectUrl);
		
		$code = $request->getParameter('code');
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
		$pdf->Cell(0,10,__('certifie que'),0,1,'C');
		
		$pdf->SetTextColor(73,115,16);
		$pdf->SetFontSize(16);
		$pdf->Cell(0,7,$username,0,1,'C');
		$pdf->SetFontSize(12);
		$pdf->SetTextColor(0);
		$pdf->Cell(0, 5, '', 0, 1); // saut de ligne
		
		$pdf->Cell(0,5,format_number_choice(
			"(-Inf,1]a financé la plantation d'un arbre|(1,+Inf]a financé la plantation de {number} arbres",
			array('{number}' => $nbTotal),
			$nbTotal
		),0,1,'C');
		
		foreach($trees as $key => $value) {
			$programme = Doctrine_Core::getTable('programme')->findOneBy('id', $key);
			$programmes[] = $programme->getTitle();
		}
		
		$pdf->Cell(0,5,format_number_choice(
			"(-Inf,1]dans le programme de reforestation suivant :|(1,+Inf]dans les programmes de reforestation suivants :",
			array(),
			sizeof($programmes)
		),0,1,'C');
		
		
		$current_y_position = $pdf->getY();
		$pdf->SetTextColor(73,115,16);
		$pdf->SetFontSize(13);
		$pdf->writeHTMLCell(130, 0, 15, $current_y_position, join(', ', $programmes),0,1,false, true, 'C');
		$pdf->SetFontSize(12);
		$pdf->SetTextColor(0);
		
		$str = __("À {city}, le {date}", array(
				"{city}" => "Paris",
				"{date}" => format_date(time()),
		));
		
		$pdf->writeHTMLCell(0, 0, 15, 85, '<b><font size="-4">'.$str.'</font></b>', 0, 1, false, true, 'L');
		
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
		$pdf = new attestationPDF(sfConfig::get('sf_web_dir').'/images/pdf/attestation_empty_sdf.png');
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
						->select('p.id, t.title');
		
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
