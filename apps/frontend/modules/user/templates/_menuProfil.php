<div class="module grey" style="width:300px;float:left;">
	<div class="content center notitle">
		<ul class="list">
			<li><a href="<?php echo url_for('@user_profil') ?>"><?php echo __('Mon profil'); ?></a></li>
			<li><a href="#"><?php echo __('Parrainer des amis'); ?></a></li>
		</ul>
		<ul class="list">
			<li><a href="<?php echo url_for('@user_coupon') ?>"><?php echo __('Mes coupons'); ?></a></li>
		</ul>
		<ul class="list">
			<li><a href="<?php echo url_for('@checkout_coupon') ?>"><?php echo __('Offrir des coupons'); ?></a></li>
			<li><a href="<?php echo url_for('@checkout_credit') ?>"><?php echo __('Acheter des crédits'); ?></a></li>
		</ul>
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>