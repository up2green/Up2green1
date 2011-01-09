<div id="body">
    <div id="center">
	<?php

	$errorLabels = array(
		'coupon-already-user' => __("Ce coupon a déjà été utilisé"),
		'plant-succes' => __("Vos arbres ont bien été plantés !"),
		'email-confirmation' => __("Vous aller recevoir un email attestant de votre plantation."),
		'error-plant-all' => __("Veuillez planter tous vos arbres avant de valider !"),
		'error-deco' => __("Vous avez été déconnecté"),
	);

	$errorImages = array(
		'coupon-already-user' => '/images/icons/48x48/error.png',
		'plant-succes' => '/images/icons/48x48/tick.png',
		'email-confirmation' => '/images/icons/48x48/tick.png',
		'error-plant-all' => '/images/icons/48x48/warning.png',
		'error-deco' => '/images/icons/48x48/error.png',
	);

	$errorTitres = array(
		'coupon-already-user' => __("Erreur"),
		'plant-succes' => __("Info"),
		'email-confirmation' => __("Info"),
		'error-plant-all' => __("Erreur"),
		'error-deco' => __("Erreur"),
	);

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
	<?php if (sizeof($errors)): ?>
	<script type="text/javascript">
		$(document).ready(function(){
			<?php foreach($errors as $error) : ?>
			$.gritter.add({
				title: "<?php echo $errorTitres[$error] ?>",
				class_name: 'flash_notice',
				image: "<?php echo $errorImages[$error] ?>",
				text: "<?php echo $errorLabels[$error] ?>"
			});
			<?php endforeach; ?>
		});
	</script>
	<?php endif ?>

    </div>
</div>
