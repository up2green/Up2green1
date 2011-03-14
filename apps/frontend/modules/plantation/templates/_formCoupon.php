<div id="form_programme_plantation" class="module">
	<img class="title corner left" src="/images/module/green/icon/coupon.png" alt="" />
	<p class="title"><?php echo __("Utiliser un coupon") ?></p>
	<div class="content">
		<p>
			<?php echo __("Choisissez où planter vos arbres sur la planète en saisissant votre code dès maintenant !") ?>
			<img title="<?php echo __("Si l'un de nos partenaires entreprises ou collectivités vous a offert un coupon reforestation saisissez le code ici. Les arbres correspondant s'incrémenteront automatiquement dans votre compte Up2green.") ?>" src="/images/icons/16x16/consulting.png" />
		</p>
		<form action="" method="post">
		<p class="center"><input type="text" name="code" placeholder="<?php echo __("Numéro de coupon") ?>" /></p>
		<p class="center"><input type="submit" class="button white" name="numCouponToUse" value="<?php echo __("Utiliser") ?>" /></p>
		</form>

	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>
