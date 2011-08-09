<div class="module">
	<div class="content center">
		<h1 style="font-size:18px;"><?php echo __("Erreur 404 : page introuvable !") ?></h1>
		<p style="padding:20px;"><?php echo __("La page que vous demandez n'existe plus ou a changer d'addresse.") ?></p>
		<p><?php echo link_to(__("Retour à l'accueil"), '@homepage', array('class' => 'button big green')) ?></p>
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>
