<?php
	$totalTrees = (int)$totalTrees + sfConfig::get('app_hardcode_tree_number');
?>

<div id="home">

	<?php if (!$sf_user->isAuthenticated()): ?>
	<div class="module acteur">
		<img class="title middle left" src="/images/module/green/icon/acteur.png" alt="" />
		<p class="title">Devenez acteur de la reforestation</p>
		<div class="content">
			<p>Créez votre compte et collectez GRATUITEMENT des arbres au fur et à mesure de vos recherches</p>
			<p>Vous choisissez ensuite vous même où les planter sur la Planète parmi les programmes de reforestation que nous soutenons</p>
			<p class="center">
				<a href="<?php echo url_for("user/inscription"); ?>" class="button green"><strong>Créer un compte</strong></a>
			</p>
			<p class="center">
				<a href="#" class="button green">Définir Up2green comme moteur<br/>de recherche par defaut</a>
			</p>
		</div>
		<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
	</div>
	<?php else: ?>
	<div class="module acteur">
		<img class="title middle left" src="/images/module/green/icon/acteur.png" alt="" />
		<p class="title">Plantez vos arbres</p>
		<div class="content">
			<p>Vous pouvez dès à présent accéder à la plateforme de reforestation et planter vos arbres si vous en avez collectés suffisement</p>
			<p class="center">
				<a href="<?php echo url_for("plantation/index"); ?>" class="button green">Accéder à la plateforme de reforestation</a>
			</p>
		</div>
		<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
	</div>
	<?php endif; ?>

	<div class="module statistiques">
		<img class="title middle right" src="/images/module/green/icon/stats.png" alt="" />
		<p class="title">Statistiques</p>
		<div class="content">
			<p><img class="img_map" src="/images/moteur/stats_maps_200x70.png" /></p>
			<p class="center tooltiped" tooltip="Les forêts sont reconnues pour être de véritables puits de carbone.<br /> A titre indicatif, d’après l’ONU, pendant sa croissance un arbre capte en moyenne 12 kgs de CO2 par an et rejette l’oxygène nécessaire à la respiration dune famille de 4 personnes" style="padding:10px 0;">
				Arbres plantés : <strong style="color:#015F00;"><?php echo $totalTrees; ?></strong> <br/>
				soit plus de <strong style="color:#015F00;"><?php echo number_format($totalTrees*sfConfig::get('app_conversion_tree_co2'), 2, ',', ' '); ?></strong> tonnes<br/>
				de CO<sub>2</sub> qui seront stockées pendant leur croissance
			</p>
		</div>
		<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
	</div>

	<?php if (!$sf_user->isAuthenticated()): ?>
	<div class="module purple partenaires">
		<img class="title middle right" src="/images/module/purple/icon/icon-partenaires.png" alt="" />
		<p class="title">Partenaires</p>
		<div class="content">
			<p>Entreprises et collectivités, devenez acteur de la reforestation en impliquant vos administrés, client et colaborateur...</p>
			<div class="lien_partenaires righter">
				<a href="<?php echo sfConfig::get('app_url_blog'); ?>">plus d'informations ici</a>
			</div>
		</div>
		<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
	</div>
	<?php endif; ?>

</div>