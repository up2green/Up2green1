<div id="body">
    <div id="center">
	<?php

	if(
	$sf_user->isAuthenticated() &&
		$view === 'listeCouponsPartenaires' &&
		!is_null($partenaire)
	) {
	    use_helper('Date');
	    if (sizeof($coupons) > 0) : ?>

	<div class="module">
	    <img class="title middle left" src="/images/module/green/icon/acteur.png" alt="" />
	    <p class="title little indent">Coupons non utilisés (<?php echo sizeof($coupons) ?>) <a href="<?php echo url_for('@couponsCSV') ?>">CSV</a></p>
	    <div class="content scrollableWrapper">
			<?php if(sizeof($coupons) > 6) : ?>
		<center><span class="button white maxWidth slideUp">
			<img src="/images/icons/top.png" alt="Haut"/>
		    </span></center>
			<?php endif; ?>

		<ul class='scrollable medium'>
			    <?php foreach($coupons as $coupon) : ?>
		    <li>
			<span class="bigitem">
					<?php echo $coupon->getCode(); ?> [<?php echo $coupon->getCouponGen()->getCredit() ?> arbre(s)]
													Généré le <?php echo format_date($coupon->getCreatedAt(), 'p', $sf_user->getCulture());?>
			</span>
		    </li>
			    <?php endforeach; ?>
		</ul>

			<?php if(sizeof($coupons) > 6) : ?>
		<center><span class="button white maxWidth slideDown">
			<img src="/images/icons/bottom.png" alt="Bas"/>
		    </span></center>
			<?php endif; ?>
	    </div>
		    <?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
	</div>

	    <?php endif; ?>
	    <?php if (sizeof($couponsUsed) > 0): ?>
	<div class="module scrollableWrapper">
	    <img class="title middle left" src="/images/module/green/icon/acteur.png" alt="" />
	    <p class="title little indent">Coupons utilisés (<?php echo sizeof($couponsUsed) ?>) <a href="<?php echo url_for('@couponsUsedCSV') ?>">CSV</a></p>
	    <div class="content">
			<?php if(sizeof($couponsUsed) > 6) : ?>
		<span class="button white maxWidth slideUp">
		    <img src="/images/icons/top.png" alt="Haut"/>
		</span>
			<?php endif; ?>

		<ul class='scrollable medium'>
			    <?php foreach($couponsUsed as $coupon) : ?>
		    <li>
			<span class="bigitem"><?php echo $coupon->getCode(); ?> [<?php echo $coupon->getCouponGen()->getCredit() ?> arbre(s)]
														Utilisé le <?php echo format_date($coupon->getUsedAt(), 'p', $sf_user->getCulture()) ?></span>
		    </li>
			    <?php endforeach; ?>
		</ul>

			<?php if(sizeof($couponsUsed) > 6) : ?>
		<span class="button white maxWidth slideDown">
		    <img src="/images/icons/bottom.png" alt="Bas"/>
		</span>
			<?php endif; ?>
	    </div>
		    <?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
	</div>
	    <?php
	    endif;

	} 
	else {
		include_partial('formGMap', array('gMap' => $gMap));
	}
	
	echo '</div><div id="left">';
	
	if($view !== 'listeCouponsPartenaires' or !$sf_user->isAuthenticated()) {
		if (isset($coupon)) {
			include_partial('formPlant', array('coupon' => $coupon, 'nbArbresToPlant' => $nbArbresToPlant, 'programmes' => $programmes));
		} 
		else {
			include_partial('formCoupon', array("phraseCoupon" => $phraseCoupon));
		}
	}
	
	if ($sf_user->isAuthenticated()) {
		if (!is_null($partenaire)) {
			include_partial('formPartenaire', array('partenaire' => $partenaire, 'view' => $view));
		}
	} 
	else {
		include_partial('formInscription', array());
	}
	
	?>
    </div>
</div>
