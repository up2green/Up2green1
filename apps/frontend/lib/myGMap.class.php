<?php

class myGMap extends GMap {

	public $programmes;
	public $partenaire;
	public $canPlant;
	public $user;

	public function __construct(
			$programmes,
			$partenaire=null,
			$user=null,
			$options=array(), 
			$container_style=array(),
			$container_attributes=array(),
			$parameters=array()
	) {

		$options = array_merge(array(
			'scrollwheel' => 'false',
			'mapTypeId' => 'google.maps.MapTypeId.SATELLITE',
			'mapTypeControl' => 'false',
			'canPlant' => false,
			'navigationControl' => 'false'
		), $options);

		$this->canPlant = $options['canPlant'];

		unset($options['canPlant']);

		parent::__construct($options, $container_style, $container_attributes, $parameters);
		
		$this->programmes = $programmes;
		$this->partenaire = $partenaire;
		$this->user = $user;

		foreach($this->programmes as $programme)
			if(
			!is_null($programme->getGeoadress()) ||
			(!is_null($programme->getLatitude()) && !is_null($programme->getLongitude()))
			) {

				if(!is_null($programme->getLatitude()) && !is_null($programme->getLongitude())) {
					// latitude / longitude method
					$geocoded_addr = new GMapGeocodedAddress(null);
					$geocoded_addr->setLat($programme->getLatitude());
					$geocoded_addr->setLng($programme->getLongitude());
				}
				else {
					// adress user friendly method
					$geocoded_addr = new GMapGeocodedAddress($programme->getGeoadress());
					$geocoded_addr->geocode($this->getGMapClient());
				}

				$gMapMarker = new GMapMarker(
					$geocoded_addr->getLat(),
					$geocoded_addr->getLng(),
					array(
//						'title ' => "'".$programme->getId()."'",
						'zIndex ' => (100 + floor($programme->getMaxTree()/1000)),
						'icon'	=> $this->getProgrammeIcon($programme),
					)
				);

				$html = '<span class="title">'.$programme->getTitle().'</span>';
				$html .= '<span style="display:block;padding-top:10px;" class="content">';

				if(
					$programme->getLogo() != '' &&
					file_exists(sfConfig::get('sf_upload_dir').'/programme/'.$programme->getLogo())
				) {
					$html .= '<img class="gmap-programme" src="/uploads/programme/'.$programme->getLogo().'" alt="Diapo Image" />';
				}

				$html .= '<div class="accroche-programme">'.$programme->getAccroche().'</div>';
				$html .= '<a href="'.sfConfig::get('app_url_blog').'/programme/'.$programme->getSlug().'" class="read_more" target="_blank">Lire la suite</a>';
				$html .= '<br /></span>';

				if($this->canPlant) {
					$html .= '
						<span class="action">
							<span>Plantez vos arbres <span class="nbTree" programme="'.$programme->getId().'"></span> : </span>
							<button class="addTree button really-small green" programme="'.$programme->getId().'">+</button>
							<button class="removeTree button really-small gray" programme="'.$programme->getId().'">-</button>
						</span>
					';
				}

				if($geocoded_addr->getLat() != '' && $geocoded_addr->getLng() != '') {
					$gMapMarker->addEvent(new GMapEvent(
						'click',
						'$.fn.moveToMarker('.$geocoded_addr->getLat().', '.$geocoded_addr->getLng().');'
					));
				}

				$gMapMarker->addHtmlInfoWindow(new GMapInfoWindow(
					'<div class="gmap-info-bulle">'.$html.'</div>',
					array(
						'maxWidth' => 300
					)
				));

				$this->addMarker($gMapMarker);

			}

		$this->setZoom(2);
		$this->setCenter(25, 0);
	}

	public function getGmapModeSelector($options = array()) {

		return array();

		$options = array_merge(array(
			'displayAll' => true
		), $options);

		$modes = array();
		$checked = false;

		// mode tous
		$allValues = array();
		$allValuesEmpty = array();
		$programmesIds = array();

		foreach($this->programmes as $programme) {
			$allValuesEmpty += array($programme->getId() => array(
				'title' => $programme->getTitle(),
				'number' => 0
			));
		}

		if($options['displayAll']) {
			$results = Doctrine_Core::getTable('programme')->countTrees(array_keys($allValuesEmpty));
			$allValues = $allValuesEmpty;
			foreach($results as $result) {
				$allValues[$result['id']]['number'] = $result['nbTree'];
			}
		}

		// mode partenaire
		if(!is_null($this->partenaire)) {

			$partenaireValues = $allValuesEmpty;
			$sum = 0;

			$resultsFromUser = Doctrine_Core::getTable('tree')->countFromUserByProgramme($this->partenaire->getUser()->getId(), array_keys($allValuesEmpty));
			$resultsFromCoupon = Doctrine_Core::getTable('tree')->countFromCouponPartenaireByProgramme($this->partenaire->getId(), array_keys($allValuesEmpty));

			foreach($resultsFromUser as $result) {
				$partenaireValues[$result['programme_id']]['number'] += $result['nbTree'];
				$sum += $result['nbTree'];
			}

			foreach($resultsFromCoupon as $result) {
				$partenaireValues[$result['programme_id']]['number'] += $result['nbTree'];
				$sum += $result['nbTree'];
			}

			$checked = !$checked;
			$modes[] = array(
				'name' => 'partenaire-'.$this->partenaire->getId(),
				'partenaireId' => $this->partenaire->getId(),
				'partenaireTitle' => $this->partenaire->getTitle(),
				'values' => $partenaireValues,
				'displayValue' => $sum,
				'checked' => $checked
			);
		}

		if (!is_null($this->user) && $this->user->isAuthenticated()) {
			$userValues = $allValuesEmpty;
			$sum = 0;

			$resultsFromUser = Doctrine_Core::getTable('tree')->countFromUserByProgramme($this->user->getGuardUser()->getId(), array_keys($allValuesEmpty));
			foreach($resultsFromUser as $result) {
				$userValues[$result['programme_id']]['number'] += $result['nbTree'];
				$sum += $result['nbTree'];
			}

			$modes[] = array(
				'name' => 'user',
				'values' => $userValues,
				'displayValue' => $sum,
				'checked' => false
			);

			if(!is_null($this->partenaire)) {
				$couponValues = $allValuesEmpty;
				$sum = 0;

				$resultsFromCoupon = Doctrine_Core::getTable('tree')->countFromCouponPartenaireByProgramme($this->partenaire->getId(), array_keys($allValuesEmpty));
				foreach($resultsFromCoupon as $result) {
					$couponValues[$result['programme_id']]['number'] += $result['nbTree'];
					$sum += $result['nbTree'];
				}

				$checked = !$checked;
				$modes[] = array(
					'name' => 'coupon',
					'values' => $couponValues,
					'displayValue' => $sum,
					'checked' => $checked
				);

			}

		}

		if($options['displayAll']) {
			$modes[] = array(
				'name' => 'all',
				'values' => $allValues,
				'displayValue' => Doctrine_Core::getTable('tree')->count() + sfConfig::get('app_hardcode_tree_number'),
				'checked' => !$checked
			);
		}

		return $modes;
	}

	private function getProgrammeIcon(programme $programme) {
		return new GMapMarkerImage(
			'/images/gmap/pointeur/60x60/arbre/vert.png',
			array(
				'width' => 60,
				'height' => 60,
			)
		);
	}
}