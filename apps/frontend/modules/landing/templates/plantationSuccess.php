<?php 
	if($isPartenaire = (isset($partenaire) && !empty($partenaire))) {
		$blocWidth = "20%";
		$contentWidth = "45%";
		
		$url = $partenaire->getUrl();
		$partenaireHasImage = $partenaire->getLogo() != '' && file_exists(sfConfig::get('sf_upload_dir').'/partenaire/'.$partenaire->getLogo());
		
		$title = "Déjà ".$nbArbres." arbres plantés avec ".$partenaire->getTitle();
		$contentTitle = "Faites grandir la forêt de ".$partenaire->getTitle()." sur le planète !";
	}
	else {
		$title = "Devenez acteur de la reforestation en plantant vos arbres avec up2gren !";
		$contentTitle = "Faites grandir les forêts des programmes que nous soutenons sur le planète en quelques clics.";
		
		$blocWidth = "45%";
		$contentWidth = "45%";
	}
	
	use_stylesheet('landingPlantation');
	use_stylesheet('blog');
?>

<div id="content">

<div id="title" class="module">
	<div class="content">
		<h1><?php echo $title; ?></h1>
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>

<!-- module up2green -->
<div class="module" style="width:<?php echo $blocWidth; ?>">
	<div class="content">
		<img src="/images/logo/200x200/earth-hand.png" alt="up2green" style="position: relative; left: -10px;" />
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>

<!-- module content -->
<div class="module" style="width:<?php echo $contentWidth; ?>">
	<div class="content">
		<h2><?php echo $contentTitle; ?></h2>
		<h3>Choisissez où planter votre (vos) arbre(z) sur la Planète</h3>
		<p>
			Entrez simplement votre code sécurisé pour accéder à la 
			<a href="http://reforestation.up2green.com" target="_blank">
			plate-forme de plantation</a> et choisir vos programmes de reforestation
		</p>
		<p>
		<form action="http://reforestation.up2green.com/" method="post">
			<input type="text" name="code" value="Numéro de coupon" title="Numéro de coupon" /><br />
			<input type="submit" class="button green" name="numCouponToUse" value="Utiliser" />
		</form>
		</p>
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>

<?php if($isPartenaire) : ?>
<!-- module partenaire -->
<div class="module" style="width:<?php echo $blocWidth; ?>">
	<div class="content">
		<?php if(!empty($url)) : ?>
		<a target="_blank" href="<?php echo $url; ?>">
		<?php endif; ?>
		
		<?php if($partenaireHasImage) : ?>
		<img class="organisme-image" src="/uploads/partenaire/<?php echo $partenaire->getLogo(); ?>" alt="Logo">
		<?php endif; ?>
		
		<p><?php echo $partenaire->getAccroche(); ?></p>
		</a>
	</div>
	<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>
<?php endif; ?>

</div>
