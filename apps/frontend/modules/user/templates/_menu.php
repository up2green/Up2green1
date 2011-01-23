<div class="menu_haut">
	<div class="left_menu_haut"></div>
	<div class="middle_menu_haut">
	
		<div class="menu_accueil">
			<div id="language-wrapper">
				<?php echo include_component('user', 'language'); ?>
			</div>
			<ul class="menu">
				<li><a class="button small green" href="<?php echo sfConfig::get('app_url_moteur') ?>"><?php echo __("Le moteur") ?></a></li>
				<li><a class="button small green" href="<?php echo sfConfig::get('app_url_blog') ?>article/nos_objectifs"><?php echo __("L'association") ?></a></li>
				<?php if(!$sf_user->isAuthenticated()):?>
				<li><a class="button small green" href="<?php echo url_for("user/inscription"); ?>"><?php echo __("Créer mon compte") ?></a></li>
				<?php endif; ?>
			</ul>
		</div>

		<div class="menu_connexion">
			<?php if(!$sf_user->isAuthenticated()):?>
			<?php echo include_component('user', 'sideSignin'); ?>
			<?php else: ?>
			<ul class="menu">
				<li><a href="<?php echo url_for('@sf_guard_signout') ?>"><?php echo __("Déconnexion") ?></a></li>
				<li><a href="<?php echo url_for('@plantation') ?>"><?php echo __(
					"Planter mes arbres ({number})",
					array('{number}' => number_format($sf_user->getProfile()->getCredit(), 3))
				) ?></a></li>
				<li><a href="<?php echo url_for("user/profil"); ?>"><?php echo __(
					"Mon profil ({username})",
					array('{username}' => $sf_user->getUsername())
				) ?></a></li>
			</ul>
			<?php endif; ?>
		</div>

	</div>
	<div class="right_menu_haut"></div>
</div>
