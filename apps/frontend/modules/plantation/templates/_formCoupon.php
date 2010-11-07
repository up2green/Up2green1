<div id="form_programme_plantation" class="module">
	<img class="title corner left" src="/images/module/green/icon/coupon.png" alt="" />
	<p class="title">Utiliser un coupon</p>
	<div class="content">
		<?php 
			if(!empty($errors)) {
				echo '<p class="error">'.join('</p><p class="error">', $errors).'</p>';
			} 
		?>
		<p>Choisissez où planter vos arbres sur la planète en saisissant votre code dès maintenant !</p>
		<form action="" method="post">
		<p class="center"><input type="text" name="code" value="Numéro de coupon" title="Numéro de coupon" /></p>
		<p class="center"><input type="submit" class="button white" name="numCouponToUse" value="Utiliser" /></p>
		</form>

	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>
