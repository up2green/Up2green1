<div class="menu_haut">
	<div class="left_menu_haut"></div>
	<div class="middle_menu_haut">
	
		<?php if(!$sf_user->isAuthenticated()):?>
		
		<div class="menu_accueil">
			<div class="flag"></div>
			<ul class="menu">
				<li><a class="button small green" href="/">Accueil</a></li>
				<li><a class="button small gray disabled" href="<?php echo url_for("user/inscription"); ?>">Créer mon compte</a></li>
			</ul>
		</div>
		<div class="menu_connexion">
			<?php echo include_component('user', 'sideSignin'); ?>
		</div>
		
		<?php else: ?>
		
		<div class="menu_accueil">
			<div class="flag"></div>
			<ul class="menu">
				<li><a class="button small green" href="/">Accueil</a></li>
				<li><a class="button small gray disabled" href="#">Définir comme page d'accueil</a></li>
			</ul>
		</div>
		<div class="menu_connexion">
			<ul class="menu">
				<li><a href="<?php echo url_for('@sf_guard_signout') ?>">Déconnexion</a></li>
				<li><a href="<?php echo url_for('@plantation') ?>">Planter mes arbres (<?php echo $sf_user->getProfile()->getCredit() ?>)</a></li>
				<li><a href="<?php echo url_for("user/profil"); ?>">Mon profil (<?php echo $sf_user->getUsername() ?>) </a></li>
			</ul>
		</div>
		
		<?php endif; ?>

	</div>
	<div class="right_menu_haut"></div>
</div>
