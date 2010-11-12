<?php use_helper('I18N') ?>

<div class="module grey" style="width:300px;float:left;">
	<div class="content center notitle">
		<ul class="list">
			<li><a href=""><?php echo __('Mon profil'); ?></a></li>
			<li><a href="#"><?php echo __('Parrainer des amis'); ?></a></li>
		</ul>
		<?php if(false) : ?>
		<ul class="list">
			<li><a href=""><?php echo __('Mes coupons'); ?></a></li>
			<li><a href=""><?php echo __('Récapitulatif'); ?></a></li>
		</ul>
		<?php endif; ?>
		<ul class="list">
			<li><a href="#"><?php echo __('Acheter des coupons'); ?></a></li>
			<li><a href="#"><?php echo __('Acheter des crédits'); ?></a></li>
		</ul>
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>