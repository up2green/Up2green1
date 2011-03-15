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
		echo '
			<!-- module -->
			<div id="gmapWrapper" class="module" style="position:relative;" >
				<img class="title corner left" src="/images/module/green/icon/program.png" alt="" />
				<p class="title"><?php echo __("Les programmes de reforestation que nous soutenons") ?></p>
				<div class="content">';
		include_partial('formGMap', array('gMap' => $gMap, 'gMapModes' => $gMapModes));

		echo '<div class="clear"></div>
			</div>
				'.file_get_contents(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php').'
			</div>
		';
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
			'redirectUrl' => $redirectUrl,
			'coupon' => isset($coupon) ? $coupon : NULL, 
			'nbArbresToPlant' => $nbArbresToPlant, 
			'programmes' => $programmes
		));
	}
	
	if($view !== 'listeCouponsPartenaires' && !isset($coupon)) {
		include_partial('formCoupon');
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
