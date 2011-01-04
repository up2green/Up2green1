<?php 
	if($isPartenaire = (isset($partenaire) && !empty($partenaire))) {
		$blocWidth = "20%";
		$contentWidth = "45%";
		
		$url = $partenaire->getUrl();
		$partenaireHasImage = $partenaire->getLogo() != '' && file_exists(sfConfig::get('sf_upload_dir').'/partenaire/'.$partenaire->getLogo());
		
		$title = __("Déjà {number} arbres plantés avec {affiliate}", array(
			'{number}' => $nbArbres,
			'{affiliate}' => $partenaire->getTitle()
		));

		$contentTitle = __("Faites grandir la forêt de {affiliate} sur la planète !", array(
			'{affiliate}' => $partenaire->getTitle()
		));
	}
	else {
		$title = __("Devenez acteur de la reforestation en plantant vos arbres avec up2gren !");
		$contentTitle = __("Faites grandir les forêts des programmes que nous soutenons sur la planète en quelques clics.");
		
		$blocWidth = "45%";
		$contentWidth = "45%";
	}
	
	use_stylesheet('landingPlantation?v='.sfConfig::get('app_media_version'));
	use_stylesheet('blog?v='.sfConfig::get('app_media_version'));
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
		<h3><?php echo __("Choisissez où planter votre (vos) arbre(s) sur la Planète") ?></h3>
		<p>
		<?php echo __("Entrez simplement votre code sécurisé pour accéder à la {lien}plate-forme de plantation{:lien} et choisir vos programmes de reforestation", array(
			'{lien}' => '<a href="'.sfConfig::get('sf_app_url_plantation').'" target="_blank">',
			'{:lien}' => '</a>'
		)) ?>
		</p>
		<p>
		<form action="<?php echo sfConfig::get('sf_app_url_plantation'); ?>" method="post">
			<input type="text" name="code" value="<?php echo __("Numéro de coupon") ?>" title="<?php echo __("Numéro de coupon") ?>" /><br />
			<input type="submit" class="button green" name="numCouponToUse" value="<?php echo __("Utiliser") ?>" />
			<input type="hidden" name="fromUrl" value="http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" />
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
