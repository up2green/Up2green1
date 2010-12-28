<div id="body">
    <div id="center">
	<?php

	if(
		$sf_user->isAuthenticated() &&
		$view === 'listeCouponsPartenaires' &&
		!is_null($partenaire)
	) {
	    if (sizeof($coupons) > 0) {
			include_partial('coupons', array('coupons' => $coupons));
		}
	    if (sizeof($couponsUsed) > 0) {
			include_partial('couponsUsed', array('coupons' => $couponsUsed));
		}
	}
	else {
	    include_partial('formGMap', array('gMap' => $gMap, 'gMapModes' => $gMapModes));
	}

	echo '</div>';
	
	// Left
	
	echo '<div id="left">';
	
	if(!isset($coupon)) {
		include_partial('logo');
	}
	
	if(
		$view !== 'listeCouponsPartenaires' && 
		(isset($coupon) or $sf_user->isAuthenticated())
	) {
		include_partial('formPlant', array(
			'fromUrl' => $fromUrl, 
			'coupon' => isset($coupon) ? $coupon : NULL, 
			'nbArbresToPlant' => $nbArbresToPlant, 
			'programmes' => $programmes, 
			'errors' => $errors
		));
	}
	
	if($view !== 'listeCouponsPartenaires' && !isset($coupon)) {
		include_partial('formCoupon', array('errors' => $errors));
	}

	if(!is_null($partenaire)) {
	    include_partial('formPartenaire', array('partenaire' => $partenaire, 'view' => $view));
	}
	elseif(!$sf_user->isAuthenticated()) {
	    include_partial('formInscription', array());
	}

	?>
    </div>
</div>
