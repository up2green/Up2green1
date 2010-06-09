<div id="body">
	<div id="center">
		<?php include_component('gmap', 'index'); ?>
	</div>
	<!-- for SEO the sidebar after the content -->
	<div id="left">
		<?php if ($sf_user->isAuthenticated()): ?>
		<?php include_component('programme', 'plant'); ?>
		<?php else : ?>
		<div id="form_programme_plantation" class="module">
			<div class="head">Devenez acteur de la reforestation</div>
			<div class="body_wrapper">
				<div class="body_inner">
					<p>Créez votre compte et collectez GRATUITEMENT des arbres au fur et à mesure de vos recherches</p>
					<p>Vous choisissez ensuite vous même où les planter sur la Planète parmi les programmes de reforestation que nous soutenons</p>
					<p class="center">
						<a href="#" class="button green">Créer un compte</a>
					</p>
				</div>
			</div>
			<div class="foot"></div>
		</div>
		<div id="form_programme_plantation" class="module">
			<div class="head">Coupon</div>
			<div class="body_wrapper">
				<div class="body_inner">
					<p>On vous a offert un coupon ou vous vous en êtes vous même offert un ? Entrez son code ici et planter vos arbres dès maintenant !</p>
					<?php include_component('coupon', 'form'); ?>
				</div>
			</div>
			<div class="foot"></div>
		</div>
		<?php endif; ?>
	</div>
</div>
