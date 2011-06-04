<div class="module grey" style="width:300px;float:left;">
	<div class="content center notitle">
		<ul class="list">
			<li><a href="<?php echo url_for('@user_profil') ?>"><?php echo __('Mon profil'); ?></a></li>
			<li><a href="<?php echo url_for('@user_invite_filleul') ?>"><?php echo __('Parrainer des amis'); ?></a></li>
			<li><a href="<?php echo url_for('@user_filleul') ?>"><?php echo __('Mes filleuls'); ?></a></li>
		</ul>
		<ul class="list">
			<li><a href="<?php echo url_for('@checkout_coupon') ?>"><?php echo __('Offrir des arbres (coupons)'); ?></a></li>
			<li><a href="<?php echo url_for('@user_coupon') ?>"><?php echo __('Mes coupons'); ?></a></li>
			<li><a href="<?php echo url_for('@checkout_credit') ?>"><?php echo __('Ajouter des crédits arbres à mon compte'); ?></a></li>
		</ul>
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>