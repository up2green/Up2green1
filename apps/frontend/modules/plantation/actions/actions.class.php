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
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request) {
		// chargement des variables pour le form programmes
		$this->programmes = Doctrine_Core::getTable('programme')->getActive();
		
		$this->fromUrl = '';
		$this->redirectUrl = '';
		
		// pour le form partenaire et pour savoir si on affiche la liste des programmes quand le user est connecté
		$this->partenaire = null;
		$this->nbArbresToPlant = 0;
		$this->spendAll = false;
		
		if ($request->isMethod('post')) {

			$this->fromUrl = $request->getParameter('fromUrl');
			$this->redirectUrl = $request->getParameter('redirectUrl');
			
			if(empty($this->fromUrl)) {
				$this->fromUrl = sfConfig::get('app_url_moteur');
			}
			
			// l'utilisateur a entré son numéro de coupon
			if ($request->getParameter('numCouponToUse')) {
				if ($coupon = Doctrine_Core::getTable('coupon')->findOneBy('code', $request->getParameter('code'))) {
					if ($coupon->getIsActive()) {
						$this->coupon = $coupon;
						if(is_null($this->partenaire)) {
							$this->partenaire = $coupon->getPartenaire()->getPartenaire();
						}
						$this->setProgrammesFromPartenaire($this->partenaire);
						$this->spendAll = true;
						$this->nbArbresToPlant = $coupon->getCouponGen()->getCredit();
					}
					else {
						$this->coupon = null;
						$this->getUser()->setFlash('error', 'coupon-already-user');
					}
				}
			}
		}
		
		if($this->getUser()->isAuthenticated() && is_null($this->partenaire)) {
			$user = $this->getUser()->getGuardUser();
			$this->partenaire = ($user->getPartenaire()->getId() != null ? $user->getPartenaire() : null);
		}

		if(is_null($this->coupon) && !empty($this->fromUrl)) {
			return $this->redirect($this->fromUrl);
		}

		$this->gMap = new myGMap(
			$this->programmes,
			$this->partenaire,
			$this->getUser(),
			array(
				'canPlant' => isset($this->nbArbresToPlant) && !empty($this->nbArbresToPlant)
			)
		);
		
		$this->gMapModes = $this->gMap->getGmapModeSelector();

	}

	public function executePlant(sfWebRequest $request) {
		if (!$request->isMethod('post') || !$request->getParameter('confirmPlant')) {
			return $this->forward404();
		}

		$email = "";
		$sendMail = true;
		$code = $request->getParameter('coupon');
		$trees = $request->getParameter('trees');
		$fromUrl = $request->getParameter('fromUrl');
		$redirectUrl = $request->getParameter('redirectUrl');
		$sdf = false;

		if(empty($redirectUrl)) {
			$redirectUrl = 'plantation/index';
		}

		if(empty($fromUrl)) {
			$fromUrl = 'plantation/index';
		}
		
		if (!empty($code)) {
			// plantation à partir d'un code coupon
			$coupon = Doctrine_Core::getTable('coupon')->findOneBy('code', $code);

			if(empty($coupon)) {
				$this->getUser()->setFlash('error', 'invalid-coupon');
				return $this->redirect('plantation/index');
			}
			elseif(!$coupon->getIsActive()) {
				$this->getUser()->setFlash('error', 'coupon-already-user');
				return $this->redirect('plantation/index');
			}
			elseif(array_sum($trees) !== ($credit = (int)$coupon->getCouponGen()->getCredit())){
				$this->getUser()->setFlash('error', 'error-plant-all');
				return $this->forward('plantation', 'index');
			}
			
			foreach ($trees as $programme => $nombre){
				$coupon->plantArbre((int)$nombre, $programme, $this->getUser());
			}

			$email = $request->getParameter('email_user');
			$prenom = $request->getParameter('prenom_user');
			$nom = $request->getParameter('nom_user');
			$sdf = ($coupon->getPartenaire()->getPartenaire()->getTitle() === 'STORISTES DE FRANCE');

			$coupon->setUsedAt(date('c'));
			$coupon->setIsActive(false);
			$coupon->save();
			
			$coupon->logUser($email);
		}
		else if(!$this->getUser()->isAuthenticated()) {
			$this->getUser()->setFlash('error', 'error-deco');
			return $this->redirect('plantation/index');
		}
		elseif(array_sum($trees) > $credit = floor((int)$this->getUser()->getGuardUser()->getProfile()->getCredit())){
			$this->getUser()->setFlash('error', 'not-enough-credit');
			return $this->redirect('plantation', 'index');
		}
		else {
			foreach ($trees as $programme => $nombre){
				Doctrine_Core::getTable('treeUser')->plantArbre($nombre, $programme, $this->getUser());
			}

			$profil = $this->getUser()->getGuardUser()->getProfile();
			$profil->setCredit($credit - array_sum($trees));
			$profil->save();

			$email = $this->getUser()->getGuardUser()->getEmailAddress();
			$prenom = $this->getUser()->getGuardUser()->getFirstName();
			$nom = $this->getUser()->getGuardUser()->getLastName();
			$sendMail = (bool)$request->getParameter('send_email');
		}

		$this->getUser()->setFlash('notice', 'plant-succes');

		if($sendMail && !empty($email)) {
			// on construit l'attestation :
			if($sdf) {
				$filename = $this->buildAttestationSdF($email, $trees, $prenom, $nom);
				$newsletter = Doctrine_Core::getTable('newsletter')->getBySlug('attestation-de-plantation-sdf');
			}
			else {
				$filename = $this->buildAttestation($email, $trees, $prenom, $nom);
				$newsletter = Doctrine_Core::getTable('newsletter')->getBySlug('attestation-de-plantation');
			}
			
			$message = $this->getMailer()->compose(
				array($newsletter->getEmailFrom() => 'Up2Green'),
				$email,
				$newsletter->getTitle()
			);

			$html = $newsletter->getContent();
			$html = str_replace('%treeNumber%', $credit, $html);

			$message->setBody($html, 'text/html');

			if(file_exists($filename)) {
				$message->attach(
					Swift_Attachment::fromPath($filename)
				);
			}

			$this->getMailer()->send($message);
			$this->getUser()->setFlash('notice', 'email-confirmation');
		}
		
		return $this->redirect($this->getUser()->hasFlash('error') ? $fromUrl : $redirectUrl);
	}
	
	/**
	 * Executes confirm action
	 * @param sfRequest $request A request object
	 */
	public function executeConfirm(sfWebRequest $request) {

		if (!$request->isMethod('post') || !$request->getParameter('submitArbresProgramme')) {
			return $this->forward404();
		}

		$code = $request->getParameter('plantCouponCode');
		$this->programmes = array();
		$this->partenaire = null;
		$this->trees = array();
		$this->fromUrl = $request->getParameter('fromUrl');
		$this->redirectUrl = $request->getParameter('redirectUrl');

		if (!empty($code)) {
			// plantation à partir d'un code coupon
			$this->coupon = Doctrine_Core::getTable('coupon')->findOneBy('code', $code);
			if(empty($this->coupon)) {
				$this->getUser()->setFlash('error', 'invalid-coupon');
				return $this->redirect('plantation/index');
			}
			elseif(!$this->coupon->getIsActive()) {
				$this->getUser()->setFlash('error', 'coupon-already-user');
				return $this->redirect('plantation/index');
			}

			$this->partenaire = $this->coupon->getPartenaire()->getPartenaire();
			$this->setProgrammesFromPartenaire($this->partenaire);
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
				return $this->forward('plantation', 'index');
			}
		}
		else {
			if(!$this->getUser()->isAuthenticated()) {
				$this->getUser()->setFlash('error', 'error-deco');
				return $this->redirect('plantation/index');
			}

			if($this->getUser()->getGuardUser()->getPartenaire()->getId()) {
				$this->partenaire = $this->getUser()->getGuardUser()->getPartenaire();
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
				return $this->redirect('plantation/index');
			}
		}

	}
	/*
	 * Construit l'attestation pdf dans le dossier temporaire
	 * @return: (string) nom du fichier physique
	 */
	public function buildAttestation($email, $trees, $prenom = '', $nom = '') {
		$config = sfTCPDFPluginConfigHandler::loadConfig('my_config');
		$username = (empty($prenom) && empty($nom)) ? $email : $prenom.' '.$nom;

		// pdf object
		$pdf = new attestationPDF();

		// settings
		$pdf->SetMargins(10, 20);
		$pdf->SetHeaderMargin(0);
		$pdf->setPrintFooter(false);

		// init pdf doc
		$pdf->AliasNbPages();
		$pdf->AddPage();
		
		$nbTotal = array_sum($trees);
		
		//body
		$pdf->Cell(0,10,'certifie que',0,1,'C');
		
		$pdf->SetTextColor(73,115,16);
		$pdf->SetFontSize(16);
		$pdf->Cell(0,7,$username,0,1,'C');
		$pdf->SetFontSize(12);
		$pdf->SetTextColor(0);
		$pdf->Cell(0, 5, '', 0, 1); // saut de ligne
		$pdf->Cell(0,5,'a financé la plantation '.($nbTotal > 1 ? 'de '.$nbTotal.' arbres' : 'd\'un arbre'),0,1,'C');
		
		if(sizeof($trees) > 1) {
			$pdf->Cell(0,5,'dans les programmes de reforestation suivants :',0,1,'C');
		}
		else {
			$pdf->Cell(0,5,'dans le programme de reforestation suivant :',0,1,'C');
		}

		foreach($trees as $key => $value) {
			$programme = Doctrine_Core::getTable('programme')->findOneBy('id', $key);
			$programmes[] = $programme->getTitle();
		}
		
		$current_y_position = $pdf->getY();
		$pdf->SetTextColor(73,115,16);
		$pdf->SetFontSize(13);
		$pdf->writeHTMLCell(130, 0, 15, $current_y_position, join(', ', $programmes),0,1,false, true, 'C');
		$pdf->SetFontSize(12);
		$pdf->SetTextColor(0);
			
		$pdf->writeHTMLCell(0, 0, 15, 85, '<b><font size="-4">A Paris, le '.date('d/m/Y').'</font></b>', 0, 1, false, true, 'L');
		
		// output
		$filename = '/tmp/attestation-'.uniqid().'.pdf';
		$pdf->Output($filename , 'F');
		return $filename;
	}
	
	/*
	 * Construit l'attestation pdf dans le dossier temporaire pour le partenaire SdF
	 * @return: (string) nom du fichier physique
	 */
	public function buildAttestationSdF($email, $trees, $prenom = '', $nom = '') {
		$config = sfTCPDFPluginConfigHandler::loadConfig('my_config');

		$username = (empty($prenom) && empty($nom)) ? $email : $prenom.' '.$nom;
		$programme = Doctrine_Core::getTable('programme')->findOneBy('id', key($trees));
		
		// pdf object
		$pdf = new attestationPDFSdF();

		// settings
		$pdf->SetMargins(10, 20);
		$pdf->SetHeaderMargin(0);
		$pdf->setPrintFooter(false);

		// init pdf doc
		$pdf->AliasNbPages();
		$pdf->AddPage();

		//body
		$police = strlen($username) > 30 ? 12 : 14;
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('Times','BI', $police);
		$pdf->writeHTMLCell(0, 0, 20, 66, $username,0,0,false, true, 'L');
		
		$pdf->SetTextColor(255,255,255);
		$pdf->SetFont('Times','B', 9);
		$pdf->writeHTMLCell(0, 0, 53, 77, $programme->getTitle(),0,0,false, true, 'L');

		$pdf->SetFont('Times','B', 9);
		$pdf->SetTextColor(255,255,255);
		$pdf->writeHTMLCell(0, 0, 95, 89, '<b><font size="-4">A Paris, le '.date('d/m/Y').'</font></b>', 0, 0, false, true, 'L');
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
		
		$user = $this->getUser()->getGuardUser();
		$partenaire = ($user->getPartenaire()->getId() != null ? $user->getPartenaire() : null);
		
		if(!is_null($partenaire)) {
			$query = Doctrine::getTable('coupon')->getByPartenaireQuery($partenaire->getId());
		} else {
			$query = Doctrine::getTable('coupon')->getByUserQuery($user->getId());
		}
		
		$this->couponGens = Doctrine::getTable('couponGen')->getArrayById();
		$this->coupons = $query->select('c.gen_id, c.code, c.is_active, c.used_at')->fetchArray();
		$this->setLayout(false);
	}

}
