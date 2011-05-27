<?php include_partial('user/menuProfil'); ?>

<div class="module grey" style="width:700px;float:right;">
	<div class="content center notitle">
		<div class="step-wrapper">
			<div class="button <?php echo ($step == "choice" ? "green" : "gray") ?> big step"><?php echo __("Votre choix"); ?></div>
			<div class="button <?php echo ($step == "dest" ? "green" : "gray") ?> big step"><?php echo __("Destinataire"); ?></div>
			<div class="button <?php echo ($step == "buy" ? "green" : "gray") ?> big step"><?php echo __("Mode de paiement"); ?></div>
		</div>
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>

<div class="module grey" style="width:700px;float:right;">
	<div class="content center notitle">
		<?php include_partial('formCoupon'.  ucfirst($step), $vars);	?>		
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>