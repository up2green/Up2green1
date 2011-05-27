<?php include_partial('user/menuProfil'); ?>

<div class="module grey" style="width:700px;float:right;">
	<div class="content center notitle">
		<div class="step-wrapper">
			<div class="button green small step active"><?php echo __("Votre choix"); ?></div>
			<div class="button green small step"><?php echo __("Mode de paiement"); ?></div>
		</div>
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>

<div class="module grey" style="width:700px;float:right;">
	<div class="content center notitle">
		<?php foreach($products as $product) : ?>
		
		<?php endforeach; ?>
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>

