<div class="menu_haut">
	<div class="left_menu_haut"></div>
	<div class="middle_menu_haut">
	
		<?php if(!$sf_user->isAuthenticated()):?>
		
		<div class="menu_accueil">
			<div class="flag"></div>
			<ul class="menu">
				<li><a class="button small green" href="/">Acceuil</a></li>
				<li><a class="button small gray disabled" href="#<?php /*echo url_for("user/inscription")*/ ?>">Créer mon compte (bientot disponible)</a></li>
			</ul>
		</div>
		<div class="menu_connexion">
			<?php echo include_component('user', 'sideSignin'); ?>
		</div>
		
		<?php else: ?>
		
		<div class="menu_accueil">
			<div class="flag"></div>
			<ul class="menu">
				<li><a class="button small gray disabled" href="#">Définir comme page d'accueil</a></li>
			</ul>
		</div>
		<div class="menu_connexion">
			<ul class="menu">
				<li><a href="<?php echo url_for('@plantation') ?>">Planter mes arbres</a></li>
				<li><a href="#">Parrainer des amis</a></li>
				<li><a href="#">Mes crédits (<?php echo $sf_user->getProfile()->getCredit() ?> arbres)</a></li>
				<li><a href="#">Mon profil (<?php echo $sf_user->getUsername() ?>) </a></li>
				<li><a href="<?php echo url_for1('@sf_guard_signout') ?>">Déconnexion</a></li>
			</ul>
		</div>
		
		<?php endif; ?>

	</div>
	<div class="right_menu_haut"></div>
</div>
