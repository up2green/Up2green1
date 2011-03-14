<div class="module">
	<img class="title middle left" src="/images/module/green/icon/acteur.png" alt="" />
	<p class="title indent"><?php echo __("Nouveau mot de passe") ?></p>
	<div class="content center" style="min-height:250px;">
		<?php 
		if (isset($pwd)):
			echo __("Le nouveau mot de passe a été envoyé par mail à l'adresse renseignée sur le profil.<br /> Regardez dans votre boite à SPAM si vous ne voyez pas l'e-mail dans votre boite de réception, il est possible que votre logiciel de messagerie bloque ce message.");
		else: ?>
		<?php if (isset($error)) echo $error ?>
		<form method="post" action="" name="pwd">
				<input type="text" name="username" placeholder="<?php echo __("Nom d'utilisateur") ?>" />
				<input class="button small white" type="submit" name="forgotPassword" value="<?php echo __('Envoyer') ?>" />
		</form>
		<p style="margin:25px;"><i>
			<?php echo __("En cliquant sur \"Envoyer\", un nouveau mot de passe sera généré et envoyé à l'adresse mail renseignée sur le profil.") ?>
			<br />
			<?php echo __("Une fois ce mot de passe changé, l'ancien ne sera plus valable.") ?>
		</i></p>
		<?php endif; ?>
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>
