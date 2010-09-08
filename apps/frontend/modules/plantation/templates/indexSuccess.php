<div id="body">
	<div id="center">
		<?php include_component('gmap', 'index'); ?>
	</div>
	<!-- for SEO the sidebar after the content -->
	<div id="left">
		<?php if ($sf_user->isAuthenticated()): ?>
                <?php if ($partenaire != null): ?>
            <div class="module">
			<img class="title middle left" src="/images/module/purple/module_icon-partenaires_55x55.png" alt="" />
			<p class="title little indent"><?php echo $partenaire->getTitle() ?></p>
			<div class="content">
				<?php echo $partenaire->getAccroche() ?>
			</div>
			<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
		</div>
                <?php endif; ?>
		<?php include_component('programme', 'plant'); ?>
		<?php else : ?>
		<!-- module -->
		<div class="module">
			<img class="title middle left" src="/images/module/green/icon/acteur.png" alt="" />
			<p class="title little indent">Devenez acteur de la reforestation</p>
			<div class="content">
				<p>Créez votre compte et collectez GRATUITEMENT des arbres au fur et à mesure de vos recherches</p>
				<p>Vous choisissez ensuite vous même où les planter sur la Planète parmi les programmes de reforestation que nous soutenons</p>
				<p class="center">
					<a href="#" class="button green">Créer un compte</a>
				</p>
			</div>
			<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
		</div>
		<!-- module -->
		<div id="form_programme_plantation" class="module">
			
			<img class="title corner left" src="/images/module/green/icon/coupon.png" alt="" />
			<p class="title">Coupon</p>
			<div class="content">
				<p>On vous a offert un coupon ou vous vous en êtes vous même offert un ? Entrez son code ici et planter vos arbres dès maintenant !</p>
				<?php include_component('coupon', 'form'); ?>
			</div>
			<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
		</div>
		<?php endif; ?>
	</div>
</div>
